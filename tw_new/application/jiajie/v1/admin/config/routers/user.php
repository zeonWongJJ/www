<?php

return array_merge(\utils\Router::admin('user', 'user'), [
    // 用户登陆
    'user.login'  => [
        'class'  => 'PC_User',
        'method' => 'login'
    ],
    // 显示用户积分列表
    'user.show_jifen_list'   =>  [
        'class' =>  'PC_User',
        'method'   =>   'show_jifen_list'
    ],
    // 显示用户积分列表
    'user.show_balance_list'   =>  [
        'class' =>  'PC_User',
        'method'   =>   'show_balance_list'
    ],
    'member.type' => [
        'class'  => 'PC_User',
        'method' => 'fuck_test'
    ]
]);