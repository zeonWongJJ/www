<?php

class Allow_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/*********************************** 验证是否登录 ***********************************/

	public function is_login() {
		$oldurl = $this->router->get_url();
		if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
		    $this->error->location($this->router->url('nuser_center'));
//			$a_parameter = [
//				'msg'      => '',
//				'url'      => 'nuser_center',
//				'log'      => false,
//				'wait'     => 0,
//			];
//			$this->error->show_error($a_parameter);
		}
	}

	public function is_wechat() {
		$is_wechat = false;
		// header("Content-type: text/html; charset=utf-8"); 
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		if (!strpos($user_agent, 'MicroMessenger') === false) {
			$is_wechat = true;
		} 
		return $is_wechat;
	}
	

/************************************************************************************/
}

?>