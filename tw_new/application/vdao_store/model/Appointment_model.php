<?php

class Appointment_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /********************************* 预约办公室订单列表 *********************************/

    public function get_appointment_order($store_id, $state, $appointment_type)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(3);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        if ($state == 9) {
            $a_where = [
                'store_id'            => $store_id,
                'delete_store'        => 1,
                'appointment_state >' => 0,
                'appointment_type'    => $appointment_type,
            ];
        } else {
            $a_where = [
                'store_id'          => $store_id,
                'delete_store'      => 1,
                'appointment_state' => $state,
                'appointment_type'  => $appointment_type,
            ];
        }
        if ($state == 5) {
            $a_where = [
                'store_id'         => $store_id,
                'delete_store'     => 1,
                'appointment_type' => $appointment_type,
            ];
        }
        if ($state == 5) {
            $i_total = $this->db->where_in('appointment_state', [4, 5])
                ->get_total('appointment', $a_where);
        } else {
            $i_total = $this->db->get_total('appointment', $a_where);
        }
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = '';
        $a_order = [
            'appointment_id' => 'desc',
        ];
        if ($state == 5) {
            $a_data['order'] = $this->db->where_in('appointment_state', [4, 5])
                ->from('appointment')
                ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'appointment.user_id'])
                ->where($a_where)
                ->get('', NULL, $s_field, $a_order);
        } else {
            $a_data['order'] = $this->db->from('appointment')
                ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'appointment.user_id'])
                ->get('', $a_where, $s_field, $a_order);
        }
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /********************************* 更新预约办公室订单 *********************************/

    /**
     * [update_appointment 更新预约办公室订单]
     * @param  [array] $a_where [更新的条件]
     * @param  [array] $a_data  [更新的数据]
     * @return [int]            [返回受影响的行数]
     */
    public function update_appointment($a_where, $a_data)
    {
        $i_result = $this->db->update('appointment', $a_data, $a_where);
        return $i_result;
    }

    /******************************* 批量更新预约办公室订单 *******************************/

    /**
     * [delete_device_mony 批量更新预约办公室订单]
     * @param  [array] $a_data     [要更新的订单id数组]
     * @return [int]   $i_result   [返回删除的行数]
     */
    public function update_appointment_mony($appointment_ids, $a_data)
    {
        $i_result = $this->db->where_in('appointment_id', $appointment_ids)->update('appointment', $a_data);
        return $i_result;
    }

    /********************************* 根据关键词搜索订单 *********************************/

    public function get_appointment_search($store_id, $keywords, $search_office, $search_seat, $appointment_type)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(5);
        if (empty($i_page)) {
            $i_page = 1;
        }
        if ($search_office == 'all' && $search_seat == 'all') {
            $a_where = [
                'store_id'            => $store_id,
                'delete_store'        => 1,
                'appointment_state >' => 0,
                'appointment_type'    => $appointment_type,
            ];
        }
        if ($search_office != 'all' && $search_seat != 'all') {
            $a_where = [
                'store_id'         => $store_id,
                'delete_store'     => 1,
                'office_id'        => $search_office,
                'office_seatname'  => $search_seat,
                'appointment_type' => $appointment_type,
            ];
        }
        if ($search_office == 'all' && $search_seat != 'all') {
            $a_where = [
                'store_id'         => $store_id,
                'delete_store'     => 1,
                'office_seatname'  => $search_seat,
                'appointment_type' => $appointment_type,
            ];
        }
        if ($search_office != 'all' && $search_seat == 'all') {
            $a_where = [
                'store_id'         => $store_id,
                'delete_store'     => 1,
                'office_id'        => $search_office,
                'appointment_type' => $appointment_type,
            ];
        }
        $a_where_or = [
            'appointment_number LIKE' => '%' . $keywords . '%',
            'linkman LIKE'            => '%' . $keywords . '%',
            'link_phone LIKE'         => '%' . $keywords . '%',
        ];

        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        if ($keywords == 9) {
            $i_total = $this->db->get_total('appointment', $a_where);
        } else {
            $i_total = $this->db->group_start('AND')
                ->where_or($a_where_or)
                ->group_end()
                ->get_total('appointment', $a_where);
        }
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = '';
        $a_order = [
            'appointment_id' => 'desc',
        ];
        if ($keywords == 9) {
            $a_data['order'] = $this->db->from('appointment')
                ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'appointment.user_id'])
                ->get('', $a_where, $s_field, $a_order);
        } else {
            $a_data['order'] = $this->db->from('appointment')
                ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'appointment.user_id'])
                ->group_start('AND')
                ->where_or($a_where_or)
                ->group_end()
                ->where($a_where)
                ->get('', NULL, $s_field, $a_order);
        }
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /******************************* 获取当前登录的门店信息 *******************************/

    /**
     * [get_store_one 获取当前登录的门店信息]
     * @param  [int]   $store_id  [传入的门店id]
     * @return [array]            [返回查询到的数据]
     */
    public function get_store_one($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $a_data  = $this->db->get_row('store', $a_where);
        return $a_data;
    }

    /************************************ 更新门店信息 ************************************/

    /**
     * [update_store 更新门店信息]
     * @param  [array] $a_where [更新的条件]
     * @param  [array] $a_data  [更新的数据]
     * @return [int]            [返回修改的行数]
     */
    public function update_store($a_where, $a_data)
    {
        $i_result = $this->db->update('store', $a_data, $a_where);
        return $i_result;
    }

    /****************************** 获取未处理订单以便计划任务 ****************************/

    public function get_appointment_timing()
    {
        $a_where = [
            'appointment_state <' => 4,
            'appointment_time >'  => time() - 30 * 3600,
        ];
        $s_field = '';
        $a_order = [
            'appointment_id' => 'desc',
        ];
        $a_data  = $this->db->get('appointment', $a_where, $s_field, $a_order, 0, 9999999);
        return $a_data;
    }

    /******************************* 根据订单状态获取订单总数 *****************************/

    public function get_state_count($store_id, $appointment_state, $appointment_type)
    {
        if ($appointment_state == 5) {
            $a_where  = [
                'store_id'         => $store_id,
                'appointment_type' => $appointment_type,
            ];
            $i_result = $this->db->where_in('appointment_state', [4, 5])
                ->get_total('appointment', $a_where);
        } else {
            $a_where  = [
                'store_id'          => $store_id,
                'appointment_state' => $appointment_state,
                'appointment_type'  => $appointment_type,
            ];
            $i_result = $this->db->get_total('appointment', $a_where);
        }
        return $i_result;
    }

    /*********************************** 获取今日订单总数 *********************************/

    public function get_appointment_today($store_id, $today_start, $appointment_type)
    {
        $a_where  = [
            'store_id'           => $store_id,
            'appointment_time >' => $today_start,
            'appointment_type'   => $appointment_type,
        ];
        $i_result = $this->db->get_total('appointment', $a_where);
        return $i_result;
    }

    /********************************* 获取门店所有的房间 *******************************/

    public function get_store_office($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $s_field = 'office_id, ' . $this->db->get_prefix() . 'office.room_id, store_id, office_state, room_name';
        $a_order = [
            'office_id' => 'desc',
        ];
        $a_data  = $this->db->from('office')
            ->join('room', [$this->db->get_prefix() . 'room.room_id' => $this->db->get_prefix() . 'office.room_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 99999999);
        return $a_data;
    }

    /********************************* 获取一条办公室信息 *******************************/

    /**
     * [get_office_one 获取一条办公室信息]
     * @param  [type] $office_id [description]
     * @return [type]            [description]
     */
    public function get_office_one($office_id)
    {
        $a_where = [
            'office_id' => $office_id,
        ];
        $a_data  = $this->db->get_row('office', $a_where);
        return $a_data;
    }

    /********************************** 获取一条预约信息 ********************************/

    /**
     * [get_appointment_one 获取一条预约信息]
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

    /****************************** 根据设置名获取设置信息 *******************************/

    /**
     * [get_set_one 根据设置名获取设置信息]
     * @param  [type] $set_name [description]
     * @return [type]           [description]
     */
    public function get_set_one($set_name)
    {
        $a_where = [
            'set_name' => $set_name,
        ];
        $a_data  = $this->db->get_row('set', $a_where);
        return $a_data['set_parameter'];
    }

    /************************************ 一条用户信息 ************************************/

    /**
     * [get_user_one 一条用户信息]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function get_user_one($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        $a_data  = $this->db->get_row('user', $a_where);
        return $a_data;
    }

    /********************************* 更新一条用户信息 **********************************/

    /**
     * [update_user 更新一条用户信息]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_user($a_where, $a_data)
    {
        $i_result = $this->db->update('user', $a_data, $a_where);
        return $i_result;
    }

    /******************************** 插入一条积分记录 ************************************/

    /**
     * [insert_points_log description]
     * @param  [type] $a_data [description]
     * @return [type]         [description]
     */
    public function insert_points_log($a_data)
    {
        $i_result = $this->db->insert('points_log', $a_data);
        return $i_result;
    }

    /****************************** 获取一条消费统计信息 **********************************/

    /**
     * [get_statistic_one 获取一条消费统计信息]
     * @param  [type] $user_id  [description]
     * @param  [type] $sta_time [description]
     * @return [type]           [description]
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

    /****************************** 更新一条消费统计信息 **********************************/

    /**
     * [update_statistic 更新一条消费统计信息]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_statistic($a_where, $a_data)
    {
        $i_result = $this->db->update('statistic', $a_data, $a_where);
        return $i_result;
    }

    /****************************** 插入一条消费统计信息 **********************************/

    /**
     * [insert_statistic 插入一条消费统计信息]
     * @param  [type] $a_data [description]
     * @return [type]         [description]
     */
    public function insert_statistic($a_data)
    {
        $i_result = $this->db->insert('statistic', $a_data);
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

    /********************************* 插入一条门店积分变动信息 *******************************/

    public function insert_storescore($a_data)
    {
        $i_result = $this->db->insert('storescore', $a_data);
        return $i_result;
    }

    /******************************************************************************************/

}
