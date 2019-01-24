<?php

/**
 * Class Wechat_ctrl
 */
class Wechat_ctrl extends \utils\BaseController
{
    public $app_id = 'wxd40a4f9141fe81d0';
    public $secret = '2ccfa5ce1255ee17d70a1c5324d6ea02';

    public $_ignore_node = [
        'getAccessToken'
        , 'getSignPackage'
    ];

    protected $access_token = '';

    /**
     * @router http://server.name/wechat.get.sign.package
     * @return mixed
     */
    public function getSignPackage()
    {
        if (!$url = $this->request->post('url', '', 'trim')) {
            $url = $this->request->get('url', '', 'trim');
        }
        $url = urldecode($url);
        $jsapiTicket = $this->getJsApiTicket();
        // $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = time();
        $nonceStr = $this->createNonceStr();
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);
        $signPackage = [
            'appId' => $this->app_id,
            'nonceStr' => $nonceStr,
            'timestamp' => $timestamp,
            'url' => $url,
            'signature' => $signature,
            'rawString' => $string,
            'ticket' => $jsapiTicket,
            'access_token' => $this->access_token
        ];
        return $this->success($signPackage);
    }

    /**
     * 根据access_token获取js ticket
     * @param $accessToken
     * @return mixed
     */
    public function getJsApiTicket()
    {
        $accessToken = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$accessToken}&&type=jsapi";
        $returnData = json_decode(file_get_contents($url), true);
        /** @noinspection SpellCheckingInspection TypeUnsafeComparisonInspection */
        if (isset($returnData['errcode']) && $returnData['errcode'] != 0) {
            /** @noinspection SpellCheckingInspection */
            return $this->error('获取js api ticket失败!' . $returnData['errcode'] . $returnData['errmsg']);
        }
        return $returnData['ticket'];
    }

    /**
     * 获取微信的access Token
     * @router http://server.name/wechat.get.token
     */
    public function getAccessToken()
    {
        $state = $this->request->get('return_code', '', 'trim');
        if (!$access_token = $this->cache('wechat.access.token')) {
            // wx192abf31ae355781
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $this->app_id . '&secret=' . $this->secret;
            $returnData = json_decode(file_get_contents($url), true);
            if (isset($returnData['errcode'])) {
                return $this->error('token获取失败' . $returnData['errmsg'], $returnData['errcode']);
            }
            $access_token = $returnData['access_token'];
            $this->cache('wechat.access.token', $access_token, 7100);
        }
        $this->access_token = $access_token;

        if ($state && $state == 'true') {
            return $this->success(compact('access_token'), 1);
        }

        return $access_token;
    }

    /**
     * 生成随机字符串
     * @param int $length 生成长度
     * @return string
     */
    private
    function createNonceStr($length = 16)
    {
        /** @noinspection SpellCheckingInspection */
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            try {
                $str .= $chars[random_int(0, strlen($chars) - 1)];
            } catch (Exception $e) {
            }
        }
        return $str;
    }
}
