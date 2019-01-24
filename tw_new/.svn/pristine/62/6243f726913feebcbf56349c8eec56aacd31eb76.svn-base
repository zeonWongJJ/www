<?php

class Role_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('role_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 角色列表 *************************************/

	public function role_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data['role'] = $this->role_model->get_role_showlist();
			//获取所有权限信息分配到模板
			$a_data['auth'] = $this->role_model->get_auth_all();
			//将数据进行无限极分类整理
			$a_data['auth'] = $this->getSubTree($a_data['auth'], 0 , 0);
			$this->view->display('role_showlist2', $a_data);
		}
	}

/************************************* 添加角色 *************************************/

	public function role_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交过来的信息
			$role_name        = trim($this->general->post('role_name'));
			$role_auth        = $this->general->post('role_auth');
			$role_description = trim($this->general->post('role_description'));
			$role_state       = trim($this->general->post('role_state'));
			// 拆分权限权限ids
			$role_auth = explode('-', $role_auth);
			//查询权限表拿到相应权限
			$a_data = $this->role_model->get_auth_all();
			foreach ($a_data as $key => $value) {
				foreach ($role_auth as $k => $v) {
					if ($v==$value['auth_id'] && $value['auth_url']!='') {
						$url[] = $value['auth_url'];
					}
				}
			}
			//将权限url拼接成字符串
			$auth_url = implode('-', $url);
			//角色权限总数
			$auth_count = count($role_auth);
			//将权限id拼接成字符串
			$auth_ids = implode(',', $role_auth);
			//将数据插入到角色表中
			$a_data = [
				'role_name'        => $role_name,
				'role_auth'        => $auth_url,
				'role_description' => $role_description,
				'add_time'         => $_SERVER['REQUEST_TIME'],
				'auth_ids'         => $auth_ids,
				'auth_count'       => $auth_count,
				'role_state'       => $role_state
			];
			$i_result = $this->role_model->insert_role($a_data);
			if ($i_result) {
				$this->error->show_success('添加角色成功', 'role_showlist', false, 2);
			} else {
				$this->error->show_error('添加角色失败', 'role_showlist', false, 2);
			}
		} else {
			//获取所有权限信息分配到模板
			$a_data = $this->role_model->get_auth_all();
			//将数据进行无限极分类整理
			$a_data = $this->getSubTree($a_data, 0 , 0);
			$this->view->display('role_add2', $a_data);
		}
	}

/************************************* 修改角色 *************************************/

	public function role_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交过来的信息
			$role_id          = $this->general->post('role_id');
			$role_name        = trim($this->general->post('role_name'));
			$role_description = trim($this->general->post('role_description'));
			$role_state       = trim($this->general->post('role_state'));
			$role_auth        = $this->general->post('role_auth');
			$role_auth        = explode(',', $role_auth);
			//查询权限表拿到相应权限
			$a_data    = $this->role_model->get_auth_all();
			foreach ($a_data as $key => $value) {
				foreach ($role_auth as $k => $v) {
					if ($v==$value['auth_id'] && $value['auth_url'] != '') {
						$url[] = $value['auth_url'];
					}
				}
			}
			//将权限url拼接成字符串
			$auth_url = implode('-', $url);
			//角色权限总数
			$auth_count = count($role_auth);
			//将权限id拼接成字符串
			$auth_ids = implode(',', $role_auth);
			//将数据插入到角色表中
			$a_where = [
				'role_id' => $role_id
			];
			$a_data = [
				'role_name'        => $role_name,
				'role_auth'        => $auth_url,
				'role_description' => $role_description,
				'auth_ids'         => $auth_ids,
				'auth_count'       => $auth_count,
				'role_state'       => $role_state,
				'update_time'      => $_SERVER['REQUEST_TIME'],
			];
			$i_result = $this->role_model->update_role($a_where, $a_data);
			if ($i_result) {
				$this->error->show_success('修改角色成功', 'role_showlist', false, 2);
			} else {
				$this->error->show_error('修改角色失败', 'role_showlist', false, 2);
			}
		} else {
			//接收需要修改权限的角色id
			$role_id = $this->router->get(1);
			//查询角色详情分配给模板
			$a_data['role'] = $this->role_model->get_role_detail($role_id);
			//查询所有权限信息分配给模板
			$a_data['auth'] = $this->role_model->get_auth_all();
			//将数据进行无限极分类整理
			$a_data['auth'] = $this->getSubTree($a_data['auth'], 0 , 0);
			//当前已有的权限
			$a_data['present'] = explode(',', $a_data['role']['auth_ids']);
			$this->view->display('role_update2', $a_data);
		}
	}

