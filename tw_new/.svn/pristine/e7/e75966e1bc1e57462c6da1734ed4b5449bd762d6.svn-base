<?PHP

class User_score_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/**********************************************************************************/

	/**
	 * [get_user_score 获取用户的实时积分]
	 * [操作的表 new_member_variation_log 操作方式 select]
	 * @return [array] [返回查询到的积分变动信息]
	 */
	public function get_user_score() {
		$a_where = [
			'member_id =' => $_SESSION['user_id'],
			'type =' => 5
		];
		$s_field = 'original_value, variation';
		$a_order = [
			'variation_id' => 'desc'
		];
		$a_data = $this->db->get_row('member_variation_log', $a_where, $s_field, $a_order);
		return $a_data;
	}

/**********************************************************************************/

	/**
	 * [get_history_score 获取用户的历史积分]
	 * [操作的表 new_member_variation_log 操作方式 select]
	 * @return [array] [返回查询到的用户的历史积分]
	 */
	public function get_history_score() {
		$a_where = [
			'member_id =' => $_SESSION['user_id'],
			'type =' => 5,
			'variation_type =' => '1'
		];
		$s_field = 'variation';
		$a_order = [
			'variation_id' => 'desc'
		];
		$a_data = $this->db->get('member_variation_log', $a_where, $s_field, $a_order);
		return $a_data;
	}

/**********************************************************************************/

	/**
	 * [get_score_detail 获取用户的积分明细]
	 * [操作的表 new_member_variation_log 操作方式 select]
	 * @return [array] [返回用户的记录信息]
	 */
	public function get_score_detail() {
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
			'type =' => 5
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

	/**
	 * [get_score_exchange 获取用户的积分兑换明细]
	 * [操作的表 new_member_variation_log 操作方式 select]
	 * @return [array] [返回查询到积分兑换明细]
	 */
	public function get_score_exchange() {
		$a_where = [
			'uesr_id =' => $_SESSION['user_id'],
		];
		$s_field = '';
		$a_order = [
			'id' => 'desc'
		];
		$a_data = $this->db->get('cash_coupon', $a_where, $s_field, $a_order);
		return $a_data;
	}

/**********************************************************************************/

	/**
	 * [get_member_total 获取会员的总数]
	 * @return [int] [返回会员的总数]
	 */
	public function get_member_total() {
		$i_member_total = $this->db->get_total('member');
		return $i_member_total;
	}

/**********************************************************************************/

	/**
	 * [get_member_shao 获取历史积分比我的会员总数]
	 * @param  [int] $user_history [我的历史tkwv]
	 * @return [int]               [返回历史积分比我少的会员数]
	 */
	public function get_member_shao($user_history) {
		$a_where = [
			'integral_history <' => $user_history
		];
		$i_member_shao = $this->db->get_total('member', $a_where);
		return $i_member_shao;
	}

/**********************************************************************************/

	/**
	 * [get_gold_note 获取代金券]
	 * @return [array] [返回代金券信息]
	 */
	public function get_gold_note() {
		$a_order = [
			'cash_coupon_id' => 'desc'
		];
		$a_data = $this->db->get('gold_note', [], '', $a_order, 0, 4);
		return $a_data;
	}

/************************************************** 测试 **************************************************/

	//获取积分 上拉获取数据测试
	public function get_page() {
		return $a_data = $this->db->get('member_variation_log', [], '', [], 0, 10);
	}

	//获取更多
	public function get_more_data($page) {
        // 先设置默认从第一页开始
        $i_page = $page;
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $i_total = $this->db->get_total('member_variation_log');
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        //总页数
        $page_total = ceil($i_total/$i_prow);
        //判断是否超过总页数
        if ($page > $page_total) {
        	return $a_data = array('state'=>0);
        }

		$a_data = $this->db->get('member_variation_log');
		return $a_data;
	}

/*************************************************************************************************************/

}

?>