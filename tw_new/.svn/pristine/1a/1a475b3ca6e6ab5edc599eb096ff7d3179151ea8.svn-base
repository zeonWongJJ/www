<?php

class Cup_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

	//杯型管理
	public function cup() {
		$a_name = trim($this->general->post('name'));
		$a_data = $this->db->where("`cup_name` LIKE '%$a_name%'")->get('cup');
		$this->view->display('cup', $a_data);
	}

	//杯子添加
	public function cup_add() {
		//接收提交的信息
		$a_name = trim($this->general->post('name'));
		
		$a_data = [
			'cup_name'   => $a_name,			
		];
		$i_result = $this->db->insert('cup', $a_data);
		if ($i_result) {
			echo 55;die;
		}
	}

	//杯子修改
	public function cup_update() {
		//接收提交的信息
		$i_id   = $this->general->post('id');
		$a_name = trim($this->general->post('name'));
		if (empty($a_name)) {
			$a_data = $this->db->get_row('cup', ['cup_id' => $i_id]);
			echo json_encode($a_data);
		} else {	
			$a_data = [
				'cup_name'   => $a_name,				
			];
			$i_result = $this->db->update('cup', $a_data, ['cup_id' => $i_id]);
			if ($i_result) {
				echo 8;
				die;
			}	
		}		
	}

	//杯子删除
	public function cup_del() {		
		$i_id = $this->general->post('id');
		$vart = $this->general->post('vart');
		if ($vart == 1) {
			$i_result = $this->db->delete('cup', ['cup_id' => $i_id]);
		} else if($vart == 2) {
			$i_result = $this->db->where_in('cup_id', $i_id)->delete('cup');
		}		
		if ($i_result) {
			echo 1;die;
		} else {
			echo 2;die;
		}
	}
}
?>