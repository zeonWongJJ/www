<?php
defined('BASEPATH') OR exit('禁止访问！');
class Auth_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('auth_model');
		$this->load->model('allow_model');
		//判断是否登录
		$this->allow_model->is_login();
		//判断是否有权限访问
		$this->allow_model->is_allow();
	}

/**********************************************************************************************/

	//权限列表
	public function auth_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->auth_model->get_auth_showlist();
			//将权限信息进行分类整理
			$a_data = $this->getSubTree($a_data , 0 , 0);
			echo "<pre>";
			var_dump($a_data);die;
			$this->view->display('auth_showlist', $a_data);
		}
	}

/**********************************************************************************************/

	//增加权限
	public function auth_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收信息
			$auth_name = trim($this->general->post('auth_name'));
			$action_url = trim($this->general->post('action_url'));
			$type = trim($this->general->post('type'));
			$level_pid = $this->general->post('level_pid');
			if ($level_pid == 0) {
				$parent_id =  0;
				$level     =  0;
			} else {
				$level_pid = explode('-', $level_pid);
				$parent_id = $level_pid[0];
				$level = $level_pid[1]+1;
			}
			$a_data = [
				'auth_name'  => $auth_name,
				'action_url' => $action_url,
				'type'       => $type,
				'parent_id'  => $parent_id,
				'level'      => $level,
			];
			//将数据插入到数据库
			$i_result = $this->auth_model->insert_auth($a_data);
			if ($i_result) {
				$this->error->show_success('添加权限成功', 'auth_showlist', false, 2);
			} else {
				$this->error->show_error('添加权限失败', 'auth_showlist', false, 2);
			}
		} else {
			//权限信息分配到模板
			$a_data_auth = $this->auth_model->get_auth_showlist();
			$a_data = $this->getSubTree($a_data_auth , 0 , 0);
			$this->view->display('auth_add', $a_data);
		}
	}

/**********************************************************************************************/

	//删除权限
	public function auth_delete() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要删除的权限id
			$id = $this->router->get(1);
			$i_result = $this->user_auth->delete_auth($id);
			if ($i_result) {
				$this->error->show_success('删除成功', 'auth_showlist', false, 2);
			} else {
				$this->error->show_error('删除失败', 'auth_showlist', false, 2);
			}
		}
	}

/**********************************************************************************************/

	//修改权限
	public function auth_update() {
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			//接收信息
			$auth_id = $this->general->post('auth_id');
			$auth_name = trim($this->general->post('auth_name'));
			$action_url = trim($this->general->post('action_url'));
			$type = trim($this->general->post('type'));
			$level_pid = $this->general->post('level_pid');
			if ($level_pid == 0) {
				$parent_id =  0;
				$level     =  0;
			} else {
				$level_pid = explode('-', $level_pid);
				$parent_id = $level_pid[0];
				$level = $level_pid[1]+1;
			}
			//判断父权限是否是自己 如果是则修改失败
			if ($parent_id==$auth_id) {
				$this->error->show_error('修改权限失败', 'auth_showlist', false, 2);
			}
			$a_where = [
				'auth_id' 	 => $auth_id,
			];
			$a_data = [
				'auth_name'  => $auth_name,
				'action_url' => $action_url,
				'type'       => $type,
				'parent_id'  => $parent_id,
				'level'      => $level,
			];
			//将数据更新到数据库
			$i_result = $this->auth_model->update_auth($a_where,$a_data);
			if ($i_result) {
				$this->error->show_success('修改权限成功', 'auth_showlist', false, 2);
			} else {
				$this->error->show_error('修改权限失败', 'auth_showlist', false, 2);
			}
		} else {
			//接收需要修改的权限id
			$id = $this->router->get(1);
			$a_data['detail'] = $this->auth_model->get_auth_detail($id);
			//权限信息分配到模板
			$a_data_auth = $this->auth_model->get_auth_showlist();
			$a_data['auth'] = $this->getSubTree($a_data_auth , 0 , 0);
			$this->view->display('auth_update', $a_data);
		}
	}

/**********************************************************************************************/

	/**
	 * 获取子孙树
	 * @param   array        $data   待分类的数据
	 * @param   int/string   $id     要找的子节点id
	 * @param   int          $lev    节点等级
	 */
	 public function getSubTree($data , $id = 0 , $lev = 1) {
	     static $son = array();
	     foreach($data as $key => $value) {
	         if($value['parent_id'] == $id) {
	             $value['level'] = $lev;
	             $son[] = $value;
	             $this->getSubTree($data, $value['auth_id'] , $lev+1);
	         }
	     }
	     return $son;
	 }

/**********************************************************************************************/

}
