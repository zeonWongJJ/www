<?php
defined('BASEPATH') OR exit('禁止访问！');
date_default_timezone_set('PRC'); 
class Money_ctrl extends TW_Controller {


	public function __construct() {
		parent :: __construct();	
		$this->prefix = $this->db->get_prefix();
		$this->load->model('login_model');
	}
	
	//资产中心
	public function money() {
		
		//判断是否登录
		$this->login_model->login();
		
		//获取参数
		$s_while = $this->router->get(1) ? $this->router->get(1) : 0;
		$i_page = $this->router->get(2) ? $this->router->get(2) : 1;
		$a_data = [
				's_while' => $s_while,
				'i_page' => $i_page
		];

		//实例化index模型
		$this->load->model('index_model');

		//获取优惠券的数量
		$a_data['voucher'] = $this->index_model->voucher();

		//获取用户信息
		$a_data['userinfo'] = $this->index_model->index_userinfo();
		
		// 获取余额记录
		$a_data['balance'] = $this->index_model->balance($s_while);
		$this->view->display('money', $a_data);
	}

	//获取消费记录
	public function consume() {
		//判断是否登录
		$this->login_model->login();

		//获取参数
		$s_while = $this->router->get(1) ? $this->router->get(1) : 0;
		$i_page = $this->router->get(2) ? $this->router->get(2) : 1;
		$a_data = [
				's_while' => $s_while,
				'i_page' => $i_page
		];

		//实例化index模型
		$this->load->model('index_model');
		
		//获取优惠券的数量
		$a_data['voucher'] = $this->index_model->voucher();

		//获取用户信息
		$a_data['userinfo'] = $this->index_model->index_userinfo();

		//获取消费记录
		$a_data['consume'] = $this->index_model->consume();
		$this->view->display('consume', $a_data); 
	}

	//获取充值记录
	public function recharge() {
		//判断是否登录
		$this->login_model->login();

		//获取参数
		$s_while = $this->router->get(1) ? $this->router->get(1) : 0;
		$i_page = $this->router->get(2) ? $this->router->get(2) : 1;
		$a_data = [
				's_while' => $s_while,
				'i_page' => $i_page
		];

		//实例化index模型
		$this->load->model('index_model');
		
		//获取优惠券的数量
		$a_data['voucher'] = $this->index_model->voucher();

		//获取用户信息
		$a_data['userinfo'] = $this->index_model->index_userinfo();

		//获取充值记录
		$a_data['res'] = $this->index_model->recharge();
		$this->view->display('recharge', $a_data); 
	}

	//提现记录
	public function deposit() {
		//判断是否登录
		$this->login_model->login();

		//获取参数
		$s_while = $this->router->get(1) ? $this->router->get(1) : 0;
		$i_page = $this->router->get(2) ? $this->router->get(2) : 1;
		$a_data = [
				's_while' => $s_while,
				'i_page' => $i_page
		];

		//实例化index模型
		$this->load->model('index_model');
		
		//获取优惠券的数量
		$a_data['voucher'] = $this->index_model->voucher();

		//获取用户信息
		$a_data['userinfo'] = $this->index_model->index_userinfo();

		//获取提现记录
		$a_data['res'] = $this->index_model->deposit();
		$this->view->display('deposit', $a_data); 
	}

