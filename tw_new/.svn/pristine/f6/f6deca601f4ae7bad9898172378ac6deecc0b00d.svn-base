<?php
class Audit_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
		$this->load->model('allow_model');
		$this->allow_model->is_login();
	}

	//资质申请
	public function qualifi() {
		$i_one  = $this->router->get(1) ? $this->router->get(1) : 0;
		$name   = $this->general->post('name') ? $this->general->post('name') : $this->router->get(2);
		$a_data = [
			'i_one' => $i_one,
			'name'  => $name,
		];
		$a_where = "";
		if ( ! empty($name)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`b`.`user_name` LIKE '%$name%' or `a`.`phone` LIKE '%$name%'";
		}
		$a_where .= ($a_where ? ' AND ' : '') . "`audit` < '5'";
		if ( ! empty($i_one)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`audit` = '$i_one'";
		}
		// 先设置默认从第一页开始
		$i_page = $this->router->get(2);
		if (empty($i_page)) {
			$i_page = 1;
		}
		// 设置每页显示的数据行数
		$i_prow = 10;
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数，以产品为例
		$a_data['i_total'] = $this->db->from('qualifi as a')
									->join('user as b', ['a.user_id' => 'b.user_id'])
									->get_total('', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($a_data['i_total'], $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		$a_data['goods'] = $this->db->from('qualifi as a')
									->join('user as b', ['a.user_id' => 'b.user_id'])
									->get('', $a_where, '', ['add_time' => 'desc']);
		// echo $this->db->get_sql();
		$a_data['pages'] = $this->pages->link_style_one($this->router->url('qualifi-'.$i_one.'-'.$name.'-', [], false, false));
		$this->view->display('qualifi', $a_data);
	}

	//资质申请详情
	public function qualifi_list() {
		$id     = $this->router->get(1);
		$a_data = $this->db->from('qualifi as a')
							->join('user as b', ['a.user_id' => 'b.user_id'])
							->get_row('', ['qua_id' => $id]);
		$this->view->display('qualifi_list', $a_data);
	}

	// 资质申请审批查看
	public function qualifi_chan() {
		$id = $this->general->post('id');
		$a_data['qualifi'] = $this->db->get_row('qualifi', ['qua_id' => $id]);
		
		$a_data['time'] = date('Y-m-d H:i', $a_data['qualifi']['audit_time']);
		
		if ($a_data) {
			echo json_encode(array('code' => 200, 'data' => $a_data));
			die;
		} else {
			echo json_encode(array('code' => 400));
			die;
		}
	}

	//审核
	public function qualifi_state() {
		$state = $this->general->post('state');
		$i_id  = $this->general->post('id');
		$liyou = $this->general->post('liyou');
		if ($state == 1) {
			$a_data = $this->db->update('qualifi', ['audit' => 2, 'reason' => $liyou, 'audit_time' => $_SERVER['REQUEST_TIME']], ['qua_id' => $i_id]);
		} else if ($state == 2) {
			$a_data = $this->db->update('qualifi', ['audit' => 3, 'reason' => $liyou, 'audit_time' => $_SERVER['REQUEST_TIME']], ['qua_id' => $i_id]);
		} else if ($state == 3) {
			$a_data = $this->db->update('qualifi', ['audit' => 4, 'audit_time' => $_SERVER['REQUEST_TIME']], ['qua_id' => $i_id]);
		}
		if ($a_data) {
			echo json_encode(array('code' => 200, 'data' => '审核成功！'));
			die;
		} else {
			echo json_encode(array('code' => 400, 'data' => '审核失败！'));
			die;
		}
	}

}
?>