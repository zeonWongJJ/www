<?php

class Cons_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('cons_model');
		$this->load->model('allow_model');
		$this->load->model('image_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 耗材分类列表 *************************************/

	public function cons() {
		$a_name  = $this->general->post('name') ? $this->general->post('name') : '';
		$a_data = [
		 	'a_name' => $a_name,
		];
		$a_where = '';
		if ( ! empty($a_name)) {			
			$a_where = ['cons_name LIKE' => '%'.$a_name.'%'];
		}
		$a_data['cons'] = $this->db->limit(0, 999999999)->get('consumable', $a_where);
		// print_r($a_data['cons']);
		$this->view->display('cons', $a_data);
	}

/************************************* 耗材增加分类 *************************************/

	public function cons_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_name = $this->general->post('name');
			if (empty($a_name)) {
				$this->error->show_error('请写耗材名称', 'cons_add', false, 2);
			}
			$a_conname = $this->db->get('consumable', ['cons_name' => $a_name]);
			if ( ! empty($a_conname)) {
				$this->error->show_error('填写耗材分类名称重复！请更改！', 'cons_add', false, 2);
			}
			$i_result = $this->cons_model->insert_cate();
			if ($i_result) {
				$this->error->show_success('添加成功', 'cons', false, 1);
			} else {
				$this->error->show_error('添加失败', 'cons_add', false, 1);
			}
		} else {
			//先查找所有的分类数据并分配到模板
			$a_data = $this->db->get('consumable', ['cons_id' => 1]);
			$this->view->display('cons_add', $a_data);
		}
	}

/************************************* 耗材修改分类 *************************************/

	public function cons_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// print_r($_POST);
			$id      = $this->general->post('id');
			$cons_id = $this->general->post('cons_id');
			$cons    = $this->general->post('cons');
			$cons_id = explode('-', $cons_id);
			$a_cons  = $this->db->get_row('consumable', ['id' => $cons_id[0]]);
			if ($id == $a_cons['id'] || $id == $a_cons['cons_upid']) {
				$this->error->show_error('不能选下级或子级', 'cons_update-'.$id, false, 1);
			}
			if ($cons < $cons_id[1]+1) {
				$son_count = $this->cons_model->get_cate_son($id);
				if ($son_count > 0) {
					$this->error->show_error('请移动或删除该分类下的子分类再进行操作', 'cons_update-'.$id, false, 1);
					die;
				}
			}

			$i_result = $this->cons_model->update_cate();
			if ($i_result) {
				$this->error->show_success('修改成功', 'cons', false, 1);
			} else {
				$this->error->show_error('无修改', 'cons', false, 1);
			}
		} else {
			$id = $this->router->get(1);
			$a_data['con'] = $this->db->get_row('consumable', ['id' => $id]);
			// print_r($a_data['con']);
			if (empty($a_data['con'])) {
				$this->error->show_error('无效参数', 'cons', false, 1);
			}
			//查找所有的分类信息并分配到模板
			$a_data['all'] = $this->db->get('consumable');
			$this->view->display('cons_update', $a_data);
		}
	}

/************************************* 耗材分类显示隐藏 ***********************************/
	public function cons_switch() {
		$id  =  $this->general->post('id');
		$a_data = $this->db->get_row('consumable', ['id' => $id]);
		if ($a_data['cons_show'] == 1) {
			$a_cons_show = [
				'cons_show' => 2,
			];
			$aou = 2;
		} else {
			$aou = 1;
			$a_cons_show = [
				'cons_show' => 1,
			];
		}
		$i_result = $this->db->update('consumable', $a_cons_show, ['id' => $id]);
		if (isset($i_result)) {
			echo json_encode(array('code'=>20, 'kou'=>$aou));
		} else {
			echo json_encode(array('code'=>44));
		}
	}

