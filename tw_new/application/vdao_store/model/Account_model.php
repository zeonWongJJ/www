<?php

class Account_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/************************************* 结算列表 *************************************/

	public function get_account_page($store_id, $state) {
		// 先设置默认从第一页开始
		$i_page = $this->router->get(3);
		if (empty($i_page)) {
			$i_page = 1;
		}
		// 设置每页显示的数据行数
		$i_prow = 10;
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数
		if ($state == 9) {
			$a_where = [
				'store_id' => $store_id
			];
		} else {
			$a_where = [
				'store_id'      => $store_id,
				'account_state' => $state
			];
		}
		$i_total = $this->db->get_total('account', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);

		$s_field = '';
		$a_order = [
			'account_id' => 'desc'
		];
		$a_data['account'] = $this->db->get('account', $a_where, $s_field, $a_order);
		$a_data['count']   = $i_total;
		return $a_data;
	}


/************************************* 最新的结算列表 *************************************/
	public function get_accounttbl_page($store_id, $state) {
		// 先设置默认从第一页开始
		$i_page = $this->router->get(3);
		if (empty($i_page)) {
			$i_page = 1;
		}
		// 设置每页显示的数据行数
		$i_prow = 10;
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数
		if ($state == 9) {
			$a_where = [
				'store_id' => $store_id
			];
		} else {
			$a_where = [
				'store_id'      => $store_id,
				'account_state' => $state
			];
		}
		$i_total = $this->db->get_total('accounttbl', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);

		$s_field = '';
		$a_order = [
			'account_date' => 'desc'
		];
		$a_data['account'] = $this->db->get('accounttbl', $a_where, $s_field, $a_order);
		$a_data['count']   = $i_total;
		return $a_data;
	}
/******************************* 获取门店所有结算数据 *******************************/

	/**
	 * [get_account_all 获取门店所有结算数据]
	 * @param  [int] $store_id  [传入的门店id]
	 * @return [array]          [返回查询到的数据]
	 */
	public function get_account_all($store_id) {
		$a_where = [
			'store_id' => $store_id
		];
		$s_field = '';
		$a_order = [
			'account_id' => 'desc'
		];
		$a_data = $this->db->get('account', $a_where, $s_field, $a_order);
		return $a_data;
	}

/********************************* 获取一条结算信息 *********************************/

	/**
	 * [get_account_one 获取一条结算信息]
	 * @param  [int]   $account_id [传入的获取的记录id]
	 * @return [array]             [返回查询到的数据信息]
	 */
	public function get_account_one($account_id) {
		$a_where = [
			'account_id' => $account_id
		];
		$a_data = $this->db->get_row('account', $a_where);
		return $a_data;
	}

	public function get_tbl_account_one($account_date) {
		$a_where = [
			'account_date' => $account_date,
			'store_id' => $_SESSION['store_id']
		];
		$a_data = $this->db->get_row('accounttbl', $a_where);
		return $a_data;
	}

