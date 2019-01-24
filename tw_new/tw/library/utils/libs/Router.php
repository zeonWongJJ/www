<?php

namespace utils;

class Router
{
    /**
     * 生成资源路由
     * @param $uri
     * @param $class
     * @param array $target
     * @return array
     */
    public static function resources($uri, $class, $target = [])
    {
        $_map = $map = [
            'add'    => 'insert',
            'update' => 'update',
            'delete' => 'delete',
            'get'    => 'getOne',
            'list'   => 'getList',
            'count'  => 'getCount',
        ];

        if ($target) {
            $map_keys            = array_keys($map);
            $map_array_intersect = array_intersect($map_keys, $target);

            $_map = [];
            foreach ($map_array_intersect as $key) {
                $_map[$key] = $map[$key];
            }
        }


        $router = [];
        foreach ($_map as $route => $method) {
            $router[$uri . '.' . $route] = [
                'class'  => $class,
                'method' => $method
            ];
        }

        return $router;
    }

    /**
     * 生成后台转跳路由
     * @param $uri
     * @param $class
     * @param array $target
     * @return array
     */
    public static function admin($uri, $class, $target = [])
    {
        $_map = $map = [
            'insert'   => 'insert',
            'update'   => 'update',
            'delete'   => 'delete',
            'get_one'  => 'getOne',
            'get_list' => 'getList'
        ];

        if ($target) {
            $map_keys            = array_keys($map);
            $map_array_intersect = array_intersect($map_keys, $target);

            $_map = [];
            foreach ($map_array_intersect as $key) {
                $_map[$key] = $map[$key];
            }
        }


        $router = [];
        foreach ($_map as $route => $method) {
            $router[$uri . '.' . $route] = [
                'class'  => 'PC_' . ucfirst($class),
                'method' => $method
            ];
        }

        return $router;

    }
}