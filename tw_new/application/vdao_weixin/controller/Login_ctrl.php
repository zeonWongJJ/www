<?php
defined('BASEPATH') or exit('禁止访问！');
class Login_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('login_model');
	}

/************************************* 会员登录 *************************************/

	public function login() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$name_or_tel = trim($this->general->post('name_or_tel'));
			$user_password = trim($this->general->post('user_password'));
			$oldurl = trim($this->general->post('oldurl'));
			if (!empty($oldurl)) {
				$a_parameter = [
					'msg'      => '密码长度不合法',
					'url'      => 'login?oldurl='.$oldurl,
					'log'      => false,
					'wait'     => 2,
				];
			} else {
				$a_parameter = [
					'msg'      => '密码长度不合法',
					'url'      => 'login',
					'log'      => false,
					'wait'     => 2,
				];
			}
			// 验证密码长度
			if (strlen($user_password) < 6 || strlen($user_password) > 16) {
				$this->error->show_error($a_parameter);
			}
			// 验证账号是否存在
			if (is_numeric($name_or_tel)) {
				//验证手机号码是否合法
				$check_phone = preg_match("/^1[34578]\d{9}$/", $name_or_tel);
				if ($check_phone) {
					// 根据手机号码取出数据
					$a_data = $this->login_model->get_user_one($name_or_tel, 1);
				} else {
					$a_parameter['msg'] = '手机号码不合法';
					$this->error->show_error($a_parameter);
				}
			} else {
				// 根据用户名取出数据
				$a_data = $this->login_model->get_user_one($name_or_tel, 2);
			}
			// 如果数据为真则账号存在 为假则账号不存在
			if ($a_data) {
				// 账号存在 验证密码是否正确
				if ($a_data['user_password'] !== md5(md5($user_password))) {
					$a_parameter['msg'] = '密码不正确';
					$this->error->show_error($a_parameter);
				}
				// 验证账号是否被停用
				if ($a_data['user_state'] == 2) {
					$a_parameter['msg'] = '账号已被管理员临时停用';
					$this->error->show_error($a_parameter);
				}
				// 验证通过后持久化数据并更新相关字段
				$_SESSION['user_id']   = $a_data['user_id'];
				$_SESSION['user_name'] = $a_data['user_name'];
				$a_update_where = [
					'user_id' => $a_data['user_id'],
				];
				$a_update_data = [
					'user_logtime' => $_SERVER['REQUEST_TIME'],
					'user_logip'   => $this->general->get_ip(),
				];
				$i_result = $this->login_model->update_user($a_update_where, $a_update_data);
				if ($i_result) {
					if (!empty($oldurl)) {
						$a_parameter['url'] = $oldurl;
					} else {
						$a_parameter['url'] = 'user_center';
					}
					$a_parameter['msg'] = '登录成功';
					$this->error->show_success($a_parameter);
				} else {
					$a_parameter['msg'] = '登录失败';
					$this->error->show_error($a_parameter);
				}
			} else {
				$a_parameter['msg'] = '该账号不存在';
				$this->error->show_error($a_parameter);
			}
		} else {
			$this->view->display('login3');
		}
	}

