<?php

defined('BASEPATH') OR exit('No direct script access allowed');
// 加载接口入口文件
// header ( 'Content-type:text/html;charset=utf-8' );
require_once(BASEPATH . '/libraries/pay/unionpay/df/acp_service.php');

class TW_Unionpay_df {

	// 公共参数数组

	// 银联接口对象
	// private $_o_aop;

	// 构造函数，对参数进行处理
	public function __construct($a_param = []) {
		$this->_config();
	}

	// 执行接口调用
	/**
	* 重要：联调测试时请仔细阅读注释！
	*
	* 产品：代付产品<br>
	* 交易：单笔代付：后台异步交易，有同步应答和异步应答<br>
	* 日期： 2015-09<br>
	* 版权： 中国银联<br>
	* 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
	* 提示：该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《代付产品接口规范》，<br>
	*              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范），
	*              《全渠道平台接入接口规范 第3部分 文件接口》（对账文件格式说明）<br>
	* 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
	* 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
	*                             测试过程中产生的7位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
	*                          2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
	*                          3）  测试环境测试支付请使用测试卡号测试， FAQ搜索“测试卡号”
	*                          4） 切换生产环境要点请FAQ搜索“切换”
	* 交易说明:以后台通知或交易状态查询交易确定交易成功
		//TODO 填寫卡信息
		//支付卡要素说明：证件和姓名至少出现一个，其余手机号等要素不送

		$accNo = '6226388000000095';
		$customerInfo = array(
				'certifTp' => '01',
				'certifId' => '510265790128303',
				'customerNm' => '张三',
		);

		$params = array(

				//以下信息非特殊情况不需要改动
				'version' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->version,		      //版本号
				'encoding' => 'utf-8',		      //编码方式
				'signMethod' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->signMethod,		      //签名方法
				'txnType' => '12',		          //交易类型
				'txnSubType' => '00',		      //交易子类
				'bizType' => '000401',		      //业务类型
				'accessType' => '0',		      //接入类型
				'channelType' => '08',		      //渠道类型
		        'currencyCode' => '156',          //交易币种，境内商户勿改
				'backUrl' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->backUrl, //后台通知地址
				'encryptCertId' => com\unionpay\acp\sdk\df\AcpService::getEncryptCertId(), //验签证书序列号

				//TODO 以下信息需要填写
				'merId' => $_POST["merId"],		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
				'orderId' => $_POST["orderId"],	//商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
				'txnTime' => $_POST["txnTime"],	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
				'txnAmt' => $_POST["txnAmt"],	//交易金额，单位分，此处默认取demo演示页面传递的参数
		// 		'billNo' =>'保险',  				//银行附言。会透传给发卡行，完成改造的发卡行会把这个信息在账单、短信中显示给用户的，请按真实情况填写。

		// 		'accNo' => $accNo,     //卡号，旧规范请按此方式填写
		// 		'customerInfo' => com\unionpay\acp\sdk\df\AcpService::getCustomerInfo($customerInfo), //持卡人身份信息，旧规范请按此方式填写
				'accNo' =>  com\unionpay\acp\sdk\df\AcpService::encryptData($accNo),     //卡号，新规范请按此方式填写
				'customerInfo' => com\unionpay\acp\sdk\df\AcpService::getCustomerInfoWithEncrypt($customerInfo), //持卡人身份信息，新规范请按此方式填写

				//收款账号为对公时：测试卡使用 6212142600000000167（单位结算卡）
				//单位结算卡完整账户名称     comDebitCardAccName 120字节以下，支持汉字，1个汉字算2字节
				//营业执照注册号        businessLicenseRegNo 20字节以下，支持汉字，1个汉字算2字节
				//'accType' => '04',				//04表示对公账户,当04时不需要送customerInfo
				//'reserved' => '{comDebitCardAccName=中国银联单位结算卡&businessLicenseRegNo=1101888888}',


				//sourcesOfFunds为01时payerVerifiInfo必送，其他情况不送payerVerifiInfo。
				//付款方账号        payerAccNo     1到19位数字
				//付款方姓名        payerNm 30字节以下，支持汉字，1个汉字算2字节
				//'sourcesOfFunds' =>'01',
				//'payerVerifiInfo' =>'{payerAccNo=6226090000000048&payerNm=张三}',


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
		);
	 */
	public function pay($customerInfo, $accNo, $a_param = []) {
		$params = array(
				//以下信息非特殊情况不需要改动
				'version' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->version,		      //版本号
				'encoding' => 'utf-8',		      //编码方式
				'signMethod' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->signMethod,		      //签名方法
				'txnType' => '12',		          //交易类型
				'txnSubType' => '00',		      //交易子类
				'bizType' => '000401',		      //业务类型
				'accessType' => '0',		      //接入类型
				'channelType' => '08',		      //渠道类型
		        'currencyCode' => '156',          //交易币种，境内商户勿改
				'backUrl' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->backUrl, //后台通知地址
				'encryptCertId' => com\unionpay\acp\sdk\df\AcpService::getEncryptCertId(), //验签证书序列号

				//TODO 以下信息需要填写
				//'merId' => $_POST["merId"],		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
				//'orderId' => $_POST["orderId"],	//商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
				//'txnTime' => $_POST["txnTime"],	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
				//'txnAmt' => $_POST["txnAmt"],	//交易金额，单位分，此处默认取demo演示页面传递的参数
		// 		'billNo' =>'保险',  				//银行附言。会透传给发卡行，完成改造的发卡行会把这个信息在账单、短信中显示给用户的，请按真实情况填写。

		// 		'accNo' => $accNo,     //卡号，旧规范请按此方式填写
		// 		'customerInfo' => com\unionpay\acp\sdk\df\AcpService::getCustomerInfo($customerInfo), //持卡人身份信息，旧规范请按此方式填写
				'accNo' =>  com\unionpay\acp\sdk\df\AcpService::encryptData($accNo),     //卡号，新规范请按此方式填写
				'customerInfo' => com\unionpay\acp\sdk\df\AcpService::getCustomerInfoWithEncrypt($customerInfo), //持卡人身份信息，新规范请按此方式填写

				//收款账号为对公时：测试卡使用 6212142600000000167（单位结算卡）
				//单位结算卡完整账户名称     comDebitCardAccName 120字节以下，支持汉字，1个汉字算2字节
				//营业执照注册号        businessLicenseRegNo 20字节以下，支持汉字，1个汉字算2字节
				//'accType' => '04',				//04表示对公账户,当04时不需要送customerInfo
				//'reserved' => '{comDebitCardAccName=中国银联单位结算卡&businessLicenseRegNo=1101888888}',


				//sourcesOfFunds为01时payerVerifiInfo必送，其他情况不送payerVerifiInfo。
				//付款方账号        payerAccNo     1到19位数字
				//付款方姓名        payerNm 30字节以下，支持汉字，1个汉字算2字节
				//'sourcesOfFunds' =>'01',
				//'payerVerifiInfo' =>'{payerAccNo=6226090000000048&payerNm=张三}',


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
		);

        // 四个必须的参数
		if (isset($a_param['orderId'])) {
			$params['orderId'] = $a_param['orderId'];
		}
		else
		    return array();

		if (isset($a_param['merId'])) {
			$params['merId'] = $a_param['merId'];
		}
		else
		    return array();

		if (isset($a_param['txnTime'])) {
			$params['txnTime'] = $a_param['txnTime'];
		}
		else
		    return array();

		if (isset($a_param['txnAmt'])) {
			$params['txnAmt'] = $a_param['txnAmt'];
		}
		else
		    return array();

		com\unionpay\acp\sdk\df\AcpService::sign ( $params ); // 签名
		$url = com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->backTransUrl;

		$result_arr = com\unionpay\acp\sdk\df\AcpService::post ( $params, $url);
		if(count($result_arr)<=0) { //没收到200应答的情况
			return array();
		}

		return $result_arr;

		//if (!com\unionpay\acp\sdk\df\AcpService::validate ($result_arr) ){
		//    echo "应答报文验签失败<br>\n";
		//    return;
		//}

		//echo "应答报文验签成功<br>\n";
		//if ($result_arr["respCode"] == "00"){
		//    //交易已受理，等待接收后台通知更新订单状态，如果通知长时间未收到也可发起交易状态查询
		//    //TODO
		//    echo "受理成功。<br>\n";
		//} else if ($result_arr["respCode"] == "03"
		// 	    || $result_arr["respCode"] == "04"
		// 	    || $result_arr["respCode"] == "05"
		// 	    || $result_arr["respCode"] == "01"
		// 	    || $result_arr["respCode"] == "12"
		// 	    || $result_arr["respCode"] == "34"
		// 	    || $result_arr["respCode"] == "60" ){
		//    //后续需发起交易状态查询交易确定交易状态
		//    //TODO
		//     echo "处理超时，请稍后查询。<br>\n";
		//} else {
		//    //其他应答码做以失败处理
		//     //TODO
		//     echo "失败：" . $result_arr["respMsg"] . "。<br>\n";
		//}
	}

