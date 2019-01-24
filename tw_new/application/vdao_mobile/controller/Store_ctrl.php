<?php

class Store_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('store_model');
		$this->load->model('allow_model');
	}

/************************************* 商城下单 *************************************/
	public function order_store() {
        $appointment_type = $this->general->post('appointment_type');
        $store_id = $this->general->post('store_id');
        if ($store_id) {
            $a_data = [];
            $a_data['store'] = $this->store_model->get_store_one($store_id);
            // 获取一条办公室信息
            $a_data['office'] = $this->store_model->get_office_one($store_id);
            if ($appointment_type == 2) {
                // 订座位
                $post = $this->general->post();
                if ($post['office_seat']) {
                    // 获取选定的座位id
                    $a_data['office_seat'] = is_array($post['office_seat']) ? $post['office_seat'] : explode(',', $post['office_seat']);
                }
                if ($post['office_seatname']) {
                    // 获取选定的座位名称
                    $a_data['office_seatname'] = is_array($post['office_seatname']) ? $post['office_seatname'] : explode(',', $post['office_seatname']);
                }
                $a_data['seat_count'] = count($a_data['office_seat']);
            }
            $a_data['appointment_type'] = $appointment_type;
            $this->view->display('norder_booking', $a_data);
        }

    }

/************************************* 附近门店 *************************************/

	public function store_showlist() {
			$this->view->display('nearby_store_list');
		
	}
	//获取用户定位储存到session里
	public function get_user_location(){
		$res = array("status" => "fail");

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$lng = $this->general->post('user_lngs');
			$lat = $this->general->post('user_lats');
			if(!empty($lng) && !empty($lat)) {
				
					$_SESSION['user_lngs'] = $lng;
					$_SESSION['user_lats'] = $lat;



			} 

		}
		$res['status'] = "ok";
		echo json_encode($res);

	}


/************************************* 附近门店接口 *************************************/
	public function nearby_store_list(){
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$type = $this->general->post('type');
			$a_data = $this->store_model->new_get_stroe_nearby($citycode="020");
				foreach ($a_data as $key => $value) {
					$store_id = $value['store_id'];
					  // 获取门店所有评论
					        $a_comment = $this->store_model->get_store_comment($value['store_id']);
					        $goods_score = 0;
					        $service_score = 0;
					        foreach ($a_comment as $key => $values) {
					            $goods_score = $goods_score + $values['goods_score'];
					            $service_score = $service_score + $values['service_score'];
					        }
					        if ($goods_score > 0) {
					            $goods_scores = round($goods_score/count($a_comment),1);
					        } else {
					            $goods_scores = 5.0;
					        }
					        if ($service_score > 0) {
					            $service_scores = round($service_score/count($a_comment),1);
					        } else {
					            $service_scores = 5.0;
					        }
					$value['all_score'] = round(($goods_scores + $service_scores)/2,1);
					$value['month_sale'] = $this->store_model->get_stroe_order_sale($value['store_id']);
					 $value['set']  = $this->db->get_row('set', ['set_name' => 'user_order_freight'], ['set_parameter']);
					if (empty($value['store_mainimg'])) {
						$value['main_pic'] = get_config_item('store_touxiang').'upload/store/20180124055629958.jpg';
					} else {
						$value['main_pic'] = get_config_item('store_touxiang').$value['store_mainimg'];
					}
					//获取门店的销量产品
					$value['sale_prod'] = $this->store_model->get_stroe_prod_sale($value['store_id']);

					//门店距离
					list($f_order_longitude, $f_order_latitude) = explode(',', $value['store_position']);
					$distance = $this->store_model->get_distance($_SESSION['user_lngs'] ,$_SESSION['user_lats'] ,
						$f_order_longitude ,$f_order_latitude );
					$distance >100 ?$value['distance'] = '>50':$value['distance'] = $distance;
 					// 产品价格起
        			$value['cup']  = $this->db->limit(0, 9999999)->get('price', ['price >' => 0], '', ['price' => 'asc']);
					$new_data[] = $value;
				}
				//条件排序
				$key_arrays = array();
				switch ($type) {
					case 1:
						foreach ($new_data as $val) {
            				$key_arrays[] = $val['all_score'];
        				}	
        				array_multisort($key_arrays, SORT_DESC, SORT_NUMERIC, $new_data);
					break;
					case 2:
					foreach ($new_data as $val) {
            				$key_arrays[] = $val['transport_start'];
        				}	
        				array_multisort($key_arrays, SORT_DESC, SORT_NUMERIC, $new_data);
					break;
					case 3:
						foreach ($new_data as $val) {
            				$key_arrays[] = $val['distance'];
        				}	
        				array_multisort($key_arrays, SORT_ASC, SORT_NUMERIC, $new_data);
					break;
					case 4:
					foreach ($new_data as $val) {
            				$key_arrays[] = $val['month_sale'];
        				}	
        				array_multisort($key_arrays, SORT_DESC, SORT_NUMERIC, $new_data);
					break;
				}
			echo json_encode(array('status'=>"ok",  'data'=>$new_data));
			exit;
		}
	}
/************************************* 附近门店API *********************************/

	public function store_api() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$citycode = $this->router->get(1);
			$a_data = $this->store_model->get_stroe_nearby($citycode);
			if (empty($a_data)) {
				echo json_encode(array('code'=>400, 'msg'=>'没有任何数据', 'data'=>''));
			} else {
				foreach ($a_data as $key => $value) {
					$store_id = $value['store_id'];
					// 获取评论总条数
					$a_comment = $this->store_model->get_store_comment($store_id);
					$userpic_arr = array();
					if (!empty($a_comment)) {
						$i = 0;
						foreach ($a_comment as $k => $v) {
							$user_pic = $v['user_pic'];
							if (strpos($user_pic, 'http') === false) {
								$user_pic = get_config_item('domain') . '/' .$user_pic;
							}
							if (count($userpic_arr) < 5 && !empty($v['user_pic']) && !in_array($user_pic, $userpic_arr)) {
								$userpic_arr[] = $user_pic;
							}
						}
					}
					$value['userpic_arr'] = $userpic_arr;
					$value['comment_total'] = count($a_comment);
					$value['go_url'] = get_config_item('domain').'/list_store-'.$value['store_id'];
					if (empty($value['store_mainimg'])) {
						$value['main_pic'] = get_config_item('store_touxiang').'upload/store/20180124055629958.jpg';
					} else {
						$value['main_pic'] = get_config_item('store_touxiang').$value['store_mainimg'];
					}
					$new_data[] = $value;
				}
				echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$new_data));
			}
		}
	}

/************************************* 门店详情 *************************************/

	public function store_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收需要查看详情的门店id
			$store_id = $this->router->get(1);
			// 获取该门店信息
			$a_data['detail'] = $this->store_model->get_store_one($store_id);
			// 判断用户是否登录 如果登录判断是否收藏了门店
			if (isset($_SESSION['user_id'])) {
				// 判断是否收藏了当前门店
				$a_collection = $this->store_model->get_collection_one($store_id, $_SESSION['user_id'], 1);
				if ($a_collection) {
					$a_data['collection'] = 1;
				} else {
					$a_data['collection'] = 2;
				}
			} else {
				$a_data['collection'] = 2;
			}
			// 获取该店铺所有的评价
			$a_comment = $this->store_model->get_store_comment($store_id);
			$a_data['star'] = 0;
			foreach ($a_comment as $key => $value) {
				$a_data['star'] = $a_data['star'] + $value['goods_score'] + $value['service_score'];
			}
			if ($a_data['star'] != 0) {
				$a_data['star'] = round($a_data['star']/(count($a_comment)*2), 1);
			}
			$a_data['comment_count'] = count($a_comment);
			// 获取本月的订单
			$beginThismonth = mktime(0, 0, 0, date('m'), 1, date('Y'));
			$a_data['order_month'] = $this->store_model->get_month_order($store_id, $beginThismonth);
			// 最新的一条评论
			$a_data['comment'] = $a_comment[0];
			if ($a_data['comment']['comment_type'] == 1) {
				$a_row = $this->store_model->get_appointment_one($a_data['comment']['object_id']);
				$a_data['comment']['pname'] = $a_row['room_type'].$a_row['room_name'];
			} else {
				$a_row = $this->store_model->get_product_one($a_data['comment']['object_id']);
				$a_data['comment']['pname'] = $a_row['product_name'];
			}
			// 获取营业时间
			$a_set = $this->store_model->get_set_one('store_open_time');
			$a_data['store_open_time'] = $a_set['set_parameter'];
			// 展示页面
			$this->view->display('store_detail2', $a_data);
		}
	}

/*********************************** 新门店详情 *************************************/

	public function store_newdetail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$store_id = $this->router->get(1);
			// 获取该门店信息
			$a_data['detail'] = $this->store_model->get_store_one($store_id);
			// 判断用户是否登录 如果登录判断是否收藏了门店
			if (isset($_SESSION['user_id'])) {
				// 判断是否收藏了当前门店
				$a_collection = $this->store_model->get_collection_one($store_id, $_SESSION['user_id'], 1);
				if ($a_collection) {
					$a_data['collection'] = 1;
				} else {
					$a_data['collection'] = 2;
				}
			} else {
				$a_data['collection'] = 2;
			}
			// 获取营业时间
			$a_set = $this->store_model->get_set_one('store_open_time');
			$a_data['store_open_time'] = $a_set['set_parameter'];
			// 获取门店所有评论
			$a_comment = $this->store_model->get_store_comment($store_id);
			$goods_score = 0;
			$service_score = 0;
			foreach ($a_comment as $key => $value) {
				$goods_score = $goods_score + $value['goods_score'];
				$service_score = $service_score + $value['service_score'];
			}
			if ($goods_score != 0) {
				$a_data['goods_score'] = round($goods_score/count($a_comment),1);
			} else {
				$a_data['goods_score'] = 5.0;
			}
			if ($service_score != 0) {
				$a_data['service_score'] = round($service_score/count($a_comment),1);
			} else {
				$a_data['service_score'] = 5.0;
			}
			$a_data['all_score'] = round(($a_data['goods_score'] + $a_data['service_score'])/2,1);
			$this->view->display('store_newdetail', $a_data);
		}
	}

