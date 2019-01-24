<?php
defined('BASEPATH') OR exit('禁止访问！');

/**
 * 同步登录操作
 */
class Sso_ctrl extends TW_Controller {
	// 存储用户信息
	private $_a_udata = [];
	private $_a_ssodata = [];
	
	public function __construct() {
		parent :: __construct();
	}

	// 同步登录操作
	public function login()	{
		if ($this->_auth()) {
			// 设置登录信息
			$this->general->set_cookie('user_id', $this->_a_udata['member_id'], $this->_a_ssodata['sso_keep']);
			$this->general->set_cookie('user_name', $this->_a_udata['member_name'], $this->_a_ssodata['sso_keep']);
			$_SESSION['user_id'] = $this->_a_udata['member_id'];
			$_SESSION['user_name'] = $this->_a_udata['member_name'];
		}
	}
	
	// 同步退出操作
	public function logout() {
		if ($this->_auth()) {
			$this->general->set_cookie('user_id', '', -99999999999);
			$this->general->set_cookie('user_name', '', -99999999999);
			unset($_SESSION['user_id']);
			unset($_SESSION['user_name']);
		}
	}
	
	// 同步验证
	private function _auth() {
		$s_token = $this->general->base64_convert($this->router->get('1'), true);
		$this->_a_ssodata = $this->db->get_row('sso', ['sso_token' => $s_token]);
		
		// TOKEN 5 分钟内有效
		if (isset($this->_a_ssodata['sso_id']) && $_SERVER['REQUEST_TIME'] - $this->_a_ssodata['sso_time'] < 300 && $this->_a_ssodata['sso_syn_num'] < $this->_a_ssodata['sso_site_num']) {
			$this->_a_udata = $this->db->get_row('member', ['member_id' => $this->_a_ssodata['sso_user_id']], 'member_id, member_name, member_passwd');
			// 检查SSO表的用户信息是否和用户表的一致
			if (isset($this->_a_udata['member_id']) && $this->_a_udata['member_id'] == $this->_a_ssodata['sso_user_id'] && $this->_a_udata['member_name'] == $this->_a_ssodata['sso_user_name']) {
				$s_pwd = $this->_a_ssodata['sso_user_id'] . $this->_a_ssodata['sso_user_name'] . $this->_a_udata['member_passwd'] . $this->general->get_ip() . $this->_a_ssodata['sso_time'];
				// 检查加密串是否一致
				if (password_verify($s_pwd, $s_token)) {
					// 更新已同步站点数
					$this->db->set('sso_syn_num', 'sso_syn_num + 1', false);
					$this->db->update('sso', NULL, ['sso_id' => $this->_a_ssodata['sso_id']]);
					
					return true;
				}
			}
		}
		return false;
	}
}
