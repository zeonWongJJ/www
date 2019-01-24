<?php
$a_db_config['db'] = [
    'server'     => getenv('MYSQL_HOST') ?: '172.18.0.4:3306',
    'user'       => getenv('MYSQL_USER_NAME') ?: 'root',
    'password'   => getenv('MYSQL_USER_PWD') ?: '123456',
    'database'   => getenv('MYSQL_DB_NAME') ?: 'qiqing',
    'charset'    => 'UTF8',
    'persistent' => true,
    'prefix'     => getenv('MYSQL_TB_PREFIX') ?: 'qq_'
];