/******************************* 新门店评论 *********************************/

	public function store_newcomment() {
		$store_id = $this->router->get(1);
		if (empty($store_id)) {
			header("location:{$this->router->url('index')}");
		}
		// 查看咖啡评论还是办公室评论
		$comment_type = $this->router->get(2);
		if (empty($comment_type)) {
			$comment_type = 2;
		}
		// 要查看的标签
		$tag = urldecode($this->router->get(3));
		if (empty($tag)) {
			$tag = 'all';
		}
		// 获取该门店信息
		$a_data['detail'] = $this->store_model->get_store_one($store_id);
		// 判断用户是否登录 如果登录判断是否收藏了门店
		if (isset($_SESSION['user_id'])) {
			// 判断是否收藏了当前门店
			$a_collection = $this->store_model->get_collection_one($store_id, $_SESSION['user_id'], 1);
			if ($a_collection) {
				$a_data['collection'] = 1;
			} else {
				$a_data['
				'] = 2;
			}
		} else {
			$a_data['collection'] = 2;
		}
		// 获取营业时间
		$a_set = $this->store_model->get_set_one('store_open_time');
		$a_data['store_open_time'] = $a_set['set_parameter'];
		// 获取门店所有评论
		$a_comment = $this->store_model->get_store_comment($store_id);
		$goods_score = 0;
		$service_score = 0;
		foreach ($a_comment as $key => $value) {
			$goods_score = $goods_score + $value['goods_score'];
			$service_score = $service_score + $value['service_score'];
		}
		if ($goods_score != 0) {
			$a_data['goods_score'] = round($goods_score/count($a_comment),1);
		} else {
			$a_data['goods_score'] = 5.0;
		}
		if ($service_score != 0) {
			$a_data['service_score'] = round($service_score/count($a_comment),1);
		} else {
			$a_data['service_score'] = 5.0;
		}
		$a_data['all_score'] = round(($a_data['goods_score'] + $a_data['service_score'])/2,1);
		// 获取所有标签
		$a_data['comtag'] = $this->store_model->get_store_comtag($store_id, $comment_type);
		// 获取分页评论
		$a_data['comment'] = $this->store_model->get_comment_page($store_id, $comment_type, 1, $tag);
		if (!empty($a_data['comment'])) {
			foreach ($a_data['comment'] as $key => $value) {
				if ($comment_type == 2) {
					// 获取产品名
					$a_product = $this->store_model->get_product_one($value['object_id']);
					$value['proname'] = $a_product['product_name'];
				} else {
					// 获取办公室
					$a_appointment = $this->store_model->get_appointment_one($value['object_id']);
					$value['proname'] = $a_appointment['room_type'].$a_appointment['room_name'];
				}
				$new_data[] = $value;
			}
			$a_data['comment']  = $new_data;
		}
		$a_data['comment_type'] = $comment_type;
		$a_data['store_id']     = $store_id;
		$a_data['thistag']      = $tag;
		$this->view->display('store_newcomment', $a_data);
	}

/********************************* 门店评论 *********************************/

	public function store_comment() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收需要查看的门店
			$store_id = $this->router->get(1);
			if (empty($store_id)) {
				header("location:{$this->router->url('index')}");
			}
			// 查看咖啡评论还是办公室评论
			$comment_type = $this->router->get(2);
			if (empty($comment_type)) {
				$comment_type = 2;
			}
			// 要查看的标签
			$tag = urldecode($this->router->get(3));
			if (empty($tag)) {
				$tag = 'all';
			}
			// 获取一条门店信息
			$a_data['store'] = $this->store_model->get_store_one($store_id);
			// 获取门店所有评论
			$a_comment = $this->store_model->get_store_comment($store_id);
			$goods_score = 0;
			$service_score = 0;
			foreach ($a_comment as $key => $value) {
				$goods_score = $goods_score + $value['goods_score'];
				$service_score = $service_score + $value['service_score'];
			}
			if ($goods_score != 0) {
				$a_data['goods_score'] = round($goods_score/count($a_comment),1);
			} else {
				$a_data['goods_score'] = 5.0;
			}
			if ($service_score != 0) {
				$a_data['service_score'] = round($service_score/count($a_comment),1);
			} else {
				$a_data['service_score'] = 5.0;
			}
			$a_data['all_score'] = round(($a_data['goods_score'] + $a_data['service_score'])/2,1);
			// 获取所有标签
			$a_data['comtag'] = $this->store_model->get_store_comtag($store_id, $comment_type);
			// 获取分页评论
			$a_data['comment'] = $this->store_model->get_comment_page($store_id, $comment_type, 1, $tag);
			if (!empty($a_data['comment'])) {
				foreach ($a_data['comment'] as $key => $value) {
					if ($comment_type == 2) {
						// 获取产品名
						$a_product = $this->store_model->get_product_one($value['object_id']);
						$value['proname'] = $a_product['product_name'];
					} else {
						// 获取办公室
						$a_appointment = $this->store_model->get_appointment_one($value['object_id']);
						$value['proname'] = $a_appointment['room_type'].$a_appointment['room_name'];
					}
					$new_data[] = $value;
				}
				$a_data['comment']      = $new_data;
			}
			$a_data['comment_type'] = $comment_type;
			$a_data['store_id']     = $store_id;
			$a_data['thistag']      = $tag;
			$this->view->display('store_comment', $a_data);
		}
	}

/*********************************** 获取更多评论 ***********************************/

	public function storecomment_getmore() {
		$store_id     = trim($this->general->post('store_id'));
		$comment_type = trim($this->general->post('comment_type'));
		$thistag      = trim($this->general->post('thistag'));
		$page         = trim($this->general->post('page'));
		$a_data = $this->store_model->get_comment_page($store_id, $comment_type, $page, $tag);
		if (!empty($a_data)) {
			foreach ($a_data as $key => $value) {
				if ($comment_type == 2) {
					// 获取产品名
					$a_product = $this->store_model->get_product_one($value['object_id']);
					$value['proname'] = $a_product['product_name'];
				} else {
					// 获取办公室
					$a_appointment = $this->store_model->get_appointment_one($value['object_id']);
					$value['proname'] = $a_appointment['room_type'].$a_appointment['room_name'];
				}
				$value['comment_time'] = date('m-d', $value['comment_time']);
				if (!empty($value['comment_tags'])) {
					$value['comment_tags'] = str_replace(',','、', $value['comment_tags']);
				}
				$new_data[] = $value;
			}
			echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$new_data));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'没有更多数据了', 'data'=>''));
		}
	}

/********************************** 共享办公室列表 **********************************/

	public function office_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 判断是预约为会议还是座位
			$appointment_type = $this->router->get(1);
			if (empty($appointment_type)) {
				$appointment_type = 1;
			}
			$_SESSION['appointment_type'] = $appointment_type;
			// 接收门店id
			$store_id = $this->router->get(2);
			if (empty($store_id)) {
				header("location:{$this->router->url('index')}");
			}
			// 获取门店所有办公室信息
			$a_data['office'] = $this->store_model->get_office_store($store_id, $appointment_type);
			$type_arr = array();
			if (!empty($a_data['office'])) {
				foreach ($a_data['office'] as $key => $value) {
					if (!in_array($value['type_id'], $type_arr)) {
						$type_arr[] = $value['type_id'];
					}
					// 获取该办公室的所有订单
					$a_appointment = $this->store_model->get_office_appointment($value['office_id']);
					$appointment_arr = array();
					foreach ($a_appointment as $k => $v) {
						$appointment_arr[] = $v['appointment_id'];
					}
					// 获取办公室评价
					if (!empty($appointment_arr)) {
						$a_comment = $this->store_model->get_office_comment($appointment_arr, 'all');
						$star = 0;
						foreach ($a_comment as $kk => $vv) {
							$star = $star + $vv['goods_score'] + $vv['service_score'];
						}
						if ($star == 0) {
							$value['star'] = 0;
						} else {
							$value['star'] = $star/(count($a_comment)*2);
						}
					} else {
						$value['star'] = 5.0;
					}
					$value['star'] = 5.0;
					$new_data[] = $value;
				}
				$a_data['office'] = $new_data;
			} else {
				$a_data['office'] = array();
			}
			// 获取房间分类信息
			$a_data['type'] = $this->store_model->get_office_type($type_arr);
			$this->view->display('office_showlist', $a_data);
		}
	}

