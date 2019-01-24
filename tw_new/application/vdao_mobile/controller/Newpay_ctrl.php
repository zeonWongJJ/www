<?php
defined('BASEPATH') or exit('禁止访问！');
class Newpay_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('newpay_model');
		$this->load->model('allow_model');
		$this->load->model('order_model');
	}

/************************************* 咖啡结算 *************************************/

	public function coffee_newpay() {
		// var_dump($this->general->post());exit;
		// 验证是否登录
		$this->allow_model->is_login();
		// 获取配送信息
		$a_address = $this->newpay_model->get_address_default($_SESSION['user_id']);
		if (empty($a_address)) {
			$this->error->show_error('你没有选择地址', 'new_bill?oldurl='.$_GET['oldurl'], '', 1);
		}
		// 处理请求
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$come_type = trim($this->general->post('come_type'));
			// var_dump($this->general->post());exit;
			// $come_type = 1 代表来自购物车结算
			if ($come_type == 1) {
				// 接收数据
				$cart_ids          = trim($this->general->post('cart_ids'));
				$balance_deduction = trim($this->general->post('balance_deduction'));
				$score_deduction   = trim($this->general->post('score_deduction'));
				$pay_type          = trim($this->general->post('pay_type'));
				$shipping_fee      = trim($this->general->post('shipping_fee'));
				$goods_amount      = trim($this->general->post('goods_amount'));
				$time_delay        = trim($this->general->post('time_delay'));
				$actual_pay        = trim($this->general->post('actual_pay'));
				$appointment_ids   = trim($this->general->post('appointment_ids'));
				$order_message 	   = trim($this->general->post('order_message'));
				// 验证必填项是否为空
				if (empty($cart_ids) || empty($pay_type)) {
					$a_parameter['msg'] = '必填项不能为空';
					$a_parameter['url'] = 'product_category';
					$this->error->show_error($a_parameter);
				}
				// 获取要抵扣的座位
				$store_arr = array();
				if (!empty($appointment_ids)) {
					$appointment_arr = explode(',', $appointment_ids);
					$a_appointment = $this->newpay_model->get_appointment_seat($appointment_arr);

					foreach ($a_appointment as $key => $value) {
						if (!in_array($value['store_id'], $store_arr)) {
							$store_arr[] = $value['store_id'];
						}
					}
				}

				// 获取一条设置信息
				$a_set = $this->newpay_model->get_set_one('user_score_cash');
				$user_score_cash = $a_set['set_parameter'];
				// 拆分购物车 判断需要生成多少个订单
				$cart_arr          = explode(',', $cart_ids);
				$car_have_store    = array();
				$car_not_store     = array();
				$car_have_share    = array();
				$share_product_arr = array();
				for ($i=0; $i < count($cart_arr); $i++) {
					// 获取一条购物车信息
					$a_cart_row = $this->newpay_model->get_cart_one($cart_arr[$i]);
					if (!$a_cart_row) {
						$a_parameter = [
							'msg'      => '购物车信息不存在',
							'url'      => 'goods_order',
							'log'      => false,
							'wait'     => 2,
						];
						$this->error->show_error($a_parameter);
					}
					if (empty($a_cart_row['store_id'])) {
						// 判断是否是分享者订单
						if (empty($a_cart_row['share_userid'])) {
							$car_not_store[] = $a_cart_row['cart_id'];
						} else {
							if (!in_array($a_cart_row['share_userid'], $car_have_share)) {
								$car_have_share[] = $a_cart_row['share_userid'];
								$share_product_arr[] = $a_cart_row['product_id'];
							}
						}
					} else {
						if (!in_array($a_cart_row['store_id'], $car_have_store)) {
							$car_have_store[] = $a_cart_row['store_id'];
						}
					}
				}
				// 判断是否有分享的订单
				// $share_shipfee = 0;
				// if (!empty($share_product_arr)) {
				// 	// 获取所有的分享的运费
				// 	$share_qualifi_goods = $this->newpay_model->get_goods_share($share_product_arr);
				// 	foreach ($share_qualifi_goods as $key => $value) {
				// 		$share_shipfee = $share_shipfee + $value['distribution'];
				// 	}
				// }
				// 自营总订单数
				// $order_length = count($car_have_store) + count($car_not_store);
				// // 减去自营的运费
				// $goods_amount = $goods_amount - ($order_length*$shipping_fee);
				// // 最终商品总价[除去所有运费之后的价格]
				// $goods_amount = $goods_amount - $share_shipfee;
				// 生成支付单号
				$pay_sn = date('YmdHis', time()) . rand(1111, 9999);
				// 生成分享订单
				if (!empty($car_have_share)) {
					for ($i=0; $i < count($car_have_share); $i++) {
						// 获取购物车信息
						$a_cart_share = $this->newpay_model->get_cart_share($car_have_share[$i], $cart_arr, $_SESSION['user_id']);
						$this_goods_amount = 0;
						$this_goods_count = 0;
						$this_balance_deduction = 0;
						$this_score_deduction = 0;
						$this_car_arr = array();
						$this_product_arr = array();
						foreach ($a_cart_share as $key => $value) {
							$this_goods_amount  = $this_goods_amount + ($value['money']*$value['prot_count']);
							$this_goods_count   = $this_goods_count + $value['prot_count'];
							$this_car_arr[]     = $value['cart_id'];
							$this_product_arr[] = $value['product_id'];
							$this_share_userid  = $value['share_userid'];
						}
						// 获取运费
						$this_shipping_fee = 0;
						$a_qualifi_goods = $this->newpay_model->get_qualifi_goods($_SESSION['user_id'], $this_product_arr);
						foreach ($a_qualifi_goods as $key => $value) {
							$this_shipping_fee = $this_shipping_fee + $value['distribution'];
						}
						// 验证是否有积分抵扣余额抵扣
						if ($balance_deduction > 0 && $this_goods_amount > 0) {
							$this_balance_deduction = round(($this_goods_amount/$goods_amount)*$balance_deduction, 2);
						}
						if (!empty($score_deduction) && $this_goods_amount > 0) {
							$this_score_deduction = round(($this_goods_amount/$goods_amount)*$score_deduction,2);
						}
						if (!empty($score_deduction) && $user_score_cash > 0) {
							$this_use_points = round(($user_score_cash/100)*$this_score_deduction, 2);
						} else {
							$this_use_points = 0.00;
						}
						// 订单号
						$order_number = date('YmdHis', time()) . rand(1111, 9999);
						// 生成一条订单数据
						$a_share_data = [
							'user_id'           => $_SESSION['user_id'],
							'user_name'         => $_SESSION['user_name'],
							'store_id'          => 0,
							'order_type'        =>2,
							'order_count'       => $this_goods_count,
							'goods_amount'      => $this_goods_amount,
							'shipping_fee'      => $this_shipping_fee,
							'order_price'       => $this_goods_amount + $this_shipping_fee,
							'chankan'           => 1,
							'order_number'      => $order_number,
							'pay_sn'            => $pay_sn,
							'time_create'       => $_SERVER['REQUEST_TIME'],
							'order_state'       => 40,
							'evaluation_state'  => 0,
							'order_message'     => trim($this->general->post('order_message')),
							'use_jife'          => $this_score_deduction,
							'use_points'        => $this_use_points,
							'balance_deduction' => $this_balance_deduction,
							'reciver_name'      => $a_address['user_name'],
							'addres'            => $a_address['address'] . $a_address['house'],
							'addres_post'       => $a_address['longitude'],
							'mob_phone'         => $a_address['mob_phone'],
							'time_delay'        => $time_delay,
							'share_userid'      => $this_share_userid,
							'actual_pay'        => $actual_pay
						];
						// print_r($a_share_data);die;
						// 插入一条订单信息
						$order_id = $this->newpay_model->insert_order($a_share_data);
						$a_track = [
				    		'order_id'     => $order_id,
				    		'order_number' => $order_number,
				    		'name'		   => '订单提交成',
				    		'time'	       => $_SERVER['REQUEST_TIME'],
				    	];
				    	$this->db->insert('order_tracking', $a_track);
						// 如果订单生成成功则将数据分别插入到订单商品表
						if ($order_id) {
							for ($j=0; $j < count($this_car_arr); $j++) {
								// 获取一条购物车信息
								$a_cart_row = $this->newpay_model->get_cart_one($this_car_arr[$j]);
								// 插入一条订单商品表
								$a_order_goods = [
									'order_id'        => $order_id,
									'product_id'      => $a_cart_row['product_id'],
									'product_name'    => $a_cart_row['product_name'],
									'money'           => $a_cart_row['money'],
									'cup_id'          => $a_cart_row['spec'],
									'spec'            => $a_cart_row['shux_name'],
									'goods_num'       => $a_cart_row['prot_count'],
									'pro_img'         => $a_cart_row['pro_img'],
									'goods_pay_price' => $a_cart_row['money'],
									'user_id'         => $a_cart_row['user_id'],
									'goods_type'      => 1,
									'store_id'        => 0,
								];
								$i_res = $this->newpay_model->insert_order_goods($a_order_goods);
							}

						}
					}
				}
				// 生成无门店的订单
				if (!empty($car_not_store)) {
					// 获取此部分无门店购物车信息
					$a_cart_not = $this->newpay_model->get_cart_part($car_not_store);
					$not_goods_amount = 0;
					$not_goods_count = 0;
					$not_balance_deduction = 0;
					$not_score_deduction = 0;
					foreach ($a_cart_not as $key => $value) {
						$not_goods_amount = $not_goods_amount + ($value['money']*$value['prot_count']);
						$not_goods_count  = $not_goods_count + $value['prot_count'];
					}
					if ($balance_deduction > 0 && $not_goods_amount > 0) {
						$not_balance_deduction = round(($not_goods_amount/$goods_amount)*$balance_deduction, 2);
					}
					if (!empty($score_deduction) && $not_goods_amount > 0) {
						$not_score_deduction = round(($not_goods_amount/$goods_amount)*$score_deduction,2);
					}
					// 抵扣的金额
					if (!empty($score_deduction) && $user_score_cash > 0) {
						$not_use_points = round(($user_score_cash/100)*$not_score_deduction, 2);
					} else {
						$not_use_points = 0;
					}
					// 订单号
					$order_number = date('YmdHis', time()) . rand(1111, 9999);
					// 生成一条订单数据
					$a_not_data = [
						'user_id'           => $_SESSION['user_id'],
						'user_name'         => $_SESSION['user_name'],
						'order_count'       => $not_goods_count,
						'goods_amount'      => $not_goods_amount,
						'shipping_fee'      => $shipping_fee,
						'order_price'       => $not_goods_amount + $shipping_fee,
						'chankan'           => 1,
						'order_number'      => $order_number,
						'pay_sn'            => $pay_sn,
						'time_create'       => $_SERVER['REQUEST_TIME'],
						'order_state'       => 40,
						'evaluation_state'  => 0,
						'order_message'     => trim($this->general->post('order_message')),
						'use_jife'          => $not_score_deduction,
						'use_points'        => $not_use_points,
						'balance_deduction' => $not_balance_deduction,
						'reciver_name'      => $a_address['user_name'],
						'addres'            => $a_address['address'] . $a_address['house'],
						'addres_post'       => $a_address['longitude'],
						'mob_phone'         => $a_address['mob_phone'],
						'time_delay'        => $time_delay,
						'order_type'        => 2,
						'actual_pay'        => $actual_pay
					];
					// print_r($a_not_data);die;
					// 插入一条订单信息
					$order_id = $this->newpay_model->insert_order($a_not_data);
					$a_track = [
			    		'order_id'     => $order_id,
			    		'order_number' => $order_number,
			    		'name'		   => '订单提交成',
			    		'time'	       => $_SERVER['REQUEST_TIME'],
			    	];
			    	$this->db->insert('order_tracking', $a_track);
					// 如果订单生成成功则将数据分别插入到商品表
					if ($order_id) {
						for ($j=0; $j < count($car_not_store); $j++) {
							// 获取一条购物车信息
							$a_cart_row = $this->newpay_model->get_cart_one($car_not_store[$j]);
							// 插入一条订单商品表
							$a_order_goods = [
								'order_id'        => $order_id,
								'product_id'      => $a_cart_row['product_id'],
								'product_name'    => $a_cart_row['product_name'],
								'money'           => $a_cart_row['money'],
								'cup_id'          => $a_cart_row['spec'],
								'spec'            => $a_cart_row['shux_name'],
								'goods_num'       => $a_cart_row['prot_count'],
								'pro_img'         => $a_cart_row['pro_img'],
								'goods_pay_price' => $a_cart_row['money'],
								'user_id'         => $a_cart_row['user_id'],
								'goods_type'      => 1,
							];
							$i_res = $this->newpay_model->insert_order_goods($a_order_goods);
						}
					}
				}
				// 生成有门店的订单
				if (!empty($car_have_store)) {
					
					for ($i=0; $i < count($car_have_store); $i++) {
						// 获取此门店购物车记录
						$a_cart_have = $this->newpay_model->get_cart_store($car_have_store[$i], $cart_arr, $_SESSION['user_id']);
						// 判断是否有座位订金抵扣
						$seat_deduction = 0;
						$this_appointment_id = array();
						if (!empty($appointment_ids) && in_array($car_have_store[$i], $store_arr)) {
							// 获取当前门店需抵扣的座位
							foreach ($a_appointment as $kkk => $vvv) {
								if ($vvv['store_id'] == $car_have_store[$i]) {
									$seat_deduction = $seat_deduction + $vvv['appointment_price'];
									$this_appointment_id[] = $vvv['appointment_id'];
								}
							}
						}
						// 抵扣的座位订单id
						if (!empty($this_appointment_id)) {
							$appointment_use = implode(',', $this_appointment_id);
						} else {
							$appointment_use = '';
						}
						$this_goods_amount = 0;
						$this_goods_count = 0;
						$this_balance_deduction = 0;
						$this_score_deduction = 0;
						$this_car_arr = array();
						foreach ($a_cart_have as $key => $value) {
							$this_goods_amount = $this_goods_amount + ($value['money']*$value['prot_count']);
							$this_goods_count  = $this_goods_count + $value['prot_count'];
							$this_store_name   = $value['store_name'];
							$this_car_arr[]    = $value['cart_id'];
						}
						if ($balance_deduction > 0 && $this_goods_amount > 0) {
							$this_balance_deduction = round(($this_goods_amount/$goods_amount)*$balance_deduction, 2);
						}
						if (!empty($score_deduction) && $this_goods_amount > 0) {
							$this_score_deduction = round(($this_goods_amount/$goods_amount)*$score_deduction,2);
						}
						// 抵扣的金额
						if (!empty($score_deduction)) {
							$this_use_points = round(($user_score_cash/100)*$this_score_deduction, 2);
						} else {
							$this_use_points = 0;
						}
						// 订单号
						$order_number = date('YmdHis', time()) . rand(1111, 9999);
						// 生成一条订单数据
						$a_not_data = [
							'user_id'           => $_SESSION['user_id'],
							'user_name'         => $_SESSION['user_name'],
							'store_id'          => $car_have_store[$i],
							'store_name'        => $this_store_name,
							'order_count'       => $this_goods_count,
							'goods_amount'      => $this_goods_amount,
							'shipping_fee'      => $shipping_fee,
							'order_price'       => $this_goods_amount + $shipping_fee,
							'chankan'           => 1,
							'order_number'      => $order_number,
							'pay_sn'            => $pay_sn,
							'time_create'       => $_SERVER['REQUEST_TIME'],
							'order_state'       => 40,
							'evaluation_state'  => 0,
							'order_message'     => trim($this->general->post('order_message')),
							'use_jife'          => $this_score_deduction,
							'use_points'        => $this_use_points,
							'balance_deduction' => $this_balance_deduction,
							'reciver_name'      => $a_address['user_name'],
							'addres'            => $a_address['address'] . $a_address['house'],
							'addres_post'       => $a_address['longitude'],
							'mob_phone'         => $a_address['mob_phone'],
							'time_delay'        => $time_delay,
							'seat_deduction'    => $seat_deduction,
							'appointment_use'   => $appointment_use,
							'actual_pay'        => $actual_pay
						];
						// print_r($a_not_data);die;
						// 插入一条订单信息
						$order_id = $this->newpay_model->insert_order($a_not_data);
						$a_track = [
				    		'order_id'     => $order_id,
				    		'order_number' => $order_number,
				    		'name'		   => '订单提交成',
				    		'time'	       => $_SERVER['REQUEST_TIME'],
				    	];
				    	$this->db->insert('order_tracking', $a_track);
						// 如果订单生成成功则将数据分别插入到商品表
						if ($order_id) {
							for ($j=0; $j < count($this_car_arr); $j++) {
								// 获取一条购物车信息
								$a_cart_row = $this->newpay_model->get_cart_one($this_car_arr[$j]);
								// 插入一条订单商品表
								$a_order_goods = [
									'order_id'        => $order_id,
									'product_id'      => $a_cart_row['product_id'],
									'product_name'    => $a_cart_row['product_name'],
									'money'           => $a_cart_row['money'],
									'cup_id'          => $a_cart_row['spec'],
									'spec'            => $a_cart_row['shux_name'],
									'goods_num'       => $a_cart_row['prot_count'],
									'pro_img'         => $a_cart_row['pro_img'],
									'goods_pay_price' => $a_cart_row['money'],
									'user_id'         => $a_cart_row['user_id'],
									'goods_type'      => 1,
									'store_id'        => $car_have_store[$i],
								];
								$i_res = $this->newpay_model->insert_order_goods($a_order_goods);
							}
							if (!empty($appointment_arr)) {
								$this ->newpay_model->update_appointment_seat($appointment_arr);
							}							
						}
					}
				}
				// 删除原来购物车的数据
				$this->newpay_model->delete_cart_mony($cart_arr);
			} else if ($come_type == 2) { // 立即购买
				// var_dump($this->general->post());exit;
				// 接收数据
				$order_count       = trim($this->general->post('prot_count'));
				$store_name        = trim($this->general->post('store_name'));
				$store_id          = trim($this->general->post('store_id'));
				$balance_deduction = trim($this->general->post('balance_deduction'));
				$score_deduction   = trim($this->general->post('score_deduction'));
				$pay_type          = trim($this->general->post('pay_type'));
				$order_price       = trim($this->general->post('order_price'));
				$shipping_fee      = trim($this->general->post('shipping_fee'));
				$goods_amount      = trim($this->general->post('goods_amount'));
				$time_delay        = trim($this->general->post('time_delay'));
				// $order_message     = $this->general->post('order_message');
				$product_id        = trim($this->general->post('product_id'));
				$spec              = trim($this->general->post('shux_name'));
				$prot_count        = trim($this->general->post('prot_count'));
				$pro_img           = trim($this->general->post('imge'));
				$money             = trim($this->general->post('money'));
				$product_name      = trim($this->general->post('goods_name'));
				$actual_pay        = trim($this->general->post('actual_pay'));
				$appointment_ids   = trim($this->general->post('appointment_ids'));
				$order_message 	   = trim($this->general->post('order_message'));
				// 获取配送信息
				$a_address = $this->newpay_model->get_address_default($_SESSION['user_id']);
				$this_goods_amount      = $goods_amount;
				$this_goods_count       = $order_count;
				$this_balance_deduction = $balance_deduction;
				$this_score_deduction   = $score_deduction;
				// 获取一条产品信息 [验证是否为分享的产品]
				$this_product = $this->newpay_model->get_product_one($product_id);
				if ($this_product['goods_stye'] == 2) {
					// 获取分享信息
					$row_qualifi_goods = $this->newpay_model->get_qualifi_row($product_id);
					$share_userid = $row_qualifi_goods['user_id'];
				} else {
					$share_userid = 0;
				}
				// 判断是否有座位抵扣
				$seat_deduction = 0;
				if (!empty($appointment_ids)) {
					$appointment_arr = explode(',', $appointment_ids);
					$a_appointment = $this->newpay_model->get_appointment_seat($appointment_arr);
					foreach ($a_appointment as $key => $value) {
						$seat_deduction = $seat_deduction + $value['appointment_price'];
					}
				}
				// 获取一条设置信息
				$a_set = $this->newpay_model->get_set_one('user_score_cash');
				$user_score_cash = $a_set['set_parameter'];
				// 抵扣的金额
				if (!empty($score_deduction) && $user_score_cash > 0) {
					$not_use_points = round(($user_score_cash/100)*$score_deduction, 2);
				} else {
					$not_use_points = 0;
				}
				// 生成支付单号
				$pay_sn = date('YmdHis', time()) . rand(1111, 9999);
				// 订单号
				$order_number = date('YmdHis', time()) . rand(1111, 9999);
				// 生成一条订单数据
				$a_not_data = [
					'user_id'           => $_SESSION['user_id'],
					'user_name'         => $_SESSION['user_name'],
					'store_id'          => $store_id,
					'store_name'        => $store_name,
					'order_count'       => $this_goods_count,
					'goods_amount'      => $this_goods_amount,
					'shipping_fee'      => $shipping_fee,
					'order_price'       => $order_price,
					'chankan'           => 1,
					'order_number'      => $order_number,
					'pay_sn'            => $pay_sn,
					'time_create'       => $_SERVER['REQUEST_TIME'],
					'order_state'       => 40,
					'evaluation_state'  => 0,
					'order_message'     => $order_message,
					'use_jife'          => $this_score_deduction,
					'use_points'        => $not_use_points,
					'balance_deduction' => $this_balance_deduction,
					'reciver_name'      => $a_address['user_name'],
					'addres'            => $a_address['address'] . $a_address['house'],
					'addres_post'       => $a_address['longitude'],
					'mob_phone'         => $a_address['mob_phone'],
					'time_delay'        => $time_delay,
					'share_userid'      => $share_userid,
					'seat_deduction'    => $seat_deduction,
					'appointment_use'   => $appointment_ids,
					'actual_pay'        => $actual_pay
				];
				// print_r($a_not_data);die;
				// 插入一条订单信息
				$order_id = $this->newpay_model->insert_order($a_not_data);
				$a_track = [
		    		'order_id'     => $order_id,
		    		'order_number' => $order_number,
		    		'name'		   => '订单提交成功',
		    		'time'	       => $_SERVER['REQUEST_TIME'],
		    	];
		    	$this->db->insert('order_tracking', $a_track);
				// 插入一条订单商品表
				$a_order_goods = [
					'order_id'        => $order_id,
					'product_id'      => $product_id,
					'product_name'    => $product_name,
					'money'           => $money,
					'cup_id'          => $a_cart_row['spec'],
					'spec'            => $spec,
					'goods_num'       => $prot_count,
					'pro_img'         => $pro_img,
					'goods_pay_price' => $goods_amount,
					'user_id'         => $_SESSION['user_id'],
					'goods_type'      => 1,
					'store_id'        => $store_id,
				];
				// print_r($a_order_goods);
				$i_res = $this->newpay_model->insert_order_goods($a_order_goods);
			} else if ($come_type == 3) { // 订单列表未支付时前往支付
				$pay_type = trim($this->general->post('pay_type'));
				$order_id = $this->general->post('order_id');
				$a_order = $this->db->get_row('order', ['user_id' => $_SESSION['user_id'], 'order_id' => $order_id, 'order_state' => 40]);

				$actual_pay = $a_order['order_price'] - $a_order['use_points'] - $a_order['balance_deduction'] - $a_order['seat_deduction'];
				// 生成新的支付单号
				$pay_sn = date('YmdHis', time()) . rand(1111, 9999);
				$a = $this->db->update('order', ['pay_sn' => $pay_sn, 'actual_pay' => $actual_pay], ['user_id' => $_SESSION['user_id'], 'order_id' => $order_id, 'order_state' => 40]);
			}
		
			// 验证实付款是否为零
			
			if ($actual_pay == 0 ) {
				// echo $actual_pay ;exit;
				// 支付成功后修改订单状态
				$a_order_where = [
					'pay_sn' => $pay_sn,
				];
				$a_order_data = [
					'order_time'   => $_SERVER['REQUEST_TIME'],
					'payment_code' => 'online',
					'order_state'  => 20
				];
				$i_result_order = $this->newpay_model->update_order($a_order_where, $a_order_data);
				// 获取一条订单信息
				$a_this_order = $this->newpay_model->get_order_bynumber($pay_sn);
				$ub_money = 0;
				$pl_points = 0;
				$use_points = 0;
				foreach ($a_this_order as $key => $value) {
					$ub_money = $ub_money + $value['balance_deduction'];
					$pl_points = $pl_points + $value['use_jife'];
					$use_points = $use_points + $value['use_points'];
					// 如果有座位抵扣则将座位状态改为服务中
					if (!empty($value['appointment_use'])) {
						$appointment_arr = explode(',', $value['appointment_use']);
						$a_update_data = [
							'appointment_state' => 3
						];
						$this->newpay_model->update_appointment_inserver($appointment_arr,$a_update_data);
						// 获取一条门店信息
						$this_store = $this->newpay_model->get_store_one($value['store_id']);
						// 更新门店成交的座位数
						$a_where_store = [
							'store_id' => $value['store_id']
						];
						$a_data_store = [
							'book_count' => $this_store['book_count'] + count($appointment_arr),
						];
						$this->newpay_model->update_store($a_where_store, $a_data_store);
					}
				}
				// 判断订单是否有积分抵扣或者余额抵扣
				$user_id = $a_this_order[0]['user_id'];
				$a_user = $this->newpay_model->get_user_one($user_id);
				if ($ub_money > 0) {
					// 使用了余额抵扣的业务
					$a_ubdata = [
						'ub_type'        => 2,
						'ub_money'       => $ub_money,
						'ub_balance'     => $a_user['user_balance'] - $ub_money,
						'ub_time'        => $_SERVER['REQUEST_TIME'],
						'ub_item'        => '余额抵扣',
						'ub_description' => '商品支付时使用余额抵扣了' . $ub_money. '元',
						'user_id'        => $user_id,
						'ub_number'      => $pay_sn,
					];
					$i_result = $this->newpay_model->insert_userbalance($a_ubdata);
					// 将用户的余额加上
					$a_uwhere = [
						'user_id' => $user_id,
					];
					$a_udata = [
						'user_balance' => $a_user['user_balance'] - $ub_money,
					];
					$i_uint = $this->newpay_model->update_user($a_uwhere, $a_udata);
				}
				if ($pl_points > 0) {
					// 使用了积分抵扣的业务
					$a_insert_data = [
						'user_id'        => $user_id,
						'user_name'      => $a_user['user_name'],
						'pl_type'        => 2,
						'pl_variation'   => $pl_points,
						'pl_score'       => $a_user['user_score'] - $pl_points,
						'pl_item'        => '积分抵现',
						'pl_description' => '订单'. $pay_sn. '支付时使用积分抵扣了' . $use_points . '元',
						'pl_time'        => $_SERVER['REQUEST_TIME'],
						'pl_code'        => 4,
					];
					$i_result = $this->newpay_model->insert_points_log($a_insert_data);
					// 减少用户的积分
					$a_uuwhere = [
						'user_id' => $user_id,
					];
					$a_uudata = [
						'user_score' => $a_user['user_score'] - $pl_points,
					];
					$i_uuint = $this->newpay_model->update_user($a_uuwhere, $a_uudata);
				}
				$a_parameter = [
					'msg'      => '支付成功',
					'url'      => '这是要跳转到的url',
					'log'      => false,
					'wait'     => 2,
				];
				if ($i_result_order) {
					$a_parameter['msg'] = '支付成功';
					$a_parameter['url'] = 'goods_order';
					 // echo'<script src="static/style_default/plugin/layer/layer.js?v=4.0"></script>';
					 echo"<script>alert('支付成功');location.replace('goods_order');</script>";  
				} else {
					$a_parameter['msg'] = '支付失败';
					$a_parameter['url'] = 'goods_order';
					 echo"<script>alert('支付失败');location.replace('goods_order');</script>";  
				}
			}
			if($actual_pay < $goods_amount && $actual_pay > 0) {
				// 支付成功后修改订单状态
				$a_order_where = [
					'pay_sn' => $pay_sn,
				];
				// $a_order_data = [
				// 	'order_time'   => $_SERVER['REQUEST_TIME'],
				// 	'payment_code' => 'online',
				// 	'order_state'  => 20
				// ];
				// $i_result_order = $this->newpay_model->update_order($a_order_where, $a_order_data);
				// 获取一条订单信息
				$a_this_order = $this->newpay_model->get_order_bynumber($pay_sn);
				$ub_money = 0;
				$pl_points = 0;
				$use_points = 0;
				foreach ($a_this_order as $key => $value) {
					$ub_money = $ub_money + $value['balance_deduction'];
					$pl_points = $pl_points + $value['use_jife'];
					$use_points = $use_points + $value['use_points'];
					// 如果有座位抵扣则将座位状态改为服务中
					if (!empty($value['appointment_use'])) {
						$appointment_arr = explode(',', $value['appointment_use']);
						$a_update_data = [
							'appointment_state' => 3,
							'officeseat_state'  =>0
						];
						$this->newpay_model->update_appointment_inserver($appointment_arr,$a_update_data);
						// 获取一条门店信息
						$this_store = $this->newpay_model->get_store_one($value['store_id']);
						// 更新门店成交的座位数
						$a_where_store = [
							'store_id' => $value['store_id']
						];
						$a_data_store = [
							'book_count' => $this_store['book_count'] + count($appointment_arr),
						];
						$this->newpay_model->update_store($a_where_store, $a_data_store);
					}
				}
				// 判断订单是否有积分抵扣或者余额抵扣
				$user_id = $a_this_order[0]['user_id'];
				$a_user = $this->newpay_model->get_user_one($user_id);
				if ($ub_money > 0) {
					// 使用了余额抵扣的业务
					$a_ubdata = [
						'ub_type'        => 2,
						'ub_money'       => $ub_money,
						'ub_balance'     => $a_user['user_balance'] - $ub_money,
						'ub_time'        => $_SERVER['REQUEST_TIME'],
						'ub_item'        => '余额抵扣',
						'ub_description' => '商品支付时使用余额抵扣了' . $ub_money. '元',
						'user_id'        => $user_id,
						'ub_number'      => $pay_sn,
					];
					$i_result = $this->newpay_model->insert_userbalance($a_ubdata);
					// 将用户的余额加上
					$a_uwhere = [
						'user_id' => $user_id,
					];
					$a_udata = [
						'user_balance' => $a_user['user_balance'] - $ub_money,
					];
					$i_uint = $this->newpay_model->update_user($a_uwhere, $a_udata);
				}
				if ($pl_points > 0) {
					// 使用了积分抵扣的业务
					$a_insert_data = [
						'user_id'        => $user_id,
						'user_name'      => $a_user['user_name'],
						'pl_type'        => 2,
						'pl_variation'   => $pl_points,
						'pl_score'       => $a_user['user_score'] - $pl_points,
						'pl_item'        => '积分抵现',
						'pl_description' => '订单'. $pay_sn. '支付时使用积分抵扣了' . $use_points . '元',
						'pl_time'        => $_SERVER['REQUEST_TIME'],
						'pl_code'        => 4,
					];
					$i_result = $this->newpay_model->insert_points_log($a_insert_data);
					// 减少用户的积分
					$a_uuwhere = [
						'user_id' => $user_id,
					];
					$a_uudata = [
						'user_score' => $a_user['user_score'] - $pl_points,
					];
					$i_uuint = $this->newpay_model->update_user($a_uuwhere, $a_uudata);
				}				
			}

		
			// 订单生成成功 且实付款不为零 前去支付
			if ($order_id) {

				// pay_type == 1 代表支付宝支付 为2代表微信支付 为3代表网关支付
				if ($pay_type == 1) {
					// 加载手机版支付接口类
					$this->load->library('alipay_wap');
					$a_data = [
						// 商户订单号，商户网站订单系统中唯一订单号，必填
						'out_trade_no' => $pay_sn,
						// 订单名称，必填
						'subject' => '订单支付',
						// 付款金额，必填
						// 'total_amount' => 0.01,
						'total_amount' => $actual_pay,
						// 商品描述，可空
						'body' => '订单支付',
						/** 该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，
							1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。
							该参数数值不接受小数点， 如 1.5h，可转换为 90m。
						*/
						'timeout_express' => '24h',
						// 设置是跳转到支付宝页面，还是返回执行结果，默认为前者，这里我们要设置为获取执行结果
						// 异步通知地址，当设置此参数时，将忽略配置文件中的通知地址
						'notify_url' => $this->router->url('newpay_alipaynot'),
						// 同步通知地址，当设置此参数时，将忽略配置文件中的通知地址
						'return_url' => $this->router->url('newpay_alipayret'),
					];
					// print_r($a_data);die;
					echo $a = $this->alipay_wap->pay($a_data);
				} else if ($pay_type == 2) {
					// echo 1111;exit;
					// 此处是微信支付
					$a_data = [
						// 商品描述, 必填
						'body' => '商品支付',
						// 商户订单号, 必填
						'out_trade_no' => $pay_sn,
						// 标价金额,以分为单位, 必填
						// 'total_fee' => 1,
						'total_fee' => $actual_pay*100,
						// 终端IP, 必填
						'spbill_create_ip' => $this->general->get_ip(),
						// 通知地址
						'notify_url' => $this->router->url('newpay_wxpaynot'),
						// 'notify_url' => 'http://wofei_wap.7dugo.com/recharge_wxpaynot.html',
					];
					// print_r($a_data);die
					$this->load->library('wxpay_h5', '', [$a_data]);
					$a_result = $this->wxpay_h5->pay();
					// var_dump($a_result);exit;

					// 这里是支付链接
					// echo '<a href="' . $a_result['mweb_url'] . '">支付</a>';
					$url = $a_result['mweb_url'];
					header("location:$url");
				
				} else if ($pay_type == 3) {
					// 此处为银联网关支付
					$this->load->library('unionpay_geteway');
					$a_param = [
						// 订单号
						'id_order' => $pay_sn,
						// 订单金额，以分为单位
						// 'amount' => 1,
						'amount' => $actual_pay*100,
						// （选填）前台返回链接， 不传此参数将默认使用配置文件中的设置url
						'url_front' => $this->router->url('newpay_unionret'),
						// （选填）后台返回链接， 不传此参数将默认使用配置文件中的设置url
						'url_back' => $this->router->url('newpay_unionnot')
					];
					$a_result = $this->unionpay_geteway->pay($a_param);
					// print_r($a_result);
				}
			}
		}
	}

