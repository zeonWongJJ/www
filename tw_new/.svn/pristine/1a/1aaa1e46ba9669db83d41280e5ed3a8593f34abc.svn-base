<?php
class Content_model extends TW_Model {
	public function __construct() {
		parent :: __construct();
	}
	
	// 把文本格式化
	public function pre($s_content) {
		$a_patterns = [
			"/[\x20]/",
			"/[\r|\n]/",
			"/\t/",
		];
		$a_replacements = [
			'&nbsp;&nbsp;',
			'<br />',
			'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
		];
		return preg_replace($a_patterns, $a_replacements, $s_content);
	}
}
?>