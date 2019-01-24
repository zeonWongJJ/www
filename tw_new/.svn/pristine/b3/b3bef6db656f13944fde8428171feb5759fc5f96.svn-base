<?php
defined('BASEPATH') or exit('禁止访问！');

/**
 * 本类负责Notify回调数据表相关处理
 */
class Notify_model extends TW_Model {
	
	public function __construct() {
		parent :: __construct();
	}
	
	// 获取一条回调数据
	public function get_row($i_id_order, $s_company) {
		$a_where = [
			'id_trade' => $i_id_order,
			'company_code' => $s_company
		];
		$a_order = ['notify_time' => 'DESC'];
		return $this->db->get_row('notify', $a_where, NULL, $a_order);
	}
	
	// 保存一条回调数据
	public function save($a_notify_data, $s_company, $s_status) {
		$a_insert = [
			'id_trade' => $a_notify_data['order_id'],
			'company_code' => $s_company,
			'notify_time' => $a_notify_data['update_time'],
			// 订单状态(待接单＝1 待取货＝2 配送中＝3 已完成＝4 已取消＝5 已过期＝7 指派单=8 妥投异常之物品返回中=9 妥投异常之物品返回完成=10 创建达达运单失败=1000 可参考下面的状态说明）
			// 已取消：包括配送员取消、商户取消、客服取消、系统取消（发单后，期望取货时间后推30分钟无人接单，系统取消订单）
			// 已过期：待接单、待取货、配送中的订单，3天后自动过期
			// 妥投异常：配送员在收货地，无法正常送到用户手中（包括用户电话打不通、客户暂时不方便收件、客户拒收、货物有问题等等）
			'notify_status' => $s_status,
			'notify_data' => json_encode($a_notify_data),
			'time' => $_SERVER['REQUEST_TIME']
		];
		if ($this->db->insert('notify', $a_insert)) {
			return true;
		} else {
			return false;
		}
	}
}
?>