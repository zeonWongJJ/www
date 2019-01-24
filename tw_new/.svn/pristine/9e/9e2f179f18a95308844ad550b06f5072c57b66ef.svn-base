<?php
defined('BASEPATH') OR exit('禁止访问！');
header('content-type:text/html;charset=utf-8;');
date_default_timezone_set('PRC');
class Home_ctrl extends TW_Controller {
	
	public function __construct() {
		parent :: __construct();
		
		$this->load->model('user_model');
	}

	public function index()	{
		$this->view->display('index');
	}
	
	/**
	 * wap登录页面
	 */
	public function login()	{
		$i_ip = $_SERVER["REMOTE_ADDR"];
		$back_url = $this->router->get('1');
		if ( ! empty($back_url) ) {
			$back_url = $this->general->base64_convert($back_url, true);
		} else {
			$back_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->router->url('index');
		}
		$_SESSION['back_url'] = $back_url;
		
		if (isset($_SESSION['user_id']) && ! empty($_SESSION['user_id'])) {
			$this->error->show_warning('您已经登录！', $_SESSION['back_url'], '',0);
		}
		$a_data = $this->db->get('member', ['member_login_ip' => $i_ip,'member_name >' => $_SESSION['member_na']], ['member_name'],['member_time_login' => 'desc'], 0,3);
		$this->view->display('login', $a_data);
	}

	//android登录页面
	public function login_android()	{
		$back_url = $this->router->get('1');
		if ( ! empty($back_url) ) {
			$back_url = $this->general->base64_convert($back_url, true);
		} else {
			$back_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->router->url('index');
		}
		$_SESSION['back_url'] = $back_url;
		
		if (isset($_SESSION['user_id']) && ! empty($_SESSION['user_id'])) {
			$this->error->show_warning('您已经登录！', $_SESSION['back_url'], '',0);
		}
		$a_data = $this->db->get('member', ['member_login_ip' => $i_ip], ['member_name'],['member_time_login' => 'desc'], 0,3);
		$this->view->display('login_android', $a_data);
	}

	//ios登录页面
	public function login_ios()	{
		$i_ip = $_SERVER["REMOTE_ADDR"];
		$back_url = $this->router->get('1');
		if ( ! empty($back_url) ) {
			$back_url = $this->general->base64_convert($back_url, true);
		} else {
			$back_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->router->url('index');
		}
		$_SESSION['back_url'] = $back_url;
		
		if (isset($_SESSION['user_id']) && ! empty($_SESSION['user_id'])) {
			$this->error->show_warning('您已经登录！', $_SESSION['back_url'], '',0);
		}
		$a_data = $this->db->get('member', ['member_login_ip' => $i_ip,'member_name >' => $_SESSION['member_na']], ['member_name'],['member_time_login' => 'desc'], 0,3);
		$this->view->display('login_ios', $a_data);
	}

	/**
	 * QQ首页
	 */
	public function qq_index() {
		require_once( PROJECTPATH . "/libraries/qqlogin/qqConnectAPI.php");
		$qc = new QC();
		$qc->qq_login();
	}

	/**
	 * QQ回调地址并QQ单点登陆
	 */
	public function qq_callback() {
		require_once( PROJECTPATH . "/libraries/qqlogin/qqConnectAPI.php");
		$qc = new QC();  
		$acs = $qc->qq_callback();  
		$oid = $qc->get_openid();  
		$qc = new QC($acs,$oid);  
		$arr = $qc->get_user_info();
		$_SESSION['user_name'] = $arr['nickname'];
		$this->user_model->qqlogin($_SESSION['openid'],$arr['figureurl_qq_1']);
	}

