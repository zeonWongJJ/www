<?php
class Task_group_model extends TW_Model {
	public function __construct() {
		parent :: __construct();
		$this->load->model('project_model');
		//$this->load->model('total_task_group_model');
	}
	
	// 添加
	public function add($a_param) {
		if (empty($a_param['name'])) {
			return ['state_code' => '10002', 'msg' => '任务组名称不能为空！'];
		}
		$a_data = [
			'id_project_parent' => intval($a_param['project_parent']),
			'id_project' => intval($a_param['project']),
			'id_user' => $_SESSION['user']['id_user'],
			'name' => trim($a_param['name']),
			'sort_group' => intval($a_param['sort']),
			'task_ratio_finsh' => 100,
			'time_create' => $_SERVER['REQUEST_TIME']
		];
		if (empty($a_data['id_project_parent']) || empty($a_data['id_project'])) {
			return ['state_code' => '10001', 'msg' => '没有选择项目！'];
		}
		if ($this->project_model->is_top($a_data['id_project'])) {
			return ['state_code' => '10004', 'msg' => '不能选择顶级项目！'];
		}
		
		if ($i_id_group = $this->db->insert('task_group', $a_data)) {
			return ['state_code' => '10000', 'msg' => '成功创建一个新任务组！'];
		}
		return ['state_code' => '10003', 'msg' => '创建新任务组失败！'];
	}
	
	// 获取数据
	public function get_data($i_id_group) {
		return $this->db->get('task_group', ['id_task_group' => $i_id_group, 'state' => 1]);
	}
	
	// 获取统计
	public function get_total($i_id_project) {
		$s_project = $this->project_model->get_sub_str($i_id_project);
		
		$this->db->where_in('id_project', [$s_project]);
		return $this->db->get_total('task_group');
	}
	
	// 获取分页数据
	public function get_page($i_id_project, $i_page, $i_prow = 20) {
		if (empty($i_page)) {
			$i_page = 1;
		}
		$a_where = '';
		if ($i_id_project) {
			$a_where = ['id_project' => $i_id_project];
		}
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数，以产品为例
		$i_total = $this->db->get_total('task_group', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		return $this->db->get('task_group', $a_where, '', ['id_project' => 'ASC']);
	}
	
	// 获取分页数据
	public function get_group($i_id_project) {
		return $this->db->get('task_group', ['id_project' => $i_id_project, 'state' => 1]);
	}
	
	// 获取数据
	public function get_row($i_id_group) {
		return $this->db->get_row('task_group', ['id_task_group' => $i_id_group, 'state' => 1]);
	}
	
	// 获取名称
	public function get_name($i_id_group) {
		$a_data = $this->db->get_row('task_group', ['id_task_group' => $i_id_group], 'name');
		if (isset($a_data['name'])) {
			return $a_data['name'];
		}
		return '';
	}
	
	// 面包屑
	public function breadcrumb($i_id_project = '', $a_pre = [], $a_post = []) {
		return $this->project_model->breadcrumb($i_id_project, $a_pre, $a_post);
	}
}
?>