<?php
class Notice_model extends TW_Model {
	public function __construct() {
		parent :: __construct();
		$this->load->model('user_model');
		$this->load->model('project_model');
		//$this->load->model('procedure_model');
		//$this->load->model('task_model');
	}
	
	// 动作通知
	public function action($a_param) {
		$a_data = $this->db->get_row('task', ['id_task' => $a_param['id_task']], 'id_task, id_project, id_project_parent, id_task_group, title');
		$a_param['title'] = '任务《' . $a_data['title'] . '》有新动作更新';
		$a_param['remark'] = $this->router->url('task_home', [$a_data['id_task']]);
		//$this->weixin_multiple($a_notifier, $_SESSION['user']['id_user'], $a_data['id_project'], $s_title, $s_content, $s_remark);
		$this->weixin_multiple($a_param, $_SESSION['user']['id_user']);
	}
	
	// 流程通知
	public function procedure($a_param) {
		$a_data = $this->db->get_row('task', ['id_task' => $a_param['id_task']], 'id_task, id_project, id_project_parent, id_task_group, title');
		$a_param['title'] = '任务《' . $a_data['title'] . '》有新流程发布';
		$a_param['remark'] = $this->router->url('task_home', [$a_param['id_task']]);
		//$this->weixin_multiple($a_notifier, $_SESSION['user']['id_user'], $a_data['id_project'], $s_title, $s_content, $s_remark);
		$this->weixin_multiple($a_param, $_SESSION['user']['id_user']);
	}
	
	// 任务通知
	public function task($a_param) {
		$a_param['title'] = '有新的任务：《' . $a_param['title'] . '》';
		$a_param['remark'] = $this->router->url('task_home', [$a_param['id_task']]);
		//$this->weixin_multiple($a_notifier, $_SESSION['user']['id_user'], $a_data['id_project'], $s_title, $s_content, $s_remark);
		$this->weixin_multiple($a_param, $_SESSION['user']['id_user']);
	}
	
	// 邮箱群发
	public function email_multiple() {
		$this->load->library('email');
		$this->email->add_address('3274997607@qq.com');
		//$this->email->send_smtp(标题, 内容, true/false是否以HTML文本发送, 收件人, 发件人，发件人昵称，SMTP帐号，SMTP密码);
	}
	
	// 微信群发
	public function weixin_multiple($a_param, $i_operator) {
		$a_param['notifier'][] = 1;
		$a_param['notifier'] = array_unique($a_param['notifier']);
		$s_username = $this->user_model->get_name($i_operator);
		if ($a_param['id_project'] == -10) {
			$a_project_name['project_name_parent'] = '自定义通知';
			$a_project_name['project_name'] = '';
		} else {
			$a_project_name = $this->project_model->get_names($a_param['id_project']);
		}
		foreach ($a_param['notifier'] as $i_id_user) {
			$a_data = [
				'openid' => $this->user_model->get_openid_weixin($i_id_user),
				'template_id' => 'LTMIryi6Pw3txjqvboPdPtF0VxeJGy0aKKRySdoM468',
				'data' => [
					// 标题
					'first' => [
						'value' => $a_param['title'],
						'color' => '#FFA500'
					],
					// 提交人
					'keyword1' => [
						'value' => $s_username,
						'color' => '#63B8FF'
					],
					// 提交项目
					'keyword2' => [
						'value' => isset($a_project_name['project_name_parent']) ? $a_project_name['project_name_parent'] : $a_project_name['project_name'],
						'color' => '#0000EE'
					],
					// 项目分支
					'keyword3' => [
						'value' => $a_project_name['project_name'],
						'color' => '#0000EE'
					],
					// 提交信息
					'keyword4' => [
						'value' => $a_param['content'],
						'color' => '#008B00'
					],
					'remark' => [
						'value' => $a_param['remark'],
						'color' => '#030303'
					],
				]
			];
			$this->load->library('wx_template');
			$a_result = $this->wx_template->send($a_data);
			if ($a_result['errcode'] == 0) {
				$this->log($a_param, $i_id_user);
			}
		}
	}

	public function log($a_param, $i_id_receiver) {
		$a_data = [
			'id_project' => ($a_param['id_project'] < 1) ? 0 : $a_param['id_project'],
			'id_project_parent' => $a_param['id_project_parent'],
			'id_task_group' => intval($a_param['id_task_group']),
			'id_task' => intval($a_param['id_task']),
			'id_procedure' => intval($a_param['id_procedure']),
			'id_action' => intval($a_param['id_action']),
			'id_user' => $a_param['id_user'],
			'id_receiver' => $i_id_receiver,
			'type' => 10,
			'content' => $a_param['content'],
			'link' => $a_param['remark'],
			'state' => 30,
			'time_create' => $_SERVER['REQUEST_TIME']
		];
		
		$this->db->insert('notice', $a_data);
	}
	
	/**
	 * $i_id_user 当前用户id
	 * $i_page 当前页码
	 * $s_type SENT表示发送的通知, RECEIVE表示接收到的通知
	 * $i_rows 表示每页显示的行数
	 */
	public function get_page($i_id_user, $i_page, $s_type, $i_rows = 20) {
		if (empty($i_page)) {
			$i_page = 1;
		}
		$a_where = [];
		if ($s_type == 'SENT') {
			$a_where = ['id_user' => $i_id_user];
		} else {
			$a_where = ['id_receiver' => $i_id_user];
		}
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数，以产品为例
		$i_total = $this->db->get_total('notice', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_rows);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		$a_data['notice'] = $this->db->get('notice', $a_where, '', ['state' => 'DESC', 'time_create' => 'ASC']);
		$a_data['page'] = $this->pages->link_style_one($this->router->url('notice_' . strtolower($s_type), [''], false, false));
		return $a_data;
	}
	
	public function update_state($i_id_notice) {
		$a_data = $this->db->get_row('notice', ['id_notice' => $i_id_notice], 'state');
		if ($a_data['state'] == 30) {
			$a_set['state'] = 10;
		} else if ($a_data['state'] == 10) {
			$a_set['state'] = 30;
		}
		if ($this->db->update('notice', $a_set, ['id_notice' => $i_id_notice])) {
			return $a_set['state'];
		}
		return $a_data['state'];
	}
}
?>