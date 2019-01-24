<?php

/**
 * 订单控制器
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */
class Order_ctrl extends \utils\BaseController
{
    public $_ignore_node = [
        'pay',
        'pay_return'
    ];

    protected $repository = \repositories\OrderRepository::class;

    /**
     * 发起订单支付
     * @router http://server.name/order.pay
     * @throws Exception
     */
    public function pay()
    {
        $data['order_sn']   = $this->request->get('order_sn', '', 'trim');
        $data['order_sign'] = $this->request->get('order_sign', '', 'trim');

        $this->validate($data, [
            'order_sn'   => 'required',
            'order_sign' => 'required'
        ]);

        /** @var \model\OrderModel $order_model */
        $order_model = \utils\Factory::getFactory('order');
        return $order_model->payOrder(...array_values($data));
    }

    /**
     * 订单支付结果同步返回
     * @router http:://server.name/order.pay.return
     */
    public function pay_return()
    {
        echo '交易处理中，请不要关闭页面...';

        $data['out_trade_no'] = $this->request->get('out_trade_no', '', 'trim');
        $data['trade_no']     = $this->request->get('trade_no', '', 'trim');
        /** @var \model\OrderModel $order_model */
        $order_model = \utils\Factory::getFactory('order');
        try {
            // 如果是微信回调
            if ('wechat' == $this->router->get(1)) {
                // 查询订单
                $a_data = [
                    'out_trade_no' => $data['out_trade_no']
                ];

                $this->load->library('wxpay_h5', '', [$a_data]);
                $result = $this->wxpay_h5->query();
                /** @noinspection TypeUnsafeComparisonInspection PhpUnreachableStatementInspection */
                if ($result['return_code'] == 'SUCCESS' && $result['return_msg'] == 'OK') {
                    $order_model->orderCallBack($data['out_trade_no']);
                } else {
                    throw new RuntimeException($result['return_msg']);
                }
            } elseif ('alipay' == $this->router->get(1)) {
                // 支付宝回调
                $order_model->orderCallBack($data['out_trade_no']);
            } elseif ('bankcard' == $this->router->get(1)) {
                $this->load->library('unionpay_geteway');
                $a_param  = [
                    'id_order' => $data['out_trade_no']
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
            header('Location:http://jiajie-touch.7dugo.com/#/orderDetails?order_sn=' . $data['out_trade_no']);
        } catch (Exception $e) {
            $order_model->rollbackOrder($data['out_trade_no']);
            header('location:http://jiajie-touch.7dugo.com/#/myfb');
        }
    }

    /**
     * 微信异步通知
     */
    public function wxpaynot()
    {
        $s_xml = file_get_contents('php://input');
        // 加载微信支付类
        $this->load->library('wxpay_h5');
        // 把微信返回的通知xml数据转换为数组格式
        $a_data = $this->wxpay_h5->xml_to_array($s_xml);
        // 验证签名成功
        if ($this->wxpay_h5->verify($a_data)) {
            if ($this->wxpay_h5->check($a_data, 'PAY')) {
                var_dump($a_data);
                exit;
            }
        }
    }

    /**
     * 根据交易流水号获取订单信息
     * @router http://server.name/order.getby.sn
     */
    public function getOne()
    {
        $order_sn = $this->router->get(1); // 交易流水号
        $this->validate(compact('order_sn'), [
            'order_sn' => 'required|length:23'
        ]);

        $order_info = $this->db->get_row(get_table('order'), ['order_sn' => $order_sn]);
        if (!$order_info) {
            return $this->error('订单流水号无记录');
        }

        switch ((int)$order_info['order_type']) {
            case 1:
                $entity_table = 'jiajie_service';
                break;
            case 2:
                $entity_table = 'jiajie_demand';
                break;
            case 3:
                $entity_table = 'jiajie_recharge';
                break;
            default:
                $entity_table = false;
        }

        if (false === $entity_table) {
            return $this->error('订单参数不合法');
        }
//        $entity_table = $order_info['order_type'] == 1 ? 'jiajie_service' : 'jiajie_demand';
        $fields     = [
            'jiajie_service'  => [
                'id',
                'store_id',
                'service_name as subject_name',
                'service_info as subject_info',
                'service_img as subject_img',
                'service_remuneration as subject_money'
            ],
            'jiajie_demand'   => [
                'id',
                'subject_title as subject_name',
                'demand_info as subject_info',
                'demand_service_at as subject_date_time',
                'demand_img as subject_img'
            ],
            'jiajie_recharge' => [
                '*'
            ]
        ];
        $entity_row = $this->db->select($fields[$entity_table])->get_row($entity_table, ['id' => $order_info['order_type_id']]);

        if (!$entity_row) {
            return $this->error('订单找不到对应商品');
        }

        $store = $this->db->get_row(get_table('store'), ['id' => $entity_row['store_id']], 'store_name, id, store_pic');
        if ($entity_table === get_table('service')) { // 订单为服务下单时，添加店铺信息
            $entity_row['store_name'] = $store['store_name'];
            $entity_row['store_id']   = $store['id'];
            unset($fields);
        }
        $order_info['order_amount']      = number_format($order_info['order_amount'] / 100, 2, '.', ','); // 格式化金额
        $order_info['add_time']          = date('Y-m-d H:i:s', $order_info['add_time']); // 转换时间格式
        $entity_row['subject_date_time'] = date('Y-m-d H:i:s', $entity_row['subject_date_time']); // 转换时间格式

        unset($order_info['order_belong_store_id']);
        $row = [
            'order_info'   => filter($order_info)
            , 'entity_row' => filter($entity_row)
            , 'store_info' => filter($store)
        ];


        if ($row['entity_row']['subject_img']) {
            $row['entity_row']['subject_img'] = explode(',', $row['entity_row']['subject_img']);
        }
        $row['store_info']['store_pic'] = explode(',', $row['store_info']['store_pic']);
        return $this->success($row);
    }

    /**
     * 通过流水号删除订单
     * @router http://server.name/order.delete-{order_sn}
     */
    public function delete()
    {
        $order_sn = $this->router->get(1);
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
        if ($order_info = $order_model->checkSnHas($order_sn)) {
            $source = app('router')->get(2);
            if ('store' === $source) {
                $store_info = $this->db->get_row('jiajie_store', ['user_id' => $user_info->user_id]);
                /** @noinspection TypeUnsafeComparisonInspection */
                if ($order_info['order_belong_store_id'] != $store_info['id']) {
                    return $this->error('该订单不属于当前店铺');
                }
            } /** @noinspection TypeUnsafeComparisonInspection */ elseif (false == $source) {
                /** @noinspection TypeUnsafeComparisonInspection */
                if ($order_info['user_id'] != $user_info->user_id) {
                    return $this->error('该订单不属于当前用户');
                }
            }
            /** @noinspection TypeUnsafeComparisonInspection */
            if ($order_info['order_state'] == 4 || $order_info['order_state'] == 5) {
                try {
                    $this->db->begin();
                    // 执行删除
                    $result = $this->db->delete('jiajie_order', compact('order_sn'));
                    if ($result) {
                        /** @noinspection TypeUnsafeComparisonInspection */
                        if ($order_info['order_type'] == 2) {
                            $result = $this->db->delete('jiajie_demand', ['order_sn' => $order_sn]);
                        }

                        if ($result) {
                            $this->db->commit();
                            return $this->success(false);
                        }
                    }
                } catch (Exception $e) {
                    $this->db->roll_back();
                }
            }
        }
        return $this->error('订单删除失败');
    }

    /**
     * 取消指定订单,通过流水号
     * @router http://server.name/order.cancel-{order_sn}
     */
    public function cancelOrder()
    {
        $order_sn = $this->router->get(1);
        $this->validate(compact('order_sn'), [
            'order_sn' => 'required|length:23'
        ]);

        /** @var \model\OrderModel $order_model */
        $order_model = \utils\Factory::getFactory('order');
        // 判断订单流水号是否存在 && 判断订单是否属于当前用户
        if (($order_info = $order_model->checkSnHas($order_sn)) && ($user_info = $order_model->checkOrderBelongUser($order_sn))) {
            /** @noinspection TypeUnsafeComparisonInspection */
            if (!in_array((int)$order_info['order_state'], [0, 1, 2], true)) {
                return $this->error('订单当前状态不允许取消');
            }
            try {
                $this->db->begin();
                $this->db->set_error_mode();
                // 执行取消
                /** @noinspection TypeUnsafeComparisonInspection */
                if ($order_info['order_state'] != 0) {
                    $order_model->orderRefund($order_info['order_sn']);
                }
                $result = $this->db->update('jiajie_order', [
                    'order_state' => 4
                ], compact('order_sn'));
                if ($result) {
                    $this->db->commit();
                    return $this->success(false);
                }
                throw new RuntimeException('取消订单失败');
            } catch (Exception $e) {
                $this->db->roll_back();
                return $this->error('取消订单失败' . $e->getMessage());
            }
        }
    }

    /**
     * 更新订单状态
     * @router http://server.name/order.change.status-receipt 接单，更新为待确认；既待上门
     * @router http://server.name/order.change.status-begin 开始服务，更新为服务中
     * @router http://server.name/order.change.status-completed 服务商主动完成，更新为已完成
     */
    public function changeOrderStatus()
    {
        $target_status = $this->router->get(1);

        if (!in_array($target_status, ['receipt', 'begin', 'completed'])) {
            return $this->error('更新状态未定义');
        }

        $order_sn = $this->router->get(2);
        if (!$order_sn) {
            return $this->error('订单流水号必须');
        }

        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        $map['user_id'] = $user_info->user_id;
        $store_info     = $this->db->get_row('jiajie_store', $map);

        if (!$store_info) {
            return $this->error('您还未开通店铺!');
        }

        /** @noinspection TypeUnsafeComparisonInspection */
        if ($store_info['store_status'] != 1) {
            return $this->error('店铺当前不可用!');
        }

        $order_info = $this->db->get_row(get_table('order'), ['order_sn' => $order_sn]);
        if (!$order_info) {
            return $this->error('订单不存在或已关闭');
        }

        $order_info = $this->db->get_row(get_table('order'), ['order_sn' => $order_sn]);
        if (!$order_info) {
            return $this->error('订单不存在或已关闭');
        }
        $result = false;
        if ('receipt' === $target_status) {
            // 接单逻辑
            /** @noinspection TypeUnsafeComparisonInspection */
            if (0 == $order_info['order_is_pay']) {
                return $this->error('订单未支付，不能接单');
            }

            /** @noinspection TypeUnsafeComparisonInspection */
            if ($order_info['order_type'] == 1) {
                /** @noinspection TypeUnsafeComparisonInspection */
                if ($order_info['order_belong_store_id'] != $store_info['id']) {
                    return $this->error('该订单不属于您的店铺，不能执行此操作');
                }
            }
            $result = $this->db->update('jiajie_order', [
                'order_state'  => 2
                , 'receipt_at' => $_SERVER['REQUEST_TIME']
            ], ['order_sn' => $order_sn]);
        }

        if ('begin' === $target_status) {
            // 开始订单逻辑
            /** @noinspection TypeUnsafeComparisonInspection */
            if ($order_info['order_belong_store_id'] != $store_info['id']) {
                return $this->error('该订单不属于您的店铺，不能执行此操作');
            }
            /** @noinspection TypeUnsafeComparisonInspection */
            if (2 != $order_info['order_state']) {
                return $this->error('订单状态不为待服务，不可开始服务!');
            }
            // 判断当前时间是否在预约时间之后
            if ($order_info['order_type'] == 1) {
                if ($order_info['contact_appointment_at'] < $_SERVER['REQUEST_TIME']) {
                    return $this->error('未到预约时间');
                }
            }
            $result = $this->db->update(get_table('order'), [
                'order_state'   => 3
                , 'order_sm_at' => $_SERVER['REQUEST_TIME']
            ], ['order_sn' => $order_sn]);
        }
        // 服务商主动完成订单
        if ('completed' === $target_status) {
            /** @noinspection TypeUnsafeComparisonInspection */
            if ($order_info['order_belong_store_id'] != $store_info['id']) {
                return $this->error('该订单不属于您的店铺，不能执行此操作');
            }
            /** @noinspection TypeUnsafeComparisonInspection */
            if (3 != $order_info['order_state']) {
                return $this->error('订单状态不为服务中，不可结束!');
            }
            $result = $this->db->update(get_table('order'), [
                'order_rate'    => 1
                , 'complete_at' => $_SERVER['REQUEST_TIME']
            ], ['order_sn' => $order_sn]);
        }

        return $result ? $this->success(false) : $this->error(APP_DEBUG ? $this->db->get_sql() : '更新订单信息错误');
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
        $order_info = $this->db->get_row('jiajie_order', ['order_sn' => $order_sn]);
        if (!$order_info) {
            return $this->error('流水号对应的订单不存在');
        }
        return $this->success([
            'order_sign' => md5(implode('-', [$order_sn, $order_info['order_type'], $order_info['order_type_id']]))
        ]);
    }

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $data = [
            'insert' => [
                // 写入操作时需要获取的字段 例子:
                // 'role_name' =>  $this->request->post('role_name', '', 'trim')
            ],
            'update' => [
                // 更新操作时需要获取的字段 例子:
                // 'role_name' =>  $this->request->post('role_name', '', 'trim'),
            ]
        ];

        return $data[$method] ?? [];
    }


    /**
     * 验证定义
     * @param $method
     * @return array
     */
    public function valid($method): array
    {
        $valid = [
            'insert' => [
                // 写入时的数据验证如：
                // 'role_name' =>  'required'
            ],
            'update' => [
                // 更新时的数据验证如：
                // 'role_name' =>  'required'
            ]
        ];

        return $valid[$method] ?? [];
    }

    // - 更多方法定义
}
