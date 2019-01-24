<?php
// 在控制器实例化之后立即执行，控制器的任何方法都还尚未调用（除构造函数）
$a_config_plan['pre_controller'] = [
	function() {
		$o_tw =& get_instance();
		$o_tw->load->config('company_code', 'a_config_company_code');
		$o_tw->_a_company = $o_tw->config['a_config_company_code'];
	}
];
?>