/************************************* QQ登录 *************************************/

	public function login_qq() {
		if (!empty($_GET['userid'])) {
			$_SESSION['myreferee'] = $_GET['userid'];
		}
		if (!empty($_GET['oldurl'])) {
			$_SESSION['oldurl'] = $_GET['oldurl'];
		}
		require_once(PROJECTPATH . "/libraries/qq/qqConnectAPI.php");
		$qc = new QC();
		$qc->qq_login();
	}

	public function qq_callback() {
		require_once(PROJECTPATH . "/libraries/qq/qqConnectAPI.php");
		$qc = new QC();
		$access_token = $qc->qq_callback();
		$openid = $qc->get_openid();
		$qc = new QC($access_token, $openid);
		$arr = $qc->get_user_info();
		//验证之前是否有登录过
		$a_parameter = [
			'msg'      => '登录成功',
			'url'      => 'login',
			'log'      => false,
			'wait'     => 2,
		];
		$a_data = $this->login_model->get_user_openid($openid);
		// 如果$a_data为真则存在账号 为假则不存存在账号
		if ($a_data) {
			// 验证是否是qq登录还是qq绑定
			if (isset($_SESSION['user_id'])) {
				$a_parameter['url'] = 'user_update';
				$a_parameter['msg'] = '绑定失败，此QQ号已被占用';
				$this->error->show_error($a_parameter);
				die;
			}
			// 存在则直接持久化数据并更新表字段
			$_SESSION['user_id']   = $a_data['user_id'];
			$_SESSION['user_name'] = $a_data['user_name'];
			$a_update_where = [
				'user_id' => $a_data['user_id'],
			];
			$a_update_data = [
				'user_logtime' => $_SERVER['REQUEST_TIME'],
				'user_logip'   => $this->general->get_ip(),
			];
			$i_result = $this->login_model->update_user($a_update_where, $a_update_data);
			if ($i_result) {
				if (isset($_SESSION['oldurl'])) {
					$a_parameter['url'] = $_SESSION['oldurl'];
					unset($_SESSION['oldurl']);
				} else {
					$a_parameter['url'] = 'user_center';
				}
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '登录失败';
				$this->error->show_error($a_parameter);
			}
		} else {
			// 为假则为登录 为真则为修改资料时绑定QQ
			if (isset($_SESSION['user_id'])) {
				$a_where_u = [
					'user_id' => $_SESSION['user_id']
				];
				$a_data_u = [
					'qq_openid'   => $openid,
					'update_time' => $_SERVER['REQUEST_TIME'],
				];
				$i_result = $this->login_model->update_user($a_where_u, $a_data_u);
				if ($i_result) {
					$a_parameter['url'] = 'user_update';
					$a_parameter['msg'] = '绑定成功';
					$this->error->show_success($a_parameter);
				} else {
					$a_parameter['url'] = 'user_update';
					$a_parameter['msg'] = '绑定失败';
					$this->error->show_error($a_parameter);
				}
			}
			// 将QQ的昵称去除特殊字符
			$user_name = preg_replace('|[^a-zA-Z0-9\x{4e00}-\x{9fa5}]|u', '', $arr['nickname']);
			// 检验是否占用，如果占用加上随机字符串
			$check_user_name = $this->login_model->get_user_one($name_or_tel, 2);
			if ($check_user_name) {
				$user_name = $arr['nickname'] . rand(100,999);
			}
			if (empty($user_name)) {
				$user_name = substr('qwertyuiopasdfghjklzxcvbnm', rand(0,21), 3) . rand(1111, 9999);
			}
			// 获取性别
			if ($arr['gender']=='男') {
				$user_sex = 1;
			} else if ($arr['gender']=='女') {
				$user_sex = 2;
			} else {
				$user_sex = 0;
			}
			// 获取城市
			if (!empty($arr['city'])) {
				$user_city = $arr['city'];
			} else {
				$user_city = '';
			}
			// 获取年龄
			if (!empty($arr['year'])) {
				$user_age = date('Y',time()) - $arr['year'];
			} else {
				$user_age = 0;
			}
			if (!empty($_SESSION['myreferee'])) {
				$user_referee = $_SESSION['myreferee'];
				// 不存在则为其注册一条信息
				$a_insert_data = [
					'user_name'     => $user_name,
					'user_sex'      => $user_sex,
					'user_age'      => $user_age,
					'user_city'     => $user_city,
					'user_referee'  => $user_referee,
					'user_regtime'  => $_SERVER['REQUEST_TIME'],
					'user_logtime'  => $_SERVER['REQUEST_TIME'],
					'user_regip'    => $this->general->get_ip(),
					'user_logip'    => $this->general->get_ip(),
					'user_pic'      => $arr['figureurl_1'],
					'qq_openid'     => $openid,
					'user_nickname' => $user_name,
				];
			} else {
				// 不存在则为其注册一条信息
				$a_insert_data = [
					'user_name'     => $user_name,
					'user_sex'      => $user_sex,
					'user_age'      => $user_age,
					'user_city'     => $user_city,
					'user_regtime'  => $_SERVER['REQUEST_TIME'],
					'user_logtime'  => $_SERVER['REQUEST_TIME'],
					'user_regip'    => $this->general->get_ip(),
					'user_logip'    => $this->general->get_ip(),
					'user_pic'      => $arr['figureurl_1'],
					'qq_openid'     => $openid,
					'user_nickname' => $user_name,
				];
			}
			// 将数据保存到user表
			$i_result = $this->login_model->insert_user($a_insert_data);
			if ($i_result) {
				// 持久化信息
				$_SESSION['user_id']   = $i_result;
				$_SESSION['user_name'] = $user_name;
				if (isset($_SESSION['oldurl'])) {
					$a_parameter['url'] = $_SESSION['oldurl'];
					unset($_SESSION['oldurl']);
				} else {
					$a_parameter['url'] = 'user_center';
				}
				if (isset($_SESSION['myreferee'])) {
					unset($_SESSION['myreferee']);
				}
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '登录失败';
				$this->error->show_error($a_parameter);
			}
		}
	}

