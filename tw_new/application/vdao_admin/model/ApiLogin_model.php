<?php
/**
 * Created by PhpStorm.
 * User: 7du-28
 * Date: 2018/4/25
 * Time: 13:44
 */

class ApiLogin_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    //获取要登录用户的信息

    /**
     * [get_user_info 获取要登录的用户的信息]
     * @param  [string] $admin_name [要登录的管理员用户名]
     * @return array  $a_data     [返回查询到的管理员信息]
     */
    public function get_user_info($admin_name)
    {
        $a_where = [
            'admin_name' => $admin_name,
        ];
        return $this->db->get_row('admin', $a_where);
    }

    /********************************* 获取一条角色信息 *************************************/

    /**
     * [get_role_one 获取一条角色信息]
     * @param  [int]   $role_id [传入的角色信息]
     * @return array          [返回查询到的数据]
     */
    public function get_role_one($role_id)
    {
        $a_where = [
            'role_id' => $role_id,
        ];
        return $this->db->get_row('role', $a_where);
    }
    /*********************************** 更新管理员记录 *************************************/

    /**
     * [update_admin_login 登录成功后更新表]
     * @param  [array] $a_where        [更新的条件]
     * @param  [array] $a_data        [更新的数据]
     * @return int   $i_result        [返回更新的行数]
     */
    public function update_admin_login($a_where, $a_data)
    {
        return $this->db->update('admin', $a_data, $a_where);
    }
    /******************************************************************************************/
}