<?php
class Pro_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('pro_model');
		$this->load->model('allow_model');
		$this->load->model('image_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

	//产品分类详情
	public function pro() {
		$a_name  = $this->general->post('name');
		$a_data = [
		 	'a_name' => $a_name,
		];
		$a_where = '';
		if ( ! empty($a_name)) {			
			$a_where = ['pro_name LIKE' => '%'.$a_name.'%'];
		}
		$a_data['pro'] = $this->db->limit(0, 999999999)->get('pro', $a_where);
		$this->view->display('pro', $a_data);
	}

	// 产品分类添加
	public function pro_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$i_show     = trim($this->general->post('show'));
			$a_name     = trim($this->general->post('name'));
			$i_proid    = trim($this->general->post('proid'));
			$pro_id_1   = trim($this->general->post('pro_id_1'));
			$pro_id_2   = trim($this->general->post('pro_id_2'));
			$a_goodsename = $this->db->limit(0, 999999999)->get('pro', ['pro_name' => $a_name]);
			if (!empty($a_goodsename)) {
			 	$this->error->show_error('填写产品分类名重复，请修改！', 'pro_add', false, 2);
			} 
			if ($i_proid === 0) {
				$pro_pid = 0;
				$i_proid = 0;
			} else {
				$i_proid = explode('-', $i_proid);
				$pro_pid = $i_proid[0];
				$i_proid = $i_proid[1]+1;
			}
			$pro_id_1 = explode('-', $pro_id_1);
			$pro_id_2 = explode('-', $pro_id_2);
			$a_data = [
				'pro_name' => $a_name,
				'pro_pid'  => $pro_pid,
				'proid'    => $i_proid,
				'pro_id_1' => $pro_id_1[0],
				'pro_id_2' => $pro_id_2[0],
				'is_show'  => $i_show,
			];
			$i_result = $this->db->insert('pro', $a_data);
			if ($i_result) {
				$this->error->show_success('添加成功', 'pro', false, 1);
			} else {
				$this->error->show_error('添加失败', 'pro', false, 1);
			}
		} else {								
			$a_data = $this->db->limit(0, 999999999)->get('pro', ['proid' => 1]);
			$this->view->display('pro_add', $a_data);	
		}
	}

	//产品分类修改
	public function pro_up() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// print_r($_POST);
			//接收提交的信息
			$i_id     = $this->general->post('id');
			$i_show   = trim($this->general->post('show'));
			$a_name   = trim($this->general->post('name'));
			$i_proid  = trim($this->general->post('proid'));
			$pro_id_1 = trim($this->general->post('pro_id_1'));
			$pro_id_2 = trim($this->general->post('pro_id_2'));
			$cons_id  = explode('-', $i_proid);
			$cons     = $this->general->post('cons');
			if ($cons < $cons_id[1]+1) {
				$son_count = $this->db->get_total('pro',['pro_pid' => $i_id]);
				if ($son_count > 0) {
					$this->error->show_error('请移动或删除该分类下的子分类再进行操作', 'pro_up-'.$i_id, false, 1);
					die;
				}
			}
			if ($i_proid === 0) {
				$pro_pid = 0;
				$i_proid = 0;
			} else {
				$i_proid = explode('-', $i_proid);
				$pro_pid = $i_proid[0];
				$i_proid = $i_proid[1]+1;
			}
			$pro_id_1 = explode('-', $pro_id_1);
			$pro_id_2 = explode('-', $pro_id_2);
			$a_data = [
				'pro_name'   => $a_name,
				'pro_pid'    => $pro_pid,
				'proid'      => $i_proid,
				'pro_id_1' => $pro_id_1[0],
				'pro_id_2' => $pro_id_2[0],
				'is_show'    => $i_show,
			];
			$i_result = $this->db->update('pro', $a_data, ['pro_id' => $i_id]);
			if ($i_result) {
				$this->error->show_success('修改成功', 'pro', false, 1);
			} else {
				$this->error->show_error('无修改', 'pro', false, 1);
			}
		} else {
			$i_id = $this->router->get(1);
			$a_data['pro'] = $this->db->get_row('pro', ['pro_id' => $i_id]);
			// print_r($a_data['pro']);
			$a_data['ali'] = $this->pro_model->get_pro_showlist();
			$this->view->display('pro_up', $a_data);
		}
	}

	//产品分类显示隐藏
	public function pro_switch() {
		$id  =  $this->general->post('id');
		$a_data = $this->db->get_row('pro', ['pro_id' => $id]);
		if ($a_data['is_show'] == 1) {
			$a_is_show = [
				'is_show' => 2,
			];
			$aou = 2;
		} else {
			$aou = 1;
			$a_is_show = [
				'is_show' => 1,
			];
		}
		$i_result = $this->db->update('pro', $a_is_show, ['pro_id' => $id]);
		if (isset($i_result)) {
			echo json_encode(array('code'=>20, 'kou'=>$aou));
		} else {
			echo json_encode(array('code'=>44));
		}
	}

	//产品分类删除
	public function pro_delete() {
		//接收需要删除的分类id
		$type = $this->general->post('out');
		if ($type == 1) {
			$id   = $this->general->post('id');
			// 验证分类是否有子分类 如果有则删除
			$son_count = $this->pro_model->get_cate_son($id);
			if ($son_count > 0) {
				echo json_encode(array('code'=> 400, 'msg'=>'请移动或删除该分类下的子分类再进行操作'));
				die;
			}
			$i_result = $this->pro_model->delete_one($id);
			if ($i_result) {
				echo json_encode(array('code'=> 33));
			} else {
				echo json_encode(array('code'=> 66));
			}
		} else {
			$new_ids = $this->general->post('id');
			// // 验证是否符合删除条件
			// for ($i = 0; $i<count($id); $i++) {
			// 	$son_count = $this->pro_model->get_cate_son($id[$i]);
			// 	if ($son_count == 0) {
			// 		$new_ids[] = $id[$i];
			// 	}
			// }
			if (empty($new_ids)) {
				echo json_encode(array('code'=>400, 'msg'=>'没有符合删除条件的分类'));
				die;
			}
			$i_result = $this->db->where_in('pro_id', $new_ids)->delete('pro');
			if ($i_result) {
				echo json_encode(array('code'=>33, 'msg'=>'删除成功', 'data'=>$new_ids));
			} else {
				echo json_encode(array('code'=>60, 'msg'=>'删除失败', 'data'=>$new_ids));
			}
		}
	}

	//产品
	public function product() {
		$i_one   = $this->router->get(1) ? $this->router->get(1) : 0;
		$i_two   = $this->router->get(2) ? $this->router->get(2) : 0;
		$i_three = $this->router->get(3) ? $this->router->get(3) : 0;
		$i_four  = $this->general->base64_convert($this->router->get(4), true) ? $this->general->base64_convert($this->router->get(4), true) : '';
		$a_data = [
			'i_one'   => $i_one,
			'i_two'   => $i_two,
			'i_three' => $i_three,
			'i_four'  => $i_four,
			'i_pag'   => $i_pag 
		];
		$a_where = "`goods_stye` = 1";
		if ( ! empty($i_one)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`proid_id_1` = $i_one";
		}
		if ( ! empty($i_two)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`proid_id_2` = $i_two";
		}
		if ( ! empty($i_three)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`proid_id_3` = $i_three";
		}
		if ( ! empty($i_four)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`antistop` LIKE '%$i_four%'";
		}
		// 先设置默认从第一页开始
		$i_page = $this->router->get(5);
		if (empty($i_page)) {
			$i_page = 1;
		}
		// 设置每页显示的数据行数
		$i_prow = 12;
		// 加载分页类
		$this->load->library('pages');
		// 获取数据总行数，以产品为例
		$i_total = $this->db->get_total('product', $a_where);
		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		$a_data['product'] = $this->db->get('product', $a_where, '', ['order' => 'asc']);
		$a_data['pages'] = $this->pages->link_style_one($this->router->url('product-'.$i_one.'-'.$i_two.'-'.$i_three.'-'.$i_four.'-', [], false, false));
		$a = '';
		foreach ($a_data['product'] as $product) {
			$a .= $product['antistop'].',';
		}
		$a = str_replace(",,",",", $a);
		$a =  ltrim(rtrim($a, ","), ",");
		$a = explode(",", $a);
		$a_data['name']  = array_unique($a);
		//分类
		$a_data['search'] = $this->pro_model->category($i_one, $i_two);
		// print_r($a_data['search']);
		$a_data['price']  = $this->db->limit(0,99999999999)->get('price', ['price >' => 0]);
		$this->view->display('product', $a_data);
	}

	//产品添加
	public function product_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$i_pname      = trim($this->general->post('pname'));
			$i_proid_id_1 = trim($this->general->post('proid_id_1'));
			$i_proid_id_2 = trim($this->general->post('proid_id_2'));
			$i_proid_id_3 = trim($this->general->post('proid_id_3'));
			$i_order      = trim($this->general->post('order'));
			$i_antistop   = trim(rtrim($this->general->post('antistop'), ","));
			$i_details    = trim($this->general->post('details', false));
			$i_wen        = $this->general->post('wen');
			$i_time       = implode(",",$this->general->post('time'));
			$a_images     = trim($this->general->post('mainpic_path'));
			$a_img        = $this->general->post('otherpic_path');
			$a_goodsename = $this->db->get('product', ['product_name' => $i_pname]);
			if ( ! empty($a_goodsename)) {
			 	$this->error->show_error('填写产品名重复，请修改！', 'product_add', false, 2);
			} 
			$a_data = [
				'product_name' => $i_pname,
				'proid_id_1'   => $i_proid_id_1,
				'proid_id_2'   => $i_proid_id_2,
				'proid_id_3'   => $i_proid_id_3,
				'pro_show'     => 1,
				'goods_stye'   => 1,
				'order'        => $i_order,
				'antistop'     => $i_antistop,
				'pro_details'  => $i_details,
				'pro_image'    => $a_img,
				'pro_img'      => $a_images,
				'supply_time'  => $i_time,
			];
			// print_r($a_data);
			$i_result = $this->db->insert('product', $a_data);
			$this->db->insert('product_number', ['product_id' => $i_result, 'number' => 0]);
			if ( ! empty($i_wen)) {	
				foreach ($i_wen as $id => $nety) {
					$tuup = implode(",", $nety);
					$this->db->insert('product_att', ['product_id' => $i_result, 'stye' => $id, 'attri_id' => $tuup]);
				}
			}
			$a_data['cup'] = $this->pro_model->get_cup_showlist();
			$a_data['cons'] = $this->pro_model->get_cons_showlist();
			foreach ($a_data['cup'] as $key => $cup) {
				$i_cup = $this->general->post('price_'.$cup['cup_id']);
				if ($i_cup) {
					//保存产品杯型价格
					$a_cup = [
						'product_id' => $i_result,
						'cup_id'     => $cup['cup_id'],
						'cup_name'     => $cup['cup_name'],
						'price'      => $i_cup,
					];
					$this->db->insert('price', $a_cup);
					foreach ($a_data['cons'] as $ke => $cons) {
						$con = $this->general->post('cons_'.$cup['cup_id'].'_'.$cons['consumption_id']);
							$a_cons = [
								'product_id'     => $i_result,
								'cup_id'         => $cup['cup_id'],
								'consumption_id' => $cons['consumption_id'],
								'consu_name'     => $cons['consu_name'],
								'amount'         => $con,
							];
							$this->db->insert('product_term', $a_cons);
					}
				}
			}
			if ($i_result) {
				$this->error->show_success('添加成功', 'product', false, 1);
			} else {
				$this->error->show_error('添加失败', 'product_add', false, 1);
			}
		} else {
			$a_data['pro']  = $this->pro_model->get_pro_showlist();
			$a_data['cons'] = $this->pro_model->get_cons_showlist();
			$a_data['cup']  = $this->pro_model->get_cup_showlist();
			// 属性分类
			$a_data['attr'] = $this->db->get('attributive', ['show' => 1],'','', 0,9999999999);
			$a_data['time'] = $this->db->order_by(['time_id'=>'asc'])->limit(0, 9999999)->get('time');
			// print_r($a_data['time']);
			//将数据进行无限级分类整理
			$this->view->display('product_add', $a_data);
		}
	}

	//产品修改
	public function product_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$i_id         = trim($this->general->post('id'));
			$i_pname      = trim($this->general->post('pname'));
			$i_proid_id_1 = trim($this->general->post('proid_id_1'));
			$i_proid_id_2 = trim($this->general->post('proid_id_2'));
			$i_proid_id_3 = trim($this->general->post('proid_id_3'));
			$i_order      = trim($this->general->post('order'));
			$i_wen        = $this->general->post('wen');
			$i_time       = implode(",",$this->general->post('time'));
			$i_antistop   = trim(rtrim($this->general->post('antistop'), ","));
			$i_details    = trim($this->general->post('details', false));
			$a_images     = $this->general->post('mainpic_path');
			$a_img        = $this->general->post('otherpic_path');
			$a_data = [
				'product_name' => $i_pname,
				'proid_id_1'   => $i_proid_id_1,
				'proid_id_2'   => $i_proid_id_2,
				'proid_id_3'   => $i_proid_id_3,
				'order'        => $i_order,
				'antistop'     => $i_antistop,
				'pro_details'  => $i_details,
				'pro_image'    => $a_img,
				'pro_img'      => $a_images,
				'supply_time'  => $i_time,
			];
			$i_result = $this->db->update('product', $a_data, ['product_id' => $i_id]);
			$att = $this->db->delete('product_att', ['product_id' => $i_id]);
			if ( ! empty($i_wen)) {	
				foreach ($i_wen as $id => $nety) {
					$tuup = implode(",", $nety);
					$this->db->insert('product_att', ['product_id' => $i_id, 'stye' => $id, 'attri_id' => $tuup]);
				}
			}
			$a_data['cup'] = $this->pro_model->get_cup_showlist();
			$a_data['cons'] = $this->pro_model->get_cons_showlist();
			$this->db->delete('product_term', ['product_id' => $i_id]);
			$this->db->delete('price', ['product_id' => $i_id]);
			foreach ($a_data['cup'] as $cup) {
				$i_cup = $this->general->post('price_'.$cup['cup_id']);
				if ($i_cup) {
					//保存产品杯型价格
					$a_cup = [
						'product_id' => $i_id,
						'cup_id'     => $cup['cup_id'],
						'cup_name'     => $cup['cup_name'],
						'price'      => $i_cup,
					];
					$this->db->insert('price', $a_cup);
					foreach ($a_data['cons'] as $cons) {
						$con = $this->general->post('cons_'.$cup['cup_id'].'_'.$cons['consumption_id']);
						$a_cons = [
							'product_id'     => $i_id,
							'cup_id'         => $cup['cup_id'],
							'consumption_id' => $cons['consumption_id'],
							'consu_name'     => $cons['consu_name'],
							'amount'         => $con,
						];
						$this->db->insert('product_term', $a_cons);
					}
				}
			}
			if (isset($i_result) || isset($con) || isset($cuptt)) {
				$this->error->show_success('修改成功', 'product', false, 1);
			} else {
				$this->error->show_error('无修改', 'product', false, 1);
			}
		} else {
			$i_id = $this->router->get(1);
			$a_data['product'] = $this->db->get_row('product', ['product_id' => $i_id]);
			$a_data['price']   = $this->db->limit(0, 999999999)->get('price', ['product_id' => $i_id]);
			$a_data['term']    = $this->db->limit(0, 999999999)->get('product_term', ['product_id' => $i_id]);
			$a_data['pro']  = $this->pro_model->get_pro_showlist();
			$a_data['cons'] = $this->pro_model->get_cons_showlist();
			$a_data['cup']  = $this->pro_model->get_cup_showlist();
			// 属性分类
			$a_data['attr'] = $this->db->get('attributive', ['show' => 1],'','', 0,9999999999);
			$a_data['time'] = $this->db->order_by(['time_id'=>'asc'])->limit(0, 9999999)->get('time');
			//产品属性温度
			$a_wendu  = $this->db->get('product_att', ['product_id' => $i_id]);
			foreach ($a_wendu as $key => $value) {
				$a = explode(",", $value['attri_id']);
				foreach ($a as $t) {
					$c[] = $t;
				}
			}
			$a_data['wendu'] = $c;
			$this->view->display('product_update', $a_data);
		}
	}

	//产品分类显示隐藏
	public function product_switch() {
		$id  =  $this->general->post('id');
		$a_data = $this->db->get_row('product', ['product_id' => $id]);
		if ($a_data['pro_show'] == 1) {
			$a_pro_show = [
				'pro_show' => 2,
			];
		} else {
			$a_pro_show = [
				'pro_show' => 1,
			];
		}
		$i_result = $this->db->update('product', $a_pro_show, ['product_id' => $id]);
		if (isset($i_result)) {
			echo json_encode(array('code'=>20));
		}
	}

	//产品分类删除
	public function product_delete() {
		//type为1代表删除单条，为2代表批量删除
		// $type = $this->general->post('type');
		// if ($type == 1) {
			$i_id  = $this->general->post('id');
			$i_result = $this->db->delete('product', ['product_id' =>$i_id]);
			$i_result = $this->db->delete('price', ['product_id' =>$i_id]);
			$i_result = $this->db->delete('product_term', ['product_id' =>$i_id]);
			if ($i_result) {
				echo json_encode(200);
			} else {
				echo json_encode(400);
			}
		// } else if ($type == 2) {
		// 	$i_id = $this->general->post('id');
		// 	$i_result = $this->db->where_in('product_id', $i_id)->delete('product');
		// 	$i_result = $this->db->where_in('price', $i_id)->delete('product');
		// 	$i_result = $this->db->where_in('product_term', $i_id)->delete('product');
		// 	if ($i_result) {
		// 		echo json_encode(array('code'=>200));
		// 	} else {
		// 		echo json_encode(array('code'=>400));
		// 	}
		// }
	}
	// //产品图片上传
	// public function imge() {
	// 	$a_images = $_FILES['file'];
	// 	$url = "./upload/goods";
	// 	$name = "file";
	// 	if ( ! empty($a_images)) {
	// 		$a_images = $this->image_model->image_add($url,$name);
	// 	}	
	// 	if ($a_images) {
 //            echo json_encode(array('code'=> 200, 'msg'=>'上传成功', 'data'=> $a_images));
 //        } else {
 //            echo json_encode(array('code'=> 400, 'msg'=>'上传失败', 'data'=> ''));
 //        }
	// }
	//产品图片删除
	public function img_del() {
		$dtype = trim($this->general->post('dtype'));
		$id    = $this->general->post('record_id');
		$img   = $this->general->post('image_path');
		$del   = unlink($img);
		if ($del) {
			if ($dtype == 2) {
				$a_data = $this->db->get_row('product', ['product_id' => $id]);
	    		$imge = explode(",", $a_data['pro_image']);
	    		foreach ($imge as $image) {
	    			if ($image != $img) {
					 	$imag .= $image.',';
	    			}
	    		}
	    		$imag = rtrim($imag, ",");
				$this->db->update('product', ['pro_image' => $imag], ['product_id' => $id]);
			}			
			echo json_encode(array('code'=> 200, 'msg'=>'删除成功'));
		} else {
			echo json_encode(array('code'=> 400, 'msg'=>'删除失败'));
		}
	}

	//产品分类2级
	public function proid_id_2() {
		$i_id_1 = $this->general->post('id');
		$a_pro  = $this->db->limit(0, 999999999)->get('pro', ['pro_pid' => $i_id_1]);
		echo json_encode($a_pro);
	}

	//产品分类2级
	public function proid_id_3() {
		$i_id_1 = $this->general->post('id');
		$a_pro  = $this->db->limit(0, 999999999)->get('pro', ['pro_pid' => $i_id_1]);
		echo json_encode($a_pro);
	}
	/**
	 * 获取子孙树
	 * @param   array        $data   待分类的数据
	 * @param   int/string   $id     要找的子节点id
	 * @param   int          $lev    节点等级
	 */
	public function getSubTree($data , $id = 0 , $lev = 1) {
     	static $son = array();
     	foreach($data as $key => $value) {
 			if($value['pro_pid'] == $id) {
	            $value['proid'] = $lev;
	            $son[] = $value;
	            $this->getSubTree($data, $value['pro_id'] , $lev+1);
	        }
	    }
	    return $son;
	}
}
?>