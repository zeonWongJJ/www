<?php

class Allow_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/**********************************************************************************************/

	//判断用户是否登录
	public function is_login() {
		if ( !isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['role_id'])) {
			$this->error->show_error('请先登录再进行操作', 'login', false, 2);
		}
	}

/**********************************************************************************************/

	//判断当前登录用户是否有权访问该方法
	public function is_allow() {
		//判断是否是超级管理员 超级管理员拥有所有权限 直接跳过验证
		if ($_SESSION['role_id']==1) {
			return true;
		}
		//获取当前的url
		$url = $this->router->get_index();
		//默认允许访问的权限
		$default_url = "login-index-loginout";
		if (strpos($default_url, $url) !== false) {
			return true;
		}
		//获取当前管理员的所有权限url
		$a_where = [
			'role_id' => $_SESSION['role_id'],
		];
		$a_data = $this->db->get_row('role', $a_where);
		$allow_url = $a_data['role_auth'];
		//当前url是否在允许的权限内
		$pos = strpos($allow_url, $url);
		if ($pos === false) {
			$this->error->show_remind('您没有访问权限', 'index', false, 2);
		}
	}

/**********************************************************************************************/

}

?>