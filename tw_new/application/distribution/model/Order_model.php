<?php
defined('BASEPATH') or exit('禁止访问！');

/**
 * 本类负责订单处理
 */
class Order_model extends TW_Model {
	
	// 订单当前状态
	private $_status;
	
	public function __construct() {
		parent :: __construct();
	}
	
	// 保存订单数据
	public function save(&$a_post) {
		$a_data = [
			'trade_param' => json_encode($a_post),
			'trade_time' => $_SERVER['REQUEST_TIME'],
			'trade_status' => 0
		];
		// 检查订单是否存在，存在即更新数据，不存在则创建新数据
		$a_where = ['id_trade' => $a_post['order_id']];
		$a_result = $this->db->get_row('order', $a_where);
		if (isset($a_result['trade_status'])) {
			// 只有订单状态是发布失败的时候，才能重新提交
			if ($a_result['trade_status'] == 0) {
				if ($this->db->update('order', $a_data, $a_where)) {
					return true;
				}
			}	
		} else {
			$a_data['id_trade'] = $a_post['order_id'];
			if ($this->db->insert('order', $a_data)) {
				return true;
			}
		}
		return false;
	}
	
	// 更新状态
	public function update_status($i_id_order, $s_status, $s_company = '') {
		// 避免重复执行更新相同状态
		if ($s_status == $this->_status) {
			return true;
		}
		$a_data = [
			'trade_status' => $s_status,
			'time_status_update' => $_SERVER['REQUEST_TIME']
		];
		if ( ! empty($s_company) ) {
			$a_data['company_receive'] = $s_company;
		}
		$a_update = [
			'id_trade' => $i_id_order
		];
		
		$this->db->group_start();
		
		// 记录第一个接单的公司代码，防止多个配送公司同时接单时，反复更新接单的配送公司代码
		$this->db->where_or(['company_receive' => '']);
		// 同一数组出现相同键名会被覆盖，所以分成两次调用
		$this->db->where_or(['company_receive' => $s_company]);
		
		$this->db->group_end();
		
		$a_result = $this->db->update('order', $a_data, $a_update);
		// 记录订单当前状态
		if ($a_result) {
			$this->_status = $s_status;
		}
		return $a_result;
	}
	
	// 订单查询
	public function query($a_post) { 
		$a_where = [
			'id_trade' => $a_post['order_id']
		];
		$a_result = $this->db->get_row('order', $a_where, 'id_trade, trade_status, company_receive, distribution_dada');
		if (empty($a_result)) {
			return array_merge($a_post, ['status_code' => '20001', 'msg' => '订单不存在！']);
		}
		$s_model_name = $a_result['company_receive'] . '_model';
		$this->load->model($s_model_name);
		$this->$s_model_name->update_distribution_data($a_post['order_id']);
		$a_data = [
			'order_id' => $a_result['id_trade'],
			'status' => $a_result['trade_status'],
			'status_code' => '20000',
			'msg' => '数据成功返回！'
		];
		if ( ! empty($a_result['company_receive']) ) {
			if ( ! empty($a_result['distribution_dada']) ) {
				// 组装配送信息
				$a_result = $this->$s_model_name->distribution_dada($a_post, $a_result);
				$a_data = array_merge($a_data, $a_result);
			}
		}
		
		return $a_data;
	}
	
	// 已有人接单，把其他平台的订单取消，避免重复接单
	public function cancel_other($i_id_order) {
		$a_order = $this->db->get_row('order', ['id_trade' => $i_id_order]);
		$a_company = json_decode($a_order['company_success'], true);
		unset($a_company[$a_order['company_receive']]);
		foreach ($a_company as $s_code => $s_name) {
			$s_model_name = $s_code . '_model';
			$this->load->model($s_model_name);
			$this->$s_model_name->cancel($i_id_order);
		}
	}
	
	// 更新订单表的配送信息
	public function update_distribution_dada($i_id_order, $s_distribution_dada, $s_company = '') {
		$a_data = ['distribution_dada' => $s_distribution_dada];
		$a_where = [
			'id_trade' => $i_id_order
		];
		if ( ! empty($s_company) ) {
			$a_where['company_receive'] = $s_company;
		}
		if ($this->db->update('order', $a_data, $a_where)) {
			return true;
		} else {
			$this->log->record("有人接单，更新配送信息失败！" . print_r($this->db->get_error(), true), 11);
		}
		return false;
	}
	
