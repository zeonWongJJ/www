<?php
defined('BASEPATH') OR exit('禁止访问！');
class Shop_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();

		//实例化模型
		// $this->load->model('index_model');
		$this->load->model('login_model');
		$this->load->model('cart_model');
	}

	public function shopping(){
		//判断是否登录
		$this->login_model->login();
		//查询购物车页面输出的数据
		$a_data['cart'] = $this->cart_model->cart();
		//获取到删除购物车的第一个删除
		$i_del = $this->general->post('id');
		if( ! empty($i_del)){
			$i_del = $this->db->delete('cart', ['buyer_id' => $_SESSION['user_id'], 'goods_id' => $i_del]);
			echo 1;
			die;
		}
		$this->view->display('shop', $a_data);
	}
}
