<?php

class Admin_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************* 管理员列表 *************************************/

    /**
     * [get_admin_showlist 获取所有管理员信息]
     * @return [array] $a_data [返回所有管理员的信息]
     */
    public function get_admin_showlist()
    {
        $a_order = [
            $this->db->get_prefix() . 'admin.admin_id' => 'desc',
        ];
        $a_data  = $this->db->from('admin')
            ->join('role', [$this->db->get_prefix() . 'admin.role_id' => $this->db->get_prefix() . 'role.role_id'])
            ->get('', [], '', $a_order, 0, 999999);
        return $a_data;
    }

    /**
     * [get_role_all 获取角色信息]
     * @return [array] $a_data [返回所有的角色信息]
     */
    public function get_role_all()
    {
        $a_order = [
            'role_id' => 'desc',
        ];
        $a_data  = $this->db->get('role', [], '', $a_order, 0, 999999);
        return $a_data;
    }

    /************************************* 添加管理员 *************************************/

    /**
     * [insert_admin  插入一条数据到表admin]
     * [ 操作表 admin 操作方式 insert ]
     * @param  [array]  $a_data     [要插入的数据]
     * @return [int]    $i_result    [返回新数据的id]
     */
    public function insert_admin($a_data)
    {
        $i_result = $this->db->insert('admin', $a_data);
        return $i_result;
    }

    /**
     * [get_name_occupy 获取用户名为xx的管理员总条数]
     * @param  [string] $admin_name [用户名]
     * @return [int]                [返回查询到的总条数]
     */
    public function get_name_occupy($admin_name)
    {
        $a_where  = [
            'admin_name' => $admin_name,
        ];
        $i_result = $this->db->get_total('admin', $a_where);
        return $i_result;
    }

    /**
     * [admin_count_add 添加管理员成功后将对应角色的管理员总数更新]
     * @param  [int] $role_id [角色id]
     * @return [int]          [返回修改受影响的行数]
     */
    public function update_admin_count($role_id)
    {
        //先查询原来的数量
        $a_where = [
            'role_id' => $role_id,
        ];
        $a_data  = $this->db->get_total('admin', $a_where);
        //将新数据更新到表中
        $a_update_data = [
            'admin_count' => $a_data,
        ];
        $i_result      = $this->db->update('role', $a_update_data, $a_where);
        return $i_result;
    }

    /*********************************** 修改管理员信息 ***********************************/

    /**
     * [get_admin_one 根据id获取一条管理员信息]
     * [ 操作的表 admin 操作方式 select ]
     * @param  [int]    $admin_id    [要查询的管理员id]
     * @return [array]  $a_data     [管理员信息]
     */
    public function get_admin_one($admin_id)
    {
        $a_where = [
            'admin_id' => $admin_id,
        ];
        $a_data  = $this->db->get_row('admin', $a_where);
        return $a_data;
    }

    /**
     * [update_admin 修改管理员信息]
     * [ 操作的表 admin 操作方式 update ]
     * @param  [array] $a_where    [条件]
     * @param  [array] $a_data    [要更新的数据]
     * @return [int]   $i_result    [受影响的行数]
     */
    public function update_admin($a_where, $a_data)
    {
        $i_result = $this->db->update('admin', $a_data, $a_where);
        return $i_result;
    }

    /************************************* 删除管理员 *************************************/

    /**
     * [delete_admin  删除单个管理员]
     * [ 操作的表 admin 操作方式 delete ]
     * @param  [int] $id         [要删除的管理员的id]
     * @return [int] $i_result  [返回受影响的行数]
     */
    public function delete_admin_one($admin_id)
    {
        $a_where  = [
            'admin_id' => $admin_id,
        ];
        $i_result = $this->db->delete('admin', $a_where);
        return $i_result;
    }

    /**
     * [delete_manager_mony 批量删除管理员]
     * @param  [array] $a_data     [要删除的管理员id数组]
     * @return [int]   $i_result   [返回删除的行数]
     */
    public function delete_admin_mony($a_data)
    {
        $i_result = $this->db->where_in('admin_id', $a_data)->delete('admin');
        return $i_result;
    }

    /****************************** 根据关键词获取管理员信息 ******************************/

    public function get_admin_search($keywords)
    {
        $a_where_or = [
            'admin_name LIKE'     => '%' . $keywords . '%',
            'admin_realname LIKE' => '%' . $keywords . '%',
            'admin_phone LIKE'    => '%' . $keywords . '%',
            'admin_email LIKE'    => '%' . $keywords . '%',
        ];
        $s_field    = '';
        $a_order    = [
            'admin_id' => 'desc',
        ];
        $a_data     = $this->db->from('admin')
            ->join('role', [$this->db->get_prefix() . 'admin.role_id' => $this->db->get_prefix() . 'role.role_id'])
            ->where_or($a_where_or)
            ->get('', [], $s_field, $a_order, 999999);
        return $a_data;
    }

    /**************************************************************************************/

}
