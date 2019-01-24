<?php

class News_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/*********************************** 新闻列表 ***********************************/

	/**
	 * [get_news_all 获取所有显示的新闻信息]
	 * @return [array] [返回查询到的所有数据]
	 */
	public function get_news_page($page, $cate_arr) {
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
			'news_state' => 1
		];
		$i_total = $this->db->where_in('cate_id', $cate_arr)->get_total('news', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);

		$a_order = [
			'news_id' => 'desc'
		];
		$a_data = $this->db->where_in('cate_id', $cate_arr)->get('news', $a_where, '', $a_order);

		// 判断是否超过总页数
		if ($page > ceil($i_total/$i_prow)) {
			return array();
		} else {
			return $a_data;
		}
	}

/*********************************** 新闻分类 ***********************************/

	/**
	 * [get_cate_all 新闻分类]
	 * @return [type] [description]
	 */
	public function get_cate_all() {
		$a_where = [
			'is_show' => 1
		];
		$s_field = '';
		$a_order = [
			'cate_id' => 'desc'
		];
		$a_data = $this->db->get('cate', $a_where, $s_field, $a_order, 0, 999999999);
		return $a_data;
	}

/********************************* 获取一条分类 *********************************/

	/**
	 * [get_cate_one 获取一条分类]
	 * @param  [type] $cate_id [description]
	 * @return [type]          [description]
	 */
	public function get_cate_one($cate_id) {
		$a_where = [
			'cate_id' => $cate_id
		];
		$a_data = $this->db->get_row('cate', $a_where);
		return $a_data;
	}

/*********************************** 新闻详情 ***********************************/

	/**
	 * [get_news_one 新闻详情]
	 * @param  [int]   $news_id [传入的新闻id]
	 * @return [array]          [返回查询到的数据]
	 */
	public function get_news_one($news_id) {
		$a_where = [
			'news_id' => $news_id
		];
		$a_data = $this->db->get_row('news', $a_where);
		return $a_data;
	}

/********************************************************************************/

}

?>