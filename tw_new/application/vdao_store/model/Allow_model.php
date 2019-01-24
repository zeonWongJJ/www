<?php

class Allow_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /*************************************** 验证是否登录 *****************************************/

    public function is_login()
    {
        if (!isset($_SESSION['store_id'])) {
            $a_parameter = [
                'msg'  => '请登录后再操作',
                'url'  => 'login',
                'log'  => false,
                'wait' => 2,
            ];
            session_destroy();
            $this->error->show_error($a_parameter);
        }
    }

    /***************************************** 验证权限 *******************************************/

    public function is_allow()
    {
        //验证当前店铺状态是否正常
        $a_where  = [
            'store_id' => $_SESSION['store_id'],
        ];
        $a_result = $this->db->get_row('store', $a_where, 'store_state');
        if ($a_result['store_state'] != 1) {


            $a_parameter = [
                'msg'  => '店铺已关闭,已退出门店管理！',
                'url'  => 'login',
                'log'  => false,
                'wait' => 2,
            ];
            $this->error->show_error($a_parameter);
            session_destroy();
            exit;

        }
        //判断当前管理员是否是超级管理员 如果是则直接跳过验证
        if ($_SESSION['manager_type'] == 1) {
            return true;
        }

        //获取当前访问的url
        $url = $this->router->get_index();
        //默认允许访问的权限
        $default_url = 'login-loginout-index-message-oute-order_detail-delivery_xindind-delivery_weixuan-appointment_getseat-appointment_timing-store_touxiang-save_plan-office_search-consumable_add-consumable_pass-proid_id_2-proid_id_3-haoc_id_2-haoc_id_3-haoc_name-proid_goode-image_upload-storetem_delete-wxrefund_notify-unionpay_refund_notify';
        //判断当前访问的url是否在默认权限里面
        if (strpos($default_url, $url) !== false) {
            return true;
        }
        unset($a_where);
        //获取当前管理员的所有权限
        $a_where = [
            'group_id' => $_SESSION['group_id'],
        ];
        $a_data  = $this->db->get_row('group', $a_where);
        $url_all = $a_data['group_auth'];
        //判断当前管理员是否有权访问
        if (strpos($url_all, $url) === false) {
            $this->error->show_remind('您无权访问该页面', 'index', false, 2);
        }
    }

    /**********************************************************************************************/

}
