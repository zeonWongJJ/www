<?php
static $a_router = [
    //  登录
	'login' => [
		'class' => 'Home',
		'method' => 'login'
	],	
		
	'login_but' => [
		'class' => 'Home',
		'method' => 'login_but'
	],
	//通用
	'header' => [
		'class' => 'Home',
		'method' => 'header'
	],
	//首页
	'index' => [
		'class' => 'Home',
		'method' => 'index'
	],
	//详情页
	'details' => [
		'class' => 'Home',
		'method' => 'details'
	],
	// 考核
	'check' => [
		'class' => 'Home',
		'method' => 'check'
	],
	// 考核
	'check_butr' => [
		'class' => 'Home',
		'method' => 'check_butr'
	],
	// 客服填写
	'write' => [
		'class' => 'Home',
		'method' => 'write'
	],
	// 编辑填写
	'redact' => [
		'class' => 'Home',
		'method' => 'redact'
	],
	// 技术填写
	'science' => [
		'class' => 'Home',
		'method' => 'science'
	],
	// 任务列表
	'tasks' => [
		'class' => 'Home',
		'method' => 'tasks'
	],
	// 发表任务
	'task' => [
		'class' => 'Home',
		'method' => 'task'
	],
	// 任务修改
	'taskde' => [
		'class' => 'Home',
		'method' => 'taskde'
	],
	'taskdel' => [
		'class' => 'Home',
		'method' => 'taskdel'
	],
	//任务完成
	'task_accomplish' => [
		'class' => 'Home',
		'method' => 'task_accomplish'
	],
	//任务完成触发
	'task_acco' => [
		'class' => 'Home',
		'method' => 'task_acco'
	],
	// 设置
	'setting' => [
		'class' => 'Home',
		'method' => 'setting'
	],

	// 退出登录
	'logout' => [
		'class' => 'Home',
		'method' => 'logout'
	],
	//定时考核
	'test' => [
		'class' => 'Home',
		'method' => 'test'
	],
];
?>