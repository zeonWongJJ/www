<?php

class Shopman_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('shopman_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 店主列表 *************************************/

	public function shopman_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// type为1代表全部状态 为2代表已通过 3代表申请中 4代表已拒绝 5代表已搁置
			$type = $this->router->get(1);
			if ($type == 1 || empty($type)) {
				$a_data = $this->shopman_model->get_shopman_all();
				$a_data['type'] = 1;
			} else if ($type == 2) {
				$a_data = $this->shopman_model->get_shopman_yes();
				$a_data['type'] = 2;
			} else if ($type == 3) {
				$a_data = $this->shopman_model->get_shopman_applylist();
				$a_data['type'] = 3;
			} else if ($type == 4) {
				$a_data = $this->shopman_model->get_shopman_refuselist();
				$a_data['type'] = 4;
			} else if ($type == 5) {
				$a_data = $this->shopman_model->get_shopman_shelvelist();
				$a_data['type'] = 5;
			}
			$this->view->display('shopman_showlist2', $a_data);
		}
	}

/************************************* 状态开关 *************************************/

	public function shopman_switch() {
		//接收店主id
		$user_id =$this->general->post('user_id');
		//取出原来的状态
		$a_data = $this->shopman_model->get_shopman_one($user_id);
		if ($a_data['shopman_state']==0) {
			$a_update_data = [
				'shopman_state' => 1,
			];
		} else {
			$a_update_data = [
				'shopman_state' => 0,
			];
		}
		$a_update_where = [
			'user_id' => $user_id
		];
		$i_result = $this->shopman_model->update_user($a_update_where, $a_update_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'设置成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'设置失败'));
		}
	}

/************************************* 删除店主 *************************************/

	public function shopman_delete() {
		// type值为1代表单个删除 为2代表批量删除
		$type = $this->general->post('type');
		if ($type==1) {
			$user_id = $this->general->post('user_id');
			$i_result = $this->shopman_model->delete_shopman_one($user_id);
			if ($i_result) {
				echo json_encode(array('code'=>200,'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400,'msg'=>'删除失败'));
			}
		} else {
			$user_ids = $this->general->post('user_ids');
			$i_result = $this->shopman_model->delete_shopman_mony($user_ids);
			if ($i_result) {
				echo json_encode(array('code'=>200,'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400,'msg'=>'删除失败'));
			}
		}
	}

/************************************* 搜索店主 *************************************/

	public function shopman_search() {
		// $searchtype值为1代表查询店主，值为2代表查询推荐人, 值为3代表查询订单
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$searchtype = $this->general->post('searchtype');
			$keywords = $this->general->post('keywords');
		} else {
			$searchtype = $this->router->get(2);
			$keywords   = $this->router->get(3);
			// url解码
			$keywords  = urldecode($keywords);
		}
		if ($searchtype == 1) {
			$a_data = $this->shopman_model->get_shopman_search($keywords);
			$a_data['type'] = 6; // 类型为6代表搜索
			$a_data['keywords'] = $keywords;
			$a_data['searchtype'] = $searchtype;
			$this->view->display('shopman_showlist2', $a_data);
		} else if ($searchtype == 2) {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$user_id = $this->general->post('user_id');
			} else {
				$user_id = $this->router->get(1);
			}
			$a_data = $this->shopman_model->get_referee_search($keywords, $user_id);
			$a_data['user_id'] = $user_id;
			$a_data['keywords'] = $keywords;
			$a_data['type'] = 6;
			$a_data['searchtype'] = $searchtype;
			// 获取一条移动店主信息
			$a_shopman = $this->shopman_model->get_shopman_one($user_id);
			$a_data['user_name'] = $a_shopman['user_name'];
			$this->view->display('shopman_referee2', $a_data);
		} else if ($searchtype == 3) {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$user_id = $this->general->post('user_id');
			} else {
				$user_id = $this->router->get(1);
			}
			$a_data = $this->shopman_model->get_order_search($keywords, $user_id);
			$a_data['user_id'] = $user_id;
			$a_data['keywords'] = $keywords;
			$a_data['type'] = 6;
			$a_data['searchtype'] = $searchtype;
			// 获取一条移动店主信息
			$a_shopman = $this->shopman_model->get_shopman_one($user_id);
			$a_data['user_name'] = $a_shopman['user_name'];
			$a_data['type'] = 6; // 7代表正常请求 6代表搜索
			$this->view->display('shopman_order2', $a_data);
		}
	}

/************************************* 店主详情 *************************************/

	public function shopman_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要查看的店主id
			$user_id = $this->router->get(1);
			//获取部分推荐人
			$a_data['referee'] = $this->shopman_model->get_part_referee($user_id);
			//获取部分推荐人下的订单
			$a_data['order'] = $this->shopman_model->get_part_order($user_id);
			$a_data['user_id'] = $user_id;
			$this->view->display('shopman_detail', $a_data);
		}
	}

