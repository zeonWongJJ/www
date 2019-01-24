<?php
/**
 * 控制器
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

class Rule_ctrl extends \utils\BaseController
{

    public $_ignore_node = [
        'level'
    ];

    /**
     * 缓存key前缀
     * @var string
     */
    protected $cache_key = 'auth.rule.';

    protected $repository = \repositories\RuleRepository::class;

    /**
     * @router http://server.name/auth.rule.enable
     */
    public function changeEnable()
    {
        $data['id'] = $this->router->get(1);

        $row = $this->db->get_row(get_table('rule'), $data);
        if ($row) {
            $update['rule_enable'] = $row['rule_enable'] == 1 ? 0 : 1;
            $this->db->update(get_table('rule'), $update, $data);

            return $this->success(false);
        }

        return $this->error('ips-server-error');
    }

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $row = [
            'rule_name'         => $this->request->post('rule_name', '', 'trim'),
            'rule_controller'   => $this->request->post('rule_controller', '', 'trim'),
            'rule_action'       => $this->request->post('rule_action', '', 'trim'),
            'rule_enable'       => $this->request->post('rule_enable', 1, 'intval'),
            'parent_id'         => $this->request->post('parent_id', 1, 'intval'),
            'is_menu'           => $this->request->post('is_menu', 1, 'intval'),
            'rule_sort'         => $this->request->post('rule_sort', 50, 'intval'),
            'rule_router_param' => $this->request->post('rule_router_param', '', 'trim')
        ];

        $data = [
            'insert' => array_merge($row, [
                'parent_id' => $this->request->post('parent_id', 0, 'intval')
            ]),
            'update' => array_merge($row, [
                'parent_id' => $this->request->post('parent_id', null, 'intval')
            ])
        ];

        return $data[$method] ?? [];
    }


    /**
     * 验证定义
     * @param $method
     * @return array
     */
    public function valid($method): array
    {
        $row = [
            'rule_name'       => 'required|length:3,25',
            'rule_controller' => 'required',
            'rule_action'     => 'required',
            'rule_sort'       => 'required'
        ];

        $valid = [
            'insert' => $row,
            'update' => $row
        ];

        return $valid[$method] ?? [];
    }

    /**
     * @return array
     */
    public function setField(): array
    {
        return [
            'rule_name'         => '规则名字'
            , 'rule_controller' => '规则所属控制器'
            , 'rule_action'     => '规则所属方法'
            , 'rule_sort'       => '规则排序'
        ];
    }

    // - 更多方法定义

    /**
     * 获取接口认证等级
     * @router http://server.name/auth.rule.level
     * @return mixed
     */
    public function level()
    {
        $data = [
            [
                'rule_level' => 1,
                'level_name' => '只判断是否登录'
            ],
            [
                'rule_level' => 2,
                'level_name' => '判断登录+权限'
            ]
        ];

        return $this->success($data, count($data));
    }
}
