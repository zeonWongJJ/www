<?php

class Order_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************ 所有有订单的门店 ************************************/

    public function get_store_all()
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(1);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 8;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where = [
            'store_allorder >' => 0,
        ];
        $i_total = $this->db->get_total('store', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = '';
        $a_order         = [
            'store_allorder' => 'desc',
        ];
        $a_data['store'] = $this->db->get('store', $a_where, $s_field, $a_order);
        $a_data['count'] = $i_total;
        $a_data['page']  = $i_page;
        return $a_data;
    }

    /*************************************** 办公室订单 ***************************************/

    public function get_appointment_page($store_id, $state, $appointment_type)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(3);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 6;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        if ($state == 'all') {
            $a_where = [
                'store_id'            => $store_id,
                'appointment_type'    => $appointment_type,
                'appointment_state >' => 0,
            ];
        } else {
            if ($state == 5) {
                $a_where = [
                    'store_id'         => $store_id,
                    'appointment_type' => $appointment_type,
                ];
            } else {
                $a_where = [
                    'store_id'          => $store_id,
                    'appointment_state' => $state,
                    'appointment_type'  => $appointment_type,
                ];
            }
        }
        if ($state == 5) {
            $i_total = $this->db->where_in('appointment_state', [4, 5])->get_total('appointment', $a_where);
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
            $a_data['appointment'] = $this->db->where_in('appointment_state', [4, 5])
                ->from('appointment')
                ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'appointment.user_id'])
                ->get('', $a_where, $s_field, $a_order);
        } else {
            $a_data['appointment'] = $this->db->from('appointment')
                ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'appointment.user_id'])
                ->get('', $a_where, $s_field, $a_order);
        }
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /******************************** 获取不同订单状态的订单数 ********************************/

    public function get_state_count($appointment_state, $store_id, $appointment_type)
    {
        if ($appointment_state == 5) {
            $a_where  = [
                'store_id'         => $store_id,
                'appointment_type' => $appointment_type,
            ];
            $i_result = $this->db->where_in('appointment_state', [4, 5])->get_total('appointment', $a_where);
        } else {
            $a_where  = [
                'appointment_state' => $appointment_state,
                'store_id'          => $store_id,
                'appointment_type'  => $appointment_type,
            ];
            $i_result = $this->db->get_total('appointment', $a_where);
        }
        return $i_result;
    }

    /************************************ 获取一条门店信息 ************************************/

    public function get_store_one($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $a_data  = $this->db->get_row('store', $a_where);
        return $a_data;
    }

    /********************************** 获取某门店所有房间 ************************************/

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
            ->get('', $a_where, $s_field, $a_order, 0, 999999);
        return $a_data;
    }

    /************************************* 获取今日的预约 *************************************/

    public function get_appointment_today($store_id)
    {
        // 今日起始时间戳
        $start    = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $a_where  = [
            'appointment_time >' => $start,
            'store_id'           => $store_id,
        ];
        $i_result = $this->db->get_total('appointment', $a_where);
        return $i_result;
    }


    /*********************************** 获取某门店预约总数 ***********************************/

    public function get_appointment_total($store_id)
    {
        $a_where  = [
            'store_id' => $store_id,
        ];
        $i_result = $this->db->get_total('appointment', $a_where);
        return $i_result;
    }

    /************************************* 搜索办公室订单 *************************************/

    public function get_appointment_search($store_id, $keywords, $office_id, $state, $appointment_type)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(5);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 6;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        if ($office_id == 'all' && $state == 'all') {
            $a_where = [
                'store_id'         => $store_id,
                'appointment_type' => $appointment_type,
            ];
        }
        if ($office_id == 'all' && $state != 'all') {
            if ($state == 5) {
                $a_where = [
                    'store_id'         => $store_id,
                    'appointment_type' => $appointment_type,
                ];
            } else {
                $a_where = [
                    'store_id'          => $store_id,
                    'appointment_state' => $state,
                    'appointment_type'  => $appointment_type,
                ];
            }
        }
        if ($office_id != 'all' && $state == 'all') {
            $a_where = [
                'store_id'         => $store_id,
                'office_id'        => $office_id,
                'appointment_type' => $appointment_type,
            ];
        }
        if ($office_id != 'all' && $state != 'all') {
            if ($state == 5) {
                $a_where = [
                    'store_id'         => $store_id,
                    'office_id'        => $office_id,
                    'appointment_type' => $appointment_type,
                ];
            } else {
                $a_where = [
                    'store_id'          => $store_id,
                    'office_id'         => $office_id,
                    'appointment_state' => $state,
                    'appointment_type'  => $appointment_type,
                ];
            }
        }
        if ($keywords == 9) {
            if ($state == 5) {
                $i_total = $this->db->where_in('appointment_state', [4, 5])
                    ->get_total('appointment', $a_where);
            } else {
                $i_total = $this->db->get_total('appointment', $a_where);
            }
        } else {
            $a_where_or = [
                $this->db->get_prefix() . 'appointment.linkman LIKE'            => '%' . $keywords . '%',
                $this->db->get_prefix() . 'appointment.link_phone LIKE'         => '%' . $keywords . '%',
                $this->db->get_prefix() . 'appointment.appointment_number LIKE' => '%' . $keywords . '%',
            ];
            if ($state == 5) {
                $i_total = $this->db->where_in('appointment_state', [4, 5])
                    ->group_start('AND')
                    ->where_or($a_where_or)
                    ->group_end()
                    ->get_total('appointment', $a_where);
            } else {
                $i_total = $this->db->group_start('AND')
                    ->where_or($a_where_or)
                    ->group_end()
                    ->get_total('appointment', $a_where);
            }
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
            if ($state == 5) {
                $a_data['appointment'] = $this->db->where_in('appointment_state', [4, 5])
                    ->from('appointment')
                    ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'appointment.user_id'])
                    ->get('', $a_where, $s_field, $a_order);
            } else {
                $a_data['appointment'] = $this->db->from('appointment')
                    ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'appointment.user_id'])
                    ->get('', $a_where, $s_field, $a_order);
            }
        } else {
            if ($state == 5) {
                $a_data['appointment'] = $this->db->where_in('appointment_state', [4, 5])
                    ->group_start('AND')
                    ->where_or($a_where_or)
                    ->group_end()
                    ->from('appointment')
                    ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'appointment.user_id'])
                    ->get('', $a_where, $s_field, $a_order);
            } else {
                $a_data['appointment'] = $this->db->group_start('AND')
                    ->where_or($a_where_or)
                    ->group_end()
                    ->from('appointment')
                    ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'appointment.user_id'])
                    ->get('', $a_where, $s_field, $a_order);
            }
        }
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /************************************** 搜索座位订单 **************************************/

    public function get_book_search($store_id, $keywords, $seatkey, $state, $appointment_type)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(5);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        if ($keywords == 'all' && $seatkey == 'all' && $state == 'all') {
            $a_where    = [
                'store_id'         => $store_id,
                'appointment_type' => $appointment_type,
            ];
            $a_where_or = [];
        }
        if ($keywords != 'all' && $seatkey == 'all' && $state == 'all') {
            $a_where    = [
                'store_id'         => $store_id,
                'appointment_type' => $appointment_type,
            ];
            $a_where_or = [
                $this->db->get_prefix() . 'appointment.linkman LIKE'            => '%' . $keywords . '%',
                $this->db->get_prefix() . 'appointment.link_phone LIKE'         => '%' . $keywords . '%',
                $this->db->get_prefix() . 'appointment.appointment_number LIKE' => '%' . $keywords . '%',
            ];
        }
        if ($keywords != 'all' && $seatkey != 'all' && $state == 'all') {
            $a_where    = [
                'store_id'         => $store_id,
                'appointment_type' => $appointment_type,
            ];
            $a_where_or = [
                $this->db->get_prefix() . 'appointment.linkman LIKE'            => '%' . $keywords . '%',
                $this->db->get_prefix() . 'appointment.link_phone LIKE'         => '%' . $keywords . '%',
                $this->db->get_prefix() . 'appointment.appointment_number LIKE' => '%' . $keywords . '%',
                $this->db->get_prefix() . 'appointment.office_seatname LIKE'    => '%' . $seatkey . '%',
            ];
        }
        if ($keywords == 'all' && $seatkey != 'all' && $state == 'all') {
            $a_where    = [
                'store_id'         => $store_id,
                'appointment_type' => $appointment_type,
            ];
            $a_where_or = [
                $this->db->get_prefix() . 'appointment.office_seatname LIKE' => '%' . $seatkey . '%',
            ];
        }
        $i_total = $this->db->group_start('AND')
            ->where_or($a_where_or)
            ->group_end()
            ->get_total('appointment', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field               = '';
        $a_order               = [
            'appointment_id' => 'desc',
        ];
        $a_data['appointment'] = $this->db->group_start('AND')
            ->where_or($a_where_or)
            ->group_end()
            ->from('appointment')
            ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'appointment.user_id'])
            ->get('', $a_where, $s_field, $a_order);
        $a_data['count']       = $i_total;
        return $a_data;
    }

    /******************************************************************************************/

}
