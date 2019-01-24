<?php
defined('BASEPATH') OR exit('禁止访问！');
/**
 * 模板类
 * 处理模板中的PHP程序代码
 */
class TW_Template {
	// 模板路径
	private $_s_path = '';
	
	public function __construct() {
		$this->_s_path = TEMPATH . '/';
	}
	
	function __get($key) {
		$TW =& get_instance();
		return $TW->$key;
	}
	
	// 设置模板路径
	public function set_path($s_path) {
		$this->_s_path = $s_path . '/';
	}
	
	/**
	 * $templates 模板路径及文件名
	 * 输出PHP处理后的结果
	 */
	public function display($s_template, Array &$a_data = [], $b_is_html = false, $s_file = NULL) {
		$s_content = $this->get($s_template, $a_data);
		if (get_config_item('is_html') || $b_is_html) {
			if ( ! $this->html($s_content, $s_file) ) {
				$this->error->debug('生成页面失败！');
			}
		} else {
			echo $s_content;
		}
	}
	
	/**
	 * $templates 模板路径及文件名
	 * 返回模板处理好数据后的文本
	 */
	public function get($s_template, Array &$a_view_data = []) {
		$s_template .= '.php';
		// 指定路径模板不存在时，或者模板文件放在WEB要目录时，将被强制使用框架指定的模板目录
		if ( ! file_exists($s_template) || dirname($s_template) == '.') {
			$s_template = $this->_s_path . $s_template;
		}
		
		ob_start();
		eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php echo ', file_get_contents($s_template))));
		$s_content = ob_get_contents();
		ob_end_clean();
		return $s_content;
	}
	
	// 生成静态文件，如果文件名为空，将使用当前访问的文件名
	public function html($s_content, $s_file = NULL) {
		
		if (empty($s_file)) {
			$a_url = $this->router->get_parse_url();
			$s_file = ltrim($a_url['path'], '/');
		}
		$a_path = explode('/', $s_file);
		$s_fname = end($a_path);
		$s_fname = str_replace($s_fname, '', $s_file);
		if (! empty($s_fname) ) {
			$this->create_path($s_fname);
		}
		if (@file_put_contents($s_file, $s_content)) {
			return true;
		}
		return false;
	}
	
	/**
	 * 把字符串按"/"符号创建文件夹
	 * @path 后面不加"/"的路径字符串
	 * @str 用"/"分隔的文件夹字符串，getDateTime('Y/m/d')
	 */
	public function create_path($s_path) {
		$a_path = explode ('/', rtrim($s_path, '/'));
		$s_create_path = '';
		foreach ($a_path as $s_p) {
			$s_create_path .= $s_p;
			if ( ! file_exists($s_create_path) &&  ! in_array($s_p, ['.', '..'])) {
				mkdir($s_create_path) or $this->error->debug('创建文件夹错误');
			}
			$s_create_path .= '/';
		}
		return $s_create_path;
	}
}
?>