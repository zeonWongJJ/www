<?php

class User_experience_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/**********************************************************************************/

	//会员中心->荣耀明细
	public function get_experience_detail() {
		$a_where = [
			'member_id =' 	=> $_SESSION['user_id'],
			'type'			=> 1,
		];
		$s_field = '';
		$a_order = [
			'variation_id' => 'desc'
		];
		$a_data = $this->db->get('member_variation_log', $a_where, $s_field, $a_order);
		return $a_data;
	}

/**********************************************************************************/

}

?>