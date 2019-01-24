<?php
/**
 * 需求模型
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

use utils\BaseModel;

/**
 * Class DemandModel
 * @package model
 */
class DemandModel extends BaseModel
{
    /**
     * 审核需求
     * @param int|array $id
     * @return mixed
     */
    public function examineDemand($id)
    {
        if (\is_array($id)) {
            $query = $this->db->where_in('id', $id);
        } else {
            $query = $this->db->where(compact('id'));
        }

        $query->update('jiajie_demand', ['demand_is_show' => 1]);
        return $this->success(false);
    }

    /**
     * 需求退款
     * @param array $row
     */
    public function refundOrder(array $row)
    {
        $user_info = $this->db->get_row('user', ['user_id' => $row['user_id']]);

        if ($row['order_deductible_type'] == 1) { // 订单使用了余额抵扣，返还抵扣的到余额
            $update = [
                'user_balance' => sprintf(
                    '%.2f'
                    , ($user_info['user_balance'] * 100 + $row['order_deductible_count'] + $row['order_actual_amount']) / 100)
            ];
            $this->db->insert('userbalance', [
                'ub_type'          => 1
                , 'ub_money'       => sprintf('%.2f', ($row['order_deductible_count'] + $row['order_actual_amount']) / 100)
                , 'ub_balance'     => $update['user_balance']
                , 'ub_time'        => $_SERVER['REQUEST_TIME']
                , 'ub_item'        => '退还金额'
                , 'user_id'        => $row['user_id']
                , 'ub_number'      => $row['order_sn']
                , 'ub_description' => '订单号' . $row['order_sn'] . '过期退还金额'
            ]);
        }  elseif ($row['order_deductible_type'] == 2) { // 使用了积分抵扣，返回抵扣的到积分
            $update = [
                'user_score'     => sprintf(
                    '%.2f'
                    , ($user_info['user_score'] * 100 + $row['order_deductible_count']) / 100
                )
                , 'user_balance' => sprintf(
                    '%.2f'
                    , ($user_info['user_balance'] * 100 + $row['order_actual_amount']) / 100
                )
            ];
            $this->db->insert('userbalance', [
                'ub_type'          => 1
                , 'ub_money'       => sprintf('%.2f', $row['order_actual_amount'] / 100)
                , 'ub_balance'     => $update['user_balance']
                , 'ub_time'        => $_SERVER['REQUEST_TIME']
                , 'ub_item'        => '退还金额'
                , 'user_id'        => $row['user_id']
                , 'ub_number'      => $row['order_sn']
                , 'ub_description' => '订单号' . $row['order_sn'] . '过期退还金额'
            ]);
            $this->db->insert('points_log', [
                'user_id'          => $row['user_id']
                , 'user_name'      => $user_info['user_name']
                , 'pl_type'        => 1
                , 'pl_variation'   => sprintf('%.2f', $row['order_deductible_count'] / 100)
                , 'pl_score'       => $update['user_score']
                , 'pl_item'        => '退还积分'
                , 'pl_description' => '订单号' . $row['order_sn'] . '过期退还积分'
                , 'pl_time'        => $_SERVER['REQUEST_TIME']
                , 'pl_code'        => 4
            ]);
        } else { // 没有使用抵扣，退还订单金额到用户余额中
            $update['user_balance'] = sprintf(
                '%.2f'
                , ($user_info['user_balance'] * 100 + $row['order_amount']) / 100
            );
            $this->db->insert('userbalance', [
                'ub_type'          => 1
                , 'ub_money'       => sprintf('%.2f', $row['order_amount'] / 100)
                , 'ub_balance'     => $update['user_balance']
                , 'ub_time'        => $_SERVER['REQUEST_TIME']
                , 'ub_item'        => '退还金额'
                , 'user_id'        => $row['user_id']
                , 'ub_number'      => $row['order_sn']
                , 'ub_description' => '订单号' . $row['order_sn'] . '过期退还金额'
            ]);
        }

//        $update['user_balance'] = number_format($update['user_balance'], 2);
//        $update['user_score']   = number_format($update['user_score'], 2);

        $this->db->update('user', $update, ['user_id' => $row['user_id']]);
        $this->db->update(get_table('order'), [
            'order_state'       => 4
            , 'order_refund'    => 1
            , 'order_refund_at' => $_SERVER['REQUEST_TIME']
        ], ['order_sn' => $row['order_sn']]);
        $this->db->insert(get_table('order_log'), [
            'order_sn' => $row['order_sn']
            , 'log_at' => $_SERVER['REQUEST_TIME']
            , 'log'    => '订单' . $row['order_sn'] . '由于失效已被系统自动取消，资金退回'
            , 'uid'    => 0
        ]);
    }
}
