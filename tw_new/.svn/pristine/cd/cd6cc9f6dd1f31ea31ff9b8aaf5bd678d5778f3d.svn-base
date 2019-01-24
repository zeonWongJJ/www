<?php
defined('BASEPATH') or exit('禁止访问！');
class Balance_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('balance_model');
		$this->load->model('allow_model');
	}

/********************************* 我的余额 *********************************/

	public function user_balance() {
		// 验证是否登录
		$this->allow_model->is_login();
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 获取用户的基本信息
			$user_id = $_SESSION['user_id'];
			$a_data['user'] = $this->balance_model->get_user_one($user_id);
			// 获取用户的资金明细
			$a_data['userbalance'] = $this->balance_model->get_user_balance($user_id, 1);
			$this->view->display('user_balance', $a_data);
		}
	}

/********************************* 获取更多 *********************************/

	public function balance_getmore() {
		// 验证是否登录
		$this->allow_model->is_login();
		$page = trim($this->general->post('page'));
		$user_id = $_SESSION['user_id'];
		$a_data = $this->balance_model->get_user_balance($user_id, $page);
		if (empty($a_data)) {
			echo json_encode(array('code'=>400, 'msg'=>'没有更多数据', 'data'=>''));
		} else {
			foreach ($a_data as $key => $value) {
				$value['ub_time'] = date('Y-m-d',$value['ub_time']);
				$new_data[] = $value;
			}
			echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$new_data));
		}
	}

/********************************* 充值余额 *********************************/

	public function balance_recharge() {
		// 验证是否登录
		$this->allow_model->is_login();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$pay_type = trim($this->general->post('pay_type'));
			$recharge_money = trim($this->general->post('recharge_money'));
			// 验证数据合法性
			$a_parameter = [
				'msg'      => '这是提示信息',
				'url'      => 'user_balance',
				'log'      => false,
				'wait'     => 2,
			];
			// 验证是否为空
			if (empty($pay_type) || empty($recharge_money) || $recharge_money < 0) {
				$a_parameter['msg'] = '支付方式或者充值金额错误';
				$a_parameter['url'] = 'balance_recharge';
				$this->error->show_error($a_parameter);
			}
			// 根据支付方式不同加载不同支付类
			if ($pay_type == 1) {
				// 加载手机版支付接口类
				$this->load->library('alipay_wap');
				$a_data = [
					// 商户订单号，商户网站订单系统中唯一订单号，必填
					'out_trade_no' => 'ALIPAY'.date('YmdHis', time()).$_SESSION['user_id'],
					// 订单名称，必填
					'subject' => '余额充值',
					// 付款金额，必填
					'total_amount' => $recharge_money,
					// 商品描述，可空
					'body' => '余额充值',
					/** 该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，
						1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。
						该参数数值不接受小数点， 如 1.5h，可转换为 90m。
					*/
					'timeout_express' => '24h',
					// 设置是跳转到支付宝页面，还是返回执行结果，默认为前者，这里我们要设置为获取执行结果
					// 异步通知地址，当设置此参数时，将忽略配置文件中的通知地址
					'notify_url' => $this->router->url('recharge_alipaynot'),
					// 'notify_url' => 'http://wofei_wap.7dugo.com/recharge_alipaynot',
					// 同步通知地址，当设置此参数时，将忽略配置文件中的通知地址
					'return_url' => $this->router->url('recharge_alipayret'),
					// 'return_url' => 'http://wofei_wap.7dugo.com/recharge_alipayret',
				];
				echo $a = $this->alipay_wap->pay($a_data);
			} else if ($pay_type == 2) {
				$a_data = [
					// 商品描述, 必填
					'body' => '余额充值',
					// 商户订单号, 必填
					'out_trade_no' => 'WXPAY'.date('YmdHis', time()).$_SESSION['user_id'],
					// 标价金额,以分为单位, 必填
					'total_fee' => $recharge_money*100,
					// 终端IP, 必填
					'spbill_create_ip' => $this->general->get_ip(),
					// 通知地址
					'notify_url' => $this->router->url('recharge_wxpaynot'),
					// 'notify_url' => 'http://wofei_wap.7dugo.com/recharge_wxpaynot.html',
				];
				$this->load->library('wxpay_h5', '', [$a_data]);
				$a_result = $this->wxpay_h5->pay();

				// 这里是支付链接
				// echo '<a href="' . $a_result['mweb_url'] . '">支付</a>';
				$url = $a_result['mweb_url'];
				header("location:$url");
			} else {
				$this->load->library('unionpay_geteway');
				$a_param = [
					// 订单号
					'id_order' => 'UNIONPAY'.date('YmdHis', time()).$_SESSION['user_id'],
					// 订单金额，以分为单位
					'amount' => $recharge_money*100,
					// （选填）前台返回链接， 不传此参数将默认使用配置文件中的设置url
					'url_front' => $this->router->url('recharge_unionret'),
					// （选填）后台返回链接， 不传此参数将默认使用配置文件中的设置url
					'url_back' => $this->router->url('recharge_unionnot')
				];
				$a_result = $this->unionpay_geteway->pay($a_param);
				print_r($a_result);
			}
		} else {
			$this->view->display('balance_recharge');
		}
	}

