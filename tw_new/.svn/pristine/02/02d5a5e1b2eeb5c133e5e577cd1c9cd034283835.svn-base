<?php
// 统一下单接口 https://pay.weixin.qq.com/wiki/doc/api/H5.php?chapter=9_20&index=1
// 签名算法 https://pay.weixin.qq.com/wiki/doc/api/H5.php?chapter=4_3
class TW_wxpay_h5
{
    // 请求参数
    private $_a_param = [
        // 商品描述, 必填
        'body'             => '',
        // 商户订单号, 必填
        'out_trade_no'     => '',
        // 标价金额,以分为单位, 必填
        'total_fee'        => '',
        // 终端IP, 必填
        'spbill_create_ip' => '',
        // 交易类型, 必填
        'trade_type'       => 'MWEB',
        // 场景信息
        'scene_info'       => '',
        // 签名类型
        'sign_type'        => '',
        // 商品详情
        'detail'           => '',
        // 设备号
        'device_info'      => '',
        // 附加数据
        'attach'           => '',
        // 标价币种
        'fee_type'         => '',
        // 交易起始时间
        'time_start'       => '',
        // 交易结束时间
        'time_expire'      => '',
        // 商品标记
        'goods_tag'        => '',
        // 商品ID
        'product_id'       => '',
        // 指定支付方式
        'limit_pay'        => '',
        // 用户标识
        'openid'           => '',
        // 随机字符串
        'nonce_str'        => '',
        // 签名
        'sign'             => '',

        // 微信订单号
        'transaction_id'   => '',


        // 通知地址，当设置此参数时，将忽略配置文件中的通知地址
        'notify_url'       => '',
        // 自定义配置文件名，当有多个配置或通知路径等需求时，可以设置不同配置文件来解决
        'config_file'      => 'config_wxpay'
    ];

    // 配置参数
    private $_a_config = [
        // 应用ID
        'app_id'     => '',
        // AppSecret
        'app_secret' => '',
        // 商户私钥
        'api_key'    => ''
    ];

    // 自定义配置文件名，当有多个通知路径等需求时，可以设置不同配置文件来解决
    private $_s_config_file = 'config_wxpay';

    // 构造函数，对参数进行处理
    public function __construct($a_param = [])
    {
        $this->set_param($a_param);
    }

    // 订单支付

    public function set_param($a_param = [])
    {
        if (!is_array($a_param) || empty($a_param)) {
            return false;
        }
        foreach ($a_param as $s_key => $u_val) {
            $this->_a_param[$s_key] = $a_param[$s_key];
        }

        // 使用自定义配置文件
        if (isset($this->_a_param['config_file'])) {
            $this->_s_config_file = $this->_a_param['config_file'];
            unset($this->_a_param['config_file']);
        }

        // 调用配置文件
        $this->_config();

        $this->_a_param['scene_info'] = '{"h5_info": {"type":"' . $this->_a_config['type'] . '","wap_name": "' . $this->_a_config['wap_name'] . '","wap_url": "' . $this->_a_config['wap_url'] . '"}}';
        $this->_a_param['appid']      = $this->_a_config['app_id'];
        $this->_a_param['mch_id']     = $this->_a_config['mch_id'];
        if (empty($this->_a_param['notify_url'])) {
            $this->_a_param['notify_url'] = $this->_a_config['notify_url'];
        }
        $this->_a_param['nonce_str'] = $this->rand_str();
    }

    // 查询订单

    private function _config()
    {
        $this->_s_config_file = rtrim($this->_s_config_file, '.php');
        if (file_exists(PROJECTPATH . "/config/{$this->_s_config_file}.php")) {
            require(PROJECTPATH . "/config/{$this->_s_config_file}.php");
        } else {
            require(BASEPATH . "libraries/pay/wxpay_h5/{$this->_s_config_file}.php");
        }
        if (!isset($a_config_wxpay) || empty($a_config_wxpay['app_id'])
            || empty($a_config_wxpay['app_secret'])
            || empty($a_config_wxpay['api_key'])
            || empty($a_config_wxpay['mch_id'])) {
            throw new Exception("公共参数不完整!");
        }
        $this->_a_config = $a_config_wxpay;
    }

