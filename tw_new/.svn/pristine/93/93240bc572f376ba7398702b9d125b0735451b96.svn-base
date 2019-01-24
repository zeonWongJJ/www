<?php

class Store_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('store_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 门店列表 *************************************/

	public function store_showlist() {
		$this->load->library('passenger_flow');
		$now_date = date('Y-m-d', time());
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->store_model->get_store_showlist();
			$new_data = array();
			if (!empty($a_data['store'])) {
				foreach ($a_data['store'] as $key => $value) {
					if (!empty($value['passenger_openid'])) {
						$a_shiti_detail = $this->passenger_flow->get_entity_detail($value['passenger_openid']);
						// 实体第一个设备的openid
						$deviceopenId = $a_shiti_detail['content']['passageways'][0]['devices'][0]['openId'];
						$a_passenger_min = $this->passenger_flow->get_device($deviceopenId, $now_date, $now_date);
						if (!empty($a_passenger_min['content'])) {
							$out_cur = $in_all = 0;
							foreach ($a_passenger_min['content'] as $k => $v) {
								$in_all += $v['in'];
								$out_cur += $v['out'];
							}
							
							/*$num = count($a_passenger_min['content']) - 1;
							$now_pass = $a_passenger_min['content'][$num];
							$in_cur = $now_pass['in'];
							$out_cur = $now_pass['out'];*/
							$value['in_all']  = $in_all;
							$value['in_cur']  = $in_all - $out_cur;
							$value['out_cur'] = $out_cur;
						} else {
							$value['in_all']  = 0;
							$value['in_cur']  = 0;
							$value['out_cur'] = 0;
						}
					} else {
						$value['in_all']  = 0;
						$value['in_cur']  = 0;
						$value['out_cur'] = 0;
					}
					$new_data[] = $value;
				}
			}
			$a_data['store'] = $new_data;
			$a_data['type'] = 8;
			$this->view->display('store_showlist', $a_data);
		}
	}

/************************************* 添加门店 *************************************/

	public function store_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$store_name        = trim($this->general->post('store_name'));
			$store_state       = trim($this->general->post('store_state'));
			$store_address     = trim($this->general->post('store_address'));
			$store_linkman     = trim($this->general->post('store_linkman'));
			$store_contact     = trim($this->general->post('store_contact'));
			$store_licence     = trim($this->general->post('otherpic_path'));
			$manager_name      = trim($this->general->post('manager_name'));
			$manager_password  = trim($this->general->post('manager_password'));
			$manager_password2 = trim($this->general->post('manager_password2'));
			$passenger_openid  = trim($this->general->post('passenger_openid'));
			$transport_id      = trim($this->general->post('transport_id'));

            //验证数据合法性
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'store_add',
				'log'      => false,
				'wait'     => 2,
			];
			if (empty($store_name) || empty($manager_name) || empty($manager_password) || empty($manager_password2)) {
				$this->error->show_error($a_parameter);
			}
			if ($manager_password != $manager_password2) {
				$a_parameter['msg'] = '两次密码输入不一致';
				$a_parameter['url'] = 'store_add';
				$this->error->show_error($a_parameter);
			}
			// 验证管理员用户名是否被占用
			$a_manager = $this->store_model->get_manager_name($manager_name);
			if ($a_manager) {
				$a_parameter['msg'] = '门店账号已被占用';
				$a_parameter['url'] = 'store_add';
				$this->error->show_error($a_parameter);
			}
			//组装数据并保存到数据库
			$a_data = [
				'store_name'       => $store_name,
				'store_address'    => $store_address,
				'store_order'      => 0,
				'store_score'      => 0,
				'store_licence'    => $store_licence,
				'store_linkman'    => $store_linkman,
				'store_contact'    => $store_contact,
				'store_state'      => $store_state,
				'passenger_openid' => $passenger_openid,
				'transport_id'     => $transport_id,
				'store_regtime'    => $_SERVER['REQUEST_TIME'],
			];
			$i_result = $this->store_model->insert_store($a_data);
			if ($i_result) {
				// 添加一个分组
				$a_group_data = [
					'group_name'        => $store_name . '店长',
					'manager_count'     => 1,
					'store_id'          => $i_result,
					'add_time'          => $_SERVER['REQUEST_TIME'],
					'group_state'       => 1,
					'group_description' => '拥有当前门店所有权限'
				];
				$i_group = $this->store_model->insert_group($a_group_data);
				// 获取密码强度
				$manager_safe = $this->manager_safe($manager_password);
				// 添加成功后添加此门店的管理员账号
				$a_manager_data = [
					'manager_name'     => $manager_name,
					'manager_password' => md5(md5($manager_password)),
					'manager_realname' => $store_linkman,
					'manager_type'     => 1,
					'manager_phone'    => $store_contact,
					'register_time'    => $_SERVER['REQUEST_TIME'],
					'manager_state'    => 1,
					'store_id'         => $i_result,
					'group_id'         => $i_group,
					'manager_safe'     => $manager_safe
				];
				$this->store_model->insert_manager($a_manager_data);
				$a_parameter['msg'] = '添加成功';
				$a_parameter['url'] = 'store_showlist';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '添加失败';
				$a_parameter['url'] = 'store_add';
				$this->error->show_error($a_parameter);
			}
		} else {
			$this->view->display('store_add4');
		}
	}