/********************************* 支付宝同步通知 *********************************/

	public function recharge_alipayret() {
		$this->load->library('alipay_wap');
		// 安全验证，确认是不是支付宝返回的正确数据
		$a_parameter = [
			'msg'      => '这是提示信息',
			'url'      => '这是要跳转到的url',
			'log'      => false,
			'wait'     => 2,
		];
		if ($this->alipay_wap->verify($_GET)) {
			// 查询订单证实是否支付成功
			$a_data = [
				// 商户订单号，商户网站订单系统中唯一订单号，必填
				'out_trade_no' => $_GET['out_trade_no'],
				// 支付宝交易号，和上面的参数二选一
				'trade_no'     => '',
				'is_page'      => false
			];
			// 显示返回的查询结果
			$pay_result = $this->alipay_wap->query($a_data);
			if ($pay_result['code'] == 10000) {
				$a_parameter['msg'] = '充值成功';
				$a_parameter['url'] = 'user_balance';
				$this->error->show_success($a_parameter);
        	} else {
				$a_parameter['msg'] = '充值失败';
				$a_parameter['url'] = 'user_balance';
				$this->error->show_error($a_parameter);
        	}
		} else {
			// 没有通过验证，肯定数据有问题，不做任何处理
			$a_parameter['msg'] = '充值失败';
			$a_parameter['url'] = 'user_balance';
			$this->error->show_error($a_parameter);
		}
	}

/******************************** 支付宝异步 ********************************/

	public function recharge_alipaynot() {
		$this->load->library('alipay_wap');
		// 安全验证，确认是不是支付宝返回的正确数据
		if ($this->alipay_wap->verify($_POST, 'notify') && ($_POST['trade_status'] == 'TRADE_SUCCESS' || $_POST['trade_status'] == 'TRADE_FINISHED')) {
			// 支付成功后插入一条变动信息
			$user_id = substr($_POST['out_trade_no'], 20);
			$a_user = $this->balance_model->get_user_one($user_id);
			$a_data = [
				'ub_type'        => 1,
				'ub_money'       => $_POST['total_amount'],
				'ub_balance'     => $a_user['user_balance'] + $_POST['total_amount'],
				'ub_time'        => $_SERVER['REQUEST_TIME'],
				'ub_item'        => '余额充值',
				'ub_description' => '使用支付宝进行了充值',
				'user_id'        => $user_id,
				'ub_number'      => $_POST['out_trade_no'],
			];
			$i_result = $this->balance_model->insert_userbalance($a_data);
			// 将用户的余额加上
			$a_where = [
				'user_id' => $user_id,
			];
			$a_udata = [
				'user_balance' => $a_user['user_balance'] + $_POST['total_amount'],
			];
			$i_uint = $this->balance_model->update_user($a_where, $a_udata);
			echo "success";
		} else {
			// 没有通过验证，肯定数据有问题，不做任何处理
		}
	}

