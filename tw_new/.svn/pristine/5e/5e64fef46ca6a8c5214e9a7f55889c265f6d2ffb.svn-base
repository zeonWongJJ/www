<?php

class Appellation_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('appellation_model');
		$this->load->model('allow_model');
		//判断是否登录
		$this->allow_model->is_login();
		//判断是否有权限访问
		$this->allow_model->is_allow();
	}

/**********************************************************************************************/

	//服务者称号列表
	public function appellation_demand() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$app_type = 1; //1代表为服务者
			$a_data = $this->appellation_model->get_appellation_demand($app_type);
			$this->view->display('appellation_demand', $a_data);
		}
	}

/**********************************************************************************************/

	//需求者称号列表
	public function appellation_server() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$app_type = 2; //2代表为需求者
			$a_data = $this->appellation_model->get_appellation_server($app_type);
			$this->view->display('appellation_server', $a_data);
		}
	}

/**********************************************************************************************/

	//境加称号
	public function add_appellation() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收用户提交的信息
			$app_name = trim($this->general->post('app_name'));
			$min_score = trim($this->general->post('min_score'));
			$max_score = trim($this->general->post('max_score'));
			$app_type = trim($this->general->post('app_type'));
			$app_level = trim($this->general->post('app_level'));
			$multiple = trim($this->general->post('multiple'));
			$a_data = [
				'app_name'	=> $app_name,
				'min_score' => $min_score,
				'max_score' => $max_score,
				'app_type'  => $app_type,
				'app_level' => $app_level,
				'multiple'  => $multiple,
			];
			//将数据插入到数据表
			$i_result = $this->appellation_model->insert_appellation($a_data);
			if ($i_result) {
				if ($app_type == 1) {
					$this->error->show_success('添加称号成功', 'appellation_server', false, 2);
				} else {
					$this->error->show_success('添加称号成功', 'appellation_demand', false, 2);
				}
			} else {
				$this->error->show_error('添加称号失败', 'appellation_demand', false, 2);
			}
		} else {
			$this->view->display('add_appellation');
		}
	}

/**********************************************************************************************/

	//删除某个称号
	public function appellation_delete() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要删除的称号id
			$id = $this->router->get(1);
			$i_result = $this->appellation_model->delete_appellation($id);
			if ($i_result) {
				$this->error->show_success('删除成功', 'appellation_demand', false, 2);
			} else {
				$this->error->show_error('删除失败', 'appellation_demand', false, 2);
			}
		}
	}

/**********************************************************************************************/

	//修改某个称号
	public function appellation_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的数据
			$app_id = $this->general->post('app_id');
			$app_name = trim($this->general->post('app_name'));
			$min_score = trim($this->general->post('min_score'));
			$max_score = trim($this->general->post('max_score'));
			$app_type = trim($this->general->post('app_type'));
			$app_level = trim($this->general->post('app_level'));
			$multiple = trim($this->general->post('multiple'));
			//判断数据合法性
			if (strlen($app_name)==0 || strlen($min_score)==0 || strlen($max_score)==0 || strlen($app_type)==0 || strlen($app_level)==0 || strlen($multiple)==0) {
				if ($app_type==1) {
					$this->error->show_error('修改失败，必填项不能为空', 'appellation_server', false, 2);
				} else {
					$this->error->show_error('修改失败，必填项不能为空', 'appellation_demand', false, 2);
				}
			}
			//更新数据表数据
			$a_where = [
				'app_id'	=> $app_id,
			];
			$a_data = [
				'app_name'	=> $app_name,
				'min_score' => $min_score,
				'max_score' => $max_score,
				'app_type'  => $app_type,
				'app_level' => $app_level,
				'multiple'  => $multiple,
			];
			$i_result = $this->appellation_model->update_appellation($a_where, $a_data);
			if ($i_result) {
				if($app_type==1){
					$this->error->show_success('修改成功', 'appellation_server', false, 2);
				} else {
					$this->error->show_success('修改失败', 'appellation_demand', false, 2);
				}
			} else {
				$this->error->show_error('修改失败', 'appellation_demand', false, 2);
			}
		} else {
			//接收需要修改的称号id
			$id = $this->router->get(1);
			$a_data = $this->appellation_model->get_appellation_detail($id);
			$this->view->display('appellation_update', $a_data);
		}
	}

/**********************************************************************************************/

}

?>