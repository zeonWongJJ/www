<?php

class Appellation extends TW_Model {

    public function __construct() {
        parent :: __construct();
    }

/**********************************************************************************************/

    //获取称号列表信息
    public function get_appellation_server($app_type) {
        $a_where = [
            'app_type' => $app_type
        ];
        $s_field = '';
        $a_order = [
            'app_level' => 'desc'
        ];
        $a_data = $this->db->get('appellation', $a_where, $s_field, $a_order);
        return $a_data;
    }

/**********************************************************************************************/

    //添加称号
    public function insert_appellation($a_data) {
        $i_result = $this->db->insert('appellation', $a_data);
        return $i_result;
    }

/**********************************************************************************************/

    //删除某个称号
    public function delete_appellation($id) {
        $a_where = [
            'app_id' => $id,
        ];
        $i_result = $this->db->delete('appellation', $a_where);
        return $i_result;
    }

/**********************************************************************************************/

    //获取某一条称号的详情
    public function get_appellation_detail($id) {
        $a_where = [
            'app_id' => $id
        ];
        $a_data = ->db->get_row('appellation', $a_where);
        return $a_data;
    }

/**********************************************************************************************/

    //更新某一条称号
    public function update_appellation($a_where, $a_data) {
        $i_result = $this->db->update('appellation', $a_data, $a_where);
        return $i_result;
    }

/**********************************************************************************************/

}

?>