/************************************* 耗材分类删除分类 *************************************/

	public function cons_delete() {
		//接收需要删除的分类id
		$type = $this->general->post('out');
		if ($type == 1) {
			$id   = $this->general->post('id');
			// 验证分类是否有子分类 如果有则删除
			$son_count = $this->cons_model->get_cate_son($id);
			if ($son_count > 0) {
				echo json_encode(array('code'=> 400, 'msg'=>'请移动或删除该分类下的子分类再进行操作'));
				die;
			}
			$i_result = $this->cons_model->delete_one($id);
			if ($i_result) {
				echo json_encode(array('code'=> 33));
			} else {
				echo json_encode(array('code'=> 66));
			}
		} else {
			$new_ids = $this->general->post('id');
			// // 验证是否符合删除条件
			// for ($i = 0; $i<count($id); $i++) {
			// 	$son_count = $this->cons_model->get_cate_son($id[$i]);
			// 	if ($son_count == 0) {
			// 		$new_ids[] = $id[$i];
			// 	}
			// }
			if (empty($new_ids)) {
				echo json_encode(array('code'=>400, 'msg'=>'没有符合删除条件的分类'));
				die;
			}
			$i_result = $this->db->where_in('id', $new_ids)->delete('consumable');
			if ($i_result) {
				echo json_encode(array('code'=>33, 'msg'=>'删除成功', 'data'=>$new_ids));
			} else {
				echo json_encode(array('code'=>60, 'msg'=>'删除失败', 'data'=>$new_ids));
			}
		}
		
	}

/************************************* 耗材列表 *************************************/
	public function annex() {
		$i_one   = $this->router->get(1) ? $this->router->get(1) : 0;
		$i_two   = $this->router->get(2) ? $this->router->get(2) : 0;
		$i_three = $this->router->get(3) ? $this->router->get(3) : 0;
		$a_data  = [
			'i_one'   => $i_one,
			'i_two'   => $i_two,
			'i_three' => $i_three,
			'i_page'  => $i_page,
		];
		$a_where = "";
		if ( ! empty($i_one)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`consu_id_1` = $i_one";
		}
		if ( ! empty($i_two)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`consu_id_2` = $i_two";
		}
		if ( ! empty($i_three)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`consu_id_3` = $i_three";
		}
		$i_page = $this->router->get(4);
		if (empty($i_page)) {
			$i_page = 1;
		}
		// 设置每页显示的数据行数
		$i_prow = 10;
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数，以产品为例
		$i_total = $this->db->get_total('consumption', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		$a_data['annex'] = $this->db->get('consumption', $a_where, '', ['consumption_id' => 'desc']);
		$a_data['zonsh'] = $i_total; 
		$a_data['pages'] = $this->pages->link_style_one($this->router->url('annex-'.$i_one.'-'.$i_two.'-'.$i_three.'-', [], false, false));
		//耗材分类
		$a_data['search'] = $this->cons_model->category($i_one, $i_two);
		$a_data['expend'] = $this->db->get('consumabel_expend', ['daily_time' => mktime(0,0,0,date('m'),date('d')-1,date('Y'))]);
 	// 	$a_test = $this->db->group_by('consumption_id')->limit(0,99999)->get('consumabel_expend',['daily_time' => mktime(0,0,0,date('m'),date('d')-1,date('Y'))],'consumption_id,expend');
		//  print_r($a_test);
		// echo $this->db->get_sql();exit;		
		$this->view->display('annex', $a_data);
	}
/************************************* 材料增加 *************************************/

	public function annex_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_name   = trim($this->general->post('name'));
			$i_id_1   = trim($this->general->post('id_1'));
			$i_id_2   = trim($this->general->post('id_2'));
			$i_id_3   = trim($this->general->post('id_3'));
			$i_price  = trim($this->general->post('price'));
			$i_units  = trim($this->general->post('units'));
			$i_amount = trim($this->general->post('amount'));
			$i_prewaning = trim($this->general->post('prewaning'));
			$a_conname = $this->db->get('consumption', ['consu_name' => $a_name]);
			if ( ! empty($a_conname)) {
				$this->error->show_error('填写耗材名称重复！请更改！', 'annex_add', false, 2);
			}
			$a_cout = [
				'consu_name' => $a_name,
				'consu_id_1' => $i_id_1,
				'consu_id_2' => $i_id_2,
				'consu_id_3' => $i_id_3,
				'price'      => $i_price,
				'amount'     => $i_amount,
				'units'      => $i_units,
				'prewaning'  => $i_prewaning,
				'add_time'   => $_SERVER['REQUEST_TIME'],
			];
			$i_result = $this->db->insert('consumption', $a_cout);
			if ($i_result) {
				$this->error->show_success('添加成功', 'annex', false, 1);
			} else {
				$this->error->show_error('添加失败', 'annex_add', false, 1);
			}
		} else {
			//先查找所有的分类数据并分配到模板
			$a_data = $this->cons_model->get_cons_showlist();
			$this->view->display('annex_add', $a_data);
		}
	}

