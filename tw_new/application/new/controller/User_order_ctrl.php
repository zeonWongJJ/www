<?php

class User_order_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('user_order_model');
        $this->load->model('is_login_model');
        $this->is_login_model->is_login();
	}

/**********************************************************************************/

    //会员中心->需求订单->全部订单
    public function demand_all() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
           $a_data_all = $this->user_order_model->get_demand_all();
           echo "<pre>";
           print_r($a_data_all);die;
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->传入不同状态码获取不同状态下的订单信息
    public function demand_custom() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //接收需要的状态码
            $state = $this->router->get(1);
            $a_demand_custom = $this->user_order_model->get_demand_custom($state);
            echo "<pre>";
            var_dump($a_demand_custom);die;
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->竞标中的订单
    public function demand_bid() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $a_data_bid = $this->user_order_model->get_demand_bid();
           echo "<pre>";
           print_r($a_data_bid);die;
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->待付款的订单
    public function demand_waitpay() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $a_data_waitpay = $this->user_order_model->get_demand_waitpay();
           echo "<pre>";
           print_r($a_data_waitpay);die;
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->待确定的订单
    public function demand_waitconfirm() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $a_data_waitconfirm = $this->user_order_model->get_demand_waitconfirm();
           echo "<pre>";
           print_r($a_data_waitconfirm);die;
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->待服务的订单
    public function demand_waitservice() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $a_data_waitservice = $this->user_order_model->get_demand_waitservice();
           echo "<pre>";
           print_r($a_data_waitservice);die;
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->服务中的订单
    public function demand_inservice() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $a_data_inservice = $this->user_order_model->get_demand_inservice();
           echo "<pre>";
           print_r($a_data_inservice);die;
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->待评价的订单
    public function demand_waitcomment() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $a_data_waitcomment = $this->user_order_model->get_demand_waitcomment();
           echo "<pre>";
           print_r($a_data_waitcomment);die;
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->已完成的订单
    public function demand_complete() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $a_data_complete = $this->user_order_model->get_demand_complete();
           echo "<pre>";
           print_r($a_data_complete);die;
        }
    }

/**********************************************************************************/

    //获取某一条订单的详情
    public function demand_detail() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //接收需要查询详情的订单id
            $id = $this->router->get(1);
            $a_data = $this->user_order_model->get_demand_detail($id);
            $this->view->display('competitiveOrder', $a_data);
        }
    }

/**********************************************************************************/

    //查询某一条订单的投标详情
    public function demand_bid_detail() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //接收需要查看详情的订单id
            $id = $this->router->get(1);
            //订单详情
            $a_data_detail = $this->user_order_model->get_demand_detail($id);
            $selected_bid = $a_data_detail['selected_bid'];
            //已选中的投标者信息
            if ($a_data_detail['state'] != 11) {
                $a_bid_selected = $this->user_order_model->get_server_selected($selected_bid);
            } else {
                $a_bid_selected = array();
            }
            //未选中的投标者信息
            $a_bid_unselected = $this->user_order_model->get_server_unselected($a_data_detail);
            $a_data = [
                'order_detail'   => $a_data_detail,
                'bid_selected'   => $a_bid_selected,
                'bid_unselected' => $a_bid_unselected
            ];
            $this->view->display('competitiveDetails', $a_data);
        }
    }

/**********************************************************************************/

    //取消订单
    public function demand_cancel() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //接收需要取消的订单id
            $id = $this->router->get(1);
            //订单详情
            $a_demand_detail = $this->user_order_model->get_demand_detail($id);
            //将已选中的服务者与竞标id清除
            $i_update_result = $this->user_order_model->update_demand_cancel($id);
            //插入一条跟踪信息
            $a_data = [
                'demand_id'         => $id,
                'service_state'     => $a_demand_detail['state'],
                'classify'          => 2,
                'classify_user'     => $_SESSION['user_name'],
                'classify_msg'      => '取消了订单',
                'write_time'        => $_SERVER['REQUEST_TIME'],
                'classify_uid'      => $_SESSION['user_id']
            ];
            $i_insert_result = $this->user_order_model->insert_message_logging($a_data);
            echo $i_insert_result;die;
        }
    }

