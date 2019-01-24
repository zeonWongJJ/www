<?php
header("Content-type: text/html; charset=utf-8");
// 设置当前环境，'development'会报出错误，'formally'不会显示错误信息
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

/*
 *---------------------------------------------------------------
 * 错误报告设置
 */
switch (ENVIRONMENT) {
	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
		break;
	case 'formally':
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>=')) {
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		} else {
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		}
		break;
	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo '当前环境无法正常运行！';
		exit();
}

// 设置根路径
define('BASEPATH', '../../');
// 应用路径
define('APPPATH', BASEPATH . 'application');
// 项目路径
define('PROJECTPATH', APPPATH . '/sample');
// 控制器路径
define('CONTPATH', PROJECTPATH . '/controller');
// 模型路径(为了多项目模型共享)
define('MODELPATH', PROJECTPATH . '/model');
// 模板路径
define('TEMPATH', PROJECTPATH . '/template');
// 系统核心类前缀，不可修改
define('TW_', 'TW_');


/*
 * --------------------------------------------------------------------
 * 加载引导文件
 * --------------------------------------------------------------------
 *
 */
require(BASEPATH . 'core/base.php');