/************************************* 退出登录 *************************************/

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

/************************************* 会员注册 *************************************/

	public function register() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收用户提交的注册信息
			$user_name      = trim($this->general->post('user_name'));
			$user_password  = trim($this->general->post('user_password'));
			$user_password2 = trim($this->general->post('user_password2'));
			$user_phone     = trim($this->general->post('user_phone'));
			$user_code      = trim($this->general->post('user_code'));
			$user_referee   = trim($this->general->post('user_referee'));
			// 验证数据合法性
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'login',
				'log'      => false,
				'wait'     => 2,
			];
			// 验证验证码是否存在
			if (!isset($_SESSION['code'])) {
				$a_parameter['msg'] = '请先获取验证码';
				$this->error->show_error($a_parameter);
			}
			// 验证验证码是否正确
			if ($user_code != $_SESSION['code']) {
				$a_parameter['msg'] = '验证码不正确';
				$this->error->show_error($a_parameter);
			}
			// 验证必填项是否为空
			if (empty($user_name) || empty($user_password) || empty($user_password2) || empty($user_phone)) {
				$this->error->show_error($a_parameter);
			}
			// 验证用户名长度
			if (strlen($user_name) < 6 || strlen($user_name) > 20) {
				$a_parameter['msg'] = '用户名长度不合法';
				$this->error->show_error($a_parameter);
			}
			// 验证两次密码是否一致
			if ($user_password != $user_password2) {
				$a_parameter['msg'] = '两次密码输入不一致';
				$this->error->show_error($a_parameter);
			}
			// 验证密码长度
			if (strlen($user_password) < 6 || strlen($user_password) > 20) {
				$a_parameter['msg'] = '密码长度不合法';
				$this->error->show_error($a_parameter);
			}
			// 验证用户名是否含有特殊字符
			$special_character = array('!','@','$','%','^','&','*','(',')','+','=','~','·','<','>',',','.','。','，','?','/','\\','|',':',';','[',']','【','】','{','}','"',"'",'`');
			// 将用户名拆分为数组并循环匹配
			for ($i=0; $i<strlen($user_name); $i++) {
				$name_array[] = $user_name[$i];
			}
			for ($i=0; $i<count($name_array); $i++) {
				if (in_array($name_array[$i], $special_character)) {
					$a_parameter['msg'] = '用户名不能含有特殊符号';
					$this->error->show_error($a_parameter);
				}
			}
			// 验证密码是否有特殊字符
			for ($i=0; $i<strlen($user_password); $i++) {
				$name_array[] = $user_password[$i];
			}
			for ($i=0; $i<count($name_array); $i++) {
				if (in_array($name_array[$i], $special_character)) {
					$a_parameter['msg'] = '密码不能含有特殊符号';
					$this->error->show_error($a_parameter);
				}
			}
			// 验证手机号码格式是否正确
            $check_user_phone = preg_match("/^1[34578]\d{9}$/", $user_phone);
            if (!$check_user_phone) {
				$a_parameter['msg'] = '手机号码格式不正确';
				$this->error->show_error($a_parameter);
            }
            // 验证手机号码是否被占用
            $check_phone_occupy = $this->login_model->get_phone_total($user_phone);
            if ($check_phone_occupy) {
				$a_parameter['msg'] = '当前手机号码已被占用';
				$this->error->show_error($a_parameter);
            }
			// 验证用户名是否被占用
			$check_name_occupy = $this->login_model->get_user_total($user_name);
			if ($check_name_occupy) {
				$a_parameter['msg'] = '用户名已被占用';
				$this->error->show_error($a_parameter);
			}
			// 所有验证通过后将数据保存到数据库
			$a_insert_data = [
				'user_name'     => $user_name,
				'user_phone'    => $user_phone,
				'user_password' => md5(md5($user_password)),
				'user_regtime'  => $_SERVER['REQUEST_TIME'],
				'user_regip'    => $this->general->get_ip(),
				'user_referee'  => $user_referee
			];
			// 将数据保存到user表
			$i_result = $this->login_model->insert_user($a_insert_data);
			if ($i_result) {
				$b_result = session_destroy();
				$a_parameter['msg'] = '注册成功';
				$a_parameter['url'] = 'login';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '注册失败';
				$this->error->show_error($a_parameter);
			}
		} else {
			$this->view->display('register');
		}
	}

