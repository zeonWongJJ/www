<?php
defined('BASEPATH') OR exit('禁止访问！');
class Register_ctrl extends TW_Controller {

    public function __construct() {
        parent :: __construct();
        $this->load->model('register_model');
        $this->load->model('check_model');
    }

/**********************************************************************************/

    //注册
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //接收用户提交的数据
            $mobile = trim($this->general->post('mobile'));
            $username = trim($this->general->post('username'));
            $password1 = trim($this->general->post('password1'));
            $password2 = trim($this->general->post('password2'));
            $code = trim($this->general->post('code'));
            $equipment = trim($this->general->post('equipment'));
            //验证数据合法性
            //判断手机号码是否合法
            $check_mobile = preg_match("/^1[34578]\d{9}$/", $mobile);
            if (!$check_mobile) {
                //echo json_encode(array('code'=>21,'msg'=>'手机号码格式不正确'));
                $this->error->show_error('手机号码格式不正确', 'register', false, 2);
                die;
            }
            //判断验证码是否有验证码
            $a_data = $this->register_model->get_row_code($mobile);
            if (empty($a_data)) {
                //echo json_encode(array('code'=>22,'msg'=>'请先获取验证码'));
                $this->error->show_error('请先获取验证码', 'register', false, 2);
                die;
            }
            //判断验证码是否正确
            if ($code !== $a_data['code']) {
                //echo json_encode(array('code'=>23,'msg'=>'验证码不正确，请重新输入'));
                $this->error->show_error('验证码不正确，请重新输入', 'register', false, 2);
                die;
            }
            //判断验证码是否过期
            if ($a_data['expire_time'] < $_SERVER['REQUEST_TIME']) {
                //echo json_encode(array('code'=>24,'msg'=>'验证码已过期，请重新获取'));
                $this->error->show_error('验证码已过期，请重新获取', 'register', false, 2);
                die;
            }
            //判断手机号码是否已被注册
            $i_result = $this->register_model->is_mobile_occupy($mobile);
            if ($i_result != 0) {
                //echo json_encode(array('code'=>25,'msg'=>'手机号码已被占用'));
                $this->error->show_error('手机号码已被占用', 'register', false, 2);
                die;
            }
            //判断用户名是否占用
            $i_result = $this->register_model->is_username_occupy($username);
            if ($i_result != 0) {
                //echo json_encode(array('code'=>26,'msg'=>'用户名已被占用'));
                $this->error->show_error('用户名已被占用', 'register', false, 2);
                die;
            }
            //判断两次密码是否一致
            if ($password1 !== $password2) {
                //echo json_encode(array('code'=>27,'msg'=>'两次密码不一致'));
                $this->error->show_error('两次密码不一致', 'register', false, 2);
                die;
            }
            //如果通过所有验证内里将数据写入数据库
            $a_data = [
                'username'              => $username,
                'password'              => md5($password),
                'mobile'                => $mobile,
                'mobile_validate'       => 1, //手机验证状态
                'equipment'             => $equipment, //用户设备
                'time_create'           => $_SERVER['REQUEST_TIME'], //注册时间
                'ip_create'             => $this->general->get_ip(), //注册时的ip地址
                'auth_level'            => 0, //未认证状态
                'integral'              => 0, //积分
                'integral_history'      => 0, //历史积分
                'cash_coupon'           => 0, //代金券数
                'balance'               => 0, //余额
                'ketubbah'              => 0, //保障金
                'experience'            => 0, //经验值[荣耀]
                'exploit'               => 0, //功勋值[声望]
                'order'                 => 0 //成效的订单数
            ];
            $i_result =  $this->register_model->insert_member($a_data);
            if ($i_result) {
                //注册成功
                //echo json_encode(array('code'=>28,'msg'=>'注册成功'));
                $this->error->show_success('注册成功', 'login', false, 2);
                die;
            } else {
                //注册失败
                //echo json_encode(array('code'=>29,'msg'=>'注册失败'));
                $this->error->show_error('注册失败', 'register', false, 2);
                die;
            }
        } else {
            //判断是否已经登录过
            if (isset($_SESSION['user_id'])) {
                $this->error->show_error('您已经登录过了', 'user_index', false, 2);
            }
            $this->view->display('login&&register&repwd');
        }
    }

/**********************************************************************************/

}