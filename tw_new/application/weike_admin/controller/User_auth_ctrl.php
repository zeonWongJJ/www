<?php
defined('BASEPATH') OR exit('禁止访问！');
class User_auth_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('User_auth_model');
	}

	public function user_auth(){

		// 查看需要验证的信息
		$a_data = $this->User_auth_model->user_auth();

		// $this->view->display('user', $a_data);
	}

	public function user_auth_update(){
		if(empty($this->router->get(1))){
			$this->error->show_error('未找到该用户','user_auth');
		}

		if (! empty($this->general->post('auth_status'))){
			$auth_status = $this->general->post('auth_status');
			$user_auth_id= $this->router->get(1);
			$result = $this->User_model->user_auth_update($user_auth_id,$auth_status);
			if ($result['status']){
				$this->error->show_success($result['tips'], $result['url']);
			} else {
				$this->error->show_error($result['tips'], $result['url']);
			}
		} else {
			$this->view->display('user_auth_update');
		}
	}
}
