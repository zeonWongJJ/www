<?php
/**
 * 用户操作接口
 * @author rusice <liruizhao970302@outlook.com>
 */

$resource = \utils\Router::resources('User', 'User');

$router = [
    // 用户登录接口
    'user.login'               => [
        'class'  => 'User',
        'method' => 'login'
    ],
    // 检查用户token
    'user.check.token'         => [
        'class'  => 'User',
        'method' => 'checkToken'
    ],
    // 用户退出登录
    'user.logout'              => [
        'class'  => 'User',
        'method' => 'logout'
    ],
    // 用户注册接口
    'user.register'            => [
        'class'  => 'User',
        'method' => 'register'
    ],
    // 用户余额充值接口
    'user.balance.recharge'    => [
        'class'  => 'User',
        'method' => 'recharge'
    ],
    // 修改用户资料
    'user.info.update'         => [
        'class'  => 'User',
        'method' => 'updateInfo'
    ],
    // 获取用户个人信息
    'user.info.get'            => [
        'class'  => 'User',
        'method' => 'getInfo'
    ],
    // 修改用户性别
    'user.info.update.gender'  => [
        'class'  => 'User',
        'method' => 'updateGender'
    ],
    // 修改用户头像
    'user.info.update.pic'     => [
        'class'  => 'User',
        'method' => 'updatePic'
    ],
    // 修改用户登录密码
    'user.info.update.pwd'     => [
        'class'  => 'User',
        'method' => 'updatePwd'
    ],
    // 修改用户交易密码
    'user.info.update.payment' => [
        'class'  => 'User',
        'method' => 'updatePayment'
    ],
    // 发送验证码
    'user.code.send'           => [
        'class'  => 'User',
        'method' => 'sendCodePhone'
    ],
    // 用户下单
    'user.buy.service'         => [
        'class'  => 'User',
        'method' => 'orderService'
    ],
    // 校验验证码
    'user.code.check'          => [
        'class'  => 'User',
        'method' => 'checkVerifyCode'
    ],
    // 用户绑定、解绑第三方账号
    'user.bind'                => [
        'class'  => 'User',
        'method' => 'bindAccount'
    ],
    // 获取用户的提现列表账号
    'user.withdraw.account'    => [
        'class'  => 'User',
        'method' => 'withdrawList'
    ],
    // 用户提现
    'user.withdraw'            => [
        'class'  => 'User',
        'method' => 'withdraw'
    ],
    // 获取用户管理后台菜单
    'user.admin.nav.get'       => [
        'class'  => 'User',
        'method' => 'getNav'
    ],
    // 获取当前登录用户的订单列表
    'user.get.order'           => [
        'class'  => 'User',
        'method' => 'getOrderList'
    ],
    // 获取当前登录用户的发布列表
    'user.get.demand'          => [
        'class'  => 'User',
        'method' => 'getDemandList'
    ],
    // 删除订单
    'user.order.delete'        => [
        'class'  => 'User',
        'method' => 'deleteOrder'
    ],
    'user.demand.list'         => [
        'class'  => 'User',
        'method' => 'getDemandList'
    ],
    // 统计用户店铺的数据
    'user.store.statistics'    => [
        'class'  => 'User',
        'method' => 'getMyStoreCount'
    ],
    // 获取店铺状态
    'user.store.status'        => [
        'class'  => 'User',
        'method' => 'storeStatus'
    ],
    // 用户开启/禁用
    'user.enable'              => [
        'class'  => 'User',
        'method' => 'enable'
    ],
    // 获取用户订单的统计
    'user.order.statistics'    => [
        'class'  => 'User',
        'method' => 'getOrderStatistics'
    ],
    // 检测用户支付密码是否设置
    'userpayment.code.check'   => [
        'class'    => 'User'
        , 'method' => 'fuck_check_payment_pwd'
    ],
    // 第一次设置用户交易密码
    'userpayment.init'         => [
        'class'    => 'User'
        , 'method' => 'fuck_set_payment'
    ],
    'user.canuse'              => [
        'class'  => 'User',
        'method' => 'canuse'
    ],
    'user.cancel.order'        => [
        'class'    => 'User'
        , 'method' => 'cancelOrder'
    ],
    // 收藏、取消收藏
    'user.collect'             => [
        'class'  => 'User',
        'method' => 'collect'
    ],
    // 收藏列表
    'user.collect.list'        => [
        'class'  => 'User',
        'method' => 'collectList'
    ],
    'test'                     => [
        'class'  => 'User',
        'method' => 'test'
    ],
    // 获取登录用户的评论列表
    'user.comment.list'        => [
        'class'  => 'User',
        'method' => 'getCommentList'
    ],
    // 获取用户分享总数
    'user.get.share.count'     => [
        'class'    => 'User'
        , 'method' => 'getUserShareCount'
    ],
    // 微信相关个人信息获取
    'wechat.get.userinfo'      => [
        'class'  => 'wechat',
        'method' => 'getUserInfo'
    ],
    // 获取当前登录用户的店铺
    'user.store.info.get'      => [
        'class'  => 'User',
        'method' => 'getOwnStore'
    ],
    // 获取店铺下的评论
    'store.get.comment'        => [
        'class'  => 'User',
        'method' => 'getComment'
    ],
];

return array_merge($resource, $router);
