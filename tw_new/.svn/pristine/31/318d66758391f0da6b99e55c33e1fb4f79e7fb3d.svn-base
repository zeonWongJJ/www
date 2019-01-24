<?php
/**
 * 积分模型类
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

use utils\Factory;

class JifenModel extends BaseModel
{
    /**
     * 计算返还积分,必须在事务中调用
     * @param string $order_sn
     * @param int $order_sub_sn
     */
    public function restore($order_sn, $order_sub_sn = 0)
    {
        /** @var UserModel $user_model */
        $user_model = Factory::getFactory('user');
        $order_id = "{$order_sn}-{$order_sub_sn}";
        // 考虑到数据循环查询下比较浪费性能，采用一分钟的redis储存减少无谓的额外查询开销
        if (!$cache_rows = $this->cache('restore.order.id.' . $order_id)) {
            if (!$order_info = $this->cache('jiajie.order.row.' . $order_id)) {
                $order_info = $this->db->get_row(get_table('order'), compact('order_sub_sn', 'order_sn'));
                $this->cache('jiajie.order.row.', $order_info, 60);
            }

            $this->cache('restore.order.id' . $order_id, [
                'order_info' => $order_info,
            ], 60);
        } else {
            $order_info = $cache_rows['order_info'];
        }

        if ($order_info) {
            $order_actual_amount = sprintf('%.2f', $order_info['order_actual_amount'] / 100); // 订单实际支付金额，单位元
            // 获取返还比例
            $consumption_return_ratio = $this->db->get_row(get_table('config'), ['config_key' => 'consumption_return_ratio'], 'config_value');
            if ($consumption_return_ratio && $consumption_return_ratio['config_value']) {
                $consumption_return_ratio = $consumption_return_ratio['config_value'];
                $consumption_return_ratio /= 100; // 百分比
            } else {
                $consumption_return_ratio = 0; // 如果没有则不返还
            }
            $user_info = $this->db->get_row('user', ['user_id' => $order_info['user_id']], 'user_name');
            // +---------------------------------------------------------------------------------------------------
            // | 新的返还策略，根据订单场景不同分开返还
            // +---------------------------------------------------------------------------------------------------
            // 场景1：不使用抵扣的时候，从订单总金额中返还,返还到用户余额上
            if ($order_info['order_deductible_type'] == 0) {
                $wallet_change          = sprintf('%.2f', $order_actual_amount * $consumption_return_ratio); // 因为上面已经处理成百分比了，这里直接算
                $this->db->set('user_balance', "user_balance + {$wallet_change}", false)
                        ->update('user', null, ['user_id' => $order_info['user_id']]);
                UserModel::userBalanceLog(
                    $wallet_change,
                    UserModel::getCapitalChangeTerms(9, [$order_info['order_name'], $wallet_change]),
                    1,
                    "{$order_info['order_sn']}-{$order_info['order_sub_sn']}",
                    $order_info['user_id']
                );
            } elseif ($order_info['order_deductible_type'] != 0 && $order_info['order_actual_amount'] == 0) {
                // 场景2：订单使用了金额（或积分）完全抵扣，则从抵扣的总金额（也就是订单总金额）中返还，返还到具体抵扣的账号上
                $wallet_change = sprintf('%.2f', ($order_info['order_deductible_count'] / 100) * $consumption_return_ratio); // 因为上面已经处理成百分比了，这里直接算
                if ($order_info['order_deductible_type'] == 1) { //1：余额抵扣
                    $this->db->set('user_balance', "user_balance + {$wallet_change}", false)
                                ->update('user', null, ['user_id' => $order_info['user_id']]);
                    UserModel::userBalanceLog(
                        $wallet_change,
                        UserModel::getCapitalChangeTerms(9, [$order_info['order_name'], $wallet_change]),
                        1,
                        "{$order_info['order_sn']}-{$order_info['order_sub_sn']}",
                        $order_info['user_id']
                    );
                } else {
                    $this->db->set('user_score', "user_score + {$wallet_change}", false)
                        ->update('user', null, ['user_id' => $order_info['user_id']]);
                    $this->db->insert('points_log', [
                        'user_id'        => $order_info['user_id'],
                        'user_name'      => $user_info['user_name'],
                        'pl_type'        => 1,
                        'pl_variation'   => $wallet_change,
                        'pl_score'       => $user_model->getUserBalanceLock($order_info['user_id'], 2),
                        'pl_item'        => UserModel::getCapitalChangeTerms(9, [$order_info['order_name'], $wallet_change]),
                        'pl_description' => UserModel::getCapitalChangeTerms(9, [$order_info['order_name'], $wallet_change]),
                        'pl_time'        => $_SERVER['REQUEST_TIME'],
                        'pl_code'        => 5
                    ]);
                }
            } elseif ($order_info['order_deductible_type'] != 0 && $order_info['order_actual_amount'] != 0) {
                // 场景3：订单使用了金额（或积分）不完全抵扣，仍需支付剩余的部分，则分开返还
                if ($order_info['order_deductible_type'] == 1) { //1：余额抵扣
                    $wallet_change          = sprintf('%.2f', ($order_info['order_amount'] / 100) * $consumption_return_ratio);
                    $this->db->set('user_balance', "user_balance + {$wallet_change}")
                        ->update('user', null, ['user_id' => $order_info['user_id']]);
                    UserModel::userBalanceLog(
                        $wallet_change,
                        UserModel::getCapitalChangeTerms(9, [$order_info['order_name'], $wallet_change]),
                        1,
                        "{$order_info['order_sn']}-{$order_info['order_sub_sn']}",
                        $order_info['user_id']
                    );
                } else {
                    $order_deductible_count = sprintf('%.2f', $order_info['order_deductible_count'] / 100); // 抵扣了的金额，单位元
                    $deductible_refund      = sprintf('%.2f', $order_deductible_count * $consumption_return_ratio); // 抵扣部分的返还

                    $this->db->set('user_score', "user_score + {$deductible_refund}", false)
                        ->update('user', null, ['user_id' => $order_info['user_id']]);
                    $this->db->insert('points_log', [
                        'user_id'        => $order_info['user_id'],
                        'user_name'      => $user_info['user_name'],
                        'pl_type'        => 1,
                        'pl_variation'   => $user_model->getUserBalanceLock($user_info['user_id'], 2),
                        'pl_score'       => $deductible_refund,
                        'pl_item'        => UserModel::getCapitalChangeTerms(9, [$order_info['order_name'], $deductible_refund]),
                        'pl_description' => UserModel::getCapitalChangeTerms(9, [$order_info['order_name'], $deductible_refund]),
                        'pl_time'        => $_SERVER['REQUEST_TIME'],
                        'pl_code'        => 5
                    ]);

                    $user_balance_change    = sprintf('%.2f', $order_actual_amount * $consumption_return_ratio); // 实际支付部分的返还，单位元
                    $this->db->set('user_balance', "user_balance + $user_balance_change", false)
                        ->update('user', null, ['user_id' => $order_info['user_id']]);
                    UserModel::userBalanceLog(
                        $user_balance_change,
                        UserModel::getCapitalChangeTerms(9, [$order_info['order_name'], $user_balance_change]),
                        1,
                        "{$order_info['order_sn']}-{$order_info['order_sub_sn']}",
                        $order_info['user_id']
                    );
                }
            }
        }
    }
}