/************************************* 微信登录 *************************************/

	public function wx_callback() {
		require_once(PROJECTPATH . "/libraries/weixin/config.php");

		$appid=WX_APPID;     //在开放平台创建应用后获取的
	    $appkey=WX_APPKEY;  //应用签名
	    $code=$_REQUEST['code'];//触发微信登录请求接口后返回的code参数
	    $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$appkey.'&code='.$code.'&grant_type=authorization_code';
	    // echo $url;

	    $data=file_get_contents($url);
	    $data=json_decode($data);
	    // print_r($data);

	    $access_token=$data->access_token;
	    $openid=$data->openid;

	    $url1='https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid;
	    $call=file_get_contents($url1);
	    $call=json_decode($call);

        // 无 access_token 缓存
        // openid存在，直接登录，openid不存在，先注册再登录
        // 获取从微信获取的用户信息
	    // $name=$call->nickname;
	    // $img=$call->headimgurl;
	    // $sex=$call->sex;
	    $openid=$call->openid;
	    // $unionid = $call->unionid;

		// 验证之前是否有登录过
		$a_parameter = [
			'msg'      => '登录成功',
			'url'      => 'login',
			'log'      => false,
			'wait'     => 2,
		];
		$a_data = $this->login_model->get_user_weixin($openid);
		//如果$a_data为真则存在账号 为假则不存存在账号
		if ($a_data) {
			//存在则直接持久化数据并更新表字段
			$_SESSION['user_id']   = $a_data['user_id'];
			$_SESSION['user_name'] = $a_data['user_name'];
			$a_update_where = [
				'user_id' => $a_data['user_id'],
			];
			$a_update_data = [
				'user_logtime' => $_SERVER['REQUEST_TIME'],
				'user_logip'   => $this->general->get_ip(),
			];
			$i_result = $this->login_model->update_user($a_update_where, $a_update_data);
			if ($i_result) {
				$a_parameter['url'] = 'user_center';
				$a_parameter['msg'] = '登录成功';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '登录失败';
				$this->error->show_error($a_parameter);
			}
		} else {
			// 为假则为登录 为真则为修改资料时绑定微信
			if (isset($_SESSION['user_id'])) {
				$a_where_u = [
					'user_id' => $_SESSION['user_id']
				];
				$a_data_u = [
					'weixin_openid' => $openid,
					'update_time'   => $_SERVER['REQUEST_TIME'],
				];
				$i_result = $this->login_model->update_user($a_where_u, $a_data_u);
				if ($i_result) {
					$a_parameter['url'] = 'user_update';
					$a_parameter['msg'] = '绑定成功';
					$this->error->show_success($a_parameter);
				} else {
					$a_parameter['url'] = 'user_update';
					$a_parameter['msg'] = '绑定失败';
					$this->error->show_error($a_parameter);
				}
			}
			//将WC的昵称去除特殊字符
			$user_name = preg_replace('|[^a-zA-Z0-9\x{4e00}-\x{9fa5}]|u', '', $call->nickname);
			//检验是否占用，如果占用加上随机字符串
			$type = 2;
			$check_user_name = $this->login_model->get_user_one($user_name, $type);
			if ($check_user_name) {
				$user_name = $user_name . rand(100,999);
			}
			//获取性别
			if ($call->sex=='男') {
				$user_sex = 1;
			} else if ($call->sex=='女') {
				$user_sex = 2;
			} else {
				$user_sex = 0;
			}
			// 获取城市
			if (!empty($call->city)) {
				$user_city = $call->city;
			} else {
				$user_city = '';
			}
			//获取年龄
			//if (!empty($arr['year'])) {
			//	$user_age = date('Y',time()) - $arr['year'];
			//} else {
				$user_age = 0;
			//}
			//不存在则为其注册一条信息
			$a_insert_data = [
				'user_name'     => $user_name,
				'user_sex'      => $user_sex,
				'user_age'      => $user_age,
				'user_city'     => $user_city,
				'user_regtime'  => $_SERVER['REQUEST_TIME'],
				'user_logtime'  => $_SERVER['REQUEST_TIME'],
				'user_regip'    => $this->general->get_ip(),
				'user_logip'    => $this->general->get_ip(),
				'user_pic'      => $call->headimgurl,
				'weixin_openid' => $openid,
				'user_nickname' => $user_name,
			];
			//将数据保存到user表
			$i_result = $this->login_model->insert_user($a_insert_data);
			if ($i_result) {
				//持久化信息
				$_SESSION['user_id']   = $i_result;
				$_SESSION['user_name'] = $user_name;
				$a_parameter['url'] = 'user_center';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '登录失败';
				$this->error->show_error($a_parameter);
			}
		}
	}

