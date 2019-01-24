<?php
defined('BASEPATH') OR exit('禁止访问！');
class Member_ctrl extends TW_Controller {
	
	public function __construct() {
		parent :: __construct();

		//实例化模型
		$this->load->model('login_model');
	}
	//个人中心
	public function member() {
		//判断是否登录
		$this->login_model->login();
		$a_data = $this->db->get_row('member', ['member_name' => $_SESSION['user_name']]);
		$this->view->display('member/member', $a_data);
	}
}
