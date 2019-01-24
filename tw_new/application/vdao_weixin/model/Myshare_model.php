<?php
class Myshare_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

	// 收入数据
	public function myshare($user, $i_time) {
		$a_where = "`share_userid` = '$user'";
		if (! empty($i_time)) {
			if ($i_time == 1) {
				$a = mktime(0,0,0,date('m'),date('d'),date('Y'));
				$a_where .= ($a_where ? ' AND ' : '') . "`time_create` >= '$a'";
			} else if ($i_time == 2) {
				$a = mktime(0,0,0,date('m'),date('d')-1,date('Y'));
				$b = mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
				$a_where .= ($a_where ? ' AND ' : '') . "`time_create` >= '$a' AND `time_create` <= '$b'";
			} else {
				$a = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
				$b = mktime(0,0,0,date('m'),date('d')-7,date('Y'));
				$a_where .= ($a_where ? ' AND ' : '') . "`time_create` >= '$b' AND `time_create` <= '$a'";
			}
		} else {
			$a = mktime(0,0,0,date('m'),date('d'),date('Y'));
			$a_where .= ($a_where ? ' AND ' : '') . "`time_create` >= $a";
		}
		$a_order = $this->db->limit(1,999999999)->get('order', $a_where);
		$a_pro = 0;
		$moner = 0;
		$moner1 = 0;
		$moner2 = 0;
		foreach ($a_order as $key => $value) {
			$a_pro += $value['order_price'];
			if ($value['order_state'] == 30) {
				$moner += $value['order_price'];
			}
			if ($value['order_state'] == 10) {
				$moner1 += $value['order_price'];
			}
			if ($value['order_state'] == 80) {
				$moner2 += $value['order_price'];
			}
		}
		// 收入
		$a_or['mone'] = $moner + $moner1 + $moner2;
		//笔数
		$a_or['oute'] = $this->db->get_total('order', $a_where);
		//评价数
		$a_or['oune'] = $this->db->where($a_where ." AND `evaluation_state` > '0'")->get_total('order');
		// 笔单价
		if ($a_or['oute'] == 0) {
			$a_or['proe'] = 0;
		} else {
			$a_or['proe'] = sprintf("%.2f", $a_pro / $a_or['oute']);			
		}
		return $a_or;
	}
}?>