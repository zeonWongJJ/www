<?php
defined('BASEPATH') OR exit('禁止访问！');
class Code_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
        $this->load->model('code_model');
	}

/**********************************************************************************/

    //发送验证码
    public function send_code() {
        //接收需要发送验证码的手机号码
        $mobile = trim($this->general->post('mobile'));
        $device_number = trim($this->general->post('device_number'));//设备号
        $source = trim($this->general->post('source'));//来源
        //对手机号码进行验证
        $check_mobile = preg_match("/^1[34578]\d{9}$/", $mobile);
        if (!$check_mobile) {
            echo json_encode(array('code'=>61, 'msg'=>'手机号码格式不正确'));
            die;
        }
        //加载发送短信的类
        $this->load->library('short_message');
        //获取剩余短信条数
        $i_surplus = $this->short_message->balance();
        //如果剩余短信条数为0则返回错误信息并终止程序
        if ($i_surplus == 0) {
            echo json_encode(array('code'=>62, 'msg'=>'该手机号码当日可发送短信数量已用尽，请明天再试'));
            die;
        }
        //检验通过之后发送验证码
        //$this->short_message->send(手机号码, 短信内容, authcode/notice/marketing，延时N秒后发送);
        //短信内容
        $code = rand(1000, 9999);
        $content = '您的验证码为 ' . $code . '，请及时完成验证。如非本人操作请忽略！';
        $b_result = $this->short_message->send($mobile, $content, 'authcode');
        //如果发送成功则将验证码写入数据库
        if ($b_result) {
            $a_data = [
                'comprehensive' => $mobile,
                'code'          => $code,
                'send_time'     => $_SERVER['REQUEST_TIME'],
                'expire_time'   => $_SERVER['REQUEST_TIME']+1800,
                'code_type'     => 1,
                'source'        => $source,
                'device_number' => $device_number
            ];
            $i_result = $this->code_model->insert_code($a_data);
            if ($i_result) {
                echo json_encode(array('code'=>200, 'msg'=>'发送验证码成功'));
                die;
            } else {
                echo json_encode(array('code'=>400, 'msg'=>'发送验证码失败'));
                die;
            }
        }
    }

/**********************************************************************************/


}
