<?php
namespace com\unionpay\acp\sdk;
include_once BASEPATH . 'libraries/pay/unionpay/geteway/log.class.php';
include_once BASEPATH . 'libraries/pay/unionpay/geteway/common.php';

class SDKConfig {

	private static $_config = null;
	public static function getSDKConfig(){
		if (SDKConfig::$_config == null ) {
			SDKConfig::$_config = new SDKConfig();
		}
		return SDKConfig::$_config;
	}

	private $frontTransUrl;
	private $backTransUrl;
	private $singleQueryUrl;
	private $batchTransUrl;
	private $fileTransUrl;
	private $appTransUrl;
	private $cardTransUrl;
	private $jfFrontTransUrl;
	private $jfBackTransUrl;
	private $jfSingleQueryUrl;
	private $jfCardTransUrl;
	private $jfAppTransUrl;
	private $qrcBackTransUrl;
	private $qrcB2cIssBackTransUrl;
	private $qrcB2cMerBackTransUrl;

	private $signMethod;
	private $version;
	private $ifValidateCNName;
	private $ifValidateRemoteCert;

	private $signCertPath;
	private $signCertPwd;
	private $validateCertDir;
	private $encryptCertPath;
	private $rootCertPath;
	private $middleCertPath;
	private $frontUrl;
	private $backUrl;
	private $secureKey;
	private $logFilePath;
	private $logLevel;
	// 增加商户号变量
	private $_id_mer;

	function __construct(){
		if (file_exists(PROJECTPATH . "/config/config_unionpay_geteway.php")) {
			require(PROJECTPATH . "/config/config_unionpay_geteway.php");
		} else {
			require(BASEPATH . "libraries/pay/unionpay/geteway/config_unionpay_geteway.php");
		}
		$this->frontTransUrl = 'https://gateway.95516.com/gateway/api/frontTransReq.do';
		$this->backTransUrl = 'https://gateway.95516.com/gateway/api/backTransReq.do';
		$this->singleQueryUrl = 'https://gateway.95516.com/gateway/api/queryTrans.do';
		$this->batchTransUrl = 'https://gateway.95516.com/gateway/api/batchTrans.do';
		$this->fileTransUrl = 'https://filedownload.95516.com/';
		$this->appTransUrl = 'https://gateway.95516.com/gateway/api/appTransReq.do';
		$this->cardTransUrl = 'https://gateway.95516.com/gateway/api/cardTransReq.do';
		$this->jfFrontTransUrl = null;
		$this->jfBackTransUrl = null;
		$this->jfSingleQueryUrl = null;
		$this->jfCardTransUrl = null;
		$this->jfAppTransUrl = null;
		$this->qrcBackTransUrl = null;
		$this->qrcB2cIssBackTransUrl = null;
		$this->qrcB2cMerBackTransUrl = null;

		// 签名方式，证书方式固定01，请勿改动
		$this->signMethod = '01';
		// 报文版本号，固定5.1.0，请勿改动
		$this->version = '5.1.0';
		$this->ifValidateCNName = "true";
		$this->ifValidateRemoteCert = "false";

		$this->signCertPath = $a_config_unionpay_geteway['cert_sign_path'];
		$this->signCertPwd = $a_config_unionpay_geteway['cert_sign_pwd'];

		$this->validateCertDir = null;
		$this->encryptCertPath = $a_config_unionpay_geteway['cert_encrypt_path'];
		$this->rootCertPath = $a_config_unionpay_geteway['cert_root_path'];
		$this->middleCertPath = $a_config_unionpay_geteway['cert_middle_path'];

		$this->frontUrl = $a_config_unionpay_geteway['notify_url_front'];
		$this->backUrl = $a_config_unionpay_geteway['notify_url_back'];

		$this->secureKey = null;
		// 日志打印路径，linux注意要有写权限
		$this->logFilePath = $a_config_unionpay_geteway['log_file_path'];
		// 日志级别，debug级别会打印密钥，生产请用info或以上级别
		$this->logLevel = $a_config_unionpay_geteway['log_level'] ? \defined('DEBUG') || 'DEBUG' : \defined('OFF') || 'OFF';
		// 增加商户号变量
		$this->_id_mer = $a_config_unionpay_geteway['id_mer'];
	}

	public function __get($property_name)
	{
		if(isset($this->$property_name))
		{
			return($this->$property_name);
		}
		else
		{
			return(NULL);
		}
	}

}


