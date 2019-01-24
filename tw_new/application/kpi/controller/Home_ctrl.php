<?php
defined('BASEPATH') OR exit('禁止访问！');
date_default_timezone_set('PRC'); 
class Home_ctrl extends TW_Controller {

    //登录
	public function login() {
		$this->view->display('login');
	}    
	public function login_but() {
       	$s_name = $this->general->post('username');
		$s_pwd = $this->general->post('passwd');
		if (empty($s_name) || empty($s_pwd)) {
			$this->error->show_warning('请填写用户名和密码！');
		}
        //获取函数
		$this->load->config('hust', 'a_hust');
		$a_data['brand'] = get_config_item('a_hust');
        foreach ($a_data['brand'] as $ke => $vr) {  
        	if ($ke == $s_name && $vr == $s_pwd) {
				$_SESSION['user_name'] = $s_name;	
				//获取函数
		        $this->load->config('hust', 'a_record');
				$a_data['brand'] = get_config_item('a_record');	
				foreach ($a_data['brand'] as $ka => $vve) {
					if ($vve == $_SESSION['user_name']) {
						$_SESSION['name'] = $ka;
					} 
				}			
				$this->error->show_success('登录成功！', $this->router->url('index'));
        	}
        }
        $this->error->show_warning('用户名或密码错误！');        
	}
    //首页
	public function index() {
		if (empty($_SESSION['user_name'])) {
			$this->error->show_warning('请先登录！', $this->router->url('login'));
		}
		$this->db->group_by('update_time');
		$this->db->select('update_time');
		$a_data['min'] = $this->db->get('score');
        $i_mine = $this->general->post('dd') ? $this->general->post('dd') : date('Ym');
		// $this->db->get(表名, 条件, 字段, 排序, 开始行, 结束行);
        $a_data['details'] = $this->db->get('score', ['update_time' => $i_mine]);
		$this->view->display('index', $a_data);			
	}
	//详情页
	public function details() {;
       	$a_name = $this->router->get(1);
      	$a_id = $this->router->get(2);
      	$a_data = $this->db->get_row('score', ['id' => $a_id]);
		$this->view->display('details', $a_data);
	}
    //考核
	public function check() {
        if (empty($_SESSION['user_name'])) {
			$this->error->show_warning('请先登录！', $this->router->url('login'));
		}
		$this->load->config('hust', 'a_record');
		$a_data['brand'] = get_config_item('a_record');	
		$this->view->display('check', $a_data);
	}

	//考核触发
	public function check_butr() {
		$this->load->config('hust', 'a_htuw');        
    	if ( ! in_array($_SESSION['name'], $this->config['a_htuw'])) {
			$this->error->show_success('管理员才可以选择！');
    	}
        $a_gc = $this->router->get(1);
		//客服
        $this->load->config('hust', 'a_write');  
        if (in_array($a_gc, $this->config['a_write'])) {      
	    	header('Location:' . $this->router->url('write', [$a_gc]));
    	}
       
        //编辑
        $this->load->config('hust', 'a_redact');
        if (in_array($a_gc, $this->config['a_redact'])) {
			header('Location:' . $this->router->url('redact', [$a_gc]));
	    }
        //技术
        $this->load->config('hust', 'a_science');
        if (in_array($a_gc, $this->config['a_science'])) {
    		header('Location:' . $this->router->url('science', [$a_gc]));
        }
	}

