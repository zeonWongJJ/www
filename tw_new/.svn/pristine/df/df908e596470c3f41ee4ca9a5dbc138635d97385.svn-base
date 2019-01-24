<?php
defined('BASEPATH') or exit('禁止访问！');
header("Content-Type:text/html;charset=utf8");
class Address_ctrl extends TW_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('address_model');
    }
   
    /**
     * [收获地址管理-首页面]
     */
    public function index(){
        //判断是否登录
        $this->login_model->login();
        $a_view_data = $this->db->get('address', ['member_id' => $_SESSION['user_id']]);
        $this->view->display('member/address', $a_view_data);
    }
    /**
     * [收获地址修改]
     */
    public function address_opera_edit(){
        $this->login_model->login();
        $id = $this->router->get('1');
        $a_data['address_data'] = $this->db->from('address as a')
                                ->join('area as b', ['a.city_id' => 'b.area_id'])
                                ->get_row('', ['a.address_id' => $id], ['a.area_id AS third', 'a.city_id AS second', 'b.area_parent_id AS first', 'a.true_name', 'a.mob_phone', 'a.tel_phone', 'a.address', 'a.address_id']); 
        $this->view->display('member/address_opera_edit', $a_data);        
    }
    //新增收货地址
    public function address_opera(){
        $this->login_model->login();
        $a_data = $this->db->from("area")->where(['area_deep'=>'1'])->get();
        // print_r($a_data);
        $this->view->display('member/address_opera', $a_data);
    } 

    /**
     * [delete 删除地址数据]
     * @param  [int]  [address_id  地址id]
     * @return [int]  [1|0] 成功与否
     */
    public function address_ajax_delete(){
        $this->login_model->login();
        $address_id = $this->router->get('1');
        $status_row = $this->address_model->delete_address($address_id);
        if (! empty($status_row)) {
            $this->error->show_success('删除成功！', $this->router->url('address'));
        }
        $this->error->show_error('删除失败！', $this->router->url('address'));
    }
    /**
     * [新增收货地址或修改]
     * @param  [string]  [$name | 收货人]
     * @param  [int]     [$area_id |地区ID]
     * @param  [string]  [$address | 详细地址]
     * @param  [int]     [$mobile | 手机号码]
     * @param  [int]     [$tel | 固定电话]
     * @param  [int]     [$is_default | 默认与否]
     * @return [boolean] [true|false 成功与否]
     */
    public function address_add_or_update() {
        
        $a_address_id = $this->general->post('address_id');
        $a_true = $this->general->post('true_name');
        $a_mob = $this->general->post('mob_phone');
        $a_tel = $this->general->post('tel_phone');
        $a_city = $this->general->post('city_id');
        $a_area = $this->general->post('area_id');
        $a_address = $this->general->post('address');
        $a_are = $this->get_three_grade_addrss($a_area);
        $a_area_id =  $a_are['c'].$a_are['b'].$a_are['a'];
        if (empty($a_true)) {
            $this->error->show_error('用户不能为空！');
        } else if (preg_match("/^[A-Za-z0-9]+$/",$a_true)) {
            $this->error->show_error('姓名有特殊字符！');
        }
        if (empty($a_mob)) {
            $this->error->show_error('手机不能为空！'); 
        } else if ( ! preg_match("/^1[34578]\d{9}$/", $a_mob)) {
            $this->error->show_error('手机格式错误！');
        }
        if (empty($a_area) || $a_area == 请选择 || empty($a_address)) {
            $this->error->show_error('地址信息填写不完善！请完善！');
        }
        $a_post = [
            'address_id' => $a_address_id, 
            'true_name' => $a_true,
            'mob_phone' => $a_mob,
            'tel_phone' => $a_tel,
            'area_info' => $a_area_id,
            'city_id' => $a_city,
            'area_id' => $a_area,
            'address' => $a_address
        ];
        $a_post_data = $this->security->xss_clean($a_post);
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

    public function address_update() {
        
        $a_address_id = $this->general->post('address_id');
        $a_true = $this->general->post('true_name');
        $a_mob = $this->general->post('mob_phone');
        $a_tel = $this->general->post('tel_phone');
        $a_city = $this->general->post('city_id');
        $a_area = $this->general->post('area_id');
        $a_address = $this->general->post('address');
        $a_are = $this->get_three_grade_addrss($a_area);
        $a_area_id =  $a_are['c'].$a_are['b'].$a_are['a'];
        if (empty($a_true)) {
            echo '用户不能为空！';die;
        } else if (preg_match("/^[A-Za-z0-9]+$/",$a_true)) {
            echo '姓名有特殊字符！';die;
        }
        if (empty($a_mob)) {
            echo '手机不能为空！';die; 
        } else if ( ! preg_match("/^1[34578]\d{9}$/", $a_mob)) {
            echo '手机格式错误！';die;
        }
        if (empty($a_area) || $a_area == 请选择 || empty($a_address)) {
            echo '地址信息填写不完善！请完善！';die;
        }
        $a_post = [
            'address_id' => $a_address_id, 
            'true_name' => $a_true,
            'mob_phone' => $a_mob,
            'tel_phone' => $a_tel,
            'area_info' => $a_area_id,
            'city_id' => $a_city,
            'area_id' => $a_area,
            'address' => $a_address
        ];
        $a_post_data = $this->security->xss_clean($a_post);
        //新增操作
        if ($a_post_data['address_id'] == '') {
            $address_status = $this->address_model->address_add($a_post_data);
            echo 1;  die;
        } else {
            //更新操作
            $address_status = $this->address_model->address_update($a_post_data);
        }
        
    }

    //地址
    public function get_three_grade_addrss($area_id){
           $a_data = $this->db->from('area as a')
                                ->join('area as b', ['a.area_parent_id' => 'b.area_id'])
                                ->join('area as c', ['b.area_parent_id' => 'c.area_id'])
                                ->where(['a.area_id'=>$area_id])
                                ->select("a.area_name as a,b.area_name as b,c.area_name as c",false)
                                ->get_row();
                            
            return $a_data;
    }
    // 跟新默认收货地址
    public function upaddress(){
        $s_address = $this->general->post('car');
        $this->db->update('address', ['is_default' => 0], ['member_id' => $_SESSION['user_id']]);
        $this->db->update('address', ['is_default' => 1], ['member_id' => $_SESSION['user_id'], 'address_id' => $s_address]);
        echo 1;
    }
}