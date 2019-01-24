<?php
/**
  银联网关支付接口
  开发包下载地址：https://open.unionpay.com/ajweb/help/file/techFile?cateLog=Development_kit
  文档： https://open.unionpay.com/ajweb/help/api
 */
 
// mcrypt扩展的函数在php7移除，关闭此相关的警告显示
//error_reporting(E_ALL || ~E_NOTICE);

require_once BASEPATH . '/libraries/pay/unionpay/geteway/acp_service.php';

class TW_unionpay_geteway {
	// 配置参数
	private $_a_config = [];
	
	// 构造函数，对参数进行处理
	public function __construct() {
		$this->_a_config['encoding'] = 'utf-8';
		$this->_a_config['txn_type'] = '01';
		$this->_a_config['txn_sub_type'] = '01';
		$this->_a_config['channel_type'] = '07';
		$this->_a_config['access_type'] = '0';
		$this->_a_config['currency_code'] = '156';
		$this->_a_config['biz_type'] = '000201';
	}
	
	// 支付
	public function pay($a_param = []) {
		$a_data = [
			// 版本号
			'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,
			// 编码方式
			'encoding' => $this->_a_config['encoding'],
			// 交易类型
			'txnType' => $this->_a_config['txn_type'],
			// 交易子类
			'txnSubType' => $this->_a_config['txn_sub_type'],
			// 业务类型
			'bizType' => $this->_a_config['biz_type'],
			// 前台通知地址
			'frontUrl' => isset($a_param['url_front']) ? $a_param['url_front'] : com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->frontUrl,
			// 后台通知地址
			'backUrl' => isset($a_param['url_back']) ? $a_param['url_back'] : com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backUrl,
			// 签名方法
			'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,
			// 渠道类型，07-PC，08-手机
			'channelType' => $this->_a_config['channel_type'],
			// 接入类型
			'accessType' => $this->_a_config['access_type'],
			// 交易币种，境内商户固定156
			'currencyCode' => $this->_a_config['currency_code'],

			//TODO 以下信息需要填写
			'merId' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->_id_mer,		//商户代码，请改自己的测试商户号
			'orderId' => $a_param['id_order'],	//商户订单号，8-32位数字字母，不能含“-”或“_”
			'txnTime' =>  date('YmdHis'),//$_POST["txnTime"],	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间
			'txnAmt' => $a_param['amount'],	//交易金额，单位分

			// 订单超时时间。
			// 超过此时间后，除网银交易外，其他交易银联系统会拒绝受理，提示超时。 跳转银行网银交易如果超时后交易成功，会自动退款，大约5个工作日金额返还到持卡人账户。
			// 此时间建议取支付时的北京时间加15分钟。
			// 超过超时时间调查询接口应答origRespCode不是A6或者00的就可以判断为失败。
			'payTimeout' => isset($a_param['time_out']) ? $a_param['time_out'] : date('YmdHis', strtotime('+30 minutes')), 

			// 请求方保留域，
			// 透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据。
			// 出现部分特殊字符时可能影响解析，请按下面建议的方式填写：
			// 1. 如果能确定内容不会出现&={}[]"'等符号时，可以直接填写数据，建议的方法如下。
			//    'reqReserved' =>'透传信息1|透传信息2|透传信息3',
			// 2. 内容可能出现&={}[]"'符号时：
			// 1) 如果需要对账文件里能显示，可将字符替换成全角＆＝｛｝【】“‘字符（自己写代码，此处不演示）；
			// 2) 如果对账文件没有显示要求，可做一下base64（如下）。
			//    注意控制数据长度，实际传输的数据长度不能超过1024位。
			//    查询、通知等接口解析时使用base64_decode解base64后再对数据做后续解析。
			//    'reqReserved' => base64_encode('任意格式的信息都可以'),

			//TODO 其他特殊用法请查看 special_use_purchase.php
		];

		com\unionpay\acp\sdk\AcpService::sign($a_data);
		$s_url = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->frontTransUrl;
		$s_html = com\unionpay\acp\sdk\AcpService::createAutoFormHtml($a_data, $s_url);
		return $s_html;
		//file_put_contents('d:/1.txt', $s_html);
	}
	
