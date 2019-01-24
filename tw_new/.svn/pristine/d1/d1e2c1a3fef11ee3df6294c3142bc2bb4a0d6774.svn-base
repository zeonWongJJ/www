<?php
class User_model extends TW_Model {
	public function __construct() {
		parent :: __construct();
	}
	
	// 注册处理
	public function register($a_param) {
		if (empty($a_param['name_user']) || empty($a_param['name_real']) || empty($a_param['email']) ||
			empty($a_param['mobile']) || empty($a_param['pswd']) || empty($a_param['repswd'])) {
			return ['state_code' => '10001', 'msg' => '信息填写不完整！'];
		}
		if ( ! preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $a_param['email']) ) {
			return ['state_code' => '10002', 'msg' => '邮箱格式不正确！'];
		}
		if ( ! preg_match("/^1[34578]\d{9}$/", $a_param['mobile']) ) {
			return ['state_code' => '10003', 'msg' => '手机号码格式不正确！'];
		}
		if (strlen($a_param['pswd']) < 6 || $a_param['pswd'] != $a_param['repswd']) {
			return ['state_code' => '10004', 'msg' => '密码格式不正确或两次输入不匹配！'];
		}
		if (empty($a_param['openid'])) {
			return ['state_code' => '10005', 'msg' => '获取微信openid失败！'];
		}
		$a_data = [
			'group' => 'user',
			'name_user' => trim($a_param['name_user']),
			'name_real' => trim($a_param['name_real']),
			'email' => trim($a_param['email']),
			'openid_weixin' => $this->general->base64_convert($a_param['openid'], true),
			'mobile' => trim($a_param['mobile']),
			'pswd' => md5(trim($a_param['pswd'])),
			'ip_create' => $this->general->ip_convert($this->general->get_ip(), 'ENCODE'),
			'time_create' => $_SERVER['REQUEST_TIME'],
		];
		if ($this->db->insert('user', $a_data)) {
			return ['state_code' => '10000', 'msg' => '世上无难事，只要肯花钱！'];
		}
		return ['state_code' => '10006', 'msg' => '注册失败，可能信息已被注册！'];
	}
	
	// 登录处理
	public function login($a_param) {
		if (empty($a_param['user']) || empty($a_param['pswd'])) {
			return ['state_code' => '10006', 'msg' => '信息填写不完整！'];
		}
		if (strlen($a_param['pswd']) < 6) {
			return ['state_code' => '10007', 'msg' => '密码格式不正确！'];
		}
		$a_where = ['pswd' => md5(trim($a_param['pswd']))];
		$a_where_or = [
			'name_user' => $a_param['user'],
			'name_real' => $a_param['user'],
			'mobile' => $a_param['user'],
			'email' => $a_param['user']
		];
		$this->db->group_start();
		$this->db->where_or($a_where_or);
		$this->db->group_end();
		$a_result = $this->db->get_row('user', $a_where);
		if (isset($a_result['id_user'])) {
			if ($a_result['state'] != 1) {
				return ['state_code' => '10010', 'msg' => '让君子去成人之美吧，我小人当夺人所爱！'];
			}
			$a_data = [
				'ip_last' => $this->general->ip_convert($this->general->get_ip(), 'ENCODE'),
				'time_last' => $_SERVER['REQUEST_TIME']
			];
			$a_where = ['id_user' => $a_result['id_user']];
			if ($this->db->update('user', $a_data, $a_where)) {
				$_SESSION['user'] = $a_result;
				return ['state_code' => '10000', 'msg' => '上车啦！'];
			} else {
				return ['state_code' => '10008', 'msg' => '登录失败！'];
			}
		}
		return ['state_code' => '10009', 'msg' => '登录失败！'];
	}
	
	// 登录处理
	public function binding_weixin($i_id_user, $s_openid) {
		if ($this->db->update('user', ['openid_weixin' => $s_openid], ['id_user' => $i_id_user])) {
			return true;
		}
		return false;
	}
	
	// 注销
	public function logout() {
		unset($_SESSION['user']);
		return ['state_code' => '10000', 'msg' => '我想早恋，但已经晚了！'];
	}
	
	// 获取用户名
	public function get_name($i_id_user, $s_type = 'USER/REAL') {
		$a_data = $this->db->get_row('user', ['id_user' => $i_id_user], 'name_user, name_real');
		if ($s_type == 'USER') {
			return $a_data['name_user'];
		}
		return $a_data['name_real'];
	}
	
	// 获取用户
	public function get_data($i_id_user = 0, $m_field = '') {
		if ($i_id_user) {
			return $this->db->get('user', ['id_user' => $i_id_user, 'state' => 1], $m_field);
		}
		return $this->db->get('user', ['state' => 1], $m_field);
	}
	
	// 获取部门名称
	public function get_department_name($s_department) {
		$a_department = [
			'admin' => '不限',
			'front' => '前端',
			'design' => '设计',
			'server' => '服务端程序',
			'app' => '手机应用'
		];
		return $a_department[$s_department];
	}
	
	// 把用户按部门进行组装好
	public function get_department($i_id_user = 0, $m_field = '') {
		$a_data = $this->get_data($i_id_user, $m_field);
		$a_result = [];
		foreach ($a_data as $u_key => $u_val) {
			$a_result[$u_val['department']][] = $u_val;
		}
		return $a_result;
	}
	
	// 返回一个选择用户的多级框代码
	public function get_user_select($a_param = []) {
		$a_param['user'] = $this->get_data();
		if ( ! isset($a_param['name']) ) {
			$a_param['checkbox_name'] = 'user_select';
		} else {
			$a_param['checkbox_name'] = $a_param['name'];
		}
		if ( ! isset($a_param['multiple']) ) {
			$a_param['multiple'] = true;
		}
		return $this->view->get('user_select', $a_param);
	}
	
	// 把用户id组合成[1],[2],[3]格式，以便存储和查询
	public function user_id_string($a_param) {
		if ( ! is_array($a_param) ) {
			return '';
		}
		$s_string = '';
		foreach ($a_param as $i_id_user) {
			$i_id_user = intval($i_id_user);
			if ($i_id_user) {
				$s_string .= "[{$i_id_user}],";
			}
		}
		return rtrim($s_string, ',');
	}
	
	// 返回openid
	public function get_openid_weixin($i_id_user) {
		$a_data = $this->db->get_row('user', ['id_user' => $i_id_user], 'openid_weixin');
		return $a_data['openid_weixin'];
	}
}
?>