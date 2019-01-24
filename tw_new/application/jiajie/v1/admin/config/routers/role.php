<?php

$resource = \utils\Router::admin('role', 'role'); // [refer]

$routes = [
    // 角色组分配权限
    'role.allow' => [
        'class'  => 'PC_Role',
        'method' => 'allow'
    ]
];


return array_merge($routes, $resource);
