<?php
defined('BASEPATH') OR exit('禁止访问！');

/**
 * @property \model\SearchModel search_model
 * @property \model\IndexModel index_model
 */
class Search_ctrl extends TW_Controller{
	public function __construct(){
		parent :: __construct();
		//实例化商品模型
//		$this->load->model('search_model');
		$this->search_model = \utils\Factory::getFactory('search');

	}

	public function search(){
		//实例化分类模型
        $this->index_model = \utils\Factory::getFactory('index');
//		$this->load->model('index_model');

		//导航分类
		$a_res = $this->index_model->category();

		// 组装数组中多出来的那个位置
		$a_data['cate'] = $this->index_model->arr($a_res);

		//搜索页面的分类展示
		$a_data['cate_id'] = $this->router->get(2);

		//搜索页面分类
		$a_data['search_cate'] = $this->search_model->category($a_data['cate_id']);

		//搜索暂时的列表页面
		$a_data['search'] = $this->search_model->search($a_data['cate_id']);

		//拼装URL地址
		$a_data['url'] = [
			'keyword' 	 => $a_data['search']['keyword'],
			'cate_id' 	 => $a_data['cate_id'],
			'order'		 => $a_data['search']['order'],
			'price_min'	 => $a_data['search']['price_min'],
			'price_max'	 => $a_data['search']['price_max'],
			'autotrophy' => $a_data['search']['autotrophy'],
			'gift'		 => $a_data['search']['gift'],
			'promotion'	 => $a_data['search']['promotion'],
			'integral'	 =>	$a_data['search']['integral'],
			'third'		 => $a_data['search']['third'],
			'brand'		 => $a_data['search']['brand'],
			'type'		 => $a_data['search']['type'],
			'store'		 => $a_data['search']['store']
		];

		$a_data['time'] = $_SERVER['REQUEST_TIME'];

		//浏览历史记录
		// $this->search_model->displayHistory();
		$this->view->display('search', $a_data);
	}

	public function collect(){
		//传入商品ID
		$s_cellgood = $this->general->post('cellgood');

		if(! empty($s_cellgood)){
			if(! empty($_SESSION['user_id'])){
				$s_data = $this->search_model->cellgood($s_cellgood);
				echo $s_data;die;
			} else {
				echo '您没有登录请先登录';die;
			}
		}


	}

	//加入购物车
	public function goodshop(){
		//传入商品ID
		$s_goodshop = $this->general->post('goodshop');//$_GET['goodshop'];

		//传入商品数量,如果商品数量为空设置商品数量为1;
		$s_goodsnum = $this->general->post('goodsnum');//$_GET['goodsnum'];

		if( empty($s_goodsnum)){
			$s_goodsnum = 1;
		}

		if(! empty($s_goodshop)){
			if(! empty($_SESSION['user_id'])){
				$s_data = $this->search_model->goodshop($s_goodshop, $s_goodsnum);
				echo $s_data;
				die;
			} else {
				echo '0';
				die;
			}
		}
		echo 'aa';
	}
}
