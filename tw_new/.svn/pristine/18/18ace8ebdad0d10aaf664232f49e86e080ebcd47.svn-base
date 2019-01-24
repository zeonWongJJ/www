<?php

class Office_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('office_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/***************************************** 房型列表 *****************************************/

	public function room_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//获取后台所有的办公室类型
			$a_data = $this->office_model->get_room_all();
			//获取房间设备信息
			foreach ($a_data as $key => $value) {
				$device_ids = $value['device_ids'];
				$device_ids = explode(',', $device_ids);
				$device_data = $this->office_model->get_room_device($device_ids);
				$new_array = $value;
				$new_array['device'] = '';
				foreach ($device_data as $k => $v) {
					$new_array['device']  .= $v['device_name'].'、';
				}
				$new_array['device'] = rtrim($new_array['device']);
				$new_data[] = $new_array;
			}
			$a_data = $new_data;
			$this->view->display('room_showlist2', $a_data);
		}
	}

/***************************************** 添加房型 *****************************************/

	public function office_add() {
		$type = $this->general->post('type');
		if ($type == 1) {
			//接收需要添加的房型id
			$room_id = $this->general->post('room_id');
			//组装数据并插入到数据库
			$a_data = [
				'room_id'      => $room_id,
				'store_id'     => $_SESSION['store_id'],
				'add_time'     => $_SERVER['REQUEST_TIME'],
				'office_state' => 1,
			];
			$i_result = $this->office_model->insert_office($a_data);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'添加成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'添加失败'));
			}
		} else {
			//接收需要添加的房型id数组
			$room_ids = $this->general->post('room_ids');
			for ($i=0; $i<count($room_ids); $i++) {
				//组装数据并插入到数据库
				$a_data = [
					'room_id'      => $room_ids[$i],
					'store_id'     => $_SESSION['store_id'],
					'add_time'     => $_SERVER['REQUEST_TIME'],
					'office_state' => 1,
				];
				$i_result = $this->office_model->insert_office($a_data);
			}
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'添加成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'添加失败'));
			}
		}
	}

/***************************************** 搜索房间 *****************************************/

	public function room_search() {
		$keywords = trim($this->general->post('keywords'));
		if (empty($keywords) || strlen($keywords) > 60) {
			echo json_encode(array('code'=>400, 'msg'=>'关键词长度不合法', 'data'=>''));
			die;
		}
		$a_data = $this->office_model->get_room_search($keywords);
		if (empty($a_data)) {
			echo json_encode(array('code'=>400, 'msg'=>'未搜索到任何内容', 'data'=>''));
		} else {
			//获取房间设备信息
			foreach ($a_data as $key => $value) {
				$device_ids = $value['device_ids'];
				$device_ids = explode(',', $device_ids);
				$device_data = $this->office_model->get_room_device($device_ids);
				$new_array = $value;
				$new_array['device'] = '';
				foreach ($device_data as $k => $v) {
					$new_array['device'] .= $v['device_name'].'、';
				}
				$new_data[] = $new_array;
			}
			echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$new_data));
		}
	}

/*************************************** 办公室列表 *****************************************/

	public function office_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//获取当前门店所有的办公室数据
			$a_data = $this->office_model->get_office_all();
			//获取房间设备信息
			if (!empty($a_data)) {
				foreach ($a_data as $key => $value) {
					$device_ids = $value['device_ids'];
					$device_ids = explode(',', $device_ids);
					$device_data = $this->office_model->get_room_device($device_ids);
					$new_array = $value;
					$new_array['device'] = '';
					foreach ($device_data as $k => $v) {
						$new_array['device'] .= $v['device_name'].'、';
					}
					$new_data[] = $new_array;
				}
				$a_data = $new_data;
			}
			$this->view->display('office_showlist2', $a_data);
		}
	}

/*************************************** 办公室开关 *****************************************/

	public function office_switch() {
		//接收分组id
		$office_id = $this->general->post('office_id');
		$a_data = $this->office_model->get_office_one($office_id);
		$a_where = [
			'office_id' => $office_id
		];
		if ($a_data['office_state']==0) {
			$a_update_data = [
				'office_state' => 1
			];
		} else {
			$a_update_data = [
				'office_state' => 0
			];
		}
		$i_result = $this->office_model->update_office($a_where, $a_update_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'设置成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'设置失败'));
		}
	}

