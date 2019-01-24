<?php
defined('BASEPATH') OR exit('禁止访问！');
class Verification_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('verification_model');
        $this->load->model('is_login_model');
        $this->is_login_model->is_login();
	}

/***************************************** 会员中心身份证验证 *****************************************/

	// 会员中心之身份证验证
	public function id_verification() {
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			//接收用用提交的数据
			$realname = trim($this->general->post('realname'));
			$id_number = trim($this->general->post('id_number'));
			$realsex = trim($this->general->post('realsex'));
			$id_type = trim($this->general->post('id_type'));
			//对数据进行验证
			if (strlen($realname)<6 || strlen($realname)>30) {
				//echo json_encode(array('code'=>70,'msg'=>'姓名不合法'));
				$this->error->show_error('姓名不合法', 'id_verification', false, 2);
				die;
			}
			if (strlen($id_number)!=18) {
				//echo json_encode(array('code'=>71,'msg'=>'身份证有误'));
				$this->error->show_error('身份证有误', 'id_verification', false, 2);
				die;
			}
			if (strlen($id_type)<3 || strlen($id_type)>20) {
				//echo json_encode(array('code'=>68,'msg'=>'证件类型长度不合法'));
				$this->error->show_error('证件类型长度不合法', 'id_verification', false, 2);
				die;
			}
			if (strlen($realsex)!=1) {
				//echo json_encode(array('code'=>69,'msg'=>'请选择性别'));
				$this->error->show_error('请选择性别', 'id_verification', false, 2);
				die;
			}
			//开始上传证照照片
			$file = $_FILES['id_image'];
			//允许上传的类型
			$allow = array('image/jpeg','image/jpg','image/png');
			//确定上传的目录
			$path = './images';
			//确定文件上传的大小 1M
			$maxsize = 1048576;
			//调用文件上传文件方法
			$id_image = $this->upload_img($file, $allow, $error, $path, $maxsize);
			if ($id_image) {
				//上传身份证正面照
				$file = $_FILES['id_imgtwo'];
				$id_imgtwo = $this->upload_img($file, $allow, $error, $path, $maxsize);
				if ($id_imgtwo) {
					//两张照片均上传成功则保存到数据库
					$a_data = [
						'uid' => $_SESSION['user_id'],
						'username' => $_SESSION['user_name'],
						'id_number' => $id_number,
						'realname' => $realname,
						'realsex' => $realsex,
						'id_type' => $id_type,
						'id_image' => $id_image,
						'id_imgtwo' => $id_imgtwo,
						'start_time' => $_SERVER['REQUEST_TIME'],
						'auth_status' => 0
					];
					$result = $this->verification_model->add_auth_realname($a_data);
					if($result){
						//echo json_encode(array('code'=>200, 'msg'=>'提交成功，请耐心等待'));
						$this->error->show_success('提交成功，请耐心等待', 'id_verification', false, 2);
						die;
					}else{
						//echo json_encode(array('code'=>400, 'msg'=>'提交失败，发生未知错误'));
						$this->error->show_error('提交失败，发生未知错误', 'id_verification', false, 2);
						die;
					}
				} else {
					//echo json_encode(array('code'=>73, 'msg'=>'身份证正面照片上传失败，失败原因：' . $error));
					$this->error->show_error('身份证正面照片上传失败，失败原因：' . $error, 'id_verification', false, 2);
					die;
				}
			} else {
				//echo json_encode(array('code'=>74, 'msg'=>'手持身份证照片上传失败，失败原因：' . $error));
				$this->error->show_error('手持身份证照片上传失败，失败原因：' . $error, 'id_verification', false, 2);
				die;
			}
		} else {
			//判断用户是否有提交身份证认证信息
			$a_data = $this->verification_model->is_submit_realname();
			//将身份证号码做隐私处理
			$a_data['id_number'] = substr_replace($a_data['id_number'], '********', 6, 8);
			if ($a_data && $a_data['auth_status']==0) {
				//用户已提交过认证信息，且还未审核
				//echo json_encode(array('code'=>75, 'msg'=>'用户已提交过认证信息，还未审核', 'data'=>$a_data));
				$this->view->display('AuthenNameWait', $a_data);
			} else if ($a_data && $a_data['auth_status']==1) {
				//用户已提交认证信息，且认证已审核通过
				//echo json_encode(array('code'=>76, 'msg'=>'用户已提交认证信息，且认证已审核通过', 'data'=>$a_data));
				$this->view->display('AuthenNameSuccess', $a_data);
			} else if ($a_data && $a_data['auth_status']==2) {
				//用户已提交认证信息，但认证审核不通过
				//echo json_encode(array('code'=>77, 'msg'=>'用户已提交认证信息，但认证审核不通过', 'data'=>$a_data));
				$this->view->display('AuthenNameFail', $a_data);
			} else {
				//用户未提交过认证信息
				echo json_encode(array('code'=>78, 'msg'=>'用户未提交过认证信息','data'=>$a_data));
			}
		}
	}

