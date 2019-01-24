<?php

class Newpay_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/*********************************** 获取一条设置信息 ***********************************/

	/**
	 * [get_set_one description]
	 * @return [type] [description]
	 */
	public function get_set_one($set_name) {
		$a_where = [
			'set_name' => $set_name
		];
		$a_data = $this->db->get_row('set', $a_where);
		return $a_data;
	}

/*********************************** 插入一条订单记录 ***********************************/

	/**
	 * [insert_order 插入一条订单记录s]
	 * @param  [type] $a_data [description]
	 * @return [type]         [description]
	 */
	public function insert_order($a_data) {
		$i_result = $this->db->insert('order', $a_data);
		return $i_result;
	}

/*********************************** 更新一条订单记录 ***********************************/

	/**
	 * [update_order 更新一条订单记录]
	 * @param  [type] $a_where [description]
	 * @param  [type] $a_data  [description]
	 * @return [type]          [description]
	 */
	public function update_order($a_where, $a_data) {
		$i_result = $this->db->update('order', $a_data, $a_where);
		return $i_result;
	}

/****************************** 根据订单号获取一条订单记录 ******************************/

	/**
	 * [get_order_bynumber 根据订单号获取一条订单记录]
	 * @return [type] [description]
	 */
	public function get_order_bynumber($pay_sn) {
		$a_where = [
			'pay_sn' => $pay_sn
		];
		$a_data = $this->db->get('order', $a_where, '', [], 0, 999999999);
		return $a_data;
	}

/*********************************** 获取一条用户信息 ***********************************/

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

/*********************************** 插入一条余额变动 ***********************************/

	/**
	 * [insert_userbalance description]
	 * @param  [type] $a_data [description]
	 * @return [type]         [description]
	 */
	public function insert_userbalance($a_data) {
		$i_result = $this->db->insert('userbalance', $a_data);
		return $i_result;
	}

/*********************************** 更新一条用户记录 ***********************************/

	/**
	 * [update_user 插入一条余额变动]
	 * @param  [type] $a_where [description]
	 * @param  [type] $a_data  [description]
	 * @return [type]          [description]
	 */
	public function update_user($a_where, $a_data) {
		$i_result = $this->db->update('user', $a_data, $a_where);
		return $i_result;
	}

/*********************************** 插入一条积分记录 ***********************************/

	/**
	 * [insert_points_log 插入一条积分记录]
	 * @param  [type] $a_data [description]
	 * @return [type]         [description]
	 */
	public function insert_points_log($a_data) {
		$i_result = $this->db->insert('points_log', $a_data);
		return $i_result;
	}

/*********************************** 插入一条订单商品 ***********************************/

	/**
	 * [insert_order_goods 插入一条订单商品]
	 * @param  [type] $a_data [description]
	 * @return [type]         [description]
	 */
	public function insert_order_goods($a_data) {
		$i_result = $this->db->insert('order_goods', $a_data);
		return $i_result;
	}

/*********************************** 插入一条订单商品 ***********************************/

	/**
	 * [get_cart_one 插入一条订单商品]
	 * @param  [type] $cart_id [description]
	 * @return [type]          [description]
	 */
	public function get_cart_one($cart_id) {
		$a_where = [
			'cart_id' => $cart_id
		];
		$a_data = $this->db->get_row('cart', $a_where);
		return $a_data;
	}

/*********************************** 插入一条订单商品 ***********************************/

	/**
	 * [delete_cart_mony 插入一条订单商品]
	 * @param  [type] $cart_arr [description]
	 * @return [type]           [description]
	 */
	public function delete_cart_mony($cart_arr) {
		$i_result = $this->db->where_in('cart_id', $cart_arr)->delete('cart');
		return $i_result;
	}

/********************************* 获取部分购物车信息 *********************************/

	/**
	 * [get_cart_part description]
	 * @return [type] [获取部分购物车信息]
	 */
	public function get_cart_part($car_not_store) {
		$a_where = [
			'user_id' => $_SESSION['user_id'],
		];
		$s_field = '';
		$a_order = [
			'cart_id' => 'desc'
		];
		$a_data = $this->db->where_in('cart_id', $car_not_store)
						   ->get('cart', $a_where, $s_field, $a_order, 0, 999999999);
		return $a_data;
	}

/********************************* 获取部分购物车信息 *********************************/

	/**
	 * [get_address_default 获取部分购物车信息]
	 * @return [type] [description]
	 */
	public function get_address_default($user_id) {
		$a_where = [
			'user_id'    => $user_id,
			'is_default' => 1,
		];
		$a_data = $this->db->get_row('address', $a_where);
		return $a_data;
	}

/********************************* 获取部分购物车信息 *********************************/

	/**
	 * [get_cart_store 获取部分购物车信息]
	 * @return [type] [description]
	 */
	public function get_cart_store($store_id, $cart_arr, $user_id) {
		$a_where = [
			'store_id' => $store_id,
			'user_id'  => $user_id
		];
		$s_field = '';
		$a_order = [
			'cart_id' => 'desc'
		];
		$a_data = $this->db->where_in('cart_id', $cart_arr)
						   ->get('cart', $a_where, $s_field, $a_order, 0, 999999999);
		return $a_data;
	}


