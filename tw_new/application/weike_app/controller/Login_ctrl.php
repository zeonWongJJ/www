<?php
defined('BASEPATH') OR exit('禁止访问！');
class Login_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('login_model');
	}

	//登录
	public function login() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			//接收用户提交的数据
			$tel_or_username = trim($this->general->post('tel_or_username'));
			$password = trim($this->general->post('password'));
			$location = trim($this->general->post('location')); //定位信息
			$equipment = trim($this->general->post('equipment')); //设备码

/******************************************************************************************/

			//验证数据合法性
			if (strlen($tel_or_username) < 2 || strlen($tel_or_username) > 30) {
                //echo json_encode(array('code'=>31, 'msg'=>'登录名长度不合法'));
                $this->error->show_error('登录名长度不合法', 'login', false, 2);
                die;
			}
			if (strlen($password) < 4 || strlen($password) > 20) {
                //echo json_encode(array('code'=>31, 'msg'=>'密码长度不合法'));
                $this->error->show_error('密码长度不合法', 'login', false, 2);
                die;
			}
			if (is_numeric($tel_or_username)) {
				$check_mobile = preg_match("/^1[34578]\d{9}$/", $tel_or_username);
	            if (!$check_mobile) {
	                //echo json_encode(array('code'=>32, 'msg'=>'手机号码格式不正确'));
	                $this->error->show_error('手机号码格式不正确', 'login', false, 2);
	                die;
	            }
	            //判断账号是否存在 [当登录方式是手机号码时]
	            $a_data = $this->login_model->is_tel_exist($tel_or_username);
			} else {
				//判断账号是否存在 [登录方式是用户名]
	            $a_data = $this->login_model->is_username_exist($tel_or_username);
			}
			//判断账号是否存在
            if (empty($a_data)) {
                //echo json_encode(array('code'=>33, 'msg'=>'账号不存在'));
                $this->error->show_error('账号不存在', 'login', false, 2);
                die;
            }
			//校验登录密码是否正确
			if (md5($password) != $a_data['password']) {
	            //echo json_encode(array('code'=>34, 'msg'=>'密码不正确'));
	            $this->error->show_error('密码不正确', 'login', false, 2);
	            die;
			}

/******************************************************************************************/
			//检验通过后持久化相关信息
			$_SESSION['user_id'] = $a_data['id'];
			$_SESSION['user_name'] =$a_data['username'];

/**********************************************************************************************/

			//更新登录历史记录表 new_location
			$a_data_location = [
				'ip' 		 => $this->general->get_ip(),
				'source' 	 => '登录',
				'member_id'  => $a_data['id'],
				'location'   => $location, //定位信息
				'equipment'  => $equipment, //设备码
				'time'		 => $_SERVER['REQUEST_TIME'] //操作时间
			];
			//更新登录历史记录表 new_location
			$i_location_result = $this->login_model->insert_location($a_data_location);

/************************************************************************************************/

			//登录成功 增加相应的荣耀、积分 判断上次登录的时间，如果当日已登录过刚不加 当日第一次登录则加
			//获取今天凌晨0点的时间戳
	        $today_start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	        //获取用户原来的积分
	        $original_value_score = $this->login_model->get_original_score($a_data['id']);
	        //获取用户原来的荣耀
	        $original_value_honour = $this->login_model->get_original_honour($a_data['id']);
			if ($a_data['time_login'] < $today_start) {
				//增加积分
				$a_variation_data = [
					'member_id'	  		=> $a_data['id'],
					'change_hints'		=> '登录成功',
					'variation'			=> '+1',
					'type'				=> 5,
					'original_value'	=> $original_value_score,
					'variation_type'	=> '1',
					'variation_time'	=> $_SERVER['REQUEST_TIME']
				];
				$i_score_result = $this->login_model->insert_variation($a_variation_data);
				//增加荣耀
				$a_variation_data = [
					'member_id'	  		=> $a_data['id'],
					'change_hints'		=> '登录成功',
					'variation'			=> '+5',
					'type'				=> 1,
					'original_value'	=> $original_value_honour,
					'variation_type'	=> '1',
					'variation_time'	=> $_SERVER['REQUEST_TIME']
				];
				$i_honour_result = $this->login_model->insert_variation($a_variation_data);
			}

/**********************************************************************************/

			//更新用户的称号
			//从称号表取出服务者称号的全部信息
			$a_data_appellation = $this->login_model->get_appellation(1);
			//根据用户声望值获取对应的服务者称号
			foreach ($a_data_appellation as $key => $value) {
				if ($a_data['exploit'] >= $value['min_score'] && $a_data['exploit'] <= $value['max_score']) {
					$service_appellation = $value['app_name'];
				}
			}
			//根据用户的荣耀值获取对应的需求者名称
			$a_data_appellation = $this->login_model->get_appellation(2);
			foreach ($a_data_appellation as $key => $value) {
				if ($a_data['experience'] >= $value['min_score'] && $a_data['experience'] <= $value['max_score']) {
					$demander_appellation = $value['app_name'];
				}
			}

/******************************************************************************************/

			//更新用户表信息 new_member
			$a_data_member = [
				'time_login' 			=> $_SERVER['REQUEST_TIME'], //当前的登录时间
				'time_login_last'   	=> $a_data['time_login'], //上次登录的时间
				'ip_login'          	=> $this->general->get_ip(), //当前的登录ip
				'ip_login_last'			=> $a_data['ip_login'], //上次登录ip
				'location'				=> $location, //当前定位
				'location_last'			=> $a_data['location'], //上次的登录定位
				'integral'				=> $original_value_score+1, //积分
				'experience'			=> $original_value_honour+5, //经验[荣耀]
				'service_appellation' 	=> $service_appellation, //服务者称号
				'demander_appellation'	=> $demander_appellation //需求者称号
			];
			$i_member_result = $this->login_model->update_member($a_data_member);

/********************************************************************************************/

			$this->error->show_success('登录成功', 'user_index', false, 2);

		} else {
			//判断是否已经登录过
			if (isset($_SESSION['user_id'])) {
				$this->error->show_error('您已经登录过了', 'user_index', false, 2);
			}
			$this->view->display('login&&register&repwd');
		}
	}

/**********************************************************************************/

	//退出登录
	public function loginout() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$b_result = session_destroy();
			if ($b_result) {
				//echo json_encode(array('code'=>200, 'msg'=>'退出成功'));
				$this->error->show_success('退出登录成功', 'login', false, 2);
				die;
			} else {
				//echo json_encode(array('code'=>400, 'msg'=>'退出失败'));
				$this->error->show_error('退出登录失败', 'login', false, 2);
				die;
			}
		}
	}

/**********************************************************************************/


}
