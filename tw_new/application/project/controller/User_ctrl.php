<?php
class User_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
		
		$this->load->model('user_model');
	}
	
	// 注册
	public function register() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_post = $this->general->post();
			$a_result = $this->user_model->register($a_post);
			if ($a_result['state_code'] != '10000') {
				$this->error->show_error($a_result['msg']);
			} else {
				$this->error->show_success($a_result['msg'], '/');
			}
		} else {
			$a_get = $this->general->get();
			$this->load->library('phpqrcode');
			$a_param = [
				// 要生成二维码的数据，必填
				'data' => 'http://www.7dugo.com/weixin_code.html',
				// 二维码图片大小，选填，默认4
				'size' => 10,
				// 二维码错误修正级别L/M/Q/H，选填，默认“L”。L水平 7% 的字码可被修正，M水平 15% 的字码可被修正，Q水平 25% 的字码可被修正，H水平 30% 的字码可被修正
				'level' => 'L'
			];
			if ( ! isset($a_get['openid']) || empty($a_get['openid']) ) {
				$this->phpqrcode->qrcode($a_param);
				exit;
			}
			$this->view->display('login', $a_get);
		}
	}
	
	// 登录
	public function login() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_post = $this->general->post();
			$a_result = $this->user_model->login($a_post);
			if ($a_result['state_code'] != '10000') {
				$this->error->show_error($a_result['msg']);
			} else {
				//$this->error->show_success($a_result['msg'], '/');
				$this->error->location('/');
			}
		} else {
			$this->view->display('login');
		}
	}
	
	// 注销
	public function logout() {
		$a_result = $this->user_model->logout();
		$this->error->show_success($a_result['msg'], '/');
	}
}
?>