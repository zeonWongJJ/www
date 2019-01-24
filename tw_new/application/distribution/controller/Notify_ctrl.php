<?php
defined('BASEPATH') OR exit('禁止访问！');

// 本控制器，负责接收回调数据

class Notify_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
	}
	
	// 达达配送通知
	public function dada() {
		//c1e77a8dd5895da0dc0875b0ab1d9de3
		/*$s_json_data = '{"order_status":2,"cancel_reason":"","update_time":1516004660,"cancel_from":0,"dm_id":666,"signature":"fba01848f7063a0fcf79b76e112658be","dm_name":"测试达达","order_id":"20180115880","client_id":"271445646904875","dm_mobile":"13546670420"}';
		$s_json_data = '{"order_status":3,"cancel_reason":"","update_time":1516004928,"cancel_from":0,"dm_id":666,"signature":"06a47ca8d553ea9929256a84cab25132","dm_name":"测试达达","order_id":"20180115880","client_id":"271445646904875","dm_mobile":"13546670420"}';
		$s_json_data = '{"order_status":4,"cancel_reason":"","update_time":1515739203,"cancel_from":0,"dm_id":666,"signature":"1c9771701e66a982b893bdc147100e09","dm_name":"测试达达","order_id":"20180111566","client_id":"","dm_mobile":"13546670420"}';
		$s_json_data = '{"order_status":5,"cancel_reason":"可选参数，取消原因说明","update_time":1515740400,"cancel_from":2,"dm_id":666,"signature":"967d843710a99623455ead5c2638b1cb","dm_name":"测试达达","order_id":"20180111566","client_id":"","dm_mobile":"13546670420"}';
		$s_json_data = '{"order_status":7,"cancel_reason":"","update_time":1515740522,"cancel_from":0,"dm_id":666,"signature":"c16a9285f5f2886c1e6056168bc95164","dm_name":"测试达达","order_id":"20180112832","client_id":"","dm_mobile":"13546670420"}';
		*/
		$s_json_data = file_get_contents('php://input');
		//file_put_contents('/data/www/tw/web/7dugo_pc/1.txt', $s_json_data, FILE_APPEND);
		$this->load->model('dada_model');
		$this->dada_model->notify($s_json_data);
	}
}