/**********************************************************************************/

    //会员中心->需求中的订单->选中某个服务者
    public function demand_selected() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //接收需要选中的竞标id
            $id = $this->router->get(1);
            //更新订单表
            $i_update_result = $this->user_order_model->update_demand_selected($id);
            echo $i_update_result;die;
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->确定服务完成
    public function demand_confirm_finish() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //接收需要确定完成的需求id
            $id = $this->router->get(1);
            $i_update_result = $this->user_order_model->update_demand_finish($id);
            echo $i_update_result;die;
        }
    }

/*****************************************************************************************/

    //会员中心->需求订单->申请退款
    public function for_refund() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //接收数据
            $demand_id     = $this->general->post('demand_id');
            $server_id     = $this->general->post('server_id');
            $demand_state  = $this->general->post('demand_state');
            $service_state = $this->general->post('service_state');
            $refund_why    = trim($this->general->post('refund_why'));
            $refund_money  = trim($this->general->post('refund_money'));
            $refund_detail = trim($this->general->post('refund_detail'));
            //验证数据的合法性
            if (strlen($refund_why)<2 || strlen($refund_why)>100) {
                echo json_encode(array('code'=>21, 'msg'=>'退款原因不合法'));
                die;
            }
            if (!is_numeric($refund_money) || strlen($refund_money)==0) {
                echo json_encode(array('code'=>22, 'msg'=>'退款金额不合法'));
                die;
            }
            //调用文件上传方法上传视频和图片
            $file = $_FILES['refund_video'];
            //允许上传的类型
            $allow = array('image/jpeg','image/jpg','image/png',);
            //确定上传的目录
            $path = './images';
            //确定文件上传的大小 1M
            $maxsize = 1048576;
            //上传视频凭证
            $refund_video = $this->upload_img($file, $allow, $error, $path, $maxsize);

            //上传图片凭证
            $file = $_FILES['refund_img'];
            for ($i=0; $i < count($_FILES['refund_img']['name']); $i++) {
                $files[$i]['name']     =    $file['name'][$i];
                $files[$i]['type']     =    $file['type'][$i];
                $files[$i]['tmp_name'] =    $file['tmp_name'][$i];
                $files[$i]['error']    =    $file['error'][$i];
                $files[$i]['size']     =    $file['size'][$i];
            }
            for ($i=0; $i<count($files); $i++) {
                if ($files[$i]['error'] == 0) {
                    $file    = $files[$i];
                    $names[] = $this->upload_img($file, $allow, $error, $path, $maxsize);
                }
            }
            $img_path = implode('&', $names);
            if ($img_path == '&&&') {
                $img_path = '';
            }

            $a_data = [
                'demand_id'       =>    $demand_id,
                'demand_uid'      =>    $_SESSION['user_id'],
                'demand_state'    =>    $demand_state,
                'server_uid'      =>    $server_id,
                'service_state'   =>    $service_state,
                'refund_why'      =>    $refund_why,
                'refund_money'    =>    $refund_money,
                'refund_detail'   =>    $refund_detail,
                'refund_video'    =>    $refund_video,
                'refund_img'      =>    $img_path,
                'refund_number'   =>    date('Ymdhis',time()) . rand(111,999),
                'refund_time'     =>    $_SERVER['REQUEST_TIME'],
                'refund_type'     =>    1,
                'refund_tip'      =>    '需求者发起退款申请',
            ];
            //调用模型方法实现插入数据
            $i_result = $this->user_order_model->insert_refund($a_data);
            if ($i_result) {
                echo json_encode(array('code'=>200, 'msg'=>'申请成功，系统将尽快处理'));
            } else {
                echo json_encode(array('code'=>400, 'msg'=>'申请失败，发生未知错误'));
            }
        } else {
            //接收需要退款的需求id
            $id = $this->router->get(1);
            //查询退款需求的详情返回给页面
            $a_data = $this->user_order_model->get_demand_detail($id);
            //判断是否符合退款时间
            if ($a_data['state'] > 105) {
                if ($a_data['finish_time']+3600*72 < $_SERVER['REQUEST_TIME']) {
                    $this->error->show_remind('已过退款期限', 'demand_all', false, 2);
                }
            }
            //判断该条订单之前是否有申请过退款
            $i_refund_total = $this->user_order_model->get_refund_total($id);
            if ($i_refund_total>0) {
                $this->error->show_remind('同一条订单不能多次提交退款申请', 'demand_all', false, 2);
            }
            $this->view->display('for_refund', $a_data);
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->查看退款订单详情
    public function refund_detail() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
           //接收需要查看详情的id
           $id = $this->router->get(1);
           //获取订单的详情
           $a_demand_detail = $this->user_order_model->get_demand_detail($id);
           //获取退款详情
           $a_data_refund = $this->user_order_model->get_refund_detail($a_demand_detail);
           //服务者信息
           $a_data_server = $this->user_order_model->get_refund_server($a_demand_detail);
           $a_data = array(
                'demand_detail' => $a_demand_detail,
                'data_refund'   => $a_data_refund,
                'data_server'   => $a_data_server
            );
           echo "<pre>";
           print_r($a_data);die;
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->退款进度
    public function refund_schedule() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //接收需要查看进度的需求id
            $id = $this->router->get(1);
            $a_data = $this->user_order_model->get_refund_schedule($id);
            echo "<pre>";
            print_r($a_data);die;
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->修改退款申请
    public function refund_update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //接收用户提交的信息
            $refund_why    = trim($this->general->post('refund_why'));
            $refund_money  = trim($this->general->post('refund_money'));
            $refund_detail = trim($this->general->post('refund_detail'));
            $refund_id     = $this->general->post('refund_id');
            $refund_video  = $this->general->post('refund_video');
            $demand_id     = $this->general->post('demand_id');
            $service_state = $this->general->post('service_state');

            //验证数据的合法性
            if (strlen($refund_why)<2 || strlen($refund_why)>100) {
                echo json_encode(array('code'=>21, 'msg'=>'退款原因不合法'));
                die;
            }
            if (!is_numeric($refund_money) || strlen($refund_money)==0) {
                echo json_encode(array('code'=>22, 'msg'=>'退款金额不合法'));
                die;
            }

            //获取旧数据的信息
            $a_refund_old = $this->user_order_model->get_refund_old($refund_id);

            //调用文件上传方法上传视频和图片
            $file = $_FILES['refund_video'];
            //允许上传的类型
            $allow = array('image/jpeg','image/jpg','image/png',);
            //确定上传的目录
            $path = './images';
            //确定文件上传的大小 1M
            $maxsize = 1048576;
            //上传视频凭证
            if ($_FILES['refund_video']['error'] == 0) {
                $refund_video = $this->upload_img($file, $allow, $error, $path, $maxsize);
            }

            //上传图片凭证
            if ($_FILES['refund_img']['name'][0] != '') {
                $file = $_FILES['refund_img'];
                for ($i=0; $i < count($_FILES['custom_img']['name']); $i++) {
                    $files[$i]['name']     = $file['name'][$i];
                    $files[$i]['type']     = $file['type'][$i];
                    $files[$i]['tmp_name'] = $file['tmp_name'][$i];
                    $files[$i]['error']    = $file['error'][$i];
                    $files[$i]['size']     = $file['size'][$i];
                }
                for ($i=0; $i<count($files); $i++) {
                    if ($files[$i]['error'] == 0) {
                        $file    = $files[$i];
                        $names[] = $this->upload_img($file, $allow, $error, $path, $maxsize);
                    }
                }
                $img_path = implode('&', $names);
            } else {
                //到原数据中获取原图片地址
                $img_path = $a_refund_old['refund_img'];
            }

            $a_update_data = [
                'demand_id'         => $a_refund_old['demand_id'],
                'demand_uid'        => $a_refund_old['demand_uid'],
                'demand_state'      => $a_refund_old['demand_state'],
                'server_uid'        => $a_refund_old['server_uid'],
                'refund_number'     => $a_refund_old['refund_number'],
                'refund_why'        => $refund_why,
                'refund_money'      => $refund_money,
                'refund_detail'     => $refund_detail,
                'refund_video'      => $refund_video,
                'refund_img'        => $img_path,
                'refund_time'       => $_SERVER['REQUEST_TIME'],
                'refund_type'       => 3,
                'refund_tip'        => '需求者修改了退款申请',
                'service_state'     => $service_state
            ];

            //调用模型方法实现插入数据
            $i_result = $this->user_order_model->update_refund_change($a_update_data, $demand_id);
            if ($i_result) {
                echo json_encode(array('code'=>200, 'msg'=>'修改退款成功'));
            } else {
                echo json_encode(array('code'=>400, 'msg'=>'修改退款失败'));
            }
        } else {
           //接收需要修改的退款订单id
           $id = $this->router->get(1);
           //获取订单的详情
           $a_demand_detail = $this->user_order_model->get_demand_detail($id);
           //获取退款详情
           $a_data_refund = $this->user_order_model->get_refund_detail($a_demand_detail);
           $a_data = [
                'demand_detail' => $a_demand_detail,
                'data_refund'   => $a_data_refund,
           ];
           $this->view->display('update_refund', $a_data);
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->撤消退款申请 订单将回到退款前的状态
    public function refund_cancel() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //接收需要撤消退款的需求id
            $id = $this->router->get(1);
            //获取订单的详情
            $a_demand_detail = $this->user_order_model->get_demand_detail($id);
            //撤消退款申请 订单将回到之前的状态
            $i_update_result = $this->user_order_model->update_refund_cancel($a_demand_detail);
            echo $i_update_result;die;
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->申请客服介入
    public function refund_custom_service() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //接收数据
            $demand_id     = $this->general->post('demand_id');
            $refund_id     = $this->general->post('refund_id');
            $custom_why    = trim($this->general->post('custom_why'));
            $proposer_tel  = trim($this->general->post('proposer_tel'));
            $custom_detail = trim($this->general->post('custom_detail'));
            //当前订单的状态
            $demand_state = $this->general->post('demand_state');
            //对数据进行验证
            if (strlen($custom_why)==0 || strlen($proposer_tel)==0 || strlen($custom_detail)==0) {
                $this->error->show_remind('数据不能为空', 'demand_all', false, 2);
                die;
            }
            //调用文件上传方法上传视频和图片
            $file = $_FILES['custom_video'];
            //允许上传的类型
            $allow = array('image/jpeg','image/jpg','image/png',);
            //确定上传的目录
            $path = './images';
            //确定文件上传的大小 1M
            $maxsize = 1048576;
            //上传视频凭证
            $custom_video = $this->upload_img($file, $allow, $error, $path, $maxsize);

            //上传图片凭证
            $file = $_FILES['custom_img'];
            for ($i=0; $i < count($_FILES['custom_img']['name']); $i++) {
                $files[$i]['name']     =    $file['name'][$i];
                $files[$i]['type']     =    $file['type'][$i];
                $files[$i]['tmp_name'] =    $file['tmp_name'][$i];
                $files[$i]['error']    =    $file['error'][$i];
                $files[$i]['size']     =    $file['size'][$i];
            }
            for ($i=0; $i<count($files); $i++) {
                if ($files[$i]['error'] == 0) {
                    $file    = $files[$i];
                    $names[] = $this->upload_img($file, $allow, $error, $path, $maxsize);
                }
            }
            $img_path = implode('&', $names);
            if ($img_path == '&&&') {
                $img_path = '';
            }

            $a_data = [
                'demand_id'     => $demand_id,
                'detail_id'     => $refund_id,
                'proposer_id'   => $_SESSION['user_id'],
                'proposer_tel'  => $proposer_tel,
                'custom_why'    => $custom_why,
                'custom_detail' => $custom_detail,
                'custom_video'  => $custom_video,
                'custom_img'    => $img_path,
                'custom_time'   => $_SERVER['REQUEST_TIME'],
                'custom_type'   => 1, //1代表退款过程中提交的客服介入
                'demand_state'  => $demand_state,
            ];
            //将数据插入到表中
            $i_insert_result = $this->user_order_model->insert_custom($a_data);
            if ($i_insert_result) {
                echo json_encode(array('code'=>200, 'msg'=>'已提交申请，请耐心等待客服处理', 'data'=>''));
            }
        } else {
            //接收需要申请客服介入的需求id
            $demand_id = $this->router->get(1);
            //获取订单的详情
            $a_demand_detail = $this->user_order_model->get_demand_detail($demand_id);
            //获取退款详情
            $a_data = $this->user_order_model->get_refund_detail($a_demand_detail);
            //将当前订单状态传递过去
            $a_data['present_state'] = $a_demand_detail['state'];
            $this->view->display('refund_custom_service', $a_data);
        }
    }

