<?php

defined('BASEPATH') or exit('禁止访问！');

class Admin_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('admin_model');
	}

/*********************************** 管理员列表 ***********************************/

	public function admin_showlist() {
		// 接收数据
		$order = $this->router->get(1) ? $this->router->get(1) : 'default';
		$page  = $this->router->get(2) ? $this->router->get(1) : 1;
		// 获取数据
		$a_data = $this->admin_model->get_admin_page($order, $page);
		// 展示页面
		$this->view->display('admin_showlist', $a_data);
	}

/*********************************** 管理员开关 ***********************************/

	public function admin_switch() {
		// 接收数据
		$admin_id    = trim($this->general->post('admin_id'));
		$admin_state = trim($this->general->post('admin_state'));
		// 验证数据
		if (empty($admin_id) || empty($admin_state)) {
			echo json_encode(array('code'=>400,'msg'=>'请求参数有误'));
			die;
		}
		// 保存数据
		$a_where = [
			'admin_id' => $admin_id
		];
		$a_data = [
			'admin_state' => $admin_state,
			'update_time' => time()
		];
		$i_result = $this->admin_model->update_admin($a_where, $a_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'保存成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'保存失败'));
		}
	}

/*********************************** 删除管理员 ***********************************/

	public function admin_delete() {
		// 接收数据
		$delete_type = trim($this->general->post('delete_type'));
		// 验证是单个删除还是批量删除
		if ($delete_type == 1) {
			$admin_id = $this->general->post('admin_id');
			$i_result = $this->admin_model->delete_admin(array($admin_id));
		} else {
			$admin_ids = $this->general->post('admin_ids');
			$i_result  = $this->admin_model->delete_admin($admin_ids);
		}
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'删除成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'删除失败'));
		}
	}

/*********************************** 添加管理员 ***********************************/

	public function admin_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收数据
			$admin_name     = trim($this->general->post('admin_name'));
			$admin_password = trim($this->general->post('admin_password'));
			$admin_phone    = trim($this->general->post('admin_phone'));
			$admin_email    = trim($this->general->post('admin_email'));
			$admin_state    = trim($this->general->post('admin_state'));
			$admin_sex      = trim($this->general->post('admin_sex'));
			$admin_realname = trim($this->general->post('admin_realname'));
			$role_id        = trim($this->general->post('role_id'));
			$admin_pic      = trim($this->general->post('admin_pic'));
			// 验证必填项是否为空
			if (empty($admin_name) || empty($admin_password) || empty($role_id)) {
	        	echo json_encode(array('code'=>400, 'msg'=>'必填项不能为空'));
	        	die;
			}
			// 验证手机号码是否正确
			if (!empty($admin_phone)) {
		        $check_result = preg_match("/^1[3456789]\d{9}$/", $admin_phone);
		        if (!$check_result) {
		        	echo json_encode(array('code'=>400, 'msg'=>'手机号码不正确'));
		        	die;
		        }
			}
			// 验证密码长度
			if (strlen($admin_password) < 5 || strlen($admin_password) > 16) {
				echo json_encode(array('code'=>400, 'msg'=>'密码长度必须为5-15个字符'));
				die;
			}
			// 验证用户名是否被占用
			$a_data = $this->admin_model->get_admin_byname($admin_name);
			if (!empty($a_data)) {
				echo json_encode(array('code'=>400, 'msg'=>'用户名已被占用'));
				die;
			}
			// 验证通过后组装数据
			$a_insert_data = [
				'admin_name'     => $admin_name,
				'admin_password' => md5(md5($admin_password)),
				'admin_phone'    => $admin_phone,
				'admin_email'    => $admin_email,
				'admin_state'    => $admin_state,
				'admin_sex'      => $admin_sex,
				'admin_realname' => $admin_realname,
				'role_id'        => $role_id,
				'admin_pic'      => $admin_pic,
				'register_time'  => time(),
				'update_time'    => time()
			];
			$int_result = $this->admin_model->insert_admin($a_insert_data);
			if ($int_result) {
				echo json_encode(array('code'=>200, 'msg'=>'添加成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'添加失败'));
			}
		} else {
			// 获取所有的角色
			$a_data['role'] = $this->admin_model->get_role_all();
			// 展示页面
			$this->view->display('admin_add', $a_data);
		}
	}

