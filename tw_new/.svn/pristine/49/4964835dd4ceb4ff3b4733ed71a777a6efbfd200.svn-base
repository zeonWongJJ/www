<?php

class Device_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('device_model');
        $this->load->model('allow_model');
        $this->allow_model->is_login();
        $this->allow_model->is_allow();
	}

/************************************* 设备列表 *************************************/

	public function device_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->device_model->get_device_all();
            $a_data['type'] = 9;
			$this->view->display('device_showlist2', $a_data);
		}
	}

/************************************* 添加设备 *************************************/

	public function device_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $device_name        = trim($this->general->post('device_name'));
            $device_version     = trim($this->general->post('device_version'));
            $device_description = trim($this->general->post('device_description'));
            $device_mainpic    = trim($this->general->post('mainpic_path'));
            $device_otherpic    = trim($this->general->post('otherpic_path'));
            $device_state       = trim($this->general->post('device_state'));
			//验证数据合法性
            $a_parameter = [
            	'msg'      => '添加设备成功',
            	'url'      => 'device_showlist',
            	'log'      => false,
            	'wait'     => 2,
            ];
			if (empty($device_name) || empty($device_version) || empty($device_otherpic)) {
            	$a_parameter['msg'] = '必填项不能为空';
            	$a_parameter['url'] = 'device_add';
            	$this->error->show_error($a_parameter);
			}
            if (empty($device_mainpic) && !empty($device_otherpic)) {
                $device_image = explode(',', $device_otherpic);
                $device_mainpic = $device_image[0];
            }
            //组装数据并保存到数据库
            if (!empty($device_mainpic) && !empty($device_otherpic)) {
                $a_data = [
    				'device_name'        => $device_name,
    				'device_version'     => $device_version,
    				'device_description' => $device_description,
    				'device_mainpic'     => $device_mainpic,
    				'device_otherpic'    => $device_otherpic,
    				'device_state'       => $device_state,
                ];
            }
            if (empty($device_mainpic) && empty($device_otherpic)) {
                $a_data = [
                    'device_name'        => $device_name,
                    'device_version'     => $device_version,
                    'device_description' => $device_description,
                    'device_state'       => $device_state,
                ];
            }
            if (!empty($device_mainpic) && empty($device_otherpic)) {
                $a_data = [
                    'device_name'        => $device_name,
                    'device_version'     => $device_version,
                    'device_description' => $device_description,
                    'device_mainpic'     => $device_mainpic,
                    'device_state'       => $device_state,
                ];
            }
            $i_result = $this->device_model->insert_device($a_data);
            if ($i_result) {
            	$this->error->show_success($a_parameter);
            } else {
            	$a_parameter['msg'] = '添加设备失败';
            	$a_parameter['url'] = 'device_add';
            	$this->error->show_error($a_parameter);
            }
		} else {
			$this->view->display('device_add3');
		}
	}

/************************************* 设备图片 *************************************/

    public function deviceimg_upload() {
        // 以下请求来自设备图片上传
        $file     = $_FILES['file'];
        $allow    = array('image/jpeg','image/jpg','image/png'); // 允许上传的图片类型
        $path     = 'upload/device';                             // 上传的路径
        $maxsize  = 1048576;                                     // 允许上传的最大文件大小
        $path_img = $this->upload_img($file, $allow, $error, $path, $maxsize);
        if ($path_img) {
            echo json_encode(array('code'=> 200, 'msg'=>'上传成功', 'data'=> $path_img));
        } else {
            echo json_encode(array('code'=> 400, 'msg'=>'上传失败', 'data'=> ''));
        }
    }

/*********************************** 删除临时图片 ***********************************/

    public function devicetem_delete() {
        $image_path = trim($this->general->post('image_path'));
        $dtype      = trim($this->general->post('dtype'));
        $record_id  = trim($this->general->post('record_id'));
        $b_result = unlink($image_path);
        if ($b_result) {
            if ($dtype == 2) {
                // 删除数据中记录的图片路径
                $a_device = $this->device_model->get_device_one($record_id);
                $device_mainpic = $a_device['device_mainpic'];
                $device_otherpic = $a_device['device_otherpic'];
                $a_update_where = [
                    'device_id' => $record_id
                ];
                if ($device_mainpic == $image_path) {
                    $a_update_data = [
                        'device_time'    => $_SERVER['REQUEST_TIME'],
                        'device_mainpic' => '',
                    ];
                    $this->device_model->update_device($a_update_where, $a_update_data);
                }
                // 将其余图片拆分成数组匹配
                $img_arr = explode(',', $device_otherpic);
                for ($i=0; $i<count($img_arr); $i++) {
                    if ($img_arr[$i] == $image_path) {
                        unset($img_arr[$i]);
                    }
                }
                $a_update_data = [
                    'device_time'     => $_SERVER['REQUEST_TIME'],
                    'device_otherpic' => implode(',', $img_arr),
                ];
                $this->device_model->update_device($a_update_where, $a_update_data);
            }
            echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
        } else {
            echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
        }
    }

