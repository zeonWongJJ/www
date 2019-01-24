<?php

ini_set('display_errors', 1);
date_default_timezone_set('PRC');

// 在系统最开始的时候执行，控制器尚未执行
$a_config_plan['pre_system'] = [
    // 跨域处理
    function() {
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Credentials: true');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit('ok');
        }
    }
];
// 在控制器实例化之后立即执行，控制器的任何方法都还尚未调用（除构造函数）
$a_config_plan['pre_controller'] = [
    function () {
        // 注入应用

        // 访问操作权限检查
//        $a_filter_login = ['login', 'logout', 'register'];
//        if (!in_array(app('app')->instance->router->get_index(), $a_filter_login)) {
//            app('app')->checkToken();
//        }
    }
];