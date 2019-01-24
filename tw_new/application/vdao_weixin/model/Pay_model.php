<?php
date_default_timezone_set('PRC');
class Pay_model extends TW_Model {
	public function __construct() {
        parent :: __construct();
    }

    //添加订单
	public function pay(){
		//接收下单购物车的ID
		$a_goods_id	= $this->general->post('goods_id');

		//接收下单商品是否使用积分
		$s_points	= $this->general->post('integral');
		// $s_points	= 0;

		//接收下单商品购买数量
		$a_num		= $this->general->post('num');

		//支付方式
		$s_paytype	= $this->general->post('paytype');
		// $s_paytype	= 3;

		//留言
		$a_message  = $this->general->post('remarks');

		//送达时间
		// $a_delay    = $this->general->post('delay');
		$a_delay    = '09:00-10:00';

		//判断支付类型
		if($s_paytype == 1){
			$s_payment_code = 'online';
		} else if ($s_paytype == 2){
			$s_payment_code = 'offline';
		} else if($s_paytype == 3){
			$s_payment_code = 'alipay';
		} else {
			$this->error->show_error('支付方式有误,请重新提交',$this->router->url('shop'));
		}
		//查询商品表信息
		$a_goods = $this->db->where_in('cart_id', $a_goods_id)->get('cart');

		//查询用户信息
		$a_where    = ['user_id' => $_SESSION['user_id']];
		$s_field    = 'user_id,user_name,user_score,user_email,user_balance';
		$a_member = $this->db->get_row('user', $a_where, $s_field);


		//查询收货人地址
		$a_address = $this->db->get_row('address',['user_id' => $_SESSION['user_id'],'is_default' => 1]);

		//判断用户是否有登录地址
		if($a_address == false){
			$this->error->show_error('请您设置您的收货地址！',$this->router->url('shop'));
		}
		//判断用户传过来的积分是不是用户已有的积分
		if( $a_member['user_score'] < $s_points){
			$this->error->show_error('用户使用积分不正确,请重新提交',$this->router->url('shop'));
		}

		$a_str = array();

		// 所有店铺的总价格
		$price_sum = 0;
		$num = 0;
		foreach($a_goods as $key => $value) {
			//将传过来的数量转成整型
			$a_num[$key] = intval($a_num[$key]);
			if(empty($a_num[$key])){
				$a_num[$key] = 0;
			}

			$price[$value['store_id']] = $price[$value['store_id']] + $a_num[$key] * $value['money'];
			$price_sum += $a_num[$key] * $value['money'];
			$num += $a_num[$key];
			$a_order_goods[$value['store_id']]['goods'][] = $value;
			$a_order_goods[$value['store_id']]['num'][] = $a_num[$key];
		}

		//店铺的总价格
		$a_price = $price;

		//店铺的运费
		$freight = $this->db->get('set');
		$a_freight = $freight[7]['set_parameter'];

		// //钱获取的总积分
		// $i_feng_sum = 0;

		//所有店铺的总价格
		$price_sum = $price_sum;

		if($s_paytype == 1) {
			if($a_member['user_balance'] < $price_sum) {
				$this->error->show_error('你们余额不足,请重新选择支付方式',$this->router->url('shop'));
			}
		}

		//循环拼装出每个店铺的数组
		foreach ($a_goods as $key => $value) {
			$a_res[$value['store_id']]['goods'] = $a_order_goods;
			$a_res[$value['store_id']]['store_id'] = $value['store_id'];
			$a_res[$value['store_id']]['store_name'] = $value['store_name'];
			$a_res[$value['store_id']]['goods_amount'] = $a_price[$value['store_id']];
		}

		//用户使用积分算的订单总价
		$price = $a_res[0]['goods_amount'] + $a_freight - $s_points / $freight[5]['set_parameter'];

		// 开启事务
		$this->db->begin();

		// 循环插入数据order表和order_common表
		foreach ($a_res as $key => $value) {
			//生成支付单号
			$pay_sn  = $_SERVER['REQUEST_TIME'] . rand(10000000,99999999);

			$pay_sn_sum[] = $pay_sn;

			//生成订单编号
			$new_order = $this->db->get_row('order', '','order_id', ['order_id' => desc]);
			$new_order_id = $new_order['order_id'] + 1;
			$order_sn = date('YmdH', $_SERVER['REQUEST_TIME']) . sprintf("%06d", $new_order['order_id'] + 1);

			// 拼装order表插入的数据
			$a_data = ['store_id' 		=> $value['store_id'],
					   'store_name' 	=> $value['store_name'],
					   'order_number' 	=> $order_sn,
					   'pay_sn' 		=> $pay_sn,
					   'user_id' 		=> $a_member['user_id'],
					   'user_name'   	=> $a_member['user_name'],
					   'time_create' 	=> $_SERVER['REQUEST_TIME'],
					   'payment_code' 	=> $s_payment_code,
					   'goods_amount' 	=> $value['goods_amount'],
					   'order_price' 	=> $price,
					   'shipping_fee' 	=> $a_freight,
					   'order_state' 	=> 40,
					   'order_count'	=> $num,
					   'use_points' 	=> $s_points,
					   'addres_post' 	=> $a_address['longitude'],
					   'order_message' 	=> $a_message,
					   'reciver_name'   => $a_address['user_name'],
					   'addres'         => $a_address['longitude'],
					   'mob_phone'      => $a_address['mob_phone'],
					   'tel_phone'      => $a_address['tel_phone'],
					   'time_delay'     => $a_delay,
					   ];

				//插入order表数据
				$b_order = $this->db->insert('order', $a_data);
				// 产品名称
				$s_gname = '';
				//插入order_goods表数据
				foreach ($a_res[$key]['goods'][$key]['goods'] as $k => $v) {
					$cup_id = $this->db->get_row('price', ['price_id' => $v['spec']]);
					//拼装插入order_goods表的数据
					$a_order_good = [	'order_id' 		=> $b_order,
										'product_id' 	=> $v['product_id'],
										'product_name'	=> $v['product_name'],
										'money' 	    => $v['money'],
										'goods_num' 	=> $a_res[$key]['goods'][$key]['num'][$k],
										'cup_id'        => $cup_id['cup_id'],
										'spec'          => $v['spec'].'/'.$v['swee'].'/'.$v['temp'],
										'pro_img' 	    => $v['pro_img'],
										'store_id' 		=> $a_res[$key]['store_id'],
										'user_id' 		=> $_SESSION['user_id'],
										];

					$s_gname .= $v['product_name'] . ',';

					//商品价格
					$a_order_good['goods_pay_price'] = $v['money'];

					$b_order_goods = $this->db->insert('order_goods', $a_order_good);

					//如果插入数据错误$b_order_goods_sum 存在
					if($b_order_goods == false){
						$b_order_goods_sum = 1;
					}
				}

				//插入订单历史表tw_order_log
				$b_order_log = $this->db->insert('order_log', ['order_id' => $b_order,'log_msg' => '用户提交订单','log_time' => $_SERVER['REQUEST_TIME'],'log_role' => '系统', 'log_user' => '系统', 'log_orderstate' => 40]);

			}

			//判断会员要输入的积分是否大于0分，如果大于0分扣除积分，否则不处理
		if($s_points > 0){
				$b_member = $this->db->set('user_score', 'user_score - ' . $s_points, false)
					 			 	 ->update('user', NULL, ['user_id' => $_SESSION['user_id']]);
		}else{
			$b_member = 1;
		}

		// 插入会员积分数据
		$a_ponit_data =  [	'pl_memberid' 	=> $_SESSION['user_id'],
							'pl_membername'	=> $a_member['user_name'],
							'pl_points'		=> '-' . $s_points,
							'pl_time_create'=> $_SERVER['REQUEST_TIME'],
							'pl_desc'		=> '订单'.$order_sn.'购物消费使用的积分',
							'pl_stage'		=> '用户进行下单'];

		// // 插入会员积分日志表
		$b_points_log = $this->db->insert('points_log', $a_ponit_data);

		// //判断会员支付得的积分是否大于0分，如果大于0分得到积分，否则不处理
		// if($i_feng_sum > 0){
		// 	$b_member = $this->db->set('user_score', 'user_score + ' . $i_feng_sum, false)
		// 		 			 	 ->update('user', NULL, ['user_id' => $_SESSION['user_id']]);
		// }else{
		// 	$b_member = 1;
		// }

		// // 插入会员积分数据
		// $a_ponit_data =  [	'pl_memberid' 	=> $_SESSION['user_id'],
		// 					'pl_membername'	=> $a_member['user_name'],
		// 					'pl_points'		=> $i_feng_sum,
		// 					'pl_time_create'=> $_SERVER['REQUEST_TIME'],
		// 					'pl_desc'		=> '订单'.$order_sn.'购物消费获得积分',
		// 					'pl_stage'		=> '用户进行下单'];

		// // 插入会员积分日志表
		// $a_points_log = $this->db->insert('points_log', $a_ponit_data);

		//订单生完完成后删除购物车商品
		$b_cart = $this->db->where_in('cart_id', $a_goods_id)->delete('cart',['user_id' => $_SESSION['user_id']]);
		$b_cart = 1;

		if($b_member != false && $b_cart != false && $b_order_log != false && ! isset($b_order_goods_sum)){
			$this->db->commit();
		} else {
			$b_roll_back = 'roll_back';
			// 事务回滚
			$this->db->roll_back();
		}

		if($b_roll_back == 'roll_back'){
			$this->error->show_error('订单有误请重新提交', $this->router->url('shop'));
		}
		// 1、余额支付2、货到付款3、支付宝支付
		return $this->payment($pay_sn_sum,$s_paytype);
	}

