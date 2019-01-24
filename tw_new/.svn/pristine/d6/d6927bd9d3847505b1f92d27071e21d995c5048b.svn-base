<?php
/**
  银联代付接口（由对接方提供，与官网不同）
 */
 
 // mcrypt扩展的函数在php7移除，关闭此相关的警告显示
 error_reporting(E_ALL || ~E_NOTICE);

require_once BASEPATH . '/libraries/pay/unionpay/transfer/netpayclient.php';

class TW_unionpay_transfer {
	// 商户号
	private $s_merid = '';
	
	// 私钥文件
	private $_key_private = '';
	// 公钥文件
	private $_key_public = '';
	// 常用类对象
	private $o_general;
	
	// 构造函数，对参数进行处理
	public function __construct() {
//		global $o_general;
//		var_dump($o_general);exit;
		$this->_key_private = BASEPATH . '/libraries/pay/unionpay/transfer/MerPrK.key';
		$this->_key_public = BASEPATH . '/libraries/pay/unionpay/transfer/PgPubk.key';
//		$this->o_general = $o_general;
		$this->o_general = get_instance()->general ?? null;

		// sdk低版本需要先创建类对象后使用，如：$this->o_net_pay->buildKey
		//$this->o_net_pay = new netpayclient();
		
		$this->s_merid = buildKey($this->_key_private);
	}
	
	// 生成签名值
	public function sign($a_param) {
		// 按次序组合报文信息为待签名串
		$s_plain = $a_param['merId'] . $a_param['merDate']  . $a_param['merSeqId'] . 
			$a_param['cardNo'] . $a_param['usrName']  . $a_param['openBank']  . $a_param['prov']  . 
			$a_param['city']  . $a_param['transAmt']  . $a_param['purpose']  . $a_param['subBank']  . 
			$a_param['flag']  . $a_param['version'] . $a_param['termType'];
		// 进行Base64编码
		$s_plain = base64_encode($s_plain);
		// 生成签名值，必填
		$s_sign = sign($s_plain);
		return $s_sign;
	}
	
	// 查询可用余额
	public function query_balance() {
		//签名标志，值固定，但不参与签名
		$a_param['signFlag'] = '1';
		//接口版本号，境内支付为 20090501，必填
		$a_param['version'] = '20090501';
		// 商户号
		$a_param['merId'] = $this->s_merid;
		//按次序组合报文信息为待签名串
		$s_plain = $plain = $a_param['merId'] . $a_param['version'];
		// 进行Base64编码
		$s_plain = base64_encode($s_plain);
		//生成签名值，必填
		$a_param['chkValue'] = sign($s_plain);
		$a_result = $this->request('http://sfj.chinapay.com/dac/BalanceQueryUTF8', $a_param);
		list($a_result) = each($a_result);
		
		//开始解析数据
		$a_data = explode('|', $a_result);
		$i_dex = strripos($a_result, '|');
		$s_plain = substr($a_result, 0, $i_dex + 1);
		$s_plain = base64_encode($s_plain);
		$s_chk_value = substr($a_result, $i_dex + 1);

		//开始验证签名，首先导入公钥文件
		$s_flag = buildKey($this->_key_public);
		if ( ! $s_flag ) {
			exit('导入公钥文件失败！');
		} else {
			$b_verify  =  verify($s_plain, $s_chk_value);
			if( ! $b_verify ) {
				exit('验证签名失败！');
			}
		}
		
		return $a_data;
	}
	