/*************************************** 办公室搜索 *****************************************/

	public function office_search() {
		$keywords = trim($this->general->post('keywords'));
		if (empty($keywords) || strlen($keywords) > 60) {
			echo json_encode(array('code'=>400, 'msg'=>'关键词长度不合法', 'data'=>''));
			die;
		}
		$a_data = $this->office_model->get_office_search($keywords);
		if (empty($a_data)) {
			echo json_encode(array('code'=>400, 'msg'=>'未搜索到任何内容', 'data'=>''));
		} else {
			//获取房间设备信息
			foreach ($a_data as $key => $value) {
				$device_ids = $value['device_ids'];
				$device_ids = explode(',', $device_ids);
				$device_data = $this->office_model->get_room_device($device_ids);
				$new_array = $value;
				$new_array['device'] = '';
				foreach ($device_data as $k => $v) {
					$new_array['device'] .= $v['device_name'].'、';
				}
				$new_data[] = $new_array;
			}
			echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$new_data));
		}
	}

/*************************************** 设置平面图 *****************************************/

	public function office_plan() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要设置平面图的办公室id
			$office_id = $this->router->get(1);
			//获取原来的数据
			$a_data['office'] = $this->office_model->get_office_one($office_id);
			// 获取一条房间信息
			$a_data['room'] = $this->office_model->get_room_one($a_data['office']['room_id']);
			//如果平面图为空则给其默认值
			if (empty($a_data['office']['office_plan'])) {
				$a_data['plan'] = [2,2, 0, 0, 0, 0];
			} else {
				$a_data['plan'] = explode('-', $a_data['office']['office_plan']);
			}
			if (empty($a_data['office']['office_seatname'])) {
				$a_data['seatname'] = [0, 0, 0, 0];
			} else {
				$a_data['seatname'] = explode('-', $a_data['office']['office_seatname']);
			}
			$this->view->display('office_plan2', $a_data);
		}
	}

	public function save_plan() {
		$office_plan = trim($this->general->post('office_plan'));
		$office_seatname = trim($this->general->post('office_seatname'));
		$office_id = $this->general->post('office_id');
		$a_where = [
			'office_id'  => $office_id
		];
		$a_data = [
			'office_plan'     => $office_plan,
			'office_seatname' => $office_seatname,
		];
		$i_result = $this->office_model->update_office($a_where, $a_data);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'保存设置成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'保存设置失败'));
		}
	}

/*************************************** 删除办公室 *****************************************/

	public function office_delete() {
		// type=1代表单个删除 =2代表批量删除
		$type = $this->general->post('type');
		if ($type==1) {
			//接收需要删除的办公室id
			$office_id = $this->general->post('office_id');
			//验证当前办公室是否有人使用 有则阻止删除
			$i_total = $this->office_model->get_seat_occupy($office_id);
			if ($i_total>0) {
				echo json_encode(array('code'=>400, 'msg'=>'当前办公室正在使用中无法删除'));
				die;
			}
			//验证成功则删除办公室
			$i_result = $this->office_model->delete_office_one($office_id);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
			}
		} else {
			//接收需要删除的办公室ids
			$office_ids = $this->general->post('office_ids');
			for ($i=0; $i<count($office_ids); $i++) {
				$i_total = $this->office_model->get_seat_occupy($office_ids[$i]);
				if (!$i_total) {
					$i_result = $this->office_model->delete_office_one($office_ids[$i]);
					if ($i_result) {
						$new_data[] = $office_ids[$i];
					}
				}
			}
			if (!empty($new_data)) {
				echo json_encode(array('code'=>200, 'msg'=>'删除成功', 'data'=>$new_data));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'没有符合删除条件的办公室'));
			}
		}
	}

/************************************* 修改办公室价格 ***************************************/

	function office_updateprice() {
		$office_id = trim($this->general->post('office_id'));
		$new_price = trim($this->general->post('new_price'));
		$a_where = [
			'office_id' => $office_id,
		];
		$a_data = [
			'office_price' => $new_price,
		];
		$i_result = $this->office_model->update_office($a_where, $a_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'修改成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'修改失败'));
		}
	}

/********************************************************************************************/

}

?>