/*****************************************************************************************************/

	//会员中心个人身份认证之认证失败后重新认证
	public function id_verification_again() {
		if ($_SERVER['REQUEST_METHOD'] == "GET") {
			//删除认证失败的信息
			$i_result = $this->verification_model->del_realname();
			if($i_result){
				echo json_encode(array('code'=>200, 'msg'=>'ok'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'error'));
			}
		}
	}

/*****************************************************************************************************/

	//会员中心之银行卡认证
	public function bankcard_verification() {
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			//接收用户提交的数据
			$bank = trim($this->general->post('bank'));
			$account_name = trim($this->general->post('account_name'));
			$bank_number = trim($this->general->post('bank_number'));
			$bank_address = trim($this->general->post('bank_address'));
			//对提交的数据进行验证
			if (empty($bank)) {
				echo json_encode(array('code'=>31,'msg'=>'请选择账户所在银行'));
				die;
			}
			//对账户名进行验证
			if (strlen($account_name)<6 || strlen($account_name)>30) {
				echo json_encode(array('code'=>32,'msg'=>'账户名长度不合法'));
				die;
			}
			//对银行卡号进行验证
			if (!is_numeric($bank_number) || strlen($bank_number)<10 || strlen($bank_number)>25) {
				echo json_encode(array('code'=>33,'msg'=>'银行卡号不合法'));
				die;
			}
			//对开户支行进行验证
			if (strlen($bank_address)<6 || strlen($bank_address)>60) {
				echo json_encode(array('code'=>34,'msg'=>'开户支行长度不合法'));
				die;
			}
			$a_data = [
				'member_id' => $_SESSION['user_id'],
				'bank_name' => $bank,
				'card_number' => $bank_number,
				'account_name' => $account_name,
				'bank_address' => $bank_address,
				'state' => 0
			];
			//调用模型方法实现插入数据
			$result = $this->verification_model->add_bound_cards($a_data);
			if ($result) {
				echo json_encode(array('code'=>200, 'msg'=>'提交成功，请耐心等待'));
				die;
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'提交失败，发生未知错误'));
				die;
			}
		} else {
			//判断用户是否已经进行实名认证
			$result = $this->verification_model->is_auth_realname();
			if ($result==0) {
				//没有实名认证
				//echo json_encode(array('code'=>35, 'msg'=>'请先进行身份证验证'));
				$this->view->display('id_verification');
			} else {
				//判断用户是否已经提交过银行卡认证信息
				$a_data = $this->verification_model->is_submit_bank();
				if ($a_data && $a_data['state'] == 0) {
					//已提交过银行卡认证，系统未打款
					//echo json_encode(array('code'=>36, 'msg'=>'已提交过银行卡认证，系统未打款', 'data'=>$data));
					$this->view->display('AuthenWait', $a_data);
				} else if ($a_data && $a_data['state'] == 1) {
					//已提交过银行卡认证，系统已打款，用户未验证
					//echo json_encode(array('code'=>37, 'msg'=>'已提交过银行卡认证，系统已打款，用户未验证', 'data'=>$data));
					$this->view->display('bankCardAuthen', $a_data);
				} else if ($a_data && $a_data['state'] == 2) {
					//已提交过银行卡认证，系统已打款，用户已验证，且验证通过
					//echo json_encode(array('code'=>38, 'msg'=>'已提交过银行卡认证，系统已打款，用户已验证，且验证通过', 'data'=>$data));
					$this->view->display('AuthenSuccess', $a_data);
				} else if ($a_data && $a_data['state'] == 3) {
					//已提交过银行卡认证，系统已打款，用户已验证，验证不通过
					//echo json_encode(array('code'=>39, 'msg'=>'已提交过银行卡认证，系统已打款，用户已验证，验证不通过', 'data'=>$data));
					$this->view->display('AuthenFail', $a_data);
				} else {
					//未提交过银行卡认证
					//取出银行的信息
					$a_data['bank'] = $this->verification_model->bank_info();
					//取出身份验证信息的个人真实姓名
					$a_data['realname'] = $this->verification_model->realname_info();
					echo json_encode(array('code'=>40, 'msg'=>'未提交过银行卡认证', 'data'=>$data));
				}
			}
		}
	}

