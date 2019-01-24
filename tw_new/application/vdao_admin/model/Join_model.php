<?php

class Join_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /*************************************** 加盟列表 ****************************************/

    /**
     * [get_join_page 加盟列表]
     * @param  [type] $type     [description]
     * @param  [type] $keywords [description]
     * @return [type]           [description]
     */
    public function get_join_page($type, $keywords)
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
        if ($type == 9) {
            $a_where = [
                'join_state >'     => 1,
                'join_admindelete' => 1,
            ];
        } else {
            $a_where = [
                'join_state'       => $type,
                'join_admindelete' => 1,
            ];
        }
        if ($keywords == 9) {
            $i_total = $this->db->get_total('join', $a_where);
        } else {
            $a_where_or = [
                $this->db->get_prefix() . 'join.user_name LIKE'    => '%' . $keywords . '%',
                $this->db->get_prefix() . 'join.join_linkman LIKE' => '%' . $keywords . '%',
                $this->db->get_prefix() . 'join.join_phone LIKE'   => '%' . $keywords . '%',
            ];
            $i_total    = $this->db->group_start('AND')
                ->where_or($a_where_or)
                ->group_end('AND')
                ->get_total('join', $a_where);
        }
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = 'user_pic, user_regtime, join_id, ' . $this->db->get_prefix() . 'join.user_id, ' . $this->db->get_prefix() . 'join.user_name, join_storename, join_storecount, join_province, join_city, join_district, join_address, join_passenger, join_size, join_floor, join_licence, join_regmark, join_licname, join_corporation, join_expirydate, join_idcard, join_idcardpic, join_linkman, join_phone, join_state, join_time, join_agreetime, join_agreereason, join_refusetime, join_refusereason, join_userdelete, join_admindelete';
        $a_order = [
            'join_time' => 'desc',
        ];
        if ($keywords == 9) {
            $a_data['join'] = $this->db->from('join')
                ->join('user', [$this->db->get_prefix() . 'join.user_id' => $this->db->get_prefix() . 'user.user_id'])
                ->get('', $a_where, $s_field, $a_order);
        } else {
            $a_data['join'] = $this->db->group_start('AND')
                ->where_or($a_where_or)
                ->group_end('AND')
                ->from('join')
                ->join('user', [$this->db->get_prefix() . 'join.user_id' => $this->db->get_prefix() . 'user.user_id'])
                ->get('', $a_where, $s_field, $a_order);
        }
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /*********************************** 更新一条加盟记录 ************************************/

    /**
     * [update_join 更新一条加盟记录]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_join($a_where, $a_data)
    {
        $i_result = $this->db->update('join', $a_data, $a_where);
        return $i_result;
    }

    /*********************************** 获取一条加盟记录 ************************************/

    /**
     * [get_join_one 获取一条加盟记录]
     * @param  [type] $join_id [description]
     * @return [type]          [description]
     */
    public function get_join_one($join_id)
    {
        $a_where = [
            'join_id' => $join_id,
        ];
        $a_data  = $this->db->get_row('join', $a_where);
        return $a_data;
    }

    /*****************************************************************************************/

}
