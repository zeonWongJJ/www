<?php

class Order_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
		$this->load->model('order_model');
		$this->load->model('allow_model');
		//判断是否登录
		$this->allow_model->is_login();
		//判断是否有权限访问
		$this->allow_model->is_allow();
	}

	//全部订单
	public function order_all() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->order_model->get_order_all();
			$this->view->display('order_all', $a_data);
		}
	}
}

?>