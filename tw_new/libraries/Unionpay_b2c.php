<?php

defined('BASEPATH') OR exit('No direct script access allowed');
// 加载接口入口文件
// header ( 'Content-type:text/html;charset=utf-8' );
require_once(BASEPATH . '/libraries/pay/unionpay/b2c/acp_service.php');

class TW_Unionpay_b2c {

	// 公共参数数组
	/*
	private $_a_config = [
		// 支付宝分配给开发者的应用ID
		'app_id' => '',
		// 支付宝接口请求地址
		'api_url' => 'https://openapi.alipay.com/gateway.do',
		// 商户私钥
		'key_private' => '',
		// 支付宝公钥
		'key_public' => '',
		// 调用的接口版本，固定为：1.0
		'version' => '1.0',
		// 请求使用的编码格式，如utf-8,gbk,gb2312等
		'charset' => 'utf-8',
		// 仅支持JSON
		'format' => 'json',
		// 商户生成签名字符串所使用的签名算法类型，目前支持RSA2和RSA，推荐使用RSA2
		'sign_type' => 'rsa',
		// 同步通知地址
		'return_url' => '',
		// 异步通知地址
		'notify_url' => ''
	];*/

	// 银联接口对象
	// private $_o_aop;

	// 构造函数，对参数进行处理
	public function __construct($a_param = []) {
		$this->_config();
	}

