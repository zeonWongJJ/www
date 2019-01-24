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
		if (isset($a_rs['sso_id'])) {
			if ( ! $this->db->update('sso', $a_data, ['sso_id' => $a_rs['sso_id']]) ) {
				return 0;
			}
		} else {
			if ( ! $this->db->insert('sso', $a_data) ) {
				return 0;
			}
		}
		return $this->general->base64_convert($s_token);
	}
	
	/**
	 * 生成单点登录JS
	 * $i_type 操作类型；登录：login ； 退出：logout
	 */
	public function sso_script($s_token, $s_type = 'login') {
		$s_index = $s_type == 'logout' ? 'sso_logout' : 'sso_login';
		$s_script = '';
		foreach ($this->_a_sso_site as $s_site) {
			$s_script .= '<script src="' . $s_site . "/{$s_index}-" . $s_token . '.html"></script>';
		}
		return $s_script;
	}
}
?>