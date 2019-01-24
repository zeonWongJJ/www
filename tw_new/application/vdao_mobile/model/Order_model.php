<?php

class Order_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /***************************** 获取5条办公室订单信息 *****************************/

    /**
     * [get_appointment_part 获取5条办公室订单信息]
     * @param  [int] $user_id   [传入的用户id]
     * @return [array]          [返回查询到的数据]
     */
    public function get_appointment_user($user_id, $appointment_state)
    {
        if ($appointment_state == 9) {
            $a_where = [
                'user_id'          => $user_id,
                'appointment_type' => 1,
            ];
        } else {
            $a_where = [
                'user_id'           => $user_id,
                'appointment_state' => $appointment_state,
                'appointment_type'  => 1,
            ];
        }
        $s_field = '';
        $a_order = [
            'appointment_id' => 'desc',
        ];
        $a_data  = $this->db->from('appointment')
            ->join('store', [$this->db->get_prefix() . 'store.store_id' => $this->db->get_prefix() . 'appointment.store_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /****************************** 获取一条办公室订单 ******************************/

    /**
     * [get_appointment_one 获取一条办公室订单]
     * @param  [int] $appointment_id   [传入的订单id]
     * @return [array]                 [返回查询到的数据]
     */
    public function get_appointment_one($appointment_id)
    {
        $a_where = [
            'appointment_id' => $appointment_id,
        ];
        $s_field = '';
        $a_data  = $this->db->from('appointment')
            ->join('store', [$this->db->get_prefix() . 'store.store_id' => $this->db->get_prefix() . 'appointment.store_id'])
            ->join('room', [$this->db->get_prefix() . 'room.room_id' => $this->db->get_prefix() . 'appointment.room_id'])
            ->get_row('', $a_where, $s_field);
        return $a_data;
    }

    /********************************* 获取房间设备 ********************************/

    /**
     * [get_romm_device 获取部分设备信息]
     * @param  [array]   $a_data     [要获取的设备id数组]
     * @return [array]   $i_result   [返回获取到的数据]
     */
    public function get_room_device($a_data)
    {
        $a_where = [
            'device_state' => 1,
        ];
        $a_data  = $this->db->where_in('device_id', $a_data)->get('device', $a_where, '', [], 0, 99999999);
        return $a_data;
    }

    /******************************* 更新一条预约记录 *******************************/

    /**
     * [update_appointment 更新一条预约记录]
     * @param  [array] $a_where [更新的条件]
     * @param  [array] $a_data  [更新的数据]
     * @return [int]            [返回受影响的行数]
     */
    public function update_appointment($a_where, $a_data)
    {
        $i_result = $this->db->update('appointment', $a_data, $a_where);
        return $i_result;
    }

    /***************************** 获取某条订单评论数 *******************************/

    /**
     * [get_comment_total 获取某条订单评论数]
     * @param  [int] $appointment_id [传入的订单id]
     * @return [int]                 [返回查询到的总数]
     */
    public function get_comment_total($appointment_id)
    {
        $a_where  = [
            'object_id'    => $appointment_id,
            'user_id'      => $_SESSION['user_id'],
            'comment_type' => 1,
        ];
        $i_result = $this->db->get_total('comment', $a_where);
        return $i_result;
    }

    /****************************** 插入一条评论信息 ********************************/

    /**
     * [insert_comment 插入一条评论信息]
     * @param  [array] $a_data [要插入的信息]
     * @return [int]           [返回新数据的id]
     */
    public function insert_comment($a_data)
    {
        $i_result = $this->db->insert('comment', $a_data);
        return $i_result;
    }

    /***************************** 获取5条产品订单信息 *****************************/

    /**
     * [product 获取5条产品订单信息]
     * @param  [int] $user_id   [传入的用户id]
     * @return [array]          [返回查询到的数据]
     */
    public function product()
    {
        $this->db->group_by('b.order_id');
        $a_where   = ['a.user_id' => $_SESSION['user_id']];
        $a_sele    = "b.order_id, b.spec, b.pro_img, b.product_id, b.product_name, b.money, b.goods_num";
        $a_product = $this->db->from('order as a')
            ->join('order_goods as b', ['a.order_id' => 'b.order_id'])
            ->get('', $a_where, $a_sele, '', 0, 9999999);
        return $a_product;
    }

    /***************************** 获取产品订单详情信息 *****************************/

    /**
     * [product 获取5条产品订单信息]
     * @param  [int] $user_id   [传入的订单id]
     * @return [array]          [返回查询到的数据]
     */
    public function product_details($id)
    {
        $a_where   = ['a.user_id' => $_SESSION['user_id'], 'a.order_id' => $id];
        $a_details = $this->db->from('order as a')
            ->join('order_goods as b', ['a.order_id' => 'b.order_id'])
            ->join('store as c', ['a.store_id' => 'c.store_id'])
            ->get('', $a_where);
        return $a_details;
    }


    /****************************** 获取订单评论的标签 ******************************/

    /**
     * [get_comtag_all 获取订单评论的标签]
     * @return [type] [description]
     */
    public function get_comtag_all($store_id)
    {
        $a_where = [
            'comtag_type' => 1,
            'store_id'    => $store_id,
        ];
        $s_field = '';
        $a_order = [
            'comtag_id' => 'desc',
        ];
        $a_data  = $this->db->get('comtag', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /******************************** 获取订座的订单 ********************************/

    public function get_order_book($user_id, $state, $page)
    {
        // 先设置默认从第一页开始
        $i_page = $page;
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        if ($state == 9) {
            $a_where = [
                'user_id'          => $user_id,
                'appointment_type' => 2,
            ];
        } else {
            $a_where = [
                'user_id'           => $user_id,
                'appointment_type'  => 2,
                'appointment_state' => $state,
            ];
        }
        $i_total = $this->db->get_total('appointment', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = '';
        $a_order = [
            'appointment_id' => 'desc',
        ];
        $a_data  = $this->db->from('appointment')
            ->join('store', [$this->db->get_prefix() . 'store.store_id' => $this->db->get_prefix() . 'appointment.store_id'])
            ->get('', $a_where, $s_field, $a_order);
        return $a_data;
    }

    /****************************** 获取门店所有评论 *******************************/

    /**
     * [get_comment_store 获取门店所有评论]
     * @param  [type] $store_id [description]
     * @return [type]           [description]
     */
    public function get_comment_store($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $s_field = '';
        $a_order = [
            'comment_id' => 'desc',
        ];
        $a_data  = $this->db->get('comment', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /******************************* 更新一条门店信息 *******************************/

    /**
     * [update_store 更新一条门店信息]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_store($a_where, $a_data)
    {
        $i_result = $this->db->update('store', $a_data, $a_where);
        return $i_result;
    }

    /************************** 获取最近5秒支付的一条订单 ***************************/

    public function get_officeorder_second()
    {
        $a_where = [
            'pay_time >' => time() - 5,
        ];
        $a_data  = $this->db->get_row('appointment', $a_where);
        return $a_data;
    }

    /********************************************************************************/
    /**
     * [system_sure_order 自动确认订单的收货状态]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function system_sure_order()
    {
        $a_where = ['order_state' => 30, 'user_id' => $_SESSION['user_id'], 'order_time <' => strtotime(' -120 minute')];
        $a_data  = $this->db->get('order', $a_where, '', '', 0, 9999999999);
        if (!empty($a_data) && is_array($a_data)) {
            foreach ($a_data as $key => $val) {
                $a_name = [
                    'order_id'       => $val['order_id'],
                    'log_msg'        => '确认了收货',
                    'log_time'       => $_SERVER['REQUEST_TIME'],
                    'log_role'       => '系统',
                    'log_user'       => '系统',
                    'log_orderstate' => 10,
                ];
                $this->db->insert('order_log', $a_name);
                $a_ensure = $this->db->update('order', ['order_state' => 10, 'time_finnshed' => $_SERVER['REQUEST_TIME']], ['order_id' => $val['order_id']]);
            }
        }
        //付款订单的取消
        unset($a_where);
        unset($a_data);
        $a_where = ['order_state' => 20, 'user_id' => $_SESSION['user_id'], 'order_time <' => strtotime(' -30 minute')];
        $a_data  = $this->db->get('order', $a_where, '', '', 0, 9999999999);
        if (!empty($a_data) && is_array($a_data)) {
            foreach ($a_data as $key => $val) {
                // 退款加到退款记录表
                $this->db->insert('reimburse', ['order_id' => $val['order_id'], 'order_number' => $val['order_number'], 'reimburse' => '付款订单长时间没接单,系统自动取消订单。', 'time' => $_SERVER['REQUEST_TIME']]);
                $a_track = [
                    'order_id'     => $val['order_id'],
                    'order_number' => $val['order_number'],
                    'name'         => '订单已取消',
                    'time'         => $_SERVER['REQUEST_TIME'],
                ];
                $a_user  = $this->db->get_row('user', ['user_id' => $val['user_id']]);
                if ($val['payment_code'] == 'online') {
                    $this->db->insert('order_tracking', $a_track);
                    //把返回的金额和积分返回给用户

                    $balance = $a_user['user_balance'] + $val['balance_deduction'];
                    $score   = $a_user['user_score'] + $val['use_jife'];
                    $a_usr   = [
                        'user_score'   => $score,
                        'user_balance' => $balance,
                    ];
                    $this->db->update('user', $a_usr, ['user_id' => $val['user_id']]);
                    // 增加会员积分表
                    if ($val['use_jife'] > 0) {
                        $a_jife = [
                            'user_id'        => $val['user_id'],
                            'user_name'      => $a_user['user_name'],
                            'pl_type'        => 1,
                            'pl_variation'   => $val['use_jife'],
                            'pl_time'        => $_SERVER['REQUEST_TIME'],
                            'pl_score'       => $score,
                            'pl_description' => $val['order_number'] . '退还积分',
                            'pl_item'        => '退还积分',
                            'pl_code'        => 7,
                        ];
                        $this->db->insert('points_log', $a_jife);
                    }
                    // 用户资金明细表
                    if ($val['balance_deduction'] > 0) {
                        $a_userba = [
                            'ub_type'        => 1,
                            'ub_money'       => $val['balance_deduction'],
                            'ub_balance'     => $balance,
                            'ub_time'        => $_SERVER['REQUEST_TIME'],
                            'ub_item'        => '退还余额',
                            'user_id'        => $_SESSION['user_id'],
                            'ub_number'      => $val['order_number'],
                            'ub_description' => $val['order_number'] . '退还余额',
                        ];
                        $this->db->insert('userbalance', $a_userba);
                    }
                    $a_name = [
                        'order_id'       => $val['order_id'],
                        'log_msg'        => '取消了订单',
                        'log_time'       => $_SERVER['REQUEST_TIME'],
                        'log_role'       => '系统',
                        'log_user'       => $a_user['user_name'],
                        'log_orderstate' => 0,
                    ];
                    $this->db->insert('order_log', $a_name);
                    $a_weifuk = $this->db->update('order', ['order_state' => 0, 'time_finnshed' => $_SERVER['REQUEST_TIME']], ['order_id' => $val['order_id'], 'user_id' => $val['user_id']]);

                } else if ($val['payment_code'] == 'alipay') {//支付宝
                    $this->load->library('alipay_wap');
                    $a_data = [
                        // 商户订单号，商户网站订单系统中唯一订单号，必填
                        'out_trade_no'   => $val['pay_sn'],
                        // 请求退款金额，必填
                        'refund_amount'  => $val['actual_pay'],
                        // 'refund_amount' => 0.01,
                        'refund_reason'  => '退款测试',
                        // 退款交易号，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
                        'out_request_no' => $val['order_number'],
                        'is_page'        => false,
                    ];
                    $zhihu  = $this->alipay_wap->refund($a_data);
                    if ($zhihu['code'] == 10000) {
                        // 退款加到退款记录表
                        $this->db->insert('reimburse', ['order_id' => $val['order_id'], 'order_number' => $val['order_number'], 'reimburse' => '第三方处理中', 'time' => $_SERVER['REQUEST_TIME']]);
                        $this->db->insert('order_tracking', $a_track);
                        // 把订单状态改为取消
                        $this->db->update('order', ['order_state' => 0, 'time_finnshed' => $_SERVER['REQUEST_TIME']], ['order_id' => $i_fukuan, 'user_id' => $_SESSION['user_id']]);
                        if ($val['use_jife'] > 0) {
                            // 增加会员积分表
                            $a_jife = [
                                'pl_memberid'    => $val['user_id'],
                                'pl_membername'  => $val['user_name'],
                                'pl_adminid'     => $val['store_id'],
                                'pl_adminname'   => $val['store_name'],
                                'pl_points'      => $val['use_jife'],
                                'pl_time_create' => $_SERVER['REQUEST_TIME'],
                                'pl_status'      => 1,
                                'pl_desc'        => '积分退还！',
                                'pl_stage'       => '订单取消',
                            ];
                            $this->db->insert('points_log', $a_jife);
                        }
                        //增加订单处理历史表
                        $a_log = [
                            'order_id'       => $val['order_id'],
                            'log_msg'        => $a_user['user_name'] . '付款订单取消',
                            'log_time'       => $_SERVER['REQUEST_TIME'],
                            'log_role'       => '系统',
                            'log_user'       => $a_user['user_name'],
                            'log_orderstate' => 0,
                        ];
                        $this->db->insert('order_log', $a_log);
                        // $a_logg = [
                        // 	'order_id' => $i_fukuan,
                        // 	'log_msg'  => '系统退款'.$val['order_price'].'到支付宝成功！',
                        // 	'log_time' => $_SERVER['REQUEST_TIME'],
                        // 	'log_role' => '系统',
                        // 	'log_user' => '系统',
                        // 	'log_orderstate' => 5,
                        // ];
                        // $this->db->insert('order_log', $a_logg);

                        //把返回的金额和积分返回给用户
                        $balance = $a_user['user_balance'] + $val['balance_deduction'];
                        $score   = $a_user['user_score'] + $val['use_jife'];
                        $a_usr   = [
                            'user_score'   => $score,
                            'user_balance' => $balance,
                        ];
                        $this->db->update('user', $a_usr, ['user_id' => $_SESSION['user_id']]);
                        // 增加会员积分表
                        if ($val['use_jife'] > 0) {
                            $a_jife = [
                                'user_id'        => $_SESSION['user_id'],
                                'user_name'      => $_SESSION['user_name'],
                                'pl_type'        => 1,
                                'pl_variation'   => $val['use_jife'],
                                'pl_time'        => $_SERVER['REQUEST_TIME'],
                                'pl_score'       => $score,
                                'pl_description' => $val['order_number'] . '退还积分',
                                'pl_item'        => '退还积分',
                                'pl_code'        => 7,
                            ];
                            $this->db->insert('points_log', $a_jife);
                        }
                        // 用户资金明细表
                        if ($val['balance_deduction'] > 0) {
                            $a_userba = [
                                'ub_type'        => 1,
                                'ub_money'       => $val['balance_deduction'],
                                'ub_balance'     => $balance,
                                'ub_time'        => $_SERVER['REQUEST_TIME'],
                                'ub_item'        => '退还余额',
                                'user_id'        => $val['user_id'],
                                'ub_number'      => $val['order_number'],
                                'ub_description' => $val['order_number'] . '退还余额',
                            ];
                            $this->db->insert('userbalance', $a_userba);
                        }

                    }

                } else if ($val['payment_code'] == 'offline') {// 微信
                    $a_data = [
                        // 商户订单号和微信订单号必须二选一，同时设置时，优先使用微信订单号
                        'out_trade_no'   => $val['pay_sn'],
                        // 微信订单号
                        'transaction_id' => '',
                        // 商户退款单号（自定义的，单号唯一，用来识别退款记录的）
                        'out_refund_no'  => $val['order_number'],
                        // 订单金额，不是退款金额，以分为单位,
                        'total_fee'      => $val['order_price'] * 100,
                        // 'total_fee' => 1,
                        // // 退款金额，以分为单位,
                        'refund_fee'     => $val['actual_pay'] * 100,
                        // 'refund_fee' => 1,
                        // 通知地址，请参考支付实例完成退款的通知处理
                        'notify_url'     => $this->router->url('refund_notify'),

                        'is_page' => false,
                    ];
                    $this->load->library('wxpay_h5', '', [$a_data]);
                    $a_result = $this->wxpay_h5->refund();
                    // print_r($a_result);exit;
                    $this->db->insert('test', ['test_content' => json_encode($a_result), 'order_id' => $val['order_id']]);
                    if ($a_result['return_code'] == 'SUCCESS' && $a_result['return_code'] == 'SUCCESS') {
                        // 退款加到退款记录表
                        $this->db->insert('reimburse', ['order_id' => $val['order_id'], 'order_number' => $val['order_number'], 'reimburse' => '第三方处理中', 'time' => $_SERVER['REQUEST_TIME']]);
                        $this->db->insert('order_tracking', $a_track);
                        // 把订单状态改为取消
                        $this->db->update('order', ['order_state' => 0, 'time_finnshed' => $_SERVER['REQUEST_TIME']], ['order_id' =>
                                                                                                                           $val['order_id']]);
                        //增加订单处理历史表
                        $a_log = [
                            'order_id'       => $val['order_id'],
                            'log_msg'        => $a_user['user_name'] . '付款订单取消',
                            'log_time'       => $_SERVER['REQUEST_TIME'],
                            'log_role'       => '系统',
                            'log_user'       => $_SESSION['user_name'],
                            'log_orderstate' => 0,
                        ];
                        $this->db->insert('order_log', $a_log);
                        // $a_logg = [
                        // 	'order_id' => $i_fukuan,
                        // 	'log_msg'  => '系统退款'.$val['actual_pay'].'到微信成功！',
                        // 	'log_time' => $_SERVER['REQUEST_TIME'],
                        // 	'log_role' => '系统',
                        // 	'log_user' => '系统',
                        // 	'log_orderstate' => 15,
                        // ];
                        // $this->db->insert('order_log', $a_logg);
                        //把返回的金额和积分返回给用户
                        $balance = $a_user['user_balance'] + $val['balance_deduction'];
                        $score   = $a_user['user_score'] + $val['use_jife'];
                        $a_usr   = [
                            'user_score'   => $score,
                            'user_balance' => $balance,
                        ];
                        $this->db->update('user', $a_usr, ['user_id' => $val['user_id']]);
                        // 增加会员积分表
                        if ($val['use_jife'] > 0) {
                            $a_jife = [
                                'user_id'        => $val['user_id'],
                                'user_name'      => $val['user_name'],
                                'pl_type'        => 1,
                                'pl_variation'   => $val['use_jife'],
                                'pl_time'        => $_SERVER['REQUEST_TIME'],
                                'pl_score'       => $score,
                                'pl_description' => $val['order_number'] . '退还积分',
                                'pl_item'        => '退还积分',
                                'pl_code'        => 7,
                            ];
                            $this->db->insert('points_log', $a_jife);
                        }
                        // 用户资金明细表
                        if ($val['balance_deduction'] > 0) {
                            $a_userba = [
                                'ub_type'        => 1,
                                'ub_money'       => $val['balance_deduction'],
                                'ub_balance'     => $balance,
                                'ub_time'        => $_SERVER['REQUEST_TIME'],
                                'ub_item'        => '退还余额',
                                'user_id'        => $val['user_id'],
                                'ub_number'      => $val['order_number'],
                                'ub_description' => $val['order_number'] . '退还余额',
                            ];
                            $this->db->insert('userbalance', $a_userba);
                        }

                    }
                } else if ($val['payment_code'] == 'unionpay') { //银联
                    $this->load->library('unionpay_geteway');
                    $a_param  = [
                        // 订单号
                        'id_order' => $val['order_number'],
                    ];
                    $a_result = $this->unionpay_geteway->query($a_param);
                    if ($this->unionpay_geteway->verify($a_result)) {
                        if ($a_result['origRespCode'] == '00') {
                            $a_param  = [
                                // 订单号
                                'id_order' => $val['order_number'],
                                // 原消费的queryId，可以从查询接口或者通知接口中获取
                                'id_query' => $a_result['queryId'],
                                // （选填）交易金额，退货总金额需要小于或等于原消费
                                'amount'   => $val['actual_pay'],
                            ];
                            $a_result = $this->unionpay_geteway->refund($a_param);
                            // 退款加到退款记录表
                            $this->db->insert('reimburse', ['order_id' => $val['order_id'], 'order_number' => $val['order_number'], 'reimburse' => '第三方处理中', 'time' => $_SERVER['REQUEST_TIME']]);
                            if ($this->unionpay_geteway->verify($a_result)) {
                                if ($a_result['respCode'] == '00') {
                                    $this->db->insert('order_tracking', $a_track);
                                    // 把订单状态改为取消
                                    $this->db->update('order', ['order_state' => 0], ['order_id' => $val['order_id']]);
                                    //把返回的金额和积分返回给用户
                                    $balance = $a_user['user_balance'] + $val['balance_deduction'];
                                    $score   = $a_user['user_score'] + $val['use_jife'];
                                    $a_usr   = [
                                        'user_score'   => $score,
                                        'user_balance' => $balance,
                                    ];
                                    $this->db->update('user', $a_usr, ['user_id' => $val['user_id']]);
                                    // 增加会员积分表
                                    if ($val['use_jife'] > 0) {
                                        $a_jife = [
                                            'user_id'        => $val['user_id'],
                                            'user_name'      => $val['user_name'],
                                            'pl_type'        => 1,
                                            'pl_variation'   => $val['use_jife'],
                                            'pl_time'        => $_SERVER['REQUEST_TIME'],
                                            'pl_score'       => $score,
                                            'pl_description' => $val['order_number'] . '退还积分',
                                            'pl_item'        => '退还积分',
                                            'pl_code'        => 7,
                                        ];
                                        $this->db->insert('points_log', $a_jife);
                                    }
                                    // 用户资金明细表
                                    if ($val['balance_deduction'] > 0) {
                                        $a_userba = [
                                            'ub_type'        => 1,
                                            'ub_money'       => $val['balance_deduction'],
                                            'ub_balance'     => $balance,
                                            'ub_time'        => $_SERVER['REQUEST_TIME'],
                                            'ub_item'        => '退还余额',
                                            'user_id'        => $val['user_id'],
                                            'ub_number'      => $val['order_number'],
                                            'ub_description' => $val['order_number'] . '退还余额',
                                        ];
                                        $this->db->insert('userbalance', $a_userba);
                                    }
                                    $cho = $cho ?? '';
                                    //增加订单处理历史表
                                    $a_log = [
                                        'order_id'       => $val['order_id'],
                                        'log_msg'        => $a_user['user_name'] . $cho . '付款订单取消',
                                        'log_time'       => $_SERVER['REQUEST_TIME'],
                                        'log_role'       => '系统',
                                        'log_user'       => $a_user['user_name'],
                                        'log_orderstate' => 0,
                                    ];
                                    $this->db->insert('order_log', $a_log);

                                    die;
                                }
                            }
                        }
                    }
                }

            }
        }

    }

    /**
     * [system_sure_order 处理超时订单(分为未付款和已付款)]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function system_sure_book_order()
    {
        //已付款而超过了订单服务时间没确认状态的，系统自动确认
        $a_where = ['appointment_state' => 3, 'appointment_type' => 1, 'end_time <' => strtotime(' -10 minute')];
        $a_data  = $this->db->get('appointment', $a_where, '', '', 0, 9999999999);
        if (!empty($a_data) && is_array($a_data)) {
            foreach ($a_data as $key => $val) {

                $a_ensure = $this->db->update('appointment', ['appointment_state' => 4, 'complete_msg' => '超过了订单服务时间，系统自动确认状态', 'officeseat_state' => 0], ['appointment_id' => $val['appointment_id']]);
            }
        }
        //已付款而超过了订单预约时间没确认状态的，系统自动确认取消
        unset($a_where);
        unset($a_data);
        $a_where = ['appointment_state' => 1, 'appointment_type' => 1, 'begin_time <' => time()];
        $a_data  = $this->db->get('appointment', $a_where, '', '', 0, 9999999999);
        if (!empty($a_data) && is_array($a_data)) {
            foreach ($a_data as $key => $val) {
                $res = $this->db->update('appointment', ['appointment_state' => 6, 'officeseat_state' => 0, 'cancel_reason' => '超过了订单服务时间，系统自动取消', 'who_cancel' => 2, 'cancel_time' => time()], ['appointment_id' => $val['appointment_id']]);
                if ($res) {
                    $isrefund = false;
                    // 判断支付方式
                    if ($val['pay_type'] == 1) {
                        $this->load->library('alipay_wap');
                        $a_datas = [
                            // 商户订单号，商户网站订单系统中唯一订单号，必填
                            'out_trade_no'   => $val['appointment_number'],
                            // 请求退款金额，必填
                            'refund_amount'  => $val['actual_pay'],
                            'refund_reason'  => '订单退款',
                            // 退款交易号，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
                            'out_request_no' => 'tk' . date('YmdHis', time()),
                            'is_page'        => false,
                        ];
                        $result  = $this->alipay_wap->refund($a_datas);
                        if ($result['code'] == 10000) {
                            $isrefund = true;
                        }
                    } else if ($val['pay_type'] == 2) {
                        $a_datas = [
                            // 商户订单号和微信订单号必须二选一，同时设置时，优先使用微信订单号
                            'out_trade_no'   => $val['appointment_number'],
                            // 微信订单号
                            'transaction_id' => '',
                            // 商户退款单号（自定义的，单号唯一，用来识别退款记录的）
                            'out_refund_no'  => 'tk' . date('YmdHis', time()),
                            // 订单金额，不是退款金额，以分为单位,
                            'total_fee'      => $val['actual_pay'] * 100,
                            // 退款金额，以分为单位,
                            'refund_fee'     => $val['actual_pay'] * 100,
                            // 通知地址，请参考支付实例完成退款的通知处理
                            'notify_url'     => $this->router->url('wxrefund_notify'),
                        ];
                        $this->load->library('wxpay_h5', '', [$a_datas]);
                        $a_result = $this->wxpay_h5->refund();
                        if ($a_result['return_code'] == 'SUCCESS') {
                            $isrefund = true;
                        }
                    } else if ($val['pay_type'] == 3) {
                        $this->load->library('unionpay_geteway');
                        $a_param  = [
                            // 订单号
                            'id_order' => $val['appointment_number'],
                        ];
                        $a_result = $this->unionpay_geteway->query($a_param);
                        if ($this->unionpay_geteway->verify($a_result)) {
                            if ($a_result['origRespCode'] == '00') {
                                $a_param  = [
                                    // 订单号
                                    'id_order' => 'T' . $val['appointment_number'],
                                    // 原消费的queryId，可以从查询接口或者通知接口中获取
                                    'id_query' => $a_result['queryId'],
                                    // （选填）交易金额，退货总金额需要小于或等于原消费
                                    'amount'   => $val['actual_pay'] * 100,
                                    // （选填）后台返回链接， 不传此参数将默认使用配置文件中的设置url
                                    'url_back' => $this->router->url('unionpay_refund_notify'),
                                ];
                                $a_result = $this->unionpay_geteway->refund($a_param);
                                if ($this->unionpay_geteway->verify($a_result)) {
                                    if ($a_result['respCode'] == '00') {
                                        $isrefund = true;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

    }

    /**
     * 更新月结统计表
     * @param number $type = array(
     *      '1' => 'group_chat_total',
     *      '2' => 'chat_total',
     *      '3' => 'del_chat_total',
     *      '4' => 'del_group_chat_total',
     *      '5' => 'fans_total',
     *      '6' => 'del_fans_total',
     * )
     *
     */
    public function update_accounttbl($store_id, $order_price = 0.00, $month_score = 0.00, $product_count = 0, $account_date)
    {

        //订单统计

        $num           = 1;
        $account_date  = $account_date ? $account_date : date('Ym');
        $month_score   = $month_score ? $month_score : 0;
        $update_fields = "order_count=order_count+$num,product_count =product_count+$product_count, money_count=money_count+$order_price ,month_score = month_score +$month_score";
        $sql           = "INSERT INTO '.$this->db->get_prefix().'accounttbl(store_id,account_date,order_count,money_count,month_score,product_count)
                VALUES ('{$store_id}','{$account_date}',{$num},{$order_price},{$month_score},{$product_count})
                ON DUPLICATE KEY UPDATE {$update_fields}";
        $this->db->query($sql);
    }

}