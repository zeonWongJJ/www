<?php
/**
 * 路由定义
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 */

$resource = \utils\Router::resources('service', 'service'); // [refer]

$routes = [
    // 定义增删改查外的路由
    // 服务上架
    'service.shelf'         => [
        'class'  => 'service',
        'method' => 'shelf'
    ],

    // 服务下架
    'service.shift'         => [
        'class'  => 'service',
        'method' => 'shift'
    ],

    // 购买服务
    'service.buy'           => [
        'class'  => 'service',
        'method' => 'order'
    ],

    // 服务审核
    'service.examine'       => [
        'class'  => 'service',
        'method' => 'examine'
    ],
    // 获取未通过理由
    'service.nopass.reason' => [
        'class'  => 'service',
        'method' => 'nopassReason'
    ]
];

return array_merge($routes, $resource);