/************************************* 材料修改 *************************************/

	public function annex_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$i_id     = trim($this->general->post('id'));
			$a_name   = trim($this->general->post('name'));
			$i_id_1   = trim($this->general->post('id_1'));
			$i_id_2   = trim($this->general->post('id_2'));
			$i_id_3   = trim($this->general->post('id_3'));
			$i_price  = trim($this->general->post('price'));
			$i_units  = trim($this->general->post('units'));
			$i_amount = trim($this->general->post('amount'));
			$i_prewaning = trim($this->general->post('prewaning'));
			$a_cout = [
				'consu_name' => $a_name,
				'consu_id_1' => $i_id_1,
				'consu_id_2' => $i_id_2,
				'consu_id_3' => $i_id_3,
				'price'      => $i_price,
				'amount'     => $i_amount,
				'units'      => $i_units,
				'prewaning'  => $i_prewaning,
			];
			$i_result = $this->db->update('consumption', $a_cout, ['consumption_id' => $i_id]);
			if ($i_result) {
				$this->error->show_success('修改成功', 'annex', false, 1);
			} else {
				$this->error->show_error('无修改', 'annex', false, 1);
			}
		} else {
			$id = $this->router->get(1);
			//获取原数据并分配到模板
			$a_where = [
				'consumption_id' => $id
			];
			$a_data['self'] = $this->db->get_row('consumption', $a_where);
			//查找所有的分类信息并分配到模板
			$a_data['all'] = $this->db->limit(0 ,999999999)->get('consumable');
			$this->view->display('annex_update', $a_data);
		}
	}


/************************************* 材料删除 ***********************************/
	public function annex_delete() {
		//接收需要删除的分类id
		$id  =  $this->general->post('id');
		$a_where = [
			'consumption_id' => $id,
		];
		$i_result = $this->db->delete('consumption', $a_where);
		if ($i_result) {
			echo json_encode(33);
		} else {
			echo json_encode(66);
		}
	}


/************************************ 耗材出入库记录 ********************************/
    public function entry_record() {
    	$a_name  = trim($this->general->post('name')) ? trim($this->general->post('name')) : $this->general->base64_convert($this->router->get(1), true);
    	$i_state = $this->router->get(2);
    	$i_page  = $this->router->get(3);
    	$a_data = [
    		'a_name'  => $a_name,
    		'i_state' => $i_state,
    		'i_page'  => $i_page,
    	];
    	$a_where = '';
    	if (! empty($a_name)) {
    		$a_where .= ($a_where ? 'AND' : '') . "`consu_name` LIKE '%$a_name%'";
    	}
    	if (! empty($i_state)) {
    		$a_where .= ($a_where ? 'AND' : '') . "`state` = $i_state";
    	}
		if (empty($i_page)) {
			$i_page = 1;
		}
		// 设置每页显示的数据行数
		$i_prow = 10;
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数，以产品为例
		$i_total = $this->db->get_total('consumption_record', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		$a_data['annex'] = $this->db->order_by(['record_id' => 'desc'])->get('consumption_record', $a_where);
		$a_data['ourt']  = $this->db->get_total('consumption_record', $a_where);
		// echo $this->db->get_sql();
		$a_data['pages'] = $this->pages->link_style_one($this->router->url('entry_record-'.$a_name."-". $i_state ."-", [], false, false));
		$this->view->display('entry_record', $a_data);
    }
    // 查看
    public function entry_record_imge() {
    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id    = $this->general->post('id');
			$a_img = $this->db->get_row('consumption_record', ['record_id' => $id]);
			$a_img = explode(",", $a_img['img']);
			echo json_encode(array('data' => $a_img));
			die;
    	}
    }