/*****************************************************************************************/

    //会员中心->需求订单->申请保修
    public function for_guarantee() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //接收数据
            $demand_id     = $this->general->post('demand_id');
            $server_id     = $this->general->post('server_id');
            $guarantee_why = $this->general->post('guarantee_why');
            $linkman       = $this->general->post('linkman');
            $link_tel      = $this->general->post('link_tel');
            $demand_state  = $this->general->post('demand_state');
            //验证数据合法性
            if (strlen($guarantee_why)<4 || strlen($refund_why)>220) {
                echo json_encode(array('code'=>31, 'msg'=>'描述问题长度不合法'));
                die;
            }
            if (strlen($linkman)<2 || strlen($linkman)>20) {
                echo json_encode(array('code'=>32, 'msg'=>'联系人长度不合法'));
                die;
            }
            if (strlen($link_tel)<3 || strlen($link_tel)>20) {
                echo json_encode(array('code'=>33, 'msg'=>'联系方式长度不合法'));
                die;
            }
            //调用文件上传方法上传视频和图片
            $file = $_FILES['guarantee_video'];
            //允许上传的类型
            $allow = array('image/jpeg','image/jpg','image/png',);
            //确定上传的目录
            $path = './images';
            //确定文件上传的大小 1M
            $maxsize = 1048576;
            //上传视频凭证
            $guarantee_video = $this->upload_img($file, $allow, $error, $path, $maxsize);
            //上传图片凭证
            $file = $_FILES['guarantee_img'];
            for ($i=0; $i < count($_FILES['guarantee_img']['name']); $i++) {
                $files[$i]['name']     =    $file['name'][$i];
                $files[$i]['type']     =    $file['type'][$i];
                $files[$i]['tmp_name'] =    $file['tmp_name'][$i];
                $files[$i]['error']    =    $file['error'][$i];
                $files[$i]['size']     =    $file['size'][$i];
            }
            for ($i=0; $i<count($files); $i++) {
                if ($files[$i]['error'] == 0) {
                    $file = $files[$i];
                    $names[] = $this->upload_img($file, $allow, $error, $path, $maxsize);
                }
            }
            $img_path = implode('&', $names);
            if ($img_path == '&&&') {
                $img_path = '';
            }

            $a_data = [
                'demand_id'         =>  $demand_id,
                'demand_uid'        =>  $_SESSION['user_id'],
                'sever_uid'         =>  $server_id,
                'demand_state'      =>  $demand_state,
                'guarantee_why'     =>  $guarantee_why,
                'linkman'           =>  $linkman,
                'link_tel'          =>  $link_tel,
                'guarantee_video'   =>  $guarantee_video,
                'guarantee_img'     =>  $img_path,
                'guarantee_time'    =>  $_SERVER['REQUEST_TIME'],
                'guarantee_number'  =>  date('Ymdhis', time()) . rand(111,999),
                'guarantee_type'    =>  1,
                'guarantee_tip'     =>  '需求者发起报修申请'
            ];
            //调用模型方法实现插入数据
            $i_result = $this->user_order_model->insert_guarantee($a_data);
            if ($i_result) {
                echo json_encode(array('code'=>200, 'msg'=>'申请成功，系统将尽快处理'));
            } else {
                echo json_encode(array('code'=>400, 'msg'=>'申请失败，发生未知错误'));
            }
        } else {
            //接收需要保修的需求id
            $id = $this->router->get(1);
            //查询需求的详情返回给页面
            $a_data = $this->user_order_model->get_demand_detail($id);
            //判断是否保修期内
            if (($a_data['finish_time']+$a_data['guarantee_long']) < $_SERVER['REQUEST_TIME']) {
                //保修期已过
                $this->error->show_remind('已过保修期', 'demand_all', false, 2);
            }
            $this->view->display('for_guarantee', $a_data);
            //echo json_encode($a_data);
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->保修订单->保修详情
    public function guarantee_detail() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //接收需要的订单id
            $id = $this->router->get(1);
            //订单详情
            $a_demand_detail = $this->user_order_model->get_demand_detail($id);
            //服务者信息
            $a_data_server = $this->user_order_model->get_guarantee_server($a_demand_detail);
            //保修详情
            $a_data_guarantee = $this->user_order_model->get_guarantee_detail($a_demand_detail);
            $a_data = [
                'demand'    => $a_demand_detail,
                'server'    => $a_data_server,
                'guarantee' => $a_data_guarantee,
            ];
            echo "<pre>";
            var_dump($a_data);die;
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->保修进度
    public function guarantee_schedule() {
         if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //接收需要查询的订单id
            $id = $this->router->get(1);
            $a_data = $this->user_order_model->get_guarantee_schedule($id);
            echo "<pre>";
            var_dump($a_data);die;
         }
    }