	/**
	 * 登录提交信息处理
	 */
	public function login_auth() {
		$s_name = $this->general->post('username');
		$s_pwd = $this->general->post('passwd');
		$a_id_equipment = $this->general->post('id_equipment');
		if (empty($s_name) || empty($s_pwd)) {
			echo json_encode(array(
				"code" => 23,
				"memberName" => $s_name,
			));			
			die;
		}
		$i_keep = $this->general->post('keep') == 'on' ? 2592000 : 0;
		$a_rs = $this->db->where_or(['member_name' => $s_name, 'member_mobile' => $s_name])->get_row('member');
		if (! empty($a_rs) && $a_rs['member_passwd'] == md5($s_pwd)) {
			if ( ! $s_token = $this->user_model->sso_save_token($a_rs['member_id'], $a_rs['member_name'], $a_rs['member_passwd'], 31536000) ) {
				echo json_encode(array(
					"code" => 24,
				));
				die;
			}
			$this->general->set_cookie('user_id', $a_rs['member_id'], $i_keep);
			$this->general->set_cookie('user_name', $a_rs['member_name'], $i_keep);
			$_SESSION['user_id'] = $a_rs['member_id'];
			$_SESSION['user_name'] = $a_rs['member_name'];
			$_SESSION['username'] = $a_rs['member_name'];
			$a_data = [
				'member_time_old_login' => $a_rs['member_time_login'],
				'member_time_login' => $_SERVER['REQUEST_TIME'],
				'member_old_login_ip' => $a_rs['member_login_ip'],
				'member_login_ip' => $_SERVER["REMOTE_ADDR"]
			];
			$a_where = ['member_id' => $a_rs['member_id']];
			$this->db->update('member', $a_data, $a_where);
			echo json_encode(array(
				"code" => 25,
		 		"memberName" => $_SESSION['user_name'],
		 		"memberId" => $_SESSION['user_id'],
		 		"equipmentId" => $a_id_equipment
		 	));
		} else {
			echo json_encode(array(
				"code" => 26,
			));
		}
	}

	//验证码登录
	public function login_code() {
		$s_mobile = $this->general->post('mobile');
		$i_verify = $this->general->post('verify');
		$a_member = $this->db->get('member', ['member_mobile' => $s_mobile]);
		if (empty($s_mobile) || ! preg_match("/^1[34578]\d{9}$/", $s_mobile)) {
			echo 52;
			die;
		}
		if (empty($i_verify)) {
			echo 53;
			die;
		}
		//判断验证码是否正确
		$this->load->model('reset_model');
		$i_rand = $this->reset_model->pass_pwd($i_verify); 

		//判断有无该手机
		if(empty($a_member)) {
			//随机生成密码
		    $s_randpwd  = "";
		    for ( $i = 0; $i < 8; $i++ ) {
		        $s_randpwd  .= $chars[mt_rand(0, strlen($chars))];
		    }
			// 保存注册数据
			$a_data = [
				'member_name' => $s_mobile,
				'member_passwd' => md5($s_randpwd),
				'member_time' => $_SERVER['REQUEST_TIME'],
				'member_time_login' => $_SERVER['REQUEST_TIME'],
				'member_login_ip' => $_SERVER["REMOTE_ADDR"]
			];
			if ($i_id = $this->db->insert('member', $a_data)) {
				//同步登录
				$s_token = $this->user_model->sso_save_token($i_id, $a_data['member_name'], $a_data['member_passwd']);
				$this->general->set_cookie('user_id', $i_id);
				$this->general->set_cookie('user_name', $a_data['member_name']);
				$_SESSION['user_id'] = $i_id;
				$_SESSION['user_name'] = $a_data['member_name'];
				// $this->error->show_success('欢迎' . $_SESSION['user_name'] . '回来！' . $this->user_model->sso_script($s_token), 'index');
				echo 51;
			}
		} else {
			//同步登录
			$s_token = $this->user_model->sso_save_token($a_member[0]['member_id'], $a_member[0]['member_name'],  $a_member[0]['member_passwd']);
			$this->general->set_cookie('user_id', $a_member[0]['member_id']);
			$this->general->set_cookie('user_name', $a_member[0]['member_name']);
			$_SESSION['user_id'] = $a_member[0]['member_id'];
			$_SESSION['user_name'] = $a_member[0]['member_name'];
			// $this->error->show_success('欢迎' . $_SESSION['user_name'] . '回来！' . $this->user_model->sso_script($s_token), 'index');
			echo 51;
		}
	}
	
