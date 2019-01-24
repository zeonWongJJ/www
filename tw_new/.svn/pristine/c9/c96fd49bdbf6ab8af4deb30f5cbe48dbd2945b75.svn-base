<?php
defined('BASEPATH') OR exit('禁止访问！');
header("Content-Type:text/html;charset=utf8");
date_default_timezone_set('PRC'); 
class Evaluation_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();	
		$this->load->model('login_model');
	}
	
	//资产中心
	public function evaluate()	{
		//判断是否登录
		$this->login_model->login();
		
		//实例化index模型
		$this->load->model('index_model');

		//获取所有评价信息
		$a_data = $this->index_model->evaluate();
		
		$this->view->display('evaluation',$a_data);
	}

}