/************************************ 支付宝同步 ************************************/

	public function newpay_alipayret() {
		$this->load->library('alipay_wap');
		// 安全验证，确认是不是支付宝返回的正确数据
		$a_parameter = [
			'msg'      => '这是提示信息',
			'url'      => '这是要跳转到的url',
			'log'      => false,
			'wait'     => 2,
		];
		if ($this->alipay_wap->verify($_GET)) {
			// 查询订单证实是否支付成功
			$a_data = [
				// 商户订单号，商户网站订单系统中唯一订单号，必填
				'out_trade_no' => $_GET['out_trade_no'],
				// 支付宝交易号，和上面的参数二选一
				'trade_no'     => '',
				'is_page'      => false
			];
			// 显示返回的查询结果
			$pay_result = $this->alipay_wap->query($a_data);
			if ($pay_result['code'] == 10000) {
				$a_parameter['msg'] = '支付成功';
				$a_parameter['url'] = 'goods_order';
				// $this->error->show_success($a_parameter);
				 echo"<script>alert('支付成功');location.replace('goods_order');</script>";
        	} else {
				$a_parameter['msg'] = '支付失败';
				$a_parameter['url'] = 'goods_order';
				// $this->error->show_error($a_parameter);
				 echo"<script>alert('支付失败');location.replace('goods_order');</script>";
        	}
		} else {
			// 没有通过验证，肯定数据有问题，不做任何处理
			$a_parameter['msg'] = '支付失败';
			$a_parameter['url'] = 'goods_order';
			 echo"<script>alert('支付失败');location.replace('goods_order');</script>";
		}
	}