/**********************************************************************************/

    //会员中心->需求订单->保修->撤消报修申请
    //撤消报修申请将会使订单回到之前的状态 之后将不能再报修
    public function guarantee_cancel() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //接收需要撤消的需求id
            $id = $this->router->get(1);
            $a_demand_detail = $this->user_order_model->get_demand_detail($id);
            //将订单状态还原
            $i_update_result = $this->user_order_model->update_guarantee_cancel($a_demand_detail);
            $this->error->show_success('撤消成功', 'demand_all', false, 2);
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->保修->不认可服务[申请客服介入]
    public function guarantee_custom_service() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //接收数据
            $demand_id     = $this->general->post('demand_id');
            $guarantee_id  = $this->general->post('guarantee_id');
            $custom_why    = trim($this->general->post('custom_why'));
            $proposer_tel  = trim($this->general->post('proposer_tel'));
            $custom_detail = trim($this->general->post('custom_detail'));
            //当前订单状态
            $present_state = $this->general->post('present_state');
            //对数据进行验证
            if (strlen($custom_why)==0 || strlen($proposer_tel)==0 || strlen($custom_detail)==0) {
                $this->error->show_remind('数据不能为空', 'demand_all', false, 2);
                die;
            }
            //调用文件上传方法上传视频和图片
            $file = $_FILES['custom_video'];
            //允许上传的类型
            $allow = array('image/jpeg','image/jpg','image/png',);
            //确定上传的目录
            $path = './images';
            //确定文件上传的大小 1M
            $maxsize = 1048576;
            //上传视频凭证
            $custom_video = $this->upload_img($file, $allow, $error, $path, $maxsize);

            //上传图片凭证
            $file = $_FILES['custom_img'];
            for ($i=0; $i < count($_FILES['custom_img']['name']); $i++) {
                $files[$i]['name']     =    $file['name'][$i];
                $files[$i]['type']     =    $file['type'][$i];
                $files[$i]['tmp_name'] =    $file['tmp_name'][$i];
                $files[$i]['error']    =    $file['error'][$i];
                $files[$i]['size']     =    $file['size'][$i];
            }
            for ($i=0; $i<count($files); $i++) {
                if ($files[$i]['error'] == 0) {
                    $file    = $files[$i];
                    $names[] = $this->upload_img($file, $allow, $error, $path, $maxsize);
                }
            }
            $img_path = implode('&', $names);
            if ($img_path == '&&&') {
                $img_path = '';
            }

            $a_data = [
                'demand_id'     => $demand_id,
                'detail_id'     => $guarantee_id,
                'proposer_id'   => $_SESSION['user_id'],
                'proposer_tel'  => $proposer_tel,
                'custom_why'    => $custom_why,
                'custom_detail' => $custom_detail,
                'custom_video'  => $custom_video,
                'custom_img'    => $img_path,
                'custom_time'   => $_SERVER['REQUEST_TIME'],
                'custom_type'   => 2, //2代表保修过程中提交的客服介入
                'demand_state'  => $present_state,
            ];

            //将数据插入到表中
            $i_insert_result = $this->user_order_model->insert_custom_guarantee($a_data);
            echo $i_insert_result;die;
        } else {
            //接收需要申请客服介入的需求id
            $id = $this->router->get(1);
            //获取订单的详情
            $a_demand_detail = $this->user_order_model->get_demand_detail($id);
            //获取保修详情
            $a_data = $this->user_order_model->get_guarantee_detail($a_demand_detail);
            //将当前订单状态传递过去
            $a_data['present_state'] = $a_demand_detail['state'];
            $this->view->display('guarantee_custom_service', $a_data);
        }
    }

