<?php
/**
 * 容器实现
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */
namespace utils;

class Container
{
    /**
     * 容器存放
     * @var array
     */
    protected static $app = [];

    /**
     * 容器注册
     * @param $alias
     * @param $class
     * @param array $args
     * @return bool
     */
    public static function register($alias, $class, array $args = []): bool
    {
        if (\is_object($class)) {
            self::$app[$alias] = $class;
        } else if (class_exists($class)) {
            self::$app[$alias] = new $class(...$args);
        }

        return true;
    }

    /**
     * 获取容器
     * @param $alias
     * @return mixed
     */
    public static function getApp($alias)
    {
        if (isset(self::$app[$alias])) {
            return self::$app[$alias];
        }
        return false;
    }
}
