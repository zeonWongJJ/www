<?php
class procedure_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
		$this->load->model('task_group_model');
		$this->load->model('procedure_model');
		//$this->load->model('task_model');
	}
	
	// 添加新任务
	public function add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_post = $this->general->post();
			$a_result = $this->procedure_model->add($a_post);
			if ($a_result['state_code'] > 10000) {
				$this->error->show_error($a_result['msg']);
			} else {
				$this->error->location();
			}
		} else {
			$a_data['breadcrumb'] = [
				'添加新任务' => ''
			];
			$a_data['title'] = '发起新任务';
			$a_data['group'] = $this->task_group_model->get_group($_SESSION['project']['curr_project']);
			//$a_data['task'] = $this->task_model->get_data();
			$this->view->display('task_add', $a_data);
		}
	}
	
	
}
?>