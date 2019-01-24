<?php

class Admin_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('admin_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 管理员列表 *************************************/

	//管理员列表
	public function admin_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data['admin'] = $this->admin_model->get_admin_showlist();
			$a_data['role'] = $this->admin_model->get_role_all();
			foreach ($a_data['admin'] as $key => $value) {
				if ($value['admin_sex'] == 1) {
					$value['admin_sex'] = '男';
				} else if ($value['admin_sex'] == 2) {
					$value['admin_sex'] = '女';
				} else {
					$value['admin_sex'] = '未知';
				}
				$value['register_time'] = date('Y-m-d', $value['register_time']);
				$new_data[] = $value;
			}
			$a_data['admin'] = $new_data;
			$this->view->display('admin_showlist2', $a_data);
		}
	}

/************************************* 添加管理员 *************************************/

	//添加管理员
	public function admin_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$admin_name      = trim($this->general->post('admin_name'));
			$admin_password  = trim($this->general->post('admin_password'));
			$admin_password2 = trim($this->general->post('admin_password2'));
			$admin_realname  = trim($this->general->post('admin_realname'));
			$admin_sex       = trim($this->general->post('admin_sex'));
			$admin_phone     = trim($this->general->post('admin_phone'));
			$admin_email     = trim($this->general->post('admin_email'));
			$role_id         = trim($this->general->post('role_id'));
			//验证数据合法性
			if (empty($admin_name) || empty($admin_password) || empty($admin_password2) || empty($role_id)) {
				$this->error->show_error('必填项不能为空', 'admin_showlist', false, 2);
			}
			//验证手机号码是否合法
			$check_phone = preg_match("/^1[34578]\d{9}$/", $admin_phone);
			if (!$check_phone) {
				$this->error->show_error('手机号码格式不正确', 'admin_showlist', false, 2);
			}
			//验证邮箱是否合法
			$check_email = $this->general->is_mail($admin_email);
			if (!$check_email) {
				$this->error->show_error('邮箱格式不正确', 'admin_showlist', false, 2);
			}
			//判断密码长度是否合法
			if (strlen($admin_password)<6 || strlen($admin_password)>16) {
				$this->error->show_error('密码长度必须为6-16个字符', 'admin_showlist', false, 2);
			}
			//验证两次密码是否一致
			if ($admin_password != $admin_password2) {
				$this->error->show_error('两次密码不一致', 'admin_showlist', false, 2);
			}
			//验证用户和密码是否含有特殊符号
			$special_character = array('!','@','$','%','^','&','*','(',')','+','=','~','·','<','>',',','.','。','，','?','/','\\','|',':',';','[',']','【','】','{','}','"',"'",'`');
			//将用户名拆分为数组并循环匹配
			for ($i=0; $i<strlen($admin_name); $i++) {
				$name_array[] = $admin_name[$i];
			}
			for ($i=0; $i<count($name_array); $i++) {
				if (in_array($name_array[$i], $special_character)) {
					$this->error->show_error('用户名不能含有特殊符号', 'admin_showlist', false, 2);
				}
			}
			//将密码拆分为数组并循环匹配
			for ($i=0; $i<strlen($admin_password); $i++) {
				$password_array[] = $admin_password[$i];
			}
			for ($i=0; $i<count($password_array); $i++) {
				if (in_array($password_array[$i], $special_character)) {
					$this->error->show_error('密码不能含有特殊符号', 'admin_showlist', false, 2);
				}
			}
			//验证用户名是否被占用
			$check_name_occupy = $this->admin_model->get_name_occupy($admin_name);
			if ($check_name_occupy) {
				$this->error->show_error('用户名已被占用，请更换', 'admin_showlist', false, 2);
			}
			//所有验证通过后组装数据保存到数据库
			$a_data = [
				'admin_name'     => $admin_name,
				'admin_password' => md5(md5($admin_password)), //使用双层md5()加密
				'role_id'        => $role_id,
				'admin_phone'    => $admin_phone,
				'admin_email'    => $admin_email,
				'admin_realname' => $admin_realname,
				'admin_sex'      => $admin_sex,
				'register_time'  => $_SERVER['REQUEST_TIME'],
			];
			$i_result = $this->admin_model->insert_admin($a_data);
			if ($i_result) {
				//更新对应角色下的管理员数量
				$this->admin_model->update_admin_count($role_id);
				$this->error->show_success('添加管理员成功', 'admin_showlist', false, 2);
			} else {
				$this->error->show_error('添加管理员失败', 'admin_showlist', false, 2);
			}
		} else {
			//获取角色信息分配到模板
			$a_data = $this->admin_model->get_role_all();
			$this->view->display('admin_add2', $a_data);
		}
	}