/********************************** 共享办公室详情 **********************************/

	public function office_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收需要查看详情的办公室id
			$office_id = $this->router->get(1);
			if (empty($office_id)) {
				header("location:{$this->router->url('index')}");
			}
			$a_office = $this->store_model->get_office_one($office_id);
			$a_store = $this->db->get_row("store",['store_id'=>$a_office['store_id']],'store_touxiang');
			$a_data['store_touxiang'] = $a_store['store_touxiang'];

			// 获取房间的详情
			$a_data['room'] = $this->store_model->get_room_one($a_office['room_id']);
			// 获取房间类型
			$a_data['type'] = $this->store_model->get_type_one($a_data['room']['type_id']);
			if ($a_data['type']['type_cate'] == 1) {
				$_SESSION['appointment_type'] = 1;
			} else {
				$_SESSION['appointment_type'] = 2;
			}
			// 获取房间设备
			if (!empty($a_data['room']['device_ids'])) {
				$device_ids = explode(',', $a_data['room']['device_ids']);
				$a_data['device'] = $this->store_model->get_room_device($device_ids);
			} else {
				$a_data['device'] = array();
			}
			// 获取该办公室的所有订单
			$a_appointment = $this->store_model->get_office_appointment($office_id);
			$appointment_arr = array();
			foreach ($a_appointment as $k => $v) {
				$appointment_arr[] = $v['appointment_id'];
			}
			// 获取办公室评价
			if (!empty($appointment_arr)) {
				// 最近预约时间
				$a_data['recentlyappoint'] = $a_appointment[0]['appointment_time'];
				// 办公室星级
				$a_comment = $this->store_model->get_office_comment($appointment_arr, 'all');
				$star = 0;
				$a_data['comtag'] = array();
				foreach ($a_comment as $kk => $vv) {
					$star = $star + $vv['goods_score'] + $vv['service_score'];
					if (!empty($vv['comment_tags'])) {
						$tag_arr = explode(',', $vv['comment_tags']);
						for ($i=0; $i < count($tag_arr); $i++) {
							if (!in_array($tag_arr[$i], $a_data['comtag'])) {
								$a_data['comtag'][] = $tag_arr[$i];
							}
						}
					}
				}
				if ($star == 0) {
					$a_data['star'] = 0;
				} else {
					$a_data['star'] = $star/(count($a_comment)*2);
				}
				$a_data['comment_total'] = count($a_comment);
			} else {
				$a_data['star'] = 5.0;
				$a_data['comment_total'] = 0;
				$a_data['recentlyappoint'] = '';
				$a_data['comtag'] = array();
			}
			$a_data['office_id'] = $office_id;
			$a_data['store_id']  = $a_office['store_id'];
			$a_data['office_price'] =$a_office['office_price'];
			// 判断用户是否收藏过此办公室
			if (isset($_SESSION['user_id'])) {
				$a_collection = $this->store_model->get_collection_one($office_id, $_SESSION['user_id'], 2);
				if ($a_collection) {
					$a_data['is_collection'] = 1;
				} else {
					$a_data['is_collection'] = 2;
				}
			} else {
				$a_data['is_collection'] = 2;
			}
			// 插入一条足迹信息
			if (isset($_SESSION['user_id'])) {
				// 判断最近是否浏览过
				$i_to = $this->store_model->get_footprint_total($_SESSION['user_id'], $office_id);
				if (empty($i_to)) {
					$a_frint_data = [
						'footprint_type' => 2,
						'object_id'      => $office_id,
						'user_id'        => $_SESSION['user_id'],
						'footprint_time' => $_SERVER['REQUEST_TIME'],
					];
					$this->store_model->insert_footprint($a_frint_data);
				}
			}
			$a_data['comment'] = $this->store_model->get_num_office_comment($appointment_arr, 3);;
			// print_r($a_data['comment']);exit;
			// 展示页面
			$this->view->display('new_office_detail', $a_data);
		}
	}

/************************************* 收藏办公室 *************************************/

	public function office_collection() {
		// 验证是否登录
		if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
			echo json_encode(array('code'=>500,'msg'=>'登录后才可以收藏哦！'));
			die;
		}
		// 接收要收藏的门店id
		$office_id = $this->general->post('office_id');
		// 验证之前是否收藏过 已收藏则取消收藏
		$a_data = $this->store_model->get_collection_one($office_id, $_SESSION['user_id'], 2);
		if (!$a_data) {
			// 插入一条收藏信息
			$a_insert_data = [
				'object_id'       => $office_id,
				'user_id'         => $_SESSION['user_id'],
				'collection_type' => 2,
				'collection_time' => $_SERVER['REQUEST_TIME'],
			];
			$i_result = $this->store_model->insert_collection($a_insert_data);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'收藏成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'收藏失败'));
			}
		} else {
			$i_result = $this->store_model->delete_collection($a_data['collection_id']);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'取消收藏成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'取消收藏失败'));
			}
		}
	}

/************************************ 办公室评价 ************************************/

	public function office_comment() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$office_id = $this->router->get(1);
			if (empty($office_id)) {
				header("localtion:{$this->router->url('index')}");
			}
			// 接收关键词
			$tag = urldecode($this->router->get(2));
			if (empty($tag)) {
				$tag = 'all';
			}
			// 获取一条办公室信息
			$a_office = $this->store_model->get_office_one($office_id);
			// 获取一条房间信息
			$a_data['room'] = $this->store_model->get_room_one($a_office['room_id']);
			// 获取一条分类信息
			$a_data['roomtype'] = $this->store_model->get_type_one($a_data['room']['type_id']);
			// 获取该办公室的所有订单
			$a_appointment = $this->store_model->get_office_appointment($office_id);
			$appointment_arr = array();
			foreach ($a_appointment as $k => $v) {
				$appointment_arr[] = $v['appointment_id'];
			}
			// 获取办公室评价
			if (!empty($a_appointment)) {
				$a_data['comment'] = $this->store_model->get_office_comment($appointment_arr, $tag);
				// 获取有图评价的总条数
				$a_tu = $this->store_model->get_office_comment($appointment_arr, 'tu');
				$a_data['tu_count'] = count($a_tu);
			} else {
				$a_data['comment'] = array();
				$a_data['tu_count'] = 0;
			}
			// 获取办公室标签
			$a_data['comtag'] = $this->store_model->get_office_comtag($a_office['store_id']);
			// 当前标签
			$a_data['thistag'] = $tag;
			$a_data['office_id'] = $office_id;
			$this->view->display('office_comment', $a_data);
		}
	}

/************************************ 预约办公室 ************************************/

	//验证用户是否有权预约办公室
	public function order_office_allow() {
		//验证是否登录
		if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
			echo json_encode(array('code'=>500,'msg'=>'请登录后再操作'));
			die;
		}
		$user_id = $_SESSION['user_id'];
		//获取一条用户信息
		$a_data = $this->store_model->get_user_one($user_id);
		//获取预约办公室资格所需的消费金额
		$a_set = $this->store_model->get_set_appointment();
		if ($a_data['user_consume'] >= $a_set['set_parameter']) {
			echo json_encode(array('code'=>200,'msg'=>'可以申请房间'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'消费额度不足'.$a_set['set_parameter'].',无法申请房间'));
		}
	}

/************************************ 预约办公室 ************************************/

	public function office_appoint() {
		// 验证是否登录
		$this->allow_model->is_login();
		// 处理请求
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收参数
			$office_id        = trim($this->general->post('office_id'));
			$beginseat        = trim($this->general->post('beginseat'));
			$endseat          = trim($this->general->post('endseat'));
			$linkman          = trim($this->general->post('linkman'));
			$link_phone       = trim($this->general->post('link_phone'));
			$code             = trim($this->general->post('code'));
			$pay_type         = trim($this->general->post('pay_type'));
			$actual_pay       = trim($this->general->post('actual_pay'));
			$appointment_type = trim($this->general->post('appointment_type'));
			// 安全验证
			if (empty($office_id)) {
				header("localtion:{$this->router->url('index')}");
			}
			// 组装信息
			$a_data['orderinfo'] = [
				'office_id'        => $office_id,
				'beginseat'        => $beginseat,
				'endseat'          => $endseat,
				'linkman'          => $linkman,
				'link_phone'       => $link_phone,
				'code'             => $code,
				'pay_type'         => $pay_type,
				'actual_pay'       => $actual_pay,
				'appointment_type' => $appointment_type,
			];
			// 获取办公室信息
			$a_data['office'] = $this->store_model->get_office_one($office_id);
			// 获取一条房间信息
			$a_data['room'] = $this->store_model->get_room_one($a_data['office']['room_id']);
			// 获取一条分类信息
			$a_data['roomtype'] = $this->store_model->get_type_one($a_data['room']['type_id']);
			// 办公室平面图
			if (!empty($a_data['office']['office_plan'])) {
				$a_data['plan'] = explode('-', $a_data['office']['office_plan']);
			} else {
				$a_data['plan'] = array();
			}
			// 办公室座位名称
			if (!empty($a_data['office']['office_seatname'])) {
				$a_data['seatname'] = explode('-', $a_data['office']['office_seatname']);
			} else {
				$a_data['seatname'] = array();
			}
			// 获取已被占用的座位
			$a_data['occupy'] = $this->store_model->get_seat_occupy($office_id);
			if (!empty($a_data['occupy'])) {
				foreach ($a_data['occupy'] as $key => $value) {
					$new_data[] = $value['office_seat'];
				}
				$a_data['occupy'] = implode(',', $new_data);
			} else {
				$a_data['occupy'] = '';
			}
//			 var_dump($a_data);exit;
			// 展示选座的页面
			$this->view->display('office_selectseat', $a_data);
		} else {
			// 接收办公室id
			$office_id = $this->router->get(1);
			if (empty($office_id)) {
				header("localtion:{$this->router->url('index')}");
			}
			// 获取一条办公室信息
			$a_data['office'] = $this->store_model->get_office_one($office_id);
			// 获取一条房间信息
			$a_data['room'] = $this->store_model->get_room_one($a_data['office']['room_id']);
			// 获取一条门店信息
			$a_data['store'] = $this->store_model->get_store_one($a_data['office']['store_id']);
			// 获取一条分类信息
			$a_data['roomtype'] = $this->store_model->get_type_one($a_data['room']['type_id']);
            // 获取今日结束时间戳
            $todayend = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y'))-1;
            // 当前时间戳
            $thistime = time();
            if (date('i', $thistime) < 30) {
            	$thistime = mktime(date('H'), 30, 0, date('m'), date('d'), date('Y'));
            } else {
            	$thistime = mktime(date('H')+1, 0, 0, date('m'), date('d'), date('Y'));
            }
			while($thistime < ($todayend-3600)) {
				$a_data['time'][] = $thistime;
				$thistime = $thistime + 1800;
			}
			// var_dump($a_data);
			$this->view->display('office_appoint', $a_data);
		}
	}

