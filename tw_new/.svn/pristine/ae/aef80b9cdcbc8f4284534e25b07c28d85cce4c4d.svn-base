<?php
// 达达配送 http://newopen.imdada.cn/

class TW_distribution_dada {
	
	// 配置文件
	private $_s_config_file = 'config_distribution_dada';
	// 基础参数
	private $_a_param = [];
	private $_s_app_secret = '';
	// api地址
	private $_s_api_url = 'http://newopen.imdada.cn';
	// 保存执行结果用
	private $_a_exec_result = [];
	
	public function __construct() {
		$this->_config();
	}
	
	// 模拟接收，参数例：['order_id' => '20180111566']
	public function analog_receive($a_data) {
		$a_param = $this->_a_param;
		$a_param['body'] = json_encode($a_data);
		$a_param['signature'] = $this->sign($a_param);
		$this->_a_exec_result = $this->request($this->_s_api_url . '/api/order/accept', $a_param);
		if ($this->_a_exec_result['status'] == 'success' && $this->_a_exec_result['code'] == 0) {
			return true;
		}
		return false;
	}
	
	// 模拟完成取货，参数例：['order_id' => '20180111566']
	public function analog_fetch($a_data) {
		$a_param = $this->_a_param;
		$a_param['body'] = json_encode($a_data);
		$a_param['signature'] = $this->sign($a_param);
		$this->_a_exec_result = $this->request($this->_s_api_url . '/api/order/fetch', $a_param);
		if ($this->_a_exec_result['status'] == 'success' && $this->_a_exec_result['code'] == 0) {
			return true;
		}
		return false;
	}
	
	// 模拟完成订单，参数例：['order_id' => '20180111566']
	public function analog_finish($a_data) {
		$a_param = $this->_a_param;
		$a_param['body'] = json_encode($a_data);
		$a_param['signature'] = $this->sign($a_param);
		$this->_a_exec_result = $this->request($this->_s_api_url . '/api/order/finish', $a_param);
		if ($this->_a_exec_result['status'] == 'success' && $this->_a_exec_result['code'] == 0) {
			return true;
		}
		return false;
	}
	
	// 模拟取消订单，参数例：['order_id' => '20180111566', 'reason' => '可选参数，取消原因说明']
	public function analog_cancel($a_data) {
		$a_param = $this->_a_param;
		$a_param['body'] = json_encode($a_data);
		$a_param['signature'] = $this->sign($a_param);
		$this->_a_exec_result = $this->request($this->_s_api_url . '/api/order/cancel', $a_param);
		if ($this->_a_exec_result['status'] == 'success' && $this->_a_exec_result['code'] == 0) {
			return true;
		}
		return false;
	}
	
	// 模拟订单过期，参数例：['order_id' => '20180111566']
	public function analog_expire($a_data) {
		$a_param = $this->_a_param;
		$a_param['body'] = json_encode($a_data);
		$a_param['signature'] = $this->sign($a_param);
		$this->_a_exec_result = $this->request($this->_s_api_url . '/api/order/expire', $a_param);
		if ($this->_a_exec_result['status'] == 'success' && $this->_a_exec_result['code'] == 0) {
			return true;
		}
		return false;
	}
	
	// 取消订单
	public function cancel($a_data) {
		$a_param = $this->_a_param;
		$a_param['body'] = json_encode($a_data);
		$a_param['signature'] = $this->sign($a_param);
		$this->_a_exec_result = $this->request($this->_s_api_url . '/api/order/formalCancel', $a_param);
		if ($this->_a_exec_result['status'] == 'success' && $this->_a_exec_result['code'] == 0) {
			return true;
		}
		return false;
	}

	// 订单查询
	public function query($a_data) {
		$a_param = $this->_a_param;
		$a_param['body'] = json_encode($a_data);
		$a_param['signature'] = $this->sign($a_param);
		$this->_a_exec_result = $this->request($this->_s_api_url . '/api/order/status/query', $a_param);
		return $this->_a_exec_result;
	}
	
	// 重发订单
	public function readd_order($a_data) {
		$a_param = $this->_a_param;
		$a_param['body'] = json_encode($a_data);
		$a_param['signature'] = $this->sign($a_param);
		$this->_a_exec_result = $this->request($this->_s_api_url . '/api/order/reAddOrder', $a_param);
		if ($this->_a_exec_result['status'] == 'success' && $this->_a_exec_result['code'] == 0) {
			return true;
		}
		return false;
	}
	
