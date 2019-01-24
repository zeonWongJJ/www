<?php
defined('BASEPATH') OR exit('禁止访问！');
class User_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('user_model');
		$this->load->model('allow_model');
		//判断是否登录
		$this->allow_model->is_login();
		//判断是否有权限访问
		$this->allow_model->is_allow();
	}

/**********************************************************************************************/

	//用户列表
	public function user_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->user_model->get_user_showlist();
			$this->view->display('user_showlist', $a_data);
		}
	}

/**********************************************************************************************/

	//修改用户资料
	public function user_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			//$data = trim($this->general->post('data'));
		} else {
			//接收需要修改的会员id
			$id = $this->router->get(1);
			$a_data = $this->user_model->get_userinfo($id);
			$this->view->display('user_update', $a_data);
		}
	}

/**********************************************************************************************/

	//删除一个会员
	public function user_delete() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要删除会员的id
			$id = $this->router->get(1);
			$i_result = $this->user_model->delete_user($id);
			if ($i_result) {
				$this->error->show_success('删除成功', 'user_showlist', false, 2);
			} else {
				$this->error->show_error('删除失败', 'user_showlist', false, 2);
			}
		}
	}

/**********************************************************************************************/

}
