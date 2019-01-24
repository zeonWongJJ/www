<?php
class Schedule_model extends TW_Model {
	public function __construct() {
		parent :: __construct();
	}

	/**
	*排班查询
	*/
	public function working_schedule($id,$demand_id) {
		switch ($id) {
			case '1':
			echo 1111;
				$a_demand = $this->db->get('demand', ['selected_member_id' => $demand_id], ['bid_time', 'lnternet']);
				return $a_demand;
				break;
			case '2':
			echo 2222;
				$a_demand = $this->db->get('demand', ['publisher_id' => $demand_id], ['bid_time', 'lnternet']);
				return $a_demand;
				break;
		}
	}
}