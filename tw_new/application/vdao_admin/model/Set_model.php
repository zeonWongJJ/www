<?php

class Set_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************* 设置列表 *************************************/

    public function get_set_all()
    {
        $a_data = $this->db->get('set', [], '', [], 0, 9999999);
        return $a_data;
    }

    /************************************* 保存设置 *************************************/

    /**
     * [update_set 保存设置]
     * @param  [array] $a_where [修改的条件]
     * @param  [array] $a_data  [修改的数据]
     * @return [int]            [返回受影响的行数]
     */
    public function update_set($a_where, $a_data)
    {
        $i_result = $this->db->update('set', $a_data, $a_where);
        return $i_result;
    }

    /************************************* 保存设置 *************************************/


}
