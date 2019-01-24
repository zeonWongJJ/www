<?php
defined('BASEPATH') or exit('禁止访问！');
header("Content-Type:text/html;charset=utf8");
class Address_ctrl extends TW_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->address_islogin_ctrl();
    }
    /**
     * [判断是否登录状态]
     * @return [status] [true|false]
     */
    public function address_islogin_ctrl(){
        if ( ! isset( $_SESSION['user_name']) ) {
            $this->error->show_warning('您没有登陆', '/');
            //如果没登陆的话跳转
        }
    }
    /**
     * [收获地址管理-首页面]
     */
    public function index(){
     
        $userid = $_SESSION['user_id'];
        $this->load->model('address_model');
        $a_view_data = $this->address_model->address_data($userid);

        //如果不存在地址数据
        if (empty($a_view_data)){
         
         $this->view->display("address", $a_view_data);

         die;
        }

        //拿到最基本数据
        // $a_grade_data=$this->address_model->get_three_grade_address($a_grade_id);
        foreach ($a_view_data as $key => $value) {
            $a_view_data[$key]['member_email'] = $this->address_model->address_dispose("email", $value['member_email']);
            $a_view_data[$key]['mob_phone'] = $this->address_model->address_dispose("mobile", $value['mob_phone']);
            $a_grade_id[$value['area_id']]['address_detail'] = $value['area_id'];
            //打包成三级地址 ID数组
        }
        $a_grade_data = $this->address_model->get_three_grade_address($a_grade_id);
        //拿到具体的三级地址名
        foreach ($a_view_data as $key => $value) {
            //辽宁 本溪市 本溪满族自治县 生成该类型字符串
            $s_grade_all = $a_grade_data[$value['area_id']]['first_name'] . ' ' . $a_grade_data[$value['area_id']]['second_name'] . ' ' . $a_grade_data[$value['area_id']]['third_name'];
            $a_view_data[$key]['three_grade'] = $s_grade_all;
        }
        $this->view->display('address', $a_view_data);
    }
    /**
     * [ajax 设置默认]
     * @param  [int]  [地址id]
     * @return [boolean] [true|false] 成功与否
     */
    public function address_ajax_set_default(){

        $address_id = $this->general->post('id');
        $this->load->model('address_model');
        $set_default_result = $this->address_model->set_default($address_id);
        if ($set_default_result > 0) {
            echo 1;
        } else {
            echo 0;
        }

    }
    /**
     * [select 收获地址]
     * @param  [int]  [address_id  地址id]
     * @return [array] [该ID对应的数据]
     */
    public function address_ajax_select(){
     
        $address_id = $this->general->post('id');
        $this->load->model('address_model');
        $address_data = $this->address_model->get_address($address_id);
        // var_dump($address_data);
        if ($address_data) {
            echo json_encode($address_data);
        } else {
            echo false;
        }

    }
    /**
     * [delete 删除地址数据]
     * @param  [int]  [address_id  地址id]
     * @return [int]  [1|0] 成功与否
     */
    public function address_ajax_delete(){

        $address_id = $this->general->post('id');
        $this->load->model('address_model');
        $status_row = $this->address_model->delete_address($address_id);
        //返回受影响行数
        echo $status_row;
    }
    /**
     * [地区数据导出]
     */
    function address_export()
    {
        
        $export_token = $this->general->get('token');
        if ($export_token == '32121321121') {
            $this->load->model('address_model');
            $address_data = $this->address_model->select_export_address();
        }
    }
    /**
     * [新增收货地址]
     * @param  [string]  [$name | 收货人]
     * @param  [int]     [$area_id |地区ID]
     * @param  [string]  [$address | 详细地址]
     * @param  [int]     [$mobile | 手机号码]
     * @param  [int]     [$tel | 固定电话]
     * @param  [int]     [$is_default | 默认与否]
     * @return [boolean] [true|false 成功与否]
     */
    public function address_add_or_update()
    {
    
        $a_post = $this->general->post();
        $a_post_data = $this->security->xss_clean($a_post);

        $this->load->model('address_model');
        //新增操作
        if ($a_post_data['address_id'] == '') {
            $address_status = $this->address_model->address_add($a_post_data);
        } else {
            //更新操作
            $address_status = $this->address_model->address_update($a_post_data);
        }
        //判断提示语
        if ($address_status == 1) {
            $this->error->show_success('更新成功。', $this->router->url('address'));
        } else {
            $this->error->show_success('更新失败或数据无修改。', $this->router->url('address'));
        }
    }
}