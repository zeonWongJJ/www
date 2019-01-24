<?php

class User_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('user_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/*********************************** 用户列表 ***********************************/

	public function user_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 获取所有用户信息
			$a_data['user'] = $this->user_model->get_user_showlist();
			// 获取用户总数
			$a_data['count'] = $this->user_model->get_user_total();
			$this->view->display('user_showlist2', $a_data);
		}
	}

/*********************************** 添加用户 ***********************************/


	public function user_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$user_name      = trim($this->general->post('user_name'));
			$user_password  = trim($this->general->post('user_password'));
			$user_password2 = trim($this->general->post('user_password2'));
			$user_sex       = trim($this->general->post('user_sex'));
			$user_phone     = trim($this->general->post('user_phone'));
			$user_email     = trim($this->general->post('user_email'));
			$user_score     = trim($this->general->post('user_score'));
			$user_balance   = trim($this->general->post('user_balance'));
			//验证数据合法性
			if (empty($user_name) || empty($user_password) || empty($user_password2)) {
				$this->error->show_error('必填项不能为空', 'user_add', false, 2);
			}
			// 验证积分是否为数字
			if (!is_numeric($user_score) || !is_numeric($user_balance)) {
				$this->error->show_error('积分和余额必须均为数字', 'user_add', false, 2);
			}
			// 判断密码长度是否合法
			if (strlen($user_password)<6 || strlen($user_password)>16) {
				$this->error->show_error('密码长度不合法', 'user_add', false, 2);
			}
			// 验证两次密码是否一致
			if ($user_password != $user_password2) {
				$this->error->show_error('两次密码输入不一致', 'user_add', false, 2);
			}
			//验证用户名是否有特殊符号
			$special_character = array('!','@','$','%','^','&','*','(',')','+','=','~','·','<','>',',','.','。','，','?','/','\\','|',':',';','[',']','【','】','{','}','"',"'",'`');
			//将用户名拆分为数组并循环匹配
			for ($i=0; $i<strlen($user_name); $i++) {
				$name_array[] = $user_name[$i];
			}
			for ($i=0; $i<count($name_array); $i++) {
				if (in_array($name_array[$i], $special_character)) {
					$this->error->show_error('用户名不能含有特殊符号', 'user_add', false, 2);
				}
			}
			//验证密码是否有特殊字符
			for ($i=0; $i<strlen($user_password); $i++) {
				$name_array[] = $user_password[$i];
			}
			for ($i=0; $i<count($name_array); $i++) {
				if (in_array($name_array[$i], $special_character)) {
					$this->error->show_error('密码不能含有特殊符号', 'user_add', false, 2);
				}
			}
			// 验证用户名是否已占用
			$i_user_exist = $this->user_model->get_user_exist($user_name);
			if ($i_user_exist) {
				$this->error->show_error('用户名已被占用', 'user_add', false, 2);
			}
			// 验证手机号码是否被占用
			$i_phone_exist = $this->user_model->get_phone_exist($user_phone);
//			if ($i_phone_exist) {
//				$this->error->show_error('手机号码已被占用', 'user_add', false, 2);
//			}
			//验证通过后将数据保存至数据库
			$a_data = [
				'user_name'     => $user_name,
				'user_password' => md5(md5($user_password)), //对密码进行md5双层加密
				'user_sex'      => $user_sex,
				'user_phone'    => $user_phone,
				'user_email'    => $user_email,
				'user_score'    => $user_score,
				'user_balance'  => $user_balance,
				'user_regtime'  => $_SERVER['REQUEST_TIME'],
				'user_regip'    => $this->general->get_ip(),
				'user_state'    => 1,
			];
			$i_result = $this->user_model->insert_user($a_data);
			if ($i_result) {
				$this->error->show_success('添加用户成功', 'user_showlist', false, 2);
			} else {
				$this->error->show_error('添加用户失败', 'user_showlist', false, 2);
			}
		} else {
			$this->view->display('user_add');
		}
	}

