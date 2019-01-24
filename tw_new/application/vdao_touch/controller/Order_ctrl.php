<?php
date_default_timezone_set('PRC');
class Order_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('order_model');
		$this->load->model('order_toview_model');
		$this->load->model('modetr_model');
		$this->load->model('product_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
	}

/*********************************** 办公室订单 **********************************/

	public function order_office() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$state = $this->router->get(1);
			if ($state == '') {
				$state = 9;
			}
			//获取该用户的办公室预约订单
			$a_data['office'] = $this->order_model->get_appointment_user($_SESSION['user_id'], $state);
			$a_data['state'] = $state;
			$this->view->display('order_office2', $a_data);
		}
	}

/********************************* 办公室订单详情 ********************************/

	public function appoint_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要查看详情的订单id
			$appointment_id = $this->router->get(1);
			//根据id获取其详情信息
			$a_data = $this->order_model->get_appointment_one($appointment_id);
			//获取办公室设备信息
			$device_ids = $a_data['device_ids'];
			$device_ids = explode(',', $device_ids);
			$a_device = $this->order_model->get_room_device($device_ids);
			$a_data['device'] = '';
			foreach ($a_device as $key => $value) {
				$a_data['device'] .= $value['device_name'] . ' ';
			}
			$a_data['device'] = rtrim($a_data['device']);
			$this->view->display('appoint_detail2', $a_data);
		}
	}

/************************************ 用户产品订单 *********************************/

	public function goods_order() {
		$i_order  = $this->router->get(1) ? $this->router->get(1) : 0;
		$a_data = [
			'i_order'  => $i_order,
		];
		$a_where = "`user_id` = ".$_SESSION['user_id'];
		if ( ! empty($i_order)) {
			if ($i_order == 55) {
				$a_where .= ($a_where ? ' AND ' : '') . "`order_state` < 2";
			} else {
				$a_where .= ($a_where ? ' AND ' : '') . "`order_state` = $i_order";
			}

		}
		//获取该用户的产品订单
		$a_data['product'] = $this->db->from('order as a')
										->join('store as b', ['a.store_id' => 'b.store_id'])
										->get('', $a_where, '', ['order_id' => 'desc'], 0, 99999999);
		//订单的产品
		$a_data['goods']  = $this->order_model->product();
		$a_modetr = $this->modetr_model->modert();
		$a_wangc  = $this->modetr_model->wangc();
		$this->view->display('goods_order', $a_data);
	}

/********************************* 产品订单详情 **********************************/

	public function goods_list() {
		$i_id = $this->router->get(1);
		$a_data['list'] = $this->order_model->product_details($i_id);
		// print_r($a_data['list']);
		if (empty($a_data['list'])) {
			$this->error->show_error('非法访问！', 'user_order', '', 1);
		} else {

			$this->view->display('goods_list', $a_data);
		}
	}

/********************************* 订单追踪  ***********************************************/
	public function order_tracking() {
		$id = $this->router->get(1);
		$a_data = $this->order_toview_model->order_tracking($id);
		$this->view->display('order_tracking', $a_data);
	}

/********************************* 查看退款  ***********************************************/
	public function refund() {
		$id     = $this->router->get(1);
		$a_data = $this->order_toview_model->refund($id);
		$this->view->display('refund', $a_data);
	}