/*********************************** 修改管理员 ***********************************/

	public function admin_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收数据
			$admin_id       = trim($this->general->post('admin_id'));
			$admin_name     = trim($this->general->post('admin_name'));
			$admin_password = trim($this->general->post('admin_password'));
			$admin_phone    = trim($this->general->post('admin_phone'));
			$admin_email    = trim($this->general->post('admin_email'));
			$admin_state    = trim($this->general->post('admin_state'));
			$admin_sex      = trim($this->general->post('admin_sex'));
			$admin_realname = trim($this->general->post('admin_realname'));
			$role_id        = trim($this->general->post('role_id'));
			$admin_pic      = trim($this->general->post('admin_pic'));
			// 验证必填项是否为空
			if (empty($admin_name) || empty($role_id)) {
	        	echo json_encode(array('code'=>400, 'msg'=>'必填项不能为空'));
	        	die;
			}
			// 验证手机号码是否正确
			if (!empty($admin_phone)) {
		        $check_result = preg_match("/^1[3456789]\d{9}$/", $admin_phone);
		        if (!$check_result) {
		        	echo json_encode(array('code'=>400, 'msg'=>'手机号码不正确'));
		        	die;
		        }
			}
			// 验证密码长度
			if (!empty($admin_password)) {
				if (strlen($admin_password) < 5 || strlen($admin_password) > 20) {
					echo json_encode(array('code'=>400, 'msg'=>'密码长度必须为5-15个字符'));
					die;
				}
			}
			// 验证用户名是否被占用
			$a_data = $this->admin_model->get_admin_byname($admin_name);
			if (!empty($a_data) && $a_data['admin_id'] != $admin_id) {
				echo json_encode(array('code'=>400, 'msg'=>'用户名已被占用'));
				die;
			}
			// 获取一条管理员信息
			$admin_row = $this->admin_model->get_admin_one($admin_id);
			if (empty($admin_password)) {
				$admin_password = $admin_row['admin_password'];
			} else {
				$admin_password = md5(md5($admin_password));
			}
			$a_update_where = [
				'admin_id' => $admin_id
			];
			$a_update_data = [
				'admin_name'     => $admin_name,
				'admin_password' => $admin_password,
				'admin_phone'    => $admin_phone,
				'admin_email'    => $admin_email,
				'admin_state'    => $admin_state,
				'admin_sex'      => $admin_sex,
				'admin_realname' => $admin_realname,
				'role_id'        => $role_id,
				'admin_pic'      => $admin_pic,
				'update_time'    => time()
			];
			$int_result = $this->admin_model->update_admin($a_update_where, $a_update_data);
			if ($int_result) {
				echo json_encode(array('code'=>200, 'msg'=>'保存成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'保存失败'));
			}
		} else {
			// 接收参数
			$admin_id = $this->router->get(1);
			// 获取详情
			$a_data['admin'] = $this->admin_model->get_admin_one($admin_id);
			// 获取所有的角色
			$a_data['role'] = $this->admin_model->get_role_all();
			// 展示页面
			$this->view->display('admin_update', $a_data);
		}
	}

/************************************ 角色列表 ************************************/

	public function role_showlist() {
		// 接收数据
		$order = $this->router->get(1) ? $this->router->get(1) : 'default';
		$page  = $this->router->get(2) ? $this->router->get(1) : 1;
		// 获取数据
		$a_data = $this->admin_model->get_role_page($order, $page);
		// 展示页面
		$this->view->display('role_showlist', $a_data);
	}

