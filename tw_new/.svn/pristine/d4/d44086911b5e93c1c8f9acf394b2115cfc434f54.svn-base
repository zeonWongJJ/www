<?php
defined('BASEPATH') OR exit('禁止访问！');

//require_once(PROJECTPATH."/libraries/1.php");
class Pay_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
		$this->prefix = $this->db->get_prefix();
		$this->load->model('pay_model');
	}

	public function pay() {

		// require_once(PROJECTPATH."/libraries/alipay/alipay.config.php");
  		// require_once(PROJECTPATH."/libraries/alipay/lib/alipay_submit.class.php");

		$_POST['WIDout_trade_no'] = $this->router->get(1) ? $this->router->get(1) : '';
        if($_POST['WIDout_trade_no'] != ""){
         /**************************请求参数**************************/
         $a_goods = $this->db->from('order as a')
							->join('order_goods', ['a.order_id' => $this->prefix.'order_goods.order_id'])
							->where(['a.order_sn' => $_POST['WIDout_trade_no']])
							->select([$this->prefix.'order_goods.goods_name', 'a.order_amount'])
     					 	->get();
         	if ( ! empty($a_goods)) {

/***************************************  旧代码 ************************************************/

		        //商户订单号，商户网站订单系统中唯一订单号，必填

		     //    $out_trade_no = $_POST['WIDout_trade_no'];

		     //   //订单名称，必填
		     //    $a = '';
		   		// foreach ($a_goods as $key) {
		   		// 	$a .= "$key[goods_name] ";
		   		// }
		   		// $subject = rtrim($a," ");

		     //    //付款金额，必填
		     //    $total_fee = $a_goods[0]['order_amount'];

		     //    //商品描述，可空
		     //    $body = $_POST['WIDbody'];

/***************************************  旧代码 ************************************************/

/************************************  框架支付宝支付  ************************************/


       //订单名称，必填
        $a = '';
   		foreach ($a_goods as $key) {
   			$a .= $key['goods_name'];
   		}
		$this->load->library('alipay_wap');
		$a_data = [
			// 商户订单号，商户网站订单系统中唯一订单号，必填
			'out_trade_no' => $_POST['WIDout_trade_no'],// '201781113588902',
			// 订单名称，必填
			'subject' => rtrim($a," "),
			// 付款金额，必填
			'total_amount' => $a_goods[0]['order_amount'],
			//'total_amount' => 0.01,
			// 商品描述，可空
			'body' => $_POST['WIDbody'],
			/** 该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，
				1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。
				该参数数值不接受小数点， 如 1.5h，可转换为 90m。
			*/
			'timeout_express' => '24h'
		];
		
			
		
		echo $this->alipay_wap->pay($a_data);

/************************************  框架支付宝支付  ************************************/

/***************************************** 旧代码 *************************************************/


		//构造要请求的参数数组，无需改动
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
		// 		"subject"	=> $subject,
		// 		"total_fee"	=> $total_fee,
		// 		"body"	=> $body,
		// 		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		// 		//其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
		//         //如"参数名"=>"参数值"

		// );


		// 		//建立请求
		// 		$alipaySubmit = new AlipaySubmit($alipay_config);

		// 		if($this->is_wechat()){
		// 			echo "<img src=image/pay.png style='width: 100%;height: 100%;'>";
		// 		}else{
		// 			$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		// 			echo $html_text;

		// 		}

/***************************************** 旧代码 *************************************************/

       		} else {
       		   $this->error->show_warning(网络异常，请稍后再试！);
       		}
       	}else{

		 $this->view->display('pay');
		}
	}

/************************************  框架支付宝支付  ************************************/

	// 同步通知
	public function ret() {
		$this->load->library('alipay_wap');
		// 验证成功，开始对订单进行相应的处理，并显示友好提示页面，示例只是显示下结果而已
		echo $this->alipay_wap->verify($this->general->get()) ? '验证成功' : '验证失败';
	}

	// 异步通知
	public function not() {
		$s_result = $this->alipay_wap->verify($this->general->get()) ? '验证成功' : '验证失败';

		// 这里要对订单进行相应处理，示例只是把结果写到文本而已了
		file_put_contents('./not.txt', $s_result);
	}

/************************************  框架支付宝支付  ************************************/

/***************************************** 旧代码 *************************************************/

	//支付宝回调
	// public function alipay() {
	// 	require_once(PROJECTPATH . "/libraries/alipay/notify_url.php");
	// }

/***************************************** 旧代码 *************************************************/

	//多方式支付
	public function payment() {
		// if(! empty($_SESSION['user_id']) && ! empty($pay)){

		// } else {

		// 	$this->error->show_error('非法访问');

		// }

		$pay = $this->general->post();
		$pay_sn=$this->pay_model->pay();
		//$url="get_pay_sn-".$pay_sn;
		//Header("Location: $url");


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
