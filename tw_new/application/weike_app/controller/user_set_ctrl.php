<?php

class User_set_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('user_set_model');
        $this->load->model('is_login_model');
        $this->is_login_model->is_login();
	}

/**********************************************************************************/

    //会员中心设置页-[首页]
    public function user_set() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //调用模型方法获取会员基本信息
            $a_mybaseinfo = $this->user_set_model->get_user_baseinfo();
            echo json_encode($a_mybaseinfo);
        }
    }

/**********************************************************************************/

    //会员中心设置页-[修改个人密码]
    public function user_set_pwd() {
    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    		//接收数据
    		$oldpwd = trim($this->general->post('oldpwd'));
    		$newpwd = trim($this->general->post('newpwd'));
    		$newpwd2 = trim($this->general->post('newpwd2'));
    		//判断密码长度
			if (strlen($oldpwd)<6 || strlen($oldpwd)>16) {
				echo json_encode(array('code'=>501,'msg'=>'旧密码长度不合法'));
				die;
			}
			if (strlen($newpwd)<6 || strlen($newpwd)>16) {
				echo json_encode(array('code'=>502,'msg'=>'新密码长度不合法'));
				die;
			}
    		//验证两次密码输入是否一致
    		if ($newpwd != $newpwd2) {
    			echo json_encode(array('code'=>504, 'msg'=>'两次密码输入不一致'));
    			die;
    		}
    		//检查旧密码是否正确
    		$s_oldpwd = $this->user_set_model->get_user_pwd();
    		if (md5($oldpwd) != $s_oldpwd) {
    			echo json_encode(array('code'=>505, 'msg'=>'旧密码输入错误'));
    			die;
    		}
    		//检验旧密码与新密码是否相同
    		if (md5($newpwd) == $s_oldpwd) {
    			echo json_encode(array('code'=>506, 'msg'=>'新密码不能与旧密码一致'));
    			die;
    		}
    		//验证通过将新密码更新到数据
    		$newpwd = md5($newpwd);
    		$i_result = $this->user_set_model->update_user_pwd($newpwd);
    		if ($i_result) {
    			echo json_encode(array('code'=>200, 'msg'=>'修改密码成功'));
    			die;
    		} else {
    			echo json_encode(array('code'=>400, 'msg'=>'修改密码失败'));
    			die;
    		}
    	} else {
    		$this->view->display('update_pwd');
    	}
    }

/**********************************************************************************/

    //会员中心设置-[个人资料]
    public function user_set_baseinfo() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //调用模型方法获取会员基本信息
            $a_data = $this->user_set_model->get_user_baseinfo();
            $this->view->display('personal', $a_data);
        }
    }

/**********************************************************************************/

    //会员中心设置-[修改头像]
    public function user_set_userpic() {
    	if (isset($_SERVER['HTTP_REQUEST_TYPE']) && $_SERVER['HTTP_REQUEST_TYPE'] == "ajax") {
			$file = $_FILES['user_pic'];
			//允许上传的类型
			$allow = array('image/jpeg','image/jpg','image/png');
			//确定上传的目录
			$path = './images';
			//确定文件上传的大小 1M
			$maxsize = 1048576;
			//上传头像
			$photo = $this->upload_img($file, $allow, $error, $path, $maxsize);
			if($photo){
				//如果头像上传成功则删除原先的头像再将新的头像路径保存到数库
				//获取旧头像路径名并删除
				$oldphoto_path = $this->user_set_model->get_oldphoto_path();
				//如果存在旧头像就删除
				if(!empty($oldphoto_path)){
					unlink($oldphoto_path);
				}
				//将新的头像路径保存到数据库
				$i_result = $this->user_set_model->update_user_photo($photo);
				if($i_result) {
					echo json_encode(array('code'=>200, 'msg'=>'头像上传成功', 'newpath'=>$photo));
				} else {
					echo json_encode(array('code'=>300, 'msg'=>'保存头像路径出错', 'newpath'=>$photo));
				}
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'头像上传失败，失败原因：'. $error));
				die;
			}
    	}
    }

/**********************************************************************************/

	//修改用户性别
	public function user_set_usersex() {
		if (isset($_SERVER['HTTP_REQUEST_TYPE']) && $_SERVER['HTTP_REQUEST_TYPE'] == "ajax") {
			//判断用户是否已进行个人验证，如果是则不允许修改性别
			$i_result = $this->user_set_model->get_user_authlevel();
			if ($i_result==0) {
				//接收数据
				$sex = $this->general->post('sex');
				$i_result = $this->user_set_model->update_user_sex($sex);
				if ($i_result) {
					echo json_encode(array('code'=>200, 'msg'=>'修改成功'));
				} else {
					echo json_encode(array('code'=>300, 'msg'=>'修改失败'));
				}
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'您已经过身份认证，不允许修改性别'));
			}
		}
	}

/**********************************************************************************/

	/**
	 * [upload_img 文件上传函数]
	 * @param  [array]  $file    [上传文件的信息]
	 * @param  [array]  $allow   [允许的文件上传类型]
	 * @param  [string] &$error  [引用传递,用来记录错误信息]
	 * @param  [string] $path    [上传路径]
	 * @param  [int]    $maxsize [允许文件上传的最大大小]
	 * @return [string|boolean]  [如果上传失败就返回false,成功就返回新的文件名]
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
			$error = '上传的图片类型不正确';
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