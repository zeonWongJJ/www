<?php

class Login_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /*********************************** 获取一条门店管理员信息 ***********************************/

    /**
     * [get_manager_one 根据用户名获取一条门店管理员信息]
     * @param  [type] $manager_name [description]
     * @return [type]               [description]
     */
    public function get_manager_one($manager_name)
    {
        $a_where = [
            'manager_name' => $manager_name,
        ];
        $a_data  = $this->db->get_row('manager', $a_where);
        return $a_data;
    }

    /************************************* 更新门店管理员信息 *************************************/

    /**
     * [update_manager 更新门店管理员信息]
     * @param  [array] $a_where [要更新的条件]
     * @param  [array] $a_data  [要更新的数据]
     * @return [int]            [返回受影响的行数]
     */
    public function update_manager($a_where, $a_data)
    {
        $i_result = $this->db->update('manager', $a_data, $a_where);
        return $i_result;
    }

    /************************************* 获取一条门店信息 *************************************/

    public function get_store_one($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $a_data  = $this->db->get_row('store', $a_where);
        return $a_data;
    }

    /********************************************************************************************/

}