/********************************* 微信异步 *********************************/

	// 异步通知
	public function recharge_wxpaynot() {
		// 接收微信返回的通知xml数据， 也可以用 $GLOBALS['HTTP_RAW_POST_DATA'] 获取post数据
		$s_xml = file_get_contents('php://input');
		// 加载微信支付类
		$this->load->library('wxpay_h5');
		// 把微信返回的通知xml数据转换为数组格式
		$a_data = $this->wxpay_h5->xml_to_array($s_xml);

		// 验证签名成功
		if ($this->wxpay_h5->verify($a_data)) {
			// 判断结果的状态是否为成功， 第二个参数支持：PAY/REFUND/QUERY 等，对应相应的函数
			if ($this->wxpay_h5->check($a_data, 'PAY')) {
				// 也可以用自行验证，但是需要自己查阅微信接口文档，因为不同的操作，验证参数不一样
				//if ($a_data['return_code'] == 'SUCCESS' && $a_data['result_code'] == 'SUCCESS') {

				// 处理订单逻辑，比如更新订单的状态为付款成功等

				$user_id = substr($a_data['out_trade_no'], 19);
				// 支付成功后插入一条变动信息
				$a_user = $this->balance_model->get_user_one($user_id);
				$a_insert_data = [
					'ub_type'        => 1,
					'ub_money'       => $a_data['total_fee']/100,
					'ub_balance'     => $a_user['user_balance'] + $a_data['total_fee']/100,
					'ub_time'        => $_SERVER['REQUEST_TIME'],
					'ub_item'        => '余额充值',
					'ub_description' => '使用微信进行了充值',
					'user_id'        => $user_id,
					'ub_number'      => $a_data['out_trade_no'],
				];
				$i_result = $this->balance_model->insert_userbalance($a_insert_data);
				// 将用户的余额加上
				$a_where = [
					'user_id' => $user_id,
				];
				$a_udata = [
					'user_balance' => $a_user['user_balance'] + $a_data['total_fee']/100,
				];
				$i_uint = $this->balance_model->update_user($a_where, $a_udata);

				// 通知微信，我们已经收到消息，知道付款成功了，如果不通知微信，微信会一直给我们发消息
				echo $this->wxpay_h5->success();
			} else {
				// 支付结果失败，所以这里是不能更新付款状态为成功的
			}
		} else {
			// 验证签名失败，数据肯定存在问题，所以不做任何处理，无视即可
		}
	}

/********************************* 银联同步 *********************************/

	public function recharge_unionret() {
		$this->load->library('unionpay_geteway');
		// 安全验证，确认是不是银联返回的正确数据
		if ($this->unionpay_geteway->verify($this->general->post())) {
			$a_data = $this->general->post();
			// 验证签名成功
			if ($a_data['respCode'] == '00') {
				// 把订单的状态改为已经付款成功
				// 进行交易相关的业务逻辑处理
				$a_parameter = [
					'msg'      => '充值成功',
					'url'      => 'user_balance',
					'log'      => false,
					'wait'     => 2,
				];
				$this->error->show_success($a_parameter);
			} elseif (in_array($a_data['respCode'], ['03', '04', '05'])) {
				$a_parameter = [
					'msg'      => '正在处理中',
					'url'      => 'user_balance',
					'log'      => false,
					'wait'     => 2,
				];
				$this->error->show_error($a_parameter);
			} else {
				$a_parameter = [
					'msg'      => '充值失败',
					'url'      => 'user_balance',
					'log'      => false,
					'wait'     => 2,
				];
				$this->error->show_error($a_parameter);
			}
		} else {
			// 没有通过验证，肯定数据有问题，不做任何处理
		}
	}

