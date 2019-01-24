<?php
class Test_model extends TW_Model {
	public function __construct() {
        
    }
	
	public function tmodel() {
		$this->db->get_row('shopnc_admin_log', array('id <' => 6831));
	}
}
?>