/*********************************** 预约办公室2 ************************************/

	public function office_appoint2() {
		// 验证是否登录
		$this->allow_model->is_login();
		// if (empty($_POST)) {
		// 	if ($_SESSION['appointment_type'] == 1) {
		// 		$thisurl = get_config_item('domain').'/order_office';
		// 		header("localtion:$thisurl");
		// 	} else {
		// 		$thisurl = get_config_item('domain').'/book_order';
		// 		header("localtion:$thisurl");
		// 	}
		// }
		// 接收参数
		$office_seat      = trim($this->general->post('office_seat'));
		$office_seatname  = trim($this->general->post('office_seatname'));
		$office_id        = trim($this->general->post('office_id'));
		$beginseat        = trim($this->general->post('beginseat'));
		$endseat          = trim($this->general->post('endseat'));
		$linkman          = trim($this->general->post('linkman'));
		$link_phone       = trim($this->general->post('link_phone'));
		$code             = trim($this->general->post('code'));
		$pay_type         = trim($this->general->post('pay_type'));
		$actual_pay       = trim($this->general->post('actual_pay'));
		$appointment_type = trim($this->general->post('appointment_type'));
		// 组装信息
		$a_data['orderinfo'] = [
			'office_seat'      => $office_seat,
			'office_seatname'  => $office_seatname,
			'office_id'        => $office_id,
			'beginseat'        => $beginseat,
			'endseat'          => $endseat,
			'linkman'          => $linkman,
			'link_phone'       => $link_phone,
			'code'             => $code,
			'pay_type'         => $pay_type,
			'actual_pay'       => $actual_pay,
			'appointment_type' => $appointment_type,
		];
		// 获取一条办公室信息
		$a_data['office'] = $this->store_model->get_office_one($office_id);
		// 获取一条房间信息
		$a_data['room'] = $this->store_model->get_room_one($a_data['office']['room_id']);
		// 获取一条门店信息
		$a_data['store'] = $this->store_model->get_store_one($a_data['office']['store_id']);
		// 获取一条分类信息
		$a_data['roomtype'] = $this->store_model->get_type_one($a_data['room']['type_id']);
        // 获取今日结束时间戳
        $todayend = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y'))-1;
        // 当前时间戳
        $thistime = time();
        if (date('i', $thistime) < 30) {
        	$thistime = mktime(date('H'), 30, 0, date('m'), date('d'), date('Y'));
        } else {
        	$thistime = mktime(date('H')+1, 0, 0, date('m'), date('d'), date('Y'));
        }
		while($thistime < ($todayend-3600)) {
			$a_data['time'][] = $thistime;
			$thistime = $thistime + 1800;
		}

		$this->view->display('office_appoint2', $a_data);
//        $this->view->display('norder_booking', $a_data);
	}

