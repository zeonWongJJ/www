<?php

class User_set_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/**********************************************************************************/

    /**
     * [get_user_baseinfo 会员中心获取会员的基本信息]
     * [操作的表 member 操作方式 select]
     * @return [array] [返回查询到数据]
     */
    public function get_user_baseinfo() {
        $a_where = [
            'id =' => $_SESSION['user_id']
        ];
        $a_data = $this->db->get_row('member', $a_where);
        return $a_data;
    }

/**********************************************************************************/

    /**
     * [get_user_pwd 修改密码操作时获取用户的旧密码进行比对]
     * [操作的表 member 操作方式 select]
     * @return [string] [返回用户的密码]
     */
    public function get_user_pwd() {
        $a_where = [
            'id =' => $_SESSION['user_id']
        ];
        $a_data = $this->db->get_row('member', $a_where);
        return $a_data['password'];
    }

/**********************************************************************************/

    /**
     * [update_user_pwd 修改密码之保存新密码]
     * [操作的表 member 操作方式 update]
     * @param  [string] $newpwd [要保存的新密码]
     * @return [int]            [返回修改的行数]
     */
    public function update_user_pwd($newpwd) {
        $a_where = [
            'id =' => $_SESSION['user_id']
        ];
        $a_data = [
            'password' => $newpwd
        ];
        $i_result = $this->db->update('member', $a_data, $a_where);
        return  $i_result;
    }

/**********************************************************************************/

    /**
     * [get_oldphoto_path 获取会员头像路径]
     * [操作的表 member 操作方式 select]
     * @return [string] [返回会员头像路径]
     */
    public function get_oldphoto_path() {
        $a_where = [
            'id =' => $_SESSION['user_id']
        ];
        $a_data = $this->db->get_row('member', $a_where);
        return $a_data['photo'];
    }

/**********************************************************************************/

    /**
     * [update_user_photo 修改会员头像]
     * [操作的表 member 操作方式 update]
     * @param  [string] $photo [头像路径]
     * @return [int]           [返回修改的行数]
     */
    public function update_user_photo($photo) {
        $a_where = [
            'id =' => $_SESSION['user_id']
        ];
        $a_data = [
            'photo' => $photo
        ];
        $i_result = $this->db->update('member', $a_data, $a_where);
        return  $i_result;
    }

/**********************************************************************************/

    /**
     * [get_user_authlevel 修改性别前判断用户的认证状态]
     * [操作的表 member 操作方式 select]
     * @return [int] [返回用户的认证状态]
     */
    public function get_user_authlevel() {
        $a_where = [
            'id =' => $_SESSION['user_id']
        ];
        $a_result = $this->db->get_row('member', $a_where);
        return  $a_result['auth_level'];
    }

/**********************************************************************************/

    /**
     * [update_user_sex 会员设置之修改性别]
     * [操作的表 member 操作方式 update]
     * @param  [int] $sex [性别状态码]
     * @return [int]      [返回修改受影响的行数]
     */
    public function update_user_sex($sex) {
        $a_where = [
            'id =' => $_SESSION['user_id']
        ];
        $a_data = [
            'sex' => $sex
        ];
        $i_result = $this->db->update('member', $a_data, $a_where);
        return $i_result;
    }

/**********************************************************************************/

}


?>