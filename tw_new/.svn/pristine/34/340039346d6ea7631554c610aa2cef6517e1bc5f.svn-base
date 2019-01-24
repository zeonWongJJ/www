<?php

class Login_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/************************************* 获取一条 *************************************/

	/**
	 * [get_user_one 根据手机号码或者用户名获取一条会员信息]
	 * @param  [string] $name_or_tel [传入的手机号码或者用户名]
	 * @param  [int]    $type        [type为1表示手机号码，type为2表示用户名]
	 * @return [array]               [返回查询到的数据]
	 */
	public function get_user_one($name_or_tel, $type) {
		if ($type == 1) {
			$a_where = [
				'user_phone' => $name_or_tel
			];
		} else {
			$a_where = [
				'user_name' => $name_or_tel
			];
		}
		$a_data = $this->db->get_row('user', $a_where);
		return $a_data;
	}

/************************************* 更新数据 *************************************/

	/**
	 * [update_user 更新会员数据]
	 * @param  [array] $a_where [更新的条件]
	 * @param  [array] $a_data  [更新的数据]
	 * @return [int]            [返回更新的行数]
	 */
	public function update_user($a_where, $a_data) {
		$i_result = $this->db->update('user', $a_data, $a_where);
		return $i_result;
	}

/******************************** 通过openid获取数据 ********************************/

	/**
	 * [get_user_openid 通过openid获取数据]
	 * @param  [string] $openid [传入的openid]
	 * @return [array]          [返回查询到的数据]
	 */
	public function get_user_openid($openid) {
		$a_where = [
			'qq_openid' => $openid
		];
		$a_data = $this->db->get_row('user', $a_where);
		return $a_data;
	}

/***************************** 通过weixin_openid获取数据 ****************************/

	/**
	 * [get_user_openid 通过openid获取数据]
	 * @param  [string] $openid [传入的openid]
	 * @return [array]          [返回查询到的数据]
	 */
	public function get_user_weixin($openid) {
		$a_where = [
			'weixin_openid' => $openid
		];
		$a_data = $this->db->get_row('user', $a_where);
		return $a_data;
	}

/*********************************** 插入一条数据 ***********************************/

	/**
	 * [insert_user 插入一条数据到user表]
	 * @param  [array] $a_data [要插入的数据]
	 * @return [int]           [返回新数据的id]
	 */
	public function insert_user($a_data) {
		$i_result = $this->db->insert('user', $a_data);
		return $i_result;
	}

/******************************* 获取同一手机号总条数 *******************************/

	/**
	 * [get_phone_total 根据手机号码获取总条数]
	 * @param  [int] $user_phone [传入的手机号码]
	 * @return [int]             [返回查询到的总条数]
	 */
	public function get_phone_total($user_phone) {
		$a_where = [
			'user_phone' => $user_phone
		];
		$i_result = $this->db->get_total('user', $a_where);
		return $i_result;
	}

/******************************* 获取同一用户名总条数 *******************************/

	/**
	 * [get_user_total 根据用户名获取总条数]
	 * @param  [string] $user_name [传入的用户名]
	 * @return [int]               [返回查询到的总条数]
	 */
	public function get_user_total($user_name) {
		$a_where = [
			'user_name' => $user_name
		];
		$i_result = $this->db->get_total('user', $a_where);
		return $i_result;
	}

/************************************************************************************/

	/**
	 * [get_user_uid 根据微博uid获取一条信息]
	 * @param  [type] $uid [description]
	 * @return [type]      [description]
	 */
	public function get_user_uid($uid) {
		$a_where = [
			'weibo_uid' => $uid
		];
		$a_data = $this->db->get_row('user', $a_where);
		return $a_data;
	}

/************************************************************************************/

}

?>