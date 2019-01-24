<?php

class Manager_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('manager_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 门店管理员列表 *************************************/

	public function manager_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->manager_model->get_manager_showlist();
			$this->view->display('manager_showlist', $a_data);
		}
	}

/************************************* 添加门店管理员 *************************************/

	public function manager_add() {
		if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest") {
			//ajax请求获取对应门店的管理员分组信息
			$store_id = $this->general->post('store_id');
			$a_data = $this->manager_model->get_group_store($store_id);
			//如果分组为空则自动创建一个默认分组
			if (empty($a_data)) {
				$a_data_insert = [
					'group_name' => '默认分组',
					'store_id'   => $store_id,
				];
				$i_result = $this->manager_model->insert_group_manager($a_data_insert);
				if ($i_result) {
					$a_data = $this->manager_model->get_group_store($store_id);
				}
			}
			echo json_encode($a_data);
		} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收用户提交的信息
			$manager_name     = trim($this->general->post('manager_name'));
			$manager_password = trim($this->general->post('manager_password'));
			$store_id         = trim($this->general->post('store_id'));
			$group_id         = trim($this->general->post('group_id'));
			$manager_phone    = trim($this->general->post('manager_phone'));
			$manager_email    = trim($this->general->post('manager_email'));
			//验证数据合法性
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'manager_add',
				'log'      => false,
				'wait'     => 2,
			];
			if (empty($manager_name) || empty($manager_password) || empty($group_id)) {
				$this->error->show_error($a_parameter);
			}
			//验证手机号码是否合法
			$check_phone = preg_match("/^1[34578]\d{9}$/", $manager_phone);
			if (!$check_phone) {
				$this->error->show_error('手机号码格式不正确', 'admin_showlist', false, 2);
			}
			//验证邮箱是否合法
			$check_email = $this->general->is_mail($manager_email);
			if (!$check_email) {
				$this->error->show_error('邮箱格式不正确', 'admin_showlist', false, 2);
			}
			//验证密码长度是否合法
			if (strlen($manager_password) < 6 || strlen($manager_password) > 16) {
				$a_parameter['msg'] = '密码长度必须为6-16个字符';
				$this->error->show_error($a_parameter);
			}
			//验证用户和密码是否含有特殊符号
			$special_character = array('!','@','$','%','^','&','*','(',')','+','=','~','·','<','>',',','.','。','，','?','/','\\','|',':',';','[',']','【','】','{','}','"',"'",'`');
			//将用户名拆分为数组并循环匹配
			for ($i=0; $i<strlen($manager_name); $i++) {
				$name_array[] = $manager_name[$i];
			}
			for ($i=0; $i<count($name_array); $i++) {
				if (in_array($name_array[$i], $special_character)) {
					$this->error->show_error('用户名不能含有特殊符号', 'manager_add', false, 2);
				}
			}
			//将密码拆分为数组并循环匹配
			for ($i=0; $i<strlen($manager_password); $i++) {
				$password_array[] = $manager_password[$i];
			}
			for ($i=0; $i<count($password_array); $i++) {
				if (in_array($password_array[$i], $special_character)) {
					$this->error->show_error('密码不能含有特殊符号', 'manager_add', false, 2);
				}
			}
			//验证用户名是否被占用
			$check_manager_name = $this->manager_model->check_manager_name($manager_name);
			if (!empty($check_manager_name)) {
				$a_parameter['msg'] = '用户名已被占用，请更换';
				$this->error->show_error($a_parameter);
			}
			//所有验证通过后将数据保存到数据库
			$a_data = [
				'manager_name'     => $manager_name,
				'manager_password' => md5(md5($manager_password)),
				'manager_phone'    => $manager_phone,
				'manager_email'    => $manager_email,
				'group_id'         => $group_id,
				'store_id'         => $store_id,
				'register_time'    => $_SERVER['REQUEST_TIME'],
			];
			$i_result = $this->manager_model->insert_manager($a_data);
			if ($i_result) {
				//添加成功后将对应分组的管理员总数更新
				$i_result = $this->manager_model->update_manager_count($group_id);
				$a_parameter['msg'] = '添加成功';
				$a_parameter['url'] = 'manager_showlist';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '添加失败';
				$this->error->show_error($a_parameter);
			}
		} else {
			//查询所有门店并分配到模板
			$a_data['store'] = $this->manager_model->get_store_all();
			$this->view->display('manager_add', $a_data);
		}
	}

