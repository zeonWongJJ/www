<?php
defined('BASEPATH') or exit('禁止访问！');
header("Content-Type:text/html;charset=utf8");
class Search_ctrl extends TW_Controller {
	
	public function __construct() {
		parent :: __construct();
		$this->load->model('points_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
	}

	//积分列表
	public function points() {
		$a_data['name']   = $this->db->get_row('user', ['user_id' => $_SESSION['user_id']]);
		$a_data['points'] = $this->db->get('points_log', ['pl_memberid' => $_SESSION['user_id']], '', ['pl_id' => 'desc']);
		$this->view->display('points', $a_data);
	}

	//积分说明
	public function points_point() {
		$this->view->display('points_point');
	}

	//积分明细
	public function points_detail() {
		$id = $this->router->get(1);
		$a_data['log']   = $this->db->get_row('points_log', ['pl_id' => $id]);
		$a_data['goods'] = $this->db->from('order as a')
									->join('order_goods as b', ['a.order_id' => 'b.order_id'])
									->get('', ['a.order_id' => $a_data['log']['order_id']]);
		$a_data['reim'] = $this->db->get('reimburse', ['order_number' => $a_data['log']['order_number']]);
		$this->view->display('points_detail', $a_data);
	}

	//积分脱换金额
	public function points_eum() {
		$this->points_model->points();
	}
}
?>