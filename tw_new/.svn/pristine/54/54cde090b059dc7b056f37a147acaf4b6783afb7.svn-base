<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 0.1-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

class Oauth_ctrl extends \utils\BaseController
{
    public $_ignore_node = [
        'alipayToken',
        'getAlipaySign',
    ];
    private $aop;

    /**
     * Oauth_ctrl constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();

        include_once ROOT_PATH . 'utils/alipaySDK/aop/AopClient.php';
        include ROOT_PATH . 'utils/alipaySDK/aop/SignData.php';
        include ROOT_PATH . 'config/config_alipay.php';

        $this->aop                = new AopClient();
        $this->aop->gatewayUrl    = 'https://openapi.alipay.com/gateway.do';
        $this->aop->appId         = $a_config_alipay['auth_config']['app_id'];
        $this->aop->rsaPrivateKey = $a_config_alipay['auth_config']['rsa_private_key'];
        $this->aop->apiVersion    = '1.0';
        $this->aop->format        = 'JSON';
        $this->aop->postCharset   = 'utf-8';
        $this->aop->signType      = 'RSA2';
    }

    /**
     * 获取支付宝签名
     * @router http://server.name/alipay.get.signtrue
     */
    public function getAlipaySign()
    {
        include ROOT_PATH . 'utils/alipaySDK/aop/request/AlipayUserInfoAuthRequest.php';
        include ROOT_PATH . 'utils/alipaySDK/lotusphp_runtime/Logger/Logger.php';
        $request     = new AlipayUserInfoAuthRequest ();
        $state       = md5(uniqid(rand(), TRUE));
        $biz_content = json_encode([
            'scopes'    => ['auth_base'],
            'state'     => $state
        ]);

        $request->setBizContent($biz_content);

        $result = $this->aop->execute($request);

        /**
         * {
         * "alipay_user_info_auth_response": {
         * "code": "10000",
         * "msg": "Success"
         * },
         * "sign": "ERITJKEIJKJHKKKKKKKHJEREEEEEEEEEEE"
         * }
         */
        $responseNode = str_replace('.', '_', $request->getApiMethodName()) . '_response';
        $resultCode   = $result->$responseNode->code;
        if (!empty($resultCode) && $resultCode == 10000) {
            return $this->success(['signtrue' => $result->$responseNode->sign]);
        }
        return $this->error($result->$responseNode);
    }

    /**
     * 支付宝用户授权接口
     * @router http://server.name/alipay.system.oauth.token
     */
    public function alipayToken()
    {
        $data['auth_code'] = $this->request->get('auth_code', '', 'trim');

        $this->validate($data, [
            'auth_code' => 'required',
        ]);


        include ROOT_PATH . 'utils/alipaySDK/aop/request/AlipaySystemOauthTokenRequest.php';

        // 换取授权访问令牌
        $request = new AlipaySystemOauthTokenRequest();
        $request->setGrantType('authorization_code');
        $request->setCode($data['auth_code']);
        $result = $this->aop->execute($request);
        $result = (array)$result->alipay_system_oauth_token_response;

        if (!isset($result['code'])) {
            /**
             * {
             * "alipay_system_oauth_token_response": {
             * "user_id": "2088102150477652",
             * "access_token": "20120823ac6ffaa4d2d84e7384bf983531473993",
             * "expires_in": "3600",
             * "refresh_token": "20120823ac6ffdsdf2d84e7384bf983531473993",
             * "re_expires_in": "3600"
             * }
             * }
             */
            return $this->success(['access_token' => $result['access_token']]);
        }
        return $this->error($result);
    }

    /**
     * @return array
     */
    public function setField(): array
    {
        return [
            'auth_code' => '授权码',
        ];
    }
}
