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

		if( isset($_SESSION['user_id']) && ! empty($_SESSION['user_id']) ){
			$this->load->model('index_model');

			//获取用户信息
			$a_data['userinfo'] = $this->index_model->index_userinfo();	

			// 获取订单信息
			$a_data['order'] = $this->index_model->index_order();

			// 获取订单状态
			$a_data['state'] = $this->index_model->index_order_state();

			// 获取密码安全性等级
			$a_data['safe'] = $this->index_model->safe($a_data['userinfo']['member_email'],$a_data['userinfo']['member_mobile'],$a_data['userinfo']['member_passwd']);

			//获取消息条数
			$i_message = $this->db->get_total('message', ['to_member_id' => $_SESSION['user_id'], 'message_state' => 0]);
			$_SESSION['message'] = $i_message;
			
			//获取当前时间
			$a_data['time'] = $_SERVER['REQUEST_TIME'];

			//获取优惠券的数量
			$a_data['voucher'] = $this->index_model->voucher();

			$this->view->display('index', $a_data);
		}else
			$this->view->display('login');
	}
	
	/**
	 * 登录页面
	 */
	public function login()	{
		$back_url = $this->router->get('1');
		if ( ! empty($back_url) ) {
			$back_url = $this->general->base64_convert($back_url, true);
		} else {
			$back_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->router->url('index');
		}
		$_SESSION['back_url'] = $back_url;
		
		if (isset($_SESSION['user_id']) && ! empty($_SESSION['user_id'])) {
			$this->error->show_warning('您已经登录！', $_SESSION['back_url']);
		}
		
		$this->view->display('login');
	}
	
	/**
	 * QQ首页
	 */
	public function qq_index(){
		require_once( PROJECTPATH . "/libraries/qqlogin/qqConnectAPI.php");
		$qc = new QC();
		$qc->qq_login();
	}

	/**
	 * QQ回调地址并QQ单点登陆
	 */
	public function qq_callback(){
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
		if (empty($s_name) || empty($s_pwd)) {
			$this->error->show_warning('请填写用户名和密码！');
		}
		$i_keep = $this->general->post('keep') == 'on' ? 2592000 : 0;
		$a_rs = $this->db->get_row('member', ['member_name' => $s_name, 'member_passwd' => md5($s_pwd)]);
		if (isset($a_rs['member_id'])) {

			if ( ! $s_token = $this->user_model->sso_save_token($a_rs['member_id'], $a_rs['member_name'], $a_rs['member_passwd'], 31536000) ) {
				$this->error->show_error('登录失败！');
			}
			$this->general->set_cookie('user_id', $a_rs['member_id'], $i_keep);
			$this->general->set_cookie('user_name', $a_rs['member_name'], $i_keep);
			$_SESSION['user_id'] = $a_rs['member_id'];
			$_SESSION['user_name'] = $a_rs['member_name'];
			$a_data = [
				'member_time_old_login' => $a_rs['member_time_login'],
				'member_time_login' => $_SERVER['REQUEST_TIME'],
				'member_old_login_ip' => $a_rs['member_login_ip'],
				'member_login_ip' => $this->general->get_ip()
			];
			$a_where = ['member_id' => $a_rs['member_id']];
			$this->db->update('member', $a_data, $a_where);
			
			$this->error->show_success('欢迎' . $a_rs['member_name'] . '回来！' . $this->user_model->sso_script($s_token), $_SESSION['back_url']);
		}else{
			$this->error->show_error('登录失败,请尝试重新登录','/');
		}
	}
	
	/**
	 * 退出
	 */
	public function logout() {
		if ( ! isset($_SESSION['user_id']) ) {
			$this->error->show_error('请先登录！', $this->router->url('login', [$this->general->base64_convert($this->router->url('index'))]));
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
		
		$this->error->show_success('注销成功！' . $this->user_model->sso_script($s_token, 'logout'), $this->router->url('index'));
	}
	
	/**
	 * 注册
	 */
	public function register() {
		$back_url = $this->router->get('1');
		if ( ! empty($back_url) ) {
			$back_url = $this->general->base64_convert($back_url, true);
		} else {
			$back_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->router->url('index');
		}
		$_SESSION['back_url'] = $back_url;
		
		$this->view->display('register');
	}
	
	/**
	 * 注册处理
	 */
	public function register_auth() {
		//获取传过来的指定字段
		$s_username = $this->general->post('username');
		$s_passwd1 = $this->general->post('passwd1');
		$s_passwd2 = $this->general->post('passwd2');
		$s_email = $this->general->post('email');
		$captcha = $this->general->post('captcha');

		if( $captcha == $_SESSION['captcha']  ){

			// 数据验证
			if (empty($s_username) || strlen($s_username) < 3) {
				$this->error->show_warning('用户名太短！');
			}
			if (strlen($s_username) > 50) {
				$this->error->show_warning('用户名太长！');
			}
			if (empty($s_passwd1) || strlen($s_passwd1) < 6) {
				$this->error->show_warning('密码太短！');
			}
			if ($s_passwd1 != $s_passwd2) {
				$this->error->show_warning('两次输入的密码不一致！');
			}
			if ( ! $this->general->is_mail($s_email) ) {
				$this->error->show_warning('请填写正确的邮箱！');
			}
			
			// 用户重复性验证
			$a_rs = $this->db->get_row('member', ['member_name' => $s_username], 'member_id');
			if (isset($a_rs['member_id'])) {
				$this->error->show_warning('用户名已经存在！');
			}
			$a_rs = $this->db->get_row('member', ['member_email' => $s_email], 'member_id');
			if (isset($a_rs['member_id'])) {
				$this->error->show_warning('邮箱已经注册，请尝试登录或找回密码！');
			}
			
			// 保存注册数据
			$a_data = [
				'member_name' => $s_username,
				'member_passwd' => md5($s_passwd1),
				'member_email' => $s_email,
				'member_time' => $_SERVER['REQUEST_TIME'],
				'member_time_login' => $_SERVER['REQUEST_TIME'],
				'member_login_ip' => $this->general->get_ip()
			];
			if ($i_id = $this->db->insert('member', $a_data)) {
				// 同步登录
				$s_token = $this->user_model->sso_save_token($i_id, $a_data['member_name'], $a_data['member_passwd']);
				$this->general->set_cookie('user_id', $i_id);
				$this->general->set_cookie('user_name', $a_data['member_name']);
				$_SESSION['user_id'] = $i_id;
				$_SESSION['user_name'] = $a_data['member_name'];
				$this->error->show_success('注册成功！' . $this->user_model->sso_script($s_token), $_SESSION['back_url']);
			}
			$this->error->show_error('注册失败，请重试或联系客服！');
		} else {
			$this->error->show_error('验证码输入错误');
		}
	}
	
	// 验证用户名是否存在
	public function name_exists() {
		$s_username = $this->general->post('username');
		$i_res = $this->db->get_total('member', ['member_name' => $s_username]);
		echo "$i_res";die;
	}

	// 验证邮箱是否存在
	public function email_exists() {
		$s_email = $this->general->post('email');
		$i_res = $this->db->get_total('member', ['member_email' => $s_email]);
		echo "$i_res";die;
	}
	
	// 验证码
	public function captcha() {
		$this->load->library('captcha');
		$this->captcha->image(89, 32);
		$_SESSION['captcha'] = $this->captcha->get_code();
	}
	
	// 忘记密码
	public function reset() {
		//获取用户名
		$s_username = $this->general->post('username');
		$i_captcha = $this->general->post('captcha');
		//判断用户名是否存在，如果存在利用模型处理好并返回数据
		if ( ! empty( $s_username ) ){
			//判断传过来的验证码
			if ( $i_captcha == $_SESSION['captcha'] ){
				$this->load->model('reset_model');
				$this->reset_model->get_username($s_username);
			} else {
				$this->error->show_error('验证码输入错误','reset',false,2);
			}
		}
		$this->view->display('reset');
	}

	//忘记密码验证身份
	public function reset_two(){	
		if ( isset($_SESSION['member_name']) ){
			$this->load->model('reset_model');
			$a_data = $this->reset_model->get_more($_SESSION['member_name']);
			$this->view->display('reset_two',$a_data);
		}

	}

	//手机验证和邮箱验证
	public function verify(){
		$s_email = $this->general->post('email');
		$s_mobile = $this->general->post('mobile');

		//发送邮箱和发送短信
		if ( ! empty( $s_email ) ){
			//加载邮件类
			$this->load->library('email');
			//产生随机数并保存到cookie中并加密
			$i_rand = rand(1000,9999);
			//加密验证码并存入cookie中,只存放2分钟
			$s_rand = $this->general->base64_convert($i_rand);
			$this->general->set_cookie('rand',$s_rand,120);
			//发送邮箱的内容
			$s_content = '你的验证码是' . $i_rand . ',请妥善保管,不要告诉他人！';
			//发送
			$this->email->send_smtp('七度修改密码',$s_content,true,$s_email);
		} else {
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
	}

	//验证验证码与发送的验证法是否一致
	public function verify_res(){
		$i_verify = $this->general->post('verifyName');
		if ( ! empty($i_verify) ){
			$this->load->model('reset_model');
			$this->reset_model->pass_pwd($i_verify);		
		} else {
			$this->error->show_error('验证码不能为空','reset_two',false,2);
		}
	}

	//重置密码
	public function reset_three(){
		$s_passwd1 = $this->general->post('passwd1');
		$s_passwd2 = $this->general->post('passwd2');
		//判断是否有session的id让页面是否显示
		if ( ! empty( $_SESSION['id'] ) ){
			//如果接收到密码进入数据库更改密码
			if ( ! empty($s_passwd1) && ! empty($s_passwd2) && $s_passwd1 == $s_passwd2){
				//判断两次密码是否大于6小于14条件
				if ( strlen($s_passwd2) >= 6 && strlen($s_passwd2) <= 14 ){		
					$this->load->model('reset_model');	
					$this->reset_model->update($s_passwd2);
				} else {
					$this->error->show_error('输入密码格式不正确','reset_three',false,2);
				}
			} else if ( $s_passwd1 != $s_passwd2){
				$this->error->show_error('两次输入的密码不一致！','reset_three',false,2);
			} else {
				$this->view->display('reset_three');
			}
		} else {
			$this->error->show_error('非法访问','reset',false,2);
		}
	}

	//重置密码成功
	public function reset_four(){
		$this->view->display('reset_four');
	}

	//支付宝支付临时界面
	public function alipay(){
		$this->view->display('alipay');
	}

	//支付宝支付成功后返回的界面
	public function alipay_y(){

		require_once(PROJECTPATH."/libraries/alipay/notify_url.php");
	}

	//微博登录
	public function wblogin(){
		require_once PROJECTPATH . '/libraries/weibo/config.php';
		require_once PROJECTPATH . '/libraries/weibo/saetv2.ex.class.php';

		$wb = new SaeTOAuthV2(WB_KEY,WB_SEC);

		//回调的地址
		$oauth = $wb->getAuthorizeURL(CALLBACK);
		header('location:'.$oauth);
	}

	//微博登录
	public function wblogin_callback(){
		require_once PROJECTPATH . '/libraries/weibo/config.php';
		require_once PROJECTPATH . '/libraries/weibo/saetv2.ex.class.php';

		// 用GET方法从地址栏中获取code参数
		$code = $_GET['code'];

		//$keys是一个数组需要输入code和回调地址
		$keys['code'] = $code;
		$keys['redirect_uri'] =  CALLBACK;

		$wb = new SaeTOAuthV2(WB_KEY,WB_SEC);

		//修改了原来类中输入参数的位子,获取到的有access_token，过期时间，还有uid是微博的id
		$auth = $wb->getAccessToken($keys);

		//将access_token存在cookie中
		setcookie('accesstoken' , $auth['access_token'], time()+86400);

		$wb = new SaeTClientV2(WB_KEY,WB_SEC,$_COOKIE['accesstoken']);
		$uid_get = $wb->get_uid();

		//获取微博专一的UID
		$uid = $uid_get['uid'];
		$user_message = $wb->show_user_by_id( $uid);//根据ID获取用户
		$this->load->model('user_model');
		$this->user_model->wblogin($uid_get, $user_message['screen_name']);
	}
	
}
