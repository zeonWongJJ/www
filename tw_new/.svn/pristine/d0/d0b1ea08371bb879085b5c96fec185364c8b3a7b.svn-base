<?php
defined('BASEPATH') OR exit('禁止访问！');
class Login_ctrl extends TW_Controller {

/**********************************************************************************************/

	public function __construct() {
		parent :: __construct();
		$this->load->model('login_model');
		$this->load->model('allow_model');
		//判断是否有权限访问
		$this->allow_model->is_allow();
	}

/**********************************************************************************************/

	// 管理员登录
	public function login(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收用户提交的数据
			$username = trim($this->general->post('username'));
			$password = trim($this->general->post('password'));
			//验证数据合法性
			//判断用户名长度是否合法
			if (strlen($username)<2 || strlen($username)>20) {
				$this->error->show_error('登录名不合法', 'login', false, 2);
			}
			//判断密码是否合法
			if (strlen($password)<2 || strlen($password)>20) {
				$this->error->show_error('密码不合法', 'login', false, 2);
			}
			//判断用户名是否存在
			$check_username_result = $this->login_model->check_username_exist($username);
			if (empty($check_username_result)) {
				$this->error->show_error('用户名不存在', 'login', false, 2);
			}
			//判断密码是否正确
			if (md5($password)!=$check_username_result['password']) {
				$this->error->show_error('登录密码不正确', 'login', false, 2);
			}
			//所有验证通过后持久化登录信息并更新相关表
			$_SESSION['admin_id'] = $check_username_result['admin_id'];
			$_SESSION['admin_name'] = $check_username_result['username'];
			$_SESSION['role_id']	= $check_username_result['role_id'];
			//更新数据表 [登录历史记录表]
			$a_data_location = [
				'ip' 		 => $this->general->get_ip(),
				'source' 	 => '管理员登录',
				'location'	 => '',
				'equipment'	 => '',
				'member_id'  => $check_username_result['admin_id'],
				'time'		 => $_SERVER['REQUEST_TIME'], //操作时间
			];
			//更新登录历史记录表 new_location
			$i_location_result = $this->login_model->insert_location($a_data_location);
			//页面跳转到后台首页
			$this->error->show_success('登录成功', 'index', false, 2);
		} else {
			$this->view->display('login');
		}
	}

/**********************************************************************************************/

	//退出登录
	public function loginout(){
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$b_result = session_destroy();
			if ($b_result) {
				$this->error->show_success('退出登录成功', 'login', false, 2);
			} else {
				$this->error->show_error('退出登录失败', 'index', false, 2);
			}
		}
	}

/**********************************************************************************************/

}
