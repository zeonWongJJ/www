<?php
defined('BASEPATH') OR exit('禁止访问！');
class Search_ctrl extends TW_Controller{
	public function __construct(){
		parent :: __construct();

		$this->load->model('login_model');
		//实例化商品模型
		$this->load->model('search_model');
		
	}

	//我的收藏
	public function collection(){ 

		//判断是否登录
		$this->login_model->login();

		//实例化index模型
		$this->load->model('collection_model');

		//获取所有收藏信息
		$a_data = $this->collection_model->collection();
		//获取传过来的参数进行删除数据
		$s_pid = $this->general->post('id');
		if( ! empty($s_pid)){
			$a_where = ['member_id' => $_SESSION['user_id'], 'fav_id' => $s_pid];
			$goods_id = $this->db->delete('favorites', $a_where);
			echo 1;
			die;
			
		}

		$this->view->display('member/collection', $a_data);
	}

	//加入购物车
	public function cart_list(){
		//传入商品ID
		$s_goodshop = $this->general->post('goodshop');

		//传入商品数量,如果商品数量为空设置商品数量为1;
		$s_goodsnum = $this->general->post('goodsnum');

		if( empty($s_goodsnum)){
			$s_goodsnum = 1;
		}

		if(! empty($s_goodshop)){
			if(! empty($_SESSION['user_id'])){
				$s_data = $this->search_model->goodshop($s_goodshop, $s_goodsnum);
				echo $s_data;
				die;
			} else {
				echo 3;
				die;
			}
		}
	}

}