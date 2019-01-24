<?php
class Back_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/**********************************************************************************/

	//获取当前手机号码的最近一条验证码
	public function get_row_code($mobile) {
		$time = $_SERVER['REQUEST_TIME']-1800;
		$a_where = [
			'comprehensive =' => $mobile,
			'code_type =' => 1,
			'send_time >' =>$time
		];
		$s_field = '';
		$a_order = [
			'id' => 'desc'
		];
		$a_data = $this->db->get_row('code', $a_where, $s_field, $a_order);
		return $a_data;
	}

/**********************************************************************************/

	//检验用户是否存在
	public function is_account_exist($mobile) {
		$a_where = [
			'mobile =' => $mobile
		];
		$s_field = '';
		$a_order = [
			'id' => 'desc'
		];
		$a_data = $this->db->get_row('member', $a_where, $s_field, $a_order);
		return $a_data;
	}

/**********************************************************************************/

	//更新密码
	public function update_member_pwd($a_data_update, $mobile) {
		$a_where = [
			'mobile =' => $mobile
		];
		$i_result = $this->db->update('member', $a_data_update, $a_where);
		return $i_result;
	}

/**********************************************************************************/

}

?>