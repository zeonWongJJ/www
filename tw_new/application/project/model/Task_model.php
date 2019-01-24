<?php
class Task_model extends TW_Model {
	public function __construct() {
		parent :: __construct();
		$this->load->model('user_model');
		$this->load->model('project_model');
		$this->load->model('task_group_model');
		$this->load->model('total_model');
	}
	
	// 添加任务
	public function add($a_param) {
		$a_data = [
			'id_classify' => intval($a_param['classify']),
			'id_task_group' => intval($a_param['group']),
			'id_task_extend' => intval($a_param['extend']) ? intval($a_param['extend']) : 0,
			'type' => isset($a_param['type']) ? intval($a_param['type']) : 0,
			'title' => trim($a_param['title']),
			'desc' => $this->general->json_encode(['desc' => $a_param['desc']]),
			'priority' => $a_param['score'],
			'id_user' => $_SESSION['user']['id_user'],
			//'executor' => $this->user_model->user_id_string($a_param['executor']),
			'notifier' => $this->user_model->user_id_string($a_param['notifier']),
			'time_start' => strtotime($a_param['time_start']),
			'time_end' => strtotime($a_param['time_end']),
			'time_create' => $_SERVER['REQUEST_TIME'],
			// (已用默认流程取代)默认创建新任务，预设10个小时
			'hour_plan' => 0,
			'state' => count($a_param['executor']) ? 10 : 0,
			'sort' => $a_param['sort']
		];
		if (empty($a_data['id_task_group'])) {
			return ['state_code' => '10001', 'msg' => '任务组必选！'];
		}
		if (empty($a_data['title'])) {
			return ['state_code' => '10002', 'msg' => '标题必填！'];
		}
		/*if (empty($a_data['hour_plan'])) {
			return ['state_code' => '10002', 'msg' => '计划用时必填！'];
		}*/
		$a_group = $this->task_group_model->get_row($a_data['id_task_group']);
		if (empty($a_group['id_project']) || empty($a_group['id_project_parent'])) {
			return ['state_code' => '10003', 'msg' => '非法操作！'];
		} else {
			$a_data['id_project'] = $a_group['id_project'];
			$a_data['id_project_parent'] = $a_group['id_project_parent'];
		}
		if ($i_id_task = $this->db->insert('task', $a_data)) {
			$this->add_default($a_group['id_project_parent'], $a_group['id_project'], $a_data['id_task_group'], $i_id_task);
			//$this->total_model->task_create($i_id_task, $a_data['id_task_group'], $a_group['id_project'], $a_group['id_project_parent'], $a_data['hour_plan']);
			$this->total_model->total($i_id_task, $a_data['id_task_group'], $a_group['id_project'], $a_group['id_project_parent']);
			
			$a_notice_data = $a_data;
			$a_notice_data['id_task'] = $i_id_task;
			$a_notice_data['notifier'] = $a_param['notifier'];
			$a_notice_data['content'] = $a_param['desc'];
			$this->notice_model->procedure($a_notice_data);
			//$this->notice_model->task($a_param['notifier'], $i_id_task, $a_data['title'], $a_param['desc']);
			
			return ['state_code' => '10000', 'msg' => '发布成功！'];
		}
		return ['state_code' => '10004', 'msg' => '发布失败！'];
	}
	
	// 获取任务
	public function get_data($m_id_task = 'ALL', $i_id_group = '') {
		if ($m_id_task == 'ALL') {
			$a_where = '';
		} else {
			$a_where = ['id_task' => $m_id_task];
		}
		if ($i_id_group) {
			$a_where = ['id_task_group' => $i_id_group];
		}
		return $this->db->get('task', $a_where);
	}
	
	// 获取任务
	public function get_row($i_id_task) {
		return $this->db->get_row('task', ['id_task' => $i_id_task]);
	}
	
	// 获取同一任务组下的任务，第二个参数是否按前置任务进行分组
	public function get_group($i_id_group, $b_group = false) {
		$where = ['id_task_group' => $i_id_group];
		$a_data = $this->db->get('task', $where);
		if ($b_group) {
			$a_data = $this->grouping($a_data);
		}
		return $a_data;
	}
	
	// 获取同一任务组下的问题，第二个参数是否按前置任务进行分组
	public function get_question($i_id_group, $b_group = false) {
		$where = [
			'id_task_group' => $i_id_group,
			'type' => 50,
			//'state <' => 20
		];
		$a_data = $this->db->get('task', $where);
		if ($b_group) {
			$a_data = $this->grouping($a_data);
		}
		return $a_data;
	}
	
