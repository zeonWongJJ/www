<?php

class User_footprint_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/**********************************************************************************/

    /**
     * [get_all_myfootprint 会员中心->足迹->全部足迹]
     * [操作的表 new_member_footprint & new_demand & new_member 操作方式 select]
     * @return [array] [返回查询到足迹信息]
     */
    public function get_all_myfootprint() {
        //查询浏览过的需求
        $a_where = [
            'new_member_footprint.member_id =' => $_SESSION['user_id'],
            'type =' => 2
        ];
        $a_order = [
            'footprint_id' => 'desc'
        ];
        $a_data_one = $this->db->from('member_footprint')
                           ->join('demand', ['new_demand.demand_id'=>'new_member_footprint.browse_id'])
                           ->get('', $a_where, '', $a_order);
        //查询浏览过的服务者
        $a_where = [
            'new_member_footprint.member_id =' => $_SESSION['user_id'],
            'type =' => 1
        ];
        $a_order = [
            'footprint_id' => 'desc'
        ];
        $a_data_two = $this->db->from('member_footprint')
                           ->join('member', ['new_member.id'=>'new_member_footprint.browse_id'])
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
          $tmp[$key] = $row['footprint_id'];
        }
        //将数组重新排序[array_multisort函数可以将一个二维数组根据某个键值进行排序]
        array_multisort($tmp,SORT_DESC,$a_data);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [get_demand_myfootprint 会员中心->足迹->需求足迹]
     * [操作的表 new_member_footprint & new_demand 操作方式 select]
     * @return [array] [返回查询到会员足迹信息]
     */
    public function get_demand_myfootprint() {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(1);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where = [
            'member_id =' => $_SESSION['user_id'],
            'type =' => 2
        ];
        $i_total = $this->db->get_total('member_footprint', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        //查询浏览过的需求
        $a_where = [
            'new_member_footprint.member_id =' => $_SESSION['user_id'],
            'type =' => 2
        ];
        $a_order = [
            'footprint_id' => 'desc'
        ];
        $a_data = $this->db->from('member_footprint')
                           ->join('demand', ['new_demand.demand_id'=>'new_member_footprint.browse_id'])
                           ->get('', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [get_server_myfootprint 会员中心->足迹->服务者]
     * [操作的表 new_member_footprint & new_member 操作方式 select]
     * @return [type] [description]
     */
    public function get_server_myfootprint() {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(1);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where = [
            'member_id =' => $_SESSION['user_id'],
            'type =' => 1
        ];
        $i_total = $this->db->get_total('member_footprint', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_where = [
            'new_member_footprint.member_id =' => $_SESSION['user_id'],
            'type =' => 1
        ];
        $s_field = '';
        $a_order = [
            'footprint_id' => 'desc'
        ];
        $a_data = $this->db->from('member_footprint')
                           ->join('member', ['new_member.id'=>'new_member_footprint.browse_id'])
                           ->get('', $a_where,  '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [del_myfootprint 会员中心->足迹->删除足迹]
     * [操作的表 new_member_footprint 操作方式 delete]
     * @param  [array] $a_data [传入的要删除的足迹id集合]
     * @return [int]           [返回删除的行数]
     */
    public function del_myfootprint($a_data) {
        $i_result = $this->db->where_in('footprint_id', $a_data)->delete('member_footprint');
        return $i_result;
    }

/**********************************************************************************/

    /**
     * [insert_footprint 会员中心->我的足迹->插入一条足迹]
     * @param  [array] $a_data [传入的要插入的信息]
     * @return [int]           [返回新据的id]
     */
    public function insert_footprint($a_data) {
        $i_result = $this->db->insert('member_footprint', $a_data);
        return $i_result;
    }

/**********************************************************************************/

}

?>