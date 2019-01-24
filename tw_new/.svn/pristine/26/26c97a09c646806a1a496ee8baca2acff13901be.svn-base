<?php

class Score_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /*************************************** 积分列表 ***************************************/

    /**
     * [get_user_page 积分列表]
     * @return [type] [description]
     */
    public function get_user_page($keywords)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(2);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 25;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where = [
            'user_state' => 1,
        ];
        if ($keywords == 9) {
            $i_total = $this->db->get_total('user', $a_where);
        } else {
            $a_where_or = [
                'user_phone LIKE' => '%' . $keywords . '%',
                'user_name LIKE'  => '%' . $keywords . '%',
            ];
            $i_total    = $this->db->group_start('AND')->where_or($a_where_or)->group_end('AND')->get_total('user', $a_where);
        }
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = '';
        $a_order = [
            'user_score' => 'desc',
        ];
        if ($keywords == 9) {
            $a_data['score'] = $this->db->get('user', $a_where, $s_field, $a_order);
        } else {
            $a_data['score'] = $this->db->group_start('AND')->where_or($a_where_or)->group_end('AND')->get('user', $a_where, $s_field, $a_order);
        }
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /*************************************** 一条用户 ***************************************/

    /**
     * [get_user_one 获取一条用户]
     * @return [type] [description]
     */
    public function get_user_one($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        $a_data  = $this->db->get_row('user', $a_where);
        return $a_data;
    }

    /*************************************** 更新用户 ***************************************/

    /**
     * [update_user 更新用户]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_user($a_where, $a_data)
    {
        $i_result = $this->db->update('user', $a_data, $a_where);
        return $i_result;
    }

    /*************************************** 修改积分 ***************************************/

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

    /*************************************** 积分明细 ***************************************/

    /**
     * [get_score_page 积分明细]
     * @return [type] [description]
     */
    public function get_score_page($user_id, $type, $time, $etime)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(4);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        if ($type == 9 && $time == 9) {
            $a_where = [
                'user_id' => $user_id,
            ];
        } else if ($type != 9 && $time == 9) {
            $a_where = [
                'user_id' => $user_id,
                'pl_type' => $type,
            ];
        } else if ($type != 9 && $time != 9) {
            $a_where = [
                'user_id'   => $user_id,
                'pl_type'   => $type,
                'pl_time >' => $time,
                'pl_time <' => $etime,
            ];
        } else if ($type == 9 && $time != 9) {
            $a_where = [
                'user_id'   => $user_id,
                'pl_time >' => $time,
                'pl_time <' => $etime,
            ];
        }
        $i_total = $this->db->get_total('points_log', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field          = '';
        $a_order          = [
            'pl_id' => 'desc',
        ];
        $a_data['points'] = $this->db->get('points_log', $a_where, $s_field, $a_order);
        $a_data['count']  = $i_total;
        $a_data['page']   = $i_page;
        return $a_data;
    }

    /*************************************** 用户积分 ***************************************/

    /**
     * [get_score_user 用户积分]
     * @return [type] [description]
     */
    public function get_score_user($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        $s_field = '';
        $a_order = [
            'pl_id' => 'desc',
        ];
        $a_data  = $this->db->get('points_log', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /********************************* 获取所有积分变动信息 *********************************/

    /**
     * [get_score_variation 获取所有积分变动信息]
     * @return [type] [description]
     */
    public function get_score_variation()
    {
        $a_order = [
            'pl_id' => 'desc',
        ];
        $a_data  = $this->db->get('points_log', [], '', $a_order, 0, 999999999);
        return $a_data;
    }

    /********************************* 获取所有积分变动信息 *********************************/

    /**
     * [get_user_all description]
     * @return [type] [description]
     */
    public function get_user_all()
    {
        $a_where = [
            'user_state' => 1,
        ];
        $s_field = '';
        $a_order = [
            'user_id' => 'desc',
        ];
        $a_data  = $this->db->get('user', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /****************************************************************************************/

}
