<?php

class Home_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /*********************************** 获取一条门店信息 ***********************************/

    /**
     * [get_store_one 获取一条门店信息]
     * @param  [int]    $store_id  [传入的门店id]
     * @return [array]             [返回查询到的数据]
     */
    public function get_store_one($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $a_data  = $this->db->get_row('store', $a_where);
        return $a_data;
    }

    /*********************************** 获取门店所有房间 ***********************************/

    public function get_office_total($store_id)
    {
        $a_where  = [
            'store_id' => $store_id,
        ];
        $i_result = $this->db->get_total('office', $a_where);
        return $i_result;
    }

    /******************************* 获取门店不同状态房间总数 *******************************/

    public function get_office_state($store_id, $office_state)
    {
        $a_where  = [
            'store_id'     => $store_id,
            'office_state' => $office_state,
        ];
        $i_result = $this->db->get_total('office', $a_where);
        return $i_result;
    }

    /******************************* 获取最新未选门店的订单 *******************************/

    public function get_nearby_order()
    {
        $a_where = [
            'order_state' => 20,
            'store_id'    => '',
        ];
        $s_field = 'b.user_name,b.user_pic,a.order_time,a.addres_post,a.time_delay,a.order_price,a.order_id';
        $a_order = [
            'order_id' => 'desc',
        ];
        $a_orde  = $this->db->from('order as a')
            ->join('user as b', ['b.user_id' => 'a.user_id'])
            ->get_total('', $a_where, $s_field, $a_order);
        //门店的坐标
        $a_storeb = $this->db->get_row('store', ['store_id' => $_SESSION['store_id']], ['store_position', 'order_distance']);
        $store    = explode(",", $a_storeb['store_position']);
        $a_store  = [];
        for ($i = 0; $i < $a_orde; $i++) {
            $order       = explode(",", $a_orde[$i]['addres_post']);
            $a_store[$i] = $this->getDistance($store[0], $store[1], $order[0], $order[1], 2);
            if ($a_store[$i] <= $a_storeb['order_distance']) {
                $a_storet[$i] = $a_store[$i];
                $a_ordeb [$i] = $a_orde[$i];
            }
        }
        $a_data['store'] = $a_storet;
        $a_data['orde']  = $a_ordeb;
        return $a_data;
    }

    /**
     * 计算两点地理坐标之间的距离
     * @param  Decimal $longitude1 起点经度
     * @param  Decimal $latitude1 起点纬度
     * @param  Decimal $longitude2 终点经度
     * @param  Decimal $latitude2 终点纬度
     * @param  Int $unit 单位 1:米 2:公里
     * @param  Int $decimal 精度 保留小数位数
     * @return Decimal
     */
    function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit = 2, $decimal = 2)
    {

        $EARTH_RADIUS = 6370.996; // 地球半径系数
        $PI           = 3.1415926;

        $radLat1 = $latitude1 * $PI / 180.0;
        $radLat2 = $latitude2 * $PI / 180.0;

        $radLng1 = $longitude1 * $PI / 180.0;
        $radLng2 = $longitude2 * $PI / 180.0;

        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;

        $distance = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $distance = $distance * $EARTH_RADIUS * 1000;

        if ($unit == 2) {
            $distance = $distance / 1000;
        }

        return round($distance, $decimal);
    }

    /********************************** 获取门店的最新评论 **********************************/

    public function get_comment_recently($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $s_field = 'comment_id, ' . $this->db->get_prefix() . 'user.user_id, object_id, store_id, goods_score, service_score, comment_content, comment_pic, is_anonymous, comment_time, order_number, comment_type, user_pic, user_name';
        $a_order = [
            'comment_id' => 'desc',
        ];
        $a_data  = $this->db->from('comment')
            ->join('user', [$this->db->get_prefix() . 'comment.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 4);
        return $a_data;
    }

    /********************************** 获取门店的所有评论 **********************************/

    /********************************** 获取门店的评论总数 **********************************/

    public function get_comment_total($store_id)
    {
        $a_where  = [
            'store_id' => $store_id,
        ];
        $i_result = $this->db->get_total('comment', $a_where);
        return $i_result;
    }

    /******************************** 获取门店最近的办公室 **********************************/

    /**
     * [get_comment_all 获取门店的所有评论]
     * @return [array] [返回查询到的所有评论]
     */
    public function get_comment_all($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $s_field = '';
        $a_order = [
            'comment_id' => 'desc',
        ];
        $a_data  = $this->db->get('comment', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /******************************** 获取门店停用的为公室 **********************************/

    /**
     * [get_appointment_store 获取门店最近的办公室]
     * @param  [type] $store_id [description]
     * @return [type]           [description]
     */
    public function get_appointment_store($store_id)
    {
        $a_where = [
            'store_id'         => $store_id,
            'appointment_type' => 1,
        ];
        $s_field = '';
        $a_order = [
            'appointment_id' => 'desc',
        ];
        $a_data  = $this->db->where_in('appointment_state', [1, 2, 3])->get('appointment', $a_where, $s_field, $a_order, 0, 99999999);
        return $a_data;
    }


    /******************************** 获取门店停用的为公室 **********************************/

    /**
     * [get_office_stop 获取门店停用的为公室]
     * @param  [type] $store_id [description]
     * @return [type]           [description]
     */
    public function get_office_stop($store_id)
    {
        $a_where  = [
            'store_id'     => $store_id,
            'office_state' => 0,
        ];
        $i_result = $this->db->get_total('office', $a_where);
        return $i_result;
    }

    /******************************** 获取门店咖啡订单数量 **********************************/

    /**
     * [get_coffee_month 获取门店停用的为公室]
     * @return [type] [description]
     */
    public function get_coffee_month()
    {
        $beginThismonth = mktime(0, 0, 0, date('m'), 1, date('Y'));
        $a_where        = [
            'order_time >' => $beginThismonth,
            'store_id'     => $_SESSION['store_id'],
        ];
        $s_field        = '';
        $a_order        = [
            'order_id' => 'desc',
        ];
        $a_data         = $this->db->where_in("order_state", [25, 30, 10, 80])->get('order', $a_where, $s_field, $a_order, 0, 99999999);
        return $a_data;
    }

    /********************************** 获取一条管理员信息 **********************************/

    /**
     * [get_order_state 获取门店咖啡订单数量]
     * @param  [type] $order_state [description]
     * @return [type]              [description]
     */
    public function get_order_state($order_state)
    {
        $a_where  = [
            'order_state' => $order_state,
            'store_id'    => $_SESSION['store_id'],
        ];
        $i_result = $this->db->get_total('order', $a_where);
        return $i_result;
    }

    /********************************** 修改一条管理员信息 **********************************/

    /**
     * [get_manager_one 获取一条管理员信息]
     * @param  [type] $manager_id [description]
     * @return [type]             [description]
     */
    public function get_manager_one($manager_id)
    {
        $a_where = [
            'manager_id' => $manager_id,
        ];
        $a_data  = $this->db->get_row('manager', $a_where);
        return $a_data;
    }

    /****************************************************************************************/

    /**
     * [update_manager 修改一条管理员信息]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_manager($a_where, $a_data)
    {
        $i_result = $this->db->update('manager', $a_data, $a_where);
        return $i_result;
    }

}
