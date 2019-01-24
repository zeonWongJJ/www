<?php
class Competitive_model extends TW_Model {
	private $user_id;
    public function __construct() {
    	$this->userid = $_SESSION['user_id'];
    }
    /**
     * [投标人+1]
     * @param  [type]  [description]
     * $demand_id   需求的id
     */
    public function add_bidder_num($demand_id) {

    	$this->db->set('bidder_num', 'bidder_num + 1', false);
		$affect_row= $this->db->update('demand', NULL, ['demand_id' => $demand_id]);
    	return $affect_row;
    }
	/**
     * [查看投标人]
     * @param  [type]  [description]
     * $number  传需求人的id
     */
    public function number($number) {
    	$fields = 'name_user';
    	$table = 'demand as a';
    	$join_on = ['a.demand_id' => 'b.demand_id'];
    	$select = 'a.publisher_id, a.selected_member_id, b.demand_id, b.bidder_member_id, b.is_guarantee, b.amount';
    	$where = ['a.publisher_id' => $this->userid, 'a.demand_id' => $number];
    	//查出所有数据
    	$number = $this->db->from($table)
			                   ->join('bid as b',$join_on,INNER)
			                   ->where($where)
			                   ->select($select)
			                   ->get();
    	return $number;
    }
    /**
     * [竞标人选择]
     * @param  [type]  [description]
     * $member_id 需求id
     * $bidder_member_id 竞标人的ID
     */
    public function elect($member_id, $bidder_member_id) {
    	$alter = $this->db->update('demand', ['selected_member_id' => $bidder_member_id], ['demand_id' => $demand_id]);
    	return $alter;
    }
    /**
     * [竞标内容]
     * @param  [type]  [description]
     */
    public function content() {
    	$select = 'title, state, bidder_num, demand_details, images_path, video_path, position, release_time';
    	$content = $this->db->get('demand', ['publisher_id' => $this->userid], $select);
    	return $content;
    }
    /**
     * [删除需求]
     * @param  [type]  [description]
     *  $id  需求ID
     */
	public function del_demand($id) {
		$del_id = $this->db->delete('demand', ['demand_id' => $id, 'publisher_id' => $this->userid]);
		return $del_id;
	}
    /**
     * [需求添加]
     * @param  [type]  [description]   
     * $a_data 参数
     */
	public function inserts_demand($a_data) {
		$inserts_demand =  $this->db->insert('demand', $a_data);
		return $inserts_demand;
	}
}
?>