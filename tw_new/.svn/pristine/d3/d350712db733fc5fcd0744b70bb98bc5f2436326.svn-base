<?php

class Room_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('room_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 房间列表 *************************************/

	public function room_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_room = $this->room_model->get_room_all();
			$a_data['room'] = $a_room['room'];
			$a_data['count'] =$a_room['count'];
			//获取房间设备信息
			foreach ($a_data['room'] as $key => $value) {
				$device_ids = $value['device_ids'];
				$device_ids = explode(',', $device_ids);
				$device_data = $this->room_model->get_room_device($device_ids);
				$new_array = $value;
				$new_array['device'] = '';
				foreach ($device_data as $k => $v) {
					$new_array['device']  .= $v['device_name'].'、';
				}
				$new_data[] = $new_array;
			}
			$a_data['room'] = $new_data;
			$a_data['type'] = 9;
			$this->view->display('room_showlist2', $a_data);
		}
	}

/************************************* 添加房间 *************************************/

	public function room_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$room_name        = trim($this->general->post('room_name'));
			$type_id          = trim($this->general->post('type_id'));
			$room_keywords    = trim($this->general->post('room_keywords'));
			$room_size        = trim($this->general->post('room_size'));
			$room_state       = trim($this->general->post('room_state'));
			$room_seat        = trim($this->general->post('room_seat'));
			$room_description = trim($this->general->post('room_description'));
			$device_ids       = $this->general->post('device_ids');
			$room_mainpic     = $this->general->post('mainpic_path');
			$room_otherpic    = $this->general->post('otherpic_path');
			//验证数据合法性
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'room_showlist',
				'log'      => false,
				'wait'     => 2,
			];
			if (empty($room_name) || empty($type_id)) {
				$this->error->show_error($a_parameter);
			}
			// 将关键词中的中文逗号替换成英文逗号
			if (!empty($room_keywords)) {
				$room_keywords = str_replace('，', ',', $room_keywords);
			}
			if (empty($room_mainpic) && !empty($room_otherpic)) {
				$room_imgs = explode(',', $room_otherpic);
				$room_mainpic = $room_imgs[0];
			}
            //组装数据
            $a_data = [
				'room_name'        => $room_name,
				'type_id'          => $type_id,
				'room_keywords'    => $room_keywords,
				'room_size'        => $room_size,
				'room_seat'        => $room_seat,
				'device_ids'       => $device_ids,
				'room_mainpic'     => $room_mainpic,
				'room_otherpic'    => $room_otherpic,
				'room_description' => $room_description,
				'room_state'       => $room_state,
				'add_time'         => $_SERVER['REQUEST_TIME'],
				'update_time'      => $_SERVER['REQUEST_TIME'],
            ];
            $i_result = $this->room_model->insert_room($a_data);
            if ($i_result) {
            	$a_parameter['msg'] = '添加房间成功';
            	$a_parameter['url'] = 'room_showlist';
            	$this->error->show_success($a_parameter);
            } else {
            	$a_parameter['msg'] = '添加房间失败';
            	$this->error->show_error($a_parameter);
            }
		} else {
			//查询房间分类信息并分配到模板
			$a_data['type'] = $this->room_model->get_room_type();
			$a_data['type'] = $this->getSubTree($a_data['type'], 0, 0);
			//查询设备信息并分配到模板
			$a_data['device'] = $this->room_model->get_device_all();
			$this->view->display('room_add2', $a_data);
		}
	}

/*********************************** 删除临时图片 ***********************************/

    public function roomtem_delete() {
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
                    'room_id' => $record_id
                ];
                if ($room_mainpic == $image_path) {
                    $a_update_data = [
                        'update_time'  => $_SERVER['REQUEST_TIME'],
                        'room_mainpic' => '',
                    ];
                    $this->room_model->update_room($a_update_where, $a_update_data);
                }
                // 将其余图片拆分成数组匹配
                $img_arr = explode(',', $room_otherpic);
                for ($i=0; $i<count($img_arr); $i++) {
                    if ($img_arr[$i] == $image_path) {
                        unset($img_arr[$i]);
                    }
                }
                $a_update_data = [
					'update_time'   => $_SERVER['REQUEST_TIME'],
					'room_otherpic' => implode(',', $img_arr),
                ];
                $this->room_model->update_room($a_update_where, $a_update_data);
            }
            echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
        } else {
            echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
        }
    }

