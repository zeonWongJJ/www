<?php
/**
 * 家洁项目基础控制器
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace Controller;

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
        /** @var TokenModel $token_model */
        $token_model = Factory::getFactory('token');
        $user_info   = $token_model->parseToken($token);

        if ('admin' == $user_info['user_type_key']) {
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
            return $this->error('规则未定义', 403, $map);
        }

        // 只有接口验证等级为2时需要认证权限分配
        if ((int)$rule_info['rule_level'] === 2) {
            if ($staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info['user_id']])) {
                if (!$role_info_id = $this->cache('staff.belong.role.id' . $staff_row['user_type'])) {
                    switch ((int)$staff_row['user_type']) {
                        case 1:
                            $role_info = $this->db->get_row(get_table('role'), ['role_key' => 'pu_tong_dian_yuan'], 'id');
                            break;
                        case 2:
                            $role_info = $this->db->get_row(get_table('role'), ['role_key' => 'dian_pu_guan_li_yuan'], 'id');
                            break;
                        case 3:
                            $role_info = $this->db->get_row(get_table('role'), ['role_key' => 'dian_zhu'], 'id');
                            break;
                        default:
                            $role_info = false;
                    }
                    if (!$role_info) {
                        return $this->error('店员角色未定义', 403);
                    }
                    $role_info_id = $role_info['id'];
                    $this->cache('staff.belong.role.id' . $staff_row['user_type'], $role_info_id, 3600);
                }
            } else {
                $role_info_id = $user_info['role_id'];
            }
            if (1 > $has_permission = $this->db->get_total(get_table('role_assign'), ['role_id' => $role_info_id, 'rule_id' => $rule_info['id']])) {
                $this->error('没有权限！', 403, ['rule' => $map, 'role_id' => $role_info_id]);
            }
        }
    }
}
