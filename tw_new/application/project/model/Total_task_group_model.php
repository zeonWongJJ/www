<?php
class Total_task_group_model extends TW_Model {
	public function __construct() {
		parent :: __construct();
	}
	
	// 获取指定项目的统计信息
	public function get_row($i_id_project) {
		
	}
	
	// 添加一条任务组记录
	public function add($i_id_task_group) {
		return $this->db->insert('total_task_group', ['id_task_group' => $i_id_task_group]);
	}
}
?>