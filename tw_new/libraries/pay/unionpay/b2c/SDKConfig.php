<?php
// "商户在入网测试过程中遇到任何问题，可通过QQ或邮箱或电话进行技术问题沟通。
// QQ：800033969；邮箱：acpservice@unionpay.com；值班电话：021-38929999-2049。

namespace com\unionpay\acp\sdk;

if (file_exists(PROJECTPATH . "/config/config_union_gateway.php")) {
	require(PROJECTPATH . "/config/config_union_gateway.php");
} else {
	require(BASEPATH . "libraries/pay/unionpay/b2c/config_union_gateway.php");
}
define('UNION_SIGN_CERT_PATH', $a_config_union_geteway['union_sign_cert_path']);
define('UNION_SIGN_CERT_PWD', $a_config_union_geteway['union_sign_cert_pwd']);
define('UNION_VERIFY_CERT_DIR', $a_config_union_geteway['union_verify_cert_dir']);
define('UNION_FILE_DOWN_PATH', $a_config_union_geteway['union_file_down_path']);
define('UNION_LOG_FILE_PATH', $a_config_union_geteway['union_log_file_path']);
define('UNION_LOG_LEVEL', $a_config_union_geteway['union_log_level'] ? PhpLog::DEBUG : PhpLog::OFF);
define('UNION_FRONT_NOTIFY_URL', $a_config_union_geteway['union_front_notify_url']);
define('UNION_BACK_NOTIFY_URL', $a_config_union_geteway['union_back_notify_url']);
define('UNION_MERID', $a_config_union_geteway['union_merid']);

// 自定义商户号常量
const SDK_MER_ID = UNION_MERID;

// ######(以下配置为PM环境：入网测试环境用，生产环境配置见文档说明)#######
// 签名证书路径
const SDK_SIGN_CERT_PATH = UNION_SIGN_CERT_PATH;

// 签名证书密码
const SDK_SIGN_CERT_PWD = UNION_SIGN_CERT_PWD;

// 密码加密证书（这条一般用不到的请随便配）
const SDK_ENCRYPT_CERT_PATH = 'D:/certs/acp_test_enc.cer';

// 验签证书路径（请配到文件夹，不要配到具体文件）
const SDK_VERIFY_CERT_DIR = UNION_VERIFY_CERT_DIR;

//;;;;;;;;;;;;;;;;;;;;;;;;;;验签证书配置;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
//; 验签中级证书（证书位于assets/测试环境证书/文件夹下，请复制到d:/certs文件夹）
//acpsdk.middleCert.path=D:/certs/acp_test_middle.cer
const SDK_MIDDLE_CERT_PATH = 'D:/certs/acp_test_middle.cer';
//; 验签根证书（证书位于assets/测试环境证书/文件夹下，请复制到d:/certs文件夹）
//acpsdk.rootCert.path=D:/certs/acp_test_root.cer
const SDK_ROOT_CERT_PATH = 'E:/www/tw/libraries/pay/unionpay/b2c/acp_test_sign.pfx';

// 前台请求地址
const SDK_FRONT_TRANS_URL = 'https://gateway.95516.com/gateway/api/frontTransReq.do';

// 后台请求地址
const SDK_BACK_TRANS_URL = 'https://gateway.95516.com/gateway/api/backTransReq.do';

// 批量交易
const SDK_BATCH_TRANS_URL = 'https://gateway.95516.com/gateway/api/batchTrans.do';

//单笔查询请求地址
const SDK_SINGLE_QUERY_URL = 'https://gateway.95516.com/gateway/api/queryTrans.do';

//文件传输请求地址
const SDK_FILE_QUERY_URL = ' https://filedownload.95516.com/';

//有卡交易地址
const SDK_Card_Request_Url = 'https://gateway.95516.com/gateway/api/cardTransReq.do';

//App交易地址
const SDK_App_Request_Url = 'https://gateway.95516.com/gateway/api/appTransReq.do';

// 前台通知地址 (商户自行配置通知地址)
const SDK_FRONT_NOTIFY_URL = UNION_FRONT_NOTIFY_URL;

// 后台通知地址 (商户自行配置通知地址，需配置外网能访问的地址)
const SDK_BACK_NOTIFY_URL = UNION_BACK_NOTIFY_URL;

//文件下载目录
const SDK_FILE_DOWN_PATH = UNION_FILE_DOWN_PATH;

//日志 目录
const SDK_LOG_FILE_PATH = UNION_LOG_FILE_PATH;

//日志级别，关掉的话改PhpLog::OFF
const SDK_LOG_LEVEL = UNION_LOG_LEVEL;


/** 以下缴费产品使用，其余产品用不到，无视即可 */
// 前台请求地址
const JF_SDK_FRONT_TRANS_URL = 'https://101.231.204.80:5000/jiaofei/api/frontTransReq.do';
// 后台请求地址
const JF_SDK_BACK_TRANS_URL = 'https://101.231.204.80:5000/jiaofei/api/backTransReq.do';
// 单笔查询请求地址
const JF_SDK_SINGLE_QUERY_URL = 'https://101.231.204.80:5000/jiaofei/api/queryTrans.do';
// 有卡交易地址
const JF_SDK_CARD_TRANS_URL = 'https://101.231.204.80:5000/jiaofei/api/cardTransReq.do';
// App交易地址
const JF_SDK_APP_TRANS_URL = 'https://101.231.204.80:5000/jiaofei/api/appTransReq.do';

?>