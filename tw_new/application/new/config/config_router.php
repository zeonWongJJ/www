<?php
static $a_router = [
	// 首页
	'index' => [
		'class' => 'Index',
		'method' => 'index'
	],
	// 添加
	'add_index' => [
		'class' => 'Index',
		'method' => 'add_index'
	],
	// 登录页面
	'login' => [
		'class' => 'Login',
		'method' => 'login'
	],
	// 退出登录
	'loginout' => [
		'class' => 'Login',
		'method' => 'loginout'
	],
	// 用户注册
	'register' => [
		'class' => 'Register',
		'method' => 'register'
	],
	// 密码找回
	'find_password' => [
		'class' => 'Back',
		'method' => 'find_password'
	],
	// 发送验证码
	'send_code' => [
		'class' => 'Code',
		'method' => 'send_code'
	],


	//发布需求
	'demand' => [
		'class' => 'Demand',
		'method' => 'demand'
	],
	//发布需求添加
	'demand_add' => [
		'class' => 'Demand',
		'method' => 'demand_add'
	],


/**************************************************/
	//上拉查看下一页 [测试]
	'up_page' => [
		'class' => 'User_score',
		'method' => 'up_page'
	],
	//ajax获取数据 [测试]
	'get_more' => [
		'class' => 'User_score',
		'method' => 'get_more'
	],
/**************************************************/


	// 会员中心[首页]
	'user_index' => [
		'class' => 'User',
		'method' => 'user_index'
	],
	// 会员中心->设置
	'user_set' => [
		'class' => 'User_set',
		'method' => 'user_set'
	],
	// 会员中心->设置->修改密码
	'user_set_pwd' => [
		'class' => 'User_set',
		'method' => 'user_set_pwd'
	],
	// 会员中心->设置->修改个人资料
	'user_set_baseinfo' => [
		'class' => 'User_set',
		'method' => 'user_set_baseinfo'
	],
	// 会员中心->设置页->修改个人资料->修改头像[ajax请求]
	'user_set_userpic' => [
		'class' => 'User_set',
		'method' => 'user_set_userpic'
	],
	// 会员中心->设置->修改个人资料->修改性别[ajax请求]
	'user_set_usersex' => [
		'class' => 'User_set',
		'method' => 'user_set_usersex'
	],
	// 会员中心->设置->初级身份认证[身份证认证]
	'id_verification' => [
		'class' => 'Verification',
		'method' => 'id_verification'
	],
	// 会员中心->设置->初级身份认证[身份证认证]--->重新认证
	'id_verification_again' => [
		'class' => 'Verification',
		'method' => 'id_verification_again'
	],
	// 会员中心->设置->中级身份认证(银行卡认证)[01步]
	'bankcard_verification' => [
		'class' => 'Verification',
		'method' => 'bankcard_verification'
	],
	// 会员中心->设置->中级身份认证(银行卡认证)[02步 打款金额验证]
	'bankcard_two' => [
		'class' => 'Verification',
		'method' => 'bankcard_two'
	],
	// 会员中心->设置->中级身份认证(银行卡认证)-->重新认证银行卡
	'bankcard_again' => [
		'class' => 'Verification',
		'method' => 'bankcard_again'
	],


	//会员中心->足迹->全部足迹
	'get_all_footprint' => [
		'class' => 'User_footprint',
		'method' => 'get_all_footprint'
	],
	//会员中心->足迹->需求足迹
	'get_demand_footprint' => [
		'class' => 'User_footprint',
		'method' => 'get_demand_footprint'
	],
	//会员中心->足迹->服务者
	'get_server_footprint' => [
		'class' => 'User_footprint',
		'method' => 'get_server_footprint'
	],
	//会员中心->足迹->删除足迹
	'delete_footprint' => [
		'class' => 'User_footprint',
		'method' => 'delete_footprint'
	],
	//会员中心->足迹->添加足迹
	'add_footprint' => [
		'class' => 'User_footprint',
		'method' => 'add_footprint'
	],


	//会员中心->我的收藏
	'get_mycollect' => [
		'class' => 'User_collect',
		'method' => 'get_mycollect'
	],
	//会员中心->收藏->全部收藏
	'get_all_collect' => [
		'class' => 'User_collect',
		'method' => 'get_all_collect'
	],
	//会员中心->收藏->收藏的服务者
	'get_server_collect' => [
		'class' => 'User_collect',
		'method' => 'get_server_collect'
	],
	//会员中心->收藏->收藏的需求
	'get_demand_collect' => [
		'class' => 'User_collect',
		'method' => 'get_demand_collect'
	],
	//会员中心->我的收藏->删除收藏
	'delete_collect' => [
		'class' => 'User_collect',
		'method' => 'delete_collect'
	],
	//会员中心->我的收藏->添加收藏
	'add_collect' => [
		'class' => 'User_collect',
		'method' => 'add_collect'
	],



	//会员中心->积分记录->我的积分
	'user_myscore' => [
		'class' => 'User_score',
		'method' => 'user_myscore'
	],
	//会员中心->积分记录->积分明细
	'user_score_detail' => [
		'class' => 'User_score',
		'method' => 'user_score_detail'
	],
	//会员中心->积分记录->兑换记录
	'user_score_exchange' => [
		'class' => 'User_score',
		'method' => 'user_score_exchange'
	],


	//会员中心->交易记录->我的资产
	'user_mymoney' => [
		'class' => 'User_money',
		'method' => 'user_mymoney'
	],
	//会员中心->充值
	'user_recharge' => [
		'class' => 'User_money',
		'method' => 'user_recharge'
	],

	//会员中心->荣耀详情
	'user_experience_detail' => [
		'class' => 'User_experience',
		'method' => 'user_experience_detail'
	],

	//会员中心->需求订单->全部订单
	'demand_all' => [
		'class' => 'User_order',
		'method' => 'demand_all'
	],
	//会员中心->需求订单->根据传入值获取数据
	'demand_custom' => [
		'class' => 'User_order',
		'method' => 'demand_custom'
	],
	//会员中心->需求订单->竞标中的订单
	'demand_bid' => [
		'class' => 'User_order',
		'method' => 'demand_bid'
	],
	//会员中心->需求订单->待付款的订单
	'demand_waitpay' => [
		'class' => 'User_order',
		'method' => 'demand_waitpay'
	],
	//会员中心->需求订单->待确定的订单
	'demand_waitconfirm' => [
		'class' => 'User_order',
		'method' => 'demand_waitconfirm'
	],
	//会员中心->需求订单->待服务的订单
	'demand_waitservice' => [
		'class' => 'User_order',
		'method' => 'demand_waitservice'
	],
	//会员中心->需求订单->服务中的订单
	'demand_inservice' => [
		'class' => 'User_order',
		'method' => 'demand_inservice'
	],
	//会员中心->需求订单->待评价的订单
	'demand_waitcomment' => [
		'class' => 'User_order',
		'method' => 'demand_waitcomment'
	],
	//会员中心->需求订单->已完成的订单
	'demand_complete' => [
		'class' => 'User_order',
		'method' => 'demand_complete'
	],
	//会员中心->需求订单->获取某一条订单的详情
	'demand_detail' => [
		'class' => 'User_order',
		'method' => 'demand_detail'
	],
	//会员中心->需求订单->查询某一条订单的投标详情
	'demand_bid_detail' => [
		'class' => 'User_order',
		'method' => 'demand_bid_detail'
	],
	//会员中心->需求订单->取消订单
	'demand_cancel' => [
		'class' => 'User_order',
		'method' => 'demand_cancel'
	],
	//会员中心->竞标中的订单->选中某个服务者
	'demand_selected' => [
		'class' => 'User_order',
		'method' => 'demand_selected'
	],
	//会员中心->竞标中的订单->确定服务完成
	'demand_confirm_finish' => [
		'class' => 'User_order',
		'method' => 'demand_confirm_finish'
	],


	//会员中心->需求订单->申请退款
	'for_refund' => [
		'class' => 'User_order',
		'method' => 'for_refund'
	],
	//会员中心->需求订单->退款订单->退款详情
	'refund_detail' => [
		'class' => 'User_order',
		'method' => 'refund_detail'
	],
	//会员中心->需求订单->退款订单->退款进度
	'refund_schedule' => [
		'class' => 'User_order',
		'method' => 'refund_schedule'
	],
	//会员中心->需求订单->退款订单->修改退款申请
	'refund_update' => [
		'class' => 'User_order',
		'method' => 'refund_update'
	],
	//会员中心->需求订单->退款订单->撤消退款申请
	'refund_cancel' => [
		'class' => 'User_order',
		'method' => 'refund_cancel'
	],
	//会员中心->需求订单->退款订单->申请客服介入
	'refund_custom_service' => [
		'class' => 'User_order',
		'method' => 'refund_custom_service'
	],


	//会员中心->需求订单->申请保修
	'for_guarantee' => [
		'class' => 'User_order',
		'method' => 'for_guarantee'
	],
	//会员中心->需求订单->保修订单->保修详情
	'guarantee_detail' => [
		'class' => 'User_order',
		'method' => 'guarantee_detail'
	],
	//会员中心->需求订单->保修进度
	'guarantee_schedule' => [
		'class' => 'User_order',
		'method' => 'guarantee_schedule'
	],
	//会员中心->需求订单->保修->撤消报修申请
	'guarantee_cancel' => [
		'class' => 'User_order',
		'method' => 'guarantee_cancel'
	],
	//会员中心->需求订单->保修->申请客服介入[不认可服务]
	'guarantee_custom_service' => [
		'class' => 'User_order',
		'method' => 'guarantee_custom_service'
	],
	//会员中心->需求订单->保修->撤消客服介入申请
	'custom_cancel' => [
		'class' => 'User_order',
		'method' => 'custom_cancel'
	],
	//会员中心->需求订单->保修->修改客服介入申请
	'custom_change' => [
		'class' => 'User_order',
		'method' => 'custom_change'
	],
	//会员中心->需求订单->保修->修改保修申请信息
	'guarantee_change' => [
		'class' => 'User_order',
		'method' => 'guarantee_change'
	],
	//会员中心->需求订单->保修->保修记录
	'guarantee_record' => [
		'class' => 'User_order',
		'method' => 'guarantee_record'
	],
	//会员中心->需求订单->保修->协商历史
	'guarantee_history' => [
		'class' => 'User_order',
		'method' => 'guarantee_history'
	],




	//服务者保修中的全部订单
	'server_guarantee' => [
		'class' => 'Server_order',
		'method' => 'server_guarantee'
	],
	//订单详情
	'server_guarantee_detail' => [
		'class' => 'Server_order',
		'method' => 'server_guarantee_detail'
	],
	//保修进度
	'server_guarantee_schedule' => [
		'class' => 'Server_order',
		'method' => 'server_guarantee_schedule'
	],
	//确认保修
	'server_guarantee_confirm' => [
		'class' => 'Server_order',
		'method' => 'server_guarantee_confirm'
	],
	//确认保修完成
	'server_guarantee_complete' => [
		'class' => 'Server_order',
		'method' => 'server_guarantee_complete'
	],
	//服务者申辩
	'server_guarantee_averment' => [
		'class' => 'Server_order',
		'method' => 'server_guarantee_averment'
	],

	//服务者中心->所有退款订单
	'server_refund' => [
		'class' => 'Server_order',
		'method' => 'server_refund'
	],
	//服务者中心->退款订单的详情
	'server_refund_detail' => [
		'class' => 'Server_order',
		'method' => 'server_refund_detail'
	],
	//服务者中心->退款订单->确认退款
	'server_refund_confirm' => [
		'class' => 'Server_order',
		'method' => 'server_refund_confirm'
	],
	//服务者中心->退款订单->拒绝退款
	'server_refund_refuse' => [
		'class' => 'Server_order',
		'method' => 'server_refund_refuse'
	],
	//服务者中心->竞标中的订单
	'server_order_inbid' => [
		'class' => 'Server_order',
		'method' => 'server_order_inbid'
	],
	//服务者中心->竞标中的订单->查看详情
	'server_inbid_detail' => [
		'class' => 'Server_order',
		'method' => 'server_inbid_detail'
	],
	//服务者中心->服务中的订单
	'server_inservice' => [
		'class' => 'Server_order',
		'method' => 'server_inservice'
	],
	//服务者中心->服务中的订单->查看详情
	'server_inservice_detail' => [
		'class' => 'Server_order',
		'method' => 'server_inservice_detail'
	],
	//服务者中心->服务中的订单->确认服务完成
	'server_inservice_confirm' => [
		'class' => 'Server_order',
		'method' => 'server_inservice_confirm'
	],
	//服务者中心->服务中的订单->确认服务完成
	'server_inservice_append' => [
		'class' => 'Server_order',
		'method' => 'server_inservice_append'
	],
	//服务者中心->待确认的订单
	'server_wait_confirm' => [
		'class' => 'Server_order',
		'method' => 'server_wait_confirm'
	],
	//服务者中心->待确认的订单->查看详情
	'server_wait_detail' => [
		'class' => 'Server_order',
		'method' => 'server_wait_detail'
	],
	//服务者中心->待确认的订单->确认接单
	'server_order_taking' => [
		'class' => 'Server_order',
		'method' => 'server_order_taking'
	],
	//服务者中心->待确定的订单->放弃接单
	'server_cancel_order' => [
		'class' => 'Server_order',
		'method' => 'server_cancel_order'
	],
	//服务者中心->已完成的订单
	'server_complete' => [
		'class' => 'Server_order',
		'method' => 'server_complete'
	],
	//服务者中心->已完成的订单->查看详情
	'server_complete_detail' => [
		'class' => 'Server_order',
		'method' => 'server_complete_detail'
	],
	//服务者中心->已完成的订单->保修明细
	'server_complete_guarantee' => [
		'class' => 'Server_order',
		'method' => 'server_complete_guarantee'
	],
	//服务者中心->已完成的订单->删除订单
	'server_complete_del' => [
		'class' => 'Server_order',
		'method' => 'server_complete_del'
	],




	//服务者中心称号页面
	'service_chenghao' => [
		'class' => 'Service',
		'method' => 'service_chenghao'
	],
	//服务者中心验证页面
	'service_verification' => [
		'class' => 'Service',
		'method' => 'service_verification'
	],
	//证照验证
	'certificate_verification' => [
		'class' => 'Verification',
		'method' => 'certificate_verification'
	],
	//企业验证
	'company_verification' => [
		'class' => 'Verification',
		'method' => 'company_verification'
	],



];
?>