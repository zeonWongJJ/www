<?php
defined('BASEPATH') OR exit('禁止访问！');

class Waits_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		
	}
// 默认显示页面
	public function waits() {
		$this->view->display('waits');
	}	


}
