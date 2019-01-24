<?php
/**
 * 路由定义
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 */

$resource = \utils\Router::resources('demand', 'demand'); // [refer]

$routes = [
    // 定义增删改查外的路由
    'demand.examine'    => [ // 审核服务
                             'class'  => 'demand',
                             'method' => 'examine',
    ],
    // 服务商接单接口
    'demand.receipt'    => [
        'class'  => 'demand',
        'method' => 'receipt',
    ],
    // 获取审核不通过的理由
    'demand.get.reason' => [
        'class'  => 'demand',
        'method' => 'getNoPassReason',
    ],
    // 快速预约
    'fast.subscribe'    => [
        'class'  => 'demand',
        'method' => 'fastSubscribe',
    ],
    // 取消预约
    'cancel.subscribe'  => [
        'class' =>  'Demand',
        'method' => 'cancelSubscribe'
    ],
    // 按照定位排序需求
    'demand.list.lal'   => [
        'class'  => 'demand',
        'method' => 'getListByLaL'
    ]
];

return array_merge($routes, $resource);
