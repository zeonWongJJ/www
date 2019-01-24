<?php
defined('BASEPATH') or exit('禁止访问！');
class Balance_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('balance_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/**************************************** 资金变动列表 ****************************************/

	public function balance_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$type = $this->router->get(1);
			if (empty($type)) {
				$type = 9;
			}
			$btime = $this->router->get(2);
			if (empty($btime)) {
				$btime = 9;
			}
			$etime = $this->router->get(3);
			if (empty($etime)) {
				$etime = 9;
			}
			$a_balance = $this->balance_model->get_balance_page($_SESSION['store_id'], $type, $btime, $etime);
			$a_data['balance'] = $a_balance['balance'];
			$a_data['count'] = $a_balance['count'];
			$a_data['store'] = $this->balance_model->get_store_one($_SESSION['store_id']);
			$a_data['type'] = $type;
			$a_data['btime'] = $btime;
			$a_data['etime'] = $etime;
			// 查询近期抢单所返的积分
			$a_storescore = $this->balance_model->get_store_score($_SESSION['store_id']);
			$time_arr = array();
			$sc_arr = array();
			foreach ($a_storescore as $key => $value) {
				$thistime = $value['sc_time'];
				$thisstart = mktime(0, 0, 0, date('m', $thistime),date('d', $thistime),date('Y', $thistime));
				if (!in_array($thisstart, $time_arr) && count($time_arr) < 31) {
					$value['sc_time'] = $thisstart;
					$sc_arr[] = $value;
					$time_arr[] = $thisstart;
				} else {
					foreach ($sc_arr as $k => $v) {
						if ($thisstart == $v['sc_time']) {
							$v['sc_score'] = $v['sc_score'] + $value['sc_score'];
							$sc_arr[$k] = $v;
						}
					}
				}
			}
			$a_data['myscore'] = $sc_arr;
			$this->view->display('balance_showlist2', $a_data);
		}
	}