	// 查询订单
	public function query($a_param) {
		$a_param = $this->o_general->batch_to_hump($a_param);
		//签名标志，值固定，但不参与签名
		$a_param['signFlag'] = '1';
		//接口版本号，境内支付为 20090501，必填
		$a_param['version'] = '20090501';
		// 商户号
		$a_param['merId'] = $this->s_merid;
		//按次序组合报文信息为待签名串
		$s_plain = $a_param['merId'] . $a_param['merDate']  . $a_param['merSeqId'] . $a_param['version'];
		// 进行Base64编码
		$s_plain = base64_encode($s_plain);
		//生成签名值，必填
		$a_param['chkValue'] = sign($s_plain);
		$a_result = $this->request('http://sfj.chinapay.com/dac/SinPayQueryServletUTF8', $a_param);
		list($a_result) = each($a_result);
		
		//开始解析数据
		$a_data = explode('|', $a_result);
		$i_dex = strripos($a_result, '|');
		$s_plain = substr($a_result, 0, $i_dex + 1);
		$s_plain = base64_encode($s_plain);
		$s_chk_value = substr($a_result, $i_dex + 1);

		//开始验证签名，首先导入公钥文件
		$s_flag = buildKey($this->_key_public);
		if ( ! $s_flag ) {
			exit('导入公钥文件失败！');
		} else {
			$b_verify  =  verify($s_plain, $s_chk_value);
			if( ! $b_verify ) {
				exit('验证签名失败！');
			}
		}
		
		return $a_data;
	}
	
	// 支付函数
	public function pay($a_param) {
		$a_param = $this->o_general->batch_to_hump($a_param);
		$a_param['merId'] = $this->s_merid;
		$a_param['version'] = '20150304';
		$a_param['signFlag'] = '1';
		$a_param['chkValue'] = $this->sign($a_param);
		$a_result = $this->request('http://sfj.chinapay.com/dac/SinPayServletUTF8', $a_param);

		if ($a_result['responseCode'] == '0000') {
			//开始验证签名，首先导入公钥文件
			$s_plain = "responseCode={$a_result['responseCode']}&merId={$a_result['merId']}&merDate={$a_result['merDate']}&merSeqId={$a_result['merSeqId']}&cpDate={$a_result['cpDate']}&cpSeqId={$a_result['cpSeqId']}&transAmt={$a_result['transAmt']}&stat={$a_result['stat']}&cardNo={$a_result['cardNo']}";
			$s_plain = base64_encode($s_plain);
			$s_flag = buildKey($this->_key_public);
			if ( ! $s_flag ) {
				exit('导入公钥文件失败！');
			} else {
				$b_verify  =  verify($s_plain, $a_result['chkValue']);
				if( ! $b_verify ) {
					exit('验证签名失败！');
				}
			}
		}
		return $a_result;
	}
	
	// 发起请求
	public function request($s_url, $m_data) {
		$a_header = NULL;
		if (is_array($m_data)) {
			$m_data = http_build_query($m_data);
		}
		$o_curl = curl_init();
		//超时时间
		curl_setopt($o_curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($o_curl, CURLOPT_RETURNTRANSFER, 1);
		//这里设置代理，如果有的话
		//curl_setopt($o_curl, CURLOPT_PROXY, '10.206.30.98');
		//curl_setopt($o_curl, CURLOPT_PROXYPORT, 8080);
		curl_setopt($o_curl, CURLOPT_URL, $s_url);
		//curl_setopt($o_curl, CURLOPT_SSL_VERIFYPEER, false);
		//curl_setopt($o_curl, CURLOPT_SSL_VERIFYHOST, false);
		// 设置host
		if( is_array($a_header) && ! empty($a_header) ) {
			curl_setopt($o_curl, CURLOPT_HTTPHEADER, $a_header);
		}
	 
		curl_setopt($o_curl, CURLOPT_POST, 1);
		curl_setopt($o_curl, CURLOPT_POSTFIELDS, $m_data);
		// 如果要输出Header信息
		//curl_setopt($o_curl, CURLOPT_HEADER, true);
		$a_result = [];
		$s_result = curl_exec($o_curl);
		// 把get方式的Url传值参数转换为数组
		parse_str($s_result, $a_result);
		if(empty($s_result)) {
			$a_result['error'] = curl_errno($o_curl);
		}
		curl_close($o_curl);
		return $a_result;
	}
}
?>