/********************************* 银联异步 *********************************/

	public function recharge_unionnot() {
		$this->load->library('unionpay_geteway');
		// 安全验证，确认是不是银联返回的正确数据
		if ($this->unionpay_geteway->verify($this->general->post())) {
			$a_data = $this->general->post();
			// 验证签名成功
			if ($a_data['respCode'] == '00') {
				// 把订单的状态改为已经付款成功
				// 进行交易相关的业务逻辑处理
				$user_id = substr($a_data['orderId'], 22);
				// 支付成功后插入一条变动信息
				$a_user = $this->balance_model->get_user_one($user_id);
				$a_insert_data = [
					'ub_type'        => 1,
					'ub_money'       => $a_data['txnAmt']/100,
					'ub_balance'     => $a_user['user_balance'] + $a_data['txnAmt']/100,
					'ub_time'        => $_SERVER['REQUEST_TIME'],
					'ub_item'        => '余额充值',
					'ub_description' => '使用银行卡进行了充值',
					'user_id'        => $user_id,
					'ub_number'      => $a_data['orderId'],
				];
				$i_result = $this->balance_model->insert_userbalance($a_insert_data);
				// 将用户的余额加上
				$a_where = [
					'user_id' => $user_id,
				];
				$a_udata = [
					'user_balance' => $a_user['user_balance'] + $a_data['txnAmt']/100,
				];
				$i_uint = $this->balance_model->update_user($a_where, $a_udata);

			} elseif (in_array($a_data['respCode'], ['03', '04', '05'])) {

			} else {

			}
		} else {
			// 没有通过验证，肯定数据有问题，不做任何处理
		}
	}

/********************************* 明细详情 *********************************/

	public function balance_detail() {
		// 验证是否登录
		$this->allow_model->is_login();
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收需要查看详情的id
			$ub_id = $this->router->get(1);
			// 获取一条明细信息
			$a_data['detail'] = $this->balance_model->get_balance_one($ub_id);
			$this->view->display('balance_detail', $a_data);
		}
	}

/******************************** 用户总资产 ********************************/

	public function user_asset() {
		// 验证是否登录
		$this->allow_model->is_login();
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$user_id = $_SESSION['user_id'];
			$a_data['user'] = $this->balance_model->get_user_one($user_id);
			$this->view->display('user_asset', $a_data);
		}
	}

