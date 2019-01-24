<?php

class Service_model extends TW_Model {
	public function __construct() {
		parent :: __construct();
	}

	//查询当前登录用户的信息
	public function get_userinfo() {
		//获取当前用户的id
		$id = $_SESSION['user_id'];
		$a_where = [
			'id =' => $id
		];
		//用户名，积分，服务者称号，经验值
		$s_field = 'username, integral, service_appellation,experience';
		$a_data = $this->db->get_row('member', $a_where, $s_field);
		return $a_data;
	}

	//我的排班表(查询需求表中选中者为当前用户且状态为服务中的数据)
	public function get_demand() {
		$a_where = [
			'state =' => 3,
			'selected_member_id' => $_SESSION['user_id']
		];
		$s_field = 'title';//需求标题
		$a_data = $this->db->get('demand', $a_where, $s_field);
		return $a_data;
	}

	//查询我的竞标中的订单
	public function get_mybid() {
		$a_where = [
			'new_bid.bidder_member_id =' => $_SESSION['user_id']
		];
		$a_data = $this->db->from('demand')
						   ->join('bid', ['new_bid.demand_id'=>'new_demand.demand_id'])
						   ->get('', $a_where);
		return $a_data;
	}

	//查询我的待确定的订单
	public function get_toconfirmed() {
		$a_where = [
			'selected_member_id =' => $_SESSION['user_id'],
			'state' => 2
		];
		$a_data = $this->db->get('demand', $a_where);
		return $a_data;
	}

	//查询订单(需求)详情
	public function get_toconfirmed_detail($id) {
		$a_where = [
			'demand_id' => $id
		];
		$a_data = $this->db->get_row('demand', $a_where);
		return $a_data;
	}

	//确认订单操作(将需求状态改为服务中)
	public function update_confirmed($id) {
		$a_where = [
			'demand_id' => $id
		];
		$a_data = [
			'state' => 3 //状态为3表示服务中
		];
		$i_result = $this->db->update('demand', $a_data, $a_where);
		if ($i_result) {
			return $i_result;
		} else {
			return false;
		}
	}

	//放弃订单操作
	public function update_cancel($id) {
		$a_where = [
			'demand_id' => $id
		];
		$a_data = [
			'state' => 1, //状态为1表示正在竞标
			'selected_member_id' => '' //将需要表中的选中的服务者id清空
		];
		$i_result = $this->db->update('demand', $a_data, $a_where);
		if ($i_result) {
			return $i_result;
		}else{
			return false;
		}
	}

	//查询正在服务中的订单
	public function get_inservice() {
		$a_where = [
			'selected_member_id =' => $_SESSION['user_id'],
			'state' => 3
		];
		$a_data = $this->db->get('demand', $a_where);
		return $a_data;
	}

	//确认服务完成
	public function update_complete($id) {
		$a_where = [
			'demand_id' => $id
		];
		$a_data = [
			'state' => 4, //状态为4表示待评价
		];
		$i_result = $this->db->update('demand', $a_data, $a_where);
		if ($i_result) {
			return $i_result;
		}else{
			return false;
		}
	}

	//服务者中心之增加服务费用
	public function update_addmoney($id, $add_money, $add_why) {
		//选取出中标的投标id,再根据中标id将数据写入到对应的投标数据上
		$a_where = [
			'demand_id' => $id
		];
		$a_data = $this->db->get_row('demand', $a_where);
		$selected_bid = $a_data['selected_bid'];//中标的竞标id
		//将数据写入该选上的竞标id上
		$a_where = [
			'bid' => $selected_bid
		];
		$a_data = [
			'add_money' => $add_money, //要增加的服务费用
			'add_why' => $add_why //增加费用的原因
		];
		$i_result = $this->db->update('bid', $a_data, $a_where);
		if ($i_result) {
			return $i_result;
		} else {
			return false;
		}
	}

	//服务者中心之获取待评价的订单
	public function get_tocomment() {
		$a_where = [
			'selected_member_id' => $_SESSION['user_id'],
			'state' => 4 //状态为4表示待评价
		];
		$a_data = $this->db->get('demand', $a_where);
		return $a_data;
	}

	//服务者中心之获取保修中的订单
	public function get_guarantee() {
		$a_where = [
			'selected_member_id' => $_SESSION['user_id'],
			'state' => 5 //状态为5表示保修中
		];
		$a_data = $this->db->get('demand', $a_where);
		return $a_data;
	}

	//服务者中心之获取已完成的订单
	public function get_end() {
		$a_where = [
			'selected_member_id' => $_SESSION['user_id'],
			'state' => 6 //状态为6表示已完成
		];
		$a_data = $this->db->get('demand', $a_where);
		return $a_data;
	}


}

?>