	// 更新成功发布订单的配送公司 $s_type参数'REMOVE'表示删除操作，非'REMOVE'都是添加或更新操作
	public function update_company_success($i_id_order, $s_company, $s_type = 'REMOVE', $s_company_success = '') {
		if (empty($s_company_success)) {
			$a_result = $this->db->get_row('order', ['id_trade' => $i_id_order]);
			if ( ! isset($a_result['company_success']) ) {
				return false;
			}
			$s_company_success = $a_result['company_success'];
		}
		$a_company = json_decode($s_company_success, true);
		if ($s_type == 'REMOVE') {
			unset($a_company[$s_company]);
		} else {
			$a_company[$s_company] = $this->_a_company[$s_company];
		}
		$a_data = ['company_success' => json_encode($a_company)];
		$a_where = ['id_trade' => $i_id_order];
		if ($this->db->update('order', $a_data, $a_where)) {
			return true;
		}
		
		$this->log->record("更新订单的成功配送公司字段失败！订单号：{$i_id_order}，错误信息：" . $this->db->get_error(), 11);
		return false;
	}
	
	// 取消订单
	public function cancel($a_post) {
		$a_where = [
			'id_trade' => $a_post['order_id']
		];
		$a_result = $this->db->get_row('order', $a_where);
		
		if (empty($a_result)) {
			return ['status_code' => '30001', 'msg' => '订单不存在！'];
		}
		if ($a_result['trade_status'] == 0) {
			return ['status_code' => '30002', 'msg' => '订单未提交成功，不需要取消！'];
		} elseif ($a_result['trade_status'] == 50) {
			return ['status_code' => '30003', 'msg' => '订单已经取消，不需要重复取消！'];
		} elseif ($a_result['trade_status'] >= 30) {
			return ['status_code' => '30004', 'msg' => '订单已经开始配送！'];
		} else {
			$a_company = json_decode($a_result['company_success'], true);
			if ( is_array($a_company) && ! empty($a_company) ) {
				$a_company_success = [];
				foreach ($a_company as $s_code => $s_name) {
					$s_model_name = $s_code . '_model';
					$this->load->model($s_model_name);
					$b_status = $this->$s_model_name->cancel($a_post['order_id'], $a_post['reason_id']);
					// 如果取消成功，则记录公司代码，失败则记录到错误表
					if ($b_status) {
						$a_company_success[] = $s_code;
					} else {
						// 在配送公司的模型中会记录失败的具体信息，这里就不重复记录了
						//$this->log->record("取消“{$s_code}”的订单失败！订单号：{$a_post['order_id']}", 11);
					}
				}
				// 把已取消订单成功的公司删除记录
				if (count($a_company_success)) {
					foreach ($a_company as $s_code => $s_name) {
						if (in_array($s_code, $a_company_success)) {
							unset($a_company[$s_code]);
						}
					}
					$a_update = ['company_success' => json_encode($a_company)];
					// 如果数组变空，说明全部取消成功，这里就需要把订单状态更改为已取消
					if ( ! count($a_company) ) {
						$a_update['trade_status'] = 50;
					}
					if (! $this->db->update('order', $a_update, $a_where) ) {
						$this->log->record("更新订单的成功配送公司字段失败！订单号：{$a_post['order_id']}，公司代码：" . implode(',', $a_company_success), 11);
					}
				}
				// 如果还有公司代码存在此数组，说明有的配送公司取消订单失败
				if (count($a_company)) {
					return ['status_code' => '30005', 'msg' => '订单取消失败！失败的公司：' . implode(',', $a_company)];
				}
				return ['status_code' => '30000', 'msg' => '订单取消成功！'];
			}
			return ['status_code' => '30006', 'msg' => '此订单当前没有在第三方配送平台提交配送订单！'];
		}
	}
	
	// 获取一条订单信息
	public function get_row($i_id_order) {
		return $this->db->get_row('order', ['id_trade' => $i_id_order]);
	}
}
?>