/**************************************** 门店资金提现 ****************************************/

	public function balance_withdraw() {
		// 获取当前门店信息
		$a_store = $this->balance_model->get_store_one($_SESSION['store_id']);
		// 验证数据
		$a_parameter = [
			'msg'      => '必填项不能为空',
			'url'      => 'balance_showlist',
			'log'      => false,
			'wait'     => 2,
		];
		// 验证是否设置提现密码
		if (empty($a_store['store_password'])) {
			$a_parameter['msg'] = '请先设置提现密码';
			$a_parameter['url'] = 'store_set';
			$this->error->show_error($a_parameter);
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收数据
			$balance_number = trim($this->general->post('balance_number'));
			$balance_score = trim($this->general->post('balance_score'));
			$withdraw_type  = trim($this->general->post('withdraw_type'));
			$store_password = trim($this->general->post('store_password'));
			// 验证必填项不能为空
			if (empty($withdraw_type) || empty($store_password)) {
				$a_parameter['msg'] = '必填项不能为空';
				$a_parameter['url'] = 'balance_showlist';
				$this->error->show_error($a_parameter);
			}
			if (empty($balance_number) && empty($balance_score)) {
				$a_parameter['msg'] = '提现金额不能为空';
				$a_parameter['url'] = 'balance_showlist';
				$this->error->show_error($a_parameter);
			}
			// 验证提现密码是否正确
			if ($a_store['store_password'] != md5(md5($store_password))) {
				$a_parameter['msg'] = '提现密码错误';
				$this->error->show_error($a_parameter);
			}
			// 验证提现金额是否合法
			if ($balance_number > $a_store['store_balance'] || $balance_score > $a_store['store_score']) {
				$a_parameter['msg'] = '可提现余额或积分不足';
				$this->error->show_error($a_parameter);
			}
			// $withdraw_type为1代表提现到支付宝 为2代表提现到银行卡
			if ($withdraw_type == 1) {
				// 验证是否绑定了支付宝
				if (empty($a_store['store_alipay'])) {
					$a_parameter['msg'] = '请先绑定支付宝账号';
					$a_parameter['url'] = 'store_set';
					$this->error->show_error($a_parameter);
				}
				// 加载转账的类
				$this->load->library('alipay_wap');
				if (!empty($balance_number)) {
					// 此处为余额提现
					$a_data = [
						'out_biz_no'      => date('Ymdhis', time()) . rand(100, 999),
						'payee_account'   => $a_store['store_alipay'],
						'amount'          => $balance_number,
						'payee_real_name' => $a_store['store_remittee'],
						'remark'          => '门店余额提现',
						// 设置是跳转到支付宝页面，还是返回执行结果，默认为前者，这里我们要设置为获取执行结果
						'is_page'         => false
					];
					$a_result = $this->alipay_wap->transfer($a_data);
					if ($a_result['code'] == 10000) {
						// 转账成功则更改门店账户金额 同时插入一条金额变动信息
						$a_update_where = [
							'store_id' => $_SESSION['store_id']
						];
						$a_update_data = [
							'store_balance' => $a_store['store_balance'] - $balance_number,
							'mony_withdraw' => $a_store['mony_withdraw'] + $balance_number,
						];
						$this->balance_model->update_store($a_update_where, $a_update_data);
						// 插入一条金额变动信息
						$a_insert_data = [
							'store_id'            => $_SESSION['store_id'],
							'balance_item'        => '门店余额提现',
							'balance_remain'      => $a_store['store_balance']-$balance_number,
							'score_remain'        => $a_store['store_score'],
							'balance_number'      => $balance_number,
							'balance_type'        => 2,
							'balance_time'        => $_SERVER['REQUEST_TIME'],
							'balance_description' => '提现到支付宝账号' . $a_store['store_alipay']
						];
						$this->balance_model->insert_balance($a_insert_data);
					} else {
						$a_parameter['msg'] = $a_result['sub_msg'];
						$a_parameter['url'] = 'balance_showlist';
						$this->error->show_error($a_parameter);
					}
				}
				// 此处为积分提现
				if (!empty($balance_score)) {
					// 重新获取门店信息
					$a_store2 = $this->balance_model->get_store_one($_SESSION['store_id']);
					// 提现金额
					$a_set = $this->balance_model->get_set_all();
					foreach ($a_set as $key => $value) {
						if ($value['set_name'] == 'user_score_cash') {
							$user_score_cash = $value['set_parameter'];
						}
					}
					$my_number = round(($user_score_cash/100)*$balance_score);
					$a_data = [
						'out_biz_no'      => date('Ymdhis', time()) . rand(100, 999),
						'payee_account'   => $a_store['store_alipay'],
						'amount'          => $my_number,
						'payee_real_name' => $a_store['store_remittee'],
						'remark'          => '门店积分提现',
						// 设置是跳转到支付宝页面，还是返回执行结果，默认为前者，这里我们要设置为获取执行结果
						'is_page'         => false
					];
					// var_dump($a_data);exit;
					$a_result = $this->alipay_wap->transfer($a_data);
					// var_dump($a_result);exit;
					if ($a_result['code'] == 10000) {

						// 转账成功则更改门店账户金额 同时插入一条金额变动信息
						$a_update_where = [
							'store_id' => $_SESSION['store_id']
						];
						$a_update_data = [
							'store_score'    => $a_store2['store_score']-$balance_score,
							'score_withdraw' => $a_store2['score_withdraw']+$balance_score,
						];
						$this->balance_model->update_store($a_update_where, $a_update_data);
						// 插入一条金额变动信息
						$a_insert_data = [
							'store_id'            => $_SESSION['store_id'],
							'balance_item'        => '门店积分提现',
							'balance_remain'      => $a_store2['store_balance'],
							'score_remain'        => $a_store2['store_score'] - $balance_score,
							'balance_number'      => $my_number,
							'balance_type'        => 2,
							'balance_time'        => $_SERVER['REQUEST_TIME'],
							'balance_description' => '提现到支付宝账号' . $a_store['store_alipay']
						];
						$this->balance_model->insert_balance($a_insert_data);
						$a_parameter['msg'] = '提现成功';
					} else if($a_result['code'] == 40004 ) {
						$a_parameter['msg'] = $a_result['sub_msg'];
					}else {
						$a_parameter['msg'] = '提现失败';
					}
				}
				
				$this->error->show_success($a_parameter);
			} elseif ($withdraw_type == 2) {
				// 此处为提现到银行卡账号
				// 验证是否绑定了银行卡
				if (empty($a_store['store_remittee']) || empty($a_store['store_bankcard'])) {
					$a_parameter['msg'] = '请先设置提现银行卡账号';
					$a_parameter['url'] = 'store_set';
					$this->error->show_success($a_parameter);
				}
				// 加载银联代付接口
				$this->load->library('unionpay_transfer');
				$a_param = [
					// 标志该笔交易发生的日期,格式为YYYYMMDD，请填写当天的日期。
					'mer_date' => date('Ymd', time()),
					// 订单号，商户流水号
					'mer_seqId' => date('YmdHis', time()),
					// 银行卡号或者存折号
					'card_no' => $a_store['store_bankcard'],
					// 收款人在银行开户时留存的开户姓名
					'usr_name' => $a_store['store_remittee'],
					// 开户银行名称
					'open_bank' => $a_store['open_bank'],
					// 收款人开户行所在省
					'prov' => $a_store['bank_prov'],
					// 收款人开户行所在地区
					'city' => $a_store['bank_city'],
					// 金额，整数，货币种类为人民币，以分为单位
					'trans_amt' => '0',
					// 存款用途。
					'purpose' => '门店余额提现',
					// 开户支行名称。
					'sub_bank' => $a_store['sub_bank'],
					// 对公对私标记。“00”对私，“01”对公。该字段可以不填，如不填则默认为对私。
					'flag' => '00',
					// 表示商户代付业务使用场景，（业务参数）07：互联网；08：移动端
					'term_type' => '07',
					// 表示商户代付业务交易模式（业务参数），0：被动发起代付，1：主动发起代付
					'pay_mode' => '1'
				];
				if (!empty($balance_number)) {
					$a_param['trans_amt'] = $balance_number*100;
					$a_result = $this->unionpay_transfer->pay($a_param);
					if ($a_result['responseCode'] == '0000') {
						if ($a_result['stat'] == 's' || $a_result['stat'] == 2 || $a_result['stat'] == 3 || $a_result['stat'] == 4 || $a_result['stat'] == 5 || $a_result['stat'] == 7 || $a_result['stat'] == 8) {
							// 处理相关业务
							// 转账成功则更改门店账户金额 同时插入一条金额变动信息
							$a_update_where = [
								'store_id' => $_SESSION['store_id']
							];
							$a_update_data = [
								'store_balance' => $a_store['store_balance'] - $balance_number,
								'mony_withdraw' => $a_store['mony_withdraw'] + $balance_number,
							];
							$this->balance_model->update_store($a_update_where, $a_update_data);
							// 插入一条金额变动信息
							$a_insert_data = [
								'store_id'            => $_SESSION['store_id'],
								'balance_item'        => '门店余额提现',
								'balance_remain'      => $a_store['store_balance']-$balance_number,
								'score_remain'        => $a_store['store_score'],
								'balance_number'      => $balance_number,
								'balance_type'        => 2,
								'balance_time'        => $_SERVER['REQUEST_TIME'],
								'balance_description' => '提现到银行卡' . $a_store['store_bankcard']
							];
							$this->balance_model->insert_balance($a_insert_data);
						} elseif ($a_result['stat'] == 6 || $a_result['stat'] == 9) {
							$a_parameter['msg'] = '余额提现失败';
							$a_parameter['url'] = 'balance_showlist';
							$this->error->show_error($a_parameter);
						}
					} else {
						$a_parameter['msg'] = '余额提现失败';
						$a_parameter['url'] = 'balance_showlist';
						$this->error->show_error($a_parameter);
					}
				}
				if (!empty($balance_score)) {
					// 重新获取门店信息
					$a_store2 = $this->balance_model->get_store_one($_SESSION['store_id']);
					// 提现金额
					$a_set = $this->balance_model->get_set_all();
					foreach ($a_set as $key => $value) {
						if ($value['set_name'] == 'user_score_cash') {
							$user_score_cash = $value['set_parameter'];
						}
					}
					$my_number = round(($user_score_cash/100)*$balance_score, 2);
					$a_param['trans_amt'] = $my_number*100;
					$a_result = $this->unionpay_transfer->pay($a_param);
					if ($a_result['responseCode'] == '0000') {
						if ($a_result['stat'] == 's' || $a_result['stat'] == 2 || $a_result['stat'] == 3 || $a_result['stat'] == 4 || $a_result['stat'] == 5 || $a_result['stat'] == 7 || $a_result['stat'] == 8) {
							// 处理相关业务
							// 转账成功则更改门店账户金额 同时插入一条金额变动信息
							$a_update_where = [
								'store_id' => $_SESSION['store_id']
							];
							$a_update_data = [
								'store_score'    => $a_store2['store_score'] - $balance_score,
								'score_withdraw' => $a_store2['score_withdraw'] + $balance_score,
							];
							$this->balance_model->update_store($a_update_where, $a_update_data);
							// 插入一条金额变动信息
							$a_insert_data = [
								'store_id'            => $_SESSION['store_id'],
								'balance_item'        => '门店积分提现',
								'balance_remain'      => $a_store2['store_balance'],
								'score_remain'        => $a_store2['store_score'] - $balance_score,
								'balance_number'      => $my_number,
								'balance_type'        => 2,
								'balance_time'        => $_SERVER['REQUEST_TIME'],
								'balance_description' => '提现到银行卡' . $a_store['store_bankcard']
							];
							$this->balance_model->insert_balance($a_insert_data);
						} elseif ($a_result['stat'] == 6 || $a_result['stat'] == 9) {
							$a_parameter['msg'] = '积分提现失败';
							$a_parameter['url'] = 'balance_showlist';
							$this->error->show_error($a_parameter);
						}
					} else {
						$a_parameter['msg'] = '积分提现失败';
						$a_parameter['url'] = 'balance_showlist';
						$this->error->show_error($a_parameter);
					}
				}
				$a_parameter['msg'] = '提现完成';
				$this->error->show_success($a_parameter);
			}
		} else {
			$this->view->display('balance_withdraw', $a_store);
		}
	}

/**********************************************************************************************/

}

?>