<?php
class Home_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
		$this->load->model('action_model');
		// 模板需要用到的模型
		$this->load->model('content_model');
	}
	
	// 主页
	public function index() {
		$a_data['action'] = $this->action_model->get_new();
		$this->view->display('index', $a_data);
		//$this->error->location($this->router->url('project_list'));
	}
	
	// 清空所有表
	public function clear() {return;
		$a_filter = ['pro_user'];//, 'pro_project'
		$a_tables = $this->db->query('show tables');
		foreach ($a_tables as $a_table) {
			if (in_array($a_table[0], $a_filter)) {
				continue;
			}
			$this->db->query('TRUNCATE TABLE `' . $a_table[0] . '` ');
		}
	}
}
?>