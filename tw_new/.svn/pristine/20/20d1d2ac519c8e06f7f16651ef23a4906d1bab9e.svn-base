<?php
defined('BASEPATH') OR exit('禁止访问！');
date_default_timezone_set('PRC'); 
class Cron_ctrl extends TW_Controller {
    public function __construct() {
        parent :: __construct();    
        $this->prefix = $this->db->get_prefix();
    }
    public function cron() {
    //自动确认收货 开始
        $a_whert = [$this->prefix.'order_common.time_shipping <='=> 
        $_SERVER['REQUEST_TIME'] - 86400*15, 'a.order_state' => 30];      
        $a_time = $this->db
                        ->from('order as a')
                        ->join('order_common', ['a.order_id' => $this->prefix.'order_common.order_id'])
                        ->limit(0, 1000)
                        ->get('', $a_whert, ['a.order_id']);
        $a = array_column($a_time, "order_id");
        foreach ($a as $ku => $va) {
            $i_ordr_id = $this->db->update('order', ['order_state' => 40], ['order_id' => $va]);
            $a_name = [
                'order_id' => $va, 
                'log_msg' => '签收了货物 ( 超期未收货系统自动完成订单 )', 
                'log_time' => $_SERVER['REQUEST_TIME'], 
                'log_role' => '系统',
                'log_user' => '系统',
                'log_orderstate' => 40
            ];
            $this->db->insert('order_log', $a_name);
        }
        //自动确认收货 结束

        //未付款自动取消开始
        $a_tim = $this->db->get('order', ['order_state' => 10, 'time_create <' => strtotime('-1 day')], ['order_id']);
        $a = array_column($a_tim, "order_id");
        foreach ($a as $ku => $va) {
            $i_ordr_id = $this->db->update('order', ['order_state' => 0], ['order_id' => $va]);
            $a_name = [
                'order_id' => $va, 
                'log_msg' => '取消了订单 ( 超期未支付系统自动关闭订单 )', 
                'log_time' => $_SERVER['REQUEST_TIME'], 
                'log_role' => '系统',
                'log_user' => '系统',
                'log_orderstate' => 0
            ];
            $this->db->insert('order_log', $a_name);
        }  
        //未付款自动取消结束
    }
}