<?php
defined('BASEPATH') OR exit('禁止访问！');

/**
 * 路由器
 */
class TW_Router {

	public $_s_class = ''; // 类名
	public $_s_method = ''; // 方法名
	private $_s_router_index = 'index'; // 当前URL文件名
	private $_a_url_params = []; // 保存URL参数
	private $_s_url = ''; // 当前访问的URL
	private $_a_parse_url = []; // 保存当前访问的URL的语法结构数组
	public $_s_ctrl_path = ''; // 保存控制器路径

	public function __construct() {
		$this->_s_url = get_config_item('domain') . $_SERVER['REQUEST_URI'];
		$this->_a_parse_url = parse_url($_SERVER['REQUEST_URI']);
		$a_params = explode('/', $this->_a_parse_url['path']);
		for ($i = 0; $i < count($a_params) - 1; $i++) {
			if ( ! empty($a_params[$i]) ) {
				$this->_s_ctrl_path .= '/' . $a_params[$i];
			}
		}
		$s_params = preg_replace("/\.html$/is", '', end($a_params));
		$this->_a_url_params = explode('-', $s_params);
		$this->_s_router_index = isset($this->_a_url_params[0]) && ! empty($this->_a_url_params[0]) ? $this->_a_url_params[0] : 'index';
		$this->get_router();
	}

	/**
	 * 定义路由规则
	 */
	protected function &_rule() {
		require_once(PROJECTPATH . '/config/config_router.php');
		return $a_router;
	}

	/**
	 * 获取当前路由对应的类名和方法名
	 */
	public function get_router() {
		$a_rule =& $this->_rule();
		foreach ($a_rule as $i_key => $a_val) {
			if ($i_key == $this->_s_router_index) {
				$this->_s_class = ucfirst($a_rule[$i_key]['class']) . '_ctrl';
				$this->_s_method = $a_rule[$i_key]['method'];
				return $a_rule[$i_key];
			}
		}

		return false;
	}

	/**
	 * 获取URL传值参数
	 * 第一个参数，即传入1获取，余下类推
	 */
	public function get($i_num) {
		if (isset($this->_a_url_params[$i_num])) {
			return $this->_a_url_params[$i_num];
		}
		return false;
	}

	// 返回当前 URL
	public function get_url() {
		return $this->_s_url;
	}

	// 解析当前URL，返回关联数组
	public function get_parse_url($s_url = '') {
		if (empty($s_url)) {
			return $this->_a_parse_url;
		}
		return parse_url($s_url);
	}

	// 构建URL
	public function url($s_index, $a_params = [], $b_is_code = false, $b_suffix = true) {
		$s_url = get_config_item('domain') . '/' . $s_index;
		foreach ($a_params as $s_key => $u_val) {
			$s_url .= "-{$u_val}";
		}
		if ($b_suffix) {
			$s_url .= '.html';
		}
		if ($b_is_code) {
			return urlencode($s_url);
		}
		return $s_url;
	}

	// 获取当前索引
	public function get_index() {
		return $this->_s_router_index;
	}

	// 获取当前控制器名
	public function get_controller() {
		return $this->_s_class;
	}

	// 获取当前方法名
	public function get_method() {
		return $this->_s_method;
	}
}
