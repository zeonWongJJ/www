<?php

class Modetr_model extends TW_Model
{
    public function __construct()
    {
        parent:: __construct();
    }

    // 自动取消
    public function modert()
    {
        $a_data = $this->db->get('order', ['time_create <' => strtotime("-5 minute"), 'order_state' => 40], '', '', 0, 9999999999);
        foreach ($a_data as $key => $value) {
            //把返回的金额和积分返回给用户
            $a_user  = $this->db->get_row('user', ['user_id' => $value['user_id']]);
            $balance = $a_user['user_balance'] + $value['balance_deduction'];
            $score   = $a_user['user_score'] + $value['use_jife'];
            $a_usr   = [
                'user_score'   => $score,
                'user_balance' => $balance,
            ];
            $this->db->update('user', $a_usr, ['user_id' => $value['user_id']]);
            // 增加会员积分表
            if (!empty($value['use_jife'])) {
                $a_jife = [
                    'user_id'        => $a_user['user_id'],
                    'user_name'      => $a_user['user_name'],
                    'pl_type'        => 1,
                    'pl_variation'   => $value['use_jife'],
                    'pl_time'        => $_SERVER['REQUEST_TIME'],
                    'pl_score'       => $score,
                    'pl_description' => $value['order_number'] . '退还积分',
                    'pl_item'        => '退还积分',
                    'pl_code'        => 7,
                ];
                $this->db->insert('points_log', $a_jife);
            }
            // 用户资金明细表
            if (!empty($value['balance_deduction'])) {
                $a_userba = [
                    'ub_type'        => 1,
                    'ub_money'       => $value['balance_deduction'],
                    'ub_balance'     => $balance,
                    'ub_time'        => $_SERVER['REQUEST_TIME'],
                    'ub_item'        => '退还余额',
                    'user_id'        => $a_user['user_id'],
                    'ub_number'      => $value['order_number'],
                    'ub_description' => $value['order_number'] . '退还余额',
                ];
                $this->db->insert('userbalance', $a_userba);
            }
            $a_name = [
                'order_id'       => $value['order_id'],
                'log_msg'        => '取消了订单',
                'log_time'       => $_SERVER['REQUEST_TIME'],
                'log_role'       => '系统',
                'log_user'       => $a_user['user_name'],
                'log_orderstate' => 0,
            ];
            $this->db->insert('order_log', $a_name);
            $a_weifuk = $this->db->update('order', ['order_state' => 0, 'time_finnshed' => $_SERVER['REQUEST_TIME']], ['order_id' => $value['order_id'], 'user_id' => $a_user['user_id']]);
        }
        return $a_weifuk;
    }

    // 自动完成
    public function wangc()
    {
        $a_data = $this->db->get('order', ['order_time <' => strtotime("-1 day"), 'order_state' => 30], '', '', 0, 9999999999);
        foreach ($a_data as $key => $value) {
            $a_user = $this->db->get_row('user', ['user_id' => $value['user_id']]);
            $a_name = [
                'order_id'       => $value['order_id'],
                'log_msg'        => '确认了收货',
                'log_time'       => $_SERVER['REQUEST_TIME'],
                'log_role'       => '系统',
                'log_user'       => $a_user['user_name'],
                'log_orderstate' => 10,
            ];
            $this->db->insert('order_log', $a_name);
            $a_weifuk = $this->db->update('order', ['order_state' => 10, 'time_finnshed' => $_SERVER['REQUEST_TIME']], ['order_id' => $value['order_id'], 'user_id' => $a_user['user_id']]);
        }
        return $a_weifuk;
    }
}
