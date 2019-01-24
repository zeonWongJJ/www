<?php

class Admin_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/**********************************************************************************************/

	//获取所有管理员信息
	public function get_admin_showlist() {
		$a_where = [];
		$s_field = '';
		$a_order = [
			'admin_id' => 'desc'
		];
		$a_data = $this->db->get('admin', $a_where, $s_field, $a_order);
		return $a_data;
	}

/**********************************************************************************************/

	//添加管理员时获取角色信息
	public function get_role_info() {
		$a_where = [];
		$s_field = '';
		$a_order = [
			'role_id' => 'desc'
		];
		$a_data = $this->db->get('role', $a_where, $s_field, $a_order);
		return $a_data;
	}

/**********************************************************************************************/

	//添加管理员
	public function insert_admin($a_data) {
		$i_result = $this->db->insert('admin', $a_data);
		return $i_result;
	}

/**********************************************************************************************/

	//删除某个管理员
	public function delete_admin($id) {
		$a_where = [
			'admin_id' => $id,
		];
		$i_result = $this->db->delete('admin', $a_where);
		return $i_result;
	}

/**********************************************************************************************/

	//获取某个管理员信息的详情
	public function get_admin_detail($id) {
		$a_where = [
			'admin_id' => $id
		];
		$a_data = ->db->get_row('admin', $a_where);
		return $a_data;
	}
/**********************************************************************************************/

	//修改某个管理员的信息
	public function update_admin($a_where, $a_data) {
		$i_result = $this->db->update('admin', $a_data, $a_where);
		return $i_result;
	}

/**********************************************************************************************/


}

?>