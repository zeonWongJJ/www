<?php
// https://doc.open.alipay.com/docs/doc.htm?spm=a219a.7629140.0.0.Cnbsvf&treeId=58&articleId=103578&docType=1

// 加载接口入口文件
require_once(BASEPATH . '/libraries/pay/alipay_wap/AopSdk.php');

class TW_alipay_wap {
	// 接口请求参数数组
	private $_a_param = [
		// 商户订单号，商户网站订单系统中唯一订单号，订单支付时必填；查询、退款、取消关闭等操作与“trade_no”参数二选一
		'out_trade_no' => '',
		// 支付宝交易号，订单支付时不使用此参数；查询、退款、取消、关闭操作时与“out_trade_no”参数二选一
		'trade_no' => '',
		
		/******* 订单支付参数 开始 *****************/
		// 订单名称，必填
		'subject' => '',
		// 付款金额，必填
		'total_amount' => '',
		// 商品描述，可空
		'body' => '',
		/** 该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，
			1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。 
			该参数数值不接受小数点， 如 1.5h，可转换为 90m。
		*/
		'timeout_express' => '24h',
		/******* 订单支付参数 结束 *****************/
		
		// 销售产品码，商家和支付宝签约的产品码。该产品请填写固定值：QUICK_WAP_WAY
		'product_code' => 'FAST_INSTANT_TRADE_PAY',
		
		/******* 退款参数 开始 *********************/
		// 请求退款金额，必填
		'refund_amount' => 0,
		// 请求退款原因，选填
		'refund_reason' => '',
		// 退款交易号，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
		'out_request_no' => '',
		// 商户的操作员编号，选填
		'operator_id' => '',
		// 商户的门店编号
		'store_id' => '',
		// 商户的终端编号
		'terminal_id' => '',
		/******* 退款参数 结束 *********************/
		
		/******* 转账参数 开始 *********************/
		// 商户转账唯一订单号
		'out_biz_no' => '',
		/** 收款方账户类型。可取值： 
			1、ALIPAY_USERID：支付宝账号对应的支付宝唯一用户号。以2088开头的16位纯数字组成。 
			2、ALIPAY_LOGONID：支付宝登录号，支持邮箱和手机号格式。
		*/
		'payee_type' => 'ALIPAY_LOGONID',
		// 收款方账户。付款方和收款方不能是同一个账户。
		'payee_account' => '',
		// 转账金额，单位：元。 只支持2位小数。
		'amount' => '0.00',
		// 付款方姓名，可选
		'payer_show_name' => '',
		// 收款方真实姓名，可选
		'payee_real_name' => '',
		// 转账备注（支持200个英文/100个汉字），可选。 
		'remark' => '',
		/******* 转账参数 结束 *********************/
		
		// 异步通知地址，当设置此参数时，将忽略配置文件中的通知地址
		'notify_url' => '',
		// 同步通知地址，当设置此参数时，将忽略配置文件中的通知地址
		'return_url' => '',
		// 自定义配置文件名，当有多个配置或通知路径等需求时，可以设置不同配置文件来解决
		'config_file' => 'config_alipay',
		
		// true表示返回html，直接显示支付宝页面，flase返回执行结果的数组，像订单查询等操作无论传入true或false都返回Json结果
		'is_page' => true
	];
	
	// 存储参数用json编码后的字符串
	private $_s_param = '';
	
	// 公共参数数组
	private $_a_config = [
		// 支付宝分配给开发者的应用ID
		'app_id' => '',
		// 支付宝接口请求地址
		'api_url' => 'https://openapi.alipay.com/gateway.do',
		// 商户私钥
		'key_private' => '',
		// 支付宝公钥
		'key_public' => '',
		// 调用的接口版本，固定为：1.0
		'version' => '1.0',
		// 请求使用的编码格式，如utf-8,gbk,gb2312等
		'charset' => 'utf-8',
		// 仅支持JSON
		'format' => 'json',
		// 商户生成签名字符串所使用的签名算法类型，目前支持RSA2和RSA，推荐使用RSA2
		'sign_type' => 'rsa',
		// 同步通知地址
		'return_url' => '',
		// 异步通知地址
		'notify_url' => ''
	];
	
	// 支付宝接口对象
	private $_o_aop;
	
	// 对象转数组的临时存储变量
	private $_a_object_to_array = [];
	
	// 构造函数，对参数进行处理
	public function __construct($a_param = []) {
		$this->set_param($a_param);
	}
	
