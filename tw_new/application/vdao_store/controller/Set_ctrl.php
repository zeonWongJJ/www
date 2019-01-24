<?php

class Set_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('set_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/***************************************** 门店设置 *****************************************/

	public function store_set() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的数据
			$store_position     = trim($this->general->post('store_position'));
			$store_areanum      = trim($this->general->post('store_areanum'));
			$store_citycode     = trim($this->general->post('store_citycode'));
			$store_output       = trim($this->general->post('store_output'));
			$order_distance     = trim($this->general->post('order_distance'));
			$store_contact      = trim($this->general->post('store_contact'));
			$store_tel          = trim($this->general->post('store_tel'));
			$store_traffic      = trim($this->general->post('store_traffic'));
			$store_introduction = trim($this->general->post('store_introduction'));
			$store_mainimg      = trim($this->general->post('mainpic_path'));
			$store_img          = trim($this->general->post('otherpic_path'));
			$monybox_pwd        = trim($this->general->post('monybox_pwd'));

			//验证数据合法性
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'store_set',
				'log'      => false,
				'wait'     => 2,
			];
			// 判断定位是否为空
			if (empty($store_areanum) || empty($store_position)) {
				$a_parameter['msg'] = '定位不能为空';
				$this->error->show_error($a_parameter);
			}
			// 设置一张主图
			if (!empty($store_img) && empty($store_mainimg)) {
				$img_arr = explode(',', $store_img);
				$store_mainimg = $img_arr[0];
			}
			//组装数据并保存到数据库
			$a_where = [
				'store_id' => $_SESSION['store_id'],
			];
			// 拆分经纬度度
			$position_arr = explode(',', $store_position);
			$a_data = [
				'store_introduction' => $store_introduction,
				'store_position'     => $store_position,
				'store_areanum'      => $store_areanum,
				'store_citycode'     => $store_citycode,
				'store_output'       => $store_output,
				'store_traffic'      => $store_traffic,
				'store_tel'          => $store_tel,
				'store_contact'      => $store_contact,
				'store_mainimg'      => $store_mainimg,
				'store_img'          => $store_img,
				'order_distance'     => $order_distance,
				'store_longitude'    => $position_arr['0'],
				'store_latitude'     => $position_arr['1'],
				'update_time'        => $_SERVER['REQUEST_TIME'],
			];
			// 验证是否要修改钱箱密码
			if (!empty($monybox_pwd)) {
				$a_data['moneybox_pwd'] = md5(md5($monybox_pwd));
			}
			$i_result = $this->set_model->update_store($a_where, $a_data);
			if ($i_result) {
				$a_parameter['msg'] = '修改成功';
				$a_parameter['url'] = 'index';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '修改失败';
				$a_parameter['url'] = 'store_set';
				$this->error->show_error($a_parameter);
			}
		} else {
			//获取门店信息
			$a_data = $this->set_model->get_store_one($_SESSION['store_id']);
			// $store_position = $a_data['store_position'];
			if (empty($a_data['store_longitude']) || empty($a_data['store_latitude'])) {
				$a_data['position_x'] = 9999;
				$a_data['position_y'] = 9999;
			} else {
				// $store_position = explode(',', $store_position);
				$a_data['position_x'] = $a_data['store_longitude'];
				$a_data['position_y'] = $a_data['store_latitude'];
			}
			$this->view->display('store_set2', $a_data);
		}
	}

