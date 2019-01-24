<?php

class Code_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /**********************************************************************************/

    //将发送成功的验证码写入到数据库 [ 操作的表 new_code 操作方式 insert ]
    public function insert_code($a_data)
    {
        $i_result = $this->db->insert('code', $a_data);
        return $i_result;
    }

    /**********************************************************************************/

}
