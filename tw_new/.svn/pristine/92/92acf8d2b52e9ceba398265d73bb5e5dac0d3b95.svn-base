<?php
/**
 * 路由定义
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 */

$resource = \utils\Router::resources('store', 'store'); // [refer]

$routes = [
    // 获取店铺下的所有服务
    'store.get.services'     => [
        'class'  => 'store',
        'method' => 'getServers'
    ],
    // 获取店铺的今日订单
    'store.today.order'      => [
        'class'  => 'store',
        'method' => 'get_today_order'
    ],
    // 获取店铺的订单列表
    'store.order.list'       => [
        'class'  => 'Store',
        'method' => 'getOrderList'
    ],
    // 更新订单状态
    'order.change.status'    => [
        'class'  => 'Store',
        'method' => 'changeOrderStatus'
    ],
    // 获取店铺订单统计信息
    'store.order.statistics' => [
        'class'  => 'store',
        'method' => 'getStoreOrderStatistics'
    ],
    // 店铺启用/暂用
    'store.auditing'         => [
        'class'  => 'store',
        'method' => 'updateStoreAuditing'
    ],
    // 审核店铺
    'store.shenhe'           => [
        'class'  => 'store',
        'method' => 'shenHe'
    ],
    // 指派订单到指定店员
    'appointed.order'        => [
        'class'    => 'store'
        , 'method' => 'appointedOrder'
    ]
    // 获取店员详细资料
    , 'store.clerk.get'      => [
        'class'    => 'Store'
        , 'method' => 'clerkInfoGet'
    ]
    // 获取店铺操作规则列表
    , 'store.rule.list'      => [
        'class'    => 'Store'
        , 'method' => 'storeRuleList'
    ]
    // 获取店铺收益记录
    , 'store.income.log'     => [
        'class'    => 'Store'
        , 'method' => 'incomeLog'
    ]
    , 'get.income.log'       => [
        'class'    => 'Store'
        , 'method' => 'getInComeLog'
    ]
    // 获取店铺类型
    , 'store.nature'         => [
        'class'    => 'Store'
        , 'method' => 'getStoreNature'
    ]
    // 店铺自动接单开关切换
    , 'store.receipt.toggle' => [
        'class'    => 'Store'
        , 'method' => 'toggleReceipt'
    ],
    // 用户申请开店
    'user.store.add'         => [
        'class'  => 'Store',
        'method' => 'insert'
    ]
    // 删除订单
    , 'store.delete.order'   => [
        'class'    => 'Store'
        , 'method' => 'deleteOrder'
    ]
    // 获取店铺的订单结算设置
    , 'store.get.customize'  => [
        'class'    => 'Store'
        , 'method' => 'getStoreCustomize'
    ],
    'store.staff.income'     => [
        'class'  => 'Store',
        'method' => 'getStaffIncome'
    ]
];

return array_merge($routes, $resource);
