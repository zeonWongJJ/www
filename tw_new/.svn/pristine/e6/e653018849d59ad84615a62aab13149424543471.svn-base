<?php
defined('BASEPATH') OR exit('禁止访问！');

/**
 * @property \model\IndexModel index_model
 * @property \model\BillModel bill_model
 */
class Bill_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();

		//实例化商品模型
//		$this->load->model('index_model');
//		$this->load->model('bill_model');

		$this->index_model = \utils\Factory::getFactory('index');
		$this->bill_model = \utils\Factory::getFactory('bill');
	}

	//结算页面
	public function bill(){
		if(isset($_SESSION['user_id']) && ! empty($_SESSION['user_id'])){
			//首页导航分类
			$a_res = $this->index_model->category();
			// 组装数组中多出来的那个位置
			$a_data['cate'] = $this->index_model->arr($a_res);

			//收货人地址
			$a_data['address'] = $this->bill_model->address();

			// 查询出用户信息
			$a_data['member'] = $this->bill_model->member();

			//获取POST数据将其加入订单
			$a_cart = $this->general->post();

			//获取顶级地区
			$a_data['area'] = $this->bill_model->area();

			//订单输出商品数据
			if(! empty($a_cart)){
				$a_data['bill'] = $this->bill_model->bill();
				$this->view->display('bill', $a_data);
			}else{
				$this->error->show_error('你没有选择商品','shop');
			}
		}else{
			$this->error->show_error('请先登录！', get_config_item('user_domain') . '/login');
		}

	}

	// 结算页面修改用户默认地址
	public function billaddress(){
		$s_address = $this->general->post('address');
		if( ! empty($s_address)){
			$a_data = $this->bill_model->upaddress($s_address);
			echo json_encode($a_data);die;;
		}
	}

	//三级联动获取地址
	public function area(){
		$s_area = $this->general->post('area');
		if(! empty($s_area)){
			$a_data = $this->bill_model->area($s_area);
			echo json_encode($a_data);die;;
		}
	}

	// 添加地址
	public function addarea(){
		if ($_SESSION['user_id']){
			$a_res = $this->bill_model->addarea();
			echo json_encode($a_res);die;
		} else {
			$this->error->show_error('请先登录！', get_config_item('user_domain') . '/login');
		}
	}

	// 删除地址
	public function del_address(){
		if($_SESSION['user_id']){
			$i_res = $this->bill_model->del_address();
			echo json_encode($i_res);die;
		} else{
			$this->error->show_error('请先登录！', get_config_item('user_domain') . '/login');
		}
	}

	// 修改地址一个地址
	public function update_address(){
		if($_SESSION['user_id']){
			$i_res = $this->bill_model->update_address();
			echo json_encode($i_res);die;
		} else{
			$this->error->show_error('请先登录！', get_config_item('user_domain') . '/login');
		}
	}

	// 修改数据库信息
	public function alter_address(){
		if($_SESSION['user_id']){
			$i_res = $this->bill_model->alter_address();
			echo json_encode($i_res);die;
		} else{
			$this->error->show_error('请先登录！', get_config_item('user_domain') . '/login');
		}
	}


}