/************************************* 角色开关 ************************************/

	public function role_switch() {
		// 接收数据
		$role_id    = trim($this->general->post('role_id'));
		$role_state = trim($this->general->post('role_state'));
		// 验证数据
		if (empty($role_id) || empty($role_state)) {
			echo json_encode(array('code'=>400,'msg'=>'请求参数有误'));
			die;
		}
		// 保存数据
		$a_where = [
			'role_id' => $role_id
		];
		$a_data = [
			'role_state' => $role_state,
			'update_time' => time()
		];
		$i_result = $this->admin_model->update_role($a_where, $a_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'保存成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'保存失败'));
		}
	}

/************************************ 删除角色 ************************************/

	public function role_delete() {
		// 接收数据
		$delete_type = trim($this->general->post('delete_type'));
		// 验证是单个删除还是批量删除
		if ($delete_type == 1) {
			$role_id = $this->general->post('role_id');
			$i_result = $this->admin_model->delete_role(array($role_id));
		} else {
			$role_ids = $this->general->post('role_ids');
			$i_result  = $this->admin_model->delete_role($role_ids);
		}
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'删除成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'删除失败'));
		}
	}

/************************************ 添加角色 ************************************/

	public function role_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收数据
			$role_name        = trim($this->general->post('role_name'));
			$role_state       = trim($this->general->post('role_state'));
			$role_description = trim($this->general->post('role_description'));
			$auth_ids         = $this->general->post('role_auth');
			// 验证数据
			if (empty($role_name) || empty($role_state)) {
				echo json_encode(array('code'=>400,'msg'=>'必填项不能为空'));
				die;
			}
			// 组装数据
			if (!empty($auth_ids)) {
				$a_auth = $this->admin_model->get_auth_part($auth_ids);
				if (!empty($a_auth)) {
					$auth_url = array();
					foreach ($a_auth as $key => $value) {
						if (!empty($value['auth_url'])) {
							$auth_url[] = $value['auth_url'];
						}
					}
					$role_auth = implode(',', $auth_url);
				}
				$auth_ids = implode(',', $auth_ids);
			} else {
				$auth_url = '';
				$auth_ids = '';
			}
			// 组装数据
			$a_data = [
				'role_name'        => $role_name,
				'role_state'       => $role_state,
				'role_description' => $role_description,
				'auth_ids'         => $auth_ids,
				'role_time'        => time(),
				'update_time'      => time(),
				'role_auth'        => $role_auth
			];
			$int_result = $this->admin_model->insert_role($a_data);
			if ($int_result) {
				echo json_encode(array('code'=>200,'msg'=>'添加成功'));
			} else {
				echo json_encode(array('code'=>400,'msg'=>'添加失败'));
			}
		} else {
			// 获取数据
			$a_auth = $this->admin_model->get_auth_all();
			// 进行无限极分类
			$a_data['auth'] = $this->getSubTree($a_auth, 0, 0);
			// 展示页面
			$this->view->display('role_add', $a_data);
		}
	}

/************************************ 修改角色 ************************************/

	public function role_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收数据
			$role_id          = trim($this->general->post('role_id'));
			$role_name        = trim($this->general->post('role_name'));
			$role_state       = trim($this->general->post('role_state'));
			$role_description = trim($this->general->post('role_description'));
			$auth_ids         = $this->general->post('role_auth');
			// 验证数据
			if (empty($role_name) || empty($role_state)) {
				echo json_encode(array('code'=>400,'msg'=>'必填项不能为空'));
				die;
			}
			// 组装数据
			if (!empty($auth_ids)) {
				$a_auth = $this->admin_model->get_auth_part($auth_ids);
				if (!empty($a_auth)) {
					$auth_url = array();
					foreach ($a_auth as $key => $value) {
						if (!empty($value['auth_url'])) {
							$auth_url[] = $value['auth_url'];
						}
					}
					$role_auth = implode(',', $auth_url);
				}
				$auth_ids = implode(',', $auth_ids);
			} else {
				$role_auth = '';
				$auth_ids  = '';
			}
			// 组装数据
			$a_where = [
				'role_id' => $role_id
			];
			$a_data = [
				'role_name'        => $role_name,
				'role_state'       => $role_state,
				'role_description' => $role_description,
				'auth_ids'         => $auth_ids,
				'update_time'      => time(),
				'role_auth'        => $role_auth
			];
			$int_result = $this->admin_model->update_role($a_where, $a_data);
			if ($int_result) {
				echo json_encode(array('code'=>200, 'msg'=>'保存成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'保存失败'));
			}
		} else {
			// 接收参数
			$role_id = $this->router->get(1);
			// 获取一条角色
			$a_data['role'] = $this->admin_model->get_role_one($role_id);
			// 获取权限
			$a_auth = $this->admin_model->get_auth_all();
			// 进行无限极分类
			$a_data['auth'] = $this->getSubTree($a_auth, 0, 0);
			// 展示页面
			$this->view->display('role_update', $a_data);
		}
	}