/************************************ 支付宝异步 ************************************/

	public function newpay_alipaynot() {
		$this->load->library('alipay_wap');
		// 安全验证，确认是不是支付宝返回的正确数据
		if ($this->alipay_wap->verify($_POST, 'notify') && ($_POST['trade_status'] == 'TRADE_SUCCESS' || $_POST['trade_status'] == 'TRADE_FINISHED')) {
			// 支付成功后修改订单状态
			$a_order_where = [
				'pay_sn' => $_POST['out_trade_no'],
			];
			$a_order_data = [
				'order_time'   => $_SERVER['REQUEST_TIME'],
				'payment_code' => 'alipay',
				'order_state'  => 20,
			];
			$i_result_order = $this->newpay_model->update_order($a_order_where, $a_order_data);
			// 获取一条订单信息
			$a_this_order = $this->newpay_model->get_order_bynumber($_POST['out_trade_no']);
			$ub_money = 0;
			$pl_points = 0;
			$use_points = 0;
			foreach ($a_this_order as $key => $value) {
				$ub_money = $ub_money + $value['balance_deduction'];
				$pl_points = $pl_points + $value['use_jife'];
				$use_points = $use_points + $value['use_points'];
				// 如果有座位抵扣则将座位状态改为服务中
				if (!empty($value['appointment_use'])) {
					$appointment_arr = explode(',', $value['appointment_use']);
					$a_update_data = [
						'ishave_deduction' => 2
					];
					$this->newpay_model->update_appointment_inserver($appointment_arr,$a_update_data);
					// 获取一条门店信息
					$this_store = $this->newpay_model->get_store_one($value['store_id']);
					// 更新门店成交的座位数
					$a_where_store = [
						'store_id' => $value['store_id']
					];
					$a_data_store = [
						'book_count' => $this_store['book_count'] + count($appointment_arr),
					];
					$this->newpay_model->update_store($a_where_store, $a_data_store);
				}
				$a_track = [
		    		'order_id'     => $value['order_id'],
		    		'order_number' => $value['order_number'],
		    		'name'		   => '订单已支付',
		    		'time'	       => $_SERVER['REQUEST_TIME'],
		    	];
		    	$this->db->insert('order_tracking', $a_track);
			}
			// 判断订单是否有积分抵扣或者余额抵扣
			$user_id = $a_this_order[0]['user_id'];
			$a_user = $this->newpay_model->get_user_one($user_id);
			if ($ub_money > 0) {
				// 使用了余额抵扣的业务
				$a_ubdata = [
					'ub_type'        => 2,
					'ub_money'       => $ub_money,
					'ub_balance'     => $a_user['user_balance'] - $ub_money,
					'ub_time'        => $_SERVER['REQUEST_TIME'],
					'ub_item'        => '余额抵扣',
					'ub_description' => '商品支付时使用余额抵扣了' . $ub_money. '元',
					'user_id'        => $user_id,
					'ub_number'      => $_POST['out_trade_no'],
				];
				$i_result = $this->newpay_model->insert_userbalance($a_ubdata);
				// 将用户的余额加上
				$a_uwhere = [
					'user_id' => $user_id,
				];
				$a_udata = [
					'user_balance' => $a_user['user_balance'] - $ub_money,
				];
				$i_uint = $this->newpay_model->update_user($a_uwhere, $a_udata);
			}
			if ($pl_points > 0) {
				// 使用了积分抵扣的业务
				$a_insert_data = [
					'user_id'        => $user_id,
					'user_name'      => $a_user['user_name'],
					'pl_type'        => 2,
					'pl_variation'   => $pl_points,
					'pl_score'       => $a_user['user_score'] - $pl_points,
					'pl_item'        => '积分抵现',
					'pl_description' => '订单'. $_POST['out_trade_no']. '支付时使用积分抵扣了' . $use_points . '元',
					'pl_time'        => $_SERVER['REQUEST_TIME'],
					'pl_code'        => 4,
				];
				$i_result = $this->newpay_model->insert_points_log($a_insert_data);
				// 减少用户的积分
				$a_uuwhere = [
					'user_id' => $user_id,
				];
				$a_uudata = [
					'user_score' => $a_user['user_score'] - $pl_points,
				];
				$i_uuint = $this->newpay_model->update_user($a_uuwhere, $a_uudata);
			}
			echo "success";
		} else {
			// 没有通过验证，肯定数据有问题，不做任何处理
		}
	}

