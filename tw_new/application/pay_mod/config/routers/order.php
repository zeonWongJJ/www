<?php
/**
 * 路由定义
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 */

$resource = \utils\Router::resources('order', 'order'); // [refer]

$routes = [
    // 定义增删改查外的路由
    'order.pay'        => [
        'class'  => 'order',
        'method' => 'pay'
    ],

    // 获取订单签名，用于另外调起订单时调用
    'order.sign.get'   => [
        'class'  => 'order',
        'method' => 'getSign'
    ],

    // 订单支付结果同步返回
    'order.pay.return' => [
        'class'  => 'order',
        'method' => 'pay_return'
    ],

    // 微信支付回调
    'pay.wxpaynot'     => [
        'class'  => 'order',
        'method' => 'wxpaynot'
    ]
];

return array_merge($routes, $resource);