/************************************* 微博登录 *************************************/

	public function login_wb() {
		require_once(PROJECTPATH . "/libraries/weibo/config.php");
		require_once(PROJECTPATH . "/libraries/weibo/saetv2.ex.class.php");
		$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
		$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
	}

	public function wb_callback() {
		require_once(PROJECTPATH . "/libraries/weibo/config.php");
		require_once(PROJECTPATH . "/libraries/weibo/saetv2.ex.class.php");
		$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
		if (isset($_REQUEST['code'])) {
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = WB_CALLBACK_URL;
			try {
				$token = $o->getAccessToken( 'code', $keys ) ;
			} catch (OAuthException $e) {

			}
		}
		if ($token) {
			$_SESSION['token'] = $token;
			setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
		}
		$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
		$ms  = $c->home_timeline(); // done
		$uid_get = $c->get_uid();
		$uid = $uid_get['uid'];
		$user_message = $c->show_user_by_id($uid);
  		//根据微博的uid判断之前是否有登录
  		$a_data = $this->login_model->get_user_uid($uid);
  		$a_parameter = [
  			'msg'      => '登录成功',
  			'url'      => 'login',
  			'log'      => false,
  			'wait'     => 2,
  		];
  		if ($a_data) {
  			$_SESSION['user_id'] = $a_data['user_id'];
  			$_SESSION['user_name'] = $a_data['user_name'];
			$a_update_data = [
				'user_logtime' => $_SERVER['REQUEST_TIME'],
				'user_logip'   => $this->general->get_ip(),
			];
			$i_result = $this->login_model->update_user($a_update_where, $a_update_data);
			if ($i_result) {
  				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '登录失败';
				$this->error->show_error($a_parameter);
			}
  		} else {
  			$user_name = $user_message['screen_name'];
  			$a_insert_data = [
				'user_name'    => $user_name,
				'weibo_uid'    => $uid,
				'user_regtime' => $_SERVER['REQUEST_TIME'],
				'user_logtime' => $_SERVER['REQUEST_TIME'],
				'user_regip'   => $this->general->get_ip(),
				'user_logip'   => $this->general->get_ip(),
				'user_pic'     => $user_message['profile_image_url'],
  			];
  			$i_result = $this->login_model->insert_user($a_insert_data);
  			if ($i_result) {
  				$_SESSION['user_id'] = $i_result;
  				$_SESSION['user_name'] = $user_name;
  				$a_parameter['url'] = 'index';
  				$this->error->show_success($a_parameter);
  			} else {
  				$a_parameter['msg'] = '登录失败';
  				$this->error->show_error($a_parameter);
  			}
  		}
	}

