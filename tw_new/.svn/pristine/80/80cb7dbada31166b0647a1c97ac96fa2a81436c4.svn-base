<?php

class ApiOrder_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
        $this->load->model('apiToken_model');
        $is_allow=$this->apiToken_model->is_allow();
        if(!$is_allow){
            echo json_encode($this->apiToken_model->token_no_allow());
            exit;
        }
		$this->load->model('apiOrder_model');
	}

/************************************* 店铺餐饮订单列表 *************************************/

	public function store_lunch_order_list() {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $pageSize = trim($this->general->post('pageSize'));
            $pageNum = trim($this->general->post('pageNum'));
            $storeId = $this->general->post('storeId');
            $orderState = $this->general->post('orderState');
            /*$pageSize=$this->router->get(1);
            $pageNum =$this->router->get(2);
            $storeId =$this->router->get(3);
            $orderState =$this->router->get(4);*/
            $a_data['order'] = $this->apiOrder_model->store_lunch_order_list($storeId,$orderState,$pageNum,$pageSize);
            $a_data['store'] = $this->apiOrder_model->get_store_one($storeId);
            if (!empty($a_data['order'])) {
                foreach ($a_data['order'] as $value){
                    $order_arr[] = $value['order_id'];
                    //$a_order_goods_data = array();
                    $a_order_goods_data=$this->apiOrder_model->get_order_goods_list($value['order_id']);
                    $value['order_goods'] = $a_order_goods_data;
                    $new_data[] = $value;
                }
                $a_data['order'] = $new_data;
            }
            $result = array(
                'code' => 200,
                'msg' => "",
                'data' => $a_data,
            );
            echo json_encode($result);
        }
	}

    public function lunch_order_detail() {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $orderId = trim($this->general->post('orderId'));
            $a_data = $this->apiOrder_model->lunch_order_detail($orderId);
            $a_order_goods_data=$this->apiOrder_model->get_order_goods_list($a_data['order_id']);
            $a_data['order_goods'] = $a_order_goods_data;
            $result = array(
                'code' => 200,
                'msg' => "",
                'data' => $a_data,
            );
            echo json_encode($result);
        }
    }


    /************************************* 店铺会议或座位订单列表 *************************************/

    public function store_meeting_seat_order_list() {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $pageSize = trim($this->general->post('pageSize'));
            $pageNum = trim($this->general->post('pageNum'));
            $storeId = $this->general->post('storeId');
            $appointmentState = $this->general->post('appointmentState');
            $appointmentType = $this->general->post('appointmentType');
            if ($appointmentState == '') {
                $appointmentState = 'default';
            }
            /*$pageSize=$this->router->get(1);
            $pageNum =$this->router->get(2);*/
            $a_data['order'] = $this->apiOrder_model->store_meeting_seat_order_list($storeId,$appointmentState,$appointmentType,$pageNum,$pageSize);
            $a_data['store'] = $this->apiOrder_model->get_store_one($storeId);
            $result = array(
                'code' => 200,
                'msg' => "",
                'data' => $a_data,
            );
            echo json_encode($result);
        }
    }

    public function meeting_seat_order_detail() {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $appointmentId = trim($this->general->post('appointmentId'));
            $a_data = $this->apiOrder_model->meeting_seat_order_detail($appointmentId);
            $room_data=$this->apiOrder_model->get_room_row_by_room_id($a_data['room_id']);
            if($room_data){
                $a_data['room']=$room_data;
            }
            $result = array(
                'code' => 200,
                'msg' => "",
                'data' => $a_data,
            );
            echo json_encode($result);
        }
    }
}

?>