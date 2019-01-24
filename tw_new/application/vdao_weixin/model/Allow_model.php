<?php

class Allow_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/*********************************** 验证是否登录 ***********************************/

	public function is_login() {
		$oldurl = $this->router->get_url();
		if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
			$a_parameter = [
				'msg'      => '请登录后再操作',
				'url'      => 'login?oldurl='.$oldurl,
				'log'      => false,
				'wait'     => 2,
			];
			$this->error->show_error($a_parameter);
		}
	}

/************************************************************************************/

}

?>