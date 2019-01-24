<?php
class Points_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
	}

	// 积分管理
	public function points() {
		//积分剩余
		$a_data['user'] = $this->db->limit(0,99999999999)->get('user', '', ['user_score']);
		$a_data['score'] = 0;
		foreach ($a_data['user'] as $score) {
			$a_data['score'] += $score['user_score']; 
		}
		//积分总抵现
		$a_order = $this->db->limit(0,99999999999)->get('order', ['order_state >=' => 25], ['use_points']);
		$a_data['order'] = 0;
		foreach ($a_order as $order) {
			$a_data['order'] += $order['use_points']; 
		}
		//积分总提现
		$a_points = $this->db->limit(0,99999999999)->get('points', '', ['points']);
		$a_data['poi'] = 0;
		foreach ($a_points as $points) {
			$a_data['poi'] += $points['points']; 
		}

		$a_user = trim($this->general->post('user')) ? trim($this->general->post('user')) : $this->router->get(1);
		if (empty($a_user)) {
			$a_where_or = '';
		} else {
			$a_where_or = [
				'user_name LIKE'  => '%'. $a_user .'%',
				'user_phone LIKE' => '%'. $a_user .'%',
			];
		}
		// 加载分页类
		$this->load->library('pages');
		//页面数据显示和条件
		$i_canshu = $this->router->get(2) ? $this->router->get(2) : '1';
		// 获取数据总行数，以产品为例
		$i_total = $this->db->where_or($a_where_or)->get_total('user');
   		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_canshu, 25);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		//数据		
		$a_data['points'] = $this->db->where_or($a_where_or)->get('user');
		// echo $this->db->get_sql(); 		
		//显示页
		$a_data['page'] = $this->pages->link_style_one($this->router->url('points-' . $a_user . '-', [''], false, false));
		$this->view->display('points', $a_data);
	}

	//积分明细
	public function points_detail() {
		$i_id           = $this->router->get(1);
		$a_data['user'] = $this->db->get_row('user', ['user_id' => $i_id]);
		// 加载分页类
		$this->load->library('pages');
		//页面数据显示和条件
		$i_canshu = $this->router->get(2) ? $this->router->get(2) : '1';
		// 获取数据总行数，以产品为例
		$i_total = $this->db->get_total('points_log');
   		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_canshu, 9);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		//数据		
		$a_data['points'] = $this->db->order_by(['pl_id' => 'desc'])->get('points_log');
		// echo $this->db->get_sql(); 
		//显示页
		$a_data['page'] = $this->pages->link_style_one($this->router->url('order_form-' . $i_id . '-', [''], false, false));
		$this->view->display('points_detail', $a_data);
	}

	//积分修改
	public function points_update() {
		$user_id = trim($this->general->post('id'));
		$i_score = trim($this->general->post('score'));
		if ( ! empty($user_id)) {
			$a_user = $this->db->get_row('user', ['user_id' => $user_id]);
			echo json_encode($a_user);
		}
		if ( ! empty($i_score)) {	
			$i_chenr = trim($this->general->post('chenr'));
			$i_id    = trim($this->general->post('user_id'));	
			$a_user = $this->db->get_row('user', ['user_id' => $i_id]);	
			if ($a_user['user_score'] < $i_score) {					
				$user = $this->db->update('user', ['user_score' => $i_score], ['user_id' => $i_id]);		
				$i_aou = $i_score - $a_user['user_score'];
				// 插入会员积分数据
				$a_ponit_data =  [	'pl_memberid' 	=> $a_user['user_id'],
									'pl_membername'	=> $a_user['user_name'],
									'pl_points'		=> $i_aou,
									'pl_time_create'=> $_SERVER['REQUEST_TIME'],
									'pl_desc'		=> $i_chenr,
									'pl_stage'		=> '管理员修整积分'];	
				// 插入会员积分日志表
				$b_points_log = $this->db->insert('points_log', $a_ponit_data);	
				
			} else if ($a_user['user_score'] > $i_score) {
				$user = $this->db->update('user', ['user_score' => $i_score], ['user_id' => $i_id]);
				$i_aou = $a_user['user_score'] - $i_score;
				// 插入会员积分数据
				$a_ponit_data =  [	'pl_memberid' 	=> $a_user['user_id'],
									'pl_membername'	=> $a_user['user_name'],
									'pl_points'		=> '-'.$i_aou,
									'pl_time_create'=> $_SERVER['REQUEST_TIME'],
									'pl_desc'		=> $i_chenr,
									'pl_stage'		=> '管理员修整积分'];
				// 插入会员积分日志表
				$b_points_log = $this->db->insert('points_log', $a_ponit_data);	
			}
			if (! empty($user)) {
				echo 33;
			} else {
				echo 44;
			}
		}
	}
}
?>