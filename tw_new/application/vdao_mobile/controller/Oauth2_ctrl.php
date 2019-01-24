<?php

defined('BASEPATH') or exit('禁止访问！');

class Oauth2_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
	}

	// 创建一个令牌
	public function oauth2_token() {
		$this->db->insert('test', ['test_content'=>$_POST['redirect_uri']]);
		$my_client_id = $_POST['client_id'];
		$my_code = $_POST['code'];
		$a_where = [
			'client_id' => $my_client_id,
			'authorization_code' => $my_code,
		];
		$a_data = $this->db->get_row('oauth_authorization_codes', $a_where);
		$_POST['myUserId'] = $a_data['user_id'];
		// 引入服务器对象文件
		require_once( PROJECTPATH . '/libraries/OAuth2/myserver.php' );
		// Handle a request for an OAuth2.0 Access Token and send the response to the client
		$server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();
	}

	// 创建一个授权方法
	public function oauth2_authorize() {
		// 引入服务器对象文件
		require_once( PROJECTPATH . '/libraries/OAuth2/myserver.php' );
		$request = OAuth2\Request::createFromGlobals();
		$response = new OAuth2\Response();

		// validate the authorize request
		if (!$server->validateAuthorizeRequest($request, $response)) {
		    $response->send();
		    die;
		}
		// display an authorization form
		if (empty($_POST)) {
			$this->view->display('oauth2_authorize');
			die;
		} else {
			$this->load->model('login_model');
			$is_login = trim($this->general->post('is_login'));
			$is_authorized = trim($this->general->post('authorized'));
			if ($is_login == 2) {
				$name_or_tel = trim($this->general->post('user_name'));
				$user_password = trim($this->general->post('user_password'));
				$a_parameter = [
					'msg'      => '账号密码不能为空',
					'url'      => $this->router->get_url(),
					'log'      => false,
					'wait'     => 2,
				];
				// 验证是否为空
				if (empty($name_or_tel) || empty($user_password)) {
					$this->error->show_error($a_parameter);
				}
				//验证账号是否存在
				if (is_numeric($name_or_tel)) {
					//验证手机号码是否合法
					$check_phone = preg_match("/^1[34578]\d{9}$/", $name_or_tel);
					if ($check_phone) {
						//根据手机号码取出数据
						$type = 1;
						$a_data = $this->login_model->get_user_one($name_or_tel, $type);
					} else {
						$a_parameter['msg'] = '手机号码不合法';
						$this->error->show_error($a_parameter);
					}
				} else {
					//根据用户名取出数据
					$type = 2;
					$a_data = $this->login_model->get_user_one($name_or_tel, $type);
				}
				if (!$a_data) {
					$a_parameter['msg'] = '账号不存在';
					$this->error->show_error($a_parameter);
				}
				//账号存在 验证密码是否正确
				if ($a_data['user_password'] !== md5(md5($user_password))) {
					$a_parameter['msg'] = '密码不正确';
					$this->error->show_error($a_parameter);
				}
				//验证通过后持久化数据并更新相关字段
				$_SESSION['user_id']   = $a_data['user_id'];
				$_SESSION['user_name'] = $a_data['user_name'];
			}
		}

		if ($is_authorized == 'yes') {
			$userid = $_SESSION['user_id'];
			$server->handleAuthorizeRequest($request, $response, true, $userid);
			$response->send();
		} else {
			echo '授权失败';die;
		}
	}

	// 测试请求
	public function oauth2_six() {
		$this->load->model('oauth2_model');
		$token = $this->oauth2_model->oauth2_resource();
		if ($token) {
			$a_data = $this->oauth2_model->get_user_one($token['user_id']);
			echo json_encode(array($a_data));
		}
	}

	// 验证并获取用户信息
	public function oauth2_me() {
		// 引入服务器对象文件
		require_once( PROJECTPATH . '/libraries/OAuth2/myserver.php' );
		// Handle a request to a resource and authenticate the access token
		if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
		    $server->getResponse()->send();
		    die;
		}
		$a_where = [
			'access_token' => $_GET['access_token']
		];
		$my_token = $this->db->get_row('oauth_access_tokens', $a_where);
		$this->load->model('oauth2_model');
		$a_data = $this->oauth2_model->get_user_one($my_token['user_id']);
		echo json_encode($a_data);
	}

}

?>