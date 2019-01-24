<?php
/**
 * 路由定义
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 */

$resource = \utils\Router::resources('comment', 'comment'); // [refer]

$routes = [
    // 定义增删改查外的路由
    'comment.auditing'       => [
        'class'  => 'comment',
        'method' => 'auditing'
    ]
    // 检查当前评论是否可以操作
    , 'comment.check.canIdo' => [
        'class'    => 'comment'
        , 'method' => 'checkHasComment'
    ],
    // 获取指定服务的评论列表
    'service.comment.list'   => [
        'class'  => 'Comment',
        'method' => 'ServiceCommentList'
    ]
];

return array_merge($routes, $resource);
