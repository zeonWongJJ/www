<?php
static $a_router = [
    // 首页
    'index'                     => [
        'class'  => 'Index',
        'method' => 'index'
    ],
    // 商品页
    'item'                      => [
        'class'  => 'Good_Details',
        'method' => 'item'
    ],
    // 商品搜索页
    'search'                    => [
        'class'  => 'Search',
        'method' => 'search'
    ],

    // 商品列表页面收藏
    'collect'                   => [
        'class'  => 'Search',
        'method' => 'collect'
    ],
    // 商品列表页面加入购物车
    'goodshop'                  => [
        'class'  => 'Search',
        'method' => 'goodshop'
    ],
    // 购物车
    'shop'                      => [
        'class'  => 'Shop',
        'method' => 'shopping'
    ],
    // 结算页面
    'bill'                      => [
        'class'  => 'Bill',
        'method' => 'bill'
    ],
    // 结算地址
    'area'                      => [
        'class'  => 'Bill',
        'method' => 'area'
    ],
    // 修改数据库
    'alter_address'             => [
        'class'  => 'Bill',
        'method' => 'alter_address'
    ],
    // 删除地址
    'del_address'               => [
        'class'  => 'Bill',
        'method' => 'del_address'
    ],
    // 添加收货地址
    'addarea'                   => [
        'class'  => 'Bill',
        'method' => 'addarea'
    ],
    // 修改收货地址
    'update_address'            => [
        'class'  => 'Bill',
        'method' => 'update_address'
    ],
    // 结算页面修改用户默认地址
    'billaddress'               => [
        'class'  => 'Bill',
        'method' => 'billaddress'
    ],
    // 其他地方调用支付方式支付
    'payment'                   => [
        'class'  => 'Pay',
        'method' => 'payment'
    ],
    // 登录
    'sso_login'                 => [
        'class'  => 'Sso',
        'method' => 'login'
    ],
    // 退出
    'sso_logout'                => [
        'class'  => 'Sso',
        'method' => 'logout'
    ],
    // 支付
    'pay'                       => [
        'class'  => 'Pay',
        'method' => 'pay'
    ],
    // 支付宝支付
    'alipay'                    => [
        'class'  => 'Pay',
        'method' => 'alipay'
    ],
    // 财务通支付
    'tenpay'                    => [
        'class'  => 'Pay',
        'method' => 'tenpay'
    ],
    // 快递查询接口
    'express'                   => [
        'class'  => 'express',
        'method' => 'send_express'
    ]
    ,
    // 快递查询接口
    'call_back'                 => [
        'class'  => 'express',
        'method' => 'call_back'
    ]
    ,
    // 快递查询接口
    'call'                      => [
        'class'  => 'express',
        'method' => 'call'
    ],
    // 临时测试
    'test'                      => [
        'class'  => 'Index',
        'method' => 'test'
    ],
    // 临时测试
    'notify'                    => [
        'class'  => 'Index',
        'method' => 'notify'
    ],
    // 二维码
    'qrcode'                    => [
        'class'  => 'Index',
        'method' => 'qrcode'
    ],
    // 接收微信回调返回的code
    'weixin_code'               => [
        'class'  => 'Project',
        'method' => 'weixin_code'
    ],
    // vdao_weixin 余额充值微信支付回调
    'recharge_wxpaynot'         => [
        'class'  => 'Project',
        'method' => 'recharge_wxpaynot'
    ],
    // 订单支付，用于微信公众号支付
//    'order.pay'                 => [
//        'class'    => 'Order'
//        , 'method' => 'pay'
//    ],
//    // 订单支付结果同步返回
//    'order.pay.return'          => [
//        'class'  => 'order',
//        'method' => 'pay_return'
//    ],
    // 获取微信的access token
    'wechat.get.token'          => [
        'class'    => 'Wechat'
        , 'method' => 'getAccessToken'
    ]
    // 获取微信分享的签名信息
    , 'wechat.get.sign.package' => [
        'class'    => 'Wechat'
        , 'method' => 'getSignPackage'
    ]
    , 'fuck.search.jiajie'      => [
        'class'    => 'Jiajie'
        , 'method' => 'Search'
    ]
];
