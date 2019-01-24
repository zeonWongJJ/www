<?php

class User_money_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('user_money_model');
        $this->load->model('is_login_model');
        $this->is_login_model->is_login();
	}

/**********************************************************************************/

	//会员中心->交易记录
	public function user_mymoney() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//获取时实总金额
			$a_total = $this->user_money_model->get_money_total();
			$money_total = $a_total['original_value']+$a_total['variation'];
			$a_detail = $this->user_money_model->get_money_detail();
			$a_data = array('total'=>$money_total, 'detail'=>$a_detail);
			$this->view->display('myAssets',$a_data);
		}
	}

/**********************************************************************************/

	//账户充值
	public function user_recharge() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		} else {
			$this->view->display('recharge');
		}
	}

/**********************************************************************************/

}

?>