/*********************************** 预约办公室3 ************************************/

	public function office_appoint3() {
		$this->allow_model->is_login();
		if (empty($_POST)) {
			if ($_SESSION['appointment_type'] == 1) {
				$thisurl = get_config_item('domain').'/order_office';
				header("localtion:$thisurl");
			} else {
				$thisurl = get_config_item('domain').'/book_order';
				header("localtion:$thisurl");
			}
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$come_source = trim($this->general->post('come_source'));
			if ($come_source == 3 || $come_source == 4) {
				if ($come_source == 3) {
					$_SESSION['appointment_type'] = 1;
				} else {
					$_SESSION['appointment_type'] = 2;
				}
				$appointment_id = trim($this->general->post('appointment_id'));
				$pay_type       = trim($this->general->post('pay_type'));
				// 获取一条预约信息
				$a_appointment = $this->store_model->get_appointment_one($appointment_id);
				if ($a_appointment['appointment_state'] > 0) {
					$i_result = 0;
				} else {
					$i_result = 1;
				}
				$appointment_number = $a_appointment['appointment_number'];
				$actual_pay = $a_appointment['actual_pay'];
			} else {
				// 接收参数
				$office_seat     = trim($this->general->post('office_seat'));
				$office_seatname = trim($this->general->post('office_seatname'));
				$office_id       = trim($this->general->post('office_id'));
				$beginseat       = trim($this->general->post('beginseat'));
				$endseat         = trim($this->general->post('endseat'));
				$linkman         = trim($this->general->post('linkman'));
				$link_phone      = trim($this->general->post('link_phone'));
				$code            = trim($this->general->post('code'));
				$room_id         = trim($this->general->post('room_id'));
				$store_id        = trim($this->general->post('store_id'));
				$room_name       = trim($this->general->post('room_name'));
				$room_type       = trim($this->general->post('room_type'));
				$arrival_time    = date('H:i', $beginseat) . '-' . date('H:i', $endseat);

				// 有价格后修改
				$appointment_type  = trim($this->general->post('appointment_type'));
				// $appointment_price = trim($this->general->post('appointment_price'));
				$pay_type          = trim($this->general->post('pay_type'));
				// $appointment_date  = trim($this->general->post('appointment_date'));
				// $balance_deduction = trim($this->general->post('balance_deduction'));
				// $score_deduction   = trim($this->general->post('score_deduction'));
				$actual_pay        = trim($this->general->post('actual_pay'));

				// 验证数据合法性
				$a_parameter = [
					'msg'      => '必填项不能为空',
					'url'      => 'office_appoint-' . $office_id,
					'log'      => false,
					'wait'     => 2,
				];
				// 验证是否为空
				if (empty($office_id) || empty($linkman) || empty($link_phone) || empty($code)) {
					$a_parameter['msg'] = '必填项不能为空';
					$this->error->show_error($a_parameter);
				}
				// 如果是预订座位则验证座位是否为空
				if ($_SESSION['appointment_type'] == 2) {
					if (empty($office_seat) || empty($office_seatname) ) {
						$a_parameter['msg'] = '预订的座位不能为空';
						$this->error->show_error($a_parameter);
					}
				}
				// 验证是否登录
				if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
					$a_parameter['msg'] = '请登录后再操作';
					$a_parameter['url'] = 'login.html?oldurl='.$this->router->get_url();
					$this->error->show_error($a_parameter);
				}
				// 验证是否是发送验证码的手机
				if ($link_phone != $_SESSION['user_phone']) {
					$a_parameter['msg'] = '非法预约';
					$a_parameter['url'] = 'office_appoint-' . $office_id;
					$this->error->show_error($a_parameter);
				}
				// 验证验证码是否正确
				if ($code != $_SESSION['code']) {
					$a_parameter['msg'] = '验证码不正确';
					$this->error->show_error($a_parameter);
				}
				// 验证该用户是否有未完成的订单
/*				$i_ing = $this->store_model->get_appointment_mying($_SESSION['user_id']);
				if ($i_ing > 0) {
					$a_parameter['msg'] = '您有订单未完成，不可再次预约';
					$a_parameter['url'] = 'order_office';
					$this->error->show_error($a_parameter);
				}*/
				// 获取该用户的信息
				$userinfo = $this->store_model->get_user_one($_SESSION['user_id']);
				//获取预约办公室资格所需的消费金额
				// $a_set = $this->store_model->get_set_appointment();
				// if ($userinfo['user_consume'] < $a_set['set_parameter']) {
				// 	$a_parameter['msg'] = "消费额度未满" . $a_set['set_parameter'] . ",无法使用此服务";
				// 	$a_parameter['url'] = 'office_detail-'.$office_id;
				// 	$this->error->show_error($a_parameter);
				// }
				// 生成订单号
				$appointment_number = date('YmdHis',time()).rand(1111,9999);
				// 组装数据并保存到数据库
				$a_data = [
					'office_id'          => $office_id,
					'store_id'           => $store_id,
					'office_seat'        => $office_seat,
					'office_seatname'    => $office_seatname,
					'linkman'            => $linkman,
					'link_phone'         => $link_phone,
					'arrival_time'       => $arrival_time,
					'appointment_time'   => $_SERVER['REQUEST_TIME'],
					'user_id'            => $_SESSION['user_id'],
					'room_id'            => $room_id,
					'room_type'          => $room_type,
					'room_name'          => $room_name,
					'appointment_state'  => 0,
					'officeseat_state'   => 0,
					'appointment_number' => $appointment_number,
					'actual_pay'         => $actual_pay,
					'appointment_price'  => $actual_pay,
					'appointment_type'   => $appointment_type,
					'begin_time'         => $beginseat,
					'end_time'           => $endseat,
					'appointment_date'   => time(),
				];
				$i_result = $this->store_model->insert_appointment($a_data);
			}
			if ($i_result) {
				// $a_parameter['msg'] = '预约成功';
				// $a_parameter['url'] = 'order_office';
				// $this->error->show_success($a_parameter);
				// 根据选择的支付方式跳转页面
				// pay_type == 1 代表支付宝支付 为2代表微信支付 为3代表网关支付
				if ($pay_type == 1) {
					// 加载手机版支付接口类
					$this->load->library('alipay_wap');
					$a_data = [
						// 商户订单号，商户网站订单系统中唯一订单号，必填
						'out_trade_no' => $appointment_number,
						// 订单名称，必填
						'subject' => '订单支付',
						// 付款金额，必填
						// 'total_amount' => 0.01,
						'total_amount' => $actual_pay,
						// 商品描述，可空
						'body' => '订单支付',
						/** 该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，
							1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。
							该参数数值不接受小数点， 如 1.5h，可转换为 90m。
						*/
						'timeout_express' => '24h',
						// 设置是跳转到支付宝页面，还是返回执行结果，默认为前者，这里我们要设置为获取执行结果
						// 异步通知地址，当设置此参数时，将忽略配置文件中的通知地址
						'notify_url' => $this->router->url('officepay_alipaynot'),
						// 同步通知地址，当设置此参数时，将忽略配置文件中的通知地址
						'return_url' => $this->router->url('officepay_alipayret'),
					];
					// print_r($a_data);die;
					echo $a = $this->alipay_wap->pay($a_data);
				} else if ($pay_type == 2) {
					// 此处是微信支付
					$a_data = [
						// 商品描述, 必填
						'body' => '订单支付',
						// 商户订单号, 必填
						'out_trade_no' => $appointment_number,
						// 标价金额,以分为单位, 必填
						// 'total_fee' => 1,
						'total_fee' => $actual_pay*100,
						// 终端IP, 必填
						'spbill_create_ip' => $this->general->get_ip(),
						// 通知地址
						'notify_url' => $this->router->url('officepay_wxpaynot'),
						// 'notify_url' => 'http://wofei_wap.7dugo.com/recharge_wxpaynot.html',
					];
					$this->load->library('wxpay_h5', '', [$a_data]);
					$a_result = $this->wxpay_h5->pay();

					// 这里是支付链接
					// echo '<a href="' . $a_result['mweb_url'] . '">支付</a>';
					$url = $a_result['mweb_url'];
					header("location:$url");
				} else if ($pay_type == 3) {
					// 此处为银联网关支付
					$this->load->library('unionpay_geteway');
					$a_param = [
						// 订单号
						'id_order' => $appointment_number,
						// 订单金额，以分为单位
						// 'amount' => 1,
						'amount' => $actual_pay*100,
						// （选填）前台返回链接， 不传此参数将默认使用配置文件中的设置url
						'url_front' => $this->router->url('officepay_unionret'),
						// （选填）后台返回链接， 不传此参数将默认使用配置文件中的设置url
						'url_back' => $this->router->url('officepay_unionnot')
					];
					$a_result = $this->unionpay_geteway->pay($a_param);
					print_r($a_result);
				}
			} else {
				$a_parameter['msg'] = '预约失败';
				$a_parameter['url'] = 'office_detail-'.$office_id;
				$this->error->show_error($a_parameter);
			}
		}
	}

    public function office_appoint_new()
    {
        // 验证是否登录
        $this->allow_model->is_login();
        // 处理请求
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 接收参数
            $office_id = trim($this->general->post('office_id'));
            $beginseat = trim($this->general->post('beginseat'));
            $endseat = trim($this->general->post('endseat'));
            $linkman = trim($this->general->post('linkman'));
            $link_phone = trim($this->general->post('link_phone'));
            $code = trim($this->general->post('code'));
            $pay_type = trim($this->general->post('pay_type'));
            $actual_pay = trim($this->general->post('actual_pay'));
            $appointment_type = trim($this->general->post('appointment_type'));
            // 安全验证
            if (empty($office_id)) {
                header("localtion:{$this->router->url('index')}");
            }
            // 组装信息
            $a_data['orderinfo'] = [
                'office_id' => $office_id,
                'beginseat' => $beginseat,
                'endseat' => $endseat,
                'linkman' => $linkman,
                'link_phone' => $link_phone,
                'code' => $code,
                'pay_type' => $pay_type,
                'actual_pay' => $actual_pay,
                'appointment_type' => $appointment_type,
            ];
            // 获取办公室信息
            $a_data['office'] = $this->store_model->get_office_one($office_id);
            // 获取一条房间信息
            $a_data['room'] = $this->store_model->get_room_one($a_data['office']['room_id']);
            // 获取一条分类信息
            $a_data['roomtype'] = $this->store_model->get_type_one($a_data['room']['type_id']);
            // 办公室平面图
            if (!empty($a_data['office']['office_plan'])) {
                $a_data['plan'] = explode('-', $a_data['office']['office_plan']);
            } else {
                $a_data['plan'] = array();
            }
            // 办公室座位名称
            if (!empty($a_data['office']['office_seatname'])) {
                $a_data['seatname'] = explode('-', $a_data['office']['office_seatname']);
            } else {
                $a_data['seatname'] = array();
            }
            // 获取已被占用的座位
            $a_data['occupy'] = $this->store_model->get_seat_occupy($office_id);
            if (!empty($a_data['occupy'])) {
                foreach ($a_data['occupy'] as $key => $value) {
                    $new_data[] = $value['office_seat'];
                }
                $a_data['occupy'] = implode(',', $new_data);
            } else {
                $a_data['occupy'] = '';
            }
            // 展示选座的页面
            $this->view->display('office_selectseat', $a_data);
        } else {
            // 接收办公室id
            $office_id = $this->router->get(1);
            $a_data = $this->Booking($office_id);
            $a_user = $this->db->get_row("user",['user_id'=>$_SESSION['user_id']],'user_name,user_phone');
            $a_data['user_name'] = $a_user['user_name'];
            $a_data['user_phone'] = $a_user['user_phone'];

            $this->view->display('order_office_new', $a_data);

        }
    }

    public function reservation()
    {
        // 验证是否登录
        $this->allow_model->is_login();
        // 处理请求
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 接收参数
            $office_seat     = trim($this->general->post('office_seat'));
            $office_seatname = trim($this->general->post('office_seatname'));
            $office_id       = trim($this->general->post('office_id'));
            $beginseat       = trim($this->general->post('beginseat'));
            $endseat         = trim($this->general->post('endseat'));
            $linkman         = trim($this->general->post('linkman'));
            $link_phone      = trim($this->general->post('link_phone'));
            $room_id         = trim($this->general->post('room_id'));
            $store_id        = trim($this->general->post('store_id'));
            $room_name       = trim($this->general->post('room_name'));
            $room_type       = trim($this->general->post('room_type'));
            $appointment_type  = trim($this->general->post('appointment_type'));
            $pay_type          = trim($this->general->post('pay_type'));
            $actual_pay        = trim($this->general->post('actual_pay'));
            $link_leave_msg        = trim($this->general->post('link_leave_msg'));
            $arrival_time    = date('H:i', $beginseat);
            // 验证是否为空
            if (empty($office_id) || empty($linkman) || empty($link_phone) || $beginseat === '0') {
                echo json_encode(['code' => 400, 'msg' => '必填项不能为空']);
                die;
            }
            // 验证是否登录
            if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
                echo json_encode(['code' => 401, 'msg' => '请登录后再操作']);
                die;
            }

            if (strlen($link_leave_msg) > 80) {
                echo json_encode(['code' => 400, 'msg' => '留言字数不可超过80个']);
                die;
            }

            if (!preg_match("/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\\d{8}$/", $link_phone, $match)) {
                echo json_encode(['code' => 400, 'msg' => '请输入正确的手机号码']);
                die;
            }
            // 验证该用户是否有未完成的订单
            /*				$i_ing = $this->store_model->get_appointment_mying($_SESSION['user_id']);
                            if ($i_ing > 0) {
                                $a_parameter['msg'] = '您有订单未完成，不可再次预约';
                                $a_parameter['url'] = 'order_office';
                                $this->error->show_error($a_parameter);
                            }*/
            // 获取该用户的信息
            $userinfo = $this->store_model->get_user_one($_SESSION['user_id']);
            //获取预约办公室资格所需的消费金额
            // $a_set = $this->store_model->get_set_appointment();
            // if ($userinfo['user_consume'] < $a_set['set_parameter']) {
            // 	$a_parameter['msg'] = "消费额度未满" . $a_set['set_parameter'] . ",无法使用此服务";
            // 	$a_parameter['url'] = 'office_detail-'.$office_id;
            // 	$this->error->show_error($a_parameter);
            // }
            // 生成订单号
            $appointment_number = date('YmdHis',time()).rand(1111,9999);
            // 组装数据并保存到数据库
            $a_data = [
                'office_id'          => $office_id,
                'store_id'           => $store_id,
                'office_seat'        => $office_seat,
                'office_seatname'    => $office_seatname,
                'linkman'            => $linkman,
                'link_phone'         => $link_phone,
                'arrival_time'       => $arrival_time,
                'appointment_time'   => $_SERVER['REQUEST_TIME'],
                'user_id'            => $_SESSION['user_id'],
                'room_id'            => $room_id,
                'room_type'          => $room_type,
                'room_name'          => $room_name,
                'appointment_state'  => 0,
                'officeseat_state'   => 0,
                'appointment_number' => $appointment_number,
                'actual_pay'         => $actual_pay,
                'appointment_price'  => $actual_pay,
                'appointment_type'   => $appointment_type,
                'begin_time'         => $beginseat,
                'end_time'           => $endseat,
                'appointment_date'   => time(),
            ];
            $i_result = $this->store_model->insert_appointment($a_data);

            // 签名生成
            if ($i_result) {
                //订单添加成功，生成前面并返回
                $uniqid = md5(uniqid(microtime(), true));
                $sign = md5($office_id . $appointment_number . $uniqid);

                //把sign存进session
                // $_SESSION[$_SESSION['user_id'] . $_SERVER['REQUEST_TIME'] . $uniqid] = $sign;

                echo json_encode([
                    'code' => 200,
                    'msg' => '预订成功',
                    'data' => [
                        'appointment_number' => $appointment_number,
                        'uniqid' => $uniqid,
                        'office_id' => $office_id,
                        'pay_type' => $pay_type,
                        'office_order_id' => $i_result,
                        'order_sign' => $sign
                    ]
                ]);
            }
                die;
        } else {
            // 接收办公室id
            $office_id = $this->general->get('office_id');
            $office_seat = explode(',',$this->general->get('office_seat'));
            $office_seatname = explode(',',$this->general->get('office_seatname'));
            $a_data = $this->Booking($office_id);
            $a_data['appointment_type'] = $this->general->get("appointment_type");
            $a_data['office_seat'] = $office_seat;
            $a_data['office_seatname'] = $office_seatname;
            $a_user = $this->db->get_row("user",['user_id'=>$_SESSION['user_id'],'user_state'=>1],'user_name,user_phone');
            $a_data['user_name'] = $a_user['user_name']?$a_user['user_name']:$a_user['user_phone'];
            $a_data['user_phone'] = $a_user['user_phone'];
            $this->view->display('order_booking', $a_data);
        }
    }

    public function Booking($office_id)
    {
        if (empty($office_id)) {
            header("localtion:{$this->router->url('index')}");
        }
        // 获取一条办公室信息
        $a_data['office'] = $this->store_model->get_office_one($office_id);
        // 获取一条房间信息
        $a_data['room'] = $this->store_model->get_room_one($a_data['office']['room_id']);
        // 获取一条门店信息
        $a_data['store'] = $this->store_model->get_store_one($a_data['office']['store_id']);
        // 获取一条分类信息
        $a_data['roomtype'] = $this->store_model->get_type_one($a_data['room']['type_id']);
        // 获取今日结束时间戳
        $todayend = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
        // 当前时间戳
        $thistime = time();
        if (date('i', $thistime) < 30) {
            $thistime = mktime(date('H'), 30, 0, date('m'), date('d'), date('Y'));
        } else {
            $thistime = mktime(date('H') + 1, 0, 0, date('m'), date('d'), date('Y'));
        }
        while ($thistime < ($todayend - 3600)) {
            $a_data['time'][] = $thistime;
            $thistime = $thistime + 1800;
        }

        return $a_data;
    }

    /************************************ 新的预约办公室3 使用ajax请求 ************************************/

    public function office_appoint3_new()
    {
        $this->allow_model->is_login();
        if (empty($_POST)) {
            if ($_SESSION['appointment_type'] == 1) {
                $thisurl = get_config_item('domain') . '/order_office';
                header("localtion:$thisurl");
            } else {
                $thisurl = get_config_item('domain') . '/book_order';
                header("localtion:$thisurl");
            }
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $come_source = trim($this->general->post('come_source'));
            if ($come_source == 3 || $come_source == 4) {
                if ($come_source == 3) {
                    $_SESSION['appointment_type'] = 1;
                } else {
                    $_SESSION['appointment_type'] = 2;
                }
                $appointment_id = trim($this->general->post('appointment_id'));
                $pay_type = trim($this->general->post('pay_type'));
                // 获取一条预约信息
                $a_appointment = $this->store_model->get_appointment_one($appointment_id);
                if ($a_appointment['appointment_state'] > 0) {
                    $i_result = 0;
                } else {
                    $i_result = 1;
                }
                $appointment_number = $a_appointment['appointment_number'];
                $actual_pay = $a_appointment['actual_pay'];
            } else {
            	// var_dump($this->general->post());exit;
                // 接收参数
                $office_seat = trim($this->general->post('office_seat'));
                $office_seatname = trim($this->general->post('office_seatname'));
                $office_id = trim($this->general->post('office_id'));
                $beginseat = trim($this->general->post('beginseat'));
                $endseat = trim($this->general->post('endseat'));
                $linkman = trim($this->general->post('linkman'));
                $link_phone = trim($this->general->post('link_phone'));
//                $code = trim($this->general->post('code'));
                $room_id = trim($this->general->post('room_id'));
                $store_id = trim($this->general->post('store_id'));
                $room_name = trim($this->general->post('room_name'));
                $room_type = trim($this->general->post('room_type'));
                $link_leave_msg = trim($this->general->post('link_leave_msg'));
                $arrival_time = date('H:i', $beginseat) . '-' . date('H:i', $endseat);

                // 有价格后修改
                $appointment_type = trim($this->general->post('appointment_type'));
                // $appointment_price = trim($this->general->post('appointment_price'));
                $pay_type = trim($this->general->post('pay_type'));
                // $appointment_date  = trim($this->general->post('appointment_date'));
                // $balance_deduction = trim($this->general->post('balance_deduction'));
                // $score_deduction   = trim($this->general->post('score_deduction'));
                $actual_pay = trim($this->general->post('actual_pay'));
                $a_wheres = ['begin_time < ' => $beginseat , 'end_time > ' =>$beginseat ,'ishave_deduction'=> 1,'appointment_type'=>1,'officeseat_state'=>1,'office_id'=>$office_id ];
                $beging_data = $this->db->get("appointment",$a_wheres,'','',0,999999999);
                 $a_wheress = ['begin_time < ' => $endseat , 'end_time > ' =>$endseat ,'ishave_deduction'=> 1,'appointment_type'=>1,'officeseat_state'=>1,'office_id'=>$office_id];
                $end_data = $this->db->get("appointment",$a_wheress,'','',0,999999999);
                // var_dump($end_data);exit;
                if($beging_data || $end_data){
                	exit(json_encode(['code'=>400,'msg'=>'该时间段已有预约，请重新选择预约时间段!']));
                }

                if (strlen($link_leave_msg) > 80) {
                    echo json_encode(['code' => 400, 'msg' => '留言字数不可超过80个']);
                    die;
                }

                // 验证数据合法性
                $a_parameter = [
                    'msg' => '必填项不能为空',
                    'url' => 'office_appoint3_new-' . $office_id,
                    'log' => false,
                    'wait' => 2,
                ];
                // 验证是否为空
                if (empty($office_id) || empty($linkman) || empty($link_phone) || $beginseat === '0' || $endseat === '0') {
                    echo json_encode(['code' => 400, 'msg' => '必填项不能为空']);
                    die;
                }
                // 如果是预订座位则验证座位是否为空
                if ($_SESSION['appointment_type'] == 2) {
                    if (empty($office_seat) || empty($office_seatname)) {
                        echo json_encode(['code' => 400, 'msg' => '预订的座位不能为空']);
                        die;
                    }
                }

                if (!preg_match("/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\\d{8}$/", $link_phone, $match)) {
                    echo json_encode(['code' => 400, 'msg' => '请输入正确的手机号码']);
                    die;
                }
                // 验证该用户是否有未完成的订单
                /*				$i_ing = $this->store_model->get_appointment_mying($_SESSION['user_id']);
                                if ($i_ing > 0) {
                                    $a_parameter['msg'] = '您有订单未完成，不可再次预约';
                                    $a_parameter['url'] = 'order_office';
                                    $this->error->show_error($a_parameter);
                                }*/
                // 获取该用户的信息
                $userinfo = $this->store_model->get_user_one($_SESSION['user_id']);
                //获取预约办公室资格所需的消费金额
                // $a_set = $this->store_model->get_set_appointment();
                // if ($userinfo['user_consume'] < $a_set['set_parameter']) {
                // 	$a_parameter['msg'] = "消费额度未满" . $a_set['set_parameter'] . ",无法使用此服务";
                // 	$a_parameter['url'] = 'office_detail-'.$office_id;
                // 	$this->error->show_error($a_parameter);
                // }
                // 生成订单号
                $appointment_number = date('YmdHis', time()) . rand(1111, 9999);
                // 组装数据并保存到数据库
                $a_data = [
                    'office_id' => $office_id,
                    'store_id' => $store_id,
                    'office_seat' => $office_seat,
                    'office_seatname' => $office_seatname,
                    'linkman' => $linkman,
                    'link_phone' => $link_phone,
                    'arrival_time' => $arrival_time,
                    'appointment_time' => $_SERVER['REQUEST_TIME'],
                    'user_id' => $_SESSION['user_id'],
                    'room_id' => $room_id,
                    'room_type' => $room_type,
                    'room_name' => $room_name,
                    'appointment_state' => 0,
                    'officeseat_state' => 0,
                    'appointment_number' => $appointment_number,
                    'actual_pay' => $actual_pay,
                    'appointment_price' => $actual_pay,
                    'appointment_type' => 1,
                    'begin_time' => $beginseat,
                    'end_time' => $endseat,
                    'link_leave_msg' => $link_leave_msg,
                    'appointment_date' => time(),
                ];
                $i_result = $this->store_model->insert_appointment($a_data);
            }
            // 签名生成
            if ($i_result) {
                //订单添加成功，生成前面并返回
                $uniqid = md5(uniqid(microtime(), true));
                $sign = md5($office_id . $appointment_number. $uniqid);

                //把sign存进session
                // $_SESSION[$_SESSION['user_id'] . $_SERVER['REQUEST_TIME'] . $uniqid] = $sign;

                echo json_encode([
                    'code' => 200,
                    'msg' => '预订成功',
                    'data' => [
                        'appointment_number' => $appointment_number,
                        'uniqid' => $uniqid,
                        'office_id' => $office_id,
                        'pay_type' => $pay_type,
                        'office_order_id' => $i_result,
                        'order_sign'    =>  $sign
                    ]
                ]);
                die;
            } else {
                echo json_encode(['code' => 400, 'msg' => '预约失败', 'data' => ['office_id' => $office_id]]);
                die;
            }
        }
    }

    public function verfiy_order()
    {
        header('Content-type:application/json;charset=utf8');
        $uniqid = trim($this->general->post('uniqid'));
        $office_id = trim($this->general->post('office_id'));
        $appointment_number = trim($this->general->post('appointment_number'));
        $order_sign = trim($this->general->post('order_sign'));
        $office_order_id = trim($this->general->post('office_order_id'));
        $appointment_type = trim($this->general->post('appointment_type'));
        $pay_type = trim($this->general->post('pay_type'));

        $sign = md5($office_id . $appointment_number . $uniqid );

        if ($order_sign !== $sign) {
            echo json_encode(['code' => 400, 'msg' => '验证未通过', 'data' => ['office_id' => $office_id]]);
//        $this->error->show_error(['url' => 'office_appoint_new-'.$office_id, 'msg' => '验证未通过']);
        } else {
            $arr = compact('uniqid', 'office_id', 'appointment_number', 'office_id', 'office_order_id', 'pay_type','appointment_type');
            $order_params = base64_encode(serialize($arr));
            echo json_encode(['code' => 200, 'data' => $order_params]);
        }
    }

    public function office_pay()
    {
        $order_params = $this->general->get('order_params');
//        if (!$order_params)
        $order_params = unserialize(base64_decode($order_params));
        @extract($order_params);

        $actual_pay = $this->db->get_row('appointment', ['appointment_number' => $appointment_number], 'actual_pay')['actual_pay'];

        // 根据选择的支付方式跳转页面
        // pay_type == 1 代表支付宝支付 为2代表微信支付 为3代表网关支付
        if ($pay_type == 1) {
            // 加载手机版支付接口类
            $this->load->library('alipay_wap');
            $a_data = [
                // 商户订单号，商户网站订单系统中唯一订单号，必填
                'out_trade_no' => $appointment_number,
                // 订单名称，必填
                'subject' => '订单支付',
                // 付款金额，必填
                // 'total_amount' => 0.01,
                'total_amount' => $actual_pay,
                // 商品描述，可空
                'body' => '订单支付',
                /** 该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，
                 * 1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。
                 * 该参数数值不接受小数点， 如 1.5h，可转换为 90m。
                 */
                'timeout_express' => '24h',
                // 设置是跳转到支付宝页面，还是返回执行结果，默认为前者，这里我们要设置为获取执行结果
                // 异步通知地址，当设置此参数时，将忽略配置文件中的通知地址
                'notify_url' => $this->router->url('officepay_alipaynot'),
                // 同步通知地址，当设置此参数时，将忽略配置文件中的通知地址
                'return_url' => $this->router->url('officepay_alipayret-'.$appointment_type),
            ];
            // print_r($a_data);die;
            echo $this->alipay_wap->pay($a_data);
        } elseif ($pay_type == 2) {
            // 此处是微信支付
            $a_data = [
                // 商品描述, 必填
                'body' => '订单支付',
                // 商户订单号, 必填
                'out_trade_no' => $appointment_number,
                // 标价金额,以分为单位, 必填
                // 'total_fee' => 1,
                'total_fee' => (float)$actual_pay * 100,
                // 终端IP, 必填
                'spbill_create_ip' => $this->general->get_ip(),
                // 通知地址
                'notify_url' => $this->router->url('officepay_wxpaynot-'.$appointment_type),
                // 'notify_url' => 'http://wofei_wap.7dugo.com/recharge_wxpaynot.html',
            ];
            $this->load->library('wxpay_h5', '', [$a_data]);
            $a_result = $this->wxpay_h5->pay();
//            var_dump($a_result);exit;
            // 这里是支付链接
            // echo '<a href="' . $a_result['mweb_url'] . '">支付</a>';
            $url = $a_result['mweb_url'];
            header("location:$url");
   //          var_dump($this->general->get());
			// var_dump($this->general->post());
			// exit;
        } elseif ($pay_type == 3) {
            // 此处为银联网关支付
            $this->load->library('unionpay_geteway');
            $a_param = [
                // 订单号
                'id_order' => $appointment_number,
                // 订单金额，以分为单位
                // 'amount' => 1,
                'amount' => $actual_pay * 100,
                // （选填）前台返回链接， 不传此参数将默认使用配置文件中的设置url
                'url_front' => $this->router->url('officepay_unionret-'.$appointment_type),
                // （选填）后台返回链接， 不传此参数将默认使用配置文件中的设置url
                'url_back' => $this->router->url('officepay_unionnot')
            ];
            $a_result = $this->unionpay_geteway->pay($a_param);
            print_r($a_result);
        }
    }

