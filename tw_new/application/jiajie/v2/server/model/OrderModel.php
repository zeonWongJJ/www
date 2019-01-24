<?php
/**
 * 订单模型类，处理订单相关逻辑
 * @copyright 柒度信息科技有限公司
 * @version 2.0-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

use model\dao\StaffDAO;
use utils\Factory;

/**
 * Class OrderModel
 * @package model
 */
class OrderModel extends BaseModel
{
    const ORDER_USER_BUY_SERVER = 1; // 用户购买服务
    const ORDER_USRE_DEMAND = 2; // 用户支付需求
    const ORDER_USER_RECHANGE = 3; // 用户充值余额
    const ORDER_USER_SUBSCRIBE = 4; // 用户预约服务

    /**
     * @var array
     */
    private $contact = [];

    /**
     * @var array
     */
    private $deductible = [
        'type'  => 0, // 抵扣类型，1：余额 2：积分 0：无抵扣
        'count' => 0 // 抵扣金额，单位？
    ];

    /**
     * 统一下单；这一步执行的是订单的创建，返回创建后生成的订单号，以及需要支付的信息
     * @param $order_type
     * @param $order_belong_id
     * @param $order_pay_way
     * @param integer $order_amount 订单总金额
     * @return array
     */
    public function unifiedOrder($order_type, $order_belong_id, $order_pay_way, $order_amount): array
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
        $data['order_pay_state_dsc'] = 'PENDING_PAY'; // 默认订单支付状态为待付款
        $data['order_bis_state_dsc'] = 'SET_UP'; // 默认订单业务状态为拍下
        $data['order_pay_way']       = $order_pay_way; // 订单支付方式
        $data['order_amount']        = $order_amount; // 交易金额，单位分
        $data['add_time']            = $_SERVER['REQUEST_TIME']; // 订单下单时间
        $data['pay_time']            = 0; // 订单支付时间

        $data = array_merge($this->contact, $data); // 合并联系人

        // 抵扣
        $data['order_deductible_type']  = $this->deductible['type']; // 抵扣类型 1：余额 2：积分 0：无抵扣
        $_user_info                     = $this->db->get_row('user', ['user_id' => $user_info->user_id], 'user_score,user_balance');
        $data['order_deductible_count'] = 0;
        if ($data['order_deductible_type'] == 1) { // 处理余额抵扣
            $user_balance = $_user_info['user_balance'] * 100;
            if ($user_balance >= $order_amount) {
                $data['order_deductible_count'] = $order_amount;
            } else {
                $data['order_deductible_count'] = $user_balance;
            }
            // $update = sprintf('%.2f', ($user_balance - $data['order_deductible_count']) / 100);
        } else if ($data['order_deductible_type'] == 2) { // 处理积分抵扣
            $user_score = $_user_info['user_score'] * 100;
            if ($user_score >= $order_amount) {
                $data['order_deductible_count'] = $order_amount;
            } else {
                $data['order_deductible_count'] = $user_score;
            }
            // $update = sprintf('%.2f', ($user_score - $data['order_deductible_count']) / 100);
        }
        $data['order_actual_amount'] = $order_amount - $data['order_deductible_count']; // 实际支付金额

        $this->validate($data, [
            'order_sn' => 'required|length:32',
        ]);

        // 检查一次指向的类型ID是否存在
        switch ($data['order_type']) {
            // 下单需求
            case self::ORDER_USRE_DEMAND:
                $table_name         = get_table('demand');
                $has_one            = $this->db->get_row($table_name, ['id' => $data['order_type_id']]);
                $data['order_info'] = $has_one['demand_info'];
                $data['order_name'] = $has_one['subject_title'] ?: mb_substr($has_one['demand_info'], 0, 15);
                break;
            // 下单服务
            case self::ORDER_USER_BUY_SERVER:
                $table_name         = get_table('service');
                $has_one            = $this->db->get_row($table_name, ['id' => $data['order_type_id']]);
                $data['order_info'] = $has_one['service_info'];
                $data['order_name'] = $has_one['service_name'];
                break;
            // 充值余额
            case self::ORDER_USER_RECHANGE:
                $table_name         = get_table('recharge');
                $has_one            = $this->db->get_row($table_name, ['id' => $data['order_type_id']]);
                $data['order_info'] = $data['order_name'] = '用户编号' . $has_one['user_id'] . '充值';
                $data['order_name'] = $data['order_info'];
                break;
            case self::ORDER_USER_SUBSCRIBE:
                $table_name         = get_table('subscribe');
                $has_one            = $this->db
                    ->select('b.*, a.cat_name', false)
                    ->join([get_table('category') => 'a'], ['a.id' => 'b.cate_id'])
                    ->get_row([$table_name => 'b'], ['b.id' => $data['order_type_id']]);
                $data['order_name'] = $data['order_info'] = '预约服务[' . $has_one['cat_name'] . ']';
                break;
            default:
                $has_one = $table_name = false;
        }

        if (false === $table_name) {
            return $this->error('支付适配器未定义');
        }
        if (!$insert_id = $this->db->insert(get_table('order'), $data)) {
            return $this->error('订单创建失败' . $this->db->get_error());
        }
        $this->db->set_error_mode();

        // 组装返回的信息
        $micro  = sprintf('%.0f', microtime(true));
        $return = [
            'order_sn' => $micro . str_pad($insert_id, 13, '0', STR_PAD_LEFT), // 订单流水号
        ];

        $this->db->update(get_table('order'), ['order_sn' => $return['order_sn']], ['id' => $insert_id]); // 更新订单流水号

        if ($has_one) {
            // 写入订单关联
            $this->db->insert(get_table('order_info'), [
                'order_sn'   => $return['order_sn'],
                'order_info' => json_encode(filter($has_one)),
            ]);
        }

