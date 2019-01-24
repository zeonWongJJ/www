<?php
/**
 * 用户模块
 */
class User_model extends TW_Model {
	public function __construct() {
        include_once(PROJECTPATH . '/config/config_sso_site.php');
		$this->_a_sso_site = $a_sso_site;
    }
	
	// 保存单点登录的TOKEN
	public function sso_save_token($i_uid, $s_name, $s_pwd, $i_keep = 0) {
		$s_pwd = $i_uid . $s_name . $s_pwd . $this->general->get_ip() . $_SERVER['REQUEST_TIME'];
		$s_token = password_hash($s_pwd, PASSWORD_DEFAULT);
		$a_rs = $this->db->get_row('sso', ['sso_user_id' => $i_uid, 'sso_user_name' => $s_name]);
		$a_data = [
			'sso_user_id' => $i_uid,
			'sso_user_name' => $s_name,
			'sso_token' => $s_token,
			'sso_keep' => $i_keep,
			'sso_syn_num' => 0,
			'sso_site_num' => count($this->_a_sso_site),
			'sso_time' => $_SERVER['REQUEST_TIME']
		];
		if (isset($a_rs['sso_id'])){
			if ( ! $this->db->update('sso',$a_data,['sso_id' => $a_rs['sso_id']])) {
				return 0;
			}
		} else {
			if ( ! $this->db->insert('sso',$a_data)) {
				return 0;
			}
		}
		return $this->general->base64_convert($s_token);
	}
	
	/**
	 * 生成单点登录JS
	 * $i_type 操作类型；登录：login ； 退出：logout
	 */
	public function sso_script($s_token,$s_type = 'login') {
		$s_index = $s_type == 'logout' ? 'sso_logout' : 'sso_login';
		$s_script = '';
		foreach ($this->_a_sso_site as $s_site) {
			$s_script .= '<script src="' . $s_site . "/{$s_index}-" . $s_token . '.html"></script>';
		}
		return $s_script;
	}

	//qq登录
	public function qqlogin($openid,$figureurl = null) {
		//判断数据库中是否已经关联了账号
		$a_where = ['member_qqopenid' => $openid]; 
		$s_field = 'member_name,member_id,member_passwd,member_time_login,member_login_ip'; 

		// 根据openid查询出用户的信息
		$a_rs = $this->db->get_row('member',$a_where,$s_field);

		//用户是否有登录过,如果登录过用原来的用户名作为昵称,如果没有登录给用户添加资料到数据库中
		if ($a_rs == false) {
			//读取文件内容
			$a_where = ['member_qqopenid' 	=> $openid,
						'member_name' 		=> $_SESSION['user_name'],
						'member_time' 		=> $_SERVER['REQUEST_TIME'],
						'member_time_login' => $_SERVER['REQUEST_TIME'],
						'member_login_ip'	=> $this->general->get_ip(),
						'member_avatar' 	=> $figureurl]; 
			$this->db->insert('member',$a_where);
			$a_where = ['member_qqopenid' => $openid]; 
			$s_field = 'member_name,member_id,member_passwd,member_time_login,member_login_ip'; 
			$a_rs = $this->db->get_row('member',$a_where,$s_field);
			$_SESSION['user_id'] = $a_rs['member_id'];
		}

		if (isset($a_rs['member_id'])) {
			if ( ! $s_token = $this->sso_save_token($a_rs['member_id'], $a_rs['member_name'], $a_rs['member_passwd'], 31536000) ) {
				$this->error->show_error('登录失败！');
			}
			$i_keep = 31536000;
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
			$s_script = $this->sso_script($s_token);
			echo $s_script;
			// echo "<script>opener.location.href='http://wap.7dugo.com/index';window.close();</script>";
			$this->error->show_success('登录成功', 'index', '', 1);
		}else{
			$this->error->show_error('登录失败,请尝试重新登录','/');
		}

	}

	//处理微博登录
	public function wblogin($uid, $name = null){
		//判断数据中是否已经关联了账号
		$a_where = ['member_sinaopenid' => $uid]; 
		$s_field = 'member_name,member_id,member_passwd,member_time_login,member_login_ip'; 
		$a_rs = $this->db->get_row('member',$a_where,$s_field);

		//用户是否有登录过,如果登录过用原来的用户名作为昵称,如果没有登录给用户添加资料到数据库中
		if ($a_rs == false) {
			//读取文件内容
			$a_where = ['member_sinaopenid' => $uid,
						'member_name' 		=> $name,
						'member_time' 		=> $_SERVER['REQUEST_TIME'],
						'member_time_login' => $_SERVER['REQUEST_TIME'],
						'member_login_ip'	=> $this->general->get_ip()]; 
			$this->db->insert('member',$a_where);
			$a_where = ['member_sinaopenid' => $uid]; 
			$s_field = 'member_name,member_id,member_passwd,member_time_login,member_login_ip'; 
			$a_rs = $this->db->get_row('member',$a_where,$s_field);
			$_SESSION['user_id'] = $a_rs['member_id'];
		}

		if (isset($a_rs['member_id'])) {
			if ( ! $s_token = $this->sso_save_token($a_rs['member_id'], $a_rs['member_name'], $a_rs['member_passwd'], 31536000) ) {
				$this->error->show_error('登录失败！');
			}
			$i_keep = 31536000;
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
			$s_script = $this->sso_script($s_token);
			echo $s_script;
			echo "<script>opener.location.href='http://user.7dugo.com/index';window.close();</script>";
		}else{
			$this->error->show_error('登录失败,请尝试重新登录','/');
		}
	}
}
?>