/************************************ 微信异步 ************************************/

	public function newpay_wxpaynot() {
		// 接收微信返回的通知xml数据， 也可以用 $GLOBALS['HTTP_RAW_POST_DATA'] 获取post数据
		$s_xml = file_get_contents('php://input');
		// 加载微信支付类
		$this->load->library('wxpay_h5');
		// 把微信返回的通知xml数据转换为数组格式
		$a_data = $this->wxpay_h5->xml_to_array($s_xml);

		// 验证签名成功
		if ($this->wxpay_h5->verify($a_data)) {
			// 判断结果的状态是否为成功， 第二个参数支持：PAY/REFUND/QUERY 等，对应相应的函数
			if ($this->wxpay_h5->check($a_data, 'PAY')) {
				// 也可以用自行验证，但是需要自己查阅微信接口文档，因为不同的操作，验证参数不一样
				//if ($a_data['return_code'] == 'SUCCESS' && $a_data['result_code'] == 'SUCCESS') {

				// 处理订单逻辑，比如更新订单的状态为付款成功等

				// 支付成功后修改订单状态
				$a_order_where = [
					'pay_sn' => $a_data['out_trade_no'],
				];
				$a_order_data = [
					'order_time'   => $_SERVER['REQUEST_TIME'],
					'payment_code' => 'offline',
					'order_state'  => 20
				];
				$i_result_order = $this->newpay_model->update_order($a_order_where, $a_order_data);
				// 获取一条订单信息
				$a_this_order = $this->newpay_model->get_order_bynumber($a_data['out_trade_no']);
				$ub_money = 0;
				$pl_points = 0;
				$use_points = 0;
				foreach ($a_this_order as $key => $value) {
					$ub_money = $ub_money + $value['balance_deduction'];
					$pl_points = $pl_points + $value['use_jife'];
					$use_points = $use_points + $value['use_points'];
					// 如果有座位抵扣则将座位状态改为服务中
					if (!empty($value['appointment_use'])) {
						$appointment_arr = explode(',', $value['appointment_use']);
						$a_update_data = [
							'ishave_deduction' => 2
						];
						$this->newpay_model->update_appointment_inserver($appointment_arr,$a_update_data);
					}
					$a_track = [
			    		'order_id'     => $value['order_id'],
			    		'order_number' => $value['order_number'],
			    		'name'		   => '订单已支付',
			    		'time'	       => $_SERVER['REQUEST_TIME'],
			    	];
			    	$this->db->insert('order_tracking', $a_track);
				}
				// 判断订单是否有积分抵扣或者余额抵扣
				$user_id = $a_this_order[0]['user_id'];
				$a_user = $this->newpay_model->get_user_one($user_id);
				if ($ub_money > 0) {
					// 使用了余额抵扣的业务
					$a_ubdata = [
						'ub_type'        => 2,
						'ub_money'       => $ub_money,
						'ub_balance'     => $a_user['user_balance'] - $ub_money,
						'ub_time'        => $_SERVER['REQUEST_TIME'],
						'ub_item'        => '余额抵扣',
						'ub_description' => '商品支付时使用余额抵扣了' . $ub_money. '元',
						'user_id'        => $user_id,
						'ub_number'      => $a_data['out_trade_no'],
					];
					$i_result = $this->newpay_model->insert_userbalance($a_ubdata);
					// 将用户的余额加上
					$a_uwhere = [
						'user_id' => $user_id,
					];
					$a_udata = [
						'user_balance' => $a_user['user_balance'] -$ub_money,
					];
					$i_uint = $this->newpay_model->update_user($a_uwhere, $a_udata);
				}
				if ($pl_points > 0) {
					// 使用了积分抵扣的业务
					$a_insert_data = [
						'user_id'        => $user_id,
						'user_name'      => $a_user['user_name'],
						'pl_type'        => 2,
						'pl_variation'   => $pl_points,
						'pl_score'       => $a_user['user_score'] - $pl_points,
						'pl_item'        => '积分抵现',
						'pl_description' => '订单'. $a_data['out_trade_no']. '支付时使用积分抵扣了' . $use_points . '元',
						'pl_time'        => $_SERVER['REQUEST_TIME'],
						'pl_code'        => 4,
					];
					$i_result = $this->newpay_model->insert_points_log($a_insert_data);
					// 减少用户的积分
					$a_uuwhere = [
						'user_id' => $user_id,
					];
					$a_uudata = [
						'user_score' => $a_user['user_score'] - $pl_points,
					];
					$i_uuint = $this->newpay_model->update_user($a_uuwhere, $a_uudata);
				}
				// 通知微信，我们已经收到消息，知道付款成功了，如果不通知微信，微信会一直给我们发消息
				echo $this->wxpay_h5->success();
			} else {
				// 支付结果失败，所以这里是不能更新付款状态为成功的
			}
		} else {
			// 验证签名失败，数据肯定存在问题，所以不做任何处理，无视即可
		}
	}

