<?php
defined('BASEPATH') or exit('禁止访问！');
class Order_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('order_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/**************************************** 总订单列表 ****************************************/

	public function order_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->order_model->get_store_all();
			// print_r($a_data);
			$this->view->display('order_showlist', $a_data);
		}
	}

/*************************************** 办公室订单 ***************************************/

	public function order_office() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收门店id
			$store_id = $this->router->get(1);
			$state = $this->router->get(2);
			if (empty($state)) {
				$state = 'all';
			}
			$appointment_type = 1;
			$a_data = $this->order_model->get_appointment_page($store_id, $state, $appointment_type);
			// 获取不同状态的订单总数
			$a_data['state_one']   = $this->order_model->get_state_count(1, $store_id, $appointment_type);
			$a_data['state_two']   = $this->order_model->get_state_count(2, $store_id, $appointment_type);
			$a_data['state_three'] = $this->order_model->get_state_count(3, $store_id, $appointment_type);
			$a_data['state_five']  = $this->order_model->get_state_count(5, $store_id, $appointment_type);
			$a_data['state_six']  = $this->order_model->get_state_count(6, $store_id, $appointment_type);
			// 门店基本信息
			$a_data['store'] = $this->order_model->get_store_one($store_id);
			// 获取门店所有的房间
			$a_data['office'] = $this->order_model->get_store_office($store_id);
			// 查询今日的预约数
			$a_data['today_order'] = $this->order_model->get_appointment_today($store_id);
			// 订单总数
			$a_data['all_order'] = $this->order_model->get_appointment_total($store_id);
			// 日均预约
			$daycount = ceil((time()-$a_data['store']['store_regtime'])/(3600*24));
			$a_data['average_order'] = sprintf("%.1f",$a_data['all_order']/$daycount);
			$a_data['ofid']   = 'all';
			$a_data['state']  = $state;
			$a_data['type']   = 99;
			$this->view->display('order_office2', $a_data);
		}
	}

/************************************* 搜索办公室订单 *************************************/

	public function appointment_search() {
		// 接收关键词
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$store_id  = trim($this->general->post('store_id'));
			$keywords  = trim($this->general->post('keywords'));
			$office_id = trim($this->general->post('office_id'));
			$state     = trim($this->general->post('appointment_state'));
		} else {
			$store_id  = $this->router->get(1);
			$office_id = $this->router->get(2);
			$state     = $this->router->get(3);
			$keywords  = urldecode($this->router->get(4));
		}
		if (empty($keywords)) {
			$keywords = 9;
		}
		$a_data = $this->order_model->get_appointment_search($store_id, $keywords, $office_id, $state, 1);
		// 获取不同状态的订单总数
		$a_data['state_one']   = $this->order_model->get_state_count(1, $store_id, 1);
		$a_data['state_two']   = $this->order_model->get_state_count(2, $store_id, 1);
		$a_data['state_three'] = $this->order_model->get_state_count(3, $store_id, 1);
		$a_data['state_five']  = $this->order_model->get_state_count(5, $store_id, 1);
		$a_data['state_six']   = $this->order_model->get_state_count(6, $store_id, 1);
		// 门店基本信息
		$a_data['store'] = $this->order_model->get_store_one($store_id);
		// 获取门店所有的房间
		$a_data['office']   = $this->order_model->get_store_office($store_id);
		// 查询今日的预约数
		$a_data['today_order'] = $this->order_model->get_appointment_today($store_id);
		// 订单总数
		$a_data['all_order'] = $this->order_model->get_appointment_total($store_id);
		// 日均预约
		$daycount = ceil((time()-$a_data['store']['store_regtime'])/(3600*24));
		$a_data['average_order'] = sprintf("%.1f",$a_data['all_order']/$daycount);
		$a_data['keywords'] = $keywords;
		$a_data['ofid']     = $office_id;
		$a_data['state']    = $state;
		$a_data['type']     = 88;
		$this->view->display('order_office2', $a_data);
	}