	/**
	 * 退出
	 */
	public function logout() {
		if ( ! isset($_SESSION['user_id']) ) {
			$this->error->show_error('请先登录！', $this->router->url('login', [$this->general->base64_convert($this->router->url('index'))]), '', 0);
		}
		$a_rs = $this->db->get_row('member', ['member_id' => $_SESSION['user_id']]);
		if ( ! $s_token = $this->user_model->sso_save_token($a_rs['member_id'], $a_rs['member_name'], $a_rs['member_passwd'], 31536000) ) {
			$this->error->show_error('注销失败！');
		}
		
		$this->general->set_cookie('user_id', '', -99999999999);
		$this->general->set_cookie('user_name', '', -99999999999);
		unset($_SESSION['user_id']);
		unset($_SESSION['user_name']);
		
		unset($_SESSION['back_url']);
		
		$this->error->show_success('注销成功！' . $this->user_model->sso_script($s_token, 'logout'), $this->router->url('index'), '', 0);
	}

	//一键注册（副本）
	public function register() {
		$this->view->display('register');
	}
	//发送返回已注册
	public function fail() {
		$this->view->display('fail');
	}
	//注册成功
	public function success() {
		$this->view->display('success');
	}
	//发送返回已注册
	public function again() {
		$this->view->display('again');
	}
	//发送返回已注册
	public function reminder() {
		$this->view->display('reminder');
	}
	//一键注册
	public function key_register() {
		$a_id_equipment = $this->general->post('id_equipment');
		$a_ip_create = $_SERVER["REMOTE_ADDR"];
		$a_member = $this->db->get_row('member', ['id_equipment' => $a_id_equipment]);
		$a_memb = $this->db->get_row('member', ['ip_create' => $a_ip_create, 'member_time >' => strtotime(date("Y-m-d"))]);
		//判断ip或id有没有
		if (empty($a_memb)) {
			//随机生成
			$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			//用户名
		    $s_username = "";
		    for ( $i = 0; $i < 8; $i++ ) {
		        $s_username .= $chars[mt_rand(0, strlen($chars))];
		    }
		    // 用户重复性验证
			$a_rs = $this->db->get_row('member', ['member_name' => '7du_'.$s_username], 'member_id');
			if ( ! empty($a_rs['member_id'])) {
				for ( $i = 0; $i < 8; $i++ ) {
		        	$s_username .= $chars[mt_rand(0, strlen($chars))];
		   		}
			}
		    //密码
		    $s_randpwd  = "";
		    for ( $i = 0; $i < 8; $i++ ) {
		        $s_randpwd  .= $chars[mt_rand(0, strlen($chars))];
		    }	    
			// 保存注册数据
			$a_data = [
				'member_name' => '7du_'.$s_username,
				'member_passwd' => md5($s_randpwd),
				'member_time' => $_SERVER['REQUEST_TIME'],
				'ip_create' => $a_ip_create,
				'id_equipment' => $a_id_equipment
			];
			$i_idt = $this->db->insert('member', $a_data);
			echo json_encode(array(
					"code" => '7du_'.$s_username,
			 		"msg" => $s_randpwd,
			 	));
			$_SESSION['pw'] = $s_randpwd;
			$_SESSION['member_na'] = '7du_'.$s_username;
		} else {
			echo json_encode(
            	78
			);
		}
	}

	//触发注册账号密码发收手机
	public function mobile() {
		$s_mobile = $this->general->post('mobile');
		$_SESSION['mobile'] = $s_mobile;
		if( ! preg_match("/^1[34578]\d{9}$/", $s_mobile)){
			echo json_encode(
            	33
			);
			die;
		}
		$i_mobli = $this->db->get_row('member', ['member_mobile' => $s_mobile], ['member_id']);
		if (empty($i_mobli)) {
			$s_content = '您的七度账号是：' . $_SESSION['member_na'] . '，您的七度密码是：' . $_SESSION['pw'] . '，请妥善保管，不要告诉他人！';
			//加载短信类
			$this->load->library('short_message');
			//发送短信
			$this->short_message->send($s_mobile, $s_content, 'authcode');
			//把手机号存进数据库
			$this->db->update('member', ['member_mobile' => $s_mobile], ['member_name' => $_SESSION['member_na']]);
			echo json_encode(11);
		} else {
			echo json_encode(22);
		}		
	}
	
