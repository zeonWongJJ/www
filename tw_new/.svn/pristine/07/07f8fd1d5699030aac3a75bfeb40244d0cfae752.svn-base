<?php
/**
 * 权限模块-用户组控制器
 *
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */

class Role_ctrl extends \utils\BaseController
{
    /**
     * 缓存key前缀
     * @var string
     */
    protected $cache_key = 'auth.role.';

    protected $repository = \repositories\RoleRepository::class;

    /**
     * 数据获取
     * @param $method
     * @return array|mixed
     */
    public function getData($method)
    {
        $data = [
            'insert' => [
                'role_name' => $this->request->post('role_name', '', 'trim'),
                'role_info' => $this->request->post('role_info', '', 'trim'),
                'parent_id' => $this->request->post('parent_id', 0, 'intval'),
            ],
            'update' => [
                'role_name' => $this->request->post('role_name', '', 'trim'),
                'role_info' => $this->request->post('role_info', '', 'trim'),
                'parent_id' => $this->request->post('parent_id', null, 'intval')
            ]
        ];

        return $data[$method] ?? [];
    }

    /**
     * 验证定义
     * @param $method
     * @return array|mixed
     */
    public function valid($method)
    {
        $rule  = [
            'role_name' => 'required',
        ];
        $valid = [
            'insert' => $rule,
            'update' => $rule
        ];

        return $valid[$method] ?? [];
    }

    public function setField()
    {
        return [
            'role_name' => '角色名'
        ];
    }

    /**
     * 角色分配权限
     * @route http://server.name/auth.role.assign-1
     */
    public function assign()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role_id = $this->router->get(1);

            $data['assign_ids'] = $this->request->post('assign_ids/a', [], 'trim');

            if (!$data['assign_ids']) {
                $this->db->update(get_table('role'), [
                    'role_auth'     => '',
                    'role_auth_ids' => ''
                ], ['id' => $role_id]);
                return $this->success(false);
            }
            try {
                $this->db->set_error_mode();
                $this->db->begin();

                $where_in = implode(',', $data['assign_ids']);
                $limit    = count($data['assign_ids']);
                $sql      = <<<EOF
SELECT id, rule_controller, rule_action, rule_router_param, rule_enable FROM {$this->db->get_prefix(get_table('rule'))} WHERE id IN ({$where_in}) LIMIT 0, {$limit}
EOF;
                $rules    = [];
                $pdo_ret  = $this->db->query($sql);
                if ($pdo_ret) {
                    $rules = $pdo_ret->fetchAll(\PDO::FETCH_ASSOC);
                }
                $update['role_auth']     = [];
                $update['role_auth_ids'] = [];
                foreach ($rules as $rule) {
                    $update['role_auth'][]     = "{$rule['rule_controller']}/{$rule['rule_action']}" . ($rule['rule_router_param'] ? "/{$rule['rule_router_param']}" : '');
                    $update['role_auth_ids'][] = $rule['id'];
                }
                $update['role_auth']     = implode(PHP_EOL, $update['role_auth']);
                $update['role_auth_ids'] = implode(',', $update['role_auth_ids']);
                $this->db->update(get_table('role'), $update, ['id' => $role_id]);
                $this->db->commit();
                return $this->success(false);
            } catch (Exception $e) {
                $this->db->roll_back();
                $this->error($e->getMessage());
            }
        }
        return $this->error('isp-invalid-request');
    }

    /**
     * 获取用户已分配的权限列表
     * @router http://server.name/auth.role.assigned
     */
    public function assigned()
    {
        $map['id']           = $this->router->get(1);
        $data['is_get_rule'] = $this->request->post('is_get_rule', 0, 'intval');
        $role_info           = $this->db->get_row(get_table('role'), $map, 'role_auth_ids, parent_id');
        $role_auth_ids       = explode(',', $role_info['role_auth_ids']);
        $all_total           = $this->db->get_total(get_table('rule'));
        $all_rules           = [];
        // 查询上级没有的权限
        $topper_id = $this->db->get_row(get_table('role'), ['id' => $role_info['parent_id']], 'role_auth_ids'); // 上一级有的权限id
        if ($all_total) {
            $topper_id = explode(',', $topper_id['role_auth_ids']);
            $all_rules = $this->db->limit(0, $all_total)->get(get_table('rule'), null, 'rule_name as title, id, parent_id, rule_enable');
            $all_rules = filter($all_rules);
            foreach ($all_rules as &$all_rule) {
                if ($role_info['parent_id'] == 0) {
                    $all_rule['disabled'] = $all_rule['rule_enable'] == 0;
                } else {
                    $all_rule['disabled'] = $all_rule['rule_enable'] == 0 || !in_array($all_rule['id'], $topper_id, false);
                }
                $all_rule['checked'] = $all_rule['selected'] = in_array($all_rule['id'], $role_auth_ids, false);
            }

            $all_rules = list_to_tree($all_rules);
        }
        return $this->success($all_rules);

    }

    /**
     * 开启、关闭角色组
     * @return mixed
     * @router http://server.name/auth.role.enable
     */
    public function enable()
    {
        $map['id'] = $this->router->get(1);

        $this->validate($map, [
            'id' => 'required|number',
        ]);

        // 判断角色组是否允许被修改
        $role = $this->db->get_row(get_table('role'), $map);

        if ($role && $role['can_del'] == 1) {

            $update['role_status'] = $role['role_status'] == 1 ? 0 : 1;
            $this->db->update(get_table('role'), $update, $map);
            return $this->success(false);
        }
        return $this->error('角色不允许修改');
    }
}
