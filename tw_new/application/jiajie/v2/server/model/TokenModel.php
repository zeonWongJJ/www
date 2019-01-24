<?php
/**
 * token逻辑处理
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

use phpseclib\Crypt\RSA;

/**
 * Class TokenModel
 * @package model
 */
class TokenModel extends BaseModel
{

    /**
     * 获取当前访问来源
     * @return string 访问来源，可能是 APP ADMIN
     */
    public static function getSourceSign(): string
    {
        return strtoupper($_SERVER['HTTP_X_SOURCE_SIGN'] ?? 'app');
    }

    /**
     * 清理过期token
     */
    public function clearExpireToken()
    {
        $map = [
            'expir_at <' => $_SERVER['REQUEST_TIME'],
        ];

        $this->db->delete(get_table('access_token'), $map);
    }

    /**
     * token生成机制
     * @param array $user
     * @param $userRole
     * @return string
     */
    public function generalToken(array $user, $userRole)
    {

        $map['user_type'] = $userRole == 'admin' ? $userRole : 'user';

        $userId    = $user['user_id'];
        $userSalt  = $user['user_salt'];
        $_userRole = strtolower($userRole);
        $ua        = md5($_SERVER['HTTP_USER_AGENT']);
        $source    = self::getSourceSign();
        // 生成user_token
        $userToken = [$userId, $ua, $userSalt, $_userRole, $source, $map['user_type']];
        $userToken = implode('#', $userToken);

        $rsa = new RSA();
        $rsa->loadKey(file_get_contents(__DIR__ . '/rsa/public.pem'));
        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
        $token_prefix = base64_encode($rsa->encrypt($userToken));
        $access_token = uniqid($token_prefix, false); // 前缀生成不重复字符串,作为access_token

        $map['user_id']     = $userId;
        $map['source_sign'] = $source;

        $count = $this->db->get_row(get_table('access_token'), $map);

        $old_access_token = $this->cache('user.token.by.uid.' . $user['user_id']);
        $old_access_token && $this->cache($old_access_token, null);

        if ($count) {
            $this->db->update(get_table('access_token'), [
                'token'    => $access_token,
                'expir_at' => $_SERVER['REQUEST_TIME'] + 604800,
            ], ['id' => $count['id'], 'source_sign' => $source]);
        } else {
            $this->db->insert(
                get_table('access_token'), [
                    'token'         => $access_token
                    , 'expir_at'    => $_SERVER['REQUEST_TIME'] + 604800
                    , 'user_id'     => $userId
                    , 'user_type'   => $map['user_type']
                    , 'source_sign' => $source,
                ]
            );
        }

        $user_info = base64_encode(serialize(filter($user)));

        $this->cache('user.token.by.uid.' . $user['user_id']);
        $this->cache($access_token, $userToken, 604800); // access_token 记录到缓存中
        $this->cache($userToken, $user_info, 604800);

        // 返回生成的token
        return urlencode(base64_encode($rsa->encrypt($access_token)));
    }

    /**
     * 解析token
     * @param string $token
     * @param bool $is_remove 是否强制移除token
     * @return mixed
     */
    public function parseToken($token = '', $is_remove = false)
    {
        $token = $token ?: $this->tokenGetter();
        if (!$token) {
            return $this->error('登录令牌不存在', 401);
        }
        try {
            $rsa = new RSA();
            $rsa->loadKey(file_get_contents(__DIR__ . '/rsa/private.pem'));
            $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
            $token = urldecode($token);
            $token = @$rsa->decrypt(base64_decode($token));
        } catch (\Exception $e) {
            return $this->error('Token resolution error', 401);
        }
        $user_token = $this->cache($token);
        if ($token && $user_token && ($user_info = $this->cache($user_token))) {
            $temp      = explode('#', $user_token);
            $user_type = end($temp);
            array_pop($temp);
            $source_sign = end($temp);
            array_pop($temp);
            $has_token = $this->db->get_total(get_table('access_token'), [
                'user_id'     => $temp[0],
                'source_sign' => $source_sign,
                'user_type'   => $user_type,
            ]);
            if (!$has_token) {
                return $this->error('令牌失效', 401);
            }
            $_user_info                  = unserialize(base64_decode($user_info));
            $_user_info['user_type_key'] = end($temp);
            if ('admin' === strtolower($_user_info['user_type_key'])) {
                $has_user    = $this->db->get_row(get_table('admin'), ['user_id' => $_user_info['user_id']]);
                $user_enable = $has_user['is_enable'];
            } else {
                $has_user    = $this->db->get_row('user', ['user_id' => $_user_info['user_id']]);
                $user_enable = $has_user['user_state'];
            }

            if (!$has_user || $user_enable != 1) {
                return $this->error('用户不存在或已被禁用', 401);
            }
            app('user_info', (object)$_user_info);
            if ($is_remove) {
                $this->cache($token, null);
                $this->cache($user_token, null);
                $this->cache('user.token.by.uid.' . app('user_info')->user_id, null);

                return $this->success(false);
            }
            // 延长token过期时间
            $this->cache($token, $user_token, 604800);
            $this->cache($user_token, $user_info, 604800);
            return $_user_info;
        }

        return $this->error('登录令牌失效，请重新登录', 401);
    }

    /**
     * token获取方法
     * @return string
     */
    private function tokenGetter(): string
    {
        return $_SERVER['HTTP_X_TOKEN'] ?? '';
    }

    /**
     * @remark 判断是否后台访问
     * @return bool
     */
    public static function isAdminSource(): bool
    {
        $user_info   = (new self)->parseToken();
        return 'ADMIN' === self::getSourceSign() && $user_info['user_type_key'] === 'admin';
    }
}
