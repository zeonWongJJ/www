<?php

defined('BASEPATH') or exit('禁止访问！');

class Score_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('score_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
	}

/************************************** 用户积分 **************************************/

	public function user_score() {
		$user_id = $_SESSION['user_id'];
		// 获取用户的积分变动
		$a_data['score'] = $this->score_model->get_score_user($user_id, 1);
		// 获取一条用户信息
		$a_data['user'] = $this->score_model->get_user_one($user_id);
		$this->view->display('user_score', $a_data);
	}

/************************************** 积分详情 **************************************/

	public function score_detail() {
		$pl_id = $this->router->get(1);
		$a_data['score'] = $this->score_model->get_score_one($pl_id);
		$this->view->display('score_detail', $a_data);
	}

/************************************** 积分说明 **************************************/

	public function score_explain() {
		$this->view->display('score_explain');
	}

/************************************** 获取更多 **************************************/

	public function user_scoremore() {
		$page = trim($this->general->post('page'));
		$user_id = $_SESSION['user_id'];
		$a_data = $this->score_model->get_score_user($user_id, $page);
		if (!empty($a_data)) {
			foreach ($a_data as $key => $value) {
				$value['pl_time'] = date('Y-m-d H:i:s', $value['pl_time']);
				$new_data[] = $value;
			}
			echo json_encode(array('code'=>200,'msg'=>'获取成功','data'=>$new_data));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'没有更多数据了','data'=>''));
		}
	}

/**************************************************************************************/

}

?>