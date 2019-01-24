<?php
defined('BASEPATH') OR exit('禁止访问！');
class Index_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('index_model');
		$this->load->model('allow_model');
		//判断是否登录
		$this->allow_model->is_login();
		//判断是否有权限访问
		$this->allow_model->is_allow();
	}

	//首页
	public function index(){
		$_SESSION['id']=1;
		// $this->Auth_model->delete_auth(1);

		$this->Login_model->growth_experience();

	}


}
