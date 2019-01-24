<?php
defined('BASEPATH') OR exit('禁止访问！');
class User_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('user_model');
        $this->load->model('is_login_model');
        $this->is_login_model->is_login();
    }

/**********************************************************************************/

    //会员中心首页
    public function user_index() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //调用模型方法获取会员基本信息
            $a_mybaseinfo = $this->user_model->get_user_baseinfo();
            //调用模型方法获取我的足迹总数
            $i_myfootprint_total = $this->user_model->get_myfootprint_total();
            //调用模型方法获取我的收藏总数
            $i_mycollect_total = $this->user_model->get_mycollect_total();
            //调用模型方法获取我的排班总数
            $i_mypaiban_total = $this->user_model->get_mypaiban_total();
            //获取竞标中的订单总数
            $inbid_total = $this->user_model->get_demand_total(101);
            //获取待付款的订单数量
            $waitpay_total = $this->user_model->get_demand_total(102);
            //获取待确定的订单数量
            $waitconfirm_total = $this->user_model->get_demand_total(103);
            //获取待服务的订单
            $waitservice_total = $this->user_model->get_demand_total(104);
            //获取服务中的订单
            $inservice_total = $this->user_model->get_demand_total(105);
            //获取待评价的订单
            $waitcomment_total = $this->user_model->get_demand_total(106);
            //获取已完成的订单
            $complete_total = $this->user_model->get_demand_total(107);
            //获取我的全部订单
            $all_order = $this->user_model->get_all_myorder();
            $a_data = [
                'mybaseinfo'        => $a_mybaseinfo,
                'myfootprint'       => $i_myfootprint_total,
                'mycollect'         => $i_mycollect_total,
                'mypaiban'          => $i_mypaiban_total,
                'inbid_total'       => $inbid_total,
                'waitpay_total'     => $waitpay_total,
                'waitconfirm_total' => $waitconfirm_total,
                'waitservice_total' => $waitservice_total,
                'inservice_total'   => $inservice_total,
                'waitcomment_total' => $waitcomment_total,
                'complete_total'    => $complete_total,
                'all_order'         => $all_order
            ];
            $this->view->display('vipIndex', $a_data);
        }
    }

/**********************************************************************************/

}

?>
