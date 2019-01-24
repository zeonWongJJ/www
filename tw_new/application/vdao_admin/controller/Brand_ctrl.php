<?php

class Brand_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

	public function time_list() {
		$a_order = [
			'time_id' => 'asc'
		];
		$a_data = $this->db->order_by($a_order)->get('time');
		$this->view->display('time_list', $a_data);
	}

	public function time_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_name  = trim($this->general->post('name'));
			$a_start = trim($this->general->post('start'));
			$a_end   = trim($this->general->post('end_tiem'));
			if (empty($a_name) && empty($a_start) && empty($a_end)) {
				$this->error->show_error('信息填写不完善！', 'time_add', 2);
			}
			$a_time  = [
				'time_nema'  => $a_name,
				'start_time' => $a_start,
				'end_tiem'   => $a_end,
			];
			$ster = $this->db->insert('time', $a_time);
			if ($ster) {
				$this->error->show_success('添加成功！', 'time_list', 2);
			} else {
				$this->error->show_error('添加失败！', 'time_list', 2);
			}
		} else {
			$this->view->display('time_add');
		}
	}

	public function time_up() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$i_id    = $this->general->post('id');
			$a_name  = trim($this->general->post('name'));
			$a_start = trim($this->general->post('start'));
			$a_end   = trim($this->general->post('end_tiem'));
			if (empty($a_name) && empty($a_start) && empty($a_end)) {
				$this->error->show_error('信息填写不完善！', 'time_up', 2);
			}
			$a_time  = [
				'time_nema'  => $a_name,
				'start_time' => $a_start,
				'end_tiem'   => $a_end,
			];
			$ster = $this->db->update('time', $a_time, ['time_id' => $i_id]);
			if ($ster) {
				$this->error->show_success('修改成功！', 'time_list', 2);
			} else {
				$this->error->show_error('修改失败！', 'time_list', 2);
			}
		} else {
			$i_id = $this->router->get(1);
			$a_data = $this->db->get_row('time', ['time_id' => $i_id]);
			$this->view->display('time_up', $a_data);
		}
	}

	public function time_dele() {
		$i_id = $this->general->post('id');
		$vart = $this->general->post('vart');
		if ($vart == 1) {
			$i_result = $this->db->delete('time', ['time_id' => $i_id]);
		} else if($vart == 2) {
			$i_result = $this->db->where_in('time_id', $i_id)->delete('time');
		}		
		if ($i_result) {
			echo json_encode(array('code'=>1, 'msg'=>'删除成功'));
			die;
		} else {
			echo json_encode(array('code'=>2, 'msg'=>'删除失败'));
			die;
		}
	}
}
?>