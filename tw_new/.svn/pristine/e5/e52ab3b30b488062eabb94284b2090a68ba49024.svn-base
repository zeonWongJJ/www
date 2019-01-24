<?php
/**
 * 记录日志
 */
class TW_Log {
	
	public function __construct() {
		
	}
	
	// 记录错误信息到数据库
	public static function record($s_log, $s_type, $s_url = '') {
		$TW =& get_instance();
		if ( ! is_object($TW->router) || ! is_object($TW->db) ) {
			return false;
		}
		$s_url = empty($s_url) ? $TW->router->get_url() : $s_url;
		$i_uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;
		$TW->db->insert('error', ['recode' => $s_log, 'type' => $s_type, 'url' => $s_url, 'ip' => $TW->general->get_ip(), 'uid' => $i_uid, 'time' => $_SERVER['REQUEST_TIME']]);
	}
}
?>