	/**
	 * 交易查询接口文档：
	 *
	 * 重要：联调测试时请仔细阅读注释！
	 *
	 * 产品：代付产品<br>
	 * 交易：交易状态查询交易：只有同步应答 <br>
	 * 日期： 2015-09<br>
	 * 版本： 1.0.0
	 * 版权： 中国银联<br>
	 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能及规范性等方面的保障<br>
	 * 该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《代付产品接口规范》，<br>
	 *              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范）<br>
	 * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
	 * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
	 *                             测试过程中产生的7位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
	 *                           2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
	 * 交易说明：代付同步返回00，如果未收到后台通知建议3分钟后发起查询交易，可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03 04 05 01 12 34 60继续查询，否则终止查询）。【如果最终尚未确定交易是否成功请以对账文件为准】
	 *        代付同步返03 04 05 01 12 34 60响应码及未得到银联响应（读超时）建议3分钟后发起查询交易，可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03 04 05 01 12 34 60继续查询，否则终止查询）。【如果最终尚未确定交易是否成功请以对账文件为准】
	 *
		$params = array(
				//以下信息非特殊情况不需要改动
				'version' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->version,		  //版本号
				'encoding' => 'utf-8',		  //编码方式
				'signMethod' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->signMethod,		  //签名方法
				'txnType' => '00',		      //交易类型
				'txnSubType' => '00',		  //交易子类
				'bizType' => '000000',		  //业务类型
				'accessType' => '0',		  //接入类型
				'channelType' => '07',		  //渠道类型

				//TODO 以下信息需要填写
				'orderId' => $_POST["orderId"],	//请修改被查询的交易的订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数
				'merId' => $_POST["merId"],	    //商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
				'txnTime' => $_POST["txnTime"],	//请修改被查询的交易的订单发送时间，格式为YYYYMMDDhhmmss，此处默认取demo演示页面传递的参数
			);
		return array()
	 */
	public function query($a_param = []) {

		$params = array(
				//以下信息非特殊情况不需要改动
				'version' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->version,		  //版本号
				'encoding' => 'utf-8',		  //编码方式
				'signMethod' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->signMethod,		  //签名方法
				'txnType' => '00',		      //交易类型
				'txnSubType' => '00',		  //交易子类
				'bizType' => '000000',		  //业务类型
				'accessType' => '0',		  //接入类型
				'channelType' => '07',		  //渠道类型

				//TODO 以下信息需要填写
				//'orderId' => $_POST["orderId"],	//请修改被查询的交易的订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数
				//'merId' => $_POST["merId"],	    //商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
				//'txnTime' => $_POST["txnTime"],	//请修改被查询的交易的订单发送时间，格式为YYYYMMDDhhmmss，此处默认取demo演示页面传递的参数
			);

        // 三个必须的参数
		if (isset($a_param['orderId'])) {
			$params['orderId'] = $a_param['orderId'];
		}
		else
		    return array();

		if (isset($a_param['merId'])) {
			$params['merId'] = $a_param['merId'];
		}
		else
		    return array();

		if (isset($a_param['txnTime'])) {
			$params['txnTime'] = $a_param['txnTime'];
		}
		else
		    return array();

		com\unionpay\acp\sdk\df\AcpService::sign ( $params ); // 签名
		$url = com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->singleQueryUrl;

		$result_arr = com\unionpay\acp\sdk\df\AcpService::post ( $params, $url);

		return $result_arr;

        /*
		if(count($result_arr)<=0) { //没收到200应答的情况
			return;
		}

		if (!com\unionpay\acp\sdk\df\AcpService::validate ($result_arr) ){
		    echo "应答报文验签失败<br>\n";
		    return;
		}

		echo "应答报文验签成功<br>\n";
		if ($result_arr["respCode"] == "00"){
		  if ($result_arr["origRespCode"] == "00"){
			    //交易成功
			    //TODO
			    echo "交易成功。<br>\n";
			} else if ($result_arr["origRespCode"] == "03"
			 	    || $result_arr["origRespCode"] == "04"
			 	    || $result_arr["origRespCode"] == "05"
			 	    || $result_arr["origRespCode"] == "01"
			 	    || $result_arr["origRespCode"] == "12"
			 	    || $result_arr["origRespCode"] == "34"
			 	    || $result_arr["origRespCode"] == "60" ){
			    //后续需发起交易状态查询交易确定交易状态
			    //TODO
			     echo "交易处理中，请稍微查询。<br>\n";
			} else {
			    //其他应答码做以失败处理
			     //TODO
			     echo "交易失败：" . $result_arr["origRespMsg"] . "。<br>\n";
			}
		} else if ($result_arr["respCode"] == "03"
		 	    || $result_arr["respCode"] == "04"
		 	    || $result_arr["respCode"] == "05" ){
		    //后续需发起交易状态查询交易确定交易状态
		    //TODO
		     echo "处理超时，请稍微查询。<br>\n";
		} else {
		    //其他应答码做以失败处理
		     //TODO
		     echo "失败：" . $result_arr["respMsg"] . "。<br>\n";
		}*/
	}

