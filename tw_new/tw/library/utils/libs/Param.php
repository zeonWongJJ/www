<?php
/**
 * Created by PhpStorm.
 * User: rusice
 * Date: 2018/7/7
 * Time: 10:13
 */

namespace utils;

class Param
{
    /**
     * @var array
     */
    private $route_config = [];

    /**
     * 获取模块
     * @return string
     */
    public function route_module()
    {
        $m = isset($_GET['m']) && !empty($_GET['m']) ? $_GET['m'] : (isset($_POST['m']) && !empty($_POST['m']) ? $_POST['m'] : '');
        $m = $this->safe_deal($m);
        if (empty($m)) {
            return $this->route_config['m'] ?? 'index';
        }
        if(\is_string($m)) {
            return $m;
        }
    }

    /**
     * 获取控制器
     * @return mixed|string
     */
    public function route_controller()
    {
        $c = isset($_GET['c']) && !empty($_GET['c']) ? $_GET['c'] : (isset($_POST['c']) && !empty($_POST['c']) ? $_POST['c'] : '');
        $c = $this->safe_deal($c);
        if (empty($c)) {
            return $this->route_config['c'] ?? 'index';
        }
        if(\is_string($c)) {
            return $c;
        }
    }

    /**
     * 获取方法
     * @return mixed|string
     */
    public function route_action()
    {
        $a = isset($_GET['a']) && !empty($_GET['a']) ? $_GET['a'] : (isset($_POST['a']) && !empty($_POST['a']) ? $_POST['a'] : '');
        $a = $this->safe_deal($a);
        if (empty($a)) {
            return $this->route_config['a'] ?? 'index';
        }
        if(\is_string($a)) {
            return $a;
        }
    }

    /**
     * 安全处理函数 处理m,a,c
     * @param $str
     * @return mixed
     */
    private function safe_deal($str)
    {
        return str_replace(array('/', '.'), '', $str);
    }
}