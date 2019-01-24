<?php
defined('BASEPATH') OR exit('禁止访问！');

class Home_ctrl extends TW_Controller {
	
	public function __construct() {
		parent :: __construct();
		
		
	}

	public function index()	{
		$this->load->library('wxpay_pub');
		
		$s_result = $this->wxpay_pub->pay();
		
		print_r($s_result);
	}
	
	// 同步通知
	public function ret() {
		// 接收微信返回的通知xml数据， 也可以用 $GLOBALS['HTTP_RAW_POST_DATA'] 获取post数据
		$s_xml = file_get_contents('php://input');

		// 加载微信支付类
		$this->load->library('wxpay_h5');
		// 把微信返回的通知xml数据转换为数组格式
		$a_data = $this->wxpay_h5->xml_to_array($s_xml);
		// 下面进行签名验证，以及支付状态验证
		// 验证签名成功，并且支付状态也是成功的
		if ($this->wxpay_h5->verify($a_data)) {
			// 判断结果的状态是否为成功， 第二个参数支持：PAY/REFUND/QUERY 等，对应相应的函数
			if ($this->wxpay_h5->check($a_data, 'PAY')) {
				// 也可以用自行验证
				//if ($a_data['return_code'] == 'SUCCESS' && $a_data['result_code'] == 'SUCCESS') {
					
				// 处理订单逻辑，比如更新订单的状态为付款成功等
			
				// 通知微信，我们已经收到消息，知道付款成功了，如果不通知微信，微信会一直给我们发消息
				echo $this->wxpay_h5->success();
			} else {
				// 支付结果为失败，所以这里也不能更新付款状态
			}
			file_put_contents('1.txt', print_r($this->wxpay_h5->success(), true));
		} else {
			// 验证签名失败，数据肯定存在问题，所以不做任何处理，无视即可
			file_put_contents('2.txt', print_r($a_data, true));
			file_put_contents('3.txt', $s_xml);
		}
	}
	
	
	// 异步通知
	public function not() {
		print_r($_GET);
		file_put_contents('./not.txt', print_r($_GET, true));
	}
}
