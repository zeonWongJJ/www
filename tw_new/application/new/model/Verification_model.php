<?php

class Verification_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/**********************************************************************************/

	/**
	 * [bank_info 取出银行的信息]
	 * [操作的表 new_bank 方式 select]
	 * @return [array] [返回查询到的所有银行的信息]
	 */
	public function bank_info() {
		$a_order = [
			'id' => 'desc'
		];
        $a_data = $this->db->get('bank', [], '', $a_order);
        return $a_data;
	}

/**********************************************************************************/

	/**
	 * [realname_info 取出身份证认证中个人真实姓名]
	 * [操作的表 new_auth_realname 方式 select]
	 * @return [string] [返回查询到的个人真实姓名]
	 */
	public function realname_info() {
        $a_where = [
            'uid =' => $_SESSION['user_id']
        ];
        $a_data = $this->db->get_row('auth_realname', $a_where);
        return $a_data['realname'];
	}

/**********************************************************************************/

	/**
	 * [add_auth_realname 插入一条身份证验证数据]
	 * [操作的表 new_auth_realname 方式 insert]
	 * @param [array] $a_data [要插入的数据]
	 */
	public function add_auth_realname($a_data) {
		//如果写入成功返回写入的新数据的id值，写入失败返回false
		$i_result = $this->db->insert('auth_realname', $a_data);
		if ($i_result) {
			return $i_result;
		} else {
			return false;
		}
	}

/**********************************************************************************/

	/**
	 * [add_auth_certificate 插入一条证件验证的数据]
	 * @param [type] $a_data [要插入的数据]
	 */
	public function insert_auth_certificate($a_data) {
		//如果写入成功返回写入的新数据的id值，写入失败返回false
		$i_result = $this->db->insert('auth_certificate', $a_data);
		return $i_result;
	}

/**********************************************************************************/

	/**
	 * [add_auth_company 插入一条数企业验证数据]
	 * @param [array] $a_data [要插入的数据]
	 */
	public function insert_auth_company($a_data) {
		$i_result = $this->db->insert('auth_company', $a_data);
		return $i_result;
	}

/**********************************************************************************/

	/**
	 * [is_auth_realname 判断是否已经实名认证]
	 * @return int [返回认证数字状态]
	 */
	public function is_auth_realname() {
        $a_where = [
            'id =' => $_SESSION['user_id']
        ];
        $a_data = $this->db->get_row('member', $a_where);
        return $a_data['auth_level'];
	}

/**********************************************************************************/

	/**
	 * [add_bound_cards 插入一条银行卡验证数据]
	 * [操作的表 new_bound_cards 方式 insert]
	 * @param [array] $a_data [要插入的数据]
	 */
	public function add_bound_cards($a_data){
		$i_result = $this->db->insert('bound_cards', $a_data);
		//如果写入成功返回写入的新数据的id值，写入失败返回false
		if ($i_result) {
			return $i_result;
		} else {
			return false;
		}
	}

/**********************************************************************************/

	/**
	 * [is_submit_bank 银行卡认证时判断是否已经提交过认证]
	 * [操作的表 new_bound_cards 方式 select]
	 * @return array|boolean [查询到据则返回数据 未查找到则返回false]
	 */
	public function is_submit_bank() {
        $a_where = [
            'member_id =' => $_SESSION['user_id']
        ];
		$a_order = [
			'id' => 'desc'
		];
        $a_data = $this->db->get_row('bound_cards', $a_where, '', $a_order);
        if(!empty($a_data)){
        	return $a_data;
        }else{
        	return false;
        }
	}

/**********************************************************************************/

	/**
	 * [update_bank_state 银行卡认证金额认证通过后，改变银行卡认证的状态为成功]
	 * [操作的表 new_bound_cards 方式 update]
	 * @param  [int] $state [要更新的数据]
	 * @return [int]        [返回修改受影响的行数]
	 */
	public function update_bank_state($state) {
		$a_data = [
			'state' => $state
		];
		$a_where = [
			'member_id =' => $_SESSION['user_id']
		];
		$i_result = $this->db->update('bound_cards', $a_data, $a_where);
		return $i_result;
	}

/**********************************************************************************/

	/**
	 * [update_user_state 银行卡认证金额认证通过后，将用户表用户信息的状态更新为2]
	 * [操作的表 new_member 方式 update]
	 * @return [int] [返回受影响的行数]
	 */
	public function update_user_state() {
		$a_data = [
			'auth_level' => 2
		];
		$a_where = [
			'id =' => $_SESSION['user_id']
		];
		$i_result = $this->db->update('member', $a_data, $a_where);
		return $i_result;
	}

/**********************************************************************************/

	/**
	 * [del_bank 银行卡重新认证之删除之前的认证信息]
	 * [操作的表 new_bound_cards 方式 delete]
	 * @return [int] [返回删除的行数]
	 */
	public function del_bank() {
		$a_where = [
			'member_id =' => $_SESSION['user_id']
		];
		$i_result = $this->db->delete('bound_cards', $a_where);
		return $i_result;
	}

/**********************************************************************************/

	/**
	 * [is_submit_realname 判断用户是否提交过身份证认证]
	 * [操作的表 new_auth_realname 方式 select]
	 * @return array|boolean [如果有查询到数据则返回数据，没有则返回false]
	 */
	public function is_submit_realname() {
        $a_where = [
            'uid =' => $_SESSION['user_id']
        ];
		$a_order = [
			'realname_a_id' => 'desc'
		];
        $a_data = $this->db->get_row('auth_realname', $a_where, '', $a_order);
        if(!empty($a_data)){
        	return $a_data;
        }else{
        	return false;
        }
	}

/**********************************************************************************/

	/**
	 * [del_realname 会员中心个人身份认证之认证失败后重新认证]
	 * [操作的表 new_auth_realname 方式 delete]
	 * @return [int] [返回删除的行数]
	 */
	public function del_realname() {
		$a_where = [
			'member_id =' => $_SESSION['user_id']
		];
		$i_result = $this->db->delete('auth_realname', $a_where);
		return $i_result;
	}

/**********************************************************************************/

}

?>