<?php
// https://doc.open.alipay.com/docs/doc.htm?spm=a219a.7629140.0.0.wBroSa&treeId=193&articleId=105170&docType=1

require(BASEPATH . "libraries/pay/alipay_f2f/AopSdk.php");

class TW_alipay_f2f {
	// 接口请求参数数组
	private $_a_param = [
		// 接口名称
		'method' => 'alipay.trade.pay',
		/** 该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，
			1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。 
			该参数数值不接受小数点， 如 1.5h，可转换为 90m。
		*/
		'timeout_express' => '30m',

		// 异步通知地址，当设置此参数时，将忽略配置文件中的通知地址
		'notify_url' => '',
		// 同步通知地址，当设置此参数时，将忽略配置文件中的通知地址
		'return_url' => '',
		// 自定义配置文件名，当有多个配置或通知路径等需求时，可以设置不同配置文件来解决
		'config_file' => 'config_alif2f'
	];
	
	// 公共参数数组
	private $_a_config = [];
	// 自定义配置文件名，当有多个通知路径等需求时，可以设置不同配置文件来解决
	private $_s_config_file = 'config_alif2f';
	
	// 构造函数，对参数进行处理
	public function __construct($a_param = []) {
		$this->set_param($a_param);
	}
	
	// 当交易发生之后一段时间内，由于买家或者卖家的原因需要退款时，卖家可以通过退款接口将支付款退还给买家，支付宝将在收到退款请求并且验证成功之后，按照退款规则将支付款按原路退到买家帐号上。 交易超过约定时间（签约时设置的可退款时间）的订单无法进行退款 支付宝退款支持单笔交易分多次退款，多次退款需要提交原支付订单的商户订单号和设置不同的退款单号。一笔退款失败后重新提交，要采用原来的退款单号。总退款金额不能超过用户实际支付金额
	// 接口文档及参数 https://docs.open.alipay.com/api_1/alipay.trade.refund/
	public function refund($a_param) {
		// 接口名称
		$a_param['method'] = 'alipay.trade.refund';
		$this->set_param($a_param);
		
		$o_request = new AlipayTradeRefundRequest();
		$o_request->setBizContent($this->_s_param);
		$a_result = $this->_exec($o_request);
		$a_result['refund_detail_item_list'] = $this->_object_to_array($a_result['refund_detail_item_list']);
		return $a_result;
	}
	
	// 商户可使用该接口查询自已通过alipay.trade.refund提交的退款请求是否执行成功。 该接口的返回码10000，仅代表本次查询操作成功，不代表退款成功。如果该接口返回了查询数据，则代表退款成功，如果没有查询到则代表未退款成功，可以调用退款接口进行重试。重试时请务必保证退款请求号一致。
	// 接口文档及参数 https://docs.open.alipay.com/api_1/alipay.trade.fastpay.refund.query/
	public function query_refund($a_param) {
		// 接口名称
		$a_param['method'] = 'alipay.trade.fastpay.refund.query';
		$this->set_param($a_param);
		
		$o_request = new AlipayTradeFastpayRefundQueryRequest();
		$o_request->setBizContent($this->_s_param);
		$a_result = $this->_exec($o_request);
		return $a_result;
	}
	
	// 用于交易创建后，用户在一定时间内未进行支付，可调用该接口直接将未付款的交易进行关闭。
	// 接口文档及参数 https://docs.open.alipay.com/api_1/alipay.trade.close/
	public function close($a_param) {
		// 接口名称
		$a_param['method'] = 'alipay.trade.close';
		$this->set_param($a_param);
		
		$o_request = new AlipayTradeCloseRequest();
		$o_request->setBizContent($this->_s_param);
		$a_result = $this->_exec($o_request);
		return $a_result;
	}
	
