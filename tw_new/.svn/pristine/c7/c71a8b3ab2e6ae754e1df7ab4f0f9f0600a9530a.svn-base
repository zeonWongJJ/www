<?php

defined('BASEPATH') or exit('禁止访问！');

class Join_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('join_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/*************************************** 加盟列表 ****************************************/

	public function join_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收参数
			$type = $this->router->get(1);
			if (empty($type)) {
				$type = 9;
			}
			$keywords = urldecode($this->router->get(2));
			if (empty($keywords)) {
				$keywords = 9;
			}
			$a_data = $this->join_model->get_join_page($type, $keywords);
			$a_data['type'] = $type;
			$a_data['keywords'] = $keywords;
			$this->view->display('join_showlist', $a_data);
		}
	}

/*************************************** 同意申请 ****************************************/

	public function join_agree() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收参数
			$join_id = trim($this->general->post('join_id'));
			$join_agreereason = trim($this->general->post('join_agreereason'));
			// 验证数据
			$a_parameter = [
				'msg'      => '这是提示信息',
				'url'      => 'join_showlist',
				'log'      => false,
				'wait'     => 1,
			];
			// 验证是否为空
			if (empty($join_id) || empty($join_agreereason)) {
				$a_parameter['msg'] = '必填项不能为空';
				$this->error->show_error($a_parameter);
			}
			// 改变申请状态
			$a_where = [
				'join_id' => $join_id
			];
			$a_data = [
				'join_state'       => 3,
				'join_agreereason' => $join_agreereason,
				'join_agreetime'   => $_SERVER['REQUEST_TIME'],
			];
			$i_result = $this->join_model->update_join($a_where, $a_data);
			if ($i_result) {
				$a_parameter['msg'] = '通过申请成功';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '通过申请失败';
				$this->error->show_error($a_parameter);
			}
		}
	}

/*************************************** 驳回申请 ****************************************/

	public function join_refuse() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$join_id = trim($this->general->post('join_id2'));
			$join_refusereason = trim($this->general->post('join_refusereason'));
			// 验证数据
			$a_parameter = [
				'msg'      => '这是提示信息',
				'url'      => 'join_showlist',
				'log'      => false,
				'wait'     => 1,
			];
			// 验证是否为空
			if (empty($join_id) || empty($join_refusereason)) {
				$a_parameter['msg'] = '必填项不能为空';
				$this->error->show_error($a_parameter);
			}
			// 改变申请状态
			$a_where = [
				'join_id' => $join_id
			];
			$a_data = [
				'join_state'        => 5,
				'join_refusereason' => $join_refusereason,
				'join_refusetime'   => $_SERVER['REQUEST_TIME'],
			];
			$i_result = $this->join_model->update_join($a_where, $a_data);
			if ($i_result) {
				$a_parameter['msg'] = '驳回成功';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '驳回失败';
				$this->error->show_error($a_parameter);
			}
		}
	}

/*************************************** 申请信息 ****************************************/

	public function join_info() {
		$join_id = trim($this->general->post('join_id'));
		$a_data = $this->join_model->get_join_one($join_id);
		$a_data['join_time1'] = date('Y-m-d', $a_data['join_time']);
		$a_data['join_time2'] = date('H:i', $a_data['join_time']);
		$a_data['join_address1'] = $a_data['join_province'] . $a_data['join_city'] . $a_data['join_district'] . $a_data['join_address'];
		if ($a_data['join_state'] == 5) {
			$a_data['join_refusetime1'] = date('Y-m-d H:i', $a_data['join_refusetime']);;
		}
		if ($a_data['join_state'] == 3) {
			$a_data['join_agreetime1'] = date('Y-m-d H:i', $a_data['join_agreetime']);;
		}
		echo json_encode(array('code'=>200, 'msg'=>'成功', 'data'=> $a_data));
	}

/*************************************** 搁置申请 ****************************************/

	public function join_shelve() {
		$join_id = trim($this->general->post('join_id'));
		$a_where = [
			'join_id' => $join_id
		];
		$a_data = [
			'join_state' => 4,
		];
		$i_result = $this->join_model->update_join($a_where, $a_data);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'搁置成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'搁置失败'));
		}
	}

/*************************************** 申请详情 ****************************************/

	public function join_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收参数
			$join_id = $this->router->get(1);
			// 获取详情
			$a_data = $this->join_model->get_join_one($join_id);
			$this->view->display('join_detail', $a_data);
		}
	}

/*****************************************************************************************/

}

?>