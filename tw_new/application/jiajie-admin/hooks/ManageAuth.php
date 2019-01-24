<?php

class ManageAuth {

	public function auth_check() {
		// 访问数据方式
		$o_mysql =& load_class('mysql', 'core');
		$o_tw =& get_instance();
		$this_url = $o_tw->router->get_index();
        // 验证是否登录
        if (!isset($_SESSION['admin_id']) && $this_url != 'admin_login') {
			$url = 'admin_login';
			Header("Location: $url");
			die;
        }
      	// 默认允许访问登录页面
    	if (!isset($_SESSION['admin_id']) && $this_url == 'admin_login') {
			return false;
        }
		// 如果是超级管理员则自动跳过验证
		if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1) {
			return false;
		}
		// 如果是默认允许的权限也跳过验证
		$default_allow = 'index-admin_logout-admin_pic';
		if (isset($_SESSION['role_id']) && strpos($default_allow, $this_url) !== false) {
			return false;
		}
		// 验证权限
		if (isset($_SESSION['role_id'])) {
			$a_where = [
				'role_id' => $_SESSION['role_id'],
			];
			$a_data = $o_mysql->get_row('role', $a_where);
			$role_auth = $a_data['role_auth'];
			if (!empty($role_auth)) {
				$auth_arr = explode(',', $role_auth);
				if (!in_array($this_url, $auth_arr)) {
					if ($_SERVER['REQUEST_METHOD'] == 'GET') {
						die('无操作权限');
					} else {
						echo json_encode(array('code'=>400, 'msg'=>'无操作权限'));
						die;
					}
				}
			} else {
				// 如果权限为空
				if ($_SERVER['REQUEST_METHOD'] == 'GET') {
					die('无操作权限');
				} else {
					echo json_encode(array('code'=>400, 'msg'=>'无操作权限'));
					die;
				}
			}
		} else {
			die('非法访问');
		}
	}

}