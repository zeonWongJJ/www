<?php

class Delivery_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************ 获取所有设置信息 ************************************/

    /**
     * [get_set_all 获取所有设置信息]
     * @return [array] [返回查询到的所有数据]
     */
    public function get_set_all()
    {
        $a_order = [
            'set_id' => 'desc',
        ];
        $a_data  = $this->db->get('set', [], '', $a_order, 0, 999999);
        return $a_data;
    }

    /************************************ 获取一条订单信息 ************************************/

    /**
     * [get_order_one 获取一条订单信息]
     * @param  [int]   $order_id [传入的订单id]
     * @return [array]           [返回查询到的数据]
     */
    public function get_order_one($order_id)
    {
        $a_where = [
            'order_id' => $order_id,
        ];
        $a_data  = $this->db->get_row('order', $a_where);
        return $a_data;
    }

    /************************************ 获取一条用户信息 ************************************/

    /**
     * [get_user_one 获取一条用户信息]
     * @param  [int]   $user_id [传入的用户id]
     * @return [array]          [返回查询到的数据]
     */
    public function get_user_one($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        $a_data  = $this->db->get_row('user', $a_where);
        return $a_data;
    }

    /************************************ 更新一条订单信息 ************************************/

    /**
     * [update_order 更新一条订单信息]
     * @param  [array] $a_where [更新的条件]
     * @param  [array] $a_data  [更新的数据]
     * @return [int]            [返回更新的行数]
     */
    public function update_order($a_where, $a_data)
    {
        $i_result = $this->db->update('order', $a_data, $a_where);
        return $i_result;
    }

    /************************************ 更新一条用户信息 ************************************/

    /**
     * [update_user 更新一条用户信息]
     * @param  [array] $a_where [更新的条件]
     * @param  [array] $a_data  [更新的数据]
     * @return [int]            [返回更新的行数]
     */
    public function update_user($a_where, $a_data)
    {
        $i_result = $this->db->update('user', $a_data, $a_where);
        return $i_result;
    }

    /************************************ 获取一条结算信息 ************************************/

    /**
     * [get_account_one 获取一条结算信息]
     * @param  [int]   $account_time [结算时间戳]
     * @param  [int]   $store_id     [门店id]
     * @return [array]               [返回查询到的数据]
     */
    public function get_account_one($account_time, $store_id)
    {
        $a_where = [
            'account_time' => $account_time,
            'store_id'     => $store_id,
        ];
        $a_data  = $this->db->get_row('account', $a_where);
        return $a_data;
    }

    /************************************ 更新一条结算信息 ************************************/

    /**
     * [update_account 更新一条结算信息]
     * @param  [array] $a_where [更新的条件]
     * @param  [array] $a_data  [更新的数据]
     * @return [int]            [返回更新的行数]
     */
    public function update_account($a_where, $a_data)
    {
        $i_result = $this->db->update('account', $a_data, $a_where);
        return $i_result;
    }

    /************************************ 插入一条结算信息 ************************************/

    /**
     * [insert_account 插入一条结算信息]
     * @param  [array] $a_data [要插入的数据]
     * @return [int]           [返回新数据的id]
     */
    public function insert_account($a_data)
    {
        $i_result = $this->db->insert('account', $a_data);
        return $i_result;
    }

    /************************************ 获取一条统计数据 ************************************/

    /**
     * [get_statistic_one 获取一条统计数据]
     * @param  [int]   $user_id  [传入的用户id]
     * @param  [int]   $sta_time [传入的月份起始时间戳]
     * @return [array]           [返回查询到的数据]
     */
    public function get_statistic_one($user_id, $sta_time)
    {
        $a_where = [
            'user_id'  => $user_id,
            'sta_time' => $sta_time,
        ];
        $a_data  = $this->db->get_row('statistic', $a_where);
        return $a_data;
    }

    /************************************ 修改一条统计数据 ************************************/

    /**
     * [update_statistic 修改一条统计数据]
     * @param  [array] $a_where [修改的条件]
     * @param  [array] $a_data  [修改的数据]
     * @return [int]            [返回修改的行数]
     */
    public function update_statistic($a_where, $a_data)
    {
        $i_result = $this->db->update('statistic', $a_data, $a_where);
        return $i_result;
    }

    /************************************ 插入一条统计数据 ************************************/

    /**
     * [insert_statistic 插入一条统计数据]
     * @param  [array] $a_data [插入的数据]
     * @return [inbt]          [返回新数据的行数]
     */
    public function insert_statistic($a_data)
    {
        $i_result = $this->db->insert('statistic', $a_data);
        return $i_result;
    }

    /********************************** 插入一条积分变动记录 **********************************/

    /**
     * [insert_points_log 插入一条积分变动记录]
     * @param  [array] $a_data [要插入的数据]
     * @return [int]           [返回新数据的id]
     */
    public function insert_points_log($a_data)
    {
        $i_result = $this->db->insert('points_log', $a_data);
        return $i_result;
    }

    /************************************ 获取一条门店信息 ************************************/

    public function get_store_one($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $a_data  = $this->db->get_row('store', $a_where);
        return $a_data;
    }

    /************************************ 更新一条门店信息 ************************************/

    public function update_store($a_where, $a_data)
    {
        $i_result = $this->db->update('store', $a_data, $a_where);
        return $i_result;
    }

    /********************************* 插入一条门店积分变动信息 *******************************/

    public function insert_storescore($a_data)
    {
        $i_result = $this->db->insert('storescore', $a_data);
        return $i_result;
    }

    /********************************* 获取某订单下所有的产品 *********************************/

    public function get_order_goods($order_id)
    {
        $a_where = [
            'order_id' => $order_id,
        ];
        $s_field = '';
        $a_order = [
            'rec_id' => 'desc',
        ];
        $a_data  = $this->db->get('order_goods', $a_where, $s_field, $a_order, 0, 9999999999);
        return $a_data;
    }

    public function get_pro_sto($product_id)
    {
        $a_where = [
            'product_id' => $product_id,
            'store_id'   => $_SESSION['store_id'],
        ];
        $a_data  = $this->db->get_row('prod_sto', $a_where);
        return $a_data;
    }

    public function get_stock_one($product_id)
    {
        // 当日的开始时间戳
        $start   = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $a_where = [
            'product_id' => $product_id,
            'store_id'   => $_SESSION['store_id'],
            'stock_time' => $start,
        ];
        $a_data  = $this->db->get_row('stock', $a_where);
        return $a_data;
    }

    public function insert_stock($a_data)
    {
        $i_result = $this->db->insert('stock', $a_data);
        return $i_result;
    }

    public function update_stock($a_where, $a_data)
    {
        $i_result = $this->db->update('stock', $a_data, $a_where);
        return $i_result;
    }

    /******************************************************************************************/

}