        $return['order_sign']             = md5(implode('-', [$return['order_sn'], $data['order_type'], $data['order_type_id']]));
        $return['order_deductible_count'] = $data['order_deductible_count'];
        return $return; // 返回订单信息
    }

    /**
     * @remark      支付订单
     * @description 这一步执行的是订单的支付，返回订单的支付信息
     *              订单签名算法：MD5(explode('-', [$order_sn, $order_type, $order_type_id]))
     * @param string $order_sn 订单流水号
     * @param string $order_sign 订单签名
     * @param array $server_url 业务转跳路由
     * @return mixed
     */
    public function payOrder($order_sn, $order_sign, ...$server_url)
    {
        $map['order_sn'] = $order_sn;
        $order           = $this->db->get_row(get_table('order'), $map);
        if ($order) {
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

                // $this->db->update(get_table('order'), ['order_pay_state_dsc' => 'PAYING'], ['order_sn' => $order_sn]); // 标记订单支付处理中

                list($success_url, $error_url) = $server_url;
                $success_url = urldecode($success_url);
                $error_url   = urldecode($error_url);

                $order_pay_info = $this->db->get_total(get_table('order_pay_info'), compact('order_sn'));
                if (!$order_pay_info) {
                    $this->db->insert(get_table('order_pay_info'), compact('order_sn', 'success_url', 'error_url'));
                } else {
                    $this->db->update(get_table('order_pay_info'), compact('success_url', 'error_url'), compact('order_sn'));
                }

//                    $table_name = (int)$order['order_type'] === self::ORDER_USRE_DEMAND ? get_table('demand') : get_table('service');
//                    $row        = $this->db->get_row($table_name, ['id' => $order['order_type_id']]);
                // 4. 检查该服务或者需求是否与订单流水号对应
//                    if ($row['order_sn'] === $order_sn) {
                //5. 更改订单交易状态
//                $this->db->update(get_table('order'), ['order_paying' => 1], $map); // 更改订单状态为交易中
                // 如果传递了修改支付方式
                $data['order_pay_way'] = $this->request->get('order_pay_way', '', 'trim');
                if ($data['order_pay_way'] || $data['order_pay_way'] == $order['order_pay_way']) {
                    if (!\in_array($data['order_pay_way'], ['alipay', 'wechat', 'bankcard'], false)) {
                        unset($data['order_pay_way']);
                    }
                }
                $data['order_deductible_type'] = $this->request->get('order_deductible_type', $order['order_deductible_type'], 'intval');
                if ($data['order_deductible_type'] == $order['order_deductible_type'] || !\in_array($data['order_deductible_type'], [0, 1, 2], false)) {
                    unset($data['order_deductible_type']);
                } else {
                    $this->setContact($order['telephone'], $order['address_name'], $order['house_number'], $order['contact_name'])
                        ->coumpteDeductible($data['order_deductible_type'], $order['user_id'])
                        ->reOrder($order_sn);
                }
                if ($data['order_pay_way']) {
                    $this->db->update(get_table('order'), ['order_pay_way' => $data['order_pay_way']], $map);
                    $order['order_pay_way'] = $data['order_pay_way'];
                }
                $row['subject_title'] = $row['subject_title'] ?: '帮家洁订单' . $order_sn;
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
                        header('location: ' . getenv('SERVER_DOMAIN') . "/order.pay.ret-deductible?out_trade_no={$order_sn}");
                        exit(200);
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
     * @param string $order_sn 订单编号
     * @return mixed
     */
    public function reOrder($order_sn)
    {
        if (!$this->contact) {
            return $this->error('未设置下单人信息');
        }

        $order_info = $this->db->get_row(get_table('order'), compact('order_sn'));
        $user_id    = $order_info['user_id'];

        $order_amount = $order_info['order_amount'];

        // 抵扣
        $data['order_deductible_type']  = $this->deductible['type']; // 抵扣类型 1：余额 2：积分 0：无抵扣
        $_user_info                     = $this->db->get_row('user', ['user_id' => $user_id], 'user_score,user_balance');
        $data['order_deductible_count'] = 0;
        if ($data['order_deductible_type'] == 1) { // 处理余额抵扣
            $user_balance = $_user_info['user_balance'] * 100;
            if ($user_balance >= $order_amount) {
                $data['order_deductible_count'] = $order_amount;
            } else {
                $data['order_deductible_count'] = $user_balance;
            }
        } else if ($data['order_deductible_type'] == 2) { // 处理积分抵扣
            $user_score = $_user_info['user_score'] * 100;
            if ($user_score >= $order_amount) {
                $data['order_deductible_count'] = $order_amount;
            } else {
                $data['order_deductible_count'] = $user_score;
            }
        }
        $data['order_actual_amount'] = $order_amount - $data['order_deductible_count']; // 实际支付金额
        $this->db->update(get_table('order'), $data, compact('order_sn')); // 更新表

        $order_sign     = $this->request->get('order_sign', '', 'trim');
        $order_sn       = $this->request->get('order_sn', '', 'trim');
        $order_pay_way  = $this->request->get('order_pay_way', '', 'trim');
        $order_pay_info = $this->db->get_row(get_table('order_pay_info'), ['order_sn' => $order_sn]);
        $url            = <<<EOF
/order.pay?order_sign={$order_sign}&order_sn={$order_sn}&success_url={$order_pay_info['success_url']}&errorUrl={$order_pay_info['error_url']}&order_pay_way={$order_pay_way}
EOF;
        ToolModel::location(getenv('SERVER_DOMAIN') . $url);
    }

    /**
     * 计算抵扣
     * @param $deductible_type
     * @return $this|mixed
     */
    public function coumpteDeductible($deductible_type, $user_id = '')
    {
        if (!$user_id) {
            $user_info = app('user_info');
            if (!$user_info || !isset($user_info->user_id)) {
                return $this->error('user-info-error');
            }
            $user_id = $user_info->user_id;
        }
        $map['user_id'] = $user_id;

        if ($deductible_type == 0) { // 无抵扣
            $this->deductible['count'] = 0;
            $this->deductible['type']  = 0;
        } else if ($deductible_type == 1) { // 抵扣余额
            $this->deductible['type'] = $deductible_type;
        } else if ($deductible_type == 2) { // 抵扣积分
            $this->deductible['type'] = $deductible_type;
        } else {
            return $this->error('抵扣类型不支持!');
        }

        return $this;
    }

    /**
     * 设置订单联系人
     * @param $telephone
     * @param $address_name
     * @param $house_number
     * @param $contact_name
     * @return $this
     */
    public function setContact($telephone, $address_name, $house_number, $contact_name): self
    {
        $this->contact['telephone']    = $telephone;
        $this->contact['address_name'] = $address_name;
        $this->contact['house_number'] = $house_number;
        $this->contact['contact_name'] = $contact_name;

        return $this;
    }

    /**
     * @remark 完成支付订单的后续操作；这一步执行的是订单的最终状态写入
     * @param string $out_trade_no 提交订单的自定义订单号，也就是订单编号
     * @return mixed
     * @throws \Exception
     */
    public function orderCallBack($out_trade_no)
    {
        $order = $this->db
            ->select('b.*, a.error_url, a.success_url', false)
            ->join([get_table('order_pay_info') => 'a'], ['a.order_sn' => 'b.order_sn'], 'INNER')
            ->get_row([get_table('order') => 'b'], ['b.order_sn' => $out_trade_no]);
        if (!$order) {
            throw new \RuntimeException('没有匹配的订单');
        }

        if ($order['order_is_pay'] == 1) {
            $this->response->header('location', urldecode($order['success_url']));
        }
        if (!$user_info = $this->db->get_row('user', ['user_id' => $order['user_id']])) {
            throw new \RuntimeException('订单查询不到用户');
        }
        // 充值后,更新用户余额
        if ($order['order_type'] == 3) {
            $this->db->update(get_table('recharge'), ['recharge_status' => 2], ['id' => $order['order_type_id']]);
            $_update['user_balance'] = sprintf('%.2f', $order['order_amount'] / 100);
            $result                  = $this->db->set('user_balance', "user_balance + {$_update['user_balance']}", false)
                ->update('user', null, ['user_id' => $order['user_id']]);
            if (!$result) {
                throw new \RuntimeException('冲入用户余额失败!');
            }

            UserModel::userBalanceLog(
                sprintf('%.2f', $order['order_amount'] / 100),
                UserModel::getCapitalChangeTerms(7, [self::getPayWay($order['order_pay_way']), sprintf('%.2f', $order['order_amount'] / 100)]),
                1,
                $order['order_sn'],
                $order['user_id']
            );
        }
        // 支付成功后更新表
        $this->db->update(get_table('order'), [
            'order_is_pay'        => 1,  // 订单更新为已支付
            'pay_time'            => $_SERVER['REQUEST_TIME'],
            'order_state'         => 1, // 订单状态为待确认
            'order_pay_state_dsc' => 'PAY_SUCCESS' // 支付成功
        ], ['order_sn' => $out_trade_no]);
        OrderModel::orderLogger($out_trade_no, $order['user_id'], '成功支付订单');
        if ($order['order_type'] != 3) {
            // 订单使用了积分抵扣
            if ($order['order_deductible_type'] == 2) {
                $wallet_change = sprintf('%.2f', $order['order_deductible_count'] / 100);
                $this->db->set('user_score', "user_score + {$wallet_change}", false)
                    ->update('user', null, ['user_id' => $user_info['user_name']]);
                $this->db->insert('points_log', [
                    'user_id'        => $user_info['user_id'],
                    'user_name'      => $user_info['user_name'],
                    'pl_type'        => 2,
                    'pl_variation'   => $wallet_change,
                    'pl_score'       => $this->db->get_row('user', ['user_id' => $user_info['user_id']], 'user_score')['user_score'],
                    'pl_item'        => '订单抵扣',
                    'pl_description' => '订单' . $order['order_sn'] . '支付时使用抵扣',
                    'pl_time'        => $_SERVER['REQUEST_TIME'],
                    'pl_code'        => 4
                ]);
            } elseif ($order['order_deductible_type'] == 1) {
                // 订单使用了余额抵扣
                $wallet_change = sprintf('%.2f', $order['order_deductible_count'] / 100);
                $this->db->set('user_balance', "user_balance + {$wallet_change}", false)
                    ->update('user', null, ['user_id' => $user_info['user_name']]);
                UserModel::userBalanceLog(
                    sprintf('%.2f', $order['order_amount'] / 100),
                    UserModel::getCapitalChangeTerms($order['order_type'] == 1 ? 0 : 8, [$order['order_name'], $wallet_change]),
                    2,
                    $order['order_sn'],
                    $order['user_id']
                );
            } else {
                // 无抵扣
                UserModel::userBalanceLog(
                    sprintf('%.2f', $order['order_amount'] / 100),
                    UserModel::getCapitalChangeTerms($order['order_type'] == 1 ? 0 : 8, [$order['order_name'], sprintf('%.2f', $order['order_amount'] / 100)]),
                    2,
                    $order['order_sn'],
                    $order['user_id']
                );
            }
        }

        $order['order_type'] == 1 && $this->afterPayService($order); // 为下单服务的时候，执行支付后操作
    }

    /**
     * 获取支付类型
     * @param $order_pay_way
     * @return mixed|string
     */
    public static function getPayWay($order_pay_way)
    {
        if (\is_array($order_pay_way)) {
            $order_pay_way = $order_pay_way['order_pay_way'];
        }
        $map = [
            'alipay'   => '支付宝',
            'wechat'   => '微信支付',
            'bankcard' => '银联支付',
        ];
        return $map[$order_pay_way] ?? '微信支付';
    }

    /**
     * 日志记录
     * @param string $order_sn 订单流水号
     * @param int $uid 用户id
     * @param string $log 日志记录内容
     * @param string $action_user_type 用户类型 USER-普通用户 SERVER-服务人员 ADMIN-管理员
     */
    public static function orderLogger($order_sn, $uid, $log, $action_user_type = 'USER')
    {
        $order_sub_sn = 0;
        if (strpos($order_sn, '-') > -1) {
            list($order_sn, $order_sub_sn) = explode('-', $order_sn);
        }
        (new static)->db->insert(get_table('order_log'), array_merge(
            compact('order_sn', 'uid', 'log', 'action_user_type', 'order_sub_sn'),
            ['log_at' => $_SERVER['REQUEST_TIME']]
        ));
    }

    /**
     * 支付下单服务后调用,主要用于判断是否需要自动分配订单
     * @param array $order_info 订单记录
     * @return bool
     * @throws \Exception
     */
    public function afterPayService(array $order_info)
    {
        /** @var MessageModel $message_model */
        $message_model = Factory::getFactory('message');
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
        $message_send_order_service = str_replace('#demand_name#', $service['service_name'], $temp);
        // +-----------------------------------------------------------------------------------------------
        // | 自动接单+自动分配
        // +-----------------------------------------------------------------------------------------------
        if (1 == $store_info['store_auto_receipt']) {
            $this->db->update(get_table('order'), [
                'order_state'         => 2, // 不管有没有分配到店员，都先把订单状态搞成已接单
                'order_bis_state_dsc' => 'PENDING_ASSIGN' // 待分配
            ], ['order_sn' => $order_info['order_sn']]);
            $user_id = $this->autoAssignStaff($order_info['order_sn']); // 执行自动分配
            if ($user_id) {
                $staff_row   = $this->db->get_row(get_table('store_user'), ['user_id' => $user_id], 'staff_name');
                $_order_info = $this->db
                    ->select('b.store_director, b.store_phone, a.appointed_uid')
                    ->join([get_table('store') => 'b'], ['a.appointed_uid' => 'b.user_id'])
                    ->get_row([get_table('order') => 'a'], ['a.order_sn' => $order_info['order_sn']]);
                // 判断是否有子订单
                $order_total = $this->db->get_total(get_table('order'), ['order_sn' => $order_info['order_sn']]);
                if ($order_total > 1) {
                    $where            = [
                        'is_sys_order' => 0,
                        'order_sn'     => $order_info['order_sn'],
                        'id <>'        => $order_info['id']
                    ];
                    $children_count   = $this->db->get_total(get_table('order'), $where);
                    $children_orders  = $this->db->limit(0, $children_count)->get(get_table('order'), $where);
                    $insert_appointed = [];
                    foreach ($children_orders as $order) {
                        $insert_appointed[] = [
                            'order_sn'      => $order['order_sn'],
                            'order_sub_id'  => $order['order_sub_sn'],
                            'appointed_uid' => $user_id,
                            'appointed_at'  => $_SERVER['REQUEST_TIME'],
                            'store_id' => $order['order_belong_store_id'],
                            'order_begin_at'    =>  $order['contact_appointment_at'],
                            'order_end_at' => $order['contact_appointment_at'] + $order['service_length'] * 3600
                        ];
                    }
                    $this->db->inserts(get_table('order_appointed'), $insert_appointed);
                }
                $message_model->notifyUser($user_id, '您已被指派到订单，请点击查看')->appPush(0, '', [
                    'url'   =>  trim(getenv('TOUCH_DOMAIN'), '/') . '/#/store_orders_x?staff_id=' . $user_id
                ]);
                OrderModel::orderLogger($order_info['order_sn'], 0, "自动分配订单成功，分配到服务人员{$staff_row['staff_name']}", 'SYSTEM');
                // 执行通知店铺管理人员
                if ($_order_info['store_phone']) {
                    // 预约服务时间前10小时、30分钟前发送一次短信通知指派人员
                    $msn_info = '您被指派的订单[' . $order_info['order_sn'] . ']预约将在' . date('Y-m-d H:i', $order_info['contact_appointment_at']) . '开始服务，请留意订单详情!';
                    // 如果预约时间距离现在小于10小时，则预约服务前30分钟通知一次指派人员
                    if ($order_info['contact_appointment_at'] <= $_SERVER['REQUEST_TIME'] + 36000) {
                        $delay = $order_info['contact_appointment_at'] - 36000;
                        $message_model->asyncSend($_order_info['store_phone'], $delay, $msn_info);
                    }
                    $message_model->asyncSend($_order_info['store_phone'], $order_info['contact_appointment_at'] - 1800, $msn_info);
                }
            }
        }
        if ($store_info['store_phone']) {
            $message_model->sendMsm($store_info['store_phone'], $message_send_order_service);
        }
    }

    /**
     * 自动指派订单到服务人员
     * @param string $order_sn 指派订单
     * @param int $order_sub_sn
     * @return bool|integer 指派成功返回被指派的用户id，失败返回false
     */
    public function autoAssignStaff($order_sn, $order_sub_sn = 0)
    {
        /** @var StoreModel $store_model */
        $store_model = Factory::getFactory('store');
        $order_info  = $this->getOrderInfo($order_sn, true, $order_sub_sn);

        $cancel_assignor      = []; // 被拒绝过的店员
        $unassigned_user_rows = []; // 可分配的店员数组

        $rejected = $this->db->get(get_table('order_cancel_log'), ['order_sn' => $order_sn], 'cancel_assignor');
        foreach ($rejected as $item) {
            $cancel_assignor[] = $item['cancel_assignor'];
        }
        $cancel_assignor = array_merge($cancel_assignor, [1]); // 把勇哥变成拒接的这样就不用指派给他了
        unset($rejected);

        // 订单未完全 && 字段所属店铺不为空时作分配
        if ($order_info['order_rate'] == 0 && $order_info['order_belong_store_id'] != 0) {

            $store_admin_has_receipt_permission = $store_model->storeAdminReceiptPermission(); // 获取管理员是否有接手权限
            $parent_store_info                  = $store_model->getStoreInfo($order_info['order_belong_store_id'], true); // 获取订单所属的店铺信息
            $all_staffs                         = $parent_store_info['staff_list']; // 店铺下的所有店员（包括管理员）
            list($all_staffs, $can_assign_staff) = $store_model->getCanAssignStaff($order_sn, $order_sub_sn, $all_staffs);
            $can_assign_staff_row = [];
            foreach ($can_assign_staff as $uid) {
                $can_assign_staff_row[$uid] = $all_staffs[$uid] ?? [];
            }
            foreach ($can_assign_staff_row as $uid => $staff) {
                // 管理员没有接手权限时，把管理员剔除
                if (!$store_admin_has_receipt_permission && $staff['user_type'] == 2) {
                    continue;
                }
                if (!$staff['staff_current_order_sn']) {
                    if (\in_array($uid, $cancel_assignor, false)) {
                        continue;
                    }

                    // 计算距离
                    $staff['_distance']                      = get_distance($order_info['order_lat'], $order_info['order_lng'], $staff['store_user_lat'], $staff['store_user_lng']);
                    $unassigned_user_rows[$staff['user_id']] = $staff;
                }
            }

            if ($unassigned_user_rows) {
                $unassigned_user_rows = array_sort_by_key($unassigned_user_rows, '_distance', 'asc'); // 按照计算出来的距离排序数组
                $assign_row           = array_shift($unassigned_user_rows); //不能[0]取第一条，因为id已经被打乱了
                $rend_staff           = $assign_row['user_id'];
                $this->db->update(get_table('order'), [
                    'appointed_uid'       => $rend_staff, // 适配新的分配方案
                    'order_state'         => 2,
                    'order_bis_state_dsc' => 'PENDING_DOOR' // 分配成功，状态更改为待上门
                ], ['order_sn' => $order_sn]);
                $this->db->insert(get_table('order_appointed'), [
                    'order_sn'      => $order_sn,
                    'appointed_uid' => $rend_staff,
                    'appointed_at'  => $_SERVER['REQUEST_TIME'],
                    'appointer_id'  => 0,
                    'completed'     => 0
                ]);
                // 店员服务总数+1
                $staff_id = $this->db->get_row(get_table('store_user'), ['user_id' => $rend_staff], 'id');
                $this->db
                    ->set('staff_all_services', 'staff_all_services + 1', false)
                    ->update(get_table('store_staff_info'), null, ['staff_id' => $staff_id['id']]);
                return $rend_staff;
            }
        }
        return false;
    }

    /**
     * 通过订单号获取订单信息
     * @param string $order_sn 订单流水号
     * @param bool $is_refresh 是否强制获取数据
     * @param int $order_sub_sn
     * @return array|bool
     */
    public function getOrderInfo($order_sn, $is_refresh = false, $order_sub_sn = 0)
    {
        $cache_key  = 'order.info.' . $order_sn;
        $order_info = $this->cache($cache_key);
        if ($is_refresh || !$order_info) {
            $order_info = $this->db->get_row(get_table('order'), compact('order_sn', 'order_sub_sn'));
            if ($order_info) {
                $order_info = json_encode($order_info);
                $this->cache($cache_key, $order_info, 1800);
            }
        }
        return json_decode($order_info, true);
    }

    /**
     * 通过首单流水号获取最后一期订单数据
     * @param string $first_order_sn 首单订单号
     * @return array|bool
     */
    public function getLastPeriodOrderByFirstOrder($first_order_sn)
    {
        $last_period_order_sn   = $this->db->order_by(['id' => 'desc'])->get_row(get_table('order_periods'), ['first_order_sn' => $first_order_sn]);
        $last_period_order_info = $this->getOrderInfo($last_period_order_sn['current_order_sn']); // 获取最后一期的订单信息

        $last_period_order_info['order_periods'] = $last_period_order_sn;
        return $last_period_order_info;
    }

    /**
     * @param string $order_sn 订单流水号
     * @return bool
     */
    public function orderDelete($order_sn)
    {
        $order_info = $this->db->get_row(get_table('order'), compact('order_sn'));
        if (\in_array($order_info['order_bis_state_dsc'], ['CLOSED', 'COMPLETED'])) {
            $this->db->set('order_user_del', '1')->update(get_table('order'), null, compact('order_sn'));
            $this->db->commit();
            return $this->success(false);
        }
    }

    /**
     * 判断流水号是否存在
     * @param $order_sn
     * @param $order_sub_sn
     * @return array|mixed
     */
    public function checkSnHas($order_sn, $order_sub_sn = 0)
    {
        $order_info = $this->db->get_row(get_table('order'), compact('order_sn', 'order_sub_sn'));
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
    public function reward($order_sn, $order_sub_sn = 0)
    {
        $order_info = $this->db->get_row(get_table('order'), compact('order_sn', 'order_sub_sn'));
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
     * @param int $order_sub_sn 订单子编号
     * @param string $assign_to_wallet 分配到钱包类型，默认分配到用户钱包，这里是防止以后又改需求
     * @return bool
     */
    public function orderSettlement($order_sn, $order_sub_sn = 0, $assign_to_wallet = 'user')
    {
        // 查询一次订单信息
        if ($order_info = $this->db->get_row(get_table('order'), compact('order_sn', 'order_sub_sn'))) {
            $added_order_amount = 0;
            if ($order_info['order_added_sn']) {
                // 如果有补费订单
                $order_added = $this->db->get_row(get_table('order'), ['order_sn' => $order_info['order_added_sn'], 'order_sub_sn' => 0], 'order_pay_state_dsc, order_amount');
                if ($order_added['order_pay_state_dsc'] !== 'PAY_SUCCESS') {
                    throw new \RuntimeException('补费订单的支付状态不正确，不能执行结算');
                }
                $added_order_amount = $order_added['order_amount'];
            }
            //$this->db->begin();
            $this->db->set_error_mode();
            try {
                $order_amount = $order_info['order_amount'] + $added_order_amount; // 订单总金额，单位分
                // 获取该订单所属的评论
                if (!$comment_info = $this->db->get_row(get_table('comment'), [
                    'comment_order_sn'     => $order_sn,
                    'comment_order_sub_sn' => $order_sub_sn
                ])) {
                    throw new \RuntimeException('用户未评价订单');
                }
                $comment_average_score     = ceil($comment_info['comment_average_score']); // 当前订单的平均得分, 向上取证到整数
                $store_allocation_strategy = $this->db->get_row(get_table('store_settlement_setting'), ['store_id' => $order_info['order_belong_store_id']]); // 店铺设置的分配策略
                if (!$store_allocation_strategy) { // 店铺没有设置分配策略，则读取默认策略
                    $default_config_map = [
                        'default_star_rated_return',  // 默认各星级对应的订单结算策略
                        'default_service_remuneration', // 默认服务员劳务报酬
                        'default_shop_division', // 默认店铺分成
                        'default_platform_actual_income' // 默认平台所得
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
//                if ($order_info['order_type'] == 1) {
//                    $service_info = $this->db->get_row(get_table('service'), ['id' => $order_info['order_type_id']], 'service_level_1');
//                    if ($service_info['service_level_1'] == 110) {
//                        $star_rated_return[5] = 100; // 5星给100%
//                        $fixed                = [4000 => 3000, 5000 => 3500, 6000 => 4000]; // 40块的服务人给30，50给35，60给40
//                        $assign_to_service    = $fixed[$order_amount] * ($star_rated_return[(int)$comment_average_score] / 100);
//                    }
//                }
                // 分配到店铺
                $assign_to_store = $order_amount * ($store_allocation_strategy['shop_division'] / 100); // 店铺分配 = 订单总金额 * 店铺设置的分配占成，标记当前订单设于可分配为A2
                // 剩余的分配到平台
//            $assign_to_platform = $order_amount - $assign_to_service - $assign_to_store;

                // 分配到服务员账号
                $wallet_change = sprintf('%.2f', $assign_to_service / 100); // 服务人员总分配额度
                // 获取订单多少人完成
                $order_appointed_count = $this->db->get_total(get_table('order_appointed'), array_merge(compact('order_sn'), ['order_sub_id' => $order_sub_sn]));
                // 订单分配人记录
                $order_appointed_users = $this->db
                    ->limit(0, $order_appointed_count)
                    ->get(get_table('order_appointed'), array_merge(compact('order_sn'), ['order_sub_id' => $order_sub_sn]), 'appointed_uid');
                $deserves_fen          = $wallet_change / $order_appointed_count; // 每人应得 = 总分配额度 / 总服务人数
                $deserves              = sprintf('%.2f', $deserves_fen / 100);
                foreach ($order_appointed_users as $appointed_user) {
                    $staff_store = true; /*$this->db
                        ->join([get_table('staff_wallet') => 'b'], ['a.id' => 'b.staff_id'], 'INNER')
                        ->get_row([get_table('store_user') => 'a'], ['a.user_id' => $appointed_user['appointed_uid']], 'a.store_id, b.balance');*/
                    if ($staff_store) {
                        $log_desc = UserModel::getCapitalChangeTerms(1, [$order_info['order_name'], $deserves]);
                        if ($assign_to_wallet == 'user') {
                            $this->db
                                ->set('user_balance', "user_balance + {$deserves}", false)
                                ->update('user', null, ['user_id' => $appointed_user['appointed_uid']]);
                            $this->db
                                ->set('balance', "balance + {$deserves_fen}", false)
                                ->set('total_income', "total_income + {$deserves_fen}", false)
                                ->update(get_table('staff_wallet'), null, ['user_id' => $appointed_user['appointed_uid']]);
                            UserModel::userBalanceLog(
                                $deserves,
                                $log_desc,
                                1,
                                "{$order_sn}:{$order_sub_sn}",
                                $appointed_user['appointed_uid'],
                                1
                            );
                        } else {
                            $this->db
                                ->set('balance', "balance + {$deserves_fen}", false)
                                ->set('total_income', "total_income + {$deserves_fen}", false)
                                ->update(get_table('staff_wallet'), null, ['user_id' => $appointed_user['appointed_uid']]);
                            $this->db->insert(get_table('store_wallet_log'), [
                                'store_id'        => $order_info['order_belong_store_id'],
                                'order_sn'        => $order_sn,
                                'order_sub_sn'    => $order_sub_sn,
                                'wallet_change'   => $deserves,
                                'current_balance' => $staff_store['balance'] + $deserves,
                                'log_at'          => $_SERVER['REQUEST_TIME'],
                                'log_remark'      => $log_desc,
                            ]); // 记录日志
                        }
                    }
                }
                unset($wallet_change);
                // 分配到店铺账号
                $wallet_change = sprintf('%.2f', $assign_to_store / 100);
                /** @var \PDOStatement $pdo_state */
//                $pdo_state  = $this->db->query(StoreDAO::getStoreWithWallet($order_info['order_belong_store_id'], true));
//                $store_info = $pdo_state ? $pdo_state->fetch(\PDO::FETCH_ASSOC) : false;
//                $store_info = $this->db
//                    ->join([get_table('order') => 'b'], ['a.order_belong_store_id' => 'a.id'], 'INNER')
//                    ->get_row([get_table('store') => 'a'], ['b.order_sn' => $order_info['order_sn'], 'b.order_sub_sn' => $order_info['order_sub_sn']]);
                $store_info = $this->db->get_row(get_table('store'), ['id' => $order_info['order_belong_store_id']]);
                if ($store_info) {
                    if ($assign_to_wallet == 'user') {
                        $this->db->set('user_balance', "user_balance + {$wallet_change}", false)
                            ->update('user', null, ['user_id' => $store_info['user_id']]);
                        $this->db
                            ->set('balance', "balance + $assign_to_store", false)
                            ->set('total_income', "total_income + $assign_to_store", false)
                            ->update(get_table('staff_wallet'), null, [
                                'store_id' => $order_info['order_belong_store_id'],
                                'user_id'  => $store_info['user_id']
                            ]);
                        UserModel::userBalanceLog(
                            $wallet_change,
                            UserModel::getCapitalChangeTerms(1, [$order_info['order_name'], $wallet_change]),
                            1,
                            "{$order_sn}:{$order_sub_sn}",
                            $store_info['user_id']
                        );
                    } else {
                        $this->db
                            ->set('balance', "balance + $assign_to_store", false)
                            ->set('total_income', "total_income + $assign_to_store", false)
                            ->update(get_table('staff_wallet'), null, [
                                'store_id' => $order_info['order_belong_store_id'],
                                'user_id'  => $store_info['user_id']
                            ]);
                        $this->db->insert(get_table('store_wallet_log'), [
                            'store_id'        => $order_info['order_belong_store_id'],
                            'order_sn'        => $order_sn,
                            'order_sub_sn'    => $order_sub_sn,
                            'wallet_change'   => $wallet_change,
                            'current_balance' => $store_info['balance'] + $wallet_change,
                            'log_at'          => $_SERVER['REQUEST_TIME'],
                            'log_remark'      => '订单完成后分配收入',
                        ]);
                    }
                }
                // 剩余分配到平台
                //$this->db->commit();
            } catch (\Exception $e) {
                //$this->db->roll_back();
                return false;
            }
        }
        return true;
    }

    /**
     * 处理订单回佣，上一级获取佣金
     * @param string $order_sn 订单号
     * @return bool
     */
    public function orderReward($order_sn): bool
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
                $this->db
                    ->set('user_balance', "user_balance + {$parent_user_update['user_balance']}")
                    ->update('user', null, ['id' => $relationship['parent_id']]);
                $this->db->insert('userbalance', [
                    'ub_type'        => 1,
                    'ub_money'       => $order_amount * $lower_consumption_return,
                    'ub_balance'     => $parent_user_update['user_balance'],
                    'ub_time'        => $_SERVER['REQUEST_TIME'],
                    'ub_item'        => '下级消费获得回佣',
                    'user_id'        => $relationship['parent_id'],
                    'ub_number'      => $order_info['order_sn'],
                    'ub_description' => '下级消费获得回佣,当前回佣比例:' . $lower_consumption_return . '%',
                ]);
            }
        }
        return true;
    }

    public function _rejecteOrder()
    {

    }

    /**
     * 取消订单
     * @param string $order_sn 订单号
     * @param string $reject_reason 订单取消理由
     * @param integer $uid 订单原本指派的店员id
     * @param int $order_sub_id
     * @param bool $is_log_cancel
     */
    public function rejecteOrder($order_sn, $reject_reason, $uid, $order_sub_id = 0, $is_log_cancel = true)
    {
        if (!$order_info = $this->db->get_row(get_table('order'), ['order_sn' => $order_sn])) {
            throw new \RuntimeException('订单不存在');
        }
        $cancel_count = 0;
        if ($is_log_cancel) {
            $cancel_count = $this->db->get_total(get_table('order_cancel_log'), ['order_sn' => $order_sn]);
            $this->db->insert(get_table('order_log'), [
                'order_sn' => $order_sn,
                'log_at'   => $_SERVER['REQUEST_TIME'],
                'log'      => '订单已被拒绝,已被拒接' . $cancel_count . '次',
                'uid'      => $uid,
            ]);
        }
        $this->db->insert(get_table('order_cancel_log'), [
            'order_sn'        => $order_sn,
            'cancel_assignor' => $uid,
        ]);
        $this->db->delete(get_table('order_appointed'), [
            'appointed_uid' => $uid,
            'order_sn'      => $order_sn,
            'order_sub_id'  => $order_sub_id
        ]);
        $this->db->update(get_table('store_user'), [
            'staff_current_order_sn'     => '',
            'staff_current_order_sub_id' => 0
        ], ['user_id' => $uid]); // 恢复店员的接手订单状态
        /** @var \PDOStatement $pdo_state */
        $pdo_state = $this->db->query(StaffDAO::getStaffByUserID([$uid]));
        $staff_id  = $pdo_state ? $pdo_state->fetch(\PDO::FETCH_ASSOC) : [];
        $this->db->set('staff_all_services', 'staff_all_services - 1', false)
            ->set('staff_total_services', 'staff_total_services - 1', false)
            ->update(get_table('store_staff_info'), ['staff_id' => $staff_id['id']]);
        $appointed_uid = explode('-', $order_info['appointed_uid']);
        foreach ($appointed_uid as $key => $_uid) {
            if ($_uid == $uid) {
                unset($appointed_uid[$key]);
            }
        }
        $appointed_uid = implode('-', $appointed_uid);
        $this->db->update(get_table('order'), compact('appointed_uid'), array_merge(compact('order_sn'), ['order_sub_sn' => $order_sub_id])); // 更新订单表的指派数据，反转2次数组并取消下表实现快速删除
        // +--------------------------------------------------------------------------------------
        // | 新的取消流程，指派给下一个有空的店员，如果没有有空店员或连续三次取消则停止, 2018-8-30
        // +--------------------------------------------------------------------------------------
        if ((3 >= $cancel_count) && $user_id = $this->autoAssignStaff($order_sn)) {
            $staff_row = $this->db->get_row(get_table('store_user'), compact('user_id'), 'staff_name');
            $this->db->insert(get_table('order_log'), [
                'order_sn'     => $order_sn,
                'order_sub_sn' => $order_sub_id,
                'log_at'       => $_SERVER['REQUEST_TIME'],
                'log'          => "新的服务人员接手，服务人员:{$staff_row['staff_name']}",
                'uid'          => $user_id
            ]);
        }
    }

    /**
     * 格式化订单数据DTO
     * @param array|string|bool $order 订单号或者订单查询出来的记录
     * @param bool $get_appointed 是否获取订单指派信息
     * @return array|bool
     */
    public function formatOrderRow($order, $get_appointed = false): array
    {
        if (\is_string($order) && !$order = $this->getOrderInfo($order, true)) {
            return false;
        }
        $_order = [];
        // +----------------------------------------------------------------------------------------------------
        // | 订单时间记录
        // +----------------------------------------------------------------------------------------------------
        $_order['time_record'] = [
            'receipt_at'             => date('Y-m-d H:i', $order['receipt_at']),
            'add_time'               => date('Y-m-d H:i', $order['add_time']), // 订单创建时间
            'pay_time'               => date('Y-m-d H:i', $order['pay_time']), // 订单支付时间
            'complete_at'            => $order['complete_at'] && $order['complete_at'] = date('Y-m-d H:i', $order['complete_at']),  // 订单完成时间
            'contact_appointment_at' => $order['order_type'] == 4 ? '待确认' : date('Y-m-d H:i', $order['contact_appointment_at']), // 订单预约时间
            'order_sm_at'            => $order['order_sm_at'] && $order['order_sm_at'] = date('Y-m-d H:i', $order['order_sm_at']), // 服务人员上门时间，也就是点开始服务的时间,当有上门时间时才会格式化
        ];
        if ($order['order_refund']) {
            $_order['time_record']['order_refund_at'] = date('Y-m-d H:i', $order['order_refund_at']); // 退款时间
        }
        unset($order['order_refund_at'], $order['order_store_del'], $order['order_user_del']);
        // +----------------------------------------------------------------------------------------------------
        // | 支付详情
        // +----------------------------------------------------------------------------------------------------
        $_order['payment'] = [
            'order_deductible_type'  => $order['order_deductible_type'], // 订单递归方式
            'order_pay_way'          => $order['order_pay_way'], // 订单支付途径
            'order_actual_amount'    => sprintf('%.2f', $order['order_actual_amount'] / 100), // 实际支付金额，单位元
            'order_amount'           => sprintf('%.2f', $order['order_amount'] / 100), // 订单总金额，单位元
            'order_deductible_count' => sprintf('%.2f', $order['order_deductible_count'] / 100), // 订单抵扣金额，单位元
        ];
        if (!$order['order_added_sn']) {
            unset($_order['order_added_sn']);
        }
        // +----------------------------------------------------------------------------------------------------
        // | 订单详情
        // +----------------------------------------------------------------------------------------------------
        $table_name = $order['order_type'] == 1 ? get_table('service') : get_table('demand');
        if (get_table('service') == $table_name) {
            if (!$order_pic = $this->cache('_service.info.' . $order['order_type_id'])) {
                $order_pic = $this->db
                    ->join([get_table('category') => 'a'], ['a.id' => 'b.service_level_1'], 'INNER')
                    ->get_row([$table_name => 'b'], ['b.id' => $order['order_type_id']],
                        'b.service_img as img, b.order_charging, a.cat_name');
                $order_pic = json_encode(filter($order_pic));
                $this->cache('_service.info.' . $order['order_type_id'], $order_pic, 120);
            }
        } else {
            $order_pic = $this->db
                ->join([get_table('category') => 'a'], ['a.id' => 'b.demand_level_1'], 'INNER')
                ->get_row([$table_name => 'b'], ['b.id' => $order['order_type_id']], 'b.demand_img as img, a.cat_name');
            $order_pic = json_encode(filter($order_pic));
        }

        $order_pic              = json_decode($order_pic, true);
        $_order['order_detail'] = [
            'is_sys_order'        => $order['is_sys_order'] == 1,
            'order_info'          => str_replace(['&amp;', '&quot;', '&#039;', '&lt;', '&gt;'], ['&', '"', "'", '<', '>'], $order['order_info']), // 这里不采用内置的htmlspecialchars_decode的原因是当字符串内含有非UTF8字符集时会导致转换失败
            'order_pic'           => isset($order_pic['img']) ? explode(',', $order_pic['img']) : '', // 订单图片
            'order_message'       => $order['order_message'],
            'order_normal_id'     => $order['id'],
            'order_type'          => $order['order_type'],
            'order_type_id'       => $order['order_type_id'],
            'order_sn'            => $order['order_sn'], // 订单流水号
            'order_state'         => $order['order_state'], // 旧的订单状态
            'order_is_pay'        => $order['order_is_pay'], // 订单是否支付
            'order_refund'        => $order['order_refund'], // 是否退款
            'order_is_peddling'   => $order['order_is_peddling'], // 订单是否处于交易处理中
            'order_rate'          => $order['order_rate'], // 服务人员是否点击已完成
            'cancel_reason'       => $order['cancel_reason'], // 订单取消理由
            'order_comment_id'    => $order['order_comment_id'], // 评论id
            'order_bis_state_dsc' => $order['order_bis_state_dsc'],
            'order_pay_state_dsc' => $order['order_pay_state_dsc'],
            'order_name'          => $order['order_name'],
            'order_sub_sn'        => 0,
            'cat_name'            => $order_pic['cat_name'] ?? ''
        ];
        if ($order['order_type'] == 1) {
            $_order['order_detail']['order_charging'] = $order_pic['order_charging'];
        }
        if ($order['is_sys_order']) {
            // 如果是周期订单，显示下一期订单的服务时间
            $next_order = $this->db->order_by(['id' => 'asc'])->get_row(get_table('order'), [
                'order_sn'   => $order['order_sn'],
                'id <>'      => $order['id'], // 不是他自己的订单
                'order_rate' => 0
            ], 'contact_appointment_at, order_sub_sn, order_bis_state_dsc, order_pay_state_dsc');
            if ($next_order) {
                $_order['time_record']['next_order_at']        = date('Y-m-d H:i', $next_order['contact_appointment_at']);
                $_order['order_detail']['order_sub_sn']        = $next_order['order_sub_sn'];
                $_order['order_detail']['order_bis_state_dsc'] = $next_order['order_bis_state_dsc'];
                $_order['order_detail']['order_pay_state_dsc'] = $next_order['order_pay_state_dsc'];
                unset($next_order);
            }
        }
        // +----------------------------------------------------------------------------------------------------
        // | 店铺信息
        // +----------------------------------------------------------------------------------------------------
        $store_info = $this->cache('order.cache.store.info.' . $order['order_belong_store_id']);
        if (!$store_info) {
            $store_info = $this->db->get_row(get_table('store'), ['id' => $order['order_belong_store_id']], 'id as order_belong_store_id, store_phone, store_name');
            if ($store_info) {
                $store_info = serialize(filter($store_info));
                $this->cache('order.cache.store.info.' . $order['order_belong_store_id'], $store_info, 120);
            }
        }
        $_order['store_info'] = unserialize($store_info);
        // +----------------------------------------------------------------------------------------------------
        // | 订单所属用户信息
        // +----------------------------------------------------------------------------------------------------
        if (!isset($order['user_name'])) {
            $user_info = $this->cache('order.user.info.' . $order['user_id']);
            if (!$user_info) {
                $user_info = $this->db->get_row('user', ['user_id' => $order['user_id']], 'user_name, user_phone, user_pic');
                $user_info = serialize(filter($user_info));
                $this->cache('order.user.info.' . $order['user_id'], $user_info);
            }
            $user_info = unserialize($user_info);
        }
        $_order['user_info'] = [
            'user_id'    => $order['user_id'],
            'user_name'  => $user_info['user_name'] ?? '',
            'user_phone' => $user_info['user_phone'] ?? '',
            'user_pic'   => $user_info['user_pic'] ?? ''
        ];
        unset($order['user_id'], $order['user_name'], $order['user_phone'], $order['user_pic']);
        // +----------------------------------------------------------------------------------------------------
        // | 订单服务详情
        // +----------------------------------------------------------------------------------------------------
        $_order['server_info'] = [
            'address_name'   => $order['address_name'],
            'appointed_uid'  => (string)$order['appointed_uid'],
            'contact_name'   => $order['contact_name'],
            'house_number'   => $order['house_number'],
            'telephone'      => $order['telephone'],
            'order_lat'      => $order['order_lat'],
            'order_lng'      => $order['order_lng'],
            'service_length' => $order['service_length']
        ];
        if (!$get_appointed) {
            return $_order;
        }
        $_order['server_info']['appointed_row'] = []; // 返回指派的记录
        if ($order['appointed_uid']) {
            $appointed_uid       = explode('-', $order['appointed_uid']);
            $appointed_uid       = $this->db->limit(0, \count($appointed_uid))
                ->order_by(['id' => 'ASC'])
                ->get(get_table('order_appointed'), ['order_sn' => $order['order_sn'], 'order_sub_id' => $order['order_sub_sn']], 'appointed_uid');
            $query_appointed_uid = $cache_appointed_uid = [];
            $query_rows          = $cache_rows = [];

            foreach ($appointed_uid as $appointed) {
                $user_id = $appointed['appointed_uid'];
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

            foreach (array_merge($query_rows, $cache_rows) as $item) {
                $rows[$item['user_id']] = $item;
            }
            $rows = filter($rows);

            $appointed_rows = [];
            foreach ($appointed_uid as $appointed) {
                $appointed_rows[] = $rows[$appointed['appointed_uid']];
            }

            $_order['server_info']['appointed_row'] = array_merge($appointed_rows, []);
        }

        return $_order;
    }

    /**
     * 获取订单分配的用户资料
     * @param array|integer $id
     * @return array
     */
    private function _get_appointed_row($id)
    {
        $query = $this->db
            ->select('b.user_pic, c.staff_name, b.user_id')
            ->join([get_table('store_user') => 'c'], ['b.user_id' => 'c.user_id'], 'INNER');

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

    /**
     * @remark 根据首单起始日期排序周期订单， 返回的价格是分单位
     * @param array $orders 周期订单列表
     * @param integer|string|boolean $start_time 订单起始日时间戳
     * @param int $cycleLong 订单循环周期
     * @return array
     */
    public function sortOrder($orders, $start_time, $cycleLong = 1): array
    {
        $service_id           = $this->router->get(1) ?: $this->request->post('service_id', 0, 'intval');
        $data['service_item'] = $this->request->post('service_item/a', [], 'trim');

        if (!$service = $this->db->get_row(get_table('service'), ['id' => $service_id])) {
            return $this->error('要下单的服务已不存在');
        }

        switch ($service['order_charging']) {
            // 免预约
            case 'NON_RESERVATION':
                $data['order_actual_amount'] = 0;
                break;
            case 'FIXED_PRICE': // 固定价格（一口价）
            default:
                $remuneration = 0;
                // 如果下单的是服务项目
                if ($data['service_item']) {
                    foreach ($data['service_item'] as $item) {
                        $item         = $this->db->get_row(get_table('service_items'), [
                            'id'         => $item['id'],
                            'service_id' => $service_id
                        ]);
                        $remuneration += $item['item_change'] * $item['length'];
                    }
                    $data['order_actual_amount'] = $remuneration;
                } else {
                    $data['order_actual_amount'] = $service['service_remuneration'];
                }
                break;
            // 预约金
            case 'HAS_RESERVATION':
                $data['order_actual_amount'] = $service['service_remuneration'];
                break;
        }

        \is_string($start_time) && $start_time = ToolModel::strtotime($start_time);
        if (!$start_time) {
            return [];
        }
        $all_orders = [];
        // 循环所有订单
        foreach ($orders as $day => $orderItems) {
            foreach ($orderItems['order'] as $order) {
                // 订单开始时间戳 => 时长
                $all_orders[ToolModel::strtotime($order)] = $orderItems['long'];
            }
        }

        // 升序排序订单
        $all_orders_keys = array_keys($all_orders);
        sort($all_orders_keys); // 升序排序

        $sort_orders = [];
        foreach ($all_orders_keys as $key) {
            $sort_orders[$key] = $all_orders[$key];
        }
        unset($all_orders);

        $insert_orders = []; // 要写入的订单
        $delay_orders  = []; // 推迟订单
        $cycle_days    = 7 * $cycleLong; // 推迟天数 = 周期数 * 7天
        // 排序订单，首单排第一，早于首单的往数组后移
        foreach ($sort_orders as $order_at => $order_long) {
            $order_at_time = date('Y-m-d', $order_at); // 订单服务的日期
            $begin_day_at  = strtotime($order_at_time); // 订单服务的零点时间戳
            if ($start_time <= $begin_day_at) {
                $insert_orders[] = [
                    'order_at'     => $order_at,
                    'order_length' => $order_long
                ];
            } else {
                $date                                                   = date('Y-m-d H:i:s', $order_at);
                $delay_orders[strtotime($date . " +{$cycle_days}days")] = $order_long;
            }
        }
        // 把推迟订单追加写入订单数组中,得到排序好的订单顺序
        if ($delay_orders) {
            foreach ($delay_orders as $order_at => $order_long) {
                $insert_orders[] = [
                    'order_at'     => $order_at,
                    'order_length' => $order_long
                ];
            }
        }

        unset($sort_orders, $delay_orders);

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

        $calc_orders = [];
        // 判断订单是否有周期弹性变动规则
        foreach ($insert_orders as $order) {
            $calc_orders[$order['order_at']] = [
                'charge'       => $data['order_actual_amount'],
                'order_length' => $order['order_length'],
                'order_at'     => $order['order_at']
            ];
            if (isset($_price_change_rules['alternation']) && $_price_change_rules['alternation']) {
                foreach ($_price_change_rules['alternation'] as $rule) {
                    $day = date('w', $order['order_at']); // 星期中的第几天，数字表示；0（表示星期天）到 6（表示星期六）
                    !$day || $day = 7;
                    if ($rule['choose_date'] == $day && ToolModel::checkIsBetweenTime($rule['begin_at'], $rule['end_at'], $order['order_at'])) {
                        $calc_orders[$order['order_at']] = [
                            'charge'       => $rule['diff_type'] == 'INCR'
                                ? $data['order_actual_amount'] + $rule['price_change']
                                : $data['order_actual_amount'] - $rule['price_change'],
                            'order_length' => $order['order_length'],
                            'order_at'     => $order['order_at']
                        ];
                    }
                }
            }
        }
        unset($all_orders);
        // 计算固定周期内是否有变动规则
        foreach ($calc_orders as $order) {
            $order_at_key               = date('Y-m-d H:i:s', $order['order_at']);
            $order_date                 = date('Y-m-d', $order['order_at']);
            $calc_orders[$order_at_key] = [
                'charge'       => $order['charge'],
                'order_length' => $order['order_length'],
                'order_at'     => $order['order_at']
            ];
            if (isset($_price_change_rules['custom']) && $_price_change_rules['custom']) {
                foreach ($_price_change_rules['custom'] as $rule) {
                    if ($rule['choose_date'] == $order_date && ToolModel::checkIsBetweenTime($rule['begin_at'], $rule['end_at'], $order['order_at'])) {
                        $calc_orders[$order_at_key] = [
                            'charge'       => $rule['diff_type'] == 'INCR'
                                ? $order['charge'] + $rule['price_change']
                                : $order['charge'] - $rule['price_change'],
                            'order_length' => $order['order_length'],
                            'order_at'     => $order['order_at']
                        ];
                    }
                }
            }
            unset($calc_orders[$order['order_at']]);
        }
        return $calc_orders;
    }

    /**
     * 订单退款
     * @param string $order_sn 订单流水号
     * @param bool $force 是否强制取消，为真时则不检测是否订单在服务前
     * @param int $order_sub_sn
     */
    public function orderRefund($order_sn, $force = false, $order_sub_sn = 0)
    {
        $order_info = $this->db->get_row(get_table('order'), compact('order_sn', 'order_sub_sn'));
        if (!$order_info) {
            throw new \RuntimeException('订单信息不存在');
        }

        $bis_state_dsc_arr = [
            'PENDING_ORDER',
            'PENDING_ASSIGN',
            'PENDING_DOOR',
        ];
        if (!$force && ($order_info['order_pay_state_dsc'] == 'PAY_SUCCESS'
                && \in_array($order_info['order_bis_state_dsc'], $bis_state_dsc_arr, false))) {
            throw new \RuntimeException('当前订单状态不允许退款！');
        }

        if ($order_info['order_refund'] != 0) {
            throw new \RuntimeException('订单已退款，不能再次操作');
        }

        if ($order_info['order_deductible_type'] == 1) { // 订单使用了余额抵扣
            $wallet_change = sprintf('%.2f', ($order_info['order_deductible_count'] + $order_info['order_actual_amount']) / 100);
            UserModel::userBalanceLog(
                $wallet_change,
                UserModel::getCapitalChangeTerms(10, [$order_info['order_sn'], $wallet_change]),
                1,
                $order_info['order_sn'],
                $order_info['user_id']
            );
            $this->db->set('user_balance', "user_balance + {$wallet_change}", false)
                ->update('user', null, ['user_id' => $order_info['user_id']]);
        } elseif ($order_info['order_deductible_type'] == 2) { // 订单使用了积分抵扣
            $wallet_change = sprintf('%.2f', $order_info['order_deductible_count'] / 100);
            UserModel::pointLog(
                $order_info['order_deductible_count'],
                $order_info['user_id'],
                1,
                '退还积分',
                '订单[' . $order_info['order_sn'] . ']退还积分'
            );
            $this->db->set('user_score', "user_score + {$wallet_change}", false)
                ->update('user', null, ['user_id' => $order_info['user_id']]);
            if ($order_info['order_actual_amount']) {
                $wallet_change = sprintf('%.2f', $order_info['order_actual_amount']);
                UserModel::userBalanceLog(
                    $wallet_change,
                    UserModel::getCapitalChangeTerms(10, [$order_info['order_sn'], $wallet_change]),
                    1,
                    $order_info['order_sn'],
                    $order_info['user_id']
                );
                $this->db->set('user_score', "user_score + {$wallet_change}", false)
                    ->update('user', null, ['user_id' => $order_info['user_id']]);
            }
        } else {
            $wallet_change = sprintf('%.2f', $order_info['order_actual_amount']);
            UserModel::userBalanceLog(
                $wallet_change,
                UserModel::getCapitalChangeTerms(10, [$order_info['order_sn'], $wallet_change]),
                1,
                $order_info['order_sn'],
                $order_info['user_id']
            );
            $this->db->set('user_balance', "user_balance + {$wallet_change}", false)
                ->update('user', null, ['user_id' => $order_info['user_id']]);
        }
        $this->db->update(get_table('order'), [
            'order_refund'    => 1,
            'order_refund_at' => $_SERVER['REQUEST_TIME'],
        ], compact('order_sn', 'order_sub_sn'));
    }
}
