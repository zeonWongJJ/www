<?php

class Home_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    //日销售额
    public function forehead()
    {

        $a_sales = $this->db->get_total('order');
        return $a_sales;
    }

    //总订单
    public function order()
    {
        //各订单数
        $s_fields      = 'order_state,count(1) as num';
        $s_group_by    = 'order_state';
        $a_data_result = $this->db
            ->select($s_fields, false)
            ->group_by($s_group_by)
            ->get('order');
        foreach ($a_data_result as $key => $value) {
            $a_result[$value['order_state']] = $value['num'];
        }
        $or    = isset($a_result['10']) ? intval($a_result['10']) : 0;
        $ord   = isset($a_result['20']) ? intval($a_result['20']) : 0;
        $orde  = isset($a_result['25']) ? intval($a_result['25']) : 0;
        $order = isset($a_result['30']) ? intval($a_result['30']) : 0;
        $rder  = isset($a_result['80']) ? intval($a_result['80']) : 0;
        $order = $or + $ord + $orde + $order + $rder;
        return $order;
    }

    //订单总数
    public function order_total()
    {
        $a_where = 'order_state >= 9 AND order_state != 40';
        $i_total = $this->db->get_total("order", $a_where);
        return $i_total;
    }

    //当天的销售额和订单数
    public function today_order()
    {
        $a_where = 'order_state >= 9 AND order_state != 40';
        return $this->db->select("IFNULL(sum(order_price),0) as order_price,count(order_id) as count", false)
            ->where(['time_create' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))])
            ->get_row('order', $a_where);

    }

    //总销售额
    public function sales()
    {
        $a_where = 'order_state >= 9 AND order_state != 40';
        $a_sales = $this->db->select("SUM(order_price) as order_price", false)->get_row('order', $a_where);
        return $a_sales['order_price'];

    }

    // 月增长
    public function yuezezhan()
    {
        // 上月订单增长
        $i_account = $this->db->get('account', ['account_time' => mktime(0, 0, 0, date('m') - 1, 1, date('Y'))], ['order_count']);
        $i_acco    = 0;
        foreach ($i_account as $kaccs) {
            $i_acco += $kaccs['order_count'];
        }
        $a_data['acco'] = $i_acco;
        // 本月订单
        $i_accot  = $this->db->get('account', ['account_time' => mktime(0, 0, 0, date('m'), 1, date('Y'))], ['order_count']);
        $i_accott = 0;
        foreach ($i_accot as $kaccs) {
            $i_accott += $kaccs['order_count'];
        }
        $a_data['accott'] = $i_accott;
        // 上月用户
        $a_data['user'] = $this->db->where(['user_regtime >=' => mktime(0, 0, 0, date('m') - 1, 1, date('Y')), 'user_regtime <=' => mktime(23, 59, 59, date("m"), 0, date("Y"))])->get_total('user');
        //本月用户
        $a_data['user_ben'] = $this->db->where(['user_regtime >=' => mktime(0, 0, 0, date('m'), 1, date('Y')), 'user_regtime <=' => mktime(23, 59, 59, date('m'), date('t'), date('Y'))])->get_total('user');
        // 上月门店
        $a_data['store'] = $this->db->where(['store_regtime >=' => mktime(0, 0, 0, date('m') - 1, 1, date('Y')), 'store_regtime <=' => mktime(23, 59, 59, date("m"), 0, date("Y"))])->get_total('store');
        // 本月门店
        $a_data['stor_ben'] = $this->db->where(['store_regtime >=' => mktime(0, 0, 0, date('m'), 1, date('Y')), 'store_regtime <=' => mktime(23, 59, 59, date('m'), date('t'), date('Y'))])->get_total('store');
        // 上月移动店主
        $a_data['shop'] = $this->db->where(['shopman_regtime >=' => mktime(0, 0, 0, date('m') - 1, 1, date('Y')), 'shopman_regtime <=' => mktime(23, 59, 59, date("m"), 0, date("Y")), 'is_shopman' => 1])->get_total('user');
        //本月移动店主
        $a_data['shop_ben'] = $this->db->where(['shopman_regtime >=' => mktime(0, 0, 0, date('m'), 1, date('Y')), 'shopman_regtime <=' => mktime(23, 59, 59, date('m'), date('t'), date('Y')), 'is_shopman' => 1])->get_total('user');

        return $a_data;
    }
}
