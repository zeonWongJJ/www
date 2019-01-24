<?php
class Weixin_model extends TW_Model {
	private $_app_id = 'wxd40a4f9141fe81d0';
	//private
	
	public function __construct() {
		parent :: __construct();
	}
	
	// 请求CODE
	public function get_code($a_data) {
		if (isset($_SESSION['weixin_get_code_state']) && $a_data['state'] == $_SESSION['weixin_get_code_state']) {
			if ( isset($a_data['code']) && ! empty($a_data['code']) ) {
				return ['state_code' => '20000', 'msg' => '未同意操作授权！'];
			} else {
				return ['state_code' => '20001', 'msg' => '未同意操作授权！'];
			}
		}
	}
	
	
}
?>