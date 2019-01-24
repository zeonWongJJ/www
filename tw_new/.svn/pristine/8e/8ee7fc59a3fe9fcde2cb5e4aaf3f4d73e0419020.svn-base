<?php
/**
 * Created by PhpStorm.
 * User: 7du-28
 * Date: 2018/4/25
 * Time: 16:21
 */

class ApiOrder_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }
    //餐饮订单
    // 根据门店id 服务状态 订单分页查询

    public function store_lunch_order_list($storeId, $orderState, $pageNum, $raw)
    {
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        if ($orderState == '') {
            $a_where = [
                'store_id' => $storeId,
            ];
        } else {
            $a_where = [
                'store_id'    => $storeId,
                'order_state' => $orderState,
            ];
        }
        $i_total = $this->db->get_total('order', $a_where);
        if ($pageNum > ceil($i_total / $raw)) {
            return [];
        }
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $pageNum, $raw);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);
        $s_field = 'o.order_id,o.order_number,o.order_state,o.store_name,o.user_name,o.goods_amount,o.time_create,u.user_id,u.user_pic';
        //$s_field = 'u.user_pic,u.user_id,o.order_id,o.store_id';
        $a_order = [
            'order_id' => 'desc',
        ];
        $a_data  = $this->db->from('order as o')
            ->join('user as u', ['o.user_id' => 'u.user_id'])
            ->get('', $a_where, $s_field, $a_order);

        return $a_data;
    }

    /**
     * [get_store_one description]
     * @param  [type] $store_id [description]
     * @return [type]           [description]
     */
    public function get_store_one($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $a_data  = $this->db->get_row('store', $a_where);
        return $a_data;
    }

    public function get_order_goods_list($order_id)
    {
        $a_where = [
            'order_id' => $order_id,
        ];
        $a_data  = $this->db->get('order_goods', $a_where);
        return $a_data;
    }

    public function lunch_order_detail($orderId)
    {
        $a_where = [
            'order_id' => $orderId,
        ];
        /*payment_code 支付方式名称代码 offline微信付款、online在线支付、alipay支付宝、unionpay银联网关支付、cashier线下支付*/
        $s_field = 'o.order_id,o.order_number,o.order_state,o.store_name,o.user_name,o.goods_amount,o.time_create,u.user_id,u.user_pic,o.time_delay,o.payment_code,o.addres,o.reciver_name,o.mob_phone,o.use_jife,o.use_points,o.goods_feng,o.shipping_fee';
        //$s_field = 'u.user_pic,u.user_id,o.order_id,o.store_id';
        $a_data = $this->db->from('order as o')
            ->join('user as u', ['o.user_id' => 'u.user_id'])
            ->get_row('', $a_where, $s_field);
        return $a_data;
    }
    //会议订单  座位订单
    // 根据门店id 服务状态 订单分页查询
    public function store_meeting_seat_order_list($storeId, $appointmentState, $appointmentType, $pageNum, $raw)
    {
        // 先设置默认从第一页开始
        if (empty($pageNum)) {
            $pageNum = 1;
        }
        // 设置每页显示的数据行数
        if (empty($raw)) {
            $raw = 10;
        }
        // 加载分页类
        $this->load->library('pages');
        if ($appointmentState == 'default') {
            $a_where = [
                'store_id' => $storeId, 'appointment_type' => $appointmentType,
            ];
        } else {
            $a_where = [
                'store_id' => $storeId, 'appointment_state' => $appointmentState, 'appointment_type' => $appointmentType,
            ];
        }
        // 获取数据总行数，以产品为例
        $i_total = $this->db->get_total('appointment', $a_where);
        if ($pageNum > ceil($i_total / $raw)) {
            return [];
        }
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $pageNum, $raw);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        //$s_field = 'goods_id, goods_name';

        //$a_data = $this->db->get('appointment', $a_where, "", $a_order);
        $s_field = 'o.appointment_id,o.office_id,o.store_id,o.office_seat,o.office_seatname,o.room_id,o.room_name,o.room_type,o.linkman,o.link_phone,o.arrival_time,o.appointment_time,o.officeseat_state,o.appointment_number,o.appointment_state,o.complete_msg,o.appointment_type,o.appointment_price,o.appointment_date,o.actual_pay,o.pay_type,u.user_pic,u.user_id,u.user_name';
        //$s_field = 'u.user_pic,u.user_id,o.order_id,o.store_id';
        $a_order = [
            'appointment_id' => 'desc',
        ];
        $a_data  = $this->db->from('appointment as o')
            ->join('user as u', ['o.user_id' => 'u.user_id'])
            ->get('', $a_where, $s_field, $a_order);
        return $a_data;
    }

    public function meeting_seat_order_detail($appointmentId)
    {
        $a_where = [
            'appointment_id' => $appointmentId,
        ];
        $s_field = 'o.appointment_id,o.office_id,o.store_id,o.office_seat,o.office_seatname,o.room_id,o.room_name,o.room_type,o.linkman,o.link_phone,o.arrival_time,o.appointment_time,o.officeseat_state,o.appointment_number,o.appointment_state,o.complete_msg,o.appointment_type,o.appointment_price,o.appointment_date,o.actual_pay,o.pay_type,o.begin_time,o.end_time,u.user_pic,u.user_id,u.user_name';
        $a_data  = $this->db->from('appointment as o')
            ->join('user as u', ['o.user_id' => 'u.user_id'])
            ->get_row('', $a_where, $s_field);
        //$a_data =$this->db->get_row('appointment', $a_where,$s_field);
        return $a_data;
    }

    public function get_room_row_by_room_id($room_id)
    {
        $a_where = [
            'room_id' => $room_id,
        ];
        $a_data  = $this->db->get_row('room', $a_where);
        return $a_data;
    }
}
