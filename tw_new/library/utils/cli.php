<?php
/**
 * CLI模式下运行的引导
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace utils;

\define('AUTHOR_NAME', 'rusice');
\define('AUTHOR_EMAIL', 'liruizhao970302@outlook.com');
\define('__PATH__', __DIR__ . '/../../');
// 加载自动加载器
include __DIR__ . '/libs/Loader.php';

// 注册自动加载
Loader::register();

// 手动注册namespace
Loader::addNamespace('task', __DIR__ . '/../task/');

$arguments = [];

$arguments['params'] = [];
foreach ($argv as $k => $arg) {
    if ($k == 1) {
        $arguments['task'] = $arg;
    } elseif ($k == 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

$task_namespace = '\task\\' . ucfirst($arguments['task']);

if (class_exists($task_namespace)) {
    $task_namespace = new $task_namespace;
    $method = $arguments['action'];
    if (\is_callable([$task_namespace, $method])) {
        $task_namespace->$method($arguments['params']);
    }
} else {
    throw new \RuntimeException("task脚本{$task_namespace}不能加载!");
}