	public function payment($pay_sn,$s_paytype = 3){
		//判断支付单号不为空
		if(empty($pay_sn)){
			$this->error->show_error('订单有误,请重新提交', $this->router->url('shop'));
		}


		//判断用户必须先登录
		if(empty($_SESSION['user_id'])){
			$this->error->show_error('请您先登录', $this->router->url('shop'));
		}

		if(! is_array($pay_sn)){
			$this->error->show_error('支付单号格式有误,请重新提交', $this->router->url('shop'));
		}

		//余额支付
		if($s_paytype == 1){
			//余额支付
			$this->paid($pay_sn);
		} else if ($s_paytype == 2){
			//微信支付
			$this->wxpay($pay_sn);
		} else if ($s_paytype == 3){
			//支付宝
			$this->alipay($pay_sn);
		} else {
			$this->error->show_error('支付方式有误', $this->router->url('shop'));
		}

	}

	private function paid($pay_sn) {

		// 开启事务
		$this->db->begin();

		// 条件
		$a_data = $this->db->where_in('pay_sn', $pay_sn)->get('order',['user_id' => $_SESSION['user_id']],'order_id,order_price');
		foreach ($a_data as $key => $value) {
			$price_sum += $value['order_price'];
			$order_log_id[] = $value['order_id'];
		}

		$a_where    = ['user_id' => $_SESSION['user_id']];
		$s_field    = 'user_balance, user_name';
		$a_member = $this->db->get_row('user', $a_where, $s_field);
		if($a_member['user_balance'] < $price_sum){
				$this->error->show_error('你们余额不足,请重新选择支付方式');
			}

		//更新会员表
		$b_member = $this->db->set('user_balance', 'user_balance - ' . $price_sum, false)
							 ->update('user', NULL,['user_id' => $_SESSION['user_id']]);


		//更新订单表
		$b_order = $this->db->where_in('pay_sn', $pay_sn)->update('order', ['order_state' => '20', 'order_time' => $_SERVER['REQUEST_TIME'],'payment_code' => 'online'], ['user_id' => $_SESSION['user_id']]);

		//更新订单历史表tw_order_log
		$b_order_log = $this->db->where_in('order_id', $order_log_id)->update('order_log',['log_msg' => '已收到货款(余额支付)', 'log_time' => $_SERVER['REQUEST_TIME'],'log_role' => '系统', 'log_user' => '系统','log_orderstate' => 20]);

		//判断上面表是否插入成功如果有失败进行回滚
		if($b_member != false && $b_order != false && $b_order_log != false){
			$s_commit = 'commit';
			// 提交事务
			$this->db->commit();
		} else {
			$s_roll_back = 'roll_back';
			// 事务回滚
			$this->db->roll_back();
		}

		//根据状态给用户相应的提示
		if($s_commit == 'commit'){
			$this->error->show_success('您选择的是余额,支付成功',$this->router->url('index'), '', 1);
		}

		if($s_roll_back == 'roll_back'){
			$this->error->show_error('订单已提交,支付有误,请到订单中重新支付',$this->router->url('index'), '', 1);
		}
	}