/********************************* 产品订单状态的反应 ****************************/

	public function order_confirm() {
		//未付款订单的取消
		$i_weifuk = $this->general->post('weifuk');
		if(!empty($i_weifuk)) {
			$a_data = $this->db->get_row('order', ['order_id' => $i_weifuk, 'order_state' => 40, 'user_id' => $_SESSION['user_id']]);
			if ( empty($a_data)) {
				echo json_encode(array('code'=> 8, 'usname' => '订单有误'));
				die;
			}
			$a_track = [
	    		'order_id'     => $i_weifuk,
	    		'order_number' => $a_data['order_number'],
	    		'name'		   => '订单已取消',
	    		'time'	       => $_SERVER['REQUEST_TIME'],
	    	];
			$this->db->insert('order_tracking', $a_track);
			//把返回的金额和积分返回给用户
			$a_user  = $this->db->get_row('user', ['user_id' => $_SESSION['user_id']]);
			$balance = $a_user['user_balance'] + $a_data['balance_deduction'];
			$score   = $a_user['user_score'] + $a_data['use_jife'];
			$a_usr   = [
				'user_score'   => $score,
				'user_balance' => $balance,
			];
			$this->db->update('user', $a_usr, ['user_id' => $_SESSION['user_id']]);
			// 增加会员积分表
			if( ! empty($a_data['use_jife'])){
				$a_jife = [
					'user_id'       => $_SESSION['user_id'],
					'user_name'     => $_SESSION['user_name'],
					'pl_type'       => 1,
					'pl_variation'  => $a_data['use_jife'],
					'pl_time'       => $_SERVER['REQUEST_TIME'],
					'pl_score'       => $score,
					'pl_description' => $a_data['order_number'].'退还积分',
					'pl_item'  		 => '退还积分',
					'pl_code'        => 7,
				];
				$this->db->insert('points_log', $a_jife);
			}
			// 用户资金明细表
			if ( ! empty($a_data['balance_deduction'])) {
				$a_userba = [
					'ub_type'    => 1,
					'ub_money'   => $a_data['balance_deduction'],
					'ub_balance' => $balance,
					'ub_time'    => $_SERVER['REQUEST_TIME'],
					'ub_item'    => '退还余额',
					'user_id'    => $_SESSION['user_id'],
					'ub_number'  => $a_data['order_number'],
					'ub_description' => $a_data['order_number'].'退还余额',
				];
				$this->db->insert('userbalance', $a_userba);
			}
			$a_name = [
            	'order_id' => $i_weifuk,
            	'log_msg'  => '取消了订单',
            	'log_time' => $_SERVER['REQUEST_TIME'],
            	'log_role' => '买家',
            	'log_user' => $_SESSION['user_name'],
            	'log_orderstate' => 0
            ];
            $this->db->insert('order_log', $a_name);
			$a_weifuk = $this->db->update('order', ['order_state' => 0, 'time_finnshed' => $_SERVER['REQUEST_TIME']], ['order_id' => $i_weifuk, 'user_id' => $_SESSION['user_id']]);
			if ($a_weifuk) {
			 	echo json_encode(array('code'=>50, 'usname' => '订单取消成功'));
			 	die;
			} else {
			 	echo json_encode(array('code'=>55, 'usname' => '订单取消失败'));
			 	die;
			}
		}
		//付款订单的取消
		$i_fukuan = $this->general->post('fukuan');
		if( ! empty($i_fukuan)) {
			$a_tert = $this->db->get_row('order', ['order_id' => $i_fukuan, 'order_state' => 20, 'user_id' => $_SESSION['user_id']]);
			if ( empty($a_tert)) {
				echo json_encode(array('code'=> 8, 'usname' => '订单有误'));
				die;
			}
			if ((time() - $a_tert['order_time']) > 600) {
				echo json_encode(array('code' => 5, 'usname' => '订单已过10分钟，不能取消订单！'));
				die;
			} else {
				// 退款加到退款记录表
				$this->db->insert('reimburse', ['order_id' => $a_tert['order_id'], 'order_number' => $a_tert['order_number'], 'reimburse' => '卖家退款', 'time' => $_SERVER['REQUEST_TIME']]);
				$a_track = [
		    		'order_id'     => $i_fukuan,
		    		'order_number' => $a_tert['order_number'],
		    		'name'		   => '订单已取消',
		    		'time'	       => $_SERVER['REQUEST_TIME'],
		    	];
		    	if ($a_tert['payment_code'] == 'online') {
					$this->db->insert('order_tracking', $a_track);
					//把返回的金额和积分返回给用户
					$a_user  = $this->db->get_row('user', ['user_id' => $_SESSION['user_id']]);
					$balance = $a_user['user_balance'] + $a_tert['balance_deduction'];
					$score   = $a_user['user_score'] + $a_tert['use_jife'];
					$a_usr   = [
						'user_score'   => $score,
						'user_balance' => $balance,
					];
					$this->db->update('user', $a_usr, ['user_id' => $_SESSION['user_id']]);
					// 增加会员积分表
					if( ! empty($a_tert['use_jife'])){
						$a_jife = [
							'user_id'       => $_SESSION['user_id'],
							'user_name'     => $_SESSION['user_name'],
							'pl_type'       => 1,
							'pl_variation'  => $a_tert['use_jife'],
							'pl_time'       => $_SERVER['REQUEST_TIME'],
							'pl_score'       => $score,
							'pl_description' => $a_tert['order_number'].'退还积分',
							'pl_item'  		 => '退还积分',
							'pl_code'        => 7,
						];
						$this->db->insert('points_log', $a_jife);
					}
					// 用户资金明细表
					if ( ! empty($a_tert['balance_deduction'])) {
						$a_userba = [
							'ub_type'    => 1,
							'ub_money'   => $a_tert['balance_deduction'],
							'ub_balance' => $balance,
							'ub_time'    => $_SERVER['REQUEST_TIME'],
							'ub_item'    => '退还余额',
							'user_id'    => $_SESSION['user_id'],
							'ub_number'  => $a_tert['order_number'],
							'ub_description' => $a_tert['order_number'].'退还余额',
						];
						$this->db->insert('userbalance', $a_userba);
					}
					$a_name = [
		            	'order_id' => $i_fukuan,
		            	'log_msg'  => '取消了订单',
		            	'log_time' => $_SERVER['REQUEST_TIME'],
		            	'log_role' => '买家',
		            	'log_user' => $_SESSION['user_name'],
		            	'log_orderstate' => 0
		            ];
		            $this->db->insert('order_log', $a_name);
					$a_weifuk = $this->db->update('order', ['order_state' => 0, 'time_finnshed' => $_SERVER['REQUEST_TIME']], ['order_id' => $i_fukuan, 'user_id' => $_SESSION['user_id']]);
					if ($a_weifuk) {
					 	echo json_encode(array('code'=>50, 'usname' => '订单取消成功'));
					 	die;
					} else {
					 	echo json_encode(array('code'=>55, 'usname' => '订单取消失败'));
					 	die;
					}
    			} else if ($a_tert['payment_code'] == 'alipay') {//支付宝
    				$this->load->library('alipay_wap');
					$a_data = [
						// 商户订单号，商户网站订单系统中唯一订单号，必填
						'out_trade_no' => $a_tert['pay_sn'],
						// 请求退款金额，必填
						'refund_amount' => $a_tert['actual_pay'],
						// 'refund_amount' => 0.01,
						'refund_reason' => '退款测试',
						// 退款交易号，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
						'out_request_no' => $a_tert['order_number'],
						'is_page' => false
					];
					$zhihu = $this->alipay_wap->refund($a_data);
					if ($zhihu['code'] == 10000) {
						// 退款加到退款记录表
						$this->db->insert('reimburse', ['order_id' => $a_tert['order_id'], 'order_number' => $a_tert['order_number'], 'reimburse' => '第三方处理中', 'time' => $_SERVER['REQUEST_TIME']]);
						$this->db->insert('order_tracking', $a_track);
						// 把订单状态改为取消
	    				$this->db->update('order', ['order_state' => 0, 'time_finnshed' => $_SERVER['REQUEST_TIME']], ['order_id' => $i_fukuan, 'user_id' => $_SESSION['user_id']]);
	    				if( ! empty($a_tert['use_jife'])){
		    				// 增加会员积分表
		    				$a_jife = [
		    					'pl_memberid'   => $_SESSION['user_id'],
		    					'pl_membername' => $a_tert['user_name'],
		    					'pl_adminid'    => $a_tert['store_id'],
		    					'pl_adminname'  => $a_tert['store_name'],
		    					'pl_points'	    => $a_tert['use_jife'],
		    					'pl_time_create' => $_SERVER['REQUEST_TIME'],
								'pl_status'      => 1,
								'pl_desc'  		 => '积分退还！',
								'pl_stage'  	 => '订单取消',
		    				];
							$this->db->insert('points_log', $a_jife);
	    				}
		    			//增加订单处理历史表
						$a_log = [
							'order_id' => $i_fukuan,
							'log_msg'  => $_SESSION['user_name'].'付款订单取消',
							'log_time' => $_SERVER['REQUEST_TIME'],
							'log_role' => '系统',
							'log_user' => $_SESSION['user_name'],
							'log_orderstate' => 0,
						];
						$this->db->insert('order_log', $a_log);
						// $a_logg = [
						// 	'order_id' => $i_fukuan,
						// 	'log_msg'  => '系统退款'.$a_tert['order_price'].'到支付宝成功！',
						// 	'log_time' => $_SERVER['REQUEST_TIME'],
						// 	'log_role' => '系统',
						// 	'log_user' => '系统',
						// 	'log_orderstate' => 5,
						// ];
						// $this->db->insert('order_log', $a_logg);

						//把返回的金额和积分返回给用户
						$a_user  = $this->db->get_row('user', ['user_id' => $_SESSION['user_id']]);
						$balance = $a_user['user_balance'] + $a_tert['balance_deduction'];
						$score   = $a_user['user_score'] + $a_tert['use_jife'];
						$a_usr   = [
							'user_score'   => $score,
							'user_balance' => $balance,
						];
						$this->db->update('user', $a_usr, ['user_id' => $_SESSION['user_id']]);
						// 增加会员积分表
						if( ! empty($a_tert['use_jife'])){
							$a_jife = [
								'user_id'       => $_SESSION['user_id'],
								'user_name'     => $_SESSION['user_name'],
								'pl_type'       => 1,
								'pl_variation'  => $a_tert['use_jife'],
								'pl_time'       => $_SERVER['REQUEST_TIME'],
								'pl_score'       => $score,
								'pl_description' => $a_tert['order_number'].'退还积分',
								'pl_item'  		 => '退还积分',
								'pl_code'        => 7,
							];
							$this->db->insert('points_log', $a_jife);
						}
						// 用户资金明细表
						if ( ! empty($a_tert['balance_deduction'])) {
							$a_userba = [
								'ub_type'    => 1,
								'ub_money'   => $a_tert['balance_deduction'],
								'ub_balance' => $balance,
								'ub_time'    => $_SERVER['REQUEST_TIME'],
								'ub_item'    => '退还余额',
								'user_id'    => $_SESSION['user_id'],
								'ub_number'  => $a_tert['order_number'],
								'ub_description' => $a_tert['order_number'].'退还余额',
							];
							$this->db->insert('userbalance', $a_userba);
						}
						echo json_encode(array('code' => 33, 'usname' => '退款成功！'));
						die;
					} else {
						echo json_encode(array('code' => 55, 'usname' => $zhihu['sub_msg']));
						die;
					}

    			} else if ($a_tert['payment_code'] == 'offline') {// 微信
					$a_data = [
						// 商户订单号和微信订单号必须二选一，同时设置时，优先使用微信订单号
						'out_trade_no' => $a_tert['pay_sn'],
						// 微信订单号
						'transaction_id' => '',
						// 商户退款单号（自定义的，单号唯一，用来识别退款记录的）
						'out_refund_no' => $a_tert['order_number'],
						// 订单金额，不是退款金额，以分为单位,
						'total_fee' => $a_tert['order_price']*100,
						// 'total_fee' => 1,
						// // 退款金额，以分为单位,
						'refund_fee' => $a_tert['actual_pay']*100,
						// 'refund_fee' => 1,
						// 通知地址，请参考支付实例完成退款的通知处理
						'notify_url' => $this->router->url('refund_notify'),

						'is_page' => false
					];
					$this->load->library('wxpay_h5', '', [$a_data]);
					$a_result = $this->wxpay_h5->refund();
					$this->db->insert('test', ['test_content' => json_encode($a_result)]);
					if ($a_result['return_code'] == 'SUCCESS') {
						// 退款加到退款记录表
						$this->db->insert('reimburse', ['order_id' => $a_tert['order_id'], 'order_number' => $a_tert['order_number'], 'reimburse' => '第三方处理中', 'time' => $_SERVER['REQUEST_TIME']]);
						$this->db->insert('order_tracking', $a_track);
						// 把订单状态改为取消
	    				$this->db->update('order', ['order_state' => 0, 'time_finnshed' => $_SERVER['REQUEST_TIME']], ['order_id' => $i_fukuan]);
		    			//增加订单处理历史表
						$a_log = [
							'order_id' => $i_fukuan,
							'log_msg'  => $_SESSION['user_name'].'付款订单取消',
							'log_time' => $_SERVER['REQUEST_TIME'],
							'log_role' => '系统',
							'log_user' => $_SESSION['user_name'],
							'log_orderstate' => 0,
						];
						$this->db->insert('order_log', $a_log);
						// $a_logg = [
						// 	'order_id' => $i_fukuan,
						// 	'log_msg'  => '系统退款'.$a_tert['actual_pay'].'到微信成功！',
						// 	'log_time' => $_SERVER['REQUEST_TIME'],
						// 	'log_role' => '系统',
						// 	'log_user' => '系统',
						// 	'log_orderstate' => 15,
						// ];
						// $this->db->insert('order_log', $a_logg);
						//把返回的金额和积分返回给用户
						$a_user  = $this->db->get_row('user', ['user_id' => $_SESSION['user_id']]);
						$balance = $a_user['user_balance'] + $a_tert['balance_deduction'];
						$score   = $a_user['user_score'] + $a_tert['use_jife'];
						$a_usr   = [
							'user_score'   => $score,
							'user_balance' => $balance,
						];
						$this->db->update('user', $a_usr, ['user_id' => $_SESSION['user_id']]);
						// 增加会员积分表
						if( ! empty($a_tert['use_jife'])){
							$a_jife = [
								'user_id'       => $_SESSION['user_id'],
								'user_name'     => $_SESSION['user_name'],
								'pl_type'       => 1,
								'pl_variation'  => $a_tert['use_jife'],
								'pl_time'       => $_SERVER['REQUEST_TIME'],
								'pl_score'       => $score,
								'pl_description' => $a_tert['order_number'].'退还积分',
								'pl_item'  		 => '退还积分',
								'pl_code'        => 7,
							];
							$this->db->insert('points_log', $a_jife);
						}
						// 用户资金明细表
						if ( ! empty($a_tert['balance_deduction'])) {
							$a_userba = [
								'ub_type'    => 1,
								'ub_money'   => $a_tert['balance_deduction'],
								'ub_balance' => $balance,
								'ub_time'    => $_SERVER['REQUEST_TIME'],
								'ub_item'    => '退还余额',
								'user_id'    => $_SESSION['user_id'],
								'ub_number'  => $a_tert['order_number'],
								'ub_description' => $a_tert['order_number'].'退还余额',
							];
							$this->db->insert('userbalance', $a_userba);
						}
						echo json_encode(array('code' => 33, 'usname' => $a_result['return_msg']));
						die;
					} else {
						echo json_encode(array('code' => 55, 'usname' => $a_result['return_msg']));
						die;
					}
    			} else if ($a_tert['payment_code'] == 'unionpay') { //银联
					$this->load->library('unionpay_geteway');
					$a_param = [
						// 订单号
						'id_order' => $a_tert['order_number']
					];
					$a_result = $this->unionpay_geteway->query($a_param);
					if ($this->unionpay_geteway->verify($a_result)) {
						if ($a_result['origRespCode'] == '00') {
							$a_param = [
								// 订单号
								'id_order' => $a_tert['order_number'],
								// 原消费的queryId，可以从查询接口或者通知接口中获取
								'id_query' => $a_result['queryId'],
								// （选填）交易金额，退货总金额需要小于或等于原消费
								'amount' => $a_tert['actual_pay'],
							];
							$a_result = $this->unionpay_geteway->refund($a_param);
							// 退款加到退款记录表
							$this->db->insert('reimburse', ['order_id' => $a_tert['order_id'], 'order_number' => $a_tert['order_number'], 'reimburse' => '第三方处理中', 'time' => $_SERVER['REQUEST_TIME']]);
							if ($this->unionpay_geteway->verify($a_result)) {
								if ($a_result['respCode'] == '00') {
									$this->db->insert('order_tracking', $a_track);
									// 把订单状态改为取消
				    				$this->db->update('order', ['order_state' => 0], ['order_id' => $id]);
				    				//把返回的金额和积分返回给用户
									$a_user  = $this->db->get_row('user', ['user_id' => $a_tert['user_id']]);
									$balance = $a_user['user_balance'] + $a_tert['balance_deduction'];
									$score   = $a_user['user_score'] + $a_tert['use_jife'];
									$a_usr   = [
										'user_score'   => $score,
										'user_balance' => $balance,
									];
									$this->db->update('user', $a_usr, ['user_id' => $a_tert['user_id']]);
									// 增加会员积分表
									if( ! empty($a_tert['use_jife'])){
										$a_jife = [
											'user_id'       => $a_tert['user_id'],
											'user_name'     => $a_tert['user_name'],
											'pl_type'       => 1,
											'pl_variation'  => $a_tert['use_jife'],
											'pl_time'       => $_SERVER['REQUEST_TIME'],
											'pl_score'       => $score,
											'pl_description' => $a_tert['order_number'].'退还积分',
											'pl_item'  		 => '退还积分',
											'pl_code'        => 7,
										];
										$this->db->insert('points_log', $a_jife);
									}
									// 用户资金明细表
									if ( ! empty($a_tert['balance_deduction'])) {
										$a_userba = [
											'ub_type'    => 1,
											'ub_money'   => $a_tert['balance_deduction'],
											'ub_balance' => $balance,
											'ub_time'    => $_SERVER['REQUEST_TIME'],
											'ub_item'    => '退还余额',
											'user_id'    => $a_tert['user_id'],
											'ub_number'  => $a_tert['order_number'],
											'ub_description' => $a_tert['order_number'].'退还余额',
										];
										$this->db->insert('userbalance', $a_userba);
									}
					    			//增加订单处理历史表
									$a_log = [
										'order_id' => $id,
										'log_msg'  => $_SESSION['user_name'].$cho.'付款订单取消',
										'log_time' => $_SERVER['REQUEST_TIME'],
										'log_role' => '系统',
										'log_user' => $_SESSION['user_name'],
										'log_orderstate' => 0,
									];
									$this->db->insert('order_log', $a_log);
									// $a_logg = [
									// 	'order_id' => $id,
									// 	'log_msg'  => $_SESSION['user_name'].'退款'.$a_tert['actual_pay'].'到银联成功！',
									// 	'log_time' => $_SERVER['REQUEST_TIME'],
									// 	'log_role' => '系统',
									// 	'log_user' => '系统',
									// 	'log_orderstate' => 5,
									// ];
									// $this->db->insert('order_log', $a_logg);
									echo json_encode(array('stuo' => 33, 'name' => '退款成功！'));
									die;
								}
							}
						}
					}
				}
			}
		}
		//订单确认
		$i_ensure = $this->general->post('ensure');
		if ( ! empty($i_ensure)) {
			$a_name = [
            	'order_id' => $i_ensure,
            	'log_msg' => '确认了收货',
            	'log_time' => $_SERVER['REQUEST_TIME'],
            	'log_role' => '买家',
            	'log_user' => $_SESSION['user_name'],
            	'log_orderstate' => 10
            ];
            $this->db->insert('order_log', $a_name);
			$a_ensure = $this->db->update('order', ['order_state' => 10], ['order_id' => $i_ensure, 'user_id' => $_SESSION['user_id']]);
			if ($a_ensure) {
			 	echo json_encode(array('code'=>20, 'usname' => '确认订单成功'));
			 	die;
			} else {
			 	echo json_encode(array('code'=>22, 'usname' => '确认订单失败'));
			 	die;
			}
		}
	}

