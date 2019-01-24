<?php

class ApiStore_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
        $this->load->model('apiToken_model');
        $is_allow=$this->apiToken_model->is_allow();
        if(!$is_allow){
            echo json_encode($this->apiToken_model->token_no_allow());
            exit;
        }
		$this->load->model('apiStore_model');
	}

/************************************* 门店列表 *************************************/

	public function store_list() {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $pageSize = trim($this->general->post('pageSize'));
            $pageNum = trim($this->general->post('pageNum'));
            $keywords = trim($this->general->post('keywords'));

            /*$pageSize=$this->router->get(1);
            $pageNum =$this->router->get(2);*/
            $a_data = $this->apiStore_model->store_list($pageNum,$pageSize,$keywords);
            $a_data_new=[];
            foreach ($a_data as $value){
                $value['comment']=$this->apiStore_model->getStoreCommentByStoreId($value['store_id']);
                $a_data_new[]=$value;
            }
            $result = array(
                'code' => 200,
                'msg' => "",
                'data' => $a_data_new,
            );
            echo json_encode($result);
        }
	}



/************************************* 搜索门店 *************************************/

	public function store_search() {
		//接收要查询的关键词
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$keywords = trim($this->general->post('keywords'));
		} else {
			$keywords = urldecode($this->router->get(1));
		}
		$a_data = $this->store_model->get_store_search($keywords);
		$a_data['type'] = 9;
		$a_data['keywords'] = $keywords;
		$this->view->display('store_showlist', $a_data);
	}


}

?>