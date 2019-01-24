<?php
/**
 * 后台管理人员登录适配器
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0d-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model\user\login\adapter;

use model\AdminModel;
use model\TokenModel;
use model\user\login\ILoginAdapter;
use utils\Factory;

class AdminAdapter extends AdminModel implements ILoginAdapter
{

    public function login()
    {
        $data['user_name']     = $this->request->post('username', '', 'trim');
        $data['user_password'] = $this->request->post('password', '', 'trim');

        $this->validate($data, [
            'user_name'     => 'required',
            'user_password' => 'required',
        ]);

        $admin_row = $this->db->get_row(get_table('admin'), [
            'user_name' => $data['user_name'],
        ]);
        if (!$admin_row || $admin_row['user_password'] != md5(md5($data['user_password']))) {
            return $this->error('账号不存在或密码不匹配');
        }

        $this->log('登入系统', $admin_row['user_id']);
        /** @var TokenModel $token_model */
        $token_model = Factory::getFactory('token');
        $token       = $token_model->generalToken($admin_row, 'admin');
        $token_model->clearExpireToken(); // 清理过期token
        return $this->success(compact('token'));
    }
}
