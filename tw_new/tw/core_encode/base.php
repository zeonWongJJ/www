<?php
defined('BASEPATH') OR exit('禁止访问！');

// 开户会话
session_start();

require(BASEPATH . 'core/Controller.php');
require(BASEPATH . 'core/Common.php');

// 载入路由类
$o_router =& load_class('router', 'core');
// 载入错误类
$o_error =& load_class('error', 'core');
// 载入日志类
$o_log =& load_class('log', 'core');
// 载入安全类
$o_security =& load_class('security', 'core');
// 载入常用类
$o_general =& load_class('general', 'core');
// 加载模板类
$o_view =& load_class('template', 'core');
// 加载数据库
$o_mysql =& load_class('mysql', 'core');

// 执行计划 pre_system
tw_plan('pre_system');
// 加载控制器文件
if (file_exists(PROJECTPATH . "/controller{$o_router->_s_ctrl_path}/{$o_router->_s_class}.php")) {
	require(PROJECTPATH . "/controller{$o_router->_s_ctrl_path}/{$o_router->_s_class}.php");
} else {
	TW_Error :: show_404();
}

$class_name_explode = explode('/',  $o_router->_s_class);
if (count($class_name_explode) > 1) {
    $class_name = '\\controller\\' . lcfirst($class_name_explode[0]) . '\\' . end($class_name_explode);
} else {
    $class_name = $o_router->_s_class;
}

// 开始运行程序
$TW = new $class_name();
call_user_func_array(array(&$TW, $o_router->_s_method), []);

// 执行计划 post_controller
tw_plan('post_system');
