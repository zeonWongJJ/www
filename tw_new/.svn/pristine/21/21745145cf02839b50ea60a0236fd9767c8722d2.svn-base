<?php
// 微信分享接口 https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141115
// app分享接口 https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list&t=resource/res_list&verify=1&id=open1419319164&lang=zh_CN
class TW_wx_share {
	private $_s_appid = '';
	private $_s_app_secret = '';
	private $_s_config_file = 'config_wxshare';
	// 配置参数
	private $_a_config = [];

	public function __construct($s_appid = NULL, $s_app_secret = NULL) {
		$this->appId = $s_appid;
		$this->appSecret = $s_app_secret;
		
		if (empty($this->appId) || empty($this->appSecret)) {
			$this->_config();
		}
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
			require(BASEPATH . "libraries/pay/wxshare/{$this->_s_config_file}.php");
		}
		$this->_s_appid = $a_config_wxshare['app_id'];
		$this->_s_app_secret = $a_config_wxshare['app_secret'];
		$this->_a_config = $a_config_wxshare;
		$this->access_token();
		$this->jsapi_ticket();
	}
	
	// 获取token
	public function access_token() {
		if ($_SERVER['REQUEST_TIME'] >= $this->_a_config['expires_in_token']) {
			// 如果是企业号用以下URL获取access_token
			// $s_url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
			$s_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->_s_appid}&secret={$this->_s_app_secret}";
			$a_result = $this->request($s_url);
			
			if (isset($a_result['access_token']) && ! empty($a_result['access_token'])) {
				if (file_exists(PROJECTPATH . "/config/{$this->_s_config_file}.php")) {
					require(PROJECTPATH . "/config/{$this->_s_config_file}.php");
				} else {
					exit('配置文件不存在');
				}
				$this->_a_config['access_token'] = $a_result['access_token'];
				$this->_a_config['expires_in_token'] = $_SERVER['REQUEST_TIME'] + $a_result['expires_in'];
				$s_str = '<?php' . PHP_EOL . '$a_config_wxshare = [' . PHP_EOL;
				foreach ($this->_a_config as $s_k => $m_u) {
					$s_str .= "\t'{$s_k}' => '{$m_u}'," . PHP_EOL;
				}
				$s_str .= ']' . PHP_EOL . '?>';
				file_put_contents(PROJECTPATH . "/config/{$this->_s_config_file}.php", $s_str);
			}
		}
	}
	
	// 获取jsapi_ticket
	public function jsapi_ticket() {
		if ($_SERVER['REQUEST_TIME'] >= $this->_a_config['expires_in_ticket']) {
			// 如果是企业号用以下 URL 获取 ticket
			// $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
			$s_url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token={$this->_a_config['access_token']}";
			$a_result = $this->request($s_url);
			if (isset($a_result['errcode']) && $a_result['errcode'] == 0) {
				$this->_a_config['ticket'] = $a_result['ticket'];
				$this->_a_config['expires_in_ticket'] = $_SERVER['REQUEST_TIME'] + $a_result['expires_in'];
				$s_str = '<?php' . PHP_EOL . '$a_config_wxshare = [' . PHP_EOL;
					foreach ($this->_a_config as $s_k => $m_u) {
					$s_str .= "\t'{$s_k}' => '{$m_u}'," . PHP_EOL;
				}
				$s_str .= ']' . PHP_EOL . '?>';
				file_put_contents(PROJECTPATH . "/config/{$this->_s_config_file}.php", $s_str);
			}
		}
	}
	
	// 发起请求
	public function request($s_url) {
		$a_header = ['Content-type: application/x-www-form-urlencoded'];
		//$a_data = http_build_query($a_data);
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
	 
		//curl_setopt($o_curl, CURLOPT_POST, 1);
		//curl_setopt($o_curl, CURLOPT_POSTFIELDS, $a_data);
		$a_result = json_decode(curl_exec($o_curl), true);
		if(empty($a_result)) {
			$a_result['error'] = curl_errno($o_curl);
		}
		curl_close($o_curl);
		return $a_result;
	}
	
	// 生成随机字符串
	public function nonce_str($i_length = 16) {
		$s_char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$s_str = '';
		for ($i_i = 0; $i_i < $i_length; $i_i++) {
			$s_str .= substr($s_char, mt_rand(0, strlen($s_char) - 1), 1);
		}
		return $s_str;
	}
	
	// 签名参数
	public function signature() {
		// 注意 URL 一定要动态获取，不能 hardcode.
		$s_protocol = ( ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$s_url = "{$s_protocol}{$_SERVER[HTTP_HOST]}{$_SERVER[REQUEST_URI]}";
		$s_nonce_str = $this->nonce_str();
		$s_time = $_SERVER['REQUEST_TIME'];
		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$s_signature = "jsapi_ticket={$this->_a_config['ticket']}&noncestr={$s_nonce_str}&timestamp={$s_time}&url={$s_url}";
		$s_signature = sha1($s_signature);

		$a_signature = array(
			'appid'  => $this->_s_appid,
			'nonce_str' => $s_nonce_str,
			'timestamp' => $s_time,
			'url' => $s_url,
			'signature' => $s_signature
		);
		return $a_signature;
	}
	
	// 签名参数
	public function js_code($a_data) {
		$a_signature = $this->signature();
		$s_code = '<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>' . PHP_EOL;
		$s_code .= "<script>
			wx.config({
				debug: false,
				appId: '{$a_signature['appid']}',
				timestamp: {$a_signature['timestamp']},
				nonceStr: '{$a_signature['nonce_str']}',
				signature: '{$a_signature['signature']}',
				jsApiList: [
					'onMenuShareTimeline', 'onMenuShareAppMessage'
				]
			});
			wx.ready(function() {
				wx.onMenuShareTimeline({
					title: '{$a_data['title']}',
					link: '{$a_data['link']}',
					imgUrl: '{$a_data['img']}',
					success: function() {
						// 用户确认分享后执行的回调函数
					},
					cancel: function() {
						// 用户取消分享后执行的回调函数
					}
				});
			});
			wx.onMenuShareAppMessage({
				title: '{$a_data['title']}', // 分享标题
				desc: '健康生活', // 分享描述
				link: '{$a_data['link']}', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
				imgUrl: '{$a_data['img']}', // 分享图标
				type: 'link', // 分享类型,music、video或link，不填默认为link
				dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
				success: function () {
					// 用户确认分享后执行的回调函数
				},
				cancel: function () {
					// 用户取消分享后执行的回调函数
				}
			});
		</script>";
		return $s_code;
	}
}
?>