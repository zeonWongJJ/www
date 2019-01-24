<?php
/**
 * 公共函数库
 */

/**
 * 加载类
 */
function &load_class($class, $directory = 'libraries', $param = NULL) {
	static $_classes = array();

	// 如果类已经加载，就直接返回加载的类
	if (isset($_classes[$class])) {
		return $_classes[$class];
	}

	$name = FALSE;
	
	// 直接寻找目录参数下的文件
	if (file_exists("{$directory}/" . ucfirst($class) . '.php')) {
		$name = ucfirst($class);
		if (class_exists($name, FALSE) === FALSE) {
			require_once("{$directory}/" . $name . '.php');
		}
	} else {
		$directory = rtrim(ltrim($directory, '/'), '/');
		if (file_exists(PROJECTPATH . "/{$directory}/" . ucfirst($class) . '.php')) {
			// 如果项目自定义类存在，则加载自定义类
			
			$name = ucfirst($class);
			if (class_exists($name, FALSE) === FALSE) {
				require_once(PROJECTPATH . "/{$directory}/" . $name . '.php');
			}
		} elseif (file_exists(BASEPATH . 'libraries/' . ucfirst($class) . '.php')) {
			// 在核心类库中查找
			
			$name = 'TW_' . ucfirst($class);
			if (class_exists($name, FALSE) === FALSE) {
				require_once(BASEPATH . 'libraries/' . ucfirst($class) . '.php');
			}
		} elseif (file_exists(BASEPATH . 'core/' . ucfirst($class) . '.php')) {
			// 在核心类库中查找
			
			$name = 'TW_' . ucfirst($class);
			if (class_exists($name, FALSE) === FALSE) {
				require_once(BASEPATH . 'core/' . ucfirst($class) . '.php');
			}
		}
	}

	// 如果继承类存在，则加载继承类
	if (file_exists(PROJECTPATH . '/' .$directory . '/' . get_config_item('subclass_prefix') . ucfirst($class) . '.php')) {
		$name = get_config_item('subclass_prefix') . ucfirst($class);
		if (class_exists($name, FALSE) === FALSE) {
			require_once(PROJECTPATH . '/' . $directory . '/' . $name . '.php');
		}
	}

	// 如果类文件不存在
	if ($name === FALSE) {
		// 返回503错误
		echo '不能加载类文件：' . $class . '.php';
		exit;
	}

	if (strtolower($class) == 'mysql') {
		$class = 'db';
	}
	is_loaded($class);
	
	$_classes[$class] = ($param !== NULL) ? new $name(...$param) : new $name();
	return $_classes[$class];
}

/**
 * 获取单个配置项
 */
function get_config_item($item) {
	static $_config;
	if (empty($_config)) {
		// 导入配置文件数据
		$_config =& get_config();
	}

	return isset($_config[$item]) ? $_config[$item] : NULL;
}

/**
 * 获取配置变量
 * Array $replace 参数类型限定为数组
 */
function &get_config(Array $a_replace = array()) {
	static $a_system_config;
	if (empty($a_system_config)) {
		$file_path = PROJECTPATH . '/config/config_system.php';
		if (file_exists($file_path)) {
			require($file_path);
		} else {
			exit('配置文件不存在！');
		}
		// 配置信息是否存在
		if ( ! isset($a_system_config) OR ! is_array($a_system_config)) {
			exit('配置信息不存在！');
		}
	}
	// 添加配置变量，或更新配置变量
	foreach ($a_replace as $key => $val) {
		$a_system_config[$key] = $val;
	}
	return $a_system_config;
}


// 返回 web 服务器和 PHP 之间的接口类型
function is_cli() {
	return (PHP_SAPI === 'cli' OR defined('STDIN'));
}

/**
 * 记录已加载的类
 */
function &is_loaded($class = '') {
	static $_is_loaded = array();
	if ($class !== '') {
		$_is_loaded[strtolower($class)] = $class;
	}
	return $_is_loaded;
}

// 获取实例
function &get_instance() {
	return TW_Controller::get_instance();
}

// 调用计划执行函数
function tw_plan($s_plan) {
	// 加载计划配置文件
	if (file_exists(PROJECTPATH . '/config/config_plan.php')) {
		require(PROJECTPATH . '/config/config_plan.php');
	}
	if (isset($a_config_plan[$s_plan])) {
		// 判断是数组还是匿名函数
		if (is_array($a_config_plan[$s_plan])) {
			// 判断是否是多维数组
			if (count($a_config_plan[$s_plan])) {
				foreach ($a_config_plan[$s_plan] as $u_plan) {
					// 按数组方式执行
					if (is_array($u_plan)) {
						// 实例化类
						if (empty($u_plan['param_class'])) {
							$o_plan =& load_class($u_plan['class'], $u_plan['filepath']);
						} else {
							$o_plan =& load_class($u_plan['class'], $u_plan['filepath'], $u_plan['param_class']);
						}
						// 可变函数不能使用数组类型
						$s_method = $u_plan['method'];
						// 调用方法
						if (empty($u_plan['param_method'])) {
							$o_plan->$s_method();
						} else {
							$o_plan->$s_method(...$u_plan['param_method']);
						}
					} elseif (is_object($u_plan)) {
						// 按lambda 匿名函数执行
						$u_plan();
					}
				}
			}
		} elseif(is_object($a_config_plan[$s_plan])) {
			// 可变函数不能使用数组类型，所以先赋值到普通变量中
			$s_lambda = $a_config_plan[$s_plan];
			// 按lambda 匿名函数执行
			$s_lambda();
		}
	}
}
?>