/************************************ 支付宝同步 ************************************/

	public function officepay_alipayret() {
		$this->load->library('alipay_wap');
		// 安全验证，确认是不是支付宝返回的正确数据
		$a_parameter = [
			'msg'      => '这是提示信息',
			'url'      => '这是要跳转到的url',
			'log'      => false,
			'wait'     => 2,
		];
		$appointment_type = $this->router->get(1);
		if ($appointment_type  == 1) {
			$go_url = 'order_office';
		} else {
			$go_url = 'book_order';
		}
		if ($this->alipay_wap->verify($_GET)) {
			// 查询订单证实是否支付成功
			$a_data = [
				// 商户订单号，商户网站订单系统中唯一订单号，必填
				'out_trade_no' => $_GET['out_trade_no'],
				// 支付宝交易号，和上面的参数二选一
				'trade_no'     => '',
				'is_page'      => false
			];
			// 显示返回的查询结果
			$pay_result = $this->alipay_wap->query($a_data);
			if ($pay_result['code'] == 10000) {
				$a_parameter['msg'] = '支付成功';
				$a_parameter['url'] = $go_url;
				$this->error->show_success($a_parameter);
        	} else {
				$a_parameter['msg'] = '支付失败';
				$a_parameter['url'] = $go_url;
				$this->error->show_error($a_parameter);
        	}
		} else {
			// 没有通过验证，肯定数据有问题，不做任何处理
			$a_parameter['msg'] = '支付失败';
			$a_parameter['url'] = $go_url;
			$this->error->show_error($a_parameter);
		}
	}

