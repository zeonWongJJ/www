<?php
/**
 * 订单模型类，处理订单相关逻辑
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

use utils\BaseModel;
use utils\Factory;
use utils\ide\Db;

use utils\Medoo;

/**
 * @property Db pay_db_mysql
 * @property Medoo query
 */
class OrderModel extends BaseModel
{
    const ORDER_USER_BUY_SERVER = 1; // 用户购买服务
    const ORDER_USRE_DEMAND = 2; // 用户支付需求
    const ORDER_USER_RECHANGE = 3; // 用户充值余额

    public function __construct(array $param = [])
    {
        parent::__construct($param);
        $this->query = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'wofei',
            'server'        => 'localhost',
            'username'      => 'wofei',
            'password'      => 'bbJZSw8Lxq8Th6MY',
            'charset'       => 'utf8',
            'prefix'        => 'wf_'
        ]);
//        $this->load->database('pay_db_mysql');
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
//        $order           = $this->pay_db_mysql->get_row(get_table('order'), $map);
        $order = $this->query->get(get_table('order'), '*', $map);
        if ($order) {
//            if ($order['order_process'] != 0) {
//                return $this->error('订单状态不允许继续执行支付');
//            }
            // 1.判断签名是否正确
            if ($order_sign === md5(implode('-', [$order_sn, $order['order_type'], $order['order_type_id']]))) {
                // 2. 判断订单是否超过支付期限，支付期限为30分钟
//                if ($order['add_time'] + 1800 >= $_SERVER['REQUEST_TIME']) {
                if ((int)$order['order_type'] === self::ORDER_USRE_DEMAND) {
                    $row = $this->query->get(get_table('demand'), '*', ['id' => $order['order_type_id']]);
//                    $row = $this->pay_db_mysql->get_row(get_table('demand'), ['id' => $order['order_type_id']]);
                    if ($row['order_sn'] !== $order_sn) {
                        return $this->error('订单流水号不匹配!');
                    }
                } else {
                    $row['subject_title'] = $order['order_name'];
                }

//                    $table_name = (int)$order['order_type'] === self::ORDER_USRE_DEMAND ? 'jiajie_demand' : 'jiajie_service';
//                    $row        = $this->pay_db_mysql->get_row($table_name, ['id' => $order['order_type_id']]);
                // 4. 检查该服务或者需求是否与订单流水号对应
//                    if ($row['order_sn'] === $order_sn) {
                //5. 更改订单交易状态
//                $this->pay_db_mysql->update('jiajie_order', ['order_paying' => 1], $map); // 更改订单状态为交易中
                switch ($order['order_pay_way']) {
                    case 'wechat':
                        $pay_way      = JPayModel::WECHAT;
                        $order_info   = [
                            'body'             => $row['subject_title'],
                            'total_fee'        => $order['order_actual_amount'], // 订单总金额，单位为分 https://pay.weixin.qq.com/wiki/doc/api/H5.php?chapter=4_2
                            'spbill_create_ip' => get_client_ip(),
                        ];
                        $total_amount = $order_info['total_fee'] / 100;
                        break;
                    case 'alipay':
                        $pay_way      = JPayModel::ALIPAY;
                        $order_info   = [
                            'timeout_express' => '30m',
                            'subject'         => $row['subject_title'],
                            'total_amount'    => format_money($order['order_actual_amount'])
                        ];
                        $total_amount = $order_info['total_amount'];
                        break;
                    case 'bankcard':
                        $pay_way      = JPayModel::BANKCARD;
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
                    if ($total_amount * 100 == 0) {
                        header('location:' . "http://www.7dugo.com/order.pay.return-{$pay_way}?out_trade_no={$order_sn}");
                    }
                    /** @var JPayModel $pay_model */
                    $pay_model                  = Factory::getFactory('JPay');
                    $order_info['out_trade_no'] = $order_sn;
                    return $pay_model->setPayWay($pay_way)->pay($order_info);
                }
                return $this->error('交易方式非法!');
//                    }
//                    return $this->error('订单流水号不匹配!');
//                }
//                return $this->error('订单超过支付有效期，请重新下单!');
            } else {
                return $this->error('订单签名不正确');
            }
        } else {
            return $this->error('查询不到订单!');
        }
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
//        try {
//            $this->pay_db_mysql->set_error_mode();
//            $this->pay_db_mysql->begin();
        $this->query->action(function ($database) use ($out_trade_no) {

            $order = $database->get(get_table('order'), '*', [
                'order_sn' => $out_trade_no
            ]);
            /*$order = $this->pay_db_mysql->get_row('jiajie_order', [
                'order_sn' => $out_trade_no
            ]);*/

            if (!$order) {
                return $this->error('没有匹配的订单');
            }

            /** @noinspection TypeUnsafeComparisonInspection */
            if ($order['order_is_pay'] == 1) {
                return $this->error('订单已经支付!');
            }
            $user_info = $database->get('user', '*', ['user_id' => $order['user_id']]);
//            $user_info = $this->pay_db_mysql->get_row('user', ['user_id' => $order['user_id']]);
            if (!$user_info) {
//                throw new \RuntimeException('订单查询不到用户');
                return false;
            }
            /** @noinspection TypeUnsafeComparisonInspection */
            if ($order['order_type'] == 2) {
//                $this->pay_db_mysql->update('jiajie_demand', ['demand_status' => 0], ['id' => $order['order_type_id']]); // 更新已支付
            } /** @noinspection TypeUnsafeComparisonInspection */ elseif ($order['order_type'] == 3) {
//                $this->pay_db_mysql->update(get_table('recharge'), ['recharge_status' => 2], ['id' => $order['order_type_id']]);
                $database->update(get_table('recharge'), ['recharge_status' => 2], ['id' => $order['order_type_id']]);
                // 充值余额时更新用户余额
                $_update = [
                    'user_balance' => $user_info['user_balance'] * 100 + $order['order_amount']
                ];

                $_update['user_balance'] = sprintf('%.2f', $_update['user_balance'] / 100);
//                if (!$result = $this->pay_db_mysql->update('user', $_update, ['user_id' => $order['user_id']])) {
                if (!$result = $database->update('user', $_update, ['user_id' => $order['user_id']])) {
                    return false;
//                    throw new \RuntimeException('冲入用户余额失败!');
                }

//                $this->pay_db_mysql->insert('userbalance', [
                $database->insert('userbalance', [
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
//            $this->pay_db_mysql->update(get_table('order'), [
            $database->update(get_table('order'), [
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
//                    $this->pay_db_mysql->insert('points_log', [
                    $database->insert('points_log', [
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
//                    $this->pay_db_mysql->update('user', $update, ['user_id' => $user_info['user_id']]);
                    $database->update('user', $update, ['user_id' => $user_info['user_id']]);
                } /** @noinspection TypeUnsafeComparisonInspection */ elseif ($order['order_deductible_type'] == 1) {
                    $update['user_balance'] = sprintf('%.2f', ($user_info['user_balance'] * 100 - $order['order_deductible_count']) / 100);
//                    $this->pay_db_mysql->insert('userbalance', [
                    $database->insert('userbalance', [
                        'ub_type'        => 2,
                        'ub_money'       => $order['order_deductible_count'] / 100,
                        'ub_balance'     => $update['user_balance'],
                        'ub_item'        => '余额抵扣',
                        'user_id'        => $user_info['user_id'],
                        'ub_number'      => $order['order_sn'],
                        'ub_time'        => $_SERVER['REQUEST_TIME'],
                        'ub_description' => '商品支付时使用余额抵扣了' . sprintf('%.2f', $order['order_deductible_count'] / 100) . '元'
                    ]);
//                    $this->pay_db_mysql->update('user', $update, ['user_id' => $user_info['user_id']]);
                    $database->update('user', $update, ['user_id' => $user_info['user_id']]);
                }
            }
//            $this->pay_db_mysql->commit();
        });

//        } catch (\Exception $e) {
//            $this->pay_db_mysql->roll_back();
//            throw $e;
//        }
    }

    /**
     * 回滚订单
     * @param $out_trade_no
     */
    public function rollbackOrder($out_trade_no)
    {
        $order_info = $this->query->get(get_table('order'), '*', ['order_sn' => $out_trade_no]);
        if (!$order_info) {
            throw new \RuntimeException('订单不存在');
        }
        $this->query->update(get_table('order'), [
            'order_state' => 0 // 回滚到待付款状态
        ], ['order_sn' => $out_trade_no]);
    }
}