/************************************** 咖啡订单 ******************************/
	public function order_coffee() {
		$store_id = $this->router->get(1);
		$i_order  = $this->router->get(2) ? $this->router->get(2) : 0;
		//页面数据显示和条件
		$i_canshu = $this->router->get(3) ? $this->router->get(3) : '1';
		if (empty($store_id)) {
			$this->error->show_error('无效参数', 'order_showlist', false, 1);
		}
		$a_data = [
			'store_id' => $store_id,
			'i_order'  => $i_order,
			'i_canshu' => $i_canshu,
		];
		$a_data['store'] = $this->db->get_row('store', ['store_id' => $store_id]);
		$a_where = "`store_id` = $store_id";
		if ( ! empty($i_order)) {
			if ($i_order == 55) {
				$a_where .= ($a_where ? ' AND ' : '') . "`order_state` < 2";
			} else if ($i_order == 10 || $i_order == 80) {
				$a_where .= ($a_where ? ' AND ' : '') . "`order_state` IN ('10','80')";
			} else {
				$a_where .= ($a_where ? ' AND ' : '') . "`order_state` = $i_order";
			}

		}
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数，以产品为例
		$a_data['i_total'] = $this->db->get_total('order', $a_where);
   		// 调用分页运算函数
		$a_pdata = $this->pages->get($a_data['i_total'], $i_canshu, 7);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		//数据
		$a_data['order'] = $this->db->from('order as a')
									->join('user as b', ['a.user_id' => 'b.user_id'])
									->order_by(['order_id' => 'desc'])
									->get('', $a_where);
		// echo $this->db->get_sql();
		//显示页
		$a_data['page']  = $this->pages->link_style_one($this->router->url('order_coffee-'.$store_id.'-'.$i_order, [''], false, false));
		$a_data['goods'] = $this->db->order_by(['rec_id' => 'desc'])->limit(0, 999999999)->get('order_goods');
		//各订单数
		$s_fields = 'order_state,count(1) as num';
		$s_group_by = 'order_state';
		$a_wher = ['store_id' => $store_id];
		$a_data_result = $this->db
				 	   ->select($s_fields,false)
				 	   ->group_by($s_group_by)
				       ->get('order', $a_wher);
		foreach($a_data_result as $key => $value) {
			$a_result[$value['order_state']] = $value['num'];
		}
		// 显示待付款条数
   		$a_data['payment'] = isset($a_result['40']) ? intval($a_result['40']) : 0;
   		// 显示待接单条数
   		$a_data['waiting']  = isset($a_result['20']) ? intval($a_result['20']) : 0;
   		// 显示待配送条数
   		$a_data['shipping'] = isset($a_result['25']) ? intval($a_result['25']) : 0;
   		// 显示配送中条数
   		$a_data['distribu'] = isset($a_result['30']) ? intval($a_result['30']) : 0;
		$this->view->display('order_coffee', $a_data);
	}

/*************************************** 订单详情 ******************************************/

	public function order_details() {
		$i_id     = $this->general->post('id');
		$s_field  = 'a.order_number, a.time_create, a.reciver_name, a.addres, a.mob_phone, b.product_name, b.cup_id, b.goods_num, b.money, a.use_points, a.payment_code, b.cup_name,a.time_delay,a.shipping_fee,a.actual_pay';
		$a_data   = $this->db->from('order as a')
							->join('order_goods as b', ['a.order_id' => 'b.order_id'])
							->get('', ['a.order_id' => $i_id], $s_field);
		echo json_encode($a_data);
	}

/************************************** 座位订单 ******************************************/

	public function book_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收门店id
			$store_id = $this->router->get(1);
			$state = $this->router->get(2);
			// 获取门店所有的订座订单
			if (empty($state)) {
				$state = 'all';
			}
			$appointment_type = 2;
			$a_data = $this->order_model->get_appointment_page($store_id, $state, $appointment_type);
			// 获取不同状态的订单总数
			$a_data['state_one']   = $this->order_model->get_state_count(1, $store_id, $appointment_type);
			$a_data['state_two']   = $this->order_model->get_state_count(2, $store_id, $appointment_type);
			$a_data['state_three'] = $this->order_model->get_state_count(3, $store_id, $appointment_type);
			$a_data['state_five']  = $this->order_model->get_state_count(5, $store_id, $appointment_type);
			$a_data['state_six']  = $this->order_model->get_state_count(6, $store_id, $appointment_type);
			$a_data['state'] = $state;
			$a_data['store_id'] = $store_id;
			$this->view->display('book_showlist', $a_data);
		}
	}

/************************************ 搜索座位订单 ****************************************/

	public function book_search() {
		// 接收关键词
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$store_id = trim($this->general->post('store_id'));
			$keywords = trim($this->general->post('keywords'));
			$seatkey  = trim($this->general->post('seatkey'));
			$state    = trim($this->general->post('appointment_state'));
		} else {
			$store_id = $this->router->get(1);
			$seatkey  = urldecode($this->router->get(2));
			$state    = $this->router->get(3);
			$keywords = urldecode($this->router->get(4));
		}
		if (empty($keywords)) {
			$keywords = 'all';
		}
		if (empty($seatkey)) {
			$seatkey = 'all';
		}
		$state = 'all'; // 临时重置[搜索所有状态下的订单]
		// 获取数据
		$a_data = $this->order_model->get_book_search($store_id, $keywords, $seatkey, $state, 2);
		$appointment_type = 2;
		// 获取不同状态的订单总数
		$a_data['state_one']   = $this->order_model->get_state_count(1, $store_id, $appointment_type);
		$a_data['state_two']   = $this->order_model->get_state_count(2, $store_id, $appointment_type);
		$a_data['state_three'] = $this->order_model->get_state_count(3, $store_id, $appointment_type);
		$a_data['state_five']  = $this->order_model->get_state_count(5, $store_id, $appointment_type);
		$a_data['state_six']  = $this->order_model->get_state_count(6, $store_id, $appointment_type);
		$a_data['keywords'] = $keywords;
		$a_data['seatkey']  = $seatkey;
		$a_data['state']    = $state;
		$a_data['store_id'] = $store_id;
		$a_data['type']     = 88;
		$this->view->display('book_showlist', $a_data);
	}

/******************************************************************************************/

}

?>