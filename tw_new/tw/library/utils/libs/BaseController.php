<?php
/**
 * 公共基控制器
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */

namespace utils;

use model\TokenModel;
use utils\ide\Db;
use utils\interfaces\BaseRepositoryInterface;
use utils\traits\BaseRepositoryTrait;
use utils\traits\BaseTrait;

/**
 * Class BaseController
 * @package utils
 */
class BaseController extends \TW_Controller implements BaseRepositoryInterface
{
    use BaseRepositoryTrait, BaseTrait;

    /** @var array */
    public $_ignore_node = [];
    /** @var Response */
    protected $response;
    /** @var Request */
    protected $request;
    /** @var Db */
    protected $db;
    /** @var BaseRepository */
    protected $repository;
    /**
     * 错误信息存放
     * @var array
     */
    protected $message = [];

    private $_controller;
    private $_method;

    /**
     * BaseController constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->response = app('response');
        $this->request  = app('request');

        app('db', $this->db);
        app('router', $this->router);
        app('load', $this->load);
        app('general', $this->general);
        app('error', $this->error);
        app('ctrl', $this);

        $controller_explode = explode('/', $this->router->get_controller());
        $this->_controller = end($controller_explode);

        // 注册数据仓库
        if ($this->repository && class_exists($this->repository)) {
            $this->repository = new $this->repository;
        }

        if (!\in_array($this->router->get_method(), $this->_ignore_node, true)) {
            $this->checkPermission();
        }
    }

    /**
     * 限制IP操作次数，3秒内只允许发起6次请求
     * @return mixed
     */
    private function _limitOPTimes()
    {
        $times = $this->cache('ip.op.limit.' . get_client_ip());
        if ($times > 12) {
            return $this->error('你操作太快啦，真的是个人类吗？');
        }
        $this->cache('ip.op.limit.' . get_client_ip(), $times + 1, 2);
    }

    /**
     * 用户权限判断
     */
    public function checkPermission($token = '')
    {
        $map['rule_controller'] = str_replace('_ctrl', '', $this->_controller);
        $map['rule_action']     = $this->router->get_method();
        if (method_exists($this, 'getMethodRouterParams')) {
            $router_params = $this->getMethodRouterParams($this->router->get_method());
            if (is_callable($router_params)) {
                $map['rule_router_param'] = $router_params();
            }
        }
        $rule_info = $this->db->get_row(get_table('rule'), $map);
        /** @var TokenModel $token_model */
        $token_model = Factory::getFactory('token');
        $user_info   = $token_model->parseToken($token);
        /** @noinspection TypeUnsafeComparisonInspection */
        if ('admin' == $user_info['user_type_key']) {
            return true;
        }
        // todo:: 临时关闭权限认证 只验证是否登录
        if ((int)$rule_info['rule_level'] === 2) {
//            // 只有接口验证等级为2时需要认证权限分配
            $has_permission = $this->db->get_total('jiajie_role_assign', ['role_id' => $user_info['role_id'], 'rule_id' => $rule_info['id']]);
            $has_permission || $this->error('没有权限!', [
                'rule'      => $map
                , 'role_id' => $user_info['role_id']
            ]);
        }
    }
}