/************************************* 找回密码 *************************************/

	public function reset_password() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收数据
			$user_phone    = trim($this->general->post('user_phone'));
			$user_code     = trim($this->general->post('user_code'));
			$user_password = trim($this->general->post('user_password'));
			// 验证数据合法性
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'reset_password',
				'log'      => false,
				'wait'     => 2,
			];
			// 验证必填项是否为空
			if (empty($user_phone) || empty($user_code) || empty($user_password)) {
				$this->error->show_error($a_parameter);
			}
			// 验证验证码是否正确
			if ($_SESSION['code'] != $user_code) {
				$a_parameter['msg'] = '验证码不正确';
				$this->error->show_error($a_parameter);
			}
			// 验证手机号码是否正确
			if ($_SESSION['user_phone'] != $user_phone) {
				$a_parameter['msg'] = '手机号码不正确';
				$this->error->show_error($a_parameter);
			}
			// 特殊字符
			$special_character = array('!','@','#','$','%','^','&','*','(',')','+','=','~','·','<','>',',','.','。','，','?','/','\\','|',':',';','[',']','【','】','{','}','"',"'",'`');
			// 验证密码是否有特殊字符
			for ($i=0; $i<strlen($user_password); $i++) {
				$name_array[] = $user_password[$i];
			}
			for ($i=0; $i<count($name_array); $i++) {
				if (in_array($name_array[$i], $special_character)) {
					$a_parameter['msg'] = '密码不能含有特殊符号';
					$this->error->show_error($a_parameter);
				}
			}
			// 验证密码长度
			if (strlen($user_password) < 6 || strlen($user_password)>16) {
				$a_parameter['msg'] = '密码长度须为6-16位';
				$this->error->show_error($a_parameter);
			}
			// 验证账号是否存在
			$a_data = $this->login_model->get_user_one($user_phone,1);
			if (!$a_data) {
				$a_parameter['msg'] = '账号不存在';
				$this->error->show_error($a_parameter);
			} else {
				// 验证与之前密码是否一致
				if ($a_data['user_password'] == md5(md5($user_password))) {
					$b_result = session_destroy();
	  				$a_parameter['url'] = 'login';
	  				$a_parameter['msg'] = '重置密码成功';
	  				$this->error->show_success($a_parameter);
				}
			}
			// 判断是否是登录后重置还是未登录时忘记密码
			if (isset($_SESSION['user_id'])) {
				// 验证通过后则将新的密码保存到数据库
				$a_where = [
					'user_id' => $_SESSION['user_id'],
				];
			} else {
				$a_where = [
					'user_phone' => $user_phone,
				];
			}
			$a_update_data = [
				'user_password' => md5(md5($user_password))
			];
			$i_result = $this->login_model->update_user($a_where, $a_update_data);
			if ($i_result) {
				$b_result = session_destroy();
  				$a_parameter['url'] = 'login';
  				$a_parameter['msg'] = '重置密码成功';
  				$this->error->show_success($a_parameter);
			} else {
  				$a_parameter['msg'] = '重置密码失败';
  				$this->error->show_error($a_parameter);
			}
		} else {
			$this->view->display('reset_password');
		}
	}

