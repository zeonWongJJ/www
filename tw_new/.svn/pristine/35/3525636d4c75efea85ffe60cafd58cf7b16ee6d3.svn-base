<?php
// 在控制器实例化之后立即执行，控制器的任何方法都还尚未调用（除构造函数）
$a_config_plan['pre_controller'] = [
	function() {
		$o_tw =& get_instance();
		if ( (! isset($_SESSION['store_id']) || ! isset($_SESSION['manager_id'])) && ! in_array($o_tw->router->get_index(), ['login', 'logout', 'notify_wx','waits'])) {
			header("Location: " . $o_tw->router->url('login'));
			exit();
		}
	}
];
?>