/************************************* 修改房间 *************************************/

	public function room_update() {
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			$room_id          = $this->general->post('room_id');
			$room_name        = trim($this->general->post('room_name'));
			$type_id          = trim($this->general->post('type_id'));
			$room_keywords    = trim($this->general->post('room_keywords'));
			$room_size        = trim($this->general->post('room_size'));
			$room_state       = trim($this->general->post('room_state'));
			$room_seat        = trim($this->general->post('room_seat'));
			$room_description = trim($this->general->post('room_description'));
			$device_ids       = $this->general->post('device_ids');
			$room_mainpic     = $this->general->post('mainpic_path');
			$room_otherpic    = $this->general->post('otherpic_path');
			//验证数据合法性
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'room_showlist',
				'log'      => false,
				'wait'     => 2,
			];
			if (empty($room_name) || empty($type_id)) {
				$this->error->show_error($a_parameter);
			}
			// 将关键词中的中文逗号替换成英文逗号
			if (!empty($room_keywords)) {
				$room_keywords = str_replace('，', ',', $room_keywords);
			}
			if (empty($room_mainpic) && !empty($room_otherpic)) {
				$room_imgs = explode(',', $room_otherpic);
				$room_mainpic = $room_imgs[0];
			}
            //组装数据
            $a_data = [
				'room_name'        => $room_name,
				'type_id'          => $type_id,
				'room_keywords'    => $room_keywords,
				'room_size'        => $room_size,
				'room_seat'        => $room_seat,
				'device_ids'       => $device_ids,
				'room_mainpic'     => $room_mainpic,
				'room_otherpic'    => $room_otherpic,
				'room_description' => $room_description,
				'room_state'       => $room_state,
				'update_time'      => $_SERVER['REQUEST_TIME'],
            ];
            $a_where = [
            	'room_id' => $room_id
            ];
            $i_result = $this->room_model->update_room($a_where, $a_data);
            if ($i_result) {
            	$a_parameter['msg'] = '修改房间成功';
            	$a_parameter['url'] = 'room_showlist';
            	$this->error->show_success($a_parameter);
            } else {
            	$a_parameter['msg'] = '修改房间失败';
            	$this->error->show_error($a_parameter);
            }
		} else {
			//接收需要修改的房间id
			$room_id = $this->router->get(1);
			//获取房间原数据并分配到模板
			$a_data['detail'] = $this->room_model->get_room_one($room_id);
			//查询房间分类信息并分配到模板
			$a_data['type'] = $this->room_model->get_room_type();
			$a_data['type'] = $this->getSubTree($a_data['type'], 0, 0);
			//查询设备信息并分配到模板
			$a_data['device'] = $this->room_model->get_device_all();
			$this->view->display('room_update2', $a_data);
		}
	}

/************************************* 删除房间 *************************************/

	public function room_delete() {
		// type值为1代表单个删除 为2代表批量删除
		$type = $this->general->post('type');
		if ($type==1) {
			$room_id = $this->general->post('room_id');
			$i_result = $this->room_model->delete_room_one($room_id);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
			}
		} else {
			$room_ids = $this->general->post('room_ids');
			$i_result = $this->room_model->delete_room_mony($room_ids);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
			}
		}
	}

/************************************* 房间开关 *************************************/

	public function room_switch() {
		//接收房间id
		$room_id = $this->general->post('room_id');
		//获取房间信息
		$a_data = $this->room_model->get_room_one($room_id);
		$room_state = $a_data['room_state'];
		//如果房间开启则关闭 如果关闭则开启
		if ($room_state == 1) {
			$room_state = 0;
		} else {
			$room_state = 1;
		}
		$a_update_where = [
			'room_id' => $room_id
		];
		$a_update_data = [
			'room_state' => $room_state
		];
		$i_result = $this->room_model->update_room($a_update_where, $a_update_data);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'设置成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'设置失败'));
		}
	}

/************************************* 房间查询 *************************************/

	public function room_search() {
		//接收关键词
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$keywords = trim($this->general->post('keywords'));
		} else {
			$keywords = urldecode($this->router->get(1));
		}
		$a_room = $this->room_model->get_room_search($keywords);
		$a_data['room'] = $a_room['room'];
		$a_data['count'] =$a_room['count'];
		//获取房间设备信息
		foreach ($a_data['room'] as $key => $value) {
			$device_ids = $value['device_ids'];
			$device_ids = explode(',', $device_ids);
			$device_data = $this->room_model->get_room_device($device_ids);
			$new_array = $value;
			$new_array['device'] = '';
			foreach ($device_data as $k => $v) {
				$new_array['device']  .= $v['device_name'].'、';
			}
			$new_data[] = $new_array;
		}
		$a_data['room'] = $new_data;
		$a_data['type'] = 6;
		$a_data['keywords'] = $keywords;
		$this->view->display('room_showlist2', $a_data);
	}

/************************************ 无限极分类 ************************************/

	/**
	 * 获取子孙树
	 * @param   array        $data   待分类的数据
	 * @param   int/string   $id     要找的子节点id
	 * @param   int          $lev    节点等级
	 */
	 public function getSubTree($data , $id = 0 , $lev = 1) {
	     static $son = array();
	     foreach($data as $key => $value) {
	         if($value['type_pid'] == $id) {
	             $value['type_level'] = $lev;
	             $son[] = $value;
	             $this->getSubTree($data, $value['type_id'] , $lev+1);
	         }
	     }
	     return $son;
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