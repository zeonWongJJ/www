<?php

defined('BASEPATH') or exit('禁止访问！');

class Footprint_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('footprint_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
	}

/************************************* 足迹列表 *************************************/

	public function footprint_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 当前用户
			$user_id = $_SESSION['user_id'];
			// 获取足迹
			$a_data = $this->footprint_model->get_footprint_page($user_id, 1);
			$new_data['time'] = array();
			foreach ($a_data as $key => $value) {
				$todaystart = mktime(0, 0, 0, date('m', $value['footprint_time']), date('d', $value['footprint_time']), date('Y', $value['footprint_time']));
				if (!in_array($todaystart, $new_data['time'])) {
					$new_data['time'][] = $todaystart;
				}
			}
			if (!empty($a_data)) {
				foreach ($a_data as $key => $value) {
					if ($value['footprint_type'] == 2) {
						// 获取办公室
						$a_office = $this->footprint_model->get_office_one($value['object_id']);
						$value['room_name']    = $a_office['room_name'];
						$value['room_size']    = $a_office['room_size'];
						$value['room_seat']    = $a_office['room_seat'];
						if (!empty($a_office['room_mainpic'])) {
							$value['room_mainpic'] = get_config_item('wofei_admin').$a_office['room_mainpic'];
						} else {
							$value['room_mainpic'] = '';
						}
						// 获取设备
						if (!empty($a_office['device_ids'])) {
							$device_ids = explode(',', $a_office['device_ids']);
						} else {
							$device_ids = array();
						}
						$a_device = $this->footprint_model->get_room_device($device_ids);
						if (!empty($a_device)) {
							$device_arr = array();
							foreach ($a_device as $k => $v) {
								$device_arr[] = $v['device_name'];
							}
							$value['room_device'] = implode(',', $device_arr);
						} else {
							$value['device'] = '';
						}
					} else {
						// 获取产品
						$a_product = $this->footprint_model->get_product_one($value['object_id']);
						$value['product_name'] = $a_product['product_name'];
						$subject = strip_tags($a_product['pro_details']); // 去除html标签
						$pattern = '/\s/'; // 去除空白
						$content = preg_replace($pattern, '', $subject);
						$seodata = mb_substr($content, 0, 60); // 截取60个汉字
						$value['pro_details'] = $seodata;
						$value['pro_img']     = $a_product['pro_img'];
						if (!empty($a_product['pro_img'])) {
							$value['pro_img'] = get_config_item('wofei_admin').$a_product['pro_img'];
						} else {
							$value['pro_img'] = '';
						}
						$value['gourl'] = $this->router->url('item',['pid'=>$a_product['proid_id_1'],'product_id'=>$a_product['product_id'],'store_id'=>'0']);
					}
					$value['footprint_time'] = mktime(0, 0, 0, date('m', $value['footprint_time']), date('d', $value['footprint_time']), date('Y', $value['footprint_time']));
					$new_data['footprint'][] = $value;
				}
			}
			$this->view->display('footprint_showlist', $new_data);
		}
	}

/************************************* 删除足迹 *************************************/

	public function footprint_delete() {
		// 接收需要删除的id数组
		$del_arr = $this->general->post('del_arr');
		$i_result = $this->footprint_model->delete_footprint($del_arr);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
		}
	}

/************************************* 获取更多 *************************************/

	public function footprint_getmore() {
		$page = $this->general->post('page');
		// 当前用户
		$user_id = $_SESSION['user_id'];
		// 获取足迹
		$a_data = $this->footprint_model->get_footprint_page($user_id, $page);
		$new_data['time'] = array();
		foreach ($a_data as $key => $value) {
			if (!in_array(date('m月d日', $value['footprint_time']), $new_data['time'])) {
				$new_data['time'][] = date('m月d日', $value['footprint_time']);
			}
		}
		if (!empty($a_data)) {
			foreach ($a_data as $key => $value) {
				$value['footprint_time'] = date('m月d日', $value['footprint_time']);
				if ($value['footprint_type'] == 2) {
					// 获取办公室
					$a_office = $this->footprint_model->get_office_one($value['object_id']);
					$value['room_name']    = $a_office['room_name'];
					$value['room_size']    = $a_office['room_size'];
					$value['room_seat']    = $a_office['room_seat'];
					if (!empty($a_office['room_mainpic'])) {
						$value['room_mainpic'] = get_config_item('wofei_admin').$a_office['room_mainpic'];
					} else {
						$value['room_mainpic'] = '';
					}
					// 获取设备
					if (!empty($a_office['device_ids'])) {
						$device_ids = explode(',', $a_office['device_ids']);
					} else {
						$device_ids = array();
					}
					$a_device = $this->footprint_model->get_room_device($device_ids);
					if (!empty($a_device)) {
						$device_arr = array();
						foreach ($a_device as $k => $v) {
							$device_arr[] = $v['device_name'];
						}
						$value['room_device'] = implode(',', $device_arr);
					} else {
						$value['device'] = '';
					}
				} else {
					// 获取产品
					$a_product = $this->footprint_model->get_product_one($value['object_id']);
					$value['product_name'] = $a_product['product_name'];
					$subject = strip_tags($a_product['pro_details']); // 去除html标签
					$pattern = '/\s/'; // 去除空白
					$content = preg_replace($pattern, '', $subject);
					$seodata = mb_substr($content, 0, 60); // 截取60个汉字
					$value['pro_details'] = $seodata;
					$value['pro_img']     = $a_product['pro_img'];
				}
				$new_data['footprint'][] = $value;
			}
			echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$new_data));
			die;
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'没有更多数据了', 'data'=>''));
			die;
		}
	}

/************************************* 获取更多 *************************************/

	public function footprint_add() {
		$i_type  = $this->general->post('type');
		$i_goods = $this->general->post('goods');
		$a_data  = $this->db->get_row('footprint', ['footprint_type' => $i_type, 'object_id' => $i_goods, 'user_id' => $_SESSION['user_id']]);
		if (empty($a_data)) {
			$a_dtay = [
				'footprint_type' => $i_type,
				'object_id' => $i_goods,
				'user_id' => $_SESSION['user_id'],
				'footprint_time' => $_SERVER['REQUEST_TIME'],
			];
			$this->db->insert('footprint', $a_dtay);
		} else {
			$this->db->update('footprint', ['footprint_time' => $_SERVER['REQUEST_TIME']], ['footprint_type' => $i_type,'object_id' => $i_goods,'user_id' => $_SESSION['user_id']]);
		}
	}

/************************************************************************************/

}

?>