/************************************* 修改设备 *************************************/

	public function device_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $device_id          = $this->general->post('device_id');
            $device_name        = trim($this->general->post('device_name'));
            $device_version     = trim($this->general->post('device_version'));
            $device_description = trim($this->general->post('device_description'));
            $device_mainpic    = trim($this->general->post('mainpic_path'));
            $device_otherpic    = trim($this->general->post('otherpic_path'));
            $device_state       = trim($this->general->post('device_state'));
            //验证数据合法性
            $a_parameter = [
                'msg'      => '修改设备成功',
                'url'      => 'device_showlist',
                'log'      => false,
                'wait'     => 2,
            ];
            if (empty($device_name) || empty($device_version) || empty($device_description)) {
                $a_parameter['msg'] = '必填项不能为空';
                $a_parameter['url'] = 'device_showlist';
                $this->error->show_error($a_parameter);
            }
            if (empty($device_mainpic) && !empty($device_otherpic)) {
                $device_image = explode(',', $device_otherpic);
                $device_mainpic = $device_image[0];
            }
            //组装数据并保存到数据库
            $a_data = [
                'device_name'        => $device_name,
                'device_version'     => $device_version,
                'device_description' => $device_description,
                'device_mainpic'     => $device_mainpic,
                'device_otherpic'    => $device_otherpic,
                'device_time'        => $_SERVER['REQUEST_TIME'],
                'device_state'       => $device_state,
            ];
            $a_where = [
                'device_id' => $device_id
            ];
            $i_result = $this->device_model->update_device($a_where, $a_data);
            if ($i_result) {
                $a_parameter['msg'] = '修改设备成功';
                $a_parameter['url'] = 'device_showlist';
                $this->error->show_success($a_parameter);
            } else {
                $a_parameter['msg'] = '修改设备失败';
                $a_parameter['url'] = 'device_showlist';
                $this->error->show_error($a_parameter);
            }
		} else {
			//接收需要修改的设备id
			$device_id = $this->router->get(1);
			//获取原数据
			$a_data['detail'] = $this->device_model->get_device_one($device_id);
			$this->view->display('device_update3', $a_data);
		}
	}

/************************************* 删除设备 *************************************/

	public function device_delete() {
		// type值为1代表单个删除 为2代表批量删除
		$type = $this->general->post('type');
		if ($type==1) {
			$device_id = $this->general->post('device_id');
			$i_result = $this->device_model->delete_device_one($device_id);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'删除设备成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'删除设备失败'));
			}
		} else {
			$device_ids = $this->general->post('device_ids');
			$i_result = $this->device_model->delete_device_mony($device_ids);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'删除设备成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'删除设备失败'));
			}
		}
	}

/************************************* 设备开关 *************************************/

    public function device_switch() {
        //接收参数
        $device_id = $this->general->post('device_id');
        //获取原来的状态
        $a_data = $this->device_model->get_device_one($device_id);
        if ($a_data['device_state'] == 1) {
            $a_update_data = [
                'device_state' => 0,
            ];
        } else {
            $a_update_data = [
                'device_state' => 1,
            ];
        }
        $a_update_where = [
            'device_id' => $device_id
        ];
        $i_result = $this->device_model->update_device($a_update_where, $a_update_data);
        if ($i_result) {
            if ($a_data['device_state'] == 1) {
                echo json_encode(array('code'=>200,'msg'=>'停用成功'));
            } else {
                echo json_encode(array('code'=>200,'msg'=>'启用成功'));
            }
        } else {
            echo json_encode(array('code'=>400,'msg'=>'设置失败'));
        }
    }

/************************************* 搜索设备 *************************************/

    public function device_search() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $keywords = trim($this->general->post('keywords'));
        } else {
            $keywords = urldecode($this->router->get(1));
        }
        $a_data = $this->device_model->get_device_search($keywords);
        $a_data['keywords'] = $keywords;
        $a_data['type'] = 6;
        $this->view->display('device_showlist2', $a_data);
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