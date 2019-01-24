<?php
defined('BASEPATH') OR exit('禁止访问！');

class Sync_ctrl extends TW_Controller {
	
	public function __construct() {
		parent :: __construct();
		$this->load->model('auth_model');
		$this->load->model('cart_model');
	}
	
	// 显示购物车信息
	public function cart_list() {
		$a_data = $this->cart_model->data();
		
		//print_r($_SESSION['cashier']['cart']);
		// 生成二维码订单
		if (isset($_SESSION['cashier']['cart_order_id'])) {
			// 支付宝订单
			$this->load->library('alipay_f2f');
			$a_ali_param = [
				// (必填) 商户网站订单系统中唯一订单号，64个字符以内，只能包含字母、数字、下划线
				'out_trade_no' => $_SESSION['cashier']['cart_order_number'],
				// (必填) 订单总金额，单位为元，不能超过1亿元
				// 如果同时传入了【打折金额】,【不可打折金额】,【订单总金额】三者,则必须满足如下条件:【订单总金额】=【打折金额】+【不可打折金额】
				'total_amount' => $_SESSION['cashier']['cart_product_money'],
				// (必填) 订单标题，粗略描述用户的支付目的。如“XX品牌XXX门店消费”
				'subject' => '(V稻)' . $_SESSION['store_name'] . '收银机订单',
				// (可选) 订单描述，可以对交易或商品进行一个详细地描述，比如填写"购买商品2件共15.00元"
				//'body' => '测试',
				//'operator_id' => 'STOTE_' . $_SESSION['store_id'],
				//'store_id' => 'STOTE_' . $_SESSION['store_id'],
				//'terminal_id' => 'STOTE_' . $_SESSION['store_id'],
			];
			$a_ali_result = $this->alipay_f2f->qrcode($a_ali_param);
			$a_data['qr_code_ali'] = $this->general->base64_convert($a_ali_result['qr_code']);
			
			// 微信订单：
			$this->load->library('wxpay_pub');
			$a_wx_param = [
				// 商品描述，必填
				'body' => '(V稻)' . $_SESSION['store_name'] . '收银机订单',
				// 商户订单号，必填
				'out_trade_no' => $_SESSION['cashier']['cart_order_number'],
				// 标价金额，必填，标价金额，单位为分
				'total_fee' => $_SESSION['cashier']['cart_product_money'] * 100,
				// 异步通知URL，必填
				'notify_url' => $this->router->url('notify_wx'),
				// 可定义为产品标识或订单号，微信扫码支付模式一需要用到，此为扫码模式二不需要用到，但是必填
				'product_id' => '123456789'
			];
			$a_wx_result = $this->wxpay_pub->scan_code($a_wx_param);
			$a_data['qr_code_wx'] = $this->general->base64_convert($a_wx_result['code_url']);
		}
		if (empty($a_data['cart'])) {
			$this->view->display('wait');
		} else {
			$this->view->display('cart_list', $a_data);
		}
	}
	
	// 异步通知
	public function notify_wx() {
		// 注意，异步通知，这里引用了另外一个类
		$this->load->library('wxpay_pub_notify');
		// true表示需要输出签名，默认是参数是true，适用于下面的方法一
		$this->wxpay_pub_notify->Handle(true);
		
		// 验证数据安全方法一：(签名验证)
		$b_result = $this->wxpay_pub_notify->get_verify_result();
		if ($b_result) {
			$a_result = $this->wxpay_pub_notify->get_result_data();
			if ($a_result['result_code'] == 'SUCCESS' && $a_result['return_code'] == 'SUCCESS') {
				$this->cart_model->order_complete($a_result['out_trade_no'], $a_result['total_fee'] / 100, 'offline', $a_result['transaction_id']);
			}
		} else {
			// 验证数据失败
		}
	}
	
	// 默认显示页面
	public function wait() {
		$this->view->display('wait');
	}
}