	// 执行接口调用
	/**
	 * 重要：联调测试时请仔细阅读注释！
	 *
	 * 产品：代付产品<br>
	 * 交易：批量代付：后台交易<br>
	 * 日期： 2015-09<br>
	 * 版权： 中国银联<br>
	 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
	 * 提示：该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《代付产品接口规范》，<br>
	 *                  《全渠道平台接入接口规范 第3部分 文件接口》（4.批量文件基本约定）<br>
	 * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
	 * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
	 *                             测试过程中产生的7位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
	 *                          2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
	 *                          3）  测试环境测试支付请使用测试卡号测试， FAQ搜索“测试卡号”
	 *                          4） 切换生产环境要点请FAQ搜索“切换”
	 * 交易说明:   1)确定批量结果请调用批量交易状态查询交易,无后台通知。
	 *          2)批量文件格式请参考 《全渠道平台接入接口规范 第3部分 文件接口》（4.批量文件基本约定）
	 *          3）批量代付文件示例DF00000000777290058110097201507140002I.txt，注意：使用的时候需修改文件内容的批次号，日期（与txnTime前八位相同）总笔数，总金额等于下边参数中batchNo，txnTime，totalQty，totalAmt设定的一致。
		//TODO 填寫卡信息
		//支付卡要素说明：证件和姓名至少出现一个，其余手机号等要素不送

		$params = array(

				//以下信息非特殊情况不需要改动
				'version' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->version,				//版本号
				'encoding' => 'UTF-8',				//编码方式
				'signMethod'=>'01',					//签名方法
				'txnType' => '21',					//交易类型
				'txnSubType' => '03',				//交易子类型
				'bizType' => '000401',				//业务类型
				'accessType' => '0',				//接入类型
				'channelType'=>'07',				//收单机构代码

				//TODO 以下信息需要填写
				'merId' => $_POST["merId"],		    //商户代码，请改成自己的测试商户号
				'batchNo' => $_POST["batchNo"],		//批次号，当天唯一，0001-9999，商户号+批次号+上交易时间确定一笔交易
				'txnTime' => $_POST["txnTime"],		//订单发送时间，取系统时间
				'totalQty' => $_POST["totalQty"],					 //总笔数
				'totalAmt' => $_POST["totalAmt"],					 //总金额，单位分
				'fileContent' => com\unionpay\acp\sdk\df\AcpService::enCodeFileContent($_POST["filePath"]), //文件内容，内容组成请参考规范文件部分，文件gbk编码或utf8无dom编码，样例文件请参考assets文件夹下的DF00000000777290058110097201507140002I.txt文件，请注意修改商户号、批次、日期等信息。调接口时文件名不会往后传，所以不用参考规范给文件名命名。
			);
	 */
	public function payBat($a_param = []) {
		$params = array(

				//以下信息非特殊情况不需要改动
				'version' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->version,				//版本号
				'encoding' => 'UTF-8',				//编码方式
				'signMethod'=>'01',					//签名方法
				'txnType' => '21',					//交易类型
				'txnSubType' => '03',				//交易子类型
				'bizType' => '000401',				//业务类型
				'accessType' => '0',				//接入类型
				'channelType'=>'07',				//收单机构代码

				//TODO 以下信息需要填写
				//'merId' => $_POST["merId"],		    //商户代码，请改成自己的测试商户号
				//'batchNo' => $_POST["batchNo"],		//批次号，当天唯一，0001-9999，商户号+批次号+上交易时间确定一笔交易
				//'txnTime' => $_POST["txnTime"],		//订单发送时间，取系统时间
				//'totalQty' => $_POST["totalQty"],					 //总笔数
				//'totalAmt' => $_POST["totalAmt"],					 //总金额，单位分
				//'fileContent' => com\unionpay\acp\sdk\df\AcpService::enCodeFileContent($_POST["filePath"]), //文件内容，内容组成请参考规范文件部分，文件gbk编码或utf8无dom编码，样例文件请参考assets文件夹下的DF00000000777290058110097201507140002I.txt文件，请注意修改商户号、批次、日期等信息。调接口时文件名不会往后传，所以不用参考规范给文件名命名。
			);

        // 六个必须的参数
		if (isset($a_param['batchNo'])) {
			$params['batchNo'] = $a_param['batchNo'];
		}
		else
		    return array();

		if (isset($a_param['merId'])) {
			$params['merId'] = $a_param['merId'];
		}
		else
		    return array();

		if (isset($a_param['txnTime'])) {
			$params['txnTime'] = $a_param['txnTime'];
		}
		else
		    return array();

		if (isset($a_param['txnAmt'])) {
			$params['txnAmt'] = $a_param['txnAmt'];
		}
		else
		    return array();

		if (isset($a_param['totalQty'])) {
			$params['totalQty'] = $a_param['totalQty'];
		}
		else
		    return array();

		if (isset($a_param['filePath'])) {
			$params['fileContent'] = com\unionpay\acp\sdk\df\AcpService::enCodeFileContent($a_param['filePath']);
		}
		else
		    return array();

		com\unionpay\acp\sdk\df\AcpService::sign ( $params ); // 签名
		$url = com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->batchTransUrl;

		$result_arr = com\unionpay\acp\sdk\df\AcpService::post ( $params, $url);

		if(count($result_arr)<=0) { //没收到200应答的情况
			return array();
		}

		return $result_arr;

        /*
		if (!com\unionpay\acp\sdk\df\AcpService::validate ($result_arr) ){
		    echo "应答报文验签失败<br>\n";
		    return;
		}

		echo "应答报文验签成功<br>\n";
		if ($result_arr["respCode"] == "00"){
			//交易已受理
		    //需发起交易批量状态查询交易（Form10_6_6_BatchQuery）确定交易状态【建议1小时后查询】
		    //TODO
			echo "受理成功。<br>\n";
		} else {
			//其他应答码做以失败处理
			//TODO
			echo "失败：respMsg=" . $result_arr["respMsg"] . "。<br>\n";
		}*/
	}