/********************************* 取消办公室订单 *******************************/

	public function appointment_cancel() {
		//接收需要取消的订单id
		$appointment_id = trim($this->general->post('appointment_id'));
		// 获取一条预约信息
		$a_appointment = $this->order_model->get_appointment_one($appointment_id);
		$isrefund = true;
		if ($a_appointment['appointment_state'] > 0) {
			$isrefund = false;
			// 判断支付方式
			if ($a_appointment['pay_type'] == 1) {
				$this->load->library('alipay_wap');
				$a_data = [
					// 商户订单号，商户网站订单系统中唯一订单号，必填
					'out_trade_no'   => $a_appointment['appointment_number'],
					// 请求退款金额，必填
					'refund_amount'  => $a_appointment['actual_pay'],
					'refund_reason'  => '订单退款',
					// 退款交易号，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
					'out_request_no' => 'tk'.date('YmdHis', time()),
					'is_page'        => false
				];
				$result = $this->alipay_wap->refund($a_data);
				if ($result['code'] == 10000) {
					$isrefund = true;
				}
			} else if ($a_appointment['pay_type'] == 2) {
				$a_data = [
					// 商户订单号和微信订单号必须二选一，同时设置时，优先使用微信订单号
					'out_trade_no' => $a_appointment['appointment_number'],
					// 微信订单号
					'transaction_id' => '',
					// 商户退款单号（自定义的，单号唯一，用来识别退款记录的）
					'out_refund_no' => 'tk'.date('YmdHis', time()),
					// 订单金额，不是退款金额，以分为单位,
					'total_fee' => $a_appointment['actual_pay'] * 100,
					// 退款金额，以分为单位,
					'refund_fee' => $a_appointment['actual_pay'] * 100,
					// 通知地址，请参考支付实例完成退款的通知处理
					'notify_url' => $this->router->url('wxrefund_notify')
				];
				$this->load->library('wxpay_h5', '', [$a_data]);
				$a_result = $this->wxpay_h5->refund();
				if ($a_result['return_code'] == 'SUCCESS') {
					$isrefund = true;
				}
			} else if ($a_appointment['pay_type'] == 3) {
				$this->load->library('unionpay_geteway');
				$a_param = [
					// 订单号
					'id_order' => $a_appointment['appointment_number']
				];
				$a_result = $this->unionpay_geteway->query($a_param);
				if ($this->unionpay_geteway->verify($a_result)) {
					if ($a_result['origRespCode'] == '00') {
						$a_param = [
							// 订单号
							'id_order' => 'T'.$a_appointment['appointment_number'],
							// 原消费的queryId，可以从查询接口或者通知接口中获取
							'id_query' => $a_result['queryId'],
							// （选填）交易金额，退货总金额需要小于或等于原消费
							'amount' => $a_appointment['actual_pay'] * 100,
							// （选填）后台返回链接， 不传此参数将默认使用配置文件中的设置url
							'url_back' => $this->router->url('unionpay_refund_notify')
						];
						$a_result = $this->unionpay_geteway->refund($a_param);
						if ($this->unionpay_geteway->verify($a_result)) {
							if ($a_result['respCode'] == '00') {
								$isrefund = true;
							}
						}
					}
				}
			}
		}
		if ($isrefund == true) {
			$a_where = [
				'appointment_id' => $appointment_id
			];
			$a_data = [
				'appointment_state' => 6,
				'officeseat_state'  => 0,
				'who_cancel'        => 1,
				'cancel_time'       => $_SERVER['REQUEST_TIME'],
			];
			$i_result = $this->order_model->update_appointment($a_where, $a_data);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'取消订单成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'取消订单失败'));
			}
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'取消订单失败'));
		}
	}

