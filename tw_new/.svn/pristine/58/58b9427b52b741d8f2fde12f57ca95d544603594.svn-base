<?php
/**
 * 出现“redirect_uri 参数错误”，解决方法：公众号管理后台，设置->公众号设置->功能设置->网页授权域名
 * 官方文档：https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_1
 */

require_once BASEPATH . '/libraries/pay/wxpay_pub/lib/WxPay.Api.php';

class TW_wxpay_pub
{

    // 构造函数，对参数进行处理
    public function __construct()
    {
        global $o_general;
        if (isset(get_instance()->general)) {
            $this->general = get_instance()->general;
        } else if (function_exists('app') && app('general')) {
            $this->general = app('general');
        } else {
            $this->general = $o_general;
        }
//        $this->general = get_instance()->general ?? $o_general;
//		$this->general = $o_general;
    }

    // 支付函数
    public function pay($a_param)
    {
        if (function_exists('app') && app('request')) {
            $s_code = app('request')->get('code', '', 'trim');
        } else {
            $s_code         = $this->general->get('code');
        }
        $s_redirect_uri = empty($a_param['openid_redirect_uri']) ? ($this->is_https() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] : $a_param['openid_redirect_uri'];
        $s_openid       = $this->get_open_id($s_redirect_uri, $s_code);

        $o_wxpay = new WxPayUnifiedOrder();
        $o_wxpay->SetBody($a_param['body']);
        if (isset($a_param['attach'])) {
            $o_wxpay->SetAttach($a_param['attach']);
        }
        $o_wxpay->SetOut_trade_no($a_param['out_trade_no']);
        $o_wxpay->SetTotal_fee($a_param['total_fee']);
        if (isset($a_param['time_start'])) {
            $o_wxpay->SetTime_start($a_param['time_start']);
        } else {
            $o_wxpay->SetTime_start(date("YmdHis"), $_SERVER['REQUEST_TIME']);
        }
        if ($a_param['time_expire']) {
            $o_wxpay->SetTime_expire(date("YmdHis", $_SERVER['REQUEST_TIME'] + $a_param['time_expire']));
        } else {
            $o_wxpay->SetTime_expire(date("YmdHis", $_SERVER['REQUEST_TIME'] + 600));
        }
        if (isset($a_param['goods_tag'])) {
            $o_wxpay->SetGoods_tag($a_param['goods_tag']);
        }
        if (isset($a_param['nonce_str'])) {
            $o_wxpay->SetGoods_tag($a_param['nonce_str']);
        }
        if (isset($a_param['detail'])) {
            $o_wxpay->SetDetail($a_param['detail']);
        }
        if (isset($a_param['product_id'])) {
            $o_wxpay->SetProduct_id($a_param['product_id']);
        }
        $o_wxpay->SetNotify_url($a_param['notify_url']);
        $o_wxpay->SetTrade_type("JSAPI");
        $o_wxpay->SetOpenid($s_openid);
        $a_order = WxPayApi::unifiedOrder($o_wxpay);

        if ($a_order['return_code'] != 'SUCCESS') {
            throw new \RuntimeException($a_order['return_msg']);
        }

        $s_jsparam = $this->get_jsapi_param($a_order);
        $s_jscode  = $this->get_jscode($s_jsparam, $a_param);

        return $s_jscode;
    }

    // 退款用

    public function is_https()
    {
        if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return true;
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            return true;
        } elseif (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
            return true;
        }

