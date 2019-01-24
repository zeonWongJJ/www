<?php

class Server_order_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('server_order_model');
        $this->load->model('is_login_model');
        $this->is_login_model->is_login();
	}

/********************************************************************************/

	//卖家中心之保修中的订单[全部订单]
	public function server_guarantee() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data[] = $this->server_order_model->get_server_guarantee();
			echo "<pre>";
			var_dump($a_data);die;
		}
	}

/********************************************************************************/

	//保修订单详情
	public function server_guarantee_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要查看详情的订单id
			$id = $this->router->get(1);
			//获取订单详情
			$a_data = $this->server_order_model->get_demand_detail($id);
			echo "<pre>";
			var_dump($a_data);die;
		}
	}

/********************************************************************************/

	//查看保修进度
	public function server_guarantee_schedule() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要查看进度的订单id
			$id = $this->router->get(1);
			$a_data['demand'] = $this->server_order_model->get_demand_detail($id);
			//进度信息
			$a_data['schedule'] = $this->server_order_model->get_demand_schedule($id);
			echo "<pre>";
			var_dump($a_data);die;
		}
	}

/********************************************************************************/

	//申请中的订单->确认保修
	public function server_guarantee_confirm() {
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			//接收上门时间
			$visit_time = trim($this->general->post('visit_time'));
			$demand_id = $this->general->post('demand_id');
			//更改订单状态
			$a_where = [
				'demand_id' => $demand_id,
			];
			$a_data = [
				'state'	=> 202 //服务者同意保修等待服务者联系
			];
			$i_result_update = $this->server_order_model->update_demand_state($a_where, $a_data);
			if ($i_result) {
				$this->error->show_success('确认成功', 'server_guarantee', false, 2);
			} else {
				$this->error->show_error('确认失败', 'server_guarantee', false, 2);
			}
		} else {
			//接收确认保修的订单id
			$id = $this->router->get(1);
			$a_data = $this->server_order_model->get_demand_detail($id);
			echo "<pre>";
			var_dump($a_data);die;
		}
	}

/********************************************************************************/

	//服务者确认保修完成
	public function server_guarantee_complete() {
		if ($_SERVER['REQUEST_METHOD']=='GET') {
			//接收需要确认保修完成的订单
			$id = $this->router->get(1);
			//获取订单详情
			$a_data_detail = $this->server_order_model->get_demand_detail($id);
			//更新订单状态
			$a_where = [
				'demand_id' => $id,
			];
			$a_data = [
				'state' => 206,
				'guarantee_count' => $a_data_detail['guarantee_count']+1,
			];
			//更新数据表
			$i_result = $this->server_order_model->update_guarantee_complete($a_where, $a_where, $a_data_detail);
			if ($i_result) {
				$this->error->show_success('已确认完成', 'server_guarantee', false, 2);
			} else {
				$this->error->show_error('确认完成失败', 'server_guarantee', false, 2);
			}
		}
	}

