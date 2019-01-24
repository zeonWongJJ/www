<?php

class Manager_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************* 门店管理员列表 *************************************/

    public function get_manager_showlist()
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
        $a_where = [
            $this->db->get_prefix() . 'manager.store_id !=' => 0,
        ];
        $i_total = $this->db->get_total('manager', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = 'store_name,manager_id,manager_name,manager_phone,manager_email,' . $this->db->get_prefix() . 'manager.group_id,register_time,login_time,' . $this->db->get_prefix() . 'group.group_name';
        $a_order = [
            $this->db->get_prefix() . 'manager.manager_id' => 'desc',
        ];
        $a_data  = $this->db->from('manager')
            ->join('store', [$this->db->get_prefix() . 'store.store_id' => $this->db->get_prefix() . 'manager.store_id'])
            ->join('group', [$this->db->get_prefix() . 'group.group_id' => $this->db->get_prefix() . 'manager.group_id'])
            ->get('', $a_where, $s_field, $a_order);
        return $a_data;
    }

    /************************************* 添加门店管理员 *************************************/

    /**
     * [get_store_all 获取所有门店信息]
     * @return [int] [返回查询到的所有门店信息]
     */
    public function get_store_all()
    {
        $s_field = 'store_id,store_name';
        $a_order = [
            'store_id' => 'desc',
        ];
        $a_data  = $this->db->get('store', [], $s_field, $a_order);
        return $a_data;
    }

    /************************************ 获取门店分组信息 ************************************/

    /**
     * [get_group_store 获取对应门店所有的分组信息]
     * @param  [int]   $store_id [要获取的门店]
     * @return [array]           [返回获取的到所有信息]
     */
    public function get_group_store($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $s_field = 'group_id, group_name';
        $a_order = [
            'group_id' => 'desc',
        ];
        $a_data  = $this->db->get('group', $a_where, $s_field);
        return $a_data;
    }

    /************************************* 创建默认分组 *************************************/

    /**
     * [insert_group_manager 如果门店分组为空则自动创建一个默认分组]
     * @param  [array] $a_data [要插入的数据]
     * @return [int]           [返回新数据的行数]
     */
    public function insert_group_manager($a_data)
    {
        $i_result = $this->db->insert('group', $a_data);
        return $i_result;
    }

    /************************************* 获取数据总条数 *************************************/

    /**
     * [check_manager_name 获取用户名为xx的数据总条数]
     * @param  [string] $manager_name   [要查询的管理员名称]
     * @return [array]                  [返回查询到的数据]
     */
    public function check_manager_name($manager_name)
    {
        $a_where = [
            'manager_name' => $manager_name,
        ];
        $a_data  = $this->db->get_row('manager', $a_where);
        return $a_data;
    }

    /************************************* 插入一条门店信息 *************************************/

    /**
     * [insert_manager 插入一条门店管理员信息]
     * @param  [array] $a_data [要插入的信息]
     * @return [int]           [返回新数据的id]
     */
    public function insert_manager($a_data)
    {
        $i_result = $this->db->insert('manager', $a_data);
        return $i_result;
    }

    /************************************* 更新用户组总数 *************************************/

    /**
     * [update_manager_count 添加管理员成功后将对应管理组的管理员总数加1]
     * @param  [int] $group_id [要查询和更新的角色id]
     * @return [int]          [返回更新的总行数]
     */
    public function update_manager_count($group_id)
    {
        $a_where  = [
            'group_id' => $group_id,
        ];
        $i_result = $this->db->get_total('manager', $a_where);
        //将对应角色的管理员总数更新
        $a_update_data = [
            'manager_count' => $i_result,
        ];
        $i_result      = $this->db->update('group', $a_update_data, $a_where);
        return $i_result;
    }

    /********************************** 获取一条门店管理员信息 **********************************/

    /**
     * [get_manager_one 根据id获取一条门店管理员信息]
     * @param  [int]   $manager_id [传入的管理员id]
     * @return [array]             [返回查询到的数据]
     */
    public function get_manager_one($manager_id)
    {
        $a_where = [
            'manager_id' => $manager_id,
        ];
        $a_data  = $this->db->get_row('manager', $a_where);
        return $a_data;
    }

    /************************************* 获取店铺全部角色 *************************************/

    /**
     * [get_manager_group 获取某个店铺的全部分组信息]
     * @param  [int]   $store_id [传入的店铺id]
     * @return [array]           [返回查询到的所有角色信息]
     */
    public function get_manager_group($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $s_field = '';
        $a_order = [
            'group_id' => 'desc',
        ];
        $a_data  = $this->db->get('group', $a_where, $s_field, $a_order);
        return $a_data;
    }

    /************************************* 修改门店管理员 *************************************/

    /**
     * [update_manager 修改门店管理员信息]
     * @param  [array] $a_where [要修改的条件]
     * @param  [array] $a_data  [要修改的数据]
     * @return [int]            [返回修改的行数]
     */
    public function update_manager($a_where, $a_data)
    {
        $i_result = $this->db->update('manager', $a_data, $a_where);
        return $i_result;
    }

    /************************************* 删除门店管理员 *************************************/

    /**
     * [delete_manager_one 根据id删除单个门店管理员]
     * @param  [int] $manager_id [要删除的门店管理员id]
     * @return [int]             [返回删除的总行数]
     */
    public function delete_manager_one($manager_id)
    {
        $a_where  = [
            'manager_id' => $manager_id,
        ];
        $i_result = $this->db->delete('manager', $a_where);
        return $i_result;
    }

    /**
     * [delete_manager_mony 批量删除门店管理员]
     * @param  [array] $a_data     [要删除的门店id数组]
     * @return [int]   $i_result   [返回删除的行数]
     */
    public function delete_manager_mony($a_data)
    {
        $i_result = $this->db->where_in('manager_id', $a_data)->delete('manager');
        return $i_result;
    }

    /******************************************************************************************/


}
