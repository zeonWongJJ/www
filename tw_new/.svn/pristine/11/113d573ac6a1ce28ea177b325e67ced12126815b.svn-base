<?php

class User_score_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('user_score_model');
        $this->load->model('is_login_model');
        $this->is_login_model->is_login();
	}

/**********************************************************************************/

	//会员中心->积分记录->我的积分
	public function user_myscore() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//取出用户最近一条的积分变动记录
			$a_present = $this->user_score_model->get_user_score();
			//我的时实积分
			$user_myscore = $a_present['original_value']+$a_present['variation'];
			//我的历史积分[所有类型为加的记录值总和]
			$a_history = $this->user_score_model->get_history_score();
			$user_history = '';
			foreach ($a_history as $k=>$v) {
				$user_history = $user_history+$v['variation'];
			};
			//获取会员总数
			$i_member_total = $this->user_score_model->get_member_total();
			//获取历史积分比我少的会员数
			$i_member_shao = $this->user_score_model->get_member_shao($user_history);
			//我打败了多少找帮手用户
			$user_beat = round($i_member_shao/$i_member_total, 2)*100;
			//积分兑换
			$a_gold_note = $this->user_score_model->get_gold_note();
			$a_data = array('present'=>$user_myscore, 'history'=>$user_history, 'beat'=> $user_beat, 'gold'=>$a_gold_note);
			$this->view->display('integrationss',$a_data);
		}
	}

/**********************************************************************************/

	//会员中心->积分记录->积分明细
	public function user_score_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//查询当前用户的积分明细
			$a_data =  $this->user_score_model->get_score_detail();
			$this->view->display('pointsRecord',$a_data);
		}
	}

/**********************************************************************************/

	//会员中心->积分记录->兑换记录
	public function user_score_exchange() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//查询当前用户的积分兑换明细
			$a_data = $this->user_score_model->get_score_exchange();
			$this->view->display('myscore_exchange',$a_data);
		}
	}


/**************************************** 测试 ****************************************/

	//会员中心-》上拉加载下一页测试
	public function up_page() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->user_score_model->get_page();
			$this->view->display('up_page', $a_data);
		}
	}

	public function get_more() {
		//接收原来数据的总数
		$page = $this->general->post('page');
		$a_data = $this->user_score_model->get_more_data($page);
		echo json_encode($a_data);
	}

/**************************************** 测试 ****************************************/

}


?>