	/**
	 支付交易返回失败或支付系统超时，调用该接口撤销交易。
	 如果此订单用户支付失败，支付宝系统会将此订单关闭；如果用户支付成功，支付宝系统会将此订单资金退还给用户。
	 注意：只有发生支付系统超时或者支付结果未知时可调用撤销，其他正常支付的单如需实现相同功能请调用申请退款API。
	 提交支付交易后调用【查询订单API】，没有明确的支付结果再调用【撤销订单API】。
	 交易关闭接口文档：
	 https://doc.open.alipay.com/docs/api.htm?spm=a219a.7395905.0.0.7ctKpF&docType=4&apiId=866
	 商家订单号和支付宝交易号，两个参数必须传入一个，如果同时存在优先取支付宝交易号
	*/
	public function cancel($a_param = []) {
		$this->set_param($a_param);

		$o_request = new AlipayTradeCancelRequest();
		$o_request->setBizContent($this->_s_param);
		$u_result = $this->_exec($o_request);
		return $u_result;
	}
	
	/**
	 用于交易创建后，用户在一定时间内未进行支付，可调用该接口直接将未付款的交易进行关闭。
	 交易关闭接口文档：
	 https://doc.open.alipay.com/docs/api.htm?spm=a219a.7395905.0.0.ZxBuDg&docType=4&apiId=1058
	 商家订单号和支付宝交易号，两个参数必须传入一个，如果同时存在优先取支付宝交易号
	*/
	public function close($a_param = []) {
		$this->set_param($a_param);

		$o_request = new AlipayTradeCloseRequest();
		$o_request->setBizContent($this->_s_param);
		$u_result = $this->_exec($o_request);
		return $u_result;
	}
	
	// https://docs.open.alipay.com/common/105463
	// 执行接口调用
	public function pay($a_param = []) {
		$this->set_param($a_param);
		
		$o_request = new AlipayTradeWapPayRequest();
		$o_request->setNotifyUrl($this->_a_config['notify_url']);
		$o_request->setReturnUrl($this->_a_config['return_url']);
		$o_request->setBizContent($this->_s_param);
		$u_result = $this->_exec($o_request);
		return $u_result;
	}
	
	/**
	 交易查询接口文档：
	 http://app.alipay.com/market/document.htm?name=tiaomazhifu#page-14
	 https://doc.open.alipay.com/docs/api.htm?spm=a219a.7629065.0.0.edPM51&apiId=757&docType=4
	 $out_trade_no 商家订单交易号
	 $trade_no 支付宝交易号
	 两个参数必须传入一个，如果同时存在优先取 $trade_no
	*/
	public function query($a_param = []) {
		$this->set_param($a_param);
		
		$o_request = new AlipayTradeQueryRequest();
		$o_request->setBizContent($this->_s_param);
		
		$u_result = $this->_exec($o_request);
		
		return $u_result;
	}
	
	/**
	 * 退款接口文档：
	 http://app.alipay.com/market/document.htm?name=tiaomazhifu#page-16
	 https://doc.open.alipay.com/docs/api.htm?spm=a219a.7395905.0.0.vRJziM&docType=4&apiId=759
	*/
	public function refund($a_param = []) {
		$this->set_param($a_param);
		
		$o_request = new AlipayTradeRefundRequest();
		$o_request->setBizContent($this->_s_param);
		$u_result = $this->_exec($o_request);
		
		return $u_result;
	}
	
	// 支付宝公钥很多，很容易搞混，公钥查看地址：https://openhome.alipay.com/platform/keyManage.htm
	// 签名验证，返回bool值
	public function verify($a_param, $s_type = 'return') {
		$this->set_param($a_param);
		// 异步通知验证
		if ($s_type == 'notify') {
			$a_data = $a_param;
		} else {
			// 异步通知验证
			
			// 为确保传入的参数的准确性，重新整理一下数组，去掉混入的无用参数，以免影响签名验证
			$a_data = [];
			$a_data['total_amount'] = $a_param['total_amount'];
			$a_data['timestamp'] = $a_param['timestamp'];
			$a_data['sign'] = $a_param['sign'];
			$a_data['trade_no'] = $a_param['trade_no'];
			$a_data['sign_type'] = $a_param['sign_type'];
			$a_data['auth_app_id'] = $a_param['auth_app_id'];
			$a_data['charset'] = $a_param['charset'];
			$a_data['seller_id'] = $a_param['seller_id'];
			$a_data['method'] = $a_param['method'];
			$a_data['app_id'] = $a_param['app_id'];
			$a_data['out_trade_no'] = $a_param['out_trade_no'];
			$a_data['version'] = $a_param['version'];
		}
		// 此语句参数demo，实际测试不要也没影响
		$this->_o_aop->alipayrsaPublicKey = $this->_a_config['key_public'];
		
		return $this->_o_aop->rsaCheckV1($a_data, $this->_a_config['key_public'], $this->_a_config['sign_type']);
	}
	
