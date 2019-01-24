<?php
defined('BASEPATH') or exit('禁止访问！');
header("Content-Type:text/html;charset=utf8");
class Address_ctrl extends TW_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('allow_model');
         $this->load->model('store_model');
        $this->allow_model->is_login();
        $this->address_addta();
    }

    /**
     * [收获地址管理-首页面]
     */
    public function address() {
        $a_data['addre'] = $this->db->order_by(['address_id' => 'desc'])->get('address', ['user_id' => $_SESSION['user_id']]);
        $this->view->display('address', $a_data);
    }

   /**
     * [收获地址管理-首页面]
     */
    public function naddress() {
        $i_store_id = trim($this->router->get(1));
            if($i_store_id>0){
                $a_data['store_id'] = $i_store_id;
                $store_position = $this->db->get_row("store",['store_id'=>$i_store_id,'store_state'=>1],'store_position,order_distance');  
               list($store_lng,$store_lat) =explode(',',$store_position['store_position']);
            }
             
                $a_where = ['user_id' => $_SESSION['user_id']];
                $a_order = ['address_id' => 'desc'];
                $a_addr = $this->db->get("address",$a_where,'',$a_order,0,999999); 
                 $new_arr = array();
                foreach ($a_addr as $key => $value) {
                list($addr_lat,$addr_lng) = explode(',', $value['longitude']);
                $distance = $this->store_model->get_distance($addr_lng, $addr_lat, $store_lng, $store_lat);
                if( $distance <=$store_position['order_distance']){
                        $value['set'] =1;
                }else{
                     $value['set'] =2;
                   
                }
                  $new_arr[$key] =$value;
                 
                }

                $a_data['a_addr'] = $new_arr; 
                $a_data['out_addr'] = $out_arr;      
        $this->view->display('naddress',$a_data);
    }   
    //返回地址列表数据接口 
    public function naddress_list() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //d_type: 1:返回地址列表数据 2：返回某个地址数据 3：处理编辑地址表单数据 4：处理添加地址表单数据 5:删除收货地址
            $d_type =  $this->general->post('type');
            if($d_type == 1) {
            $i_store_id = $this->general->post("store_id");
             if($i_store_id>0){
                $a_data['store_id'] = $i_store_id;
                $store_position = $this->db->get_row("store",['store_id'=>$i_store_id,'store_state'=>1],'store_position,order_distance');  
               list($store_lng,$store_lat) =explode(',',$store_position['store_position']);
            }
                $a_where = ['user_id' => $_SESSION['user_id']];
                $a_order = ['is_default'=>'desc','address_id' => 'desc'];
                $a_addr = $this->db->get("address",$a_where,'',$a_order,0,999999);
                if($a_addr && is_array($a_addr)){
                $new_arr = array();
                foreach ($a_addr as $key => $value) {
                list($addr_lat,$addr_lng) = explode(',', $value['longitude']);
                $distance = $this->store_model->get_distance($addr_lng, $addr_lat, $store_lng, $store_lat);
                if($i_store_id >0){
                if(  $distance <=$store_position['order_distance']){
                        $value['set'] =1;
                }else{
                         $value['set'] =2;
                   
                }
                }else{
                     $value['set'] =1;
                }
                  $new_arr[$key] =$value;
                 }
                    echo json_encode(array("msg"=>"请求成功",'code'=>200,'data' =>$new_arr));  
                }else {
                    echo json_encode(array("msg"=>"请求成功",'code'=>400));
                }
            }else if($d_type ==2){
               $addr_id =  $this->general->post('addr_id'); 
                $a_where = ['user_id' => $_SESSION['user_id'] , 'address_id' => $addr_id];
                $a_addr = $this->db->get_row("address",$a_where);
                if($a_addr && is_array($a_addr)){
                    echo json_encode(array("msg"=>"请求成功",'code'=>200,'data' =>$a_addr));  
                }else {
                    echo json_encode(array("msg"=>"请求成功",'code'=>400));
                }                

            }else if($d_type ==3) {
                $address_id =  trim($this->general->post('address_id'));
                $location   =  trim($this->general->post('location'));
                $address    =  trim($this->general->post('address'));
                $house      =  trim($this->general->post('house'));
                $mob_phone  =  trim($this->general->post('mob_phone'));
                $user_name  =  trim($this->general->post('user_name'));
                $nei        =  trim($this->general->post('nei'));
                $user_id    =  trim($this->general->post('user_id'));
                $a_update =[
                    'address'  => $address,
                    'longitude' => $location,
                    'house'    => $house,
                    'nei'      => $nei,
                    'mob_phone'=> $mob_phone,
                    'user_name'=> $user_name,
                    'user_id'  => $user_id,
                    'is_default'=>1,

                ];
                if(!preg_match("/^1[34578]{1}\d{9}$/",$mob_phone)){  
                    echo json_encode(array("msg"=>"手机号码不正确,请重新输入!",'code'=>400)); 
                    exit;
                }
                $a_wheree = ['address_id' =>$address_id];
                $this->db->update('address', ['is_default' => 0], ['user_id' => $user_id]);
                $i_result = $this->db->update("address", $a_update, $a_wheree);
                
                if($i_result) {
                    echo json_encode(array("msg"=>"请求成功",'code'=>200));  
                }else {
                    echo json_encode(array("msg"=>"修改失败",'code'=>400));  
                }
                
            }else if($d_type == 4) {
                $location   =  trim($this->general->post('location'));
                $address    =  trim($this->general->post('address'));
                $house      =  trim($this->general->post('house'));
                $mob_phone  =  trim($this->general->post('mob_phone'));
                $user_name  =  trim($this->general->post('user_name'));
                $nei        =  trim($this->general->post('nei'));
                $user_id    =  $_SESSION['user_id'];
                if(!in_array($nei,array(1,2))) {
                    exit(json_encode(array("msg"=>"请选择性别",'code'=>400))); 
                }
                $a_insert =[
                    'address'  => $address,
                    'longitude' => $location,
                    'house'    => $house,
                    'nei'      => $nei,
                    'mob_phone'=> $mob_phone,
                    'user_name'=> $user_name,
                    'user_id'  => $user_id,
                    'is_default'=>1,

                ];
                if(!preg_match("/^1[34578]{1}\d{9}$/",$mob_phone)){  
                    echo json_encode(array("msg"=>"手机号码不正确,请重新输入!",'code'=>400)); 
                    exit;
                }
                $a_wheree = ['address_id' =>$address_id];
                $this->db->update('address', ['is_default' => 0], ['user_id' => $_SESSION['user_id']]);
                $i_result = $this->db->insert("address", $a_insert);
                
                if($i_result) {
                    $a_dara = $this->db->get_row("address",['address_id' => $i_result]);
                    echo json_encode(array("msg"=>"请求成功",'code'=>200 , 'data' => $a_dara));  
                }else {
                    echo json_encode(array("msg"=>"修改失败",'code'=>400));  
                }
                
            }else if($d_type ==5){
               $addr_id =  $this->general->post('address_id'); 
                $a_where = ['user_id' => $_SESSION['user_id'] , 'address_id' => $addr_id];
                $i_result = $this->db->delete("address",$a_where);
                if($i_result){
                    echo json_encode(array("msg"=>"请求成功",'code'=>200));  
                }else {
                    echo json_encode(array("msg"=>"删除失败!",'code'=>400));
                }                

            }
        
        }
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
            $a_res = array('msg' => '请求失败！','status' =>0);
            if (empty($this->general->post('address'))) {
                $a_address = $_SESSION['address'];
                $a_lon     = $_SESSION['a_lon'];
            } else {
                $a_address = trim($this->general->post('address'));
                $a_lon     = trim($this->general->post('lon'));
            }
            $a_name    = trim($this->general->post('name'));
            $a_mob     = trim($this->general->post('mob'));
            $a_nei     = trim($this->general->post('nei'));
            $i_house   = trim($this->general->post('house'));
            if (empty($a_name)) {
                $a_res['msg'] ='收货名不能为空！';
                exit(json_encode($a_res));
            } else if (preg_match("/^[A-Za-z0-9]+$/",$a_true)) {
                $a_res['msg'] ='姓名有特殊字符！';
                exit(json_encode($a_res));                
            }
            if (empty($a_mob)) {
                $a_res['msg'] ='手机不能为空！';
                exit(json_encode($a_res));                
            } else if ( ! preg_match("/^1[34578]\d{9}$/", $a_mob)) {
                $a_res['msg'] ='手机格式错误！';
                exit(json_encode($a_res));                  
            }
            if (empty($a_address) || empty($i_house)) {
                $a_res['msg'] ='地址信息填写不完善！请完善！';
                exit(json_encode($a_res));                 
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
                $a_res['msg'] ='添加成功!';
                $a_res['status'] = 1;
            } else {
                $a_res['msg'] ='添加失败!';
            }
            exit(json_encode($a_res));
        } else {
            // print_r($_POST);
            $this->view->display('address_add');
        }
    }
    public function address_addta() {
        $_SESSION['a_lon']   = trim($this->general->post('lon')) ? trim($this->general->post('lon')) : $_SESSION['a_lon'];
        $_SESSION['address'] = trim($this->general->post('address')) ? trim($this->general->post('address')) : $_SESSION['address'];
    }

    //地址修改
    public function address_update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $a_result = array('msg' =>'请求失败!' , 'status'=> 0);
            $this->address_up();
            if (empty($this->general->post('address'))) {
                $a_address = $_SESSION['addr'];
                $a_lon     = $_SESSION['lon'];
            } else {
                $a_address = trim($this->general->post('address'));
                $a_lon     = trim($this->general->post('lon'));
            }
            $i_id      = trim($this->general->post('id'));
            $a_name    = trim($this->general->post('name'));
            $a_mob     = trim($this->general->post('mob'));
            $i_house   = trim($this->general->post('house'));
            $a_nei     = trim($this->general->post('nei'));
            if (empty($a_name)) {
                $a_result['msg'] = '用户不能为空';
            } else if (preg_match("/^[A-Za-z0-9]+$/",$a_true)) {
                $a_result['msg'] = '姓名有特殊字符！';
            }
            if (empty($a_mob)) {
                 $a_result['msg'] = '手机不能为空！';
                 echo json_encode($a_result);
                 exit;                 
            } else if ( ! preg_match("/^1[34578]\d{9}$/", $a_mob)) {
                $a_result['msg'] = '手机格式错误！';
                echo json_encode($a_result);
                exit;                
            }
            if (empty($a_address) || empty($i_house)) {
                 $a_result['msg'] = '地址信息填写不完善！请完善！';
                 echo json_encode($a_result);
                 exit;
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
                $a_result['msg'] = '修改成功!';
                $a_result['status'] = 1;
            } else {
                $a_result['msg'] = '修改失败或数据无修改。!';
            }
            echo json_encode($a_result);
            exit;
        } else {
            $i_id = $this->router->get(1);
            $a_data = $this->db->get_row('address', ['address_id' => $i_id, 'user_id' => $_SESSION['user_id']]);
            $a_data[1] = explode(',', $a_data['longitude']);
            $a_data['now_lon'] = explode(',', $a_data['longitude']);
            // print_r($a_data);exit;
            $this->view->display('address_update', $a_data);
        }
    }
    public function address_up () {
        $_SESSION['lon']  = trim($this->general->post('lon')) ? trim($this->general->post('lon')) : $_SESSION['lon'];
        $_SESSION['addr'] = trim($this->general->post('address')) ? trim($this->general->post('address')) : $_SESSION['addr'];
        // $_SESSION['lon']  = 558;
        // $_SESSION['addr'] = 874;
        // $this->db->insert('address', ['address' => $_SESSION['addr'], 'longitude' => $_SESSION['lon']]);
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