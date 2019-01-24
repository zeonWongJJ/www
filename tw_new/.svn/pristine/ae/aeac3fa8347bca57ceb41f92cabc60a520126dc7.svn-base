<?php
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
// 设置当前环境，'development'会报出错误，'formally'不会显示错误信息
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');
if (file_exists('/data/tmp/project_session')) {
	ini_set('session.save_path', '/data/tmp/project_session');
}
ini_set('session.gc_maxlifetime', 86400);
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

function is_mobile_request() {  
	$_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
	$mobile_browser = '0';
	if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
	$mobile_browser++;
	if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))  
	$mobile_browser++;  
	if(isset($_SERVER['HTTP_X_WAP_PROFILE']))  
	$mobile_browser++;  
	if(isset($_SERVER['HTTP_PROFILE']))  
	$mobile_browser++;  
	$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));  
	$mobile_agents = array(  
	'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',  
	'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',  
	'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',  
	'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',  
	'newt','noki','oper','palm','pana','pant','phil','play','port','prox',  
	'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',  
	'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',  
	'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',  
	'wapr','webc','winw','winw','xda','xda-'
	);  
	if(in_array($mobile_ua, $mobile_agents))  
	$mobile_browser++;  
	if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)  
	$mobile_browser++;  
	// Pre-final check to reset everything if the user is on Windows  
	if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)  
	$mobile_browser=0;  
	// But WP7 is also Windows, with a slightly different characteristic  
	if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)  
	$mobile_browser++;  
	if($mobile_browser>0)  
	return true;  
	else
	return false;
}

$s_template_path = 'pc_default';//is_mobile_request() ? 'm_default' : 'pc_default';

// 设置根路径
define('BASEPATH', '../../');
// 应用路径
define('APPPATH', BASEPATH . 'application');
// 项目路径
define('PROJECTPATH', APPPATH . '/project');
// 控制器路径
define('CONTPATH', PROJECTPATH . '/controller');
// 模型路径(为了多项目模型共享)
define('MODELPATH', PROJECTPATH . '/model');
// 模板路径
define('TEMPATH', PROJECTPATH . '/template/' . $s_template_path);
// 系统核心类前缀，不可修改
define('TW_', 'TW_');


/*
 * --------------------------------------------------------------------
 * 加载引导文件
 * --------------------------------------------------------------------
 *
 */
require(BASEPATH . 'core/base.php');