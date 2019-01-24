<?php
/**
 * Created by PhpStorm.
 * User: 7du-28
 * Date: 2018/4/25
 * Time: 16:19
 */

class ApiMessage_ctrl extends TW_Controller
{

    public function __construct() {
        parent :: __construct();
        $this->load->model('apiToken_model');
        $is_allow=$this->apiToken_model->is_allow();
        if(!$is_allow){
            echo json_encode($this->apiToken_model->token_no_allow());
            exit;
        }
        $this->load->model('apiMessage_model');
    }


    public function message_count(){
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $a_data = $this->apiMessage_model->message_count();
            $result = array(
                'code' => 200,
                'msg' => "",
                'data' => $a_data,
            );
            echo json_encode($result);
        }
    }

    public function messages_show_list(){
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $pageSize = trim($this->general->post('pageSize'));
            $pageNum = trim($this->general->post('pageNum'));
            /*$pageSize=$this->router->get(1);
            $pageNum =$this->router->get(2);*/
            $a_data = $this->apiMessage_model->messages_show_list($pageNum,$pageSize);
            $result = array(
                'code' => 200,
                'msg' => "",
                'data' => $a_data,
            );
            echo json_encode($result);
        }
    }
}