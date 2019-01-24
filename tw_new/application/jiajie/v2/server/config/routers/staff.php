<?php
$resource = \utils\Router::resources('store.staff', 'Staff'); // [refer] // [refer]

$routes = [
    // 修改店员信息
    'staff.update'         => [
        'class'  => 'Store',
        'method' => 'updateStaffInfo'
    ],
    // 获取指定店员的信息
    'store.staff.info.get' => [
        'class'  => 'Store',
        'method' => 'getStaffInfo'
    ],
    // 设置店员为管理员
    'staff.set.admin'      => [
        'class'  => 'Store',
        'method' => 'setStaffAdmin'
    ],
    // 获取店铺店员列表
    'store.clerk.list'     => [
        'class'  => 'Store',
        'method' => 'getStoreClerkList'
    ],
    // 移除店员
    'store.staff.remove'   => [
        'class'  => 'Store',
        'method' => 'removeStoreStaff'
    ],
    // 查看指定店员的服务记录
    'staff.service.record' => [
        'class'  => 'Store',
        'method' => 'getStaffServiceRecord'
    ],
    'staff.shenhe'         => [
        'class'  => 'Staff',
        'method' => 'shenhe'
    ],
    'staff.get.allocation' => [
        'class'  => 'staff',
        'method' => 'getAllocationList'
    ],
    'staff.overview'       => [
        'class'  => 'staff',
        'method' => 'staffOverview'
    ]
];

return array_merge($resource, $routes);