/************************************* 删除角色 *************************************/

	public function role_delete() {
		// type值为1表示单个删除 为2代表批量删除
		$type = $this->general->post('type');
		if ($type==1) {
			$role_id = $this->general->post('role_id');
			//判断角色中是否有用户 如果有刚阻止删除
			$check_have_admin = $this->role_model->get_admin_total($role_id);
			if ($check_have_admin) {
				echo json_encode(array('code'=>400, 'msg'=>'该角色下有' . $check_have_admin . '位管理员,移除后才可删除'));
				die;
			}
			$i_result = $this->role_model->delete_role_one($role_id);
			if ($i_result) {
				echo json_encode(array('code'=>200));
			} else {
				echo json_encode(array('code'=>400));
			}
		} else {
			$role_id = $this->general->post('role_id');
			for ($i=0; $i < count($role_id); $i++) {
				//判断角色中是否有用户 如果有刚阻止删除
				$check_have_admin = $this->role_model->get_admin_total($role_id[$i]);
				if ($check_have_admin) {
					unset($role_id[$i]);
				}
			}
			if (empty($role_id)) {
				echo json_encode(array('code'=>400,'msg'=>'没有符合删除条件的角色'));
				die;
			}
			$i_result = $this->role_model->delete_role_mony($role_id);
			if ($i_result) {
				echo json_encode(array('code'=>200,'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400,'msg'=>'删除失败'));
			}
		}
	}

/************************************* 角色开关 *************************************/

	public function role_switch() {
		$role_id = $this->general->post('role_id');
		$a_data = $this->role_model->get_role_detail($role_id);
		if ($a_data['role_state']==1) {
			$a_update_data = [
				'role_state' => 0,
			];
		} else {
			$a_update_data = [
				'role_state' => 1,
			];
		}
		$a_update_where = [
			'role_id' => $role_id
		];
		$i_result = $this->role_model->update_role($a_update_where, $a_update_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'设置成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'设置失败'));
		}
	}

/************************************* 分配权限 *************************************/

	public function role_distribute() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交过来的信息
			$role_id   = $this->general->post('role_id');
			$role_auth = $this->general->post('role_auth');
			//查询权限表拿到相应权限
			$a_data    = $this->role_model->get_auth_all();
			foreach ($a_data as $key => $value) {
				foreach ($role_auth as $k => $v) {
					if ($v==$value['auth_id'] && $value['auth_url'] != '') {
						$url[] = $value['auth_url'];
					}
				}
			}
			//将权限url拼接成字符串
			$auth_url = implode('-', $url);
			//角色权限总数
			$auth_count = count($role_auth);
			//将权限id拼接成字符串
			$auth_ids = implode(',', $role_auth);
			//将数据插入到角色表中
			$a_where = [
				'role_id' => $role_id
			];
			$a_data = [
				'role_auth'  => $auth_url,
				'auth_ids'   => $auth_ids,
				'auth_count' => $auth_count,
			];
			$i_result = $this->role_model->update_role($a_where, $a_data);
			if ($i_result) {
				$this->error->show_success('分配权限成功', 'role_showlist', false, 2);
			} else {
				$this->error->show_error('分配权限失败', 'role_showlist', false, 2);
			}
		} else {
			//接收需要修改权限的角色id
			$role_id = $this->router->get(1);
			//查询角色详情分配给模板
			$a_data['role'] = $this->role_model->get_role_detail($role_id);
			//查询所有权限信息分配给模板
			$a_data['auth'] = $this->role_model->get_auth_all();
			//将数据进行无限极分类整理
			$a_data['auth'] = $this->getSubTree($a_data['auth'], 0 , 0);
			//当前已有的权限
			$a_data['present'] = explode(',', $a_data['role']['auth_ids']);
			$this->view->display('role_distribute', $a_data);
		}
	}

/************************************* 搜索角色 *************************************/

	function role_search() {
		// 接收关键词
		$keywords = trim($this->general->post('keywords'));
		if (empty($keywords)) {
			echo json_encode(array('code'=>400, 'msg'=>'关键词不能为空', 'data'=>''));
			die;
		}
		// 根据关键词获取数据
		$a_data = $this->role_model->get_role_search($keywords);
		if (empty($a_data)) {
			echo json_encode(array('code'=>500, 'msg'=>'未搜索到任何东西', 'data'=>''));
			die;
		} else {
			foreach ($a_data as $key => $value) {
				$value['add_time'] = date('Y-m-d', $value['add_time']);
				$new_data[] = $value;
			}
			echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$new_data));
		}
	}

/************************************ 无限极分类 ************************************/

	/**
	 * 获取子孙树
	 * @param   array        $data   待分类的数据
	 * @param   int/string   $id     要找的子节点id
	 * @param   int          $lev    节点等级
	 */
	 public function getSubTree($data , $id = 0 , $lev = 1) {
	     static $son = array();
	     foreach($data as $key => $value) {
	         if($value['auth_pid'] == $id) {
	             $value['auth_level'] = $lev;
	             $son[] = $value;
	             $this->getSubTree($data, $value['auth_id'] , $lev+1);
	         }
	     }
	     return $son;
	 }

/************************************************************************************/

}

?>