/********************************* 修改用户资料 *********************************/

	public function user_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$user_id        = trim($this->general->post('user_id'));
			$user_name      = trim($this->general->post('user_name'));
			$user_password  = trim($this->general->post('user_password'));
			$user_password2 = trim($this->general->post('user_password2'));
			$user_sex       = trim($this->general->post('user_sex'));
			$user_phone     = trim($this->general->post('user_phone'));
			$user_email     = trim($this->general->post('user_email'));
			$user_score     = trim($this->general->post('user_score'));
			$user_balance   = trim($this->general->post('user_balance'));
			$original_name  = trim($this->general->post('original_name'));
			$original_phone = trim($this->general->post('original_phone'));
			$original_score = trim($this->general->post('original_score'));
			$original_balance = trim($this->general->post('original_balance'));
			// 验证数据合法性
			if (empty($user_name) || empty($user_id)) {
				$this->error->show_error('必填项不能为空', 'user_update-'.$user_id, false, 2);
			}
			// 验证积分是否为数字
			if (!is_numeric($user_score) || !is_numeric($user_balance)) {
				$this->error->show_error('积分和余额必须均为数字', 'user_update-'.$user_id, false, 2);
			}
			// 验证积分余额是否合法
			if ($user_score < 0 || $user_balance < 0) {
				$this->error->show_error('积分和余额不能为负数', 'user_update-'.$user_id, false, 2);
			}
			//验证用户名是否有特殊符号
			$special_character = array('!','@','$','%','^','&','*','(',')','+','=','~','·','<','>',',','.','。','，','?','/','\\','|',':',';','[',']','【','】','{','}','"',"'",'`');
			//将用户名拆分为数组并循环匹配
			for ($i=0; $i<strlen($user_name); $i++) {
				$name_array[] = $user_name[$i];
			}
			for ($i=0; $i<count($name_array); $i++) {
				if (in_array($name_array[$i], $special_character)) {
					$this->error->show_error('用户名不能含有特殊符号', 'user_update-'.$user_id, false, 2);
				}
			}
			// 验证用户名是否已占用
			if ($user_name != $original_name) {
				$i_user_exist = $this->user_model->get_user_exist($user_name);
				if ($i_user_exist) {
					$this->error->show_error('用户名已被占用', 'user_update-'.$user_id, false, 2);
				}
			}
			// 验证手机号码是否被占用
			if ($user_phone != $original_phone) {
				$i_phone_exist = $this->user_model->get_phone_exist($user_phone);
				if ($i_phone_exist) {
					$this->error->show_error('手机号码已被占用', 'user_update-'.$user_id, false, 2);
				}
			}

			if (!empty($user_password)) {
				// 判断密码长度是否合法
				if (strlen($user_password)<6 || strlen($user_password)>16) {
					$this->error->show_error('密码长度不合法', 'user_update-'.$user_id, false, 2);
				}
				// 验证两次密码是否一致
				if ($user_password != $user_password2) {
					$this->error->show_error('两次密码输入不一致', 'user_update-'.$user_id, false, 2);
				}
				//验证密码是否有特殊字符
				for ($i=0; $i<strlen($user_password); $i++) {
					$name_array[] = $user_password[$i];
				}
				for ($i=0; $i<count($name_array); $i++) {
					if (in_array($name_array[$i], $special_character)) {
						$this->error->show_error('密码不能含有特殊符号', 'user_update-'.$user_id, false, 2);
					}
				}
				$a_data = [
					'user_name'     => $user_name,
					'user_password' => md5(md5($user_password)), //对密码进行md5双层加密
					'user_sex'      => $user_sex,
					'user_phone'    => $user_phone,
					'user_email'    => $user_email,
					'user_score'    => $user_score,
					'user_balance'  => $user_balance,
					'update_time'   => $_SERVER['REQUEST_TIME']
				];
			} else {
				$a_data = [
					'user_name'    => $user_name,
					'user_sex'     => $user_sex,
					'user_phone'   => $user_phone,
					'user_email'   => $user_email,
					'user_score'   => $user_score,
					'user_balance' => $user_balance,
					'update_time'  => $_SERVER['REQUEST_TIME']
				];
			}
			//验证通过后将数据保存至数据库
			$a_where = [
				'user_id' => $user_id
			];
			$i_result = $this->user_model->update_user($a_where, $a_data);
			if ($i_result) {
				// 修改成功后 验证积分是否变动 如有变动插入一条积分记录
				if ($user_score != $original_score) {
					// 变动金额
					if (($user_score-$original_score)>0) {
						$pl_variation = $user_score - $original_score;
						$a_insert_data = [
							'user_id'        => $user_id,
							'user_name'      => $user_name,
							'pl_type'        => 1,
							'pl_variation'   => $pl_variation,
							'pl_score'       => $user_score,
							'pl_item'        => '管理员增加',
							'pl_description' => '管理员增加',
							'pl_time'        => $_SERVER['REQUEST_TIME'],
							'pl_code'        => 1,
						];
					} else {
						$pl_variation = $original_score-$user_score;
						$a_insert_data = [
							'user_id'        => $user_id,
							'user_name'      => $user_name,
							'pl_type'        => 2,
							'pl_variation'   => $pl_variation,
							'pl_score'       => $user_score,
							'pl_item'        => '管理员减少',
							'pl_description' => '管理员减少',
							'pl_time'        => $_SERVER['REQUEST_TIME'],
							'pl_code'        => 2,
						];
					}
					$i_result = $this->user_model->insert_points_log($a_insert_data);
				}
				// 判断余额是否有变动 如有变动则插入一条记录
				if ($original_balance != $user_balance) {
					if (($user_balance - $original_balance) > 0) {
						$ub_money = $user_balance - $original_balance;
						$a_ub_data = [
							'ub_type' => 1,
							'ub_money' => $ub_money,
							'ub_balance' => $user_balance,
							'ub_time' => $_SERVER['REQUEST_TIME'],
							'ub_item' => '管理员增加',
							'ub_description' => '管理员增加',
							'user_id' => $user_id,
							'ub_number' => 'ADMIN'.date('YmdHis',time()).rand(111,222),
						];
					} else {
						$ub_money = $original_balance - $user_balance;
						$a_ub_data = [
							'ub_type' => 2,
							'ub_money' => $ub_money,
							'ub_balance' => $user_balance,
							'ub_time' => $_SERVER['REQUEST_TIME'],
							'ub_item' => '管理员减少',
							'ub_description' => '管理员减少',
							'user_id' => $user_id,
							'ub_number' => 'ADMIN'.date('YmdHis',time()).rand(111,222),
						];
					}
					$this->user_model->insert_userbalance($a_ub_data);
				}
				$this->error->show_success('修改成功', 'user_showlist', false, 2);
			} else {
				$this->error->show_error('修改失败', 'user_showlist', false, 2);
			}
		} else {
			//接收需要修改的用户id
			$user_id = $this->router->get(1);
			//根据id获取用户资料详情并分配到模板
			$a_data = $this->user_model->get_user_one($user_id);
			$this->view->display('user_update', $a_data);
		}
	}

