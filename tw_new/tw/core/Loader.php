<?php
defined('BASEPATH') OR exit('禁止访问！');

/**
 * 路由
 */
class TW_Loader {
	
	public function __construct() {
		$this->_autoloader();
		$this->_init_library();
	}
	
	/**
	 * 加载预设自动加载类
	 */
	protected function _autoloader() {
		
	}
	
	/**
	 * 初始化系统核心类库
	 */
	protected function _init_library() {
		$a_core = array('model');
		$this->_load($a_core, 'core');
	}
	
	// 初始化
	public function initialize() {
		
	}
	
	// 对多个类进行实例化
	public function _load($a_class, $directory = 'libraries') {
		foreach ($a_class as $i_var => $s_class) {
			load_class($s_class, $directory);
		}
	}
	
	/**
	 * 加载类库，加载后可以直接使用$this->类名，比如$this->template
	 */
	public function library($s_class, $directory = 'libraries', $param = NULL) {
		$o_instance =& get_instance();
		if (empty($directory)) {
			$directory = 'libraries';
		}
		if ($directory != 'libraries' && $directory != 'core') {
			$directory = 'libraries/' . $directory;
		}
		$o_instance->$s_class =& load_class($s_class, $directory, $param);
	}
	
	/**
	 * 加载模型，加载后可以直接使用$this->类名，比如$this->template
	 */
	public function model($s_class, $param = NULL) {
		$s_class = rtrim($s_class, '/');
		$a_path = explode('/', $s_class);
		$s_path = MODELPATH . '/' . ltrim($s_class, '/');
		
		$s_class = end($a_path);
		$s_path = rtrim($s_path, '/');
		$s_path = rtrim($s_path, $s_class);
		$s_path = rtrim($s_path, '/');
		$o_instance =& get_instance();
		$o_instance->$s_class =& load_class($s_class, $s_path, $param);
	}
	
	/**
	 * 加载共享模型，加载后可以直接使用$this->类名，比如$this->template
	 */
	public function smodel($s_class, $param = NULL) {
		$s_class = rtrim($s_class, '/');
		$a_path = explode('/', $s_class);
		$s_path = SHAREMODELPATH . '/' . ltrim($s_class, '/');
		
		$s_class = end($a_path);
		$s_path = rtrim($s_path, '/');
		$s_path = rtrim($s_path, $s_class);
		$s_path = rtrim($s_path, '/');
		if ( ! defined('SHAREMODELPATH') ) {
			throw '没有定义共享模型常量：SHAREMODELPATH';
		}
		$o_instance =& get_instance();
		$o_instance->$s_class =& load_class($s_class, $s_path, $param);
	}
	
	/**
	 * 加载类库，加载后可以直接使用$this->类名，比如$this->template
	 */
	public function database($s_db) {
		require_once(BASEPATH . 'core/Mysql.php');
		$o_instance =& get_instance();
		$o_instance->$s_db = new TW_Mysql($s_db);
	}
	
	/**
	 * 加载类库，加载后可以直接使用$this->类名，比如$this->template
	 */
	public function config($s_file = NULL, $s_varname = NULL) {
		$o_instance =& get_instance();
		if (file_exists(PROJECTPATH . "/config/config_{$s_file}.php")) {
			include(PROJECTPATH . "/config/config_{$s_file}.php");
		} else {
			$o_instance->error->show_error('配置文件不存在！');
		}
		if (isset($$s_varname)) {
			$o_instance->config[$s_varname] = $$s_varname;
		}
	}
}
?>