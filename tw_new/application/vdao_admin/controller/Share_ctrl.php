<?php

defined('BASEPATH') or exit('禁止访问！');

class Share_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('share_model');
	}

/*********************************** 分享列表 ***********************************/

	public function share_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$state = $this->router->get(1);
			if (empty($state)) {
				$state = 'all';
			}
			// 获取分享的产品列表
			$a_goods = $this->share_model->get_qualifi_goods($state);
			$a_data['goods'] = $a_goods['goods'];
			$a_data['count'] = $a_goods['count'];
			$a_data['state'] = $state;
			$this->view->display('share_showlist', $a_data);
		}
	}

/*********************************** 分享详情 ***********************************/

	public function share_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收参数
			$goo_id = $this->router->get(1);
			$a_data['goods'] = $this->share_model->get_qualifi_goods_row($goo_id);
			// 获取一条资质信息
			$a_data['qualifi'] = $this->share_model->get_qualifi_one($a_data['goods']['user_id']);
			// 获取一条用户信息
			$a_data['user'] = $this->share_model->get_user_one($a_data['goods']['user_id']);
			$this->view->display('share_detail', $a_data);
		}
	}

/*********************************** 通过分享 ***********************************/

	public function share_adopt() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$goo_id = trim($this->general->post('goo_id'));
			$liyou  = trim($this->general->post('liyou'));
			// 更改状态
			$a_where = [
				'goo_id' => $goo_id
			];
			$a_data = [
				'state' => 2,
				'liyou' => $liyou,
				'operate_time' => time()
			];
			$i_result = $this->share_model->update_qualifi_goods($a_where, $a_data);
			$a_parameter = [
				'msg'      => '已通过该申请',
				'url'      => 'share_showlist',
				'log'      => false,
				'wait'     => 2,
			];
			if ($i_result) {
				$this->error->show_success($a_parameter);
			} else {
				$this->error->show_error($a_parameter);
			}
		}
	}

/*********************************** 驳回分享 ***********************************/

	public function share_refuse() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$goo_id = trim($this->general->post('goo_id2'));
			$liyou  = trim($this->general->post('liyou'));
			// 更改状态
			$a_where = [
				'goo_id' => $goo_id
			];
			$a_data = [
				'state' => 3,
				'liyou' => $liyou,
				'operate_time' => time()
			];
			$i_result = $this->share_model->update_qualifi_goods($a_where, $a_data);
			$a_parameter = [
				'msg'      => '驳回该申请成功',
				'url'      => 'share_showlist',
				'log'      => false,
				'wait'     => 2,
			];
			if ($i_result) {
				$this->error->show_success($a_parameter);
			} else {
				$this->error->show_error($a_parameter);
			}
		}
	}

/*********************************** 搁置分享 ***********************************/

	public function share_shelve() {
		$goo_id = trim($this->general->post('goo_id'));
		// 更改状态
		$a_where = [
			'goo_id' => $goo_id
		];
		$a_data = [
			'state' => 4,
			'operate_time' => time()
		];
		$i_result = $this->share_model->update_qualifi_goods($a_where, $a_data);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'success'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'error'));
		}
	}

/*********************************** 一条分享 ***********************************/

	public function share_see() {
		$goo_id = trim($this->general->post('goo_id'));
		$a_data = $this->share_model->get_qualifi_goods_one($goo_id);
		if (empty($a_data)) {
			echo json_encode(array('code'=>400, 'msg'=>'数据有误'));
		} else {
			$a_data['time'] = date('Y-m-d H:i:s', $a_data['operate_time']);
			echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$a_data));
		}
	}

/************************************* 分享订单管理 ***********************************/
	public function share_order() {
		$i_order  = $this->router->get(1) ? $this->router->get(1) : 0;
		//页面数据显示和条件
		$i_canshu = $this->router->get(2) ? $this->router->get(2) : '1';
		$a_data = [
			'i_order'  => $i_order,
			'i_canshu' => $i_canshu,
		];
		$a_where = "`share_userid` > '0'";
		if ( ! empty($i_order)) {
			if ($i_order == 55) {
				$a_where .= ($a_where ? ' AND ' : '') . "`order_state` = 0";
			} else if ($i_order == 10 || $i_order == 80) {
				$a_where .= ($a_where ? ' AND ' : '') . "`order_state` IN ('10','80')";
			} else {
				$a_where .= ($a_where ? ' AND ' : '') . "`order_state` = $i_order";
			}

		}
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数，以产品为例
		$a_data['i_total'] = $this->db->get_total('order', $a_where);
   		// 调用分页运算函数
		$a_pdata = $this->pages->get($a_data['i_total'], $i_canshu, 7);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		//数据
		$a_data['order'] = $this->db->from('order as a')
									->join('user as b', ['a.user_id' => 'b.user_id'])
									->order_by(['order_id' => 'desc'])
									->get('', $a_where);
		// echo $this->db->get_sql();
		//显示页
		$a_data['page']  = $this->pages->link_style_one($this->router->url('order_coffee-'.$store_id.'-'.$i_order, [''], false, false));

		$a_data['goods'] = $this->db->order_by(['rec_id' => 'desc'])->limit(0, 999999999)->get('order_goods');

		//各订单数
		$s_fields = 'order_state,count(1) as num';
		$s_group_by = 'order_state';
		$a_wher = ['share_userid >' => '0'];
		$a_data_result = $this->db
				 	   ->select($s_fields,false)
				 	   ->group_by($s_group_by)
				       ->get('order', $a_wher);
				       // print_r($a_data_result);
		foreach($a_data_result as $key => $value) {
			$a_result[$value['order_state']] = $value['num'];
		}
		// 显示待付款条数
   		$a_data['payment'] = isset($a_result['40']) ? intval($a_result['40']) : 0;
   		// 显示待接单条数
   		$a_data['waiting']  = isset($a_result['20']) ? intval($a_result['20']) : 0;
   		// 显示待配送条数
   		$a_data['shipping'] = isset($a_result['25']) ? intval($a_result['25']) : 0;
   		// 显示配送中条数
   		$a_data['distribu'] = isset($a_result['30']) ? intval($a_result['30']) : 0;
		$this->view->display('share_order', $a_data);
	}

/*************************************** 分享订单详情 ******************************************/
	public function share_order_details() {
		$i_id     = $this->router->get(1);
		$s_field  = 'a.order_number, a.time_create, a.reciver_name, a.addres, a.mob_phone, b.product_name, b.cup_id, b.goods_num, b.money, a.use_jife, a.payment_code, b.spec,a.time_delay,a.shipping_fee,a.actual_pay,a.order_price,a.balance_deduction';
		$a_data['order'] = $this->db->from('order as a')
							->join('order_goods as b', ['a.order_id' => 'b.order_id'])
							->get('', ['a.order_id' => $i_id], $s_field);
		// 通过快递公司和单号查询
		$express_company = $a_data['order'][0]['express_company'];
		$express_number = $a_data['order'][0]['express_number'];
		if (!empty($express_company) && !empty($express_number)) {
			$this->load->library('express_kdniao');
			$a_data['express'] = $this->express_kdniao->query($express_company, $express_number);
			$j = count($a_data['express']['Traces']);
			for ($i=0; $i < count($a_data['express']['Traces']); $i++) {
				foreach ($a_data['express']['Traces'] as $key => $value) {
					if ($key == $j) {
						$new_data[] = $value;
					}
				}
				$j--;
			}
			$a_data['express']['Traces'] = $new_data;
		} else {
			$a_data['express']['Traces'] = array();
		}
		$this->view->display('share_order_details', $a_data);
	}
/********************************************************************************/

}

?>