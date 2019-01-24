<?php
$a_config_wxpay = array (
	// 应用ID
	'id_app' => 'wxd40a4f9141fe81d0',
	// AppSecret
	'app_secret' => '2ccfa5ce1255ee17d70a1c5324d6ea02',
	// 商户id
	'id_mch' => '1450892002',
	// 商户私钥
	'api_key' => 'J56tyw3NpvAEQ8Y27ssK7HcJbNn8wwjt',
	// 设置商户证书路径，相对路径可能会报错，最好用绝对路径
	'ssl_cert_path' => BASEPATH . 'libraries/pay/wxpay_pub/apiclient_cert.pem',
	'ssl_key_path' => BASEPATH . 'libraries/pay/wxpay_pub/apiclient_key.pem',
	// 设置代理机器，只有需要代理的时候才设置，不需要代理，请设置为0.0.0.0和0
	'curl_proxy_host' => '0.0.0.0',
	'curl_proxy_port' => '0',
	// 接口调用上报等级，0.关闭上报; 1.仅错误出错上报; 2.全量上报
	'report_levenl' => 1
);