/************************************* 银联异步 *************************************/

	public function newpay_unionnot() {
		$this->load->library('unionpay_geteway');
		// 安全验证，确认是不是银联返回的正确数据
		if ($this->unionpay_geteway->verify($this->general->post())) {
			$a_data = $this->general->post();
			// 验证签名成功
			if ($a_data['respCode'] == '00') {
				// 把订单的状态改为已经付款成功
				// 进行交易相关的业务逻辑处理
				$a_order_where = [
				 	'pay_sn' => $a_data['orderId'],
				];
				$a_order_data = [
					'order_time'   => $_SERVER['REQUEST_TIME'],
					'payment_code' => 'unionpay',
					'order_state'  => 20,
				];
				$i_result_order = $this->newpay_model->update_order($a_order_where, $a_order_data);
				// 获取一条订单信息
				$a_this_order = $this->newpay_model->get_order_bynumber($a_data['orderId']);
				$ub_money = 0;
				$pl_points = 0;
				$use_points = 0;
				foreach ($a_this_order as $key => $value) {
					$ub_money = $ub_money + $value['balance_deduction'];
					$pl_points = $pl_points + $value['use_jife'];
					$use_points = $use_points + $value['use_points'];
					// 如果有座位抵扣则将座位状态改为服务中
					if (!empty($value['appointment_use'])) {
						$appointment_arr = explode(',', $value['appointment_use']);
						$a_update_data = [
							'ishave_deduction' => 2
						];
						$this->newpay_model->update_appointment_inserver($appointment_arr,$a_update_data);
					}
					$a_track = [
			    		'order_id'     => $value['order_id'],
			    		'order_number' => $value['order_number'],
			    		'name'		   => '订单已支付',
			    		'time'	       => $_SERVER['REQUEST_TIME'],
			    	];
			    	$this->db->insert('order_tracking', $a_track);
				}
				// 判断订单是否有积分抵扣或者余额抵扣
				$user_id = $a_this_order[0]['user_id'];
				$a_user = $this->newpay_model->get_user_one($user_id);
				if ($ub_money > 0) {
				 // 使用了余额抵扣的业务
				 $a_ubdata = [
					'ub_type'        => 2,
					'ub_money'       => $ub_money,
					'ub_balance'     => $a_user['user_balance'] - $ub_money,
					'ub_time'        => $_SERVER['REQUEST_TIME'],
					'ub_item'        => '余额抵扣',
					'ub_description' => '商品支付时使用余额抵扣了' . $ub_money. '元',
					'user_id'        => $user_id,
					'ub_number'      => $a_data['orderId'],
				 ];
				 $i_result = $this->newpay_model->insert_userbalance($a_ubdata);
				 // 将用户的余额加上
				 $a_uwhere = [
				   	'user_id' => $user_id,
				 ];
				 $a_udata = [
				   	'user_balance' => $a_user['user_balance'] - $ub_money,
				 ];
				 $i_uint = $this->newpay_model->update_user($a_uwhere, $a_udata);
				}
				if ($pl_points > 0) {
					// 使用了积分抵扣的业务
					$a_insert_data = [
						'user_id'        => $user_id,
						'user_name'      => $a_user['user_name'],
						'pl_type'        => 2,
						'pl_variation'   => $pl_points,
						'pl_score'       => $a_user['user_score'] - $pl_points,
						'pl_item'        => '积分抵现',
						'pl_description' => '订单'. $a_data['orderId']. '支付时使用积分抵扣了' . $use_points . '元',
						'pl_time'        => $_SERVER['REQUEST_TIME'],
						'pl_code'        => 4,
					];
					$i_result = $this->newpay_model->insert_points_log($a_insert_data);
					// 减少用户的积分
					$a_uuwhere = [
						'user_id' => $user_id,
					];
					$a_uudata = [
						'user_score' => $a_user['user_score'] - $pl_points,
					];
					$i_uuint = $this->newpay_model->update_user($a_uuwhere, $a_uudata);
				}
			} elseif (in_array($a_data['respCode'], ['03', '04', '05'])) {
				echo '交易处理中';
			} else {
				echo '交易失败';
			}
		} else {
			// 没有通过验证，肯定数据有问题，不做任何处理
		}
	}

