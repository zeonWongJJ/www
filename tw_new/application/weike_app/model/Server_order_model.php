<?php

class Server_order_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/********************************************************************************/

	//获取所有当前服务者保修的订单
	public function get_server_guarantee() {
        $a_where = [
			'new_demand.selected_member_id =' 	=> $_SESSION['user_id'],
			'new_demand.state >'           		=> 200,
			'new_demand.state <'           		=> 299,
        ];
        $s_field = '';
        $a_order = [
            'new_demand.demand_id' => 'desc'
        ];
        $a_data = $this->db->from('demand')
                           ->join('member', ['new_member.id'=>'new_demand.publisher_id'])
                           ->get('', $a_where,  '', $a_order);
		return $a_data;
	}

/********************************************************************************/

	//获取订单详情
	public function get_demand_detail($id) {
		$a_where = [
			'demand_id' => $id
		];
		$a_data = $this->db->get_row('demand', $a_where);
		return $a_data;
	}

/********************************************************************************/

	//获取订单进度
	public function get_demand_schedule($id) {
		$a_where = [
			'demand_id' => $id
		];
		$s_field = '';
		$a_order = [
			'logging_id' => 'desc'
		];
		$a_data = $this->db->get('message_logging', $a_where, $s_field, $a_order);
		return $a_data;
	}

/********************************************************************************/

	//修改订单状态
	public function update_demand_state($a_where, $a_data) {
		//修改订单状态
		$i_result = $this->db->update('demand', $a_data, $a_where);

        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_where['demand_id'],
            'service_state'     => 201,
            'classify'          => 1,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '服务者同意保修',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
	}

/********************************************************************************/

	//确认保修完成
	public function update_guarantee_complete($a_where, $a_data, $a_data_detail) {
		//修改订单状态
		$i_result = $this->db->update('demand', $a_data, $a_where);

        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_data_detail['demand_id'],
            'service_state'     => $a_data_detail['state'],
            'classify'          => 1,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '服务者已确认保修完成',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
	}

/********************************************************************************/

	/**
	 * [guarantee_averment_exist 申辩前判断是否提交过申辩]
	 * @param  [int] $id [订单id]
	 * @return [int]     [返回获取到的数据总条数]
	 */
	public function guarantee_averment_exist($id) {
		$a_where = [
			'demand_id'      => $id,
			'guarantee_type' => 2,
		];
		$i_result = $this->db->get_total('guarantee', $a_where);
		return $i_result;
	}

/********************************************************************************/

	/**
	 * [get_data_guarantee 获取保修详情信息]
	 * @param  [int] $id   [订单id]
	 * @return [array]     [返回订单详情信息]
	 */
	public function get_data_guarantee($id) {
		$a_where = [
			'demand_id'      => $id,
			'guarantee_type' => 1,
		];
		$s_field = '';
		$a_order = [
			'guarantee_id' => 'desc'
		];
		$a_data = $this->db->get_row('guarantee', $a_where, $s_field, $a_order);
		return $a_data;
	}

/********************************************************************************/

	/**
	 * [insert_guarantee_averment 写入一条申辩信息]
	 * @param  [array] $a_data       [要写入的数据]
	 * @param  [int]   $demand_state [订单的状态]
	 * @return [int]                 [返回插入跟踪信息的id]
	 */
	public function insert_guarantee_averment($a_data, $demand_state) {
		//写入一条申辩信息
		$i_result = $this->db->insert('guarantee', $a_data);
		//更新订单状态
		$a_update_where = [
			'demand_id' => $a_data['demand_id'],
		];
		$a_update_data = [
			'state' => 209,
		];
		$i_update_result = $this->db->update('demand', $a_update_data, $a_update_where);
        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_data['demand_id'],
            'service_state'     => $demand_state,
            'classify'          => 1,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '服务者发起了申辩',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
	}

/********************************************************************************/

	/**
	 * [get_server_refund 获取所有的退款订单]
	 * @return [array] [返回查询到的所有信息]
	 */
	public function get_server_refund() {
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
			'state >' => 300
		];
		$i_total = $this->db->get_total('demand', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);

		$s_field = '';
		$a_order = [
			'demand_id' => 'desc'
		];
		$a_data = $this->db->get('demand', $a_where, $s_field, $a_order);
		return $a_data;
	}

/********************************************************************************/

	/**
	 * [get_refund_detail  获取退款订单详情]
	 * @param  [int] $id   [订单id]
	 * @return [array]     [返回订单的详情信息]
	 */
	public function get_refund_detail($id) {
		$a_where = [
			'demand_id'   => $id,
			'refund_type' => 1,
		];
		$s_field = '';
		$a_order = [
			'refund_id' => 'desc'
		];
		$a_data = $this->db->get_row('refund', $a_where, $s_field, $a_order);
		return $a_data;
	}

/********************************************************************************/

	/**
	 * [update_refund_confirm 确认退款->更新订单状态]
	 * @param  [array] $a_where      [更新的条件]
	 * @param  [array] $a_data       [更新的数据]
	 * @param  [int]   $demand_state [订单状态]
	 * @return [int]                 [返回插入的的跟踪信息的id]
	 */
	public function update_refund_confirm($a_where, $a_data, $demand_state) {
		$i_result = $this->db->update('demand', $a_data, $a_where);
        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_where['demand_id'],
            'service_state'     => $demand_state,
            'classify'          => 1,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '服务者同意退款',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
	}

