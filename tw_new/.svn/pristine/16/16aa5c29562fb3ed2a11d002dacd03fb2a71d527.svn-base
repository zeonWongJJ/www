<?php
class Task_group_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
		$this->load->model('project_model');
		$this->load->model('task_group_model');
	}
	
	// 列表
	public function list() {
		$_SESSION['project']['curr_project'] = $this->router->get(1) ? $this->router->get(1) : 0;
		$i_page = $this->router->get(2);
		$a_data['group'] = $this->task_group_model->get_page($_SESSION['project']['curr_project'], $i_page);
		$a_data['breadcrumb'] = $this->task_group_model->breadcrumb($_SESSION['project']['curr_project'], '', ['任务组列表' => '']);
		
		$a_data['title'] = '任务组中心';//print_r($a_data['group']);
		$this->view->display('task_group_list', $a_data);
	}
	
	// 添加
	public function add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_result = $this->task_group_model->add($this->general->post());
			if ($a_result['state_code'] == 10000) {
				$this->error->location($this->router->url('task_group_list'));
			} else {
				$this->error->show_error($a_result['msg']);
			}
		} else {
			$a_data['project'] = $this->project_model->get_data(0);
			$a_data['project_relat'] = $this->project_model->get_names($_SESSION['project']['curr_project']);
			$a_data['breadcrumb'] = $this->task_group_model->breadcrumb($_SESSION['project']['curr_project'], '', ['创建任务组' => '']);
			$a_data['title'] = '创建新任务组';
			$this->view->display('task_group_add', $a_data);
		}
	}
	
	// 获取josn数据
	public function get_task_group() {
		$i_id_project = intval($this->general->post('project'));
		if (empty($i_id_project)) {
			echo json_encode(['code' => 0, 'error' => '非法操作！']);
		} else {
			$a_data['data'] = $this->task_group_model->get_group($i_id_project);
			$a_data['code'] = '10000';
			$a_data['error'] = '成功！';
			echo json_encode($a_data);
		}
	}
}
?>