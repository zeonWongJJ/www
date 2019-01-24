<?php

namespace utils;

/**
 * Class Service
 * @package utils
 */
class Service
{
    public static $instance;
    protected $uri = '';
    protected $params = [];

    /**
     * Gateway constructor.
     * @param $uri
     * @param array $params
     */
    private function __construct($uri, array $params = [])
    {
        $this->uri    = $uri;
        $this->params = $params;
    }

    /**
     * @param $service_name
     * @return array
     */
    public static function register($service_name)
    {
        $service = explode('.', trim(trim($service_name, '/'), '.'));
        $module  = $controller = $action = 'index';
        if (\count($service) >= 3) {
            list($module, $controller, $action) = $service;
        } else if (\count($service) === 2) {
            list($module, $controller) = $service;
        } else if (\count($service) === 1) {
            $module = $service[0];
        }

        return [$module, $controller, $action];
    }
}