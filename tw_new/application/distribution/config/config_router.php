<?php
static $a_router = [
	// 首页
	'index' => [
		'class' => 'Home',
		'method' => 'index'
	],
	// 添加订单
	'add' => [
		'class' => 'Api',
		'method' => 'add'
	],
	// 查询订单
	'query' => [
		'class' => 'Api',
		'method' => 'query'
	],
	// 取消订单
	'cancel' => [
		'class' => 'Api',
		'method' => 'cancel'
	],
	// 达达配送通知
	'notify_dada' => [
		'class' => 'Notify',
		'method' => 'dada'
	],
];
?>