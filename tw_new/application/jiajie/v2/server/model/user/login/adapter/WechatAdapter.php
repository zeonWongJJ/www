<?php
/**
 * 微信登录适配器
 * @copyright 广州柒度信息科技有限公司
 * @version 0.1-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model\user\login\adapter;


use model\user\login\ILoginAdapter;
use model\user\login\LoginModel;

class WechatAdapter extends LoginModel implements ILoginAdapter
{

    public function login()
    {
        $data['wx_openid']   = $this->request->post('wx_openid', '', 'trim');
        $data['wx_nickname'] = $this->request->post('wx_nickname', '', 'trim');
        $data['wx_unionid']  = $this->request->post('wx_unionid', '', 'trim');

        $this->validate($data, [
            'wx_openid'   => 'required',
            'wx_nickname' => 'required',
            'wx_unionid'  => 'required',
        ]);

        try {
            $unionid = $this->db->get_row(get_table('user_openid'), ['wx_open_unionid' => $data['wx_unionid']]);
            if (!$unionid) {
                $this->db->set_error_mode();
                $this->db->begin();
                $user_id = $this->insertUser();
                $this->db->insert(get_table('user_openid'), [
                    'user_id'         => $user_id,
                    'wx_openid'       => $data['wx_openid'],
                    'wx_nickname'     => base64_encode($data['wx_nickname']),
                    'wx_open_unionid' => $data['wx_unionid'],
                    'update_time'     => $_SERVER['REQUEST_TIME']
                ]);
                $this->db->commit();
                return $this->afterRegisterHook($user_id);
            }
            return $this->afterLoginHook($unionid['user_id']);
        } catch (\Exception $e) {
            $this->db->roll_back();
            return $this->error('微信登录失败' . (APP_DEBUG ? '，原因：' . $e->getMessage() : ''));
        }
    }

    /**
     * @return array
     */
    public function setField(): array
    {
        return [
            'wx_openid'   => 'OPENID',
            'wx_nickname' => '微信昵称',
            'wx_unionid'  => 'UNIONID',
        ];
    }
}