	/**
	 * 个性注册
	 */
	public function register_auth() {
		//获取传过来的指定字段
		$s_username = $this->general->post('username');
		$s_passwd1 = $this->general->post('passwd');
		$s_mobile = $this->general->post('mobile');
		$s_email = $this->general->post('email');
		// 数据验证
		if (empty($s_username) || strlen($s_username) < 3) {
			echo 41;die;
		}
		if (strlen($s_username) > 18) {
			echo 42;die;
		}
		if (empty($s_passwd1) || strlen($s_passwd1) < 6) {
			echo 43;die;
		}
		if ( ! empty($s_email)) {
			if ( ! $this->general->is_mail($s_email) ) {
				echo 44;
				die;
			}
			// 用户重复性验证
			$a_rs = $this->db->get_row('member', ['member_email' => $s_email], 'member_id');
			if (isset($a_rs['member_id'])) {
				echo 45;
				die;
			}
		}
		if ( ! empty($s_mobile)) {
			if( ! preg_match("/^1[34578]\d{9}$/", $s_mobile)){
				echo 46;
				die;
			}
			// 用户重复性验证
			$a_rs = $this->db->get_row('member', ['member_mobile' => $s_mobile], 'member_id');
			if (isset($a_rs['member_id'])) {
				echo 47;
				die;
			}
		}
		
		// 用户重复性验证
		$a_rs = $this->db->where_or(['member_name' => $s_username, 'member_mobile' => $s_username])->get_row('member', '', 'member_id');
		if (isset($a_rs['member_id'])) {
			echo 48;
			die;
		}	
		
		// 保存注册数据
		$a_data = [
			'member_name' => $s_username,
			'member_passwd' => md5($s_passwd1),
			'member_email' => $s_email,
			'member_mobile' => $s_mobile,
			'member_time' => $_SERVER['REQUEST_TIME'],
			'member_time_login' => $_SERVER['REQUEST_TIME'],
			'member_login_ip' => $_SERVER["REMOTE_ADDR"]
		];
		$a_id = $this->db->insert('member', $a_data);
		if ( ! empty($a_id)) {
			echo 49;
		} else {
			echo 50;
			die;
		}		
	}
	

	//手机验证码
	public function verify() {
		$s_mobile = $this->general->post('mobile');
		// $s_mobile = 13229528477;
		//加载短信类
		$this->load->library('short_message');
		//加密验证码并存入cookie中,只存放2分钟
		$i_rand = rand(1000,9999);
		$s_rand = $this->general->base64_convert($i_rand);
		$this->general->set_cookie( 'rand',$s_rand,120);
		//发送短信内容
		$s_content = '您的验证码是' . $i_rand . ',请妥善保管,不要告诉他人！';
		//发送短信
		$this->short_message->send($s_mobile,$s_content,'authcode');
	}

	//忘记密码 验证验证码与发送的验证法是否一致
	public function verify_res() {
		$i_verify = $this->general->post('verifyName');
		$s_passwd1 = $this->general->post('passwd');
		$s_mobile = $this->general->post('mobile');
		$this->load->model('reset_model');
		$this->reset_model->get_username($s_mobile);
		if (empty($s_mobile) || ! preg_match("/^1[34578]\d{9}$/", $s_mobile)) {
			// $this->error->show_error('手机号不能为空','',false,2);
			echo 31;
			die;
		}
		
		if ( ! empty($i_verify) ) {
			$this->load->model('reset_model');
			$this->reset_model->pass_pwd($i_verify);
			
			//判断是否有session的id让页面是否显示
			if ( ! empty( $_SESSION['id'] ) ) {
				//如果接收到密码进入数据库更改密码
				if ( ! empty($s_passwd1)) {
					$this->db->update('member', ['member_passwd' => md5($s_passwd1) ], ['member_id' => $_SESSION['id'] ] );
					
					//同步登录
					$s_token = $this->user_model->sso_save_token($_SESSION['id'], $_SESSION['member_name'],  $s_passwd1);
					$this->general->set_cookie('user_id', $_SESSION['id']);
					$this->general->set_cookie('user_name', $_SESSION['member_name']);
					$_SESSION['user_id'] = $_SESSION['id'];
					$_SESSION['user_name'] = $_SESSION['member_name'];
					// $this->error->show_success('欢迎' . $a_rs['member_name'] . '回来！' . $this->user_model->sso_script($s_token), $_SESSION['back_url']);
					echo 35;	
					die;
				} else {
					// $this->error->show_error('密码不能为空','',false,2);
					echo 32;
					die;
				}
			} else {
				// $this->error->show_error('非法访问','',false,2);
				echo 33;
				die;
			}		
		} else {
			// $this->error->show_error('验证码不能为空','',false,2);
			echo 34;
			die;
		}
	}

}
