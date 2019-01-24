<?php
class Task_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
		$this->load->model('task_group_model');
		$this->load->model('task_model');
		$this->load->model('procedure_model');
		$this->load->model('project_model');
	}
	
	// 添加新任务
	public function add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_post = $this->general->post();
			$a_post['type'] = 10;
			$a_result = $this->task_model->add($a_post);
			if ($a_result['state_code'] > 10000) {
				$this->error->show_error($a_result['msg']);
			} else {
				$this->error->location($this->router->url('task_list', [$a_post['group']]));
			}
		} else {
			$a_data['id_group'] = $this->router->get(1) ? $this->router->get(1) : 0;
			$a_data['project'] = $this->project_model->get_data();
			$a_data['project_relat'] = $this->project_model->get_names($_SESSION['project']['curr_project']);
			$a_data['breadcrumb'] = $this->task_model->breadcrumb($a_data['id_group'], $_SESSION['project']['curr_project'], '', ['发起新任务' => '']);
			$a_data['title'] = '发起新任务';
			$a_data['group'] = $this->task_group_model->get_group($_SESSION['project']['curr_project']);
			$a_data['task'] = $this->task_model->get_data('ALL', $a_data['id_group']);
			$this->view->display('task_add', $a_data);
		}
	}
	
	// 添加新问题
	public function question_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_post = $this->general->post();
			$a_post['type'] = 50;
			$a_result = $this->task_model->add($a_post);
			if ($a_result['state_code'] > 10000) {
				$this->error->show_error($a_result['msg']);
			} else {
				$this->error->location($this->router->url('task_group_list', [$_SESSION['project']['curr_project']]));
			}
		} else {
			$a_data['id_group'] = $this->router->get(1);
			$a_data['project'] = $this->project_model->get_data();
			$a_data['project_relat'] = $this->project_model->get_names($_SESSION['project']['curr_project']);
			$a_data['breadcrumb'] = $this->task_model->breadcrumb($a_data['id_group'], $_SESSION['project']['curr_project'], '', ['提交问题' => '']);
			$a_data['title'] = '发起新问题';
			$a_data['group'] = $this->task_group_model->get_group($_SESSION['project']['curr_project']);
			$a_data['task'] = $this->task_model->get_data('ALL', $a_data['id_group']);
			$this->view->display('task_add', $a_data);
		}
	}
	
	// 列表
	public function list() {
		$i_group = intval($this->router->get(1));
		$a_data['title'] = $this->task_group_model->get_name($i_group);
		$a_data['breadcrumb'] = $this->task_model->breadcrumb($i_group, $_SESSION['project']['curr_project'], '', ['任务列表' => '']);
		$a_data['task'] = $this->task_model->get_group($i_group, true);
		if ( isset($a_data['task'][0][0]['id_project']) && ! empty($a_data['task'][0][0]['id_project']) ) {
			$_SESSION['project']['curr_project'] = $a_data['task'][0][0]['id_project'];
		} else {
			$a_data['group'] = $this->task_group_model->get_row($i_group);
			$_SESSION['project']['curr_project'] = $a_data['group']['id_project'];
		}
		$this->view->display('task_list', $a_data);
	}
	
	// 详情
	public function detail() {
		$i_task = intval($this->router->get(1));
		$a_data['task'] = $this->task_model->get_row($i_task);
		$_SESSION['project']['curr_project'] = $a_data['task']['id_project'];
		$a_data['breadcrumb'] = $this->task_model->breadcrumb($a_data['task']['id_task_group'], $_SESSION['project']['curr_project'], '', ['流程列表' => '']);
		$a_data['procedure'] = $this->procedure_model->get_list($i_task);
		$this->view->display('task_detail', $a_data);
	}
	
	// 任务主页
	public function home() {
		$i_task = intval($this->router->get(1));
		$a_data['task'] = $this->task_model->get_row($i_task);
		$_SESSION['project']['curr_project'] = $a_data['task']['id_project'];
		$a_data['breadcrumb'] = $this->task_model->breadcrumb($a_data['task']['id_task_group'], $_SESSION['project']['curr_project'], '', ['流程列表' => '']);
		$a_data['procedure'] = $this->procedure_model->get_list($i_task);
		$this->view->display('task_detail', $a_data);
	}
	
	public function publish_not() {
		$i_page = $this->router->get(1);
		$a_data['task'] = $this->task_model->get_my($i_page, 'PUBLISH_NOT');
		$this->view->display('task_my', $a_data);
	}
	
	public function publish_finsh() {
		$i_page = $this->router->get(1);
		$a_data['task'] = $this->task_model->get_my($i_page, 'PUBLISH_FINSH');
		$this->view->display('task_my', $a_data);
	}
	
	public function partake_not() {
		$i_page = $this->router->get(1);
		$a_data['task'] = $this->task_model->get_my($i_page, 'PARTAKE_NOT');
		$this->view->display('task_my', $a_data);
	}
	
	public function partake_finsh() {
		$i_page = $this->router->get(1);
		$a_data['task'] = $this->task_model->get_my($i_page, 'PARTAKE_FINSH');
		$this->view->display('task_my', $a_data);
	}
	
	public function task_wait() {
		$i_page = $this->router->get(1);
		$a_data['task'] = $this->task_model->get_my($i_page, 'TASK_WAIT');
		$this->view->display('task_my', $a_data);
	}
	
	public function task_all() {
		$i_page = $this->router->get(1);
		$a_data['task'] = $this->task_model->get_my($i_page, 'ALL');
		$this->view->display('task_my', $a_data);
	}
}
?>