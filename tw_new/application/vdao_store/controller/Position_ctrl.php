<?php

class Position_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('position_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/***************************************** 定位信息 *****************************************/

	public function store_position() {
		//获取门店的定位信息
		$a_data = $this->position_model->get_store_one($_SESSION['store_id']);
		$store_position = $a_data['store_position'];
		if (empty($store_position)) {
			$store_position = array(116.397428, 39.90923);
		} else {
			$store_position = explode(',', $store_position);
		}
		$this->view->display('store_position', $store_position);
	}

/***************************************** 保存定位 *****************************************/

	public function position_update() {
		$position_x = trim($this->general->post('position_x'));
		$position_y = trim($this->general->post('position_y'));
		//将数据合并为字符串
		$store_position = $position_x . ',' . $position_y;
		//组装数据
		$a_where = [
			'store_id' => $_SESSION['store_id'],
		];
		$a_data = [
			'store_position'  => $store_position,
			'store_longitude' => $position_x,
			'store_latitude'  => $position_y,
		];
		//保存数据
		$i_result = $this->position_model->update_position($a_where, $a_data);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'保存成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'保存失败'));
		}
	}

/*************************************** 新定位测试 ****************************************/

	public function position_new() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//获取门店的定位信息
			$a_data = $this->position_model->get_store_one($_SESSION['store_id']);
			$store_position = $a_data['store_position'];
			if (empty($store_position)) {
				// 给默认字符串，如果门店位置信息为空前台将显示当前城市
				$a_data = array(9999, 9999);
			} else {
				$a_data = explode(',', $store_position);
			}
			$this->view->display('position_new', $a_data);
		} else {
			// 此处ajax请求 保存位置信息
			$mylng = trim($this->general->post('mylng'));
			$mylat = trim($this->general->post('mylat'));
			// 拼接字符串
			$store_position = $mylng . ',' . $mylat;
			//组装数据
			$a_where = [
				'store_id' => $_SESSION['store_id'],
			];
			$a_data = [
				'store_position'  => $store_position,
				'store_longitude' => $mylng,
				'store_latitude'  => $mylat,
			];
			//保存数据
			$i_result = $this->position_model->update_position($a_where, $a_data);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'保存成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'保存失败'));
			}
		}
	}

/*******************************************************************************************/


}

?>