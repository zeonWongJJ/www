<?php
/**
 * 用户操作接口
 * @author rusice <liruizhao970302@outlook.com>
 */

$resource = \utils\Router::resources('user', 'user');

$router = [
    // 用户登录接口
    'user.login'               => [
        'class'  => 'user',
        'method' => 'login'
    ],
    // 检查用户token
    'user.check.token'         => [
        'class'  => 'user',
        'method' => 'checkToken'
    ],
    // 用户退出登录
    'user.logout'              => [
        'class'  => 'user',
        'method' => 'logout'
    ],
    // 用户注册接口
    'user.register'            => [
        'class'  => 'user',
        'method' => 'register'
    ],
    // 用户余额充值接口
    'user.balance.recharge'    => [
        'class'  => 'user',
        'method' => 'recharge'
    ],
    // 修改用户资料
    'user.info.update'         => [
        'class'  => 'user',
        'method' => 'updateInfo'
    ],
    // 获取用户个人信息
    'user.info.get'            => [
        'class'  => 'user',
        'method' => 'getInfo'
    ],
    // 修改用户性别
    'user.info.update.gender'  => [
        'class'  => 'user',
        'method' => 'updateGender'
    ],
    // 修改用户头像
    'user.info.update.pic'     => [
        'class'  => 'user',
        'method' => 'updatePic'
    ],
    // 修改用户登录密码
    'user.info.update.pwd'     => [
        'class'  => 'user',
        'method' => 'updatePwd'
    ],
    // 修改用户交易密码
    'user.info.update.payment' => [
        'class'  => 'user',
        'method' => 'updatePayment'
    ],
    // 发送验证码
    'user.code.send'           => [
        'class'  => 'user',
        'method' => 'sendCodePhone'
    ],
    // 用户下单
    'user.buy.service'         => [
        'class'  => 'user',
        'method' => 'orderService'
    ],
    // 校验验证码
    'user.code.check'          => [
        'class'  => 'user',
        'method' => 'checkVerifyCode'
    ],
    // 用户绑定、解绑第三方账号
    'user.bind'                => [
        'class'  => 'user',
        'method' => 'bindAccount'
    ],
    // 获取用户的提现列表账号
    'user.withdraw.account'    => [
        'class'  => 'user',
        'method' => 'withdrawList'
    ],
    // 用户提现
    'user.withdraw'            => [
        'class'  => 'user',
        'method' => 'withdraw'
    ],
    // 获取用户管理后台菜单
    'user.admin.nav.get'       => [
        'class'  => 'user',
        'method' => 'getNav'
    ],
    // 获取当前登录用户的订单列表
    'user.get.order'           => [
        'class'  => 'user',
        'method' => 'getOrderList'
    ],
    // 获取当前登录用户的发布列表
    'user.get.demand'          => [
        'class'  => 'user',
        'method' => 'getDemandList'
    ],
    // 删除订单
    'user.order.delete'        => [
        'class'  => 'user',
        'method' => 'deleteOrder'
    ],
    // 统计用户店铺的数据
    'user.store.statistics'    => [
        'class'  => 'store',
        'method' => 'getMyStoreCount'
    ],
    // 获取店铺状态
    'user.store.status'        => [
        'class'  => 'user',
        'method' => 'storeStatus'
    ],
    // 用户开启/禁用
    'user.enable'              => [
        'class'  => 'user',
        'method' => 'enable'
    ],
    // 获取用户订单的统计
    'user.order.statistics'    => [
        'class'  => 'user',
        'method' => 'getOrderStatistics'
    ],
    // 检测用户支付密码是否设置
    'userpayment.code.check'   => [
        'class'    => 'user'
        , 'method' => 'fuck_check_payment_pwd'
    ],
    // 第一次设置用户交易密码
    'userpayment.init'         => [
        'class'    => 'user'
        , 'method' => 'fuck_set_payment'
    ],
    'user.canuse'              => [
        'class'    => 'User',
        'method' => 'canuse'
    ],
    'user.cancel.order'        => [
        'class'    => 'User'
        , 'method' => 'cancelOrder'
    ],
    /******************************评论***********************************/
    // 获取登录用户的评论列表
    'user.comment.list'        => [
        'class'  => 'user',
        'method' => 'getCommentList'
    ],
    /******************************分享***********************************/
    'user.get.share.count'     => [
        'class'    => 'User'
        , 'method' => 'getUserShareCount'
    ],
    /******************************微信相关***********************************/
    'wechat.get.userinfo'  =>  [
        'class' => 'wechat',
        'method'=> 'getUserInfo'
    ]
];

return array_merge($resource, $router);