/*********************************** 删除临时图片 ***********************************/

    public function storetem_delete() {
        $image_path = trim($this->general->post('image_path'));
        $dtype      = trim($this->general->post('dtype'));
        $record_id  = trim($this->general->post('record_id'));
        $b_result 	= unlink($image_path);
        if ($b_result) {
            if ($dtype == 2) {
                // 删除数据中记录的图片路径
                $a_room = $this->room_model->get_room_one($record_id);
                $room_mainpic = $a_room['room_mainpic'];
                $room_otherpic = $a_room['room_otherpic'];
                $a_update_where = [
                    'store_id' => $record_id
                ];
                $a_update_data = [
                    'update_time'  => $_SERVER['REQUEST_TIME'],
                    'store_licence' => '',
                ];
                $this->room_model->update_store($a_update_where, $a_update_data);
            }
            echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
        } else {
            echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
        }
    }

/************************************* 修改门店 *************************************/

	public function store_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$store_id          = $this->general->post('store_id');
			$store_name        = trim($this->general->post('store_name'));
			$store_state       = trim($this->general->post('store_state'));
			$store_address     = trim($this->general->post('store_address'));
			$store_linkman     = trim($this->general->post('store_linkman'));
			$store_contact     = trim($this->general->post('store_contact'));
			$store_licence     = trim($this->general->post('otherpic_path'));
			$manager_id        = trim($this->general->post('manager_id'));
			$manager_name      = trim($this->general->post('manager_name'));
			$manager_password  = trim($this->general->post('manager_password'));
			$manager_password2 = trim($this->general->post('manager_password2'));
			$passenger_openid  = trim($this->general->post('passenger_openid'));
			$transport_id      = trim($this->general->post('transport_id'));
			$manager_name_old  = trim($this->general->post('manager_name_old'));
            //验证数据合法性
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'store_update-' . $store_id,
				'log'      => false,
				'wait'     => 2,
			];
			if (empty($store_name) || empty($manager_name)) {
				$this->error->show_error($a_parameter);
			}
			//组装数据并保存到数据库
			$a_where = [
				'store_id' => $store_id
			];
			$a_data = [
				'store_name'       => $store_name,
				'store_state'      => $store_state,
				'store_address'    => $store_address,
				'store_linkman'    => $store_linkman,
				'store_contact'    => $store_contact,
				'store_licence'    => $store_licence,
				'passenger_openid' => $passenger_openid,
				'transport_id'     => $transport_id,
				'update_time'      => $_SERVER['REQUEST_TIME'],
			];
			$i_result = $this->store_model->update_store($a_where, $a_data);
			$a_manage_where = [
				'manager_id' => $manager_id,
			];
			if (empty($manager_password) || empty($manager_password2)) {
				$a_manager_data = [
					'manager_name' => $manager_name
				];
			} else {
				// 验证两次密码是否一致
				if ($manager_password != $manager_password2) {
					$a_parameter['msg'] = '两次密码输入不一致';
					$a_parameter['url'] = 'store_update-' . $store_id;
					$this->error->show_error($a_parameter);
				}
				// 验证用户名是否被占用
				if ($manager_name != $manager_name_old) {
					$a_manager = $this->store_model->get_manager_name($manager_name);
					if ($a_manager) {
						$a_parameter['msg'] = '门店账号已被占用';
						$a_parameter['url'] = 'store_update-' . $store_id;
						$this->error->show_error($a_parameter);
					}
				}
				$a_manager_data = [
					'manager_name'     => $manager_name,
					'manager_password' => md5(md5($manager_password2)),
				];
			}
			$i_manager = $this->store_model->update_manager($a_manage_where, $a_manager_data);
			if ($i_result) {
				$a_parameter['msg'] = '修改成功';
				$a_parameter['url'] = 'store_showlist';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '修改失败';
				$a_parameter['url'] = 'store_update-' . $store_id;
				$this->error->show_error($a_parameter);
			}
		} else {
			//接收需要修改的门店id
			$store_id = $this->router->get(1);
			//查找原数据并分配到模板
			$a_data['store']   = $this->store_model->get_store_one($store_id);
			$a_data['manager'] = $this->store_model->get_manager_one($store_id);
			$this->view->display('store_update2', $a_data);
		}
	}

