<?php
/**
 * Created by PhpStorm.
 * User: rusice
 * Date: 2018/7/14
 * Time: 23:51
 */

namespace task;


abstract class BaseTask implements TaskInterface
{
    abstract function run();

    public function display($msg, $common = '')
    {
        echo($msg . PHP_EOL);
        if ($common) {
            echo '请使用命令:' . $common;
        }
        exit;
    }
}