/*********************************** 禁用用户 ***********************************/

	public function user_forbid() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$user_id       = $this->general->post('user_id');
			$forbid_start  = $this->general->post('forbid_start');
			$forbid_end    = $this->general->post('forbid_end');
			$forbid_detail = trim($this->general->post('forbid_detail'));
			//将字符串转换成时间戳
			$forbid_start  = strtotime($forbid_start);
			$forbid_end    = strtotime($forbid_end);
			$forbid_long   = $forbid_end - $forbid_start;
			//将数据保存到数据库
			$a_data = [
				'user_id'       => $user_id,
				'forbid_time'   => $forbid_start,
				'forbid_end'    => $forbid_end,
				'forbid_long'   => $forbid_long,
				'forbid_detail' => $forbid_detail
			];
			$i_result = $this->user_model->insert_forbid($a_data);
			if ($i_result) {
				$this->error->show_success('禁用成功', 'user_showlist', false, 2);
			} else {
				$this->error->show_error('禁用失败', 'user_showlist', false, 2);
			}
		} else {
			//接收需要禁止用户的id
			$user_id = $this->router->get(1);
			$a_data = $this->user_model->get_user_one($user_id);
			$this->view->display('user_forbid', $a_data);
		}
	}

/*********************************** 删除用户 ***********************************/

	public function user_delete() {
		// $type 为1时代表单个删除 为2时代表批量删除
		$type = $this->general->post('type');
		if ($type==1) {
			$user_id = $this->general->post('user_id');
			$i_result = $this->user_model->delete_user_one($user_id);
			if ($i_result) {
				echo json_encode(array('code'=>200,'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>200,'msg'=>'删除失败'));
			}
		} else {
			$user_ids = $this->general->post('user_ids');
			$i_result = $this->user_model->delete_user_mony($user_ids);
			if ($i_result) {
				echo json_encode(array('code'=>200,'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>200,'msg'=>'删除失败'));
			}
		}
	}

/*********************************** 重置密码 ***********************************/

	public function user_repassword() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收用户提交的信息
			$user_id         = $this->general->post('user_id');
			$user_password   = trim($this->general->post('user_password'));
			$user_repassword = trim($this->general->post('user_repassword'));
			//验证数据
			if ($user_password != $user_repassword) {
				$this->error->show_error('两次密码不一致', 'user_repassword-'.$user_id, false, 2);
			}
			//验证密码长度是否合法
			if (strlen($user_password)<6 || strlen($user_password)>16) {
				$this->error->show_error('密码长度不合法', 'user_repassword-'.$user_id, false, 2);
			}
			//验证密码是否含有特殊符号
			$special_character = array('!','@','$','%','^','&','*','(',')','+','=','~','·','<','>',',','.','。','，','?','/','\\','|',':',';','[',']','【','】','{','}','"',"'",'`');
			//将用户名拆分为数组并循环匹配
			for ($i=0; $i<strlen($user_password); $i++) {
				$name_array[] = $user_password[$i];
			}
			for ($i=0; $i<count($name_array); $i++) {
				if (in_array($name_array[$i], $special_character)) {
					$this->error->show_error('密码不能含有特殊符号', 'user_repassword-'.$user_id, false, 2);
				}
			}
			//验证通过后将新密码保存到数据库
			$a_where = [
				'user_id' => $user_id
			];
			$a_data = [
				'user_password' => md5(md5($user_password))
			];
			$i_result = $this->user_model->update_password($a_where, $a_data);
			if ($i_result) {
				$this->error->show_success('重置密码成功', 'user_showlist', false, 2);
			} else {
				$this->error->show_error('重置密码失败', 'user_repassword-'.$user_id, false, 2);
			}
		} else {
			//接收需要重置密码的用户id
			$user_id = $this->router->get(1);
			$a_data = [
				'user_id' => $user_id
			];
			$this->view->display('user_repassword', $a_data);
		}
	}

/*********************************** 用户搜索 ***********************************/

	public function user_search() {
	    //接收关键词
	    $keywords = trim($this->general->post('keywords'));
	    if (empty($keywords)) {
	    	echo json_encode(array('code'=>400,'msg'=>'关键词不能为空'));
	    }
	    $a_data = $this->user_model->get_user_search($keywords);
	    if (!empty($a_data)) {
	    	echo json_encode($a_data);
	    }
	}

/*********************************** 用户开关 ***********************************/

	public function user_switch() {
		//接收参数
		$user_id = $this->general->post('user_id');
		//获取原状态
		$a_data = $this->user_model->get_user_one($user_id);
		if ($a_data['user_state']==0 || $a_data['user_state']==2) {
			$a_update_data = [
				'user_state' => 1,
			];
		} else {
			$a_update_data = [
				'user_state' => 2,
			];
		}
		$a_update_where = [
			'user_id' => $user_id,
		];
		$i_result = $this->user_model->update_user($a_update_where, $a_update_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'设置成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'设置失败'));
		}
	}

/********************************************************************************/

}

?>