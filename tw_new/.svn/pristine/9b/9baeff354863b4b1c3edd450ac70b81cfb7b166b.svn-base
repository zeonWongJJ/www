<?php

class Set_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('set_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 设置列表 *************************************/

	public function set_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//获取所有的设置项
			$a_data = $this->set_model->get_set_all();
			$this->view->display('set_showlist2', $a_data);
		}
	}

/************************************* 设置列表 *************************************/

	public function set_update() {
		$type = $this->general->post('type');
		$set_name = $this->general->post('set_name');
		$set_parameter = $this->general->post('set_parameter');
		$a_where = [
			'set_name' => $set_name
		];
		$a_data = [
			'set_parameter' => $set_parameter
		];
		$i_result = $this->set_model->update_set($a_where, $a_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'保存成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'保存失败'));
		}
	}

/***************************************************************************************/

}

?>