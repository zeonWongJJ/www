<?php
class Is_login_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/**********************************************************************************/

	// 用户是否登录
	public function is_login(){
		if(!isset($_SESSION['user_id']) && !isset($_SESSION['user_name'])){
			$this->error->show_error('您没有登录,请您先登录', 'login', false, 2);
		}
	}

/**********************************************************************************/

}
?>