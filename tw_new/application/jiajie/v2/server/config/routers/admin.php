<?php
/**
 * 路由定义
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 */

$resource = \utils\Router::resources('admin', 'admin'); // [refer]

$routes = [
    // 定义增删改查外的路由
    // 用户开启、关闭
    'admin.enable'   => [
        'class'  => 'admin',
        'method' => 'adminEnable'
    ],
    // 管理员操作日志获取
    'admin.log.list' => [
        'class'  => 'admin',
        'method' => 'adminLogList'
    ]
];

return array_merge($routes, $resource);
