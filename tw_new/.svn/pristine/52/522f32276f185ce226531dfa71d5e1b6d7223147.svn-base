<?php

class User_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /*********************************** 用户列表 ***********************************/

    /**
     * [get_user_showlist 获取第x页用户信息]
     * [操作的表 user 操作方式 select]
     * @return [array] [返回查询到的10条用户信息]
     */
    public function get_user_showlist()
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
        $i_total = $this->db->get_total('user');
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_order = [
            'user_id' => 'desc',
        ];
        $a_data  = $this->db->get('user', [], '', $a_order);
        return $a_data;
    }

    /*********************************** 用户总数 ***********************************/

    /**
     * [get_user_total 获取用户总数]
     * @return [int] [返回查询到的总条数]
     */
    public function get_user_total()
    {
        $i_result = $this->db->get_total('user');
        return $i_result;
    }

    /*********************************** 添加用户 ***********************************/

    /**
     * [insert_user 添加用户]
     * [操作的表 user 操作方式 insert]
     * @param  [array] $a_data [要添加用户的信息]
     * @return [int]         [返回新数据的行数]
     */
    public function insert_user($a_data)
    {
        //print_r($a_data);die;
        $i_result = $this->db->insert('user', $a_data);
        return $i_result;
    }

    /********************************** 修改用户资料 ********************************/

    /**
     * [get_user_one 获取一条会员信息]
     * [操作的表 user 操作方式 select]
     * @param  [int]    $user_id [要获取的信息的id]
     * @return [array]           [返回获取到的数据]
     */
    public function get_user_one($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        $a_data  = $this->db->get_row('user', $a_where);
        return $a_data;
    }

    /**
     * [update_user 修改用户资料]
     * [操作的表 user 操作方式 update]
     * @param  [array] $a_where [修改的条件]
     * @param  [array] $a_data  [修改的数据]
     * @return [int]            [返回受影响的行数]
     */
    public function update_user($a_where, $a_data)
    {
        $i_result = $this->db->update('user', $a_data, $a_where);
        return $i_result;
    }

    /*********************************** 禁用用户 ***********************************/

    /**
     * [insert_forbid 插入一条数据到禁用用户表]
     * [操作的表 forbid 操作方式 insert]
     * @param  [type] $a_data [要插入的数据]
     * @return [type]         [返回新数据的id]
     */
    public function insert_forbid($a_data)
    {
        $i_result = $this->db->insert('forbid', $a_data);
        return $i_result;
    }

    /*********************************** 删除用户 ***********************************/

    /**
     * [delete_user 删除用户 单个删除]
     * [操作的表 user 操作方式 delete]
     * @param  [int] $user_id [要删除用户的id]
     * @return [int]          [返回删除受影响的行数]
     */
    public function delete_user_one($user_id)
    {
        $a_where  = [
            'user_id' => $user_id,
        ];
        return $this->db->delete('user', $a_where);
    }

    /**
     * [delete_room_mony 批量删除用户]
     * @param  [array] $a_data     [要删除的用户的id数组]
     * @return [int]   $i_result   [返回删除的行数]
     */
    public function delete_user_mony($a_data)
    {
        return $this->db->where_in('user_id', $a_data)->delete('user');
    }

    /*********************************** 重置密码 ***********************************/

    /**
     * [update_password 重置密码]
     * [操作的表 user 操作方式 update]
     * @param  [type] $a_where [条件]
     * @param  [type] $a_data  [修改的数据]
     * @return [type]          [返回受影响的行数]
     */
    public function update_password($a_where, $a_data)
    {
        $i_result = $this->db->update('user', $a_data, $a_where);
        return $i_result;
    }

    /*********************************** 用户搜索 ***********************************/

    /**
     * [get_user_search 根据关键词搜索用户]
     * @param  [array] $keywords [关键词]
     * @return [array]           [返回查询到的数据]
     */
    public function get_user_search($keywords)
    {
        $a_where = [
            'user_name LIKE' => '%' . $keywords . '%',
        ];
        $s_field = '';
        $a_order = [
            'user_id' => 'desc',
        ];
        return $this->db->get('user', $a_where, $s_field, $a_order);
    }

    /***************************** 根据用户名返回条数 ******************************/

    /**
     * [get_user_exist 根据用户名返回条数]
     * @param  [type] $user_name [传入的用户名]
     * @return [type]            [返回条数]
     */
    public function get_user_exist($user_name)
    {
        $a_where  = [
            'user_name' => $user_name,
        ];
        return $this->db->get_total('user', $a_where);
    }

    /***************************** 根据手机号码返回条数 ******************************/

    /**
     * [get_user_exist 根据用户名返回条数]
     * @param  [type] $user_name [传入的手机号码]
     * @return [type]            [返回条数]
     */
    public function get_phone_exist($user_phone)
    {
        $a_where  = [
            'user_phone' => $user_phone,
        ];
        return $this->db->get_total('user', $a_where);
    }

    /***************************** 插入一条积分变动信息 ******************************/

    public function insert_points_log($a_data)
    {
        return $this->db->insert('points_log', $a_data);
    }

    /***************************** 插入一条余额变动信息 ******************************/

    /**
     * [insert_userbalance description]
     * @param  [type] $a_data [description]
     * @return [type]         [description]
     */
    public function insert_userbalance($a_data)
    {
        return $this->db->insert('userbalance', $a_data);
    }

    /********************************************************************************/

}