/************************************ 权限列表 ************************************/

	public function auth_showlist() {
		// 获取数据
		$a_auth = $this->admin_model->get_auth_all();
		// 进行无限极分类
		$a_data['auth'] = $this->getSubTree($a_auth, 0, 0);
		// 展示页面
		$this->view->display('auth_showlist', $a_data);
	}

/************************************ 添加权限 ************************************/

	public function auth_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收数据
			$auth_name        = trim($this->general->post('auth_name'));
			$auth_url         = trim($this->general->post('auth_url'));
			$auth_pid         = $this->general->post('auth_pid');
			$auth_description = trim($this->general->post('auth_description'));
			// 验证数据
			if (empty($auth_name)) {
				echo json_encode(array('code'=>400,'msg'=>'必填项不能为空'));
				die;
			}
			if ($auth_pid != 0) {
				// 验证控制器方法是否为空
				if (empty($auth_url)) {
					echo json_encode(array('code'=>400,'msg'=>'必填项不能为空'));
					die;
				}
				// 验证数据是否存在
				$a_data = $this->admin_model->get_auth_where($auth_name);
				if (!empty($a_data)) {
					echo json_encode(array('code'=>400,'msg'=>'该权限已存在'));
					die;
				}
			}
			// 验证通过后组装数据保存到数据库
			if ($auth_pid == 0) {
				$auth_level = 0;
			} else {
				$auth_level = 1;
			}
			$a_insert_data = [
				'auth_name'        => $auth_name,
				'auth_url'  => $auth_url,
				'auth_pid'         => $auth_pid,
				'auth_description' => $auth_description,
				'auth_level'       => $auth_level,
				'auth_time'        => time(),
				'update_time'      => time()
			];
			$int_result = $this->admin_model->insert_auth($a_insert_data);
			if ($int_result) {
				echo json_encode(array('code'=>200,'msg'=>'添加成功'));
			} else {
				echo json_encode(array('code'=>400,'msg'=>'添加失败'));
			}
		} else {
			// 获取数据
			$a_data['auth'] = $this->admin_model->get_auth_parent();
			// 展示页面
			$this->view->display('auth_add', $a_data);
		}
	}

