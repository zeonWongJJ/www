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
        'count' => 0,
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

        $data['order_type']          = $order_type;
        $data['order_type_id']       = $order_belong_id;
        $data['user_id']             = $user_info->user_id;
        $data['order_state']         = 0; // 默认订单状态为拍下
        $data['order_bis_state_dsc'] = 'SET_UP'; // 默认订单状态为拍下
        $data['order_pay_state_dsc'] = 'PENDING_PAY'; // 默认订单状态为拍下
        $data['order_pay_way']       = $order_pay_way; // 订单支付方式
        $data['order_amount']        = $order_amount; // 交易金额，单位分
        $data['add_time']            = $_SERVER['REQUEST_TIME']; // 订单下单时间
        $data['pay_time']            = 0; // 订单支付时间

        $data = array_merge($this->contact, $data); // 合并联系人

        // 抵扣
        $data['order_deductible_type'] = $this->deductible['type']; // 抵扣类型 1：余额 2：积分 0：无抵扣
        $_user_info                    = $this->db->get_row('user', ['user_id' => $user_info->user_id], 'user_score,user_balance');
        if ($data['order_deductible_type'] == 1) { // 处理余额抵扣
            $user_balance = $_user_info['user_balance'] * 100;
            if ($user_balance >= $order_amount) {
                $data['order_deductible_count'] = $order_amount;
            } else {
                $data['order_deductible_count'] = $user_balance;
            }
            $update = sprintf('%.2f', ($user_balance - $data['order_deductible_count']) / 100);
        } else if ($data['order_deductible_type'] == 2) { // 处理积分抵扣
            $user_score = $_user_info['user_score'] * 100;
            if ($user_score >= $order_amount) {
                $data['order_deductible_count'] = $order_amount;
            } else {
                $data['order_deductible_count'] = $user_score;
            }
            $update = sprintf('%.2f', ($user_score - $data['order_deductible_count']) / 100);
        }
        $data['order_actual_amount'] = $order_amount - $data['order_deductible_count']; // 实际支付金额

        $this->validate($data, [
            'order_sn'     => 'required|length:32',
            'order_amount' => 'required|number',
        ]);

        // 检查一次指向的类型ID是否存在
        switch ($data['order_type']) {
            case self::ORDER_USRE_DEMAND:
                $table_name         = get_table('demand');
                $has_one            = $this->db->get_row($table_name, ['id' => $data['order_type_id']]);
                $data['order_name'] = $has_one['subject_title'];
                $data['order_info'] = $has_one['demand_info'];
                break;
            case self::ORDER_USER_BUY_SERVER:
                $table_name         = get_table('service');
                $has_one            = $this->db->get_row($table_name, ['id' => $data['order_type_id']]);
                $data['order_name'] = $has_one['service_name'];
                $data['order_info'] = $has_one['service_info'];
                break;
            case self::ORDER_USER_RECHANGE:
                $table_name         = get_table('recharge');
                $has_one            = $this->db->get_row($table_name, ['id' => $data['order_type_id']]);
                $data['order_info'] = $data['order_name'] = '用户编号' . $has_one['user_id'] . '充值';
                break;
            default:
                $has_one = $table_name = false;
        }

        if (false === $table_name) {
            return $this->error('支付适配器未定义');
        }
        if ($has_one) {
            // 获取订单名称，为实体的name
            $this->db->set_error_mode();
            if (!$insert_id = $this->db->insert(get_table('order'), $data)) {
                return $this->error('订单创建失败' . $this->db->get_error());
            }

            // 组装返回的信息
            $micro  = sprintf('%.0f', microtime(true));
            $return = [
                'order_sn' => $micro . str_pad($insert_id, 13, '0', STR_PAD_LEFT), // 订单流水号
            ];

            $this->db->update(get_table('order'), ['order_sn' => $return['order_sn']], ['id' => $insert_id]); // 更新订单流水号

            // 记录抵扣
            if (1 == $data['order_deductible_type']) {
                $this->db->insert('userbalance', [
                    'ub_type'          => 2
                    , 'ub_money'       => sprintf('%.2f', $data['order_deductible_count'] / 100)
                    , 'ub_balance'     => $update
                    , 'ub_time'        => $_SERVER['REQUEST_TIME']
                    , 'ub_item'        => '余额抵扣'
                    , 'user_id'        => $user_info->user_id
                    , 'ub_number'      => $return['order_sn']
                    , 'ub_description' => '家洁订单' . $return['order_sn'] . '抵扣余额',
                ]);
            } elseif (2 == $data['order_deductible_type']) {
                $this->db->insert('points_log', [
                    'user_id'          => $user_info->user_id
                    , 'user_name'      => $user_info->user_name
                    , 'pl_type'        => 2
                    , 'pl_variation'   => sprintf('%.2f', $data['order_deductible_count'] / 100)
                    , 'pl_score'       => $update
                    , 'pl_item'        => '积分抵扣'
                    , 'pl_description' => '家洁订单' . $return['order_sn'] . '抵扣积分'
                    , 'pl_time'        => $_SERVER['REQUEST_TIME']
                    , 'pl_code'        => 4,
                ]);
            }

            // 写入订单关联
            $this->db->insert(get_table('order_info'), [
                'order_sn'   => $return['order_sn'],
                'order_info' => json_encode(filter($has_one)),
            ]);

            $return['order_sign'] = md5(implode('-', [$return['order_sn'], $data['order_type'], $data['order_type_id']]));
            return $return; // 返回订单信息
        }

        return $this->error('没有对应记录');
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
            if ($order['order_pay_state_dsc'] == 'PAYING') {
                return $this->error('订单正在处理交易中，请稍等');
            }
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

                $this->db->update(get_table('order'), ['order_pay_state_dsc' => 'PAYING'], ['order_sn' => $order_sn]); // 标记订单支付处理中

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
                            'total_amount'    => format_money($order['order_actual_amount']),
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
                    /** @noinspection PhpUndefinedVariableInspection TypeUnsafeComparisonInspection */
                    // 订单金额全抵扣
                    if ($total_amount * 100 == 0) {
                        header('location:' . "http://jiajie-server.7dugo.com/order.pay.ret-deductible?out_trade_no={$order_sn}");
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

        if (!$order = $this->db->get_row(get_table('order'), ['order_sn' => $out_trade_no])) {
            throw new \RuntimeException('没有匹配的订单');
        }

        if ($order['order_is_pay'] == 1) {
            throw new \RuntimeException('订单已经支付');
        }
        if (!$user_info = $this->db->get_row('user', ['user_id' => $order['user_id']])) {
            throw new \RuntimeException('订单查询不到用户');
        }

        if ($order['order_type'] == 3) {
            $this->db->update(get_table('recharge'), ['recharge_status' => 2], ['id' => $order['order_type_id']]);
            // 充值余额时更新用户余额
            $_update = [
                'user_balance' => $user_info['user_balance'] * 100 + $order['order_amount'],
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
                'ub_description' => '用户冲入余额',
            ]);
        }

        // 支付成功后更新表
        $this->db->update(get_table('order'), [
            'order_is_pay'        => 1,  // 订单更新为已支付
            'pay_time'            => $_SERVER['REQUEST_TIME'],
            'order_state'         => 1, // 订单状态为待确认
            'order_pay_state_dsc' => 'PAY_SUCCESS' // 支付成功
            //'order_is_peddling' => 0 // 标记订单已处理支付,不在处于支付中
        ], ['order_sn' => $out_trade_no]);

        if ($order['order_type'] != 3) {
            // 订单使用了积分抵扣
            if ($order['order_deductible_type'] == 2) {
                $update['user_score'] = sprintf('%.2f', ($user_info['user_score'] * 100 - $order['order_deductible_count']) / 100);
                $this->db->update('user', $update, ['user_id' => $user_info['user_id']]);
            } elseif ($order['order_deductible_type'] == 1) {
                // 订单使用了余额抵扣
                $update['user_balance'] = sprintf('%.2f', ($user_info['user_balance'] * 100 - $order['order_deductible_count']) / 100);
                $this->db->update('user', $update, ['user_id' => $user_info['user_id']]);
            }
        }

        $order['order_type'] == 1 && $this->afterPayService($order); // 为下单服务的时候，执行支付后操作
    }

    /**
     * 支付下单服务后调用,主要用于判断是否需要自动分配订单
     * @param array $order_info 订单记录
     * @return bool
     * @throws \Exception
     */
    public function afterPayService(array $order_info)
    {
        if ($order_info['order_type'] != 1) {
            return false;
        }

        $store_info = $this->db
            ->select('a.*', false)
            ->where(['b.store_id' => $order_info['order_belong_store_id']])
            ->join([get_table('store') => 'a'], ['a.id' => 'b.store_id'], 'INNER')
            ->get_row([get_table('store_user') => 'b']);

        $service  = $this->db->get_row(get_table('service'), ['id' => $order_info['order_type_id']]);
        $template = $this->db->get_row(get_table('config'), ['config_key' => 'message_template_send_order_service'], 'config_value'); // 获取配置的模板
        $temp     = '您店铺下的服务#demand_name#有人下单了';
        if ($template && $template['config_value']) {
            $temp = $template['config_value'];
        }
        /** @var MessageModel $message_model */
        $message_model              = Factory::getFactory('message');
        $message_send_order_service = str_replace('#demand_name#', $service['service_name'], $temp);
        // +-----------------------------------------------------------------------------------------------
        // | 自动接单+自动分配
        // +-----------------------------------------------------------------------------------------------
        if (1 == $store_info['store_auto_receipt']) {
            $this->db->update(get_table('order'), [
                'order_state'         => 2, // 不管有没有分配到店员，都先把订单状态搞成已接单
                'order_bis_state_dsc' => 'PENDING_ASSIGN' // 待分配
            ], ['order_sn' => $order_info['order_sn']]);
            $this->autoAssignStaff($order_info['order_sn']); // 执行自动分配
            $_order_info   = $this->db
                ->select('b.store_director, b.store_phone, a.appointed_uid')
                ->join([get_table('store') => 'b'], ['a.appointed_uid' => 'b.user_id'])
                ->get_row([get_table('order') => 'a'], ['a.order_sn' => $order_info['order_sn']]);
            $appointed_uid = $this->db->get_row(get_table('order'), ['order_sn' => $order_info['order_sn']], 'appointed_uid');
            if ($appointed_uid && $appointed_uid['appointed_uid']) {
                $appointed_uid_arr = explode('-', $appointed_uid['appointed_uid']);
                foreach ($appointed_uid_arr as $uid) {
                    $this->db->insert(get_table('order_appointed'), [
                        'order_sn'      => $order_info['order_sn'],
                        'appointed_uid' => $uid,
                        'appointed_at'  => time(),
                        'appointer_id'  => 0,
                        'completed'     => 0,
                    ]);
                }
            }
            // 执行通知店铺管理人员
            if ($_order_info['store_phone']) {
                // 预约服务时间前10小时、30分钟前发送一次短信通知指派人员
                $msn_info = '您被指派的订单[' . $order_info['order_sn'] . ']预约将在' . date('Y-m-d H:i', $order_info['contact_appointment_at']) . '开始服务，请留意订单详情!';
                // 如果预约时间距离现在小于10小时，则预约服务前30分钟通知一次指派人员
                if ($order_info['contact_appointment_at'] <= $_SERVER['REQUEST_TIME'] + 36000) {
                    $message_model->sendMsm($_order_info['store_phone'], $msn_info, $order_info['contact_appointment_at'] - 36000 - $_SERVER['REQUEST_TIME']);
                }
                $message_model->sendMsm($_order_info['store_phone'], $msn_info, $order_info['contact_appointment_at'] - 1800 - $_SERVER['REQUEST_TIME']);
            }
        }
        if ($store_info['store_phone']) {
            $message_model->sendMsm($store_info['store_phone'], $message_send_order_service);
        }
    }

    /**
     * 自动指派订单到用户
     * @param string $order_sn
     */
    public function autoAssignStaff($order_sn)
    {
        $order_info = $this->db->get_row(get_table('order'), ['order_sn' => $order_sn]);
        // 被拒绝过的店员
        $cancel_assignor = [];
        $rejected        = $this->db->get(get_table('order_cancel_log'), ['order_sn' => $order_sn], 'cancel_assignor');
        foreach ($rejected as $item) {
            $cancel_assignor[] = $item['cancel_assignor'];
        }
        $cancel_assignor = array_merge($cancel_assignor, [1]); // 把勇哥默认变成拒接的这样就不用指派给他了
        unset($rejected);

        if ($order_info['order_rate'] == 0 && $order_info['order_belong_store_id'] != 0) {
            $parent_store_info = $this->db->get_row(get_table('store'), ['id' => $order_info['order_belong_store_id']]);
            // 获取上级店铺下的所有店员
            $has_receipt = $this->db->join([get_table('rule') => 'a'], ['a.id' => 'b.rule_id'], 'inner')
                ->where([
                    'a.rule_controller'     => 'Store'
                    , 'a.rule_action'       => 'changeOrderStatus'
                    , 'a.rule_router_param' => 'receipt'
                    , 'b.role_id'           => 5,
                ])->get_total([get_table('role_assign') => 'b']);
            if (!$has_receipt) {
                $all_staff_count = $this->db->get_total(get_table('store_user'), ['user_no_part' => 0, 'user_type' => 1, 'store_id' => $parent_store_info['id']]);
            } else {
                $all_staff_count = $this->db->where_in('user_type', [1, 2])->where(['user_no_part' => 0, 'store_id' => $parent_store_info['id']])->get_total(get_table('store_user'));
            }

            $map['store_id'] = $parent_store_info['id'];

            if ($all_staff_count) {
                if (!$has_receipt) {
                    $all_staffs = $this->db->limit(0, $all_staff_count)->get(get_table('store_user'), ['user_type' => 1, 'store_id' => $parent_store_info['id']], 'user_id');
                    // 先判断这些店员中是否有未指派订单的
                    $unassigned_count = $this->db->get_total(get_table('store_user'), array_merge(['user_type' => 1, 'current_order_sn' => 0], $map));
                } else {
                    $all_staffs = $this->db->limit(0, $all_staff_count)->where_in('user_type', [1, 2])->where(['store_id' => $parent_store_info['id']])->get(get_table('store_user'), 'user_id');
                    // 先判断这些店员中是否有未指派订单的
                    $unassigned_count = $this->db->where_in('user_type', [1, 2])->where($map)->get_total(get_table('store_user'), ['current_order_sn' => 0]);
                }

                $all_staff_user_ids = []; // 所有店员id
                foreach ($all_staffs as $all_staff) {
                    if ($all_staff['user_type'] == 3) {
                        continue;
                    }
                    $all_staff_user_ids[] = $all_staff['user_id'];
                }

                if ($unassigned_count) {
                    $query = $this->db->limit(0, $unassigned_count)->select('id, user_id, store_user_lng, store_user_lat');
                    if ($has_receipt) {
                        $query = $query->where(['user_type' => 1]);
                    } else {
                        $query = $query->where_in('user_type', [1, 2]);
                    }

                    $unassigned = $query->where(array_merge($map, ['current_order_sn' => 0]))->get(get_table('store_user'));
//                    $unassigned_user_ids = [];
                    $unassigned_user_rows = [];
                    foreach ($unassigned as $item) {
                        // 排除已被拒绝过的店员
                        if (!\in_array($item['user_id'], $cancel_assignor, false)) {
                            if ($lock = $this->cache('appointed.uid.lock.' . $item['user_id'])) {
                                continue; // 排除上锁的管理员
                            }
//                            $unassigned_user_ids[] = $item['user_id'];
                            // 计算距离
                            $item['_distance']      = get_distance($order_info['order_lat'], $order_info['order_lng'], $item['store_user_lat'], $item['store_user_lng']);
                            $unassigned_user_rows[] = $item;
                        }
                    }

                    // 旧的分配方案: 随机获取一个店员指派任务
                    // $rand       = array_rand($unassigned_user_ids, 1);
                    // $rend_staff = $unassigned_user_ids[$rand];

                    // 新的分配方案，根据店员距离来指派 2018-9-17
                    if ($unassigned_user_rows) {
                        $unassigned_user_rows = array_sort_by_key($unassigned_user_rows, '_distance', 'asc'); // 按照计算出来的距离排序数组
                        $assign_row           = array_shift($unassigned_user_rows); //不能[0]取第一条，因为id已经被打乱了
                        $rend_staff           = $assign_row['user_id'];
                        $this->cache('appointed.uid.lock.' . $rend_staff, $order_sn); // 上锁，防止在并发的情况下出现平台派了单但未写入完成但是服务员自己接了单的情况
                        $this->db->update(get_table('order'), [
                            'appointed_uid'       => $rend_staff, // 适配新的分配方案
                            'order_state'         => 2,
                            'order_bis_state_dsc' => 'PENDING_DOOR' // 分配成功，状态更改为待上门
                        ], ['order_sn' => $order_sn]);
                        $this->db->update(get_table('store_user'), ['current_order_sn' => $order_sn], ['user_id' => $rend_staff]); // 写入当前的订单号
                    }
                } else {
                    // 没有未指派订单的店员，从预约时间中+服务时长中 获取一个地理位置距离最短的
                    $all_incomplete_order_count = $this->db->get_total(get_table('order'), [
                        'order_belong_store_id' => $parent_store_info['id']
                        , 'order_rate'          => 0
                        , 'appointed_uid <>'    => 0,
                    ]); // 所有未完成的订单总数
                    $all_incomplete_orders      = $this->db
                        ->select('b.user_id as user_uid, a.*', false)
                        ->join(['user' => 'b'], ['b.user_id' => 'a.user_id'])
                        ->limit(0, $all_incomplete_order_count)
                        ->get([get_table('order') => 'a'], [
                            'a.order_belong_store_id' => $parent_store_info['id']
                            , 'a.order_rate'          => 0
                            , 'appointed_uid <>'      => 0,
                        ]);
                    $assigned_staff_ids         = [];
                    foreach ($all_incomplete_orders as $order) {
                        if ($order['contact_appointment_at'] + $order['service_length'] * 3600 < $order_info['contact_appointment_at']) {
//                            旧的分配逻辑，随便获取一条
//                            $this->db->update(get_table('store_user'), ['current_order_sn' => $order_sn], ['user_id' => $order['user_uid']]);
//                            $assigned_staff_info = $this->db->get_row(get_table('store'), ['user_id' => $order['user_id']], 'store_director');
//                            $this->db->update(get_table('order'), [
//                                'appointed_uid' => $order['user_uid']
//                                , 'order_state' => 2
//                            ], ['order_sn' => $order_sn]);
//                            $this->db->insert(get_table('order_log'), [
//                                'order_sn' => $order_sn
//                                , 'log_at' => $_SERVER['REQUEST_TIME']
//                                , 'log'    => '订单被指派到店员' . $assigned_staff_info['store_director']
//                                , 'uid'    => 0
//                            ]);
//                            break;

                            if (!\in_array((int)$order['appointed_uid'], $cancel_assignor, false)) {
                                $assigned_staff_ids[] = $order['appointed_uid'];
                            }
                        }
                    }

                    unset($all_incomplete_orders);

                    // 新的分配逻辑
                    if ($assigned_staff_ids) {
                        // 移除重复值
                        $assigned_staff_ids = array_flip($assigned_staff_ids);
                        $assigned_staff_ids = array_flip($assigned_staff_ids);

                        // 可分配的店员
                        $distributable_staff = $this->db->where_in('user_id', $assigned_staff_ids)
                            ->select('id, user_id, store_user_lng, store_user_lat')
                            ->limit(0, \count($assigned_staff_ids))
                            ->get(get_table('store_user'));

                        $distributable_item = [];
                        foreach ($distributable_staff as $staff) {
                            if ($lock = $this->cache('appointed.uid.lock.' . $staff['user_id'])) {
                                continue; // 排除上锁的店员
                            }
                            // 计算距离
                            $staff['_distance']   = get_distance($order_info['order_lat'], $order_info['order_lng'], $staff['store_user_lat'], $staff['store_user_lng']);
                            $distributable_item[] = $staff;
                        }

                        unset($distributable_staff, $assigned_staff_ids);

                        if ($distributable_item) {
                            $distributable_item = array_sort_by_key($distributable_item, '_distance', 'asc'); // 按照计算出来的距离排序数组
                            $assign_row         = array_shift($distributable_item); //不能[0]取第一条，因为id已经被打乱了
                            unset($distributable_item);
                            $rend_staff = $assign_row['user_id'];
                            $this->cache('appointed.uid.lock.' . $rend_staff, $order_sn); // 上锁，防止在并发的情况下出现平台派了单但未写入完成但是服务员自己接了单的情况

                            $this->db->update(get_table('order'), [
                                'appointed_uid'       => $rend_staff,
                                'order_state'         => 2,
                                'order_bis_state_dsc' => 'PENDING_DOOR' // 分配成功，状态更改为待上门
                            ], ['order_sn' => $order_sn]);
                            $this->db->update(get_table('store_user'), ['current_order_sn' => $order_sn], ['user_id' => $rend_staff]); // 写入当前的订单号
                        }
                    }
                }
            }
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
        $staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);
        if (!$order_info = $this->db->get_row(get_table('order'), compact('order_sn'))) {
            return $this->error('订单流水号不存在！');
        }

        if ($order_info['order_belong_store_id'] != $staff_row['store_id']) {
            return $this->error('改订单不属于当前店铺');
        }
        return $user_info;
    }

    /**
     * 根据店铺id自动评价订单,并同时执行评价后的操作：上级获得奖励+积分返还
     * @param int $store_id 店铺id，一级
     * @return bool
     */
    public function autoCommentOrders($store_id)
    {
        // 获取设置的天数
        $days        = $this->db->get_row(get_table('config'), ['config_key' => 'automatic_evaluation_of_days'], 'config_value');
        $day_or_days = ceil($days['config_value']) > 1 ? 'days' : 'day';
        $days        = strtotime('-' . ceil($days['config_value']) . " {$day_or_days}"); // 进一法取整

        $map = [
            'order_belong_store_id' => $store_id,
            'receipt_at <='         => $days,
            'order_comment_id'      => 0,
            'order_rate'            => 1,
            'order_type <>'         => 3,
        ];

        $count = $this->db
            ->where($map)
            ->get_total(get_table('order'));

        $orders = $this->db
            ->where($map)
            ->limit(0, $count)
            ->get(get_table('order'));

        /** @var OrderModel $order_model */
        $order_model = Factory::getFactory('order');

        if ($orders) {
            $this->db
                ->where($map)
                ->update(get_table('order'), ['order_rate' => 1, 'complete_at' => $_SERVER['REQUEST_TIME']]); // 更新订单状态为已完成

            foreach ($orders as $order) {

                if ($order['order_type'] == 1) { // 订单为下单服务时的自动评价操作
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
                        }
                    }
                }
                // 返还积分
                /** @var JifenModel $jifen_model */
                $jifen_model = Factory::getFactory('jifen');
                $jifen_model->restore($order['id']); // 执行积分返还

                $order_model->reward($order['order_sn']); // 上级获得回佣
            }
        }
        return true;
    }

    /**
     * 奖励订单，用于结算到推荐用户
     * @param string $order_sn 订单号
     */
    public function reward($order_sn)
    {
        $order_info = $this->db->get_row(get_table('order'), compact('order_sn'));
        if ($order_info) {

            $order_amount = $order_info['order_amount'] / 100; // 订单总金额，单位元

            $order_reduction    = $this->db->get_row(get_table('config'), ['config_key' => 'order_reduction'], 'config_value');
            $order_reward_level = $this->db->get_row(get_table('config'), ['config_key' => 'order_reward_level'], 'config_value');
            $first_class_rebate = $this->db->get_row(get_table('config'), ['config_key' => 'first_class_rebate'], 'config_value');

            if ($order_reward_level && $order_reduction && $first_class_rebate) {
                $first_class_rebate = $first_class_rebate['config_value'] / 100; // 一级返利占成,单位百分比
                $order_reward_level = $order_reward_level['config_value']; // 多少级可以获取返利
                $order_reduction    = $order_reduction['config_value'] / 100; // 返利级别的递减,单位百分比
            }

            $share_relationship = $this->db->get_row(get_table('share_relationship'), ['user_id' => $order_info['user_id']]); // 获取订单所属用户的层级关系描述
            if ($share_relationship && $share_relationship['relation_map']) {
                $relation_map         = explode('-', $share_relationship['relation_map']);
                $relation_map_reverse = array_merge(array_reverse($relation_map), []); // 反转数组，第一级在最前面; 合并一个空的数组是为了保证以0下标开始

                $reward_rows[$relation_map_reverse[0]] = [
                    'wallet_change' => sprintf('%.2f', $order_amount * $first_class_rebate) // 一级占成结果
                ];

                for ($i = 1; $i < $order_reward_level; $i++) {
                    if (\count($relation_map_reverse) >= $i) {
                        $reward_rows[$relation_map_reverse[$i]] = [
                            'wallet_change' => sprintf('%.2f', $order_amount * ($order_reduction / $i)),
                        ];
                    }
                }

                if ($reward_rows) {
                    foreach ($reward_rows as $user_id => $wallet_change) {
                        if ($_user_info = $this->db->get_row('user', ['user_id' => $user_id], 'user_balance')) {
                            $_wallet_change = sprintf('%.2f', $wallet_change['wallet_change'] + $_user_info['user_balance']);
                            $this->db->update('user', ['user_balance' => $_wallet_change], ['user_id' => $user_id]);
                        }
                    }
                }
            }
        }
    }

    /**
     * 结算订单
     * 1. 用户最高可获得订单金额90%的劳务报酬；
     * 2. 平台收取订单10%的管理费；
     * 3. 鸿鑫店铺获得3%的分成；
     * 4. 余下7%为平台的实际所得。
     * 以上数值需要在后台可设置调整，每个店铺的分成比例可能会不一样，这样，店铺的分成比例就需要单独设置在店铺管理中。
     *
     * 2018年9月20号改动：
     *   -- 多人加入服务后，结算是平均分配；
     *
     * @param string $order_sn 订单流水号
     * @return bool
     */
    public function orderSettlement($order_sn)
    {
        // 查询一次订单信息
        if ($order_info = $this->db->get_row(get_table('order'), compact('order_sn'))) {
            $order_amount = $order_info['order_amount']; // 订单总金额，单位分
            // 获取该订单所属的评论
            if (!$comment_info = $this->db->get_row(get_table('comment'), ['comment_order_sn' => $order_sn])) {
                throw new \RuntimeException('订单未评论，不能结算！');
            }
            $comment_average_score     = ceil($comment_info['comment_average_score']); // 当前订单的平均得分, 向上取证到整数
            $store_allocation_strategy = $this->db->get_row(get_table('store_settlement_setting'), ['store_id' => $order_info['order_belong_store_id']]); // 店铺设置的分配策略
            if (!$store_allocation_strategy) { // 店铺没有设置分配策略，则读取默认策略
                $default_config_map = [
                    'default_star_rated_return'  // 默认各星级对应的订单结算策略
                    , 'default_service_remuneration' // 默认服务员劳务报酬
                    , 'default_shop_division' // 默认店铺分成
                    , 'default_platform_actual_income' // 默认平台所得
                ];
                foreach ($default_config_map as $map) {
                    $_map                             = str_replace('default_', '', $map);
                    $config_value                     = $this->db->get_row(get_table('config'), ['config_key' => $map], 'config_value');
                    $store_allocation_strategy[$_map] = $config_value ? $config_value['config_value'] : false;
                }
            }
            // 处理星级对应的订单结算策略，组合成 星级 => 百分比 的数组形式
            $star_rated_return = explode('-', $store_allocation_strategy['star_rated_return']);
            // 先分配到服务员
            $assign_to_service = $order_amount * ($star_rated_return[(int)$comment_average_score] / 100); // 服务员分配 = 订单总金额 * 星级对饮百分比, 标记当前订单剩余可分配为A1
            if ($order_info['order_type'] == 1) {
                $service_info = $this->db->get_row(get_table('service'), ['id' => $order_info['order_type_id']], 'service_level_1');
                if ($service_info['service_level_1'] == 110) {
                    $star_rated_return[5] = 100; // 5星给100%
                    $fixed                = [4000 => 3000, 5000 => 3500, 6000 => 4000]; // 40块的服务人给30，50给35，60给40
                    $assign_to_service    = $fixed[$order_amount] * ($star_rated_return[(int)$comment_average_score] / 100);
                }
            }
            // 分配到店铺
            $assign_to_store = $order_amount * ($store_allocation_strategy['shop_division'] / 100); // 店铺分配 = 订单总金额 * 店铺设置的分配占成，标记当前订单设于可分配为A2
            // todo::剩余的分配到平台,先不入账，等通知。
            $assign_to_platform = $order_amount - $assign_to_service - $assign_to_store;

            // 执行分配写入
            $store_query_field = 'store_wallet, store_total_income, wallet_lock, id'; // 店铺表查询的字段
            // 分配到服务员账号
            $wallet_change = sprintf('%.4f', $assign_to_service / 100); // 服务人员总分配额度
            // 获取订单多少人完成
            $order_appointed_count = $this->db->get_total(get_table('order_appointed'), compact('order_sn'));
            // 订单分配人记录
            $order_appointed_users = $this->db->limit(0, $order_appointed_count)->get(get_table('order_appointed'), compact('order_sn'), 'appointed_uid');
            $deserves              = sprintf('%.2f', $wallet_change / $order_appointed_count); // 每人应得 = 总分配额度 / 总服务人数
            foreach ($order_appointed_users as $appointed_user) {
                $staff_store = $this->db->get_row(get_table('store'), ['user_id' => $appointed_user['appointed_uid']], $store_query_field);
                $this->db->update(get_table('store'), ['wallet_lock' => 1], ['id' => $staff_store['id']]); // 钱包上锁

                $service_update = [
                    'store_wallet'       => $staff_store['store_wallet'] + $deserves,  // 店铺钱包
                    'store_total_income' => $staff_store['store_total_income'] + $deserves, // 总收益
                    'wallet_lock'        => 0 // 解锁
                ]; // 写入数据

                $this->db->update(get_table('store'), $service_update, ['id' => $staff_store['id']]); // 执行写入
                $this->db->insert(get_table('store_wallet_log'), [
                    'store_id'        => $staff_store['id'],
                    'order_sn'        => $order_sn,
                    'wallet_change'   => $deserves,
                    'current_balance' => $service_update['store_wallet'],
                    'log_at'          => $_SERVER['REQUEST_TIME'],
                    'log_remark'      => '完成订单获得',
                ]); // 记录日志
            }
            unset($wallet_change);
            // 分配到店铺账号
            $wallet_change = sprintf('%.4f', $assign_to_store / 100);
            $staff_row     = $this->db->get_row(get_table('store_user'), ['user_id' => $order_info['appointed_uid']], 'store_id');
            $store_info    = $this->db->get_row(get_table('store'), ['id' => $staff_row['store_id']], $store_query_field); // 订单所属店铺信息
            $this->db->update(get_table('store'), ['wallet_lock' => 1], ['id' => $store_info['id']]); // 钱包上锁
            $store_update = [
                'store_wallet'       => $store_info['store_wallet'] + $wallet_change,
                'store_total_income' => $store_info['store_total_income'] + $wallet_change,
                'wallet_lock'        => 0 // 解锁
            ];
            $this->db->update(get_table('store'), $store_update, ['id' => $store_info['id']]);
            $this->db->insert(get_table('store_wallet_log'), [
                'store_id'        => $store_info['id'],
                'order_sn'        => $order_sn,
                'wallet_change'   => $wallet_change,
                'current_balance' => $store_update['store_wallet'],
                'log_at'          => $_SERVER['REQUEST_TIME'],
                'log_remark'      => '完成订单获得',
            ]);
            // todo::分配到平台
        }
        return true;
    }

    /**
     * 处理订单回佣，上一级获取佣金
     * @param string $order_sn 订单号
     * @return bool
     */
    public function orderReward($order_sn)
    {
        if (!$order_info = $this->db->get_row(get_table('order'), compact('order_sn'))) {
            throw new \RuntimeException('订单不存在');
        }
        if (!$comment_info = $this->db->get_total(get_table('comment'), ['comment_order_sn' => $order_sn])) {
            throw new \RuntimeException('订单未评论，不能结算！');
        }
        $lower_consumption_return = $this->db->get_row(get_table('config'), ['config_key' => 'lower_consumption_return'], 'config_value');
        if ($lower_consumption_return && $lower_consumption_return['config_value']) {
            // 回佣比例 百分比
            $lower_consumption_return = $lower_consumption_return['config_value'] / 100;

            $relationship = $this->db->get_row(get_table('share_relationship'), [
                'user_id' => $order_info['user_id'],
            ]);
            if ($relationship['parent_id']) {
                $parent_user_info = $this->db->get_row('user', ['user_id' => $relationship['parent_id']], 'user_balance');
                $order_amount     = sprintf('%.2f', $order_info['order_amount'] / 100); // 订单金额，单位元
                // 回佣后的金额总额 = 原有金额 + 订单总额 * 回佣比例
                $parent_user_update['user_balance'] = $parent_user_info['user_balance'] + $order_amount * $lower_consumption_return;
                $this->db->insert('userbalance', [
                    'ub_type'          => 1
                    , 'ub_money'       => $order_amount * $lower_consumption_return
                    , 'ub_balance'     => $parent_user_update['user_balance']
                    , 'ub_time'        => $_SERVER['REQUEST_TIME']
                    , 'ub_item'        => '下级消费获得回佣'
                    , 'user_id'        => $relationship['parent_id']
                    , 'ub_number'      => $order_info['order_sn']
                    , 'ub_description' => '下级消费获得回佣,当前回佣比例:' . $lower_consumption_return . '%',
                ]);
                $this->db->update('user', $parent_user_update, ['id' => $relationship['parent_id']]);
            }
        }
        return true;
    }

    /**
     * 订单退款
     * @param string $order_sn 订单流水号
     * @param bool $force 是否强制取消，为真时则不检测是否订单在服务前
     */
    public function orderRefund($order_sn, $force = false)
    {
        $order_info = $this->db->get_row(get_table('order'), compact('order_sn'));
        /** @noinspection TypeUnsafeComparisonInspection NotOptimalIfConditionsInspection */

        if (!$order_info) {
            throw new \RuntimeException('订单信息不存在');
        }

        if ($order_info['order_belong_store_id'] == 20) {
            $bis_state_dsc_arr = [
                'PENDING_ORDER',
                'PENDING_ASSIGN',
                'PENDING_DOOR',
            ];
            if (!$force && ($order_info['order_pay_state_dsc'] == 'PAY_SUCCESS' && \in_array($order_info['order_bis_state_dsc'], $bis_state_dsc_arr, false))) {
                throw new \RuntimeException('当前订单状态不允许退款！');
            }
        } else if (!$force && !\in_array($order_info['order_state'], [1, 2], false)) {
            throw new \RuntimeException('订单状态不正确');
        }

        if ($order_info['order_refund'] != 0) {
            throw new \RuntimeException('订单已退款，不能再次操作');
        }

        $user_info = $this->db->get_row('user', ['user_id' => $order_info['user_id']]);
        if ($order_info['order_deductible_type'] == 1) { // 订单使用了余额抵扣
            $balance_change         = sprintf('%.2f', ($order_info['order_deductible_count'] + $order_info['order_actual_amount']) / 100);
            $update['user_balance'] = $user_info['user_balance'] + $balance_change;
            $this->db->insert('userbalance', [
                'ub_type'          => 1
                , 'ub_money'       => $balance_change
                , 'ub_balance'     => $update['user_balance']
                , 'ub_time'        => $_SERVER['REQUEST_TIME']
                , 'ub_item'        => '退还金额'
                , 'user_id'        => $order_info['user_id']
                , 'ub_number'      => $order_info['order_sn']
                , 'ub_description' => '订单号' . $order_info['order_sn'] . '退还金额',
            ]);
        } elseif ($order_info['order_deductible_type'] == 2) { // 订单使用了积分抵扣
            $update['user_score']   = sprintf('%.2f', ($user_info['user_score'] * 100 + $order_info['order_deductible_count']) / 100);
            $update['user_balance'] = sprintf('%.2f', ($user_info['user_balance'] * 100 + $order_info['order_actual_amount']) / 100);
            $this->db->insert('userbalance', [
                'ub_type'          => 1
                , 'ub_money'       => sprintf('%.2f', $order_info['order_actual_amount'] / 100)
                , 'ub_balance'     => $update['user_balance']
                , 'ub_time'        => $_SERVER['REQUEST_TIME']
                , 'ub_item'        => '退还金额'
                , 'user_id'        => $order_info['user_id']
                , 'ub_number'      => $order_info['order_sn']
                , 'ub_description' => '订单号' . $order_info['order_sn'] . '退还金额',
            ]);
            $this->db->insert('points_log', [
                'user_id'          => $order_info['user_id']
                , 'user_name'      => $user_info['user_name']
                , 'pl_type'        => 1
                , 'pl_variation'   => sprintf('%.2f', $order_info['order_deductible_count'] / 100)
                , 'pl_score'       => $update['user_score']
                , 'pl_item'        => '退还积分'
                , 'pl_description' => '订单号' . $order_info['order_sn'] . '退还积分'
                , 'pl_time'        => $_SERVER['REQUEST_TIME']
                , 'pl_code'        => 4,
            ]);
        } else {
            $update['user_balance'] = sprintf('%.2f', ($user_info['user_balance'] * 100 + $order_info['order_actual_amount']) / 100);
            $this->db->insert('userbalance', [
                'ub_type'          => 1
                , 'ub_money'       => sprintf('%.2f', $order_info['order_actual_amount'] / 100)
                , 'ub_balance'     => $update['user_balance']
                , 'ub_time'        => $_SERVER['REQUEST_TIME']
                , 'ub_item'        => '退还金额'
                , 'user_id'        => $order_info['user_id']
                , 'ub_number'      => $order_info['order_sn']
                , 'ub_description' => '订单号' . $order_info['order_sn'] . '退还金额',
            ]);
        }
        $this->db->update('user', $update, ['user_id' => $order_info['user_id']]);
        $this->db->update(get_table('order'), [
            'order_refund'    => 1,
            'order_refund_at' => $_SERVER['REQUEST_TIME'],
        ], ['order_sn' => $order_sn]);

    }

    /**
     * 取消订单
     * @param string $order_sn 订单号
     * @param string $reject_reason 订单取消理由
     * @param integer $uid 订单原本指派的店员id
     */
    public function rejecteOrder($order_sn, $reject_reason, $uid)
    {
        if (!$order_info = $this->db->get_row(get_table('order'), ['order_sn' => $order_sn])) {
            throw new \RuntimeException('订单不存在');
        }

        $cancel_count = $this->db->get_total(get_table('order_cancel_log'), ['order_sn' => $order_sn]);

        $this->db->insert(get_table('order_log'), [
            'order_sn' => $order_sn
            , 'log_at' => $_SERVER['REQUEST_TIME']
            , 'log'    => '订单已被拒绝,已被拒接' . $cancel_count . '次'
            , 'uid'    => $uid,
        ]);

        $this->db->delete(get_table('order_appointed'), ['appointed_uid' => $uid, 'order_sn' => $order_sn]);
        $this->db->update(get_table('store_user'), ['current_order_sn' => 0], ['user_id' => $uid]); // 恢复店员的接手订单状态
        $this->db->insert(get_table('order_cancel_log'), [
            'order_sn'        => $order_sn,
            'cancel_assignor' => $uid,
        ]);
        $appointed_uid         = explode('-', $order_info['appointed_uid']);
        $appointed_uid_reverse = array_reverse($appointed_uid);
        unset($appointed_uid_reverse[$uid]);
        $appointed_uid = implode('-', array_reverse($appointed_uid_reverse));
        $this->db->update(get_table('order'), compact('appointed_uid'), compact('order_sn')); // 更新订单表的指派数据，反转2次数组并取消下表实现快速删除

        $this->cache('appointed.uid.lock.' . $uid, null);

        // +--------------------------------------------------------------------------------------
        // | 新的取消流程，指派给下一个有空的店员，如果没有有空店员或连续三次取消则停止, 2018-8-30
        // +--------------------------------------------------------------------------------------
        if (3 >= $cancel_count) {
            $this->autoAssignStaff($order_sn); // 执行一次自动分配
        }
    }

    /**
     * 格式化订单数据
     * @param array $order
     * @param bool $get_appointed 是否获取订单指派信息
     * @return array
     */
    public function formatOrderRow(array $order, $get_appointed = false)
    {
        $order = filter($order);

        $order['add_time'] = date('Y-m-d H:i', $order['add_time']); // 订单创建时间
        $order['pay_time'] = date('Y-m-d H:i', $order['pay_time']); // 订单支付时间
        $order['complete_at'] && $order['complete_at'] = date('Y-m-d H:i', $order['complete_at']); // 订单完成时间
        $order['contact_appointment_at'] = date('Y-m-d H:i', $order['contact_appointment_at']); // 订单预约时间
        $order['order_sm_at'] && $order['order_sm_at'] = date('Y-m-d H:i', $order['order_sm_at']); // 服务人员上门时间，也就是点开始服务的时间,当有上门时间时才会格式化

        $order['order_actual_amount']    = sprintf('%.2f', $order['order_actual_amount'] / 100); // 实际支付金额，单位元
        $order['order_amount']           = sprintf('%.2f', $order['order_amount'] / 100); // 订单总金额，单位元
        $order['order_deductible_count'] = sprintf('%.2f', $order['order_deductible_count'] / 100); // 订单抵扣金额，单位元

        // 这里不采用内置的htmlspecialchars_decode的原因是当字符串内含有非UTF8字符集时会导致转换失败
        $order['order_info'] = str_replace(['&amp;', '&quot;', '&#039;', '&lt;', '&gt;'], ['&', '"', "'", '<', '>'], $order['order_info']);

        $table_name = $order['order_type'] == 1 ? get_table('service') : get_table('demand');

        if (get_table('service') == $table_name) {
            if (!$order_pic = $this->cache('service.pic.' . $order['order_type_id'])) {
                $order_pic = $this->db->get_row($table_name, ['id' => $order['order_type_id']], 'service_img');
                $order_pic = $order_pic['service_img'];
                $this->cache('service.pic.' . $order['order_type_id'], $order_pic, 120);
            }
        } else {
            $order_pic = $this->db->get_row($table_name, ['id' => $order['order_type_id']], 'demand_img');
            $order_pic = $order_pic['demand_img'];
        }

        $order['order_pic'] = explode(',', $order_pic);
        $store_info         = $this->cache('_.order.cache.store.info.' . $order['order_belong_store_id']);
        if (!$store_info) {
            $store_info = $this->db->get_row(get_table('store'), ['id' => $order['order_belong_store_id']], 'store_phone');
            if ($store_info) {
                $store_info = serialize(filter($store_info));
                $this->cache('_.order.cache.store.info.' . $order['order_belong_store_id'], $store_info, 120);
            }
        }

        $order['store_info'] = unserialize($store_info);

        if (!$get_appointed) {
            return $order;
        }

        $order['appointed_row'] = []; // 返回指派的记录

        if ($order['appointed_uid']) {
            $appointed_uid = explode('-', $order['appointed_uid']);

            $query_appointed_uid = $cache_appointed_uid = [];
            $query_rows          = $cache_rows = [];

            foreach ($appointed_uid as $user_id) {
                if ($this->cache('appointed.user.info.' . $user_id)) {
                    $cache_appointed_uid[] = $user_id;
                } else {
                    $query_appointed_uid[] = $user_id;
                }
            }

            // 需要执行查询的数据
            if ($query_appointed_uid) {
                $query_rows = \count($query_appointed_uid) == 1
                    ? $this->_get_appointed_row($query_appointed_uid[0])
                    : $this->_get_appointed_row($query_appointed_uid);
            }

            // 从缓存中读取的数据
            if ($cache_appointed_uid) {
                $cache_rows = [];
                foreach ($cache_appointed_uid as $user_id) {
                    if ($row = $this->cache('appointed.user.info.' . $user_id)) {
                        $cache_rows[] = unserialize($row);
                    } else {
                        $cache_rows[] = $this->_get_appointed_row($user_id); // 避免redis中数据过期读不到数据
                    }
                }
            }

            $rows                   = array_merge($query_rows, $cache_rows);
            $rows                   = filter($rows);
            $rows                   = array_sort_by_key($rows, 'id', 'asc');
            $order['appointed_row'] = array_merge($rows, []);
        }

        $order['appointed_uid'] = (string)$order['appointed_uid'];

        return $order;
    }

    /**
     * 回去订单分配的用户资料
     * @param array|integer $id
     * @return array
     */
    private function _get_appointed_row($id)
    {
        $query = $this->db->select('b.user_pic, c.store_director, b.user_id')
            ->join([get_table('store') => 'c'], ['b.user_id' => 'c.user_id'], 'INNER');

        if (\is_array($id)) {
            $query = $query->limit(0, \count($id));
            foreach ($id as $ids) {
                $query->where_or(['b.user_id' => (int)$ids]);
            }
        } else {
            $query = $query->where(['b.user_id' => $id]);
        }

        $query_rows = $query->get(['user' => 'b']);

        if ($query_rows) {
            foreach ($query_rows as $row) {
                $this->cache('appointed.user.info.' . $row['user_id'], serialize($row), 3600);
            }
        }

        return $query_rows;
    }
}
