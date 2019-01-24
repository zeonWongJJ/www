<?php
// 微信公众号异步通知类
require_once BASEPATH . "/libraries/pay/wxpay_pub/lib/WxPay.Api.php";
require_once BASEPATH . "/libraries/pay/wxpay_pub/lib/WxPay.Notify.php";
class TW_wxpay_pub_notify extends WxPayNotify {
	private $b_result = false;
	private $a_data = [];
	//重写回调处理函数
	public function NotifyProcess($a_data, &$s_msg) {
		$this->a_data = $a_data;
		$o_wxpay_pub =& load_class('wxpay_pub', 'libraries');
		$this->b_result = $o_wxpay_pub->verify($a_data);
	}
	
	// 获取使用签名算法验证的结果
	public function get_verify_result() {
		return $this->b_result;
	}
	
	// 获取返回的结果，以数组形式返回
	public function get_result_data() {
		return $this->a_data;
	}
}
?>