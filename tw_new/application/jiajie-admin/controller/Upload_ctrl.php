<?php

defined('BASEPATH') or exit('禁止访问！');

class Upload_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('upload_model');
	}

/*********************************** 上传头像 ***********************************/

	public function admin_pic() {
		$file = $_FILES['userfile'];
		// 允许上传的类型
		$allow = array('image/jpeg','image/jpg','image/png');
		// 确定上传的目录
		$path = 'upload/admin';
		// 确定文件上传的大小 1M
		$maxsize = 1048576;
		// 上传头像
		$image_path = $this->upload_model->upload_img($file, $allow, $error, $path, $maxsize);
		if ($image_path) {
			echo json_encode(array('code'=>200, 'msg'=>'上传成功', 'data'=> $image_path));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'上传失败', 'data'=> $error));
		}
	}

/************************************************************************************/

}

?>