/*********************************** 查看所有订单 ***********************************/

	public function shopman_order() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收参数 获取要查看的店主id
			$user_id = $this->router->get(1);
			$a_data = $this->shopman_model->get_all_order($user_id);
			$a_data['user_id'] = $user_id;
			// 获取一条移动店主信息
			$a_shopman = $this->shopman_model->get_shopman_one($user_id);
			$a_data['user_name'] = $a_shopman['user_name'];
			$a_data['type'] = 7; // 7代表正常请求 6代表搜索
			$this->view->display('shopman_order2', $a_data);
		}
	}

/********************************** 查看所有推荐的人 **********************************/

	public function shopman_referee() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收参数 获取要查看的店主id
			$user_id = $this->router->get(1);
			$a_data = $this->shopman_model->get_all_referee($user_id);
			$a_data['user_id'] = $user_id;
			// 获取一条移动店主信息
			$a_shopman = $this->shopman_model->get_shopman_one($user_id);
			$a_data['user_name'] = $a_shopman['user_name'];
			$a_data['type'] = 7; // 7代表正常请求 6代表搜索
			$this->view->display('shopman_referee2', $a_data);
		}
	}

/************************************* 申请列表 *************************************/

	public function shopman_applylist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->shopman_model->get_shopman_applylist();
			$this->view->display('shopman_applylist', $a_data);
		}
	}

/*********************************** 接受店主申请 ***********************************/

	public function shopman_accept() {
		//接收参数
		$user_id = $this->general->post('user_id');
		$a_where = [
			'user_id' => $user_id
		];
		$a_data = [
			'is_shopman'    => 1,
			'shopman_state' => 1,
		];
		$i_result = $this->shopman_model->update_user($a_where, $a_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'已成功接受申请'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'接受申请失败'));
		}
	}

/*********************************** 拒绝店主申请 ***********************************/

	public function shopman_refuse() {
		//接收参数
		$user_id = $this->general->post('user_id');
		$a_where = [
			'user_id' => $user_id
		];
		$a_data = [
			'is_shopman'    => 3,
			'shopman_state' => 1,
		];
		$i_result = $this->shopman_model->update_user($a_where, $a_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'已成功拒绝申请'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'拒绝申请失败'));
		}
	}

/*********************************** 搁置店主申请 ***********************************/

	public function shopman_shelve() {
		//接收参数
		$user_id = $this->general->post('user_id');
		$a_where = [
			'user_id' => $user_id
		];
		$a_data = [
			'is_shopman'    => 4,
			'shopman_state' => 1,
		];
		$i_result = $this->shopman_model->update_user($a_where, $a_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'已成功搁置申请'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'搁置申请失败'));
		}
	}

/*********************************** 已拒绝的列表 ***********************************/

	public function shopman_refuselist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->shopman_model->get_shopman_refuselist();
			$this->view->display('shopman_refuselist', $a_data);
		}
	}

/*********************************** 已搁置的列表 ***********************************/

	public function shopman_shelvelist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->shopman_model->get_shopman_shelvelist();
			$this->view->display('shopman_shelvelist', $a_data);
		}
	}

/*********************************** 推荐的人的订单 ***********************************/

	public function shopman_referee_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要查看的推荐人id
			$user_id = $this->router->get(1);
			$a_data = $this->shopman_model->get_referee_order($user_id);
			$a_data['user_id'] = $user_id;
			// 获取一条移动店主信息
			$a_shopman = $this->shopman_model->get_shopman_one($user_id);
			$a_data['user_name'] = $a_shopman['user_name'];
			$this->view->display('shopman_detail2', $a_data);
		}
	}

/************************************************************************************/

}

?>