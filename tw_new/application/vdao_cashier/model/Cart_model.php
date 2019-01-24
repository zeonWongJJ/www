<?php

class Cart_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    // 合并产品
    public function merge($a_cart)
    {
        // 是否已经合并
        $b_merge = false;

        // 检查产品是否存在，存在就在数量上增加, FILE_APPEND
        if (is_array($_SESSION['cashier']['cart']) && !empty($_SESSION['cashier']['cart'])) {
            foreach ($_SESSION['cashier']['cart'] as $i_key => $a_val) {
                if ($a_val['product_id'] == $a_cart['product_id'] && $a_val['price_id'] == $a_cart['price_id']) {
                    if (is_array($a_val['attr']) && is_array($a_cart['attr'])) {
                        // 如果都选择了属性，对比选择的属性是否一致
                        $i_count     = count($a_val['attr']);
                        $b_identical = $i_count ? true : false;
                        for ($i_i = 0; $i_i < $i_count; $i_i++) {
                            if ($a_val['attr'][$i_i]['attr_name'] != $a_cart['attr'][$i_i]['attr_name']) {
                                $b_identical = false;
                            }
                        }
                        // 属性一样，数量加起来
                        if ($b_identical) {
                            $_SESSION['cashier']['cart'][$i_key]['num'] += $a_cart['num'];
                            $b_merge                                    = true;
                        }

                    } else {
                        // 都没选择属性，那肯定是同一样的产品
                        $_SESSION['cashier']['cart'][$i_key]['num'] += $a_cart['num'];
                        $b_merge                                    = true;
                    }
                }
            }
        }
        if (!$b_merge) {
            $_SESSION['cashier']['cart'][] = $a_cart;
        }
    }

    // 返回购物车数据
    public function data()
    {
        $a_json         = [];
        $a_json['cart'] = $_SESSION['cashier']['cart'];
        $this->total();
        $a_json['product_num']   = $_SESSION['cashier']['cart_product_num'];
        $a_json['product_money'] = strval($_SESSION['cashier']['cart_product_money']);
        return $a_json;
    }

    // 统计购物车中商品数量，和总金额
    public function total()
    {
        if (!isset($_SESSION['cashier']['cart']) || !is_array($_SESSION['cashier']['cart'])) {
            return;
        }
        $i_num   = 0;
        $i_money = 0;
        foreach ($_SESSION['cashier']['cart'] as $i_key => $a_val) {
            $i_num   += $a_val['num'];
            $i_money += $a_val['price'] * $a_val['num'];
        }
        $_SESSION['cashier']['cart_product_num']   = $i_num;
        $_SESSION['cashier']['cart_product_money'] = $i_money;
    }

    // 查询支付宝支付结果
    public function query_ali($s_order_number)
    {
        $this->load->library('alipay_f2f');
        $a_param  = [
            // 订单支付时传入的商户订单号,和支付宝交易号不能同时为空。trade_no,out_trade_no如果同时存在优先取trade_no
            'out_trade_no' => $s_order_number,
            // 支付宝交易号，和商户订单号不能同时为空
            // 'trade_no' => ''
        ];
        $a_result = $this->alipay_f2f->query($a_param);
        if ($a_result['trade_status'] == 'TRADE_SUCCESS') {
            $this->order_complete($a_result['out_trade_no'], $a_result['total_amount'], 'alipay', $a_result['trade_no']);
            /*$a_data = [
                'order_state' => 20,
                'payment_code' => 'alipay',
                'order_time' => $_SERVER['REQUEST_TIME']
            ];
            $a_where = [
                'order_number' => $a_result['out_trade_no'],
                'order_state' => 40,
                'order_price' => $a_result['total_amount'],
            ];
            $this->db->update('order', $a_data, $a_where);
            //echo $this->db->get_sql();
            //更新订单历史表tw_order_log
            $a_data_log = [
                'log_msg' => '已收到货款(微信支付)'. $a_result['trade_no'],
                'log_time' => $_SERVER['REQUEST_TIME'],
                'log_role' => '系统',
                'log_user' => '系统',
                'log_orderstate' => 20
            ];
            $this->db->update('order_log', $a_data_log, ['order_id' => $a_result['out_trade_no']]);*/
        }
    }

    // 更新订单为已付款
    public function order_complete($s_order_number, $money, $s_pay_mode = 'offline', $s_transaction_id = '')
    {
        $a_data  = [
            // 'store_id' => $_SESSION['store_id'],
            // 'store_name' => $_SESSION['store_name'],
            'order_state'   => 10,
            'payment_code'  => $s_pay_mode,
            'order_time'    => time(),
            'time_finnshed' => time(),
        ];
        $a_where = [
            'order_number' => $s_order_number,

            /*
             参数被转义为字符串形式，如'0.01'，
             正因为加了单引号后变成字符串，而数据库中的字段为数字类型，mysql比较的时候会判断为不一样
             这种情况目前只在有小数点的时候出现
             */
        ];
        // 改用字符串形式
        $where = "`order_number`={$s_order_number} AND `order_state`=40 AND `order_price`={$money}";
        $i_res = $this->db->update('order', $a_data, $where);
        if ($i_res) {

            $a_tert = $this->db->get_row("order", ['order_number' => $s_order_number]);

            $this->update_accounttbls($a_tert['store_id'], $a_tert['order_price'], 0, $a_tert['order_count'], date("Ym", $a_tert['time_create']));

            //file_put_contents('/data/www/tw/web/vdao_cashier/1.txt', print_r($this->db->get_sql(), true));
            //更新订单历史表tw_order_log
            $a_data_log = [
                'log_msg'        => '已收到货款(支付宝支付)' . $s_transaction_id,
                'log_time'       => $_SERVER['REQUEST_TIME'],
                'log_role'       => '系统',
                'log_user'       => '系统',
                'log_orderstate' => 20,
            ];
            $this->db->update('order_log', $a_data_log, ['order_id' => $a_tert['order_id']]);
        }

    }

    /**
     * 更新月结统计表
     * )
     *
     */
    public function update_accounttbls($store_id, $order_price = 0.00, $month_score = 0.00, $product_count = 0, $account_date)
    {
        $fields_config = [
            '1' => 'order_count',//月订单总数
            '2' => 'product_count',
            '3' => 'money_count',//月销售总额
            '4' => 'office_ordercount',
            '5' => 'office_money',//会议订单总额
            '6' => 'month_score',
        ];
        //订单统计
        $num           = 1;
        $account_date  = $account_date ? $account_date : date('Ym');
        $month_score   = $month_score ? $month_score : 0;
        $update_fields = "order_count=order_count+$num,product_count =product_count +$product_count , money_count=money_count+$order_price ,
	       		month_score = month_score +$month_score";
        $sql           = "INSERT INTO '.$this-db->get_prefix().'accounttbl(store_id,account_date,order_count,money_count,month_score,product_count)
	                    VALUES ('{$store_id}','{$account_date}',{$num},{$order_price},{$month_score},{$product_count})
	                    ON DUPLICATE KEY UPDATE {$update_fields}";
        $this->db->query($sql);

    }
}