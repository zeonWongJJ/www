<?php
/**
 * utils工厂类
 *
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 * @copyright 柒度信息科技
 */
namespace utils;

class Utils
{
    protected static $_factory = [];

    /**
     * @param $name
     * @param array $args
     * @return mixed
     */
    public static function factory($name, $args = [])
    {
        $namespace = __NAMESPACE__ . '\\' . ucfirst($name);
        if (class_exists($namespace)) {
            self::$_factory[$name] = new $namespace(...$args);
            return self::$_factory[$name];
        }
    }

    /**
     * 响应
     * @return Response
     */
    public static function response()
    {
        return self::factory('response');
    }

    /**
     * 容器
     * @return mixed
     */
    public static function app()
    {
        return self::factory('app');
    }
}
