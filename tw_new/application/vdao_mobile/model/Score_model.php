<?php

class Score_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/************************************** 用户积分 **************************************/

	public function get_score_user($user_id, $page) {
		// 先设置默认从第一页开始
		$i_page = $page;
		if (empty($i_page)) {
			$i_page = 1;
		}
		// 设置每页显示的数据行数
		$i_prow = 20;
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数
		$a_where = [
			'user_id' => $user_id
		];
		$i_total = $this->db->get_total('points_log', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);

		$s_field = '';
		$a_order = [
			'pl_id' => 'desc'
		];
		$a_data = $this->db->get('points_log', $a_where, $s_field, $a_order);
		// 判断是否超出总页数
		if ($page > ceil($i_total/$i_prow)) {
			return array();
		} else {
			return $a_data;
		}
	}

/************************************ 一条用户记录 ************************************/

	/**
	 * [get_user_one 获取一条用户记录]
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

/************************************ 一条积分记录 ************************************/

	/**
	 * [get_score_one 一条积分记录]
	 * @param  [type] $pl_id [description]
	 * @return [type]        [description]
	 */
	public function get_score_one($pl_id) {
		$a_where = [
			'pl_id' => $pl_id
		];
		$a_data = $this->db->get_row('points_log', $a_where);
		return $a_data;
	}

/**************************************************************************************/

}

?>