/************************************* 修改管理员 *************************************/

	//修改管理员资料
	public function admin_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$admin_id        = trim($this->general->post('admin_id'));
			$admin_name      = trim($this->general->post('admin_name'));
			$admin_password  = trim($this->general->post('admin_password'));
			$admin_password2 = trim($this->general->post('admin_password2'));
			$admin_phone     = trim($this->general->post('admin_phone'));
			$admin_email     = trim($this->general->post('admin_email'));
			$admin_realname  = trim($this->general->post('admin_realname'));
			$admin_sex       = trim($this->general->post('admin_sex'));
			$role_id         = trim($this->general->post('role_id'));
			//原来的角色id
			$original_role = $this->general->post('original_role');
			// 原来的用户名
			$original_name = $this->general->post('original_name');
			//验证数据合法性
			if (empty($admin_name) || empty($admin_phone) || empty($admin_email) || empty($role_id)) {
				$this->error->show_error('必填项不能为空', 'admin_showlist', false, 2);
			}
			//验证手机号码是否合法
			$check_phone = preg_match("/^1[34578]\d{9}$/", $admin_phone);
			if (!$check_phone) {
				$this->error->show_error('手机号码格式不正确', 'admin_showlist', false, 2);
			}
			//验证邮箱是否合法
			$check_email = $this->general->is_mail($admin_email);
			if (!$check_email) {
				$this->error->show_error('邮箱格式不正确', 'admin_showlist', false, 2);
			}
			//验证用户和密码是否含有特殊符号
			$special_character = array('!','@','$','%','^','&','*','(',')','+','=','~','·','<','>',',','.','。','，','?','/','\\','|',':',';','[',']','【','】','{','}','"',"'",'`');
			//将用户名拆分为数组并循环匹配
			for ($i=0; $i<strlen($admin_name); $i++) {
				$name_array[] = $admin_name[$i];
			}
			for ($i=0; $i<count($name_array); $i++) {
				if (in_array($name_array[$i], $special_character)) {
					$this->error->show_error('用户名不能含有特殊符号', 'admin_showlist', false, 2);
				}
			}
			//验证用户名是否被占用
			if ($original_name != $admin_name) {
				$check_name_occupy = $this->admin_model->get_name_occupy($admin_name);
				if ($check_name_occupy) {
					$this->error->show_error('用户名已被占用，请更换', 'admin_showlist', false, 2);
				}
			}
			//判断是否为空 为空表示不修改密码
			if (!empty($admin_password) && !empty($admin_password2)) {
				//验证两次密码是否相同
				if ($admin_password != $admin_password2){
					$this->error->show_error('两次密码不一致', 'admin_showlist', false, 2);
				}
				//判断密码长度是否合法
				if (strlen($admin_password)<6 || strlen($admin_password)>16) {
					$this->error->show_error('密码长度必须为6-16个字符', 'admin_showlist', false, 2);
				}
				//将密码拆分为数组并循环匹配
				for ($i=0; $i<strlen($admin_password); $i++) {
					$password_array[] = $admin_password[$i];
				}
				for ($i=0; $i<count($password_array); $i++) {
					if (in_array($password_array[$i], $special_character)) {
						$this->error->show_error('密码不能含有特殊符号', 'admin_showlist', false, 2);
					}
				}
				//所有验证通过后组装数据保存到数据库
				$a_data = [
					'admin_name'     => $admin_name,
					'admin_password' => md5(md5($admin_password)), //使用双层md5()加密
					'admin_phone'    => $admin_phone,
					'admin_email'    => $admin_email,
					'admin_realname' => $admin_realname,
					'admin_sex'      => $admin_sex,
					'role_id'        => $role_id,
					'update_time'    => $_SERVER['REQUEST_TIME'],
				];
			} else {
				//所有验证通过后组装数据保存到数据库
				$a_data = [
					'admin_name'     => $admin_name,
					'admin_phone'    => $admin_phone,
					'admin_email'    => $admin_email,
					'admin_realname' => $admin_realname,
					'admin_sex'      => $admin_sex,
					'role_id'        => $role_id,
					'update_time'    => $_SERVER['REQUEST_TIME'],
				];
			}
			$a_where = [
				'admin_id' => $admin_id
			];
			$i_result = $this->admin_model->update_admin($a_where, $a_data);
			if ($i_result) {
				//判断角色信息是否改变 如果不相等 则更新对应角色里管理员总数
				if ($original_role != $role_id) {
					//更新对应角色下的管理员数量
					$this->admin_model->update_admin_count($role_id);
					$this->admin_model->update_admin_count($original_role);
				}
				$this->error->show_success('修改成功', 'admin_showlist', false, 2);
			} else {
				$this->error->show_error('修改失败', 'admin_showlist', false, 2);
			}
		} else {
			//接收需要悠管理员的id
			$admin_id = $this->router->get(1);
			//获取该管理员的原有信息分配到模板
			$a_data['admin'] = $this->admin_model->get_admin_one($admin_id);
			//获取角色信息分配到模板
			$a_data['role'] = $this->admin_model->get_role_all();
			$this->view->display('admin_update2', $a_data);
		}
	}

