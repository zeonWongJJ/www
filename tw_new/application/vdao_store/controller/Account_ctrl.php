<?php
defined('BASEPATH') or exit('禁止访问！');
class Account_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('account_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 结算列表 *************************************/

	// public function account_showlist() {
	// 	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	// 		$state = $this->router->get(1);
	// 		if ($state === false) {
	// 			$state = 9;
	// 		}
	// 		$a_data = $this->account_model->get_account_page($_SESSION['store_id'], $state);
	// 		// 获取不同状态下的结算总条数
	// 		$a_data['state_zero'] = $this->account_model->get_total_state(0);
	// 		$a_data['state_one'] = $this->account_model->get_total_state(1);
	// 		$a_data['state_two'] = $this->account_model->get_total_state(2);
	// 		$a_data['state'] = $state;
	// 		$this->view->display('account_showlist2', $a_data);
	// 	}
	// }
	public function account_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$state = $this->router->get(1);
			if ($state === false) {
				$state = 9;
			}
			$a_data = $this->account_model->get_accounttbl_page($_SESSION['store_id'], $state);
			// 获取不同状态下的结算总条数
			$a_data['state_zero'] = $this->account_model->get_tbl_total_state(0);
			$a_data['state_one'] = $this->account_model->get_tbl_total_state(1);
			$a_data['state_two'] = $this->account_model->get_tbl_total_state(2);
			$a_data['state'] = $state;
			$this->view->display('account_showlist2', $a_data);
		}
	}
/************************************* 查看明细 *************************************/

	public function account_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收需要查看明细的结算id
			$account_date = $this->router->get(1);
			$stye       = $this->router->get(2);
			
			// 获取结算详情
			$a_data['detail'] = $this->account_model->get_tbl_account_one($account_date);
					
			// 获取月订单
			$a_order = $this->account_model->get_tbl_month_order($account_date,$stye);
			$a_data['order'] = $a_order['order'];
			$a_data['count'] = $a_order['count'];
			$a_data['page']  = $a_order['page'];
			$a_data['prow']  = $a_order['prow'];
			$a_data['stye']  = $stye;
			$this->view->display('account_detail2', $a_data);
		}
	}

/************************************************************************************/

}

?>