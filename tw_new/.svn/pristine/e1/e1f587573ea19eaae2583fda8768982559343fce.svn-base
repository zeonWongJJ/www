<?php
defined('BASEPATH') or exit('禁止访问！');
class Sousou_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('sousou_model');
	}

/************************************* 前台搜索 *************************************/

	public function sousou_search() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收关键词
			$keywords = trim($this->general->post('keywords'));
			// 根据关键词获取门店信息
			$a_data['store'] = $this->sousou_model->get_store_search($keywords);
			// 根据关键词获取产品信息
			$a_data['product'] = $this->sousou_model->get_product_search($keywords);
			// 关键词
			$a_data['keywords'] = $keywords;
			$this->view->display('sousou_search', $a_data);
		}
	}

/************************************************************************************/

}

?>