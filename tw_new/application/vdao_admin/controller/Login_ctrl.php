<?php

class Login_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('login_model');
	}

/************************************* 管理员登录 *************************************/

	public function login() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收登录信息
			$admin_name = trim($this->general->post('admin_name'));
			$admin_password = trim($this->general->post('admin_password'));
			// 验证数据
			if (empty($admin_name) || empty($admin_password)) {
				$this->error->show_error('必填项不能为空', 'login', false, 2);
			}
			// 获取要登录用户的信息
			$a_data = $this->login_model->get_user_info($admin_name);
			//校验账户是否存在
			if (empty($a_data)) {
				$this->error->show_error('该账号不存在', 'login', false, 2);
			}
			// 验证密码是否正确
			$admin_password = md5(md5($admin_password));
			if ($admin_password !== $a_data['admin_password']) {
				$this->error->show_error('登录密码错误', 'login', false, 2);
			}
			// 获取一条角色信息
			$a_role = $this->login_model->get_role_one($a_data['role_id']);
			// 验证是否被限制登录
			if ($a_data['admin_state'] == 0 || $a_role['role_state'] == 0) {
				$this->error->show_error('该账号已被禁用', 'login', false, 2);
			}
			// 校验通过后持久化用户信息
			$_SESSION['admin_id']   = $a_data['admin_id'];
			$_SESSION['admin_name'] = $a_data['admin_name'];
			$_SESSION['role_id']    = $a_data['role_id'];
			$_SESSION['role_name']  = $a_role['role_name'];
			// 更新相关数据表
			$a_update_data = [
				'login_time' => $_SERVER['REQUEST_TIME'],
				'login_ip'   => $this->general->get_ip(),
			];
			$a_update_where = [
				'admin_id' => $a_data['admin_id'],
			];
			$i_result = $this->login_model->update_admin_login($a_update_where, $a_update_data);
			if ($i_result) {
				$this->error->show_success('登录成功', 'index', false, 2);
			} else {
				$this->error->show_error('登录失败', 'index', false, 2);
			}
		} else {
			$this->view->display('login2');
		}
	}

/************************************* 退出登录 *************************************/

	public function loginout() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$b_result = session_destroy();
			if ($b_result) {
				$this->error->show_success('退出登录成功', 'login', false, 2);
			} else {
				$this->error->show_error('退出登录失败', 'index', false, 2);
			}
		}
	}

/************************************************************************************/

}

?>