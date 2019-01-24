<?php
/**
 * 预约路由
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

$resource = \utils\Router::resources('user.subscribe', 'subscribe'); // [refer]

$routes = [
    // 定义增删改查外的路由
    'user.subscribe.cancel' => [
        'class' => 'subscribe',
        'method' => 'cancel',
    ],
];

return array_merge($resource, $routes);
