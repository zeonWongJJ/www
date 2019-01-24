<?php
defined('BASEPATH') OR exit('禁止访问！');
class Bill_ctrl extends TW_Controller {
	
	public function __construct() {
		parent :: __construct();
		$this->load->model('bill_model');
		$this->load->model('login_model');
		$this->prefix = $this->db->get_prefix();
	}

	//结算页面
	public function bill(){
		$this->login_model->login();
		//查询收货地址
		$a_data['name'] =  $this->db->from('address as a')
                            		->join('member', ['a.member_id' => $this->prefix.'member.member_id'])
									->get('', ['a.member_id' => $_SESSION['user_id'], 'a.is_default' => 1], ['a.address_id', 'a.mob_phone', 'a.member_id', 'a.address', 'a.is_default', 'a.true_name', 'a.area_info', $this->prefix.'member.member_points', $this->prefix.'member.available_predeposit']);
		//查询全部收货地址
		$a_data['address'] =  $this->db->get('address', ['member_id' => $_SESSION['user_id']], ['address_id', 'mob_phone', 'member_id', 'address', 'is_default', 'true_name', 'area_info']);
		$a_data['member'] = $this->db->from("area")->where(['area_deep'=>'1'])->get();

		//获取POST数据将其加入订单
		$a_cart = $this->general->post();
		//订单输出商品数据
		if(! empty($a_cart)){
			$a_data['bill'] = $this->bill_model->bill();
			$this->view->display('member/bill', $a_data);
		}else{
			$this->error->show_error('你没有选择商品');
		}
	}
}