/************************************* 修改门店管理员 *************************************/

	public function manager_update() {
		if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest") {
			//ajax请求获取对应门店的管理员分组信息
			$store_id = $this->general->post('store_id');
			$a_data = $this->manager_model->get_group_store($store_id);
			//如果分组为空则自动创建一个默认分组
			if (empty($a_data)) {
				$a_data_insert = [
					'group_name' => '默认分组',
					'store_id'  => $store_id,
				];
				$i_result = $this->manager_model->insert_group_manager($a_data_insert);
				if ($i_result) {
					$a_data = $this->manager_model->get_group_store($store_id);
				}
			}
			echo json_encode($a_data);
		} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收用户提交的信息
			$manager_id    = $this->general->post('manager_id');
			$manager_name  = trim($this->general->post('manager_name'));
			$store_id      = trim($this->general->post('store_id'));
			$group_id       = trim($this->general->post('group_id'));
			$manager_phone = trim($this->general->post('manager_phone'));
			$manager_email = trim($this->general->post('manager_email'));
			$original_group = $this->general->post('original_group');
			$original_name = $this->general->post('original_name');
			//验证数据合法性
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'manager_update-' . $manager_id,
				'log'      => false,
				'wait'     => 2,
			];
			if (empty($manager_name) || empty($group_id)) {
				$this->error->show_error($a_parameter);
			}
			//验证手机号码是否合法
			$check_phone = preg_match("/^1[34578]\d{9}$/", $manager_phone);
			if (!$check_phone) {
				$this->error->show_error('手机号码格式不正确', 'admin_showlist', false, 2);
			}
			//验证邮箱是否合法
			$check_email = $this->general->is_mail($manager_email);
			if (!$check_email) {
				$this->error->show_error('邮箱格式不正确', 'admin_showlist', false, 2);
			}
			//验证用户和密码是否含有特殊符号
			$special_character = array('!','@','$','%','^','&','*','(',')','+','=','~','·','<','>',',','.','。','，','?','/','\\','|',':',';','[',']','【','】','{','}','"',"'",'`');
			//将用户名拆分为数组并循环匹配
			for ($i=0; $i<strlen($manager_name); $i++) {
				$name_array[] = $manager_name[$i];
			}
			for ($i=0; $i<count($name_array); $i++) {
				if (in_array($name_array[$i], $special_character)) {
					$this->error->show_error('用户名不能含有特殊符号', 'manager_add', false, 2);
				}
			}
			//验证用户名是否被占用
			if ($manager_name != $original_name) {
				$check_manager_name = $this->manager_model->check_manager_name($manager_name);
				if (!empty($check_manager_name)) {
					$a_parameter['msg'] = '用户名已被占用，请更换';
					$this->error->show_error($a_parameter);
				}
			}
			//所有验证通过后将数据保存到数据库
			$a_data = [
				'manager_name'     => $manager_name,
				'manager_phone'    => $manager_phone,
				'manager_email'    => $manager_email,
				'group_id'          => $group_id,
				'store_id'         => $store_id,
			];
			$a_where = [
				'manager_id' => $manager_id
			];
			$i_result = $this->manager_model->update_manager($a_where, $a_data);
			if ($i_result) {
				//判断角色信息是否改变
				if ($original_group != $group_id) {
					$this->manager_model->update_manager_count($group_id);
					$this->manager_model->update_manager_count($original_group);
				}
				$a_parameter['msg'] = '修改成功';
				$a_parameter['url'] = 'manager_showlist';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '修改失败';
				$this->error->show_error($a_parameter);
			}
		} else {
			//接收需要修改的管理员id
			$manager_id = $this->router->get(1);
			//获取原数据
			$a_data['manager'] = $this->manager_model->get_manager_one($manager_id);
			//查询所有门店并分配到模板
			$a_data['store'] = $this->manager_model->get_store_all();
			//获取分组信息
			$a_data['group'] = $this->manager_model->get_manager_group($a_data['manager']['store_id']);
			$this->view->display('manager_update', $a_data);
		}
	}

/************************************* 删除门店管理员 *************************************/

	public function manager_delete() {
		// type为1代表单个删除 为2代表批量删除
		$type = $this->general->post('type');
		if ($type==1) {
			$manager_id = $this->general->post('manager_id');
			$group_id    = $this->general->post('group_id');
			$i_result   = $this->manager_model->delete_manager_one($manager_id);
			if ($i_result) {
				//删除成功后更新角色表的管理员总数
				$this->manager_model->update_manager_count($group_id);
				echo json_encode(array('code'=>200));
			} else {
				echo json_encode(array('code'=>400));
			}
		} else if ($type==2) {
			$manager_ids = $this->general->post('manager_id');
			$group_ids    = $this->general->post('group_id');
			$i_result    = $this->manager_model->delete_manager_mony($manager_ids);
			if ($i_result) {
				//删除成功更新所有角色的管理员总数
				for ($i = 0; $i<count($group_ids); $i++) {
					$this->manager_model->update_manager_count($group_ids[$i]);
				}
				echo json_encode(array('code'=>200));
			} else {
				echo json_encode(array('code'=>400));
			}
		}
	}

/*****************************************************************************************/



}

?>