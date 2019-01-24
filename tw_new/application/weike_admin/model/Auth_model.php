<?php

class Auth_model extends TW_Model {

    public function __construct() {
        parent :: __construct();
    }

/**********************************************************************************************/

    //获取所有权限信息
    public function get_auth_showlist() {
        $a_where = [];
        $s_field = '';
        $a_order = [
            'auth_id' => 'desc'
        ];
        $a_data = $this->db->get('auth', $a_where, $s_field, $a_order);
        return $a_data;
    }

/**********************************************************************************************/

    //删除权限
    public function delete_auth($id) {
        $a_where = [
            'auth_id' => $id,
        ];
        $i_result = $this->db->delete('auth', $a_where);
        return $i_result;
    }

/**********************************************************************************************/

    //插入一条权限信息
    public function insert_auth($a_data) {
        $i_result = $this->db->insert('auth', $a_data);
        return $i_result;
    }

/**********************************************************************************************/

    //获取某一条权限的详情
    public function get_auth_detail($id) {
        $a_where = [
            'auth_id' => $id
        ];
        $a_data = $this->db->get_row('auth', $a_where);
        return $a_data;
    }

/**********************************************************************************************/

    //修改权限
    public function update_auth($a_where, $a_data) {
        $i_result = $this->db->update('auth', $a_data, $a_where);
        return $i_result;
    }

/**********************************************************************************************/

}

?>