<?php

class Pay_model extends TW_Model {
	public function __construct() {
        parent :: __construct();
    }


	public function pay(){

		//接收下单商品的ID
		$a_goods_id	= $this->general->post('goods_id');

		//接收下单商品是否使用积分
		$s_points	= $this->general->post('integral');

		//接收下单商品购买数量
		$a_num		= $this->general->post('num');

		//支付方式
		$s_paytype	= $this->general->post('paytype');

		//留言
		$a_message  = $this->general->post('remarks');

		// $a_goods_id = [1,2,3];
		// $s_points = 200;
		// $_SESSION['user_id'] = 8;
		// $a_num = [2,3,4];
		// $s_paytype = 3;
		// $a_message = ['123','123'];

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
		$s_field = 'goods_id,goods_name,goods_image,store_id,gc_id_3,store_name,deductible_point,goods_price,goods_freight,goods_promotion_type,goods_promotion_price,goods_feng,have_gift';
		$a_goods = $this->db->where_in('goods_id', $a_goods_id)->get('goods', '', $s_field);

		//查询用户信息
		$a_where    = ['member_id' => $_SESSION['user_id']];
		$s_field    = 'member_id,member_name,member_points,member_email,available_predeposit';
		$a_member = $this->db->get_row('member', $a_where, $s_field);


		//查询收货人地址
		$s_field    = 'address_id,member_id,true_name,area_id,city_id,area_info,address,tel_phone,mob_phone,dlyp_id';
		$a_address = $this->db->get_row('address',['member_id' => $_SESSION['user_id'],'is_default' => 1]);

		$a_serialize['phone'] 			= $a_address['mob_phone'];
		$a_serialize['mob_phone'] 		= $a_address['mob_phone'];
		$a_serialize['tel_phone'] 		= $a_address['tel_phone'];
		$a_serialize['address'] 		= $a_address['area_info'] . $a_address['address'];
		$a_serialize['area'] 			= $a_address['area_info'];
		$a_serialize['street'] 			= $a_address['address'];

		$serialize = serialize($a_serialize);

		//判断用户是否有登录地址
		if($a_address == false){
			$this->error->show_error('请您设置您的收货地址！',$this->router->url('shop'));
		}

		//判断用户传过来的积分是不是用户已有的积分
		if( $a_member['member_points'] < $s_points){
			$this->error->show_error('用户使用积分不正确,请重新提交',$this->router->url('shop'));
		}

		$a_str = array();

		//所有商品加起来的总积分
		$i_goods_feng_sum = 0;

		// 所有店铺的总价格
		$price_sum = 0;
		foreach($a_goods as $key => $value){
			$freight[$value['store_id']] = $value['goods_freight'];
			$goods_feng[$value['store_id']] += $value['goods_feng'];
			//将传过来的数量转成整型
			$a_num[$key] = intval($a_num[$key]);
			if(empty($a_num[$key])){
				$a_num[$key] = 0;
			}
			$points[$value['store_id']] += $value['deductible_point'];
			$points_sum += $value['deductible_point'];
			if($value['goods_promotion_type'] == 0 ){
				$price[$value['store_id']] = $price[$value['store_id']] + $a_num[$key] * $value['goods_price'];
				$price_sum += $a_num[$key] * $value['goods_price'];
			} else {
				$price[$value['store_id']] = $price[$value['store_id']] + $a_num[$key] * $value['goods_promotion_price'];
				$price_sum += $a_num[$key] * $value['goods_price'];
			}
			$i_goods_feng_sum += $value['goods_feng'];
			$a_order_goods[$value['store_id']]['goods'][] = $value;
			$a_order_goods[$value['store_id']]['num'][] = $a_num[$key];
		}

		//每个店铺可以使用的积分
		$a_points = $points;

		//每个店铺的总价格
		$a_price = $price;

		//每个店铺的运费
		$a_freight = $freight;

		//每个店铺赠送的积分
		$a_goods_feng = $goods_feng;

		//所有商品加起来的获取的总积分
		$i_goods_feng_sum = $i_goods_feng_sum;

		//所有店铺的总价格
		$price_sum = $price_sum;

		//所有店铺可以使用的总积分
		$points_sum = $points_sum;

		foreach ($a_points as $key => $value) {
			if ($s_points >= $value){
				$deductible_point[$key] = $value;
				$s_points = $s_points - $value;
			} else {
				$deductible_point[$key] = $s_points;
				$s_points = 0;
			}
		}

		if($s_paytype == 1){
			if($a_member['available_predeposit'] < $price_sum){
				$this->error->show_error('你们余额不足,请重新选择支付方式',$this->router->url('shop'));
			}
		}

		//循环拼装出每个店铺的数组
		foreach ($a_goods as $key => $value) {
			$a_res[$value['store_id']]['goods'] = $a_order_goods;
			$a_res[$value['store_id']]['store_id'] = $value['store_id'];
			$a_res[$value['store_id']]['store_name'] = $value['store_name'];
			$a_res[$value['store_id']]['goods_amount'] = $a_price[$value['store_id']];
			$a_res[$value['store_id']]['order_amount'] = $a_price[$value['store_id']] + $a_freight[$value['store_id']] - $deductible_point[$value['store_id']] * 0.01;
			$a_res[$value['store_id']]['shipping_fee'] = $a_freight[$value['store_id']];
			$a_res[$value['store_id']]['goods_feng'] = $a_goods_feng[$value['store_id']];
			$a_res[$value['store_id']]['order_message'] = $a_message[$value['store_id']];
			$a_res[$value['store_id']]['deductible_point'] = $deductible_point[$value['store_id']];
		}


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
				   'order_sn' 		=> $order_sn,
				   'pay_sn' 		=> $pay_sn,
				   'buyer_id' 		=> $a_member['member_id'],
				   'buyer_name' 	=> $a_member['member_name'],
				   'time_create' 	=> $_SERVER['REQUEST_TIME'],
				   'payment_code' 	=> $s_payment_code,
				   'goods_amount' 	=> $value['goods_amount'],
				   'order_amount' 	=> $value['order_amount'],
				   'shipping_fee' 	=> $value['shipping_fee'],
				   'order_state' 	=> 10,
				   'goods_feng' 	=> $value['goods_feng'],
				   'use_points' 	=> $value['deductible_point'],
				   ];

