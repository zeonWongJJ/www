<?php
/**
 * Created by PhpStorm.
 * User: 7du-28
 * Date: 2018/4/25
 * Time: 13:40
 */

class ApiLogin_ctrl extends TW_Controller
{

    public function __construct() {
        parent :: __construct();
        $this->load->model('apiToken_model');
        $this->load->model('apiLogin_model');
    }
    public function admin_login(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            // 接收登录信息
            $admin_name = trim($this->general->post('admin_name'));
            $admin_password = trim($this->general->post('admin_password'));

            if (empty($admin_name)) {
                $result = array(
                    'code' => 200,
                    'msg' => "账号不能为空",
                    'data' => '',
                );
                echo json_encode($result);
                exit;
            }
            if (empty($admin_password)) {
                $result = array(
                    'code' => 200,
                    'msg' => "密码不能为空",
                    'data' => '',
                );
                echo json_encode($result);
                exit;
            }

            // 获取要登录用户的信息
            $a_data = $this->apiLogin_model->get_user_info($admin_name);
            //校验账户是否存在
            if (empty($a_data)) {
                $result = array(
                    'code' => 200,
                    'msg' => "该账号不存在",
                    'data' => '',
                );
                echo json_encode($result);
                exit;
            }
            // 验证密码是否正确
            $admin_password = md5(md5($admin_password));
            if ($admin_password !== $a_data['admin_password']) {
                $result = array(
                    'code' => 200,
                    'msg' => "登录密码错误",
                    'data' => '',
                );
                echo json_encode($result);
                exit;
            }
            // 获取一条角色信息
            $a_role = $this->apiLogin_model->get_role_one($a_data['role_id']);
            // 验证是否被限制登录
            if ($a_data['admin_state'] == 0 || $a_role['role_state'] == 0) {
                $result = array(
                    'code' => 200,
                    'msg' => "该账号已被禁用",
                    'data' => '',
                );
                echo json_encode($result);
                exit;
            }

            // 更新相关数据表
            $a_update_data = [
                'login_time' => $_SERVER['REQUEST_TIME'],
                'login_ip'   => $this->general->get_ip(),
            ];
            $a_update_where = [
                'admin_id' => $a_data['admin_id'],
            ];
            $create_time=time();
            $expires_time=$create_time+1*24*60*60;
            $token=md5(md5($a_data['admin_id'].$create_time.$expires_time));
            //设置token
            $i_token =$this->apiToken_model->setToken($create_time,$expires_time,$token);

            $i_result = $this->apiLogin_model->update_admin_login($a_update_where, $a_update_data);
            if ($i_result) {
                $a_data['token']=$token;
                $result = array(
                    'code' => 200,
                    'msg' => "登录成功",
                    'data' =>$a_data,
                );
                echo json_encode($result);
                exit;
            } else {
                $this->error->show_error('登录失败', 'index', false, 2);
                $result = array(
                    'code' => 200,
                    'msg' => "登录失败",
                    'data' =>'',
                );
                echo json_encode($result);
                exit;
            }

        }
    }
}