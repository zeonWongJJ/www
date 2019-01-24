<?php
defined('BASEPATH') OR exit('禁止访问！');

class Api_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
	}
	
	public function add() {
		$a_post = $this->general->post();
		// 1. 分发给不同的物流公司
		$this->load->model('distribute_model');
		$a_result = $this->distribute_model->distribute($a_post);
		echo json_encode($a_result);
		// 2. 提交订单
		// 3. 接收通知，当有一家公司接单后，立即通知其他公司取消订单，避免重复接单，在取货状态以后的通知，都进行订单查询，更新订单表的配送信息
		// 4. 提供接口，返回当前状态数据，根据参数，可返回地图
		// 5. 定期，或是通过接口访问时参数触发，执行订单重新提交
		// 6. 取消订单
		
	}
	
	// 订单查询
	public function query() {
		$a_post = $this->general->post();
		$this->load->model('order_model');
		$a_data = $this->order_model->query($a_post);
		echo json_encode($a_data);
	}
	
	// 取消订单
	public function cancel() {
		$a_post = $this->general->post();
		$this->load->model('order_model');
		$a_data = $this->order_model->cancel($a_post);
		echo json_encode($a_data);
	}
}
