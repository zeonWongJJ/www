<?php
/**
 * utils模块启动器
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */

namespace utils;

$is_debug = getenv('APP_DEBUG') == 1;
(isset($_GET['debug']) && $_GET['debug']) && $is_debug = true;

\define('APP_DEBUG', $is_debug);

// 加载自动加载器
include __DIR__ . '/libs/Loader.php';

// 加载助手函数库
include __DIR__ . '/Helpers.php';

// 注册自动加载
Loader::register();

// 手动注册namespace
Loader::addNamespace('repositories', PROJECTPATH . '/repositories/');
Loader::addNamespace('model', PROJECTPATH . '/model/');
Loader::addNamespace('domain', PROJECTPATH . '/domain/');

// todo::composer自动加载不到这些文件，待排查
if (is_dir(__DIR__ . '/../vendor/guzzlehttp')) {
    include_once __DIR__ . '/../vendor/guzzlehttp/guzzle/src/functions.php';
    include_once __DIR__ . '/../vendor/guzzlehttp/psr7/src/functions.php';
    include_once __DIR__ . '/../vendor/guzzlehttp/promises/src/functions.php';
}

// 容器处理
app('app', new Application());
app('request', Utils::factory('request'));
app('response', Utils::factory('response'));
