<?php
/**
 * 应用入口文件
 *
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */

define('BASEPATH', '/tw/');
define('ROOT_PATH', __DIR__ . '/../');
define('__ROOT__', __DIR__ . '/');
define('PROJECTPATH', ROOT_PATH);
define('CONFIGPATH', __DIR__ . '/../config');
/** @noinspection PhpIncludeInspection */
require BASEPATH . 'library/utils/bootstrap.php';
\utils\Loader::addNamespace('Controller', __DIR__ . '/../controller/');
app('app')->run();
