<?php

class Login_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/****************************** 根据手机号码获取用户 ******************************/

	/**
	 * [get_user_byphone 根据手机号码获取用户]
	 * @param  [type] $user_phone [description]
	 * @return [type]             [description]
	 */
	public function get_user_byphone($user_phone) {
		$a_where = [
			'user_phone' => $user_phone
		];
		$a_data = $this->db->get_row('user', $a_where);
		return $a_data;
	}

/**********************************************************************************/


}