/********************************************************************************/

	//服务者申辩
	public function server_guarantee_averment() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收数据
			$demand_id       = $this->general->post('demand_id');
			$demand_state    = $this->general->post('demand_state');
			$averment_detail = trim($this->general->post('averment_detail'));
			//验证数据合法性
			if (strlen($averment_detail) < 6 || strlen($averment_detail) > 600) {
				echo json_encode(array('code'=>400, 'msg'=>'申辩内容长度不合法'));
			}
			//允许上传的类型
            $allow = array('image/jpeg','image/jpg','image/png',);
            //确定上传的目录
            $path = './images';
            //确定文件上传的大小 1M
            $maxsize = 1048576;
            if ($_FILES['averment_video']['error'] == 0) {
                //上传视频凭证
                $file = $_FILES['averment_video'];
                $averment_video = $this->upload_img($file, $allow, $error, $path, $maxsize);
            }
            //上传图片凭证
            $file = $_FILES['averment_img'];
            for ($i=0; $i < count($_FILES['averment_img']['name']); $i++) {
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
            //获取相关数据
            $a_data_guarantee = $this->server_order_model->get_data_guarantee($demand_id);
            //将数据写入到数据库
            $a_data = [
				'demand_id'        => $a_data_guarantee['demand_id'],
				'demand_uid'       => $a_data_guarantee['demand_uid'],
				'sever_uid'        => $a_data_guarantee['sever_uid'],
				'demand_state'     => $a_data_guarantee['demand_state'],
				'guarantee_why'    => $averment_detail,
				'linkman'          => $a_data_guarantee['linkman'],
				'link_tel'         => $a_data_guarantee['link_tel'],
				'guarantee_video'  => $averment_video,
				'guarantee_img'    => $img_path,
				'guarantee_number' => $a_data_guarantee['guarantee_number'],
				'guarantee_time'   => $_SERVER['REQUEST_TIME'],
				'guarantee_type'   => 2,
				'guarantee_tip'    => '服务者发起了申辩',
            ];
            $i_result = $this->server_order_model->insert_guarantee_averment($a_data, $demand_state);
            if ($i_result) {
            	$this->error->show_success('申辩提交成功', 'server_guarantee', false, 2);
            } else {
            	$this->error->show_error('申辩提交失败', 'server_guarantee', false, 2);
            }
		} else {
			//接收需要申辩的订单id
			$id = $this->router->get(1);
			//订单详情
			$a_data = $this->server_order_model->get_demand_detail($id);
			//判断是否已申请过
			$i_result = $this->server_order_model->guarantee_averment_exist($id);
			if ($i_result > 0) {
				$this->view->display('tem_name');
			} else {
				$this->view->display('guarantee_averment', $a_data);
			}
		}
	}

/********************************************************************************/

	//退款订单
	public function server_refund() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->server_order_model->get_server_refund();
			echo "<pre>";
			var_dump($a_data);die;
		}
	}

/********************************************************************************/

	//退款订单详情
	public function server_refund_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收订单id
			$id = $this->router->get(1);
			//订单详情
			$a_data['demand'] = $this->server_order_model->get_demand_detail($id);
			//退款详情
			$a_data['refund'] = $this->server_order_model->get_refund_detail($id);
			echo "<pre>";
			var_dump($a_data);die;
		}
	}

/********************************************************************************/

	//服务者中心->退款订单->确认退款
	public function server_refund_confirm() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要退款的订单id
			$id = $this->router->get(1);
			$demand_state = $this->router->get(2);
			//更新订单状态
			$a_where = [
				'demand_id' => $id,
			];
			$a_data = [
				'state' => 302,
			];
			$i_result = $this->server_order_model->update_refund_confirm($a_where, $a_data, $demand_state);
			if ($i_result) {
				$this->error->show_success('确认退款成功', 'server_refund', false, 2);
			} else {
				$this->error->show_error('确认退款失败', 'server_refund', false, 2);
			}
		}
	}

