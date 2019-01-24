<?php
//鉴权类
defined('BASEPATH') OR exit('禁止访问！');
class Authority_model extends TW_Model {
	private $white_list;
	public function __construct() {
		//权限白名单
		$this->white_list=array('login','index');
		$auth_state=$this->select_auth();
		if(!$auth_state){
			$this->error->show_error("无权",'/');
		}
	}



    /**
     * [鉴权]
     * @param  [type]  [description]
     * @return [type]        [description]
     */
	public function select_auth(){
		$_SESSION['user_id']=1;
		$get_index = $this->router->get_index();

		if(in_array($get_index,$this->white_list)){
			return true;
		}

		$admin_where=['a.id'=>$_SESSION['user_id']];
		$s_auth_id=$this->db->from("admin as a")
				 ->where($admin_where)
				 ->join('role as b', ['b.role_id' => 'a.role_id'])
				 ->select("role_auth_id")
				 ->get_row();

		if( !$s_auth_id ){
			return false;
		}

		$a_auth_id=explode(",",$s_auth_id['role_auth_id']);
		//获取实际权限
		$auth=$this->db->from("auth")
		->where_in('auth_id',$a_auth_id)
		->where(['action_url'=>$get_index])
		->select("action_url")
		->get_row();

		return $auth;
	}

}
