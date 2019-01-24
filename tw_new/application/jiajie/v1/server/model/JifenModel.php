<?php
/**
 * 积分模型类
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

class JifenModel extends \utils\BaseModel
{
    /**
     * 计算返还积分
     * @param $order_id
     */
    public function restore($order_id)
    {
        // 考虑到数据循环查询下比较浪费性能，采用一分钟的redis储存减少无谓的额外查询开销
        if (!$cache_rows = $this->cache('restore.order.id.' . $order_id)) {
            if (!$order_info = $this->cache('jiajie.order.row.' . $order_id)) {
                $order_info = $this->db->get_row('jiajie_order.', ['id' => $order_id]);
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
            $user_info = $this->db->get_row('user', ['user_id' => $order_info['user_id']], 'user_score, user_name, user_balance');
            $update    = [];
            // +---------------------------------------------------------------------------------------------------
            // | 新的返还策略，根据订单场景不同分开返还
            // +---------------------------------------------------------------------------------------------------
            // 场景1：不使用抵扣的时候，从订单总金额中返还,返还到用户余额上
            if ($order_info['order_deductible_type'] == 0) {
                $wallet_change          = sprintf('%.2f', $order_actual_amount * $consumption_return_ratio); // 因为上面已经处理成百分比了，这里直接算
                $update['user_balance'] = $user_info['user_balance'] + $wallet_change; // 计算返还后的余额

                $this->db->insert('userbalance', [
                    'ub_type'        => 1,
                    'ub_money'       => $wallet_change,
                    'ub_balance'     => $update['user_balance'],
                    'ub_time'        => $_SERVER['REQUEST_TIME'],
                    'ub_item'        => '完成订单获得返还',
                    'user_id'        => $order_info['user_id'],
                    'ub_number'      => $order_info['order_sn'],
                    'ub_description' => '订单' . $order_info['order_sn'] . '完成，获得订单返还金额'
                ]);

            } elseif ($order_info['order_deductible_type'] != 0 && $order_info['order_actual_amount'] == 0) {
                // 场景2：订单使用了金额（或积分）完全抵扣，则从抵扣的总金额（也就是订单总金额）中返还，返还到具体抵扣的账号上
                $wallet_change = sprintf('%.2f', ($order_info['order_deductible_count'] / 100) * $consumption_return_ratio); // 因为上面已经处理成百分比了，这里直接算
                if ($order_info['order_deductible_type'] == 1) { //1：余额抵扣
                    $update['user_balance'] = $user_info['user_balance'] + $wallet_change;
                    $this->db->insert('userbalance', [
                        'ub_type'        => 1,
                        'ub_money'       => $wallet_change,
                        'ub_balance'     => $update['user_balance'],
                        'ub_time'        => $_SERVER['REQUEST_TIME'],
                        'ub_item'        => '完成订单获得返还',
                        'user_id'        => $order_info['user_id'],
                        'ub_number'      => $order_info['order_sn'],
                        'ub_description' => '订单' . $order_info['order_sn'] . '完成，获得订单返还金额'
                    ]);
                } else {
                    $update['user_score'] = $user_info['user_score'] + $wallet_change;
                    $this->db->insert('points_log', [
                        'user_id'        => $order_info['user_id'],
                        'user_name'      => $user_info['user_name'],
                        'pl_type'        => 1,
                        'pl_variation'   => $wallet_change,
                        'pl_score'       => $update['user_score'],
                        'pl_item'        => '消费返积分',
                        'pl_description' => '家洁订单' . $order_info['order_sn'] . '消费返积分',
                        'pl_time'        => $_SERVER['REQUEST_TIME'],
                        'pl_code'        => 5
                    ]);
                }
            } elseif ($order_info['order_deductible_type'] != 0 && $order_info['order_actual_amount'] != 0) {
                // 场景3：订单使用了金额（或积分）不完全抵扣，仍需支付剩余的部分，则分开返还
                if ($order_info['order_deductible_type'] == 1) { //1：余额抵扣
                    $wallet_change          = sprintf('%.2f', ($order_info['order_amount'] / 100) * $consumption_return_ratio);
                    $update['user_balance'] = $user_info['user_balance'] + $wallet_change;
                    $this->db->insert('userbalance', [
                        'ub_type'        => 1,
                        'ub_money'       => $wallet_change,
                        'ub_balance'     => $update['user_balance'],
                        'ub_time'        => $_SERVER['REQUEST_TIME'],
                        'ub_item'        => '完成订单获得返还',
                        'user_id'        => $order_info['user_id'],
                        'ub_number'      => $order_info['order_sn'],
                        'ub_description' => '订单' . $order_info['order_sn'] . '完成，获得订单返还金额'
                    ]);
                } else {
                    $order_deductible_count = sprintf('%.2f', $order_info['order_deductible_count'] / 100); // 抵扣了的金额，单位元
                    $deductible_refund      = sprintf('%.2f', $order_deductible_count * $consumption_return_ratio); // 抵扣部分的返还

                    $update['user_score'] = $user_info['user_score'] + $deductible_refund;
                    $this->db->insert('points_log', [
                        'user_id'        => $order_info['user_id'],
                        'user_name'      => $user_info['user_name'],
                        'pl_type'        => 1,
                        'pl_variation'   => $deductible_refund,
                        'pl_item'        => '消费返积分',
                        'pl_description' => '家洁订单' . $order_info['order_sn'] . '消费返积分',
                        'pl_time'        => $_SERVER['REQUEST_TIME'],
                        'pl_code'        => 5,
                        'pl_score'       => $update['user_score']
                    ]);

                    $user_balance_change    = sprintf('%.2f', $order_actual_amount * $consumption_return_ratio); // 实际支付部分的返还，单位元
                    $update['user_balance'] = $user_info['user_balance'] + $user_balance_change;
                    $this->db->insert('userbalance', [
                        'ub_type'        => 1,
                        'ub_money'       => $user_balance_change,
                        'ub_balance'     => $update['user_balance'],
                        'ub_time'        => $_SERVER['REQUEST_TIME'],
                        'ub_item'        => '完成订单获得返还',
                        'user_id'        => $order_info['user_id'],
                        'ub_number'      => $order_info['order_sn'],
                        'ub_description' => '订单' . $order_info['order_sn'] . '完成，获得订单返还金额'
                    ]);
                }
            }
            $update && $this->db->update('user', $update, ['user_id' => $order_info['user_id']]); // 执行返还
            // +---------------------------------------------------------------------------------------------------
            // | 旧的返还策略，从实际消费金额中返还
            // +---------------------------------------------------------------------------------------------------
            // 返还积分 = 实际消费金额 * 返还比例
//            $update['user_score'] = $order_actual_amount * $consumption_return_ratio + $user_info['user_score'];
//            $this->db->update('user', $update, ['user_id' => $order_info['user_id']]);
//            $this->db->insert('points_log', [
//                'user_id'        => $order_info['user_id'],
//                'user_name'      => $user_info['user_name'],
//                'pl_type'        => 1,
//                'pl_variation'   => $update['user_score'],
//                'pl_item'        => '消费返积分',
//                'pl_description' => '家洁订单' . $order_info['order_sn'] . '消费返积分',
//                'pl_time'        => time(),
//                'pl_code'        => 5
//            ]);
        }
    }
}
