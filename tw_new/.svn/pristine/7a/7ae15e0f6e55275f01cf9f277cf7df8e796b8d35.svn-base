<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

define('BASEPATH', '/tw/');
define('ROOT_PATH', __DIR__ . '/../');
define('__ROOT__', __DIR__ . '/');
define('PROJECTPATH', ROOT_PATH);
define('CONFIGPATH', __DIR__ . '/../config');
require ROOT_PATH . 'vendor/autoload.php';
require BASEPATH . 'library/utils/bootstrap.php';
include BASEPATH . 'core/Common.php';
include __DIR__ . '/../utils/Db.php';

$orders = \utils\Db::getInstance()->getDB()->get(get_table('order'));
var_dump($orders);
