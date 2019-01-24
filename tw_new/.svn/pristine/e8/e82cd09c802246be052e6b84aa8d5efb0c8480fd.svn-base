<?php
/**
 * Created by PhpStorm.
 * User: 7du-28
 * Date: 2018/4/25
 * Time: 16:19
 */

class ApiConsumerUser_ctrl extends TW_Controller
{

    public function __construct() {
        parent :: __construct();
        $this->load->model('apiToken_model');
        $is_allow=$this->apiToken_model->is_allow();
        if(!$is_allow){
            echo json_encode($this->apiToken_model->token_no_allow());
            exit;
        }
        $this->load->model('apiConsumerUser_model');
    }
    //所有用户分页查询
    public function user_list(){
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $pageSize = trim($this->general->post('pageSize'));
            $pageNum = trim($this->general->post('pageNum'));
            $keywords = $this->general->post('keywords');
            /*$pageSize=$this->router->get(1);
            $pageNum =$this->router->get(2);*/
            $a_data = $this->apiConsumerUser_model->user_list($pageNum,$pageSize,$keywords);
            $result = array(
                'code' => 200,
                'msg' => "",
                'data' => $a_data,
            );
            echo json_encode($result);
        }
    }
    //移动店主搜索
    public function shopkeeper_name_list(){
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $pageSize = trim($this->general->post('pageSize'));
            $pageNum = trim($this->general->post('pageNum'));
            $keywords = $this->general->post('keywords');
            $is_shopman = $this->general->post('shopkeeperState');
            /*$pageSize=$this->router->get(1);
            $pageNum =$this->router->get(2);*/
            $a_data = $this->apiConsumerUser_model->shopkeeper_name_list($pageNum,$pageSize,$keywords,$is_shopman);
            $result = array(
                'code' => 200,
                'msg' => "",
                'data' => $a_data,
            );
            echo json_encode($result);
        }
    }

    //用户详情页-列表传过去 此接口不用写了
}