<?php

class User_model extends TW_Model {

  public function __construct() {
    parent :: __construct();
  }

/**********************************************************************************************/

  //获取所有会员信息
  public function get_user_showlist() {
    // 先设置默认从第一页开始
    $i_page = $this->router->get(1);
    if (empty($i_page)) {
      $i_page = 1;
    }
    // 设置每页显示的数据行数
    $i_prow = 10;
    // 加载分页类
    $this->load->library('pages');
    // 获取数据总行数
    $i_total = $this->db->get_total('member');
    // 调用分页运算函数
    $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
    // 开始获取产品数据
    $this->db->limit($a_pdata['start'], $a_pdata['last']);

    $a_order = [
      'id' => 'desc'
    ];
    $a_data = $this->db->get('member', [], '', $a_order);
    return $a_data;
  }

/**********************************************************************************************/

  //获取某个会员的资料
  public function get_userinfo($id) {
    $a_where = [
      'id' => $id
    ];
    $a_data = $this->db->get_row('member', $a_where);
    return $a_data;
  }

/**********************************************************************************************/

  //删除某个会员
  public function delete_user($id) {
    $a_where = [
      'id' => $id,
    ];
    $i_result = $this->db->delete('member', $a_where);
    return $i_result;
  }

/**********************************************************************************************/

}

?>