/*************************************** 提现账号设置 ***************************************/

	public function store_withdraw() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收信息
			$store_remittee = trim($this->general->post('store_remittee'));
			$store_bankcard = trim($this->general->post('store_bankcard'));
			$store_alipay   = trim($this->general->post('store_alipay'));
			$store_password = trim($this->general->post('store_password'));
			$open_bank      = trim($this->general->post('open_bank'));
			$bank_prov      = trim($this->general->post('bank_prov'));
			$bank_city      = trim($this->general->post('bank_city'));
			$sub_bank       = trim($this->general->post('sub_bank'));
			// 验证数据合法性
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'store_set',
				'log'      => false,
				'wait'     => 2,
			];
			// 将数据保存到数据库
			$a_where = [
				'store_id' => $_SESSION['store_id']
			];
			// 如果提现密码为空表示不修改 不为空则重置提现密码
			if (empty($store_password)) {
				$a_data = [
					'store_remittee' => $store_remittee,
					'store_bankcard' => $store_bankcard,
					'store_alipay'   => $store_alipay,
					'open_bank'      => $open_bank,
					'bank_prov'      => $bank_prov,
					'bank_city'      => $bank_city,
					'sub_bank'       => $sub_bank,
					'update_time'    => $_SERVER['REQUEST_TIME'],
				];
			} else {
				$a_data = [
					'store_remittee' => $store_remittee,
					'store_bankcard' => $store_bankcard,
					'store_alipay'   => $store_alipay,
					'open_bank'      => $open_bank,
					'bank_prov'      => $bank_prov,
					'bank_city'      => $bank_city,
					'sub_bank'       => $sub_bank,
					'store_password' => md5(md5($store_password)),
					'update_time'    => $_SERVER['REQUEST_TIME'],
				];
			}
			$i_result = $this->set_model->update_store($a_where, $a_data);
			if ($i_result) {
				$a_parameter['msg'] = '设置成功';
				$a_parameter['url'] = 'index';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '设置失败';
				$this->error->show_error($a_parameter);
			}
		}
	}

/*************************************** 删除门店照片 ***************************************/

    public function storetem_delete() {
        $image_path = trim($this->general->post('image_path'));
        $dtype      = trim($this->general->post('dtype'));
        $record_id  = trim($this->general->post('record_id'));
        $b_result = unlink($image_path);
        if ($b_result) {
            if ($dtype == 2) {
                // 删除数据中记录的图片路径
				$a_store       = $this->set_model->get_store_one($record_id);
				$store_mainimg = $a_store['store_mainimg'];
				$store_img     = $a_store['store_img'];
                $a_update_where = [
                    'store_id' => $record_id
                ];
                if (!empty($store_mainimg)) {
	                if ($store_mainimg == $image_path) {
	                    $a_update_data = [
							'update_time'   => $_SERVER['REQUEST_TIME'],
							'store_mainimg' => '',
	                    ];
	                    $this->set_model->update_store($a_update_where, $a_update_data);
	                }
                }
                // 将其余图片拆分成数组匹配
                if (!empty($store_img)) {
	                $img_arr = explode(',', $store_img);
	                for ($i=0; $i<count($img_arr); $i++) {
	                    if ($img_arr[$i] == $image_path) {
	                        unset($img_arr[$i]);
	                    }
	                }
	                $a_update_data = [
						'update_time' => $_SERVER['REQUEST_TIME'],
						'store_img'   => implode(',', $img_arr),
	                ];
	                $this->set_model->update_store($a_update_where, $a_update_data);
                }
            }
            echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
        } else {
            echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
        }
    }

/*************************************** 上传门店头像 ***************************************/

	public function store_touxiang() {
		$base64_img = trim($this->general->post('img'));
		$up_dir = 'upload/store/tou/';
		if(!file_exists($up_dir)){
		    mkdir($up_dir,0777);
		}
		if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)){
		    $type = $result[2];
		    if(in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png'))){
		        $new_file = $up_dir.date('YmdHis').'.'.$type;
		        if(file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)))){
		            $img_path = str_replace('../../..', '', $new_file);
		            $a_where = [
		            	'store_id' => $_SESSION['store_id'],
		            ];
		            $a_data = [
		            	'store_touxiang' => $img_path,
		            ];
		            $i_result = $this->set_model->update_store($a_where, $a_data);
		            echo json_encode(array('code'=>200, 'msg'=>'上传成功', 'data'=>$img_path));
		            die;
		        }else{
		            echo json_encode(array('code'=>400, 'msg'=>'上传失败', 'data'=>''));
		            die;
		        }
		    } else {
		         //文件类型错误
		   		 echo json_encode(array('code'=>400, 'msg'=>'上传失败', 'data'=>''));
		   		 die;
		    }
		} else {
		    //文件错误
		    echo json_encode(array('code'=>400, 'msg'=>'上传失败', 'data'=>''));
		    die;
		}
	}

/********************************************************************************************/

}

?>