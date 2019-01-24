<?php

class Sousou_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/******************************** 根据关键词获取门店 ********************************/

	/**
	 * [get_store_search 根据关键词获取产品]
	 * @param  [string] $keywords [传入的关键词]
	 * @return [array]            [返回查询到的数据]
	 */
	public function get_store_search($keywords) {
		$a_where = [
			'store_state' => 1,
			'store_name LIKE' => '%'.$keywords.'%'
		];
		$s_field = '';
		$a_order = [
			'store_id' => 'asc'
		];
		$a_data = $this->db->get('store', $a_where, $s_field, $a_order);
		return $a_data;
	}

/******************************** 根据关键词获取门店 ********************************/

	/**
	 * [get_product_search 根据关键词获取门店]
	 * @param  [string] $keywords [传入的关键词]
	 * @return [array]            [返回查询到的数据]
	 */
	public function get_product_search($keywords) {
		$a_where = [
			'product_name LIKE' => '%'.$keywords.'%',
		];
		$a_where_or = [
			'antistop LIKE' => '%'.$keywords.'%',
		];
		$s_field = '';
		$a_order = [
			'product_id' => 'desc'
		];
		$a_data = $this->db->where($a_where)->where_or( $a_where_or )->get('product', NULL, $s_field , $a_order);
		return $a_data;
	}

/************************************************************************************/

}

?>