<?php

class Role_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('role_model');
	}

/**********************************************************************************************/

	//角色列表
	public function role_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->role_model->get_role_showlist();
			echo "<pre>";
			var_dump($a_data);die;
			$this->view->display('role_showlist', $a_data);
		}
	}

/**********************************************************************************************/

	//给角色分配权限
	public function role_distribute() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交过来的信息
			$role_id = trim($this->general->post('role_id'));
			$role_name = trim($this->general->post('role_name'));
			$auth = $this->general->post('auth');
			//查询权限表打到相应权限
			$a_data = $this->role_model->get_auth_all();
			foreach ($a_data as $key => $value) {
				foreach ($auth as $k => $v) {
					if ($v==$value['auth_id'] && $value['action_url']!='') {
						$url[] = $value['action_url'];
					}
				}
			}
			//将权限url拼接成字符串
			$role_auth = implode('-', $url);
			//将权限id拼接成字符串
			$role_auth_ids = implode(',', $auth);
			//更新数据表中的角色信息
			$a_where = [
				'role_id' => $role_id
			];
			$a_data = [
				'role_name'		=> $role_name,
				'role_auth'     => $role_auth,
				'role_auth_ids' => $role_auth_ids,
			];
			$i_result = $this->role_model->update_role($a_where,$a_data);
			if ($i_result) {
				$this->error->show_success('分配权限成功', 'role_showlist', false, 2);
			} else {
				$this->error->show_error('分配权限失败', 'role_showlist', false, 2);
			}
		} else {
			//接收需要分配权限的角色id
			$id = $this->router->get(1);
			//查询角色详情分配给模板
			$a_data['role'] = $this->role_model->get_role_detail($id);
			//当前的权限
			$a_data['present'] = explode(',', $a_data['role']['role_auth_ids']);
			//查询所有权限
			$a_data_auth = $this->role_model->get_auth_all();
			$a_data['auth'] = $this->getSubTree($a_data_auth, 0 , 0);
			$this->view->display('role_distribute', $a_data);
		}
	}

/**********************************************************************************************/

	//增加角色
	public function role_add() {
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			//接收提交过来的信息
			$role_name = trim($this->general->post('role_name'));
			$auth = $this->general->post('auth');
			//查询权限表拿到相应权限
			$a_data = $this->role_model->get_auth_all();
			foreach ($a_data as $key => $value) {
				foreach ($auth as $k => $v) {
					if ($v==$value['auth_id'] && $value['action_url']!='') {
						$url[] = $value['action_url'];
					}
				}
			}
			//将权限url拼接成字符串
			$role_auth = implode('-', $url);
			//将权限id拼接成字符串
			$role_auth_ids = implode(',', $auth);
			//将数据插入到角色表中
			$a_data = [
				'role_name'     => $role_name,
				'role_auth'     => $role_auth,
				'role_auth_ids' => $role_auth_ids,
			];
			$i_result = $this->role_model->insert_role($a_data);
			if ($i_result) {
				$this->error->show_success('添加角色成功', 'role_showlist', false, 2);
			} else {
				$this->error->show_error('添加角色失败', 'role_showlist', false, 2);
			}
		} else {
			$a_data = $this->role_model->get_auth_all();
			$this->view->display('role_add', $a_data);
		}
	}

/**********************************************************************************************/

	//删除角色
	public function role_delete() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要删除角色的id
			$id = $this->router->get(1);
			$i_result = $this->role_model->delete_role($id);
			if ($i_result) {
				$this->error->show_success('删除成功', 'role_showlist', false, 2);
			} else {
				$this->error->show_error('删除失败', 'role_showlist', false, 2);
			}
		}
	}

/**********************************************************************************************/

	/**
	 * 获取子孙树
	 * @param   array        $data   待分类的数据
	 * @param   int/string   $id     要找的子节点id
	 * @param   int          $lev    节点等级
	 */
	 public function getSubTree($data , $id = 0 , $lev = 0) {
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

?>