/************************************ 修改权限 ************************************/

	public function auth_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收数据
			$auth_id          = trim($this->general->post('auth_id'));
			$auth_name        = trim($this->general->post('auth_name'));
			$auth_url         = trim($this->general->post('auth_url'));
			$auth_pid         = $this->general->post('auth_pid');
			$auth_description = trim($this->general->post('auth_description'));
			// 验证数据
			if (empty($auth_name) || empty($auth_id)) {
				echo json_encode(array('code'=>400,'msg'=>'必填项不能为空'));
				die;
			}
			if ($auth_pid != 0) {
				// 验证控制器方法是否为空
				if (empty($auth_url)) {
					echo json_encode(array('code'=>400,'msg'=>'必填项不能为空'));
					die;
				}
				// 验证数据是否存在
				$a_data = $this->admin_model->get_auth_where($auth_name);
				if (!empty($a_data) && $a_data['auth_id'] != $auth_id) {
					echo json_encode(array('code'=>400,'msg'=>'该权限已存在'));
					die;
				}
			}
			// 验证通过后组装数据保存到数据库
			if ($auth_pid == 0) {
				$auth_level = 0;
			} else {
				$auth_level = 1;
			}
			$a_where = [
				'auth_id' => $auth_id
			];
			$a_data = [
				'auth_name'        => $auth_name,
				'auth_url'         => $auth_url,
				'auth_pid'         => $auth_pid,
				'auth_description' => $auth_description,
				'auth_level'       => $auth_level,
				'update_time'      => time()
			];
			$int_result = $this->admin_model->update_auth($a_where, $a_data);
			if ($int_result) {
				echo json_encode(array('code'=>200,'msg'=>'添加成功'));
			} else {
				echo json_encode(array('code'=>400,'msg'=>'添加失败'));
			}
		} else {
			// 接收参数
			$auth_id = $this->router->get(1);
			// 获取详情
			$a_data['detail'] = $this->admin_model->get_auth_one($auth_id);
			// 获取数据
			$a_data['auth'] = $this->admin_model->get_auth_parent();
			// 展示页面
			$this->view->display('auth_update', $a_data);
		}
	}

/************************************ 删除权限 ************************************/

	public function auth_delete() {
		// 接收数据
		$delete_type = trim($this->general->post('delete_type'));
		// 验证是单个删除还是批量删除
		if ($delete_type == 1) {
			$auth_id  = $this->general->post('auth_id');
			$i_result = $this->admin_model->delete_auth(array($auth_id));
		} else {
			$auth_ids = $this->general->post('auth_ids');
			$i_result = $this->admin_model->delete_auth($auth_ids);
		}
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'删除成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'删除失败'));
		}
	}

/********************************** 管理员登录 **********************************/

	public function admin_login() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收数据
			$admin_name     = trim($this->general->post('admin_name'));
			$admin_password = trim($this->general->post('admin_password'));
			// 验证数据
			if (empty($admin_name) || empty($admin_password)) {
				echo json_encode(array('code'=>400, 'msg'=>'必填项不能为空'));
				die;
			}
			// 验证账号是否存在
			$a_data = $this->admin_model->get_admin_byname($admin_name);
			if (empty($a_data)) {
				echo json_encode(array('code'=>400, 'msg'=>'账号不存在'));
				die;
			}
			// 验证密码是否正确
			if (md5(md5($admin_password)) != $a_data['admin_password']) {
				echo json_encode(array('code'=>400, 'msg'=>'密码错误'));
				die;
			}
			// 验证是否被禁用
			if ($a_data['admin_state'] == 2) {
				echo json_encode(array('code'=>400, 'msg'=>'当前账号已被停用'));
				die;
			}
			// 验证角色是否被禁用
			$a_role = $this->admin_model->get_role_one($a_data['role_id']);
			if ($a_role['role_state'] == 2) {
				echo json_encode(array('code'=>400, 'msg'=>'用户组已被停用'));
				die;
			}
			// 持久化数据
			$_SESSION['admin_id']   = $a_data['admin_id'];
			$_SESSION['admin_name'] = $a_data['admin_name'];
			$_SESSION['role_id']    = $a_data['role_id'];
			// 验证通过后更新数据
			$a_update_where = [
				'admin_id' => $a_data['admin_id']
			];
			$a_update_data = [
				'login_time' => time(),
				'login_ip'   => $this->general->get_ip()
			];
			$int_result = $this->admin_model->update_admin($a_update_where, $a_update_data);
			echo json_encode(array('code'=>200, 'msg'=>'登录成功'));
			die;
		} else {
			// 展示页面
			$this->view->display('admin_login');
		}
	}

/******************************** 管理员退出登录 ********************************/

	public function admin_logout() {
		$b_result = session_destroy();
		$url = 'admin_login';
		Header("Location: $url");
	}

/********************************** 无限极分类 **********************************/

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

/**********************************************************************************/

}