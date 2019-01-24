<?php

namespace model;

class ResetModel extends \TW_Model {
	public function __construct() {
        parent::__construct();
    }

	//获取用户名
	public function get_username($username) {
		$a_where = [ 'member_name' => $username ];
		$s_field = 'member_name';
		$s_data = $this->db->get_row('member',$a_where,$s_field);
		if( $s_data !== false ){
			$_SESSION['member_name'] = $s_data['member_name'];
			header('location:' . $this->router->url('reset_two') );
		} else {
			$this->error->show_error('用户不存在!');
		}
	}

	//根据id查询查询全部信息
	public function get_more($s_name) {
		$a_where = ['member_name' => $s_name];
		$s_field = 'member_name,member_email,member_mobile';
		$a_data = $this->db->get_row('member',$a_where,$s_field);
		return $a_data;
	}

	//验证验证码与发送的验证法是否一致
	public function pass_pwd($i_verify){
		$i_rand = $this->general->cookie('rand');
		$i_rand = $this->general->base64_convert($i_rand,true);

		if ( $i_verify == $i_rand ){
			$a_where = ['member_name' => $_SESSION['member_name']];
			$s_field = 'member_id';
			$a_data = $this->db->get_row('member',$a_where,$s_field);
			$_SESSION['id'] = $a_data['member_id'];
			header('location:' . $this->router->url('reset_three') );
		} else {
			$this->error->show_error('验证码不正确','reset_two' ,false,2);
		}
	}

	//根据id查询查询全部信息
	public function update($s_password) {
		$b_res = $this->db->update('member', ['member_passwd' => md5($s_password) ], ['member_id' => $_SESSION['id'] ] );
		if ( $b_res ){
			header('location:' . $this->router->url('reset_four'));
		} else {
			$this->error->show_error('两次输入的密码不一致！','reset_three',false,2);
		}
	}
}
?>
