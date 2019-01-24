<?php
/**
 * 家洁项目基础控制器
 * @version 2.0-release
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace Controller;

use model\RoleModel;
use model\TokenModel;
use utils\Factory;

/**
 * Class Application
 */
class Application extends \utils\BaseController
{
    /**
     * 用户权限判断
     * @param string $token
     * @return bool|mixed
     */
    public function checkPermission($token = '')
    {
        $limit = $this->cache('ip.sensitivity.' . $this->request->ip(1));
//        if ($limit > 5) {
//            return $this->error('尝试无权操作过多，您的访问已被拦截!');
//        }
        /** @var TokenModel $token_model */
        $token_model = Factory::getFactory('token');
        $user_info   = $token_model->parseToken($token);

        if (TokenModel::isAdminSource()) {
            return true;
        }

        $map['rule_controller'] = str_replace('_ctrl', '', $this->router->get_controller());
        $map['rule_action']     = $this->router->get_method();
        if (method_exists($this, 'getMethodRouterParams')) {
            $router_params = $this->getMethodRouterParams($this->router->get_method());
            if (\is_callable($router_params)) {
                $map['rule_router_param'] = $router_params();
            }
        }

        if (!$rule_info = $this->db->get_row(get_table('rule'), $map)) {
            return $this->error('AUTH节点未定义', 403, $map);
        }

        // 只有接口验证等级为2时需要认证权限分配
        if ((int)$rule_info['rule_level'] === 2) {
            $role_info = $this->db->get_row(get_table('role'), ['id' => $user_info['role_id']]);
            if ($staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info['user_id']])) {
                switch ((int)$staff_row['user_type']) {
                    case 1:
                        $role_info = $this->db->get_row(get_table('role'), ['role_key' => RoleModel::R_WAITER], 'id, role_auth');
                        break;
                    case 2:
                        $role_info = $this->db->get_row(get_table('role'), ['role_key' => RoleModel::R_SHOP_ADMIN], 'id, role_auth');
                        break;
                    case 3:
                        $role_info = $this->db->get_row(get_table('role'), ['role_key' => RoleModel::R_SHOP_KEEPER], 'id, role_auth');
                        break;
                }
            }
            if ($role_info) {
                // 角色组已授权的权限
                $role_auth = explode(PHP_EOL, $role_info['role_auth']);
                if (!\in_array(implode('/', $map), $role_auth, false)) {
                    $this->cache('ip.sensitivity.' . $this->request->ip(1), $limit + 1, 300);
                    $this->error('无权操作', 403, APP_DEBUG ? ['rule' => $map, 'role_id' => $role_info['id']] : []);
                }
            } else {
                return $this->error('AUTH角色未定义');
            }
        }
    }
}