	// 验证
	public function verify($a_param) {
		$b_result = com\unionpay\acp\sdk\AcpService::validate($a_param);
		return $b_result;
	}
	
	// 查询
	public function query($a_param = []) {
		$a_data = [
			// 版本号
			'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,
			// 编码方式
			'encoding' => $this->_a_config['encoding'],
			// 签名方法
			'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,
			// 交易类型
			'txnType' => '00',
			// 交易子类
			'txnSubType' => '00',
			// 业务类型
			'bizType' => '000000',
			// 接入类型
			'accessType' => $this->_a_config['access_type'],
			// 渠道类型
			'channelType' => $this->_a_config['channel_type'],

			// TODO 以下信息需要填写
			'orderId' => $a_param['id_order'],	//请修改被查询的交易的订单号，8-32位数字字母，不能含“-”或“_”
			//商户代码，请改自己的测试商户号
			'merId' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->_id_mer,
			//请修改被查询的交易的订单发送时间，格式为YYYYMMDDhhmmss
			'txnTime' => date('YmdHis'),
		];

		com\unionpay\acp\sdk\AcpService::sign($a_data); // 签名
		$s_url = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->singleQueryUrl;

		$a_result = com\unionpay\acp\sdk\AcpService::post($a_data, $s_url);
		return $a_result;
	}
	
	// 撤消（可以实现全额退款，但是非退款功能）
	public function undo($a_param = []) {
		$a_data = [
			// 版本号
			'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,
			// 编码方式
			'encoding' => $this->_a_config['encoding'],
			// 签名方法
			'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,
			// 交易类型
			'txnType' => '31',
			// 交易子类
			'txnSubType' => '00',
			// 业务类型
			'bizType' => '000201',
			// 接入类型
			'accessType' => '0',
			// 渠道类型
			'channelType' => '07',
			// 后台通知地址
			'backUrl' => isset($a_param['url_back']) ? $a_param['url_back'] : com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backUrl,
			
			// 商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则，重新产生，不同于原消费
			'orderId' => $a_param['id_order'],
			// 商户代码，请改成自己的测试商户号
			'merId' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->_id_mer,
			// 原消费的queryId，可以从查询接口或者通知接口中获取
			'origQryId' => $a_param['id_query'],
			//订单发送时间，格式为YYYYMMDDhhmmss，重新产生，不同于原消费
			'txnTime' => date('YmdHis'),
			//交易金额，消费撤销时需和原消费一致
			'txnAmt' => $a_param['amount'],
		];
		// 签名
		com\unionpay\acp\sdk\AcpService::sign($a_data);
		$s_url = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backTransUrl;

		$a_result = com\unionpay\acp\sdk\AcpService::post($a_data, $s_url);
		return $a_result;
	}
	
	// 退款
	public function refund($a_param = []) {
		$params = [
			// 版本号
			'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,
			//编码方式
			'encoding' => $this->_a_config['encoding'],
			// 签名方法
			'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,
			// 交易类型
			'txnType' => '04',
			// 交易子类
			'txnSubType' => '00',
			// 业务类型
			'bizType' => '000201',
			// 接入类型
			'accessType' => '0',
			// 渠道类型
			'channelType' => '07',
			// 后台通知地址
			'backUrl' => isset($a_param['url_back']) ? $a_param['url_back'] : com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backUrl,
			
			// 商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则，重新产生，不同于原消费
			'orderId' => $a_param['id_order'],
			// 商户代码，请改成自己的测试商户号
			'merId' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->_id_mer,
			// 原消费的queryId，可以从查询接口或者通知接口中获取
			'origQryId' => $a_param['id_query'],
			// 订单发送时间，格式为YYYYMMDDhhmmss，重新产生，不同于原消费
			'txnTime' => date('YmdHis'),
			// 交易金额，退货总金额需要小于等于原消费
			'txnAmt' => $a_param['amount'],
		];

		com\unionpay\acp\sdk\AcpService::sign ( $params ); // 签名
		$s_url = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backTransUrl;

		$a_result = com\unionpay\acp\sdk\AcpService::post($params, $s_url);
		return $a_result;
	}
}
?>