<?php

defined('BASEPATH') or exit('禁止访问！');

class Product_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('product_model');
		// $this->load->model('allow_model');
		// $this->allow_model->is_login();
	}

	// 产品分类
	public function product_categories() {
		$i_one  = $this->general->post('id');
		$a_data = $this->product_model->categories($i_one);
		if ($a_data) {
			echo json_encode(array('code' => 200, 'stey' => '查询成功', 'data' => $a_data));
		} else {
			echo json_encode(array('code' => 400, 'stey' => '无数据'));
		}
	}

	// 产品综合列表
	public function product_list() {
		$i_one1   = $this->router->get(2) ? $this->router->get(2) : 0;
		$i_one2   = $this->router->get(3) ? $this->router->get(3) : 0;
		$i_one3   = $this->router->get(4) ? $this->router->get(4) : 0;
		$a_name   = Urldecode($this->router->get(5)) ? Urldecode($this->router->get(5)) : 0;
		$i_order  = $this->router->get(6) ? $this->router->get(6) : 0;
		$i_pros_d = $this->router->get(7) ? $this->router->get(7) : 0;
		$i_pros_g = $this->router->get(8) ? $this->router->get(8) : 0;
		$i_dada   = $this->router->get(9) ? $this->router->get(9) : 0;
		// 分类
		$a_data['pron']  = $this->product_model->product_classification($i_one1, $i_one2, $i_one3);
		$a_data['pront'] = $this->product_model->categories($i_one1, $i_one2);
		$a_data['list']  = $this->product_model->product_list($i_one1, $i_one2, $i_one3, $a_name, $i_order, $i_dada, 1);
		$a_wher = "";
		if ( ! empty($i_pros_d)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`price` >= $i_pros_d";
		}
		if ( ! empty($i_pros_g)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`price` <= $i_pros_g";
		}
		$a_data['money'] = $this->db->limit(0,99999999999)->get('price', $a_where);
		// echo $this->db->get_sql();
		foreach ($a_data['list'] as $list) {
			$i=0;
			foreach ($a_data['money'] as $key => $money) {
				if ($money['product_id'] == $list[0]) {
					if ($i == 0) {
						$list['money'] = $money['price'];
						$a_data['goods'][] = $list;
					}
					$i++;
				}
			}
		}
		$this->view->display('product_list', $a_data);
	}

	// 获取更多产品综合列表
	public function product_list_page() {	
		$i_one1   = $this->general->post('i_one1'); 
		$i_one2   = $this->general->post('i_one2'); 
		$i_one3   = $this->general->post('i_one3'); 
		$a_name   = $this->general->post('a_name'); 
		$i_order  = $this->general->post('i_order');
		$i_pros_d = $this->general->post('i_pros_d');
		$i_pros_g = $this->general->post('i_pros_g');
		$i_dada   = $this->general->post('i_dada');  
		$page     = $this->general->post('page'); 
		$a_data['list'] = $this->product_model->product_list($i_one1, $i_one2, $i_one3, $a_name, $i_order, $i_dada, $page);
		$a_wher = "";
		if ( ! empty($i_pros_d)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`price` >= $i_pros_d";
		}
		if ( ! empty($i_pros_g)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`price` <= $i_pros_g";
		}
		$a_data['money'] = $this->db->limit(0,99999999999)->get('price', $a_where);
		foreach ($a_data['list'] as $list) {
			$i=0;
			foreach ($a_data['money'] as $key => $money) {
				if ($money['product_id'] == $list[0]) {
					if ($i == 0) {
						$list['money'] = $money['price'];
						$goods[] = $list;
					}
					$i++;
				}
			}
		}

		if ($a_data) {
			echo json_encode(array('code' => 200, 'ste' => '查询成功', 'data' => $goods));
		} else {
			echo json_encode(array('code' => 400, 'ste' => '无数据'));
		}
	} 

	// 搜索产品
	public function search() {
		$name = $this->general->get('name');
		$a_data = $this->product_model->search($name);
		if ($a_data) {
			echo json_encode(array('code' => 200, 'data' => $a_data));
		} else {
			echo json_encode(array('code' => 400));
		}
	}
}?>