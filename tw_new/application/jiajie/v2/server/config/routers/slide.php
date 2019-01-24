<?php
/**
 * 路由定义
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 */

$resource = \utils\Router::resources('slide', 'slide'); // [refer]

$routes = [
     // 定义增删改查外的路由
    'slide.display' => [
        'class' => 'slide',
        'method' => 'display',
    ],

    // 删除图片
    'slide.remove.image' => [
        'class'  => 'slide',
        'method' => 'remove_image'
    ]
];

return array_merge($routes, $resource);