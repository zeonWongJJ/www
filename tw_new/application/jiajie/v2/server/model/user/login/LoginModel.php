<?php
/**
 * 用户登录逻辑
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model\user\login;

use model\BaseModel;
use model\TokenModel;
use utils\Factory;

class LoginModel extends BaseModel
{
    /**
     * 登录后操作
     * @param integer $user_id
     * @return mixed
     * @throws \Exception
     */
    protected function afterLoginHook($user_id)
    {
        $share_info = $this->db->get_row(get_table('share_relationship'), ['user_id' => $user_id]);
        // 没有验证码时获取一个
        $user_code = $this->createInviteCode();
        if ($share_info && !$share_info['user_code']) {
            $this->db->update(get_table('share_relationship'), compact('user_code'), ['user_id' => $user_id]);
        } elseif (!$share_info) {
            $this->db->insert(get_table('share_relationship'), [
                'user_id'      => $user_id,
                'parent_id'    => 0,
                'user_level'   => 0,
                'user_code'    => $user_code,
                'relation_map' => '',
            ]);
        }

        $user_info = $this->db->get_row('user', compact('user_id'));

        $data['user_salt']    = md5(uniqid(microtime(), true));
        $data['user_logtime'] = $_SERVER['REQUEST_TIME'];

        if (!$user_info['user_erweima']) {
            // 生成二维码文件
            $this->load->library('phpqrcode');
            $a_param              = [
                // 要生成二维码的数据，必填
                'data'      => $user_id,
                // 二维码文件生成路径，选填，不设置将直接浏览器输出，设置此参数，二维码将不直接输出，而是生成文件
                'file_name' => './uploadfile/qrcode_' . $user_id . '.png',
                // 二维码图片大小，选填，默认4
                'size'      => 10,
                // 二维码错误修正级别L/M/Q/H，选填，默认“L”。L水平 7% 的字码可被修正，M水平 15% 的字码可被修正，Q水平 25% 的字码可被修正，H水平 30% 的字码可被修正
                'level'     => 'L',
            ];
            $data['user_erweima'] = 'http://jiajie-server.7dugo.com/uploadfile/qrcode_' . $user_id . '.png';
            $this->phpqrcode->qrcode($a_param);
        }
        $this->db->update('user', $data, compact('user_id'));

        $user_phone = $this->db->get_row('user', ['user_id' => $user_id], 'user_phone');
        return $this->generalToken($user_info, !isset($user_phone['user_phone']) || !$user_phone['user_phone']);
    }

    /**
     * 生成用户邀请码
     * @return string
     * @throws \Exception
     */
    public function createInviteCode(): string
    {
        $code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand = $code[random_int(0, 25)]
            . strtoupper(dechex(date('m')))
            . date('d')
            . substr(time(), -5)
            . substr(microtime(), 2, 5)
            . sprintf('%02d', random_int(0, 99));
        for (
            $a = md5($rand, true),
            $s = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            $d = '',
            $f = 0;
            $f < 6;
            $g = \ord($a[$f]),
            $d .= $s[($g ^ \ord($a[$f + 8])) - $g & 0x1F],
            $f++
        ) {
        }

        if ($this->db->get_total(get_table('share_relationship'), ['user_code' => $d])) {
            $this->createInviteCode();
        } else {
            return $d;
        }
    }

    /**
     * 生成用户token并响应
     * @param $user_info
     * @param bool $need_bind_phone
     * @return mixed
     */
    public function generalToken($user_info, $need_bind_phone = false)
    {
        if (\is_int($user_info)) {
            $user_info = $this->db->get_row('user', ['user_id' => $user_info]);
        }
        $role_key = 'guest';
        if ($user_info['role_id']) {
            $role = $this->db->get_row(get_table('role'), ['id' => $user_info['role_id']]);
            $role && $role_key = $role['role_key'];
        }
        $user_id = $user_info['user_id'];
        /** @var TokenModel $token_model */
        $token_model = Factory::getFactory('token');
        $token       = $token_model->generalToken($user_info, $role_key);
        $token_model->clearExpireToken(); // 清理过期token
        return $this->success(compact('token', 'need_bind_phone', 'user_id'));
    }

    /**
     * 注册后操作
     * @param integer $user_id 用户id
     * @param bool $return_token
     * @return mixed
     * @throws \Exception
     */
    public function afterRegisterHook($user_id, $return_token = true)
    {
        $user_referee                 = $this->request->post('user_referee', 0, 'intval');
        $register_to_give_red_packets = $this->db->get_row(get_table('config'), ['config_key' => 'register_to_give_red_packets'], 'config_value');
        if ($register_to_give_red_packets && $register_to_give_red_packets['config_value'] > 0) {
            $user_balance_change = sprintf('%.2f', $register_to_give_red_packets['config_value']);
            $this->db->insert('userbalance', [
                'ub_type'          => 1
                , 'ub_money'       => $user_balance_change
                , 'ub_balance'     => $user_balance_change
                , 'ub_time'        => $_SERVER['REQUEST_TIME']
                , 'ub_item'        => '用户注册赠送红包'
                , 'user_id'        => $user_id
                , 'ub_number'      => '无订单号'
                , 'ub_description' => '用户注册系统自动赠送红包',
            ]);
            $this->db->insert(get_table('message'), [
                'message_content'      => '系统赠送您一个金额￥' . number_format($user_balance_change, 2) . '的大红包；可用作抵扣哦~'
                , 'message_post_at'    => $_SERVER['REQUEST_TIME']
                , 'message_notice_uid' => $user_id,
            ]);
        }
        $share_relationship_table = get_table('share_relationship');
        $inviter_row              = [];
        if (!$user_referee) {
            // 如果没有指定邀请人的user_id,则尝试获取是否有邀请码
            if ($invitation_code = $this->request->post('invitation_code', '', 'trim')) {
                $inviter_row = $this->db->get_row($share_relationship_table, ['user_code' => $invitation_code]);
            }
        } else {
            $inviter_row = $this->db->get_row($share_relationship_table, ['user_id' => $user_referee]);
        }

        // 如果有邀请人记录
        $parent_id    = $inviter_row ? $user_referee : 0;
        $level        = $inviter_row ? $inviter_row['user_level'] + 1 : 0; // 计算裂变等级
        $relation_map = $inviter_row ? $inviter_row['relation_map'] . '-' . $parent_id : '';

        $this->db->insert(get_table('share_relationship'), [
            'user_id'      => $user_id,
            'parent_id'    => $parent_id,
            'user_level'   => $level,
            'relation_map' => $relation_map, // 层级关系
            'user_code'    => $this->createInviteCode() // 用户邀请码
        ]);

        if ($return_token) {
            $user_phone = $this->db->get_row('user', ['user_id' => $user_id], 'user_phone');
            $this->generalToken($user_id, !$user_phone['user_phone']);
        } else {
            return $this->success(false);
        }
    }

    /**
     * 插入一个新的用户
     * @return int 用户id
     */
    public function insertUser($append = []): int
    {
        return $this->db->insert('user', array_merge([
            'user_password'      => '',
            'user_logip'         => $_SERVER['REMOTE_ADDR'],
            'user_regtime'       => $_SERVER['REQUEST_TIME'],
            'shopman_regtime'    => 0,
            'user_position'      => 0,
            'update_time'        => $_SERVER['REQUEST_TIME'],
            'user_orders'        => '',
            'referee_orders'     => '',
            'user_selfoffice'    => '',
            'user_refereeoffice' => '',
            'wx_openid'          => '',
            'wx_nickname'        => '',
            'user_salt'          => '',
            'role_id'            => 2
        ], $append));
    }
}