/************************************* 银联同步 *************************************/

	public function newpay_unionret() {
		$this->load->library('unionpay_geteway');
		// 安全验证，确认是不是银联返回的正确数据
		if ($this->unionpay_geteway->verify($this->general->post())) {
			$a_data = $this->general->post();
			// 验证签名成功
			if ($a_data['respCode'] == '00') {
				// 把订单的状态改为已经付款成功
				// 进行交易相关的业务逻辑处理
				$a_parameter = [
					'msg'      => '支付成功',
					'url'      => 'goods_order',
					'log'      => false,
					'wait'     => 2,
				];
				// $this->error->show_success($a_parameter);
				 echo"<script>alert('支付成功');location.replace('goods_order');</script>";
			} elseif (in_array($a_data['respCode'], ['03', '04', '05'])) {
				$a_parameter = [
					'msg'      => '正在处理中',
					'url'      => 'goods_order',
					'log'      => false,
					'wait'     => 2,
				];
				 echo"<script>alert('正在处理中');location.replace('goods_order');</script>";
				// $this->error->show_error($a_parameter);
			} else {
				$a_parameter = [
					'msg'      => '支付失败',
					'url'      => 'goods_order',
					'log'      => false,
					'wait'     => 2,
				];
				 echo"<script>alert('支付失败');location.replace('goods_order');</script>";
				// $this->error->show_error($a_parameter);
			}
		} else {
			// 没有通过验证，肯定数据有问题，不做任何处理
		}
	}

	public function weixin_ispay_bill() {
		// $this->order_model->system_sure_order();
		$this->order_model->system_sure_book_order();
		$a_data = $this->newpay_model->get_order_second();
		if ($a_data) {
			echo json_encode(array('code'=>200));
		} else {
			echo json_encode(array('code'=>400));
		}
	}

/************************************************************************************/



}

?>