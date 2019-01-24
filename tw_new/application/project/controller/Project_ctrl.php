<?php
class Project_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
		
		$this->load->model('project_model');
	}
	
	// 列表
	public function list() {
		$i_project = intval($this->router->get(1));
		if (empty($i_project)) {
			$i_project = 0;
		} else {
			$a_data['id_project_parent'] = $i_project;
			//$a_parent = $this->project_model->get_row($i_project);
		}
		$a_data['project'] = $this->project_model->get_total($i_project);
		if ($i_project) {
			foreach ($a_data['project'] as $a_project) {
				if ($a_data['project']['id_project'] == $i_project && empty($a_data['project']['id_parent'])) {
					$_SESSION['project']['curr_project'] = $i_project;
				}
			}
		}
		$a_data['breadcrumb'] = $this->project_model->breadcrumb($i_project, ['项目中心' => $this->router->url('project_list')], ['项目列表' => '']);
		
		$this->view->display('project_list', $a_data);
	}
	
	// 添加
	public function add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_result = $this->project_model->add($this->general->post());
			if ($a_result['state'] == 10000) {
				$this->error->show_error($a_result['msg']);
			} else {
				$this->error->location($this->router->url('project_list'));
			}
		} else {
			$a_data['project'] = $this->project_model->get_data(0);
			$a_data['breadcrumb'] = $this->project_model->breadcrumb('', ['项目中心' => $this->router->url('project_list')], ['创建项目' => '']);
			$a_data['title'] = '创建新项目';
			$this->view->display('project_add', $a_data);
		}
	}
}
?>