	/**
	 * 重要：联调测试时请仔细阅读注释！
	 *
	 * 产品：代付产品<br>
	 * 交易：批量交易状态查询类交易：后台交易，用户查询批量结果文件<br>
	 * 日期： 2015-09<br>
	 * 版权： 中国银联<br>
	 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
	 * 提示：该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《代付产品接口规范》，<br>
	 *                  《全渠道平台接入接口规范 第3部分 文件接口》（4.批量文件基本约定）<br>
	 * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
	 * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
	 *                             测试过程中产生的7位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
	 *                          2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
	 *                          3）  测试环境测试支付请使用测试卡号测试， FAQ搜索“测试卡号”
	 *                          4） 切换生产环境要点请FAQ搜索“切换”
	 * 交易说明: 1)确定批量结果请调用此交易。
	 *        2)批量文件格式请参考 《全渠道平台接入接口规范 第3部分 文件接口》（4.批量文件基本约定）
	 *        3)批量交易状态查询的时间机制：建议间隔1小时后查询。
	 *
		$params = array(

				//以下信息非特殊情况不需要改动
				'version' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->version,				//版本号
				'encoding' => 'UTF-8',				//编码方式
				'signMethod' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->signMethod,				//签名方法
				'txnType' => '22',					//交易类型
				'txnSubType' => '03',				//交易子类型
				'bizType' => '000401',				//业务类型
				'accessType' => '0',				//接入类型
				'channelType'=>'07',				//渠道类型

				//TODO 以下信息需要填写
				'merId' => $_POST["merId"],         //商户代码，请改成自己的测试商户号
				'txnTime' => $_POST["txnTime"],     //订单发送时间，取原批量交易订单发送时间
				'batchNo' => $_POST["batchNo"],	    //批次号，填原批量交易批次号
			);
		return array()
	 */
	public function queryBat($a_param = []) {

		$params = array(

				//以下信息非特殊情况不需要改动
				'version' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->version,				//版本号
				'encoding' => 'UTF-8',				//编码方式
				'signMethod' => com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->signMethod,				//签名方法
				'txnType' => '22',					//交易类型
				'txnSubType' => '03',				//交易子类型
				'bizType' => '000401',				//业务类型
				'accessType' => '0',				//接入类型
				'channelType'=>'07',				//渠道类型

				//TODO 以下信息需要填写
				//'merId' => $_POST["merId"],         //商户代码，请改成自己的测试商户号
				//'txnTime' => $_POST["txnTime"],     //订单发送时间，取原批量交易订单发送时间
				//'batchNo' => $_POST["batchNo"],	    //批次号，填原批量交易批次号
			);

        // 三个必须的参数
		if (isset($a_param['batchNo'])) {
			$params['batchNo'] = $a_param['batchNo'];
		}
		else
		    return array();

		if (isset($a_param['merId'])) {
			$params['merId'] = $a_param['merId'];
		}
		else
		    return array();

		if (isset($a_param['txnTime'])) {
			$params['txnTime'] = $a_param['txnTime'];
		}
		else
		    return array();

		com\unionpay\acp\sdk\df\AcpService::sign ( $params ); // 签名
		$url = com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->batchTransUrl;

		$result_arr = com\unionpay\acp\sdk\df\AcpService::post ( $params, $url);

		return $result_arr;

        /*
		if(count($result_arr)<=0) { //没收到200应答的情况
			return;
		}

		if (!com\unionpay\acp\sdk\df\AcpService::validate ($result_arr) ){
		    echo "应答报文验签失败<br>\n";
		    return;
		}

		$filePath = "d:/file/";
		//TODO 处理文件，保存路径上面那行设置，注意预先建立文件夹并授读写权限

		echo "应答报文验签成功<br>\n";
		if ($result_arr["respCode"] == "00"){
			//交易已受理
			//需发起交易批量状态查询交易（Form10_6_6_BatchQuery）确定交易状态【建议1小时后查询】
			//TODO
			echo "受理成功。<br>\n";
			if (com\unionpay\acp\sdk\df\AcpService::deCodeFileContent( $result_arr, $filePath )) //文件保存目录在配置文件SDKConfig.php中修改
				echo "文件成功保存到".$filePath."目录下。<br>\n";
			else
				echo "文件保存失败，请看下日志文件中的报错信息。<br>\n";

		} else if ($result_arr["respCode"] == "03"
				|| $result_arr["respCode"] == "04"
				|| $result_arr["respCode"] == "05" ){
			//状态未知
			//发起交易批量状态查询交易（Form10_6_6_BatchQuery）确定交易状态
			//TODO
			echo "状态未知，稍后发批量查询。<br>\n";
		} else {
			//其他应答码做以失败处理
			//TODO
			echo "失败：respMsg=" . $result_arr["respMsg"] . "。<br>\n";
		}*/
	}

