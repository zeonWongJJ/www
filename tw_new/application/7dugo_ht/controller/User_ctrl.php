<?php
defined('BASEPATH') OR exit('禁止访问！');
class User_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
		$this->load->model('ht_goods_model');
		if(!$_SESSION['user_id']){
			$this->view->display('login');
			die;
		}
	}

	// 用户列表
	public function user() {
		$i_id = $this->general->post('id') ? $this->general->post('id') : $this->router->get('1');
		$a_name = $this->general->post('name') ? $this->general->post('name') : $this->router->get('2');
		$i_email = $this->general->post('email') ? $this->general->post('email') : $this->router->get('4');
		$i_mobile = $this->general->post('mobile') ? $this->general->post('mobile') : $this->router->get('5');
		$a_tesname = $this->general->post('tesname') ? $this->general->post('tesname') : $this->router->get('3');
		$a_wher = '';
		if ( ! empty($i_id)) {
			$a_wher .= ($a_wher ? ' AND ' : '') . "`member_id` LIKE '%" . addslashes($i_id) . "%'";
		}
		if ( ! empty($a_name)) {
			$a_wher .= ($a_wher ? ' AND ' : '') . "`member_name` LIKE '%" . addslashes($a_name) . "%'";
		}
		if ( ! empty($a_tesname)) {
			$a_wher .= ($a_wher ? ' AND ' : '') . "`member_truename` LIKE '%" . addslashes($a_tesname) . "%'";
		}
		if ( ! empty($i_mobile)) {
			$a_wher .= ($a_wher ? ' AND ' : '') . "`member_mobile` LIKE '%" . addslashes($i_mobile) . "%'";
		}
		if ( ! empty($i_email)) {
			$a_wher .= ($a_wher ? ' AND ' : '') . "`member_email` LIKE '%" . addslashes($i_email) . "%'";
		}
		$s_field = "member_id, member_name, member_truename, member_points, member_time_login, member_state, member_mobile, member_email";
		// 加载分页类
		$this->load->library('pages');
		//页面数据显示和条件
		$i_canshu = $this->router->get(6) ? $this->router->get(6) : 1;
		// 获取数据总行数，以用户为例
		$i_total = $this->db->get_total('member', $a_wher, $s_field, $a_group);
   		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_canshu, 10);
		// 开始获取用户数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		//排序
		$this->db->order_by(['member_id' => 'desc']);
		//数据
		$a_data['member'] = $this->db->get('member', $a_wher, $s_field ,$a_group);
		//显示页
		$a_data['page'] = $this->pages->link_style_one($this->router->url("user-" . $i_id . "-" . $a_name . "-" . $a_tesname . "-" . $i_email . "-" . $i_mobile . "-", [], false, false));
		$this->view->display('user', $a_data);
	}

	// 登录用户列表
	public function latest_user() {
		$i_id = $this->general->post('id') ? $this->general->post('id') : $this->router->get('1');
		$a_name = $this->general->post('name') ? $this->general->post('name') : $this->router->get('2');
		$i_email = $this->general->post('email') ? $this->general->post('email') : $this->router->get('4');
		$i_mobile = $this->general->post('mobile') ? $this->general->post('mobile') : $this->router->get('5');
		$a_tesname = $this->general->post('tesname') ? $this->general->post('tesname') : $this->router->get('3');
		$a_wher = '';
		if ( ! empty($i_id)) {
			$a_wher .= ($a_wher ? ' AND ' : '') . "`member_id` LIKE '%" . addslashes($i_id) . "%'";
		}
		if ( ! empty($a_name)) {
			$a_wher .= ($a_wher ? ' AND ' : '') . "`member_name` LIKE '%" . addslashes($a_name) . "%'";
		}
		if ( ! empty($a_tesname)) {
			$a_wher .= ($a_wher ? ' AND ' : '') . "`member_truename` LIKE '%" . addslashes($a_tesname) . "%'";
		}
		if ( ! empty($i_mobile)) {
			$a_wher .= ($a_wher ? ' AND ' : '') . "`member_mobile` LIKE '%" . addslashes($i_mobile) . "%'";
		}
		if ( ! empty($i_email)) {
			$a_wher .= ($a_wher ? ' AND ' : '') . "`member_email` LIKE '%" . addslashes($i_email) . "%'";
		}
		$s_field = "member_id, member_name, member_truename, member_points, member_time_login, member_state, member_mobile, member_email";
		// 加载分页类
		$this->load->library('pages');
		//页面数据显示和条件
		$i_canshu = $this->router->get(6) ? $this->router->get(6) : '1';
		// 获取数据总行数，以用户为例
		$i_total = $this->db->get_total('member', $a_wher, $s_field, $a_group);
   		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_canshu, 10);
		// 开始获取用户数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		//排序
		$this->db->order_by(['member_time_login' => 'desc']);
		//数据
		$a_data['member'] = $this->db->get('member', $a_wher, $s_field ,$a_group);
		//显示页
		$a_data['page'] = $this->pages->link_style_one($this->router->url("user-" . $i_id . "-" . $a_name . "-" . $a_tesname . "-" . $i_email . "-" . $i_mobile . "-", [], false, false));
		$this->view->display('latest_user', $a_data);
	}

	// 用户详情
	public function true_user() {
		$i_id = $this->router->get(1);
		$a_where = ['member_id' => $i_id];
		$s_field = "member_id, member_name, member_truename, member_sex, member_birthday, member_email, member_mobile, member_qq, member_ww, member_login_num, member_time, member_time_login, member_time_old_login, member_login_ip, member_old_login_ip, member_points, available_predeposit, freeze_predeposit, available_rc_balance, freeze_rc_balance, inform_allow, is_buy, is_allowtalk, member_state, member_areaid, member_cityid, member_provinceid, member_areainfo, member_exppoints";
		$a_data = $this->db->get('member', $a_where, $s_field);
		$this->view->display('true_user', $a_data);
	}

	// 用户修改
	public function update_user() {
		$i_id = $this->router->get(1);
		$s_field = "member_id, member_name, member_state";
		$a_where = ['member_id' => $i_id];
		$a_data = $this->db->get('member', $a_where, $s_field);
		$this->view->display('update_user', $a_data);
	}
	// 用户修改
	public function update_user1() {
		$i_id = $this->router->get(1);
		$a_state = $this->general->post('state');
		$a_mamber = $this->db->update('member', ['member_state' => $a_state], ['member_id' => $i_id]);
		$this->error->show_success('修改成功！',  $this->router->url('user'));
	}
}