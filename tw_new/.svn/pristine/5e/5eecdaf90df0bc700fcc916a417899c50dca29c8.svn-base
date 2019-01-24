<?php

class Auth_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('auth_model');
		$this->load->model('allow_model');
		// $this->allow_model->is_login();
		// $this->allow_model->is_allow();
	}

/************************************* 权限列表 *************************************/

	public function auth_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->auth_model->get_auth_showlist();
			//将数据进行无限极分类
			$a_data = $this->getSubTree($a_data , 0 , 0);
			$this->view->display('auth_showlist', $a_data);
		}
	}

/************************************* 添加权限 *************************************/

	public function auth_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$auth_name = trim($this->general->post('auth_name'));
			$auth_url  = trim($this->general->post('auth_url'));
			$auth_show = trim($this->general->post('auth_show'));
			$level_pid = $this->general->post('level_pid');
			if ($level_pid == 0) {
				$auth_pid   =  0;
				$auth_level =  0;
			} else {
				$level_pid  = explode('-', $level_pid);
				$auth_pid   = $level_pid[0];
				$auth_level = $level_pid[1]+1;
			}
			//验证数据合法性
			if (empty($auth_name) || empty($auth_url)) {
				$this->error->show_error('必填项不能为空', 'auth_add', false, 2);
			}
			//验证数据权限是否已经存在
			$check_auth_url = $this->auth_model->get_auth_exist($auth_url);
			if ($check_auth_url) {
				$this->error->show_error('该权限已经存在', 'auth_add', false, 2);
			}
			$a_data = [
				'auth_name'  => $auth_name,
				'auth_url'   => $auth_url,
				'auth_pid'   => $auth_pid,
				'auth_level' => $auth_level,
				'auth_show'  => $auth_show,
				'auth_type'  => 3,
			];
			//将数据插入到数据库
			$i_result = $this->auth_model->insert_auth($a_data);
			if ($i_result) {
				$this->error->show_success('添加权限成功', 'auth_showlist', false, 2);
			} else {
				$this->error->show_error('添加权限失败', 'auth_showlist', false, 2);
			}
		} else {
			//查询所有权限并分配到模板
			$a_data = $this->auth_model->get_auth_showlist();
			//将数据进行无限极分类
			$a_data = $this->getSubTree($a_data , 0 , 0);
			$this->view->display('auth_add', $a_data);
		}
	}

/************************************* 修改权限 *************************************/

	public function auth_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$auth_id      = $this->general->post('auth_id');
			$auth_name    = trim($this->general->post('auth_name'));
			$auth_url     = trim($this->general->post('auth_url'));
			$auth_show    = trim($this->general->post('auth_show'));
			$original_url = trim($this->general->post('original_url'));
			$level_pid    = $this->general->post('level_pid');
			if ($level_pid == 0) {
				$auth_pid   =  0;
				$auth_level =  0;
			} else {
				$level_pid  = explode('-', $level_pid);
				$auth_pid   = $level_pid[0];
				$auth_level = $level_pid[1]+1;
			}
			//验证数据合法性
			if (empty($auth_id)) {
				$this->error->show_error('非法访问', 'auth_showlist', false, 2);
			}
			if (empty($auth_name) || empty($auth_url)) {
				$this->error->show_error('必填项不能为空', 'auth_update-' . $auth_id, false, 2);
			}
			//验证数据权限是否已经存在
			if ($auth_url != $original_url) {
				$check_auth_url = $this->auth_model->get_auth_exist($auth_url);
				if ($check_auth_url) {
					$this->error->show_error('该权限已经存在', 'auth_update-' . $auth_id, false, 2);
				}
			}
			$a_data = [
				'auth_name'  => $auth_name,
				'auth_url'   => $auth_url,
				'auth_pid'   => $auth_pid,
				'auth_level' => $auth_level,
				'auth_show'  => $auth_show,
				'auth_type'  => 3,
			];
			$a_where = [
				'auth_id'	 => $auth_id
			];
			//将数据插入到数据库
			$i_result = $this->auth_model->update_auth($a_where, $a_data);
			if ($i_result) {
				//修改成功后更新相关角色组
				if ($auth_url != $original_url) {
					$a_data_group = $this->auth_model->get_group_info();
					foreach ($a_data_group as $key => $value) {
						$group_auth = $value['group_auth'];
						if (strpos($group_auth, $original_url) !== false) {
							$group_auth = str_replace($original_url, $auth_url, $group_auth);
							$a_where = [
								'group_id' => $value['group_id'],
							];
							$a_data = [
								'group_auth' => $group_auth
							];
							$i_result = $this->auth_model->update_group_all($a_where, $a_data);
						}
					}
				}
				$this->error->show_success('修改权限成功', 'auth_showlist', false, 2);
			} else {
				$this->error->show_error('修改权限失败', 'auth_showlist', false, 2);
			}
		} else {
			//接收需要修改的权限id
			$auth_id = $this->router->get(1);
			//查询权限的详情并分配到模板
			$a_data['detail'] = $this->auth_model->get_auth_detail($auth_id);
			//查询所有权限信息并分配到模板
			$a_data_auth = $this->auth_model->get_auth_showlist();
			//将数据进行无限级分类
			$a_data['auth'] = $this->getSubTree($a_data_auth , 0 , 0);
			$this->view->display('auth_update', $a_data);
		}
	}

/************************************* 删除权限 *************************************/

	public function auth_delete() {
		// type值为1表示单个删除 为2代表批量删除
		$type = $this->general->post('type');
		if ($type==1) {
			$auth_id = $this->general->post('auth_id');
			//判断是否有子权限 有则阻止删除
			$check_have_son = $this->auth_model->get_son_total($auth_id);
			if ($check_have_son) {
				echo json_encode(array('code'=>400));die;
			}
			//获取权限的url
			$a_data_this = $this->auth_model->get_auth_detail($auth_id);
			$auth_url = $a_data_this['auth_url'];
			$i_result = $this->auth_model->delete_auth_one($auth_id);
			$i_result = 2;
			if ($i_result) {
				//删除成功后将所有角色里该权限删除
				$this->update_group_auth($auth_id, $auth_url);
				echo json_encode(array('code'=>200));
			} else {
				echo json_encode(array('code'=>400));
			}
		}
	}

/*********************************** 更新角色权限 ***********************************/

	public function update_group_auth($auth_id, $auth_url) {
		$a_data_group = $this->auth_model->get_group_info();
		foreach ($a_data_group as $key => $value) {
			$auth_ids   = $value['auth_ids'];
			$group_auth = $value['group_auth'];
			$auth_ids   = explode(',', $auth_ids);
			$group_auth = explode('-', $group_auth);
			if (in_array($auth_id, $auth_ids)) {
				for ($i=0; $i<count($auth_ids); $i++) {
					if ($auth_ids[$i]==$auth_id) {
						unset($auth_ids[$i]);
					}
				}
				for ($i=0; $i<count($group_auth); $i++) {
					if ($group_auth[$i]==$auth_url) {
						unset($group_auth[$i]);
					}
				}
				$auth_count = count($auth_ids);
				$group_auth = implode('-', $group_auth);
				$auth_ids   = implode(',', $auth_ids);
				$a_where = [
					'group_id' => $value['group_id'],
				];
				$a_data = [
					'auth_count' => $auth_count,
					'group_auth' => $group_auth,
					'auth_ids'   => $auth_ids,
				];
				$i_result = $this->auth_model->update_group_all($a_where, $a_data);
			}
		}
		return $i_result;
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