/**********************************************************************************/

    //需求订单->保修->撤消客服介入申请 撤消客服介入订单将回到介入前的状态
    public function custom_cancel() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //接收需要撤消客服介入的需求id
            $id = $this->router->get(1);
            $a_demand_detail = $this->user_order_model->get_demand_detail($id);
            $i_update_result = $this->user_order_model->update_custom_cancel($a_demand_detail);
            $this->error->show_success('撤回成功', 'demand_all', false, 2);
        }
    }

/**********************************************************************************/

    //需求订单->保修->修改客服介入申请
    public function custom_change() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //接收数据
            $custom_why    = trim($this->general->post('custom_why'));
            $proposer_tel  = trim($this->general->post('proposer_tel'));
            $custom_detail = trim($this->general->post('custom_detail'));
            $custom_id     = $this->general->post('custom_id');
            $custom_video  = $this->general->post('custom_video');
            //对数据进行验证
            if (strlen($custom_why)==0 || strlen($proposer_tel)==0 || strlen($custom_detail)==0) {
                $this->error->show_remind('数据不能为空', 'demand_all', false, 2);
                die;
            }
            //调用文件上传方法上传视频和图片
            $file = $_FILES['custom_video'];
            //允许上传的类型
            $allow = array('image/jpeg','image/jpg','image/png',);
            //确定上传的目录
            $path = './images';
            //确定文件上传的大小 1M
            $maxsize = 1048576;
            //上传视频凭证
            if ($_FILES['custom_video']['error'] == 0) {
                $custom_video = $this->upload_img($file, $allow, $error, $path, $maxsize);
            }

            //上传图片凭证
            if ($_FILES['custom_img']['name'][0] != '') {
                $file = $_FILES['custom_img'];
                for ($i=0; $i < count($_FILES['custom_img']['name']); $i++) {
                    $files[$i]['name']     = $file['name'][$i];
                    $files[$i]['type']     = $file['type'][$i];
                    $files[$i]['tmp_name'] = $file['tmp_name'][$i];
                    $files[$i]['error']    = $file['error'][$i];
                    $files[$i]['size']     = $file['size'][$i];
                }
                for ($i=0; $i<count($files); $i++) {
                    if ($files[$i]['error'] == 0) {
                        $file    = $files[$i];
                        $names[] = $this->upload_img($file, $allow, $error, $path, $maxsize);
                    }
                }
                $img_path = implode('&', $names);
            } else {
                //到原数据中获取原图片地址
                $img_path = $this->user_order_model->get_custom_imgpath($custom_id);
            }

            $a_where = [
                'custom_id' => $custom_id
            ];
            $a_data = [
                'custom_why'    => $custom_why,
                'custom_detail' => $custom_detail,
                'custom_video'  => $custom_video,
                'custom_img'    => $img_path,
            ];
            //修改客服介入表的记录信息
            $i_result = $this->user_order_model->update_custom_change($a_where,$a_data);
            if ($i_result) {
                echo json_encode(array('code'=>200, 'msg'=>'修改成功', 'data'=>''));
            }
        } else {
            //接收需要修改的需求id
            $id = $this->router->get(1);
            //查询客服介入表的数据返回给页面
            $a_data = $this->user_order_model->get_custom_detail($id);
            $this->view->display('custom_change', $a_data);
        }
    }

