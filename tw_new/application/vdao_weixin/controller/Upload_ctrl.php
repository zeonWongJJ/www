<?php

defined('BASEPATH') or exit('禁止访问！');

class Upload_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('upload_model');
	}

/*********************************** 上传头像 ***********************************/

	public function user_picupload() {
		$user_id = trim($this->general->post('user_id'));
		if (empty($user_id) || empty($_FILES)) {
			echo json_encode(array('code'=>400, 'msg'=>'必填项不能为空', 'data'=>''));
			die;
		}
		$file = $_FILES['user_pic'];
		// 允许上传的类型
		$allow = array('image/jpeg','image/jpg','image/png');
		// 确定上传的目录
		$path = 'upload/user';
		// 确定文件上传的大小 1M
		$maxsize = 1048576;
		// 上传头像
		$userpic_path = $this->upload_model->upload_img($file, $allow, $error, $path, $maxsize);
		if ($userpic_path) {
			// 更新头像路径
			$a_where = [
				'user_id' => $user_id,
			];
			$a_data = [
				'user_pic' => $userpic_path,
			];
			$i_result = $this->upload_model->update_user($a_where, $a_data);
			echo json_encode(array('code'=>200, 'msg'=>'上传成功', 'data'=> $userpic_path));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'上传失败', 'data'=> $error));
		}
	}

/******************************* 申请加盟时上传营业执照 *****************************/

	public function join_upload() {
		$file = $_FILES['file'];
		// 允许上传的类型
		$allow = array('image/jpeg','image/jpg','image/png');
		// 确定上传的目录
		$path = 'upload/join';
		// 确定文件上传的大小 1M
		$maxsize = 1048576*2;
		// 上传图片
		$img_path = $this->upload_model->upload_img($file, $allow, $error, $path, $maxsize);
		if ($img_path) {
			echo json_encode(array('code'=>200, 'msg'=>'上传成功', 'data'=> $img_path));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'上传失败', 'data'=> $error));
		}
	}

/************************************************************************************/

}

?>