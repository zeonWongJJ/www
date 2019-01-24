<?php
class Action_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
		//$this->load->model('task_group_model');
		$this->load->model('action_model');
	}
	
	// 添加新任务
	public function add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_post = $this->general->post();
			$a_result = $this->action_model->add($a_post);
			if ($a_result['state_code'] > 10000) {
				$this->error->show_error($a_result['msg'], $this->router->url('task_home', [$a_post['task']]));
			} else {
				$this->error->location();
			}
		}
	}
}
?>