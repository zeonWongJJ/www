<?php
defined('BASEPATH') OR exit('禁止访问！');

/**
 * @property \model\IndexModel index_model
 * @property \model\CartModel cart_model
 */
class Shop_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();

		//实例化模型
//		$this->load->model('index_model');
		$this->index_model = \utils\Factory::getFactory('index');
	}

	public function shopping(){
		if(isset($_SESSION['user_id']) && ! empty($_SESSION['user_id'])){

			//首页导航分类
			$a_res = $this->index_model->category();

			// 组装数组中多出来的那个位置
			$a_data['cate'] = $this->index_model->arr($a_res);

//			$this->load->model('cart_model');
            $this->cart_model = \utils\Factory::getFactory('cart');
			//获取推荐商品
			$a_data['commend'] = $this->cart_model->commend();

			//获取到删除购物车的第一个删除
			$del = $this->router->get(1);

			if(! empty($del)){
				$a_data['cart'] = $this->cart_model->del($del);
			}

			//判断是否有订单号传入
			$repurchase = $this->general->post('repurchase');
			if(! empty($repurchase)){
				$a_data['repurchase'] = $this->cart_model->repurchase($repurchase);
			}

			//查询购物车页面输出的数据
			$a_data['cart'] = $this->cart_model->cart();

			$this->view->display('shopping', $a_data);
		} else {
			$this->error->show_error('请先登录！', get_config_item('user_domain') . '/login');
		}

	}
}
