<?php
class Pay_model extends TW_Model {
	public function __construct() {
        parent :: __construct();
        // $this->userid= $_SESSION['user_id'];
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = 123;
    }


	public function pay() {
		//查询收货人地址
		$a_address = $this->db->get_row('address',['member_id' => $_SESSION['user_id'], 'is_default' => 1]);
		//判断用户是否有登录地址
		if($a_address == false){
			// $this->error->show_error('请您设置您的收货地址！',$this->router->url('shop'));
			//获取上传后文件名子
			$address = array(
            	"code" => 22,
            	"msg" => 请您设置您的收货地址！
			);
			return $address;
			die;
		}

		//生成支付单号
		$pay_sn  = $_SERVER['REQUEST_TIME'] . rand(10000000,99999999);

		$pay_sn_sum[] = $pay_sn;

		//生成订单编号
		$new_order = $this->db->get_row('demand', '','demand_id', ['demand_id' => desc]);
		$new_order_id = $new_order['demand_id'] + 1;
		$order_sn = date('YmdH', $_SERVER['REQUEST_TIME']) . sprintf("%06d", $new_order['demand_id'] + 1);

		$a_title = $this->general->post('title');
		$a_demand = $this->general->post('demand_details');
		$a_images = $_FILES['images'];
		$a_voice = $_FILES['voice'];
		$o_video = $_FILES['video'];
		$o_position = $this->general->post('position');
		$i_option = $this->general->post('option');
		if ( ! empty($a_images[name][0])) {
			$a_url = "./images";
			$a_data = array("gif", "png", "jpg", "jpeg");
			$a_images = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "images");
			$a_imag = implode(",", $a_images['msg']);
			// print_r($a_imag);
			// echo json_encode($a_images);
			// die;
		}