/************************************ 支付宝异步 ************************************/

	public function officepay_alipaynot() {
		$this->load->library('alipay_wap');
		// 安全验证，确认是不是支付宝返回的正确数据
		if ($this->alipay_wap->verify($_POST, 'notify') && ($_POST['trade_status'] == 'TRADE_SUCCESS' || $_POST['trade_status'] == 'TRADE_FINISHED')) {
			// 支付成功后修改订单状态
			$a_order_where = [
				'appointment_number' => $_POST['out_trade_no'],
			];
			$a_order_data = [
				'pay_time'          => $_SERVER['REQUEST_TIME'],
				'pay_type'          => 1,
				'appointment_state' => 1,
				'officeseat_state'  => 1,
			];
			$i_result_order = $this->store_model->update_appointment($a_order_where, $a_order_data);
			// 获取一条订单信息
			$a_this_order = $this->store_model->get_order_bynumber($_POST['out_trade_no']);
			// 判断订单是否有积分抵扣或者余额抵扣
			$user_id = $a_this_order['user_id'];
			$a_user = $this->store_model->get_user_one($user_id);
			$ub_money = $a_this_order['balance_deduction'];
			$pl_points = $a_this_order['spend_score'];
			$score_deduction = $a_this_order['score_deduction'];
			if ($ub_money > 0) {
				// 使用了余额抵扣的业务
				$a_ubdata = [
					'ub_type'        => 2,
					'ub_money'       => $ub_money,
					'ub_balance'     => $a_user['user_balance'] - $ub_money,
					'ub_time'        => $_SERVER['REQUEST_TIME'],
					'ub_item'        => '余额抵扣',
					'ub_description' => '商品支付时使用余额抵扣了' . $ub_money. '元',
					'user_id'        => $user_id,
					'ub_number'      => $_POST['out_trade_no'],
				];
				$i_result = $this->store_model->insert_userbalance($a_ubdata);
				// 将用户的余额加上
				$a_uwhere = [
					'user_id' => $user_id,
				];
				$a_udata = [
					'user_balance' => $a_user['user_balance'] - $ub_money,
				];
				$i_uint = $this->store_model->update_user($a_uwhere, $a_udata);
			}
			if ($pl_points > 0) {
				// 使用了积分抵扣的业务
				$a_insert_data = [
					'user_id'        => $user_id,
					'user_name'      => $a_user['user_name'],
					'pl_type'        => 2,
					'pl_variation'   => $pl_points,
					'pl_score'       => $a_user['user_score'] - $pl_points,
					'pl_item'        => '积分抵扣',
					'pl_description' => '订单'. $_POST['out_trade_no']. '支付时使用积分抵扣了' . $score_deduction . '元',
					'pl_time'        => $_SERVER['REQUEST_TIME'],
					'pl_code'        => 4,
				];
				$i_result = $this->store_model->insert_points_log($a_insert_data);
				// 减少用户的积分
				$a_uuwhere = [
					'user_id' => $user_id,
				];
				$a_uudata = [
					'user_score' => $a_user['user_score'] - $pl_points,
				];
				$i_uuint = $this->store_model->update_user($a_uuwhere, $a_uudata);
			}
			// 判断是否是办公室预约，如果是则将房间设为满房状态
			if ($a_this_order['appointment_type'] == 1) {
				$a_office_where = [
					'office_id' => $a_this_order['office_id'],
				];
				$a_office_data = [
					'office_isfull' => 2
				];
				// 更新一条办公室信息
				$this->store_model->update_office($a_office_where, $a_office_data);
			}
			echo "success";
		} else {
			// 没有通过验证，肯定数据有问题，不做任何处理
		}
	}

/************************************ 微信异步 ************************************/

	public function officepay_wxpaynot() {
		// 接收微信返回的通知xml数据， 也可以用 $GLOBALS['HTTP_RAW_POST_DATA'] 获取post数据
		$s_xml = file_get_contents('php://input');
		// 加载微信支付类
		$this->load->library('wxpay_h5');
		// 把微信返回的通知xml数据转换为数组格式
		$a_data = $this->wxpay_h5->xml_to_array($s_xml);
		// 验证签名成功
		if ($this->wxpay_h5->verify($a_data)) {
			// 判断结果的状态是否为成功， 第二个参数支持：PAY/REFUND/QUERY 等，对应相应的函数
			if ($this->wxpay_h5->check($a_data, 'PAY')) {
				// 也可以用自行验证，但是需要自己查阅微信接口文档，因为不同的操作，验证参数不一样
				//if ($a_data['return_code'] == 'SUCCESS' && $a_data['result_code'] == 'SUCCESS') {

				// 处理订单逻辑，比如更新订单的状态为付款成功等

				// 支付成功后修改订单状态
				$a_order_where = [
					'appointment_number' => $a_data['out_trade_no'],
				];
				$a_order_data = [
					'pay_time'          => $_SERVER['REQUEST_TIME'],
					'pay_type'          => 2,
					'appointment_state' => 1,
					'officeseat_state'  => 1,
				];
				$i_result_order = $this->store_model->update_appointment($a_order_where, $a_order_data);
				// 获取一条订单信息
				$a_this_order = $this->store_model->get_order_bynumber($a_data['out_trade_no']);
				// 判断订单是否有积分抵扣或者余额抵扣
				$user_id = $a_this_order['user_id'];
				$a_user = $this->store_model->get_user_one($user_id);
				$ub_money = $a_this_order['balance_deduction'];
				$pl_points = $a_this_order['spend_score'];
				$score_deduction = $a_this_order['score_deduction'];
				if ($ub_money > 0) {
					// 使用了余额抵扣的业务
					$a_ubdata = [
						'ub_type'        => 2,
						'ub_money'       => $ub_money,
						'ub_balance'     => $a_user['user_balance'] - $ub_money,
						'ub_time'        => $_SERVER['REQUEST_TIME'],
						'ub_item'        => '余额抵扣',
						'ub_description' => '商品支付时使用余额抵扣了' . $ub_money. '元',
						'user_id'        => $user_id,
						'ub_number'      => $a_data['out_trade_no'],
					];
					$i_result = $this->store_model->insert_userbalance($a_ubdata);
					// 将用户的余额加上
					$a_uwhere = [
						'user_id' => $user_id,
					];
					$a_udata = [
						'user_balance' => $a_user['user_balance'] -$ub_money,
					];
					$i_uint = $this->store_model->update_user($a_uwhere, $a_udata);
				}
				if ($pl_points > 0) {
					// 使用了积分抵扣的业务
					$a_insert_data = [
						'user_id'        => $user_id,
						'user_name'      => $a_user['user_name'],
						'pl_type'        => 2,
						'pl_variation'   => $pl_points,
						'pl_score'       => $a_user['user_score'] - $pl_points,
						'pl_item'        => '积分抵现',
						'pl_description' => '订单'. $a_data['out_trade_no']. '支付时使用积分抵扣了' . $score_deduction . '元',
						'pl_time'        => $_SERVER['REQUEST_TIME'],
						'pl_code'        => 4,
					];
					$i_result = $this->store_model->insert_points_log($a_insert_data);
					// 减少用户的积分
					$a_uuwhere = [
						'user_id' => $user_id,
					];
					$a_uudata = [
						'user_score' => $a_user['user_score'] - $a_this_order['spend_score'],
					];
					$i_uuint = $this->store_model->update_user($a_uuwhere, $a_uudata);
				}
				// 通知微信，我们已经收到消息，知道付款成功了，如果不通知微信，微信会一直给我们发消息
				echo $this->wxpay_h5->success();
					$appointment_type = $this->router->get(1);
					if ($appointment_type  == 1) {
						$go_url = 'order_office';
					} else {
						$go_url = 'book_order';
					}
				$a_parameter['msg'] = '支付成功';
				$a_parameter['url'] = $go_url;
				$this->error->show_success($a_parameter);

			} else {
				// 支付结果失败，所以这里是不能更新付款状态为成功的
			}
		} else {
			// 验证签名失败，数据肯定存在问题，所以不做任何处理，无视即可
		}
	}