/**********************************************************************************/

    //需求订单->保修->修改保修申请信息
    public function guarantee_change() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //接收数据
            $server_id        = $this->general->post('server_id');
            $demand_id        = $this->general->post('demand_id');
            $demand_state     = $this->general->post('demand_state');
            $guarantee_number = $this->general->post('guarantee_number');
            $guarantee_why    = $this->general->post('guarantee_why');
            $linkman          = $this->general->post('linkman');
            $link_tel         = $this->general->post('link_tel');
            $guarantee_video  = $this->general->post('guarantee_video');

            //验证数据合法性
            if (strlen($guarantee_why)<4 || strlen($refund_why)>250) {
                echo json_encode(array('code'=>31, 'msg'=>'描述问题长度不合法'));
                die;
            }
            if (strlen($linkman)<2 || strlen($linkman)>20) {
                echo json_encode(array('code'=>32, 'msg'=>'联系人长度不合法'));
                die;
            }
            if (strlen($link_tel)<3 || strlen($link_tel)>20) {
                echo json_encode(array('code'=>33, 'msg'=>'联系方式长度不合法'));
                die;
            }
            //允许上传的类型
            $allow = array('image/jpeg','image/jpg','image/png',);
            //确定上传的目录
            $path = './images';
            //确定文件上传的大小 1M
            $maxsize = 1048576;

            if ($_FILES['guarantee_video']['error'] == 0) {
                //上传视频凭证
                $file = $_FILES['guarantee_video'];
                $guarantee_video = $this->upload_img($file, $allow, $error, $path, $maxsize);
            }

            //上传图片凭证
            if ($_FILES['guarantee_img']['name'][0] != '') {
                $file = $_FILES['guarantee_img'];
                for ($i=0; $i < count($_FILES['guarantee_img']['name']); $i++) {
                    $files[$i]['name']     =    $file['name'][$i];
                    $files[$i]['type']     =    $file['type'][$i];
                    $files[$i]['tmp_name'] =    $file['tmp_name'][$i];
                    $files[$i]['error']    =    $file['error'][$i];
                    $files[$i]['size']     =    $file['size'][$i];
                }
                for ($i=0; $i<count($files); $i++) {
                    if ($files[$i]['error'] == 0) {
                        $file    = $files[$i];
                        $names[] = $this->upload_img($file, $allow, $error, $path, $maxsize);
                    }
                }
                $img_path = implode('&', $names);
            } else {
                //到数据库获取其原来的图片地址
                $guarantee_id = $this->general->post('guarantee_id');
                $img_path = $this->user_order_model->get_old_imgpath($guarantee_id);
            }

            $a_data = [
                'demand_id'         => $demand_id,
                'demand_uid'        => $_SESSION['user_id'],
                'sever_uid'         => $server_id,
                'demand_state'      => $demand_state,
                'guarantee_why'     => $guarantee_why,
                'linkman'           => $linkman,
                'link_tel'          => $link_tel,
                'guarantee_video'   => $guarantee_video,
                'guarantee_img'     => $img_path,
                'guarantee_time'    => $_SERVER['REQUEST_TIME'],
                'guarantee_number'  => $guarantee_number,
                'guarantee_type'    => 3, //3代表用户修改后的信息
                'guarantee_tip'     => '需求者修改了报修申请'
            ];
            //调用模型方法实现插入数据
            $i_result = $this->user_order_model->update_guarantee_change($a_data);
            if ($i_result) {
                echo json_encode(array('code'=>200, 'msg'=>'修改申请成功，系统将尽快处理'));
            } else {
                echo json_encode(array('code'=>400, 'msg'=>'修改申请失败，发生未知错误'));
            }
        } else {
            //接收需要修改的订单id
            $id = $this->router->get(1);
            //获取保修信息的详情并返回给页面
            $a_data = $this->user_order_model->get_guarantee_change($id);
            $this->view->display('guarantee_change', $a_data);
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->保修->保修记录
    public function guarantee_record() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //接收需要查看的订单id
            $id = $this->router->get(1);
            //到保修表中取出相关信息
            $a_data_guarantee = $this->user_order_model->get_guarantee_record($id);
            echo "<pre>";
            var_dump($a_data_guarantee);die;
        }
    }

