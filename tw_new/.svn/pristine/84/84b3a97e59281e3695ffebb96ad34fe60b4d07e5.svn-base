<?php

namespace model;

class LoginModel extends \TW_Model {

	public function __construct() {
		parent :: __construct();
	}

	public function login() {
		if ( ! isset($_SESSION['user_id']) ) {
			$this->error->show_error('请先登录！', $this->router->url('login',[$this->general->base64_convert($this->router->url('index'))]));
		}
	}
}
?>
