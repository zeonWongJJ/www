<?php

class Login_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/**********************************************************************************************/

	//登录->判断用户名是否在存在
	public function check_username_exist($uername) {
		$a_where = [
			'username' => $uername
		];
		$a_data = $this->db->get_row('admin', $a_where);
		return $a_data;
	}

/**********************************************************************************************/

	//更新历史登录记录表
	public function insert_location($a_data) {
		$i_result = $this->db->insert('location', $a_data);
		return $i_result;
	}

/**********************************************************************************************/
}

?>