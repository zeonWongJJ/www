<?php
class Audit_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
		$this->load->model('upload_model');
	}

	//资质申请
	public function qualifi() {
		$audit         =  $this->router->get(1);
		$phone         = $this->general->post('phone');
		$business_imge = $this->general->post('business_imge');
		$business_hao  = $this->general->post('business_hao');
		$business_name = $this->general->post('business_name');
		$business_imt  = $this->general->post('business_imt');
		$applicant     = $this->general->post('applicant');
		$unit_province = $this->general->post('unit_province');
		$unit_city     = $this->general->post('unit_city');
		$unit_district = $this->general->post('unit_district');
		$unit_address  = $this->general->post('unit_address');
		$unit_legal_name  = $this->general->post('unit_legal_name');
		$unit_legal_number = $this->general->post('unit_legal_number');
		$unit_legal_imge  = $this->general->post('unit_legal_imge');
		$applicant_name   = $this->general->post('applicant_name');
		$applicant_number = $this->general->post('applicant_number');
		$applicant_imge = $this->general->post('applicant_imge');
		$phone_code     = $this->general->post('phone_code');
		$a_parameter = [
			'msg'      => '验证码不正确',
			'url'      => 'audit',
			'log'      => false,
			'wait'     => 2,
		];
		if ($audit == 1) {
			$audit = 5;
		} else {
			$audit = 1;
			//验证数据合法性
			if (empty($phone) || empty($business_imge) || empty($business_hao) || empty($business_name) || empty($business_imt) || empty($unit_address) || empty($unit_legal_name) || empty($unit_legal_number) || empty($unit_legal_imge)) {
				$a_parameter['msg'] = '信息不完整！';
				$this->error->show_error($a_parameter);
			}
			//验证手机号码格式是否正确
	        $check_user_phone = preg_match("/^1[34578]\d{9}$/", $phone);
	        if (!$check_user_phone) {
	        	$a_parameter['msg'] = '手机号码有误';
				$this->error->show_error($a_parameter);
	        }
			// 验证验证码是否正确
			if ($phone_code != $_SESSION['code']) {
				$a_parameter['msg'] = '验证码不正确';
				$this->error->show_error($a_parameter);
			}
			//申请添加到消息表
  			$this->db->insert('messagess', ['ues' => 1, 'ues_id' => $_SESSION['user_id'], 'ues_name' => $_SESSION['user_name'], 'content' => '资质申请', 'examine' => 1, 'mess_time' => $_SERVER['REQUEST_TIME']]);
		}
		$a_tert = [
			'user_id'          => $_SESSION['user_id'],
			'phone'            => $phone,
			'business_imge'    => $business_imge,
			'business_hao'     => $business_hao,
			'business_name'    => $business_name,
			'business_imt'     => $business_imt,
			'applicant'		   => $applicant,
			'unit_province'    => $unit_province,
			'unit_city'        => $unit_city,
			'unit_district'    => $unit_district,
			'unit_address'     => $unit_address,
			'unit_legal_name'  => $unit_legal_name,
			'unit_legal_number'=> $unit_legal_number,
			'unit_legal_imge'  => $unit_legal_imge,
			'applicant_name'   => $applicant_name,
			'applicant_number' => $applicant_number,
			'applicant_imge'   => $applicant_imge,
			'audit'            => $audit,
			'add_time'         => $_SERVER['REQUEST_TIME'],
		];
		$i_result = $this->db->insert('qualifi', $a_tert);
		if ($i_result) {
			$a_parameter['msg'] = '提交成功';
			$this->error->show_success($a_parameter);
		} else {
			$a_parameter['msg'] = '提交失败';
			$this->error->show_error($a_parameter);
		}
	}

	//资质申请修改
	public function qualifi_up() {
		$audit         =  $this->router->get(1);
		$phone         = $this->general->post('phone');
		$i_id          = $this->general->post('id');
		$business_imge = $this->general->post('business_imge');
		$business_hao  = $this->general->post('business_hao');
		$business_name = $this->general->post('business_name');
		$business_imt  = $this->general->post('business_imt');
		$applicant     = $this->general->post('applicant');
		$unit_province = $this->general->post('unit_province');
		$unit_city     = $this->general->post('unit_city');
		$unit_district = $this->general->post('unit_district');
		$unit_address  = $this->general->post('unit_address');
		$unit_legal_name  = $this->general->post('unit_legal_name');
		$unit_legal_number = $this->general->post('unit_legal_number');
		$unit_legal_imge  = $this->general->post('unit_legal_imge');
		$applicant_name   = $this->general->post('applicant_name');
		$applicant_number = $this->general->post('applicant_number');
		$applicant_imge = $this->general->post('applicant_imge');
		$phone_code     = $this->general->post('phone_code');
		$a_parameter = [
			'msg'      => '验证码不正确',
			'url'      => 'audit',
			'log'      => false,
			'wait'     => 2,
		];
		if ($audit == 1) {
			$audit = 5;
		} else {
			$audit = 1;
			//验证数据合法性
			if (empty($phone) || empty($business_imge) || empty($business_hao) || empty($business_name) || empty($business_imt) || empty($unit_address) || empty($unit_legal_name) || empty($unit_legal_number) || empty($unit_legal_imge)) {
				$a_parameter['msg'] = '信息不完整！';
				$this->error->show_error($a_parameter);
			}
			//验证手机号码格式是否正确
	        $check_user_phone = preg_match("/^1[34578]\d{9}$/", $phone);
	        if (!$check_user_phone) {
	        	$a_parameter['msg'] = '手机号码有误';
				$this->error->show_error($a_parameter);
	        }
			// 验证验证码是否正确
			if ($phone_code != $_SESSION['code']) {
				$a_parameter['msg'] = '验证码不正确';
				$this->error->show_error($a_parameter);
			}
			//申请添加到消息表
  			$this->db->insert('messagess', ['ues' => 1, 'ues_id' => $_SESSION['user_id'], 'ues_name' => $_SESSION['user_name'], 'content' => '资质申请', 'examine' => 1, 'mess_time' => $_SERVER['REQUEST_TIME']]);
		}
		$a_tert = [
			'phone'            => $phone,
			'business_imge'    => $business_imge,
			'business_hao'     => $business_hao,
			'business_name'    => $business_name,
			'business_imt'     => $business_imt,
			'applicant'		   => $applicant,
			'unit_province'    => $unit_province,
			'unit_city'        => $unit_city,
			'unit_district'    => $unit_district,
			'unit_address'     => $unit_address,
			'unit_legal_name'  => $unit_legal_name,
			'unit_legal_number'=> $unit_legal_number,
			'unit_legal_imge'  => $unit_legal_imge,
			'applicant_name'   => $applicant_name,
			'applicant_number' => $applicant_number,
			'applicant_imge'   => $applicant_imge,
			'audit'            => $audit,
			'add_time'         => $_SERVER['REQUEST_TIME'],
		];
		$i_result = $this->db->update('qualifi', $a_tert, ['user_id' => $_SESSION['user_id'], 'qua_id' => $i_id]);
		if ($i_result) {
			$a_parameter['msg'] = '提交成功';
			$this->error->show_success($a_parameter);
		} else {
			$a_parameter['msg'] = '提交失败';
			$this->error->show_error($a_parameter);
		}
	}

	//分享产品添加
	public function share_goods() {
		$product_name  = $this->general->post('product_name');
		$price         = $this->general->post('price');
		$goods_license = $this->general->post('goods_license');
		$pro_details   = $this->general->post('pro_details');
		$join_province = $this->general->post('join_province');
		$join_city     = $this->general->post('join_city');
		$join_district = $this->general->post('join_district');
		$addre         = $this->general->post('addre');
		$distribution  = $this->general->post('distribution');
		$proid_id_1    = $this->general->post('proid_id_1');
		$proid_id_2    = $this->general->post('proid_id_2');
		$proid_id_3    = $this->general->post('proid_id_3');
		$pro_img       = $this->general->post('pro_img');
		//验证数据合法性
		$a_parameter = [
			'msg'      => '验证码不正确',
			'url'      => 'share_goods_list',
			'log'      => false,
			'wait'     => 2,
		];
		if (empty($goods_license) || empty($addre) || empty($distribution) || empty($proid_id_1) || empty($product_name) || empty($pro_details) || empty($price)) {
			$a_parameter['msg'] = '信息不完整！';
			$this->error->show_error($a_parameter);
		}
		// 上传动态图片
		if (!empty($_FILES['file']['name'])) {
			$file    = $_FILES['file'];
			$allow   = array('image/jpeg','image/jpg','image/png');
			$path    = 'upload/share';
			$maxsize = 1048576;
            for ($i=0; $i < count($_FILES['file']['name']); $i++) {
                $files[$i]['name']     = $file['name'][$i];
                $files[$i]['type']     = $file['type'][$i];
                $files[$i]['tmp_name'] = $file['tmp_name'][$i];
                $files[$i]['error']    = $file['error'][$i];
                $files[$i]['size']     = $file['size'][$i];
            }
            for ($i=0; $i<count($files); $i++) {
                if ($files[$i]['error'] == 0) {
					$file     = $files[$i];
					$img_path = $this->upload_model->upload_img($file, $allow, $error, $path, $maxsize);
					if ($img_path) {
						$names[] = $img_path;
					}
					// 设置主图
					if ($files[$i]['name'] == $pro_img) {
						$mainpic_path = $img_path;
					}
                }
            }
            if (!empty($names)) {
            	if (isset($mainpic_path) && !empty($mainpic_path)) {
            		$pro_img = $mainpic_path;
            	} else {
            		$pro_img = $names[0];
            	}
            	$comment_pic = implode(',', $names);
            } else {
            	$pro_img = '';
            	$comment_pic = '';
            }
		} else {
			$pro_img = '';
			$comment_pic = '';
		}
		$a_dauon = $this->db->get_row('product', '', ['order'], ['order' => 'desc']);
		// 加入产品列表
		$a_produ = [
			'proid_id_1'   => $proid_id_1,
			'proid_id_2'   => $proid_id_2,
			'proid_id_3'   => $proid_id_3,
			'product_name' => $product_name,
			'pro_details'  => $pro_details,
			'pro_image'    => $comment_pic,
			'pro_img'      => $pro_img,
			'goods_stye'   => 2,
			'pro_show'     => 2,
			'order'        => $a_dauon[0]+1,
		];
		$product = $this->db->insert('product', $a_produ);
		// 价格表
		$price   = $this->db->insert('price', ['product_id' => $product, 'price' => $price]);
		// 分享产品申请
		$a_goode = [
			'user_id'       => $_SESSION['user_id'],
			'product_id'    => $product,
			'goods_license' => $goods_license,
			'join_province' => $join_province,
			'join_city'     => $join_city,
			'join_district' => $join_district,
			'addre'         => $addre,
			'distribution'  => $distribution,
			'state'         => 1,
			'apply_time'    => $_SERVER['REQUEST_TIME'],
		];
		$i_result = $this->db->insert('qualifi_goods', $a_goode);
		if ($i_result) {
			//申请添加到消息表
  			$this->db->insert('messagess', ['ues' => 1, 'ues_id' => $_SESSION['user_id'], 'ues_name' => $_SESSION['user_name'], 'content' => '分享产品申请', 'examine' => 1, 'mess_time' => $_SERVER['REQUEST_TIME']]);
			$a_parameter['msg'] = '提交成功';
			$this->error->show_success($a_parameter);
		} else {
			$a_parameter['msg'] = '提交失败';
			$this->error->show_error($a_parameter);
		}
	}

	//分享产品修改
	public function share_goods_up() {
		$i_id          = $this->general->post('id');
		$product_name  = $this->general->post('product_name');
		$price         = $this->general->post('price');
		$goods_license = $this->general->post('goods_license');
		$pro_details   = $this->general->post('pro_details');
		$join_province = $this->general->post('join_province');
		$join_city     = $this->general->post('join_city');
		$join_district = $this->general->post('join_district');
		$addre         = $this->general->post('addre');
		$distribution  = $this->general->post('distribution');
		$proid_id_1    = $this->general->post('proid_id_1');
		$proid_id_2    = $this->general->post('proid_id_2');
		$proid_id_3    = $this->general->post('proid_id_3');
		$pro_img       = $this->general->post('pro_img');
		//验证数据合法性
		$a_parameter = [
			'msg'      => '验证码不正确',
			'url'      => 'share_goods_list',
			'log'      => false,
			'wait'     => 2,
		];
		if (empty($goods_license) || empty($addre) || empty($distribution) || empty($proid_id_1) || empty($product_name) || empty($pro_details) || empty($price)) {
			$a_parameter['msg'] = '信息不完整！';
			$this->error->show_error($a_parameter);
		}
		// 上传动态图片
		if (!empty($_FILES['file']['name'])) {
			$file    = $_FILES['file'];
			$allow   = array('image/jpeg','image/jpg','image/png');
			$path    = 'upload/share';
			$maxsize = 1048576;
            for ($i=0; $i < count($_FILES['file']['name']); $i++) {
                $files[$i]['name']     = $file['name'][$i];
                $files[$i]['type']     = $file['type'][$i];
                $files[$i]['tmp_name'] = $file['tmp_name'][$i];
                $files[$i]['error']    = $file['error'][$i];
                $files[$i]['size']     = $file['size'][$i];
            }
            for ($i=0; $i<count($files); $i++) {
                if ($files[$i]['error'] == 0) {
					$file     = $files[$i];
					$img_path = $this->upload_model->upload_img($file, $allow, $error, $path, $maxsize);
					if ($img_path) {
						$names[] = $img_path;
					}
					// 设置主图
					if ($files[$i]['name'] == $pro_img) {
						$mainpic_path = $img_path;
					}
                }
            }
            if (!empty($names)) {
            	if (isset($mainpic_path)) {
            		$pro_img = $mainpic_path;
            	}
            	if (empty($pro_img)) {
            		$pro_img = $names[0];
            	}
            	$comment_pic = implode(',', $names);
            } else {
            	$pro_img = '';
            	$comment_pic = '';
            }
		} else {
			$pro_img = '';
			$comment_pic = '';
		}
		// 分享产品申请
		$a_goode = [
			'goods_license' => $goods_license,
			'join_province' => $join_province,
			'join_city'     => $join_city,
			'join_district' => $join_district,
			'addre'         => $addre,
			'distribution'  => $distribution,
			'state'         => 1,
			'apply_time'    => $_SERVER['REQUEST_TIME'],
		];
		$i_result = $this->db->update('qualifi_goods', $a_goode, ['user_id' => $_SESSION['user_id'], 'goo_id'    => $i_id]);
		// 加入产品列表
		$a_produ = [
			'proid_id_1'   => $proid_id_1,
			'proid_id_2'   => $proid_id_2,
			'proid_id_3'   => $proid_id_3,
			'product_name' => $product_name,
			'pro_details'  => $pro_details,
			'pro_image'    => $comment_pic,
			'pro_img'      => $pro_img,
			'goods_stye'   => 2,
			'pro_show'     => 2,
		];
		$product = $this->db->update('product', $a_produ, ['product_id' => $i_result['product_id']]);
		// 价格表
		$price   = $this->db->update('price', ['price' => $price], ['product_id' => $i_result['product_id']]);
		if ($i_result) {
			//申请添加到消息表
  			$this->db->insert('messagess', ['ues' => 1, 'ues_id' => $_SESSION['user_id'], 'ues_name' => $_SESSION['user_name'], 'content' => '分享产品申请', 'examine' => 1, 'mess_time' => $_SERVER['REQUEST_TIME']]);
			$a_parameter['msg'] = '提交成功';
			$this->error->show_success($a_parameter);
		} else {
			$a_parameter['msg'] = '提交失败或没发生变化';
			$this->error->show_error($a_parameter);
		}
	}

	// 分享分类
	public function classification_share() {
		$a_data = $this->db->get('pro', '', '', '', 0,99999999999);
		return $a_data;
	}
}

?>