	//客服填写
	public function write() {
        if (empty($_SESSION['user_name'])) {
			$this->error->show_warning('请先登录！', $this->router->url('login'));
		}		
		$this->load->config('hust', 'a_htuw'); 
		$this->load->config('hust', 'a_write');       
    	if ( ! in_array($_SESSION['name'], $this->config['a_htuw'])) {
			$this->error->show_success('你没有权限选择！');
    	}
    	$a_gc = $this->router->get(1);
        $this->load->config('hust', 'a_record');
		$a_data['brand'] = get_config_item('a_record');	
		foreach ($a_data['brand'] as $kua => $grt) {
			if ($kua == $a_gc) {
				$s_namet = $grt;
			} 
		}
    	if ( ! empty($_POST)) {
    		//好评
    		$i_fine = $this->general->post('fine') ? $this->general->post('fine') : 1;
    		//中评
	        $i_centre = $this->general->post('centre') ? $this->general->post('centre') : 0;
	        //差评
	        $i_bad = $this->general->post('bad') ? $this->general->post('bad') : 0;
	        $i_late = $this->general->post('late')? $this->general->post('late') : 0;
	        $i_leave = $this->general->post('leave') ? $this->general->post('leave') : 0;
	        $i_add = $this->general->post('add') ?$this->general->post('add') : 0;        
	        $i_minus = $this->general->post('minus') ? $this->general->post('minus') : 0;
	        //总评数 ,其余分
	        $i_the = $i_fine + $i_centre + $i_bad;	        
	        //总分
	        $i_total = (100 - ($i_bad / $i_the *100) - ($i_centre / $i_the / 2 * 100)) - $i_late - $i_leave + $i_add - $i_minus;
	    	//添加到数据库
	    	$a_data = [
			    'name' => $s_namet,
			    'uaername' => $a_gc,
			    'fine' => $i_fine,
			    'head' => $i_the,
			    'centre' => $i_centre,
			    'bad' => $i_bad,
			    'late' => $i_late,
			    'leave' => $i_leave,
			    'add' => $i_add,
			    'minus' => $i_minus,
			    'total' => $i_total,
	        	'operation_time' => $_SERVER['REQUEST_TIME'],
			    'update_time' => date('Ym')
			];    	
	    	$a_name = $this->db->get('score', ['uaername' => $a_gc, 'update_time' => date('Ym')]);
			if (empty($a_name)) {
				$a_add =  $this->db->insert('score', $a_data);
				
			} else {
				$a_add =  $this->db->update('score', $a_data, ['uaername' => $a_gc, 'update_time' => date('Ym')]);
			}      
			if ($a_add) {
				$this->error->show_success('添加成功！', $this->router->url('check'));
			} else {
				$this->error->show_success('没有添加任何数据!', $this->router->url('check'));
			}
    	}   	
 		$this->view->display('write');
	}

	//编辑填写
    public function redact() {
        if (empty($_SESSION['user_name'])) {
			$this->error->show_warning('请先登录！', $this->router->url('login'));
		}
		$this->load->config('hust', 'a_htuw');        
    	if ( ! in_array($_SESSION['name'], $this->config['a_htuw'])) {
			$this->error->show_success('你没有权限选择！');
    	}       
        $a_gc = $this->router->get(1);		    

		if ( ! empty($_POST)) {
    		$i_late = $this->general->post('late')? $this->general->post('late') : 0;
	        $i_leave = $this->general->post('leave') ? $this->general->post('leave') : 0;
	        $i_add = $this->general->post('add') ?$this->general->post('add') : 0;        
	        $i_minus = $this->general->post('minus') ? $this->general->post('minus') : 0;
	        // $i_time = date('Ym') - 1; 

			$a_name = $this->db->get('score', ['uaername' => $a_gc, 'update_time' => date('Ym')]);
        	//总分
	        $i_total = $a_name[0]['head']  - $i_late - $i_leave + $i_add - $i_minus; 
	        $a_add = [
        		'late' => $i_late,
	        	'leave' => $i_leave,
	        	'add' => $i_add,
	        	'minus' => $i_minus,
	        	'total' => $i_total,
	        	'operation_time' => $_SERVER['REQUEST_TIME'],
	        	'update_time' => date('Ym')
	        ];   
			
			if (empty($a_name)) {
				$a_add =  $this->db->insert('score', $a_add);
				
			} else {
				$a_add =  $this->db->update('score', $a_add, ['uaername' => $a_gc, 'update_time' => date('Ym')]);
			}      
			if ($a_add) {
				$this->error->show_success('添加成功！', $this->router->url('check'));
			} else {
				$this->error->show_success('没有添加任何数据!', $this->router->url('check'));
			} 
    	}
		$this->view->display('redact');
	}

