<?php
static $a_router = [
	// 首页
	'index' => [
		'class' => 'Home',
		'method' => 'index'
	],
	// 登录
	'login' => [
		'class' => 'Home',
		'method' => 'login'
	],
	// 登录默认页面
	'waits' => [
		'class' => 'Waits',
		'method' => 'waits'
	],
	// 退出
	'logout' => [
		'class' => 'Home',
		'method' => 'logout'
	],
	// 添加到购物车
	'cart_add' => [
		'class' => 'Cart',
		'method' => 'cart_add'
	],
	// 同步显示购物车
	'cart_list' => [
		'class' => 'Sync',
		'method' => 'cart_list'
	],
	// 输出当前购物车数据
	'cart_data' => [
		'class' => 'Cart',
		'method' => 'cart_data'
	],
	// 增加或减少数量
	'cart_add_subtract' => [
		'class' => 'Cart',
		'method' => 'cart_add_subtract'
	],
	// 默认等待页面
	'wait' => [
		'class' => 'Sync',
		'method' => 'wait'
	],
	// 保存订单
	'create_order' => [
		'class' => 'Cart',
		'method' => 'create_order'
	],
	// 支付
	'pay' => [
		'class' => 'Cart',
		'method' => 'pay'
	],
	// 手动确认支付成功，默认记录为现金支付
	'pay_finsh' => [
		'class' => 'Cart',
		'method' => 'pay_finsh'
	],
	// 手动取消支付
	'pay_cancel' => [
		'class' => 'Cart',
		'method' => 'pay_cancel'
	],
	// 设置用户id
	'set_order_member' => [
		'class' => 'Cart',
		'method' => 'set_order_member'
	],
	// 生成二维码
	'qrcode' => [
		'class' => 'Cart',
		'method' => 'qrcode'
	],
	// 微信异步通知
	'notify_wx' => [
		'class' => 'Sync',
		'method' => 'notify_wx'
	],
	// 现金支付
	'pay_money' => [
		'class' => 'Cart',
		'method' => 'pay_money'
	],
	// 支付宝支付
	'pay_alipay' => [
		'class' => 'Cart',
		'method' => 'pay_alipay'
	],
	// 微信支付
	'pay_weixin' => [
		'class' => 'Cart',
		'method' => 'pay_weixin'
	],
	// 轮询支付结果
	'pay_result' => [
		'class' => 'Cart',
		'method' => 'pay_result'
	],
	// 最新消息
	'msg_show' => [
		'class' => 'Msg',
		'method' => 'msg_show'
	],
	//附近订单
	'order_new' => [
		'class' => 'Order',
		'method' => 'order_new'
	],
	//附近订单
	'order_new_lise' => [
		'class' => 'Order',
		'method' => 'order_new_lise'
	],
	// 线下订单
	'order_list' => [
		'class' => 'Order',
		'method' => 'order_list'
	],
	// 线上订单
	'order_online' => [
		'class' => 'Order',
		'method' => 'order_online'
	],
	// 订单详细
	'order_detail' => [
		'class' => 'Order',
		'method' => 'order_detail'
	],
	// 取消订单
	'order_cancel' => [
		'class' => 'Order',
		'method' => 'order_cancel'
	],
	// 查询最新订单和最新消息
	'new_msg_order' => [
		'class' => 'Msg',
		'method' => 'new_msg_order'
	],
	// 抢单
	'order_rob' => [
		'class' => 'Order',
		'method' => 'order_rob'
	],
	// 接单
	'order_receive' => [
		'class' => 'Order',
		'method' => 'order_receive'
	],
	// 订单完成
	'order_complete' => [
		'class' => 'Order',
		'method' => 'order_complete'
	],
	// 重新打印订单
	'order_reprint' => [
		'class' => 'Order',
		'method' => 'order_reprint'
	],
	// 验证钱箱密码
	'moneybox_pswd' => [
		'class' => 'Home',
		'method' => 'moneybox_pswd'
	],
	// 套餐
	'store_meal' => [
		'class' => 'Home',
		'method' => 'store_meal'
	],
	// 触发消息为已读
	'msg_read' => [
		'class' => 'Msg',
		'method' => 'msg_read'
	],
		// 订座订单列表
	'book_order_list' => [
		'class' => 'Order',
		'method' => 'book_order_list'
	],
	// 订座订单数据
	'order_book_lise' => [
		'class' => 'Order',
		'method' => 'order_book_lise'
	],
// 订座订单接单
	'book_receive' => [
		'class' => 'Order',
		'method' => 'book_receive'
	],	
	// 取消订座订单
	'book_cancel' => [
		'class' => 'Order',
		'method' => 'book_cancel'
	],
	// 完成订座订单
	'finish_book_order' => [
		'class' => 'Order',
		'method' => 'finish_book_order'
	],	
		// 会议订单
	'appointment_order' => [
		'class' => 'Order',
		'method' => 'appointment_order'
	],	
];

?>