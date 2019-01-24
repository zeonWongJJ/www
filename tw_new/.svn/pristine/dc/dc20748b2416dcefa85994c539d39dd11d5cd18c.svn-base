<?php
defined('BASEPATH') OR exit('禁止访问！');

class Msg_ctrl extends TW_Controller {
	
	public function __construct() {
		parent :: __construct();
		$this->load->model('delivery_model');
	}
	
	// 显示消息页面
	public function msg_show() {
		$a_data = [];
		// 先设置默认从第一页开始
		$i_page = $this->router->get(1);
		if (empty($i_page)) {
			$i_page = 1;
		}
		// 设置每页显示的数据行数
		$i_prow = 10;
		// 加载分页类
		$this->load->library('pages');
		$a_where = ['ues_id' => $_SESSION['store_id'], 'ues' => 2];
		// 获取数据总行数
		$i_total = $this->db->get_total('messagess', $a_where);
		// echo $this->db->get_sql();
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		$a_data['msg'] = $this->db->get('messagess', $a_where, '', ['mess_id' => 'desc']);
		// 这里就是产品数据了，可以在模板里面循环出来
		//print_r($a_data['product']);
		// 这里是在模板输出分页链接，注意这里的URL末尾不能带.html，所以$this->router->url函数用了第四个参数，并且设置为false
		// 还需要注意URL后面会被自动加上分页码，所以需要传入一个参数分隔符“-”
		//echo $this->pages->link_style_one($this->router->url('index-', [], false, false));
		$this->view->display('msg_show', $a_data);
	}
	
	// 查询最新订单和最新消息
	public function new_msg_order() {
		// 未付款自动取消
		$this->delivery_model->modert();
		//已配送完自动确认收货
		$this->delivery_model->system_sure_order();
		$this->delivery_model->system_sure_book_order();
		$a_max_msg = $this->db->get_row('messagess', NULL, 'mess_id', ['mess_id' => 'desc']);
		$a_max_order = $this->db->get_row('order', ['order_type' =>1,'order_state' =>20,'store_id' => $_SESSION['store_id']], 'order_id', ['order_id' => 'desc']);
		$a_new_max_order = $this->db->get_row('order', ['order_type' =>2, 'order_state' =>20], 'order_id', ['order_id' => 'desc']);
		$a_max_appointment = $this->db->get_row('appointment', NULL, 'appointment_id', ['appointment_id' => 'desc']);
		$a_json = [
			'mess_id' => $a_max_msg['mess_id'],
			'order_id' => $a_max_order['order_id'],
			'new_order_id' => $a_new_max_order['order_id'],
			'appointment_id' => $a_max_appointment['appointment_id'],
		];
		echo json_encode($a_json);
	}
	
	// 触发消息为已读
	public function msg_read() {
		$i_id_msg = intval($this->general->post('id_msg'));
		if ($i_id_msg) {
			if ($this->db->update('messagess', ['examine' => 2], ['mess_id' => $i_id_msg])) {
				echo json_encode(['state' => 'success']);
				exit;
			}
		}
		echo json_encode(['state' => 'fail']);
	}
}