	/** https://docs.open.alipay.com/api_28/alipay.fund.trans.toaccount.transfer
	 * 单笔转账接口
	*/
	public function transfer($a_param = []) {
		$this->set_param($a_param);
		
		$o_request = new AlipayFundTransToaccountTransferRequest();
		$o_request->setBizContent($this->_s_param);
		$u_result = $this->_exec($o_request);
		
		return $u_result;
	}
	
	// 执行方式
	private function _exec($o_request) {
		if ($this->_a_param['is_page']) {
			// 返回html代码
			$m_result = $this->_o_aop->pageExecute($o_request);
		} else {
			// 返回对象
			$m_result = $this->_o_aop->execute($o_request);
			if (is_object($m_result)) {
				$m_result = $this->_object_to_array($m_result);
			} else {
				$m_result = json_decode($m_result, true);
			}
		}
		return $m_result;
	}
	
	// 递归对象转数组
	private function _object_to_array($o_object) {
		foreach ($o_object as $s_key => $u_val) {
			if (is_object($u_val)) {
				$this->_object_to_array($u_val);
			} else {
				$this->_a_object_to_array[$s_key] = $u_val;
			}
		}
		return $this->_a_object_to_array;
	}
	
	// 公共参数设置
	private function _config() {
		$this->_s_config_file = rtrim($this->_s_config_file, '.php');
		if (file_exists(PROJECTPATH . "/config/{$this->_s_config_file}.php")) {
			require(PROJECTPATH . "/config/{$this->_s_config_file}.php");
		} else {
			require(BASEPATH . "libraries/pay/alipay_wap/{$this->_s_config_file}.php");
		}
		if ( ! isset($a_config_alipay) || empty($a_config_alipay['app_id'])
			|| empty($a_config_alipay['key_private'])
			|| empty($a_config_alipay['key_public']) ) {
			throw new Exception("公共参数不完整!");
		}
		$this->_a_config = $a_config_alipay;
		
		$this->_o_aop = new AopClient();
		$this->_o_aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
		$this->_o_aop->appId = $this->_a_config['app_id'];
		$this->_o_aop->rsaPrivateKey = $this->_a_config['key_private'];
		$this->_o_aop->alipayrsaPublicKey = $this->_a_config['key_public'];
		$this->_o_aop->apiVersion = $this->_a_config['version'];
		$this->_o_aop->postCharset = $this->_a_config['charset'];
		$this->_o_aop->format = $this->_a_config['format'];
		$this->_o_aop->signType = $this->_a_config['sign_type'];
	}
	
	// 请求参数设置
	public function set_param($a_param = []) {
		if ( ! is_array($a_param) || empty($a_param) ) {
			return false;
		}
		
		foreach ($this->_a_param as $s_key => $u_val) {
			if (isset($a_param[$s_key])) {
				$this->_a_param[$s_key] = $a_param[$s_key];
			}
		}
		
		// 使用自定义配置文件
		if ( isset($this->_a_param['config_file'])) {
			$this->_s_config_file = $this->_a_param['config_file'];
			unset($this->_a_param['config_file']);
		}
		
		// 调用配置文件
		$this->_config();
		
		if (! empty($this->_a_param['notify_url'])) {
			$this->_a_config['notify_url'] = $this->_a_param['notify_url'];
			unset($this->_a_param['notify_url']);
		}
		if (! empty($this->_a_param['return_url'])) {
			$this->_a_config['return_url'] = $this->_a_param['return_url'];
			unset($this->_a_param['return_url']);
		}
		
		$this->_a_param = array_filter($this->_a_param);
		
		$this->json();
	}
	
	// 将参数进行json处理
	public function json() {
		if ( ! empty($this->_a_param) ) {
			$this->_s_param = json_encode($this->_a_param, JSON_UNESCAPED_UNICODE);
		}
		return $this->_s_param;
	}
}
?>