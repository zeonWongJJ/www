<?php

class Collection_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /******************************* 获取用户收藏的办公室 ********************************/

    public function get_collection_office($user_id, $page)
    {
        // 先设置默认从第一页开始
        $i_page = $page;
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where = [
            'user_id'         => $user_id,
            'collection_type' => 2,
        ];
        $i_total = $this->db->get_total('collection', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = 'collection_id, collection_type, user_id, object_id, collection_time, office_id, room_name, room_size, room_seat, room_mainpic, device_ids';
        $a_order = [
            'collection_id' => 'desc',
        ];
        $a_data  = $this->db->from('collection')
            ->join('office', [$this->db->get_prefix() . 'office.office_id' => $this->db->get_prefix() . 'collection.object_id'])
            ->join('room', [$this->db->get_prefix() . 'office.room_id' => $this->db->get_prefix() . 'room.room_id'])
            ->get('', $a_where, $s_field, $a_order);
        if ($i_page > ceil($i_total / $i_prow)) {
            return [];
        } else {
            return $a_data;
        }
    }

    /******************************** 获取办公室设备信息 *********************************/

    /**
     * [get_device_office 获取办公室设备信息]
     * @param  [type] $device_ids [description]
     * @return [type]             [description]
     */
    public function get_device_office($device_ids)
    {
        $s_field = 'device_name';
        $a_order = [
            'device_id' => 'desc',
        ];
        $a_data  = $this->db->where_in('device_id', $device_ids)
            ->get('device', [], $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /******************************** 获取用户收藏的门店 *********************************/

    /**
     * [get_collection_store 获取用户收藏的门店]
     * @param  [type] $user_id [description]
     * @param  [type] $page    [description]
     * @return [type]          [description]
     */
    public function get_collection_store($user_id, $page)
    {
        // 先设置默认从第一页开始
        $i_page = $page;
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where = [
            $this->db->get_prefix() . 'collection.user_id'         => $user_id,
            $this->db->get_prefix() . 'collection.collection_type' => 1,
            $this->db->get_prefix() . 'store.store_state'          => 1,
        ];
        $s_field = 'collection_id, collection_type, user_id, object_id, collection_time, store_name, store_touxiang, store_star, transport_start';
        $a_order = [
            'collection_id' => 'desc',
        ];
        $i_total = $this->db->from('collection')
            ->join('store', [$this->db->get_prefix() . 'store.store_id' => $this->db->get_prefix() . 'collection.object_id'])
            ->get_total('', $a_where, $s_field, $a_order);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_data  = $this->db->from('collection')
            ->join('store', [$this->db->get_prefix() . 'store.store_id' => $this->db->get_prefix() . 'collection.object_id'])
            ->get('', $a_where, $s_field, $a_order);
        // 判断是否超出最大页码
        if ($i_page > ceil($i_total / $i_prow)) {
            return [];
        } else {
            return $a_data;
        }
    }

    /******************************** 获取用户收藏的产品 *********************************/

    /**
     * [get_collection_goods 获取用户收藏的产品]
     * @param  [type] $user_id [description]
     * @param  [type] $page    [description]
     * @return [type]          [description]
     */
    public function get_collection_goods($user_id, $page)
    {
        // 先设置默认从第一页开始
        $i_page = $page;
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where = [
            'user_id'         => $user_id,
            'collection_type' => 3,
        ];
        $i_total = $this->db->get_total('collection', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = 'collection_id, collection_type, user_id, object_id, collection_time, product_name, pro_img, pro_details,proid_id_1,product_id';
        $a_order         = [
            'collection_id' => 'desc',
        ];
        $a_data['goods'] = $this->db->from('collection as a')
            ->join('product as b', ['a.object_id' => 'b.product_id'])
            ->get('', $a_where, $s_field, $a_order);
        // 产品价格起
        $a_data['cup'] = $this->db->limit(0, 9999999999)->get('price', ['price >' => 0], '', ['price' => 'asc']);
        // 判断是否超出最大页码
        if ($i_page > ceil($i_total / $i_prow)) {
            return [];
        } else {
            return $a_data;
        }
    }

    /*********************************** 批量删除收藏 ************************************/

    /**
     * [function_name 批量删除收藏]
     * @param  [type] $del_arr [description]
     * @return [type]          [description]
     */
    public function delete_collection($del_arr)
    {
        $i_result = $this->db->where_in('collection_id', $del_arr)->delete('collection');
        return $i_result;
    }

    /*************************************************************************************/

}
