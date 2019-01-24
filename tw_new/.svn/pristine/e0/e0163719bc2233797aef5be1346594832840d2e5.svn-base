<?php
/**
 * 显示报错信息
 */
class TW_Error {
	
	public function __construct() {
		$this->db =& load_class('mysql', 'core');
		$this->view =& load_class('template', 'core');
		$this->log =& load_class('log', 'core');
	}
	
	/**
	 * header报错信息
	 */
	static public function header_status($code = 200, $text = '') {
		if (is_cli()) {
			return;
		}
		if (empty($code) OR ! is_numeric($code)) {
			throw new Exception('错误代码异常！');
		}
		if (empty($text)) {
			is_int($code) OR $code = (int) $code;
			$status = array(
				200	=> '正常',
				201	=> 'Created',
				202	=> 'Accepted',
				203	=> 'Non-Authoritative Information',
				204	=> 'No Content',
				205	=> 'Reset Content',
				206	=> 'Partial Content',

				300	=> 'Multiple Choices',
				301	=> '永久转移',
				302	=> '临时转移',
				303	=> 'See Other',
				304	=> 'Not Modified',
				305	=> 'Use Proxy',
				307	=> 'Temporary Redirect',

				400	=> 'Bad Request',
				401	=> 'Unauthorized',
				403	=> 'Forbidden',
				404	=> '页面不存在',
				405	=> 'Method Not Allowed',
				406	=> 'Not Acceptable',
				407	=> 'Proxy Authentication Required',
				408	=> 'Request Timeout',
				409	=> 'Conflict',
				410	=> 'Gone',
				411	=> 'Length Required',
				412	=> 'Precondition Failed',
				413	=> 'Request Entity Too Large',
				414	=> 'Request-URI Too Long',
				415	=> 'Unsupported Media Type',
				416	=> 'Requested Range Not Satisfiable',
				417	=> 'Expectation Failed',
				422	=> 'Unprocessable Entity',

				500	=> 'Internal Server Error',
				501	=> 'Not Implemented',
				502	=> '网关错误',
				503	=> 'Service Unavailable',
				504	=> 'Gateway Timeout',
				505	=> 'HTTP Version Not Supported'
			);
			if (isset($status[$code])) {
				$text = $status[$code];
			} else {
				throw new Exception('找不到对应的错误代码！');
			}
		}
		if (strpos(PHP_SAPI, 'cgi') === 0) {
			header('Status: ' . $code . ' ' . $text, TRUE);
		} else {
			$server_protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
			header($server_protocol . ' ' . $code . ' ' . $text, TRUE, $code);
		}
	}
	
	// 显示调试信息，正式环境记录到数据库
	static public function debug($error, $b_is_exit = TRUE, $b_log = TRUE) {
		if (ENVIRONMENT == 'development' || $b_log) {
			@file_put_contents(APPPATH . '/debug.php', $error . PHP_EOL, FILE_APPEND);
		}
		// 是否终止程序
		if ($b_is_exit) {
			exit($error);
		}
	}
	
	// 页面不存在
	static public function show_404($a_parameter = '') {
		SELF :: header_status(404);
		if ($b_log) {
			global $o_mysql, $o_router, $o_general;
			if ( ! is_object($o_mysql)) {
				// 加载数据库
				$o_mysql =& load_class('mysql', 'core');
			}
			if ( ! is_object($o_general)) {
				// 载入常用类
				$o_general =& load_class('general', 'core');
			}
			SELF :: create_table();
			$i_uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;
			$o_mysql->insert('error', ['recode' => '404页面不存在！', 'type' => 2, 'url' => $o_router->get_url(), 'ip' => $o_general->get_ip(), 'uid' => $i_uid, 'time' => $_SERVER['REQUEST_TIME']]);
		}
		$o_view =& load_class('template', 'core');
		
		if ( ! is_array($a_parameter)) {
			$a_parameter = [
				'log' => true,
				'wait' => 5
			];
		}
		if (isset($a_parameter['template']) && file_exists(TEMPATH . '/' . $a_parameter['template'] . '.php')) {
			$o_view->display(TEMPATH . '/' . $a_parameter['template'], $a_parameter);
		} else {
			$o_view->display(BASEPATH . 'libraries/error/404', $a_parameter);
		}
		exit();
	}
	
	// 显示错误信息，比如操作失败
	public function show_error($a_parameter = '', $s_url = '', $b_log = false, $i_wait = 5) {
		if ( ! is_array($a_parameter)) {
			$a_parameter = [
				'msg' => $a_parameter,
				'url' => $s_url,
				'log' => $b_log,
				'wait' => $i_wait
			];
		}
		$a_parameter['type'] = 'error';
		$a_parameter = $this->_parameter($a_parameter);
		if ($a_parameter['log']) {
			$this->log->record($a_parameter['msg'], 11, $a_parameter['url']);
		}
		
		// 如果等待时间为0秒，则直接跳转，无须经过html跳转，这样更为快捷
		$this->_location($s_url, $a_parameter['wait']);
		
		if (isset($a_parameter['template']) && file_exists(TEMPATH . '/' . $a_parameter['template'] . '.php')) {
			$this->view->display(TEMPATH . '/' . $a_parameter['template'], $a_parameter);
		} else {
			$this->view->display(BASEPATH . 'libraries/error/remind', $a_parameter);
		}
		exit;
	}
	
