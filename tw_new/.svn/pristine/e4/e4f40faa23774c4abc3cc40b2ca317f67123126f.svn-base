<?php
defined('BASEPATH') OR exit('禁止访问！');
class Goods_ctrl extends TW_Controller {
	
	public function __construct() {
		parent :: __construct();
		$this->load->model('ht_goods_model');
		if(!$_SESSION['user_id']){
			$this->view->display('login');
			die;
		}
	}

	// 商品列表
	public function goods(){
		$a_data = $this->ht_goods_model->goods();
		$this->view->display('goods', $a_data);
	}

	// 商品列表
	public function sold_out(){
		$a_data = $this->ht_goods_model->sold_out();
		$this->view->display('sold_out', $a_data);
	}

	// 修改商品列表
	public function update_goods(){
		$goods_id = $this->router->get(1);
		$add_goods = $this->general->post();

		if (! empty($add_goods)){
			$this->ht_goods_model->update_goods($goods_id);
		}

		if (! empty($goods_id)){
			// 取出下拉框的值
			$a_data['goods']	= $this->ht_goods_model->update_goods_list($goods_id);
			$a_data['list'] 	= $this->ht_goods_model->update_list($a_data['goods']);
			$this->view->display('goods_update', $a_data);
		} else {
			$this->error->show_error('非法访问',$this->router->url('goods'));
		}
	}

	// 商品列表
	public function goods_list(){
		$goods_id = $this->router->get(1);

		if (! empty($goods_id)){
			// 取出下拉框的值
			$a_data['goods']	= $this->ht_goods_model->update_goods_list($goods_id);
			$a_data['list'] 	= $this->ht_goods_model->update_list($a_data['goods']);
			$this->view->display('goods_list', $a_data);
		} else {
			$this->error->show_error('非法访问',$this->router->url('goods'));
		}
	}

	// 添加商品列表
	public function add_goods(){
		$a_data = $this->ht_goods_model->add_goods_list();
		$add_goods = $this->general->post();
		if(! empty($add_goods)){
			$this->ht_goods_model->add_goods();
		}
		$this->view->display('goods_add',$a_data);
	}

	//分类联动数据
	public function classify(){
		$pid = $this->general->post('classify');
		$a_res = $this->ht_goods_model->classify($pid);
		echo json_encode($a_res);die;
	}


	public function area(){
		$pid = $this->general->post('area');
		$a_res = $this->ht_goods_model->area($pid);
		echo json_encode($a_res);die;
	}

	// 删除商品
	public function del_goods() {
		$goods_id = $this->general->post('goods');
		$del_goods = $this->general->post('goods_id');
		if(! empty($del_goods)){
			$del_goods = explode(',', $del_goods);
			// echo $del_goods;die;
			echo $this->ht_goods_model->del_goods($del_goods);
		}

		if(! empty($goods_id)){
			$del_goods = $goods_id;
			echo $this->ht_goods_model->del_goods($del_goods);	
		}
		
	}

	// 下架商品
	public function sold_off() {
		$sold_off = $this->general->post('goods_id');
		if(! empty($sold_off)){
			$sold_off = explode(',', $sold_off);
			echo $this->ht_goods_model->sold_off($sold_off);
		}
	}

	// 上架商品
	public function new_stock() {
		$new_stock = $this->general->post('goods_id');
		if(! empty($new_stock)){
			$new_stock = explode(',', $new_stock);
			echo $this->ht_goods_model->new_stock($new_stock);
		}	
	}
}
