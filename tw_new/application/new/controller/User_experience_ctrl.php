<?php

class User_experience_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('user_experience_model');
        $this->load->model('is_login_model');
        $this->is_login_model->is_login();
	}

/**********************************************************************************/

	//会员中心->荣耀明细
	public function user_experience_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//获取数据
			$a_data = $this->user_experience_model->get_experience_detail();
			$this->view->display('user_experience',$a_data);
		}
	}

/**********************************************************************************/

}

?>