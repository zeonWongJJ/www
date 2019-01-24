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

            $data['assign_ids'] = $this->request->post('assign_ids', [], 'trim');

            if (!$data['assign_ids']) {
                $this->db->delete('jiajie_role_assign', compact('role_id'));
                return $this->success(false);
            }
            try {
                $this->db->set_error_mode();
                $this->db->begin();

                // 先清空原有分配表
                $this->db->delete('jiajie_role_assign', compact('role_id'));
                $rows = [];

                if (is_string($data['assign_ids'])) {
                    $assign_ids = explode(',', trim($data['assign_ids']));
                } else {
                    $assign_ids = $data['assign_ids'];
                }

                foreach ($assign_ids as $id) {
                    $rows[] = [
                        'role_id' => $role_id,
                        'rule_id' => $id
                    ];
                }

                // 再写入分配表
                $this->db->inserts('jiajie_role_assign', $rows);

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
        $map['role_id'] = $this->router->get(1);
        $rows           = $this->db->limit(0, $this->db->get_total('jiajie_role_assign', $map))->get('jiajie_role_assign', $map);
        $rules          = [];
        if ($rows) {
            foreach ($rows as $row) {
                $rules[] = $row['rule_id'];
            }
        }
        return $this->success($rules);
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
        $role = $this->db->get_row('jiajie_role', $map);

        if ($role && $role['can_del'] == 1) {

            $update['role_status'] = $role['role_status'] == 1 ? 0 : 1;
            $this->db->update('jiajie_role', $update, $map);
            return $this->success(false);
        }
        return $this->error('角色不允许修改');
    }
}
