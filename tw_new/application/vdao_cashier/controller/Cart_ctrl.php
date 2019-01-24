<?php
defined('BASEPATH') OR exit('禁止访问！');

class Cart_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('auth_model');
		$this->load->model('cart_model');
	}

	// 加入购物车
	public function cart_add() {
		$a_cart = [];
		$a_cart['product_id'] = $this->general->post('product_id');

		$a_data = $this->db->get_row('product', ['product_id' => $a_cart['product_id']]);
		if ( ! isset($a_data['product_name']) ) {
			echo json_encode(['msg' => 'product_not']);
			exit;
		}
		$a_cart['product_name'] = $a_data['product_name'];
		$a_cart['pro_img'] = $a_data['pro_img'];
		$a_cart['num'] = $this->general->post('num');

		$a_cart['price_id'] = $this->general->post('price_id');
		$a_data = $this->db->get_row('price', ['price_id' => $a_cart['price_id']]);
		if ( ! isset($a_data['price']) ) {
			echo json_encode(['msg' => 'price_not']);
			exit;
		}
		$a_cart['price'] = $a_data['price'];
		$a_cart['cup_name'] = $a_data['cup_name'];
		if (empty($this->general->post('atte'))) {
			$a_data = explode('|', $this->general->post('attr'));
			$a_data = array_unique($a_data);
			if ( ! empty($a_data) ) {
				foreach ($a_data as $i_aid) {
					if ( ! empty($i_aid) ) {
						$a_tdata = $this->db->get_row('attributive', ['attri_id' => $i_aid]);
						// $a_cart['attr'][] = ['attr_id' => $i_aid, 'attr_name' => $a_tdata['attri_name']];
						$a_cart['attr'][] = ['attr_name' => $a_tdata['attri_name']];
						// print_r($a_cart['attr']);
						$a_cart['shux'] .= '/' . $a_tdata['attri_name'];
						$a_cart['s_attr'] .= '|' . $i_aid;
					}

				}
			}
		} else {
			$a_cart['attr'][] = ['attr_name' => $this->general->post('atte')];
			// print_r($a_cart['attr']);
			$a_cart['shux'] .= '/' . $this->general->post('atte');		
		}
		// 合并产品
		$this->cart_model->merge($a_cart);

		$a_json = $this->cart_model->data();
		$a_json['msg'] = 'success';
		echo json_encode($a_json);
	}

	// 增加或减少数量
	public function cart_add_subtract() {
		$i_index = $this->general->post('index');
		$s_method = $this->general->post('method');
		if (isset($_SESSION['cashier']['cart'][$i_index]['product_id'])) {
			if ('add' == $s_method) {
				$_SESSION['cashier']['cart'][$i_index]['num']++;
			} elseif ('subtract' == $s_method) {
				if (1 >= $_SESSION['cashier']['cart'][$i_index]['num']) {
					unset($_SESSION['cashier']['cart'][$i_index]);
				} else {
					$_SESSION['cashier']['cart'][$i_index]['num']--;
				}
			}
		}
		$_SESSION['cashier']['cart'] = array_values($_SESSION['cashier']['cart']);
		$this->cart_data();
	}

	// 输出当前购物车数据
	public function cart_data() {
		$a_json = $this->cart_model->data();
		echo json_encode($a_json);
	}

	// 保存订单
	public function create_order() {
		// 支付单号
		//$i_pay_sn  = $_SERVER['REQUEST_TIME'] . $_SESSION['manager_id'] . rand(1000,9999);
		// 订单号
		list($i_msec, $i_sec) = explode('.', microtime(true));
		$i_order_number = date('YmdH', $_SERVER['REQUEST_TIME']) . $_SESSION['manager_id'] . $i_sec . $i_msec;
		// 拼装order表插入的数据
		$a_data = [
			'store_id' 		=> $_SESSION['store_id'],
			'store_name' 	=> $_SESSION['store_name'],
			'order_number' 	=> $i_order_number,
			'pay_sn' 		=> $i_order_number,
			'user_id' 		=> 0,
			'user_name'   	=> '',
			'time_create' 	=> $_SERVER['REQUEST_TIME'],
			'payment_code' 	=> 'cashier',
			'goods_amount' 	=> $_SESSION['cashier']['cart_product_money'],
			'order_price' 	=> $_SESSION['cashier']['cart_product_money'],
			'actual_pay'    => $_SESSION['cashier']['cart_product_money'],
			'shipping_fee' 	=> 0,
			'order_state' 	=> 40,
			'order_count'	=> $_SESSION['cashier']['cart_product_num'],
			'use_points' 	=> 0,
			'order_stye'    => 2,
			'addres_post' 	=> '',
			'order_message' => '',
			'reciver_name'  => '',
			'addres'        => '',
			'mob_phone'     => '',
			'tel_phone'     => '',
			'time_delay'    => '',
		];
		try {
			// 开启异常抛出
			// $this->db->_b_is_throw = true;
			// 开启事务
			$this->db->begin();
			//插入order表数据
			$i_order_id = $this->db->insert('order', $a_data);
			foreach ($_SESSION['cashier']['cart'] as $a_cart) {
				$s_attr = '';
				if (isset($a_cart['attr']) && is_array($a_cart['attr'])) {
					foreach ($a_cart['attr'] as $a_attr) {
						$s_attr .= $a_attr['attr_name'] . '/';
					}
				}
				$i_cup = $this->db->get_row('price', ['price_id' => $a_cart['price_id']]);
				// 没有存储属性id的字段
				$a_goods[] = [
					'order_id' 		=> $i_order_id,
					'product_id' 	=> $a_cart['product_id'],
					'product_name'	=> $a_cart['product_name'],
					'money' 	    => $a_cart['price'],
					'goods_pay_price'=>$a_cart['price'],
					'goods_num' 	=> $a_cart['num'],
					'cup_name'      => $a_cart['cup_name'],
					'cup_id'        => $i_cup['cup_id'],
					'spec'          => $a_cart['cup_name']."/".$s_attr,
					'pro_img' 	    => $a_cart['pro_img'],
					'store_id' 		=> $_SESSION['store_id'],
					'user_id' 		=> 0,
				];
			}
			$this->db->inserts('order_goods', $a_goods);
			//插入订单历史表tw_order_log
			$b_order_log = $this->db->insert('order_log', ['order_id' => $i_order_id,'log_msg' => '用户提交订单','log_time' => $_SERVER['REQUEST_TIME'],'log_role' => '系统', 'log_user' => '系统', 'log_orderstate' => 40]);

			$this->db->commit();
		} catch (Exception $e) {
			// 事务回滚
			$this->db->roll_back();
		}
		if ($i_order_id) {
			$_SESSION['cashier']['cart_order_id'] = $i_order_id;
			$_SESSION['cashier']['cart_order_number'] = $i_order_number;
			header("Location: " . $this->router->url('pay', ['order_id' => $i_order_id]));
		} else {
			$this->error->show_error('保存订单失败！', $this->router->url('index'));
		}
	}

	// 显示支付页面
	public function pay() {
		$i_order_id = intval($this->router->get(1));
		if ( ! $i_order_id ) {
			$this->error->show_error('订单提交失败！', $this->router->url('index'));
		}
		if ($i_order_id != $_SESSION['cashier']['cart_order_id']) {
			$this->error->show_error('无效订单！', $this->router->url('index'));
		}
		$a_data = $this->cart_model->data();
		$this->view->display('pay', $a_data);
	}

	// 手动确认支付成功，默认记录为现金支付
	public function pay_finsh() {
		$this->pay_money();
		unset($_SESSION['cashier']);
		header("Location: " . $this->router->url('index'));
	}

	// 手动取消支付
	public function pay_cancel() {
		unset($_SESSION['cashier']);
		header("Location: " . $this->router->url('index'));
	}

	// 显示支付页面
	public function set_order_member() {
		$i_user_id = intval($this->general->post('member_id'));
		$a_data = $this->db->get_row('user', ['user_id' => $i_user_id]);
		if (isset($a_data['user_name'])) {
			$a_updata = [
				'user_id' => $i_user_id,
				'user_name' => $a_data['user_name']
			];
			$a_where = [
				'order_id' => $_SESSION['cashier']['cart_order_id'],
				'store_id' => $_SESSION['store_id'],
				'order_state' => 40,
				'payment_code' => 'cashier'
			];
			$this->db->update('order', $a_updata, $a_where);
		}
	}

	// 生成二维码
	public function qrcode() {
		$s_url = $this->general->base64_convert($this->router->get(1), true);
		// 生成二维码文件
		$this->load->library('phpqrcode');
		$a_param = [
			// 要生成二维码的数据，必填
			'data' => $s_url,
			// 二维码图片大小，选填，默认4
			'size' => 3,
			// 二维码错误修正级别L/M/Q/H，选填，默认“L”。L水平 7% 的字码可被修正，M水平 15% 的字码可被修正，Q水平 25% 的字码可被修正，H水平 30% 的字码可被修正
			'level' => 'H'
		];
		$this->phpqrcode->qrcode($a_param);
	}

	// 轮询支付结果
	public function pay_result() {
		$this->cart_model->query_ali($_SESSION['cashier']['cart_order_number']);
		$a_result = $this->db->get_row('order', ['order_number' => $_SESSION['cashier']['cart_order_number']]);
		$a_json = $_SESSION['cashier'];
		$s_ordersn = $this->auth_model->get_ordersn();
		(!empty($s_ordersn))?$s_ordersn+=1:$s_ordersn = '101';
				
		if ($a_result['order_state'] == 10) {
			$this->auth_model->create_ordersn($s_ordersn);
			//订单相对的产品减少耗材
			$this->load->model('delivery_model');
			$this->delivery_model->delivery($a_result['order_id']);
			// 给用户结算积分
			$this->load->model('order_model');
			$this->order_model->point($a_result['order_id']);
			$a_json['product_num']   = $_SESSION['cashier']['cart_product_num'];
			$a_json['product_money'] = $_SESSION['cashier']['cart_product_money'];
			$a_json['manager_id']    = $_SESSION['manager_id'];
			$a_json['store_name']    = $_SESSION['store_name'];
			$a_json['store_address'] = $_SESSION['store_address'];
			$a_json['series_number'] = $s_ordersn;
			$a_json['pay_result']    = 'success';
			// 消除订单缓存
			unset($_SESSION['cashier']);
		}
		$a_json['series_number'] = $s_ordersn;
		echo json_encode($a_json);
	}

	// 现金支付
	public function pay_money() {
		if (isset($_SESSION['cashier']['cart_order_number']) && isset($_SESSION['cashier']['cart_product_money'])) {
			// echo json_encode(["msg" => 'sddd']);exit;
			$this->cart_model->order_complete($_SESSION['cashier']['cart_order_number'], $_SESSION['cashier']['cart_product_money'], 'cashier', '现金支付');
		}
	}

	// 支付宝支付
	public function pay_alipay() {
		$s_auth_code = $this->general->post('auth_code');
		if (is_numeric($s_auth_code) && isset($_SESSION['cashier']['cart_order_number']) && isset($_SESSION['cashier']['cart_product_money'])) {
			$this->load->library('alipay_f2f');
			$a_param = [
				// (必填) 商户网站订单系统中唯一订单号，64个字符以内，只能包含字母、数字、下划线
				'out_trade_no' => $_SESSION['cashier']['cart_order_number'],
				// (必填) 订单总金额，单位为元，不能超过1亿元
				'total_amount' => $_SESSION['cashier']['cart_product_money'],
				// (必填) 付款条码，用户支付宝钱包手机app点击“付款”产生的付款条码，（通过扫码枪获取）
				'auth_code' => $s_auth_code,
				// (必填) 订单标题，粗略描述用户的支付目的。如“XX品牌XXX门店消费”
				'subject' => '(V稻)' . $_SESSION['store_name'] . '收银机订单',
				// (可选) 订单描述，可以对交易或商品进行一个详细地描述，比如填写"购买商品2件共15.00元"
				//'body' => '测试'
			];
			$a_result = $this->alipay_f2f->pay($a_param);
			if ($a_result['trade_no'] && $a_result['trade_status'] == 'TRADE_SUCCESS') {
				$this->cart_model->order_complete($a_result['out_trade_no'], $a_result['total_amount'], 'alipay', $a_result['trade_no']);
			}
		}
	}

	// 微信支付
	public function pay_weixin() {
		$s_auth_code = $this->general->post('auth_code');
		// 根据订单号获取一条数据
		$a_where = [
			'order_number' => $_SESSION['cashier']['cart_order_number']
		];
		$a_data = $this->db->get_row('order', $a_where);
		// 生成新订单号
		$new_number = date('YmdHis').rand(111,999);
		$_SESSION['cashier']['cart_order_number'] = $new_number;
		// 更新订单号
		$u_where = [
			'order_id' => $a_data['order_id'],
		];
		$u_data = [
			'order_number' => $new_number
		];
		$i_result = $this->db->update('order', $u_data, $u_where);
		if (is_numeric($s_auth_code) && isset($_SESSION['cashier']['cart_order_number']) && isset($_SESSION['cashier']['cart_product_money']) && $i_result) {
			$this->load->library('wxpay_pub');
			$a_param = [
				// 商品描述，必填
				'body' => '(V稻)' . $_SESSION['store_name'] . '收银机订单',
				// 商户订单号，必填
				'out_trade_no' => $_SESSION['cashier']['cart_order_number'],
				// 标价金额，必填，标价金额，单位为分
				'total_fee' => $_SESSION['cashier']['cart_product_money'] * 100,
				// 授权码（条形码），可通过扫码枪获取
				'auth_code' => $s_auth_code
			];
			$a_result = $this->wxpay_pub->bar_code($a_param);
			// file_put_contents('./1.txt', print_r($a_param, true));
			if ($a_result['result_code'] == 'SUCCESS' && $a_result['return_code'] == 'SUCCESS') {
				$this->cart_model->order_complete($a_result['out_trade_no'], $a_result['total_fee'] / 100, 'offline', $a_result['transaction_id']);
			}
		}
	}
}
