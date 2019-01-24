<?php
/**
 * 控制器
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

/**
 * Class Admin_ctrl
 */
class Admin_ctrl extends \utils\BaseController
{
    /**
     * 缓存key前缀
     * @var string
     */
    protected $cache_key = 'admin.user.';

    protected $repository = \repositories\AdminRepository::class;

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $row  = [
            'user_name'       => $this->request->post('user_name', '', 'trim')
            , 'user_nicename' => $this->request->post('user_nicename', '', 'trim')
            , 'user_password' => $this->request->post('user_password', '', 'trim')
            , 'user_sex'      => $this->request->post('user_sex', 0, 'intval')
            , 'role_id'       => $this->request->post('role_id', 0, 'intval')
            , 'user_phone'    => $this->request->post('user_phone', '', 'trim')
            , 'user_email'    => $this->request->post('user_email', '', 'trim')
        ];
        $data = [
            'insert' => $row,
            'update' => $row
        ];
        return $data[$method] ?? [];
    }

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function valid($method): array
    {
        $row   = [
            'user_name'       => 'required'
            , 'user_nicename' => 'required'
            , 'user_sex'      => 'required'
            , 'user_role'     => 'required'
            , 'user_phone'    => 'required|phone'
            , 'user_email'    => 'required|email'
        ];
        $valid = [
            'insert' => array_merge($row, [
                'user_password' => 'required'
            ]),
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
            'user_name'       => '管理员用户名'
            , 'user_password' => '登陆密码'
            , 'user_nicename' => '管理员姓名'
            , 'user_sex'      => '管理员性别'
            , 'user_phone'    => '管理员手机号码'
            , 'user_email'    => '管理员邮箱地址'
        ];
    }

    /**
     * 用户开启、停用
     * @router http://server.name/admin.enable
     */
    public function adminEnable()
    {
        $user_id = (int)$this->router->get(1);
        if (!$user_id) {
            return $this->error('没有获取到管理员id');
        }
        $admin_info = $this->db->get_row('jiajie_admin', ['user_id' => $user_id]);
        if (!$admin_info) {
            return $this->error('管理员不存在');
        }


        if ($admin_info['user_id'] == 1) {
            return $this->error('超级管理员不能执行此操作');
        }
        $update['is_enable'] = $admin_info['is_enable'] == 1 ? 0 : 1;
        $this->db->update('jiajie_admin', $update, [
            'user_id' => $user_id
        ]);
        return $this->success(false);
    }
}
