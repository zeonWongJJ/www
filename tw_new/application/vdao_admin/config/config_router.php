<?php
static $a_router = [
	//首页
	'index' => [
		'class' => 'Home',
		'method' => 'index'
	],
	// 消息列表
	'messages_showlist' => [
		'class' => 'Home',
		'method' => 'messages_showlist'
	],
	// 消息提示数
	'oute' => [
		'class' => 'Home',
		'method' => 'oute'
	],
	// 管理员登录
	'login' => [
		'class' => 'Login',
		'method' => 'login'
	],
	// 用户注册
	'register' => [
		'class' => 'Login',
		'method' => 'register'
	],
	// 退出登录
	'loginout' => [
		'class' => 'Login',
		'method' => 'loginout'
	],
	// 发送验证码
	'send_code' => [
		'class' => 'Code',
		'method' => 'send_code'
	],

	// 管理员列表
	'admin_showlist' => [
		'class' => 'Admin',
		'method' => 'admin_showlist'
	],
	//添加管理员
	'admin_add' => [
		'class' => 'Admin',
		'method' => 'admin_add'
	],
	//修改管理员信息
	'admin_update' => [
		'class' => 'Admin',
		'method' => 'admin_update'
	],
	//删除管理员
	'admin_delete' => [
		'class' => 'Admin',
		'method' => 'admin_delete'
	],
	//管理员开关[启用或者禁用]
	'admin_switch' => [
		'class'  => 'Admin',
		'method' => 'admin_switch'
	],
    //提现问题记录列表
    'withdraw_log_list' => [
        'class'  => 'Admin',
        'method' => 'withdraw_log_list'
    ],
	//管理员搜索
	'admin_search' => [
		'class'  => 'Admin',
		'method' => 'admin_search'
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
	//添加角色
	'role_add' => [
		'class' => 'Role',
		'method' => 'role_add'
	],
	//给角色分配权限[修改角色]
	'role_update' => [
		'class' => 'Role',
		'method' => 'role_update'
	],
	//删除角色
	'role_delete' => [
		'class' => 'Role',
		'method' => 'role_delete'
	],
	//角色开关
	'role_switch' => [
		'class' => 'Role',
		'method' => 'role_switch'
	],
	//搜索角色
	'role_search' => [
		'class' => 'Role',
		'method' => 'role_search'
	],
	//分配权限
	'role_distribute' => [
		'class' => 'Role',
		'method' => 'role_distribute'
	],

	//用户管理
	'user_showlist' => [
		'class' => 'User',
		'method' => 'user_showlist'
	],
	//添加用户
	'user_add' => [
		'class' => 'User',
		'method' => 'user_add'
	],
	//修改用户
	'user_update' => [
		'class' => 'User',
		'method' => 'user_update'
	],
	// 禁用用户
	'user_forbid' => [
		'class' => 'User',
		'method' => 'user_forbid'
	],
	//删除用户
	'user_delete' => [
		'class' => 'User',
		'method' => 'user_delete'
	],
	//重置密码
	'user_repassword' => [
		'class' => 'User',
		'method' => 'user_repassword'
	],
	//用户搜索
	'user_search' => [
		'class' => 'User',
		'method' => 'user_search'
	],
	//用户开关
	'user_switch' => [
		'class' => 'User',
		'method' => 'user_switch'
	],

	//公告列表
	'notice_showlist' => [
		'class' => 'Notice',
		'method' => 'notice_showlist'
	],
	//添加公告
	'notice_add' => [
		'class' => 'Notice',
		'method' => 'notice_add'
	],
	//修改公告
	'notice_update' => [
		'class' => 'Notice',
		'method' => 'notice_update'
	],
	//删除公告
	'notice_delete' => [
		'class' => 'Notice',
		'method' => 'notice_delete'
	],
	//预览公告
	'notice_preview' => [
		'class' => 'Notice',
		'method' => 'notice_preview'
	],
	//公告开关[显示或隐藏]
	'notice_switch' => [
		'class' => 'Notice',
		'method' => 'notice_switch'
	],

	//分类列表
	'cate_showlist' => [
		'class' => 'Cate',
		'method' => 'cate_showlist'
	],
	//增加分类
	'cate_add' => [
		'class' => 'Cate',
		'method' => 'cate_add'
	],
	//修改分类
	'cate_update' => [
		'class' => 'Cate',
		'method' => 'cate_update'
	],
	//删除分类
	'cate_delete' => [
		'class'  => 'Cate',
		'method' => 'cate_delete'
	],
	// 启用停用分类
	'cate_switch' => [
		'class'  => 'Cate',
		'method' => 'cate_switch'
	],
	// 分类搜索
	'cate_search' => [
		'class'  => 'Cate',
		'method' => 'cate_search'
	],

	//新闻列表
	'news_showlist' => [
		'class'  => 'News',
		'method' => 'news_showlist'
	],
	//增加新闻
	'news_add' => [
		'class'  => 'News',
		'method' => 'news_add'
	],
	//修改新闻
	'news_update' => [
		'class'  => 'News',
		'method' => 'news_update'
	],
	//删除新闻
	'news_delete' => [
		'class'  => 'News',
		'method' => 'news_delete'
	],
	//预览新闻
	'news_preview' => [
		'class'  => 'News',
		'method' => 'news_preview'
	],
	//新闻开关[显示或隐藏]
	'news_switch' => [
		'class'  => 'News',
		'method' => 'news_switch'
	],
	//新闻搜索
	'news_search' => [
		'class'  => 'News',
		'method' => 'news_search'
	],

	//门店列表
	'store_showlist' => [
		'class'  => 'Store',
		'method' => 'store_showlist'
	],
	//添加门店
	'store_add' => [
		'class'  => 'Store',
		'method' => 'store_add'
	],
	//修改门店
	'store_update' => [
		'class'  => 'Store',
		'method' => 'store_update'
	],
	//删除门店
	'store_delete' => [
		'class'  => 'Store',
		'method' => 'store_delete'
	],
	//搜索门店
	'store_search' => [
		'class'  => 'Store',
		'method' => 'store_search'
	],
	//门店开关[启用或者停用]
	'store_switch' => [
		'class'  => 'Store',
		'method' => 'store_switch'
	],
	// 删除临时照片
	'storetem_delete' => [
		'class'  => 'Store',
		'method' => 'storetem_delete'
	],

	//门店管理员列表
	'manager_showlist' => [
		'class'  => 'Manager',
		'method' => 'manager_showlist'
	],
	//添加门店管理员
	'manager_add' => [
		'class'  => 'Manager',
		'method' => 'manager_add'
	],
	//修改门店管理员
	'manager_update' => [
		'class'  => 'Manager',
		'method' => 'manager_update'
	],
	//删除门店管理员
	'manager_delete' => [
		'class'  => 'Manager',
		'method' => 'manager_delete'
	],


	//属性分类
	'attri' => [
		'class' => 'Attr',
		'method' => 'attri'
	],
	//属性分类2姐
	'attri_id_2' => [
		'class' => 'Attr',
		'method' => 'attri_id_2'
	],
	//属性分类添加
	'attri_add' => [
		'class' => 'Attr',
		'method' => 'attri_add'
	],
	//属性分类修改
	'attri_up' => [
		'class' => 'Attr',
		'method' => 'attri_up'
	],
	//属性分类显示隐藏
	'attri_switch' => [
		'class' => 'Attr',
		'method' => 'attri_switch'
	],
	//属性分类删除
	'attri_delete' => [
		'class' => 'Attr',
		'method' => 'attri_delete'
	],
	//门店审核耗材
	'store' => [
		'class' => 'Cons',
		'method' => 'store'
	],
	//耗材申请处理结果查看
	'store_pass' => [
		'class'  => 'Cons',
		'method' => 'store_pass'
	],
	//耗材申请处理触发
	'touch_off' => [
		'class'  => 'Cons',
		'method' => 'touch_off'
	],
    //耗材分类列表
	'cons' => [
		'class' => 'Cons',
		'method' => 'cons'
	],
	//耗材增加分类
	'cons_add' => [
		'class' => 'Cons',
		'method' => 'cons_add'
	],
	//耗材修改分类
	'cons_update' => [
		'class' => 'Cons',
		'method' => 'cons_update'
	],
	//耗材分类状态修正
	'cons_switch' => [
		'class' => 'Cons',
		'method' => 'cons_switch'
	],
	//耗材删除分类
	'cons_delete' => [
		'class'  => 'Cons',
		'method' => 'cons_delete'
	],
	//耗材列表
	'annex' => [
		'class' => 'Cons',
		'method' => 'annex'
	],
	//耗材增加
	'annex_add' => [
		'class' => 'Cons',
		'method' => 'annex_add'
	],
	//耗材修改
	'annex_update' => [
		'class' => 'Cons',
		'method' => 'annex_update'
	],
	//耗材修改
	'consumption' => [
		'class' => 'Cons',
		'method' => 'consumption'
	],
	//耗材删除
	'annex_delete' => [
		'class'  => 'Cons',
		'method' => 'annex_delete'
	],
	//耗材出入库记录
	'entry_record' => [
		'class'  => 'Cons',
		'method' => 'entry_record'
	],
	//耗材出入库记录
	'entry_record_imge' => [
		'class'  => 'Cons',
		'method' => 'entry_record_imge'
	],
	//耗材入库曾加
	'entry_add' => [
		'class'  => 'Cons',
		'method' => 'entry_add'
	],
	//耗材入库修改
	'entry_uptate' => [
		'class'  => 'Cons',
		'method' => 'entry_uptate'
	],
	//耗材入库图片删除
	'entry_img_del' => [
		'class'  => 'Cons',
		'method' => 'entry_img_del'
	],
	//耗材分类2级
	'cons_id_2' => [
		'class'  => 'Cons',
		'method' => 'cons_id_2'
	],
	//耗材分类3级
	'cons_id_3' => [
		'class'  => 'Cons',
		'method' => 'cons_id_3'
	],
	//耗材名称
	'cons_name' => [
		'class'  => 'Cons',
		'method' => 'cons_name'
	],

	//产品分类
	'pro' => [
		'class'  => 'Pro',
		'method' => 'pro'
	],
	//图片上传
	'imge' => [
		'class'  => 'Pro',
		'method' => 'imge'
	],
	//产品分类添加
	'pro_add' => [
		'class'  => 'Pro',
		'method' => 'pro_add'
	],
	//产品分类修改
	'pro_up' => [
		'class'  => 'Pro',
		'method' => 'pro_up'
	],
	//产品分类状态修改
	'pro_switch' => [
		'class'  => 'Pro',
		'method' => 'pro_switch'
	],
	//产品分类删除
	'pro_delete' => [
		'class'  => 'Pro',
		'method' => 'pro_delete'
	],
	//杯子管理
	'cup' => [
		'class'  => 'cup',
		'method' => 'cup'
	],
	//杯子添加
	'cup_add' => [
		'class'  => 'cup',
		'method' => 'cup_add'
	],
	//杯子修改
	'cup_update' => [
		'class'  => 'cup',
		'method' => 'cup_update'
	],
	//杯子删除
	'cup_del' => [
		'class'  => 'cup',
		'method' => 'cup_del'
	],
	//产品
	'product' => [
		'class'  => 'Pro',
		'method' => 'product'
	],
	//产品分类2级
	'proid_id_2' => [
		'class'  => 'Pro',
		'method' => 'proid_id_2'
	],
	//产品分类3级
	'proid_id_3' => [
		'class'  => 'Pro',
		'method' => 'proid_id_3'
	],
	//产品添加
	'product_add' => [
		'class'  => 'Pro',
		'method' => 'product_add'
	],
	//产品添加
	'product_update' => [
		'class'  => 'Pro',
		'method' => 'product_update'
	],
	//产品添加
	'product_switch' => [
		'class'  => 'Pro',
		'method' => 'product_switch'
	],
	//产品删除
	'product_delete' => [
		'class'  => 'Pro',
		'method' => 'product_delete'
	],
	//产品图片删除
	'img_del' => [
		'class'  => 'Pro',
		'method' => 'img_del'
	],
	//房间类型列表
	'type_showlist' => [
		'class'  => 'Roomtype',
		'method' => 'type_showlist'
	],
	//添加房间类型
	'type_add' => [
		'class'  => 'Roomtype',
		'method' => 'type_add'
	],
	//修改房间类型
	'type_update' => [
		'class'  => 'Roomtype',
		'method' => 'type_update'
	],
	//删除房间类型
	'type_delete' => [
		'class'  => 'Roomtype',
		'method' => 'type_delete'
	],
	//类型开关
	'type_switch' => [
		'class'  => 'Roomtype',
		'method' => 'type_switch'
	],
	//类型搜索
	'type_search' => [
		'class'  => 'Roomtype',
		'method' => 'type_search'
	],
	// 类型ajax
	'type_cate' => [
		'class'  => 'Roomtype',
		'method' => 'type_cate'
	],

	//设备列表
	'device_showlist' => [
		'class'  => 'Device',
		'method' => 'device_showlist'
	],
	//添加设备
	'device_add' => [
		'class'  => 'Device',
		'method' => 'device_add'
	],
	//修改设备
	'device_update' => [
		'class'  => 'Device',
		'method' => 'device_update'
	],
	//删除设备
	'device_delete' => [
		'class'  => 'Device',
		'method' => 'device_delete'
	],
	//设备开关
	'device_switch' => [
		'class'  => 'Device',
		'method' => 'device_switch'
	],
	//搜索设备
	'device_search' => [
		'class'  => 'Device',
		'method' => 'device_search'
	],
	// 设备图片上传
	'deviceimg_upload' => [
		'class'  => 'Device',
		'method' => 'deviceimg_upload'
	],
	// 删除设备图片
	'devicetem_delete' => [
		'class'  => 'Device',
		'method' => 'devicetem_delete'
	],

	//房间列表
	'room_showlist' => [
		'class'  => 'Room',
		'method' => 'room_showlist'
	],
	//添加房间
	'room_add' => [
		'class'  => 'Room',
		'method' => 'room_add'
	],
	//修改房间
	'room_update' => [
		'class'  => 'Room',
		'method' => 'room_update'
	],
	//删除房间
	'room_delete' => [
		'class'  => 'Room',
		'method' => 'room_delete'
	],
	//房间开关[启用或者停用]
	'room_switch' => [
		'class'  => 'Room',
		'method' => 'room_switch'
	],
	//搜索房间
	'room_search' => [
		'class'  => 'Room',
		'method' => 'room_search'
	],
	// 删除临时图片
	'roomtem_delete' => [
		'class'  => 'Room',
		'method' => 'roomtem_delete'
	],
	//图片上传
	'image_upload' => [
		'class'  => 'Upload',
		'method' => 'image_upload'
	],



	// 移动店主列表
	'shopman_showlist' => [
		'class'  => 'Shopman',
		'method' => 'shopman_showlist'
	],
	// 移动店主状态开关[停用启用]
	'shopman_switch' => [
		'class'  => 'Shopman',
		'method' => 'shopman_switch'
	],
	// 删除移动店主
	'shopman_delete' => [
		'class'  => 'Shopman',
		'method' => 'shopman_delete'
	],
	// 移动店主详情
	'shopman_detail' => [
		'class'  => 'Shopman',
		'method' => 'shopman_detail'
	],
	// 搜索移动店主
	'shopman_search' => [
		'class'  => 'Shopman',
		'method' => 'shopman_search'
	],
	// 申请移动店主的列表
	'shopman_applylist' => [
		'class'  => 'Shopman',
		'method' => 'shopman_applylist'
	],
	// 同意申请移动店主
	'shopman_accept' => [
		'class'  => 'Shopman',
		'method' => 'shopman_accept'
	],
	// 拒绝申请移动店主
	'shopman_refuse' => [
		'class'  => 'Shopman',
		'method' => 'shopman_refuse'
	],
	// 搁置申请移动店主
	'shopman_shelve' => [
		'class'  => 'Shopman',
		'method' => 'shopman_shelve'
	],
	// 已拒绝的列表
	'shopman_refuselist' => [
		'class'  => 'Shopman',
		'method' => 'shopman_refuselist'
	],
	// 已搁置的列表
	'shopman_shelvelist' => [
		'class'  => 'Shopman',
		'method' => 'shopman_shelvelist'
	],
	// 移动店主->查看所有订单
	'shopman_order' => [
		'class'  => 'Shopman',
		'method' => 'shopman_order'
	],
	// 移动店主->查看所有推荐人
	'shopman_referee' => [
		'class'  => 'Shopman',
		'method' => 'shopman_referee'
	],
	// 移动店主->查看所有推荐人明细
	'shopman_referee_detail' => [
		'class'  => 'Shopman',
		'method' => 'shopman_referee_detail'
	],

	// 设置列表
	'set_showlist' => [
		'class'  => 'Set',
		'method' => 'set_showlist'
	],
	// 修改设置
	'set_update' => [
		'class'  => 'Set',
		'method' => 'set_update'
	],

	// 帖子列表
	'mood_showlist' => [
		'class'  => 'Mood',
		'method' => 'mood_showlist'
	],
	// 帖子审核开关
	'mood_switch' => [
		'class'  => 'Mood',
		'method' => 'mood_switch'
	],
	// 删除帖子
	'mood_delete' => [
		'class'  => 'Mood',
		'method' => 'mood_delete'
	],
	// 搜索帖子
	'mood_search' => [
		'class'  => 'Mood',
		'method' => 'mood_search'
	],
	// 预览帖子
	'mood_preview' => [
		'class'  => 'Mood',
		'method' => 'mood_preview'
	],
	// 删除动态评论
	'discuss_delete' => [
		'class'  => 'Mood',
		'method' => 'discuss_delete'
	],
	// 评论动态
	'mood_discuss' => [
		'class'  => 'Mood',
		'method' => 'mood_discuss'
	],
	// 回复评论
	'discuss_reply' => [
		'class'  => 'Mood',
		'method' => 'discuss_reply'
	],
	// 动态点赞
	'discuss_like' => [
		'class'  => 'Mood',
		'method' => 'discuss_like'
	],
	// 添加标签
	'tag_add' => [
		'class'  => 'Mood',
		'method' => 'tag_add'
	],
	// 给动态设置标签
	'mood_addtag' => [
		'class'  => 'Mood',
		'method' => 'mood_addtag'
	],
	// 删除标签
	'tag_delete' => [
		'class'  => 'Mood',
		'method' => 'tag_delete'
	],

	// 积分管理
	'points' => [
		'class'  => 'Points',
		'method' => 'points'
	],
	// 积分明细
	'points_detail' => [
		'class'  => 'Points',
		'method' => 'points_detail'
	],
	// 积分修改
	'points_update' => [
		'class'  => 'Points',
		'method' => 'points_update'
	],
	// 门店结算
	'account_store' => [
		'class'  => 'Account',
		'method' => 'account_store'
	],
	// 结算查看明细
	'account_detail' => [
		'class'  => 'Account',
		'method' => 'account_detail'
	],
	// 确定核算金额
	'account_update' => [
		'class'  => 'Account',
		'method' => 'account_update'
	],
	// 结算金额
	'account_statement' => [
		'class'  => 'Account',
		'method' => 'account_statement'
	],

	// 订单列表
	'order_showlist' => [
		'class'  => 'Order',
		'method' => 'order_showlist'
	],
	// 办公室订单列表
	'order_office' => [
		'class'  => 'Order',
		'method' => 'order_office'
	],
	// 咖啡室订单详情
	'order_coffee' => [
		'class'  => 'Order',
		'method' => 'order_coffee'
	],
	// 咖啡室订单列表
	'order_details' => [
		'class'  => 'Order',
		'method' => 'order_details'
	],
	// 办公室订单搜索
	'appointment_search' => [
		'class'  => 'Order',
		'method' => 'appointment_search'
	],

	// 用户消费月统计
	'statistic_showlist' => [
		'class'  => 'Statistic',
		'method' => 'statistic_showlist'
	],
	// 消费统计搜索
	'statistic_search' => [
		'class'  => 'Statistic',
		'method' => 'statistic_search'
	],
	// 查看该用户当月的订单
	'statistic_selforder' => [
		'class'  => 'Statistic',
		'method' => 'statistic_selforder'
	],
	// 用户当月的订单搜索
	'selforder_search' => [
		'class'  => 'Statistic',
		'method' => 'selforder_search'
	],
	// 查看该用户推荐的人当月的订单
	'statistic_otherorder' => [
		'class'  => 'Statistic',
		'method' => 'statistic_otherorder'
	],
	// 用户推荐的人订单搜索
	'otherorder_search' => [
		'class'  => 'Statistic',
		'method' => 'otherorder_search'
	],

	// 积分列表
	'score_showlist' => [
		'class'  => 'Score',
		'method' => 'score_showlist'
	],
	// 修改积分
	'score_update' => [
		'class'  => 'Score',
		'method' => 'score_update'
	],
	// 积分明细
	'score_detail' => [
		'class'  => 'Score',
		'method' => 'score_detail'
	],
	// 加盟列表
	'join_showlist' => [
		'class'  => 'Join',
		'method' => 'join_showlist'
	],
	// 同意申请
	'join_agree' => [
		'class'  => 'Join',
		'method' => 'join_agree'
	],
	// 驳回申请
	'join_refuse' => [
		'class'  => 'Join',
		'method' => 'join_refuse'
	],
	// 加盟详情
	'join_detail' => [
		'class'  => 'Join',
		'method' => 'join_detail'
	],
	// 搁置加盟申请
	'join_shelve' => [
		'class'  => 'Join',
		'method' => 'join_shelve'
	],
	// ajax加盟详情
	'join_info' => [
		'class'  => 'Join',
		'method' => 'join_info'
	],
	//资质申请
	'qualifi' => [
		'class'  => 'Audit',
		'method' => 'qualifi'
	],


	// 分享列表
	'share_showlist' => [
		'class'  => 'Share',
		'method' => 'share_showlist'
	],
	// 分享详情
	'share_detail' => [
		'class'  => 'Share',
		'method' => 'share_detail'
	],
	// 通过分享申请
	'share_adopt' => [
		'class'  => 'Share',
		'method' => 'share_adopt'
	],
	// 驳回分享申请
	'share_refuse' => [
		'class'  => 'Share',
		'method' => 'share_refuse'
	],
	// 搁置申请
	'share_shelve' => [
		'class'  => 'Share',
		'method' => 'share_shelve'
	],
	// ajax获取分享详情
	'share_see' => [
		'class'  => 'Share',
		'method' => 'share_see'
	],

	//资质申请详情
	'qualifi_list' => [
		'class'  => 'Audit',
		'method' => 'qualifi_list'
	],
	//资质申请审核
	'qualifi_state' => [
		'class'  => 'Audit',
		'method' => 'qualifi_state'
	],
	//资质申请审批查看
	'qualifi_chan' => [
		'class'  => 'Audit',
		'method' => 'qualifi_chan'
	],
	//产品分享
	'share_goods' => [
		'class'  => 'Share',
		'method' => 'share_goods'
	],
	//产品分享详情
	'share_list' => [
		'class'  => 'Share',
		'method' => 'share_list'
	],
	//产品分享审核
	'share_state' => [
		'class'  => 'Share',
		'method' => 'share_state'
	],
	//分享订单管理
	'share_order' => [
		'class'  => 'Share',
		'method' => 'share_order'
	],
	//分享订单详情
	'share_order_details' => [
		'class'  => 'Share',
		'method' => 'share_order_details'
	],
	// 座位订单
	'book_showlist' => [
		'class'  => 'Order',
		'method' => 'book_showlist'
	],
	// 查询订单
	'book_search' => [
		'class'  => 'Order',
		'method' => 'book_search'
	],
	// 时间段管理列表
	'time_list' => [
		'class'  => 'Brand',
		'method' => 'time_list'
	],
	// 时间段添加
	'time_add' => [
		'class'  => 'Brand',
		'method' => 'time_add'
	],
	// 时间段修改
	'time_up' => [
		'class'  => 'Brand',
		'method' => 'time_up'
	],
	// 时间段删除
	'time_dele' => [
		'class'  => 'Brand',
		'method' => 'time_dele'
	],
	// 广告列表
	'ad_showlist' => [
		'class'  => 'Ad',
		'method' => 'ad_showlist'
	],
	// 添加广告
	'ad_add' => [
		'class'  => 'Ad',
		'method' => 'ad_add'
	],
	// 修改广告
	'ad_update' => [
		'class'  => 'Ad',
		'method' => 'ad_update'
	],
	// 删除广告
	'ad_delete' => [
		'class'  => 'Ad',
		'method' => 'ad_delete'
	],
	// 删除上传的图片
	'adtem_delete' => [
		'class'  => 'Ad',
		'method' => 'adtem_delete'
	],
	// 套餐管理
	'package_showlist' => [
		'class'  => 'Package',
		'method' => 'package_showlist'
	],
	// 添加套餐
	'package_add' => [
		'class'  => 'Package',
		'method' => 'package_add'
	],
	// 修改套餐
	'package_update' => [
		'class'  => 'Package',
		'method' => 'package_update'
	],
	// 删除套餐
	'package_delete' => [
		'class'  => 'Package',
		'method' => 'package_delete'
	],
	// 根据分类获取产品
	'package_product' => [
		'class'  => 'Package',
		'method' => 'package_product'
	],
	// 套餐开关
	'package_switch' => [
		'class'  => 'Package',
		'method' => 'package_switch'
	],
	// 删除套餐图片
	'packagetem_delete' => [
		'class'  => 'Package',
		'method' => 'packagetem_delete'
	],


    //api-----------------------------------------
    //登录
    'admin_login' => [
        'class'  => 'ApiLogin',
        'method' => 'admin_login'
    ],
    //app首页
    'statistics' => [
        'class' => 'ApiHome',
        'method' => 'statistics'
    ],
    //消息分页
    'messages_show_list' => [
        'class' => 'ApiMessage',
        'method' => 'messages_show_list'
    ],
    //消息数量
    'message_count' => [
        'class' => 'ApiMessage',
        'method' => 'message_count'
    ],
    //用户分页查询
    'user_list' => [
        'class' => 'ApiConsumerUser',
        'method' => 'user_list'
    ],
    //移动店主分页查询
    'shopkeeper_name_list' => [
        'class' => 'ApiConsumerUser',
        'method' => 'shopkeeper_name_list'
    ],
    //门店列表分页查询
    'store_list' => [
        'class' => 'ApiStore',
        'method' => 'store_list'
    ],
    //店铺餐饮订单列表
    'store_lunch_order_list' => [
        'class' => 'ApiOrder',
        'method' => 'store_lunch_order_list'
    ],
    //单个餐饮订单
    'lunch_order_detail' => [
        'class' => 'ApiOrder',
        'method' => 'lunch_order_detail'
    ],
    //店铺会议或座位订单列表
    'store_meeting_seat_order_list' => [
        'class' => 'ApiOrder',
        'method' => 'store_meeting_seat_order_list'
    ],
    //单个会议或座位订单
    'meeting_seat_order_detail' => [
        'class' => 'ApiOrder',
        'method' => 'meeting_seat_order_detail'
    ],
    //api-----------------------------------------

];
?>