	// 支付交易返回失败或支付系统超时，调用该接口撤销交易。如果此订单用户支付失败，支付宝系统会将此订单关闭；如果用户支付成功，支付宝系统会将此订单资金退还给用户。 注意：只有发生支付系统超时或者支付结果未知时可调用撤销，其他正常支付的单如需实现相同功能请调用申请退款API。提交支付交易后调用【查询订单API】，没有明确的支付结果再调用【撤销订单API】。
	// 接口文档及参数 https://docs.open.alipay.com/api_1/alipay.trade.cancel/
	public function cancel($a_param) {
		// 接口名称
		$a_param['method'] = 'alipay.trade.cancel';
		$this->set_param($a_param);
		
		$o_request = new AlipayTradeCancelRequest();
		$o_request->setBizContent($this->_s_param);
		$a_result = $this->_exec($o_request);
		return $a_result;
	}
	
	// 收银员通过收银台或商户后台调用支付宝接口，生成二维码后，展示给用户，由用户扫描二维码完成订单支付。
	// 接口文档及参数 https://docs.open.alipay.com/api_1/alipay.trade.precreate/
	public function qrcode($a_param) {
		// 接口名称
		$a_param['method'] = 'alipay.trade.precreate';
		$this->set_param($a_param);
		
		$o_request = new AlipayTradePrecreateRequest();
		$o_request->setBizContent($this->_s_param);
		$a_result = $this->_exec($o_request);
		return $a_result;
	}
	
	// 收银员使用扫码设备读取用户手机支付宝“付款码”/声波获取设备（如麦克风）读取用户手机支付宝的声波信息后，将二维码或条码信息/声波信息通过本接口上送至支付宝发起支付。
	// 接口文档及参数 https://docs.open.alipay.com/api_1/alipay.trade.pay
	public function pay($a_param) {
		// 等待支付页面，会导致session阻塞，因此先停掉session文件锁
		session_write_close();
		// 支付场景，条码支付，取值：bar_code，声波支付，取值：wave_code
		$a_param['scene'] = 'bar_code';
		$this->set_param($a_param);
		
		$o_request = new AlipayTradePayRequest();
		$o_request->setNotifyUrl($this->_a_config['notify_url']);
		$o_request->setReturnUrl($this->_a_config['return_url']);
		$o_request->setBizContent($this->_s_param);
		$u_result = $this->_exec($o_request);
		
		// 设置用来查询的参数
		$a_param = ['out_trade_no' => $a_param['out_trade_no']];
		
		for ($i_i = 0; $i_i <= $this->_a_config['max_query_retry']; $i_i++) {
			$a_result = $this->query($a_param);

			if($a_result['trade_status'] == 'WAIT_BUYER_PAY') {
				// 还在付款中，等待后继续
				sleep($this->_a_config['query_duration']);
				continue;
			}
		}
		
		return $a_result;
	}
	
	// 订单查询
	// 接口文档及参数 https://docs.open.alipay.com/api_1/alipay.trade.query/
	public function query($a_param) {
		// 接口名称
		$a_param['method'] = 'alipay.trade.query';
		$this->set_param($a_param);
		
		$o_request = new AlipayTradeQueryRequest();
		$o_request->setBizContent($this->_s_param);
		$a_result = $this->_exec($o_request);
		return $a_result;
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
	
	// 将参数进行json处理
	public function json() {
		global $o_general;
		if ( ! empty($this->_a_param) ) {
			$this->_a_param = $o_general->value_to_string($this->_a_param);
			$this->_s_param = json_encode($this->_a_param, JSON_UNESCAPED_UNICODE);
		}
		return $this->_s_param;
	}
	
	// 请求参数设置
	public function set_param($a_param = []) {
		if ( ! is_array($a_param) || empty($a_param) ) {
			return false;
		}
		
		foreach ($a_param as $s_key => $u_val) {
			$this->_a_param[$s_key] = $a_param[$s_key];
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
	
	// 公共参数设置
	private function _config() {
		$this->_s_config_file = rtrim($this->_s_config_file, '.php');
		if (file_exists(PROJECTPATH . "/config/{$this->_s_config_file}.php")) {
			require(PROJECTPATH . "/config/{$this->_s_config_file}.php");
		} else {
			require(BASEPATH . "libraries/pay/alipay_f2f/{$this->_s_config_file}.php");
		}
		
		$this->_a_config = $a_config_alipayf2f;
		
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
}
?>