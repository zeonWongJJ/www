<?php

class Roomtype_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************* 类型列表 *************************************/

    public function get_type_showlist()
    {
        $a_order = [
            'type_id' => 'desc',
        ];
        $a_data  = $this->db->get('roomtype', [], '', $a_order, 0, 99999999);
        return $a_data;
    }

    /************************************* 添加类型 *************************************/

    /**
     * [insert_type 添加类型]
     * @param  [array] $a_data [要添加的类型]
     * @return [int]           [返回新数据的id]
     */
    public function insert_type($a_data)
    {
        $i_result = $this->db->insert('roomtype', $a_data);
        return $i_result;
    }

    /********************************* 获取一条类型信息 *********************************/

    /**
     * [get_type_one 根据id获取一条类型信息]
     * @param  [int]   $type_id [类型id]
     * @return [array]          [返回查询到的数据]
     */
    public function get_type_one($type_id)
    {
        $a_where = [
            'type_id' => $type_id,
        ];
        $a_data  = $this->db->get_row('roomtype', $a_where);
        return $a_data;
    }

    /************************************* 修改类型 *************************************/

    /**
     * [update_type 修改类型]
     * @param  [array] $a_where [修改的条件]
     * @param  [array] $a_data  [修改的数据]
     * @return [int]            [返回修改的行数]
     */
    public function update_type($a_where, $a_data)
    {
        $i_result = $this->db->update('roomtype', $a_data, $a_where);
        return $i_result;
    }

    /************************************* 删除类型 *************************************/

    /**
     * [delete_type_one 删除单个]
     * @param  [int] $type_id [要删除的类型id]
     * @return [int]          [返回删除的行数]
     */
    public function delete_type_one($type_id)
    {
        $a_where  = [
            'type_id' => $type_id,
        ];
        $i_result = $this->db->delete('roomtype', $a_where);
        return $i_result;
    }

    /**
     * [delete_manager_mony 批量删除类型]
     * @param  [array] $a_data     [要删除的类型的id数组]
     * @return [int]   $i_result   [返回删除的行数]
     */
    public function delete_type_mony($a_data)
    {
        $i_result = $this->db->where_in('type_id', $a_data)->delete('roomtype');
        return $i_result;
    }

    /************************************* 子类总数 *************************************/

    /**
     * [get_son_total 查询某个类型下所有子类的总个数]
     * @param  [int] $type_id [要查询的类型id]
     * @return [int]          [返回查询到子类总个数]
     */
    public function get_son_total($type_id)
    {
        $a_where  = [
            'type_pid' => $type_id,
        ];
        $i_result = $this->db->get_total('roomtype', $a_where);
        return $i_result;
    }

    /************************************* 房间总数 *************************************/

    /**
     * [get_room_total 查询某个分类下所有的房间数]
     * @param  [int] $type_id [传入的分类id]
     * @return [int]          [description]
     */
    public function get_room_total($type_id)
    {
        $a_where  = [
            'type_id' => $type_id,
        ];
        $i_result = $this->db->get_total('room', $a_where);
        return $i_result;
    }

    /************************************* 类型查询 *************************************/

    /**
     * [get_room_search 根据关键词搜索类型]
     * @param  [string] $keywords [传入的关键词]
     * @return [array]            [返回查询到的数据]
     */
    public function get_type_search($keywords)
    {
        $a_where    = [
            'type_name LIKE' => '%' . $keywords . '%',
        ];
        $a_where_or = [
            'type_description LIKE' => '%' . $keywords . '%',
        ];
        $s_field    = '';
        $a_order    = [
            'type_id' => 'desc',
        ];
        $a_data     = $this->db->from('roomtype')
            ->where($a_where)
            ->where_or($a_where_or)
            ->get('', NULL, $s_field, $a_order);
        return $a_data;
    }

    /*************************************************************************************/

}
