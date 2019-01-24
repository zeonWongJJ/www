<?php

class Auth_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}
	
	public function verify() {
		if ( (! isset($_SESSION['store_id']) || ! isset($_SESSION['manager_id'])) && ! in_array($this->router->get_index(), ['login', 'logout', 'notify_wx'])) {
			header("Location: " . $this->router->url('login'));
			exit();
		}
	}
	
	public function login() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收登录信息
			$manager_name     = trim($this->general->post('manager_name'));
			$manager_password = trim($this->general->post('manager_password'));
			//验证数据合法性
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'login',
				'log'      => false,
				'wait'     => 2,
			];
			//验证必填项是否为空
			if (empty($manager_name) || empty($manager_password)) {
				$this->error->show_error($a_parameter);
			}
			//验证密码长度是否合法
			if (strlen($manager_password) < 6 || strlen($manager_password) > 16) {
				$a_parameter['msg'] = '密码长度不合法';
				$this->error->show_error($a_parameter);
			}
			//验证用户名是否存在
			$a_data = $this->db->get_row('manager', ['manager_name' => $manager_name]);
			if (empty($a_data)) {
				$a_parameter['msg'] = '账号不存在';
				$this->error->show_error($a_parameter);
			} else {
				//验证此账号是否停用
				if ($a_data['manager_state'] == 0) {
					$a_parameter['msg'] = '此账号已被停用';
					$this->error->show_error($a_parameter);
				}
				//用户名存在则验证密码是否正确
				if ($a_data['manager_password'] != md5(md5($manager_password))) {
					$a_parameter['msg'] = '登录密码不正确';
					$this->error->show_error($a_parameter);
				} else {
					// 获取门店信息
					$a_store = $this->db->get_row('store', ['store_id' => $a_data['store_id']]);
					//验证通过持久化相关数据并更新表字段
					$_SESSION['store_id']     = $a_store['store_id'];
					$_SESSION['store_name']     = $a_store['store_name'];
					$_SESSION['store_address'] = $a_store['store_address'];
					$_SESSION['store_position'] = $a_store['store_position'];
					$_SESSION['store_distribution_id'] = $a_store['distribution_id'];
					$_SESSION['manager_id']   = $a_data['manager_id'];
					$_SESSION['group_id']     = $a_data['group_id'];
					$_SESSION['manager_name'] = $a_data['manager_name'];
					$_SESSION['manager_type'] = $a_data['manager_type'];
					$_SESSION['store']   = $a_store;
					//更新门店管理员的最近登录信息
					$a_update_data = [
						'login_time' => $_SERVER['REQUEST_TIME'],
						'login_ip'   => $this->general->get_ip(),
					];
					$a_update_where = [
						'manager_id' => $a_data['manager_id'],
					];
					$i_result = $this->db->update('manager', $a_update_data, $a_update_where);
					if ($i_result) {
						$a_parameter['msg'] = '登录成功';
						$a_parameter['url'] = 'index';
						$this->error->show_success($a_parameter);
					} else {
						$a_parameter['msg'] = '登录失败';
						$this->error->show_error($a_parameter);
					}
				}
			}
		} else {
			$this->view->display('login');
		}
	}
	
	// 退出登录
	public function logout() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$b_result = session_destroy();
			if ($b_result) {
				$this->error->show_success('退出登录成功', 'login', false, 2);
			} else {
				$this->error->show_error('退出登录失败', 'index', false, 2);
			}
		}
	}

	/****
		返回当天的订单序列号，用于排数取餐
		return $s_ordersn 订单序列号
	***/
	public function  get_ordersn(){
		//删除昨天的文件
		$s_yst_filename = date("Ymd",strtotime("-1 day"));

		$yst_file = "{$s_yst_filename}.txt";		
		$this->unlinkss($yst_file);		

		$s_filename  = date("Ymd");
		$file = "{$s_filename}.txt"; 
		$this->mkdirs($file);  
		$fp = fopen($file , 'r'); 
		if(flock($fp , LOCK_SH | LOCK_NB)){    
		  	 $s_ordersn = fread($fp , 100);    
		   	 flock($fp , LOCK_UN);   
		} else {    
		    	return false;    
		}   
		fclose($fp);
		return $s_ordersn;
	}

	/****
		写入当天的订单序列号，用于排数取餐
		$s_ordersn 订单序列号
	***/	
	public function create_ordersn($s_ordersn) {
		$s_filename  = date("Ymd");
		$file = "{$s_filename}.txt";  
		$fp = fopen($file , 'w');    
		if(flock($fp , LOCK_EX)) {   
			rewind($fp); 
     		fwrite($fp , $s_ordersn);  
     		flock($fp , LOCK_UN);    
		}    
		fclose($fp);
	}
	/****
		判断文件是否存在，不在则创建
		$file 文件地址
		$mode 文件夹权限
	***/
	public function mkdirs($file, $mode = 0777) {
	    if (file_exists($file) ) return TRUE;
	    return fopen($file, "w");
	} 

	/****
		判断昨天的文件是否存在，在则删除
		$file 文件地址
		$mode 文件夹权限
	***/
	public function unlinkss($file, $mode = 0777) {
	    if (!file_exists($file) ) return TRUE;
	    return unlink($file);
	} 	

 

}

?>