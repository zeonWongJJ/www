<?php
defined('BASEPATH') OR exit('禁止访问！');
class Bond_ctrl extends TW_Controller{
	public function __construct(){
		parent :: __construct();

		$this->load->model('login_model');
		
	}

	//我的代金券
	public function voucher_list(){ 

		//判断是否登录
		$this->login_model->login();

		$this->view->display('member/voucher_list');
	}

	//积分兑换
	public function exchange_code(){ 

		$this->view->display('member/exchange_code');
	}
}