	//技术填写
    public function science() {
	    if (empty($_SESSION['user_name'])) {
			$this->error->show_warning('请先登录！', $this->router->url('login'));
		}
		$this->load->config('hust', 'a_htuw');       
		if ( ! in_array($_SESSION['name'], $this->config['a_htuw'])) {
			$this->error->show_success('你没有权限选择！');
		}      
        $a_gc = $this->router->get(1);
        if ( ! empty($_POST)) {
      		$i_late = $this->general->post('late')? $this->general->post('late') : 0;
	        $i_leave = $this->general->post('leave') ? $this->general->post('leave') : 0;
	        $i_add = $this->general->post('add') ?$this->general->post('add') : 0;        
	        $i_minus = $this->general->post('minus') ? $this->general->post('minus') : 0;
	        $a_name = $this->db->get('score', ['uaername' => $a_gc, 'update_time' => date('Ym')]);
        	//总分
	        $i_total = $a_name[0]['head'] - $i_late - $i_leave + $i_add - $i_minus;
	        $a_science = [
	        	'late' => $i_late,
	        	'leave' => $i_leave,
	        	'add' => $i_add,
	        	'minus' => $i_minus,
	        	'total' => $i_total,
	        	'operation_time' => $_SERVER['REQUEST_TIME'],
	        	'update_time' => date('Ym')
	        ]; 
	        
			if (empty($a_name)) {
				$a_add =  $this->db->insert('score', $a_science);
			} else {
				$a_add =  $this->db->update('score', $a_science, ['uaername' => $a_gc, 'update_time' => date('Ym')]);
			} 
			$this->error->show_success('添加成功！', $this->router->url('check'));        
      	}  	

		$this->view->display('science');
	}

    //设置
    public function setting() {
        if (empty($_SESSION['user_name'])) {
			$this->error->show_warning('请先登录！', $this->router->url('login'));
		}
		$this->load->config('hust', 'a_htuw');     
    	if ( ! in_array($_SESSION['name'], $this->config['a_htuw'])) {
			$this->error->show_success('管理员才可以选择！');
    	}
    	if ( ! empty($_POST)) {
      		$s_science = $this->general->post('science');
    		$s_redact = $this->general->post('redact');    		
    		if (empty($s_redact) || strlen($s_redact)>3 || ! preg_match('/^([0-9])/', $s_redact)) {
    			$this->error->show_remind('填写错误！');
    		} 
    		if (empty($s_science) || strlen($s_science)>3 || ! preg_match('/^([0-9])/', $s_science)){
    			$this->error->show_remind('填写错误！');
    		}
    		$a_att = [
    			'science' => $s_science,
    			'redact' => $s_redact
    		];
    		$a_setting = $this->db->insert('setting', $a_att);
    		if ( ! empty($a_setting)) {
				$this->error->show_success('操作成功！', $this->router->url('index'));
			}
    	}    	
		$this->view->display('setting');
	}