/*********************************** APP微信登录 ***********************************/

	public function login_weixin() {
		$response = $this->general->post('response');
		$response = json_decode($response, true);
		// 取出openid
		$openid = $response['openid'];
		// 查询数据库验证是否有此openid 有则持久化信息 无则创建一条用户信息
		$a_data = $this->login_model->get_user_weixin($openid);
		// 如果$a_data为真则存在账号 为假则不存存在账号
		if ($a_data) {
			if (isset($_SESSION['user_id'])) {
				// 此处为绑定时
				echo json_encode(array('code'=>400, 'msg'=>'此微信已被占用'));
				die;
			} else {
				//存在则直接持久化数据并更新表字段
				$_SESSION['user_id']   = $a_data['user_id'];
				$_SESSION['user_name'] = $a_data['user_name'];
				$a_update_where = [
					'user_id' => $a_data['user_id'],
				];
				$a_update_data = [
					'user_logtime' => $_SERVER['REQUEST_TIME'],
					'user_logip'   => $this->general->get_ip(),
				];
				$i_result = $this->login_model->update_user($a_update_where, $a_update_data);
				echo json_encode(array('code'=>200,'msg'=>'登录成功'));
				die;
			}
		} else {
			// 为假则为登录 为真则为修改资料时绑定微信
			if (isset($_SESSION['user_id'])) {
				$a_where_u = [
					'user_id' => $_SESSION['user_id']
				];
				$a_data_u = [
					'weixin_openid' => $openid,
					'update_time'   => $_SERVER['REQUEST_TIME'],
				];
				$i_result = $this->login_model->update_user($a_where_u, $a_data_u);
				if ($i_result) {
					echo json_encode(array('code'=>200, 'msg'=>'绑定成功'));
					die;
				} else {
					echo json_encode(array('code'=>400, 'msg'=>'绑定失败'));
					die;
				}
			}
			// 将WC的昵称去除特殊字符
			$user_name = preg_replace('|[^a-zA-Z0-9\x{4e00}-\x{9fa5}]|u', '', $response['nickname']);
			// 检验是否占用，如果占用加上随机字符串
			$type = 2;
			$check_user_name = $this->login_model->get_user_one($user_name, $type);
			if ($check_user_name) {
				$user_name = $user_name . rand(100,999);
			}
			// 不存在则为其注册一条信息
			$a_insert_data = [
				'user_name'     => $user_name,
				'user_sex'      => $response['sex'],
				'user_city'     => $response['city'],
				'user_regtime'  => $_SERVER['REQUEST_TIME'],
				'user_logtime'  => $_SERVER['REQUEST_TIME'],
				'user_regip'    => $this->general->get_ip(),
				'user_logip'    => $this->general->get_ip(),
				'user_pic'      => $response['headimgurl'],
				'weixin_openid' => $openid,
				'user_nickname' => $user_name,
			];
			// 将数据保存到user表
			$i_result = $this->login_model->insert_user($a_insert_data);
			if ($i_result) {
				// 持久化信息
				$_SESSION['user_id']   = $i_result;
				$_SESSION['user_name'] = $user_name;
				echo json_encode(array('code'=>200,'msg'=>'登录成功'));
				die;
			} else {
				echo json_encode(array('code'=>400,'msg'=>'登录失败'));
				die;
			}
		}
	}

/************************************************************************************/

}

?>