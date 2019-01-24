<?php

defined('BASEPATH') or exit('禁止访问！');

class Score_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('score_model');
	}

/*************************************** 积分列表 ***************************************/

	public function score_showlist() {
			$keywords = trim($this->general->post('keywords')) ? trim($this->general->post('keywords')) : urldecode($this->router->get(1));
			if (empty($keywords)) {
				$keywords = 9;
			}
			// 获取一页用户信息
			$a_user = $this->score_model->get_user_page($keywords);
			$a_data['score'] = $a_user['score'];
			$a_data['count'] = $a_user['count'];
			$a_data['keywords'] = $keywords;
			// 所有的用户信息
			$a_userall = $this->score_model->get_user_all();
			$a_data['total'] = 0;
			if (!empty($a_userall)) {
				foreach ($a_userall as $key => $value) {
					$a_data['total'] = $a_data['total'] + $value['user_score'];
				}
			}
			// 获取所有积分变动信息
			$a_points = $this->score_model->get_score_variation();
			$a_data['dike'] = 0;
			$a_data['tixian'] = 0;
			$a_data['shiyong'] = 0;
			if (!empty($a_points)) {
				foreach ($a_points as $key => $value) {
					if ($value['pl_code'] == 4) {
						$a_data['dike'] = $a_data['dike'] + $value['pl_variation'];
					}
					if ($value['pl_code'] == 3) {
						$a_data['tixian'] = $a_data['tixian'] + $value['pl_variation'];
					}
					if ($value['pl_type'] == 2) {
						$a_data['shiyong'] = $a_data['shiyong'] + $value['pl_variation'];
					}
				}
			}
			$this->view->display('score_showlist', $a_data);
	}

/*************************************** 修改积分 ***************************************/

	public function score_update() {
		$user_id        = trim($this->general->post('user_id'));
		$score_update   = trim($this->general->post('score_update'));
		$pl_description = trim($this->general->post('pl_description'));
		// 验证数据合法性
		$a_parameter = [
			'msg'      => '这是提示信息',
			'url'      => 'score_showlist',
			'log'      => false,
			'wait'     => 2,
		];
		// 验证是否为空
		if (empty($user_id) || empty($score_update) || empty($pl_description)) {
			$a_parameter['msg'] = '必填项不能为空';
			$this->error->show_error($a_parameter);
		}
		// 获取一条用户信息
		$a_user = $this->score_model->get_user_one($user_id);
		// 验证是增加还是减少
		if ($score_update == $a_user['user_score']) {
			$a_parameter['msg'] = '未做任何修改';
			$this->error->show_error($a_parameter);
		} else if ($score_update > $a_user['user_score']) {
			// 增加积分
			$pl_type = 1;
			$pl_variation = $score_update - $a_user['user_score'];
			$pl_item = '管理员增加';
			$pl_code = 1;
		} else {
			// 减少积分
			$pl_type = 2;
			$pl_variation = $a_user['user_score'] - $score_update;
			$pl_item = '管理员减少';
			$pl_code = 2;
			if ($pl_variation < 0) {
				$a_parameter['msg'] = '积分不能为负数';
				$this->error->show_error($a_parameter);
			}
		}
		// 验证成功更新用户的积分
		$a_whereu = [
			'user_id' => $a_user['user_id'],
		];
		$a_datau = [
			'user_score' => $score_update
		];
		$i_result = $this->score_model->update_user($a_whereu, $a_datau);
		if ($i_result) {
			// 插入一条积分变动
			$a_data_insert = [
				'user_id'        => $user_id,
				'user_name'      => $a_user['user_name'],
				'pl_type'        => $pl_type,
				'pl_variation'   => $pl_variation,
				'pl_score'       => $score_update,
				'pl_item'        => $pl_item,
				'pl_description' => $pl_description,
				'pl_time'        => $_SERVER['REQUEST_TIME'],
				'pl_code'        => $pl_code,
			];
			$this->score_model->insert_points_log($a_data_insert);
			$a_parameter['msg'] = '修改成功';
			$this->error->show_success($a_parameter);
		} else {
			$a_parameter['msg'] = '修改失败';
			$this->error->show_error($a_parameter);
		}
	}

/*************************************** 积分明细 ***************************************/

	public function score_detail() {
		// 接收需要查看的用户
		$user_id = $this->router->get(1);
		// 获取的状态
		$type = $this->router->get(2);
		if (empty($type)) {
			$type = 9;
		}
		// 获取时间
		$time = $this->router->get(3);
		if (empty($time)) {
			$time = 9;
			$etime = 9;
		}
		$etime = $endThismonth=mktime(23, 59, 59, date('m',$time), date('t',$time), date('Y',$time));
		// 获取一条用户信息
		$a_data['user'] = $this->score_model->get_user_one($user_id);
		// 获取用户和积分变动信息
		$a_points = $this->score_model->get_score_page($user_id, $type, $time, $etime);
		$a_data['points'] = $a_points['points'];
		$a_data['count'] = $a_points['count'];
		$a_data['page'] = $a_points['page'];
		$a_data['type'] = $type;
		$a_data['time'] = $time;
		// 获取此用户所有的积分变动时间
		$a_score_all = $this->score_model->get_score_user($user_id);
		$a_data['month'] = array();
		foreach ($a_score_all as $key => $value) {
			$beginThismonth=mktime(0,0,0,date('m', $value['pl_time']), 1, date('Y', $value['pl_time']));
			if (!in_array($beginThismonth, $a_data['month'])) {
				$a_data['month'][] = $beginThismonth;
			}
		}
		$this->view->display('score_detail', $a_data);
	}

/****************************************************************************************/

}

?>