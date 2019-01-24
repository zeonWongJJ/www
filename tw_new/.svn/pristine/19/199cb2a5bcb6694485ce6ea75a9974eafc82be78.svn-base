<?php
defined('BASEPATH') OR exit('禁止访问！');
class Admin_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('admin_model');
		$this->load->model('allow_model');
		//判断是否登录
		$this->allow_model->is_login();
		//判断是否有权限访问
		$this->allow_model->is_allow();
	}

/**********************************************************************************************/

	//管理员列表
	public function admin_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->admin_model->get_admin_showlist();
			$this->view->display('admin_showlist', $a_data);
		}
	}

/**********************************************************************************************/

	//添加管理员
	public function admin_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收数据
			$username = trim($this->general->post('username'));
			$password = trim($this->general->post('password'));
			$role_id  = trim($this->general->post('role_id'));
			//验证数据
			if (empty($username) || empty($password) || empty($role_id)) {
				$this->error->show_error('必填项不能为空', 'admin_add', false, 2);
			}
			//将数据插入到数据表
			$a_data = [
				'username' => $username,
				'password' => md5($password),
				'role_id'  => $role_id,
			];
			$i_result = $this->admin_model->insert_admin($a_data);
			if ($i_result) {
				$this->error->show_success('添加管理员成功', 'admin_showlist', false, 2);\
			} else {
				$this->error->show_error('添加管理员失败', 'admin_showlist', false, 2);
			}
		} else {
			//获取角色信息分配到模板
			$a_data = $this->admin_model->get_role_info();
			$this->view->display('admin_add', $a_data);
		}
	}

/**********************************************************************************************/

	//删除管理员
	public function admin_delete() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要删除管理员的id
			$id = $this->router->get(1);
			$i_result = $this->admin_model->delete_admin($id);
			if ($i_result) {
				$this->error->show_success('删除成功', 'admin_showlist', false, 2);
			} else {
				$this->error->show_error('删除失败', 'admin_showlist', false, 2);
			}
		}
	}

/**********************************************************************************************/

	//修改管理员信息
	public function admin_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收信息
			$admin_id = trim($this->general->post('admin_id'));
			$username = trim($this->general->post('username'));
			$password = trim($this->general->post('password'));
			$role_id = trim($this->general->post('role_id'));
			//验证数据
			if (empty($username) || empty($role_id) || empty($admin_id)) {
				$this->error->show_error('必填项不能为空', 'admin_showlist', false, 2);
			}
			//密码为空表示不修改
			if (!empty($password)) {
				$password = md5($password);
			}
			//更新数据表信息
			$a_where = [
				'admin_id' => $admin_id
			];
			$a_data [
				'username'	=> $username,
				'password'	=> $password,
				'role_id'	=> $role_id,
			];
			$i_result = $this->admin_model->update_admin($a_where, $a_data);
			if ($i_result) {
				$this->error->show_success('修改成功', 'admin_showlist', false, 2);
			} else {
				$this->error->show_error('修改失败', 'admin_showlist', false, 2);
			}
		} else {
			//接收需要修改有管理员id
			$id = $this->router->get(1);
			//获取管理员的详情
			$a_data['detail'] = $this->admin_model->get_admin_detail($id);
			//获取角色信息
			$a_data['role'] = $this->admin_model->get_role_info();
			$this->view->display('admin_update', $a_data);
		}
	}

/**********************************************************************************************/

}
