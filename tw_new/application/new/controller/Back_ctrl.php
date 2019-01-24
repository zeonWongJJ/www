<?php
defined('BASEPATH') OR exit('禁止访问！');
class Back_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('back_model');
	}

/**********************************************************************************/

	//找回密码
	public function find_password() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收参数
			$mobile = trim($this->general->post('mobile'));
			$code = trim($this->general->post('code'));
			$password = trim($this->general->post('password'));
			//验证数据
			//判断手机号码格式是否正确
            $check_mobile = preg_match("/^1[34578]\d{9}$/", $mobile);
            if (!$check_mobile) {
                //echo json_encode(array('code'=>51, 'msg'=>'手机号码格式不正确'));
                $this->error->show_error('手机号码格式不正确', 'find_password', false, 2);
                die;
            }
            //判断密码是否为空
            if (strlen($password)<2 || strlen($password)>20) {
                //echo json_encode(array('code'=>52, 'msg'=>'密码长度不合法'));
                $this->error->show_error('密码长度不合法', 'find_password', false, 2);
                die;
            }
            //判断验证码是否为空
            if (strlen($code) < 1) {
                //echo json_encode(array('code'=>53, 'msg'=>'验证码不能为空'));
                $this->error->show_error('验证码不能为空', 'find_password', false, 2);
                die;
            }
            //判断是否有验证码
            $a_data = $this->back_model->get_row_code($mobile);
            if (empty($a_data)) {
                //echo json_encode(array('code'=>54, 'msg'=>'请先获取验证码'));
                $this->error->show_error('请先获取验证码', 'find_password', false, 2);
                die;
            }
            //判断验证码是否正确
            if ($code !== $a_data['code']) {
                //echo json_encode(array('code'=>55, 'msg'=>'验证码不正确，请重新输入'));
                $this->error->show_error('验证码不正确，请重新输入', 'find_password', false, 2);
                die;
            }
            //判断验证码是否过期
            if ($a_data['expire_time'] < $_SERVER['REQUEST_TIME']) {
                //echo json_encode(array('code'=>56, 'msg'=>'验证码已过期，请重新获取'));
                $this->error->show_error('验证码已过期，请重新获取', 'find_password', false, 2);
                die;
            }
            //检验账户是否存在
            $a_data_member = $this->back_model->is_account_exist($mobile);
            if (empty($a_data_member)) {
                //echo json_encode(array('code'=>57, 'msg'=>'该账号不存在'));
                $this->error->show_error('该账号不存在', 'find_password', false, 2);
                die;
            }
            if ($a_data_member['password'] === md5($password)) {
                //echo json_encode(array('code'=>58, 'msg'=>'新密码不能与旧密码一致'));
                $this->error->show_error('新密码不能与旧密码一致', 'find_password', false, 2);
                die;
            }
            //检验通过后重新设置密码
            $a_data_update = [
            	'password' => md5($password)
            ];
            $i_result = $this->back_model->update_member_pwd($a_data_update, $mobile);
            if ($i_result) {
                //echo json_encode(array('code'=>200, 'msg'=>'重置密码成功'));
                $this->error->show_error('重置密码成功', 'login', false, 2);
                die;
            } else {
                //echo json_encode(array('code'=>400, 'msg'=>'重置密码失败'));
                $this->error->show_error('重置密码失败', 'find_password', false, 2);
                die;
            }
		} else {
			$this->view->display('login&&register&repwd');
		}
	}

/**********************************************************************************/

}
