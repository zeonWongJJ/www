<?php

class User_order_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/**********************************************************************************/

    /**
     * [get_demand_all 获取我的全部订单]
     * @return [type] [返回我的全部订单信息]
     */
    public function get_demand_all() {
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
            'publisher_id =' => $_SESSION['user_id'],
        ];
        $i_total = $this->db->get_total('demand', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_order = [
            'demand_id' => 'desc'
        ];
        $a_data = $this->db->get('demand', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [get_demand_custom 接收状态码获取不同状态下的订单数据]
     * @param  [int] $state [订单状态]
     * @return [array]      [返回查询到的订单信息]
     */
    public function get_demand_custom($state) {
        $a_where = [
            'publisher_id'  => $_SESSION['user_id'],
            'state'         => $state,
        ];
        $a_order = [
            'demand_id' => 'desc',
        ];
        $a_data = $this->db->get('demand', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [get_demand_bid 获取竞标中的订单]
     * @return [array] [返回查询到的订单信息]
     */
    public function get_demand_bid() {
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
            'publisher_id =' => $_SESSION['user_id'],
            'state'          => 101  //状态为11表示正在竞标中
        ];
        $i_total = $this->db->get_total('demand', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_order = [
            'demand_id' => 'desc'
        ];
        $a_data = $this->db->get('demand', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [get_demand_waitpay 获取待付款的订单]
     * @return [array] [返回查询到的订单信息]
     */
    public function get_demand_waitpay() {
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
            'publisher_id =' => $_SESSION['user_id'],
            'state'          => 102
        ];
        $i_total = $this->db->get_total('demand', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_order = [
            'demand_id' => 'desc'
        ];
        $a_data = $this->db->get('demand', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    //获取待服务者确定的订单
    public function get_demand_waitconfirm() {
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
            'publisher_id =' => $_SESSION['user_id'],
            'state'          => 103
        ];
        $i_total = $this->db->get_total('demand', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_order = [
            'demand_id' => 'desc'
        ];
        $a_data = $this->db->get('demand', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    //获取待服务的订单
    public function get_demand_waitservice() {
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
            'publisher_id =' => $_SESSION['user_id'],
            'state'          => 104
        ];
        $i_total = $this->db->get_total('demand', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_order = [
            'demand_id' => 'desc'
        ];
        $a_data = $this->db->get('demand', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    //获取正在服务中的订单
    public function get_demand_inservice() {
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
            'publisher_id =' => $_SESSION['user_id'],
            'state'          => 105
        ];
        $i_total = $this->db->get_total('demand', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_order = [
            'demand_id' => 'desc'
        ];
        $a_data = $this->db->get('demand', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    //获取等待评价的订单
    public function get_demand_waitcomment() {
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
            'publisher_id =' => $_SESSION['user_id'],
            'state'          => 106
        ];
        $i_total = $this->db->get_total('demand', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_order = [
            'demand_id' => 'desc'
        ];
        $a_data = $this->db->get('demand', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    //获取已完成的订单
    public function get_demand_complete() {
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
            'publisher_id =' => $_SESSION['user_id'],
            'state'          => 107
        ];
        $i_total = $this->db->get_total('demand', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_order = [
            'demand_id' => 'desc'
        ];
        $a_data = $this->db->get('demand', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [get_demand_detail 获取订单详情]
     * @param  [int] $id  [传入的订单id]
     * @return [array]    [返回查询到的订单信息]
     */
    public function get_demand_detail($id) {
        $a_where = [
            'demand_id =' => $id
        ];
        $a_data = $this->db->get_row('demand', $a_where);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [get_server_selected 已选中投标者的信息]
     * @param  [int] $selected_bid   [选中的投标id]
     * @return [array]               [返回查询到会员信息]
     */
    public function get_server_selected($selected_bid){
        $a_where = [
            'new_bid.bid =' => $selected_bid,
        ];
        $a_data = $this->db->from('bid')
                           ->join('member', ['new_bid.bidder_member_id'=>'new_member.id'])
                           ->get('', $a_where);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [get_server_unselected 未选中投标者的信息]
     * @param  [array] $a_data_detail [订单信息]
     * @return [array]                [返回查询到的未选中的会员信息]
     */
    public function get_server_unselected($a_data_detail) {
        if ($a_data_detail['state'] == 101) {
            $a_where = [
                'new_bid.demand_id =' => $a_data_detail['demand_id'],
            ];
        } else {
            $a_where = [
                'new_bid.demand_id ='  => $a_data_detail['demand_id'],
                'new_bid.demand_id !=' => $a_data_detail['selected_member_id'],
            ];
        }
        $a_order = [
            'new_bid.bid' => 'desc'
        ];
        $a_data = $this->db->from('bid')
                           ->join('member', ['new_bid.bidder_member_id'=>'new_member.id'])
                           ->get('', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [update_demand_cancel 取消订单]
     * @param  [int] $id [传入的订单的id]
     * @return [int]     [返回订单更新影响的行数]
     */
    public function update_demand_cancel($id) {
        $a_where = [
            'demand_id' => $id
        ];
        $a_data = [
            'state'         => 101,
            'selected_bid'  => null,
            'selected_member_id' => null,
        ];
        $i_result = $this->db->update('demand',$a_data, $a_where);
        return $i_result;
    }

/**********************************************************************************/

    /**
     * [insert_message_logging 插入一条信息跟踪记录]
     * @param  [array] $a_data [传入要插入的信息]
     * @return [int]           [返回插入新数据的id]
     */
    public function insert_message_logging($a_data) {
        $i_result = $this->db->insert('message_logging', $a_data);
        return $i_result;
    }

/**********************************************************************************/

    /**
     * [update_demand_selected 确定选中某个服务者]
     * @param  [type] $id [中的投标id]
     * @return [type]     [description]
     */
    public function update_demand_selected($id) {
        //先到竞标信息中获取相关信息更新到需求表中
        $a_where = [
            'bid' => $id
        ];
        $a_data = $this->db->get_row('bid', $a_where);
        //取出相关信息
        $demand_id          = $a_data['demand_id']; //需求id
        $selected_bid       = $a_data['bid']; //竞标id
        $selected_member_id = $a_data['bidder_member_id']; //投标人
        $price              = $a_data['amount']; //金额
        $guarantee_long     = $a_data['guarantee_long']; //保修时长

        //更新需求表
        $a_update_where = [
            'demand_id' => $demand_id
        ];
        $a_update_data = [
            'state'                 => 102,
            'selected_bid'          => $selected_bid,
            'selected_member_id'    => $selected_member_id,
            'price'                 => $price,
            'guarantee_long'        => $guarantee_long
        ];
        $i_update_result = $this->db->update('demand', $a_update_data, $a_update_where);

        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $demand_id,
            'service_state'     => 101,
            'classify'          => 2,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '选中了服务者',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
    }

/**********************************************************************************/

    //确定服务完成
    public function update_demand_finish($id) {
        $a_update_where = [
            'demand_id' => $id
        ];
        $a_update_data = [
            'state'         => 106,
            'finish_time'   => $_SERVER['REQUEST_TIME'],
        ];
        $i_update_result = $this->db->update('demand', $a_update_data, $a_update_where);

        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $id,
            'service_state'     => 105,
            'classify'          => 2,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '已确认服务完成',
            'classify_uid'      => $_SESSION['user_id'],
            'write_time'        => $_SERVER['REQUEST_TIME'],
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
    }

/**********************************************************************************/

    //会员中心->需求订单->插入一条退款申请
    public function insert_refund($a_data) {
        //将数据插入到退款申请表
        $i_result = $this->db->insert('refund', $a_data);

        //更新需求表
        $a_update_where = [
            'demand_id' => $a_data['demand_id'],
        ];
        $a_update_data = [
            'state' => 301,
        ];
        $i_update_result = $this->db->update('demand', $a_update_data, $a_update_where);

        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_data['demand_id'],
            'service_state'     => $a_data['demand_state'],
            'classify'          => 2,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '发起了退款申请',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);

        if ($i_insert_result) {
            return $i_insert_result;
        } else {
            return false;
        }
    }

/**********************************************************************************/

    /**
     * [get_refund_total 查询某条订单申请退款的次数 申请退款时判断之前否有退款申请]
     * @param  [int] $id [传入的订单id]
     * @return [int]     [返回查询到的记录总条数]
     */
    public function get_refund_total($id) {
        $a_where = [
            'demand_id ='   => $id,
            'refund_type =' => 1,
        ];
        $i_result_total = $this->db->get_total('refund', $a_where);
        return $i_result_total;
    }

/**********************************************************************************/

    /**
     * [get_refund_detail 查看退款订单的详情]
     * @param  [array] $a_demand_detail [传入的订单详情]
     * @return [array]                  [返回退款详情]
     */
    public function get_refund_detail($a_demand_detail) {
        $a_where = [
            'demand_id ='   => $a_demand_detail['demand_id'],
            'refund_type =' => 1,
        ];
        $a_order = [
            'refund_id' => 'desc',
        ];
        $a_data = $this->db->get_row('refund', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [get_refund_server 获取退款订单的服务者信息]
     * @param  [array] $a_demand_detail [传入的订单信息]
     * @return [array]                  [返回退款的服务者信息]
     */
    public function get_refund_server($a_demand_detail) {
        $a_where = [
            'id ='   => $a_demand_detail['selected_member_id'],
        ];
        $a_data = $this->db->get_row('member', $a_where);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [get_refund_schedule 获得某一订单的退款进度]
     * @param  [int] $id   [订单id]
     * @return [array]     [返回退款信息]
     */
    public function get_refund_schedule($id) {
        $a_where = [
            'demand_id' =>$id,
        ];
        $a_order = [
            'logging_id' => 'desc',
        ];
        $a_data = $this->db->get('message_logging', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [get_refund_old 获得某一条退款申请的信息]
     * @param  [int] $refund_id   [传入的退款申请id]
     * @return [array]            [返回查询到的退款详情]
     */
    public function get_refund_old($refund_id) {
        $a_where = [
            'refund_id' => $refund_id,
        ];
        $a_data = $this->db->get_row('refund', $a_where);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [update_refund_change 修改退款申请]
     * @param  [array] $a_update_data [传入的更新据]
     * @param  [int]   $demand_id     [传入的订单信息]
     * @return [int]                  [返回插入跟踪数据的id]
     */
    public function update_refund_change($a_update_data, $demand_id) {
        //插入一条修改的退款申请信息
        $i_result = $this->db->insert('refund', $a_update_data);
        //查询订单获取数据更新到订单追踪表中
        $a_where = [
            'demand_id' => $demand_id
        ];
        $a_data = $this->db->get_row('demand', $a_where);
        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $demand_id,
            'service_state'     => $a_data['state'],
            'classify'          => 2,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '修改了退款申请',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_result;
    }

/**********************************************************************************/

    /**
     * [update_refund_cancel 撤消退款申请]
     * @param  [array] $a_demand_detail [传入的订单信息]
     * @return [int]                    [返回插入跟踪数据的id]
     */
    public function update_refund_cancel($a_demand_detail) {
        //首先到退款表中找回订单的原状态
        $a_where =  [
            'demand_id' => $a_demand_detail['demand_id'],
        ];
        $a_data_refund = $this->db->get_row('refund', $a_where);
        $demand_state  = $a_data_refund['demand_state'];

        //更新需求表,将订单状态还原为之前的状态
        $this->db->update('demand', ['state' => $demand_state], $a_where);

        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_demand_detail['demand_id'],
            'service_state'     => $a_demand_detail['state'],
            'classify'          => 2,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '撤消了退款申请',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
    }

/**********************************************************************************/

    /**
     * [insert_custom 插入一条数据到客服介入表]
     * @param  [array] $a_data [要插入的客服介入申请信息]
     * @return [int]           [返回插入跟踪数据的id]
     */
    public function insert_custom($a_data) {
        //插入数据到客服介入表
        $i_result = $this->db->insert('custom', $a_data);

        //更新需求表中的订单状态
        $a_update_where = [
            'demand_id' => $a_data['demand_id'],
        ];
        $a_update_data = [
            'state' => 304
        ];
        $i_update_result = $this->db->update('demand', $a_update_data, $a_update_where);

        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_data['demand_id'],
            'service_state'     => $a_data['demand_state'],
            'classify'          => 2,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '客服已介入',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
    }

/**********************************************************************************/

    /**
     * [insert_guarantee 会员中心->需求订单->插入一条保修申请]
     * @param  [array] $a_data [要插入的信息]
     * @return [int]           [返回插入跟踪数据的id]
     */
    public function insert_guarantee($a_data) {
        //插入一条保修申请
        $i_result = $this->db->insert('guarantee', $a_data);

        //更新需求表，将状态改为申请保修中
        $a_update_where = [
            'demand_id =' => $a_data['demand_id'],
        ];
        $a_update_data = [
            'state' => 201
        ];
        $i_update_result = $this->db->update('demand', $a_update_data, $a_update_where);

        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_data['demand_id'],
            'service_state'     => $a_data['demand_state'],
            'classify'          => 2,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '提出保修申请',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
    }

/**********************************************************************************/

    /**
     * [get_guarantee_server 获得某一保修订单服务者的信息]
     * @param  [array] $a_demand_detail  [传入的订单详情]
     * @return [array]                   [返回服务者的信息]
     */
    public function get_guarantee_server($a_demand_detail) {
        $a_where = [
            'id'    => $a_demand_detail['selected_member_id'],
        ];
        $a_data = $this->db->get_row('member', $a_where);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [get_guarantee_schedule 获得某一订单的保修进度]
     * @param  [int] $id   [传入的订单id]
     * @return [array]     [返回订单的保修进度]
     */
    public function get_guarantee_schedule($id) {
        $a_where = [
            'demand_id' =>$id,
        ];
        $a_order = [
            'logging_id' => 'desc',
        ];
        $a_data = $this->db->get('message_logging', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    //撤消一条保修申请
    public function update_guarantee_cancel($a_demand_detail) {
        //先到保修表中获取原来的订单状态
        $a_where = [
            'demand_id'         => $a_demand_detail['demand_id'],
            'guarantee_type'    => 1,
        ];
        $a_order = [
            'guarantee_id'  => 'desc',
        ];
        $a_data = $this->db->get_row('guarantee', $a_where, '', $a_order);
        $demand_state = $a_data['demand_state'];

        //更新订单表将订单状态还原为之前的状态
        $a_update_where = [
            'demand_id' => $a_demand_detail['demand_id'],
        ];
        $a_update_data = [
            'state' => $demand_state,
        ];
        $i_result = $this->db->update('demand', $a_update_data, $a_update_where);

        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_demand_detail['demand_id'],
            'service_state'     => $a_demand_detail['state'],
            'classify'          => 2,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '撤消了保修申请',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
    }

/**********************************************************************************/

    //获取订单的保修详情
    public function get_guarantee_detail($a_demand_detail) {
        $a_where = [
            'demand_id'         => $a_demand_detail['demand_id'],
            'guarantee_type !=' => 2,
        ];
        $a_order = [
            'guarantee_id' => 'desc'
        ];
        $a_data = $this->db->get_row('guarantee', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    //保修过程中申请客服介入
    public function insert_custom_guarantee($a_data) {
        //插入一条客服介入
        $this->db->insert('custom', $a_data);

        //更新需求表 将状态改为207 需求者不认可服务 已申请客服介入 等待服务者提供凭证
        $a_update_where = [
            'demand_id' => $a_data['demand_id'],
        ];
        $a_update_data = [
            'state' => 207 // 207代表需求者不认可服务 已申请客服介入 等待服务者提供凭证
        ];
        $i_update_result = $this->db->update('demand', $a_update_data);

        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_data['demand_id'],
            'service_state'     => $a_data['demand_state'],
            'classify'          => 2,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '已申请客服介入',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
    }

/**********************************************************************************/

    //保修时撤消客服介入
    public function update_custom_cancel($a_demand_detail) {
        $a_where = [
            'demand_id'     => $a_demand_detail['demand_id'],
            'custom_type'   => 2,
            'is_cancel'     => 1,
            'proposer_id'   => $_SESSION['user_id'],
        ];
        $a_data_custom = $this->db->get_row('custom', $a_where);

        //更新需求表，将订单状态设置为客服介入前的状态
        $a_where_demand = [
            'demand_id' => $a_demand_detail['demand_id'],
        ];
        $a_data_demand = [
            'state' => $a_data_custom['demand_state'],
        ];
        $i_update_demand = $this->db->update('demand', $a_data_demand, $a_where_demand);

        //将客服介入的信息改为撤消状态
        $a_updta_custom = [
            'is_cancel' => 2
        ];
        $i_update_custom = $this->db->update('custom', $a_updta_custom, $a_where);

        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_demand_detail['demand_id'],
            'service_state'     => $a_demand_detail['state'],
            'classify'          => 2,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '已撤回客服介入',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
    }

/**********************************************************************************/

    //获取一客服介入申请的记录详情
    public function get_custom_detail($id) {
        $a_where = [
            'demand_id'     => $id,
            'proposer_id'   => $_SESSION['user_id'],
            'custom_type'   => 2,
            'is_cancel'     => 1,
        ];
        $a_order = [
            'custom_id' => 'desc'
        ];
        $a_data = $this->db->get_row('custom', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    //获取客服介入信息的图片地址
    public function get_custom_imgpath($custom_id) {
        $a_where = [
            'custom_id' => $custom_id
        ];
        $a_data = $this->db->get_row('custom', $a_where);
        $img_path = $a_data['custom_img'];
        return $img_path;
    }

/**********************************************************************************/

    //修改客户介入信息
    public function update_custom_change($a_where, $a_data) {
        //修改客户介入信息
        $i_result = $this->db->update('custom', $a_data, $a_where);

        //查询客户介入记录获取信息
        $a_data_custom = $this->db->get_row('custom', $a_where);
        $a_where_demand = [
            'demand_id' => $a_data_custom['demand_id'],
        ];
        //查询订单获取信息
        $a_data_demand = $this->db->get_row('demand', $a_where_demand);

        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_data_demand['demand_id'],
            'service_state'     => $a_data_demand['state'],
            'classify'          => 2,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '已修改客服介入申请',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
    }

/**********************************************************************************/

    //获取一条保修信息的详情
    public function get_guarantee_change($id) {
        $a_where = [
            'demand_id'     => $id,
            'demand_uid'    => $_SESSION['user_id'],
        ];
        $a_order = [
            'guarantee_id'  => 'desc',
        ];
        $a_data = $this->db->get_row('guarantee', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    //获取保修申请数据原来的图片地址
    public function get_old_imgpath($guarantee_id) {
        $a_where = [
            'guarantee_id' => $guarantee_id,
        ];
        $a_data = $this->db->get_row('guarantee', $a_where);
        $img_path = $a_data['guarantee_img'];
        return $img_path;
    }

/**********************************************************************************/

    //修改保修的申请信息
    public function update_guarantee_change($a_data) {
        //修改保修信息
        $i_result = $this->db->insert('guarantee', $a_data);

        //查询获取相关信息
        $a_where_demand = [
            'demand_id' => $a_data['demand_id'],
        ];
        $a_data_demand = $this->db->get_row('demand', $a_where_demand);

        //插入一条跟踪信息
        $a_insert_data = [
            'demand_id'         => $a_data_demand['demand_id'],
            'service_state'     => $a_data_demand['state'],
            'classify'          => 2,
            'classify_user'     => $_SESSION['user_name'],
            'classify_msg'      => '修改了保修申请',
            'write_time'        => $_SERVER['REQUEST_TIME'],
            'classify_uid'      => $_SESSION['user_id']
        ];
        $i_insert_result = $this->db->insert('message_logging', $a_insert_data);
        return $i_insert_result;
    }

/**********************************************************************************/

    //获取保修记录
    public function get_guarantee_record($id) {
        $a_where = [
            'demand_id'         => $id,
            'guarantee_type'    => 1,
        ];
        $a_order = [
            'guarantee_id' => 'desc'
        ];
        $a_data = $this->db->get('guarantee', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    //获取保修表里的同一订单的所有信息
    public function get_guarantee_history($id) {
        $a_where = [
            'demand_id' => $id,
        ];
        $a_order = [
            'guarantee_id'  => 'desc',
        ];
        $a_data = $this->db->get('guarantee', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

    //获取客服介入表中保修介入信息
    public function get_custom_history($id) {
        $a_where = [
            'demand_id'     => $id,
            'custom_type'   => 2,
        ];
        $a_data = $this->db->get_row('custom', $a_where);
        if (!empty($a_data)) {
            return $a_data;
        } else {
            return array();
        }
    }

/**********************************************************************************/



}

?>