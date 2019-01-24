<?php

defined('BASEPATH') or exit('禁止访问！');

class Home_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('home_model');
	}

}