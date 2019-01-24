<?php

// 在系统最开始的时候执行，控制器尚未执行
$a_config_plan['pre_system'] = [
    // 跨域处理
    function() {
    }
];
// 在控制器实例化之后立即执行，控制器的任何方法都还尚未调用（除构造函数）
$a_config_plan['pre_controller'] = [
    function () {
    }
];