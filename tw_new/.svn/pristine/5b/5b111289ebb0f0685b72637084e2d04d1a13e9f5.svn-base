<?php
class Weixin_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
		
		$this->load->model('weixin_model');
		$this->load->model('project_model');
	}
	
	// 请求CODE
	public function get_code() {
		$a_get = $this->general->get();
		$this->weixin_model->get_code($a_get);
	}
	
	// 绑定微信 https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140842
	public function binding() {
		
		//header("Location: http://www.7dugo.com/weixin_code.html?state=" . $_SESSION['weixin_get_code_state']);
		$a_get = $this->general->get();
		if (isset($a_get['weixin_result'])) {// {"access_token":"6_agF72kSoBaOBfqQUvpjLuCu7e8bbgfGQhSYyITKxc_UzYDdMJ4qREX31lRzIgkLXEQMNuEYvxu-Ylq2jdow1LA","expires_in":7200,"refresh_token":"6_wvjTi1kzPewLWk7XjPBV06S3QAuyM4s3KfZ0N56djZ95vP7BT64ZJBXFo6x943XUxtDgufU17ouOfBTNpWA40w","openid":"op4jTwf4gkdfftNIdF3u22gJ7ohU","scope":"snsapi_login","unionid":"ocSxFxLUiWlnKquOn7vdnSx7G8ik"}
			$a_result = json_decode($a_get['weixin_result'], true);
			$this->load->model('user_model');
			if ($this->user_model->binding_weixin($_SESSION['user']['id_user'], $a_result['openid'])) {
				$this->error->show_success('绑定微信成功!', '/');
			}
			$this->error->show_success('绑定微信失败!', '/');
		} else {
			echo '<a href="http://www.7dugo.com/weixin_code.html" >请点击这里</a>';
			//header("Location: http://www.7dugo.com/weixin_code.html");
			//$data['weixin_get_code_state'] = $_SESSION['weixin_get_code_state'] = $this->general->rand_string();
			//$this->view->display('weixin_binding', $data);
		}
	}
	
	// 发送微信模板消息
	public function template_msg_send() {
		$a_param = [
			'openid' => 'okjLDuMQrWo60D3tNrZai7rIB0tI',
			'template_id' => 'LTMIryi6Pw3txjqvboPdPtF0VxeJGy0aKKRySdoM468',
			'data' => [
				// 标题
				'first' => [
					'value' => '用户登录任务有问题提交',
					'color' => '#ff0000'
				],
				// 提交人
				'keyword1' => [
					'value' => '张三',
					'color' => '#ff0000'
				],
				// 提交项目
				'keyword2' => [
					'value' => '企擎',
					'color' => '#ff0000'
				],
				// 项目分支
				'keyword3' => [
					'value' => '用户模块',
					'color' => '#ff0000'
				],
				// 提交信息
				'keyword4' => [
					'value' => '新问题标题为：无法登录',
					'color' => '#ff0000'
				],
				'remark' => [
					'value' => '请及时查看',
					'color' => '#ff0000'
				],
			]
		];
		$this->load->library('wx_template');
		print_r($this->wx_template->send($a_param));
	}
}
?>