	private function wxpay($pay_sn) {
        // 条件
		$a_data = $this->db->where_in('pay_sn', $pay_sn)->get('order', '', 'order_price,order_number');
		foreach ($a_data as $key => $value) {
			$price_sum += $value['order_price'];
			$order_sn   = $value['order_number'];
		}

		//将支付单号进行字符串分割
		$s_pay_sn = implode(',', $pay_sn);
        $a_data = [
			// 商品描述, 必填
			'body' => '7度购订单编号' . $order_sn,
			// 商户订单号, 必填
			'out_trade_no' => $s_pay_sn,
			// 标价金额,以分为单位, 必填
			'total_fee' => '1',
			// 终端IP, 必填
			'spbill_create_ip' => $this->general->get_ip(),
		];
		$this->load->library('wxpay_h5', '', $a_data);
		$a_result = $this->wxpay_h5->pay();

		// 这里是支付链接
		echo '<a href="' . $a_result['mweb_url'] . '">支付</a>';
	}

	public function alipay($pay_sn) {
		// 条件
		$a_data = $this->db->where_in('pay_sn', $pay_sn)->get('order', '', 'order_price,order_number');
		foreach ($a_data as $key => $value) {
			$price_sum += $value['order_price'];
			$order_sn   = $value['order_number'];
		}

		//将支付单号进行字符串分割
		$s_pay_sn = implode(',', $pay_sn);

/************************************  框架支付宝支付  ************************************/

		$this->load->library('alipay_wap');
		$a_data = [
			// 商户订单号，商户网站订单系统中唯一订单号，必填
			'out_trade_no' => $s_pay_sn,// '201781113588902',
			// 订单名称，必填
			'subject' => '7度购订单编号' . $order_sn,
			// 付款金额，必填
			'total_amount' => $price_sum,
			// 'total_amount' => 0.01,
			// 商品描述，可空
			'body' => '',
			/** 该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，
				1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。
				该参数数值不接受小数点， 如 1.5h，可转换为 90m。
			*/
			'timeout_express' => '24h'
		];

		echo $this->alipay_wap->pay($a_data);
	}


/*******************************************************************************************/



}


?>

