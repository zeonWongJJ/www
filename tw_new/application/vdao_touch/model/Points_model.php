<?php
date_default_timezone_set('PRC');
class Points_model extends TW_Model {
	public function __construct() {
        parent :: __construct();
    }

    //积分脱换金额
    public function points() {
    	//积分
    	$i_ouan    = $this->general->post('ouan');
    	//脱换金额
    	$i_eum     = $this->general->post('eum'); 
    	//脱换方式  	
    	$i_pattern = $this->general->post('pattern'); 
    	//转账的姓名
    	$a_name  = $this->general->post('name');
    	//脱换的账号
    	$a_number  = $this->general->post('number');
    	//提现密码
    	$a_paw     = $this->general->post('paw');
    	//判断脱换方式
		if($i_pattern == 1){
			$s_payment_code = 'online';
		} else if ($i_pattern == 2){
			$s_payment_code = 'offline';
		} else if($i_pattern == 3){
			$s_payment_code = 'alipay';
		} else if($i_pattern == 4){
			$s_payment_code = 'bank';
		} else {
			$this->error->show_error('脱换方式有误,请重新提交',$this->router->url('points'));
		}

		$a_user = $this->db->get_row('user', ['user_id' => $_SESSION['user_id']], ['user_score', 'payment_code']);
		if ($i_ouan > $a_user['user_score']) {
			$this->error->show_error('积分不足，请重填！',$this->router->url('points'));
		}
		if (md5(md5($a_paw)) != $a_user['payment_code']) {
			$this->error->show_error('密码错误，请重填！',$this->router->url('points'));
		}
		// 开启事务
		$this->db->begin();

		$a_data = [
			'user_id' => $_SESSION['user_id'],
			'user_name' => $_SESSION['user_name'],
			'points' => $i_ouan,
			'mou' => $i_eum ,
			'name' => $a_name ,
			'account' => $a_number,
			'payment_code' => $s_payment_code,
			'time_create' => $_SERVER['REQUEST_TIME']
		];
		//插入积分脱换points表数据
		$b_order = $this->db->insert('points', $a_data);

		if($b_order != false){
			$this->db->commit();
		} else {
			$b_roll_back = 'roll_back';
			// 事务回滚
			$this->db->roll_back();
		}

		if($b_roll_back == 'roll_back'){
			$this->error->show_error('脱换方式有误,请重新提交',$this->router->url('points'));
		}

		// 1、余额   2、微信 3、支付宝 4、银行卡
		return $this->payment($b_order, $i_pattern);
    }

    public function payment($pay_sn,$s_paytype = 4){
		//判断支付单号不为空
		if(empty($pay_sn)){
			$this->error->show_error('订单有误,请重新提交', $this->router->url('shop'));
		}


		//判断用户必须先登录
		if(empty($_SESSION['user_id'])){
			$this->error->show_error('请您先登录', $this->router->url('shop'));
		}

		if($s_paytype == 1){
			//余额提现
			$this->paid($pay_sn);
		} else if ($s_paytype == 2){
			//微信提现
			$this->account($pay_sn);
		} else if ($s_paytype == 3){
			//支付宝提现
			$this->alipay($pay_sn);
		} else if ($s_paytype == 4){
			//银行卡提现
			$this->bank($pay_sn);
		} else {
			$this->error->show_error('提现方式有误', $this->router->url('shop'));
		}
	}

	//余额提现
	private function paid($pay_sn){
		// 开启事务
		$this->db->begin();
		//查询积分脱换数据
		$a_points = $this->db->get_row('points', ['user_id' => $_SESSION['user_id'], 'id' => $pay_sn]);

		//积分减少用户表的积分
		$b_member = $this->db->set('user_score', 'user_score - ' . $a_points['points'], false)
				 			 	->update('user', NULL, ['user_id' => $_SESSION['user_id']]);
		// 插入会员积分points_log数据表
		$a_ponit_data =  [	
							'pl_memberid' 	 => $_SESSION['user_id'],
							'pl_membername'	 => $_SESSION['user_name'],
							'pl_points'		 => '-' . $a_points['points'],
							'pl_time_create' => $_SERVER['REQUEST_TIME'],
							'pl_desc'		 => $_SESSION['user_name'].'使用'.$a_points['points'].'积分脱换'.$a_points['mou'],
							'pl_stage'		 => '用户进行积分脱换金额'
						];

		// 插入会员积分日志表
		$b_points_log = $this->db->insert('points_log', $a_ponit_data);
		
		//更新会员表
		$b_member = $this->db->set('user_balance', 'user_balance + ' . $a_points['mou'], false)
							 ->update('user', NULL,['user_id' => $_SESSION['user_id']]);

		//判断上面表是否插入成功如果有失败进行回滚
		if($b_member != false && $b_points_log != false){
			$s_commit = 'commit';
			// 提交事务
			$this->db->commit();
		} else {
			$s_roll_back = 'roll_back';
			// 事务回滚
			$this->db->roll_back();
		}

		//根据状态给用户相应的提示
		if($s_commit == 'commit'){
			$this->error->show_success('您选择的是余额,提现成功',$this->router->url('index'));
		}

		if($s_roll_back == 'roll_back'){
			$this->error->show_error('已提交,提现有误,请重新提交',$this->router->url('index'));
		}
	}
	//微信提现
	private function account($pay_sn){}
	//支付宝提现
	private function alipay($pay_sn){
		//查询积分脱换数据
		$a_points = $this->db->get_row('points', ['user_id' => $_SESSION['user_id'], 'id' => $pay_sn]);

		$this->load->library('alipay_wap');
		$a_data = [
			'out_biz_no' => date('Ymdhis', time()) . rand(100, 999),
			'payee_account' => $a_points['account'],
			'amount' => '0.1',
			'payee_real_name' => $a_points['name'],
			'remark' => '测试转账',
			'is_page' => false
		];
		$a   = $this->alipay_wap->transfer($a_data);
		$ali = $a->alipay_fund_trans_toaccount_transfer_response->code;
		if (!empty($ali) && $ali == 10000) {
			// 积分减少用户表的积分
			$b_member = $this->db->set('user_score', 'user_score - ' . $a_points['points'], false)
						 			 	->update('user', NULL, ['user_id' => $_SESSION['user_id']]);
				// 插入会员积分points_log数据表
				$a_ponit_data =  [	
									'pl_memberid' 	 => $_SESSION['user_id'],
									'pl_membername'	 => $_SESSION['user_name'],
									'pl_points'		 => '-' . $a_points['points'],
									'pl_time_create' => $_SERVER['REQUEST_TIME'],
									'pl_desc'		 => $_SESSION['user_name'].'使用'.$a_points['points'].'积分脱换'.$a_points['mou'],
									'pl_stage'		 => '用户进行积分脱换金额' 
								];

				// 插入会员积分日志表
			$b_points_log = $this->db->insert('points_log', $a_ponit_data);
			echo '提现成功！';
			header("location:http://wofei_wap.7dugo.com");
		} else {
			echo '提现失败，请重试！';
			header("location:http://wofei_wap.7dugo.com");
		}
	}
	//银行卡提现
	private function bank($pay_sn){}
}
?>