/********************************** 获取月咖啡订单 **********************************/

	/**
	 * [get_month_order 获取月咖啡订单]
	 * @param  [array] $order_ids [订单id数组]
	 * @param  [array] $stye      [产品1，订座2]
	 * @return [array]            [返回查询到的数据]
	 */
	public function get_month_order($order_ids,$stye) {
		// 先设置默认从第一页开始
		$i_page = $this->router->get(2);
		if (empty($i_page)) {
			$i_page = 1;
		}

		// 设置每页显示的数据行数
		$i_prow = 10;
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数
		$i_total = count($order_ids['arr_oid']);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		if ($stye == 1) {
			$s_field = 'order_id, order_number, time_create, order_time, order_count, goods_amount';
			$a_order = [
				'order_id' => 'desc'
			];
			$a_data['order'] = $this->db->where_not_in('order_id', $order_ids['arr_oid'])->get('order', $a_where='', $s_field, $a_order);
		} else {
			$s_field = 'appointment_id, appointment_number, appointment_time, pay_time, appointment_price';
			$a_order = [
				'appointment_id' => 'desc'
			];
			$a_data['order'] = $this->db->where_in('appointment_id', $order_ids['arr_oid'])->get('appointment', $a_where, $s_field, $a_order);
		}
		$a_data['count'] = $i_total;
		$a_data['page']  = $i_page;
		$a_data['prow']  = $i_prow;
		return $a_data;
	}
	/**
	 * [get_month_order 获取月咖啡订单]
	 * @param  [int] $order_date [结算年月份]
	 * @param  [int] $stye      [产品1，订座2]
	 * @return [array]            [返回查询到的数据]
	 */	
	public function get_tbl_month_order($order_date,$stye) {
		// 先设置默认从第一页开始
		$i_page = $this->router->get(3);
		if (empty($i_page)) {
			$i_page = 1;
		}
		$order_date =substr($order_date, 0,4). '-'.substr($order_date, 4,2);
		$begin_order_date = $order_date.'-01 00:00:00';
		$begin_order_date = strtotime($begin_order_date);
		$end_order_date = time();
		// $a_where = [
		// 	'store_id' => $_SESSION['store_id'],
		// 	// 'order_state in' => '10,25,30,80',
		// 	'time_create >' => $begin_order_date,
		// 	'time_create <' => $end_order_date,
		// ];

		// // 设置每页显示的数据行数
		// $i_prow = 10;
		// // 加载分页类
		// $this->load->library('pages');
		// // 获取数据总行数
		// // $i_total = count($order_ids['arr_oid']);
		// if ($stye == 1) {
		// 	$s_field = 'order_id';
		// 	$i_total = count($this->db->where_in("order_state",[10,25,30,80])->get('order',$a_where,'','',0,99999999999));
		// 	// echo $this->db->get_sql();
		// } else {
		// 	$s_field = 'appointment_id';
		
		// 	$a_data['order'] = $this->db->where_in('appointment_id', $order_ids['arr_oid'])->get('appointment', $a_where, $s_field);
		// }

		// //调用分页运算函数
		// $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// // 开始获取产品数据
		// $this->db->limit($a_pdata['start'], $a_pdata['last']);
		// if ($stye == 1) {
		// 	$s_field = 'order_id, order_number, time_create, order_time, order_count, goods_amount';
		// 	$a_order = [
		// 		'order_id' => 'desc'
		// 	];
		// 	$a_data['order'] = $this->db->where_in("order_state",[10,25,30,80])->get('order', $a_where, $s_field, $a_order);
		// } else {
		// 	$s_field = 'appointment_id, appointment_number, appointment_time, pay_time, appointment_price';
		// 	$a_order = [
		// 		'appointment_id' => 'desc'
		// 	];
		// 	$a_data['order'] = $this->db->where_in('appointment_id', $order_ids['arr_oid'])->get('appointment', $a_where, $s_field, $a_order);
		// }
		//$stye =1获取餐饮订单的统计数据列表
		if($stye == 1) {
			$a_where = [
			'store_id' => $_SESSION['store_id'],
			'time_create >' => $begin_order_date,
			'time_create <' => $end_order_date,
			];	
			// 设置每页显示的数据行数
			$i_prow = 10;
			// 加载分页类
			$this->load->library('pages');	
			$s_field = 'order_id';
			$i_total = count($this->db->where_in("order_state",[10,80])->get('order',$a_where,'','',0,99999999999));
			// echo $this->db->get_sql();
			//调用分页运算函数
			$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
			// 开始获取产品数据
			$this->db->limit($a_pdata['start'], $a_pdata['last']);	
			$s_field = 'order_id, order_number, time_create, order_time, order_count, goods_amount';
			$a_order = [
				'order_id' => 'desc'
			];
			$a_data['order'] = $this->db->where_in("order_state",[10,80])->get('order', $a_where, $s_field, $a_order);												

		} else {
			$a_where = [
			'store_id' => $_SESSION['store_id'],
			'pay_time >' => $begin_order_date,
			'pay_time <' => $end_order_date,
			'appointment_type' => 1,

			];	
			// 设置每页显示的数据行数
			$i_prow = 10;
			// 加载分页类
			$this->load->library('pages');	
			$s_field = 'appointment_id';
			$i_total = count($this->db->where_in("appointment_state", [2,3,4,5])->get('appointment',$a_where,'','',0,99999999999));
			// echo $this->db->get_sql();
			//调用分页运算函数
			$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
			// 开始获取产品数据
			$this->db->limit($a_pdata['start'], $a_pdata['last']);	
			$s_field = 'appointment_id, appointment_number, pay_time, appointment_price';
			$a_order = [
				'appointment_id' => 'desc'
			];
			$a_data['order'] = $this->db->where_in("appointment_state", [2,3,4,5])->get('appointment', $a_where, $s_field, $a_order);					

		}


		$a_data['count'] = $i_total;
		$a_data['page']  = $i_page;
		$a_data['prow']  = $i_prow;
		return $a_data;
	}

/***************************** 获取不同状态下的结算条数 *****************************/

	public function get_total_state($account_state) {
		$a_where = [
			'account_state' => $account_state,
			'store_id'      => $_SESSION['store_id'],
		];
		$i_result = $this->db->get_total('account', $a_where);
		return $i_result;
	}


	public function get_tbl_total_state($account_state) {
		$a_where = [
			'account_state' => $account_state,
			'store_id'      => $_SESSION['store_id'],
		];
		$i_result = $this->db->get_total('accounttbl', $a_where);
		return $i_result;
	}

/************************************************************************************/

}

?>