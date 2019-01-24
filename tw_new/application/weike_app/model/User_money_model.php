<?php

class User_money_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/**********************************************************************************/

	//获取用户最近的一条余额交易记录
	public function get_money_total() {
		$a_where = [
			'member_id =' => $_SESSION['user_id'],
			'type =' => 3
		];
		$s_field = 'original_value, variation';
		$a_order = [
			'variation_id' => 'desc'
		];
		$a_data = $this->db->get_row('member_variation_log', $a_where, $s_field, $a_order);
		return $a_data;
	}

/**********************************************************************************/

	//获取用户交易的详细记录
	public function get_money_detail() {
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
			'type =' => 3
		];
        $i_total = $this->db->get_total('member_variation_log', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);
		$s_field = '';
		$a_order = [
			'variation_id' => 'desc'
		];
		$a_data = $this->db->get('member_variation_log', $a_where, $s_field, $a_order);
		return $a_data;
	}

/**********************************************************************************/


}

?>