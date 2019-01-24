<?php
/**
 * 路由定义
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 */

$resource = \utils\Router::resources('auth.rule', 'rule'); // [refer]

$routes = [
    // 定义增删改查外的路由
    'auth.rule.level' => [
        'class'  => 'rule',
        'method' => 'level'
    ],

    'auth.rule.enable' => [
        'class'  => 'rule',
        'method' => 'changeEnable'
    ]
];

return array_merge($routes, $resource);