	// 解密数据，返回string值
	public function decryptData($encryptData) {
		return com\unionpay\acp\sdk\df\AcpService::decryptData ($encryptData);
	}

	// 签名验证，返回bool值
	public function validate($result_arr) {
		return com\unionpay\acp\sdk\df\AcpService::validate ($result_arr);
	}

	// 公共参数设置
	// 为兼容升级便利，采用原SDK配置文件格式
	// 直接采用 b2c类库 的配置文件， 覆盖原有的ini配置值
	private function _config() {
		if (file_exists(PROJECTPATH . '/config/config_unionpay.php')) {
			include_once(PROJECTPATH . '/config/config_unionpay.php');
		} else {
			include_once(BASEPATH . 'libraries/pay/unionpay/b2c/SDKConfig.php');
		}
		//if ( ! isset($a_config_alipay) || empty($a_config_alipay['app_id'])
		//	|| empty($a_config_alipay['key_private'])
		//	|| empty($a_config_alipay['key_public']) ) {
		//	throw new Exception("公共参数不完整!");
		//}
		//$this->_a_config = $a_config_alipay;

		// 兼容性补丁代码
		// SDK_FILE_DOWN_PATH
		com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->frontUrl = com\unionpay\acp\sdk\SDK_FRONT_NOTIFY_URL;
		com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->backUrl = com\unionpay\acp\sdk\SDK_BACK_NOTIFY_URL;
		com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->logFilePath = com\unionpay\acp\sdk\SDK_LOG_FILE_PATH;
		com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->encryptCertPath = com\unionpay\acp\sdk\SDK_ENCRYPT_CERT_PATH;
		com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->validateCertDir = com\unionpay\acp\sdk\SDK_VERIFY_CERT_DIR;
		com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->signCertPwd = com\unionpay\acp\sdk\SDK_SIGN_CERT_PWD;
		com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->signCertPath = com\unionpay\acp\sdk\SDK_SIGN_CERT_PATH;

		//com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->secureKey = com\unionpay\acp\sdk\SDK_SINGLE_QUERY_URL;
		com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->middleCertPath = com\unionpay\acp\sdk\SDK_MIDDLE_CERT_PATH;
		com\unionpay\acp\sdk\df\SDKConfig::getSDKConfig()->rootCertPath = com\unionpay\acp\sdk\SDK_ROOT_CERT_PATH;
	}
}
?>