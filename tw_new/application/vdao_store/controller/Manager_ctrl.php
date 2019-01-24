<?php
defined('BASEPATH') or exit('禁止访问！');
class Manager_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('manager_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/***************************************** 管理员列表 *****************************************/

	public function manager_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 获取门店所有管理员信息
			$a_data['manager'] = $this->manager_model->get_manager_showlist();
			// 获取所有分组信息
			$a_data['group'] = $this->manager_model->get_group_all();
			$this->view->display('manager_showlist2', $a_data);
		}
	}

/***************************************** 添加管理员 *****************************************/

	public function manager_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收提交的信息
			$manager_name      = trim($this->general->post('manager_name'));
			$manager_password  = trim($this->general->post('manager_password'));
			$manager_password2 = trim($this->general->post('manager_password2'));
			$manager_phone     = trim($this->general->post('manager_phone'));
			$manager_email     = trim($this->general->post('manager_email'));
			$manager_realname  = trim($this->general->post('manager_realname'));
			$manager_sex       = trim($this->general->post('sex'));
			$group_id          = trim($this->general->post('group_id'));
			// 验证数据合法性
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'manager_showlist',
				'log'      => false,
				'wait'     => 2,
			];
			// 验证必填项是否为空
			if (empty($manager_name) || empty($manager_password) || empty($group_id) || empty($manager_password2)) {
				$this->error->show_error($a_parameter);
			}
			// 验证密码长度是否合法
			if (strlen($manager_password) < 6 || strlen($manager_password) > 16) {
				$a_parameter['msg'] = '密码长度必须为6-16位';
				$this->error->show_error($a_parameter);
			}
			// 验证两次密码是否一致
			if ($manager_password != $manager_password2) {
				$a_parameter['msg'] = '两次密码输入不一致';
				$this->error->show_error($a_parameter);
			}
			// 验证手机号码是否正确
			if (!empty($manager_phone)) {
				//验证手机号码格式是否正确
	            $check_phone = preg_match("/^1[34578]\d{9}$/", $manager_phone);
	            if (!$check_phone) {
					$a_parameter['msg'] = '手机号码格式不正确';
					$this->error->show_error($a_parameter);
	            }
			}
			// 验证邮箱是否正确
			if (!empty($manager_email)) {
				$check_email = $this->general->is_mail($manager_email);
				if (!$check_email) {
					$a_parameter['msg'] = '邮箱格式不正确';
					$this->error->show_error($a_parameter);
				}
			}
			// 验证密码是否含有特殊字符
			$special_character = array('!','@','$','%','^','&','*','(',')','+','=','~','·','<','>',',','.','。','，','?','/','\\','|',':',';','[',']','【','】','{','}','"',"'",'`');
			//将密码拆分为数组并循环匹配
			for ($i=0; $i<strlen($manager_password); $i++) {
				$name_array[] = $manager_password[$i];
			}
			for ($i=0; $i<count($name_array); $i++) {
				if (in_array($name_array[$i], $special_character)) {
					$a_parameter['msg'] = '密码不能含有特殊符号';
					$this->error->show_error($a_parameter);
				}
			}
			// 验证用户名是否被占用
			$i_total = $this->manager_model->get_manager_total($manager_name);
			if ($i_total) {
				$a_parameter['msg'] = '用户名已被占用，请更换';
				$this->error->show_error($a_parameter);
			}
			// 获取密码强度
			$manager_safe = $this->manager_safe($manager_password);
			// 验证成功后组装数据并保存到数据
			$a_data = [
				'manager_name'     => $manager_name,
				'manager_password' => md5(md5($manager_password)),
				'manager_phone'    => $manager_phone,
				'manager_email'    => $manager_email,
				'group_id'         => $group_id,
				'store_id'         => $_SESSION['store_id'],
				'register_time'    => $_SERVER['REQUEST_TIME'],
				'manager_safe'     => $manager_safe,
				'manager_realname' => $manager_realname,
				'manager_sex'      => $manager_sex
			];
			$i_result = $this->manager_model->insert_manager($a_data);
			if ($i_result) {
				// 刷新对应分组的管理员总数
				$i_total = $this->manager_model->get_manager_count($group_id);
				$a_where = [
					'group_id' => $group_id
				];
				$a_data = [
					'manager_count' => $i_total
				];
				$this->manager_model->update_group($a_where, $a_data);
				$a_parameter['msg'] = '添加管理员成功';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '添加管理员失败';
				$this->error->show_error($a_parameter);
			}
		} else {
			// 获取所有分级信息
			$a_data = $this->manager_model->get_group_all();
			$this->view->display('manager_add', $a_data);
		}
	}

