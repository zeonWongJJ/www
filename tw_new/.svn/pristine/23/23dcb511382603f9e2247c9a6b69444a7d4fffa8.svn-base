<?php

class Admin_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/*********************************** 获取管理员 ***********************************/

	public function get_admin_page($order, $i_page) {
		// 设置每页显示的数据行数
		$i_prow = 25;
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数
		$i_total = $this->db->get_total('admin');
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		if ($order == 'logintime') {
			$a_order = [
				'a.login_time' => 'desc'
			];
		} else {
			$a_order = [
				'a.admin_id' => 'desc'
			];
		}
		$a_data['admin'] = $this->db->from('admin as a')
								    ->join('role as r',['a.role_id'=>'r.role_id'])
								    ->order_by($a_order)
								    ->get('');
		$a_data['count'] = $i_total;
		return $a_data;
	}

/*********************************** 更新管理员 ***********************************/

	/**
	 * [update_admin 更新管理员]
	 * @param  [type] $a_where [description]
	 * @param  [type] $a_data  [description]
	 * @return [type]          [description]
	 */
	public function update_admin($a_where, $a_data) {
		$i_result = $this->db->update('admin', $a_data, $a_where);
		return $i_result;
	}

/*********************************** 删除管理员 ***********************************/

	/**
	 * [delete_admin 删除管理员]
	 * @param  [type] $admin_ids [description]
	 * @return [type]            [description]
	 */
	public function delete_admin($admin_ids) {
		$i_result = $this->db->where_in('admin_id', $admin_ids)->delete('admin');
		return $i_result;
	}

/********************************* 获取所有角色 **********************************/

	/**
	 * [get_role_all 获取所有角色]
	 * @return [type] [description]
	 */
	public function get_role_all() {
		$a_order = [
			'role_id' => 'DESC'
		];
		$a_data = $this->db->get('role', [], '', $a_order, 0, 999999999);
		return $a_data;
	}

/****************************** 根据用户名获取管理员 ******************************/

	/**
	 * [get_admin_byname 根据用户名获取管理员]
	 * @param  [type] $admin_name [description]
	 * @return [type]             [description]
	 */
	public function get_admin_byname($admin_name) {
		$a_where = [
			'admin_name' => $admin_name
		];
		$a_data = $this->db->get_row('admin', $a_where);
		return $a_data;
	}

/********************************* 插入一条管理员 *********************************/

	/**
	 * [insert_admin 插入一条管理员]
	 * @param  [type] $a_data [description]
	 * @return [type]         [description]
	 */
	public function insert_admin($a_data) {
		$i_result = $this->db->insert('admin', $a_data);
		return $i_result;
	}

/********************************* 获取一条管理员 *********************************/

	/**
	 * [get_admin_one 获取一条管理员]
	 * @param  [type] $admin_id [description]
	 * @return [type]           [description]
	 */
	public function get_admin_one($admin_id) {
		$a_where = [
			'admin_id' => $admin_id
		];
		$a_data = $this->db->get_row('admin', $a_where);
		return $a_data;
	}

/*********************************** 获取角色列表 ***********************************/

	public function get_role_page($order, $i_page) {
		// 设置每页显示的数据行数
		$i_prow = 25;
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数
		$i_total = $this->db->get_total('role');
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		$a_data['role'] = $this->db->get('role');
		$a_data['count'] = $i_total;
		return $a_data;
	}

/************************************* 更新角色 ***********************************/

	/**
	 * [update_role 更新角色]
	 * @param  [type] $a_where [description]
	 * @param  [type] $a_data  [description]
	 * @return [type]          [description]
	 */
	public function update_role($a_where, $a_data) {
		$i_result = $this->db->update('role', $a_data, $a_where);
		return $i_result;
	}

/************************************* 删除角色 ***********************************/

	/**
	 * [delete_role 删除角色]
	 * @param  [type] $admin_ids [description]
	 * @return [type]            [description]
	 */
	public function delete_role($role_ids) {
		$i_result = $this->db->where_in('role_id', $role_ids)->delete('role');
		return $i_result;
	}

