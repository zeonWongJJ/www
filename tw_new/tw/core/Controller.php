<?php
/**
 * 控制器
 */
class TW_Controller {

	// 存储整个系统为一个大的对象
	private static $o_instance;

	public function __construct() {
		self::$o_instance =& $this;

		// 初始化类库
		// 把加载的类库放进this对象中
		foreach (is_loaded() as $var => $class) {
			$this->$var =& load_class($class);
		}
		
		if (isset($this->template)) {
			$this->view =& $this->template;
		}

		$this->load =& load_class('Loader', 'core');
		//$this->load->initialize();
		
		$this->config =& get_config();
		
		// 执行计划 pre_controller
		tw_plan('pre_controller');
	}

	// --------------------------------------------------------------------

	/**
	 * 获取系统对象
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance() {
		return self::$o_instance;
	}
}
