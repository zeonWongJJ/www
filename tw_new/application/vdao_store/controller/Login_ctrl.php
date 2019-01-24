<?php

class Login_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('login_model');
	}

/*********************************** 门店管理员登录 ***********************************/

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
			$a_data = $this->login_model->get_manager_one($manager_name);
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
					$a_store = $this->login_model->get_store_one($a_data['store_id']);
					if ($a_store == false) {
						$a_parameter['msg'] = '门店不存在';
						$this->error->show_error($a_parameter);
					}
					if ($a_store['store_state'] != 1) {
						$a_parameter['msg'] = '该店已停用';
						$this->error->show_error($a_parameter);
					}
					//验证通过持久化相关数据并更新表字段
					$_SESSION['store_id']     = $a_data['store_id'];
					$_SESSION['manager_id']   = $a_data['manager_id'];
					$_SESSION['group_id']     = $a_data['group_id'];
					$_SESSION['manager_name'] = $a_data['manager_name'];
					$_SESSION['manager_type'] = $a_data['manager_type'];
					$_SESSION['store_name']   = $a_store['store_name'];
					//更新门店管理员的最近登录信息
					$a_update_data = [
						'login_time' => $_SERVER['REQUEST_TIME'],
						'login_ip'   => $this->general->get_ip(),
					];
					$a_update_where = [
						'manager_id' => $a_data['manager_id'],
					];
					$i_result = $this->login_model->update_manager($a_update_where, $a_update_data);
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
			$this->view->display('login2');
		}
	}


// 测试测试测试测试测试测试测试测试测试

public function oauth_test() {
	if (!empty($_GET['code']) && !empty($_GET['state'])) {
		// 如果授权码不为空 则去向认证服务器申请令牌
		// $data = $this->curl_post("http://wofei_wap.7dugo.com/oauth2_token.html", array('grant_type'=>'client_credentials','client_id'=>'7dugo', 'client_secret'=>'7dugocom', 'code'=>$_GET['code'], 'redirect_uri'=>'http://wofei_pc.7dugo.com/oauth_test.html'));
		// $data = $this->curl_post("http://wofei_wap.7dugo.com/oauth2_token.html", array('grant_type'=>'authorization_code','client_id'=>'7dugo', 'client_secret'=>'7dugocom', 'code'=>$_GET['code'], 'redirect_uri'=>'http://wofei_pc.7dugo.com/oauth_test.html'));
		$data = $this->curl_post("http://wofei4.com/oauth2_token.html", array('grant_type'=>'authorization_code','client_id'=>'7dugo', 'client_secret'=>'7dugocom', 'code'=>$_GET['code'], 'redirect_uri'=>'http://wofei3.com/oauth_test.html'));
		echo '<h1>授权成功</h1>';
		var_dump($data);
	}
}

function curl_post($url, $post){
	$options = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER         => false,
		CURLOPT_POST           => true,
		CURLOPT_POSTFIELDS     => $post,
	);
	$ch = curl_init($url);
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

public function oauth_two() {
	// 请求数据
	$a_data = $data = $this->curl_post("http://wofei_wap.7dugo.com/oauth2_six?access_token=5db9e01dcd784edde9a9c4e1b2e07840316e24e8", array());
	// $data = $this->curl_post("http://wofei4.com/oauth2_token.html", array('grant_type'=>'refresh_token','refresh_token'=>'03288ed9a747bba6c38f35166b60ecc127fb88c0'));
	// $data = $this->curl_post("http://wofei_wap.7dugo.com/oauth2_token.html", array('grant_type'=>'refresh_token','refresh_token'=>'03288ed9a747bba6c38f35166b60ecc127fb88c0'));
	echo "<pre>";
	var_dump($data);die;
	$this->view->display('oauth_two', $a_data);
}


/************************************** 退出登录 **************************************/

	public function loginout() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$b_result = session_destroy();
			if ($b_result) {
				$this->error->show_success('退出登录成功', 'login', false, 2);
			} else {
				$this->error->show_error('退出登录失败', 'index', false, 2);
			}
		}
	}

/**************************************************************************************/

	public function unionpay_refund_notify() {

	}

/********************************* 微信退款地址 ********************************/

	public function wxrefund_notify() {

	}


}

?>