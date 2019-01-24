<?php

class Office_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /********************************* 获取所有已启用的房间类型 *********************************/

    /**
     * [get_room_all 获取所有已启用的房间类型]
     * @return [array] [返回查询到的房间类型]
     */
    public function get_room_all()
    {
        $a_where = [
            'room_state' => 1,
        ];
        $a_order = [
            'room_id' => 'desc',
        ];
        $a_data  = $this->db->from('room')
            ->join('roomtype', [$this->db->get_prefix() . 'roomtype.type_id' => $this->db->get_prefix() . 'room.type_id'])
            ->get('', $a_where, '', $a_order, 9999999);
        return $a_data;
    }

    /************************************* 搜索房间 *************************************/

    public function get_room_search($keywords)
    {
        $a_where    = [
            'room_state' => 1,
        ];
        $a_where_or = [
            $this->db->get_prefix() . 'room.room_name LIKE'        => '%' . $keywords . '%',
            $this->db->get_prefix() . 'room.room_description LIKE' => '%' . $keywords . '%',
            $this->db->get_prefix() . 'roomtype.type_name LIKE'    => '%' . $keywords . '%',
        ];
        $a_order    = [
            'room_id' => 'desc',
        ];
        $a_data     = $this->db->group_start('AND')
            ->where_or($a_where_or)
            ->group_end()
            ->from('room')
            ->join('roomtype', [$this->db->get_prefix() . 'roomtype.type_id' => $this->db->get_prefix() . 'room.type_id'])
            ->get('', $a_where, '', $a_order, 9999999);
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
        $a_data  = $this->db->where_in('device_id', $a_data)->get('device', $a_where, '', [], 0, 9999999);
        return $a_data;
    }

    /************************************ 插入一条办公室记录 ************************************/

    /**
     * [insert_office 插入一条办公室记录]
     * @param  [array] $a_data [要插入的数据]
     * @return [int]           [返回新数据的id]
     */
    public function insert_office($a_data)
    {
        $i_result = $this->db->insert('office', $a_data);
        return $i_result;
    }

    /********************************** 获取当前门店所有办公室 **********************************/

    public function get_office_all()
    {
        $a_where = [
            'store_id' => $_SESSION['store_id'],
        ];
        $s_field = '';
        $a_order = [
            'office_id' => 'desc',
        ];
        $a_data  = $this->db->from('office')
            ->join('room', [$this->db->get_prefix() . 'room.room_id' => $this->db->get_prefix() . 'office.room_id'])
            ->join('roomtype', [$this->db->get_prefix() . 'roomtype.type_id' => $this->db->get_prefix() . 'room.type_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 9999999);
        return $a_data;
    }

    /************************************ 获取一条办公室记录 ************************************/

    /**
     * [get_office_one 获取一条办公室记录]
     * @param  [int] $office_id   [传入的要查询的记录id]
     * @return [array]            [返回查询到的记录]
     */
    public function get_office_one($office_id)
    {
        $a_where = [
            'office_id' => $office_id,
        ];

        $a_data  = $this->db->get_row('office', $a_where, $s_field, $a_order);
        return $a_data;
    }

    /************************************ 修改一条办公室记录 ************************************/

    /**
     * [update_office 修改一条办公室记录]
     * @param  [array] $a_where [修改的条件]
     * @param  [array] $a_data  [修改的数据]
     * @return [int]            [返回修改的行数]
     */
    public function update_office($a_where, $a_data)
    {
        $i_result = $this->db->update('office', $a_data, $a_where);
        return $i_result;
    }

    /****************************** 获取当前办公室被占用座位的总数 ******************************/

    /**
     * [get_seat_occupy 获取当前办公室被占用座位的总数]
     * @param  [int] $office_id [传入的办公室id]
     * @return [int]            [返回查询到的总数]
     */
    public function get_seat_occupy($office_id)
    {
        $a_where  = [
            'office_id'        => $office_id,
            'officeseat_state' => 1,
        ];
        $i_result = $this->db->get_total('appointment', $a_where);
        return $i_result;
    }

    /************************************ 删除一条办公室记录 ************************************/

    /**
     * [delete_office_one 删除一条办公室记录]
     * @param  [int] $office_id [传入的要删除的办公室的id]
     * @return [int]            [返回删除的行数]
     */
    public function delete_office_one($office_id)
    {
        $a_where  = [
            'office_id' => $office_id,
        ];
        $i_result = $this->db->delete('office', $a_where);
        return $i_result;
    }

    /********************************** 根据关键词搜索办公室 ************************************/

    public function get_office_search($keywords)
    {
        $a_where    = [
            $this->db->get_prefix() . 'office.store_id' => $_SESSION['store_id'],
        ];
        $a_where_or = [
            $this->db->get_prefix() . 'room.room_name LIKE'        => '%' . $keywords . '%',
            $this->db->get_prefix() . 'room.room_description LIKE' => '%' . $keywords . '%',
            $this->db->get_prefix() . 'roomtype.type_name LIKE'    => '%' . $keywords . '%',
        ];
        $s_field    = '';
        $a_order    = [
            'office_id' => 'desc',
        ];
        $a_data     = $this->db->group_start('AND')
            ->where_or($a_where_or)
            ->group_end()
            ->from('office')
            ->join('room', [$this->db->get_prefix() . 'room.room_id' => $this->db->get_prefix() . 'office.room_id'])
            ->join('roomtype', [$this->db->get_prefix() . 'roomtype.type_id' => $this->db->get_prefix() . 'room.type_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 9999999);
        return $a_data;
    }

    /************************************ 获取一条房间信息 **************************************/

    /**
     * [get_room_one 获取一条房间信息]
     * @param  [type] $room_id [description]
     * @return [type]          [description]
     */
    public function get_room_one($room_id)
    {
        $a_where = [
            'room_id' => $room_id,
        ];
        $a_data  = $this->db->get_row('room', $a_where);
        return $a_data;
    }

    /********************************************************************************************/

}

?>