        return false;
    }

    // 订单查询

    public function get_open_id($s_redirect_uri, $s_code = NULL)
    {
        //通过code获得openid
        if (empty($s_code)) {
            //触发微信返回code码
            $s_url_base = urlencode($s_redirect_uri);
            $s_url      = $this->_create_code_url($s_url_base);
            header("Location: $s_url");
            exit();
        } else {
            //获取code码，以获取openid
            $s_code   = $_GET['code'];
            $s_openid = $this->get_mp_openid($s_code);
            return $s_openid;
        }
    }

    // 退款查询

    /**
     *
     * 构造获取code的url连接
     * @param string $s_url_redirect 微信服务器回跳的url，需要url编码
     *
     * @return string 返回构造好的url
     */
    private function _create_code_url($s_url_redirect)
    {
        $a_url["appid"]         = WxPayConfig::APPID;
        $a_url["redirect_uri"]  = "$s_url_redirect";
        $a_url["response_type"] = "code";
        $a_url["scope"]         = "snsapi_base";
        $a_url["state"]         = "STATE" . "#wechat_redirect";
        $s_url_param            = $this->url_to_param($a_url);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?" . $s_url_param;
    }

    // 关闭订单

    /**
     *
     * 拼接签名字符串
     * @param array $a_url
     *
     * @return 返回已经拼接好的字符串
     */
    private function url_to_param($a_url)
    {
        $s_param = '';
        foreach ($a_url as $s_k => $u_v) {
            if ($s_k != "sign") {
                $s_param .= $s_k . "=" . $u_v . "&";
            }
        }

        $s_param = trim($s_param, "&");
        return $s_param;
    }

    // 验证操作是否成功

    /**
     *
     * 通过code从工作平台获取openid机器access_token
     * @param string $code 微信跳转回来带上的code
     *
     * @return openid
     */
    public function get_mp_openid($s_code)
    {
        $s_url = $this->_create_openid_url($s_code);
        //初始化curl
        $o_curl = curl_init();
        //设置超时
        curl_setopt($o_curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($o_curl, CURLOPT_URL, $s_url);
        curl_setopt($o_curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($o_curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($o_curl, CURLOPT_HEADER, FALSE);
        curl_setopt($o_curl, CURLOPT_RETURNTRANSFER, TRUE);
        if (WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
            && WxPayConfig::CURL_PROXY_PORT != 0) {
            curl_setopt($o_curl, CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
            curl_setopt($o_curl, CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
        }
        //运行curl，结果以jason形式返回
        $s_result = curl_exec($o_curl);
        curl_close($o_curl);
        //取出openid
        $a_data     = json_decode($s_result, true);
        $this->data = $a_data;
        $s_openid   = $a_data['openid'];
        return $s_openid;
    }

    // 异步通知验证

    /**
     *
     * 构造获取open和access_toke的url地址
     * @param string $code，微信跳转带回的code
     *
     * @return 请求的url
     */
    private function _create_openid_url($s_code)
    {
        $a_url["appid"]      = WxPayConfig::APPID;
        $a_url["secret"]     = WxPayConfig::APPSECRET;
        $a_url["code"]       = $s_code;
        $a_url["grant_type"] = "authorization_code";
        $s_url_param         = $this->url_to_param($a_url);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?" . $s_url_param;
    }

    // 签名验证，返回bool值

    /**
     *
     * 获取jsapi支付的参数
     * @param array $a_order_result 统一支付接口返回的数据
     * @throws WxPayException
     *
     * @return json数据，可直接填入js函数作为参数
     */
    public function get_jsapi_param($a_order_result)
    {
        if (!array_key_exists("appid", $a_order_result)
            || !array_key_exists("prepay_id", $a_order_result)
            || $a_order_result['prepay_id'] == "") {
            throw new WxPayException("参数错误");
        }
        $o_jsapi = new WxPayJsApiPay();
        $o_jsapi->SetAppid($a_order_result['appid']);
        // 必须加引号转为字符串格式
        $o_jsapi->SetTimeStamp("{$_SERVER['REQUEST_TIME']}");
        $o_jsapi->SetNonceStr(WxPayApi::getNonceStr());
        $o_jsapi->SetPackage('prepay_id=' . $a_order_result['prepay_id']);
        $o_jsapi->SetSignType('MD5');
        $o_jsapi->SetPaySign($o_jsapi->MakeSign());
        $s_parameters = json_encode($o_jsapi->GetValues());
        return $s_parameters;
    }

    // 把数组参数转为url格式

    public function get_jscode($s_jsapi_param, $param = NULL)
    {
        if (empty($param['pay_function_name'])) {
            $pay_function_name = 'wxpay';
        }

        $s_jscode = "<script type=\"text/javascript\">
		function {$pay_function_name}_call()
		{
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				{$s_jsapi_param},
				function(res){
					WeixinJSBridge.log(res.err_msg);
					// nanget_brand_wcpay_request:ok
					if (res.err_msg == 'get_brand_wcpay_request:ok') {
						// 支付成功
		";
        if (isset($param['url_success']) && !empty($param['url_success'])) {
            $s_jscode .= "window.location.href = '{$param['url_success']}';";
        }
        $s_jscode .= "
					} else {
						// 取消支付（get_brand_wcpay_request:cancal） 或支付失败 get_brand_wcpay_request:fail
		";
        if (isset($param['url_fail']) && !empty($param['url_fail'])) {
            $s_jscode .= "window.location.href = '{$param['url_fail']}';";
        }
        $s_jscode .= "
					}
				}
			);
		}
		function {$pay_function_name}()
		{
			if (typeof WeixinJSBridge == \"undefined\"){
				if( document.addEventListener ){
					document.addEventListener('WeixinJSBridgeReady', {$pay_function_name}_call, false);
				}else if (document.attachEvent){
					document.attachEvent('WeixinJSBridgeReady', {$pay_function_name}_call); 
					document.attachEvent('onWeixinJSBridgeReady', {$pay_function_name}_call);
				}
			}else{
				{$pay_function_name}_call();
			}
		}
		</script>";
        return $s_jscode;
    }

    public function refund($a_param)
    {
        $o_refund = new WxPayRefund();
        if (empty($a_param['transaction_id'])) {
            $o_refund->SetOut_trade_no($a_param['out_trade_no']);
        } else {
            $o_refund->SetTransaction_id($a_param['transaction_id']);

        }
        $o_refund->SetOut_refund_no($a_param['out_refund_no']);
        $o_refund->SetTotal_fee($a_param['total_fee']);
        $o_refund->SetRefund_fee($a_param['refund_fee']);
        $o_refund->SetOp_user_id(WxPayConfig::MCHID);
        $a_result = WxPayApi::refund($o_refund);
        return $a_result;
    }

    public function query($a_param)
    {
        $o_refund = new WxPayOrderQuery();
        if (empty($a_param['transaction_id'])) {
            $o_refund->SetOut_trade_no($a_param['out_trade_no']);
        } else {
            $o_refund->SetTransaction_id($a_param['transaction_id']);
        }
        $a_result = WxPayApi::orderQuery($o_refund);
        return $a_result;
    }

    public function refund_query($a_param)
    {
        $o_refund = new WxPayRefundQuery();
        $o_refund->SetTransaction_id($a_param['transaction_id']);
        $o_refund->SetOut_trade_no($a_param['out_trade_no']);
        $o_refund->SetOut_refund_no($a_param['out_refund_no']);
        $o_refund->SetRefund_id($a_param['refund_id']);
        $a_result = WxPayApi::refundQuery($o_refund);
        return $a_result;
    }

    public function close($a_param)
    {
        $o_refund = new WxPayCloseOrder();
        $o_refund->SetOut_trade_no($a_param['out_trade_no']);
        $a_result = WxPayApi::closeOrder($o_refund);
        return $a_result;
    }

    public function check($a_data, $s_method = 'QUERY')
    {
        switch ($s_method) {
            case 'REFUND':
                if ($a_data['result_code'] == 'SUCCESS' && $a_data['return_code'] == 'SUCCESS') {
                    return true;
                }
                break;
            case 'REFUND_QUERY':
                if ($a_data['refund_status'] == 'SUCCESS') {
                    return true;
                }
                break;
            case 'QUERY':
                if ($a_data['result_code'] == 'SUCCESS') {
                    return true;
                }
                break;
            case 'CLOSE':
                if ($a_data['result_code'] == 'SUCCESS') {
                    return true;
                }
                break;
        }
        return false;
    }

    // 判断是否Https

    public function notify()
    {
        $o_notify = new TW_wx_Notify();
        // true表示需要输出签名
        $o_notify->Handle(true);
    }

    // 调用微信JS api 支付

    public function verify($a_param)
    {
        $s_return_sign = $a_param['sign'];
        // 签名不参与运算
        unset($a_param['sign']);
        //$a_param = array_filter($a_param);
        ksort($a_param);
        $s_url_str = $this->param_to_url($a_param) . '&key=' . WxPayConfig::KEY;
        $s_sign    = strtoupper(md5($s_url_str));

        if ($s_sign == $s_return_sign) {
            return true;
        }
        return false;
    }

    public function param_to_url($a_param)
    {
        return urldecode(http_build_query($a_param));
    }

    // 扫码支付

    public function scan_code($a_param)
    {
        $o_wxpay = new WxPayUnifiedOrder();
        $o_wxpay->SetBody($a_param['body']);
        if (isset($a_param['attach'])) {
            $o_wxpay->SetAttach($a_param['attach']);
        }
        $o_wxpay->SetOut_trade_no($a_param['out_trade_no']);
        $o_wxpay->SetTotal_fee($a_param['total_fee']);
        if (isset($a_param['time_start'])) {
            $o_wxpay->SetTime_start($a_param['time_start']);
        } else {
            $o_wxpay->SetTime_start(date("YmdHis"), $_SERVER['REQUEST_TIME']);
        }
        if ($a_param['time_expire']) {
            $o_wxpay->SetTime_expire(date("YmdHis", $_SERVER['REQUEST_TIME'] + $a_param['time_expire']));
        } else {
            $o_wxpay->SetTime_expire(date("YmdHis", $_SERVER['REQUEST_TIME'] + 600));
        }
        if (isset($a_param['goods_tag'])) {
            $o_wxpay->SetGoods_tag($a_param['goods_tag']);
        }
        if (isset($a_param['nonce_str'])) {
            $o_wxpay->SetGoods_tag($a_param['nonce_str']);
        }
        $o_wxpay->SetNotify_url($a_param['notify_url']);
        $o_wxpay->SetTrade_type("NATIVE");
        $o_wxpay->SetProduct_id($a_param['product_id']);

        $a_result = WxPayApi::unifiedOrder($o_wxpay);
        return $a_result;
    }

    // 生成二维码
    public function qrcode($s_url)
    {
        $o_qrcode =& load_class('phpqrcode', 'libraries');
        $o_qrcode->qrcode(['data' => $s_url]);
    }

    // 刷卡支付
    public function bar_code($a_param)
    {
        // 等待支付页面，会导致session阻塞，因此先停掉session文件锁
        session_write_close();
        try {
            require_once BASEPATH . "/libraries/pay/wxpay_pub/lib/WxPay.MicroPay.php";

            $s_auth_code = $a_param['auth_code'];
            $o_wxpay     = new WxPayMicroPay();
            $o_wxpay->SetAuth_code($s_auth_code);
            $o_wxpay->SetBody($a_param['body']);
            $o_wxpay->SetTotal_fee($a_param['total_fee']);
            $o_wxpay->SetOut_trade_no($a_param['out_trade_no']);

            $o_micro_pay = new MicroPay();

            $a_result = $o_micro_pay->pay($o_wxpay);
        } catch (Exception $e) {
            $a_result = [
                'result_code' => '失败',
                'info'        => $e->getMessage()
            ];
        }
        return $a_result;
    }
}
