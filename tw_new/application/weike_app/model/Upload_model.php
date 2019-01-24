<?php
class Back_model extends TW_Model {
	//错误码
    private $errorNum;
    //错误信息
    private $errorMessage;
    //最终结果
    private $result;
    //用户名
    private $user_name;
    //用户手机
    private $mod_phone;
    //密码
    private $password1;
    //确认密码
    private $password2;


	public function __construct() {
		parent :: __construct();
	}

	/**
	 * [back_two 找回密码]
	 * @return [bool] [true|false]
	 */
	public function back_two(){
		$this->user_name = $this->general->post('user_name');
		$this->mod_phone = $this->general->post('mod_phone');

		// 验证码是否正确
		if ($this->general->post('captcha') != $_SESSION['captcha']){
			$this->set_option('errorNum','2');
			$this->errorMessage = $this->getError();
			return $this->errorMessage;
		}

		//判断用户名或者密码是否为空
		if (! empty($this->user_name) && ! empty($this->mod_phone)){
			return $this->existence_user();
		} else {
			$this->set_option('errorNum','3');
			$this->errorMessage = $this->getError();
			return $this->errorMessage;
		}
	}

	/**
	 * [back_three description]
	 * @return [type] [description]
	 */
	public function back_three(){
		$phone_code = $this->general->post('phone_code');
		$a_res = $this->db->get_row('code', ['comprehensive' => $_SESSION['mod_phone']], 'code', ['send_time' => desc]);

		if(empty($a_res)){
			$this->set_option('errorNum','8');
			$this->errorMessage = $this->getError();
			return $this->errorMessage;
		}

		if($phone_code != $a_res['code']){
			$this->set_option('errorNum','9');
			$this->errorMessage = $this->getError();
			return $this->errorMessage;
		}

		$a_data = $this->db->get_row('member',['mobile' => $_SESSION['mod_phone']], 'id');
		$_SESSION['user_id'] = $a_data['id'];
		return $this->result['status'] 	= true;

	}

	// 修改密码成功
	/**
	 * [back_four 修改密码成功]
	 * @return [bool] [true|false]
	 */
	public function back_four(){

		$this->password1 = $this->general->post('password1');
		$this->password2 = $this->general->post('password2');

		// 非法访问
		if(empty($_SESSION['user_id'])){
			$this->set_option('errorNum','4');
			$this->errorMessage = $this->getError();
			return $this->errorMessage;
		}

		//密码为空
		if($this->password1 == "" || $this->password2 == ""){
			$this->set_option('errorNum','5');
			$this->errorMessage = $this->getError();
			return $this->errorMessage;
		}

		// 两次密码不一致
		if($this->password1 != $this->password2){
			$this->set_option('errorNum','6');
			$this->errorMessage = $this->getError();
			return $this->errorMessage;
		}

		//修改密码成功清楚session值
		$res = $this->db->update('member', ['password' =>$this->password1 ], ['id' => $_SESSION['user_id']]);

		if($res){
			unset($_SESSION['user_id']);
			unset($_SESSION['mod_phone']);
			$this->result['status'] 	= true;
      		$this->result['tips'] 		= '修改密码成功';
      		return $this->result;
		} else {
			$this->set_option('errorNum','7');
			$this->errorMessage = $this->getError();
			return $this->errorMessage;
		}
	}

	//验证用户名和用户密码是否存在
	/**
	 * [existence_user 验证用户名和用户密码是否存在]
	 * @return [bool] [true|false]
	 */
	private function existence_user(){
		$a_res = $this->db 	->where_or(['name_user' 	=> $this->user_name,
										'mobile' 		=> $this->mod_phone])
							->get_row('member', '', 'password,status,id,wei_equipment_id');

		//用户名或者手机号不存在
    	if (empty($a_res)){
    		$this->set_option('errorNum','1');
			$this->errorMessage = $this->getError();
			return $this->errorMessage;
    	} else {
    		$_SESSION['mod_phone']  = $this->mod_phone;
    		$this->result['status'] = true;
	      	$this->result['tips'] 	= '用户名和手机号码正确';
	      	return $this->result;
    	}
	}

	//赋值
    private function set_option($key,$value){
        $this->$key = $value;
    }

    /**
     * [getError 错误类型统计]
     * @return [array] [错误内容和false]
     */
    private function getError() {
      switch ($this->errorNum) {
        case 1: $case = "用户名或者手机不正确"; break;
        case 2: $case = "验证码不正确"; break;
        case 3: $case = "用户名或者手机不能为空"; break;
        case 4: $case = "非法访问"; break;
        case 5: $case = "修改密码不能为空"; break;
        case 6: $case = "两次密码不能一致"; break;
        case 7: $case = "修改密码失败"; break;
        case 8: $case = "验证码发送失败请重新发送"; break;
        case 9: $case = "验证码错误请重新输入"; break;
        default: $case= "未知错误";
      }
      $this->result['status'] 	= false;
      $this->result['tips'] 	= $case;

      return $this->result;
    }
}

?>