	// 添加订单
	public function add_order($a_data) {
		$a_param = $this->_a_param;
		$a_param['body'] = json_encode($a_data);
		$a_param['signature'] = $this->sign($a_param);
		$this->_a_exec_result = $this->request($this->_s_api_url . '/api/order/addOrder', $a_param);
		if ($this->_a_exec_result['status'] == 'success' && $this->_a_exec_result['code'] == 0) {
			return true;
		}
		return false;
	}
	
	// 获取取消原因列表
	public function reasons() {
		$a_param = $this->_a_param;
		$a_param['body'] = '';
		$a_param['signature'] = $this->sign($a_param);
		$this->_a_exec_result = $this->request($this->_s_api_url . '/api/order/cancel/reasons', $a_param);
		return $this->_a_exec_result;
	}
	
	// 获取城市列表
	public function city_code() {
		$a_param = $this->_a_param;
		$a_param['body'] = '';
		$a_param['signature'] = $this->sign($a_param);
		$this->_a_exec_result = $this->request($this->_s_api_url . '/api/cityCode/list', $a_param);
		return $this->_a_exec_result;
	}
	
	// 返回执行结果数组
	public function get_result() {
		return $this->_a_exec_result;
	}
	
	// 签名
	public function sign($a_param = '') {
		if (empty($a_param)) {
			return $this->_sign($this->_a_param);
		} else {
			return $this->_sign($a_param);
		}
	}
	
	// 生成签名
	private function _sign($a_param) {
		ksort($a_param);
		$s_string = '';
		foreach ($a_param as $s_k => $u_v) {
			$s_string .= $s_k . $u_v;
		}
		$s_string = $this->_s_app_secret . $s_string . $this->_s_app_secret;
		$s_string = strtoupper(md5($s_string));
		return $s_string;
	}
	
	// 回调签名验证
	public function signature($m_param) {
		if (is_string($m_param)) {
			$a_data = json_decode($m_param, true);
		} elseif (is_array($m_param)) {
			$a_data = $m_param;
		} else {
			return false;
		}
		$a_sign = [
			'client_id' => $a_data['client_id'],
			'order_id' => $a_data['order_id'],
			'update_time' => $a_data['update_time']
		];
		asort($a_sign);
		$s_sign = implode('', $a_sign);
		return md5($s_sign);
	}
	
	// 发起请求
	public function request($s_url, $a_data) {
		$a_header = ['Content-Type: application/json'];
		$s_data = json_encode($a_data);
		$o_curl = curl_init();
		//超时时间
		curl_setopt($o_curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($o_curl, CURLOPT_RETURNTRANSFER, 1);
		//这里设置代理，如果有的话
		//curl_setopt($o_curl, CURLOPT_PROXY, '10.206.30.98');
		//curl_setopt($o_curl, CURLOPT_PROXYPORT, 8080);
		curl_setopt($o_curl, CURLOPT_URL, $s_url);
		curl_setopt($o_curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($o_curl, CURLOPT_SSL_VERIFYHOST, false);
		// 设置host
		if ( is_array($a_header) && ! empty($a_header) ) {
			curl_setopt($o_curl, CURLOPT_HTTPHEADER, $a_header);
		}
	 
		curl_setopt($o_curl, CURLOPT_POST, 1);
		curl_setopt($o_curl, CURLOPT_POSTFIELDS, $s_data);
		$a_result = json_decode(curl_exec($o_curl), true);
		if (empty($a_result)) {
			$a_result['error'] = curl_errno($o_curl);
		}
		curl_close($o_curl);
		return $a_result;
	}
	
	// 设置配置文件名
	public function set_config_file($s_config_file) {
		$this->_s_config_file = $s_config_file;
	}
	
	// 获取配置参数
	private function _config() {
		$this->_s_config_file = rtrim($this->_s_config_file, '.php');
		if (file_exists(PROJECTPATH . "/config/{$this->_s_config_file}.php")) {
			require(PROJECTPATH . "/config/{$this->_s_config_file}.php");
		} else {
			require(BASEPATH . "libraries/pay/distribution_dada/{$this->_s_config_file}.php");
		}
		$this->_s_app_secret = $a_config_distribution_dada['app_secret'];
		unset($a_config_distribution_dada['app_secret']);
		$a_config_distribution_dada['timestamp'] = $_SERVER['REQUEST_TIME'];
		$this->_a_param = $a_config_distribution_dada;
	}
}
?>