/************************************* 删除门店 *************************************/

	public function store_delete() {
		//如果type值为1则代表删除单个 为2代表删除批量删除
		$type = $this->general->post('type');
		if($type == 1) {
			$store_id = $this->general->post('store_id');
			$i_result = $this->store_model->delete_store_one($store_id);
			if ($i_result) {
				// 删除该门店店所有管理员
				$a_where = [
					'store_id' => $store_id,
				];
				  $this->db->delete('manager', $a_where);
				  $this->db->delete('prod_sto', $a_where);
				echo json_encode(array('code'=>200,'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400,'msg'=>'删除失败'));
			}
		} else {
			$a_data = $this->general->post('store_ids');
			$i_result = $this->store_model->delete_store_mony($a_data);
			if($i_result) {
				$i_result = $this->db->where_in('store_id', $a_data)->delete('manager');
				$i_result = $this->db->where_in('store_id', $a_data)->delete('prod_sto');
				echo json_encode(array('code'=>200,'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400,'msg'=>'删除失败'));
			}
		}
	}

/************************************* 搜索门店 *************************************/

	public function store_search() {
		//接收要查询的关键词
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$keywords = trim($this->general->post('keywords'));
		} else {
			$keywords = urldecode($this->router->get(1));
		}
		$a_data = $this->store_model->get_store_search($keywords);
		$a_data['type'] = 9;
		$a_data['keywords'] = $keywords;
		$this->view->display('store_showlist', $a_data);
	}

/************************************* 照片审批 *************************************/

	public function store_photo() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//获取所有门店的照片
			$a_data = $this->store_model->get_store_photo();
			$this->view->display('store_photo', $a_data);
		} else {
			//接收参数
			$store_id = $this->general->post('store_id');
			$num = $this->general->post('num');
			$i_result = $this->store_model->update_store_photo($store_id, $num);
			if ($i_result) {
				echo json_encode(array('code'=>200));
			} else {
				echo json_encode(array('code'=>400));
			}
		}
	}

/************************************* 启用停用 *************************************/

	public function store_switch() {
		$store_id = $this->general->post('store_id');
		//取出原来的状态
		$a_data = $this->store_model->get_store_one($store_id);
		$store_state = $a_data['store_state'];
		if ($store_state == 1) {
			$a_update_data = [
				'store_state'=> 2
				
			];
		
		} else {
			$a_update_data = [
				'store_state'=> 1
			];
			
		}
		$a_update_where = [
			'store_id' => $store_id
		];
		// 更新数据
		$i_result = $this->store_model->update_store($a_update_where, $a_update_data);
		if ($i_result) {
			if ($a_update_data['store_state'] == 2) {
				$this->db->update('prod_sto', ['prod_show' => 2], ['store_id' => $store_id]);
			}
			echo json_encode(array('code'=>200));
		} else {
			echo json_encode(array('code'=>400));
		}
	}

/************************************* 文件上传 *************************************/

	// 门店图片上传
	function store_img() {
		$file     = $_FILES['file'];
		$allow    = array('image/jpeg','image/jpg','image/png'); //允许上传的图片类型
		$path     = './upload/store'; 							 //上传的路径
		$maxsize  = 1048576;									 //允许上传的最大文件大小
		$path_img = $this->upload_img($file, $allow, $error, $path, $maxsize);
        if ($path_img) {
        	echo json_encode(array('code'=> 200, 'msg'=>'上传成功', 'data'=> $path_img));
        } else {
        	echo json_encode(array('code'=> 400, 'msg'=>'上传失败', 'data'=> ''));
        }
	}

/**************************************** 账号安全等级 ****************************************/

	public function manager_safe($str) {
       $score = 0;
       if(preg_match("/[0-9]+/",$str))
       {
          $score ++;
       }
       if(preg_match("/[0-9]{3,}/",$str))
       {
          $score ++;
       }
       if(preg_match("/[a-z]+/",$str))
       {
          $score ++;
       }
       if(preg_match("/[a-z]{3,}/",$str))
       {
          $score ++;
       }
       if(preg_match("/[A-Z]+/",$str))
       {
          $score ++;
       }
       if(preg_match("/[A-Z]{3,}/",$str))
       {
          $score ++;
       }
       if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/",$str))
       {
          $score += 2;
       }
       if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]{3,}/",$str))
       {
          $score ++ ;
       }
       if(strlen($str) >= 10)
       {
          $score ++;
       }
       return $score;
	}

/************************************* 文件上传 *************************************/

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

        //判断文件夹是否存在 不存在则创建
	    if (!file_exists($path)){
	        mkdir($path);
	    }

        //拼接新的文件名
        $newname = date('Ymdhis',time()) . rand(111, 999) .strrchr($file['name'], '.');
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

/************************************************************************************/

}

?>