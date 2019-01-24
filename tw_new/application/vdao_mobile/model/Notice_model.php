<?php

class Notice_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/*********************************** 公告列表 ***********************************/

	public function get_notice_page($i_page) {
		// 设置每页显示的数据行数
		$i_prow = 10;
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数
		$a_where = [
			'notice_state' => 1
		];
		$i_total = $this->db->get_total('notice', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);

		$a_order = [
			'notice_id' => 'desc'
		];
		$a_data = $this->db->get('notice', $a_where, '', $a_order);

		// 判断是否超出总页数
		if ($i_page > ceil($i_total/$i_prow)) {
			return array();
		} else {
			return $a_data;
		}
	}

/*********************************** 公告详情 ***********************************/

	/**
	 * [notice_detail 获取一条公告信息]
	 * @param  [int] $notice_id   [传入的公告id]
	 * @return [array]            [返回查询到的数据]
	 */
	public function get_notice_one($notice_id) {
		$a_where = [
			'notice_id' => $notice_id
		];
		$a_data = $this->db->get_row('notice', $a_where);
		return $a_data;
	}

/********************************************************************************/

}

?>