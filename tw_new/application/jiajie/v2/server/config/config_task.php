<?php
/**
 * 定时任务配置
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 *
 *
 *   * * * * * * *    //格式 :秒 分 时 天 月 年 周
 * 10 * * * * * *    //表示每一分钟的第10秒运行
 * /10 * * * * * *    //表示每10秒运行
 * /1 * 15,16 * * * * //表示 每天的15点,16点的每一秒运行
 *
 */
$db_hot_port = getenv('MYSQL_HOST') ?: '172.18.0.4:3306';
list($host, $port) = explode(':', $db_hot_port);

return [
    //任务列表
    'task_list' => [
        //key为任务名，多任务下名称必须唯一
        'checkAssign' => [
            'callback'        => ['task\\CheckAssign', 'run'],//任务调用:类名和方法
            'worker_memory'   => '512M',//指定任务进程最大内存  系统默认为512M
            'worker_pthreads' => false,//开启任务进程的多线程模式
            'worker_count'    => 1,//任务的进程数 系统默认1
            'crontab'         => '/60 * * * * * *',//crontad格式 :秒 分 时 天 月 年 周
        ],
    ],
    //'php_path'=>'php',//可手动为php设置环境变量
    'db'        => [
        'type'            => 'mysql',
        'username'        => getenv('MYSQL_USER_NAME'),
        'password'        => getenv('MYSQL_USER_PWD'),
        'host'            => $host,
        'port'            => $port,
        'name'            => getenv('MYSQL_DB_NAME') ?: 'qiqing',
        // 数据库编码默认采用utf8
        'charset'         => 'utf8',
        // 数据库表前缀
        'prefix'          => getenv('MYSQL_TB_PREFIX') ?: 'qq_',
        // 开启断线重连
        'break_reconnect' => true,
    ],

];
