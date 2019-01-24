<?php
static $a_router = [
	// 首页
	'index' => [
		'class' => 'Home',
		'method' => 'index'
	],
	// 清空所有表
	'clear' => [
		'class' => 'Home',
		'method' => 'clear'
	],
	// 注册
	'register' => [
		'class' => 'User',
		'method' => 'register'
	],
	// 登录
	'login' => [
		'class' => 'User',
		'method' => 'login'
	],
	// 注销
	'logout' => [
		'class' => 'User',
		'method' => 'logout'
	],
	// 项目列表
	'project_list' => [
		'class' => 'Project',
		'method' => 'list'
	],
	// 项目列表
	'project_add' => [
		'class' => 'Project',
		'method' => 'add'
	],
	// 任务组列表
	'task_group_list' => [
		'class' => 'Task_group',
		'method' => 'list'
	],
	// 添加任务组
	'task_group_add' => [
		'class' => 'Task_group',
		'method' => 'add'
	],
	// 获取json任务组数据
	'get_task_group' => [
		'class' => 'Task_group',
		'method' => 'get_task_group'
	],
	// 任务列表
	'task_list' => [
		'class' => 'Task',
		'method' => 'list'
	],
	// 全部任务
	'task_all' => [
		'class' => 'Task',
		'method' => 'task_all'
	],
	// 发表未完成
	'publish_not' => [
		'class' => 'Task',
		'method' => 'publish_not'
	],
	// 发表已完成
	'publish_finsh' => [
		'class' => 'Task',
		'method' => 'publish_finsh'
	],
	// 参与未完成
	'partake_not' => [
		'class' => 'Task',
		'method' => 'partake_not'
	],
	// 参与已完成
	'partake_finsh' => [
		'class' => 'Task',
		'method' => 'partake_finsh'
	],
	// 等待接手
	'task_wait' => [
		'class' => 'Task',
		'method' => 'task_wait'
	],
	// 添加任务
	'task_add' => [
		'class' => 'Task',
		'method' => 'add'
	],
	// 任务详情
	'task_detail' => [
		'class' => 'Task',
		'method' => 'detail'
	],
	// 任务主页
	'task_home' => [
		'class' => 'Task',
		'method' => 'home'
	],
	// 添加问题
	'question_add' => [
		'class' => 'Task',
		'method' => 'question_add'
	],
	// 添加程序
	'procedure_add' => [
		'class' => 'Procedure',
		'method' => 'add'
	],
	// 添加动作
	'action_add' => [
		'class' => 'Action',
		'method' => 'add'
	],
	// 自定义通知
	'notice_custom' => [
		'class' => 'Notice',
		'method' => 'custom'
	],
	// 通知列表
	'notice_sent' => [
		'class' => 'Notice',
		'method' => 'sent'
	],
	// 通知列表
	'notice_receive' => [
		'class' => 'Notice',
		'method' => 'receive'
	],
	// 修改通知状态
	'notice_update_state' => [
		'class' => 'Notice',
		'method' => 'update_state'
	],
	// 修改通知状态
	'notice_get_last' => [
		'class' => 'Notice',
		'method' => 'get_last'
	],
	
	
	
	// 获取微信的code，准备获取授权码用
	'get_code' => [
		'class' => 'Weixin',
		'method' => 'get_code'
	],
	// 绑定微信
	'binding' => [
		'class' => 'Weixin',
		'method' => 'binding'
	],
	// 发送微信模板消息
	'template_msg_send' => [
		'class' => 'Weixin',
		'method' => 'template_msg_send'
	],
	
];
?>