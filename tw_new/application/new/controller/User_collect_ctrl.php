<?php

class User_collect_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('user_collect_model');
        $this->load->model('is_login_model');
        $this->is_login_model->is_login();
	}

    //会员中心->我的收藏
    public function get_mycollect() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //我收藏的需求
            $a_data['demand'] = $this->user_collect_model->get_demand_mycollect();
            //我收藏的服务者
            $a_data['server'] = $this->user_collect_model->get_server_mycollect();
            $this->view->display('myCollect', $a_data);
        }
    }

/**********************************************************************************/

   //会员中心->我的收藏->全部收藏
    public function get_all_collect() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //调用模型方法获取数据
            $a_data = $this->user_collect_model->get_all_mycollect();
            if ($a_data) {
                echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$a_data));
                die;
            } else {
                echo json_encode(array('code'=>400, 'msg'=>'没有任何收藏'));
                die;
            }
        }
    }

/**********************************************************************************/

    //会员中心->我的收藏->收藏的服务者
    public function get_server_collect() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //调用模型方法获取数据
            $a_data = $this->user_collect_model->get_server_mycollect();
            if($a_data){
                echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$a_data));
                die;
            }else{
                echo json_encode(array('code'=>400, 'msg'=>'没有任何收藏', 'data'=>''));
                die;
            }
        }
    }

/**********************************************************************************/

    //会员中心->我的收藏->收藏的需求
    public function get_demand_collect() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //调用模型方法获取数据
            $a_data = $this->user_collect_model->get_demand_mycollect();
            $this->view->display('myCollect', $a_data);
        }
    }

/**********************************************************************************/

    //会员中心->我的收藏->删除收藏
    public function delete_collect() {
        //接收需要删除的id
        $ids = $this->general->post('ids');
        //将字符串转成数组
        $a_data = explode('-', $ids);
        //将对应的收藏删除
        $i_result = $this->user_collect_model->del_mycollect($a_data);
        if ($i_result) {
            echo json_encode(array('code'=>200));
        } else {
            echo json_encode(array('code'=>400));
        }
    }

/**********************************************************************************/

    //会员中心->我的收藏->添加收藏
    public function add_collect() {
        //接收需要收藏的需求id或者服务者id
        $collect_id = $this->router->get(1);
        //接收收藏类型
        $collect_type = $this->router->get(2);
        //判断是否已经存在此条收藏
        $is_exist = $this->user_collect_model->get_is_exist($collect_id,$collect_type);
        if ($is_exist) {
            echo json_encode(array('code'=>300, 'msg'=>'已经收藏过此条信息'));
            die;
        }
        $a_data = [
            'member_id'     => $_SESSION['user_id'],
            'collect_id'    => $collect_id,
            'collect_time'  => $_SERVER['REQUEST_TIME'],
            'type'          => $collect_type,
        ];
        $i_result = $this->user_collect_model->insert_collect($a_data);
        if ($i_result) {
            echo json_encode(array('code'=>200, 'msg'=>'收藏成功'));
            die;
        } else {
            echo json_encode(array('code'=>400, 'msg'=>'收藏失败'));
            die;
        }
    }

/**********************************************************************************/


}

?>