/********************************* 结束办公室订单 *******************************/

	public function appointment_over() {
		//接收需要取消的订单id
		$appointment_id = trim($this->general->post('appointment_id'));
		$a_where = [
			'appointment_id' => $appointment_id
		];
		$a_data = [
			'appointment_state' => 4, // 结束后进入待评价状态
			'officeseat_state'  => 0  // 座位释放
		];
		$i_result = $this->order_model->update_appointment($a_where, $a_data);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'结束订单成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'结束订单失败'));
		}
	}

/********************************* 评价办公室订单 *******************************/

	public function appointment_comment() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$appointment_id     = trim($this->general->post('appointment_id'));
			$goods_score        = trim($this->general->post('goods_score'));
			$service_score      = trim($this->general->post('service_score'));
			$comment_content    = trim($this->general->post('comment_content'));
			$is_anonymous       = trim($this->general->post('is_anonymous'));
			$appointment_number = trim($this->general->post('appointment_number'));
			$comment_tags       = trim($this->general->post('comment_tags'));
			$comment_cate       = trim($this->general->post('comment_cate'));
			// 验证数据合法性
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'order_office',
				'log'      => false,
				'wait'     => 2,
			];
			if (empty($appointment_id) || empty($appointment_number) || empty($goods_score) || empty($service_score)) {
				$this->error->show_error($a_parameter);
			}
			// 标签评论内容评论必须有一项不为空
			if (empty($comment_content) && empty($comment_tags)) {
				$this->error->show_error($a_parameter);
			}
			if (empty($comment_content)) {
				$comment_empty = 2;
			} else {
				$comment_empty = 1;
			}
			// 安全性验证
			$a_appointment = $this->order_model->get_appointment_one($appointment_id);
			if ($a_appointment['user_id'] == $_SESSION['user_id']) {
				$store_id = $a_appointment['store_id'];
			} else {
				$a_parameter['msg'] = '非法访问';
				$this->error->show_error($a_parameter);
			}
			// 验证之前否评价过
			$i_total = $this->order_model->get_comment_total($appointment_id);
			if ($i_total > 0) {
				$a_parameter['msg'] = '已经评论过啦，不能再评价了';
				$this->error->show_error($a_parameter);
			}
			// 上传评论的图片
			if (!empty($_FILES['file']['name'])) {
				$file = $_FILES['file'];
				for ($i=0; $i < count($_FILES['file']); $i++) {
					$files[$i]['name']     = $file['name'][$i];
					$files[$i]['type']     = $file['type'][$i];
					$files[$i]['tmp_name'] = $file['tmp_name'][$i];
					$files[$i]['error']    = $file['error'][$i];
					$files[$i]['size']     = $file['size'][$i];
				}
				//允许上传的类型
				$allow = array('image/jpeg','image/jpg','image/png');
				//确定上传的目录
				$path = 'upload/comment';
				//确定文件上传的大小 1M
				$maxsize = 1048576;
				// 循环上传
				for ($i=0; $i<count($files); $i++) {
				    if ($files[$i]['error'] == 0) {
				        $file = $files[$i];
				        $names_res = $this->upload_img($file, $allow, $error, $path, $maxsize);
				        if ($names_res) {
				        	$names[] = $names_res;
				        }
				    }
				}
				if (!empty($names)) {
					$comment_pic = implode(',', $names);
					$comment_ispic = 1;
				} else {
					$comment_pic = '';
					$comment_ispic = 2;
				}
			} else {
				$comment_pic = '';
				$comment_ispic = 2;
			}
            //组装数据并保存到数据库
            $a_data = [
				'user_id'         => $_SESSION['user_id'],
				'object_id'       => $appointment_id,
				'store_id'        => $store_id,
				'goods_score'     => $goods_score,
				'service_score'   => $service_score,
				'comment_content' => $comment_content,
				'comment_pic'     => $comment_pic,
				'is_anonymous'    => $is_anonymous,
				'comment_time'    => $_SERVER['REQUEST_TIME'],
				'comment_type'    => 1,
				'order_number'    => $appointment_number,
				'comment_tags'    => $comment_tags,
				'comment_cate'    => $comment_cate,
				'comment_state'   => 0,
				'comment_empty'   => $comment_empty,
            ];
            $i_result = $this->order_model->insert_comment($a_data);
        	// 获取一条预约信息
        	$a_appointment_row = $this->order_model->get_appointment_one($appointment_id);
        	if ($a_appointment_row['appointment_type'] == 1) {
        		$a_parameter['url'] = 'order_office';
        	} else {
        		$a_parameter['url'] = 'book_order';
        	}
            if ($i_result) {
            	// 评论成功后将订单状态改为已完成
            	$a_where = [
            		'appointment_id' => $appointment_id
            	];
            	$a_order = [
					'appointment_state' => 5,
            	];
            	$this->order_model->update_appointment($a_where, $a_order);
            	// 获取门店所有的评论
            	$a_comment_all = $this->order_model->get_comment_store($store_id);
            	$goods_score = 0;
            	$service_score = 0;
            	foreach ($a_comment_all as $key => $value) {
					$goods_score   = $goods_score + $value['goods_score'];
					$service_score = $service_score + $value['service_score'];
            	}
            	if (($goods_score + $service_score) > 0) {
            		$store_star = round(($goods_score + $service_score)/(count($a_comment_all)*2),1);
            	}
            	$a_where_w = [
            		'store_id' => $store_id
            	];
            	$a_data_d = [
            		'store_star' => $store_star
            	];
            	// 重新更新门店星级
            	$this->order_model->update_store($a_where_w, $a_data_d);
            	$a_parameter['msg'] = '评论成功';
            	$this->error->show_success($a_parameter);
            } else {
            	$a_parameter['msg'] = '评论失败';
            	$this->error->show_error($a_parameter);
            }
		} else {
			// 接收需要评价的订单id
			$appointment_id = $this->router->get(1);
			//获取订单信息
			$a_data['detail'] = $this->order_model->get_appointment_one($appointment_id);
			// 获取评价标签
			$a_data['comtag'] = $this->order_model->get_comtag_all($a_data['detail']['store_id']);
			$this->view->display('comment_office', $a_data);
		}
	}