/************************************ 耗材入库添加 ********************************/
    public function entry_add() {
    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    		$a_name   = trim($this->general->post('name'));
    		$i_pid    = trim($this->general->post('cons_id'));
    		$cons_id_1 = trim($this->general->post('cons_id_1'));
    		$cons_id_2 = trim($this->general->post('cons_id_2'));
    		$cons_id_3 = trim($this->general->post('cons_id_3'));
    		$a_amount = trim($this->general->post('amount'));
    		$a_price  = trim($this->general->post('price'));
    		$a_reason = trim($this->general->post('reason'));
    		$path_img = $this->general->post('otherpic_path');
			$a_consu = [
				'consumption_id' => $i_pid,
				'cons_id_1' 	 => $cons_id_1,
				'cons_id_2' 	 => $cons_id_2,
				'cons_id_3' 	 => $cons_id_3,
				'consu_name'     => $a_name,
				'amount'         => $a_amount,
				'price'          => $a_price,
				'operate'        => $_SESSION['admin_name'],
				'state'          => 1,
				'reason'         => $a_reason,
				'img'            => $path_img,  
				'add_time'       => $_SERVER['REQUEST_TIME'],
			];
			$i_result = $this->db->insert('consumption_record', $a_consu);
			if ($i_result) {
				$this->db->set('amount', 'amount +'.$a_amount, false)->update('consumption', '', ['consumption_id' => $i_pid]);
				$this->error->show_success('添加成功', 'entry_record', false, 1);
			} else {
				$this->error->show_error('添加失败', 'entry_add', false, 1);
			}
    	} else {
    		$a_data['con'] = $this->db->limit(0,9999999)->get('consumable');
			$this->view->display('entry_add', $a_data);
    	}
    }

/************************************ 耗材入库修改 ********************************/
    public function entry_uptate() {
    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    		$i_id      = trim($this->general->post('id'));
    		$a_name    = trim($this->general->post('name'));
    		$i_pid     = trim($this->general->post('cons_id'));
    		$cons_id_1 = trim($this->general->post('cons_id_1'));
    		$cons_id_2 = trim($this->general->post('cons_id_2'));
    		$cons_id_3 = trim($this->general->post('cons_id_3'));
    		$a_amount  = trim($this->general->post('amount'));
    		$a_price   = trim($this->general->post('price'));
    		$a_reason  = trim($this->general->post('reason'));
    		$a_img     = trim($this->general->post('otherpic_path'));
			$a_consu = [
				'consumption_id' => $i_pid,
				'cons_id_1' 	 => $cons_id_1,
				'cons_id_2' 	 => $cons_id_2,
				'cons_id_3' 	 => $cons_id_3,
				'consu_name'     => $a_name,
				'amount'         => $a_amount,
				'price'          => $a_price,
				'operate'        => $_SESSION['admin_name'],
				'reason'         => $a_reason,
				'img'            => $a_img,  
				'add_time'       => $_SERVER['REQUEST_TIME'],
			];
			$i_out = $this->db->get_row('consumption_record', ['record_id' => $i_id], ['amount']);
			$i_result = $this->db->update('consumption_record', $a_consu, ['record_id' => $i_id]);
			if ($i_result) {
				if ($i_out['amount'] < $a_amount) {
					$a_amount = $a_amount - $i_out['amount'];
					$this->db->set('amount', 'amount +'.$a_amount, false)->update('consumption', '', ['consumption_id' => $i_pid]);
				} else if ($i_out['amount'] > $a_amount) {
					$a_amount = $i_out['amount'] - $a_amount;
					$this->db->set('amount', 'amount -'.$a_amount, false)->update('consumption', '', ['consumption_id' => $i_pid]);
				}				
				$this->error->show_success('修改成功', 'entry_record', false, 1);
			} else {
				$this->error->show_error('无修改', 'entry_uptate-'.$i_id, false, 1);
			}
    	} else {
    		$i_id = $this->router->get(1);
    		$a_data['con']    = $this->db->limit(0,999999999)->get('consumable');
    		$a_data['paost']  = $this->db->limit(0,999999999)->get('consumption');
    		$a_data['record'] = $this->db->get_row('consumption_record', ['record_id' => $i_id, 'state' => 1]);
    		if (empty($a_data['record'])) {
    			$this->error->show_error('操作有误，请重试！', 'entry_record', false, 1);
    		}
			$this->view->display('entry_uptate', $a_data);
    	}
    }  

