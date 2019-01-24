<?php

/**
 在控制器实例化之后立即执行，控制器的任何方法都还尚未调用（除构造函数）
 这种情况用的比较多，像登录判断就可以在这个阶段执行计划程序
*/
$a_config_plan['pre_controller'] = [
	function() {
		// 访问系统类库的方法，$o_tw 就相当于平常在控制器中用的 $this
		// $o_tw =& get_instance();
		// // 访问数据库
		// $o_tw->db->get('table');
		// 其他的类库也可以这样使用
	},
	[
		// 类名
		'class' => 'ManageAuth',
		// 函数名
		'method' => 'auth_check',
		// 文件名，免.php后缀
		'filename' => 'ManageAuth',
		// 文件所在项目下的路径，
		'filepath' => 'hooks',
		/**
		 实例化时的初始参数
		 'param_class' => 1   会以 $class->$function(1)的形式传入，其中1可以是任何顾类型的变量，包括数组
		 'param_class' => [1, 2]   会以$class->$function(1, 2)形式传入，其中1和2可以是任何顾类型的变量，包括数组
		*/
		// 'param_class' => ['aa', 'bb'],
		// // 调用函数时传入的参数，参数使用同上
		// 'param_method' => ['cc', 'dd', 'ee'],
	],
	function() {
		// echo '第3函数';
	},
];


?>