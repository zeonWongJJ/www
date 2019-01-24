<?php
static $a_router = [
	// 首页
	'index' => [
		'class' => 'Home',
		'method' => 'index'
	],
	// 消息查看
	'message' => [
		'class' => 'Home',
		'method' => 'message'
	],
	'oute' => [
		'class' => 'Home',
		'method' => 'oute'
	],
	// 门店管理员登录
	'login' => [
		'class' => 'Login',
		'method' => 'login'
	],
	// 退出登录
	'loginout' => [
		'class' => 'Login',
		'method' => 'loginout'
	],
	// 门店的订单
	'delivery' => [
		'class' => 'Delivery',
		'method' => 'delivery'
	],
	// 门店的订单的详情
	'order_details' => [
		'class' => 'Delivery',
		'method' => 'order_details'
	],
	'order_detail' => [
		'class' => 'Delivery',
		'method' => 'order_detail'
	],
	// 门店的订单取消
	'delivery_quxiao' => [
		'class' => 'Delivery',
		'method' => 'delivery_quxiao'
	],
	//订单完成
	'delivery_wanchen' => [
		'class' => 'Delivery',
		'method' => 'delivery_wanchen'
	],
	//订单接单
	'delivery_jiedan' => [
		'class' => 'Delivery',
		'method' => 'delivery_jiedan'
	],
	// 订单派送
	'delivery_order' => [
		'class' => 'Delivery',
		'method' => 'delivery_order'
	],
	// 门店新订单
	'delivery_xindind' => [
		'class' => 'Delivery',
		'method' => 'delivery_xindind'
	],
	// 未选择门店订单抢单
	'delivery_weixuan' => [
		'class' => 'Delivery',
		'method' => 'delivery_weixuan'
	],
	// 门店抢单
	'single' => [
		'class' => 'Delivery',
		'method' => 'single'
	],
	// 门店一键抢单
	'onekey' => [
		'class' => 'Delivery',
		'method' => 'onekey'
	],
	// 预约办公室的订单
	'appointment_order' => [
		'class' => 'Appointment',
		'method' => 'appointment_order'
	],
	// 搜索办公室订单
	'appointment_search' => [
		'class' => 'Appointment',
		'method' => 'appointment_search'
	],
	// 办公室订单接单
	'appointment_getorder' => [
		'class' => 'Appointment',
		'method' => 'appointment_getorder'
	],
	// 办公室订单开始服务
	'appointment_beginser' => [
		'class' => 'Appointment',
		'method' => 'appointment_beginser'
	],
	// 办公室订单服务结束
	'appointment_overser' => [
		'class' => 'Appointment',
		'method' => 'appointment_overser'
	],
	// 办公室订单服务结束
	'appointment_cancel' => [
		'class' => 'Appointment',
		'method' => 'appointment_cancel'
	],
	// 获取房间的座位
	'appointment_getseat' => [
		'class' => 'Appointment',
		'method' => 'appointment_getseat'
	],
	// 删除预约订单
	'appointment_delete' => [
		'class' => 'Appointment',
		'method' => 'appointment_delete'
	],
	// 营业结束将所有预约改为已完成 [定时任务]
	'appointment_timing' => [
		'class' => 'Appointment',
		'method' => 'appointment_timing'
	],
	// 门店定位
	'store_position' => [
		'class' => 'Position',
		'method' => 'store_position'
	],
	// ajax保存定位信息
	'position_update' => [
		'class' => 'Position',
		'method' => 'position_update'
	],

	// 门店设置
	'store_set' => [
		'class' => 'Set',
		'method' => 'store_set'
	],
	// 提现账户设置
	'store_withdraw' => [
		'class' => 'Set',
		'method' => 'store_withdraw'
	],
	// 门店头像
	'store_touxiang' => [
		'class' => 'Set',
		'method' => 'store_touxiang'
	],

	// 房间类型列表
	'room_showlist' => [
		'class' => 'Office',
		'method' => 'room_showlist'
	],
	// 搜索房间
	'room_search' => [
		'class' => 'Office',
		'method' => 'room_search'
	],
	// 添加办公室类型 [ajax]
	'office_add' => [
		'class' => 'Office',
		'method' => 'office_add'
	],
	// 办公室列表
	'office_showlist' => [
		'class' => 'Office',
		'method' => 'office_showlist'
	],
	// 办公室设置平面图
	'office_plan' => [
		'class' => 'Office',
		'method' => 'office_plan'
	],
	// 保存办公室平面图设置 [ajax]
	'save_plan' => [
		'class' => 'Office',
		'method' => 'save_plan'
	],
	// 删除办公室 [ajax]
	'office_delete' => [
		'class' => 'Office',
		'method' => 'office_delete'
	],
	// 办公室启用停用
	'office_switch' => [
		'class' => 'Office',
		'method' => 'office_switch'
	],
	// 办公室搜索
	'office_search' => [
		'class' => 'Office',
		'method' => 'office_search'
	],

	//门店产品管理
	'store_product' => [
		'class' => 'Product',
		'method' => 'store_product'
	],
	//门店产品状态修改
	'product_state' => [
		'class' => 'Product',
		'method' => 'product_state'
	],
	//门店产品添加
	'product_add' => [
		'class' => 'Product',
		'method' => 'product_add'
	],
	//门店产品删除
	'product_dele' => [
		'class' => 'Product',
		'method' => 'product_dele'
	],

	// 权限列表
	'auth_showlist' => [
		'class' => 'Auth',
		'method' => 'auth_showlist'
	],
	// 添加权限
	'auth_add' => [
		'class' => 'Auth',
		'method' => 'auth_add'
	],
	// 删除权限
	'auth_delete' => [
		'class' => 'Auth',
		'method' => 'auth_delete'
	],
	// 修改权限
	'auth_update' => [
		'class' => 'Auth',
		'method' => 'auth_update'
	],

	// 角色列表
	'group_showlist' => [
		'class' => 'Group',
		'method' => 'group_showlist'
	],
	// 添加角色
	'group_add' => [
		'class' => 'Group',
		'method' => 'group_add'
	],
	// 删除角色
	'group_delete' => [
		'class' => 'Group',
		'method' => 'group_delete'
	],
	// 修改角色
	'group_update' => [
		'class' => 'Group',
		'method' => 'group_update'
	],
	// 分组开关
	'group_switch' => [
		'class' => 'Group',
		'method' => 'group_switch'
	],
	// 搜索分组
	'group_search' => [
		'class' => 'Group',
		'method' => 'group_search'
	],

	// 管理员列表
	'manager_showlist' => [
		'class' => 'Manager',
		'method' => 'manager_showlist'
	],
	// 添加管理员
	'manager_add' => [
		'class' => 'Manager',
		'method' => 'manager_add'
	],
	// 删除管理员
	'manager_delete' => [
		'class' => 'Manager',
		'method' => 'manager_delete'
	],
	// 修改管理员
	'manager_update' => [
		'class' => 'Manager',
		'method' => 'manager_update'
	],
	// 启用停用开关
	'manager_switch' => [
		'class' => 'Manager',
		'method' => 'manager_switch'
	],
	// 搜索管理员
	'manager_search' => [
		'class' => 'Manager',
		'method' => 'manager_search'
	],
	//门店耗材列表
	'consumable' => [
		'class' => 'Consumable',
		'method' => 'consumable'
	],
	//门店耗材预警值修改
	'consumable_uptate' => [
		'class' => 'Consumable',
		'method' => 'consumable_uptate'
	],
	//门店耗材每日消耗查看
	'consumable_daily' => [
		'class' => 'Consumable',
		'method' => 'consumable_daily'
	],
	//门店耗材申请列表
	'consumable_apply' => [
		'class' => 'Consumable',
		'method' => 'consumable_apply'
	],
	//门店耗材申请参数获取
	'consumable_add' => [
		'class' => 'Consumable',
		'method' => 'consumable_add'
	],
	//门店耗材申请添加
	'consumable_addition' => [
		'class' => 'Consumable',
		'method' => 'consumable_addition'
	],
	//门店耗材重新申请
	'consumable_reapply' => [
		'class' => 'Consumable',
		'method' => 'consumable_reapply'
	],
	//门店耗材申请通过和拒绝查看
	'consumable_pass' => [
		'class' => 'Consumable',
		'method' => 'consumable_pass'
	],
	//门店耗材申请修改
	'consumable_up' => [
		'class' => 'Consumable',
		'method' => 'consumable_up'
	],
	//门店耗材申请取消
	'consumable_abolish' => [
		'class' => 'Consumable',
		'method' => 'consumable_abolish'
	],
	//获取产品2级分类
	'proid_id_2' => [
		'class' => 'Consumable',
		'method' => 'proid_id_2'
	],
	//获取产品3级分类
	'proid_id_3' => [
		'class' => 'Consumable',
		'method' => 'proid_id_3'
	],
	//获取耗材2级分类
	'haoc_id_2' => [
		'class' => 'Consumable',
		'method' => 'haoc_id_2'
	],
	//获取耗材3级分类
	'haoc_id_3' => [
		'class' => 'Consumable',
		'method' => 'haoc_id_3'
	],
	//获取耗材名称
	'haoc_name' => [
		'class' => 'Consumable',
		'method' => 'haoc_name'
	],
	//获取产品3级分类得到产品
	'proid_goode' => [
		'class' => 'Consumable',
		'method' => 'proid_goode'
	],
	// 结算列表
	'account_showlist' => [
		'class' => 'Account',
		'method' => 'account_showlist'
	],
	// 结算列表查看明细
	'account_detail' => [
		'class' => 'Account',
		'method' => 'account_detail'
	],
	// 资金变动列表
	'balance_showlist' => [
		'class' => 'Balance',
		'method' => 'balance_showlist'
	],
	// 门店资金提现
	'balance_withdraw' => [
		'class' => 'Balance',
		'method' => 'balance_withdraw'
	],
	// 新定位测试
	'position_new' => [
		'class' => 'Position',
		'method' => 'position_new'
	],
	// 上传图片
	'image_upload' => [
		'class' => 'Upload',
		'method' => 'image_upload'
	],
	// 删除门店照片
	'storetem_delete' => [
		'class' => 'Set',
		'method' => 'storetem_delete'
	],
	// 添加评论标签
	'comtag_add' => [
		'class' => 'Comment',
		'method' => 'comtag_add'
	],
	// 删除标签
	'comtag_delete' => [
		'class' => 'Comment',
		'method' => 'comtag_delete'
	],
	// 房间评价
	'comment_room' => [
		'class' => 'Comment',
		'method' => 'comment_room'
	],
	// 删除房间评论
	'comment_delete' => [
		'class' => 'Comment',
		'method' => 'comment_delete'
	],
	// 审核房间评论
	'comment_shenhe' => [
		'class' => 'Comment',
		'method' => 'comment_shenhe'
	],
	//产品评论
	'coffee_room' => [
		'class' => 'Comment',
		'method' => 'coffee_room'
	],

	// 微信退款
	'wxrefund_notify' => [
		'class' => 'Login',
		'method' => 'wxrefund_notify'
	],
	// 银行卡退款
	'unionpay_refund_notify' => [
		'class' => 'Login',
		'method' => 'unionpay_refund_notify'
	],
	// 修改办公室价格
	'office_updateprice' => [
		'class' => 'Office',
		'method' => 'office_updateprice'
	],
	// 修改库存
	'update_stock' => [
		'class' => 'Product',
		'method' => 'update_stock'
	],
	// 套餐管理
	'package_showlist' => [
		'class' => 'Product',
		'method' => 'package_showlist'
	],
	// 套餐上架
	'package_add' => [
		'class' => 'Product',
		'method' => 'package_add'
	],
	// 套餐下架
	'package_delete' => [
		'class' => 'Product',
		'method' => 'package_delete'
	],
	// 套餐开关
	'package_switch' => [
		'class' => 'Product',
		'method' => 'package_switch'
	],
];
?>