/************************************* 银联异步 *************************************/

	public function officepay_unionnot() {
		$this->load->library('unionpay_geteway');
		// 安全验证，确认是不是银联返回的正确数据
		if ($this->unionpay_geteway->verify($this->general->post())) {
			$a_data = $this->general->post();
			// 验证签名成功
			if ($a_data['respCode'] == '00') {
				// 把订单的状态改为已经付款成功
				// 进行交易相关的业务逻辑处理
				$a_order_where = [
				 	'appointment_number' => $a_data['orderId'],
				];
				$a_order_data = [
					'pay_time'          => $_SERVER['REQUEST_TIME'],
					'pay_type'          => 3,
					'appointment_state' => 1,
					'officeseat_state'  => 1,
				];
				$i_result_order = $this->store_model->update_appointment($a_order_where, $a_order_data);
				// 获取一条订单信息
				$a_this_order = $this->store_model->get_order_bynumber($a_data['orderId']);
				// 判断订单是否有积分抵扣或者余额抵扣
				$user_id = $a_this_order['user_id'];
				$a_user = $this->store_model->get_user_one($user_id);
				$ub_money = $a_this_order['balance_deduction'];
				$pl_points = $a_this_order['spend_score'];
				$score_deduction = $a_this_order['score_deduction'];
				if ($ub_money > 0) {
				 // 使用了余额抵扣的业务
				 $a_ubdata = [
					'ub_type'        => 2,
					'ub_money'       => $ub_money,
					'ub_balance'     => $a_user['user_balance'] - $ub_money,
					'ub_time'        => $_SERVER['REQUEST_TIME'],
					'ub_item'        => '余额抵扣',
					'ub_description' => '商品支付时使用余额抵扣了' . $ub_money. '元',
					'user_id'        => $user_id,
					'ub_number'      => $a_data['orderId'],
				 ];
				 $i_result = $this->store_model->insert_userbalance($a_ubdata);
				 // 将用户的余额加上
				 $a_uwhere = [
				   	'user_id' => $user_id,
				 ];
				 $a_udata = [
				   	'user_balance' => $a_user['user_balance'] - $ub_money,
				 ];
				 $i_uint = $this->store_model->update_user($a_uwhere, $a_udata);
				}
				if ($pl_points > 0) {
					// 使用了积分抵扣的业务
					$a_insert_data = [
						'user_id'        => $user_id,
						'user_name'      => $a_user['user_name'],
						'pl_type'        => 2,
						'pl_variation'   => $pl_points,
						'pl_score'       => $a_user['user_score'] - $pl_points,
						'pl_item'        => '积分抵现',
						'pl_description' => '订单'. $a_data['orderId']. '支付时使用积分抵扣了' . $use_points . '元',
						'pl_time'        => $_SERVER['REQUEST_TIME'],
						'pl_code'        => 4,
					];
					$i_result = $this->store_model->insert_points_log($a_insert_data);
					// 减少用户的积分
					$a_uuwhere = [
						'user_id' => $user_id,
					];
					$a_uudata = [
						'user_score' => $a_user['user_score'] - $pl_points,
					];
					$i_uuint = $this->store_model->update_user($a_uuwhere, $a_uudata);
				}
			} elseif (in_array($a_data['respCode'], ['03', '04', '05'])) {
				echo '交易处理中';
			} else {
				echo '交易失败';
			}
		} else {
			// 没有通过验证，肯定数据有问题，不做任何处理
		}
	}

/************************************* 银联同步 *************************************/

	public function officepay_unionret() {
		$this->load->library('unionpay_geteway');
		if ($_SESSION['appointment_type'] == 1) {
			$go_url = 'order_office';
		} else {
			$go_url = 'book_order';
		}
		// 安全验证，确认是不是银联返回的正确数据
		if ($this->unionpay_geteway->verify($this->general->post())) {
			$a_data = $this->general->post();
			// 验证签名成功
			if ($a_data['respCode'] == '00') {
				// 把订单的状态改为已经付款成功
				// 进行交易相关的业务逻辑处理
				$a_parameter = [
					'msg'      => '支付成功',
					'url'      => $go_url,
					'log'      => false,
					'wait'     => 2,
				];
				$this->error->show_success($a_parameter);
			} elseif (in_array($a_data['respCode'], ['03', '04', '05'])) {
				$a_parameter = [
					'msg'      => '正在处理中',
					'url'      => $go_url,
					'log'      => false,
					'wait'     => 2,
				];
				$this->error->show_error($a_parameter);
			} else {
				$a_parameter = [
					'msg'      => '支付失败',
					'url'      => $go_url,
					'log'      => false,
					'wait'     => 2,
				];
				$this->error->show_error($a_parameter);
			}
		} else {
			// 没有通过验证，肯定数据有问题，不做任何处理
		}
	}


/********************************* 添加产品到购物车 *********************************/

	public function add_cart() {
		if (empty($_SESSION['user_id'])) {
               $this->error->show_error('请先登录', 'login', '', 0);
                echo json_encode(array('code'=>500,'msg'=>'请先登录再操作'));
                die;
            }
            $i_id   = $this->general->post('id');
            $i_ouan = $this->general->post('ouan');
            $i_store_id = $this->general->post('store_id');
            $a_name = $this->general->post('name');
            $i_spec = $this->general->post('spec');
            $i_swee = $this->general->post('swee');
            $i_temp = $this->general->post('temp');
            print_r($_POST);
            if( empty($i_ouan)) {
                $i_ouan = 1;
            }
            $a_res = $this->db->get_row('cart', ['user_id' => $_SESSION['user_id'], 'product_id' => $i_id, 'spec' => $i_spec, 'swee' => $i_swee, 'temp' => $i_temp]);
            //查询购物车表中是否已经存在了改商品，如果存在更新跟购物车该字段的数量,如果不存在查询出商品插入到购物车中
            if($a_res == false) {
                $i_goodsnum = $i_ouan;
                $a_data  = $this->db->get_row('product', ['product_id' => $i_id]);
                $a_price = $this->db->get_row('price', ['price_id' => $i_spec]);
                $a_where = ['product_id' => $a_data['product_id'],
                            'product_name' => $a_data['prot_name'],
                            'store_id' => $i_store_id,
                            'store_name' => $a_name,
                            'spec' => $i_spec,
                            'swee' => $i_swee,
                            'temp' => $i_temp,
                            'money' => $a_price['price'],
                            'pro_img' => $a_data['pro_img'],
                            'user_id' => $_SESSION['user_id'],
                            'prot_count' => $i_goodsnum ];
                $s_data = $this->db->insert('cart',$a_where);
            } else {
                $i_goodsnum = $a_res['prot_count'] + $i_ouan;
                $s_data = $this->db->update('cart', ['prot_count' => $i_goodsnum], ['user_id' => $_SESSION['user_id'], 'cart_id' => $a_res['cart_id']]);
            }
            if(! empty($s_data)) {
                // $this->error->show_success('添加成功！', 'list', '', 0);
                echo json_encode(array('code'=>20,'msg'=>'添加成功！'));
                die;
            } else {
                // $this->error->show_error('添加失败', 'list', '', 0);
                echo json_encode(array('code'=>40,'msg'=>'添加失败'));
                die;
            }
	}

/************************************* 收藏门店 *************************************/

	public function store_collection() {
		// 验证是否登录
		if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
			echo json_encode(array('code'=>500,'msg'=>'登录后才可以收藏哦！'));
			die;
		}
		// 接收要收藏的门店id
		$store_id = $this->general->post('store_id');
		// 验证之前是否收藏过 已收藏则取消收藏
		$a_data = $this->store_model->get_collection_one($store_id, $_SESSION['user_id'], 1);
		if (!$a_data) {
			// 插入一条收藏信息
			$a_insert_data = [
				'object_id'       => $store_id,
				'user_id'         => $_SESSION['user_id'],
				'collection_type' => 1,
				'collection_time' => $_SERVER['REQUEST_TIME'],
			];
			$i_result = $this->store_model->insert_collection($a_insert_data);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'收藏成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'收藏失败'));
			}
		} else {
			$i_result = $this->store_model->delete_collection($a_data['collection_id']);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'取消收藏成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'取消收藏失败'));
			}
		}
	}


	public function weixin_ispay() {
		$appointment_type = trim($this->general->post('appointment_type'));
		$a_data = $this->store_model->get_appointment_second($appointment_type);
		if ($a_data) {
			echo json_encode(array('code'=>200));
		} else {
			echo json_encode(array('code'=>400));
		}
	}


/**********************************************************************************/

}

?>