/********************************* 余额提现 *********************************/

	public function withdraw_balance() {
		$this->allow_model->is_login();
		$user_id = $_SESSION['user_id'];
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data['user'] = $this->balance_model->get_user_one($user_id);
			$this->view->display('withdraw_balance', $a_data);
		} else {
			// 接收数据
			$withdraw_type    = trim($this->general->post('withdraw_type'));
			$withdraw_account = trim($this->general->post('withdraw_account'));
			$withdraw_name    = trim($this->general->post('withdraw_name'));
			$withdraw_money   = trim($this->general->post('withdraw_money'));
			$payment_code     = trim($this->general->post('payment_code'));
			// 验证数据合法性
			$a_parameter = [
				'msg'      => '这是提示信息',
				'url'      => 'user_asset',
				'log'      => false,
				'wait'     => 2,
			];
			// 验证金额大小
			if ((float)$withdraw_money < 0.1) {
				$a_parameter['url'] = 'withdraw_balance';
				$a_parameter['msg'] = '提现金额不能小于0.1';
				$this->error->show_error($a_parameter);
			}
			// 验证必填项是否为空
			if (empty($withdraw_type) || empty($withdraw_account) || empty($withdraw_name) || empty($payment_code) || empty($withdraw_money)) {
				$a_parameter['url'] = 'withdraw_balance';
				$a_parameter['msg'] = '必填项不能为空';
				$this->error->show_error($a_parameter);
			}
			// 验证支付密码
			$a_user = $this->balance_model->get_user_one($user_id);
			// 验证支付密码是否为空
			if (empty($a_user['payment_code'])) {
				$a_parameter['url'] = 'user_update';
				$a_parameter['msg'] = '请先设置支付密码';
				$this->error->show_error($a_parameter);
			}
			// 验证支付密码是否正确
			if (md5(md5($payment_code)) != $a_user['payment_code']) {
				$a_parameter['url'] = 'withdraw_balance';
				$a_parameter['msg'] = '提现密码不正确';
				$this->error->show_error($a_parameter);
			}
			// 验证提现金额
			if ($withdraw_money > $a_user['user_balance']) {
				$a_parameter['url'] = 'withdraw_balance';
				$a_parameter['msg'] = '提现金额不合法';
				$this->error->show_error($a_parameter);
			}
			// 根据不同的提现方式执行不同业务
			if ($withdraw_type == 1) {
				// 此处为提现到支付宝
				// 加载转账的类
				$this->load->library('alipay_wap');
				// 订单号
				$ub_number = 'WITHDRAW' . date('Ymdhis', time()) . $user_id;
				$a_data = [
					'out_biz_no'      => $ub_number,
					'payee_account'   => $withdraw_account,
					'amount'          => $withdraw_money,
					'payee_real_name' => $withdraw_name,
					'remark'          => '余额提现',
					// 设置是跳转到支付宝页面，还是返回执行结果，默认为前者，这里我们要设置为获取执行结果
					'is_page'         => false
				];
				$a_result = $this->alipay_wap->transfer($a_data);
				if ($a_result['code'] == 10000) {
					// 提现成功的业务
					// 插入一条余额详情记录
					$a_insert_data = [
						'ub_type'        => 2,
						'ub_money'       => $withdraw_money,
						'ub_balance'     => $a_user['user_balance'] - $withdraw_money,
						'ub_time'        => $_SERVER['REQUEST_TIME'],
						'ub_item'        => '余额提现',
						'ub_description' => '提现到支付宝账号' . $withdraw_account,
						'user_id'        => $_SESSION['user_id'],
						'ub_number'      => $ub_number,
					];
					$i_result = $this->balance_model->insert_userbalance($a_insert_data);
					// 减少用户的余额
					$a_uwhere = [
						'user_id' => $_SESSION['user_id'],
					];
					$a_udata = [
						'user_balance' => $a_user['user_balance'] - $withdraw_money,
					];
					$i_uint = $this->balance_model->update_user($a_uwhere, $a_udata);
					// 页面跳转
					$a_parameter['msg'] = '提现成功';
					$a_parameter['url'] = 'user_asset';
					$this->error->show_success($a_parameter);
				}
			} else {
				// 此处为提现到银行卡
				$open_bank = trim($this->general->post('open_bank'));
				$prov      = trim($this->general->post('prov'));
				$city      = trim($this->general->post('city'));
				$sub_bank  = trim($this->general->post('sub_bank'));
				$mer_date = date('Ymd', time());
				$mer_seqId = date('Ymdhis', time()) . $user_id;
				// 验证是否为空
				if (empty($open_bank) || empty($prov) || empty($city) || empty($sub_bank)) {
					$a_parameter['msg'] = '必填项不能为空';
					$a_parameter['url'] = 'user_asset';
					$this->error->show_error($a_parameter);
				}
				// 加载银联代付接口
				$this->load->library('unionpay_transfer');
				$a_param = [
					// 标志该笔交易发生的日期,格式为YYYYMMDD，请填写当天的日期。
					'mer_date' => $mer_date,
					// 订单号，商户流水号
					'mer_seqId' => $mer_seqId,
					// 银行卡号或者存折号
					'card_no' => $withdraw_account,
					// 收款人在银行开户时留存的开户姓名
					'usr_name' => $withdraw_name,
					// 开户银行名称
					'open_bank' => $open_bank,
					// 收款人开户行所在省
					'prov' => $prov,
					// 收款人开户行所在地区
					'city' => $city,
					// 金额，整数，货币种类为人民币，以分为单位
					'trans_amt' => $withdraw_money*100,
					// 存款用途。
					'purpose' => '余额提现',
					// 开户支行名称。
					'sub_bank' => $sub_bank,
					// 对公对私标记。“00”对私，“01”对公。该字段可以不填，如不填则默认为对私。
					'flag' => '00',
					// 表示商户代付业务使用场景，（业务参数）07：互联网；08：移动端
					'term_type' => '07',
					// 表示商户代付业务交易模式（业务参数），0：被动发起代付，1：主动发起代付
					'pay_mode' => '1'
				];
				$a_result = $this->unionpay_transfer->pay($a_param);
				if ($a_result['responseCode'] == '0000') {
					if ($a_result['stat'] == 's' || $a_result['stat'] == 2 || $a_result['stat'] == 3 || $a_result['stat'] == 4 || $a_result['stat'] == 5 || $a_result['stat'] == 7 || $a_result['stat'] == 8) {
						// 处理相关业务
						// 插入一条余额详情记录
						$a_insert_data = [
							'ub_type'        => 2,
							'ub_money'       => $withdraw_money,
							'ub_balance'     => $a_user['user_balance'] - $withdraw_money,
							'ub_time'        => $_SERVER['REQUEST_TIME'],
							'ub_item'        => '余额提现',
							'ub_description' => '提现到银行卡' . $withdraw_account,
							'user_id'        => $_SESSION['user_id'],
							'ub_number'      => $mer_seqId,
						];
						$i_result = $this->balance_model->insert_userbalance($a_insert_data);
						// 减少用户的余额
						$a_uwhere = [
							'user_id' => $_SESSION['user_id'],
						];
						$a_udata = [
							'user_balance' => $a_user['user_balance'] - $withdraw_money,
						];
						$i_uint = $this->balance_model->update_user($a_uwhere, $a_udata);
						// 页面跳转
						$a_parameter['msg'] = '提现成功';
						$a_parameter['url'] = 'user_asset';
						$this->error->show_success($a_parameter);
					} elseif ($a_result['stat'] == 6 || $a_result['stat'] == 9) {
						$a_parameter['msg'] = '提现失败';
						$a_parameter['url'] = 'user_asset';
						$this->error->show_error($a_parameter);
					}
				} else {
					$a_parameter['msg'] = '提现失败';
					$a_parameter['url'] = 'user_asset';
					$this->error->show_error($a_parameter);
				}
			}
		}
	}

