<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

$resource = \utils\Router::resources('msm.template', 'MSMTemplate'); // [refer]

$routes = [
    // 定义增删改查外的路由
];

return array_merge($routes, $resource);