/***************************************** 删除管理员 *****************************************/

	public function manager_delete() {
		// type为1代表单个删除 type为2代表批量删除
		$type = trim($this->general->post('type'));
		if ($type==1) {
			// 接收需要删除的管理员id
			$manager_id = $this->general->post('manager_id');
			$i_result = $this->manager_model->delete_manager_one($manager_id);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
			}
		} else {
			// 接收需要删除的管理员id数组
			$manager_ids = $this->general->post('manager_ids');
			$i_result = $this->manager_model->delete_manager_maony($manager_ids);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
			}
		}
	}

/***************************************** 修改管理员 *****************************************/

	public function manager_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收提交的信息
			$manager_id        = trim($this->general->post('manager_id'));
			$manager_name      = trim($this->general->post('manager_name'));
			$manager_realname  = trim($this->general->post('manager_realname'));
			$manager_sex       = trim($this->general->post('manager_sex'));
			$manager_password  = trim($this->general->post('manager_password'));
			$manager_password2 = trim($this->general->post('manager_password2'));
			$manager_phone     = trim($this->general->post('manager_phone'));
			$manager_email     = trim($this->general->post('manager_email'));
			$group_id          = trim($this->general->post('group_id'));
			$original_name     = trim($this->general->post('original_name'));
			$original_group    = trim($this->general->post('original_group'));
			// 验证数据合法性
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'manager_showlist',
				'log'      => false,
				'wait'     => 2,
			];
			// 验证必填项是否为空
			if (empty($manager_name) || empty($group_id)) {
				$this->error->show_error($a_parameter);
			}
			// 验证手机号码是否正确
			if (!empty($manager_phone)) {
				//验证手机号码格式是否正确
	            $check_phone = preg_match("/^1[34578]\d{9}$/", $manager_phone);
	            if (!$check_phone) {
					$a_parameter['msg'] = '手机号码格式不正确';
					$this->error->show_error($a_parameter);
	            }
			}
			// 验证邮箱是否正确
			if (!empty($manager_email)) {
				$check_email = $this->general->is_mail($manager_email);
				if (!$check_email) {
					$a_parameter['msg'] = '邮箱格式不正确';
					$this->error->show_error($a_parameter);
				}
			}
			// 验证用户名是否被占用
			if ($manager_name != $original_name) {
				$i_total = $this->manager_model->get_manager_total($manager_name);
				if ($i_total) {
					$a_parameter['msg'] = '用户名已被占用，请更换';
					$this->error->show_error($a_parameter);
				}
			}
			$a_where = [
				'manager_id' => $manager_id
			];
			// 如果密码为空则直接组装数据 如果不为空则先验证再组装
			if (empty($manager_password)) {
				// 验证成功后组装数据并保存到数据
				$a_data = [
					'manager_name'     => $manager_name,
					'manager_phone'    => $manager_phone,
					'manager_email'    => $manager_email,
					'group_id'         => $group_id,
					'store_id'         => $_SESSION['store_id'],
					'manager_realname' => $manager_realname,
					'manager_sex'      => $manager_sex,
					'update_time'      => $_SERVER['REQUEST_TIME'],
				];
			} else {
				// 验证密码长度是否合法
				if (strlen($manager_password) < 6 || strlen($manager_password) > 16) {
					$a_parameter['msg'] = '密码长度必须为6-16位';
					$this->error->show_error($a_parameter);
				}
				// 验证密码是否含有特殊字符
				$special_character = array('!','@','$','%','^','&','*','(',')','+','=','~','·','<','>',',','.','。','，','?','/','\\','|',':',';','[',']','【','】','{','}','"',"'",'`');
				//将密码拆分为数组并循环匹配
				for ($i=0; $i<strlen($manager_password); $i++) {
					$name_array[] = $manager_password[$i];
				}
				for ($i=0; $i<count($name_array); $i++) {
					if (in_array($name_array[$i], $special_character)) {
						$a_parameter['msg'] = '密码不能含有特殊符号';
						$this->error->show_error($a_parameter);
					}
				}
				// 获取密码强度
				$manager_safe = $this->manager_safe($manager_password);
				// 验证成功后组装数据并保存到数据
				$a_data = [
					'manager_name'     => $manager_name,
					'manager_password' => md5(md5($manager_password)),
					'manager_phone'    => $manager_phone,
					'manager_email'    => $manager_email,
					'group_id'         => $group_id,
					'store_id'         => $_SESSION['store_id'],
					'manager_realname' => $manager_realname,
					'manager_safe'     => $manager_safe,
					'manager_sex'      => $manager_sex,
					'update_time'      => $_SERVER['REQUEST_TIME'],
				];
			}
			$i_result = $this->manager_model->update_manager($a_where, $a_data);
			if ($i_result) {
				// 刷新对应分组的管理员总数
				// 判断分组信息是否改变
				if ($original_group != $group_id) {
					// 更新现分组管理员总数
					$i_total = $this->manager_model->get_manager_count($group_id);
					$a_where = [
						'group_id' => $group_id
					];
					$a_data = [
						'manager_count' => $i_total
					];
					$this->manager_model->update_group($a_where, $a_data);
					// 更新旧分组管理员总数
					$i_total = $this->manager_model->get_manager_count($original_group);
					$a_where = [
						'group_id' => $original_group
					];
					$a_data = [
						'manager_count' => $i_total
					];
					$this->manager_model->update_group($a_where, $a_data);
				}
				$a_parameter['msg'] = '修改管理员成功';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '修改管理员失败';
				$this->error->show_error($a_parameter);
			}
		} else {
			// 接收需要修改的管理员信息
			$manager_id = $this->router->get(1);
			// 获取原数据
			$a_data['detail'] = $this->manager_model->get_manager_one($manager_id);
			// 获取分组信息
			$a_data['group'] = $this->manager_model->get_group_all();
			$this->view->display('manager_update2', $a_data);
		}
	}

