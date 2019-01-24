<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

define('BASEPATH', '/tw/');
define('ROOT_PATH', __DIR__ . '/../');
define('__ROOT__', __DIR__ . '/');
define('PROJECTPATH', ROOT_PATH);
define('CONFIGPATH', __DIR__ . '/../config');
require ROOT_PATH . 'vendor/autoload.php';
require BASEPATH . 'library/utils/bootstrap.php';
\utils\Loader::addNamespace('Controller', __DIR__ . '/../controller/');
\utils\Loader::addNamespace('utils', __DIR__ . '/../utils/');
app('app')->run();
