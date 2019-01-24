<?php

class Allow_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /*********************************** 判断是否登录 ***********************************/

    public function is_login()
    {
        if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['role_id'])) {
            $this->error->show_error('请先登录再进行操作', 'login', false, 2);
        }
    }

    /**************************** 判断当前管理员是否有权访问 ****************************/

    public function is_allow()
    {
        //判断当前管理员是否是超级管理员 如果是则直接跳过验证
        if ($_SESSION['role_id'] == 1) {
            return true;
        }
        //获取当前访问的url
        $url = $this->router->get_index();
        //默认允许访问的权限
        $default_url = 'login-loginout-cons_name-imge-proid_id_2-proid_id_3-img_del-type_cate-deviceimg_upload-devicetem_delete-roomtem_delete-image_upload-order_details-appointment_search-join_info-share_see-share_order_details-book_search-index-messages_showlist-oute-package_product-packagetem_delete-adtem_delete';
        //判断当前访问的url是否在默认权限里面
        if (strpos($default_url, $url) !== false) {
            return true;
        }
        //获取当前管理员的所有权限
        $a_where = [
            'role_id' => $_SESSION['role_id'],
        ];
        $a_data  = $this->db->get_row('role', $a_where);
        $url_all = $a_data['role_auth'];
        //判断当前管理员是否有权访问
        if (strpos($url_all, $url) === false) {
            $this->error->show_remind('您无权访问该页面', 'index', false, 2);
        }
    }

    /************************************************************************************/

}