	// 按前置任务进行分组
	public function grouping($a_param) {
		$a_data = [];
		foreach ($a_param as $a_p) {
			$a_data[$a_p['id_task_extend']][] = $a_p;
		}
		return $a_data;
	}
	
	// 获取任务标题
	public function get_name($i_id_task) {
		return $this->get_title($i_id_task);
	}
	
	// 获取任务标题
	public function get_title($i_id_task) {
		$a_data = $this->db->get_row('task', ['id_task' => $i_id_task], 'title');
		return $a_data['title'];
	}
	
	// 获取项目组id
	public function get_group_id($i_id_task) {
		$a_data = $this->db->get_row('task', ['id_task' => $i_id_task], 'id_task_group');
		return $a_data['id_task_group'];
	}
	
	// 面包屑
	public function breadcrumb($i_id_group, $i_id_project, $a_pre = [], $a_post = []) {
		$a_data = $this->project_model->breadcrumb($i_id_project, $a_pre);
		if ($i_id_group) {
			$a_data[$this->task_group_model->get_name($i_id_group)] = $this->router->url('task_list', [$i_id_group]);
		}
		if (is_array($a_post)) {
			foreach ($a_post as $s_key => $s_val) {
				$a_data[$s_key] = $s_val;
			}
		}
		return $a_data;
	}
	
	// 流程状态变化
	public function state_update($i_task, $i_state) {
		if ($i_state == 20) {
			if ($this->db->get_total('procedure', ['id_task' => $i_task, 'state <>' => 20])) {
				// 任务下还有流程尚未完成，不能更新任务的状态为完成
				return true;
			}
		}
		$a_where = [
			'id_task' => $i_task
		];

		$a_data = [
			'state' => $i_state
		];

		return $this->db->update('task', $a_data, $a_where);
	}
	
	// 更新负责人字段
	public function executor_update($i_id_task, $i_executor) {
		$a_data = $this->db->get_row('task', ['id_task' => $i_id_task], 'executor');
		if (empty($s_executor)) {
			$s_executor = '';
		}
		$s_executor = str_replace("[{$i_executor}],", '', $a_data['executor']);
		$s_executor .= "[{$i_executor}],";
		return $this->db->update('task', ['executor' => $s_executor], ['id_task' => $i_id_task]);
	}
	
	// 获取分页数据 $s_type = 'ALL/TASK_WAIT/PUBLISH_NOT/PUBLISH_FINSH/PARTAKE_FINSH/PARTAKE_NOT'
	public function get_my($i_page, $s_type = 'PUBLISH_NOT', $i_prow = 20) {
		if (empty($i_page)) {
			$i_page = 1;
		}
		switch ($s_type) {
			case 'PUBLISH_NOT':
				$a_where = [
					'id_user' => $_SESSION['user']['id_user'],
					'state <' => 20
				];
				break;
			case 'PUBLISH_FINSH':
				$a_where = [
					'id_user' => $_SESSION['user']['id_user'],
					'state' => 20
				];
				break;
			case 'PARTAKE_NOT':
				$a_where = [
					'executor LIKE %' => '%[' . $_SESSION['user']['id_user'] . '],%',
					'state <' => 20
				];
				break;
			case 'PARTAKE_FINSH':
				$a_where = [
					'executor LIKE' => '%[' . $_SESSION['user']['id_user'] . '],%',
					'state' => 20
				];
				break;
			case 'TASK_WAIT':
				$a_where = [
					'ratio_finsh <' => 100
				];
				break;
			default:
				$a_where = [];
		}
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数，以产品为例
		$i_total = $this->db->get_total('task', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		return $this->db->get('task', $a_where);
	}
	
	// 生成一个默认流程
	public function add_default($i_id_project_parent, $i_id_project, $i_id_task_group, $i_id_task) {
		$a_data = [
			'id_user' => 0,
			'id_project' => $i_id_project,
			'id_project_parent' => $i_id_project_parent,
			'id_task_group' => $i_id_task_group,
			'id_task' => $i_id_task,
			'content' => '',
			'plan_hour' => 10,
			'executor' => 0,
			'notifier' => '',
			'state' => 60,
			'time_create' => $_SERVER['REQUEST_TIME']
		];
		return $this->db->insert('procedure', $a_data);
	}
}
?>