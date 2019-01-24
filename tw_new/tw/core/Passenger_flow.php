<?php
// 客流统计
class TW_passenger_flow {
	// 配置文件名
	private $_s_config_file = 'config_passenger_flow';
	// 配置参数
	private $_a_config = [];
	
	// 构造函数
	public function __construct($a_param = []) {
		$this->access_token();
	}
	
	// 获取token
	public function access_token() {
		if (file_exists(PROJECTPATH . "/config/{$this->_s_config_file}.php")) {
			require(PROJECTPATH . "/config/{$this->_s_config_file}.php");
		} else {
			 throw new Exception('配置文件不存在');
		}
		$this->_a_config = $a_config_passenger_flow;
		if (empty($this->_a_config['access_token']) || $_SERVER['REQUEST_TIME'] >= $this->_a_config['expires_in']) {
			$s_url = 'http://dev.meirenji.cn/oauth/token';
			$a_data = [
				'grant_type' => $this->_a_config['grant_type'],
				'client_id' => $this->_a_config['client_id'],
				'client_secret' => $this->_a_config['client_secret']
			];
			$a_reslut = $this->request($s_url, $a_data);
			if (isset($a_reslut['status']) && $a_reslut['status'] == '40000') {
				throw new Exception($a_reslut['msg']);
			} elseif (isset($a_reslut['error'])) {
				throw new Exception($a_reslut['error_description']);
			} elseif (isset($a_reslut['access_token'])) {
				$this->_a_config['access_token'] = $a_reslut['access_token'];
				$this->_a_config['expires_in'] = $_SERVER['REQUEST_TIME'] + $a_reslut['expires_in'];
				$s_str = '<?php' . PHP_EOL . '$a_config_passenger_flow = [' . PHP_EOL;
				foreach ($this->_a_config as $s_k => $m_u) {
					$s_str .= "\t'{$s_k}' => '{$m_u}'," . PHP_EOL;
				}
				$s_str .= ']' . PHP_EOL . '?>';
				file_put_contents(PROJECTPATH . "/config/{$this->_s_config_file}.php", $s_str);
			}
		}
	}
	
	// 获取所有实体客流和滞留数据
	public function get_entity_all($date_start, $date_end) {
		$a_data = [
			'access_token' => $this->_a_config['access_token'],
			'appId' => $this->_a_config['client_id'],
			'start' => $date_start,
			'end' => $date_end
		];
		$s_url = 'http://dev.meirenji.cn/api/v2/multipleInstance/traffic/day';
		$a_reslut = $this->request($s_url, $a_data);
		return $a_reslut;
	}
	
	// 获取所有商户实体列表
	public function get_entity_list() {
		$a_data = [
			'access_token' => $this->_a_config['access_token'],
			'appId' => $this->_a_config['client_id']
		];
		$s_url = 'http://dev.meirenji.cn/api/v2/instances';
		$a_reslut = $this->request($s_url, $a_data);
		return $a_reslut;
	}
	
	// 获取商户实体详情
	public function get_entity_detail($s_open_id) {
		$a_data = [
			'access_token' => $this->_a_config['access_token'],
			'appId' => $this->_a_config['client_id'],
			'openId' => $s_open_id
		];
		$s_url = 'http://dev.meirenji.cn/api/v2/instance/detail';
		$a_reslut = $this->request($s_url, $a_data);
		return $a_reslut;
	}
	
	// 获取实体天客流数据
	public function get_entity($s_open_id, $date_start, $date_end) {
		$a_data = [
			'access_token' => $this->_a_config['access_token'],
			'appId' => $this->_a_config['client_id'],
			'start' => $date_start,
			'end' => $date_end,
			'openId' => $s_open_id
		];
		$s_url = 'http://dev.meirenji.cn/api/v2/instance/traffic/day';
		$a_reslut = $this->request($s_url, $a_data);
		return $a_reslut;
	}
	
	// 获取设备列表
	public function get_device_list() {
		$a_data = [
			'access_token' => $this->_a_config['access_token'],
			'appId' => $this->_a_config['client_id']
		];
		$s_url = 'http://dev.meirenji.cn/api/v2/devices';
		$a_reslut = $this->request($s_url, $a_data);
		return $a_reslut;
	}
	
	// 获取设备每5分钟时间段的客流数据
	public function get_device($s_open_id, $date_start, $date_end) {
		$a_data = [
			'access_token' => $this->_a_config['access_token'],
			'appId' => $this->_a_config['client_id'],
			'openId' => $s_open_id,
			'start' => $date_start,
			'end' => $date_end,
		];
		$s_url = 'http://dev.meirenji.cn/api/v2/device/traffic/five';
		$a_reslut = $this->request($s_url, $a_data);
		return $a_reslut;
	}
	
	// 发起请求
	public function request($s_url, $a_data) {
		$a_header = ['Content-type: application/x-www-form-urlencoded'];
		$a_data = http_build_query($a_data);
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
		if( is_array($a_header) && ! empty($a_header) ) {
			curl_setopt($o_curl, CURLOPT_HTTPHEADER, $a_header);
		}
	 
		curl_setopt($o_curl, CURLOPT_POST, 1);
		curl_setopt($o_curl, CURLOPT_POSTFIELDS, $a_data);
		$a_result = json_decode(curl_exec($o_curl), true);
		if(empty($a_result)) {
			$a_result['error'] = curl_errno($o_curl);
		}
		curl_close($o_curl);
		return $a_result;
	}
	
	// 设置配置文件名
	public function set_config_file($s_config_file) {
		$this->_s_config_file = $s_config_file;
	}
}
?>