/************************************* 所有权限 ***********************************/

	/**
	 * [get_auth_all 所有权限]
	 * @return [type] [description]
	 */
	public function get_auth_all() {
		$a_where = [];
		$s_field = '';
		$a_order = [
			'auth_id' => 'asc'
		];
		$a_data = $this->db->get('auth', $a_where, $s_field, $a_order, 0, 999999999);
		return $a_data;
	}

/************************************* 父级权限 ***********************************/

	/**
	 * [get_auth_all 所有权限]
	 * @return [type] [description]
	 */
	public function get_auth_parent() {
		$a_where = [
			'auth_pid' => 0
		];
		$s_field = '';
		$a_order = [
			'auth_id' => 'desc'
		];
		$a_data = $this->db->get('auth', $a_where, $s_field, $a_order, 0, 999999999);
		return $a_data;
	}

/************************************* 删除权限 ***********************************/

	/**
	 * [delete_role 删除权限]
	 * @param  [type] $admin_ids [description]
	 * @return [type]            [description]
	 */
	public function delete_auth($auth_ids) {
		$i_result = $this->db->where_in('auth_id', $auth_ids)->delete('auth');
		return $i_result;
	}

/************************************* 部分权限 ***********************************/

	/**
	 * [get_auth_part description]
	 * @param  [type] $auth_ids [description]
	 * @return [type]           [description]
	 */
	public function get_auth_part($auth_ids) {
		$a_data = $this->db->where_in('auth_id', $auth_ids)
						   ->get('auth', [], '', [], 0, 999999999);
		return $a_data;
	}

/******************************** 插入一条角色记录 ********************************/

	/**
	 * [insert_admin 插入一条角色记录]
	 * @param  [type] $a_data [description]
	 * @return [type]         [description]
	 */
	public function insert_role($a_data) {
		$i_result = $this->db->insert('role', $a_data);
		return $i_result;
	}

/******************************** 获取一条角色记录 ********************************/

	/**
	 * [get_role_one 获取一条角色记录]
	 * @param  [type] $role_id [description]
	 * @return [type]          [description]
	 */
	public function get_role_one($role_id) {
		$a_where = [
			'role_id' => $role_id
		];
		$a_data = $this->db->get_row('role', $a_where);
		return $a_data;
	}

/******************************** 根据名称获取权限 ********************************/

	/**
	 * [get_auth_where 根据名称获取权限]
	 * @param  [type] $auth_name [description]
	 * @return [type]            [description]
	 */
	public function get_auth_where($auth_name) {
		$a_where = [
			'auth_name' => $auth_name
		];
		$a_data = $this->db->get_row('auth', $a_where);
		return $a_data;
	}

/******************************** 插入一条权限记录 ********************************/

	/**
	 * [insert_auth 插入一条权限记录]
	 * @param  [type] $a_data [description]
	 * @return [type]         [description]
	 */
	public function insert_auth($a_data) {
		$i_result = $this->db->insert('auth', $a_data);
		return $i_result;
	}

/******************************** 获取一条权限记录 ********************************/

	/**
	 * [get_auth_one 获取一条权限记录]
	 * @param  [type] $auth_id [description]
	 * @return [type]          [description]
	 */
	public function get_auth_one($auth_id) {
		$a_where = [
			'auth_id' => $auth_id
		];
		$a_data = $this->db->get_row('auth', $a_where);
		return $a_data;
	}

/******************************** 修改一条权限记录 ********************************/

	/**
	 * [update_auth 修改一条权限记录]
	 * @param  [type] $a_where [description]
	 * @param  [type] $a_data  [description]
	 * @return [type]          [description]
	 */
	public function update_auth($a_where, $a_data) {
		$i_result = $this->db->update('auth', $a_data, $a_where);
		return $i_result;
	}

/**********************************************************************************/

}