/********************************* 积分提现 *********************************/

	public function withdraw_score() {
		$this->allow_model->is_login();
		$user_id = $_SESSION['user_id'];
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 获取用户信息
			$a_data['user'] = $this->balance_model->get_user_one($user_id);
			// 获取积分提现比例
			$a_set = $this->balance_model->get_set_all();
			foreach ($a_set as $key => $value) {
				if ($value['set_name'] == 'user_score_cash') {
					$a_data['set'] = $value['set_parameter']/100;
				}
			}
			$this->view->display('withdraw_score', $a_data);
		} else {
			// 接收数据
			$withdraw_type    = trim($this->general->post('withdraw_type'));
			$withdraw_account = trim($this->general->post('withdraw_account'));
			$withdraw_name    = trim($this->general->post('withdraw_name'));
			$withdraw_score   = trim($this->general->post('withdraw_score'));
			$payment_code     = trim($this->general->post('payment_code'));
			// 验证数据合法性
			$a_parameter = [
				'msg'      => '这是提示信息',
				'url'      => 'user_asset',
				'log'      => false,
				'wait'     => 2,
			];
			// 验证必填项是否为空
			if (empty($withdraw_type) || empty($withdraw_account) || empty($withdraw_name) || empty($payment_code) || empty($withdraw_score)) {
				$a_parameter['url'] = 'withdraw_score';
				$a_parameter['msg'] = '必填项不能为空';
				$this->error->show_error($a_parameter);
			}
			// 验证支付密码
			$a_user = $this->balance_model->get_user_one($user_id);
			// 验证支付密码是否为空
			if (empty($a_user['payment_code'])) {
				$a_parameter['url'] = 'user_update';
				$a_parameter['msg'] = '请先设置支付密码';
				$this->error->show_error($a_parameter);
			}
			// 验证支付密码是否正确
			if (md5(md5($payment_code)) != $a_user['payment_code']) {
				$a_parameter['url'] = 'withdraw_score';
				$a_parameter['msg'] = '提现密码不正确';
				$this->error->show_error($a_parameter);
			}
			// 验证提现积分
			if ($withdraw_score > $a_user['user_score']) {
				$a_parameter['url'] = 'withdraw_score';
				$a_parameter['msg'] = '提现金额不合法';
				$this->error->show_error($a_parameter);
			}
			// 将积分将成金钱
			$a_set = $this->balance_model->get_set_all();
			foreach ($a_set as $key => $value) {
				if ($value['set_name'] == 'user_score_cash') {
					$user_score_cash = $value['set_parameter']/100;
				}
			}
			// 可提现金钱
			$withdraw_money = $user_score_cash * $withdraw_score;
			// 验证金额大小
			if ((float)$withdraw_money < 0.1) {
				$a_parameter['url'] = 'withdraw_balance';
				$a_parameter['msg'] = '提现金额不能小于0.1';
				$this->error->show_error($a_parameter);
			}
			// 根据提现方式加载不同类
			if ($withdraw_type == 1) {
				// 此处为提现到支付宝
				// 加载转账的类
				$this->load->library('alipay_wap');
				// 订单号
				$ub_number = 'WITHDRAW' . date('Ymdhis', time()) . $user_id;
				$a_data = [
					'out_biz_no'      => $ub_number,
					'payee_account'   => $withdraw_account,
					'amount'          => $withdraw_money,
					'payee_real_name' => $withdraw_name,
					'remark'          => '余额提现',
					// 设置是跳转到支付宝页面，还是返回执行结果，默认为前者，这里我们要设置为获取执行结果
					'is_page'         => false
				];
				$a_result = $this->alipay_wap->transfer($a_data);
				if ($a_result['code'] == 10000) {
					// 提现成功的业务
					$a_insert_data = [
						'user_id'        => $_SESSION['user_id'],
						'user_name'      => $a_user['user_name'],
						'pl_type'        => 2,
						'pl_variation'   => $withdraw_score,
						'pl_score'       => $a_user['user_score'] - $withdraw_score,
						'pl_item'        => '积分提现',
						'pl_description' => '提现到支付宝账号' . $withdraw_account,
						'pl_time'        => $_SERVER['REQUEST_TIME'],
						'pl_code'        => 3,
					];
					$i_result = $this->balance_model->insert_points_log($a_insert_data);
					// 减少用户的积分
					$a_uwhere = [
						'user_id' => $_SESSION['user_id'],
					];
					$a_udata = [
						'user_score' => $a_user['user_score'] - $withdraw_score,
					];
					$i_uint = $this->balance_model->update_user($a_uwhere, $a_udata);
					// 页面跳转
					$a_parameter['msg'] = '提现成功';
					$a_parameter['url'] = 'user_asset';
					$this->error->show_success($a_parameter);
				}
			} else {
				// 此处为提现到银行卡
				$open_bank = trim($this->general->post('open_bank'));
				$prov      = trim($this->general->post('prov'));
				$city      = trim($this->general->post('city'));
				$sub_bank  = trim($this->general->post('sub_bank'));
				$mer_date = date('Ymd', time());
				$mer_seqId = date('Ymdhis', time()) . $user_id;
				// 验证是否为空
				if (empty($open_bank) || empty($prov) || empty($city) || empty($sub_bank)) {
					$a_parameter['msg'] = '必填项不能为空';
					$a_parameter['url'] = 'user_asset';
					$this->error->show_error($a_parameter);
				}
				// 加载银联代付接口
				$this->load->library('unionpay_transfer');
				$a_param = [
					// 标志该笔交易发生的日期,格式为YYYYMMDD，请填写当天的日期。
					'mer_date' => $mer_date,
					// 订单号，商户流水号
					'mer_seqId' => $mer_seqId,
					// 银行卡号或者存折号
					'card_no' => $withdraw_account,
					// 收款人在银行开户时留存的开户姓名
					'usr_name' => $withdraw_name,
					// 开户银行名称
					'open_bank' => $open_bank,
					// 收款人开户行所在省
					'prov' => $prov,
					// 收款人开户行所在地区
					'city' => $city,
					// 金额，整数，货币种类为人民币，以分为单位
					'trans_amt' => $withdraw_money*100,
					// 存款用途。
					'purpose' => '余额提现',
					// 开户支行名称。
					'sub_bank' => $sub_bank,
					// 对公对私标记。“00”对私，“01”对公。该字段可以不填，如不填则默认为对私。
					'flag' => '00',
					// 表示商户代付业务使用场景，（业务参数）07：互联网；08：移动端
					'term_type' => '07',
					// 表示商户代付业务交易模式（业务参数），0：被动发起代付，1：主动发起代付
					'pay_mode' => '1'
				];
				$a_result = $this->unionpay_transfer->pay($a_param);
				if ($a_result['responseCode'] == '0000') {
					if ($a_result['stat'] == 's' || $a_result['stat'] == 2 || $a_result['stat'] == 3 || $a_result['stat'] == 4 || $a_result['stat'] == 5 || $a_result['stat'] == 7 || $a_result['stat'] == 8) {
						// 处理相关业务
						// 插入一条积分详情记录
						$a_insert_data = [
							'user_id'        => $_SESSION['user_id'],
							'user_name'      => $a_user['user_name'],
							'pl_type'        => 2,
							'pl_variation'   => $withdraw_score,
							'pl_score'       => $a_user['user_score'] - $withdraw_score,
							'pl_item'        => '积分提现',
							'pl_description' => '提现到银行卡' . $withdraw_account,
							'pl_time'        => $_SERVER['REQUEST_TIME'],
							'pl_code'        => 3,
						];
						$i_result = $this->balance_model->insert_points_log($a_insert_data);
						// 减少用户的积分
						$a_uwhere = [
							'user_id' => $_SESSION['user_id'],
						];
						$a_udata = [
							'user_score' => $a_user['user_score'] - $withdraw_score,
						];
						$i_uint = $this->balance_model->update_user($a_uwhere, $a_udata);
						// 页面跳转
						$a_parameter['msg'] = '提现成功';
						$a_parameter['url'] = 'user_asset';
						$this->error->show_success($a_parameter);
					} elseif ($a_result['stat'] == 6 || $a_result['stat'] == 9) {
						$a_parameter['msg'] = '提现失败';
						$a_parameter['url'] = 'user_asset';
						$this->error->show_error($a_parameter);
					}
				} else {
					$a_parameter['msg'] = '提现失败';
					$a_parameter['url'] = 'user_asset';
					$this->error->show_error($a_parameter);
				}
			}
		}
	}


	public function weixin_ispay_ban() {
		$a_data = $this->balance_model->get_ub_second();
		if ($a_data) {
			echo json_encode(array('code'=>200));
		} else {
			echo json_encode(array('code'=>400));
		}
	}

/****************************************************************************/

}

?>