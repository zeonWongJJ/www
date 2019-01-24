<?php

class Register_model extends TW_Model {

  public function __construct() {
      parent :: __construct();
  }

/**********************************************************************************/

  //检验手机号码是否已被注册
  public function is_mobile_occupy($mobile) {
      $a_where = [
        'mobile =' => $mobile
      ];
      $i_result = $this->db->get_total('member', $a_where);
      return $i_result;
  }

/**********************************************************************************/

  //检验用户名是否已被占用
  public function is_username_occupy($username) {
      $a_where = [
        'username =' => $username
      ];
      $i_result = $this->db->get_total('member', $a_where);
      return $i_result;
  }

/**********************************************************************************/

  //获取当前手机号码的最近一条验证码
  public function get_row_code($mobile) {
      $time = $_SERVER['REQUEST_TIME']-1800;
      $a_where = [
        'comprehensive =' => $mobile,
        'code_type =' => 1,
        'send_time >' => $time
      ];
      $s_field = '';
      $a_order = [
        'id' => 'desc'
      ];
      $a_data = $this->db->get_row('code', $a_where, $s_field, $a_order);
      return $a_data;
  }

/**********************************************************************************/

  //注册成功将数据插入到数据库
  public function insert_member($a_data) {
      $i_result = $this->db->insert('member', $a_data);
      return $i_result;
  }

/**********************************************************************************/

}

?>