/**********************************************************************************/

    //会员中心->需求订单->保修->协商历史
    public function guarantee_history() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //接收订单id
            $id = $this->router->get(1);
            //获取保修表中的信息
            $a_data_guarantee = $this->user_order_model->get_guarantee_history($id);
            //获取客服介入表中的信息
            $a_data_custom = $this->user_order_model->get_custom_history($id);
            $a_data = [
                'guarantee' => $a_data_guarantee,
                'custom'    => $a_data_custom,
            ];
            echo "<pre>";
            var_dump($a_data);die;
        }
    }

/**********************************************************************************/

    /**
     * [upload_img 上传文件函数]
     * @param  [array]  $file           [上传文件的信息]
     * @param  [array]  $allow          [允许的文件上传类型]
     * @param  [string] &$error         [引用传递，用来记录错误信息]
     * @param  [string] $path           [文件上传目录]
     * @param  [int]    $maxsize        [1024*1024 允许文件上传的最大大小]
     * @return [string] $target|false   [成功则返回新文件路径 失败返回false]
     */
    public function upload_img($file, $allow, &$error, $path, $maxsize) {

        switch ($file['error']) {
            case 1 : $error = '超出了上传限制大小';
                return false;
            case 2 : $error = '超出了浏览器表单允许的大小';
                return false;
            case 3 : $error = '文件上传不完整';
                return false;
            case 4 : $error = '请先选择需要上传的文件';
                return false;
            case 7 : $error = '服务器繁忙，稍后再试';
                return false;
        }

        //判断文件大小
        if ($file['size'] > $maxsize) {
            //超出了规定大小
            $error = '上传错误，超出了上传限制大小';
            return false;
        }

        //判断文件类型
        if (!in_array($file['type'],$allow)) {
            $error = '上传的文件类型不正确';
            return false;
        }

        //拼接新的文件名
        $newname = date('Ymdhis',time()) . '_' . rand(111,999) .strrchr($file['name'], '.');
        $target = $path . '/' . $newname;

        //移动临时文件
        $result = move_uploaded_file($file['tmp_name'] , $target);
        if ($result) {
            //移动成功则返回新的文件名
            return $target;
        } else {
            $error = "发生未知错误，上传失败！";
            return false;
        }

    }

/**********************************************************************************/

}

?>