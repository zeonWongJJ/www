<?php
// 在控制器实例化之后立即执行，控制器的任何方法都还尚未调用（除构造函数）
$a_config_plan['pre_controller'] = [
	function() {
		// 初始化变量
		$_SESSION['project']['curr_project'] = empty($_SESSION['project']['curr_project']) ? 0 : $_SESSION['project']['curr_project'];
		$o_tw =& get_instance();
		
		// 访问操作权限检查
		$a_filter_login = ['login', 'logout', 'register'];
		if (! in_array($o_tw->router->get_index(), $a_filter_login) ) {
			// 判断是否登录
			if ( ! isset($_SESSION['user']['id_user']) ) {
				header("Location: " . $o_tw->router->url('login'));
				exit();
			}
			//if (empty($_SESSION['user']['openid_weixin'])) {
				//header("Location: " . $o_tw->router->url('binding'));
				//exit();
			//}
			
			
			// 必须先选中一个项目才能进行其他操作
			/*$a_filter_project = ['project_list', 'project_add', 'task_group_list', 'index', 'clear'];
			if ( ! in_array($o_tw->router->get_index(), $a_filter_project) ) {
				if ( ! isset($_SESSION['project']['curr_project']) || empty($_SESSION['project']['curr_project']) ) {
					$o_tw->error->show_warning('必须进入一个项目才能操作的呢！', $o_tw->router->url('project_list'));
					exit();
				}
				$_SESSION['project']['data'] = $o_tw->db->get('project');
				foreach ($_SESSION['project']['data'] as $a_project) {
					if ($_SESSION['project']['curr_project'] == $a_project['id_project'] && $a_project['id_parent'] == 0) {
						$o_tw->error->location($o_tw->router->url('project_list', [$_SESSION['project']['curr_project']]));
					}
				}
			}*/
			
			// 初始化分类数据，避免重复加载到$this->config中，所以直接使用require加载
			require(PROJECTPATH . '/config/config_custom.php');
			$_SESSION['classify'] = $a_config_classify[0];
			//$_SESSION['department'] = $a_config_department;
		}
	}
];
?>