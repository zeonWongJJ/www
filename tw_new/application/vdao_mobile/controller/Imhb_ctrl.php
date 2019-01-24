<?php

defined('BASEPATH') or exit('禁止访问！');

class Imhb_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('imhb_model');
	}

/**************************************** 发红包 ****************************************/

	public function im_fhb() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 验证token
			$this->load->model('oauth2_model');
			$access_token = $_GET['access_token'];
			$access_token_data = $this->oauth2_model->oauth2_resource();
			if (!$access_token) {
				echo json_encode(array('code'=>400, 'msg'=>'access_token过期或非法', 'data'=>''));
				die;
			}
			// 获取用户id
			$a_token = $this->imhb_model->get_token_one($access_token_data['access_token']);
			$user_id = $a_token['user_id'];
			// 获取用户的信息
			$a_user = $this->imhb_model->get_user_one($user_id);
			// 接收提交的信息
			$hb_amount    = trim($this->general->post('hb_amount'));
			$hb_message   = trim($this->general->post('hb_message'));
			$payment_code = trim($this->general->post('payment_code'));
			$pay_type     = trim($this->general->post('pay_type'));
			$hb_total     = trim($this->general->post('hb_total'));
			$a_parameter = [
				'msg'      => '这里是提示',
				'url'      => $this->router->get_url(),
				'log'      => false,
				'wait'     => 2,
			];
			// 验证数据是否正确
			if (empty($hb_amount) || empty($payment_code) || empty($pay_type)) {
				$a_parameter['msg'] = '必填项不能为空';
				$this->error->show_error($a_parameter);
			}
			// 验证红包金额是否合法
			if (($hb_amount/$hb_total) < 0.01) {
				$a_parameter['msg'] = '单个红包金额必须大于0.01';
				$this->error->show_error($a_parameter);
			}
			// 判断用户是否有设置支付密码
			if (empty($a_user['payment_code'])) {
				$a_parameter['msg'] = '请先设置支付密码';
				$this->error->show_error($a_parameter);
			}
			// 判断支付密码是否正确
			if (md5(md5($payment_code)) != $a_user['payment_code']) {
				$a_parameter['msg'] = '支付密码错误';
				$this->error->show_error($a_parameter);
			}
			if ($pay_type == 1) {
				// 判断余额是否足够
				if ($a_user['user_balance'] < $hb_amount) {
					$a_parameter['msg'] = '您的余额不足';
					$this->error->show_error($a_parameter);
				}
				// 验证通过则发送红包
				// 检测是否触发异常
				try {
					// 开启事务
					$this->db->begin();
					// 执行数据库操作
					$a_inser_data = [
						'user_id'    => $user_id,
						'hb_type'    => 2,
						'hb_amount'  => $hb_amount,
						'pay_type'   => $pay_type,
						'hb_message' => $hb_message,
						'hb_balance' => $hb_amount,
						'hb_total'   => $hb_total,
						'hb_remain'  => $hb_total,
						'hb_time'    => $_SERVER['REQUEST_TIME'],
					];
					$i_hbid = $this->imhb_model->insert_hongbao($a_inser_data);
					// 减少用户的的余额[更新用户表]
					$a_update_where = [
						'user_id' => $user_id
					];
					$a_update_data = [
						'user_balance'  => $a_user['user_balance'] - $hb_amount,
						'user_fhbtotal' => $a_user['user_fhbtotal'] + 1,
					];
					$i_result = $this->imhb_model->update_user($a_update_where, $a_update_data);;
					if ($i_hbid && $i_result) {
						// 提交事务
						$this->db->commit();
						echo json_encode(array('code'=>200, 'msg'=>'发送成功', 'data'=>$a_inser_data));
					} else {
						// 事务回滚
						$this->db->roll_back();
						echo json_encode(array('code'=>400, 'msg'=>'发送失败', 'data'=>''));
					}
				} catch (Exception $e) { // 捕获异常
					// 事务回滚
					$this->db->roll_back();
					echo json_encode(array('code'=>400, 'msg'=>'发送失败', 'data'=>''));
				}
			} else if ($pay_type == 2) {
				// 以下为支付宝支付
				// 加载手机版支付接口类
				$this->load->library('alipay_wap');
				$a_data = [
					// 商户订单号，商户网站订单系统中唯一订单号，必填
					'out_trade_no' => date('Ymdhis', time()) . rand(100, 999),// '201781113588902',
					// 订单名称，必填
					'subject' => '红包支付测试',
					// 付款金额，必填
					'total_amount' => '0.01',
					// 商品描述，可空
					'body' => '测试',
					/** 该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，
						1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。
						该参数数值不接受小数点， 如 1.5h，可转换为 90m。
					*/
					'timeout_express' => '24h',
					// 设置是跳转到支付宝页面，还是返回执行结果，默认为前者，这里我们要设置为获取执行结果
					// 异步通知地址，当设置此参数时，将忽略配置文件中的通知地址
					'notify_url' => 'http://wofei_wap.7dugo.com/hb_alipaynot',
					// 同步通知地址，当设置此参数时，将忽略配置文件中的通知地址
					'return_url' => 'http://wofei_wap.7dugo.com/hb_alipayret',
				];
				echo $a = $this->alipay_wap->pay($a_data);
			}
		} else {
			// 展示页面
			$this->view->display('im_fhb');
		}
	}

	public function hb_alipayret() {
		$this->load->library('alipay_wap');
		// 安全验证，确认是不是支付宝返回的正确数据
		if ($this->alipay_wap->verify($_GET)) {
			echo "<pre>";
			var_dump($_GET);die;
			echo '支付成功';
			// 验证通过则发送红包
			// 检测是否触发异常
			try {
				// 开启事务
				$this->db->begin();
				// 执行数据库操作
				$a_inser_data = [
					'user_id'    => $user_id,
					'hb_type'    => 2,
					'hb_amount'  => $hb_amount,
					'pay_type'   => $pay_type,
					'hb_message' => $hb_message,
					'hb_balance' => $hb_amount,
					'hb_total'   => $hb_total,
					'hb_remain'  => $hb_total,
					'hb_time'    => $_SERVER['REQUEST_TIME'],
				];
				$i_hbid = $this->imhb_model->insert_hongbao($a_inser_data);
				// 减少用户的的余额[更新用户表]
				$a_update_where = [
					'user_id' => $user_id
				];
				$a_update_data = [
					'user_fhbtotal' => $a_user['user_fhbtotal'] + 1,
				];
				$i_result = $this->imhb_model->update_user($a_update_where, $a_update_data);;
				if ($i_hbid && $i_result) {
					// 提交事务
					$this->db->commit();
					echo json_encode(array('code'=>200, 'msg'=>'发送成功', 'data'=>$a_inser_data));
				} else {
					// 事务回滚
					$this->db->roll_back();
					echo json_encode(array('code'=>400, 'msg'=>'发送失败', 'data'=>''));
				}
			} catch (Exception $e) { // 捕获异常
				// 事务回滚
				$this->db->roll_back();
				echo json_encode(array('code'=>400, 'msg'=>'发送失败', 'data'=>''));
			}
		} else {
			// 没有通过验证，肯定数据有问题，不做任何处理
		}
	}

	public function hb_alipaynot() {
		$this->load->library('alipay_wap');

		// 安全验证，确认是不是支付宝返回的正确数据
		if ($this->alipay_wap->verify($_GET)) {
			// 验证成功，证实是支付宝返回的正确数据
			// 把订单的状态改为已经付款成功
			// 进行交易相关的业务逻辑处理
		} else {
			// 没有通过验证，肯定数据有问题，不做任何处理
		}
	}

