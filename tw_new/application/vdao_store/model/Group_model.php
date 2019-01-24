<?php

class Group_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /***************************************** 所有分组 *****************************************/

    public function get_group_showlist($store_id)
    {
        // 先设置默认从第一页开始
        // $i_page = $this->router->get(1);
        // if (empty($i_page)) {
        // 	$i_page = 1;
        // }
        // // 设置每页显示的数据行数
        // $i_prow = 10;
        // // 加载分页类
        // $this->load->library('pages');
        // 获取数据总行数
        $a_where = [
            'store_id' => $store_id,
        ];
        $i_total = $this->db->get_total('group', $a_where);
        // 调用分页运算函数
        // $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // // 开始获取产品数据
        // $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = '';
        $a_order = [
            'group_id' => 'desc',
        ];
        $a_data  = $this->db->get('group', $a_where, $s_field, $a_order, 0, $i_total);
        return $a_data;
    }

    /***************************************** 所有分组 *****************************************/

    public function get_group_all()
    {
        $a_order = [
            'group_id' => 'desc',
        ];
        $a_data  = $this->db->get('group', [], '', $a_order);
        return $a_data;
    }

    /*************************************** 获取所有权限 ***************************************/

    /**
     * [get_auth_showlist 获取所有权限信息]
     * @return [array] [返回查询到的所有权限信息]
     */
    public function get_auth_all()
    {
        $a_where = [
            'auth_type' => 3,
        ];
        $a_order = [
            'auth_id' => 'desc',
        ];
        $a_data  = $this->db->get('auth', $a_where, '', $a_order);
        return $a_data;
    }

    /************************************* 插入一条分组信息 *************************************/

    /**
     * [insert_group 插入一条分组信息]
     * @param  [array] $a_data [要插入的数据]
     * @return [int]           [返回新数据的id]
     */
    public function insert_group($a_data)
    {
        $i_result = $this->db->insert('group', $a_data);
        return $i_result;
    }

    /************************************* 获取一条分组信息 *************************************/

    /**
     * [get_group_one 获取一条分组信息]
     * @return [type] [description]
     */
    public function get_group_one($group_id)
    {
        $a_where = [
            'group_id' => $group_id,
        ];
        $a_data  = $this->db->get_row('group', $a_where);
        return $a_data;
    }

    /************************************* 修改一条分组信息 *************************************/

    /**
     * [update_group 修改一条分组信息]
     * @param  [array] $a_where [修改的条件]
     * @param  [array] $a_data  [修改的数据]
     * @return [int]            [返回修改的行数]
     */
    public function update_group($a_where, $a_data)
    {
        $i_result = $this->db->update('group', $a_data, $a_where);
        return $i_result;
    }

    /********************************* 获取一条分组的管理员总数 *********************************/

    /**
     * [get_manager_total 获取一条分组的管理员总数]
     * @param  [int] $group_id   [传入的分组id]
     * @return [array]           [返回查询到的数据]
     */
    public function get_manager_total($group_id)
    {
        $a_where  = [
            'group_id' => $group_id,
        ];
        $i_result = $this->db->get_total('manager', $a_where);
        return $i_result;
    }

    /************************************ 删除一条分组信息 ************************************/

    /**
     * [delete_group_one 删除一条分组信息]
     * @param  [int] $group_id  [传入的要删除的分组id]
     * @return [int]            [description]
     */
    public function delete_group_one($group_id)
    {
        $a_where  = [
            'group_id' => $group_id,
        ];
        $i_result = $this->db->delete('group', $a_where);
        return $i_result;
    }

    /********************************** 根据关键词获取分组信息 **********************************/

    public function get_group_search($keywords)
    {
        $a_where    = [
            'store_id' => $_SESSION['store_id'],
        ];
        $a_where_or = [
            'group_name LIKE'        => '%' . $keywords . '%',
            'group_description LIKE' => '%' . $keywords . '%',
        ];
        $s_field    = '';
        $a_order    = [
            'group_id' => 'desc',
        ];
        $a_data     = $this->db->where($a_where)
            ->group_start('AND')
            ->where_or($a_where_or)
            ->group_end()
            ->get('group', NULL, $s_field, $a_order, 0, 9999);
        return $a_data;
    }

    /********************************************************************************************/

}