/********************************** 评价产品订单***********************************/

	public function order_evaluate() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$order_id        = trim($this->general->post('order_id'));
			$store_id        = trim($this->general->post('store_id'));
			$product_id      = $this->general->post('product_id');
			$comment_cate    = $this->general->post('comment_cate');
			$comment_tags    = $this->general->post('comment_tags');
			$comment_content = $this->general->post('comment_content');
			$is_anonymous    = $this->general->post('is_anonymous');
			$goods_score     = $this->general->post('goods_score');
			$service_score   = $this->general->post('service_score');
			for ($n=0; $n < count($comment_cate) ; $n++) {
				// 上传动态图片
				if (!empty($_FILES['file']['name'][$n])) {
					$file    = $_FILES['file'];
					$allow   = array('image/jpeg','image/jpg','image/png');
					$path    = 'upload/mood';
					$maxsize = 1048576;
		            for ($i=0; $i < count($_FILES['file']['name']); $i++) {
		                $files[$i]['name']     = $file['name'][$n][$i];
		                $files[$i]['type']     = $file['type'][$n][$i];
		                $files[$i]['tmp_name'] = $file['tmp_name'][$n][$i];
		                $files[$i]['error']    = $file['error'][$n][$i];
		                $files[$i]['size']     = $file['size'][$n][$i];
		            }
		            for ($i=0; $i<count($files); $i++) {
		                if ($files[$i]['error'] == 0) {
							$file     = $files[$i];
							$img_path = $this->upload_img($file, $allow, $error, $path, $maxsize);
							if ($img_path) {
								$names[] = $img_path;
							}
		                }
		            }
		            if (!empty($names)) {
		            	$comment_pic = implode(',', $names);
		            } else {
		            	$comment_pic = '';
		            }
				} else {
					$comment_pic = '';
				}
	            //组装数据并保存到数据库
	            $a_data = [
					'user_id'         => $_SESSION['user_id'],
					'object_id'       => $product_id[$n],
					'store_id'        => $store_id,
					'goods_score'     => $goods_score,
					'service_score'   => $service_score,
					'comment_content' => $comment_content[$n],
					'comment_pic'     => $comment_pic,
					'is_anonymous'    => $is_anonymous,
					'comment_time'    => $_SERVER['REQUEST_TIME'],
					'comment_type'    => 2,
					'order_number'    => $order_id,
					'comment_tags'    => $comment_tags[$n],
					'comment_cate'    => $comment_cate[$n],
					'comment_state'   => 0,
					'comment_empty'   => 1,
	            ];
	            $i_result = $this->db->insert('comment', $a_data);
	            $a_prod = $this->db->get_row('comment_product', ['product_id' => $product_id[$n]]);
	            if (empty($a_prod)) {
	            	if ($comment_cate[$n] == 1) {
	            		$this->db->insert('comment_product', ['hao' => 1, 'product_id' => $product_id[$n]]);
	            	} else if ($comment_cate[$n] == 2) {
	            		$this->db->insert('comment_product', ['zhon' => 1, 'product_id' => $product_id[$n]]);
	            	} else if ($comment_cate[$n] == 3) {
	            		$this->db->insert('comment_product', ['cha' => 1, 'product_id' => $product_id[$n]]);
	            	}
	            } else {

					if ($comment_cate[$n] == 1) {
	            		$this->db->set('hao', 'hao +' . 1, false);
						$this->db->update('comment_product', '', ['product_id' => $product_id[$n]]);
	            	} else if ($comment_cate[$n] == 2) {
	            		$this->db->set('zhon', 'zhon +' . 1, false);
						$this->db->update('comment_product', '', ['product_id' => $product_id[$n]]);
	            	} else if ($comment_cate[$n] == 3) {
	            		$this->db->set('cha', 'cha +' . 1, false);
						$this->db->update('comment_product', '', ['product_id' => $product_id[$n]]);
	            	}
	            }
			}
			$this->product_model->comment();
            if ($i_result) {
            	//评论成功后将订单状态改为已完成
            	$this->db->update('order', ['order_state' => 80, 'evaluation_state' => 1], ['order_id' => $order_id, 'user_id' => $_SESSION['user_id']]);
/*
|-----------------------------------------------------------------------------
| 更新门店星级
|-----------------------------------------------------------------------------
 */
            	// 获取门店所有的评论
            	$a_comment_all = $this->order_model->get_comment_store($store_id);
            	$goods_score = 0;
            	$service_score = 0;
            	foreach ($a_comment_all as $key => $value) {
					$goods_score   = $goods_score + $value['goods_score'];
					$service_score = $service_score + $value['service_score'];
            	}
            	if (($goods_score + $service_score) > 0) {
            		$store_star = round(($goods_score + $service_score)/(count($a_comment_all)*2),1);
            	}
            	$a_where_w = [
            		'store_id' => $store_id
            	];
            	$a_data_d = [
            		'store_star' => $store_star
            	];
            	// 重新更新门店星级
            	$this->order_model->update_store($a_where_w, $a_data_d);
/*
|----------------------------------------------------------------------------------
| 更新结束
|----------------------------------------------------------------------------------
 */
            	$this->error->show_success('评论成功', 'goods_order', '', 1);
            } else {
            	$this->error->show_error('评论失败', 'order_evaluate-' . $order_id, '', 1);
            }
		} else {
			//接收需要评价的订单id
			$goods_id = $this->router->get(1);
			$a_data['goods']  = $this->order_model->product_details($goods_id);
			$a_data['comtag'] = $this->db->get('comtag', ['comtag_type' => 2]);
			if ( ! empty($a_data)) {
				$this->view->display('order_evaluate', $a_data);
			} else {
				$this->error->show_error('非法访问！', 'user_order', '', 1);
			}
		}

	}

