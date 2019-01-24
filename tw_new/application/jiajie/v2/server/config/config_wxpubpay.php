<?php
/**
 * 微信公众号支付配置
 * @copyright 广州柒度信息科技有限公司
 */

$a_config_wxpay = [
    // 应用ID
    'id_app'          => 'wx6c69af15244da7bc',
    // AppSecret
    'app_secret'      => 'b9bd023014450e2fd4d8b6a97424be15',
    // 商户id
    'id_mch'          => '1514558451',
    // 商户私钥
    'api_key'         => 'ZY6tyw3NpvAEQ8Y27ssK7HcJ1Nn8wmjt',
    // 设置商户证书路径，相对路径可能会报错，最好用绝对路径
//    'ssl_cert_path'   => BASEPATH . 'libraries/pay/wxpay_pub/apiclient_cert.pem',
//    'ssl_key_path'    => BASEPATH . 'libraries/pay/wxpay_pub/apiclient_key.pem',
    'ssl_cert_path'   => realpath(__DIR__ . '/pem/1514558451_20180913_cert.pem'),
    'ssl_key_path'    => realpath(__DIR__ . '/pem/1514558451_20180913_key.pem'),
    // 设置代理机器，只有需要代理的时候才设置，不需要代理，请设置为0.0.0.0和0
    'curl_proxy_host' => '0.0.0.0',
    'curl_proxy_port' => '0',
    // 接口调用上报等级，0.关闭上报; 1.仅错误出错上报; 2.全量上报
    'report_levenl'   => 1,
    // 微信对接时的token
    'wx_token' => 'jr4NxYpK8Uitdanu'
];
