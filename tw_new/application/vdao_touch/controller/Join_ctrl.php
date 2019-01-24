<?php

defined('BASEPATH') or exit('禁止访问！');

class Join_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('join_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
	}

/**************************************** 申请加盟 ****************************************/

	public function join_apply() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_parameter = [
				'msg'      => '这是提示信息',
				'url'      => 'join_showlist',
				'log'      => false,
				'wait'     => 2,
			];
			$i_result = $this->join_model->join_apply();
			$is_temporary = $this->router->get(1);
			if ($i_result) {
				if ($is_temporary == 1) {
					$a_parameter['msg'] = '保存成功';
				} else {
					$a_parameter['msg'] = '提交成功';
				}
				$this->error->show_success($a_parameter);
			} else {
				if ($is_temporary == 1) {
					$a_parameter['msg'] = '保存失败';
				} else {
					$a_parameter['msg'] = '提交失败';
				}
				$this->error->show_error($a_parameter);
			}
		} else {
			// 展示加盟页面
			$this->view->display('join_apply');
		}
	}

/**************************************** 加盟列表 ****************************************/

	public function join_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$user_id = $_SESSION['user_id'];
			$a_data['join'] = $this->join_model->get_join_user($user_id);
			$this->view->display('join_showlist', $a_data);
		}
	}

/**************************************** 修改申请 ****************************************/

	public function join_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_parameter = [
				'msg'      => '这是提示信息',
				'url'      => 'join_showlist',
				'log'      => false,
				'wait'     => 2,
			];
			$i_result = $this->join_model->join_update();
			$is_temporary = $this->router->get(2);
			if ($i_result) {
				if ($is_temporary == 'draft') {
					$a_parameter['msg'] = '保存成功';
				} else {
					$a_parameter['msg'] = '提交成功';
				}
				$this->error->show_success($a_parameter);
			} else {
				if ($is_temporary == 'draft') {
					$a_parameter['msg'] = '保存失败';
				} else {
					$a_parameter['msg'] = '提交失败';
				}
				$this->error->show_error($a_parameter);
			}
		} else {
			// 接收需要修改的申请id
			$join_id = $this->router->get(1);
			// 获取数据
			$a_data = $this->join_model->get_join_one($join_id);
			// 展示页面
			$this->view->display('join_update', $a_data);
		}
	}

/******************************************************************************************/

}

?>