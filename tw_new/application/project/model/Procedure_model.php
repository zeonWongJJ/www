<?php
class Procedure_model extends TW_Model {
	public function __construct() {
		parent :: __construct();
		$this->load->model('user_model');
		$this->load->model('total_model');
		$this->load->model('notice_model');
		$this->load->model('task_model');
	}
	
	// 添加
	public function add($a_param) {
		$a_data = [
			'id_user' => $_SESSION['user']['id_user'],
			'id_project' => intval($a_param['project']),
			'id_project_parent' => intval($a_param['project_parent']),
			'id_task_group' => intval($a_param['task_group']),
			'id_task' => intval($a_param['task']),
			'content' => trim($a_param['content']),
			'plan_hour' => is_numeric($a_param['hour']) ? $a_param['hour'] : 0,
			'executor' => intval($a_param['executor']),
			'notifier' => $this->user_model->user_id_string($a_param['notifier']),
			'time_create' => $_SERVER['REQUEST_TIME']
		];
		if (empty($a_data['id_task']) || empty($a_data['id_project']) || empty($a_data['id_project_parent']) || empty($a_data['id_task_group'])) {
			return ['state_code' => '10001', 'msg' => '非法操作！'];
		}
		if (empty($a_data['content'])) {
			return ['state_code' => '10002', 'msg' => '流程描述内容不能为空！'];
		} else {
			$a_data['content'] = $this->general->json_encode(['content' => $a_data['content']]);
		}
		if (empty($a_data['plan_hour'])) {
			return ['state_code' => '10003', 'msg' => '计划时间不能为空！'];
		}
		$a_data['state'] = $a_data['executor'] ? 10 : 0;
		
		// 查看系统默认流程是否存在，存在即用更新覆盖
		$a_default = $this->db->get_row('procedure', ['id_task' => $a_data['id_task'], 'state' => 60], 'id_procedure');
		$m_result = false;
		$a_notice_data = $a_data;
		if ($a_default['id_procedure']) {
			$a_notice_data['id_procedure'] = $a_default['id_procedure'];
			$m_result = $this->db->update('procedure', $a_data, ['id_procedure' => $a_default['id_procedure']]);
		} else {
			$m_result = $this->db->insert('procedure', $a_data);
			$a_notice_data['id_procedure'] = $m_result;
		}
		if ($m_result) {
			$this->task_model->executor_update($a_data['id_task'], $a_data['executor']);
			//$this->total_model->procedure_create($a_data['id_task'], $_SESSION['project']['curr_project'], $a_data['plan_hour']);
			$this->task_model->state_update($a_data['id_task'], 10);
			$this->total_model->total($a_data['id_task'], $a_data['id_task_group'], $a_data['id_project'], $a_data['id_project_parent']);
			
			$a_notice_data['notifier'] = $a_param['notifier'];
			$a_notice_data['content'] = $a_param['content'];
			$this->notice_model->procedure($a_notice_data);
			//$this->notice_model->procedure($a_param['notifier'], $a_data['id_task'], $a_param['content']);
			
			return ['state_code' => '10000', 'msg' => '添加新流程成功！'];
		}
		return ['state_code' => '10004', 'msg' => '添加新流程失败！'];
	}
	
	// 流程列表
	public function get_list($i_task) {
		$a_data = $this->db->get('procedure', ['id_task' => $i_task, 'state <' => 60], '', ['state' => 'ASC', 'id_procedure' => 'DESC']);
		return $a_data;
	}
	
	// 获取任务id
	public function get_id_task($i_procedure) {
		$a_data = $this->db->get_row('procedure', ['id_procedure' => $i_procedure], 'id_task');
		return $a_data['id_task'];
	}
	
	// 获取任务id
	public function get_total_task($i_task) {
		return $this->db->get_total('procedure', ['id_task' => $i_task]);
	}
	
	// 接下流程
	public function receive($i_procedure, $i_user) {
		$a_data = [
			'executor' => $i_user
		];
		$a_where = [
			'id_procedure' => $i_procedure
		];
		return $this->db->update('procedure', $a_data, $a_where);
	}
	
	// 流程状态变化
	public function state_update($i_procedure, $i_state, $i_user = 0) {
		$a_where = [
			'id_procedure' => $i_procedure
		];
		switch ($i_state) {
			case 10:
				$a_data = [
					'state' => 10
				];
				if ( ! empty($i_user) ) {
					$a_data['executor'] = $i_user;
				}
				break;
			case 20:
				$a_data = [
					'state' => 20
				];
				break;
			default:
				return false;
		}
		return $this->db->update('procedure', $a_data, $a_where);
	}
}
?>