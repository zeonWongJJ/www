<?php
class Audit_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('audit_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
	}

	//资质认证
	public function audit() {
		$a_data = $this->db->get_row('qualifi', ['user_id' => $_SESSION['user_id']]);
		if (empty($a_data)) {
			$this->view->display('qualifi');
		} else {
			$this->view->display('qualifi_liste', $a_data);
		}
	}

	//资质申请
	public function qualifi() {
		$i_result = $this->audit_model->qualifi();
	}

	//资质申请修改
	public function qualifi_up() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$i_result = $this->audit_model->qualifi_up();
		} else {			
			$i_id   = $this->router->get(1);
			$a_data = $this->db->get_row('qualifi', ['qua_id' => $i_id]);
			$this->view->display('qualifi_up', $a_data);
		}
	}
}?>