/**************************** 获取部分带有分享者的购物车信息 ****************************/

	/**
	 * [get_cart_share 获取部分带有分享者的购物车信息]
	 * @param  [type] $share_userid [description]
	 * @param  [type] $cart_arr     [description]
	 * @param  [type] $user_id      [description]
	 * @return [type]               [description]
	 */
	public function get_cart_share($share_userid, $cart_arr, $user_id) {
		$a_where = [
			'share_userid' => $share_userid,
			'user_id'      => $user_id
		];
		$s_field = '';
		$a_order = [
			'cart_id' => 'desc'
		];
		$a_data = $this->db->where_in('cart_id', $cart_arr)
						   ->get('cart', $a_where, $s_field, $a_order, 0, 999999999);
		return $a_data;
	}

/******************************* 获取分享者分享的产品 *******************************/

	/**
	 * [get_qualifi_goods 获取分享者分享的产品]
	 * @param  [type] $user_id     [description]
	 * @param  [type] $product_arr [description]
	 * @return [type]              [description]
	 */
	public function get_qualifi_goods($user_id, $product_arr) {
		$a_where = [
			'user_id'      => $user_id
		];
		$s_field = '';
		$a_order = [
			'goo_id' => 'desc'
		];
		$a_data = $this->db->where_in('product_id', $product_arr)
						   ->get('qualifi_goods', $a_where, $s_field, $a_order, 0, 999999999);
		return $a_data;
	}

/****************************** 获取分享者分享的产品 ****************************/

	/**
	 * [get_goods_share description]
	 * @return [type] [description]
	 */
	public function get_goods_share($share_product_arr) {
		$a_where = [];
		$s_field = '';
		$a_order = [
			'goo_id' => 'desc'
		];
		$a_data = $this->db->where_in('product_id', $share_product_arr)
						   ->get('qualifi_goods', $a_where, $s_field, $a_order, 0, 999999999);
		return $a_data;
	}

/****************************** 获取分享者分享的产品 ****************************/

	/**
	 * [get_appointment_seat 获取分享者分享的产品]
	 * @param  [type] $appointment_arr [description]
	 * @return [type]                  [description]
	 */
	public function get_appointment_seat($appointment_arr) {
		$s_field = 'appointment_id,store_id,office_seatname,appointment_price,actual_pay';
		$a_order = [
			'appointment_id' => 'desc'
		];
		$a_where = [ 'ishave_deduction' => 1  ];
		$a_data = $this->db->where_in('appointment_id', $appointment_arr)
						   ->where_in('appointment_state',array(2,3))
						   ->get('appointment', $a_where, $s_field, $a_order, 0, 999999999);
		return $a_data;
	}

	/****************************** 修改已使用的订座 ****************************/

	/**
	 * [update_appointment_seat 修改已使用的订座]
	 * @return [type]                  [description]
	 */
	public function update_appointment_seat($appointment_id) {

		$a_where = ['ishave_deduction' => 1,'appointment_state' => 3];
		$update_field = ['ishave_deduction' => 2,'appointment_state' =>5,'officeseat_state' => 1];
		$a_data = $this->db->where_in('appointment_id',$appointment_id)->update("appointment", $update_field ,$a_where);
		
		return $a_data;
	}

/******************************* 将座位的服务状态改为服务中 *****************************/

	/**
	 * [update_appointment_inserver 将座位的服务状态改为服务中]
	 * @param  [type] $appointment_arr [description]
	 * @param  [type] $a_data          [description]
	 * @return [type]                  [description]
	 */
	public function update_appointment_inserver($appointment_arr, $a_data) {
		$i_result = $this->db->where_in('appointment_id',$appointment_arr)->update('appointment', $a_data);
		return $i_result;
	}

/*********************************** 获取一条产品信息 *********************************/

	/**
	 * [get_product_one description]
	 * @param  [type] $product_id [description]
	 * @return [type]             [description]
	 */
	public function get_product_one($product_id) {
		$a_where = [
			'product_id' => $product_id
		];
		$a_data = $this->db->get_row('product', $a_where);
		return $a_data;
	}

/********************************* 获取一条产品分享信息 *******************************/

	/**
	 * [get_qualifi_row 获取一条产品分享信息]
	 * @param  [type] $product_id [description]
	 * @return [type]             [description]
	 */
	public function get_qualifi_row($product_id) {
		$a_where = [
			'product_id' => $product_id
		];
		$a_data = $this->db->get_row('qualifi_goods', $a_where);
		return $a_data;
	}

/********************************* 获取一条门店记录信息 *******************************/

	/**
	 * [get_store_one 获取一条门店记录信息]
	 * @param  [type] $store_id [description]
	 * @return [type]           [description]
	 */
	public function get_store_one($store_id) {
		$a_where = [
			'store_id' => $store_id
		];
		$a_data = $this->db->get_row('store', $a_where);
		return $a_data;
	}

/********************************* 更新一条门店记录信息 *******************************/

	/**
	 * [update_store 更新一条门店记录信息]
	 * @param  [type] $a_where [description]
	 * @param  [type] $a_data  [description]
	 * @return [type]          [description]
	 */
	public function update_store($a_where, $a_data) {
		$i_result = $this->db->update('store', $a_data, $a_where);
		return $i_result;
	}

/********************************** 验证是否有新订单 ************************************/

	public function get_order_second() {
		$a_where = [
			'user_id' => $_SESSION['user_id'],
			'order_time >' => time()-3
		];
		$a_data = $this->db->get_row('order', $a_where);
		return $a_data;
	}

/****************************************************************************************/


/********************************** 验证是否有过期订单订单 ************************************/
//超过1小时的订单
	public function get_order_secondsss() {
		$a_where = [
			'user_id' => $_SESSION['user_id'],
			'order_time >' => time()-3
		];
		$a_data = $this->db->get_row('order', $a_where);
		return $a_data;
	}

/****************************************************************************************/



}

?>