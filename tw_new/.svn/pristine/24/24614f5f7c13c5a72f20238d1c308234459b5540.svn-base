<?php
date_default_timezone_set('PRC');
defined('BASEPATH') OR exit('禁止访问！');
/**
 * 短信管理
 */

//set_time_limit(0);

class TW_Short_message {
	private $_s_username = '7dugo'; //用户账号
	private $_s_password = 'nunLoYI4';	//密码
	private $_tkey = ''; // 当前时间参数
	private $_a_productid = [
		'authcode' => 676767, // 优质快速验证码（速度最快）
		'notice' => 676766, // 通知短信（速度其次）
		'marketing' => 435227, // 营销短信（速度最慢）
	];
	// 框架错误处理类对象
	private $o_error;
	// 短信发送错误信息
	private $_error_info;

    public function __construct() {
		global $o_error;

		$this->o_error =& $o_error;
		$this->_tkey = date('YmdHis', $_SERVER['REQUEST_TIME']);
		$this->_s_password = md5(md5($this->_s_password) . $this->_tkey);
    }

	// 查询余额
    public function balance() {
		$i_balance = $this->ztsms_api("http://www.ztsms.cn/balanceN.do?username={$this->_s_username}&password={$this->_s_password}&tkey={$this->_tkey}");
		return $i_balance;
    }

	/*
	 * $s_type 短信类型；验证码：authcode（速度最快）； 通知：notice（速度其次）； 营销：marketing（速度最慢）；
	 *
	 */
	public function send($i_mobile, $s_content, $s_type) {
		if (strlen($i_mobile) != 11 || ! preg_match("/1[0-9]{10}/", $i_mobile)) {
			$this->o_error->show_warning('手机号码不正确！');
		}
		if (empty($s_content)) {
			$this->o_error->show_warning('短信内容不能为空！');
		}
		if ( ! in_array($s_type, ['notice', 'marketing', 'authcode']) ) {
			$this->o_error->show_warning('未知短信类型！');
		}
		$s_content = get_config_item('short_message_prefix') . ' ' . $s_content . ' 退订回T';

		/*--------------------------------
		 * 功能:	上海助通短信PHP HTTP接口 发送短信
		 * auther   henry
		 * 说明:	发送传递的参数
		 * http://www.ztsms.cn:8800/sendXSms.do?username=用户名&password=密码&mobile=手机号码&content=内容&dstime=&productid=产品ID&xh=留空
		*/
		$s_content = iconv("UTF-8", "UTF-8", $s_content);
		$u_xh = '';	//留空
		$s_content = urlencode($s_content);
		$s_url = "http://www.ztsms.cn/sendNSms.do?username={$this->_s_username}&password={$this->_s_password}&tkey={$this->_tkey}&mobile={$i_mobile}&content={$s_content}&productid={$this->_a_productid[$s_type]}&xh=";
		if (strlen($s_url) > 1000) {
			$this->o_error->show_warning('短信内容太长！');
		}
		$this->_error_info = $this->ztsms_api($s_url);
		if (substr($this->_error_info, 0, 2) == '1,') {
			return true;
		} else {
			return false;
		}
    }

	// 调用接口
	public function ztsms_api($s_url) {
		if(function_exists('file_get_contents')) {
			$s_file_contents = file_get_contents($s_url);
		} else {
			$o_ch = curl_init();
			curl_setopt ($o_ch, CURLOPT_URL, $s_url);
			curl_setopt ($o_ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($o_ch, CURLOPT_CONNECTTIMEOUT, 5);
			$s_file_contents = curl_exec($o_ch);
			curl_close($o_ch);
		}
		return $s_file_contents;
	}

	// 获取错误信息
	public function get_error() {
		$error_table = [
			'-1' => '用户名或者密码不正确',
			'1,' => '发送短信成功',
			'0,' => '发送短信失败',
			'2' => '余额不够',
			'3' => '扣费失败',
			'5,' => '短信定时成功',
			'6' => '有效号码为空',
			'7' => '短信内容为空',
			'8' => '无签名',
			'9' => '没有Url提交权限',
			'10' => '发送号码过多,最多支持200个号码',
			'11' => '产品ID异常',
			'12' => '参数异常',
			'13' => '30分种重复提交',
			'15' => 'Ip验证失败',
			'19' => '短信内容过长',
			'20' => '定时时间不正确：格式：20130202120212(14位数字)'
		];
        return '错误码：' . $this->_error_info . '，' . $error_table[$this->_error_info] ?? '';
		// return '错误码：' . $this->_error_info . '，' . isset($error_table[$this->_error_info]) ?: '';
	}
}
