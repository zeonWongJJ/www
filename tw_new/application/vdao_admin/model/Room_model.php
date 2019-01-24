<?php

class Room_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************* 房间列表 *************************************/

    public function get_room_all()
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
        $i_total = $this->db->get_total('room');
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_order         = [
            'room_id' => 'desc',
        ];
        $a_data['room']  = $this->db->from('room')
            ->join('roomtype', [$this->db->get_prefix() . 'roomtype.type_id' => $this->db->get_prefix() . 'room.type_id'])
            ->get('', [], '', $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /********************************* 获取一条房间信息 *********************************/

    /**
     * [get_room_one 获取一条房间信息]
     * @param  [int]   $room_id [传入的房间id]
     * @return [array]          [返回查询到的房间信息]
     */
    public function get_room_one($room_id)
    {
        $a_where = [
            'room_id' => $room_id,
        ];
        $a_data  = $this->db->get_row('room', $a_where);
        return $a_data;
    }

    /*********************************** 获取房间设备 ***********************************/

    /**
     * [get_romm_device 获取部分设备信息]
     * @param  [array]   $a_data     [要获取的设备id数组]
     * @return [array]   $i_result   [返回获取到的数据]
     */
    public function get_room_device($a_data)
    {
        $a_where = [
            'device_state' => 1,
        ];
        $a_data  = $this->db->where_in('device_id', $a_data)->get('device', $a_where, '', [], 0, 99999999);
        return $a_data;
    }

    /**
     * [get_device_all 获取所有设备信息]
     * @return [array] [返回查询到的所有设备信息]
     */
    public function get_device_all()
    {
        $a_where = [
            'device_state' => 1,
        ];
        $s_field = 'device_id, device_name';
        $a_order = [
            'device_id' => 'desc',
        ];
        $a_data  = $this->db->get('device', $a_where, $s_field, $a_order, 0, 99999999);
        return $a_data;
    }

    /*********************************** 获取房间分类 ***********************************/

    /**
     * [get_room_type 获取房间分类]
     * @return [array] [返回查询到的数据]
     */
    public function get_room_type()
    {
        $a_where = [
            'type_state' => 1,
        ];
        $s_field = 'type_id,type_name,type_level,type_pid';
        $a_data  = $this->db->get('roomtype', $a_where, $s_field, 0, 99999999);
        return $a_data;
    }

    /************************************* 添加房间 *************************************/

    /**
     * [inser_room 插入一条房间信息]
     * @param  [array] $a_data [要插入的房间信息]
     * @return [int]           [返回新数据的id]
     */
    public function insert_room($a_data)
    {
        $i_result = $this->db->insert('room', $a_data);
        return $i_result;
    }

    /************************************* 修改房间 *************************************/

    /**
     * [update_room 修改房间]
     * @param  [array] $a_where [修改的条件]
     * @param  [array] $a_data  [要修改的数据]
     * @return [int]            [返回受影响的行数]
     */
    public function update_room($a_where, $a_data)
    {
        $i_result = $this->db->update('room', $a_data, $a_where);
        return $i_result;
    }

    /************************************* 删除房间 *************************************/

    /**
     * [delete_room_one 删除一条房间信息]
     * @param  [int] $room_id [要删除的房间id]
     * @return [int]          [返回删除的总行数]
     */
    public function delete_room_one($room_id)
    {
        $a_where  = [
            'room_id' => $room_id,
        ];
        $i_result = $this->db->delete('room', $a_where);
        return $i_result;
    }

    /**
     * [delete_room_mony 批量删除房间]
     * @param  [array] $a_data     [要删除的房间的id数组]
     * @return [int]   $i_result   [返回删除的行数]
     */
    public function delete_room_mony($a_data)
    {
        $i_result = $this->db->where_in('room_id', $a_data)->delete('room');
        return $i_result;
    }

    /************************************* 房间查询 *************************************/

    /**
     * [get_room_search 根据关键词搜索房间]
     * @param  [string] $keywords [传入的关键词]
     * @return [array]            [返回查询到的数据]
     */
    public function get_room_search($keywords)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(2);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where    = [
            $this->db->get_prefix() . 'room.room_name LIKE' => '%' . $keywords . '%',
        ];
        $a_where_or = [
            $this->db->get_prefix() . 'room.room_keywords LIKE'    => '%' . $keywords . '%',
            $this->db->get_prefix() . 'room.room_description LIKE' => '%' . $keywords . '%',
            $this->db->get_prefix() . 'roomtype.type_name LIKE'    => '%' . $keywords . '%',
        ];
        $i_total    = $this->db->from('room')
            ->join('roomtype', [$this->db->get_prefix() . 'roomtype.type_id' => $this->db->get_prefix() . 'room.type_id'])
            ->where($a_where)
            ->group_start('OR')
            ->where_or($a_where_or)
            ->group_end()
            ->get_total('', NULL, '', $a_order);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_order         = [
            'room_id' => 'desc',
        ];
        $a_data['room']  = $this->db->from('room')
            ->join('roomtype', [$this->db->get_prefix() . 'roomtype.type_id' => $this->db->get_prefix() . 'room.type_id'])
            ->where($a_where)
            ->group_start('OR')
            ->where_or($a_where_or)
            ->group_end()
            ->get('', NULL, '', $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /************************************************************************************/

}