/********************************************************************************/

	//拒绝退款
	public function insert_refund_refuse($a_data, $demand_state) {
		//将拒绝退款插入到
		$i_result = $this->db->insert('refund', $a_data);
		//更新订单状态
		$a_update_data = [
			'demand_id' => $a_data['demand_id'],
		];
		$a_update_data = [
			'state' => 303,
		];
		$i_update_result = $this->db->update('demand', $a_update_data, $a_update_data);
        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_data['demand_id'],
            'service_state'     => $demand_state,
            'classify'          => 1,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '服务者拒绝退款',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
	}

/********************************************************************************/

	//服务者中心，获取服务者正在竞标中的订单
	public function get_server_inbid() {
        $a_where = [
			'new_demand.state'           => 101,
			'new_bid.bidder_member_id'   => $_SESSION['user_id'],
        ];
        $s_field = '';
        $a_order = [
            'new_demand.demand_id' => 'desc'
        ];
        $a_data = $this->db->from('demand')
                           ->join('bid', ['new_bid.demand_id'=>'new_demand.demand_id'])
                           ->get('', $a_where,  '', $a_order);
		return $a_data;
	}

/********************************************************************************/

	//服务者中心->竞标的订单->获取订单详情
	public function get_inbid_detail($id) {
        $a_where = [
			'new_demand.demand_id'   => $id,
        ];
        $a_data = $this->db->from('demand')
                           ->join('advanced_options_id', ['new_advanced_options_id.demand_id'=>'new_demand.demand_id'])
                           ->get_row('', $a_where);
		return $a_data;
	}

/********************************************************************************/

	//服务者中心->获取服务者所有的服务中的订单
	public function get_server_inservice() {
		$a_where = [
			'state'              => 105,
			'selected_member_id' => $_SESSION['user_id'],
		];
		$s_field = '';
		$a_order = [
			'demand_id' => 'desc'
		];
		$a_data = $this->db->get('demand', $a_where, $s_field, $a_order);
		return $a_data;
	}

/********************************************************************************/

	//服务者中心->服务中的订单->确认服务完成
	public function update_inservice_confirm($a_where, $a_data, $demand_state) {
		//更新订单状态
		$i_result = $this->db->update('demand', $a_data, $a_where);
        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_where['demand_id'],
            'service_state'     => $demand_state,
            'classify'          => 1,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '服务者已确认服务完成',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
	}

/********************************************************************************/

	//服务者中心->服务中的订单->追加服务费用
	public function update_append_money($a_where, $a_data, $a_shuju) {
		//将申请的数据更新到数据表
		$i_result = $this->db->update('bid', $a_data, $a_where);
        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_shuju['demand_id'],
            'service_state'     => $a_shuju['demand_state'],
            'classify'          => 1,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '服务者提出追加服务费用',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
	}

/********************************************************************************/

	//服务者中心->获取当前服务者待确认的订单
	public function get_wait_confirm() {
		$a_where = [
			'selected_member_id' => $_SESSION['user_id'],
			'state'              => 103,
		];
		$s_field = '';
		$a_order = [
			'demand_id' => 'desc'
		];
		$a_data = $this->db->get('demand', $a_where, $s_field, $a_order);
		return $a_data;
	}

/********************************************************************************/

	//服务者中心->待确认的订单->获取订单详情
	public function get_wait_detail($id) {
        $a_where = [
			'new_demand.demand_id'   => $id,
        ];
        $a_data = $this->db->from('demand')
                           ->join('advanced_options_id', ['new_advanced_options_id.demand_id'=>'new_demand.demand_id'])
                           ->get_row('', $a_where);
		return $a_data;
	}

/********************************************************************************/

	//服务者中心->待确认的订单->确认接单
	public function update_order_taking($a_where, $a_data, $demand_state) {
		$i_result = $this->db->update('demand', $a_data, $a_where);
        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_where['demand_id'],
            'service_state'     => $demand_state,
            'classify'          => 1,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '服务者已确认接单',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
	}

/********************************************************************************/

	//服务者中心->待确认的订单->放弃订单
	public function update_cancel_order($a_where, $a_data, $demand_state) {
		$i_result = $this->db->update('demand', $a_data, $a_where);
        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_where['demand_id'],
            'service_state'     => $demand_state,
            'classify'          => 1,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '服务者已放弃接单',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
	}

/********************************************************************************/

	//服务者中心->获取所有已完成的订单
	public function get_server_complete() {
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
			'state'              => 107,
			'selected_member_id' => $_SESSION['user_id'],
			'is_del_server'      => 1
		];
		$i_total = $this->db->get_total('demand', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);

		$s_field = '';
		$a_order = [
			'demand_id' => 'desc'
		];
		$a_data = $this->db->get('demand', $a_where, $s_field, $a_order);
		return $a_data;
	}

/********************************************************************************/

	//服务者中心->已完成的服务->查看保修明细
	public function get_complete_guarantee($id) {
		$a_where = [
			'demand_id' => $id,
		];
		$s_field = '';
		$a_order = [
			'logging_id' => 'desc'
		];
		$a_data = $this->db->get('message_logging', $a_where, $s_field, $a_order);
		return $a_data;
	}

/********************************************************************************/

	//服务者中心->已完成的订单->删除订单
	public function update_complete_del($a_where, $a_data) {
		$i_result = $this->db->update('demand', $a_data, $a_where);
		return $i_result;
	}

/********************************************************************************/


/********************************************************************************/


/********************************************************************************/

}

?>