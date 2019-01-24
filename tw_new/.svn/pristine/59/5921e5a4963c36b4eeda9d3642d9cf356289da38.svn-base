<?php
/**
 * 应用实例
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */

namespace utils;

/**
 * Class Application
 * @package utils
 */
class Application
{
    protected static $app;

    /**
     * 注册的常量存放
     * @var array
     */
    protected static $constance = [];

    /**
     * 访问的接口地址
     * @var string
     */
    protected $uri = '';

    /**
     * GET参数
     * @var array
     */
    protected $query_params = [];

    /**
     * 运行系统
     */
    public function run()
    {
        ini_set('display_errors', 1);
        ini_set('error_reporting', 'E_ALL & ~E_NOTICE'); // https://blog.csdn.net/yygzs2012/article/details/62439221?utm_source=copy
        date_default_timezone_set('PRC');

        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: x-requested-with,content-type,X-Token, X-SOURCE-SIGN');
        header('Access-Control-Allow-Credentials: true');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit('ok');
        }

        // session设置
        if (file_exists('/data/tmp/project_session')) {
            ini_set('session.save_path', '/data/tmp/project_session');
        }

        \defined('APPPATH') || \define('APPPATH', ROOT_PATH); // 应用路径
        \defined('PROJECTPATH') || \define('PROJECTPATH', APPPATH); // 项目路径
        \defined('CONTPATH') || \define('CONTPATH', APPPATH . 'controller'); // 控制器路径
        \defined('MODELPATH') || \define('MODELPATH', APPPATH . 'model'); // 模型路径

        \defined('TEMPATH') || \define('TEMPATH', PROJECTPATH . 'template/default'); // 模板路径
        \define('TW_', 'TW_'); // 系统核心类前缀，不可修改
        \defined('PROJECTNAME') || \define('PROJECTNAME', 'jiajie'); // 调用公共模块标识
        \defined('SHAREMODELPATH') || \define('SHAREMODELPATH', ROOT_PATH . 'shareModel');

        $tw_framework_dir = APP_DEBUG ? BASEPATH . 'core_debug' : BASEPATH . 'core';
        require BASEPATH . 'core/base.php'; // 加载柒度框架
    }
}
