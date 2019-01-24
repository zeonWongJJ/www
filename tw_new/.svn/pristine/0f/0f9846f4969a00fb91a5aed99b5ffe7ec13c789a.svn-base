<?php
class Login_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}
	
	public function login() {
		if ( ! isset($_SESSION['user_id']) ) {
			// $this->error->show_error('请先登录！', $this->router->url('login',[$this->general->base64_convert($this->router->url('index'))]), '',1);
			if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
                   $this->error->show_error('请先登录！', $this->router->url('login_ios',[$this->general->base64_convert($this->router->url('index'))]), '',1);
            } else if(strpos($_SERVER['HTTP_USER_AGENT'],'APP_WEBVIEW') !== false) { 
                    $this->error->show_error('请先登录！', $this->router->url('login_android',[$this->general->base64_convert($this->router->url('index'))]), '',1);
            } else {
                 	$this->error->show_error('请先登录！', $this->router->url('login',[$this->general->base64_convert($this->router->url('index'))]), '',1);
            }
		}
	}
}
?>