	//任务列表
    public function tasks() { 
    	if (empty($_SESSION['user_name'])) {
			$this->error->show_warning('请先登录！', $this->router->url('login'));
		}
    	$this->load->config('hust', 'a_record');  
    	$a_data['yshw'] = $this->config['a_record'];   	
    	$i_canshu = $this->router->get(3) ? $this->router->get(3) : 1; 
    	$i_exe = $this->general->post('executor') ? $this->general->post('executor') : $this->router->get(1);
    	$i_wen = $this->general->post('wen') ? $this->general->post('wen') : $this->router->get(2);
   		$this->load->library('pages');
   		if ( ! empty($i_exe)) {
   			$this->db->where(['executor' => $i_exe]);
   		}
   		if ( ! empty($i_wen)) {
   			$this->db->where(['accomplish' => $i_wen]);
   		}   		
   		$i_total = $this->db->get_total('task');
		$a_pdata = $this->pages->get($i_total, $i_canshu, 12);
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		if ( ! empty($i_exe)) {
   			$this->db->where(['executor' => $i_exe]);
   		}
   		if ( ! empty($i_wen)) {
   			$this->db->where(['accomplish' => $i_wen]);
   		} 
		$a_data['tasks'] = $this->db->get('task');
    	//页面数据显示和条件
   		$a_data['page'] = $this->pages->link_style_one(get_config_item('domain') . "/tasks-" . $i_exe . "-" . $i_wen . "-");
		$this->view->display('tasks', $a_data);
	}
	//发表任务
    public function task() {    	
        if (empty($_SESSION['user_name'])) {
			$this->error->show_warning('请先登录！', $this->router->url('login'));
		}
		$this->load->config('hust', 'a_htuw');     
    	if ( ! in_array($_SESSION['name'], $this->config['a_htuw'])) {
			$this->error->show_success('你没有权限选择！');
    	}
        if ( ! empty($_POST)) {
        	$a_title = $this->general->post('title');
        	$a_content = $this->general->post('content');
        	$a_executor = $this->general->post('executor');
        	$i_start = $this->general->post('start');
        	$i_end = $this->general->post('end');
        	$this->load->config('hust', 'a_record');
			$a_data['brand'] = get_config_item('a_record');	
			foreach ($a_data['brand'] as $kua => $grt) {
				if ($kua == $a_executor) {
					$s_na = $grt;
				} 
			}
        	if (empty($a_title) || empty($a_content) || empty($a_executor) || empty($i_start) || empty($i_end)) {
        		$this->error->show_success('还有地方没填写，请填写完整！');
        	}
        	$a_task = [
        		'manage' => $_SESSION['user_name'],
        		'executor' => $a_executor,
        		'name' => $s_na,
        		'title' => $a_title,
        		'content' => $a_content,
        		'time_start' => $i_start,
        		'time_end' => $i_end,
        		'time_creation' => $_SERVER['REQUEST_TIME']
        	];
        	$a_taskd = $this->db->insert('task', $a_task);
        	if ( ! empty($a_taskd)) {
        		$this->error->show_success('添加成功！', $this->router->url('tasks'));
        	}
        }
		$this->view->display('task');
	}
	//完成任务
    public function task_accomplish() {  
 		$s_task =  $this->router->get(1);
 		$_SESSION['task'] = $s_task;
		$a_data['tas'] = $this->db->get('task', ['id' => $s_task]);
		// print_r($a_data['tas']);
		foreach ($a_data['tas'] as $ts) {
			$s_named = $ts['name'];
		}
    	if ($s_named != $_SESSION['user_name']) {
			$this->error->show_success('你没有权限选择！');
    	} 
    	$this->view->display('task_accomplish', $a_data);
	}
    //完成任务触发 
    public function task_acco() {  
    	$i_accom = $this->general->post('tasd');
    	if ($i_accom == 1) {
     		$i_timet = $this->db->get_row('task', ['id' => $_SESSION['task']], ['time_start']);    	
	    	$startdate = $i_timet[0];	
			$enddate = $_SERVER['REQUEST_TIME'];			
			//算任务完成消耗的时间
			$startDate= $startdate; 
			$endDate= date('Y-m-d', $enddate); 	
			//假期日期数组，比方国庆,五一,春节等 		  
			$holidayArr=array("05-01","05-02","10-01","10-01","10-02","10-03","10-04","10-05","01-26","01-27","01-28","01-29"); 
			//周末是否双休.双休为2，仅仅星期天休息为1，没有休息为0
			$endWeek=2; 

			$beginUX=strtotime($startDate); 
			$endUX=strtotime($endDate); 
			  
			for($n=$beginUX;$n<=$endUX;$n=$n+86400){ 
			 $week=date("w",$n); 
			 $MonDay=date("m-d",$n); 
			 //去除周末休息
			 if($endWeek){ 
			 if($endWeek==2){ 
			 if($week==0||$week==6) continue; 
			 } 
			 if($endWeek==1){ 
			 if($week==0) continue; 
			 } 
			 } 
			 if(in_array($MonDay,$holidayArr)) continue; 
			 //每天工作8小时
			 $a_timed += 8; 
			}
			//算任务完成消耗的时间
			$hour =  floor($res / 3600);
	    	$a_acc = $this->db->update('task', ['accomplish' => $i_accom, 'residency' => $a_timed], ['id' => $_SESSION['task']]);	   
    	} else {
    		$a_timed = 0;
    		$a_acc = $this->db->update('task', ['accomplish' => $i_accom, 'residency' => $a_timed], ['id' => $_SESSION['task']]);
    	}
    	if ( ! empty($a_acc)) {
    			$this->error->show_success('操作成功！', $this->router->url('tasks'));
    	} else {
		  	$this->error->show_success('操作失败！', $this->router->url('tasks'));
		}
	}
    //任务修改
    public function taskde() {  
    	$this->load->config('hust', 'a_htuw');        
    	if ( ! in_array($_SESSION['name'], $this->config['a_htuw'])) {
			$this->error->show_success('管理员才可以选择！');
    	}
    	$i_taskde = $this->router->get(1);   
    	$_SESSION['taskde'] = $i_taskde; 	
    	$a_data = $this->db->get_row('task', ['id' => $i_taskde]);    	 	
    	$this->view->display('taskde', $a_data);
	}
	public function taskdel() {
		$a_title = $this->general->post('title');
    	$a_content = $this->general->post('content');
    	$a_executor = $this->general->post('executor');
    	$i_start = $this->general->post('start');
    	$i_end = $this->general->post('end');
    	$a_taskde = [
    		'title' => $a_title,
    		'content' => $a_content,
    		'executor' => $a_executor,
    		'time_start' => $i_start,
    		'time_end' => $i_end
    	];
    	$a_acc = $this->db->update('task', $a_taskde, ['id' => $_SESSION['taskde']]);
    	if ( ! empty($a_acc)) {
    		$this->error->show_success('操作成功！', $this->router->url('tasks'));
    	} else {
    		$this->error->show_success('操作失败！', $this->router->url('tasks'));
    	}
	}