/**************************************** 收红包 ****************************************/

	public function im_shb() {
		// 验证token
		$this->load->model('oauth2_model');
		$access_token = $_GET['access_token'];
		$access_token_data = $this->oauth2_model->oauth2_resource();
		if (!$access_token) {
			echo json_encode(array('code'=>400, 'msg'=>'access_token过期或非法', 'data'=>''));
			die;
		}
		// 获取用户id
		$a_token = $this->imhb_model->get_token_one($access_token_data['access_token']);
		$user_id = $a_token['user_id'];
		// 获取用户的信息
		$a_user = $this->imhb_model->get_user_one($user_id);
		// 接收信息
		$hb_fid = trim($this->general->post('hb_fid'));
		// 验证之前是否领过
		$i_thisuser_thishb = $this->imhb_model->get_thisuser_hbcount($hb_fid, $user_id);
		if ($i_thisuser_thishb != 0) {
			echo json_encode(array('code'=>400, 'msg'=>'已经领过该红包啦！'));
			die;
		}
		// 查询红包余额
		$a_fdata = $this->imhb_model->get_hongbao_one($hb_fid);
		// 验证红包剩余数量及金额
		if ($a_fdata['hb_remain'] == 0 || $a_fdata['hb_balance'] == 0) {
			echo json_encode(array('code'=>400, 'msg'=>'红包已领完'));
			die;
		}
		// 判断收红包的类型
		if ($a_fdata['hb_total'] == 1) {
			$i_myamount = $a_fdata['hb_amount'];
		} else {
			// 群里抢红包
			if ($a_fdata['hb_remain'] == 1) {
				$i_myamount = $a_fdata['hb_balance'];
			} else {
				// 随机生成一个红包金额
				$i_myamount = $this->get_hb_amount(0, $a_fdata['hb_balance'], $a_fdata['hb_balance'], $a_fdata['hb_remain']);
			}
		}
		// 收红包
		// 检测是否触发异常
		try {
			$this->load->database('db');
			// 开启事务
			$this->db->begin();
			// 增加用户的余额
			$a_where_user = [
				'user_id' => $user_id,
			];
			$a_data_user = [
				'user_balance'  => $a_user['user_balance'] + $i_myamount,
				'user_shbtotal' => $a_user['user_shbtotal'] + 1,
			];
			$i_update_user = $this->imhb_model->update_user($a_where_user, $a_data_user);
			// 插入一条收红包记录
			$a_hongbao_insert = [
				'user_id'    => $user_id,
				'hb_type'    => 1,
				'hb_amount'  => $i_myamount,
				'hb_time'    => $_SERVER['REQUEST_TIME'],
				'hb_balance' => $a_fdata['hb_balance'] - $i_myamount,
				'hb_fhbid'   => $hb_fid,
				'hb_total'   => $a_fdata['hb_total'],
				'hb_remain'  => $a_fdata['hb_remain'] - 1,
			];
			$i_insert_result = $this->imhb_model->insert_hongbao($a_hongbao_insert);
			// 减少原发送红包的余额
			$a_fa_where = [
				'hb_id' => $hb_fid
			];
			$a_fa_data = [
				'hb_balance' => $a_fdata['hb_balance'] - $i_myamount,
				'hb_remain'  => $a_fdata['hb_remain'] - 1,
			];
			$i_fa_result = $this->imhb_model->update_hongbao($a_fa_where, $a_fa_data);
			// 拼装返回数据
			if ($i_update_user && $i_insert_result && $i_fa_result) {
				// 提交事务
				$this->db->commit();
				$a_readhb = $this->imhb_model->get_hongbao_receive($hb_fid);
				echo json_encode(array('code'=>200, 'msg'=>'领取成功', 'data'=>$a_readhb));
			} else {
				// 事务回滚
				$this->db->roll_back();
				echo json_encode(array('code'=>400, 'msg'=>'领取失败', 'data'=>''));
			}
		} catch (Exception $e) { // 捕获异常
			// 事务回滚
			$this->db->roll_back();
			echo json_encode(array('code'=>400, 'msg'=>'领取失败', 'data'=>''));
		}
	}

	// 生成一个随机红包金额
	public function get_hb_amount($min, $max, $hb_balance, $hb_remain) {
		$r_result = $min + mt_rand() / mt_getrandmax() * ($max - $min);
		$r_result = round($r_result, 2);
		$remain_v = ($hb_balance - $r_result)/($hb_remain-1);
		if ($remain_v < 0.01) {
			$this->get_hb_amount($min, $max, $hb_balance, $hb_remain);
		} else {
			return $r_result;
		}
	}

/************************************* 用户红包详情 *************************************/

	public function im_hbdetail() {
		// 验证token
		$this->load->model('oauth2_model');
		$access_token = $_GET['access_token'];
		$access_token_data = $this->oauth2_model->oauth2_resource();
		if (!$access_token) {
			echo json_encode(array('code'=>400, 'msg'=>'access_token过期或非法', 'data'=>''));
			die;
		}
		// 获取用户id
		$a_token = $this->imhb_model->get_token_one($access_token_data['access_token']);
		$user_id = $a_token['user_id'];
		// 获取用户的信息
		$a_user = $this->imhb_model->get_user_one($user_id);
		// 接收信息
		$pagesize = trim($this->general->post('pagesize'));
		$pagecount = trim($this->general->post('pagecount'));
		// 获取用户的红包列表
		$a_user_hb = $this->imhb_model->get_hongbao_user($user_id, $pagesize, $pagecount);
		if (empty($a_user_hb)) {
			echo json_encode(array('code'=>400, 'msg'=>'暂无信息', 'data'=>''));
		} else {
			echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$a_user_hb));
		}
	}

/****************************************************************************************/


}

?>