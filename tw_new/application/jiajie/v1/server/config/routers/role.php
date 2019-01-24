<?php

$resource = \utils\Router::resources('auth.role', 'role');

$routes = [
    // 角色组分配权限
    'auth.role.assign' => [
        'class'  => 'role',
        'method' => 'assign'
    ],
    'auth.role.assigned'    =>  [
        'class'  => 'role',
        'method' => 'assigned'
    ],
    // 角色组开关
    'auth.role.enable' => [
        'class'  => 'role',
        'method' => 'enable'
    ]
];

return array_merge($routes, $resource);