/**************************************** 启用停用开关 ****************************************/

	public function manager_switch() {
		// 接收id
		$manager_id = $this->general->post('manager_id');
		// 获取原数据
		$a_data = $this->manager_model->get_manager_one($manager_id);
		$a_where = [
			'manager_id' => $manager_id
		];
		if ($a_data['manager_state']==1) {
			$a_update_data = [
				'manager_state' => 0
			];
		} else {
			$a_update_data = [
				'manager_state' => 1
			];
		}
		$i_result = $this->manager_model->update_manager($a_where, $a_update_data);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'设置成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'设置失败'));
		}
	}

/***************************************** 搜索管理员 *****************************************/

	public function manager_search() {
		$keywords = trim($this->general->post('keywords'));
		if (empty($keywords)) {
			echo json_encode(array('code'=>400, 'msg'=>'关键词不能为空', 'data'=>''));
			die;
		}
		$a_data = $this->manager_model->get_manager_search($keywords);
		if (empty($a_data)) {
			echo json_encode(array('code'=>500, 'msg'=>'未搜索到任何数据', 'data'=>''));
			die;
		} else {
			foreach ($a_data as $key => $value) {
				$value['register_time'] = date('Y-m-d', $value['register_time']);
				if ($value['manager_sex'] == 1) {
					$value['manager_sex'] = '男';
				} else {
					$value['manager_sex'] = '女';
				}
				$new_data[] = $value;
			}
			echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$new_data));
		}
	}

/**************************************** 账号安全等级 ****************************************/

	public function manager_safe($str) {
       $score = 0;
       if(preg_match("/[0-9]+/",$str))
       {
          $score ++;
       }
       if(preg_match("/[0-9]{3,}/",$str))
       {
          $score ++;
       }
       if(preg_match("/[a-z]+/",$str))
       {
          $score ++;
       }
       if(preg_match("/[a-z]{3,}/",$str))
       {
          $score ++;
       }
       if(preg_match("/[A-Z]+/",$str))
       {
          $score ++;
       }
       if(preg_match("/[A-Z]{3,}/",$str))
       {
          $score ++;
       }
       if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/",$str))
       {
          $score += 2;
       }
       if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]{3,}/",$str))
       {
          $score ++ ;
       }
       if(strlen($str) >= 10)
       {
          $score ++;
       }
       return $score;
	}

/**********************************************************************************************/


}

?>