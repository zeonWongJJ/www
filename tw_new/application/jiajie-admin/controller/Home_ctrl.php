<?php

defined('BASEPATH') or exit('禁止访问！');

class Home_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('home_model');
	}

/************************************** 首页 **************************************/

	public function index() {
		// 获取一条管理员信息
		$a_data['admin'] = $this->home_model->get_admin_one($_SESSION['admin_id']);
		$this->view->display('index', $a_data);
	}

/**********************************************************************************/

}