/********************************************************************************/

	//服务者中心->退款订单->拒绝退款
	public function server_refund_refuse() {
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			$demand_id = $this->general->post('demand_id');
			$demand_state = $this->general->post('demand_state');
			$refuse_why = trim($this->general->post('refuse_why'));
			$refuse_detail = trim($this->general->post('refuse_detail'));
			//验证数据合法性
			if (strlen($refuse_detail)<10 || strlen($refuse_detail)>600) {
				echo json_encode(array('code'=>400, 'msg'=>'拒绝说明长度不合法'));
			}
			//允许上传的类型
            $allow = array('image/jpeg','image/jpg','image/png',);
            //确定上传的目录
            $path = './images';
            //确定文件上传的大小 1M
            $maxsize = 1048576;
            if ($_FILES['refuse_video']['error'] == 0) {
                //上传视频凭证
                $file = $_FILES['refuse_video'];
                $refuse_video = $this->upload_img($file, $allow, $error, $path, $maxsize);
            }
            //上传图片凭证
            $file = $_FILES['refuse_img'];
            for ($i=0; $i < count($_FILES['refuse_img']['name']); $i++) {
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
            //先获取相关数据
            $a_data_refund = $this->server_order_model->get_refund_detail($demand_id);
            //将数据插入到数据库
            $a_data = [
				'demand_id'     => $demand_id,
				'demand_uid'    => $a_data_refund['demand_uid'],
				'demand_state'  => $a_data_refund['demand_state'],
				'server_uid'    => $a_data_refund['server_uid'],
				'service_state' => $a_data_refund['service_state'],
				'refund_why'    => $refuse_why,
				'refund_money'  => $a_data_refund['refund_money'],
				'refund_detail' => $refuse_detail,
				'refund_video'  => $refuse_video,
				'refund_img'    => $img_path,
				'refund_number' => $a_data_refund['refund_number'],
				'refund_time'   => $_SERVER['REQUEST_TIME'],
				'refund_type'   => 2,
				'refund_tip'    => '服务者拒绝退款',
            ];
            $i_result = $this->server_order_model->insert_refund_refuse($a_data, $demand_state);
            if ($i_result) {
            	echo json_encode(array('code'=>200, 'msg'=>'拒绝退款申请成功'));
            } else {
            	echo json_encode(array('code'=>200, 'msg'=>'拒绝退款申请失败'));
            }
		} else {
			//接收需要拒绝退款的订单id
			$id = $this->router->get(1);
			//获取订单的详情
			$a_data = $this->server_order_model->get_demand_detail($id);
			$this->view->display('refund_refuse', $a_data);
		}
	}

/********************************************************************************/

	//正在竞标中的订单
	public function server_order_inbid() {
		if ($_SERVER['REQUEST_METHOD']=='GET') {
			$a_data = $this->server_order_model->get_server_inbid();
			echo "<pre>";
			var_dump($a_data);die;
		}
	}

/********************************************************************************/

	//正在竞标中的订单之查看详情
	public function server_inbid_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要查看详情的订单id
			$id = $this->router->get(1);
			//订单详情[包含高级选项]
			$a_data = $this->server_order_model->get_inbid_detail($id);
			echo "<pre>";
			var_dump($a_data);die;
		}
	}
/********************************************************************************/

	//服务者中心->服务中的订单
	public function server_inservice() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->server_order_model->get_server_inservice();
			echo "<pre>";
			var_dump($a_data);die;
		}
	}

/********************************************************************************/

	//服务者中心->服务中的订单->查看详情
	public function server_inservice_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//获取订单id
			$id = $this->router->get(1);
			$a_data = $this->server_order_model->get_demand_detail($id);
			echo "<pre>";
			var_dump($a_data);die;
		}
	}

/********************************************************************************/

	//服务者中心->服务中的订单->确认服务完成
	public function server_inservice_confirm() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要的订单id
			$id = $this->router->get(1);
			$demand_state = $this->router->get(2);
			//更新订单状态
			$a_where = [
				'demand_id'          => $id,
				'selected_member_id' => $_SESSION['user_id'],
			];
			$a_data = [
				'state' => 106,
			];
			$i_result = $this->server_order_model->update_inservice_confirm($a_where, $a_data, $demand_state);
			if ($i_result) {
				$this->error->show_success('确认成功', 'server_inservice', false, 2);
			} else {
				$this->error->show_error('确认失败', 'server_inservice', false, 2);
			}
		}
	}

/********************************************************************************/

	//服务者中心->服务中的订单->追加服务费用
	public function server_inservice_append() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$bid = $this->general->post('bid_id');
			$a_shuju['demand_id'] = $this->general->post('demand_id');
			$a_shuju['demand_state'] = $this->general->post('demand_state');
			$append_why = trim($this->general->post('append_why'));
			$append_money = trim($this->general->post('append_money'));
			//验证数据合法性
			if (strlen($append_why) < 2 || strlen($append_why) > 900 || $append_money <= 0) {
				$this->error->show_error('提交数据不合法', 'server_inservice', false, 2);
			}
			//将数据保存到数据库
			$a_where = [
				'bid' => $bid,
			];
			$a_data = [
				'append_why'   => $append_why,
				'append_money' => $append_money,
			];
			$i_result = $this->server_order_model->update_append_money($a_where, $a_data, $a_shuju);
			if ($i_result) {
				$this->error->show_success('提交追加费用申请成功', 'server_inservice', false, 2);
			} else {
				$this->error->show_error('提交追加费用申请失败', 'server_inservice', false, 2);
			}
		} else {
			//接收需要增加服务费用的订单id
			$id = $this->router->get(1);
			$a_data = $this->server_order_model->get_demand_detail($id);
			$this->view->display('inservice_append', $a_data);
		}
	}

