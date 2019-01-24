<?php
date_default_timezone_set('PRC');

class Delivery_ctrl extends TW_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('delivery_model');
        $this->load->model('modetr_model');
        $this->load->model('allow_model');
        $this->allow_model->is_login();
        $this->allow_model->is_allow();
    }

    //门店的订单
    public function delivery()
    {
        $i_order = $this->router->get(1) ? $this->router->get(1) : 0;
        //页面数据显示和条件
        $i_canshu = $this->router->get(2) ? $this->router->get(2) : '1';
        $a_data   = [
            'store_id' => $store_id,
            'i_order'  => $i_order,
            'i_canshu' => $i_canshu,
        ];
        $a_where  = "`store_id` = " . $_SESSION['store_id'];
        if (!empty($i_order)) {
            if ($i_order == 55) {
                $a_where .= ($a_where ? ' AND ' : '') . "`order_state` < 2";
            } else {
                $a_where .= ($a_where ? ' AND ' : '') . "`order_state` = $i_order";
            }

        }

        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数，以产品为例
        $a_data['out'] = $this->db->get_total('order', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($a_data['out'], $i_canshu, 5);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);
        //门店的订单
        $a_data['order'] = $this->db->from('order as a')
            ->join('user as b', ['a.user_id' => 'b.user_id'])
            ->order_by(['order_id' => 'desc'])
            ->get('', $a_where);
        // echo $this->db->get_sql();
        //显示页
        $a_data['page'] = $this->pages->link_style_one($this->router->url('delivery-' . $i_order, [''], false, false));
        //订单产品信息
        $a_data['goods'] = $this->db->order_by(['rec_id' => 'desc'])->limit(0, 999999999)->get('order_goods');
        //各订单数
        $s_fields      = 'order_state,count(1) as num';
        $s_group_by    = 'order_state';
        $a_wher        = ['store_id' => $_SESSION['store_id']];
        $a_data_result = $this->db
            ->select($s_fields, false)
            ->group_by($s_group_by)
            ->get('order', $a_wher);
        foreach ($a_data_result as $key => $value) {
            $a_result[$value['order_state']] = $value['num'];
        }
        // 显示待付款条数
        $a_data['payment'] = isset($a_result['40']) ? intval($a_result['40']) : 0;
        // 显示待接单条数
        $a_data['waiting'] = isset($a_result['20']) ? intval($a_result['20']) : 0;
        // 显示待配送条数
        $a_data['shipping'] = isset($a_result['25']) ? intval($a_result['25']) : 0;
        // 显示配送中条数
        $a_data['distribu'] = isset($a_result['30']) ? intval($a_result['30']) : 0;
        //显示已完成
        $wang               = isset($a_result['10']) ? intval($a_result['10']) : 0;
        $wan                = isset($a_result['80']) ? intval($a_result['80']) : 0;
        $a_data['wanchenn'] = $wang + $wan;
        $a_modetr           = $this->modetr_model->modert();
        $a_wangc            = $this->modetr_model->wangc();
        $this->view->display('delivery', $a_data);
    }

    /*************************************** 订单详情 ******************************************/
    public function order_details()
    {
        $i_id             = $this->router->get(1);
        $s_field          = 'a.order_number, a.time_create, a.reciver_name, a.addres, a.mob_phone, b.product_name, b.cup_id, b.goods_num, b.money, a.use_points, a.payment_code, b.cup_name,a.time_delay,a.shipping_fee,a.actual_pay,b.spec';
        $a_data['order']  = $this->db->from('order as a')
            ->join('order_goods as b', ['a.order_id' => 'b.order_id'])
            ->get('', ['a.order_id' => $i_id], $s_field);
        $a_data['ordert'] = $this->db->get('order_tracking', ['order_id' => $i_id], '', ['id' => 'asc']);

        $a_oret           = [
            // 必传，订单ID
            'order_id'         => $a_data['order'][0]['order_number'],
            // 'order_id' => '20180118659',
            // 可选，地图中心点经度，默认以骑手位置为中心点
            'center_longitude' => 113.33343,
            // 可选，地图中心点纬度，默认以骑手位置为中心点
            'center_latitude'  => 22.96336,
            // 可选，骑手图标，图片链接
            'img'              => 'http://lbs.amap.com/web/public/dist/avatar_default.01b559.png',
            // 可选，图片宽度
            'img_width'        => 50,
            // 可选，图片高度
            'img_height'       => 50,
        ];
        $s_result         = $this->general->request('http://distribution.7dugo.com/query.html', $a_oret);
        $a_data['result'] = json_decode($s_result, true);
        $this->view->display('order_details', $a_data);
    }

    public function order_detail()
    {
        $i_id    = $this->general->post('id');
        $s_field = 'a.order_number, a.time_create, a.reciver_name, a.addres, a.mob_phone, b.product_name, b.cup_id, b.goods_num, b.money, a.use_points, a.payment_code, b.cup_name,a.time_delay,a.shipping_fee,a.order_price,b.spec';
        $a_data  = $this->db->from('order as a')
            ->join('order_goods as b', ['a.order_id' => 'b.order_id'])
            ->get('', ['a.order_id' => $i_id], $s_field);
        echo json_encode($a_data);
    }

    // 未有选择门店的订单抢单
    public function single()
    {
        //订单id
        $i_id   = $this->general->post('id');
        $a_data = $this->db->get_row('order', ['order_id' => $i_id, 'store_id' => 0, 'order_state' => 20]);
        if (!empty($a_data)) {
            $this->db->update('order', ['store_id' => $_SESSION['store_id']], ['order_id' => $i_id, 'order_state' => 20]);
            echo json_encode(['stuo' => 55, 'name' => '抢单成功！']);
            die;
        } else {
            echo json_encode(['stuo' => 60, 'name' => '抢单失败！']);
            die;
        }
    }

    //门店抢单未选门店的单显示
    public function delivery_weixuan()
    {
        $a_where = [
            'share_userid'  => 0,
            'order_state'   => 20,
            'store_id'      => '',
            'order_time <=' => strtotime("-5 minute"),
        ];
        $s_field = 'b.user_name,b.user_pic,a.order_time,a.addres_post,a.time_delay,a.order_price,a.order_id';
        $a_order = [
            'order_id' => 'desc',
        ];
        $a_orde  = $this->db->from('order as a')
            ->join('user as b', ['b.user_id' => 'a.user_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 9999999999);
        //门店的坐标
        $a_storeb         = $this->db->get_row('store', ['store_id' => $_SESSION['store_id']], ['store_position', 'order_distance']);
        $store            = explode(",", $a_storeb['store_position']);
        $a_data['sto']    = $store;
        $a_data['a_orde'] = $a_orde;
        $a_store          = [];
        for ($i = 0; $i < count($a_orde); $i++) {
            $order       = explode(",", $a_orde[$i]['addres_post']);
            $a_store[$i] = $this->getDistance($order[1], $store[0], $order[0], $store[1], 2);
            if ($a_store[$i] <= $a_storeb['order_distance']) {
                $a_storet[$i] = $a_store[$i];
                $a_ordeb [$i] = $a_orde[$i];
            }
        }
        $a_data['store'] = $a_storet;
        $a_data['orde']  = $a_ordeb;
        echo json_encode(['stur' => 50, 'data' => $a_data]);
        die;
    }

    //订单取消

    /**
     * 计算两点地理坐标之间的距离
     * @param  Decimal $longitude1 起点经度
     * @param  Decimal $latitude1 起点纬度
     * @param  Decimal $longitude2 终点经度
     * @param  Decimal $latitude2 终点纬度
     * @param  Int $unit 单位 1:米 2:公里
     * @param  Int $decimal 精度 保留小数位数
     * @return Decimal
     */
    function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit = 2, $decimal = 2)
    {

        $EARTH_RADIUS = 6370.996; // 地球半径系数
        $PI           = 3.1415926;

        $radLat1 = $latitude1 * $PI / 180.0;
        $radLat2 = $latitude2 * $PI / 180.0;

        $radLng1 = $longitude1 * $PI / 180.0;
        $radLng2 = $longitude2 * $PI / 180.0;

        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;

        $distance = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $distance = $distance * $EARTH_RADIUS * 1000;

        if ($unit == 2) {
            $distance = $distance / 1000;
        }

        return round($distance, $decimal);
    }

    //订单触发完成

    public function delivery_quxiao()
    {
        $id     = $this->general->post('id');
        $ster   = $this->general->post('ster');
        $cho    = $this->general->post('cho');
        $a_tert = $this->db->get_row('order', ['order_id' => $id, 'store_id' => $_SESSION['store_id']]);
        if (empty($a_tert)) {
            echo json_encode(['stuo' => 55, 'name' => '订单有误！']);
            die;
        }
        $a_track = [
            'order_id'     => $id,
            'order_number' => $a_tert['order_number'],
            'name'         => '订单已取消',
            'time'         => $_SERVER['REQUEST_TIME'],
        ];

        if ($ster == 1) {
            //代付款取消订单
            // 把订单状态改为取消
            $this->db->update('order', ['order_state' => 0], ['order_id' => $id]);
            //增加订单处理历史表
            $a_log = [
                'order_id'       => $id,
                'log_msg'        => $_SESSION['manager_name'] . $cho . '未付款订单取消',
                'log_time'       => $_SERVER['REQUEST_TIME'],
                'log_role'       => '门店',
                'log_user'       => $_SESSION['manager_name'],
                'log_orderstate' => 0,
            ];
            $this->db->insert('order_log', $a_log);
            $this->db->insert('order_tracking', $a_track);
            //把返回的金额和积分返回给用户
            $a_user  = $this->db->get_row('user', ['user_id' => $a_tert['user_id']]);
            $balance = $a_user['user_balance'] + $a_tert['balance_deduction'];
            $score   = $a_user['user_score'] + $a_tert['use_jife'];
            $a_usr   = [
                'user_score'   => $score,
                'user_balance' => $balance,
            ];
            $this->db->update('user', $a_usr, ['user_id' => $a_tert['user_id']]);
            // 增加会员积分表
            if (!empty($a_tert['use_jife'])) {
                $a_jife = [
                    'user_id'        => $a_tert['user_id'],
                    'user_name'      => $a_tert['user_name'],
                    'pl_type'        => 1,
                    'pl_variation'   => $a_tert['use_jife'],
                    'pl_time'        => $_SERVER['REQUEST_TIME'],
                    'pl_score'       => $score,
                    'pl_description' => $a_tert['order_number'] . '退还积分',
                    'pl_item'        => '退还积分',
                    'pl_code'        => 7,
                ];
                $this->db->insert('points_log', $a_jife);
            }
            // 用户资金明细表
            if (!empty($a_tert['balance_deduction'])) {
                $a_userba = [
                    'ub_type'        => 1,
                    'ub_money'       => $a_tert['balance_deduction'],
                    'ub_balance'     => $balance,
                    'ub_time'        => $_SERVER['REQUEST_TIME'],
                    'ub_item'        => '退还余额',
                    'user_id'        => $a_tert['user_id'],
                    'ub_number'      => $a_tert['order_number'],
                    'ub_description' => $a_tert['order_number'] . '退还余额',
                ];
                $this->db->insert('userbalance', $a_userba);
            }
            echo json_encode(['stuo' => 33, 'name' => '取消订单成功！']);
        } else if ($ster == 2) {
            if ($a_tert['order_state'] == 20 || $a_tert['order_state'] == 25) {
                // 退款加到退款记录表
                $this->db->insert('reimburse', ['order_id' => $a_tert['order_id'], 'order_number' => $a_tert['order_number'], 'reimburse' => '卖家退款', 'time' => $_SERVER['REQUEST_TIME']]);
                if ($a_tert['payment_code'] == 'online') {
                    $this->db->insert('order_tracking', $a_track);
                    //把返回的金额和积分返回给用户
                    $a_user  = $this->db->get_row('user', ['user_id' => $a_tert['user_id']]);
                    $balance = $a_user['user_balance'] + $a_tert['balance_deduction'];
                    $score   = $a_user['user_score'] + $a_tert['use_jife'];
                    $a_usr   = [
                        'user_score'   => $score,
                        'user_balance' => $balance,
                    ];
                    $this->db->update('user', $a_usr, ['user_id' => $a_tert['user_id']]);
                    // 增加会员积分表
                    if (!empty($a_tert['use_jife'])) {
                        $a_jife = [
                            'user_id'        => $a_tert['user_id'],
                            'user_name'      => $a_tert['user_name'],
                            'pl_type'        => 1,
                            'pl_variation'   => $a_tert['use_jife'],
                            'pl_time'        => $_SERVER['REQUEST_TIME'],
                            'pl_score'       => $score,
                            'pl_description' => $a_tert['order_number'] . '退还积分',
                            'pl_item'        => '退还积分',
                            'pl_code'        => 7,
                        ];
                        $this->db->insert('points_log', $a_jife);
                    }
                    // 用户资金明细表
                    if (!empty($a_tert['balance_deduction'])) {
                        $a_userba = [
                            'ub_type'        => 1,
                            'ub_money'       => $a_tert['balance_deduction'],
                            'ub_balance'     => $balance,
                            'ub_time'        => $_SERVER['REQUEST_TIME'],
                            'ub_item'        => '退还余额',
                            'user_id'        => $a_tert['user_id'],
                            'ub_number'      => $a_tert['order_number'],
                            'ub_description' => $a_tert['order_number'] . '退还余额',
                        ];
                        $this->db->insert('userbalance', $a_userba);
                    }
                    echo json_encode(['stuo' => 33, 'name' => '取消订单成功！']);
                } else if ($a_tert['payment_code'] == 'alipay') {//支付宝
                    $this->load->library('alipay_wap');
                    $a_data = [
                        // 商户订单号，商户网站订单系统中唯一订单号，必填
                        'out_trade_no'   => $a_tert['pay_sn'],
                        // 请求退款金额，必填
                        'refund_amount'  => $a_tert['actual_pay'],
                        'refund_reason'  => '退款测试',
                        // 退款交易号，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
                        'out_request_no' => 'tk' . date('YmdHis', time()),
                        'is_page'        => false,
                    ];
                    $zhihu  = $this->alipay_wap->refund($a_data);
                    // 退款加到退款记录表
                    $this->db->insert('reimburse', ['order_id' => $a_tert['order_id'], 'order_number' => $a_tert['order_number'], 'reimburse' => '第三方处理中', 'time' => $_SERVER['REQUEST_TIME'], 'difan' => '支付宝']);
                    if ($zhihu['code'] == 10000) {
                        // 把订单状态改为取消
                        $this->db->update('order', ['order_state' => 0], ['order_id' => $id]);
                        $this->db->insert('order_tracking', $a_track);
                        //把返回的金额和积分返回给用户
                        $a_user  = $this->db->get_row('user', ['user_id' => $a_tert['user_id']]);
                        $balance = $a_user['user_balance'] + $a_tert['balance_deduction'];
                        $score   = $a_user['user_score'] + $a_tert['use_jife'];
                        $a_usr   = [
                            'user_score'   => $score,
                            'user_balance' => $balance,
                        ];
                        $this->db->update('user', $a_usr, ['user_id' => $a_tert['user_id']]);
                        // 增加会员积分表
                        if (!empty($a_tert['use_jife'])) {
                            $a_jife = [
                                'user_id'        => $a_tert['user_id'],
                                'user_name'      => $a_tert['user_name'],
                                'pl_type'        => 1,
                                'pl_variation'   => $a_tert['use_jife'],
                                'pl_time'        => $_SERVER['REQUEST_TIME'],
                                'pl_score'       => $score,
                                'pl_description' => $a_tert['order_number'] . '退还积分',
                                'pl_item'        => '退还积分',
                                'pl_code'        => 7,
                            ];
                            $this->db->insert('points_log', $a_jife);
                        }
                        // 用户资金明细表
                        if (!empty($a_tert['balance_deduction'])) {
                            $a_userba = [
                                'ub_type'        => 1,
                                'ub_money'       => $a_tert['balance_deduction'],
                                'ub_balance'     => $balance,
                                'ub_time'        => $_SERVER['REQUEST_TIME'],
                                'ub_item'        => '退还余额',
                                'user_id'        => $a_tert['user_id'],
                                'ub_number'      => $a_tert['order_number'],
                                'ub_description' => $a_tert['order_number'] . '退还余额',
                            ];
                            $this->db->insert('userbalance', $a_userba);
                        }

                        //增加订单处理历史表
                        $a_log = [
                            'order_id'       => $id,
                            'log_msg'        => $_SESSION['manager_name'] . $cho . '付款订单取消',
                            'log_time'       => $_SERVER['REQUEST_TIME'],
                            'log_role'       => '系统',
                            'log_user'       => $_SESSION['manager_name'],
                            'log_orderstate' => 0,
                        ];
                        $this->db->insert('order_log', $a_log);
                        // $a_logg = [
                        // 	'order_id' => $id,
                        // 	'log_msg'  => $_SESSION['manager_name'].'退款'.$a_tert['actual_pay'].'到支付宝成功！',
                        // 	'log_time' => $_SERVER['REQUEST_TIME'],
                        // 	'log_role' => '系统',
                        // 	'log_user' => '系统',
                        // 	'log_orderstate' => 5,
                        // ];
                        // $this->db->insert('order_log', $a_log);
                        // 退款加到退款记录表
                        // $this->db->insert('reimburse', ['order_id' => $a_tert['order_id'], 'order_number' => $a_tert['order_number'], 'reimburse' => '到账成功！', 'time' => $_SERVER['REQUEST_TIME'], 'difan' => '支付宝']);
                        echo json_encode(['stuo' => 33, 'name' => '退款成功！']);
                        die;
                    } else {
                        echo json_encode(['stuo' => 55, 'name' => '订单异常']);
                        die;
                    }

                } else if ($a_tert['payment_code'] == 'offline') {// 微信
                    $a_data = [
                        // 商户订单号和微信订单号必须二选一，同时设置时，优先使用微信订单号
                        'out_trade_no'   => $a_tert['order_number'],
                        // 微信订单号
                        'transaction_id' => '',
                        // 商户退款单号（自定义的，单号唯一，用来识别退款记录的）
                        'out_refund_no'  => 'tk' . date('YmdHis', time()),
                        // 订单金额，不是退款金额，以分为单位,
                        'total_fee'      => $a_tert['order_price'] * 100,
                        // 退款金额，以分为单位,
                        'refund_fee'     => $a_tert['actual_pay'] * 100,
                        // 通知地址，请参考支付实例完成退款的通知处理
                        'notify_url'     => $this->router->url('refund_notify'),

                        'is_page' => false,
                    ];
                    $this->load->library('wxpay_h5', '', [$a_data]);
                    $a_result = $this->wxpay_h5->refund();
                    if ($a_result['return_code'] == 'SUCCESS') {
                        $this->db->insert('order_tracking', $a_track);
                        // 退款加到退款记录表
                        $this->db->insert('reimburse', ['order_id' => $a_tert['order_id'], 'order_number' => $a_tert['order_number'], 'reimburse' => '第三方处理中', 'time' => $_SERVER['REQUEST_TIME'], 'difan' => '微信']);
                        // 把订单状态改为取消
                        $this->db->update('order', ['order_state' => 0], ['order_id' => $id]);
                        //把返回的金额和积分返回给用户
                        $a_user  = $this->db->get_row('user', ['user_id' => $a_tert['user_id']]);
                        $balance = $a_user['user_balance'] + $a_tert['balance_deduction'];
                        $score   = $a_user['user_score'] + $a_tert['use_jife'];
                        $a_usr   = [
                            'user_score'   => $score,
                            'user_balance' => $balance,
                        ];
                        $this->db->update('user', $a_usr, ['user_id' => $a_tert['user_id']]);
                        // 增加会员积分表
                        if (!empty($a_tert['use_jife'])) {
                            $a_jife = [
                                'user_id'        => $a_tert['user_id'],
                                'user_name'      => $a_tert['user_name'],
                                'pl_type'        => 1,
                                'pl_variation'   => $a_tert['use_jife'],
                                'pl_time'        => $_SERVER['REQUEST_TIME'],
                                'pl_score'       => $score,
                                'pl_description' => $a_tert['order_number'] . '退还积分',
                                'pl_item'        => '退还积分',
                                'pl_code'        => 7,
                            ];
                            $this->db->insert('points_log', $a_jife);
                        }
                        // 用户资金明细表
                        if (!empty($a_tert['balance_deduction'])) {
                            $a_userba = [
                                'ub_type'        => 1,
                                'ub_money'       => $a_tert['balance_deduction'],
                                'ub_balance'     => $balance,
                                'ub_time'        => $_SERVER['REQUEST_TIME'],
                                'ub_item'        => '退还余额',
                                'user_id'        => $a_tert['user_id'],
                                'ub_number'      => $a_tert['order_number'],
                                'ub_description' => $a_tert['order_number'] . '退还余额',
                            ];
                            $this->db->insert('userbalance', $a_userba);
                        }
                        //增加订单处理历史表
                        $a_log = [
                            'order_id'       => $id,
                            'log_msg'        => $_SESSION['manager_name'] . $cho . '付款订单取消',
                            'log_time'       => $_SERVER['REQUEST_TIME'],
                            'log_role'       => '系统',
                            'log_user'       => $_SESSION['manager_name'],
                            'log_orderstate' => 0,
                        ];
                        $this->db->insert('order_log', $a_log);
                        echo json_encode(['stuo' => 33, 'name' => '退款成功！']);
                        die;
                    } else if ($a_result['return_code'] == 4009) {
                        echo json_encode(['stuo' => 55, 'name' => '订单异常']);
                        die;
                    }
                } else if ($a_appointment['pay_type'] == 'unionpay') {
                    $this->load->library('unionpay_geteway');
                    $a_param  = [
                        // 订单号
                        'id_order' => $a_tert['order_number'],
                    ];
                    $a_result = $this->unionpay_geteway->query($a_param);
                    if ($this->unionpay_geteway->verify($a_result)) {
                        if ($a_result['origRespCode'] == '00') {
                            $a_param  = [
                                // 订单号
                                'id_order' => $a_tert['order_number'],
                                // 原消费的queryId，可以从查询接口或者通知接口中获取
                                'id_query' => $a_result['queryId'],
                                // （选填）交易金额，退货总金额需要小于或等于原消费
                                'amount'   => $a_tert['actual_pay'],
                            ];
                            $a_result = $this->unionpay_geteway->refund($a_param);
                            if ($this->unionpay_geteway->verify($a_result)) {
                                if ($a_result['respCode'] == '00') {
                                    $this->db->insert('order_tracking', $a_track);
                                    // 退款加到退款记录表
                                    $this->db->insert('reimburse', ['order_id' => $a_tert['order_id'], 'order_number' => $a_tert['order_number'], 'reimburse' => '第三方处理中', 'time' => $_SERVER['REQUEST_TIME'], 'difan' => '银联']);
                                    // 把订单状态改为取消
                                    $this->db->update('order', ['order_state' => 0], ['order_id' => $id]);
                                    //把返回的金额和积分返回给用户
                                    $a_user  = $this->db->get_row('user', ['user_id' => $a_tert['user_id']]);
                                    $balance = $a_user['user_balance'] + $a_tert['balance_deduction'];
                                    $score   = $a_user['user_score'] + $a_tert['use_jife'];
                                    $a_usr   = [
                                        'user_score'   => $score,
                                        'user_balance' => $balance,
                                    ];
                                    $this->db->update('user', $a_usr, ['user_id' => $a_tert['user_id']]);
                                    // 增加会员积分表
                                    if (!empty($a_tert['use_jife'])) {
                                        $a_jife = [
                                            'user_id'        => $a_tert['user_id'],
                                            'user_name'      => $a_tert['user_name'],
                                            'pl_type'        => 1,
                                            'pl_variation'   => $a_tert['use_jife'],
                                            'pl_time'        => $_SERVER['REQUEST_TIME'],
                                            'pl_score'       => $score,
                                            'pl_description' => $a_tert['order_number'] . '退还积分',
                                            'pl_item'        => '退还积分',
                                            'pl_code'        => 7,
                                        ];
                                        $this->db->insert('points_log', $a_jife);
                                    }
                                    // 用户资金明细表
                                    if (!empty($a_tert['balance_deduction'])) {
                                        $a_userba = [
                                            'ub_type'        => 1,
                                            'ub_money'       => $a_tert['balance_deduction'],
                                            'ub_balance'     => $balance,
                                            'ub_time'        => $_SERVER['REQUEST_TIME'],
                                            'ub_item'        => '退还余额',
                                            'user_id'        => $a_tert['user_id'],
                                            'ub_number'      => $a_tert['order_number'],
                                            'ub_description' => $a_tert['order_number'] . '退还余额',
                                        ];
                                        $this->db->insert('userbalance', $a_userba);
                                    }
                                    //增加订单处理历史表
                                    $a_log = [
                                        'order_id'       => $id,
                                        'log_msg'        => $_SESSION['manager_name'] . $cho . '付款订单取消',
                                        'log_time'       => $_SERVER['REQUEST_TIME'],
                                        'log_role'       => '系统',
                                        'log_user'       => $_SESSION['manager_name'],
                                        'log_orderstate' => 0,
                                    ];
                                    $this->db->insert('order_log', $a_log);
                                    echo json_encode(['stuo' => 33, 'name' => '退款成功！']);
                                    die;
                                }
                            }
                        }
                    }
                }
            } else {
                echo json_encode(['stuo' => 44, 'name' => '用户取消了订单！']);
                die;
            }
        }
    }

    // 订单接单派送

    public function delivery_wanchen()
    {
        $id     = $this->general->post('id');
        $a_tert = $this->db->get_row('order', ['order_id' => $id, 'store_id' => $_SESSION['store_id']]);
        if (empty($a_tert)) {
            echo json_encode(['stuo' => 55, 'name' => '订单有误！']);
            die;
        }
        // 把订单状态改为取消
        $this->db->update('order', ['order_state' => 10], ['order_id' => $id]);
        //增加订单处理历史表
        $a_log = [
            'order_id'       => $id,
            'log_msg'        => $_SESSION['manager_name'] . '点击完成订单！',
            'log_time'       => $_SERVER['REQUEST_TIME'],
            'log_role'       => '门店',
            'log_user'       => $_SESSION['manager_name'],
            'log_orderstate' => 10,
        ];
        $this->db->insert('order_log', $a_log);
        echo json_encode(['stuo' => 33, 'name' => '订单完成！']);
        die;
    }

    //一键抢单

    public function delivery_jiedan()
    {
        $i_id    = $this->general->post('id');
        $a_tert  = $this->db->get_row('order', ['order_id' => $i_id, 'store_id' => $_SESSION['store_id'], 'order_state' => 20]);
        $a_store = $this->db->get_row('store', ['store_id' => $_SESSION['store_id']]);
        if (empty($a_tert)) {
            echo json_encode(['stuo' => 55, 'name' => '订单有误！']);
            die;
        }
        $a_track = [
            'order_id'     => $i_id,
            'order_number' => $a_tert['order_number'],
            'name'         => '商家已接单',
            'time'         => $_SERVER['REQUEST_TIME'],
        ];
        $this->db->insert('order_tracking', $a_track);
        if (empty($a_tert['appointment_use'])) {
            // 达达配送
            $a_data   = [
                // 门店编号
                'shop_id'             => $a_store['transport_id'],
                // 订单ID
                'order_id'            => $a_tert['order_number'],
                // 订单所在城市的代码，可通过city_list函数获取所有城市代码
                'city_code'           => '020',
                // 订单金额
                'order_price'         => $a_tert['order_price'],
                // 是否需要垫付 1:是 0:否 (垫付订单金额，非运费)
                'is_prepay'           => '0',
                // 期望取货时间（1.时间戳,以秒计算时间，即unix-timestamp; 2.该字段的设定，不会影响达达正常取货; 3.订单待接单时,该时间往后推半小时后，会自动被系统取消;4.建议取值为当前时间往后推10~15分钟）
                'expected_fetch_time' => $_SERVER['REQUEST_TIME'] + 600,
                // 	收货人姓名
                'receiver_name'       => $a_tert['reciver_name'],
                // 收货人地址
                'receiver_address'    => $a_tert['addres'],
                // 收货人地址经度（高德坐标系）
                'receiver_longitude'  => explode(",", $a_tert['addres_post'])[1],
                // 收货人地址维度（高德坐标系）
                'receiver_latitude'   => explode(",", $a_tert['addres_post'])[0],
                // 回调地址
                'callback'            => $this->router->url('notify'),
                // 收货人手机号（手机号和座机号必填一项）
                'receiver_phone'      => $a_tert['mob_phone'],
                // 收货人座机号（手机号和座机号必填一项）
                // 'receiver_tel' => '',
                //=========== 下方为选填项 =============//
                /*// 小费
                'fee' => 0.0,
                // 订单备注
                'message' => '',
                // 订单商品类型：食品小吃-1,饮料-2,鲜花-3,文印票务-8,便利店-9,水果生鲜-13,同城电商-19, 医药-20,蛋糕-21,酒品-24,小商品市场-25,服装-26,汽修零配-27,数码-28,小龙虾-29, 其他-5
                'order_type' => '',
                // 订单重量（单位：Kg）
                'goods_weight' => '',
                // 订单商品数量
                'goods_num' => '',
                // 发票抬头
                'invoice_title' => '',
                // 送货开箱码
                'deliver_locker_code' => '',
                // 取货开箱码
                'pickup_locker_code' => '',
                // 订单来源标示（该字段可以显示在达达app订单详情页面，只支持字母，最大长度为10）
                'order_mark' => '',
                // 订单来源编号（该字段可以显示在达达app订单详情页面，支持字母和数字，最大长度为30）
                'order_mark_no' => '',
                // 商品保价费(当商品出现损坏，可获取一定金额的赔付)保价费分三挡：分别为1元，3元，5元。1元保价：最高可获取100元赔付。3元保价：最高可获取300元赔付。5元保价：最高可获取1000元赔付。
                'insurance_fee' => '',
                // 收货码（0：不需要；1：需要。收货码的作用是：骑手必须输入收货码才能完成订单妥投）
                'is_finish_code_needed' => ''*/
            ];
            $s_result = $this->general->request('http://distribution.7dugo.com/add.html', $a_data);
            $a_result = json_decode($s_result, true);
            if ($a_result['status_code'] == 10000) {
                $a_track['name'] = '配送员已接单';
                $a_track['time'] = $a_data['expected_fetch_time'];
                $this->db->insert('order_tracking', $a_track);
            }
        }

        //把选择的配送订更改状态
        $s_data = $this->db->update('order', ['order_state' => 30], ['store_id' => $_SESSION['store_id'], 'order_id' => $i_id]);
        //增加订单处理历史表
        $a_log = [
            'order_id'       => $i_id,
            'log_msg'        => $_SESSION['manager_name'] . '派送了订单',
            'log_time'       => $_SERVER['REQUEST_TIME'],
            'log_role'       => '门店',
            'log_user'       => $_SESSION['manager_name'],
            'log_orderstate' => 30,
        ];
        $this->db->insert('order_log', $a_log);

        //门店日消耗销售额和订单数
        $a_ord   = $this->db->get_row('order', ['order_id' => $i_id]);
        $a_sales = $this->db->get('consumabel_sales', ['store_id' => $_SESSION['store_id'], 'daily_time' => mktime(0, 0, 0, date('m'), 1, date('Y'))]);
        if ($a_sales) {
            $this->db->set('daily_sales', 'daily_sales +' . $a_ord['order_price'], false);
            $this->db->update('consumabel_sales', '', ['store_id' => $_SESSION['store_id'], 'daily_time' => mktime(0, 0, 0, date('m'), 1, date('Y'))]);
            $this->db->set('daily_order', 'daily_order +' . 1, false);
            $this->db->update('consumabel_sales', '', ['store_id' => $_SESSION['store_id'], 'daily_time' => mktime(0, 0, 0, date('m'), 1, date('Y'))]);

        } else {
            $this->db->insert('consumabel_sales', ['store_id' => $_SESSION['store_id'], 'daily_time' => mktime(0, 0, 0, date('m'), 1, date('Y')), 'daily_order' => 1, 'daily_sales' => $a_ord['order_price']]);
        }

        //门店耗材相对在数据库减少
        //订单产品
        $a_order = $this->db->get('order_goods', ['order_id' => $i_id]);
        foreach ($a_order as $goods) {
            //把产品购买加入月售数据表
            $a_num = $this->db->get_row('product_number', ['product_id' => $goods['product_id']]);
            if (empty($a_num)) {
                $this->db->insert('product_number', ['product_id' => $goods['product_id'], 'number' => $goods['goods_num']]);
            } else {
                $this->db->set('number', 'number +' . $goods['goods_num'], false);
                $this->db->update('product_number', '', ['product_id' => $goods['product_id']]);
            }
            // 拿到相对应的产品耗材
            $a_term = $this->db->get('product_term', ['product_id' => $goods['product_id'], 'cup_id' => $goods['cup_id']]);
            //拿到耗材
            foreach ($a_term as $term) {
                $a_data = $this->db->get_row('consumable_inventory', ['store_id' => $_SESSION['store_id'], 'consumption_id' => $term['consumption_id'], 'inventory <' => 'prewarning_value']);
                if (!empty($a_data)) {
                    //耗材少于预警值就发送到消息表
                    $a_messg = [
                        'ues'       => 2,
                        'content'   => '耗材' . $term['consu_name'] . '库存低于耗材预警值快去进货吧！',
                        'examine'   => 1,
                        'mess_time' => $_SERVER['REQUEST_TIME'],
                    ];
                    $this->db->insert('messagess', $a_messg);
                }
                // 门店耗材减少
                $this->db->set('inventory', 'inventory - ' . $term['amount'] . '*' . $goods['goods_num'], false)->update('consumable_inventory', '', ['consumption_id' => $term['consumption_id'], 'store_id' => $_SESSION['store_id']]);
                //添加门店天的耗材量
                $a_where = [
                    'store_id'       => $_SESSION['store_id'],
                    'consumption_id' => $term['consumption_id'],
                    'daily_time'     => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                ];
                // $this->db->insert('test', ['test_content' => json_encode($a_where)]);
                $a_expend = $this->db->get('consumabel_expend', $a_where);
                if ($a_expend) {
                    $this->db->set('expend', 'expend +' . $term['amount'], false)->update('consumabel_expend', '', $a_where);
                } else {
                    $this->db->insert('consumabel_expend', ['store_id' => $_SESSION['store_id'], 'consumption_id' => $term['consumption_id'], 'daily_time' => mktime(0, 0, 0, date('m'), date('d'), date('Y')), 'expend' => $term['amount']]);
                }
            }
        }

        /***********************************************************************************************/

        /**
         * 更新的内容分七块：
         * 1、订单记录[order表]：下单人的上级id、下单人给上级的积分
         * 2、用户记录[user表]：用户自己的积分、用户自己的消费总额、用户自己给上级的积分总数、用户自己成单的ids、用户自己的成单数量、用户购买的咖啡数量
         * 3、用户记录[user表]：用户上级的积分、用户上级的所有下级消费总额、用户推荐人成单的ids、用户推荐的人成单数、用户推荐的人购买的咖啡数量
         * 4、结算记录[account表]：如果接单的门店本月有记录则取出修改字段
         *      月订单总数、月销售产品总数、月销售总额、当月成交的订单id集;
         *      如果没有数据则创建一条数据
         * 5、用户消费统计[statistic表]：有则追加，无则创建
         * 6、门店表[store表]：门店成单数、门店销售总额
         * 7、用户积分变动表[points_log]
         */

        // 获取设置信息
        $a_set = $this->delivery_model->get_set_all();
        foreach ($a_set as $key => $value) {
            if ($value['set_name'] == 'user_score_ratio') {
                $user_score_ratio = $value['set_parameter'];
            } else if ($value['set_name'] == 'user_consume_ratio') {
                $user_consume_ratio = $value['set_parameter'];
            } else if ($value['set_name'] == 'shopman_score_retio') {
                $shopman_score_retio = $value['set_parameter'];
            } else if ($value['set_name'] == 'shopman_referee_ratio') {
                $shopman_referee_ratio = $value['set_parameter'];
            } else if ($value['set_name'] == 'score_tostore_ratio') {
                $score_tostore_ratio = $value['set_parameter'];
            }
        }
        // 查询门店信息的条件
        $a_store_where = [
            'store_id' => $_SESSION['store_id'],
        ];
        // 循环订单id数组
        $i_id = [$i_id];
        for ($i = 0; $i < count($i_id); $i++) {
            $this_order_id = $i_id[$i];
            // 获取一条订单信息
            $a_order_row = $this->delivery_model->get_order_one($this_order_id);
            // 获取一条用户信息
            $a_user_row = $this->delivery_model->get_user_one($a_order_row['user_id']);
            // 判断用户是否有推荐人
            if ($a_user_row['user_referee']) {
                // 判断用户的推荐人是否是移动店主 并且移动店主状态是否开启
                $a_referee_row = $this->delivery_model->get_user_one($a_user_row['user_referee']);
                if ($a_referee_row['is_shopman'] == 1 && $a_referee_row['shopman_state'] == 1) {
                    $order_commission = round(($shopman_referee_ratio / 100) * $a_order_row['goods_amount'], 2);
                } else {
                    $order_commission = round(($user_consume_ratio / 100) * $a_order_row['goods_amount'], 2);
                }
                $score_tostore  = round(($score_tostore_ratio / 100) * $a_order_row['goods_amount'], 2);
                $a_order_where  = [
                    'order_id' => $this_order_id,
                ];
                $a_order_update = [
                    'order_referee'    => $a_user_row['user_referee'],
                    'order_commission' => $order_commission,
                    'score_tostore'    => $score_tostore,
                ];
                // 更新订单信息
                $this->delivery_model->update_order($a_order_where, $a_order_update);
                // 更新推荐人的积分和推荐人的推荐人消费总额
                $a_referee_where = [
                    'user_id' => $a_user_row['user_referee'],
                ];
                if (empty($a_referee_row['referee_orders'])) {
                    $referee_orders = $this_order_id;
                } else {
                    $referee_orders = $a_referee_row['referee_orders'] . ',' . $this_order_id;
                }
                $a_referee_update = [
                    'user_score'         => $a_referee_row['user_score'] + $order_commission,
                    'referee_consume'    => $a_referee_row['referee_consume'] + $a_order_row['goods_amount'],
                    'referee_orders'     => $referee_orders,
                    'referee_ordercount' => $a_referee_row['referee_ordercount'] + 1,
                    'referee_products'   => $a_referee_row['referee_products'] + $a_order_row['order_count'],
                    'shopman_income'     => $a_referee_row['shopman_income'] + $order_commission,
                ];
                $i_result         = $this->delivery_model->update_user($a_referee_where, $a_referee_update);
                // 若更新成功则插入一条积分变动信息到'.$this->db->get_prefix().'points_log表
                if ($i_result && $order_commission > 0) {
                    $a_points_log = [
                        'user_id'        => $a_user_row['user_referee'],
                        'user_name'      => $a_referee_row['user_name'],
                        'pl_type'        => 1,
                        'pl_variation'   => $order_commission,
                        'pl_score'       => $a_referee_row['user_score'] + $order_commission,
                        'pl_item'        => '推荐的人消费返积分',
                        'pl_description' => '用户' . $a_user_row['user_name'] . '消费' . $a_order_row['goods_amount'] . '元',
                        'pl_time'        => $_SERVER['REQUEST_TIME'],
                        'pl_code'        => 6,
                    ];
                    $this->delivery_model->insert_points_log($a_points_log);
                }
            } else {
                $score_tostore  = round(($score_tostore_ratio / 100) * $a_order_row['goods_amount'], 2);
                $a_order_where  = [
                    'order_id' => $this_order_id,
                ];
                $a_order_update = [
                    'score_tostore' => $score_tostore,
                ];
                // 更新订单信息
                $this->delivery_model->update_order($a_order_where, $a_order_update);
            }

            // 判断用户自己是否是移动店主
            if ($a_user_row['is_shopman'] == 1 && $a_user_row['shopman_state'] == 1) {
                $add_user_score = round(($shopman_score_retio / 100) * $a_order_row['goods_amount'], 2);
            } else {
                $add_user_score = round(($user_score_ratio / 100) * $a_order_row['goods_amount'], 2);
            }
            // 更新自己的积分及消费金额
            $a_where_thisuser = [
                'user_id' => $a_order_row['user_id'],
            ];
            if (empty($a_user_row['user_orders'])) {
                $user_orders = $this_order_id;
            } else {
                $user_orders = $a_user_row['user_orders'] . ',' . $this_order_id;
            }
            // 如果有推荐人则顺便更新给自己的推荐人的总提成字段 没有则直接更新消费金额和积分
            if ($a_user_row['user_referee']) {
                $a_thisuser_update = [
                    'user_consume'    => $a_user_row['user_consume'] + $a_order_row['goods_amount'],
                    'user_score'      => $a_user_row['user_score'] + $add_user_score,
                    'user_commission' => $a_user_row['user_commission'] + $order_commission,
                    'user_orders'     => $user_orders,
                    'user_ordercount' => $a_user_row['user_ordercount'] + 1,
                    'user_products'   => $a_user_row['user_products'] + $a_order_row['order_count'],
                ];
            } else {
                $a_thisuser_update = [
                    'user_consume'    => $a_user_row['user_consume'] + $a_order_row['goods_amount'],
                    'user_score'      => $a_user_row['user_score'] + $add_user_score,
                    'user_orders'     => $user_orders,
                    'user_ordercount' => $a_user_row['user_ordercount'] + 1,
                    'user_products'   => $a_user_row['user_products'] + $a_order_row['order_count'],
                ];
            }
            $i_res = $this->delivery_model->update_user($a_where_thisuser, $a_thisuser_update);
            // 如果更新成功则插入一条积分变动信息
            if ($i_res && $add_user_score > 0) {
                $a_points_log = [
                    'user_id'        => $a_order_row['user_id'],
                    'user_name'      => $a_user_row['user_name'],
                    'pl_type'        => 1,
                    'pl_variation'   => $add_user_score,
                    'pl_score'       => $a_user_row['user_score'] + $add_user_score,
                    'pl_item'        => '消费返积分',
                    'pl_description' => '订单' . $a_order_row['order_number'] . '消费返积分',
                    'pl_time'        => $_SERVER['REQUEST_TIME'],
                    'pl_code'        => 5,
                ];
                $this->delivery_model->insert_points_log($a_points_log);
            }

            // 当前月的起始时间戳
            $beginThismonth = mktime(0, 0, 0, date('m'), 1, date('Y'));
            // 判断结算数据表是否有当前月份的数据 有则获取并更新 无则创建
            $a_account_row = $this->delivery_model->get_account_one($beginThismonth, $a_order_row['store_id']);
            if ($a_account_row) {
                // 为真则更新结算数据
                $a_where_account = [
                    'account_id' => $a_account_row['account_id'],
                ];
                if (empty($a_account_row['order_ids'])) {
                    $order_ids = $this_order_id;
                } else {
                    $order_ids = $a_account_row['order_ids'] . ',' . $this_order_id;
                }
                $a_data_account = [
                    'order_count'       => $a_account_row['order_count'] + 1,
                    'product_count'     => $a_account_row['product_count'] + $a_order_row['order_count'],
                    'money_count'       => $a_account_row['money_count'] + $a_order_row['goods_amount'],
                    'order_ids'         => $order_ids,
                    'month_score'       => $a_account_row['month_score'] + $score_tostore,
                    'coffee_money'      => $a_account_row['coffee_money'] + $a_order_row['goods_amount'],
                    'coffee_ordercount' => $a_account_row['coffee_ordercount'] + 1,
                ];
                $this->delivery_model->update_account($a_where_account, $a_data_account);
            } else {
                // 为假则插入一条结算数据
                $a_account_insert = [
                    'store_id'          => $a_order_row['store_id'],
                    'order_count'       => 1,
                    'product_count'     => $a_order_row['order_count'],
                    'money_count'       => $a_order_row['goods_amount'],
                    'account_time'      => $beginThismonth,
                    'account_state'     => 0,
                    'order_ids'         => $this_order_id,
                    'month_score'       => $score_tostore,
                    'coffee_money'      => $a_order_row['goods_amount'],
                    'coffee_ordercount' => 1,
                ];
                $this->delivery_model->insert_account($a_account_insert);
            }

            // 将自己的消费信息统计到用户消费统计表
            $a_statistic_row = $this->delivery_model->get_statistic_one($a_order_row['user_id'], $beginThismonth);
            // 有数据则修改 无数据则插入数据
            if ($a_statistic_row) {
                $a_where_sta = [
                    'sta_id' => $a_statistic_row['sta_id'],
                ];
                // 判断字段是否为空
                if (empty($a_statistic_row['user_selforder'])) {
                    $user_selforder_s = $a_order_row['order_id'];
                } else {
                    $user_selforder_s = $a_statistic_row['user_selforder'] . ',' . $a_order_row['order_id'];
                }
                $a_sta_update = [
                    'user_self'      => $a_statistic_row['user_self'] + $a_order_row['goods_amount'],
                    'user_selfcount' => $a_statistic_row['user_selfcount'] + $a_order_row['order_count'],
                    'user_selforder' => $user_selforder_s,
                    'user_selfsum'   => $a_statistic_row['user_selfsum'] + 1,
                ];
                $this->delivery_model->update_statistic($a_where_sta, $a_sta_update);
            } else {
                $a_sta_insert = [
                    'user_id'        => $a_order_row['user_id'],
                    'sta_time'       => $beginThismonth,
                    'user_self'      => $a_order_row['goods_amount'],
                    'user_selfcount' => $a_order_row['order_count'],
                    'user_selforder' => $a_order_row['order_id'],
                    'user_selfsum'   => 1,
                ];
                $this->delivery_model->insert_statistic($a_sta_insert);
            }

            // 获取一条门店信息
            $a_store_this = $this->delivery_model->get_store_one($_SESSION['store_id']);
            // 更新门店的成单数、门店销售总额、门店积分
            $a_store_update = [
                'store_amount'     => $a_store_this['store_amount'] + $a_order_row['goods_amount'],
                'store_order'      => $a_store_this['store_order'] + 1,
                'store_salescount' => $a_store_this['store_salescount'] + $a_order_row['order_count'],
                'store_score'      => $a_store_this['store_score'] + $score_tostore,
                'store_allorder'   => $a_store_this['store_allorder'] + 1,
                'accumulate_score' => $a_store_this['accumulate_score'] + $score_tostore,
            ];
            $i_result_s     = $this->delivery_model->update_store($a_store_where, $a_store_update);
            if ($i_result_s && $score_tostore > 0) {
                // 插入一条门店积分变动信息
                $a_insert_sc = [
                    'store_id'       => $_SESSION['store_id'],
                    'sc_type'        => 1,
                    'sc_score'       => $score_tostore,
                    'sc_time'        => $_SERVER['REQUEST_TIME'],
                    'sc_description' => '订单' . $a_order_row['order_number'] . '返积分',
                ];
                $this->delivery_model->insert_storescore($a_insert_sc);
            }

            // 判断用户是否有推荐人 如果有则判断推荐人本月是否有统计数据 有则更新 无则创建
            if ($a_user_row['user_referee']) {
                // 获取推荐人本月的消费统计表
                $a_sta_referee = $this->delivery_model->get_statistic_one($a_user_row['user_referee'], $beginThismonth);
                // 有统计数据则更新 没有则创建
                if ($a_sta_referee) {
                    $a_stareferee_where = [
                        'sta_id' => $a_sta_referee['sta_id'],
                    ];
                    // 判断字段是否为空
                    if (empty($a_sta_referee['user_otherorder'])) {
                        $user_otherorder_s = $a_order_row['order_id'];
                    } else {
                        $user_otherorder_s = $a_sta_referee['user_otherorder'] . ',' . $a_order_row['order_id'];
                    }
                    $a_stareferee_data = [
                        'user_other'      => $a_sta_referee['user_other'] + $a_order_row['goods_amount'],
                        'user_othercount' => $a_sta_referee['user_othercount'] + $a_order_row['order_count'],
                        'user_otherorder' => $user_otherorder_s,
                        'user_othersum'   => $a_sta_referee['user_othersum'] + 1,
                    ];
                    $this->delivery_model->update_statistic($a_stareferee_where, $a_stareferee_data);
                } else {
                    $a_stareferee_insertdata = [
                        'user_id'         => $a_user_row['user_referee'],
                        'sta_time'        => $beginThismonth,
                        'user_other'      => $a_order_row['goods_amount'],
                        'user_othercount' => $a_order_row['order_count'],
                        'user_otherorder' => $a_order_row['order_id'],
                        'user_othersum'   => 1,
                    ];
                    $this->delivery_model->insert_statistic($a_stareferee_insertdata);
                }
            }
        }

        /***********************************************************************************************/

// 此处更新产品的库存量
        $order_id = $a_tert['order_id'];
// 获取此订单下所有的产品
        $a_order_product = $this->delivery_model->get_order_goods($order_id);
        if (!empty($a_order_product)) {
            $start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            foreach ($a_order_product as $key => $value) {
                // 获取该产品在本门店的信息
                $a_product_detail = $this->delivery_model->get_pro_sto($value['product_id']);
                // 验证当前是否有库存数据有则更新无则创建
                $a_data_stock = $this->delivery_model->get_stock_one($value['product_id']);
                if (empty($a_data_stock)) {
                    // 无记录则创建
                    $a_insert_stock = [
                        'product_id'    => $value['product_id'],
                        'store_id'      => $_SESSION['store_id'],
                        'product_stock' => $a_product_detail['pro_stock'] - $value['goods_num'],
                        'stock_time'    => $start,
                    ];
                    $i_result       = $this->delivery_model->insert_stock($a_insert_stock);
                } else {
                    // 有记录则更新
                    $a_update_where = [
                        'stock_id' => $a_data_stock['stock_id'],
                    ];
                    $a_update_data  = [
                        'product_stock' => $a_data_stock['product_stock'] - $value['goods_num'],
                    ];
                    $i_result       = $this->delivery_model->update_stock($a_update_where, $a_update_data);
                }
            }
        }

        /***********************************************************************************************/

        echo json_encode(['stuo' => 33, 'name' => '接单成！']);
    }

    //门店新订单提示消息

    public function onekey()
    {
        //门店的坐标
        $a_data['store'] = $this->db->get_row('store', ['store_id' => $_SESSION['store_id']], ['store_position']);
        $store           = explode(",", $a_data['store']['store_position']);
        //订单的定位坐标
        $a_data['order'] = $this->db->get('order', ['store_id' => 0], ['addres_post', 'order_id', 'store_id']);
        foreach ($a_data['order'] as $value) {
            $order    = explode(",", $value['addres_post']);
            $distance = $this->getDistance($order[0], $store[1], $order[1], $store[0], 2);
            //判断小于5公里的订单
            if ($distance <= 5.00) {
                $a_data = $this->db->get_row('order', ['order_id' => $value['order_id'], 'store_id' => 0]);
                if (!empty($a_data)) {
                    $a_order = $this->db->update('order', ['store_id' => $_SESSION['store_id'], 'order_state' => 25], ['order_id' => $value['order_id']]);
                }
            }
        }
        if (!empty($a_order)) {
            $this->error->show_success('抢单成功！', 'delivery', '', 1);
        } else {
            $this->error->show_error('暂时无单可抢！', 'delivery', '', 1);
        }
    }

    public function delivery_xindind()
    {
        $a_data = $this->db->get('order', ['store_id' => $_SESSION['store_id'], 'order_state' => 20, 'order_time <' => time() . '+ 600', 'chankan' => 1]);
        if (!empty($a_data)) {
            $this->db->update('order', ['chankan' => 2], ['store_id' => $_SESSION['store_id'], 'order_state' => 20, 'order_time <' => time() . '+ 600']);
            echo json_encode(['stur' => 55, 'name' => '有新订单!']);
            die;
        }
        echo json_encode(['stur' => 60, 'name' => '无新订单！']);
        die;
    }
}
