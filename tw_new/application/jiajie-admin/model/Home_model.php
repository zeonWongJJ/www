<?php

class Home_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/******************************* 获取一条管理员信息 *******************************/

	/**
	 * [get_admin_one 获取一条管理员信息]
	 * @param  [type] $admin_id [description]
	 * @return [type]           [description]
	 */
	public function get_admin_one($admin_id) {
		$a_where = [
			'admin_id' => $admin_id
		];
		$a_data = $this->db->get_row('admin', $a_where);
		return $a_data;
	}

/**********************************************************************************/

}