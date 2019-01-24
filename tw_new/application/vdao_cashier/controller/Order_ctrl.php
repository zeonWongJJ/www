<?php
defined('BASEPATH') OR exit('禁止访问！');

class Order_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('auth_model');
		$this->load->model('order_model');
		$this->load->model('delivery_model');
	}


	// 接用户指定自己门店的单
	public function order_receive() {
		$i_oid = intval($this->general->post('order_id'));
		//查询订单
		$a_tert = $this->db->get_row('order', ['order_id' => $i_oid, 'store_id' => $_SESSION['store_id'], 'order_state' => 20]);
		//查询门店信息
    	$a_store = $this->db->get_row('store', ['store_id' => $_SESSION['store_id']]);
		$a_data = [
			'store_id' => $_SESSION['store_id'],
			'store_name' => $_SESSION['store_name'],
			'order_state' => 30
		];
		$a_where = [
			'order_id' => $i_oid,
			'order_state' => 20,
			// 'order_time <=' => $_SERVER['REQUEST_TIME'] - 10*60*1000
		];
		if ($this->db->update('order', $a_data, $a_where)) {
			$a_json = ['result' => 'success'];
			$a_track = [
	    		'order_id'     => $i_oid,
	    		'order_number' => $a_tert['order_number'],
	    		'name'		   => '商家已接单',
	    		'time'	       => $_SERVER['REQUEST_TIME'],
	    	];
	    	$this->db->insert('order_tracking', $a_track);
	    	if (empty($a_tert['appointment_use'])) {
	    		// 达达配送
		    	$a_data = array(
					// 门店编号
					'shop_id'=> $a_store['transport_id'],
					// 订单ID
					'order_id'=> $a_tert['order_number'],
					// 订单所在城市的代码，可通过city_list函数获取所有城市代码
					'city_code'=> '020',
					// 订单金额
					'order_price' => $a_tert['order_price'],
					// 是否需要垫付 1:是 0:否 (垫付订单金额，非运费)
					'is_prepay' => '0',
					// 期望取货时间（1.时间戳,以秒计算时间，即unix-timestamp; 2.该字段的设定，不会影响达达正常取货; 3.订单待接单时,该时间往后推半小时后，会自动被系统取消;4.建议取值为当前时间往后推10~15分钟）
					'expected_fetch_time' => $_SERVER['REQUEST_TIME'] + 600,
					// 	收货人姓名
					'receiver_name' => $a_tert['reciver_name'],
					// 收货人地址
					'receiver_address' => $a_tert['addres'],
					// 收货人地址经度（高德坐标系）
					'receiver_longitude' => explode(",", $a_tert['addres_post'])[1],
					// 收货人地址维度（高德坐标系）
					'receiver_latitude' => explode(",", $a_tert['addres_post'])[0],
					// 回调地址
					'callback' => $this->router->url('notify'),
					// 收货人手机号（手机号和座机号必填一项）
					'receiver_phone' => $a_tert['mob_phone'],
					// 收货人座机号（手机号和座机号必填一项）
					// 'receiver_tel' => '',
					//=========== 下方为选填项 =============//
					/*// 小费
					'fee' => 0.0,
					// 订单备注
					'message' => '',
					// 订单商品类型：食品小吃-1,饮料-2,鲜花-3,文印票务-8,便利店-9,水果生鲜-13,同城电商-19, 医药-20,蛋糕-21,酒品-24,小商品市场-25,服装-26,汽修零配-27,数码-28,小龙虾-29, 其他-5
					'order_type' => '',
					// 订单重量（单位：Kg）
					'goods_weight' => '',
					// 订单商品数量
					'goods_num' => '',
					// 发票抬头
					'invoice_title' => '',
					// 送货开箱码
					'deliver_locker_code' => '',
					// 取货开箱码
					'pickup_locker_code' => '',
					// 订单来源标示（该字段可以显示在达达app订单详情页面，只支持字母，最大长度为10）
					'order_mark' => '',
					// 订单来源编号（该字段可以显示在达达app订单详情页面，支持字母和数字，最大长度为30）
					'order_mark_no' => '',
					// 商品保价费(当商品出现损坏，可获取一定金额的赔付)保价费分三挡：分别为1元，3元，5元。1元保价：最高可获取100元赔付。3元保价：最高可获取300元赔付。5元保价：最高可获取1000元赔付。
					'insurance_fee' => '',
					// 收货码（0：不需要；1：需要。收货码的作用是：骑手必须输入收货码才能完成订单妥投）
					'is_finish_code_needed' => ''*/
				);
				$s_result = $this->general->request('http://distribution.7dugo.com/add.html', $a_data);
				$a_result = json_decode($s_result, true);
				if ($a_result['status_code'] == 10000) {
					$a_track['name'] = '配送员已接单';
					$a_track['time'] = $a_data['expected_fetch_time'];
					$this->db->insert('order_tracking', $a_track);
				}
			}

			//增加订单处理历史表
			$a_log = [
				'order_id' => $i_oid,
				'log_msg'  => $_SESSION['manager_name'].'派送了订单',
				'log_time' => $_SERVER['REQUEST_TIME'],
				'log_role' => '门店',
				'log_user' => $_SESSION['manager_name'],
				'log_orderstate' => 30,
			];
			$this->db->insert('order_log', $a_log);
			$this->delivery_model->delivery($i_oid,$a_tert['order_type']);
			echo json_encode($a_json);
			exit();
		}
		$a_json = ['result' => 'fail'];
		echo json_encode($a_json);
	}

	//订座接单
	public function book_receive () {
		$appointment_id = trim($this->general->post('appointment_id'));
		$appointment_type = trim($this->general->post('appointment_type'));

		$a_where = [
			'appointment_id' => $appointment_id,
			'store_id'       => $_SESSION['store_id'], 
		];
		$a_data = [
			'appointment_state' => 3
		];
		$i_result = $this->db->update('appointment', $a_data ,$a_where);
		if ($i_result) {
			if($appointment_type == 1) {
				
				$a_data = $this->db->get_row("appointment",['appointment_id' => $appointment_id]);
				$this->order_model->update_meeting_accounttbls( $a_data['store_id'] , $a_data['appointment_price'] , date("Ym" ,$a_data['pay_time']) );
			}
			echo json_encode(array('code'=>200, 'msg'=>'接单成功'.$appointment_type));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'接单失败'));
		}		


	}
	//订座订单取消
	public function book_cancel () {
		$appointment_id     = trim($this->general->post('appointment_id'));
		$cancel_reason      = trim($this->general->post('reason'));
		$appointment_type      = trim($this->general->post('appointment_type'));
		// 获取一条预约信息
		$a_appointment = $this->db->get_row('appointment', ['appointment_id' =>$appointment_id ,'appointment_type' =>  $appointment_type]);
		// print_r($a_appointment);die;
		if ($a_appointment['appointment_state'] > 1  ) {
			echo json_encode(array('code'=>400, 'msg'=>'该订单不能取消了'));
			die;
		}
		// 初始值
		$isrefund = false;
		// 如果该订单已支付则进行退款操作
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
					'total_fee' => $a_appointment['actual_pay']*100,
					// 退款金额，以分为单位,
					'refund_fee' => $a_appointment['actual_pay']*100,
					// 通知地址，请参考支付实例完成退款的通知处理
					'notify_url' => $this->router->url('wxrefund_notify')
				];
				$this->load->library('wxpay_h5', '', [$a_data]);
				$a_result = $this->wxpay_h5->refund();
				// exit(json_encode(["data"=>$a_result]));
				if ($a_result['return_code'] == 'SUCCESS' && $a_result['result_code'] =="SUCCESS") {
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
							'amount'   => $a_appointment['actual_pay']*100,
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
		// 退款成功则更改状态
		if ($isrefund == true) {
			$a_where = [
				'appointment_id' => $appointment_id,
			];
			$a_data = [
				'appointment_state'  => 6,
				'officeseat_state'   => 0,
				'cancel_reason'      => $cancel_reason,
				'who_cancel'         => 2,
				'cancel_time'        => $_SERVER['REQUEST_TIME'],
				'cancel_description' => $cancel_description
			];
			$i_result = $this->db->update('appointment', $a_data, $a_where);
			if ($i_result) {
				
				echo json_encode(array('code'=>200, 'msg'=>'取消订单成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'取消订单失败'));
			}
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'取消订单失败'));
		}		
	}
	//结束订座订单
	public function finish_book_order () {
		$appointment_id = trim($this->general->post('appointment_id'));
		
		$a_where = [
			'appointment_id' => $appointment_id,
		];
		$a_data = [
			'appointment_state' => 4,
			'officeseat_state'  => 0
		];
		$i_result = $this->db->update('appointment', $a_data, $a_where);
		if ($i_result) {
			
			echo json_encode(array('code'=>200, 'msg'=>'服务结束成功', 'data'=> $a_data));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'服务结束失败'));
		}		
	}

	// 抢单
	public function order_rob() {
		$i_oid = intval($this->general->post('order_id'));
		$a_data = [
			'store_id' => $_SESSION['store_id'],
			'store_name' => $_SESSION['store_name'],
			'order_state' => 20
		];
		$a_where = [
			'order_id' => $i_oid,
			// 人家已经抢了，就不能再抢啦
			'store_id' => 0,
			'order_state' => 20,
			// 'order_time <=' => $_SERVER['REQUEST_TIME'] - 600
		];
		if ($this->db->update('order', $a_data, $a_where)) {
			$a_json = ['result' => 'success'];
			echo json_encode($a_json);
			exit();
		}
		$a_json = ['result' => 'fail'];
		echo json_encode($a_json);
	}

	// 异步通知
	public function notify_data() {
		$s_data = file_get_contents('php://input');

	}

	// 重新打印订单
	public function order_reprint() {
		$i_oid = intval($this->general->post('order_id'));
		$addres = $this->db->get_row('order', ['order_id' => $i_oid]);
		$a_data = [];
		$order = $this->db->get('order_goods', ['order_id' => $i_oid]);
		if (count($order)) {
			foreach ($order as $value) {

				$ordert['num']   = $value['goods_num'];
				$ordert['price'] = $value['money'];
				$ordert['cup_name'] = '';
				$ordert['attr'][] =array('attr_name'=>$value['spec']); 
				$ordert['product_name'] = $value['product_name'];
			$a_data['cart'][] = $ordert;
			}
			$a_data['phone'] = $addres['mob_phone'];
			$a_data['name']  = $addres['reciver_name'];
			$i_num = 0;
			$i_money = 0;
			foreach ($order as $i_key => $a_val) {
				$i_num += $a_val['goods_num'];
				$i_money += $a_val['goods_pay_price'] * $a_val['goods_num'];
			}
			$a_data['product_num'] = $i_num;
			$a_data['product_money'] = $i_money;
			$a_data['order_message'] =$addres['order_message'];
			$a_data['manager_id'] = $_SESSION['manager_id'];
			$a_data['store_name'] = $_SESSION['store_name'];
			$a_data['store_address'] = $addres['addres'];
			$a_data['result'] = 'success';
			$a_data['datasss'] = $order;
			//读取订单序列号
			$s_ordersn = $this->auth_model->get_ordersn();
			(!empty($s_ordersn))?$s_ordersn+=1:$s_ordersn = '101';	
		    $this->auth_model->create_ordersn($s_ordersn);		
			$a_data['series_number'] =$s_ordersn;
			echo json_encode($a_data);
			exit();
		}
		$a_json = ['result' => 'fail'];
		echo json_encode($a_json);
	}

	// 最新订单
	public function order_new() {

		$this->view->display('order_new');
	}

	// 订座订单
	public function book_order_list() {
	//订单号
	$i_number = $this->general->post('number') ? $this->general->post('number') : $this->router->get(1);
		// 支付方式
		$i_code  = $this->router->get(2); 
		// 交易状态
		$i_state = $this->router->get(3);
		// 先设置默认从第一页开始
		$i_page = $this->router->get(4);
		if (empty($i_page)) {
			$i_page = 1;
		}	
		$a_data = ['state' => $i_state, 'code' => $i_code, 'number' => $i_number];
		$a_data['oret'] = $this->order_model->book_list($i_number, $i_code, $i_state, $i_page,2);	
		$this->view->display('book_order_list',$a_data);
	}
	// 会议订单
	public function appointment_order() {
	//订单号
	$i_number = $this->general->post('number') ? $this->general->post('number') : $this->router->get(1);
		// 支付方式
		$i_code  = $this->router->get(2); 
		// 交易状态
		$i_state = $this->router->get(3);
		// 先设置默认从第一页开始
		$i_page = $this->router->get(4);
		if (empty($i_page)) {
			$i_page = 1;
		}	
		$a_data = ['state' => $i_state, 'code' => $i_code, 'number' => $i_number];
		$a_data['oret'] = $this->order_model->book_list($i_number, $i_code, $i_state, $i_page,1);	
		$this->view->display('appointment_order',$a_data);
	}

	//附近订单数据
	public function order_new_lise() {
		$a_data = [];
		// 先设置默认从第一页开始
		$i_page = $this->general->post('page');
		$i_stre = $this->general->post('stre');
		if (empty($i_page)) {
			$i_page = 1;
		}
		// 设置每页显示的数据行数
		$i_prow = 5;
		// 加载分页类
		$this->load->library('pages');
		$a_where = [
			// 'order_time <=' => strtotime("-5 minute"),
			'store_id' => 0,
			'order_state' => 20,
			'addres_post <>' => '',
			'mob_phone >' => 0
		];
		// 获取数据总行数
		$a_data['i_total'] = $this->db->get_total('order', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($a_data['i_total'], $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		$a_data['order'] = $this->db->get('order', $a_where, '', ['order_id' => 'desc']);
		$a_data['pages'] = $this->pages->link_style_one($this->router->url('order_new-'.$i_stre .'-', [], false, false));
		// 计算距离
		$i_count = count($a_data['order']);
		list($f_store_longitude, $f_store_latitude) = explode(',', $_SESSION['store_position']);
		for ($i_i = 0; $i_i < $i_count; $i_i++) {
			$a_order_good = $this->db->get('order_goods', ['order_id' => $a_data['order'][$i_i]['order_id']]);
			if ( is_array($a_order_good) && ! empty($a_order_good) ) {
				foreach ($a_order_good as $a_good) {
					$a_data[$i_i]['product_info'] .= "{$a_good['product_name']}({$a_good['spec']}){$a_good['goods_num']}份/";
				}
				$a_data[$i_i]['product_info'] = rtrim($a_data[$i_i]['product_info'], '/');
			}
			// 用户头像
			$a_user = $this->db->get_row('user', ['user_id' => $a_data['order'][$i_i]['user_id']]);
			$a_data[$i_i]['user_pic'] = $a_user['user_pic'];

			list($f_order_latitude,$f_order_longitude) = explode(',', $a_data['order'][$i_i]['addres_post']);
			$a_data[$i_i]['distance'] = $this->order_model->get_distance($f_order_longitude,$f_order_latitude, $f_store_longitude, $f_store_latitude,1,0);
			$a_data[$i_i]['html'] = '<dd>
										<div class="orderNum">
											<span>' . date('Y-m-d H:i', $a_data['order'][$i_i]['order_time']) . '</span>
											<em>
												<span>订单编号: </span>
												<span>' . $a_data['order'][$i_i]['order_number'] . '</span>
											</em>
										</div>
										<ul>
											<li>
												<img src="';
												if (empty($a_data[$i_i]['user_pic'])) {
				                                    $a_data[$i_i]['html'] .= 'static/default/images/yong_03.png />';
				                                } else if(strpos($a_data[$i_i]['user_pic'], 'http') === false) {
				                                    $a_data[$i_i]['html'] .= $a_data[$i_i]['user_pic'];
				                                } else {
				                                    $a_data[$i_i]['html'] .= $a_data[$i_i]['user_pic'];
				                                }
									$a_data[$i_i]['html'] .= '" alt=""/>
												<div class="userInfo">
													<span>' . $a_data['order'][$i_i]['reciver_name'] . '</span>
													<p>' . $a_data[$i_i]['product_info'] . '<span>共' . $a_data['order'][$i_i]['order_count'] . '件产品</span></p>
												</div>
											</li>
											<li>
												<p>¥' . $a_data['order'][$i_i]['actual_pay'] . '</p>
												<em>
													(<span>含配送费:</span><span>' . $a_data['order'][$i_i]['shipping_fee'] . '</span>)
												</em>
											</li>
											<li>
												<span>';
												switch ($a_data['order'][$i_i]['payment_code']) {
													case 'cashier':
														$a_data[$i_i]['html'] .= '线下支付'; break;
													case 'online':
														$a_data[$i_i]['html'] .= '在线支付'; break;
													case 'alipay':
														$a_data[$i_i]['html'] .= '支付宝支付'; break;
													case 'offline':
														$a_data[$i_i]['html'] .= '微信支付'; break;
													case 'unionpay':
														$a_data[$i_i]['html'] .= '银联支付'; break;
												};
						$a_data[$i_i]['html'] .= '</span>
											</li>
											<li>
												<span>' . $a_data['order'][$i_i]['time_delay'] . '</span>
											</li>
											<li>
												<span>' . $a_data[$i_i]['distance'] . 'm</span>
											</li>
											<li>
												<a class="orderDetail" onclick="show_detail(' . $a_data['order'][$i_i]['order_id'] . ')">订单详情</a>
											</li>
											<li>
												<span class="robOrder ster_' . $a_data['order'][$i_i]['order_id'] . '" onclick="qinadan(' . $a_data['order'][$i_i]['order_id'] . ')">抢单</span>
											</li>
										</ul>
									</dd>';
		}
		$ored = $i_count-1;
		echo json_encode(array('data' => $a_data, 'id' => $a_data['order'][$ored]['order_id']));
		die;
	}

	
	// 线下订单
	public function order_list() {
		$i_number = $this->general->post('number') ? $this->general->post('number') : $this->router->get(1);
		// 支付方式
		$i_code  = $this->router->get(2); 
		// 交易状态
		$i_state = $this->router->get(3);
		// 先设置默认从第一页开始
		$i_page = $this->router->get(4);
		if (empty($i_page)) {
			$i_page = 1;
		}	
		$a_data = ['state' => $i_state, 'code' => $i_code, 'number' => $i_number];
		$a_data['oret'] = $this->order_model->order_list($i_number, $i_code, $i_state, $i_page, 2);
		// 钱箱总额
		$i_money = $this->db->get('order', ['payment_code' =>'cashier', 'time_finnshed >' => mktime(0,0,0,date('m'),date('d'),date('Y')), 'time_finnshed <' => mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1, 'order_state' => 10,'store_id' =>$_SESSION['store_id']], ['actual_pay'],'',0,9999999999);
		$a_data['money'] = 0;
		foreach ($i_money as $money) {
			$a_data['money'] += $money['actual_pay'];
		}
		//该店当天线上支付金额
		
		$a_where = ['payment_code !=' =>'cashier', 'time_create >' => mktime(0,0,0,date('m'),date('d'),date('Y')), 'time_create <' => mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1,'store_id' =>$_SESSION['store_id']];
		// $s_field = 'SUM(actual_pay) as online_pay';
		$a_result = $this->db->where_in("order_state",[25,10,30,80])->get('order',$a_where,'actual_pay,use_jife','',0,9999999999);
       // echo $this->db->get_sql();
		$a_data['online_money'] = 0;
		$a_data['use_jife'] = 0;
		foreach ($a_result as $money) {
			$a_data['online_money'] += $money['actual_pay'];
			$a_data['use_jife'] +=$money['use_jife'];
		}		

		$this->view->display('order_list', $a_data);
	}

	// 线上订单
	public function order_online() {
		$i_number = $this->general->post('number') ? $this->general->post('number') : $this->router->get(1);
		// 支付方式
		$i_code  = $this->router->get(2); 
		// 交易状态
		$i_state = $this->router->get(3);
		// 先设置默认从第一页开始
		$i_page = $this->router->get(4);
		if (empty($i_page)) {
			$i_page = 1;
		}	
		if( $i_state ==50 ) {

		}
		$a_data = ['state' => $i_state, 'code' => $i_code, 'number' => $i_number];
		$a_data['oret'] = $this->order_model->order_list($i_number, $i_code, $i_state, $i_page, 1);
		$this->view->display('order_online', $a_data);
	}

	// 取消订单
	public function order_cancel() {
		$i_oid    = intval($this->general->post('order_id'));
		$s_reason = $this->general->post('reason');
		$i_ster   = $this->general->post('ster');

		if ($i_oid && $s_reason) {

			$a_order = $this->db->get_row('order', ['order_id' => $i_oid]);
			if (isset($a_order['order_id']) && $a_order['store_id'] == $_SESSION['store_id']) {			
				if ($a_order['payment_code'] == 'cashier') {//现金支付
					// 把订单状态改为取消
	    			$i_res = $this->db->update('order', ['order_state' => 0], ['order_id' => $i_oid]);
	    			if($i_res){
	    				//增加订单处理历史表
						$a_log = [
							'order_id' => $i_oid,
							'log_msg'  => $_SESSION['manager_name'].$s_reason.'付款订单取消',
							'log_time' => $_SERVER['REQUEST_TIME'],
							'log_role' => '门店',
							'log_user' => $_SESSION['manager_name'],
							'log_orderstate' => 0,
						];

						// 退款加到退款记录表
						$this->db->insert('reimburse', ['order_id' => $a_order['order_id'], 'order_number' => $a_order['order_number'], 'reimburse' => '卖家退款', 'time' => $_SERVER['REQUEST_TIME']]);
							//增加订单处理历史表
						$this->db->insert('order_log', $a_log);
						$a_json = ['result' => 'success', 'qianxia' => 'qianxia'];
						echo json_encode($a_json);
						exit;
			    	}
	    			
				} else if ($a_order['payment_code'] == 'alipay') {//支付宝
					if ($i_ster == 2) {
						//线下支付宝退款
						$this->load->library('alipay_f2f');
						$a_param = [
							// 原支付请求的商户订单号,和支付宝交易号不能同时为空
							'out_trade_no' => $a_order['order_number'],
							// 支付宝交易号，和商户订单号不能同时为空
							//'trade_no' => ''
							// 请求退款接口时，传入的退款请求号，如果在退款请求时未传入，则该值为创建交易时的外部交易号
							'refund_amount' => $a_order['actual_pay'],
							// 可选，标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
							'out_request_no' => 'tk'.date('YmdHis', time()),
							// 可选，退款的原因说明
							'refund_reason' => $s_reason,
							'is_page' => false
						];
						$a_result = $this->alipay_f2f->refund($a_param);
						if ($a_result['code'] == 10000 && $a_result['fund_change'] == 'Y') {
							// 把订单状态改为取消
		    				$this->db->update('order', ['order_state' => 0], ['order_id' => $i_oid]);	
			    			//增加订单处理历史表
							
									//增加订单处理历史表
							$a_log = [
								'order_id' => $i_oid,
								'log_msg'  => $_SESSION['manager_name'].$s_reason.'付款订单取消',
								'log_time' => $_SERVER['REQUEST_TIME'],
								'log_role' => '门店',
								'log_user' => $_SESSION['manager_name'],
								'log_orderstate' => 0,
							];
							$this->db->insert('order_log', $a_log);
							// 退款加到退款记录表
							$this->db->insert('reimburse', ['order_id' => $a_order['order_id'], 'order_number' => $a_order['order_number'], 'reimburse' => '卖家退款', 'time' => $_SERVER['REQUEST_TIME']]);
							$a_json = ['result' => 'success'];
							echo json_encode($a_json);
							exit;
						}
					} else {
						//线上支付宝退款
	    				$this->load->library('alipay_wap');
						$a_data = [
							// 商户订单号，商户网站订单系统中唯一订单号，必填
							'out_trade_no' => $a_order['pay_sn'],
							// 请求退款金额，必填
							'refund_amount' => $a_order['actual_pay'],
							'refund_reason' => $s_reason,
							// 退款交易号，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
							'out_request_no' => 'tk'.date('YmdHis', time()),
							'is_page' => false
						];
						$zhihu = $this->alipay_wap->refund($a_data);
						// 退款加到退款记录表
						$this->db->insert('reimburse', ['order_id' => $a_order['order_id'], 'order_number' => $a_order['order_number'], 'reimburse' => '第三方处理中', 'time' => $_SERVER['REQUEST_TIME'], 'difan' => '支付宝']);
						if ($zhihu['code'] == 10000) {
							// 把订单状态改为取消
		    				$this->db->update('order', ['order_state' => 0], ['order_id' => $i_oid]);	
			    			//增加订单处理历史表
							

									//增加订单处理历史表
						$a_log = [
							'order_id' => $i_oid,
							'log_msg'  => $_SESSION['manager_name'].$s_reason.'付款订单取消',
							'log_time' => $_SERVER['REQUEST_TIME'],
							'log_role' => '门店',
							'log_user' => $_SESSION['manager_name'],
							'log_orderstate' => 0,
						];
						$this->db->insert('order_log', $a_log);
						// 退款加到退款记录表
						$this->db->insert('reimburse', ['order_id' => $a_order['order_id'], 'order_number' => $a_order['order_number'], 'reimburse' => '卖家退款', 'time' => $_SERVER['REQUEST_TIME']]);
							$a_json = ['result' => 'success'];
							echo json_encode($a_json);
							exit;
						} 
					}
    			} else if ($a_order['payment_code'] == 'offline') {// 微信
    			
    				if ($i_ster == 2) {

    					// 收银机微信退款
    					$this->load->library('wxpay_pub');
						$a_param = [
							// 微信订单号，在支付通知中有返回，和商户订单号必填其中一个
							//'transaction_id' => '4200000019201710127570836440',
							// 商户订单号，和微信订单号必填其中一个
							'out_trade_no' => $a_order['order_number'],
							// 订单金额，必填，单位为分
							'total_fee' => $a_order['order_price']*100,
							// 退款金额，必填，单位为分
							'refund_fee' => $a_order['actual_pay']*100,
							// 商户退款单号，必填
							'out_refund_no' => 'tk'.date('YmdHis', time()),

							'is_page' => false
						];
						$a_result = $this->wxpay_pub->refund($a_param);
						if ($a_result['result_code'] == 'SUCCESS' && $a_result['return_code'] == 'SUCCESS') {
							// 退款加到退款记录表
							$this->db->insert('reimburse', ['order_id' => $a_order['order_id'], 'order_number' => $a_order['order_number'], 'reimburse' => '第三方处理中', 'time' => $_SERVER['REQUEST_TIME'], 'difan' => '微信']);
							// 把订单状态改为取消
		    				$this->db->update('order', ['order_state' => 0], ['order_id' => $i_oid]);
			    			
									//增加订单处理历史表
						$a_log = [
							'order_id' => $i_oid,
							'log_msg'  => $_SESSION['manager_name'].$s_reason.'付款订单取消',
							'log_time' => $_SERVER['REQUEST_TIME'],
							'log_role' => '门店',
							'log_user' => $_SESSION['manager_name'],
							'log_orderstate' => 0,
						];
						//增加订单处理历史表
							$this->db->insert('order_log', $a_log);
						// 退款加到退款记录表
						$this->db->insert('reimburse', ['order_id' => $a_order['order_id'], 'order_number' => $a_order['order_number'], 'reimburse' => '卖家退款', 'time' => $_SERVER['REQUEST_TIME']]);
							$a_json = ['result' => 'success', 'code' => 'err_code_des'];
							echo json_encode($a_json);
							exit;
						}
    				} else {
    				
    					// 线上微信退款
						$a_data = [
							// 商户订单号和微信订单号必须二选一，同时设置时，优先使用微信订单号
							'out_trade_no' =>$a_order['pay_sn'],
							// 微信订单号
							'transaction_id' => '',
							// 商户退款单号（自定义的，单号唯一，用来识别退款记录的）
							'out_refund_no' => 'tk'.date('YmdHis', time()),
							// 订单金额，不是退款金额，以分为单位,
							'total_fee' => $a_order['order_price']*100,
							// 退款金额，以分为单位,
							'refund_fee' => $a_order['actual_pay']*100,
							// 通知地址，请参考支付实例完成退款的通知处理
							'notify_url' => $this->router->url('refund_notify'),

							'is_page' => false
						];
						$this->load->library('wxpay_h5', '', [$a_data]);
						$a_result = $this->wxpay_h5->refund();
						// 	$a_res =['data'=>$a_order['actual_pay'],'res'=>$a_result];
    		// 			echo json_encode($a_res );exit;
						if ($a_result['return_code'] == 'SUCCESS' && $a_result['result_code'] =="SUCCESS") {
							// 退款加到退款记录表
							$this->db->insert('reimburse', ['order_id' => $a_order['order_id'], 'order_number' => $a_order['order_number'], 'reimburse' => '第三方处理中', 'time' => $_SERVER['REQUEST_TIME'], 'difan' => '微信']);
							// 把订单状态改为取消
		    				$this->db->update('order', ['order_state' => 0], ['order_id' => $i_oid]);
			    			
									//增加订单处理历史表
						$a_log = [
							'order_id' => $i_oid,
							'log_msg'  => $_SESSION['manager_name'].$s_reason.'付款订单取消',
							'log_time' => $_SERVER['REQUEST_TIME'],
							'log_role' => '门店',
							'log_user' => $_SESSION['manager_name'],
							'log_orderstate' => 0,
						];
						//增加订单处理历史表
							$this->db->insert('order_log', $a_log);
						// 退款加到退款记录表
						$this->db->insert('reimburse', ['order_id' => $a_order['order_id'], 'order_number' => $a_order['order_number'], 'reimburse' => '卖家退款', 'time' => $_SERVER['REQUEST_TIME']]);
							$a_json = ['result' => 'success'];
							echo json_encode($a_json);
							exit;
						}
    				}
    			} else if ($a_order['payment_code'] == 'unionpay') {//银联
					$this->load->library('unionpay_geteway');
					$a_param = [
						// 订单号
						'id_order' => $a_order['order_number']
					];
					$a_result = $this->unionpay_geteway->query($a_param);
					if ($this->unionpay_geteway->verify($a_result)) {
						if ($a_result['origRespCode'] == '00') {
							$a_param = [
								// 订单号
								'id_order' => $a_order['order_number'],
								// 原消费的queryId，可以从查询接口或者通知接口中获取
								'id_query' => $a_result['queryId'],
								// （选填）交易金额，退货总金额需要小于或等于原消费
								'amount' => $a_order['actual_pay'],
							];
							$a_result = $this->unionpay_geteway->refund($a_param);
							if ($this->unionpay_geteway->verify($a_result)) {
								if ($a_result['respCode'] == '00') {
									// 退款加到退款记录表
									$this->db->insert('reimburse', ['order_id' => $a_order['order_id'], 'order_number' => $a_order['order_number'], 'reimburse' => '第三方处理中', 'time' => $_SERVER['REQUEST_TIME'], 'difan' => '银联']);
									// 把订单状态改为取消
				    				$this->db->update('order', ['order_state' => 0], ['order_id' => $i_oid]);
					    			
											//增加订单处理历史表
								$a_log = [
									'order_id' => $i_oid,
									'log_msg'  => $_SESSION['manager_name'].$s_reason.'付款订单取消',
									'log_time' => $_SERVER['REQUEST_TIME'],
									'log_role' => '门店',
									'log_user' => $_SESSION['manager_name'],
									'log_orderstate' => 0,
								];
									//增加订单处理历史表
									$this->db->insert('order_log', $a_log);
						// 退款加到退款记录表
						$this->db->insert('reimburse', ['order_id' => $a_order['order_id'], 'order_number' => $a_order['order_number'], 'reimburse' => '卖家退款', 'time' => $_SERVER['REQUEST_TIME']]);
									$a_json = ['result' => 'success'];
									echo json_encode($a_json);
									exit;
								}
							}
						}
					}
				} else if ($a_order['payment_code'] == 'online') { //在线支付
					//把返回的金额和积分返回给用户
					// 把订单状态改为取消
				    $i_res = $this->db->update('order', ['order_state' => 0], ['order_id' => $i_oid]);
				    if($i_res){
					$a_user  = $this->db->get_row('user', ['user_id' => $a_order['user_id']]);
					$balance = $a_user['user_balance'] + $a_order['balance_deduction'];
					$score   = $a_user['user_score'] + $a_order['use_jife'];
					$a_usr   = [
						'user_score'   => $score,
						'user_balance' => $balance,
					];
					$this->db->update('user', $a_usr, ['user_id' => $a_order['user_id']]);
					// 增加会员积分表
					if( ! empty($a_order['use_jife'])){
						$a_jife = [
							'user_id'       => $a_order['user_id'],
							'user_name'     => $a_order['user_name'],
							'pl_type'       => 1,
							'pl_variation'  => $a_order['use_jife'],
							'pl_time'       => $_SERVER['REQUEST_TIME'],
							'pl_score'       => $score,
							'pl_description' => $a_order['order_number'].'退还积分',
							'pl_item'  		 => '退还积分',
							'pl_code'        => 7,
						];
						$this->db->insert('points_log', $a_jife);
					}
					// 用户资金明细表
					if ( ! empty($a_order['balance_deduction'])) {
						$a_userba = [
							'ub_type'    => 1,
							'ub_money'   => $a_order['balance_deduction'],
							'ub_balance' => $balance,
							'ub_time'    => $_SERVER['REQUEST_TIME'],
							'ub_item'    => '退还余额',
							'user_id'    => $a_order['user_id'], 
							'ub_number'  => $a_order['order_number'],
							'ub_description' => $a_order['order_number'].'退还余额',
						];
						$this->db->insert('userbalance', $a_userba);
					}
							//增加订单处理历史表
						$a_log = [
							'order_id' => $i_oid,
							'log_msg'  => $_SESSION['manager_name'].$s_reason.'付款订单取消',
							'log_time' => $_SERVER['REQUEST_TIME'],
							'log_role' => '门店',
							'log_user' => $_SESSION['manager_name'],
							'log_orderstate' => 0,
						];
						//增加订单处理历史表
						$this->db->insert('order_log', $a_log);
						// 退款加到退款记录表
						$this->db->insert('reimburse', ['order_id' => $a_order['order_id'], 'order_number' => $a_order['order_number'], 'reimburse' => '卖家退款', 'time' => $_SERVER['REQUEST_TIME']]);
					$a_json = ['result' => 'success'];
					echo json_encode($a_json);
					exit;
					}
				}
			}
		}
		$a_json = ['result' => 'fail'];
		echo json_encode($a_json);
	}

	//订单触发完成
    public function order_complete() {
    	$id = $this->general->post('id');
    	$a_tert = $this->db->get_row('order', ['order_id' => $id, 'store_id' => $_SESSION['store_id']]);
    	if (empty($a_tert)) {
    		echo json_encode(array('stuo' => 55, 'name' => '订单有误！'));
    		die;
    	} 
    	// var_dump($a_tert);exit;
		$i_res = $this->db->update('order', ['order_state' => 10 , 'time_finnshed' => $_SERVER['REQUEST_TIME']], ['order_id' => $id]);
		if($i_res) {
			$this->delivery_model->update_accounttbl( $a_tert['store_id'],$a_tert['order_price'],0 , $a_tert['order_count'], date("Ym", $a_tert['time_create']));
		}
		
		//增加订单处理历史表
		$a_log = [
			'order_id' => $id,
			'log_msg'  => $_SESSION['manager_name'].'完成订单！',
			'log_time' => $_SERVER['REQUEST_TIME'],
			'log_role' => '门店',
			'log_user' => $_SESSION['manager_name'],
			'log_orderstate' => 10,
		];
		$this->db->insert('order_log', $a_log);
		$this->delivery_model->delivery($id,$a_tert['order_type']);
		echo json_encode(array('stuo' => 33, 'name' => '订单完成！'));
		die;
    }

	// 订单详情
	public function order_detail() {
		$i_oid = intval($this->general->post('order_id'));
		if ($i_oid) {
			$a_order = $this->db->get_row('order', ['order_id' => $i_oid]);
			$a_order_good = $this->db->get('order_goods', ['order_id' => $i_oid]);
			$s_html = '<div class="messageBox">
        		<div class="numberBox">
        			<p class="dingdan"><i></i>订单编号</p>
        			<div class="cont">
        				<p>' . $a_order['order_number'] . '</p>
        			</div>
        			<span class="shang"></span>
        			<span class="xia"></span>
        		</div>
        		<div class="numberBox timeBox">
        			<p class="dingdan"><i></i>下单时间/预约时间</p>
        			<div class="cont">
        				<p>' . date('Y-m-d H:i', $a_order['order_time']) . '/' . $a_order['time_delay'] . '</p>
        			</div>
        			<span class="shang"></span>
        			<span class="xia"></span>
        		</div>
        		<div class="numberBox timeBox">
        			<p class="dingdan"><i></i>备注</p>
        			<div class="cont">
        				<p>' . $a_order['order_message'] . '</p>
        			</div>
        			<span class="shang"></span>
        			<span class="xia"></span>
        		</div>';
        		if ($a_order['order_stye'] != 2) {
        		$s_html .= '<div class="numberBox takeBox">
        		        			<p class="dingdan"><i></i>收货信息</p>
        		        			<div class="cont">
        		        				<p>联系人：' . $a_order['reciver_name'] . '</p>
        		        				<p>联系电话：' . $a_order['mob_phone'] . '</p>
        		        				<p>联系地址：' . $a_order['addres'] . '</p>
        		        			</div>
        		        			<span class="shang"></span>
        		        			<span class="xia"></span>
        		        		</div>';
        		}
        		$s_html .= '<div class="numberBox proBox">
        			<p class="dingdan"><i></i>下单产品</p>
        			<div class="cont">
        				<ul>';
					if (is_array($a_order_good) && ! empty($a_order_good)) {
						foreach ($a_order_good as $a_good) {
        					$s_html .= '<li>
        						<i class="wen1">' . $a_good['product_name'] . $a_good['cup_name'] . $a_good['spec'] . '</i>
        						<i class="wen2">x' . $a_good['goods_num'] . '</i>
        						<i class="wen3">¥' . $a_good['goods_pay_price'] . '</i>
        					</li>';
        				}
        			}
        			$s_html .=	'</ul>

        			</div>
        		</div>
        	</div>
			<div class="payBox">
				<span class="payType">';
				switch ($a_order['payment_code']) {
					case 'cashier':
						$s_html .= '线下支付'; break;
					case 'online':
						$s_html .= '在线支付'; break;
					case 'alipay':
						$s_html .= '支付宝支付'; break;
					case 'offline':
						$s_html .= '微信支付'; break;
					case 'unionpay':
						$s_html .= '银联支付'; break;
				}
			$s_html .= '</span>
				<span class="allMon">¥' . $a_order['order_price'] . '</span>
			</div>
			<div class="closeBox">
				<a href="javascript:;">关闭窗口</a>
			</div>';
			echo $s_html;
		}
	}
}
