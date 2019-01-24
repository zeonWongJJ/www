<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 0.1-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

class Auth_ctrl extends \utils\BaseController
{
    public $_ignore_node = [
        'alipay',
    ];

    /**
     * 支付宝用户授权接口
     * @router http://server.name/auth.alipay
     */
    public function alipay()
    {
        include ROOT_PATH . 'config/config_alipay.php';
        $auth_code = $_REQUEST['auth_code'] ?? '';

        if (!empty($auth_code)) {
            include ROOT_PATH . 'utils/alipaySDK/aop/AopClient.php';
            include ROOT_PATH . 'utils/alipaySDK/aop/SignData.php';
            include ROOT_PATH . 'utils/alipaySDK/aop/request/AlipaySystemOauthTokenRequest.php';

            $client                     = new AopClient();
            $client->gatewayUrl         = 'https://openapi.alipay.com/gateway.do';
            $client->appId              = $a_config_alipay['auth_config']['app_id'];
            $client->rsaPrivateKey      = $a_config_alipay['auth_config']['rsa_private_key'];
            $client->format             = 'json';
            $client->postCharset        = 'utf-8';
            $client->signType           = 'RSA';
            $client->alipayrsaPublicKey = $a_config_alipay['auth_config']['alipay_rsa_public_key'];

            $request = new AlipaySystemOauthTokenRequest();
            $request->setGrantType('authorization_code');
            $request->setCode($auth_code);
            $result = $this->AopClient->execute($request);

            //数组输出
            var_dump($result);
        } else {
            echo session_id();
            //【成功授权】后的回调地址
            $my_url                   = 'http://' . $_SERVER['HTTP_HOST'] . '/auth.alipay';
            $_SESSION['alipay_state'] = md5(uniqid(rand(), TRUE));
            //拼接请求授权的URL
            $url = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id=' . $a_config_alipay['auth_config']['app_id'] . '&scope=auth_user&redirect_uri=' . $my_url . '&state=' . $_SESSION['alipay_state'];
            echo("<script> top.location.href='" . $url . "'</script>");
        }
    }
}