    // 订单退款

    public function rand_str()
    {
        return rand(100000, 999999);
    }

    // 退款查询

    public function pay($a_param = [])
    {
        $this->set_param($a_param);
        // 过滤器
        $this->_filter_param('PAY');

        $this->_a_param['sign'] = $this->get_sign($this->_a_param);
        $s_api_url              = 'https://api.mch.weixin.qq.com/pay/unifiedorder';

        $s_xml = $this->_build_xml();

        $s_result = $this->request($s_api_url, $s_xml);

        return $s_result;
    }

    // 退款查询

    private function _filter_param($s_method)
    {
        $a_param['PAY']          = ['appid', 'mch_id', 'nonce_str', 'sign', 'sign_type', 'device_info', 'sign_type', 'body',
            'detail', 'attach', 'attach', 'out_trade_no', 'fee_type', 'total_fee', 'spbill_create_ip',
            'time_start', 'time_expire', 'goods_tag', 'notify_url', 'trade_type', 'product_id', 'limit_pay',
            'openid', 'scene_info'];
        $a_param['QUERY']        = ['appid', 'mch_id', 'transaction_id', 'out_trade_no', 'nonce_str', 'sign', 'sign_type'];
        $a_param['REFUND']       = ['appid', 'mch_id', 'nonce_str', 'sign', 'sign_type', 'transaction_id', 'out_trade_no',
            'out_refund_no', 'total_fee', 'refund_fee', 'refund_fee_type', 'refund_desc', 'refund_account'];
        $a_param['REFUND_QUERY'] = ['appid', 'mch_id', 'nonce_str', 'sign', 'sign_type', 'transaction_id', 'out_trade_no',
            'out_refund_no', 'refund_id'];
        $a_param['CLOSE']        = ['appid', 'mch_id', 'out_trade_no', 'nonce_str', 'sign', 'sign_type'];
        $a_param['PAY_BANK']     = ['mch_id', 'partner_trade_no', 'nonce_str', 'sign', 'enc_bank_no', 'enc_true_name',
            'bank_code', 'amount', 'desc'];

        $a_param['PAY_ONLY'] = ['appid', 'mch_id', 'nonce_str', 'sign', 'partner_trade_no', 'openid', 'check_name',
            'amount', 'desc', 'spbill_create_ip'];

        $a_param['QUERY_BANK']     = ['mch_id', 'partner_trade_no', 'nonce_str', 'sign'];
        $a_param['GET_PUBLIC_KEY'] = ['mch_id', 'nonce_str', 'sign', 'sign_type'];
        $a_param['PAY_POCKET']     = ['mch_appid', 'mchid', 'device_info', 'nonce_str', 'sign', 'partner_trade_no', 'openid',
            'check_name', 're_user_name', 'amount', 'desc', 'spbill_create_ip'];
        $a_param['QUERY_POCKET']   = ['nonce_str', 'sign', 'partner_trade_no', 'mch_id', 'appid'];

        if (isset($a_param[$s_method])) {
            foreach ($this->_a_param as $s_key => $u_val) {
                if (!in_array($s_key, $a_param[$s_method])) {
                    unset($this->_a_param[$s_key]);
                }
            }
        }

        $this->_a_param = array_filter($this->_a_param);
        ksort($this->_a_param);
    }

    // 生成xml文本

    public function get_sign($a_param = [])
    {
        $s_url_str = $this->param_to_url($this->_a_param) . '&key=' . $this->_a_config['api_key'];
        return strtoupper(md5($s_url_str));
    }

    // 对象转数组，$mode两种模式，1：SIMPLE，2：PARSER

    public function param_to_url($a_param)
    {
        return urldecode(http_build_query($a_param));
    }