			// 全部订单用户使用的所有积分
			$integral += $value['deductible_point'];

			//插入order表数据
			$b_order = $this->db->insert('order', $a_data);


			//插入order_goods表数据
			foreach ($a_res[$key]['goods'][$key]['goods'] as $k => $v) {
				//拼装插入order_goods表的数据
				$a_order_good = [	'order_id' 		=> $b_order,
									'goods_id' 		=> $v['goods_id'],
									'goods_name'	=> $v['goods_name'],
									'goods_price' 	=> $v['goods_price'],
									'goods_num' 	=> $a_res[$key]['goods'][$key]['num'][$k],
									'goods_image' 	=> $v['goods_image'],
									'store_id' 		=> $v['store_id'],
									'buyer_id' 		=> $_SESSION['user_id'],
									'gc_id' 		=> $v['gc_id_3'],
									];

				// 判断是否有赠品
				if($v['have_gift'] != 0){
					$a_order_good['goods_type'] = 5;
				} else {
					$a_order_good['goods_type'] = 1;
				}
				//判断商品是否有促销价格
				if($v['goods_promotion_type'] != 0){
					$a_order_good['goods_pay_price'] = $v['goods_promotion_price'];
				} else {
					$a_order_good['goods_pay_price'] = $v['goods_price'];
				}

				$b_order_goods = $this->db->insert('order_goods', $a_order_good);

				//如果插入数据错误$b_order_goods_sum 存在
				if($b_order_goods == false){
					$b_order_goods_sum = 1;
				}
			}

			//拼装插入order_common表的数据
			$a_data_common = ['order_id' 			=> $b_order,
							  'store_id' 			=> $value['store_id'],
							  'order_pointscount' 	=> $value['goods_feng'],
							  'reciver_name' 		=> $a_address['true_name'],
							  'reciver_info' 		=> $a_address['area_info'],
							  'time_evalseller' 	=> 0,
							  'order_message' 		=> $value['order_message'],
							  'reciver_info' 		=> $serialize,
							];

			//判断收货人的收货人省为null,我们给默认值为0
			if(empty($a_address['area_id'])){
				  $a_data_common['reciver_province_id'] = 0;
			}else{
				  $a_data_common['reciver_province_id'] =  $a_address['area_id'];
			}

			//判断收货人的收货人市为null,我们给默认值为0
			if(empty($a_address['city_id'])){
				$a_data_common['reciver_city_id'] = 0;
			} else {
				$a_data_common['reciver_city_id'] = $a_address['city_id'];
			}

			//插入order_common表的数据
			$b_order_common = $this->db->insert('order_common', $a_data_common);

