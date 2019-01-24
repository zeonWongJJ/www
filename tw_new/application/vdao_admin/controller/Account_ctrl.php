<?php
defined('BASEPATH') or exit('禁止访问！');
class Account_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('account_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/***************************************** 门店结算 *****************************************/

	public function account_store() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// type值为1代表全部 2待核算 3待结算 4已结算
			$state = $this->router->get(1);
			if ($state === false) {
				$state = 9;
			}
			// 结算时间为1代表全部
			$time = $this->router->get(2);
			if (empty($time)) {
				$time = 9;
			}
			$a_data = $this->account_model->get_account_page($state, $time);
			$a_all = $this->account_model->get_account_all();
			// 月份信息
			$new_data = array();
			$i = 0;
			foreach ($a_all as $key => $value) {
				if (!in_array($value['account_time'], $new_data) && $i<13) {
					$new_data[] = $value['account_time'];
					$i++;
				}
			}
			$a_data['month'] = $new_data;
			$a_data['state'] = $state;
			$a_data['time']  = $time;
			// 获取不同结算状态的总条数
			$a_data['state_one']   = $this->account_model->get_account_count(0);
			$a_data['state_two']   = $this->account_model->get_account_count(1);
			$a_data['state_three'] = $this->account_model->get_account_count(2);
			$this->view->display('account_store2', $a_data);
		}
	}

/****************************************** 查看明细 *****************************************/

	public function account_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收需要查看的门店结算id
			$account_id = $this->router->get(1);
			$stye       = $this->router->get(2);
			// 根据id获取结算数据
			$a_data['detail'] = $this->account_model->get_account_one($account_id);
			// 获取近三个月的结算数据
			$a_data['recently'] = $this->account_model->get_account_recently($a_data['detail']['store_id']);
			// 获取门店的当月的订单			
			if ($stye == 1) {
				$order_ids = explode(',', $a_data['detail']['order_ids']);		
			} else {
				$order_ids = explode(',', $a_data['detail']['office_order']);
			}	
			$a_data['count'] = count($order_ids);
			$a_order = $this->account_model->get_account_order($order_ids, $stye);
			$a_data['order'] = $a_order['order'];
			$a_data['page'] = $a_order['page'];
			$a_data['account_id'] = $account_id;
			$this->view->display('account_detail2', $a_data);
		}
	}

/***************************************** 确定核算金额 **************************************/

	public function account_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收参数信息
			$account_id    = trim($this->general->post('account_id'));
			$money_update  = trim($this->general->post('money_update'));
			$remark_update = trim($this->general->post('remark_update'));
			$is_correct    = trim($this->general->post('is_correct'));
			// 获取一条结算数据
			$a_account = $this->account_model->get_account_one($account_id);
			// 验证时间
			$beginThismonth = mktime(0, 0, 0, date('m'), 1, date('Y'));
			if ($beginThismonth == $a_account['account_time']) {
				echo json_encode(array('code'=>400, 'msg'=>'下个月再来核算哟'));
				die;
			}
			// 组装数据
			$a_where = [
				'account_id' => $account_id
			];
			$a_data = [
				'money_update'  => $money_update,
				'remark_update' => $remark_update,
				'is_correct'    => $is_correct,
				'account_state' => 1,
			];
			$i_result = $this->account_model->update_account($a_where, $a_data);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'核算成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'核算失败'));
			}
		} else {
			// 接收需要核算的结算id
			$account_id = $this->router->get(1);
			// 获取一条结算信息
			$a_data = $this->account_model->get_account_one($account_id);
			$this->view->display('account_update', $a_data);
		}
	}

/************************************ 给门店结算 ******************************************/

	public function account_statement() {
		// 接收参数
		$account_id = $this->general->post('account_id');
		// 获取结算数据
		$a_account = $this->account_model->get_account_one($account_id);
		if ($a_account['account_state'] == 1) {
			// 获取一条门店信息
			$a_store = $this->account_model->get_store_one($a_account['store_id']);
			// 组装数据 给门店增加金额
			$a_where = [
				'store_id' => $a_account['store_id'],
			];
			$a_data = [
				'store_balance'    => $a_store['store_balance'] + $a_account['money_update'],
				'accumulate_money' => $a_store['accumulate_money'] + $a_account['money_update'],
			];
			$i_result = $this->account_model->update_store($a_where, $a_data);
			if ($i_result) {
				// 结算成功后将结算状态改为已结算
				$a_update_where = [
					'account_id' => $account_id
				];
				$a_update_data = [
					'account_state' => 2
				];
				$this->account_model->update_account($a_update_where, $a_update_data);
				// 插入一条信息到门店资金变动表
				$a_insert_data = [
					'store_id'            => $a_account['store_id'],
					'balance_number'      => $a_account['money_update'],
					'balance_type'        => 1,
					'balance_item'        => '销售结算',
					'balance_remain'      => $a_store['store_balance'] + $a_account['money_update'],
					'score_remain'        => $a_store['store_score'],
					'balance_time'        => $_SERVER['REQUEST_TIME'],
					'balance_description' => date('Y年m月', $a_account['account_time']) . '结算打款'
				];
				$this->account_model->insert_balance($a_insert_data);
				echo json_encode(array('code'=>200, 'msg'=>'结算成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'结算失败'));
			}
		}
	}

/***************************************************************************************/

}

?>