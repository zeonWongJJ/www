<?php
/**
 * 视图控制器
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace utils;

use utils\ide\Db;
use utils\traits\BaseTrait;
use utils\traits\RenderTrait;

/**
 * Class ViewController
 * @package utils
 */
class ViewController extends \TW_Controller
{
    use RenderTrait;
    use BaseTrait;

    /** @var Response */
    protected $response;
    /** @var Request */
    protected $request;
    /** @var Db */
    protected $db;

    protected $controller_name;
    protected $method_name;

    protected $assets = [];

    public function __construct()
    {
        parent::__construct();

        $this->response = app('response');
        $this->request  = app('request');

        app('db', $this->db); // 注入db服务到容器中，便于在数据仓库中使用

        $this->controller_name = str_replace(['PC_', '_ctrl'], '', $this->router->get_controller());
        $this->method_name     = hump_to_line($this->router->get_method());

        $this->assets = [
            'customize_css' => strtolower($this->controller_name . '_' . $this->method_name),
            'customize_js'  => [
                strtolower($this->controller_name . '_' . $this->method_name),
            ]
        ];

    }
}