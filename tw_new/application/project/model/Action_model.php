<?php
class Action_model extends TW_Model {
	public function __construct() {
		parent :: __construct();
		$this->load->model('user_model');
		$this->load->model('notice_model');
		$this->load->model('procedure_model');
		$this->load->model('total_model');
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
			'id_procedure' => intval($a_param['procedure']),
			'content' => trim($a_param['content']),
			'notifier' => $this->user_model->user_id_string($a_param['notifier_action']),
			'type' => intval($a_param['type']),
			'time_create' => $_SERVER['REQUEST_TIME']
		];
		if (empty($a_data['id_procedure']) || empty($a_data['id_task']) || empty($a_data['id_project']) || empty($a_data['id_project_parent']) || empty($a_data['id_task_group'])) {
			return ['state_code' => '10001', 'msg' => '非法操作！'];
		}
		if (empty($a_data['content'])) {
			return ['state_code' => '10002', 'msg' => '内容不能为空！'];
		} else {
			$a_data['content'] = $this->general->json_encode(['content' => $a_data['content']]);
		}
		if (empty($a_data['type'])) {
			return ['state_code' => '10003', 'msg' => '必须选择一个动作类型！'];
		}
		// 没有接手的任务，不能完成
		if ($a_data['type'] == 40) {
			if ($this->db->get_total('procedure', ['id_procedure' => $a_data['id_procedure'], 'executor' => 0])) {
				return ['state_code' => '10005', 'msg' => '必须是接手过的任务才能完成！'];
			}
		}
		if ($i_id_action = $this->db->insert('action', $a_data)) {
			switch ($a_data['type']) {
				case 10:
					$this->task_model->executor_update($a_data['id_task'], $a_data['id_user']);
					$this->procedure_model->state_update($a_data['id_procedure'], 10, $a_data['id_user']);
					break;
				case 20:
				case 30:
					$this->procedure_model->state_update($a_data['id_procedure'], 10);
					//$this->total_model->action_create($a_data['id_procedure']);
					break;
				case 40:
					$this->procedure_model->state_update($a_data['id_procedure'], 20);
					$this->task_model->state_update($a_data['id_task'], 20);
					// 统计运算
					//$this->total_model->procedure_finsh($a_data['id_procedure']);
					break;
			}
			$this->total_model->total($a_data['id_task'], $a_data['id_task_group'], $a_data['id_project'], $a_data['id_project_parent']);
			
			$a_notice_data = $a_data;
			$a_notice_data['id_action'] = $i_id_action;
			$a_notice_data['notifier'] = $a_param['notifier_action'];
			$a_notice_data['content'] = $a_param['content'];
			$this->notice_model->action($a_notice_data);
			
			return ['state_code' => '10000', 'msg' => '添加动作成功！'];
		}
		return ['state_code' => '10004', 'msg' => '添加动作失败！'];
	}
	
	// 获取流程下的所有动作
	public function get_procedure($i_procedure) {
		$a_data = $this->db->get('action', ['id_procedure' => $i_procedure]);
		return $a_data;
	}
	
	// 获取最新的动作
	public function get_new($i_num = 50) {
		return $this->db->get('action', '', '', ['id_action' => 'DESC'], 0, $i_num);
	}
}
?>