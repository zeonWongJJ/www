<?php

namespace utils\libs\server;

/**
 * Class RpcServer
 * @package utils\libs\server
 */
class RpcServer
{
    /**
     * 注册RPC服务
     * 从路由中获取模块名.组件名，读取组件的加载文件server.php
     */
    public function register($name = '')
    {
        $server_file = PROJECTPATH . 'server.php';
        if (file_exists($server_file)) {
            /** @noinspection PhpIncludeInspection */
            $providers = include $server_file;
            if (isset($providers[$name])) {
                // 获取注册的RPC服务提供者类

            }
        }
    }
}