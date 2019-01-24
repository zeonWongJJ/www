<?php
/**
 * Created by PhpStorm.
 * User: rusice
 * Date: 2018/7/16
 * Time: 14:36
 */

namespace utils;

class Factory
{
    protected static $register = [];

    protected static $namespaceMap = [
        'model'      => 'model\#class#',
        'repository' => 'repositories\#class#'
    ];

    /**
     * 执行创建
     * @param string $className
     * @param string $map
     * @return
     */
    public static function getFactory($className, $map = 'model')
    {
        if (!isset(self::$namespaceMap[$map])) {
            throw new \RuntimeException("未指定{$map}的创建源!");
        }
        if (strpos($className, '\\')) {
            $temp = explode('\\', $className);
            foreach ($temp as &$str) {
                $str = ucfirst($str);
            }
        }
        $namespace = str_replace('#class#',
            isset($temp) ? implode($temp, '\\') : ucfirst($className),
            self::$namespaceMap[$map]);
        if (isset(self::$register[$namespace])) {
            return self::$register[$namespace];
        }

        // 处理后缀
        $namespace .= ucfirst($map);
        if (class_exists($namespace)) {
            $instance = new $namespace;
            self::$register[$namespace] = $instance;
            return $instance;
        }
        throw new \RuntimeException("找不到要创建的类{$namespace}");
    }
}
