<?php
defined('BASEPATH') OR exit('禁止访问！');

/**
 1. 由于公司唯一一个认证过的微信公众号绑定在www.7dugo.com域名下，所以其他项目要使用公众号的部分接口功能，只能放到当前项目下运行
 2. 项目管理系统，需要通过公众号，向同事发送事件通知，所以需要用到上述所说的接口功能
 3. 为了减少维护的文件数量，将不启用模型文件，所有逻辑处理都写在此控制器类
 */

class Project_ctrl extends TW_Controller {
	
	public function __construct() {
		parent :: __construct();
	}

	// 把微信回调的code转发给其他域名
	public function weixin_code() {
		$a_get = $this->general->get();
		if (isset($a_get['code']) && $_SESSION['weixin_callback_state'] == $a_get['state']) {
			$s_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxd40a4f9141fe81d0&secret=2ccfa5ce1255ee17d70a1c5324d6ea02&code={$a_get['code']}&grant_type=authorization_code";
			$s_result = $this->general->request($s_url);
			$a_result = json_decode($s_result, true);
			if (empty($a_result['openid'])) {
				exit('获取openid失败！');
			}
			$s_openid = $this->general->base64_convert($a_result['openid']);
			header("Location: https://project.7dugo.com/register.html?openid={$s_openid}");
		} else {
			//$_SESSION['weixin_callback_url'] = $_SERVER['HTTP_REFERER'];
			$_SESSION['weixin_callback_state'] = $s_state = $this->general->rand_string();
			$s_url = urlencode($this->router->url('weixin_code'));
			$s_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxd40a4f9141fe81d0&redirect_uri={$s_url}&response_type=code&scope=snsapi_base&state={$s_state}#wechat_redirect";
			//echo '<a href="' . $s_url . '" >请点击这里</a>';
			header("Location: {$s_url}");
		}
	}


	public function recharge_wxpaynot() {
		// 注意，异步通知，这里引用了另外一个类
		$this->load->library('wxpay_pub_notify');
		// true表示需要输出签名，默认是参数是true，适用于下面的方法一
		$this->wxpay_pub_notify->Handle(true);
		// 验证数据安全方法一：(签名验证)
		$b_result = $this->wxpay_pub_notify->get_verify_result();
		if ($b_result) {
			$a_result = $this->wxpay_pub_notify->get_result_data();
			file_put_contents('./2.txt', print_r($this->wxpay_pub_notify->get_result_data(), true));
		}
	}

}