/********************************* 点餐座位订单 *********************************/

	public function book_order() {
		// 获取预约信息
		$state = $this->router->get(1);
		if ($state == '') {
			$state = 9;
		}
		$user_id = $_SESSION['user_id'];
		$a_data['order'] = $this->order_model->get_order_book($user_id, $state, $page);
		$a_data['state'] = $state;
		$this->view->display('book_order', $a_data);
	}

/******************************* 点餐座位我已入店 *******************************/

	public function book_instore() {
		// 接收参数
		$appointment_id = trim($this->general->post('appointment_id'));
		// 获取一条预约信息
		$a_appointment = $this->order_model->get_appointment_one($appointment_id);
		// 将预约状态改为已入店
		if ($a_appointment['appointment_state'] == 2) {
			$a_where = [
				'appointment_id' => $appointment_id
			];
			$a_data = [
				'appointment_state' => 3
			];
			$i_result = $this->order_model->update_appointment($a_where, $a_data);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'入店成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'入店失败'));
			}
		}
	}

/*********************************** 取消订单 ***********************************/

	public function book_cancel() {
		// 接收参数
		$appointment_id = trim($this->general->post('appointment_id'));
		// 获取一条预约信息
		$a_appointment = $this->order_model->get_appointment_one($appointment_id);
		$isrefund = true;
		if ($a_appointment['appointment_state'] > 0) {
			$isrefund = false;
			// 判断支付方式
			if ($a_appointment['pay_type'] == 1) {
				$this->load->library('alipay_wap');
				$a_data = [
					// 商户订单号，商户网站订单系统中唯一订单号，必填
					'out_trade_no'   => $a_appointment['appointment_number'],
					// 请求退款金额，必填
					'refund_amount'  => $a_appointment['actual_pay'],
					'refund_reason'  => '订单退款',
					// 退款交易号，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
					'out_request_no' => 'tk'.date('YmdHis', time()),
					'is_page'        => false
				];
				$result = $this->alipay_wap->refund($a_data);
				if ($result['code'] == 10000) {
					$isrefund = true;
				}
			} else if ($a_appointment['pay_type'] == 2) {
				$a_data = [
					// 商户订单号和微信订单号必须二选一，同时设置时，优先使用微信订单号
					'out_trade_no' => $a_appointment['appointment_number'],
					// 微信订单号
					'transaction_id' => '',
					// 商户退款单号（自定义的，单号唯一，用来识别退款记录的）
					'out_refund_no' => 'tk'.date('YmdHis', time()),
					// 订单金额，不是退款金额，以分为单位,
					'total_fee' => $a_appointment['actual_pay'] * 100,
					// 退款金额，以分为单位,
					'refund_fee' => $a_appointment['actual_pay'] * 100,
					// 通知地址，请参考支付实例完成退款的通知处理
					'notify_url' => $this->router->url('wxrefund_notify')
				];
				$this->load->library('wxpay_h5', '', [$a_data]);
				$a_result = $this->wxpay_h5->refund();
				if ($a_result['return_code'] == 'SUCCESS') {
					$isrefund = true;
				}
			} else if ($a_appointment['pay_type'] == 3) {
				$this->load->library('unionpay_geteway');
				$a_param = [
					// 订单号
					'id_order' => $a_appointment['appointment_number']
				];
				$a_result = $this->unionpay_geteway->query($a_param);
				if ($this->unionpay_geteway->verify($a_result)) {
					if ($a_result['origRespCode'] == '00') {
						$a_param = [
							// 订单号
							'id_order' => 'T'.$a_appointment['appointment_number'],
							// 原消费的queryId，可以从查询接口或者通知接口中获取
							'id_query' => $a_result['queryId'],
							// （选填）交易金额，退货总金额需要小于或等于原消费
							'amount' => $a_appointment['actual_pay'] * 100,
							// （选填）后台返回链接， 不传此参数将默认使用配置文件中的设置url
							'url_back' => $this->router->url('unionpay_refund_notify')
						];
						$a_result = $this->unionpay_geteway->refund($a_param);
						if ($this->unionpay_geteway->verify($a_result)) {
							if ($a_result['respCode'] == '00') {
								$isrefund = true;
							}
						}
					}
				}
			}
		}
		if ($isrefund == true) {
			$a_where = [
				'appointment_id' => $appointment_id
			];
			$a_data = [
				'appointment_state' => 6,
				'who_cancel'        => 1,
				'cancel_time'       => time()
			];
			$i_result = $this->order_model->update_appointment($a_where, $a_data);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'取消订单成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'取消订单失败'));
			}
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'取消订单失败'));
		}
	}

