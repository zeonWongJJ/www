<?php

class Role_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/**********************************************************************************************/

	//获取所有角色信息
	public function get_role_showlist() {
		$a_where = [];
		$s_field = '';
		$a_order = [
			'role_id' => 'desc'
		];
		$a_data = $this->db->get('role', $a_where, $s_field, $a_order);
		return $a_data;
	}

/**********************************************************************************************/

	//获取某一个角色的详情
	public function get_role_detail($id) {
		$a_where = [
			'role_id' => $id
		];
		$a_data = $this->db->get_row('role', $a_where);
		return $a_data;
	}

/**********************************************************************************************/

	//获取所有的权限信息
	public function get_auth_all() {
		$a_where = [];
		$s_field = '';
		$a_order = [
			'auth_id' => 'desc'
		];
		$a_data = $this->db->get('auth', $a_where, $s_field, $a_order);
		return $a_data;
	}

/**********************************************************************************************/

	//更新角色信息
	public function update_role($a_where, $a_data) {
		$i_result = $this->db->update('role', $a_data, $a_where);
		return $i_result;
	}

/**********************************************************************************************/

	//添加角色
	public function insert_role($a_data) {
		$i_result = $this->db->insert('role', $a_data);
		return $i_result;
	}

/**********************************************************************************************/

	//删除角色
	public function delete_role($id) {
		$a_where = [
			'role_id' => $id,
		];
		$i_result = $this->db->delete('role', $a_where);
		return $i_result;
	}

/**********************************************************************************************/

}

?>