/*****************************************************************************************************/

	//会员中心银行卡认证2 [验证金额]
	public function bankcard_two() {
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			//接收用户提交的金额
			$amount = trim($this->general->post('amount'));
			//取出系统打款的金额
			$a_data = $this->verification_model->is_submit_bank();
			$system_amount = $a_data['amount'];
			if ($amount == $system_amount) {
				//如果用户输入的金额与系统一致则验证通过
				//将银行卡状态修改为2
				$this->verification_model->update_bank_state(2);
				//会员表的认证状态更新为2
				$this->verification_model->update_user_state();
				echo json_encode(array('code'=>200, 'msg'=>'银行卡认证通过'));
			} else {
				//将银行卡的认证状态改为3
				$this->verification_model->update_bank_state(3);
				echo json_encode(array('code'=>400, 'msg'=>'银行卡认证失败'));
			}
		}
	}

/*****************************************************************************************************/

	//会员中心->设置->银行卡认证->重新认证
	//重新认证将删除认证失败的信息，并将认证状态还原
	public function bankcard_again() {
		if ($_SERVER['REQUEST_METHOD'] == "GET") {
			//删除认证失败的信息
			$i_result = $this->verification_model->del_bank();
			if($i_result){
				echo json_encode(array('code'=>200, 'msg'=>'ok'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'error'));
			}
		}
	}

/*****************************************************************************************************/

	//服务者中心证照验证
	public function certificate_verification() {
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			//接收提交的信息
			$cer_cate = trim($this->general->post('cer_cate'));
			$cer_number = trim($this->general->post('cer_number'));
			$cer_effective = trim($this->general->post('cer_effective'));
			$cer_rank = trim($this->general->post('cer_rank'));
			$cer_effective = strtotime($cer_effective);
			//验证数据合法性
			if (empty($cer_cate) || empty($cer_number) || empty($cer_effective) || empty($cer_rank)) {
				echo json_encode(array('code'=>300, 'msg'=>'必填项不能为空'));
			}
			//允许上传的类型
            $allow = array('image/jpeg','image/jpg','image/png',);
            //确定上传的目录
            $path = './images';
            //确定文件上传的大小 1M
            $maxsize = 1048576;
            //上传图片凭证
            $file = $_FILES['cer_pic'];
            for ($i=0; $i < count($_FILES['cer_pic']['name']); $i++) {
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
            $a_data = [
				'cer_cate'      => $cer_cate,
				'cer_number'    => $cer_number,
				'cer_effective' => $cer_effective,
				'cer_rank'      => $cer_rank,
				'cer_pic'       => $img_path,
				'start_time'    => $_SERVER['REQUEST_TIME'],
				'sub_uid'       => $_SESSION['user_id'],
				'state'         => 0,
            ];
            $i_result = $this->verification_model->insert_auth_certificate($a_data);
            if ($i_result) {
            	echo json_encode(array('code'=>200, 'msg'=>提交成功));
            } else {
            	echo json_encode(array('code'=>400, 'msg'=>提交失败));
            }
		} else {
			$this->view->display('certificate_verification');
		}
	}

