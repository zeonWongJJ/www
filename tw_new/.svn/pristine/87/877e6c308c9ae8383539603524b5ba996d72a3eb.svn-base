<?php
defined('BASEPATH') or exit('禁止访问！');

/**
 * 本类负责把订单，分发给不同的配送公司
 */
class Distribute_model extends TW_Model {
	
	public function __construct() {
		parent :: __construct();
	}
	
	// 分发
	public function distribute(&$a_post) {
		$this->load->model('order_model');
		if ( ! $this->order_model->save($a_post) ) {
			return ['status_code' => '10001', 'msg' => '订单保存失败！'];
		}
		$b_status = false;
		$a_company = [];
		$a_name    = [];
		foreach ($this->_a_company as $s_code => $s_name) {
			$s_model_name = $s_code . '_model';
			$this->load->model($s_model_name);
			
			if ($this->$s_model_name->add($a_post)) {
				// 只要有一家配送公司提交订单成功，就视为提交订单成功
				$b_status = true;
				// 保存成功发布订单的快递公司
				$a_company[$s_code] = $s_name;
				$a_name['name']    = $s_code;
			} else {
				$a_error = $this->$s_model_name->get_result();
				$s_error .= json_encode($a_error);
			}
		}
		if ($b_status) {
			$a_data = [
				'company_success' => json_encode($a_company),
				'trade_status' => 10,
				'company_receive' => $a_name['name'],
			];
			$a_where = ['id_trade' => $a_post['order_id']];
			$this->db->update('order', $a_data, $a_where);
			return ['status_code' => '10000', 'msg' => '订单提交成功！'];
		}
		// 发布失败，把状态更新为0
		$this->order_model->update_status($a_post['order_id'], 0);
		
		return ['status_code' => '10002', 'msg' => '订单提交到第三方配送失败！', 'error' => $s_error];
	}
}
?>