/******************************* 微信是否已支付 *********************************/

	public function weixin_ispay_office() {
		$a_data = $this->order_model->get_officeorder_second();
		if ($a_data) {
			echo json_encode(array('code'=>200));
		} else {
			echo json_encode(array('code'=>400));
		}
	}

/*********************************** 文件上传 ***********************************/

    /**
     * [upload_img 上传文件函数]
     * @param  [array]  $file           [上传文件的信息]
     * @param  [array]  $allow          [允许的文件上传类型]
     * @param  [string] &$error         [引用传递，用来记录错误信息]
     * @param  [string] $path           [文件上传目录]
     * @param  [int]    $maxsize        [1024*1024 允许文件上传的最大大小]
     * @return [string] $target|false   [成功则返回新文件路径 失败返回false]
     */
    public function upload_img($file, $allow, &$error, $path, $maxsize) {

        switch ($file['error']) {
            case 1 : $error = '超出了上传限制大小';
                return false;
            case 2 : $error = '超出了浏览器表单允许的大小';
                return false;
            case 3 : $error = '文件上传不完整';
                return false;
            case 4 : $error = '请先选择需要上传的文件';
                return false;
            case 7 : $error = '服务器繁忙，稍后再试';
                return false;
        }

        //判断文件大小
        if ($file['size'] > $maxsize) {
            //超出了规定大小
            $error = '上传错误，超出了上传限制大小';
            return false;
        }

        //判断文件类型
        if (!in_array($file['type'],$allow)) {
            $error = '上传的文件类型不正确';
            return false;
        }

        //判断文件夹是否存在 不存在则创建
	    if (!file_exists($path)){
	        mkdir($path);
	    }

        //拼接新的文件名
        $newname = date('Ymdhis',time()) . rand(111, 999) .strrchr($file['name'], '.');
        $target = $path . '/' . $newname;

        //移动临时文件
        $result = move_uploaded_file($file['tmp_name'] , $target);
        if ($result) {
            //移动成功则返回新的文件名
            return $target;
        } else {
            $error = "发生未知错误，上传失败！";
            return false;
        }
    }

/********************************************************************************/

}

?>