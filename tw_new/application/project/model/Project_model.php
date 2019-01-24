<?php
class Project_model extends TW_Model {
	public function __construct() {
		parent :: __construct();
	}
	
	// 添加
	public function add($a_param) {
		if (empty($a_param['name'])) {
			return ['state_code' => '10001', 'msg' => '项目名称不能为空！'];
		}
		$a_data = [
			'id_parent' => intval($a_param['id_parent']),
			'name' => trim($a_param['name']),
			'sort' => intval($a_param['sort']),
			'time_create' => $_SERVER['REQUEST_TIME']
		];
		if (empty($a_data['id_parent'])) {
			$a_data['id_parent'] = 0;
		}
		if ($i_id_project = $this->db->insert('project', $a_data)) {
			return ['state_code' => '10000', 'msg' => '成功创建一个新项目！'];
		}
		return ['state_code' => '10002', 'msg' => '创建新项目失败！'];
	}
	
	// 获取一条项目
	public function get_row($i_id_project) {
		return $this->db->get_row('project', ['id_project' => $i_id_project]);
	}
	
	// 获取id_parent下的所有项目
	public function get_data($m_id_parent = 'ALL') {
		if ($m_id_parent == 'ALL') {
			$a_where = '';
		} else {
			$a_where = ['id_parent' => $m_id_parent];
		}
		return $this->db->get('project', $a_where);
	}
	
	// 获取id_parent下的所有项目，并且带上统计信息
	public function get_total($m_id_parent = 'ALL') {
		$m_id_parent = strval($m_id_parent);
		if ('ALL' != $m_id_parent) {
			$this->db->where(['id_parent' => $m_id_parent]);
		}
		return $this->db->get('project');
	}
	
	// 判断是否顶级项目
	public function is_top($i_id_project) {
		return $this->db->get_total('project', ['id_project' => $i_id_project, 'id_parent' => 0]);
	}
	
	// 获取子项目
	public function get_sub($i_id_project) {
		return $this->db->get('project', ['id_parent' => $i_id_project]);
	}
	
	// 获取子项目的id组成的字符串
	public function get_sub_str($i_id_project) {
		$a_project_sub = $this->get_sub($i_id_project);
		$s_project = '';
		if (count($a_project_sub)) {
			foreach ($a_project_sub as $a_sub) {
				$s_project .= ',' . $a_sub['id_project'];
			}
			$s_project = ltrim($s_project, ',');
		} else {
			$s_project = $i_id_project;
		}
		return $s_project;
	}
	
	// 获取项目名称，如果是子项目，还会返回父级项目名称
	public function get_names($i_id_project) {
		$a_return = [];
		$a_data = $this->db->get_row('project', ['id_project' => $i_id_project], 'id_project, id_parent, name');
		$a_return['project_id'] = $a_data['id_project'];
		$a_return['project_name'] = $a_data['name'];
		if ($a_data['id_parent']) {
			$a_data = $this->db->get_row('project', ['id_project' => $a_data['id_parent']]);
			$a_return['project_id_parent'] = $a_data['id_project'];
			$a_return['project_name_parent'] = $a_data['name'];
		}
		return $a_return;
	}
	
	// 获取项目名称
	public function get_name($i_id_project) {
		$a_data = $this->db->get_row('project', ['id_project' => $i_id_project], 'name');
		return $a_data['name'];
	}
	
	// 面包屑
	public function breadcrumb($i_id_project = '', $a_pre = [], $a_post = []) {
		$a_return = [];
		if (is_array($a_pre)) {
			foreach ($a_pre as $s_key => $s_val) {
				$a_return[$s_key] = $s_val;
			}
		}
		if ($i_id_project) {
			$a_data = $this->db->get_row('project', ['id_project' => $i_id_project], 'id_parent, name');
			if ($a_data['id_parent']) {
				$a_data_parent = $this->db->get_row('project', ['id_project' => $a_data['id_parent']]);
				$a_return[$a_data_parent['name']] = $this->router->url('project_list', [$a_data_parent['id_project']]);
			}
			$a_return[$a_data['name']] = $this->router->url('task_group_list', [$i_id_project]);
		}
		if (is_array($a_post)) {
			foreach ($a_post as $s_key => $s_val) {
				$a_return[$s_key] = $s_val;
			}
		}
		return $a_return;
	}
}
?>