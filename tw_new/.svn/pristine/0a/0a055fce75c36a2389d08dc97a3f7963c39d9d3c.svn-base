<?php
//写错误信息
class Error_model extends TW_Model {
	//写入错误信息
	public function insert_error($error_message){
		if($error_message['uid']==null){
			$error_message['uid']=9999;
		}
		$this->db->insert('error',$error_message);
	}

}
