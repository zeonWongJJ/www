<?php
date_default_timezone_set('PRC');
class Consumable_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

	//门店耗材列表
	public function consumable() {
		$i_audit = $this->general->post('name') ? $this->general->post('name') : 0;
		$i_page  = $this->router->get(2);
		if (empty($i_page)) {
			$i_page = 1;
		}
		$id = $_SESSION['store_id'];
		$a_where = "`store_id` = $id";
		if ( ! empty($i_audit)) {
			$name    = $this->db->get('consumption', ['consu_name LIKE' => '%' . $i_audit . '%'], ['consumption_id']);
			foreach ($name as $id) {
				$utd .= $id['consumption_id'].',';
			}
			$utd = rtrim($utd, ",");
			$i_page  = $this->router->get(2);
			if (empty($i_page)) {
				$i_page = 1;
			}
			$a_where .= ($a_where ? ' AND ':'')."`consumption_id` IN ($utd)";
		}
		// 设置每页显示的数据行数
		$i_prow = 10;
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数，以产品为例
		$i_total = $this->db->get_total('consumable_inventory', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		$a_data['cons']  = $this->db->get('consumable_inventory', $a_where);
		$a_data['total'] = $this->db->get_total('consumable_inventory', $a_where);
		$a_data['pages']  = $this->pages->link_style_one($this->router->url('consumable-'. $i_audit ."-", [], false, false));
		$a_data['consu']  = $this->consumption();
		$a_data['expend'] = $this->db->get('consumabel_expend', ['store_id' => $_SESSION['store_id'], 'daily_time' => mktime(0,0,0,date('m'),date('d')-1,date('Y'))]);
		$this->view->display('consumable', $a_data);
	}

	//门店耗材预警值修改
	public function consumable_uptate() {
		$i_id   = $this->general->post('id');
		$i_oute = $this->general->post('oute');
		$a_data = $this->db->update('consumable_inventory', ['prewarning_value' => $i_oute], ['id' => $i_id]);
		if ($a_data) {
			echo json_encode(20);
		}		
	}

	//门店耗材每日消耗查看
	public function consumable_daily() {
		$daliy   = $this->router->get(1) ? $this->router->get(1) : mktime(0,0,0,date('m'),date('d'),date('Y'));
		$a_where = "`store_id` = ".$_SESSION['store_id']. " AND `expend` > 0 AND `daily_time` =".$daliy;
		$i_page  = $this->router->get(2);
		if (empty($i_page)) {
			$i_page = 1;
		}
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数，以产品为例
		$a_data['total'] = $this->db->get_total('consumabel_expend', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($a_data['total'], $i_page, 10);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		$a_data['expend']  = $this->db->get('consumabel_expend', $a_where);
		$a_data['pages']  = $this->pages->link_style_one($this->router->url('consumable_daily-'. $daliy ."-", [], false, false));
		// echo $this->db->get_sql();
		// print_r($a_data['expend']);
		$a_data['cons'] = $this->db->limit(0, 999999999)->get('consumption');
		$this->view->display('consumable_daily', $a_data);
	}

	//门店耗材申请列表
	public function consumable_apply() {
		$i_audit = $this->router->get(1) ? $this->router->get(1) : 0;
		$i_page  = $this->router->get(2);
		if (empty($i_page)) {
			$i_page = 1;
		}
		$id = $_SESSION['store_id'];
		$a_where = "`store_id` = $id";
		if ( ! empty($i_audit)) {
			$a_where .= ($a_where ? ' AND ':'') . "`audit` = $i_audit";
		}
		// 设置每页显示的数据行数
		$i_prow = 5;
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数，以产品为例
		$i_total = $this->db->get_total('consumable_application', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		$a_data['apply'] = $this->db->order_by(['cons_id' => 'desc'])->get('consumable_application', $a_where);
		// echo $this->db->get_sql();
		$a_data['total'] = $this->db->get_total('consumable_application', $a_where);
		$a_data['pages'] = $this->pages->link_style_one($this->router->url('consumable_apply-'. $i_audit ."-", [], false, false));
		$a_data['con']   = $this->db->limit(0, 999999999)->get('consumption');
		// print_r($a_data['con']);
		$s_fields = 'b.cons_id,b.consumption_id,goods_aout,b.mone';
		$a_data['upate'] = $this->db->from('consumable_application as a')	
									->join('consumable_supplies as b', ['a.cons_id' => 'b.cons_id'])
									->select($s_fields,false)
									->group_by('b.cons_id,b.consumption_id,b.goods_aout')
									->limit(0, 999999999)
									->get('', ['a.store_id' => $_SESSION['store_id']]);
		$cons_ids = array();
		$cons_data = array();
		foreach ($a_data['upate'] as $key => $value) {
			if (!in_array($value['cons_id'].'&'.$value['consumption_id'], $cons_ids)) {
				$cons_ids[] = $value['cons_id'].'&'.$value['consumption_id'];
				$cons_data[] = $value;
			} else {
				foreach ($cons_data as $k => $v) {
					if ($v['cons_id'] == $value['cons_id']) {
						$v['goods_aout'] = $v['goods_aout'] + $value['goods_aout'];
						$v['mone'] = $v['mone'] + $value['mone'];     
						$cons_data[] = $v;
						unset($cons_data[$k]);
					}
				}
			}			
		}
					// print_r($cons_data);
		$a_data['sup'] = $cons_data;
		
		$this->view->display('consumable_apply', $a_data);
	}

	/************************************ 管理员审核查看************************************/
	public function consumable_pass() {
		$i_id   = $this->general->post('id');
		$a_data = $this->db->get_row('consumable_application', ['cons_id' => $i_id, 'store_id' => $_SESSION['store_id']]);
		echo json_encode($a_data);
	}
	
	//门店耗材重新申请
	public function consumable_reapply() {		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_address = $this->general->post('store_address');
			$a_phone   = $this->general->post('phone');
			$a_number  = $this->general->post('number');
			$a_remark  = $this->general->post('shop_remark');
			$a_cons    = $this->general->post('cons');
			$a_chere   = [
				'store_id'     	=> $_SESSION['store_id'],
				'store_name'    => $_SESSION['store_name'],
				'store_address' => $a_address,
				'audit'         => 2,
				'shop_remark'   => $a_remark,
				'phone'         => $a_phone,
				'phone_number'  => $a_number,
				'add_time'      => $_SERVER['REQUEST_TIME'],
			];	
			$a_insert = $this->db->insert('consumable_application', $a_chere);
			$a_data = $this->db->get('product_term');
			foreach ($a_cons as $key => $value) {
				if ($key == 1) {
					foreach ($value as $product => $pro) {
						foreach ($pro as $cup => $cupt) {
							foreach ($cupt as $cons => $out) {
								$a_goods = $this->db->get_row('product_term', ['product_id' => $product, 'cup_id' => $cup, 'consumption_id' => $cons], ['amount']);
								// 获取耗材金额
								$i_price = $this->db->get_row('consumption', ['consumption_id' => $cons], ['price']);
								// print_r($a_goods);
								$a_con = [
									'product_id'     => $product,
									'cup_id'         => $cup,
									'consumption_id' => $cons,
									'amount'         => $out,
									'goods_aout'     => $out * $a_goods['amount'],
									'cons_id'        => $a_insert,
									'mone'           => $i_price['price'] * ( $out * $a_goods['amount']),
			 					];
								// print_r($a_con);
								$a_inse = $this->db->insert('consumable_supplies', $a_con);
							}
						}
					}
				} else {
					foreach ($value as $cons => $out) {
						// 获取耗材金额
						$i_price = $this->db->get_row('consumption', ['consumption_id' => $cons], ['price']);
						$a_con = [
							'consumption_id' => $cons,
							'amount'         => $out,
							'cons_id'        => $a_insert,
							'goods_aout'     => $out,
							'mone'           => $i_price['price'] * $out,
	 					];
						// print_r($a_con);
						$a_inse = $this->db->insert('consumable_supplies', $a_con);
					}
				}
			}
			if (isset($a_insert) && isset($a_inse)) {
				$this->db->insert('messagess', ['ues' => 1, 'ues_id' => $_SESSION['store_id'], 'ues_name' => $_SESSION['store_name'], 'content' => '耗材申请', 'examine' => 1, 'mess_time' => $_SERVER['REQUEST_TIME']]);
				$this->error->show_success('重新申请成功！',$this->router->url('consumable_apply'), false, 2);
			} else {
				$this->error->show_error('重新申请失败！',$this->router->url('consumable_apply'), false, 2);
			}
		} else {			
			$id = $this->router->get(1);
			$a_data['con']  = $this->db->get_row('consumable_application', ['cons_id' => $id, 'store_id' => $_SESSION['store_id']]);
			$a_data['supp'] = $this->db->get('consumable_supplies', ['cons_id' => $id]);
			$a_data['suppt'] = $this->db->group_by(['product_id'])->get('consumable_supplies', ['cons_id' => $id]);			
			// 产品分类
			$a_data['pro']  = $this->db->get('pro', ['proid' => 1]);
			// 耗材分类
			$a_data['cons'] = $this->db->get('consumable', ['cons_id' => 1]);
			//杯型
			$a_data['cup']  = $this->db->limit(0, 989999999)->get('cup');
			//产品名
			$a_data['prod'] = $this->db->limit(0, 989999999)->get('product');
			//把后台的耗材表显示出来
			$a_data['consu'] = $this->consumption();
			// 查询缺少的耗材
			$a_store = $this->db->limit(0, 989999999)->get('consumable_inventory', ['store_id' => $_SESSION['store_id']]);
			foreach ($a_store as $store) {
				if ($store['inventory'] < $store['prewarning_value']) {
					foreach ($a_data['consu'] as $consu) {
						if ($store['consumption_id'] == $consu['consumption_id']) {
							$a_data['consutt'][] = $consu['consu_name'];
						}
					}	
				}	
			}	
			$this->view->display('consumable_reapply', $a_data);			
		}
	}

	//门店耗材申请参数获取
	public function consumable_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_name   = trim($this->general->post('name'));
			$cup_name = trim($this->general->post('cup_name'));
			$cup_id   = trim($this->general->post('cup_id'));
			$pro_name = trim($this->general->post('pro_name'));
			if ( ! empty($a_name)) {
				$this->db->limit(0, 989999999);	
				$a_data = $this->db->where("`product_name` LIKE '%$a_name%'")->get('product');
				echo json_encode($a_data);
			}	
			if ( ! empty($cup_name)) {
				$cup_name = $this->db->get_row('product', ['product_name' => $cup_name]);
				$cup_name = $this->db->get('price', ['product_id' => $cup_name['product_id']]);
				echo json_encode($cup_name);
			}
			if ( ! empty($cup_id)) {
				$cup_name = $this->db->get_row('product', ['product_name' => $pro_name]);
				$cup_name = $this->db->get('product_term', ['product_id' => $cup_name['product_id'], 'cup_id' => $cup_id, 'amount >' => 0]);
				// echo $this->db->get_sql();
				echo json_encode($cup_name);
			}			
		} else {
			$a_data['store'] = $this->db->get_row('store', ['store_id' => $_SESSION['store_id']]);
			// 产品分类
			$a_data['pro']   = $this->db->get('pro', ['proid' => 1]);
			// 耗材分类
			$a_data['cons']  = $this->db->get('consumable', ['cons_id' => 1]);
			// 查询缺少的耗材
			$a_store = $this->db->limit(0, 989999999)->get('consumable_inventory', ['store_id' => $_SESSION['store_id']]);
			$a_consu = $this->db->limit(0, 989999999)->get('consumption');	
			foreach ($a_store as $store) {
				if ($store['inventory'] < $store['prewarning_value']) {
					foreach ($a_consu as $consu) {
						if ($store['consumption_id'] == $consu['consumption_id']) {
							$a_data['consu'][] = $consu['consu_name'];
						}
					}	
				}	
			}	
			$this->view->display('consumable_add', $a_data);
		}
	}

	//门店申请耗材添加
	public function consumable_addition() {
		$a_address = $this->general->post('store_address');
		$a_phone   = $this->general->post('phone');
		$a_number  = $this->general->post('number');
		$a_remark  = $this->general->post('shop_remark');
		$a_cons    = $this->general->post('cons');
		if (empty($a_phone) ||empty($a_cons)) {
			$this->error->show_error('信息不完整！',$this->router->url('consumable_add'), false, 2);
		}
		$a_chere   = [
			'store_id'     	=> $_SESSION['store_id'],
			'store_name'    => $_SESSION['store_name'],
			'store_address' => $a_address,
			'audit'         => 2,
			'shop_remark'   => $a_remark,
			'phone'         => $a_phone,
			'phone_number'  => $a_number,
			'add_time' => $_SERVER['REQUEST_TIME'],
		];	
		$a_insert = $this->db->insert('consumable_application', $a_chere);
		$a_data = $this->db->get('product_term');
		foreach ($a_cons as $key => $value) {
			if ($key == 1) {
				foreach ($value as $product => $pro) {
					foreach ($pro as $cup => $cupt) {
						foreach ($cupt as $cons => $out) {
							$a_goods = $this->db->get_row('product_term', ['product_id' => $product, 'cup_id' => $cup, 'consumption_id' => $cons], ['amount']);
							// 获取耗材金额
							$i_price = $this->db->get_row('consumption', ['consumption_id' => $cons], ['price']);
							$a_con = [
								'product_id'     => $product,
								'cup_id'         => $cup,
								'consumption_id' => $cons,
								'amount'         => $out,
								'goods_aout'     => $out * $a_goods['amount'],
								'cons_id'        => $a_insert,
								'mone'           => $i_price['price'] * ( $out * $a_goods['amount']),
		 					];
							// print_r($a_con);
							$a_inse = $this->db->insert('consumable_supplies', $a_con);
						}
					}
				}
			} else {
				foreach ($value as $cons => $out) {
					// 获取耗材金额
					$i_price = $this->db->get_row('consumption', ['consumption_id' => $cons], ['price']);
					$a_con = [
						'consumption_id' => $cons,
						'amount'         => $out,
						'cons_id'        => $a_insert,
						'goods_aout'     => $out,
						'mone'           => $i_price['price'] * $out,
 					];
					// print_r($a_con);
					$a_inse = $this->db->insert('consumable_supplies', $a_con);
				}
			}
		}
		if (isset($a_insert) && isset($a_inse)) {
			$this->db->insert('messagess', ['ues' => 1, 'ues_id' => $_SESSION['store_id'], 'ues_name' => $_SESSION['store_name'], 'content' => '耗材申请', 'examine' => 1, 'mess_time' => $_SERVER['REQUEST_TIME']]);
			$this->error->show_success('添加成功！',$this->router->url('consumable_apply'), false, 2);
		} else {
			$this->error->show_error('添加失败！',$this->router->url('consumable_add'), false, 2);
		}
	}

	//门店耗材申请修改
	public function consumable_up() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// print_r($_POST);die;
			$i_id      = trim($this->general->post('id'));
			$a_address = $this->general->post('store_address');
			$a_phone   = $this->general->post('phone');
			$a_number  = $this->general->post('number');
			$a_remark  = $this->general->post('shop_remark');
			$a_cons    = $this->general->post('cons');
			// 开启事务
			$this->db->begin();
			$a_data = $this->db->get_row('consumable_application', ['cons_id' => $i_id, 'audit' => 2, 'store_id' => $_SESSION['store_id']]);
			$a_con = [
				'shop_remark'  => $a_remark,
				'phone'	       => $a_phone,
				'phone_number' => $a_number,
			];
			$consumable = $this->db->update('consumable_application', $a_con, ['cons_id' => $i_id]);
			$this->db->delete('consumable_supplies', ['cons_id' => $i_id]);
			foreach ($a_cons as $key => $value) {
				if ($key == 1) {
					foreach ($value as $product => $pro) {
						foreach ($pro as $cup => $cupt) {
							foreach ($cupt as $cons => $out) {
								$a_goods = $this->db->get_row('product_term', ['product_id' => $product, 'cup_id' => $cup, 'consumption_id' => $cons], ['amount']);
								// 获取耗材金额
								$i_price = $this->db->get_row('consumption', ['consumption_id' => $cons], ['price']);
								$a_con = [
									'product_id'     => $product,
									'cup_id'         => $cup,
									'consumption_id' => $cons,
									'amount'         => $out,
									'goods_aout'     => $out * $a_goods['amount'],
									'cons_id'        => $i_id,
									'mone'           => $i_price['price'] * ( $out * $a_goods['amount']),
			 					];
								// print_r($a_con);
								$a_inse = $this->db->insert('consumable_supplies', $a_con);
							}
						}
					}
				} else {
					foreach ($value as $cons => $out) {
						// 获取耗材金额
						$i_price = $this->db->get_row('consumption', ['consumption_id' => $cons], ['price']);
						$a_con = [
							'consumption_id' => $cons,
							'amount'         => $out,
							'cons_id'        => $i_id,
							'goods_aout'     => $out,
							'mone'           => $i_price['price'] * $out,
	 					];
						// print_r($a_con);
						$a_inse = $this->db->insert('consumable_supplies', $a_con);
					}
				}
			}
			if($a_data != false){
				$s_commit = 'commit';
				// 提交事务
				$this->db->commit();
			} else {
				$s_roll_back = 'roll_back';
				// 事务回滚
				$this->db->roll_back();
			}

			if($s_commit == 'commit'){
				$this->error->show_success('修改成功！',$this->router->url('consumable_apply'), false, 1);
			}
			if($s_roll_back == 'roll_back'){
				$this->error->show_error('改订单已被审核，不能修改！',$this->router->url('consumable_apply'), false, 1);
			}
			
		} else {			
			$id = $this->router->get(1);
			$a_data['con']  = $this->db->get_row('consumable_application', ['cons_id' => $id, 'audit' => 2, 'store_id' => $_SESSION['store_id']]);
			$a_data['supp'] = $this->db->get('consumable_supplies', ['cons_id' => $id]);
			// print_r($a_data['supp']);
			$a_data['suppt'] = $this->db->group_by(['product_id'])->get('consumable_supplies', ['cons_id' => $id]);
			// print_r($a_data['suppt']);
			if (empty($a_data['con'])) {
				$this->error->show_error('你的申请已被运行！', 'consumable_apply', false, 1);
			} else {
				// 产品分类
				$a_data['pro']  = $this->db->get('pro', ['proid' => 1]);
				// 耗材分类
				$a_data['cons'] = $this->db->get('consumable', ['cons_id' => 1]);
				//杯型
				$a_data['cup']  = $this->db->limit(0, 989999999)->get('cup');
				//产品名
				$a_data['prod'] = $this->db->limit(0, 989999999)->get('product');
				//把后台的耗材表显示出来
				$a_data['consu'] = $this->consumption();
				// 查询缺少的耗材
				$a_store = $this->db->limit(0, 989999999)->get('consumable_inventory', ['store_id' => $_SESSION['store_id']]);
				foreach ($a_store as $store) {
					if ($store['inventory'] < $store['prewarning_value']) {
						foreach ($a_data['consu'] as $consu) {
							if ($store['consumption_id'] == $consu['consumption_id']) {
								$a_data['consutt'][] = $consu['consu_name'];
							}
						}	
					}	
				}	
				$this->view->display('consumable_up', $a_data);
			}			
		}
	}

	//门店耗材申请取消
	public function consumable_abolish() {
		$id   = $this->general->post('id');
		$cons = $this->db->get_row('consumable_application', ['cons_id' => $id, 'audit' => 2]);
		if (empty($cons)) {
			echo 33;
			die;
		} else {
			$this->db->update('consumable_application', ['audit' => 4], ['cons_id' => $id]);
			echo 55;
			die;
		}
	}

	//查找耗材表数据
	public function consumption() {
		$consumption = $this->db->limit(0, 999999999)->get('consumption');
		return $consumption;
	}

	//产品分类2级
	public function proid_id_2() {
		$i_id_1 = $this->general->post('id');
		$a_pro  = $this->db->get('pro', ['pro_pid' => $i_id_1]);
		echo json_encode($a_pro);
	}

	//产品分类3级
	public function proid_id_3() {
		$i_id_2 = $this->general->post('id');
		$a_pro  = $this->db->get('pro', ['pro_pid' => $i_id_2]);
		echo json_encode($a_pro);
	}
	//获取选中的3级产品
	public function proid_goode() {
		$i_id_3  = $this->general->post('id');
		$i_shuwe = $this->general->post('shuwe');
		if ($i_shuwe == 1) {
			$a_data  = $this->db->get('product', ['proid_id_1' => $i_id_3]);
			echo json_encode($a_data);
		} else if ($i_shuwe == 2) {
			$a_data  = $this->db->get('product', ['proid_id_2' => $i_id_3]);
			echo json_encode($a_data);
		} else if ($i_shuwe == 3) {
			$a_data  = $this->db->get('product', ['proid_id_3' => $i_id_3]);
			echo json_encode($a_data);
		}
	}
	//耗材分类2级获取
	public function haoc_id_2() {
		$i_id   = $this->general->post('id');
		$a_data = $this->db->get('consumable', ['cons_upid' => $i_id, 'cons_show' => 1]);
		echo json_encode($a_data);
	}
	//耗材分类3级获取
	public function haoc_id_3() {
		$i_id   = $this->general->post('id');
		$a_data = $this->db->get('consumable', ['cons_upid' => $i_id, 'cons_show' => 1]);
		echo json_encode($a_data);
	}
	//获取耗材名称
	public function haoc_name() {
		$i_id   = $this->general->post('id');
		$i_con  = $this->general->post('con');
		if ($i_con == 1) {
			$a_data = $this->db->get('consumption', ['consu_id_1' => $i_id]);
			echo json_encode($a_data);
		} else if ($i_con == 2) {
			$a_data = $this->db->get('consumption', ['consu_id_2' => $i_id]);
			echo json_encode($a_data);
		} else if ($i_con == 3) {
			$a_data = $this->db->get('consumption', ['consu_id_3' => $i_id]);
			echo json_encode($a_data);
		}
	}	
}
?>