			//插入支付订单表tw_order_pay
			$b_order_pay = $this->db->insert('order_pay', ['pay_sn' => $pay_sn, 'buyer_id' => $_SESSION['user_id']]);

			//插入订单历史表tw_order_log
			$b_order_log = $this->db->insert('order_log', ['order_id' => $b_order,'log_msg' => '用户提交订单','log_time' => $_SERVER['REQUEST_TIME'],'log_role' => '系统', 'log_user' => '系统', 'log_orderstate' => 10]);

		}

		//判断会员要输入的积分是否大于0分，如果大于0分扣除积分，否则不处理
		if($integral > 0){
			$b_member = $this->db->set('member_points', 'member_points - ' . $integral, false)
				 			 	 ->update('member', NULL, ['member_id' => $_SESSION['user_id']]);
		}else{
			$b_member = 1;
		}

		// 插入会员积分数据
		$a_ponit_data =  [	'pl_memberid' 	=> $_SESSION['user_id'],
							'pl_membername'	=> $a_member['member_name'],
							'pl_points'		=> '-' . $integral,
							'pl_time_create'=> $_SERVER['REQUEST_TIME'],
							'pl_desc'		=> '下单时,用户所花费的积分',
							'pl_stage'		=> '用户进行下单'];

		// 插入会员积分日志表
		$b_points_log = $this->db->insert('points_log', $a_ponit_data);

		//订单生完完成后删除购物车商品
		$b_cart = $this->db->where_in('goods_id', $a_goods_id)->delete('cart',['buyer_id' => $_SESSION['user_id']]);

		if($b_points_log != false && $b_member != false && $b_cart != false &&  $b_order != false && $b_order_common != false && $b_order_pay && $b_order_log != false && ! isset($b_order_goods_sum)){
			$this->db->commit();
		} else {
			$b_roll_back = 'roll_back';
			// 事务回滚
			$this->db->roll_back();
		}

		if($b_order_common == false){
			$this->error->show_error('地址有误', $this->router->url('shop'));
		}

		if($b_roll_back == 'roll_back'){
			$this->error->show_error('订单有误请重新提交', $this->router->url('shop'));
		}


		// 1、余额支付2、货到付款3、支付宝支付
		$this->payment($pay_sn_sum,$s_paytype);

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
			$this->paid($pay_sn);
		} else if ($s_paytype == 2){
			$this->account($pay_sn);
		} else if ($s_paytype == 3){
			$this->alipay($pay_sn);
		} else {
			$this->error->show_error('支付方式有误', $this->router->url('shop'));
		}

	}

	private function paid($pay_sn){

		// 开启事务
		$this->db->begin();

		// 条件
		$a_data = $this->db->where_in('pay_sn', $pay_sn)->get('order',['buyer_id' => $_SESSION['user_id']],'order_id,order_amount');
		foreach ($a_data as $key => $value) {
			$price_sum += $value['order_amount'];
			$order_log_id[] = $value['order_id'];
		}

		$a_where    = ['member_id' => $_SESSION['user_id']];
		$s_field    = 'available_predeposit, member_name';
		$a_member = $this->db->get_row('member', $a_where, $s_field);
		if($a_member['available_predeposit'] < $price_sum){
				$this->error->show_error('你们余额不足,请重新选择支付方式',get_config_item('user_domain') . 'order_form.html');
			}

		//更新会员表
		$b_member = $this->db->set('available_predeposit', 'available_predeposit - ' . $price_sum, false)
							 ->set('freeze_predeposit','freeze_predeposit +' . $price_sum, false )
							 ->update('member', NULL,['member_id' => $_SESSION['user_id']]);


		//更新订单表
		$b_order = $this->db->where_in('pay_sn', $pay_sn)->update('order', ['order_state' => '20', 'time_payment' => $_SERVER['REQUEST_TIME'],'payment_code' => 'online'], ['buyer_id' => $_SESSION['user_id']]);

		//更新订单支付表
		$b_order_pay = $this->db->where_in('pay_sn', $pay_sn)->update('order_pay', ['api_pay_state' => '1']);

		//更新订单历史表tw_order_log
		$b_order_log = $this->db->where_in('order_id', $order_log_id)->update('order_log',['log_msg' => '已收到货款(余额支付)', 'log_time' => $_SERVER['REQUEST_TIME'],'log_role' => '系统', 'log_user' => '系统','log_orderstate' => 20]);

		//判断上面表是否插入成功如果有失败进行回滚
		if($b_member != false && $b_order != false && $b_order_pay != false && $b_order_log != false){
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
			//成功，发送短信提示给客服人员
			$this->load->library('short_message');
			$this->short_message->send('18998301449', $a_member['member_name'].'下单了快去查询吧！', 'authcode');

			$this->error->show_success('您选择的是余额,支付成功',$this->router->url('index'));
		}
		if($s_roll_back == 'roll_back'){
			$this->error->show_error('订单已提交,支付有误,请到订单中重新支付',$this->router->url('index'));
		}
	}

	private function account($pay_sn){

		// 开启事务
		$this->db->begin();

		// 条件
		$a_data = $this->db->where_in('pay_sn', $pay_sn)->get('order',['buyer_id' => $_SESSION['user_id']],'order_id,buyer_name');
		foreach ($a_data as $key => $value) {
			$order_log_id[] = $value['order_id'];
		}

		//更新订单表
		$b_order = $this->db->where_in('pay_sn', $pay_sn)->update('order', ['order_state' => '20', 'time_payment' => $_SERVER['REQUEST_TIME'], 'payment_code' => 'offline'], ['buyer_id' => $_SESSION['user_id']]);

		//更新订单历史表tw_order_log
		$b_order_log = $this->db->where_in('order_id', $order_log_id)->update('order_log',['log_msg' => '货到付款', 'log_time' => $_SERVER['REQUEST_TIME'],'log_role' => '系统', 'log_user' => '系统','log_orderstate' => 20]);

		if($b_order != false  && $b_order_log != false ){
			$s_commit = 'commit';
			// 提交事务
			$this->db->commit();
		} else {
			$s_roll_back = 'roll_back';
			// 事务回滚
			$this->db->roll_back();
		}

		if($s_commit == 'commit'){
			//成功，发送短信提示给客服人员
			$this->load->library('short_message');
			$this->short_message->send('18998301449', $a_data[0]['buyer_name'].'下单了快去查询吧！', 'authcode');

			$this->error->show_success('您选择的是货到付款,订单已提交',$this->router->url('index'));
		}
		if($s_roll_back == 'roll_back'){
			$this->error->show_error('订单已提交,支付有误,请到订单中重新支付',$this->router->url('index'));
		}

	}

	private function alipay($pay_sn){

/************************************** 旧代码 **********************************************/

		//直接提交支付宝支付
		// require_once(PROJECTPATH . "/libraries/alipay/alipay.config.php");
		// require_once(PROJECTPATH . "/libraries/alipay/lib/alipay_submit.class.php");

/************************************** 旧代码 **********************************************/

		// 条件
		$a_data = $this->db->where_in('pay_sn', $pay_sn)->get('order',['buyer_id' => $_SESSION['user_id']],'order_amount,order_sn');
		foreach ($a_data as $key => $value) {
			$price_sum += $value['order_amount'];
			$order_sn = $value['order_sn'];
		}

		//将支付单号进行字符串分割
		$s_pay_sn = implode(',', $pay_sn);

/************************************* 框架支付宝支付 *******************************************/

		$this->load->library('alipay_pc');
		$a_data = [
			// 商户订单号，商户网站订单系统中唯一订单号，必填
			'out_trade_no' => $s_pay_sn,// '201781113588902',
			// 订单名称，必填
			'subject' => '7度购订单编号' . $order_sn,
			// 付款金额，必填
			'total_amount' => $price_sum,
			// 商品描述，可空
			'body' => '',
			/** 该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，
				1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。 
				该参数数值不接受小数点， 如 1.5h，可转换为 90m。
			*/
			'timeout_express' => '24h'
		];

		echo $a = $this->alipay_pc->pay($a_data);

/************************************* 框架支付宝支付 *******************************************/

/************************************** 旧代码 **********************************************/

		/**************************请求参数**************************/
		//         //商户订单号，商户网站订单系统中唯一订单号，必填
		//         //$out_trade_no = $_POST['WIDout_trade_no'];
		//         $out_trade_no = $s_pay_sn;

		//         //订单名称，必填
		//         // 如果存在多个订单将最后一个订单编号展示给用户看
		//         //$subject = '7度购订单名称-'. $_POST['WIDsubject'];
		//         $subject = '7度购订单编号' . $order_sn;

		//         //付款金额，必填
		//         //$total_fee = '$_POST['WIDtotal_fee']';
		//         $total_fee = $price_sum;

		//         //商品描述，可空
		//         //$body = $_POST['WIDbody'];
		//         $body = '';

		// /************************************************************/

		// //构造要请求的参数数组，无需改动
		// $parameter = array(
		// 		"service"       => $alipay_config['service'],
		// 		"partner"       => $alipay_config['partner'],
		// 		"seller_id"  => $alipay_config['seller_id'],
		// 		"payment_type"	=> $alipay_config['payment_type'],
		// 		"notify_url"	=> $alipay_config['notify_url'],
		// 		"return_url"	=> $alipay_config['return_url'],

		// 		"anti_phishing_key"=>$alipay_config['anti_phishing_key'],
		// 		"exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
		// 		"out_trade_no"	=> $out_trade_no,
		// 		"subject"		=> $subject,
		// 		"total_fee"	=> $total_fee,
		// 		"body"	=> $body,
		// 		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		// 		//其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
		//         //如"参数名"=>"参数值"

		// );

		// 	//建立请求
		// 	$alipaySubmit = new AlipaySubmit($alipay_config);
		// 	$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		// 	echo $html_text;
		// 	$this->error->show_success('请您到支付宝进行支付',$this->router->url('index'));

/************************************** 旧代码 **********************************************/

	}



	//财务通支付
	private function tenpay($price, $content, $out_trade_no){
		//---------------------------------------------------------
		//财付通即时到帐支付请求示例，商户按照此文档进行开发即可
		//---------------------------------------------------------

		require_once (PROJECTPATH . "/libraries/tenpay/classes/RequestHandler.class.php");
		require_once (PROJECTPATH . "/libraries/tenpay/tenpay_config.php");


		//4位随机数
		$randNum = rand(1000, 9999);

		//订单号，此处用时间加随机数生成，商户根据自己情况调整，只要保持全局唯一就行
		$out_trade_no = date("YmdHis") . $randNum;



		/* 创建支付请求对象 */
		$reqHandler = new RequestHandler();
		$reqHandler->init();
		$reqHandler->setKey($key);
		$reqHandler->setGateUrl("https://gw.tenpay.com/gateway/pay.htm");

		//----------------------------------------
		//设置支付参数
		//----------------------------------------
		$reqHandler->setParameter("partner", $partner);
		$reqHandler->setParameter("out_trade_no", $out_trade_no);
		$reqHandler->setParameter("total_fee", "$price");  //总金额
		$reqHandler->setParameter("return_url",  $return_url);
		$reqHandler->setParameter("notify_url", $notify_url);
		$reqHandler->setParameter("body", "$content");
		$reqHandler->setParameter("bank_type", "DEFAULT");  	  //银行类型，默认为财付通
		//用户ip
		$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);//客户端IP
		$reqHandler->setParameter("fee_type", "1");               //币种
		$reqHandler->setParameter("subject","商品名称");          //商品名称，（中介交易时必填）

		//系统可选参数
		$reqHandler->setParameter("sign_type", "MD5");  	 	  //签名方式，默认为MD5，可选RSA
		$reqHandler->setParameter("service_version", "1.0"); 	  //接口版本号
		$reqHandler->setParameter("input_charset", "GBK");   	  //字符集
		$reqHandler->setParameter("sign_key_index", "1");    	  //密钥序号

		//业务可选参数
		$reqHandler->setParameter("attach", "");             	  //附件数据，原样返回就可以了
		$reqHandler->setParameter("product_fee", "");        	  //商品费用
		$reqHandler->setParameter("transport_fee", "0");      	  //物流费用
		$reqHandler->setParameter("time_start", date("YmdHis"));  //订单生成时间
		$reqHandler->setParameter("time_expire", "");             //订单失效时间
		$reqHandler->setParameter("buyer_id", "");                //买方财付通帐号
		$reqHandler->setParameter("goods_tag", "");               //商品标记
		$reqHandler->setParameter("trade_mode","1");              //交易模式（1.即时到帐模式，2.中介担保模式，3.后台选择（卖家进入支付中心列表选择））
		$reqHandler->setParameter("transport_desc","");              //物流说明
		$reqHandler->setParameter("trans_type","1");              //交易类型
		$reqHandler->setParameter("agentid","");                  //平台ID
		$reqHandler->setParameter("agent_type","");               //代理模式（0.无代理，1.表示卡易售模式，2.表示网店模式）
		$reqHandler->setParameter("seller_id","");                //卖家的商户号



		//请求的URL
		$reqUrl = $reqHandler->getRequestURL();
		header('Location:' . $reqUrl);
	}


}


?>

