<?php
<<<<<<< .mine
$a_db_config['db'] = array(
	'server' => '127.0.0.1',
	'user' => 'root',
	'password' => 'root',
	'database' => 'wofei',
	'charset' => 'UTF8',
	'persistent' => true,
	'prefix' => 'wf_'
);
=======
$a_db_config['db'] = [
    'server'     => getenv('MYSQL_HOST_NAME') ?: '172.18.0.4:3306',
    'user'       => getenv('MYSQL_USER_NAME') ?: 'root',
    'password'   => getenv('MYSQL_USER_PWD') ?: '123456',
    'database'   => getenv('MYSQL_DB_NAME') ?: 'qiqing',
    'charset'    => 'UTF8',
    'persistent' => true,
    'prefix'     => getenv('MYSQL_TB_PREFIX') ?: 'qq_',
>>>>>>> .r18167

];

$a_db_config['db_mysql'] = [
    'server'     => getenv('MYSQL_HOST_NAME') ?: '172.18.0.4:3306',
    'user'       => getenv('MYSQL_USER_NAME') ?: 'root',
    'password'   => getenv('MYSQL_USER_PWD') ?: '123456',
    'database'   => getenv('MYSQL_DB_NAME') ?: 'qiqing',
    'charset'    => 'UTF8',
    'persistent' => true,
    'prefix'     => getenv('MYSQL_TB_PREFIX') ?: 'qq_',

];