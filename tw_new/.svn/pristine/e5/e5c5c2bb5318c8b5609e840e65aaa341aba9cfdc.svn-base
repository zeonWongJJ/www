<?php

class Home_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('home_model');
	}

/******************************************* 首页 *******************************************/

	public function index() {
		// 判断是否登录
		if (isset($_SESSION['user_id'])) {
			// 获取昨日分享收益
			$a_order = $this->home_model->get_order_yestoday($_SESSION['user_id']);
			$a_data['yestoday_income'] = 0;
			if (!empty($a_order)) {
				foreach ($a_order as $key => $value) {
					$a_data['yestoday_income'] = $a_data['yestoday_income'] + $value['order_price'];
				}
			}
			// 获取一条用户信息
			$a_user = $this->home_model->get_user_one($_SESSION['user_id']);
			if (!$a_user) {
				$b_result = session_destroy();
				$a_parameter = [
					'msg'      => '请重新登录',
					'url'      => 'login',
					'log'      => false,
					'wait'     => 2,
				];
				$this->error->show_error($a_parameter);
			}
			$a_data['shopman_income'] = $a_user['shopman_income'];
			$a_data['share_income'] = $a_user['share_income'];
			// 用户信息
			$a_data['user'] = $this->home_model->get_user_one($_SESSION['user_id']);
		} else {
			$a_data['yestoday_income'] = '0.00';
			$a_data['shopman_income'] = 0;
			$a_data['share_income'] = '0.00';
		}
		// 获取热门的关键词
		$a_data['keywords'] = $this->home_model->get_search_hot();
		// 获取定位信息
		$this->load->library('map_gaode');
		$a_result =$this->map_gaode->ip_to_address($this->general->get_ip());
		$a_data['add'] = $a_result['province'] . $a_result['city'];
		$a_data['result'] =$this->map_gaode->weather($a_result['adcode']);
		$this->view->display('index2', $a_data);
	}

/**************************************** 用户中心 ****************************************/

	public function user_center() {
		if (empty($_SESSION['user_id'])) {
			$this->view->display('user_center1');
		} else {
			// 用户信息
			$a_data['user'] = $this->home_model->get_user_one($_SESSION['user_id']);
			if (!$a_data['user']) {
				$b_result = session_destroy();
				$a_parameter = [
					'msg'      => '请重新登录',
					'url'      => 'login',
					'log'      => false,
					'wait'     => 2,
				];
				$this->error->show_error($a_parameter);
			}
			// 动态数量
			$a_data['mood_count'] = $this->home_model->get_mood_count($_SESSION['user_id']);
			$this->view->display('user_center2', $a_data);
		}
	}

/**************************************** 客服中心 ****************************************/

	public function call_center() {
		$this->view->display('call_center');
	}

/**************************************** 搜索中心 ****************************************/

	public function index_search() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		} else {
			$this->view->display('index_search');
		}
	}

/**************************************** 了解使用 ****************************************/

	public function index_use() {
		$this->view->display('index_use');
	}


	// 银行卡退款
	public function unionpay_refund_notify() {

	}

	// 微信退款
	public function wxrefund_notify() {

	}

/********************************************************************************************/

}

?>