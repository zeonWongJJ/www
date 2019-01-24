<?php
/**
 * 定时任务启动
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

defined('BASEPATH') || define('BASEPATH', '/tw/');
defined('CONFIGPATH') || define('CONFIGPATH', __DIR__ . '/../config');
defined('ROOT_PATH') || define('ROOT_PATH', __DIR__ . '/../');
defined('START_PATH') || define('START_PATH', __DIR__ . '/../');
defined('PROJECTPATH') || define('PROJECTPATH', ROOT_PATH);
defined('__ROOT__') || define('__ROOT__', __DIR__ . '/');
require_once BASEPATH . 'library/utils/bootstrap.php';
require_once BASEPATH . 'core/Common.php';
include_once ROOT_PATH . 'utils/taskPHP/src/taskphp/base.php';
\utils\Loader::addNamespace('task', __DIR__ . '/../task/');
$config = include CONFIGPATH . '/config_task.php';
taskphp\Config::load($config); //加载配置信息
// app('app')->run();
taskphp\App::run(); //运行框架
