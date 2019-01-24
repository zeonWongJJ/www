<?php

defined('BASEPATH') or exit('禁止访问！');

class Login_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('login_model');
	}

/*********************************** 发送验证码 ***********************************/

	public function send_code() {
		//接收手机号码
		$user_phone = $this->general->post('user_phone');
		//验证手机号码格式是否正确
        $check_user_phone = preg_match("/^1[23456789]\d{9}$/", $user_phone);
        if (!$check_user_phone) {
        	echo json_encode(array('code'=>400,'msg'=>'手机号码格式不正确'));
        	die;
        }
        //加载发送短信的类
        $this->load->library('short_message');
        //获取剩余短信条数
        $i_surplus = $this->short_message->balance();
        //如果剩余短信条数为0则返回错误信息并终止程序
        if ($i_surplus == 0) {
            echo json_encode(array('code'=>400, 'msg'=>'短信已用完，请明日再试！'));
            die;
        }
        // 检验通过之后发送验证码
        $code = rand(10000, 99999);
        $content = '您的验证码为 ' . $code . '，请及时完成验证。如非本人操作请忽略！';
        $b_result = $this->short_message->send($user_phone, $content, 'authcode');
        if ($b_result) {
        	echo json_encode(array('code'=>200, 'msg'=>'验证码发送成功', 'data'=>$code));
        } else {
        	echo json_encode(array('code'=>400, 'msg'=>'验证码发送失败', 'data'=>''));
        }
	}

/************************************ 用户登录 ************************************/

	public function user_login() {
		// 接收参数
		$user_phone    = $this->general->post('user_phone');
		$user_password = $this->general->post('user_password');
		// 验证数据
		if (empty($user_phone) || empty($user_password)) {
			echo json_encode(array('code'=>400, '必填项不能为空'));
			die;
		}
		// 验证手机号码格式是否正确
        $check_user_phone = preg_match("/^1[23456789]\d{9}$/", $user_phone);
        if (!$check_user_phone) {
        	echo json_encode(array('code'=>400,'msg'=>'手机号码格式不正确'));
        	die;
        }
		// 验证账号是否存在
		$a_data = $this->login_model->get_user_byphone($user_phone);
		if (!$a_data) {
        	echo json_encode(array('code'=>400,'msg'=>'账号不存在'));
        	die;
		}
		// 验证密码是否正确
		if (md5(md5($user_phone)) != $a_data['user_password']) {
        	echo json_encode(array('code'=>400,'msg'=>'密码不正确'));
        	die;
		}
		// 验证用户状态
		if ($a_data['user_state'] == 2) {
        	echo json_encode(array('code'=>400,'msg'=>'此账号已被临时停用'));
        	die;
		}
		// 验证通过后将更新用户数据并返回信息
		$a_where_u = [
			'user_id' => $a_data['user_id']
		];
		$a_data_u = [
			'user_logtime' => time(),
			'user_logip'   => $this->general->get_ip()
		];
		$this->login_model->update_user($a_where_u, $a_data_u);
		// 返回数据
		echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$a_data));
	}

/************************************ 用户注册 ************************************/

	public function user_register() {

	}

/**********************************************************************************/

}