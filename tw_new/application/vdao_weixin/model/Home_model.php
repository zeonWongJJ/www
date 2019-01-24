<?php

class Home_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/************************************* 获取一条用户信息 *************************************/

	/**
	 * [get_user_one 获取一条用户信息]
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function get_user_one($user_id) {
		$a_where = [
			'user_id' => $user_id
		];
		$a_data = $this->db->get_row('user', $a_where);
		return $a_data;
	}

/************************************ 获取用户动态总条数 ************************************/

	/**
	 * [get_mood_count 获取用户动态总条数]
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function get_mood_count($user_id) {
		$a_where = [
			'user_id' => $user_id
		];
		$i_result = $this->db->get_total('mood', $a_where);
		return $i_result;
	}

/************************************** 获取热门关键词 *************************************/

	/**
	 * [get_search_hot 获取热门关键词]
	 * @return [type] [description]
	 */
	public function get_search_hot() {
		$a_order = [
			'search_count' => 'desc'
		];
		$a_data = $this->db->get('search', [], '', $a_order, 0, 5);
		return $a_data;
	}

/************************************ 获取分享者昨日的订单 ***********************************/

	/**
	 * [get_order_yestoday description]
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function get_order_yestoday($user_id) {
		$start = mktime(0,0,0,date('m'),date('d'),date('Y'));
		$beginYesterday = mktime(0,0,0,date('m'),date('d')-1,date('Y'));
		$a_where = [
			'share_userid' => $user_id,
			'time_finnshed >' => $beginYesterday,
			'time_finnshed <' => $start,
		];
		$s_field = '';
		$a_order = [
			'order_id' => 'desc'
		];
		$a_data = $this->db->where_in('order_state',[10,80])
						   ->get('order', $a_where, $s_field, $a_order, 0, 99999999);
		return $a_data;
	}

/********************************************************************************************/

}

?>