/********************************************************************************/

	//服务者中心->待确认的订单
	public function server_wait_confirm() {
		if ($_SERVER['REQUEST_METHOD']=='GET') {
			$a_data = $this->server_order_model->get_wait_confirm();
			echo "<pre>";
			var_dump($a_data);die;
		}
	}

/********************************************************************************/

	//服务者中心->待确认的订单->查看详情
	public function server_wait_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要查看详情的订单id
			$id = $this->router->get(1);
			$a_data = $this->server_order_model->get_wait_detail($id);
			echo "<pre>";
			var_dump($a_data);die;
		}
	}

/********************************************************************************/

	//服务者中心->待确定的订单->确定接单
	public function server_order_taking() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收要接单的订单id
			$id = $this->router->get(1);
			$demand_state = $this->router->get(2);
			//更改订单状态
			$a_where = [
				'demand_id'          => $id,
				'selected_member_id' => $_SESSION['user_id'],
			];
			$a_data = [
				'state' => 104,
			];
			$i_result = $this->server_order_model->update_order_taking($a_where, $a_data, $demand_state);
			if ($i_result) {
				$this->error->show_success('接单成功', 'server_wait_confirm', false, 2);
			} else {
				$this->error->show_error('接单失败', 'server_wait_confirm', false, 2);
			}
		}
	}

/********************************************************************************/

	//服务者中心->待确定的订单->放弃接单
	public function server_cancel_order() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要的id
			$id = $this->router->get(1);
			$demand_state = $this->router->get(2);
			//更新订单数据 清空选中的竞标id等 将订单状态改为
			$a_where = [
				'demand_id'          => $id,
				'selected_member_id' => $_SESSION['user_id'],
			];
			$a_data = [
				'state'              => 101,
				'guarantee_long'     => null,
				'selected_bid'       => null,
				'selected_member_id' => null,
			];
			$i_result = $this->server_order_model->update_cancel_order($a_where, $a_data, $demand_state);
			if ($i_result) {
				$this->error->show_success('取消订单成功', 'server_wait_confirm', false, 2);
			} else {
				$this->error->show_error('取消订单失败', 'server_wait_confirm', false, 2);
			}
		}
	}

/********************************************************************************/

	//服务者中心->已完成的订单
	public function server_complete() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->server_order_model->get_server_complete();
			echo "<pre>";
			var_dump($a_data);die;
		}
	}

/********************************************************************************/

	//服务者中心->已完成的订单->查看详情
	public function server_complete_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要查看详情的订单id
			$id = $this->router->get(1);
			//订单详情
			$a_data = $this->server_order_model->get_demand_detail($id);
			echo "<pre>";
			var_dump($a_data);die;
		}
	}

/********************************************************************************/

	//服务者中心->已完成的订单->保修明细
	public function server_complete_guarantee() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收订单id
			$id = $this->router->get(1);
			$a_data = $this->server_order_model->get_complete_guarantee($id);
			echo "<pre>";
			var_dump($a_data);die;
		}
	}

/********************************************************************************/

	//服务者中心->已完成的订单->删除订单
	public function server_complete_del() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收要删除的订单id
			$id = $this->router->get(1);
			//更新订单
			$a_where = [
				'demand_id' => $id,
			];
			$a_data = [
				'is_del_server' => 0,
			];
			$i_result = $this->server_order_model->update_complete_del($a_where, $a_data);
			if ($i_result) {
				$this->error->show_success('删除成功', 'server_complete', false, 2);
			} else {
				$this->error->show_error('删除失败', 'server_complete', false, 2);
			}
		}
	}

/********************************************************************************/

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

/********************************************************************************/


}

?>