	/**
	 * 重要：联调测试时请仔细阅读注释！
	 *
	 * 产品：跳转网关支付产品<br>
	 * 交易：消费撤销类交易：后台消费撤销交易，有同步应答和后台通知应答<br>
	 * 日期： 2015-09<br>
	 * 版权： 中国银联<br>
	 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
	 * 该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《网关支付产品接口规范》<br>
	 *              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范，全渠道平台银行名称-简码对照表）<br>
	 * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
	 * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
	 *                             测试过程中产生的6位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
	 *                          2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
	 * 交易说明:1）以后台通知或交易状态查询交易确定交易成功
	 *       2）消费撤销仅能对当清算日的消费做，必须为全额，一般当日或第二日到账。
		$params = array(

				//以下信息非特殊情况不需要改动
				'version' => '5.0.0',		      //版本号
				'encoding' => 'utf-8',		      //编码方式
				'signMethod' => '01',		      //签名方法
				'txnType' => '31',		          //交易类型
				'txnSubType' => '00',		      //交易子类
				'bizType' => '000201',		      //业务类型
				'accessType' => '0',		      //接入类型
				'channelType' => '07',		      //渠道类型
				'backUrl' => com\unionpay\acp\sdk\SDK_BACK_NOTIFY_URL, //后台通知地址

				//TODO 以下信息需要填写
				'orderId' => $_POST["orderId"],	    //商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
				'merId' => $_POST["merId"],			//商户代码，请改成自己的测试商户号，此处默认取demo演示页面传递的参数
				'origQryId' => $_POST["origQryId"], //原消费的queryId，可以从查询接口或者通知接口中获取，此处默认取demo演示页面传递的参数
				'txnTime' => $_POST["txnTime"],	    //订单发送时间，格式为YYYYMMDDhhmmss，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
				'txnAmt' => $_POST["txnAmt"],       //交易金额，消费撤销时需和原消费一致，此处默认取demo演示页面传递的参数
		// 		'reqReserved' =>'透传信息',            //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据
			);
	 */
	public function undo($a_param = []) {
		$params = array(

				//以下信息非特殊情况不需要改动
				'version' => '5.0.0',		      //版本号
				'encoding' => 'utf-8',		      //编码方式
				'signMethod' => '01',		      //签名方法
				'txnType' => '31',		          //交易类型
				'txnSubType' => '00',		      //交易子类
				'bizType' => '000201',		      //业务类型
				'accessType' => '0',		      //接入类型
				'channelType' => '07',		      //渠道类型
				'backUrl' => com\unionpay\acp\sdk\SDK_BACK_NOTIFY_URL, //后台通知地址

				//TODO 以下信息需要填写
				//'orderId' => $_POST["orderId"],	    //商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
				'merId' => com\unionpay\acp\sdk\SDK_MER_ID,			//商户代码，请改成自己的测试商户号，此处默认取demo演示页面传递的参数
				//'origQryId' => $_POST["origQryId"], //原消费的queryId，可以从查询接口或者通知接口中获取，此处默认取demo演示页面传递的参数
				//'txnTime' => $_POST["txnTime"],	    //订单发送时间，格式为YYYYMMDDhhmmss，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
				//'txnAmt' => $_POST["txnAmt"],       //交易金额，消费撤销时需和原消费一致，此处默认取demo演示页面传递的参数
		// 		'reqReserved' =>'透传信息',            //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据
			);

        // 五个必须的参数
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

		if (isset($a_param['origQryId'])) {
			$params['origQryId'] = $a_param['origQryId'];
		}
		else
		    return array();

		com\unionpay\acp\sdk\AcpService::sign ( $params ); // 签名
		$url = com\unionpay\acp\sdk\SDK_BACK_TRANS_URL;

		$result_arr = com\unionpay\acp\sdk\AcpService::post ( $params, $url);
		if(count($result_arr)<=0) { //没收到200应答或参数不完整的情况
			//echo "POST请求失败：" . $errMsg;
			return array();
		}

		return $result_arr;

        /*
		if (!com\unionpay\acp\sdk\AcpService::validate ($result_arr) ){
			echo "应答报文验签失败<br>\n";
			return;
		}

		echo "应答报文验签成功<br>\n";
		if ($result_arr["respCode"] == "00"){
		    //交易已受理，等待接收后台通知更新订单状态，如果通知长时间未收到也可发起交易状态查询
		    //TODO
		    echo "受理成功。<br>\n";
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

	/**
	 用于交易创建后，用户在一定时间内未进行支付，可调用该接口直接将未付款的交易进行关闭。
	 交易关闭接口文档：
	 https://doc.open.alipay.com/docs/api.htm?spm=a219a.7395905.0.0.ZxBuDg&docType=4&apiId=1058
	 商家订单号和支付宝交易号，两个参数必须传入一个，如果同时存在优先取支付宝交易号
	*/
	public function close($a_param = []) {
		//$this->set_param($a_param);

		//$o_request = new AlipayTradeCloseRequest();
		//$o_request->setBizContent($this->_s_param);
		//$s_result = $this->_o_aop->pageExecute($o_request);
		//return $s_result;
	}

	// https://docs.open.alipay.com/common/105463
	// 执行接口调用
	/**
	 * 重要：联调测试时请仔细阅读注释！
	 *
	 * 产品：跳转网关支付产品<br>
	 * 交易：消费：前台跳转，有前台通知应答和后台通知应答<br>
	 * 日期： 2015-09<br>
	 * 版本： 1.0.0
	 * 版权： 中国银联<br>
	 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
	 * 提示：该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《网关支付产品接口规范》，<br>
	 *              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范，全渠道平台银行名称-简码对照表)<br>
	 *              《全渠道平台接入接口规范 第3部分 文件接口》（对账文件格式说明）<br>
	 * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
	 * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
	 *                             测试过程中产生的6位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
	 *                          2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
	 * 交易说明:1）以后台通知或交易状态查询交易确定交易成功,前台通知不能作为判断成功的标准.
	 *       2）交易状态查询交易（Form_6_5_Query）建议调用机制：前台类交易建议间隔（5分、10分、30分、60分、120分）发起交易查询，如果查询到结果成功，则不用再查询。（失败，处理中，查询不到订单均可能为中间状态）。也可以建议商户使用payTimeout（支付超时时间），过了这个时间点查询，得到的结果为最终结果。
		$params = array(

				//以下信息非特殊情况不需要改动
				'version' => '5.0.0',                 //版本号
				'encoding' => 'utf-8',				  //编码方式
				'txnType' => '01',				      //交易类型
				'txnSubType' => '01',				  //交易子类
				'bizType' => '000201',				  //业务类型
				'frontUrl' =>  com\unionpay\acp\sdk\SDK_FRONT_NOTIFY_URL,  //前台通知地址
				'backUrl' => com\unionpay\acp\sdk\SDK_BACK_NOTIFY_URL,	  //后台通知地址
				'signMethod' => '01',	              //签名方法
				'channelType' => '08',	              //渠道类型，07-PC，08-手机
				'accessType' => '0',		          //接入类型
				'currencyCode' => '156',	          //交易币种，境内商户固定156

				//TODO 以下信息需要填写
				'merId' => $_POST["merId"],		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
				'orderId' => $_POST["orderId"],	//商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
				'txnTime' => $_POST["txnTime"],	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
				'txnAmt' => $_POST["txnAmt"],	//交易金额，单位分，此处默认取demo演示页面传递的参数
		// 		'reqReserved' =>'透传信息',        //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据

				//TODO 其他特殊用法请查看 special_use_purchase.php
			);
	 */
	public function pay($a_param = []) {
		$params = array(

				//以下信息非特殊情况不需要改动
				'version' => '5.0.0',                 //版本号
				'encoding' => 'utf-8',				  //编码方式
				'txnType' => '01',				      //交易类型
				'txnSubType' => '01',				  //交易子类
				'bizType' => '000201',				  //业务类型
				'frontUrl' =>  com\unionpay\acp\sdk\SDK_FRONT_NOTIFY_URL,  //前台通知地址
				'backUrl' => com\unionpay\acp\sdk\SDK_BACK_NOTIFY_URL,	  //后台通知地址
				'signMethod' => '01',	              //签名方法
				'channelType' => '08',	              //渠道类型，07-PC，08-手机
				'accessType' => '0',		          //接入类型
				'currencyCode' => '156',	          //交易币种，境内商户固定156

				//TODO 以下信息需要填写
				'merId' => com\unionpay\acp\sdk\SDK_MER_ID,		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
				//'orderId' => $_POST["orderId"],	//商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
				//'txnTime' => $_POST["txnTime"],	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
				//'txnAmt' => $_POST["txnAmt"],	//交易金额，单位分，此处默认取demo演示页面传递的参数
		// 		'reqReserved' =>'透传信息',        //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据

				//TODO 其他特殊用法请查看 special_use_purchase.php
			);

        // 四个必须的参数
		if (isset($a_param['orderId'])) {
			$params['orderId'] = $a_param['orderId'];
		}
		else
		    return '';

		if (isset($a_param['merId'])) {
			$params['merId'] = $a_param['merId'];
		}

		if (isset($a_param['txnTime'])) {
			$params['txnTime'] = $a_param['txnTime'];
		}
		else
		    return '';

		if (isset($a_param['txnAmt'])) {
			$params['txnAmt'] = $a_param['txnAmt'];
		}
		else
		    return '';

		com\unionpay\acp\sdk\AcpService::sign ( $params );
		$uri = com\unionpay\acp\sdk\SDK_FRONT_TRANS_URL;
		if (isset($a_param['urlFront']))
			$uri = $a_param['urlFront'];
		$html_form = com\unionpay\acp\sdk\AcpService::createAutoFormHtml( $params, $uri );
		return $html_form;
	}

	/**
	 * 交易查询接口文档：
	 *
	 * 重要：联调测试时请仔细阅读注释！
	 *
	 * 产品：跳转网关支付产品<br>
	 * 交易：交易状态查询交易：只有同步应答 <br>
	 * 日期： 2015-09<br>
	 * 版本： 1.0.0
	 * 版权： 中国银联<br>
	 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能及规范性等方面的保障<br>
	 * 该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《网关支付产品接口规范》，<br>
	 *              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范，全渠道平台银行名称-简码对照表）<br>
	 * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
	 * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
	 *                             测试过程中产生的6位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
	 *                           2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
	 * 交易说明： 1）对前台交易发起交易状态查询：前台类交易建议间隔（5分、10分、30分、60分、120分）发起交易查询，如果查询到结果成功，则不用再查询。（失败，处理中，查询不到订单均可能为中间状态）。也可以建议商户使用payTimeout（支付超时时间），过了这个时间点查询，得到的结果为最终结果。
	 *        2）对后台交易发起交易状态查询：后台类资金类交易同步返回00，成功银联有后台通知，商户也可以发起查询交易，可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03，04，05继续查询，否则终止查询）。
	 *        					         后台类资金类同步返03 04 05响应码及未得到银联响应（读超时）需发起查询交易，可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03，04，05继续查询，否则终止查询）。
	 *
		$params = array(
				//以下信息非特殊情况不需要改动
				'version' => '5.0.0',		  //版本号
				'encoding' => 'utf-8',		  //编码方式
				'signMethod' => '01',		  //签名方法
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
				'version' => '5.0.0',		  //版本号
				'encoding' => 'utf-8',		  //编码方式
				'signMethod' => '01',		  //签名方法
				'txnType' => '00',		      //交易类型
				'txnSubType' => '00',		  //交易子类
				'bizType' => '000000',		  //业务类型
				'accessType' => '0',		  //接入类型
				'channelType' => '07',		  //渠道类型

				//TODO 以下信息需要填写
				//'orderId' => $_POST["orderId"],	//请修改被查询的交易的订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数
				'merId' => com\unionpay\acp\sdk\SDK_MER_ID,	    //商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
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

		if (isset($a_param['txnTime'])) {
			$params['txnTime'] = $a_param['txnTime'];
		}
		else
		    return array();

		com\unionpay\acp\sdk\AcpService::sign ( $params ); // 签名
		$url = com\unionpay\acp\sdk\SDK_SINGLE_QUERY_URL;

		$result_arr = com\unionpay\acp\sdk\AcpService::post ( $params, $url);
		return $result_arr;

        /*
		if(count($result_arr)<=0) { //没收到200应答或参数不完整的情况
			return;
		}

		if (!com\unionpay\acp\sdk\AcpService::validate ($result_arr) ){
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
					|| $result_arr["origRespCode"] == "05"){
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

	/**
	 * 重要：联调测试时请仔细阅读注释！
	 *
	 * 产品：跳转网关支付产品<br>
	 * 交易：退货交易：后台资金类交易，有同步应答和后台通知应答<br>
	 * 日期： 2015-09<br>
	 * 版本： 1.0.0
	 * 版权： 中国银联<br>
	 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
	 * 该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《网关支付产品接口规范》<br>
	 *              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范，全渠道平台银行名称-简码对照表）<br>
	 * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
	 * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
	 *                             测试过程中产生的6位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
	 *                          2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
	 * 交易说明： 1）以后台通知或交易状态查询交易（Form_6_5_Query）确定交易成功，建议发起查询交易的机制：可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03，04，05继续查询，否则终止查询）
	 *        2）退货金额不超过总金额，可以进行多次退货
	 *        3）退货能对11个月内的消费做（包括当清算日），支持部分退货或全额退货，到账时间较长，一般1-10个清算日（多数发卡行5天内，但工行可能会10天），所有银行都支持
		$params = array(

				//以下信息非特殊情况不需要改动
				'version' => '5.0.0',		      //版本号
				'encoding' => 'utf-8',		      //编码方式
				'signMethod' => '01',		      //签名方法
				'txnType' => '04',		          //交易类型
				'txnSubType' => '00',		      //交易子类
				'bizType' => '000201',		      //业务类型
				'accessType' => '0',		      //接入类型
				'channelType' => '07',		      //渠道类型
				'backUrl' => com\unionpay\acp\sdk\SDK_BACK_NOTIFY_URL, //后台通知地址

				//TODO 以下信息需要填写
				'orderId' => $_POST["orderId"],	    //商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
				'merId' => $_POST["merId"],	        //商户代码，请改成自己的测试商户号，此处默认取demo演示页面传递的参数
				'origQryId' => $_POST["origQryId"], //原消费的queryId，可以从查询接口或者通知接口中获取，此处默认取demo演示页面传递的参数
				'txnTime' => $_POST["txnTime"],	    //订单发送时间，格式为YYYYMMDDhhmmss，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
				'txnAmt' => $_POST["txnAmt"],       //交易金额，退货总金额需要小于等于原消费
		// 		'reqReserved' =>'透传信息',            //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据
			);
	 */
	public function refund($a_param = []) {
		$params = array(

				//以下信息非特殊情况不需要改动
				'version' => '5.0.0',		      //版本号
				'encoding' => 'utf-8',		      //编码方式
				'signMethod' => '01',		      //签名方法
				'txnType' => '04',		          //交易类型
				'txnSubType' => '00',		      //交易子类
				'bizType' => '000201',		      //业务类型
				'accessType' => '0',		      //接入类型
				'channelType' => '07',		      //渠道类型
				'backUrl' => com\unionpay\acp\sdk\SDK_BACK_NOTIFY_URL, //后台通知地址

				//TODO 以下信息需要填写
				//'orderId' => $_POST["orderId"],	    //商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
				'merId' => com\unionpay\acp\sdk\SDK_MER_ID,	        //商户代码，请改成自己的测试商户号，此处默认取demo演示页面传递的参数
				//'origQryId' => $_POST["origQryId"], //原消费的queryId，可以从查询接口或者通知接口中获取，此处默认取demo演示页面传递的参数
				//'txnTime' => $_POST["txnTime"],	    //订单发送时间，格式为YYYYMMDDhhmmss，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
				//'txnAmt' => $_POST["txnAmt"],       //交易金额，退货总金额需要小于等于原消费
		// 		'reqReserved' =>'透传信息',            //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据
			);

		com\unionpay\acp\sdk\AcpService::sign ( $params ); // 签名
		$url = com\unionpay\acp\sdk\SDK_BACK_TRANS_URL;

        // 五个必须的参数
		if (isset($a_param['orderId'])) {
			$params['orderId'] = $a_param['orderId'];
		}
		else
		    return array();

		if (isset($a_param['merId'])) {
			$params['merId'] = $a_param['merId'];
		}

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

		if (isset($a_param['origQryId'])) {
			$params['origQryId'] = $a_param['origQryId'];
		}
		else
		    return array();

		$result_arr = com\unionpay\acp\sdk\AcpService::post ( $params, $url);

		if(count($result_arr)<=0) { //没收到200应答的情况
			return array();
		}

		return $result_arr;

        /*
		if (!com\unionpay\acp\sdk\AcpService::validate ($result_arr) ){
			echo "应答报文验签失败<br>\n";
			return;
		}

		echo "应答报文验签成功<br>\n";
		if ($result_arr["respCode"] == "00"){
		    //交易已受理，等待接收后台通知更新订单状态，如果通知长时间未收到也可发起交易状态查询
		    //TODO
		    echo "受理成功。<br>\n";
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

	// 解密数据，返回string值
	public function decryptData($encryptData) {
		return com\unionpay\acp\sdk\AcpService::decryptData ($encryptData);
	}

	// 签名验证，返回bool值
	public function validate($result_arr) {
		return com\unionpay\acp\sdk\AcpService::validate ($result_arr);
	}

	// 公共参数设置
	// 为兼容升级便利，采用原SDK配置文件格式
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
	}
}
?>