/************************************* 门店审核列表  ************************************/	
	public function store() {
		$a_name  = trim($this->general->post('name')) ? trim($this->general->post('name')) : $this->general->base64_convert($this->router->get(1), true);
		$i_store = $this->router->get(2);
		$i_page  = $this->router->get(3);
		$a_data  = [
			'a_name'  => $a_name,
			'i_store' => $i_store,
			'i_page'  => $i_page,
		];
		$a_where = '';
    	if (! empty($a_name)) {
    		$a_where .= ($a_where ? 'AND' : '') . "`store_name` LIKE '%$a_name%'";
    	}
    	if (! empty($i_store)) {
    		$a_where .= ($a_where ? 'AND' : '') . "`audit` = $i_store";
    	}
		if (empty($i_page)) {
			$i_page = 1;
		}
		// 设置每页显示的数据行数
		$i_prow = 10;
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数，以产品为例
		$i_total = $this->db->get_total('consumable_application', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		$a_data['cons'] = $this->db->order_by(['cons_id' => 'desc'])->get('consumable_application', $a_where);
		$a_data['pages'] = $this->pages->link_style_one($this->router->url('store-'.$a_name."-".$i_store."-", [], false, false));
		// 申请耗材副内容
		$s_fields = 'b.cons_id,b.consumption_id,goods_aout,b.mone';
		$a_upate  = $this->db->from('consumable_application as a')	
									->join('consumable_supplies as b', ['a.cons_id' => 'b.cons_id'])
									->select($s_fields,false)
									->group_by('b.cons_id,b.consumption_id,b.goods_aout')
									->limit(0, 999999999)
									->get('');
		// echo $this->db->get_sql();
		$cons_ids = array();
		$cons_data = array();
		foreach ($a_upate as $key => $value) {
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
		$a_data['sup'] = $cons_data;
		$a_data['consu'] = $this->db->limit(0,999999999)->get('consumption');
		// print_r($a_data['consu']);
		$this->view->display('store', $a_data);				
	}

/************************************ 管理员审核查看************************************/
	public function store_pass() {
		$i_id   = $this->general->post('id');
		$a_data = $this->db->get_row('consumable_application', ['cons_id' => $i_id]);
		echo json_encode($a_data);
	}

/************************************ 管理员审核触发************************************/
 	public function touch_off() {
 		$i_id   = $this->general->post('id');
 		$a_name = $this->general->post('name');
		$i_ster = $this->general->post('ster');
		$a_stor = $this->db->get_row('consumable_application', ['cons_id' => $i_id, 'audit' => 2]);
		if (empty($a_stor)) {
			echo 58;
		} else {
			if ($i_ster == 1) {
				// 发送门店的消息
				$cons = [
					'ues'    => 2,
					'ues_id' => $a_stor['store_id'],
					'ues_name' => '总门店',
					'content' => '通过了你的耗材申请！',
					'examine' => 1,
					'mess_time' => $_SERVER['REQUEST_TIME'],
				];
				$_SESSION['oute'] = $this->db->insert('messagess', $cons);
				$a_con = $this->db->get('consumable_supplies', ['cons_id' => $i_id]);
				foreach ($a_con as $key => $value) {
					if ($value['consumption_id'] != 'i') {	
						$a_store = $this->db->get('consumable_inventory', ['store_id' => $a_stor['store_id'], 'consumption_id' => $value['consumption_id']]);					
						if( ! empty($a_store)) {
							$this->db->set('inventory', 'inventory +'.$value['goods_aout'], false)->update('consumable_inventory', '', ['store_id' => $a_stor['store_id'], 'consumption_id' => $value['consumption_id']]);
							$this->db->set('amount', 'amount -'.$value['goods_aout'], false)->update('consumption', '', ['consumption_id' => $value['consumption_id']]);
					 		$a_data = $this->db->get_row('consumption', ['amount <' => 'prewaning', 'consumption_id' => $value['consumption_id']]);
					 		if ( ! empty($a_data)) {
					 			//耗材少于预警值就发送到消息表
								$a_messg = [
									'ues'     => 1,
									'content' => '耗材'.$a_data['consu_name'].'库存低于耗材预警值快去进货吧！',
									'examine' => 1,
									'mess_time' => $_SERVER['REQUEST_TIME'],
								];
								$this->db->insert('messagess', $a_messg);
								// 未读消息数
								$_SESSION['oute'] = $this->db->get_total('messagess', ['ues' => 1, 'examine' => 1]);
					 		}							
						} else {
							$a_sto = [
								'store_id'       => $a_stor['store_id'],
								'consumption_id' => $value['consumption_id'],
								'inventory'      => $value['goods_aout'],
							];
							$this->db->insert('consumable_inventory', $a_sto);
							$this->db->set('amount', 'amount -'.$value['goods_aout'], false)->update('consumption', '', ['consumption_id' => $value['consumption_id']]);
					 		$a_data = $this->db->get_row('consumption', ['amount <' => 'prewaning']);
							if ( ! empty($a_data)) {
					 			//耗材少于预警值就发送到消息表
								$a_messg = [
									'ues'     => 1,
									'content' => '耗材'.$a_data['consu_name'].'库存低于耗材预警值快去进货吧！',
									'examine' => 1,
									'mess_time' => $_SERVER['REQUEST_TIME'],
								];
								$this->db->insert('messagess', $a_messg);
								// 未读消息数
								$_SESSION['oute'] = $this->db->get_total('messagess', ['ues' => 1, 'examine' => 1]);
					 		}	
						}
					}						
				}
				$this->db->update('consumable_application', ['audit' => 1, 'back_remark' => $a_name, 'alter_time' => $_SERVER['REQUEST_TIME']], ['cons_id' => $i_id]);
				echo 33;
			} else if ($i_ster == 2) {
				// 发送门店的消息
				$cons = [
					'ues'    => 2,
					'ues_id' => $a_stor['store_id'],
					'ues_name' => '总门店',
					'content' => '拒绝了你的耗材申请！',
					'examine' => 1,
					'mess_time' => $_SERVER['REQUEST_TIME'],
				];
				$_SESSION['oute'] = $this->db->insert('messagess', $cons);
				$this->db->update('consumable_application', ['audit' => 3, 'back_remark' => $a_name,  'alter_time' => $_SERVER['REQUEST_TIME']], ['cons_id' => $i_id]);
				echo 66;
			}
		}
 	}

    //入库凭证图片删除
	public function entry_img_del() {
		$image_path = trim($this->general->post('image_path'));
        $dtype      = trim($this->general->post('dtype'));
        $record_id  = trim($this->general->post('record_id'));
		$del        = unlink($image_path);
		if ($del) {
			if ($dtype == 2) {
				$a_data = $this->db->get_row('consumption_record', ['record_id' => $record_id]);
	    		$imge = explode(",", $a_data['img']);
	    		foreach ($imge as $image) {
	    			if ($image != $image_path) {
					 	$imag .= $image.',';
	    			}
	    		}
	    		$imag = rtrim($imag, ",");
				$this->db->update('consumption_record', ['img' => $imag], ['record_id' => $record_id]);
			}			
			echo json_encode(array('code'=> 200, 'msg'=>'删除成功'));
		} else {
			echo json_encode(array('code'=> 400, 'msg'=>'删除失败'));
		}
	}

/************************************ 2级极分类 ************************************/
	public function cons_id_2() {
		$i_id   = $this->general->post('id');
		$a_data =  $this->db->get('consumable', ['cons_upid' => $i_id]);
		echo json_encode($a_data);
	}

/************************************ 3级极分类 ************************************/
	public function cons_id_3() {
		$i_id   = $this->general->post('id');
		$a_data =  $this->db->get('consumable', ['cons_upid' => $i_id]);
		echo json_encode($a_data);
	}

/************************************ 获取耗材名称 ***********************************/
	public function cons_name() {
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