/*****************************************************************************************************/

	//企业验证
	public function  company_verification() {
		if ($_SERVER['REQUEST_METHOD']=="POST") {
			//接收提交的数据
			$company_name       = trim($this->general->post('company_name'));
			$register_number    = trim($this->general->post('register_number'));
			$corporation_name   = trim($this->general->post('corporation_name'));
			$corporation_number = trim($this->general->post('corporation_number'));
			$linkman_name       = trim($this->general->post('linkman_name'));
			$linkman_tel        = trim($this->general->post('linkman_tel'));
			//对提交的数据进行验证
			//对公司名称进行验证
			if (strlen($company_name)<5 || strlen($company_name)>150) {
				echo json_encode(array('code'=>101, 'msg'=>'公司名称长度不合法'));
				die;
			}
			//对企业注册号进行验证
			if (strlen($register_number)<5 || strlen($company_id)>100) {
				echo json_encode(array('code'=>102, 'msg'=>'企业注册号长度不合法'));
				die;
			}
			//对法人姓名进行验证
			if (strlen($corporation_name)<2 || strlen($corporation_name)>20) {
				echo json_encode(array('code'=>103, 'msg'=>'法人姓名长度不合法'));
				die;
			}
			//对法人身份证号进行验证
			if (strlen($corporation_number)!=18) {
				echo json_encode(array('code'=>104, 'msg'=>'法人身份证号码长度不合法'));
				die;
			}
			//对联系人姓名进行验证
			if (strlen($linkman_name)<2 || strlen($linkman_name)>20) {
				echo json_encode(array('code'=>105, 'msg'=>'联系人姓名长度不合法'));
				die;
			}
			//对联系人联系方式进行验证
			if (strlen($linkman_tel)<3 || strlen($linkman_tel)>30) {
				echo json_encode(array('code'=>106, 'msg'=>'联系人联系方式长度不合法'));
				die;
			}
			//允许上传的类型
			$allow = array('image/jpeg','image/jpg','image/png');
			//确定上传的目录
			$path = './images';
			//确定文件上传的大小 1M
			$maxsize = 1048576;
			$file = $_FILES['business_licence'];
			$business_licence = $this->upload_img($file, $allow, $error, $path, $maxsize);
			//上传法人手持身份证照片
			$file = $_FILES['corporation_img'];
			$corporation_img = $this->upload_img($file, $allow, $error, $path, $maxsize);
			//组装数据并保存到数据库
			$a_data = [
				'company_name'       => $company_name,
				'register_number'    => $register_number,
				'corporation_name'   => $corporation_name,
				'corporation_number' => $corporation_number,
				'linkman_name'       => $linkman_name,
				'linkman_tel'        => $linkman_tel,
				'business_licence'   => $business_licence,
				'corporation_img'    => $corporation_img,
				'start_time'         => $_SERVER['REQUEST_TIME'],
				'auth_state'         => 0,//0表示等待审核中
				'sub_uid'            => $_SESSION['user_id']
			];
			$i_result = $this->verification_model->insert_auth_company($a_data);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'提交成功，请耐心等待'));
				die;
			}else {
				echo json_encode(array('code'=>400, 'msg'=>'提交失败，发生未知错误'));
				die;
			}
		}else{
			$this->view->display('company_verification');
		}
	}

/*****************************************************************************************************/

	/**
	 * [upload_img description]
	 * @param  [array] $file     [上传文件的信息]
	 * @param  [array] $allow    [上传文件的信息]
	 * @param  [string] &$error  [引用传递,用来记录错误信息]
	 * @param  [string] $path    [上传路径]
	 * @param  [int] $maxsize    [允许文件上传的最大大小]
	 * @return [boolean|string]  [如果上传失败就返回false,成功就返回新的文件名]
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


