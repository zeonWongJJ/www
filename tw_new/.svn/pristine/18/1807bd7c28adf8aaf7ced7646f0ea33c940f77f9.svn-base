<?php
defined('BASEPATH') OR exit('禁止访问！');

/**
 * @property \model\PayModel pay_model
 */
class Pay_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();

		//实例化商品模型
//		$this->load->model('pay_model');
		$this->pay_model = \utils\Factory::getFactory('pay');
	}

	public function pay(){

		$pay = $this->general->post();
			$this->pay_model->pay();die;
		if(! empty($_SESSION['user_id']) && ! empty($pay)){
		} else {
			$this->error->show_error('非法访问');
		}

	}

	// 其他地方调用的支付方法
	public function payment(){
		$pay_sn = $this->general->post('pay_sn');
		$pay_type = $this->general->post('pay_type');
		$this->pay_model->payment($pay_sn,$pay_type);
	}

	//支付宝回调
	public function alipay(){
		require_once(PROJECTPATH . "/libraries/alipay/notify_url.php");
	}

	//财务通支付
	public function tenpay(){

		// 提交事务
			if($b_cart != false && $b_order != false && $b_order_common != false && $b_order_pay ){
				$this->db->commit();
			} else {
				// 事务回滚
				$this->db->roll_back();
				$this->db->show_error('订单有误请重新提交',$this->router->url('shop'));
			}
		// } else {
		// 	$this->error->show_error('非法访问');
		// }
		$content = "123";
		$price = 1;
		$out_trade_no = 123;
		/*财务通支付需要传入的参数
		*参数
		* $price    单位分
		* $content  商品名称
		* $out_trade_no 商品订单号按需求改变里面的订单的代码
		*/
		$this->pay_model->tenpay($price, $content, $out_trade_no);
	}



}
