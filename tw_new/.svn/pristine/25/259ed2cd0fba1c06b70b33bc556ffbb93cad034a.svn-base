<?php
//写错误信息
class Error_model extends TW_Model {
	//写入错误信息
	public function insert_error($error_message){
		foreach($error_message as $key=>$value){
			$insert_data[$key]=$value;
		}
		$this->db->insert('error',$insert_data);
	}

}
