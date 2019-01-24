<?php
defined('BASEPATH') OR exit('禁止访问！');
header('content-type:text/html;charset=utf-8;');
date_default_timezone_set('PRC');
class Home_ctrl extends TW_Controller {
	
	public function __construct() {
		parent :: __construct();
		
		$this->load->model('user_model');


	}

	public function index(){
		if(!$_SESSION['user_id']){
			$this->view->display('login');
			die;
		}
		header("Location:".$this->router->url("goods").""); 
		die;
		$this->view->display('goods');
		// echo 123;
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
	 * 登录提交信息处理
	 */
	public function login_auth() {
		$s_name = $this->general->post('username');
		$s_pwd = $this->general->post('passwd');
		if (empty($s_name) || empty($s_pwd)) {
			$this->error->show_warning('请填写用户名和密码！');
		}
		$i_keep = $this->general->post('keep') == 'on' ? 2592000 : 0;
		$a_rs = $this->db->get_row('admin', ['admin_name' => $s_name, 'admin_password' => md5($s_pwd)]);
		if (isset($a_rs['admin_id'])) {
			if ( ! $s_token = $this->user_model->sso_save_token($a_rs['admin_id'], $a_rs['admin_name'], $a_rs['admin_password'], 31536000) ) {
				$this->error->show_error('登录失败！');
			}
			$this->general->set_cookie('user_id', $a_rs['admin_id'], $i_keep);
			$this->general->set_cookie('user_name', $a_rs['admin_name'], $i_keep);
			$_SESSION['user_id'] = $a_rs['admin_id'];
			$_SESSION['user_name'] = $a_rs['admin_name'];
			$_SESSION['is_admin'] = 1;

			$i = $a_rs['admin_login_num'];
			$a_data = [
				'admin_login_time' => $_SERVER['REQUEST_TIME'],
				'admin_login_num' => $i + 1
			];
			$a_where = ['admin_id' => $a_rs['admin_id']];
			$this->db->update('admin', $a_data, $a_where);
			$this->db->insert('admin_log', [
				'log_content' => '',
				'log_time_create' => $_SERVER['REQUEST_TIME'],
				'admin_name' => $_SESSION['user_name'],
				'admin_id' => $_SESSION['user_id'],
				'log_ip' => $this->general->get_ip(),
				'log_url' => 'login&login'
			]);

			$this->error->show_success('欢迎' . $a_rs['admin_name'] . '回来！' . $this->user_model->sso_script($s_token), $_SESSION['back_url']);
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
		$a_rs = $this->db->get_row('admin', ['admin_id' => $_SESSION['user_id']]);
		if ( ! $s_token = $this->user_model->sso_save_token($a_rs['admin_id'], $a_rs['admin_name'], $a_rs['admin_password'], 31536000) ) {
			$this->error->show_error('注销失败！');
		}
		
		$this->general->set_cookie('user_id', '', -99999999999);
		$this->general->set_cookie('user_name', '', -99999999999);
		unset($_SESSION['user_id']);
		unset($_SESSION['user_name']);
		
		$this->error->show_success('注销成功！' . $this->user_model->sso_script($s_token, 'logout'), $this->router->url('index'));
		// $this->error->show_success('注销成功！' . $this->user_model->sso_script($s_token, 'logout'), $this->router->url('login'));
	}	
}
