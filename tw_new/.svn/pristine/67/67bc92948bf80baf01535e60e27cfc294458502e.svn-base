<?php
defined('BASEPATH') or exit('禁止访问！');
header("Content-Type:text/html;charset=utf8");
class Address_ctrl extends TW_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('allow_model');
        $this->allow_model->is_login();         
    }

    /**
     * [收获地址管理-首页面]
     */
    public function address() {
        $a_data['addre'] = $this->db->order_by(['address_id' => 'desc'])->get('address', ['user_id' => $_SESSION['user_id']]);
        $this->view->display('address', $a_data);
    }

    /**
     * [delete 删除地址数据]
     * @param  [int]  [id  地址id]
     */
    public function address_delete(){
        $i_id = $this->general->post('id');
        $status_row = $this->db->delete('address', ['address_id' => $i_id, 'user_id' => $_SESSION['user_id']]);
        if ($status_row) {
            echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
        } else {
            echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
        } 
    }

    /**
     * [新增收货地址]
     * @param  [string]  [$a_name | 收货人]
     * @param  [string]  [$a_address | 详细地址]
     * @param  [int]     [$a_mob | 手机号码]
     * @return [boolean] [true|false 成功与否]
     */
    public function address_add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $a_address = trim($this->general->post('address')); 
            $a_name    = trim($this->general->post('name'));
            $a_mob     = trim($this->general->post('mob'));
            $a_nei     = trim($this->general->post('nei'));
            $i_house   = trim($this->general->post('house'));
            $this->load->library('map_gaode');
            $a_result  = $this->map_gaode->address_to_degree($a_address);
            $a_lon     = $a_result['latitude'].','. $a_result['longitude'];
            if (empty($a_name)) {
                $this->error->show_error('用户不能为空！');
            } else if (preg_match("/^[A-Za-z0-9]+$/",$a_true)) {
                $this->error->show_error('姓名有特殊字符！');
            }
            if (empty($a_mob)) {
                $this->error->show_error('手机不能为空！'); 
            } else if ( ! preg_match("/^1[34578]\d{9}$/", $a_mob)) {
                $this->error->show_error('手机格式错误！');
            }
            if (empty($a_address) || empty($i_house)) {
                $this->error->show_error('地址信息填写不完善！请完善！');
            }
            $a_post = [
                'user_id'   => $_SESSION['user_id'], 
                'user_name' => $a_name,
                'mob_phone' => $a_mob,
                'nei'       => $a_nei,
                'longitude' => $a_lon,
                'address'   => $a_address,
                'house'     => $i_house,
            ];
            $a_post_data = $this->security->xss_clean($a_post);
            $result = $this->db->insert('address', $a_post_data);
            // print_r($result);die;
            //判断提示语
            if ($result) {
                $this->error->show_success('添加成功!', 'address?oldurl='.$_GET['oldurl'], '', 1);
            } else {
                $this->error->show_error('添加失败！', 'address?oldurl='.$_GET['oldurl'], '', 1);
            }  
        } else {
            // print_r($_POST);
            $this->view->display('address_add');
        }   
    }

    //地址修改
    public function address_update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            $i_id      = trim($this->general->post('id'));
            $a_address = trim($this->general->post('address')); 
            $a_name    = trim($this->general->post('name'));
            $a_mob     = trim($this->general->post('mob'));
            $a_nei     = trim($this->general->post('nei'));
            $i_house   = trim($this->general->post('house'));
            $this->load->library('map_gaode');
            $a_result  = $this->map_gaode->address_to_degree($a_address);
            $a_lon     = $a_result['latitude'].','. $a_result['longitude'];
            if (empty($a_name)) {
                 $this->error->show_error('用户不能为空！', 'address_update-'.$i_id, '', 2);
            } else if (preg_match("/^[A-Za-z0-9]+$/",$a_true)) {
                 $this->error->show_error('姓名有特殊字符！', 'address_update-'.$i_id, '', 2);
            }
            if (empty($a_mob)) {
                 $this->error->show_error('手机不能为空！', 'address_update-'.$i_id, '', 2); 
            } else if ( ! preg_match("/^1[34578]\d{9}$/", $a_mob)) {
                 $this->error->show_error('手机格式错误！', 'address_update-'.$i_id, '', 2);
            }
            if (empty($a_address) || empty($i_house)) {
                 $this->error->show_error('地址信息填写不完善！请完善！', 'address_update-'.$i_id, '', 2);
            }
            $a_post = [
                'user_name' => $a_name,
                'mob_phone' => $a_mob,
                'nei'       => $a_nei,
                'longitude' => $a_lon,
                'address'   => $a_address,
                'house'     => $i_house,
            ];
            $a_post_data = $this->security->xss_clean($a_post);
            $result = $this->db->update('address', $a_post_data, ['address_id' => $i_id, 'user_id' => $_SESSION['user_id']]);  
           //判断提示语
            if ($result) {
                $this->error->show_success('修改成功!', 'address?oldurl='.$_GET['oldurl'], '', 1);
            } else {
                $this->error->show_error('修改失败或数据无修改。', 'address?oldurl='.$_GET['oldurl'], '', 1);
            }      
        } else {
            $i_id = $this->router->get(1);
            $a_data = $this->db->get_row('address', ['address_id' => $i_id, 'user_id' => $_SESSION['user_id']]);    
            $this->view->display('address_update', $a_data);
        }    
    }

    // 跟新默认收货地址
    public function upaddress() {
        $s_address = $this->general->post('id');
        $this->db->update('address', ['is_default' => 0], ['user_id' => $_SESSION['user_id']]);
        $result = $this->db->update('address', ['is_default' => 1], ['user_id' => $_SESSION['user_id'], 'address_id' => $s_address]);   
        if ($result) {
            echo json_encode(array('code'=>200, 'msg'=>'设置成功'));
        } else {
            echo json_encode(array('code'=>400, 'msg'=>'设置失败'));
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
}