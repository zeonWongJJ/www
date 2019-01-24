<?php

class User_footprint_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('User_footprint_model');
        $this->load->model('is_login_model');
        $this->is_login_model->is_login();
	}

/**********************************************************************************/

    // 会员中心->足迹->全部足迹
    public function get_all_footprint() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //调用模型方法获取数据
            $a_data = $this->User_footprint_model->get_all_myfootprint();
            if ($a_data) {
                echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$a_data));
                die;
            }else{
                echo json_encode(array('code'=>400, 'msg'=>'没有任何足迹', 'data'=>''));
                die;
            }
        }
    }

/**********************************************************************************/

    // 会员中心->足迹->需求足迹
    public function get_demand_footprint() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //调用模型方法获取数据
            $a_data = $this->User_footprint_model->get_demand_myfootprint();
            if (!empty($a_data)){
                echo json_encode(array('code'=>200, 'msg'=>'获取足迹成功', 'data'=>$a_data));
                die;
            } else {
                echo json_encode(array('code'=>400, 'msg'=>'没有足迹', 'data'=>''));
                die;
            }
        }
    }

/**********************************************************************************/

    // 会员中心->足迹->浏览服务者的足迹
    public function get_server_footprint() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //调用模型方法获取数据
            $a_data = $this->User_footprint_model->get_server_myfootprint();
            if (!empty($a_data)){
                echo json_encode(array('code'=>200, 'msg'=>'获取足迹成功', 'data'=>$a_data));
                die;
            } else {
                echo json_encode(array('code'=>400, 'msg'=>'没有足迹', 'data'=>''));
                die;
            }
        }
    }

/**********************************************************************************/

    //会员中心->我的足迹->删除足迹
    public function delete_footprint() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //接收需要删除的参数
            $a_data = $this->general->post('id');
            $i_result = $this->User_footprint_model->del_myfootprint($a_data);
            if ($i_result) {
                echo json_encode(array('code'=>200, 'msg'=>'删除足迹成功'));
            } else {
                echo json_encode(array('code'=>400, 'msg'=>'删除足迹失败'));
            }
        } else {
            $this->view->display('delete_footprint');
        }
    }

/**********************************************************************************/

    //会员中心->我的足迹->添加足迹
    public function add_footprint() {
        //接收需要添加的需求id或者服务者id
        $browse_id = $this->router->get(1);
        //接收需要添加足迹的类型
        $footprint_type = $this->router->get(2);
        $a_data = [
            'member_id'     => $_SESSION['user_id'],
            'browse_id'     => $browse_id,
            'type'          => $footprint_type,
            'browse_time'   => $_SERVER['REQUEST_TIME'],
        ];
        $i_result = $this->User_footprint_model->insert_footprint($a_data);
        echo $i_result;
    }

/**********************************************************************************/

}

?>