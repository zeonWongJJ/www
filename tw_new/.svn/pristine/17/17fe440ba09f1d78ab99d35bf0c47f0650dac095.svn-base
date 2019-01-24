<?php
class User_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
		// $this->is_login();
	}

    //会员中心获取会员的基本信息 [操作的表 member 操作方式 select]
    public function get_user_baseinfo() {
        $a_where = [
            'id =' => $_SESSION['user_id']
        ];
        $a_data = $this->db->get_row('member', $a_where);
        return $a_data;
    }

    //会员中心首页->获取会员的足迹总数 [操作的表 member_footprint 操作方式 select]
    public function get_myfootprint_total() {
        $a_where = [
            'member_id =' => $_SESSION['user_id']
        ];
        $i_data =  $this->db->get_total('member_footprint', $a_where);
        return $i_data;
    }

    //会员中心首页->获取会员的收藏总数 [操作的表 collection 操作方式 select]
    public function get_mycollect_total() {
        $a_where = [
            'member_id =' => $_SESSION['user_id']
        ];
        $i_data =  $this->db->get_total('collection', $a_where);
        return $i_data;
    }

    //会员中心首页->获取我的排班总数 [操作的表 demand 操作方式 select]
    public function get_mypaiban_total() {
        $a_where = [
            'publisher_id =' => $_SESSION['user_id'],
            'state' => 14
        ];
        $i_data =  $this->db->get_total('demand', $a_where);
        return $i_data;
    }

    //获取不同状态下的订单总数
    public function get_demand_total($state) {
        $a_where = [
            'publisher_id'  => $_SESSION['user_id'],
            'state'         => $state,
        ];
        $i_result = $this->db->get_total('demand', $a_where);
        return $i_result;
    }


}

?>