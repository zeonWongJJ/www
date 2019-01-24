<?php

class User_collect_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/**********************************************************************************/

    /**
     * [get_all_mycollect 会员中心->我的收藏->全部收藏]
     * [操作的表 new_collection & new_demand & new_member 操作方式 select]
     * @return [array] [返回我的全部收藏]
     */
    public function get_all_mycollect() {
        //查询我收藏的需求
        $a_where = [
            'new_collection.member_id =' => $_SESSION['user_id'],
            'type =' => 2
        ];
        $a_order = [
            'new_collection.cid' => 'desc'
        ];
        $a_data_one = $this->db->from('collection')
                           ->join('demand', ['new_demand.demand_id'=>'new_collection.collect_id'])
                           ->get('', $a_where, '', $a_order);
        //查询我收藏的服务
        $a_where = [
            'new_collection.member_id =' => $_SESSION['user_id'],
            'type =' => 1
        ];
        $s_field = '';
        $a_order = [
            'new_collection.cid' => 'desc'
        ];
        $a_data_two = $this->db->from('collection')
                           ->join('member', ['new_member.id'=>'new_collection.collect_id'])
                           ->get('', $a_where,  '', $a_order);
        //如果两个数组都为空则直接返回false
        if (empty($a_data_one) && empty($a_data_two)) {
            return false;
        }
        //将两个数组合并
        $a_data = array_merge($a_data_one, $a_data_two);
        $length = count($a_data);
        //提取列数组；
        foreach ($a_data as $key => $row) {
          $tmp[$key] = $row['id'];
        }
        //将数组重新排序[array_multisort函数可以将一个二维数组根据某个键值进行排序]
        array_multisort($tmp,SORT_DESC,$a_data);
        return $a_data;
    }

/**********************************************************************************/

    //会员中心->我的收藏->收藏的服务者 [操作的表 new_collection & new_member 操作方式 select]
    public function get_server_mycollect(){
        $a_where = [
            'new_collection.member_id =' => $_SESSION['user_id'],
            'type =' => 1
        ];
        $s_field = '';
        $a_order = [
            'new_collection.cid' => 'desc'
        ];
        $a_data = $this->db->from('collection')
                           ->join('member', ['new_member.id'=>'new_collection.collect_id'])
                           ->get('', $a_where,  '', $a_order);
        if(!empty($a_data)){
            return $a_data;
        }else{
            return false;
        }
    }

/**********************************************************************************/

    //会员中心->我的收藏->收藏的需求 [操作的表 new_collection & new_demand 操作方式 select]
    public function get_demand_mycollect(){
        $a_where = [
            'member_id =' => $_SESSION['user_id'],
            'type =' => 2
        ];
        //查询我收藏的需求
        $a_where = [
            'new_collection.member_id =' => $_SESSION['user_id'],
            'type =' => 2
        ];
        $a_order = [
            'new_collection.cid' => 'desc'
        ];
        $a_data = $this->db->from('collection')
                           ->join('demand', ['new_demand.demand_id'=>'new_collection.collect_id'])
                           ->get('', $a_where, '', $a_order);
        if(!empty($a_data)){
            return $a_data;
        }else{
            return false;
        }
    }

/**********************************************************************************/

    //会员中心->收藏->删除收藏 [操作的表 new_collection 操作方式 delete]
    public function del_mycollect($a_data) {
        $i_result = $this->db->where_in('cid', $a_data)->delete('collection');
        return $i_result;
    }

/**********************************************************************************/

    //会员中心->我的收藏->添加收藏前判断是否已收藏过了
    public function get_is_exist($collect_id,$collect_type) {
        $a_where = [
            'member_id'     => $_SESSION['user_id'],
            'collect_id'    => $collect_id,
            'type'          => $collect_type,
        ];
        $i_result = $this->db->get_total('collection', $a_where);
        return $i_result;
    }

/**********************************************************************************/

    //会员中心->我的收藏->插入一条收藏信息
    public function insert_collect($a_data) {
        $i_result = $this->db->insert('collection', $a_data);
        return $i_result;
    }

/**********************************************************************************/

}

?>