	// 显示警告信息，比如用户输入非法内容
	public function show_warning($a_parameter = '', $s_url = '', $b_log = false, $i_wait = 5) {
		if ( ! is_array($a_parameter)) {
			$a_parameter = [
				'msg' => $a_parameter,
				'url' => $s_url,
				'log' => $b_log,
				'wait' => $i_wait
			];
		}
		$a_parameter['type'] = 'warning';
		$a_parameter = $this->_parameter($a_parameter);
		if ($a_parameter['log']) {
			$this->log->record($a_parameter['msg'], 12, $a_parameter['url']);
		}
		
		// 如果等待时间为0秒，则直接跳转，无须经过html跳转，这样更为快捷
		$this->_location($s_url, $a_parameter['wait']);
		
		if (isset($a_parameter['template']) && file_exists(TEMPATH . '/' . $a_parameter['template'] . '.php')) {
			$this->view->display(TEMPATH . '/' . $a_parameter['template'], $a_parameter);
		} else {
			$this->view->display(BASEPATH . 'libraries/error/remind', $a_parameter);
		}
		exit;
	}
	
	// 显示提醒信息，比如后台正在处理中
	public function show_remind($a_parameter = '', $s_url = '', $b_log = false, $i_wait = 5) {
		if ( ! is_array($a_parameter)) {
			$a_parameter = [
				'msg' => $a_parameter,
				'url' => $s_url,
				'log' => $b_log,
				'wait' => $i_wait
			];
		}
		$a_parameter['type'] = 'remind';
		$a_parameter = $this->_parameter($a_parameter);
		if ($a_parameter['log']) {
			$this->log->record($a_parameter['msg'], 13, $a_parameter['url']);
		}
		
		// 如果等待时间为0秒，则直接跳转，无须经过html跳转，这样更为快捷
		$this->_location($s_url, $a_parameter['wait']);
		
		if (isset($a_parameter['template']) && file_exists(TEMPATH . '/' . $a_parameter['template'] . '.php')) {
			$this->view->display(TEMPATH . '/' . $a_parameter['template'], $a_parameter);
		} else {
			$this->view->display(BASEPATH . 'libraries/error/remind', $a_parameter);
		}
		exit;
	}
	
	// 显示操作成功信息
	public function show_success($a_parameter = '', $s_url = '', $b_log = false, $i_wait = 5) {
		
		if ( ! is_array($a_parameter)) {
			$a_parameter = [
				'msg' => $a_parameter,
				'url' => $s_url,
				'log' => $b_log,
				'wait' => $i_wait
			];
		}
		$a_parameter['type'] = 'success';
		$a_parameter = $this->_parameter($a_parameter);
		if ($a_parameter['log']) {
			$this->log->record($a_parameter['msg'], 14, $a_parameter['url']);
		}
		
		// 如果等待时间为0秒，则直接跳转，无须经过html跳转，这样更为快捷
		$this->_location($s_url, $a_parameter['wait']);
		
		if (isset($a_parameter['template']) && file_exists(TEMPATH . '/' . $a_parameter['template'] . '.php')) {
			$this->view->display(TEMPATH . '/' . $a_parameter['template'], $a_parameter);
		} else {
			$this->view->display(BASEPATH . 'libraries/error/remind', $a_parameter);
		}
		exit;
	}
	
	// 立即跳转，公用
	public function location($s_url = '') {
		$s_url = empty($s_url) ? (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/') : $s_url;
		header('Location: ' . $s_url);
		exit();
	}
	
	// 立即跳转，私用
	private function _location($s_url = '', $i_wait = 0) {
		if ( ! is_numeric($i_wait) || $i_wait <= 0) {
			$this->location($s_url);
		}
	}
	
	// 参数处理
	private function _parameter($a_parameter = []) {
		$_a_parameter = [
			'msg' => '',
			'url' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/',
			'wait' => 5,
			'log' => false,
			'type' => 1
		];
		foreach ($_a_parameter as $s_key => $u_val) {
			if ( ! isset($a_parameter[$s_key]) ) {
				$a_parameter[$s_key] = $u_val;
			}
		}
		return $a_parameter;
	}
	
	// 创建错误记录表
	static public function create_table() {
		$o_mysql =& load_class('mysql', 'core');
		$s_sql = "CREATE TABLE IF NOT EXISTS `" . $o_mysql->get_prefix('error') . "` (
		  `eid` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `recode` varchar(1000) NOT NULL COMMENT '错误详情',
		  `type` tinyint(3) unsigned NOT NULL COMMENT '1为调试，2为404页面不存在，11为错误，12为警告，13为提醒，14为成功，15为常规操作',
		  `url` varchar(100) NOT NULL DEFAULT '''''' COMMENT '出错的URL',
		  `ip` varchar(30) NOT NULL COMMENT '操作人的IP',
		  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '如果有登录，记录用户ID',
		  `time` int(10) unsigned NOT NULL COMMENT '出错时间',
		  PRIMARY KEY (`eid`)
		) ENGINE=MYISAM  DEFAULT CHARSET=utf8 COMMENT='错误记录'";
		
		$o_mysql->query($s_sql);
	}
}
?>