    // 签名验证，返回bool值

    private function _build_xml()
    {
        $s_xml = "<xml>";
        foreach ($this->_a_param as $s_key => $u_val) {
            $s_xml .= "<{$s_key}>{$u_val}</{$s_key}>";
        }
        $s_xml .= "</xml>";
        return $s_xml;
    }

    // 结果检查

    /** 连接接口
     * $s_mode 两个模式，1：FILE，2：CURL
     * $b_cert 是否使用证书
     */
    public function request($s_url, $m_data, $s_mode = 'FILE', $b_cert = true, $a_header = NULL)
    {
        if ($s_mode == 'FILE') {
            $a_option = [
                'http' => [
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    //生成URL-encode之后的请求字符串,就是?后的参数
                    'content' => $m_data
                ]
            ];
            // 创建资源流上下文
            $u_context = stream_context_create($a_option);
            $u_result  = file_get_contents($s_url, false, $u_context);
            $a_result  = $this->xml_to_array($u_result);
            return $a_result;
        }

        $o_curl = curl_init();
        //超时时间
        curl_setopt($o_curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($o_curl, CURLOPT_RETURNTRANSFER, 1);
        //这里设置代理，如果有的话
        //curl_setopt($o_curl, CURLOPT_PROXY, '10.206.30.98');
        //curl_setopt($o_curl, CURLOPT_PROXYPORT, 8080);
        curl_setopt($o_curl, CURLOPT_URL, $s_url);
//        curl_setopt($o_curl, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($o_curl, CURLOPT_SSL_VERIFYHOST, false);

        //以下两种方式需选择一种

        if ($b_cert) {
            //第一种方法，cert 与 key 分别属于两个.pem文件
            //默认格式为PEM，可以注释
            curl_setopt($o_curl, CURLOPT_SSLCERTTYPE, 'PEM');
            if (file_exists(PROJECTPATH . "/libraries/apiclient_cert.pem")) {
                $s_cert_path = PROJECTPATH . "/libraries/apiclient_cert.pem";
            } else {
                $s_cert_path = BASEPATH . "libraries/pay/wxpay_h5/apiclient_cert.pem";
            }
            curl_setopt($o_curl, CURLOPT_SSLCERT, realpath($s_cert_path));

            //默认格式为PEM，可以注释
            curl_setopt($o_curl, CURLOPT_SSLKEYTYPE, 'PEM');

            if (file_exists(PROJECTPATH . "/libraries/apiclient_key.pem")) {
                $s_key_path = PROJECTPATH . "/libraries/apiclient_key.pem";
            } else {
                $s_key_path = BASEPATH . "libraries/pay/wxpay_h5/apiclient_key.pem";
            }
            curl_setopt($o_curl, CURLOPT_SSLKEY, realpath($s_key_path));

            // 第二种方式，两个文件合成一个.pem文件
            // curl_setopt($o_curl, CURLOPT_SSLCERT, getcwd().'/all.pem');
        }

        // 设置host
        if (is_array($a_header) && !empty($a_header)) {
            curl_setopt($o_curl, CURLOPT_HTTPHEADER, $a_header);
        }

        curl_setopt($o_curl, CURLOPT_POST, 1);
        curl_setopt($o_curl, CURLOPT_POSTFIELDS, $m_data);
        $a_data = $this->xml_to_array(curl_exec($o_curl));
        if (empty($a_data)) {
            $a_data['error'] = curl_errno($o_curl);
        }
        curl_close($o_curl);
        return $a_data;
    }

    // 返回符合微信验证成功的xml
    public function xml_to_array($s_xml, $mode = 'SIMPLE')
    {
        $a_data = [];
        if ($mode == 'SIMPLE') {
            libxml_disable_entity_loader(true);
            $a_data = json_decode(json_encode(simplexml_load_string($s_xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        } else {
            // 创建 XML 解析器
            $u_parser = xml_parser_create();
            // 将 XML 数据解析到数组中
            xml_parse_into_struct($u_parser, $s_xml, $a_val, $a_index);
            // 释放解析器
            xml_parser_free($u_parser);

            foreach ($a_val as $s_key => $u_val) {
                if (isset ($u_val['tag']) && !empty($u_val['tag']) && isset($u_val['value'])) {
                    $a_data[strtolower($u_val['tag'])] = $u_val['value'];
                }
            }
        }
        return $a_data;
    }

    public function query($a_param = [])
    {
        $this->set_param($a_param);
        // 过滤器
        $this->_filter_param('QUERY');
        // 生成签名
        $this->_a_param['sign'] = $this->get_sign($this->_a_param);

        $s_api_url = 'https://api.mch.weixin.qq.com/pay/orderquery';
        $s_xml     = $this->_build_xml();
        $s_result  = $this->request($s_api_url, $s_xml);
        return $s_result;
    }

    public function refund($a_param = [], $a_header = NULL)
    {
        $this->set_param($a_param);
        // 过滤器
        $this->_filter_param('REFUND');
        // 生成签名
        $this->_a_param['sign'] = $this->get_sign($this->_a_param);

        $s_api_url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
        $s_xml     = $this->_build_xml();

        $s_result = $this->request($s_api_url, $s_xml, 'CURL', true, $a_header);
        return $s_result;
    }

    // 设置参数

    public function refund_query($a_param = [])
    {
        $this->set_param($a_param);
        // 过滤器
        $this->_filter_param('REFUND_QUERY');
        // 生成签名
        $this->_a_param['sign'] = $this->get_sign($this->_a_param);

        $s_api_url = 'https://api.mch.weixin.qq.com/pay/refundquery';
        $s_xml     = $this->_build_xml();

        $s_result = $this->request($s_api_url, $s_xml);
        return $s_result;
    }

    // 生成随机数

    public function close($a_param = [])
    {
        $this->set_param($a_param);
        // 过滤器
        $this->_filter_param('CLOSE');
        // 生成签名
        $this->_a_param['sign'] = $this->get_sign($this->_a_param);

        $s_api_url = 'https://api.mch.weixin.qq.com/pay/closeorder';
        $s_xml     = $this->_build_xml();

        $s_result = $this->request($s_api_url, $s_xml);
        return $s_result;
    }

    // 设置配置文件名

    public function verify($a_param)
    {
        $s_return_sign = $a_param['sign'];
        // 签名不参与运算
        unset($a_param['sign']);
        $a_param = array_filter($a_param);
        ksort($a_param);
        if (empty($this->_a_config['api_key'])) {
            // 调用配置文件
            $this->_config();
        }
        $s_url_str = $this->param_to_url($a_param) . '&key=' . $this->_a_config['api_key'];
        $s_sign    = strtoupper(md5($s_url_str));

        if ($s_sign == $s_return_sign) {
            return true;
        }
        return false;
    }

    // 把数组参数转为url格式

    public function check($a_param, $s_method = 'PAY')
    {
        switch ($s_method) {
            case 'PAY':
                if ($a_param['return_code'] == 'SUCCESS' && $a_param['result_code'] == 'SUCCESS') {
                    return true;
                }
                break;
            case 'REFUND':
                if ($a_param['refund_status'] == 'SUCCESS') {
                    return true;
                }
                break;
            default:
                if ($a_param['return_code'] == 'SUCCESS') {
                    return true;
                }
        }
        return false;
    }

    // 公共参数设置

    public function success()
    {
        return
            '<xml>
				<return_code><![CDATA[SUCCESS]]></return_code>
				<return_msg><![CDATA[OK]]></return_msg>
			</xml>';
    }

    // 参数过滤，由于微信接口只接受指定参数，出现多余参数将报错，这里将把不在数组中出现的参数都会被过滤掉
    // $s_method可选值：PAY, QUERY,

    public function set_config_file($s_config_file)
    {
        $this->_s_config_file = $s_config_file;
    }

    // 企业付款到银行卡 https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=24_2

    public function pay_bank($a_param)
    {
        // 加密姓名和卡号
        $s_pub_key = openssl_pkey_get_public(file_get_contents(BASEPATH . "libraries/pay/wxpay_h5/public.pem"));
        $s_jm_name = '';
        openssl_public_encrypt($a_param['enc_true_name'], $s_jm_name, $s_pub_key, OPENSSL_PKCS1_OAEP_PADDING);
        $a_param['enc_true_name'] = base64_encode($s_jm_name);
        $s_jm_bank_no             = '';
        openssl_public_encrypt($a_param['enc_bank_no'], $s_jm_bank_no, $s_pub_key, OPENSSL_PKCS1_OAEP_PADDING);
        $a_param['enc_bank_no'] = base64_encode($s_jm_bank_no);

        $this->set_param($a_param);
        // 过滤器
        $this->_filter_param('PAY_BANK');

        $this->_a_param['sign'] = $this->get_sign($this->_a_param);
        $s_api_url              = 'https://api.mch.weixin.qq.com/mmpaysptrans/pay_bank';

        $s_xml = $this->_build_xml();

        $s_result = $this->request($s_api_url, $s_xml, 'CURL', true);

        return $s_result;
    }

    // 企业付款到零钱 https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=24_2
    public function pay_only($a_param)
    {

        $this->set_param($a_param);
        // 过滤器
        $this->_filter_param('PAY_ONLY');

        $this->_a_param['sign'] = $this->get_sign($this->_a_param);
        $s_api_url              = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';

        $s_xml = $this->_build_xml();

        $s_result = $this->request($s_api_url, $s_xml, 'CURL', true);

        return $s_result;
    }

    // 企业付款到银行卡结果查询 https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=24_3
    public function query_bank($a_param)
    {
        $this->set_param($a_param);
        // 过滤器
        $this->_filter_param('QUERY_BANK');

        $this->_a_param['sign'] = $this->get_sign($this->_a_param);
        $s_api_url              = 'https://api.mch.weixin.qq.com/mmpaysptrans/query_bank';

        $s_xml = $this->_build_xml();

        $s_result = $this->request($s_api_url, $s_xml, 'CURL', true);

        return $s_result;
    }

    // 企业付款到零钱 https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=14_2
    public function pay_pocket($a_param)
    {
        $this->set_param($a_param);
        $this->_a_param['mchid']     = $this->_a_param['mch_id'];
        $this->_a_param['mch_appid'] = $this->_a_param['appid'];
        // 过滤器
        $this->_filter_param('PAY_POCKET');

        $this->_a_param['sign'] = $this->get_sign($this->_a_param);
        $s_api_url              = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';

        $s_xml = $this->_build_xml();

        $s_result = $this->request($s_api_url, $s_xml, 'CURL', true);

        return $s_result;
    }

    // 企业付款到零钱结果查询 https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=14_3
    public function query_pocket($a_param)
    {
        $this->set_param($a_param);
        // 过滤器
        $this->_filter_param('QUERY_POCKET');

        $this->_a_param['sign'] = $this->get_sign($this->_a_param);
        $s_api_url              = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gettransferinfo';

        $s_xml = $this->_build_xml();

        $s_result = $this->request($s_api_url, $s_xml, 'CURL', true);

        return $s_result;
    }

    // 获取RSA加密公钥API https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=24_3
    public function get_public_key($a_param)
    {
        $this->set_param($a_param);
        // 过滤器
        $this->_filter_param('GET_PUBLIC_KEY');

        $this->_a_param['sign'] = $this->get_sign($this->_a_param);
        $s_api_url              = 'https://fraud.mch.weixin.qq.com/risk/getpublickey';

        $s_xml = $this->_build_xml();

        $s_result = $this->request($s_api_url, $s_xml, 'CURL', true);

        return $s_result;
    }
}
