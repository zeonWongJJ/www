<?php
defined('BASEPATH') OR exit('禁止访问！');
header("Content-Type:text/html;charset=utf8");
date_default_timezone_set('PRC'); 
class Collection_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();	
		$this->load->model('login_model');
	}
	
	//我的收藏
	public function collection()	{
		//判断是否登录
		$this->login_model->login();
		
		//实例化index模型
		$this->load->model('collection_model');

		//获取所有评价信息
		$a_data = $this->collection_model->collection();

		//获取传过来的参数进行删除数据
		$s_pid = $this->router->get(1);
		if( ! empty($s_pid)){
			$this->collection_model->del($s_pid);
		}

		//获取传过来的参数进行删除数据
		$s_ptt = $this->router->get(2);
		if( ! empty($s_ptt)){
			$this->collection_model->cart($s_ptt);
		}

		//获取传过来的POST数据
		$s_coll = $this->general->post('fav');
		$s_coll = $this->security->xss_clean($s_coll);
		if( ! empty($s_coll)){
			$a_coll = explode(',', $s_coll);
			echo $this->collection_model->insert($a_coll);die;
		}
		//获取传过来的POST数据收藏
		$s_collection = $this->general->post('collection');
		$_SESSION['bbt_collection'] = $s_collection;
		if(! empty($s_collection)){
			$a_data = $this->collection_model->search($s_collection);
			if (empty($a_data)) {
				$a_data['id'] = 1;
			}
		}
		$this->view->display('collection', $a_data);
	}

	//多选加购物车
	public function gods() {
		$i_cart = $this->general->post('gods');
		$a = explode(',',$i_cart);
		foreach ($a as $key => $value) {
			$c = $this->db->get('cart', ['buyer_id' => $_SESSION['user_id'], 'goods_id' => $value]);
			if(empty($c)) {
				$select = ['store_id', 'store_name', 'goods_id', 'goods_name', 'goods_price', 'goods_image'];
				$a_nuan = $this->db->get('goods', ['goods_id' => $value], $select);	
				$a_insert = [
						'buyer_id' => $_SESSION['user_id'],
						'store_id' => $a_nuan[0]['store_id'],
						'store_name' => $a_nuan[0]['store_name'],
						'goods_id' => $a_nuan[0]['goods_id'],
						'goods_name' => $a_nuan[0]['goods_name'],
						'goods_price' => $a_nuan[0]['goods_price'],
						'goods_num' => 1,
						'goods_image' => $a_nuan[0]['goods_image']
					];
				$a_cart = $this->db->insert('cart', $a_insert);
				if( ! empty($a_cart)) {
					echo '99';
				}
			} else {
				$a_cart = $this->db->get('cart', ['buyer_id' => $_SESSION['user_id'], 'goods_id' => $value]);
				$count = $a_cart[0]['goods_num'];
				$i = 1;
				$count += $i;
				$a_cart = $this->db->update('cart', ['goods_num' => $count], ['buyer_id' => $_SESSION['user_id'], 'goods_id' => $value]);
				if( ! empty($a_cart)) {
					echo '99';
				}
			}
		}
	}
}
