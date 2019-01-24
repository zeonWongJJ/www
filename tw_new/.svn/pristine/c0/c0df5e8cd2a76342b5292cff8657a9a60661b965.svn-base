<?php

class Service_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
		// if(empty($_SESSION['user_id'])){
		// 	$this->error->show_error('您没有登录,请您先登录', 'login', false, 2);
		// }
	}

	//服务者中心首页
	public function service_index() {
		if ($_SERVER['REQUEST_METHOD']=="GET") {
			$this->view->display('service_index');
		}
	}

	//服务者中心称号页面
	public function service_chenghao() {
		if ($_SERVER['REQUEST_METHOD']=="GET") {
			//查询当前用户的信息
			$this->load->model('service_model');//引入模型
			$a_data = $this->service_model->get_userinfo();//使用模型
			$this->view->display('service_chenghao',$a_data);
		}
	}

	//服务中心验证页面
	public function service_verification() {
		if($_SERVER['REQUEST_METHOD']=="GET"){
			$this->view->display('service_verification');
		}
	}

	//服务者中心我的排班表
	public function service_mydate() {
		if ($_SERVER['REQUEST_METHOD']=="GET") {
			//调用模型查询需求表
			$this->load->model('service_model');//引入模型
			$a_data = $this->service_model->get_demand();//使用模型
			echo json_encode($a_data);
		}
	}

	//服务者中心我的竞标中的订单
	public function service_mybid() {
		if ($_SERVER['REQUEST_METHOD']=="GET") {
			$this->load->model('service_model');//引入模型
			$a_data = $this->service_model->get_mybid();//使用模型
			echo json_encode($a_data);
		}
	}

	//服务者中心待确认的订单
	public function service_toconfirmed() {
		if ($_SERVER['REQUEST_METHOD']=="GET") {
			$this->load->model('service_model');//引入模型
			$a_data = $this->service_model->get_toconfirmed();//使用模型
			echo json_encode($a_data);
		}
	}

	//服务者中心待确认订单之查看详情
	public function service_toconfirmed_detail(){
		if ($_SERVER['REQUEST_METHOD']=="GET") {
			//接收需要查询详情的需求id
			$id = $this->router->get(1);
			$this->load->model('service_model');//引入模型
			$a_data = $this->service_model->get_toconfirmed_detail($id);//使用模型
			echo json_encode($a_data);
		}
	}

	//服务者中心待确认订单之确认订单操作
	public function service_confirmed() {
		if ($_SERVER['REQUEST_METHOD']=="GET") {
			//接收需要操作的订单(需求)id
			$id = $this->router->get(1);
			$this->load->model('service_model');//引入模型
			$i_result = $this->service_model->update_confirmed($id);//使用模型
			if ($i_result) {
				echo json_encode(array('code'=>200,'msg'=>'订单已确认', 'data'=>$i_result));
			} else {
				echo json_encode(array('code'=>400,'msg'=>'订单确认失败'));
			}
		}
	}

	//服务者中心待确认订单之放弃订单操作
	public function service_cancel() {
		if ($_SERVER['REQUEST_METHOD']=="GET") {
			//接收需要操作的订单(需求)id
			$id = $this->router->get(1);
			$this->load->model('service_model');//引入模型
			$i_result = $this->service_model->update_cancel($id);//使用模型
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'取消订单成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'取消订单失败'));
			}
		}
	}

	//服务者中心之服务中的订单
	public function service_inservice() {
		if ($_SERVER['REQUEST_METHOD']=="GET") {
			$this->load->model('service_model');//引入模型
			$a_data = $this->service_model->get_inservice();//使用模型
			echo json_encode($a_data);
		}
	}

	//服务者中心之确定订单完成
	public function service_complete() {
		if ($_SERVER['REQUEST_METHOD']=="GET") {
			//接收需要操作的订单(需求)id
			$id = $this->router->get(1);
			$this->load->model('service_model');//引入模型
			$i_result = $this->service_model->update_complete($id);//使用模型
			if ($i_result) {
				echo json_encode(array('code'=>200,'msg'=>'确认服务完成成功'));
			} else {
				echo json_encode(array('code'=>400,'msg'=>'确认服务完成失败'));
			}
		}
	}

	//服务者中心之增加服务费用
	public function service_addmoney() {
		if ($_SERVER['REQUEST_METHOD']=="POST") {
			//接收需要增加费用的需求id
			$id = trim($this->general->post('id'));
			$add_money = trim($this->general->post('add_money'));
			$add_why = trim($this->general->post('add_why'));
			$this->load->model('service_model');//引入模型
			$i_result = $this->service_model->update_addmoney($id,$add_money,$add_why);//使用模型
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'增加服务费用成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'增加服务费用失败'));
			}
		} else {
			$this->view->display('service_addmoney');
		}
	}

	//服务者中心之待评价的订单
	public function service_tocomment() {
		if ($_SERVER['REQUEST_METHOD']=="GET") {
			$this->load->model('service_model');//引入模型
			$a_data = $this->service_model->get_tocomment();//使用模型
			echo json_encode($a_data);
		}
	}

	//服务者中心之保修中的的订单
	public function service_guarantee() {
		if ($_SERVER['REQUEST_METHOD']=="GET") {
			$this->load->model('service_model');
			$a_data = $this->service_model->get_guarantee();
			echo json_encode($a_data);
		}
	}

	//服务者中心之已完成的订单
	public function service_end() {
		if ($_SERVER['REQUEST_METHOD']=="GET") {
			$this->load->model('service_model');
			$a_data = $this->service_model->get_end();
			echo json_encode($a_data);
		}
	}



}

?>