	//我的订单
	public function order_form() {				
		//判断是否登录
		$this->login_model->login();

		$i_indent = $this->router->get(1) ? $this->router->get(1) : 0;
		$i_status = $this->router->get(2) ? $this->router->get(2) : 1;
		$i_page = $this->router->get(3) ? $this->router->get(3) : 1;
			$a_data = [
				'i_indent' => $i_indent,
				'i_status' => $i_status,
				'i_page' => $i_page
			];	

			if ($i_status == 1) {
				$i_status = 0;
				$abc = ' >=';
			} else if ($i_status == 2) {
				$i_status = 0;
			} else {
				$i_status = $i_status;
			}

			if ($i_indent == 1) {
				$s_while_start = strtotime('2017-1-1');
				$s_while_end   = $_SERVER['REQUEST_TIME'];
			} else if ($i_indent == 2) {
				$s_while_start = strtotime('2016-1-1');
				$s_while_end   = strtotime('2016-12-31');
			} else if ($i_indent == 3) {
				$s_while_start = strtotime('2015-1-1');
				$s_while_end   = strtotime('2015-12-31');
			} else if ($i_indent == 4) {
				$s_while_start = strtotime('2014-1-1');
				$s_while_end   = strtotime('2014-12-31');
			} else if ($i_indent == 5) {
				$s_while_start = strtotime('1970-1-1');
				$s_while_end   = strtotime('2014-1-1');
			}	

			// 获取三个月前时间戳
			if( ! empty($s_while_start) && ! empty($s_while_start)) {
				$a_where = ['buyer_id' => $_SESSION['user_id'], 'time_create >' => $s_while_start, 'time_create <' => $s_while_end, 'order_state' . $abc => $i_status];
			} else {
				// $i_stamp = $_SERVER['REQUEST_TIME'] - 7776000;

				$a_where = ['buyer_id' => $_SESSION['user_id'], 'time_create <' => $_SERVER['REQUEST_TIME'] , 'order_state' . $abc => $i_status];
			}
		$a_select = ['order_id', 'buyer_name', 'order_amount', 'order_state', 'store_name', 'time_create', 'order_sn', 'store_id', 'shipping_fee'];		

		// 加载分页类
		$this->load->library('pages');
		//页面数据显示和条件
		$i_canshu = $this->router->get(3) ? $this->router->get(3) : '1';
		// 获取数据总行数，以产品为例
		$i_total = $this->db->get_total('order', $a_where, $a_select);			
   		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_canshu, 7);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		//数据
		$a_data['order'] = $this->db->order_by(['order_id' => 'desc'])->get('order', $a_where, $a_select);
		// echo $this->db->get_sql();
		// var_dump($a_data['order']); 
		
		//显示页
		$a_data['page'] = $this->pages->link_style_one($this->router->url("order_form-" . $i_indent . "-" . $i_status . "-", [], false, false));

		//产品的副信息
		$a_data['ord'] = $this->db
								->from('order as a')
								->join('order_goods', ['a.order_id' => $this->prefix.'order_goods.order_id'])
								->select(['a.order_id', 'a.store_id', 'goods_name', 'goods_price', 'goods_image', 'goods_pay_price', 'goods_id', 'goods_num'])						
								->limit(0, 100000) 
								->get('', ['a.buyer_id' => $_SESSION['user_id']]);
		
		$s_fields = 'order_state,count(1) as num';
		$s_group_by = 'order_state';
		$a_wher = ['buyer_id'=>$_SESSION['user_id']];

		$a_data_result = $this->db
				 	   ->select($s_fields,false)
				 	   ->group_by($s_group_by)
				       ->get('order', $a_wher);

		foreach($a_data_result as $key => $value){
			$a_result[$value['order_state']] = $value['num'];
		}

		// 显示未付款条数
   		$a_data['arrearage'] = isset($a_result['10']) ? intval($a_result['10']) : 0;
   		//显示未发货条数
   		$a_data['shipments'] = isset($a_result['20']) ? intval($a_result['20']) : 0;
   		//显示未确认条数
   		$a_data['delive'] = isset($a_result['30']) ? intval($a_result['30']) : 0;
   		//显示成交条数
   		$a_data['make'] = isset($a_result['40']) ? intval($a_result['40']) : 0;

		$this->view->display('order_form', $a_data); 
	}	

	//订单状态
	public function order_confirm() {
		//订单的确定
		$i_id = $this->general->post('abc');   		
		if(isset($i_id)){
			 $a_name = [
            	'order_id' => $i_id, 
            	'log_msg' => '签收了货物', 
            	'log_time' => $_SERVER['REQUEST_TIME'], 
            	'log_role' => '买家',
            	'log_user' => $_SESSION['user_name'],
            	'log_orderstate' => 40
            ];
            $this->db->insert('order_log', $a_name);
			$a_confirm = $this->db->update('order', ['order_state' => 40], ['order_id' => $i_id]);		
			if ( ! empty($a_confirm)) {
				echo 123;
				die;
			} 
		}	
		//未付款的取消
		$i_non = $this->general->post('non');
		if(isset($i_non)){	
		$a_name = [
            	'order_id' => $i_non, 
            	'log_msg' => '取消了订单', 
            	'log_time' => $_SERVER['REQUEST_TIME'], 
            	'log_role' => '买家',
            	'log_user' => $_SESSION['user_name'],
            	'log_orderstate' => 0
            ];  		
            $this->db->insert('order_log', $a_name);				
	   		$a_non = $this->db->update('order', ['order_state' => 0], ['order_id' => $i_non]);		
			if ( ! empty($a_non)) {
				echo 88;
				die;
			}
		}
	}	
}
