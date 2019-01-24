<?php
/**
 * 订单控制器
 * @version 2.0-release
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

use model\dao\StaffDAO;
use model\OrderModel;
use model\ToolModel;
use utils\Factory;

class Order_ctrl extends \utils\BaseController
{
    public $start_day;

    public $_ignore_node = [
        'pay',
        'pay_return',
        'retPayReturn',
        'queryOrder'
    ];

    protected $repository = \repositories\OrderRepository::class;

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $data = [
            'insert' => [
                // 'role_name' =>  $this->request->post('role_name', '', 'trim')
            ],
            'update' => [
                // 'role_name' =>  $this->request->post('role_name', '', 'trim'),
            ]
        ];

        return $data[$method] ?? [];
    }

    /**
     * @param $method
     * @return array
     */
    public function valid($method): array
    {
        $valid = [
            'insert' => [
                // 'role_name' =>  'required'
            ],
            'update' => [
                // 'role_name' =>  'required'
            ]
        ];

        return $valid[$method] ?? [];
    }

    /**
     * @remark 发起订单支付
     * @RequestMapping('/order.pay')
     * @throws Exception
     */
    public function pay()
    {
        $data['order_sn']    = $this->request->get('order_sn', '', 'trim');
        $data['order_sign']  = $this->request->get('order_sign', '', 'trim');
        $data['success_url'] = $this->request->get('success_url', $_SERVER['HTTP_REFERER'] ?? '', 'trim'); // 支付成功转跳
        $data['error_url']   = $this->request->get('error_url', $_SERVER['HTTP_REFERER'] ?? '', 'trim'); // 支付失败转跳

        // 对URL执行URL编码
        $data['success_url'] = urlencode($data['success_url']);
        $data['error_url']   = urlencode($data['error_url']);

        $this->validate($data, [
            'order_sn'   => 'required',
            'order_sign' => 'required'
        ]);

        /** @var \model\OrderModel $order_model */
        $order_model = \utils\Factory::getFactory('order');
        return $order_model->payOrder(...array_values($data));
    }

    /**
     * @remark 异步处理支付结果
     * @RequestMapping('/order.pay.ret')
     * @throws Exception
     */
    public function retPayReturn(): void
    {
        $pay_type = $this->router->get(1);

        /** @var \model\OrderModel $order_model */
        $order_model = \utils\Factory::getFactory('order');

        // 订单是全抵扣订单
        if ($pay_type == \model\PayModel::DEDCUTIBLE) {
            $data['out_trade_no'] = $this->request->get('out_trade_no', '', 'trim');
            $order_info           = $this->db->get_row(get_table('order'), ['order_sn' => $data['out_trade_no']]);
            $order_pay_info       = $this->db->get_row(get_table('order_pay_info'), ['order_sn' => $data['out_trade_no']]);
            if ($order_info['order_deductible_type'] != 0 && $order_info['order_actual_amount'] == 0) {
                $order_model->orderCallBack($data['out_trade_no']);
                header('location:' . urldecode($order_pay_info['success_url']));
            }
        } else {
            $out_trade_no = false;
            try {
                $this->db->begin();
                $this->db->set_error_mode();

                if ($pay_type == \model\PayModel::WECHAT) {
                    $php_input_steam_xml = file_get_contents('php://input');
                    $jsonxml             = json_encode(simplexml_load_string($php_input_steam_xml, 'SimpleXMLElement', LIBXML_NOCDATA));
                    $result              = json_decode($jsonxml, true);
                    $out_trade_no        = $result['out_trade_no'] ?? false;

                    $this->db->update(get_table('order_pay_info'), [
                        'json_pay_result' => ToolModel::XML2Json($php_input_steam_xml)
                    ], ['order_sn' => $out_trade_no]);

                    if (is_weixin()) {
                        $this->load->library('wxpay_pub_notify'); // 微信公众号打开，是公众号支付
                        $this->wxpay_pub_notify->Handle(true);
                        if ($result = $this->wxpay_pub_notify->get_verify_result()) {
                            $order_model->orderCallBack($out_trade_no);
                        } else {
                            throw new RuntimeException('验证数据失败');
                        }
                    } else {
                        $this->load->library('wxpay_h5');
                        $data = $this->wxpay_h5->xml_to_array($php_input_steam_xml);
                        if ($this->wxpay_h5->check($data, 'PAY')) {
                            $order_model->orderCallBack($result['out_trade_no']);
                            echo $this->wxpay_h5->success();
                        }
                    }
                } elseif ($pay_type === \model\PayModel::ALIPAY) {
                    if ($out_trade_no) {
                        $this->db->update(get_table('order_pay_info'), [
                            'json_pay_result' => json_encode($_POST)
                        ], ['order_sn' => $out_trade_no]);
                    }
                    $out_trade_no = $this->request->post('out_trade_no', '', 'trim');
                    $this->load->library('alipay_wap');
                    if ($this->alipay_wap->verify($_POST, 'notify') && ($_POST['trade_status'] == 'TRADE_SUCCESS' || $_POST['trade_status'] == 'TRADE_FINISHED')) {
                        $order_model->orderCallBack($out_trade_no);
                        echo 'success';
                    }
                } elseif ($pay_type === \model\PayModel::BANKCARD) {
                    $out_trade_no     = $data['out_trade_no'] = $this->request->get('out_trade_no', '', 'trim');
                    $data['trade_no'] = $this->request->get('trade_no', '', 'trim');

                    $this->load->library('unionpay_geteway');
                    $a_param  = [
                        'id_order' => $out_trade_no
                    ];
                    $a_result = $this->unionpay_geteway->query($a_param);
                    if ($this->unionpay_geteway->verify($a_result)) {
                        if ($a_result['origRespCode'] == '00') {
                            $order_model->orderCallBack($data['out_trade_no']);
                        } elseif (in_array($a_result['origRespCode'], ['03', '04', '05'], true)) {
                            throw new RuntimeException('交易处理中');
                        } else {
                            throw new RuntimeException('交易失败');
                        }
                    } else {
                        throw new RuntimeException('验证签名失败');
                    }
                }
                $this->db->commit();
            } catch (Exception $e) {
                $this->db->roll_back(); // 回滚
                $this->db->update(get_table('order_pay_info'), [
                    'json_pay_result' => $e->getMessage(),
                ], ['order_sn' => $out_trade_no]);
                $this->db->update(get_table('order'), [
                    'order_state'         => 0,
                    'order_pay_state_dsc' => 'PENDING_PAY'
                ], ['order_sn' => $out_trade_no]);
            }
        }
    }

    /**
     * @remark 根据交易流水号获取订单信息
     * @RequestMapping('/order.getby.sn-{order_sn}')
     * @RequestMapping('/order.get-{order_sn}')
     */
    public function getOne()
    {
        $order_sn      = $this->router->get(1); // 交易流水号
        $get_appointed = $this->request->post('get_appointed', 0, 'intval');
        $this->validate(compact('order_sn'), [
            'order_sn' => 'required|length:23'
        ]);
        $order_info = $this->db->get_row(get_table('order'), ['order_sn' => $order_sn]);
        if (!$order_info) {
            return $this->error('订单流水号无记录');
        }
        switch ((int)$order_info['order_type']) {
            case 1:
                $entity_table = get_table('service');
                break;
            case 2:
                $entity_table = get_table('demand');
                break;
            case 3:
                $entity_table = get_table('recharge');
                break;
            case 4:
                $entity_table = get_table('subscribe');
                break;
            default:
                $entity_table = false;
        }
        if (false === $entity_table) {
            return $this->error('订单参数不合法');
        }
        $fields     = [
            get_table('service')   => [
                'id',
                'store_id',
                'service_name as subject_name',
                'service_info as subject_info',
                'service_img as subject_img',
                'service_remuneration as subject_money',
                'service_lal as lal'
            ],
            get_table('demand')    => [
                'id',
                'subject_title as subject_name',
                'demand_info as subject_info',
                'demand_service_at as subject_date_time',
                'demand_img as subject_img',
                'demand_lal as lal'
            ],
            get_table('subscribe') => [
                '*'
            ],
            get_table('recharge')  => [
                '*'
            ]
        ];
        $entity_row = $this->db->select($fields[$entity_table], false)
            ->get_row($entity_table, ['id' => $order_info['order_type_id']]);
        if (!$entity_row) {
            $entity_row = $this->db->get_row(get_table('order_info'), ['order_sn' => $order_sn], 'order_info');
            $entity_row = json_decode($entity_row['order_info'], true);
        }
        $store                    = $this->db->get_row(get_table('store'),
            ['id' => $order_info['order_belong_store_id']]
        );
        $entity_row['store_name'] = $store['store_name'];
        $entity_row['store_id']   = $store['id'];
        /** @var \model\OrderModel $order_model */
        $order_model = \utils\Factory::getFactory('order');
        $order_info  = $order_model->formatOrderRow($order_info, $get_appointed);
        isset($entity_row['subject_info']) && $entity_row['subject_info'] = str_replace(['&amp;', '&quot;', '&#039;', '&lt;', '&gt;'], ['&', '"', "'", '<', '>'], $entity_row['subject_info']);
        if ($entity_table == get_table('demand') && isset($entity_row['subject_date_time'])) {
            $entity_row['subject_date_time'] = date('Y-m-d H:i:s', $entity_row['subject_date_time']); // 转换时间格式
        }
        if (isset($entity_row['lal'])) {
            list($lng, $lat) = explode(',', $entity_row['lal']);
            $entity_row['lat'] = trim($lat);
            $entity_row['lng'] = trim($lng);
        }
        unset($order_info['order_belong_store_id']);
        $row = [
            'order_info' => $order_info,
            'entity_row' => filter($entity_row),
            'store_info' => filter($store)
        ];
        if (isset($row['entity_row']['subject_img']) && $row['entity_row']['subject_img']) {
            $row['entity_row']['subject_img'] = explode(',', $row['entity_row']['subject_img']);
        }
        $store['store_pic'] && $row['store_info']['store_pic'] = explode(',', $store['store_pic']);
        return $this->success($row);
    }

    /**
     * 统计列表各种状态下的条目
     * @router http://server.name/order.list.count
     */
    public function countList()
    {
        $map = [
            'pending_payment' => 0, // 待付款
            'in_service'      => 3, // 服务中
            'closed'          => 4 // 已关闭
        ];

        $rows = $sql = [];
        list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();
        foreach ($map as $key => $status) {
            $rows[$key] = $this->db->get_total(get_table('order'), array_merge($condition, ['order_state' => $status]));
            $sql[$key]  = $this->db->get_sql();
        }
        $rows['all'] = $this->db->get_total(get_table('order'), ['order_type <>' => 3]);
        // 待接单
        $rows['pending_ordering'] = $this->db->get_total(get_table('order'), [
                'order_type <>'         => 3,
                'order_state'           => 1,
                'order_belong_store_id' => 0
            ]
        );
        // 已完成
        $rows['completed'] = $this->db->get_total(get_table('order'), [
            'order_type <>' => 3,
            'order_rate'    => 1
        ]);

        return success($rows, 5, $sql);
    }

    /**
     * @remark 普通用户通过流水号删除订单，软删除
     * @RequestMapping('/order.delete-{order_sn}')
     */
    public function delete()
    {
        $order_sn     = $this->router->get(1);
        $order_sub_sn = (int)$this->router->get(2);
        $this->validate(compact('order_sn'), [
            'order_sn' => 'required|length:23'
        ]);
        /** @var \model\OrderModel $order_model */
        $order_model = \utils\Factory::getFactory('order');
        $user_info   = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }
        // 判断订单流水号是否存在 && 判断订单是否属于当前用户
        if ($order_info = $order_model->checkSnHas($order_sn, $order_sub_sn)) {
            $source = app('router')->get(2);
            if ('store' === $source) {
                $store_info = $this->db->get_row(get_table('store'), ['user_id' => $user_info->user_id]);
                if ($order_info['order_belong_store_id'] != $store_info['id']) {
                    return $this->error('该订单不属于当前店铺');
                }
            } elseif (false == $source) {
                if ($order_info['user_id'] != $user_info->user_id) {
                    return $this->error('该订单不属于当前用户');
                }
            }
            if ($order_info['order_state'] == 4 || $order_info['order_state'] == 5 ||
                $order_info['order_pay_state_dsc'] == 'REFUNDED' || $order_info['order_bis_state_dsc'] == 'CLOSED' || $order_info['order_bis_state_dsc'] == 'COMPLETED') {
                try {
                    $this->db->begin();
                    // 执行删除
                    $this->db->update(get_table('order'), ['order_user_del' => 1], compact('order_sn')); // 标记用户删除订单
                    $this->db->insert(get_table('order_log'), [
                        'order_sn' => $order_sn,
                        'log_at'   => $_SERVER['REQUEST_TIME'],
                        'log'      => '订单已被用户删除，解除与用户的关系，原属用户id:' . $order_info['user_id'],
                        'uid'      => app('user_info')->user_id
                    ]);
                    $this->db->commit();
                    return $this->success(false);
                } catch (Exception $e) {
                    $this->db->roll_back();
                }
            }
        }
        return $this->error('订单删除失败');
    }

    /**
     * 验证字段定义
     * @return array
     */
    public function setField(): array
    {
        return [
            'start_time' => '周期订单开始时间',
            'cycle_long' => '周期订单持续周数'
        ];
    }

    /**
     * 获取订单签名
     * @router http://server.name/order.sign.get
     */
    public function getSign()
    {
        $order_sn = $this->router->get(1);
        if (!$order_sn) {
            return $this->error('流水号不存在');
        }
        $order_info = $this->db->get_row(get_table('order'), ['order_sn' => $order_sn]);
        if (!$order_info) {
            return $this->error('流水号对应的订单不存在');
        }
        return $this->success([
            'order_sign' => md5(implode('-', [$order_sn, $order_info['order_type'], $order_info['order_type_id']]))
        ]);
    }

    /**
     * 订单补费
     * @RequestMapping('/order.subsidy')
     */
    public function subsidyOrder()
    {

        $data['order_sn']     = $this->request->post('order_sn', '', 'trim');
        $data['order_amount'] = $this->request->post('order_amount', 0, 'floatval');
        $this->validate($data, [
            'order_sn' => 'required'
        ]);

        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);
        if (!$staff_row) {
            return $this->error('只有服务方才有权操作');
        }

        $order_info = $this->db->get_row(get_table('order'), ['order_sn' => $data['order_sn']]);
        if (!$order_info) {
            return $this->error('订单不存在');
        }

        if ($staff_row['store_id'] != $order_info['order_belong_store_id']) {
            return $this->error('订单不属于您的店铺');
        }

        $order_info                        = filter($order_info);
        $order_info['order_pay_state_dsc'] = 'PENDING_PAY';
        $order_info['order_bis_state_dsc'] = 'SET_UP';
        $order_info['order_sn']            = '';

        $order_added_sn_id = $this->db->insert(get_table('order'), $order_info);

        $micro          = sprintf('%.0f', microtime(true));
        $order_added_sn = $micro . str_pad($order_added_sn_id, 13, '0', STR_PAD_LEFT); // 订单流水号
        $this->db->update(get_table('order'), ['order_sn' => $order_added_sn], ['id' => $order_added_sn_id]); // 写入流水号
        $this->db->update(get_table('order'), compact('order_added_sn'), ['order_sn' => $data['order_sn']]); // 写入补费订单

        return $this->success(false);
    }

    /**
     * @param $method
     * @return mixed|string
     */
    public function getMethodRouterParams($method)
    {
        $router_params = explode('-', $this->router->get_parse_url()['path']);
        $params        = [
            'changeOrderStatus' => function () use ($router_params) {
                return $router_params[1];
            }
        ];
        return $params[$method] ?? '';
    }

    /**
     * @remark 订单费用小计
     * @RequestMapping('/order.charge.calc')
     */
    public function calcOrders()
    {
        $data['orders']     = $this->request->post('order/a', [], 'trim');
        $data['start_time'] = $this->request->post('startTime', '', 'trim');
        $data['cycle_long'] = $this->request->post('cycleLong', 1, 'intval'); // 周期数
        $this->validate($data, [
            'start_time' => 'required',
            'cycle_long' => 'required'
        ]);
        $data['start_time'] = ToolModel::strtotime($data['start_time']);
        /** @var OrderModel $order_model */
        $order_model = Factory::getFactory('order');
        $all_orders  = $order_model->sortOrder($data['orders'], $data['start_time'], $data['cycle_long']);
        unset($data['orders']);
        $calc = [
            'orders'      => [],
            'total_price' => 0
        ];
        foreach ($all_orders as $order) {
            $order['charge']     = sprintf('%.2f', $order['charge'] / 100);
            $calc['orders'][]    = $order;
            $calc['total_price'] += $order['charge'];
        }
        unset($all_orders);
        return $this->success($calc);
    }

    /**
     * @remark 服务周期下单
     * @RequestMapping('/service.cyc.orders-{$service_id}')
     */
    public function cycOrders()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }
        $service_id = $this->router->get(1) ?: $this->request->post('service_id', 0, 'intval');
        if ($service_id && !$service = $this->db->get_row(get_table('service'), ['id' => $service_id])) {
            return $this->error('要下单的服务已不存在');
        }
        $subscribe_id                  = (int)$this->router->get(1);
        $data['orders']                = $this->request->post('orders/a', [], 'trim');
        $data['start_time']            = $this->request->post('startTime', '', 'trim');
        $data['cycle_long']            = $this->request->post('cycleLong', 1, 'intval'); // 周期数
        $data['order_lal']             = $this->request->post('order_lal', '', 'trim');
        $data['contact_name']          = $this->request->post('contact_name', '', 'trim');
        $data['address_name']          = $this->request->post('address_name', '', 'trim');
        $data['house_number']          = $this->request->post('house_number', '', 'trim');
        $data['telephone']             = $this->request->post('order_phone', '', 'trim');
        $data['order_message']         = $this->request->post('service_message', '', 'trim'); // 下单留言
        $data['order_deductible_type'] = $this->request->post('order_deductible_type', 0, 'intval'); // 订单抵扣方式 1：余额 2：积分 0：无抵扣
        $data['order_pay_way']         = $this->request->post('service_price_type', '', 'trim'); // 支付订单的方式，alipay：支付宝 wechat: 微信 bankcard：银行卡
        $data['order_package_type']    = $this->request->post('order_package_type', 'fixed_price', 'trim');
        $data['house_number']          = $data['house_number'] ?: '无门牌号';
        $data['order_sn']              = $this->request->post('order_sn', '', 'trim');

        $this->validate($data, [
            'lal_info'      => 'required',
            'address_name'  => 'required',
            'contact_name'  => 'required',
            'telephone'     => 'required|phone',
            'order_pay_way' => 'required',
            'start_time'    => 'required',
            'cycle_long'    => 'required'
        ]);

        $data['start_time'] = ToolModel::strtotime($data['start_time']);
        /** @var OrderModel $order_model */
        $order_model = Factory::getFactory('order');
        $all_orders  = $order_model->sortOrder($data['orders'], $data['start_time'], $data['cycle_long']);
        unset($data['orders']);
        // 写入订单

        // 判断是否经纬度
        if (!preg_match('/^.*,.*$/', $data['order_lal'])) {
            return $this->error('经纬度格式不正确');
        }

        list($lng, $lat) = explode(',', $data['order_lal']);
        $data['order_lng'] = $lng;
        $data['order_lat'] = $lat;

        // 判断支付方式是否支持
        if (!\in_array($data['order_pay_way'], ['alipay', 'wechat', 'bankcard'])) {
            return $this->error('支付方式不支持');
        }
        $insert_orders       = [];
        $order_actual_amount = 0;
        foreach ($all_orders as $order) {
            $order_actual_amount += $order['charge']; // 累计订单总金额
        }

        $this->db->begin();
        try {
            $order_update = [
                'order_belong_store_id' => $service['store_id'],
                'order_message'         => $data['order_message'],
                'order_lat'             => $data['order_lat'],
                'order_lng'             => $data['order_lng'],
                'is_sys_order'          => 1 // 周期性订单标记
            ];
            if ($data['order_sn']) {
                $order_update = array_merge($order_update, [
                    'telephone'             => $data['telephone'],
                    'address_name'          => $data['address_name'],
                    'house_number'          => $data['house_number'],
                    'contact_name'          => $data['contact_name'],
                    'order_deductible_type' => 0,
                    'order_type'            => 1,
                    'order_type_id'         => $service_id,
                    'order_pay_way'         => 'wechat',
                    'order_actual_amount'   => $data['order_actual_amount']
                ]);
                $this->db->update(get_table('subscribe'), [
                    'subscribe_state' => 'GENERATED_ORDER'
                ], ['id' => $subscribe_id]);
                $order_info = false;
            } else {
                /** @var OrderModel $order_model */
                $order_model      = Factory::getFactory('order');
                $order_info       = $order_model->setContact(
                    $data['telephone'],
                    $data['address_name'],
                    $data['house_number'],
                    $data['contact_name']
                )->coumpteDeductible(
                    $data['order_deductible_type']
                )->unifiedOrder(
                    OrderModel::ORDER_USER_BUY_SERVER,
                    $service_id,
                    $data['order_pay_way'],
                    $order_actual_amount
                );
                $data['order_sn'] = $order_info['order_sn'];
            }

            $this->db->update(get_table('order'), $order_update, ['order_sn' => $data['order_sn']]);
//            $order_deductible_average = $order_info['order_deductible_count'] ? $order_info['order_deductible_count'] / count($all_orders) : 0;
            $index = 0;
            foreach ($all_orders as $order) {
                $insert_orders[] = [
                    'order_type'             => 1,
                    'order_name'             => $service['service_name'],
                    'order_sn'               => $data['order_sn'],
                    'user_id'                => $user_info->user_id,
                    'order_pay_way'          => $data['order_pay_way'],
                    'order_type_id'          => $service_id,
                    'order_amount'           => $order['charge'],
                    'order_actual_amount'    => $order['charge'],
                    'add_time'               => $_SERVER['REQUEST_TIME'],
                    'house_number'           => $data['house_number'],
                    'contact_name'           => $data['contact_name'],
                    'order_belong_store_id'  => $service['store_id'],
                    'order_deductible_type'  => $data['order_deductible_type'],
                    'order_deductible_count' => 0,
                    'order_info'             => $service['service_info'],
                    'order_message'          => $data['order_message'],
                    'service_length'         => $order['order_length'],
                    'contact_appointment_at' => $order['order_at'],
                    'order_lat'              => $data['order_lat'],
                    'order_lng'              => $data['order_lng'],
                    'order_sub_sn'           => ++$index
                ];
            }
            $this->db->inserts(get_table('order'), $insert_orders);
            $this->db->commit();
            return $this->success($order_info);
        } catch (Exception $e) {
            $this->db->roll_back();
            return $this->error('下单失败' . (APP_DEBUG ? $e->getMessage() : ''));
        }
    }

    /**
     * @remark 通过订单获取评论
     * @RequestMapping('/order.get.comment')
     */
    public function getComment()
    {
        $data['order_sn'] = $this->router->get(1);

        $this->validate($data, [
            'order_sn' => 'required',
        ]);

        $comment_info = $this->cache('order.comment.' . $data['order_sn']);
        if (!$comment_info) {
            $comment_info = $this->db->get_row(get_table('comment'), ['comment_order_sn' => $data['order_sn']]);
            $comment_info = filter($comment_info);
            $this->cache('order.comment.' . $data['order_sn'], $comment_info, 1800);
        }

        return $this->success($comment_info);
    }

    /**
     * @remark 订单查记录
     * @RequestMapping('/order.get.actions')
     */
    public function getActions()
    {
        $data['order_sn'] = $this->router->get(1);

        $this->validate($data, [
            'order_sn' => 'required',
        ]);

        $count   = $this->db->get_total(get_table('order_log'), $data);
        $actions = $this->db->order_by(['log_at' => 'desc'])->limit(0, $count)->get(get_table('order_log'), $data);

        foreach ($actions as &$action) {
            $action['log_at'] = date('Y-m-d H:i:s', $action['log_at']);
        }

        return $this->success($actions);
    }

    /**
     * 通过流水号取消订单
     * 如果是店铺管理员以上拒绝，直接退款给用户
     * 如果是服务员操作，则指派给下一个服务员
     * @RequestMapping('/order.cancel-{order_sn}')
     */
    public function cancelOrder()
    {
        $order_sn              = $this->router->get(1);
        $order_sub_sn          = (int)$this->router->get(2);
        $data['cancel_reason'] = $this->request->post('cancel_reason', '', 'trim');
        if (mb_strlen($data['cancel_reason']) > 150) {
            return $this->error('取消订单原因过长');
        }
        $this->validate(compact('order_sn'), [
            'order_sn' => 'required|length:23'
        ]);

        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        /** @var \model\OrderModel $order_model */
        $order_model = \utils\Factory::getFactory('order');
        // 判断订单流水号是否存在 && 判断订单是否属于当前用户
        if ($order_info = $order_model->checkSnHas($order_sn, $order_sub_sn)) {
            if ($order_info['user_id'] != $user_info->user_id) {
                $user_info = $order_model->checkOrderBelongUser($order_sn);
            }
        }

        if ($order_info['order_pay_state_dsc'] == 'PAY_SUCCESS') {
            return $this->error('订单支付状态不允许取消');
        }

        if (!in_array($order_info['order_bis_state_dsc'], ['SET_UP', 'PENDING_ORDER', 'PENDING_ASSIGN'], false)) {
            return $this->error('订单当前状态不允许取消');
        }
        $this->db->begin();
        $this->db->set_error_mode();
        $staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id], 'user_type, user_type_key');
        if (($staff_row['user_type'] == 1 || $staff_row['user_type_key'] == 'SERVER') && $order_info['user_id'] != $user_info->user_id) {
            try {
                // +--------------------------------------------------------------------------------------
                // | 新的取消流程，指派给下一个有空的店员，如无有空店员或连续三次取消则停止
                // +--------------------------------------------------------------------------------------
                $order_model->rejecteOrder($order_sn, $data['cancel_reason'], $user_info->user_id, $order_sub_sn);
                $this->db->commit();
                return $this->success(false);
            } catch (Exception $e) {
                $this->db->roll_back();
                return $this->error('取消订单失败' . $e->getMessage());
            }
        } else {
            try {
                // 管理员取消订单，直接取消
                $this->db->update(get_table('order'), [
                    'order_bis_state_dsc' => 'CLOSED',
                    'order_state'         => 5,
                    'order_rate'          => -1,
                    'cancel_reason'       => $data['cancel_reason']
                ], compact('order_sn', 'order_sub_sn'));
                $order_model->orderRefund($order_sn, true, $order_sub_sn);
                $this->db->insert(get_table('order_log'), [
                    'order_sn'     => $order_sn,
                    'order_sub_sn' => $order_sub_sn,
                    'log_at'       => $_SERVER['REQUEST_TIME'],
                    'log'          => '订单以取消',
                    'uid'          => $user_info->user_id
                ]);
                if ($order_info['appointed_uid']) {
                    $this->db->update(get_table('order'), ['appointed_uid' => null], compact('order_sn', 'order_sub_sn'));
                    $this->db->delete(get_table('order_appointed'), array_merge(compact('order_sn'), ['order_sub_id' => $order_sub_sn]));
                    $appointed_uid = explode('-', $order_info['appointed_uid']);
                    if ($appointed_uid && $appointed_uid[0]) {
                        foreach ($appointed_uid as $uid) {
                            $this->db->update(get_table('store_user'), [
                                'staff_current_order_sn'     => '',
                                'staff_current_order_sub_id' => 0
                            ], ['user_id' => $uid]);
                        }
                    }
                }
                $this->db->commit();
                return $this->success(false);
            } catch (Exception $e) {
                $this->db->roll_back();
                return $this->error('订单取消失败,原因：' . $e->getMessage());
            }
        }
    }

    public function _weekMap($timestamp)
    {
        $map = [
            0 => '星期日',
            1 => '星期一',
            2 => '星期二',
            3 => '星期三',
            4 => '星期四',
            5 => '星期五',
            6 => '星期六',
        ];

        return $map[date('w', $timestamp)];
    }

    /**
     * @remark 获取周期下单的日期选择框数据
     * @RequestMapping('/service.get.ordercycle')
     */
    public function getOrderOrderCycle()
    {
        $service_id = $this->request->post('service_id', 0, 'intval');
        if (!$service_id) {
            return $this->error('请选中服务或者服务项目');
        }
        $service_info = $this->db->get_row(get_table('service'), ['id' => $service_id]);
        if (!$service_info) {
            return $this->error('下单的服务不存在');
        }

        $service_week   = $this->request->post('service_week', 1, 'intval'); // 下单的是星期中的第几天
        $service_length = $this->request->post('service_length', 2.0, 'floatval'); // 下单时长
        if ($service_length < 2 || $service_length > 6) {
            return $this->error('下单时间在2~6小时之间');
        }
        if ($service_length * 10 % 5) {
            return $this->error('下单时间的步进为0.5');
        }
        $date_w = date('w');
        if (!$date_w) {
            $date_w = 7;
        }
        static $service_day;
        if ($service_week < $date_w) {
            $days        = 7 + ($service_week - $date_w);
            $service_day = strtotime("+{$days} days 00:00:00");
        } elseif ($service_week > $date_w) {
            $days        = $service_week - $date_w;
            $service_day = strtotime("+{$days} days 00:00:00");
        } else {
            $days        = 7;
            $service_day = strtotime('+7 days 00:00:00');
//            list($service_day, $end) = ToolModel::getTodayBeginAndEnd();
        }
        $starts      = [];
        $service_day += 8 * 3600;

        for ($i = 0; $i < 24; $i++) {
            $i && $service_day += 1800;
            $end_day  = $service_day + $service_length * 3600;
            $starts[] = [
                'start_at'          => $service_day,
                'start_date_format' => date('Y-m-d H:i:s', $service_day),
                'end_at'            => $end_day,
                'end_date_format'   => date('Y-m-d H:i:s', $end_day),
                'display_text'      => date('H:i', $service_day) . '~' . date('H:i', $end_day),
                'week'              => $this->_weekMap($service_day)
            ];
        }

        // 先获取服务的波动设置
        $price_change_rule_total = $this->db->get_total(get_table('service_price_change_rule'), [
            'service_id' => $service_id
        ]);
        $price_change_rules      = $this->db->limit(0, $price_change_rule_total)
            ->get(get_table('service_price_change_rule'), compact('service_id'));

        $_price_change_rules = [];
        foreach ($price_change_rules as $rule) {
            if ($rule['change_type'] == 1) {
                // 周期弹性变动
                $_price_change_rules['alternation'][] = $rule;
            } else {
                // 固定变动
                $_price_change_rules['custom'] = $rule;
            }
        }

        /** @var \model\StoreModel $store_model */
        $store_model = Factory::getFactory('store');
        $max_day     = strtotime("+{$days} days 20:30:00");
        foreach ($starts as $key => &$index) {
            if ($index['end_at'] > $max_day) {
                unset($starts[$key]);
            }
            if ($index['start_at'] <= $_SERVER['REQUEST_TIME']) {
                $next_week_day = $index['start_at'] + 7 * 24 * 3600;
                $next_week_end = $next_week_day + $service_length * 3600;
                $starts[$key]  = [
                    'start_at'          => $next_week_day,
                    'start_date_format' => date('Y-m-d H:i:s', $next_week_day),
                    'end_at'            => $next_week_end,
                    'end_date_format'   => date('Y-m-d H:i:s', $next_week_end),
                    'display_text'      => date('H:i', $next_week_day) . '~' . date('H:i', $next_week_end),
                ];
            }
            $index['charge']    = 0;
            $index['can_order'] = $store_model->getCanAssignStaffByDay($index['start_at'], $service_length, $service_info['store_id']);
            if (isset($_price_change_rules['alternation']) && $_price_change_rules['alternation']) {
                foreach ($_price_change_rules['alternation'] as $change_rule) {
                    $day = date('w', $index['start_at']); // 星期中的第几天，数字表示；0（表示星期天）到 6（表示星期六）
                    !$day || $day = 7;
                    if ($change_rule['choose_date'] == $day
                        && ToolModel::checkIsBetweenTime($change_rule['begin_at'], $change_rule['end_at'], $index['start_at'])) {
                        $index['charge'] = $change_rule['diff_type'] == 'INCR'
                            ? "+ {$change_rule['price_change']}"
                            : "- {$change_rule['price_change']}";
                    }
                }
            }
            if (isset($_price_change_rules['custom']) && $_price_change_rules['custom']) {
                foreach ($_price_change_rules['custom'] as $change_rule) {
                    $order_date = date('Y-m-d', $index['start_at']);
                    if ($change_rule['choose_date'] == $order_date
                        && ToolModel::checkIsBetweenTime($change_rule['begin_at'], $change_rule['end_at'], $index['start_at'])) {
                        $index['charge'] = $change_rule['diff_type'] == 'INCR'
                            ? "+ {$change_rule['price_change']}"
                            : "- {$change_rule['price_change']}";
                    }
                }
            }
        }

        return $this->success($starts);
    }
}
