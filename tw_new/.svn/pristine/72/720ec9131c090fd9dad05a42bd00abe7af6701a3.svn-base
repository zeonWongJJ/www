<?php
defined('BASEPATH') OR exit('禁止访问！');
class Order_ctrl extends TW_Controller {
	
	public function __construct() {
		parent :: __construct();
		
		$this->load->model('Ht_Order_model');

		if(!$_SESSION['user_id']){
			$this->view->display('login');
			die;
		}
	}

	
	public function index(){
		$a_order_data['order_data']=$this->Ht_Order_model->order_details();
		$a_order_data['express']=$this->Ht_Order_model->express();
		$this->view->display('order',$a_order_data);
	}

    /**
     * [ajax 设置物流]
     * @param  [order_id]
     * @param  [express_num]
     * @param  [express_code]
     * @return [int] [0|1 成功与否]
     */
	public function set_express(){
	
		$post_data=$this->general->post();

		echo $this->Ht_Order_model->set_express($post_data);
	}

	public function order_details(){
		$order_id= $this->router->get(1);
		if($order_id){
		$order_data=$this->Ht_Order_model->order($order_id);
		$this->view->display('order_details',$order_data);
		}else{
		$this->error->show_error('非法访问','/');
		}
	}

}
