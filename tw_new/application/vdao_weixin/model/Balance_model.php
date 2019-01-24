<?php

class Balance_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/********************************** 获取一条用户信息 **********************************/

	/**
	 * [get_user_one 获取一条用户信息]
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function get_user_one($user_id) {
		$a_where = [
			'user_id' => $user_id,
		];
		$a_data = $this->db->get_row('user', $a_where);
		return $a_data;
	}

/********************************* 获取用户的资金明细 *********************************/

	/**
	 * [function_name description]
	 * @return [type] [description]
	 */
	public function get_user_balance($user_id, $page) {
		// 先设置默认从第一页开始
		$i_page = $page;
		if (empty($i_page)) {
			$i_page = 1;
		}
		// 设置每页显示的数据行数
		$i_prow = 10;
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数
		$a_where = [
			'user_id' => $user_id
		];
		$i_total = $this->db->get_total('userbalance', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);

		$s_field = '';
		$a_order = [
			'ub_id' => 'desc'
		];
		$a_data = $this->db->get('userbalance', $a_where, $s_field, $a_order);

		// 验证是否超出最大页
		if ($page > ceil($i_total/$i_prow)) {
			return array();
		} else {
			return $a_data;
		}
	}

/********************************* 更新一条用户信息 ***********************************/

	/**
	 * [user_user 更新一条用户信息]
	 * @param  [type] $a_where [description]
	 * @param  [type] $a_data  [description]
	 * @return [type]          [description]
	 */
	public function update_user($a_where, $a_data) {
		$i_result = $this->db->update('user', $a_data, $a_where);
		return $i_result;
	}

/********************************* 插入一条变动信息 ***********************************/

	/**
	 * [insert_userbalance 插入一条变动信息]
	 * @param  [type] $a_data [description]
	 * @return [type]         [description]
	 */
	public function insert_userbalance($a_data) {
		$i_result = $this->db->insert('userbalance', $a_data);
		return $i_result;
	}

/********************************* 获取一条资金明细 ***********************************/

	/**
	 * [get_balance_one 获取一条资金明细]
	 * @return [type] [description]
	 */
	public function get_balance_one($ub_id) {
		$a_where = [
			'ub_id' => $ub_id
		];
		$a_data = $this->db->get_row('userbalance', $a_where);
		return $a_data;
	}

/********************************** 获取设置信息 *************************************/

	/**
	 * [get_set_all 获取设置信息]
	 * @return [type] [description]
	 */
	public function get_set_all() {
		$a_data = $this->db->get('set', [], '', [], 0, 99999999);
		return $a_data;
	}

/********************************* 插入一条积分记录 ***********************************/

	/**
	 * [insert_points_log 插入一条积分记录]
	 * @param  [type] $a_data [description]
	 * @return [type]         [description]
	 */
	public function insert_points_log($a_data) {
		$i_result = $this->db->insert('points_log', $a_data);
		return $i_result;
	}

/****************************** 验证是微信是否充值成功 ********************************/

	public function get_ub_second() {
		$a_where = [
			'user_id'   => $_SESSION['user_id'],
			'ub_type'   => 1,
			'ub_time >' => time()-5
		];
		$a_data = $this->db->get_row('userbalance', $a_where);
		return $a_data;
	}

/**************************************************************************************/


}

?>