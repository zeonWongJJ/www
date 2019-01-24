<?php
defined('BASEPATH') or exit('禁止访问！');
class Statistic_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('statistic_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 用户消费统计 *************************************/

	public function statistic_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$time = $this->router->get(1);
			if (empty($time)) {
				$time = 9;
			}
			$a_data = $this->statistic_model->get_statistic_page($time);
			$a_all = $this->statistic_model->get_statistic_all();
			// 月份信息
			$new_data = array();
			$i = 0;
			foreach ($a_all as $key => $value) {
				if (!in_array($value['sta_time'], $new_data) && $i<13 ) {
					$new_data[] = $value['sta_time'];
					$i++;
				}
			}
			$a_data['month'] = $new_data;
			$a_data['time']  = $time;
			$a_data['type'] = 1;
			$this->view->display('statistic_showlist2', $a_data);
		}
	}

/********************************* 查看该用户当月的订单 *********************************/

	public function statistic_selforder() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收需要获取的统计id
			$sta_id = $this->router->get(1);
			// 获取一条统计信息
			$a_statistic = $this->statistic_model->get_statistic_one($sta_id);
			// 用户当月订单的id数组集合
			$user_selforder = explode(',', $a_statistic['user_selforder']);
			$a_data = $this->statistic_model->get_order_self($user_selforder);
			$a_data['sta_id'] = $sta_id;
			// 用户的基本信息
			$a_data['user'] = $this->statistic_model->get_user_one($a_statistic['user_id']);
			$a_data['statistic'] = $a_statistic;
			$a_data['type'] = 1;
			$this->view->display('statistic_selforder2', $a_data);
		}
	}

/******************************** 搜索该用户当月的订单 *********************************/

	public function selforder_search() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$sta_id   = trim($this->general->post('sta_id'));
			$keywords = trim($this->general->post('keywords'));
		} else {
			$sta_id   = $this->router->get(1);
			$keywords = urldecode($this->router->get(2));
		}
		// 获取一条统计信息
		$a_statistic = $this->statistic_model->get_statistic_one($sta_id);
		// 用户当月订单的id数组集合
		$user_selforder = explode(',', $a_statistic['user_selforder']);
		$a_data = $this->statistic_model->get_orderself_search($user_selforder, $keywords);
		$a_data['sta_id'] = $sta_id;
		// 用户的基本信息
		$a_data['user'] = $this->statistic_model->get_user_one($a_statistic['user_id']);
		$a_data['statistic'] = $a_statistic;
		$a_data['keywords'] = $keywords;
		$a_data['type'] = 6;
		$this->view->display('statistic_selforder2', $a_data);
	}

/****************************** 查看该用户推荐的人当月的订单 ***************************/

	public function statistic_otherorder() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收需要获取的统计id
			$sta_id = $this->router->get(1);
			// 获取一条统计信息
			$a_statistic = $this->statistic_model->get_statistic_one($sta_id);
			// 用户当月订单的id数组集合
			$user_otherorder = explode(',', $a_statistic['user_otherorder']);
			$a_data = $this->statistic_model->get_order_self($user_otherorder);
			$a_data['sta_id'] = $sta_id;
			// 用户的基本信息
			$a_data['user'] = $this->statistic_model->get_user_one($a_statistic['user_id']);
			$a_data['statistic'] = $a_statistic;
			$a_data['type'] = 2;
			$this->view->display('statistic_selforder2', $a_data);
		}
	}

/******************************** 搜索该用户推荐的人当月的订单 *********************************/

	public function otherorder_search() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$sta_id   = trim($this->general->post('sta_id'));
			$keywords = trim($this->general->post('keywords'));
		} else {
			$sta_id   = $this->router->get(1);
			$keywords = urldecode($this->router->get(2));
		}
		// 获取一条统计信息
		$a_statistic = $this->statistic_model->get_statistic_one($sta_id);
		// 用户当月订单的id数组集合
		$user_otherorder = explode(',', $a_statistic['user_otherorder']);
		$a_data = $this->statistic_model->get_orderself_search($user_otherorder, $keywords);
		$a_data['sta_id'] = $sta_id;
		// 用户的基本信息
		$a_data['user'] = $this->statistic_model->get_user_one($a_statistic['user_id']);
		$a_data['statistic'] = $a_statistic;
		$a_data['keywords'] = $keywords;
		$a_data['type'] = 7;
		$this->view->display('statistic_selforder2', $a_data);
	}

/********************************** 搜索消费统计数据 ********************************/

	public function statistic_search() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$keywords = trim($this->general->post('keywords'));
		} else {
			$keywords = urldecode($this->router->get(1));
		}
		$a_data = $this->statistic_model->get_statistic_search($keywords);
		$a_all = $this->statistic_model->get_statistic_all();
		// 月份信息
		$new_data = array();
		$i = 0;
		foreach ($a_all as $key => $value) {
			if (!in_array($value['sta_time'], $new_data) && $i<13 ) {
				$new_data[] = $value['sta_time'];
				$i++;
			}
		}
		$a_data['month']    = $new_data;
		$a_data['type']     = 6;
		$a_data['time']     = 9;
		$a_data['keywords'] = $keywords;
		$this->view->display('statistic_showlist2', $a_data);
	}

/***************************************************************************************/

}

?>