	/**
	 * 退出
	 */
	public function logout() {
		$this->general->set_cookie('user_name', '', -99999999999);
		unset($_SESSION['user_name']);		
		$this->error->show_success('注销成功！', $this->router->url('login'));
	}

	public function test(){
		//客服
        // $this->load->config('hust', 'a_write');
        //编辑 
        $this->load->config('hust', 'a_redact');
        //技术    
        $this->load->config('hust', 'a_science');  

        // $kefu=$this->config['a_write'];
        $bianji=$this->config['a_redact'];
        $jishu=$this->config['a_science'];
   

        // $kefu_data=$this->jisuan($kefu,1);
        $bianji_data=$this->jisuan($bianji,2);
        $jishu_data=$this->jisuan($jishu,3);

	}

	public function jisuan($name,$type){
		switch ($type) {
			
			case '2':
				foreach($name as $key => $s_namet){
					$this->load->config('hust', 'a_record');
					$a_user = $this->config['a_record'];
					foreach ($a_user as $kt => $vt) {
						if ($kt == $s_namet) {
							$a_user = $vt;
							
						}	
					}
				    // 获取编辑数据库的数据
					$this->load->database('wangyi120');
			        //获取上个月初到月未的时间戳
			        $thismonth = date('m');
					$thisyear = date('Y');
					if ($thismonth == 1) {
					 	$lastmonth = 12;
					 	$lastyear = $thisyear - 1;
					} else {
						$lastmonth = $thismonth - 1;
						$lastyear = $thisyear;
					}
					$lastStartDay = $lastyear . '-' . $lastmonth . '-1';
					$lastEndDay = $lastyear . '-' . $lastmonth . '-' . date('t', strtotime($lastStartDay));
					//上个月的月初时间戳
					$i_meit = strtotime($lastStartDay);
					//上个月的月末时间戳
					$i_mite = strtotime($lastEndDay);
					//查询上一月的量
			        $this->wangyi120->where(['username' => $s_namet]);
			        $this->wangyi120->where(['index_baidu' => 1]);
			        $this->wangyi120->where("`updatetime` >= '$i_meit'");
			        $this->wangyi120->where("`updatetime` <= '$i_mite'");
			        $a_wen = $this->wangyi120->get_total('v9_news');
			   		$a_b = $this->db->get_row('setting', 0 , ['redact'], ['id' => 'desc']);	
			   		//算编辑得分
			   		if ($a_wen > $a_b['redact']) {
			   			$i_score = 100 + ($a_wen - $a_b['redact']);
			   		} else {
			   			if ($a_wen == 0) {
			   				$i_score = 100 - (round($a_b['redact'] / 1 , 2));
			   			} else {
			   				$i_score = 100 - (round($a_b['redact'] / $a_wen , 2));
			   			}
			   		} 

					$a_add = [
			        	'name' => $a_user,
			        	'uaername' => $s_namet,
			        	'head' => $i_score,
			        	'measure' => $a_wen,
			        	'measure_i' => $a_b['redact'],
			        	'operation_time' => $_SERVER['REQUEST_TIME'],
			        	'update_time' => date('Ym')
			        ];   
					$a_name = $this->db->get('score', ['uaername' => $s_namet, 'update_time' => date('Ym')]);
					if (empty($a_name)) {
						$a_add =  $this->db->insert('score', $a_add);
						
					} else {
						$a_add =  $this->db->update('score', $a_add, ['uaername' => $s_namet, 'update_time' => date('Ym')]);
					}      
				}
				break;
			case '3':
				foreach($name as $key => $s_namet){
					$this->load->config('hust', 'a_record');
					$a_user = $this->config['a_record'];
					foreach ($a_user as $kt => $vt) {
						if ($kt == $s_namet) {
							$a_user = $vt;
							
						}	
					}
					
			        $i_time = date('Ym') - 1;  
			        $i_tme = substr_replace($i_time, '-', 4, -2); 

		   			$a_where = ['executor' => $s_namet, 'accomplish' => 1];
			       	$a_select = "residency";
			       	//超出的时间
		       		$i_meu = $this->db->where("`time_end` LIKE '%" . addslashes($i_tme) . "%'")->get('task', $a_where, $a_select);
		       		//技术完成的量	
		       		$i_nuse = count($i_meu);
		       		$i_tt['residency'] = '0';
		       		foreach ($i_meu as $ken => $ghy) {
		       			$i_tt['residency'] += $ghy ['residency'];	
		       		}
		       		//技术设置的参数
		       		$i_yua = $this->db->get_row('setting', 0 , ['science'], ['id' => 'desc']);	

		   			if ($i_tt['residency'] < $i_yua['science']) {
		   			 	$i_task = 100 + (($i_tt['residency'] - $i_yua['science'])*20);
		   			} else {
		   				if ($i_tt['residency'] < 40) {
		   					$i_task = 100;
		   				} else {
		   					$i_task = 100 + ($i_tt['residency'] - 40);
		   				}
		   				
		   			} 
			        $a_science = [
			        	'name' => $a_user,
			        	'uaername' => $s_namet,
				    	'head' => $i_task,
			        	'meuter' => $i_nuse,
			        	'meuter_i' => $i_yua['science'],
			        	'operation_time' => $_SERVER['REQUEST_TIME'],
			        	'update_time' => date('Ym')
			        ]; 
			        $a_name = $this->db->get('score', ['uaername' => $s_namet, 'update_time' => date('Ym')]);
					if (empty($a_name)) {
						$this->db->insert('score', $a_science);
						
					} else {
						$this->db->update('score', $a_science, ['uaername' => $s_namet, 'update_time' => date('Ym')]);
					}
				}
				break;
		}
		return $result;
	}
}