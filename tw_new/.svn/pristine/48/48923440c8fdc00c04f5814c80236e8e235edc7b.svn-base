<?php
/**
 * 支付宝登录适配器
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model\user\login\adapter;

use model\user\login\ILoginAdapter;
use model\user\login\LoginModel;

class AlipayAdapter extends LoginModel implements ILoginAdapter
{
    public function login()
    {
        $data['auth_code'] = $this->request->post('auth_code', '', 'trim');

        $this->validate($data, [
            'auth_code' => 'required',
        ]);

        include ROOT_PATH . '/utils/alipaySDK/AopSdk.php';
        include CONFIGPATH . '/config_alipay.php';

        /** @var \AopClient $aop */
        $aop                     = new \AopClient();
        $aop->gatewayUrl         = 'https://openapi.alipay.com/gateway.do';
        $aop->appId              = $a_config_alipay['auth_config']['app_id'];
        $aop->rsaPrivateKey      = $a_config_alipay['auth_config']['rsa_private_key'];
        $aop->alipayrsaPublicKey = $a_config_alipay['auth_config']['alipay_rsa_public_key'];
        $aop->apiVersion         = '1.0';
        $aop->signType           = 'RSA2';
        $aop->postCharset        = 'utf-8';
        $aop->format             = 'json';

        // 1. 通过auth_code获取auth_token
        /** @var \AlipaySystemOauthTokenRequest $request */
        $request = new \AlipaySystemOauthTokenRequest();
        $request->setGrantType('authorization_code');
        $request->setCode($data['auth_code']);
        $response     = $this->_getResponse($aop->execute($request), $request);
        exit;

        $access_token = $response->access_token;

        // 2. 通过auth_token获取用户信息
        /** @var \AlipayUserInfoShareRequest $request */
        $request  = new \AlipayUserInfoShareRequest();
        $response = $this->_getResponse($aop->execute($request, $access_token), $request);

        /**
         * {
         * "alipay_user_info_share_response": {
         * "code": "10000",
         * "msg": "Success",
         * "user_id": "2088102104794936",
         * "avatar": "http://tfsimg.alipay.com/images/partner/T1uIxXXbpXXXXXXXX",
         * "province": "安徽省",
         * "city": "安庆",
         * "nick_name": "支付宝小二",
         * "is_student_certified": "T",
         * "user_type": "1",
         * "user_status": "T",
         * "is_certified": "T",
         * "gender": "F"
         * },
         * "sign": "ERITJKEIJKJHKKKKKKKHJEREEEEEEEEEEE"
         * }
         */

        try {
            $alipay_user = $this->db->get_row(get_table('alipay_user_info'), ['alipay_user_id' => $response->user_id]);
            if (!$alipay_user) {
                $this->db->set_error_mode();
                $this->db->begin();
                $user_id = $this->insertUser();
                $this->db->insert(get_table('alipay_user_info'), [
                    'user_id'          => $user_id,
                    'alipay_user_id'   => $response->user_id,
                    'alipay_avatar'    => $response->avatar,
                    'alipay_province'  => $response->province,
                    'alipay_city'      => $response->city,
                    'alipay_nick_name' => $response->nick_name ?? '支付宝用户' . $user_id,
                ]);
                $this->db->commit();
                return $this->afterRegisterHook($user_id);
            }
            return $this->afterLoginHook($alipay_user['user_id']);
        } catch (\Exception $e) {
            $this->db->roll_back();
            return $this->error('微信登录失败' . (APP_DEBUG ? '，原因：' . $e->getMessage() : ''));
        }

    }

    /**
     * 获取支付宝SDK结果
     * @param $result
     * @param $request
     * @return mixed
     */
    public function _getResponse($result, $request)
    {
        $responseNode = str_replace('.', '_', $request->getApiMethodName()) . '_response';

        if (isset($result->error_response) && $result->error_response->code != 10000) {
            return $this->error('支付宝登录异常', (array)$result->error_response);
        }
        if ('alipay_system_oauth_token_response' == $responseNode) {
            return $result->$responseNode;
        }
        $resultCode   = $result->$responseNode->code;
        if (!empty($resultCode) && $resultCode == 10000) {
            return $result->$responseNode;
        }

        return $this->error('支付宝登录异常', (array)$result->$responseNode);
    }

    /**
     * @return array
     */
    public function setField(): array
    {
        return [
            'auth_code' => '支付宝授权码',
        ];
    }
}