/************************************* 删除管理员 *************************************/

	//删除管理员
	public function admin_delete() {
		//type为1代表删除单条，为2代表批量删除
		$type = $this->general->post('type');
		if ($type==1) {
			$admin_id = $this->general->post('admin_id');
			$role_id  = $this->general->post('role_id');
			$i_result = $this->admin_model->delete_admin_one($admin_id);
			if ($i_result) {
				//删除成功后将对应角色管理员总更新
				$this->admin_model->update_admin_count($role_id);
				echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
			}
		} else if ($type==2) {
			$admin_ids = $this->general->post('admin_id');
			$role_ids = $this->general->post('role_id');
			$i_result = $this->admin_model->delete_admin_mony($admin_ids);
			if ($i_result) {
				//删除成功后更新角色表的管理员总数
				for ($i=0; $i<count($admin_ids); $i++) {
					$this->admin_model->update_admin_count($role_ids[$i]);
				}
				echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
			}
		}
	}

/************************************* 管理员开关 *************************************/

	public function admin_switch() {
		//接收参数
		$admin_id = $this->general->post('admin_id');
		$a_data = $this->admin_model->get_admin_one($admin_id);
		if ($a_data['admin_state'] == 1) {
			$a_update_data = [
				'admin_state' => 0,
			];
		} else {
			$a_update_data = [
				'admin_state' => 1,
			];
		}
		$a_update_where = [
			'admin_id' => $admin_id
		];
		$i_result = $this->admin_model->update_admin($a_update_where, $a_update_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'设置成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'设置失败'));
		}
	}

/************************************* 重置密码 *************************************/

	public function admin_repassword() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$admin_id        = trim($this->general->post('admin_id'));
			$admin_password  = trim($this->general->post('admin_password'));
			$admin_password2 = trim($this->general->post('admin_password2'));
			//验证数据合法性
			if ($admin_password != $admin_password2) {
				$this->error->show_error('两次密码不一致', 'admin_showlist', false, 2);
			}
			if (empty($admin_id) || empty($admin_password) || empty($admin_password2)) {
				$this->error->show_error('必填项不能为空', 'admin_showlist', false, 2);
			}
			//验证密码是否含有特殊符号
			$special_character = array('!','@','$','%','^','&','*','(',')','+','=','~','·','<','>',',','.','。','，','?','/','\\','|',':',';','[',']','【','】','{','}','"',"'",'`');
			//将密码拆分为数组并循环匹配
			for ($i=0; $i<strlen($admin_password); $i++) {
				$password_array[] = $admin_password[$i];
			}
			for ($i=0; $i<count($password_array); $i++) {
				if (in_array($password_array[$i], $special_character)) {
					$this->error->show_error('密码不能含有特殊符号', 'admin_showlist', false, 2);
				}
			}
			$a_where = [
				'admin_id' => $admin_id,
			];
			$a_data = [
				'admin_password' => md5(md5($admin_password)),
			];
			//验证通过后修改数据
			$i_result = $this->admin_model->update_admin($a_where, $a_data);
			if ($i_result) {
				$this->error->show_error('重置密码成功', 'admin_showlist', false, 2);
			} else {
				$this->error->show_error('重置密码失败', 'admin_showlist', false, 2);
			}
		}
	}

/************************************ 搜索管理员 *************************************/

	public function admin_search() {
		// 接收关键词
		$keywords = trim($this->general->post('keywords'));
		if (empty($keywords)) {
			echo json_encode(array('code'=>400, 'msg'=>'关键词不能为空'));die;
		}
		// 根据关键词获取数据
		$a_data = $this->admin_model->get_admin_search($keywords);
		if (empty($a_data)) {
			echo json_encode(array('code'=>500, 'msg'=>'未搜索到任何内容', 'data'=>''));
		} else {
			foreach ($a_data as $key => $value) {
				if ($value['admin_sex'] == 1) {
					$value['admin_sex'] = '男';
				} else if ($value['admin_sex'] == 2) {
					$value['admin_sex'] = '女';
				} else {
					$value['admin_sex'] = '未知';
				}
				$value['register_time'] = date('Y-m-d', $value['register_time']);
				$new_data[] = $value;
			}
			echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$new_data));
		}
	}

/*************************************************************************************/

    //提现记录问题列表
    public function withdraw_log_list(){
        $i_page = $this->router->get(1);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 6;
        // 加载分页类
        $this->load->library('pages');
        $a_order = ['wdtime' =>'desc'];
        $i_total = $this->db->get_total('withdraw_logs');
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);
        $data = $this->db->get("withdraw_logs",'','',$a_order);
        $new = array();
        foreach($data as $key => $val){
            $userinfo = $this->db->get_row("user",['user_id'=>$val['user_id']],'user_name,user_phone');
                $val['user_name'] = $userinfo['user_name'];
                $val['user_phone'] = $userinfo['user_phone'];
                if($val['w_type'] ==1){
                    $val['payment'] = '支付宝';
                }elseif($val['w_type'] ==3){
                    $val['payment'] = '微信';
                }else{
                    $val['payment'] = '银联';
                }

                $new[$key] =$val;
        }
//        var_dump($new);exit;
        $a_data['total'] = $i_total;
        $a_data['data'] = $new;
        $this->view->display('withdraw_log_list',$a_data);
    }

}

?>