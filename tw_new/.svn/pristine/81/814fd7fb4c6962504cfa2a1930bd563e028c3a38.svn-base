<?php
defined('BASEPATH') OR exit('禁止访问！');
class Pay_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
		$this->prefix = $this->db->get_prefix();
		$this->load->model('pay_model');
	}

	public function pay() {
		$this->load->library('alipay_wap');
		$a_data = [
			// 商户订单号，商户网站订单系统中唯一订单号，必填
			// 'out_trade_no' => $s_pay_sn,// '201781113588902',
			'out_trade_no' => '201781113588916',
			// 订单名称，必填
			// 'subject' => '7度购订单编号' . $order_sn,
			'subject' => '7度购订单编号' . '154486749878',
			// 付款金额，必填
			// 'total_amount' => $price_sum,
			'total_amount' => 0.01,
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

/************************************  框架支付宝支付  ************************************/

	// 同步通知
	public function ret() {
		$this->load->library('alipay_wap');
		// 验证成功，开始对订单进行相应的处理，并显示友好提示页面，示例只是显示下结果而已
		if ($this->alipay_wap->verify($this->general->get())) {
			$shop = $this->general->get();

			//更新订单表
			$b_order = $this->db->update('order', ['order_state' => '20', 'order_time' => $_SERVER['REQUEST_TIME'],'payment_code' => 'alipay'], ['pay_sn' => $shop['out_trade_no']]);

			$a_data = $this->db->get('order',['user_id' => $_SESSION['user_id'], 'pay_sn' => $shop['out_trade_no']],'order_id,user_name');

			//更新订单历史表tw_order_log
			$b_order_log = $this->db->update('order_log',['log_msg' => '已收到货款(支付宝支付)'. $shop['trade_no'], 'log_time' => $_SERVER['REQUEST_TIME'],'log_role' => '系统', 'log_user' => '系统','log_orderstate' => 20], ['order_id' => $a_data[0]['order_id']]);

			//成功，发送短信提示给客服人员

			echo '支付成功！';
			header("location:http://wofei_wap.7dugo.com");
		}
	}

	// 异步通知
	public function not() {
		$this->load->library('alipay_wap');
		// 验证成功，开始对订单进行相应的处理，并显示友好提示页面，示例只是显示下结果而已
		if ($this->alipay_wap->verify($this->general->get())) {
			$shop = $this->general->get();

			//更新订单表
			$b_order = $this->db->update('order', ['order_state' => '20', 'order_time' => $_SERVER['REQUEST_TIME'],'payment_code' => 'alipay'], ['pay_sn' => $shop['out_trade_no']]);

			$a_data = $this->db->get('order',['user_id' => $_SESSION['user_id'], 'pay_sn' => $shop['out_trade_no']],'order_id,user_name');

			//更新订单历史表tw_order_log
			$b_order_log = $this->db->update('order_log',['log_msg' => '已收到货款(支付宝支付)'. $shop['trade_no'], 'log_time' => $_SERVER['REQUEST_TIME'],'log_role' => '系统', 'log_user' => '系统','log_orderstate' => 20], ['order_id' => $a_data[0]['order_id']]);

			//成功，发送短信提示给客服人员

			echo '支付成功！';
			header("location:http://wofei_wap.7dugo.com");
		}
	}

/************************************  框架支微信支付 **************************************/
	// 异步步通知
	public function wxpay() {
		// 接收微信返回的通知xml数据， 也可以用 $GLOBALS['HTTP_RAW_POST_DATA'] 获取post数据
		$s_xml = file_get_contents('php://input');

		// 加载微信支付类
		$this->load->library('wxpay_h5');
		// 把微信返回的通知xml数据转换为数组格式
		$a_data = $this->wxpay_h5->xml_to_array($s_xml);
		
		// 下面进行签名验证，以及支付状态验证
		
		// 验证签名成功
		if ($this->wxpay_h5->verify($a_data)) {
			// 判断结果的状态是否为成功， 第二个参数支持：PAY/REFUND/QUERY 等，对应相应的函数
			if ($this->wxpay_h5->check($a_data, 'PAY')) {
				// 也可以用自行验证，但是需要自己查阅微信接口文档，因为不同的操作，验证参数不一样
				// if ($a_data['return_code'] == 'SUCCESS' && $a_data['result_code'] == 'SUCCESS') {					
					// 处理订单逻辑
					// 更新订单表
					$b_order = $this->db->update('order', ['order_state' => '20', 'order_time' => $_SERVER['REQUEST_TIME'],'payment_code' => 'offline'], ['pay_sn' => $a_data['out_trade_no']]);

					$a_data = $this->db->get('order',['user_id' => $_SESSION['user_id'], 'pay_sn' => $a_data['out_trade_no']],'order_id,user_name');

					//更新订单历史表tw_order_log
					$b_order_log = $this->db->update('order_log',['log_msg' => '已收到货款(微信支付)'. $a_data['trade_no'], 'log_time' => $_SERVER['REQUEST_TIME'],'log_role' => '系统', 'log_user' => '系统','log_orderstate' => 20], ['order_id' => $a_data[0]['order_id']]);
				// 通知微信，我们已经收到消息，知道付款成功了，如果不通知微信，微信会一直给我们发消息
				echo $this->wxpay_h5->success();
			} else {
				// 支付结果失败，所以这里是不能更新付款状态为成功的
			}
		} else {
			// 验证签名失败，数据肯定存在问题，所以不做任何处理，无视即可
		}
	}

/************************************  框架支付宝支付  ************************************/

	//多方式支付
	public function payment() {
		$pay = $this->general->post();
		$pay_sn=$this->pay_model->pay();
	}

	public function get_pay_sn(){

		$pay_sn=$this->router->get(1);

		if($this->is_wechat()){
				echo "<img src=image/pay.png style='width: 100%;height: 100%;'>";
		}else{
				$this->pay_model->alipay(['0'=>$pay_sn]);

		}
	}


    /**
     * [is_wechat]
     */
    public function is_wechat(){
    	$user_agent = $_SERVER['HTTP_USER_AGENT'];
    	if (strpos($user_agent, 'MicroMessenger') === false) {

    		return false;

		} else {

			return true;

		}
    }
}
