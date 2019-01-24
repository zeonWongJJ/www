<?php
/**
 * 路由定义
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 */

$resource = \utils\Router::resources('message', 'message'); // [refer]

$routes = [
     // 定义增删改查外的路由
     'message.unread'   =>  [
         'class'    =>  'message',
         'method'   =>  'getUnReadCount'
     ]
];

return array_merge($routes, $resource);