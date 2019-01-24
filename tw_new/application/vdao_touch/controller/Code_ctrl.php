<?php

class Code_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
	}

/************************************* 发送验证码 *************************************/

	public function send_code() {
		//接收手机号码
		$user_phone = $this->general->post('user_phone');
		//验证手机号码格式是否正确
        $check_user_phone = preg_match("/^1[34578]\d{9}$/", $user_phone);
        if (!$check_user_phone) {
        	echo json_encode(array('code'=>100,'msg'=>'手机号码格式不正确'));
        	die;
        }
        //加载发送短信的类
        $this->load->library('short_message');
        //获取剩余短信条数
        $i_surplus = $this->short_message->balance();
        //如果剩余短信条数为0则返回错误信息并终止程序
        if ($i_surplus == 0) {
            echo json_encode(array('code'=>500, 'msg'=>'该手机号码当日可发送短信数量已用尽，请明天再试'));
            die;
        }
        // 检验通过之后发送验证码
        $code = rand(1000, 9999);
        $content = '您的验证码为 ' . $code . '，请及时完成验证。如非本人操作请忽略！';
        $b_result = $this->short_message->send($user_phone, $content, 'authcode');
        if ($b_result) {
        	//将短信验证码保存在session里
            $_SESSION['code'] = $code;
        	$_SESSION['user_phone'] = $user_phone;
        	echo json_encode(array('code'=>200,'msg'=>'验证码发送成功'));
        } else {
        	echo json_encode(array('code'=>400,'msg'=>'验证码发送失败'));
        }
	}

/************************************* 发送验证码 *************************************/

}

?>