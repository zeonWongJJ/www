<?php
/**
 * 订单模型类，处理订单相关逻辑
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

use utils\Factory;

class OrderModel extends \utils\BaseModel
{
    const ORDER_USER_BUY_SERVER = 1; // 用户购买服务
    const ORDER_USRE_DEMAND = 2; // 用户支付需求
    const ORDER_USER_RECHANGE = 3; // 用户充值余额

    /**
     * @var array
     */
    private $contact = [];

    /**
     * @var array
     */
    private $deductible = [
        'type'  => 0,
        'count' => 0
    ];

    /**
     * 设置订单联系人
     * @param $telephone
     * @param $address_name
     * @param $house_number
     * @param $contact_name
     * @return $this
     */
    public function setContact($telephone, $address_name, $house_number, $contact_name)
    {
        $this->contact['telephone']    = $telephone;
        $this->contact['address_name'] = $address_name;
        $this->contact['house_number'] = $house_number;
        $this->contact['contact_name'] = $contact_name;

        return $this;
    }

    /**
     * 计算抵扣
     * @param $deductible_type
     * @return $this|mixed
     */
    public function coumpteDeductible($deductible_type)
    {

        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $map['user_id'] = $user_info->user_id;

//        $user_info = $this->db->get_row('user', $map, 'user_score,user_balance');

        if ($deductible_type == 0) { // 无抵扣
            $this->deductible['count'] = 0;
            $this->deductible['type']  = 0;
        } else if ($deductible_type == 1) { // 抵扣余额
            $this->deductible['type'] = $deductible_type;
//            $user_balance             = $user_info['user_balance'] * 100;
            // 获取用户当前余额
//            $deductible_count         *= 100;
//            if ($user_balance < $deductible_count) {
//                return $this->error('用户余额不够抵扣');
//            }
//            $this->deductible['count'] = $deductible_count;
        } else if ($deductible_type == 2) { // 抵扣积分
            $this->deductible['type'] = $deductible_type;
//            $user_score               = $user_info['user_score'] * 100;
//            $deductible_count         *= 100;
//
//            if ($user_score < $deductible_count) {
//                return $this->error('用户积分不够抵扣');
//            }
        } else {
            return $this->error('抵扣类型不支持!');
        }

        return $this;
    }

    /**
     * 统一下单
     * 这一步执行的是订单的创建，返回创建后生成的订单号，以及需要支付的信息
     *
     * @param $order_type
     * @param $order_belong_id
     * @param $order_pay_way
     * @param $order_amount
     * @return array
     */
    public function unifiedOrder($order_type, $order_belong_id, $order_pay_way, $order_amount)
    {
        if (!$this->contact) {
            return $this->error('未设置下单人信息');
        }
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        if (!\in_array($order_pay_way, ['alipay', 'wechat', 'bankcard'])) {
            return $this->error('支付方式未支持!');
        }

        $data['order_type']    = $order_type;
        $data['order_type_id'] = $order_belong_id;
        $data['user_id']       = $user_info->user_id;
        $data['order_state']   = 0; // 默认订单状态为拍下
//        $data['order_process'] = 0; // 默认状态为拍下
        $data['order_pay_way'] = $order_pay_way; // 订单支付方式
        $data['order_amount']  = $order_amount; // 交易金额，单位分
        $data['add_time']      = $_SERVER['REQUEST_TIME']; // 订单下单时间
        $data['pay_time']      = 0; // 订单支付时间

        $data = array_merge($this->contact, $data); // 合并联系人

        // 抵扣
        $data['order_deductible_type'] = $this->deductible['type']; // 抵扣类型 1：余额 2：积分 0：无抵扣
        $_user_info                    = $this->db->get_row('user', ['user_id' => $user_info->user_id], 'user_score,user_balance');
        if ($data['order_deductible_type'] == 1) {
            // 处理余额抵扣
            $user_balance = $_user_info['user_balance'] * 100;
            if ($user_balance >= $order_amount) {
                $data['order_deductible_count'] = $order_amount;
            } else {
                $data['order_deductible_count'] = $user_balance;
            }
            $update = sprintf('%.2f', ($user_balance - $data['order_deductible_count']) / 100);
//            $this->db->update('user', ['user_balance' => $update], ['user_id' => $user_info->user_id]);
        } elseif ($data['order_deductible_type'] == 2) {
            // 处理积分抵扣
            $user_score = $_user_info['user_score'] * 100;
            if ($user_score >= $order_amount) {
                $data['order_deductible_count'] = $order_amount;
            } else {
                $data['order_deductible_count'] = $user_score;
            }
            $update = sprintf('%.2f', ($user_score - $data['order_deductible_count']) / 100);
//            $this->db->update('user', ['user_score' => $update], ['user_id' => $user_info->user_id]);
        }
        //        $data['order_deductible_count'] = $this->deductible['count']; // 抵扣金额，
        $data['order_actual_amount'] = $order_amount - $data['order_deductible_count']; // 实际支付金额

        $this->validate($data, [
            'order_sn'     => 'required|length:32',
            'order_amount' => 'required|number'
        ]);

        // 检查一次指向的类型ID是否存在
        switch ($data['order_type']) {
            case self::ORDER_USRE_DEMAND:
                $table_name         = 'jiajie_demand';
                $has_one            = $this->db->get_row($table_name, ['id' => $data['order_type_id']]);
                $data['order_name'] = $has_one['subject_title'];
                $data['order_info'] = $has_one['demand_info'];
                break;
            case self::ORDER_USER_BUY_SERVER:
                $table_name         = 'jiajie_service';
                $has_one            = $this->db->get_row($table_name, ['id' => $data['order_type_id']]);
                $data['order_name'] = $has_one['service_name'];
                $data['order_info'] = $has_one['service_info'];
                break;
            case self::ORDER_USER_RECHANGE:
                $table_name         = 'jiajie_recharge';
                $has_one            = $this->db->get_row($table_name, ['id' => $data['order_type_id']]);
                $data['order_info'] = $data['order_name'] = '用户编号' . $has_one['user_id'] . '充值';
                break;
            default:
                $has_one = $table_name = false;
        }

        if (false === $table_name) {
            return $this->error('支付适配器未定义');
        }
//        $table_name = $data['order_type'] === self::ORDER_USRE_DEMAND ? 'jiajie_demand' : 'jiajie_service';
        if ($has_one) {
            // 获取订单名称，为实体的name
//            if ($table_name == 'jiajie_demand') {
//                $data['order_name'] = $has_one['subject_title'];
//            } else if ($table_name == 'jiajie_demand')
//                $data['order_name'] = $table_name == 'jiajie_demand' ? $has_one['subject_title'] : $has_one['service_name'];
//            $data['order_info'] = $table_name == 'jiajie_demand' ? $has_one['demand_info'] : $has_one['service_info'];
            $insert_id = $this->db->insert(get_table('order'), $data);

            // 组装返回的信息
            $micro  = sprintf('%.0f', microtime(true));
            $return = [
                'order_sn' => $micro . str_pad($insert_id, 13, '0', STR_PAD_LEFT), // 订单流水号
            ];

            $this->db->update(
                get_table('order'),
                ['order_sn' => $return['order_sn']],
                ['id' => $insert_id]
            ); // 更新订单流水号

            // 抵扣记录
            /** @noinspection TypeUnsafeComparisonInspection */
            if (1 == $data['order_deductible_type']) {
                $this->db->insert('userbalance', [
                    'ub_type'          => 2
                    , 'ub_money'       => $data['order_deductible_count']
                    , 'ub_balance'     => $update
                    , 'ub_time'        => $_SERVER['REQUEST_TIME']
                    , 'ub_item'        => '余额抵扣'
                    , 'user_id'        => $user_info->user_id
                    , 'ub_number'      => $return['order_sn']
                    , 'ub_description' => '家洁订单' . $return['order_sn'] . '抵扣余额'
                ]);
            } /** @noinspection TypeUnsafeComparisonInspection */ elseif (2 == $data['order_deductible_type']) {
                $this->db->insert('points_log', [
                    'user_id'          => $user_info->user_id
                    , 'user_name'      => $user_info->user_name
                    , 'pl_type'        => 2
                    , 'pl_variation'   => $data['order_deductible_count']
                    , 'pl_score'       => $update
                    , 'pl_item'        => '积分抵扣'
                    , 'pl_description' => '家洁订单' . $return['order_sn'] . '抵扣积分'
                    , 'pl_time'        => $_SERVER['REQUEST_TIME']
                    , 'pl_code'        => 4
                ]);
            }

            $return['order_sign'] = md5(implode('-', [$return['order_sn'], $data['order_type'], $data['order_type_id']]));
            return $return; // 返回订单信息
        }

        return $this->error('没有对应记录');
//        return $this->error($data['order_type'] === self::ORDER_USRE_DEMAND ? '需求已过期' : '服务已过期');
    }

    /**
     * 支付订单
     * 这一步执行的是订单的支付，返回订单的支付信息
     *
     * 订单签名算法：MD5(explode('-', [$order_sn, $order_type, $order_type_id]))
     * @param string $order_sn 订单流水号
     * @param string $order_sign 订单签名
     * @return mixed
     * @throws \Exception
     */
    public function payOrder($order_sn, $order_sign)
    {
        $map['order_sn'] = $order_sn;
        $order           = $this->db->get_row(get_table('order'), $map);
        if ($order) {
//            if ($order['order_process'] != 0) {
//                return $this->error('订单状态不允许继续执行支付');
//            }
            // 1.判断签名是否正确
            if ($order_sign === md5(implode('-', [$order_sn, $order['order_type'], $order['order_type_id']]))) {
                // 2. 判断订单是否超过支付期限，支付期限为30分钟
//                if ($order['add_time'] + 1800 >= $_SERVER['REQUEST_TIME']) {
                if ((int)$order['order_type'] === self::ORDER_USRE_DEMAND) {
                    $row = $this->db->get_row(get_table('demand'), ['id' => $order['order_type_id']]);
                    if ($row['order_sn'] !== $order_sn) {
                        return $this->error('订单流水号不匹配!');
                    }
                } else {
                    $row['subject_title'] = $order['order_name'];
                }

//                    $table_name = (int)$order['order_type'] === self::ORDER_USRE_DEMAND ? 'jiajie_demand' : 'jiajie_service';
//                    $row        = $this->db->get_row($table_name, ['id' => $order['order_type_id']]);
                // 4. 检查该服务或者需求是否与订单流水号对应
//                    if ($row['order_sn'] === $order_sn) {
                //5. 更改订单交易状态
//                $this->db->update('jiajie_order', ['order_paying' => 1], $map); // 更改订单状态为交易中
                switch ($order['order_pay_way']) {
                    case 'wechat':
                        $pay_way      = PayModel::WECHAT;
                        $order_info   = [
                            'body'             => $row['subject_title'],
                            'total_fee'        => $order['order_actual_amount'], // 订单总金额，单位为分 https://pay.weixin.qq.com/wiki/doc/api/H5.php?chapter=4_2
                            'spbill_create_ip' => get_client_ip(),
                        ];
                        $total_amount = $order_info['total_fee'] / 100;
                        break;
                    case 'alipay':
                        $pay_way      = PayModel::ALIPAY;
                        $order_info   = [
                            'timeout_express' => '30m',
                            'subject'         => $row['subject_title'],
                            'total_amount'    => format_money($order['order_actual_amount'])
                        ];
                        $total_amount = $order_info['total_amount'];
                        break;
                    case 'bankcard':
                        $pay_way      = PayModel::BANKCARD;
                        $order_info   = [
                            'body'      => $row['subject_title'],
                            'total_fee' => $order['order_actual_amount'] // 订单总金额，单位为分
                        ];
                        $total_amount = $order_info['total_fee'] / 100;
                        break;
                    default:
                        $pay_way = false;
                }
                if (false !== $pay_way) {
                    /** @noinspection TypeUnsafeComparisonInspection */
                    /** @noinspection PhpUndefinedVariableInspection */
                    if ($total_amount * 100 == 0) {
                        header('location:' . "http://jiajie-server.7dugo.com/order.pay.return-{$pay_way}?out_trade_no={$order_sn}");
                    }
                    /** @var PayModel $pay_model */
                    $pay_model                  = Factory::getFactory('pay');
                    $order_info['out_trade_no'] = $order_sn;
                    return $pay_model->setPayWay($pay_way)->pay($order_info);
                }
                return $this->error('交易方式非法!');
//                    }
//                    return $this->error('订单流水号不匹配!');
//                }
//                return $this->error('订单超过支付有效期，请重新下单!');
            }
        }
        return $this->error('查询不到订单!');
    }

    /**
     * 完成支付订单的后续操作
     * 这一步执行的是订单的最终状态写入
     * @param string $out_trade_no 上一步提交订单的自定义订单号，也就是订单流水号
     * @return mixed
     * @throws \Exception
     */
    public function orderCallBack($out_trade_no)
    {
        try {
            $this->db->set_error_mode();
            $this->db->begin();

            $order = $this->db->get_row('jiajie_order', [
                'order_sn' => $out_trade_no
            ]);

            if (!$order) {
                return $this->error('没有匹配的订单');
            }

            /** @noinspection TypeUnsafeComparisonInspection */
            if ($order['order_is_pay'] == 1) {
                return $this->error('订单已经支付!');
            }
            $user_info = $this->db->get_row('user', ['user_id' => $order['user_id']]);
            if (!$user_info) {
                throw new \RuntimeException('订单查询不到用户');
            }
            /** @noinspection TypeUnsafeComparisonInspection */
            if ($order['order_type'] == 2) {
//                $this->db->update('jiajie_demand', ['demand_status' => 0], ['id' => $order['order_type_id']]); // 更新已支付
            } /** @noinspection TypeUnsafeComparisonInspection */ elseif ($order['order_type'] == 3) {
                $this->db->update(get_table('recharge'), ['recharge_status' => 2], ['id' => $order['order_type_id']]);
                // 充值余额时更新用户余额
                $_update = [
                    'user_balance' => $user_info['user_balance'] * 100 + $order['order_amount']
                ];

                $_update['user_balance'] = sprintf('%.2f', $_update['user_balance'] / 100);
                if (!$result = $this->db->update('user', $_update, ['user_id' => $order['user_id']])) {
                    throw new \RuntimeException('冲入用户余额失败!');
                }

                $this->db->insert('userbalance', [
                    'ub_type'        => 1,
                    'ub_money'       => sprintf('%.2f', $order['order_amount'] / 100),
                    'ub_balance'     => $_update['user_balance'],
                    'ub_time'        => $_SERVER['REQUEST_TIME'],
                    'ub_item'        => '余额充值',
                    'user_id'        => $order['user_id'],
                    'ub_number'      => $order['order_sn'],
                    'ub_description' => '用户冲入余额'
                ]);
            }
            // 支付成功后更新表
            $this->db->update(get_table('order'), [
                'order_is_pay'  => 1 // 订单更新为已支付
//                , 'order_paying' => 0
                , 'pay_time'    => time()
                , 'order_state' => 1 // 订单状态为待确认
            ], ['order_sn' => $out_trade_no]);

            /** @noinspection TypeUnsafeComparisonInspection */
            if ($order['order_type'] != 3) {
                /** @noinspection TypeUnsafeComparisonInspection */
                if ($order['order_deductible_type'] == 2) {
                    $update['user_score'] = sprintf('%.2f', ($user_info['user_score'] * 100 - $order['order_deductible_count']) / 100);
                    $this->db->insert('points_log', [
                        'user_id'        => $user_info['user_id'],
                        'user_name'      => $user_info['user_name'],
                        'pl_type'        => 2,
                        'pl_variation'   => $order['order_deductible_count'] / 100,
                        'pl_score'       => $update['user_score'],
                        'pl_item'        => '积分抵现',
                        'pl_description' => '订单' . $order['order_sn'] . '支付时使用积分抵扣了' . $order['order_deductible_count'] / 100 . '元',
                        'pl_time'        => $_SERVER['REQUEST_TIME'],
                        'pl_code'        => 4
                    ]);
                    $this->db->update('user', $update, ['user_id' => $user_info['user_id']]);
                } /** @noinspection TypeUnsafeComparisonInspection */ elseif ($order['order_deductible_type'] == 1) {
                    $update['user_balance'] = sprintf('%.2f', ($user_info['user_balance'] * 100 - $order['order_deductible_count']) / 100);
                    $this->db->insert('userbalance', [
                        'ub_type'        => 2,
                        'ub_money'       => $order['order_deductible_count'] / 100,
                        'ub_balance'     => $update['user_balance'],
                        'ub_item'        => '余额抵扣',
                        'user_id'        => $user_info['user_id'],
                        'ub_number'      => $order['order_sn'],
                        'ub_time'        => $_SERVER['REQUEST_TIME'],
                        'ub_description' => '商品支付时使用余额抵扣了' . sprintf('%.2f', $order['order_deductible_count'] / 100) . '元'
                    ]);
                    $this->db->update('user', $update, ['user_id' => $user_info['user_id']]);
                }
            }
            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->roll_back();
            throw $e;
        }
    }

    /**
     * 回滚订单
     * @param $out_trade_no
     */
    public function rollbackOrder($out_trade_no)
    {
        $order_info = $this->db->get_row('jiajie_order', ['order_sn' => $out_trade_no]);
        if (!$order_info) {
            throw new \RuntimeException('订单不存在');
        }
        try {
            $this->db->begin();
            $this->db->set_error_mode();
            $this->db->update('jiajie_order', [
                'order_state' => 0 // 回滚到待付款状态
            ], ['order_sn' => $out_trade_no]);
            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->roll_back();
        }
    }

    /**
     * @param string $order_sn 订单流水号
     * @return bool
     */
    public function orderDelete($order_sn)
    {
        try {
            $map['order_sn'] = $order_sn;
            $this->db->begin();
            $this->db->delete('jiajie_order', $map);
            //            $this->db->delete('jiajie_order_entity', $map);
            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->roll_back();
            return false;
        }
    }

    /**
     * 判断流水号是否存在
     * @param $order_sn
     * @return array|mixed
     */
    public function checkSnHas($order_sn)
    {
        $order_info = $this->db->get_row('jiajie_order', compact('order_sn'));
        if (!$order_info) {
            return $this->error('订单流水号不存在！');
        }

        return $order_info;
    }

    /**
     * 判断订单是否属于当前登录用户
     * @param $order_sn
     * @return mixed
     */
    public function checkOrderBelongUser($order_sn)
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $order_info = $this->db->get_row('jiajie_order', compact('order_sn'));
        if (!$order_info) {
            return $this->error('订单流水号不存在！');
        }
        /** @noinspection TypeUnsafeComparisonInspection */
        if ($order_info['user_id'] != $user_info->user_id) {
            return $this->error('改订单不属于当前登录用户');
        }

        return $user_info;
    }

    /**
     * 根据用户自动评价订单
     * @param int $user_id 用户id
     */
    public function autoCommentOrders($user_id)
    {
        // 获取设置的天数
        $days = $this->db->get_row(get_table('config'), ['config_key' => 'automatic_evaluation_of_days'], 'config_value');
        $days = strtotime('-' . ceil($days['config_value']) . ' day'); // 进一法取整
        $map  = [
            'user_id'                    => $user_id
            , 'order_belong_store_id <>' => 0
            , 'receipt_at <='            => $days
        ];

        $count = $this->db
            ->where($map)
            ->get_total(get_table('order'));

        $orders = $this->db
            ->where($map)
            ->limit(0, $count)
            ->get(get_table('order'));

        if ($orders) {
            $this->db
                ->where($map)
                ->update(get_table('order'), ['order_rate' => 1, 'complete_at' => $_SERVER['REQUEST_TIME']]); // 更新订单状态为已完成

            $service_orders = [];
            foreach ($orders as $order) {
                /** @noinspection TypeUnsafeComparisonInspection */
                $order['order_type'] == 1 && $service_orders[] = $order;
            }

            // todo::优化此循环，先计算出总添加量再更新到表+计算等级
            foreach ($service_orders as $order) {
                $service_info = $this->db->get_row(get_table('service'), ['id' => $order['order_type_id']]);
                if ($service_info) {
                    $store_info = $this->db->get_row(get_table('store'), ['id' => $service_info['store_id']]);
                    if ($store_info) {
                        // 默认好评
                        $evaluate_update['store_hp_count']     = $store_info['store_hp_count'] + 1;
                        $service_pj_update['service_hp_count'] = $service_info['service_hp_count'] + 1;
                        // 更新店铺总好评
                        $this->db->update(get_table('store'), $evaluate_update, ['id' => $service_info['store_id']]);
                        // 更新服务总好评
                        $this->db->update(get_table('service'), $service_pj_update, ['id' => $order['order_type_id']]);
                        /** @var StoreModel $store_model */
                        $store_model = Factory::getFactory('store');
                        $store_model->upStoreLevel($service_info['store_id']); // 计算一次店铺等级

                        // 计算返回积分
                        /** @var JifenModel $jifen_model */
                        $jifen_model = Factory::getFactory('jifen');
                        $jifen_model->restore($order['id']); // 执行积分返还
                    }
                }
            }
        }
    }

    /**
     * 退款订单退款
     * @param string $order_sn 订单流水号
     */
    public function orderRefund($order_sn)
    {
        $order_info = $this->db->get_row('jiajie_order', compact('order_sn'));
        /** @noinspection TypeUnsafeComparisonInspection NotOptimalIfConditionsInspection */
        if ($order_info && \in_array((int)$order_info['order_state'], [1, 2], true) && $order_info['order_refund'] == 0) {
            $user_info = $this->db->get_row('user', ['user_id' => $order_info['user_id']]);
            /** @noinspection TypeUnsafeComparisonInspection */
            if ($order_info['order_deductible_type'] == 1) { // 订单使用了余额抵扣
                $update['user_balance'] = sprintf(
                    '%.2f'
                    , ($user_info['user_balance'] * 100 + $order_info['order_deductible_count'] + $order_info['order_actual_amount']) / 100
                );
                $this->db->insert('userbalance', [
                    'ub_type'          => 1
                    , 'ub_money'       => sprintf('%.2f', ($order_info['order_deductible_count'] + $order_info['order_actual_amount']) / 100)
                    , 'ub_balance'     => $update['user_balance']
                    , 'ub_time'        => $_SERVER['REQUEST_TIME']
                    , 'ub_item'        => '退还金额'
                    , 'user_id'        => $order_info['user_id']
                    , 'ub_number'      => $order_info['order_sn']
                    , 'ub_description' => '订单号' . $order_info['order_sn'] . '过期退还金额'
                ]);
            } /** @noinspection TypeUnsafeComparisonInspection */ elseif ($order_info['order_deductible_type'] == 2) { // 订单使用了积分抵扣
                $update['user_score']   = sprintf(
                    '%.2f'
                    , ($user_info['user_score'] * 100 + $order_info['order_deductible_count']) / 100
                );
                $update['user_balance'] = sprintf(
                    '%.2f'
                    , ($user_info['user_balance'] * 100 + $order_info['order_actual_amount']) / 100
                );
                $this->db->insert('userbalance', [
                    'ub_type'          => 1
                    , 'ub_money'       => sprintf('%.2f', $order_info['order_actual_amount'] / 100)
                    , 'ub_balance'     => $update['user_balance']
                    , 'ub_time'        => $_SERVER['REQUEST_TIME']
                    , 'ub_item'        => '退还金额'
                    , 'user_id'        => $order_info['user_id']
                    , 'ub_number'      => $order_info['order_sn']
                    , 'ub_description' => '订单号' . $order_info['order_sn'] . '过期退还金额'
                ]);
                $this->db->insert('points_log', [
                    'user_id'          => $order_info['user_id']
                    , 'user_name'      => $user_info['user_name']
                    , 'pl_type'        => 1
                    , 'pl_variation'   => sprintf('%.2f', $order_info['order_deductible_count'] / 100)
                    , 'pl_score'       => $update['user_score']
                    , 'pl_item'        => '退还积分'
                    , 'pl_description' => '订单号' . $order_info['order_sn'] . '过期退还积分'
                    , 'pl_time'        => $_SERVER['REQUEST_TIME']
                    , 'pl_code'        => 4
                ]);
            } else {
                $update['user_balance'] = sprintf(
                    '%.2f'
                    , ($user_info['user_balance'] * 100 + $order_info['order_actual_amount']) / 100
                );
                $this->db->insert('userbalance', [
                    'ub_type'          => 1
                    , 'ub_money'       => sprintf('%.2f', $order_info['order_actual_amount'] / 100)
                    , 'ub_balance'     => $update['user_balance']
                    , 'ub_time'        => $_SERVER['REQUEST_TIME']
                    , 'ub_item'        => '退还金额'
                    , 'user_id'        => $order_info['user_id']
                    , 'ub_number'      => $order_info['order_sn']
                    , 'ub_description' => '订单号' . $order_info['order_sn'] . '过期退还金额'
                ]);
            }

            $this->db->update('user', $update, ['user_id' => $order_info['user_id']]);
            $this->db->update('jiajie_order', [
                'order_refund'      => 1
                , 'order_refund_at' => $_SERVER['REQUEST_TIME']
            ], ['order_sn' => $order_sn]);
        }
    }
}
