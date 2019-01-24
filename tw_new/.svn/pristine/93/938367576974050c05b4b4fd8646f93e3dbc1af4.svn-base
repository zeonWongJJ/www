<?php

class Store_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************* 附近门店 *************************************/

    /**
     * [get_stroe_nearby 获取附近的门店]
     * @return [array] [返回查询到的门店信息]
     */
    public function get_stroe_nearby($store_citycode)
    {
        $a_where = [
            'store_state'    => 1,
            'store_citycode' => $store_citycode,
        ];
        $s_field = '';
        $a_order = [
            'store_id' => 'desc',
        ];
        $a_data  = $this->db->get('store', $a_where, $s_field, $a_order, 0, 999999999);
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
    function get_distance($longitude1, $latitude1, $longitude2, $latitude2, $unit = 2, $decimal = 2)
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

    /*************************************新版 附近门店 *************************************/

    /**
     * [get_stroe_nearby 获取附近的门店]
     * [type  查找附近门店的类型条件1:好评优先2:起送价最低3:销量最高4:距离最近0:综合排序]
     * @return [array] [返回查询到的门店信息]
     */
    public function new_get_stroe_nearby($store_citycode, $type = 0)
    {
        $a_where = [
            'store_state'    => 1,
            'store_citycode' => $store_citycode,
        ];
        $s_field = '';
        $a_order = [
            'store_id' => 'desc',
        ];
        $a_data  = $this->db->get('store', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /*************************************新版 附近门店月销售量 *************************************/

    /**
     * [get_stroe_order_sale 获取门店的月销售量]
     * [store  门店id]
     * @return [array] [返回查询到的门店信息]
     */
    public function get_stroe_order_sale($store)
    {
        $a_where = [

            'store_id'      => $store,
            'time_create >' => strtotime(date('Y-m-01 00:00:00')),
            'time_create <' => time(),

        ];

        $a_data = $this->db->where_in("order_state", [25, 30, 10, 80])->get_total('order', $a_where, 0, 999999999999);
        // echo $this->db->get_sql();
        return $a_data;
    }

    /*************************************新版 附近门店月销售量最好的产品 *************************************/

    /**
     * [get_stroe_prod_sale 获取门店月销售量最好的产品 ]
     * [store  门店id]
     * [number 需要返回多少个销量产品]
     * @return [array] [返回查询到的门店信息]
     */
    public function get_stroe_prod_sale($store, $number = 3)
    {
        $a_sele = "a.product_id,a.product_name,a.antistop,a.pro_details,a.pro_img,p.price,d.number,a.supply_time";
        $a_data = $this->db->group_by("a.product_id")->from('product as a')
            // ->join('comment_product as b', ['a.product_id' => 'b.product_id'])
            ->join('product_number as d', ['a.product_id' => 'd.product_id'])
            ->join("price as p ", ['a.product_id' => 'p.product_id'])
            ->where('a.product_id in (select product_id from ' . $this->db->get_prefix() . 'prod_sto where prod_show =1)', null, false)
            ->limit(0, $number)
            ->get('', ['a.pro_show' => 1, 'a.goods_stye' => 1], $a_sele, ['d.number' => 'desc']);
        // echo $this->db->get_sql();
        return $a_data;
    }

    /********************************* 获取一条门店信息 *********************************/

    /**
     * [get_store_one 获取一条门店信息]
     * @param  [int]   $store_id [传入的门店id]
     * @return [array]           [返回查询到的数据]
     */
    public function get_store_one($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $a_data  = $this->db->get_row('store', $a_where);
        return $a_data;
    }

    /*********************************** 获取房间设备 ***********************************/

    /**
     * [get_romm_device 获取部分设备信息]
     * @param  [array]   $a_data     [要获取的设备id数组]
     * @return [array]   $i_result   [返回获取到的数据]
     */
    public function get_room_device($device_ids)
    {
        $a_where = [
            'device_state' => 1,
        ];
        $a_data  = $this->db->where_in('device_id', $device_ids)->get('device', $a_where);
        return $a_data;
    }

    /****************************** 获取一条共享办公室数据 ******************************/

    /**
     * [get_office_one 根据id获取一条共享办公室数据]
     * @param  [int]   $office_id [传入的id]
     * @return [array]            [返回查询到数据]
     */
    public function get_office_one($office_id)
    {
        $a_where = [
            'office_id' => $office_id,
        ];
        $a_data  = $this->db->get_row('office', $a_where);
        return $a_data;
    }

    /********************************* 获取一条房间详情 *********************************/

    /**
     * [get_room_one 根据id获取一条房间详情]
     * @param  [int]   $room_id [传入的房间id]
     * @return [array]          [description]
     */
    public function get_room_one($room_id)
    {
        $a_where = [
            'room_id' => $room_id,
        ];
        $a_data  = $this->db->get_row('room', $a_where);
        return $a_data;
    }

    /********************************* 获取一条房间分类 *********************************/

    public function get_type_one($type_id)
    {
        $a_where = [
            'type_id' => $type_id,
        ];
        $a_data  = $this->db->get_row('roomtype', $a_where);
        return $a_data;
    }

    /******************************** 获取门店所有的评论 ********************************/

    /**
     * [get_store_comment 获取门店所有的评论]
     * @param  [int]   $store_id [传入的门店id]
     * @return [array]           [返回查询到的所有评论]
     */
    public function get_store_comment($store_id)
    {
        $a_where = [
            'store_id'      => $store_id,
            'comment_state' => 1,
        ];
        $s_field = $this->db->get_prefix() . 'user.user_name,' . $this->db->get_prefix() . 'user.user_pic,' . $this->db->get_prefix() . 'comment.user_id,comment_id,object_id,comment_content,comment_time,comment_pic,store_id,goods_score,service_score,is_anonymous,comment_type,comment_tags';
        $a_order = [
            'comment_id' => 'desc',
        ];
        $a_data  = $this->db->from('comment')
            ->join('user', [$this->db->get_prefix() . 'comment.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /********************************* 获取一条用户信息 *********************************/

    /**
     * [get_user_one 获取一条用户信息]
     * @param  [int]   $user_id  [传入的用户id]
     * @return [array]           [返回查询到的用户数据]
     */
    public function get_user_one($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        $a_data  = $this->db->get_row('user', $a_where);
        return $a_data;
    }

    /******************************* 获取所有占用中的位置 *******************************/

    /**
     * [get_seat_occupy 获取所有占用中的位置]
     * @param  [int]   $office_id [传入的办公室的id]
     * @return [array]            [返回查询到的数据]
     */
    public function get_seat_occupy($office_id)
    {
        $a_where = [
            'office_id'        => $office_id,
            'officeseat_state' => 1,
        ];
        $a_data  = $this->db->get('appointment', $a_where, '', [], 0, 99999999);
        return $a_data;
    }

    /****************************** 插入一条办公室预约记录 ******************************/

    /**
     * [insert_appointment 插入一条办公室预约记录]
     * @param  [array] $a_data [要插入的信息]
     * @return [int]           [返回新数据的id]
     */
    public function insert_appointment($a_data)
    {
        $i_result = $this->db->insert('appointment', $a_data);
        return $i_result;
    }

    /********************************** 获取产品信息 **********************************/

    public function get_store_product()
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(1);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $i_total = $this->db->get_total('product', ['pro_show' => 1]);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_order = [
            'order' => 'asc',
        ];
        $a_data  = $this->db->get('product', ['pro_show' => 1], '', $a_order);
        return $a_data;
    }

    /***************************** 根据id获取一条产品信息 *****************************/

    public function get_product_one($product_id)
    {
        $a_where = [
            'product_id' => $product_id,
        ];
        $a_data  = $this->db->get_row('product', $a_where);
        return $a_data;
    }

    /****************************** 获取用户的购物车信息 ******************************/

    /**
     * [get_user_cart 获取用户的购物车信息]
     * @param  [int]   $user_id [传入的用户id]
     * @return [array]          [返回查询到的信息]
     */
    public function get_user_cart($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        $s_field = 'cart_id, user_id,prot_count,money';
        $a_order = [
            'cart_id' => 'desc',
        ];
        $a_data  = $this->db->get('cart', $a_where, $s_field, $a_order);
        return $a_data;
    }

    /****************************** 插入一条数据到购物车 ******************************/

    /**
     * [insert_cart 插入一条数据到购物车]
     * @param  [array] $a_data [要插入的数据]
     * @return [int]           [返回新数据行数]
     */
    public function insert_cart($a_data)
    {
        $i_result = $this->db->insert('cart', $a_data);
        return $i_result;
    }

    /****************************** 获取一条购物车信息 ******************************/

    /**
     * [get_cart_one 获取一条购物车信息]
     * @param  [int] $user_id    [传入的会员id]
     * @param  [int] $store_id   [传入的门店id]
     * @param  [int] $product_id [传入的产品id]
     * @param  [int] $spec       [传入的规格]
     * @param  [int] $swee       [传入的适度]
     * @param  [int] $temp       [传入的温度]
     * @return [array]           [返回查询到的购物车信息]
     */
    public function get_cart_one($user_id, $store_id, $product_id, $spec, $swee, $temp)
    {
        $a_where = [
            'user_id'    => $user_id,
            'store_id'   => $store_id,
            'product_id' => $product_id,
            'spec'       => $spec,
            'swee'       => $swee,
            'temp'       => $temp,
        ];
        $a_data  = $this->db->get_row('cart', $a_where);
        return $a_data;
    }

    /****************************** 更新一条购物车信息 ********************************/

    /**
     * [update_cart 更新一条购物车信息]
     * @param  [array] $a_where [更新的条件]
     * @param  [array] $a_data  [更新的数据]
     * @return [int]            [返回受影响的行数]
     */
    public function update_cart($a_where, $a_data)
    {
        $i_result = $this->db->update('cart', $a_data, $a_where);
        return $i_result;
    }

    /*********************** 获取预约办公室资格所需的消费金额 *************************/

    /**
     * [get_set_appointment 获取预约办公室资格所需的消费金额]
     * @return [type] [description]
     */
    public function get_set_appointment()
    {
        $a_where = [
            'set_name' => 'appointment_user_consume',
        ];
        $a_data  = $this->db->get_row('set', $a_where);
        return $a_data;
    }

    /******************************** 获取一条收藏信息 ********************************/

    /**
     * [get_collect_one 获取一条收藏信息]
     * @param  [int] $store_id   [传入的门店id]
     * @param  [int] $user_id    [传入的用户id]
     * @return [array]           [返回查询到的收藏信息]
     */
    public function get_collection_one($object_id, $user_id, $collection_type)
    {
        $a_where = [
            'object_id'       => $object_id,
            'user_id'         => $user_id,
            'collection_type' => $collection_type,
        ];
        $a_data  = $this->db->get_row('collection', $a_where);
        return $a_data;
    }

    /******************************** 插入一条收藏信息 ********************************/

    /**
     * [insert_collect 插入一条收藏信息]
     * @param  [array] $a_data [传入的要插入的数据]
     * @return [int]           [返回新数据的id]
     */
    public function insert_collection($a_data)
    {
        $i_result = $this->db->insert('collection', $a_data);
        return $i_result;
    }

    /******************************** 删除一条收藏信息 ********************************/

    /**
     * [delete_collect 删除一条收藏信息]
     * @param  [int] $collect_id [传入的收藏id]
     * @return [int]             [返回受影响的行数]
     */
    public function delete_collection($collection_id)
    {
        $a_where  = [
            'collection_id' => $collection_id,
        ];
        $i_result = $this->db->delete('collection', $a_where);
        return $i_result;
    }

    /************************** 获取一条正在进行中的订单总数 **************************/

    /**
     * [delete_collect 获取一条正在进行中的订单总数]
     * @param  [int] $user_id    [传入的用户id]
     * @return [int]             [返回受影响的行数]
     */
    public function get_appointment_mying($user_id)
    {
        $a_where  = [
            'user_id' => $user_id,
        ];
        $i_result = $this->db->where_in('appointment_state', [1, 2])->get_total('appointment', $a_where);
        return $i_result;
    }

    /************************** 获取一条正在进行中的订单总数 **************************/

    /**
     * [get_month_order 获取一条正在进行中的订单总数]
     * @param  [type] $store_id       [description]
     * @param  [type] $beginThismonth [description]
     * @return [type]                 [description]
     */
    public function get_month_order($store_id, $beginThismonth)
    {
        $a_where  = [
            'store_id'      => $store_id,
            'order_state'   => 30,
            'time_create >' => $beginThismonth,
        ];
        $i_result = $this->db->get_total('order', $a_where);
        return $i_result;
    }

    /***************************** 获取一条办公室订单 *******************************/

    /**
     * [get_appointment_one description]
     * @param  [type] $appointment_id [description]
     * @return [type]                 [description]
     */
    public function get_appointment_one($appointment_id)
    {
        $a_where = [
            'appointment_id' => $appointment_id,
        ];
        $a_data  = $this->db->get_row('appointment', $a_where);
        return $a_data;
    }

    /***************************** 获取一条设置信息 *******************************/

    /**
     * [get_set_one 获取一条设置信息]
     * @param  [type] $set_name [description]
     * @return [type]           [description]
     */
    public function get_set_one($set_name)
    {
        $a_where = [
            'set_name' => $set_name,
        ];
        $a_data  = $this->db->get_row('set', $a_where);
        return $a_data;
    }

    /*************************** 获取门店所有办公室信息 *****************************/

    /**
     * [get_office_store 获取门店所有办公室信息]
     * @param  [type] $store_id [description]
     * @return [type]           [description]
     */
    public function get_office_store($store_id, $type_cate)
    {
        $a_where = [
            'store_id'                                      => $store_id,
            'office_state'                                  => 1,
            $this->db->get_prefix() . 'roomtype.type_state' => 1,
            $this->db->get_prefix() . 'room.room_state'     => 1,
            $this->db->get_prefix() . 'roomtype.type_cate'  => $type_cate,
        ];
        $s_field = '';
        $a_order = [
            'office_id' => 'desc',
        ];
        $a_data  = $this->db->from('office')
            ->join('room', [$this->db->get_prefix() . 'office.room_id' => $this->db->get_prefix() . 'room.room_id'])
            ->join('roomtype', [$this->db->get_prefix() . 'roomtype.type_id' => $this->db->get_prefix() . 'room.type_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /*************************** 获取办公室分类信息 *****************************/

    /**
     * [get_office_type 获取办公室分类信息]
     * @param  [type] $type_arr [description]
     * @return [type]           [description]
     */
    public function get_office_type($type_arr)
    {
        $a_order = [
            'type_id' => 'desc',
        ];
        $a_data  = $this->db->where_in('type_id', $type_arr)
            ->get('roomtype', [], '', $a_order, 0, 999999999);
        return $a_data;
    }

    /*************************** 获取办公室订单信息 *****************************/

    /**
     * [get_office_appointment 获取办公室订单信息]
     * @return [type] [description]
     */
    public function get_office_appointment($office_id)
    {
        $a_where = [
            'office_id' => $office_id,
        ];
        $s_field = 'appointment_id,appointment_time';
        $a_order = [
            'appointment_id' => 'desc',
        ];
        $a_data  = $this->db->get('appointment', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /*************************** 获取办公室评论信息 *****************************/

    /**
     * [get_office_comment 获取办公室评论信息]
     * @return [type] [description]
     */
    public function get_office_comment($appointment_arr, $tag)
    {
        if ($tag == 'all') {
            $a_where = [
                'comment_type'  => 1,
                'comment_state' => 1,
            ];
        } elseif ($tag == 'tu') {
            $a_where = [
                'comment_type'  => 1,
                'comment_state' => 1,
                'comment_ispic' => 1,
            ];
        } else {
            $a_where = [
                'comment_type'                                        => 1,
                'comment_state'                                       => 1,
                $this->db->get_prefix() . 'comment.comment_tags LIKE' => '%' . $tag . '%',
            ];
        }
        $s_field  = 'comment_id, ' . $this->db->get_prefix() . 'comment.user_id, object_id, ' . $this->db->get_prefix() . 'comment.store_id, goods_score, service_score, comment_content, comment_pic, is_anonymous, comment_time, comment_type, order_number, comment_state, comment_tags, comment_cate, comment_empty, user_name, user_pic';
        $a_order  = [
            $this->db->get_prefix() . 'comment.comment_id' => 'desc',
        ];
        $a_data   = $this->db->from('comment')
            ->join('user', [$this->db->get_prefix() . 'comment.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 999999999);
        $new_data = [];
        // 获取需要的数据
        foreach ($a_data as $key => $value) {
            if (in_array($value['object_id'], $appointment_arr)) {
                $new_data[] = $value;
            }
        }
        return $a_data;
    }

    /**
     * [get_office_comment 获取办公室评论信息]
     * @return [type] [description]
     */
    public function get_num_office_comment($appointment_arr, $number)
    {

        $a_where = [
            'comment_type'  => 1,
            'comment_state' => 1,
        ];

        $s_field  = 'comment_id, ' . $this->db->get_prefix() . 'comment.user_id, object_id, ' . $this->db->get_prefix() . 'comment.store_id, goods_score, service_score, comment_content, comment_pic, is_anonymous, comment_time, comment_type, order_number, comment_state, comment_tags, comment_cate, comment_empty, user_name, user_pic';
        $a_order  = [
            $this->db->get_prefix() . 'comment.comment_id' => 'desc',
        ];
        $a_data   = $this->db->from('comment')
            ->join('user', [$this->db->get_prefix() . 'comment.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order, 0, $number);
        $new_data = [];
        // 获取需要的数据
        foreach ($a_data as $key => $value) {
            if (in_array($value['object_id'], $appointment_arr)) {
                $new_data[] = $value;
            }
        }
        return $a_data;
    }

    /*************************** 获取办公室标签信息 *****************************/

    /**
     * [get_office_comtag 获取办公室分类信息]
     * @param  [type] $store_id [description]
     * @return [type]           [description]
     */
    public function get_office_comtag($store_id)
    {
        $a_where = [
            'store_id'    => $store_id,
            'comtag_type' => 1,
        ];
        $s_field = '';
        $a_order = [
            'comtag_id' => 'desc',
        ];
        $a_data  = $this->db->get('comtag', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /**************************** 获取办门店所有标签信息 ******************************/

    /**
     * [get_store_comtag 获取办门店所有标签信息]
     * @param  [type] $store_id [description]
     * @return [type]           [description]
     */
    public function get_store_comtag($store_id, $comtag_type)
    {
        $a_where = [
            'store_id'    => $store_id,
            'comtag_type' => $comtag_type,
        ];
        $s_field = '';
        $a_order = [
            'comtag_id' => 'desc',
        ];
        $a_data  = $this->db->get('comtag', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /*************************** 获取门店评论信息 *****************************/

    /**
     * [get_comment_page 获取门店评论信息]
     * @param  [type] $store_id     [description]
     * @param  [type] $comment_type [description]
     * @param  [type] $page         [description]
     * @return [type]               [description]
     */
    public function get_comment_page($store_id, $comment_type, $page, $tag)
    {
        // 先设置默认从第一页开始
        $i_page = $page;
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 30;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        if ($tag == 'all') {
            $a_where = [
                'store_id'      => $store_id,
                'comment_type'  => $comment_type,
                'comment_state' => 1,
            ];
        } else {
            $a_where = [
                'store_id'          => $store_id,
                'comment_type'      => $comment_type,
                'comment_state'     => 1,
                'comment_tags LIKE' => '%' . $tag . '%',
            ];
        }
        $i_total = $this->db->get_total('comment', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = $this->db->get_prefix() . 'user.user_name,' . $this->db->get_prefix() . 'user.user_pic,' . $this->db->get_prefix() . 'comment.user_id,comment_id,object_id,comment_content,comment_time,comment_pic,store_id,goods_score,service_score,is_anonymous,comment_type,comment_tags';
        $a_order = [
            'comment_id' => 'desc',
        ];
        $a_data  = $this->db->from('comment')
            ->join('user', [$this->db->get_prefix() . 'comment.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 999999999);
        // 验证是否超出最大页码
        if ($page > ceil($i_total / $i_prow)) {
            return [];
        } else {
            return $a_data;
        }
    }

    /****************************** 插入一条足迹信息 *********************************/

    /**
     * [insert_footprint 插入一条足迹信息]
     * @param  [type] $a_data [description]
     * @return [type]         [description]
     */
    public function insert_footprint($a_data)
    {
        $i_result = $this->db->insert('footprint', $a_data);
        return $i_result;
    }

    /****************************** 获取足迹足迹信息 *********************************/

    public function get_footprint_total($user_id, $office_id)
    {
        $a_where  = [
            'user_id'          => $user_id,
            'object_id'        => $office_id,
            'footprint_time >' => time() - 3600,
        ];
        $i_result = $this->db->get_total('footprint', $a_where);
        return $i_result;
    }

    /****************************** 更新一条预约订单 **********************************/

    /**
     * [update_appointment 更新一条预约订单]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_appointment($a_where, $a_data)
    {
        $i_result = $this->db->update('appointment', $a_data, $a_where);
        return $i_result;
    }

    /************************* 根据订单号获取一条预约信息 *****************************/

    /**
     * [get_order_bynumber 根据订单号获取一条预约信息]
     * @param  [type] $appointment_number [description]
     * @return [type]                     [description]
     */
    public function get_order_bynumber($appointment_number)
    {
        $a_where = [
            'appointment_number' => $appointment_number,
        ];
        $a_data  = $this->db->get_row('appointment', $a_where);
        return $a_data;
    }

    /***************************** 插入一条余额变动记录 ********************************/

    /**
     * [insert_userbalance 插入一条余额变动记录]
     * @param  [type] $a_data [description]
     * @return [type]         [description]
     */
    public function insert_userbalance($a_data)
    {
        $i_result = $this->db->insert('userbalance', $a_data);
        return $i_result;
    }

    /***************************** 更新一条用户记录信息 ********************************/

    /**
     * [update_user 更新一条用户记录信息]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_user($a_where, $a_data)
    {
        $i_result = $this->db->update('user', $a_data, $a_where);
        return $i_result;
    }

    /******************************* 插入一条积分记录 **********************************/

    /**
     * [insert_points_log 插入一条积分记录]
     * @param  [type] $a_data [description]
     * @return [type]         [description]
     */
    public function insert_points_log($a_data)
    {
        $i_result = $this->db->insert('points_log', $a_data);
        return $i_result;
    }

    /******************************* 插入一条积分记录 **********************************/

    /**
     * [update_office 插入一条积分记录]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_office($a_where, $a_data)
    {
        $i_result = $this->db->update('office', $a_data, $a_where);
        return $i_result;
    }

    /**************************** 获取一条微信支付的订单 *******************************/

    public function get_appointment_second($appointment_type)
    {
        $a_where = [
            'pay_type'           => 2,
            'user_id'            => $_SESSION['user_id'],
            'appointment_time >' => time() - 10,
            'appointment_type'   => $appointment_type,
        ];
        $a_data  = $this->db->get_row('appointment', $a_where);
        return $a_data;
    }


    /**********************************************************************************/

}