		if ( ! empty($a_voice[name][0])) {
			$a_url = "./images";
			$a_data = array("mp3");
			$a_voice = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "voice");
			// print_r($a_voice['msg']);
			// echo json_encode($a_voice);
		}
		if ( ! empty($o_video[name][0])) {
			$a_url = "./images";
			$a_data = array("mp4");
			$a_im = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "video");
			// print_r($a_im['msg']);
			// echo json_encode($a_im);
		}
		// 开启事务
		$this->db->begin();

		$a_data = [
			'publisher_id' => $_SESSION['user_id'],
			'publisher_name' => $_SESSION['username'],
			'order_sn' => $order_sn,
			'pay_sn' => $pay_sn,
			'title' => $a_title,
			'state' => $a_demand,
			'contacts_name' => $a_address['user_name'],
			'mobile_phone' => $a_address['mobile_phone'],
			'area_info' => $a_address['area_info'],
			'publisher_id' => $_SESSION['user_id'],
			'images_path' => $a_imag,
			'video_path' => $a_im['msg'],
			'voice' => $a_voice['msg'],
			'state' => 12,
			'option' => $option,
			'release_time' => $_SERVER['REQUEST_TIME']
		];
		$demand = $this->db->insert('demand', $a_data);
		//插入订单历史表
		$b_order_log = $this->db->insert('message_logging', ['demand_id' => $demand, 'classify_msg' => '用户提交订单', 'write_time' => $_SERVER['REQUEST_TIME'], 'classify' => '系统', 'classify_user' => '系统', 'service_state' => 12]);
		// return $demand;
		// 1、微信支付2、竞价订单3、支付宝支付
		// return $this->payment($pay_sn_sum,$s_paytype);
		return $this->payment($pay_sn_sum, 3);
	}

	public function payment($pay_sn,$s_paytype = 3) {

		//判断支付单号不为空
		if(empty($pay_sn)){
			$a_error = [
				'code' => 121,
				'msg' => 订单有误,请重新提交

			];
			return $a_error;
			die;
		}


		//判断用户必须先登录
		if(empty($_SESSION['user_id'])){
			$a_error = [
				'code' => 121,
				'msg' => 请您先登录
			];
			return $a_error;
			die;
		}

		if(! is_array($pay_sn)){
			$a_error = [
				'code' => 121,
				'msg' => 支付单号格式有误,请重新提交
			];
			return $a_error;
			die;
		}

		//余额支付
		if($s_paytype == 1){
			$this->paid($pay_sn);
		} else if ($s_paytype == 2){
			$this->account($pay_sn);
		} else if ($s_paytype == 3){
			$this->alipay($pay_sn);
		} else {
			// $this->error->show_error('支付方式有误', $this->router->url('shop'));
			$a_error = [
				'code' => 121,
				'msg' => 支付方式有误
			];
			return $a_error;
			die;
		}
	}
	//微信支付
	private function paid($pay_sn) {

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

		// `
	}
	//需求的竞标
	private function account($pay_sn) {

		// 开启事务
		// $this->db->begin();
		// 条件
		$a_data = $this->db->where_in('pay_sn', $pay_sn)->get('demand',['publisher_id' => $_SESSION['user_id']],'demand_id');
		foreach ($a_data as $key => $value) {
			$order_log_id[] = $value['demand_id'];
		}

		//更新订单表
		$b_order = $this->db->where_in('pay_sn', $pay_sn)->update('demand', ['state' => '11', 'bidding_time' => $_SERVER['REQUEST_TIME'], 'payment_code' => 'offline'], ['publisher_id' => $_SESSION['user_id']]);

		//添加订单历史表
		$b_order_log = $this->db->where_in('demand_id', $order_log_id)->update('message_logging', ['classify_msg' => '用户等待竞标', 'write_time' => $_SERVER['REQUEST_TIME'], 'classify' => '需求', 'classify_user' => $_SESSION['username'], 'service_state' => 11]);

		// if($b_order != false  && $b_order_log != false ){
		// 	$s_commit = 'commit';
		// 	// 提交事务
		// 	$this->db->commit();
		// } else {
		// 	$s_roll_back = 'roll_back';
		// 	// 事务回滚
		// 	$this->db->roll_back();
		// }
	}

	//支付宝
	private function alipay($pay_sn) {
		//直接提交支付宝支付
		require_once(PROJECTPATH . "/libraries/alipay/alipay.config.php");
		require_once(PROJECTPATH . "/libraries/alipay/lib/alipay_submit.class.php");
		// 条件
		$a_data = $this->db->where_in('pay_sn', $pay_sn)->get('demand',['publisher_id' => $_SESSION['user_id']],'price,order_sn');

		foreach ($a_data as $key => $value) {
			$price_sum += $value['order_amount'];
			$order_sn = $value['order_sn'];
		}
		//将支付单号进行字符串分割
		$s_pay_sn = implode(',', $pay_sn);

		/**************************请求参数**************************/
		        //商户订单号，商户网站订单系统中唯一订单号，必填
		        //$out_trade_no = $_POST['WIDout_trade_no'];
		        $out_trade_no = $s_pay_sn;

		        //订单名称，必填
		        // 如果存在多个订单将最后一个订单编号展示给用户看
		        //$subject = '7度购订单名称-'. $_POST['WIDsubject'];
		        $subject = '7度购订单编号' . $order_sn;

		        //付款金额，必填
		        //$total_fee = '$_POST['WIDtotal_fee']';
		        $total_fee = $price_sum;

		        //商品描述，可空
		        //$body = $_POST['WIDbody'];
		        $body = '';

		/************************************************************/

		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service"       => $alipay_config['service'],
				"partner"       => $alipay_config['partner'],
				"seller_id"  => $alipay_config['seller_id'],
				"payment_type"	=> $alipay_config['payment_type'],
				"notify_url"	=> $alipay_config['notify_url'],
				"return_url"	=> $alipay_config['return_url'],

				"anti_phishing_key"=>$alipay_config['anti_phishing_key'],
				"exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
				"out_trade_no"	=> $out_trade_no,
				"subject"		=> $subject,
				"total_fee"	=> $total_fee,
				"body"	=> $body,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
				//其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
		        //如"参数名"=>"参数值"

		);

			//建立请求
			$alipaySubmit = new AlipaySubmit($alipay_config);
			$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
			echo $html_text;
			$this->error->show_success('请您到支付宝进行支付',$this->router->url('index'));
	}

	/**
	**  立即支付
	* @param $order_sn [订单编号]
	*/
	public function immediate($order_sn) {
		require_once(PROJECTPATH."/libraries/alipay/alipay.config.php");
        require_once(PROJECTPATH."/libraries/alipay/lib/alipay_submit.class.php");

        $_POST['WIDout_trade_no'] = $order_sn;
        if($_POST['WIDout_trade_no'] != ""){
         /**************************请求参数**************************/
         	$a_goods = $this->db->get('demand',['order_sn' => $_POST['WIDout_trade_no']], ['price', 'title']);
         	if ( ! empty($a_goods)) {

		        //商户订单号，商户网站订单系统中唯一订单号，必填

		        $out_trade_no = $_POST['WIDout_trade_no'];

		       //订单名称，必填
		   		$subject = $a_goods[0]['title'];

		        //付款金额，必填
		        $total_fee = $a_goods[0]['price'];

		        //商品描述，可空
		        $body = $_POST['WIDbody'];



				/************************************************************/

				//构造要请求的参数数组，无需改动
				$parameter = array(
						"service"       => $alipay_config['service'],
						"partner"       => $alipay_config['partner'],
						"seller_id"  => $alipay_config['seller_id'],
						"payment_type"	=> $alipay_config['payment_type'],
						"notify_url"	=> $alipay_config['notify_url'],
						"return_url"	=> $alipay_config['return_url'],

						"anti_phishing_key"=>$alipay_config['anti_phishing_key'],
						"exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
						"out_trade_no"	=> $out_trade_no,
						"subject"	=> $subject,
						"total_fee"	=> $total_fee,
						"body"	=> $body,
						"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
						//其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
				        //如"参数名"=>"参数值"

				);


				//建立请求
				$alipaySubmit = new AlipaySubmit($alipay_config);
				$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		       echo $html_text;
       		} else {
       		   $order_sn = array(
	            	"code" => 234,
	            	"msg" => 网络错误，稍后重试！
				);
				return $order_sn;
				die;
       		}
       	} else {
       		$order_sn = array(
            	"code" => 233,
            	"msg" => 订单有误！
			);
			return $order_sn;
			die;
		}
	}
}
?>

