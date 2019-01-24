<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

use JPush\Client as JPush;

$uid = $_GET['uid'] ?? 208;
defined('ROOT_PATH') || define('ROOT_PATH', __DIR__ . '/../');
defined('CONFIGPATH') || define('CONFIGPATH', __DIR__ . '/../config');

spl_autoload_register(function ($class) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = ROOT_PATH . 'utils/jpush/src/' . $path . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

include CONFIGPATH . '/config_jpush.php';
$client = new JPush($config_jpush['app_key'], $config_jpush['master_secret'], ROOT_PATH . 'runtime/jpush.log');
$extra  = [
    'url'   => trim(getenv('TOUCH_DOMAIN'), '/') . '/#/notice',
    'route' => 'notice'
];
$result = $client->push()
    ->setPlatform(['ios', 'android'])
    ->addAlias((string)$uid)//androidAlias 别名，到时候直接用用户ID
//    ->addAllAudience(['alias' => ['qidu']])
    ->setNotificationAlert('推送出去了')
    ->iosNotification('推送出去了', [
        'sound'  => 'sound',
        'badge'  => '+1',
        'extras' => $extra
    ])
    ->androidNotification('推送出去了', [
        'extras' => array_merge($extra, [
            'badge' => '+1'
        ])
    ])->send();
var_dump($result);
