<?php
static $a_router = [
	// 登录
	'login' => [
		'class' => 'Login',
		'method' => 'login'
	],
	//退出登录
	'loginout' => [
		'class' => 'Login',
		'method' => 'loginout'
	],

	//管理员列表
	'admin_showlist' => [
		'class' => 'Admin',
		'method' => 'admin_showlist'
	],
	//添加管理员
	'admin_add' => [
		'class' => 'Admin',
		'method' => 'admin_add'
	],
	//删除管理员
	'admin_delete' => [
		'class' => 'Admin',
		'method' => 'admin_delete'
	],
	//修改管理员信息
	'admin_update' => [
		'class' => 'Admin',
		'method' => 'admin_update'
	],

	//权限列表
	'auth_showlist' => [
		'class' => 'Auth',
		'method' => 'auth_showlist'
	],
	//添加权限
	'auth_add' => [
		'class' => 'Auth',
		'method' => 'auth_add'
	],
	//删除权限
	'auth_delete' => [
		'class' => 'Auth',
		'method' => 'auth_delete'
	],
	//修改权限
	'auth_update' => [
		'class' => 'Auth',
		'method' => 'auth_update'
	],

	//角色列表
	'role_showlist' => [
		'class' => 'Role',
		'method' => 'role_showlist'
	],
	//给角色分配权限[修改角色]
	'role_distribute' => [
		'class' => 'Role',
		'method' => 'role_distribute'
	],
	//添加角色
	'role_add' => [
		'class' => 'Role',
		'method' => 'role_add'
	],
	//删除角色
	'role_delete' => [
		'class' => 'Role',
		'method' => 'role_delete'
	],

	//会员列表
	'user_showlist' => [
		'class' => 'User',
		'method' => 'user_showlist'
	],
	//修改会员资料
	'user_update' => [
		'class' => 'User',
		'method' => 'user_update'
	],
	//删除某个会员
	'user_delete' => [
		'class' => 'User',
		'method' => 'user_delete'
	],


];

?>