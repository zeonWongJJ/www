<?php
defined('BASEPATH') or exit('禁止访问！');

class Collection_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('collection_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
	}

/************************************* 收藏列表 *************************************/

	public function collection_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 当前用户
			$user_id = $_SESSION['user_id'];
			// 获取用户收藏的办公室
			$a_data['office'] = $this->collection_model->get_collection_office($user_id, 1);
			// 获取办公室设备
			if (!empty($a_data['office'])) {
				foreach ($a_data['office'] as $key => $value) {
					$device_ids = explode(',', $value['device_ids']);
					// 获取办公室设备
					$a_device = $this->collection_model->get_device_office($device_ids);
					$device_arr = array();
					foreach ($a_device as $k => $v) {
						$device_arr[] = $v['device_name'];
					}
					if (!empty($device_arr)) {
						$value['room_device'] = implode(',', $device_arr);
					} else {
						$value['room_device'] = '';
					}
					$new_data[] = $value;
				}
				$a_data['office'] = $new_data;
			} else {
				$a_data['office'] = array();
			}
			// 获取用户收藏的门店
			$a_data['store'] = $this->collection_model->get_collection_store($user_id, 1);
			// 获取用户收藏的产品
			$a_data['goods'] = $this->collection_model->get_collection_goods($user_id, 1);
			$this->view->display('collection_showlist', $a_data);
		}
	}

/************************************* 删除收藏 *************************************/

	// 门店和房间删除
	public function collection_delete() {
		// 接收需要删除的id数组
		$del_arr = $this->general->post('del_arr');
		$i_result = $this->collection_model->delete_collection($del_arr);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
		}
	}

/******************************* 获取更多收藏的办公室 *******************************/

	public function collection_offgetmore() {
		$user_id = $_SESSION['user_id'];
		$page = $this->general->post('page');
		$a_data = $this->collection_model->get_collection_office($user_id, $page);
		if (empty($a_data)) {
			echo json_encode(array('code'=>400,'msg'=>'没有更多数据了', 'data'=>''));
		} else {
			foreach ($a_data as $key => $value) {
				$device_ids = explode(',', $value['device_ids']);
				// 获取办公室设备
				$a_device = $this->collection_model->get_device_office($device_ids);
				$device_arr = array();
				foreach ($a_device as $k => $v) {
					$device_arr[] = $v['device_name'];
				}
				if (!empty($device_arr)) {
					$value['room_device'] = implode(',', $device_arr);
				} else {
					$value['room_device'] = '';
				}
				if (empty($value['room_mainpic'])) {
					$value['room_mainpic'] = '<img src="static/style_default/images/tou_03.png" />';
				} else {
					$value['room_mainpic'] = '<img src="'.get_config_item('wofei_admin').$value['room_mainpic'].'">';
				}
				$new_data[] = $value;
			}
			echo json_encode(array('code'=>200,'msg'=>'获取成功', 'data'=>$new_data));
		}
	}

/******************************* 获取更多收藏的产品 *******************************/

	public function collection_goods() {
		$user_id = $_SESSION['user_id'];
		$page = $this->general->post('page');
		$a_data = $this->collection_model->get_collection_goods($user_id, $page);
		if (empty($a_data)) {
			echo json_encode(array('code'=>400,'msg'=>'没有更多数据了', 'data'=>''));
		} else {
			foreach ($a_data as $key => $value) {
				$new_data[] = $value;
			}
			echo json_encode(array('code'=>200,'msg'=>'获取成功', 'data'=>$new_data));
		}
	}

/******************************** 获取更多收藏的门店 ********************************/

	public function collection_storegetmore() {
		$user_id = $_SESSION['user_id'];
		$page = $this->general->post('page');
		$a_data= $this->collection_model->get_collection_store($user_id, $page);
		if (empty($a_data)) {
			echo json_encode(array('code'=>400,'msg'=>'没有更多数据了', 'data'=>''));
		} else {
			foreach ($a_data as $key => $value) {
		        if (empty($value['store_touxiang'])) {
		            $value['store_touxiang'] = '<img src="static/style_default/images/tou_03.png" />';
		        } else {
		            $value['store_touxiang'] = '<img src="'.get_config_item('store_touxiang').$value['store_touxiang'].'">';
		        }
		        $new_data[] = $value;
			}
			echo json_encode(array('code'=>200,'msg'=>'获取成功', 'data'=>$new_data));
		}
	}

/************************************* 添加收藏 ********************************/

	public function collection_add() {
		//收藏的对象id
		$i_id   = $this->general->post('id');
		//收藏的类型
		$i_type = $this->general->post('type');
		$cout   = explode(",", $i_id);
		foreach ($cout as $cou) {
			$a_data = $this->db->get_row('collection', ['user_id' => $_SESSION['user_id'], 'collection_type' => $i_type, 'object_id' => $cou]);
			if (empty($a_data)) {
				$a_coll = [
					'user_id' 		  => $_SESSION['user_id'],
					'collection_type' => $i_type,
					'object_id' 	  => $cou,
					'collection_time' => $_SERVER['REQUEST_TIME']
				];
				$a_coll = $this->db->insert('collection', $a_coll);
			} else {
				$this->db->delete('collection', ['collection_id' => $a_data['collection_id']]);
				$a_coll = [
					'user_id' 		  => $_SESSION['user_id'],
					'collection_type' => $i_type,
					'object_id' 	  => $cou,
					'collection_time' => $_SERVER['REQUEST_TIME']
				];
				$a_coll = $this->db->insert('collection', $a_coll);
			}
		}
		if ($a_coll) {
			echo json_encode(array('code'=>200, 'msg'=>'添加成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'添加失败'));
		}
	}

/************************************************************************************/

}

?>