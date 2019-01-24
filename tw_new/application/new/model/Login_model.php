<?php
class Login_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/**********************************************************************************/

    //判断账户是否存在 [当登录方式是手机号码时]
    public function is_tel_exist($tel_or_username) {
        $a_where = [
            'mobile' => $tel_or_username
        ];
        $s_field = '';
        $a_order = [
            'id' => 'desc'
        ];
        $a_data = $this->db->get_row('member', $a_where, $s_field, $a_order);
        return $a_data;
    }

/**********************************************************************************/

    //判断账户是否存在 [当登录方式是用户名时]
    public function is_username_exist($tel_or_username) {
        $a_where = [
            'username =' => $tel_or_username
        ];
        $s_field = '';
        $a_order = [
            'id' => 'desc'
        ];
        $a_data = $this->db->get_row('member', $a_where, $s_field, $a_order);
        return $a_data;
    }

/**********************************************************************************/

    //插入一条信息到登录历史记录表 [ 操作的表 new_location 操作方式 insert ]
    public function insert_location($a_data_location) {
        $i_location_result = $this->db->insert('location', $a_data_location);
        return $i_location_result;
    }

/**********************************************************************************/

    //更新用户信息表 [ 操作的表 new_member 操作方式 update ]
    public function update_member($a_data_member) {
        $a_where =[
            'id =' => $_SESSION['user_id'],
        ];
        $i_member_result = $this->db->update('member', $a_data_member, $a_where);
        return $i_member_result;
    }

/**********************************************************************************/

    //获取用户原来的积分
    public function get_original_score($uid) {
        $a_where = [
            'member_id =' => $uid,
            'type =' => 5
        ];
        $s_field = 'variation, original_value';
        $a_order = [
            'variation_id' => 'desc'
        ];
        $a_data = $this->db->get_row('member_variation_log', $a_where, $s_field, $a_order);
        if (empty($a_data)) {
            return 0;
        } else {
            return $a_data['variation'] + $a_data['original_value'];
        }
    }

/**********************************************************************************/

    //增加积分或者荣耀 [ 操作表 new_member_variation_log 操作方式 insert ]
    public function insert_variation($a_variation_data) {
        $i_variation_result = $this->db->insert('member_variation_log', $a_variation_data);
        return $i_variation_result;
    }

/**********************************************************************************/

    //获取用户原来的荣耀
    public function get_original_honour($uid) {
        $a_where = [
            'member_id =' => $uid,
            'type =' => 1
        ];
        $s_field = 'variation, original_value';
        $a_order = [
            'variation_id' => 'desc'
        ];
        $a_data = $this->db->get_row('member_variation_log', $a_where, $s_field, $a_order);
        if (empty($a_data)) {
            return 0;
        } else {
            return $a_data['variation'] + $a_data['original_value'];
        }
    }

/**********************************************************************************/

    //取出称号表的的相应内容
    public function get_appellation($app_type) {
        $a_where = [
            'app_type' => $app_type //称号类型: 1->服务者称号 2->需求者称号
        ];
        $a_order = [
            'app_id' => 'desc'
        ];
        $a_data = $this->db->get('appellation', $a_where, '', $a_order);
        return $a_data;
    }

/**********************************************************************************/

}
?>