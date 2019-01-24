<?php
class Attr_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('attr_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

	// 属性分类列别
	public function attri() {
		$a_name  = $this->general->post('name');
		$a_data = [
		 	'a_name' => $a_name,
		];
		$a_where = '';
		if ( ! empty($a_name)) {			
			$a_where = ['attri_name LIKE' => '%'.$a_name.'%'];
		}
		$a_data['pro'] = $this->db->limit(0, 999999999)->get('attributive', $a_where);
		// print_r($a_data['pro']);
		$this->view->display('attri', $a_data);
	}


	//属性分类添加
	public function attri_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$i_show     = trim($this->general->post('show'));
			$a_name     = trim($this->general->post('name'));
			$i_proid    = trim($this->general->post('proid'));
			$pro_id_1   = trim($this->general->post('pro_id_1'));
			$pro_id_2   = trim($this->general->post('pro_id_2'));
			$a_goodsename = $this->db->limit(0, 999999999)->get('attributive', ['attri_name' => $a_name]);
			if (!empty($a_goodsename)) {
			 	$this->error->show_error('填写属性分类名重复，请修改！', 'attri_add', false, 2);
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
				'attri_name' => $a_name,
				'attri_cupid'=> $pro_pid,
				'grade'      => $i_proid,
				'attri_id_1' => $pro_id_1[0],
				'attri_id_2' => $pro_id_2[0],
				'show'       => $i_show,
			];
			$i_result = $this->db->insert('attributive', $a_data);
			if ($i_result) {
				$this->error->show_success('添加成功', 'attri', false, 1);
			} else {
				$this->error->show_error('添加失败', 'attri', false, 1);
			}
		} else {								
			$a_data = $this->db->limit(0, 999999999)->get('attributive', ['grade' => 1]);
			$this->view->display('attri_add', $a_data);	
		}
	}

	//属性分类修改
	public function attri_up() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
				$son_count = $this->db->get_total('attributive',['attri_cupid' => $i_id]);
				if ($son_count > 0) {
					$this->error->show_error('请移动或删除该分类下的子分类再进行操作', 'attri_up-'.$i_id, false, 1);
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
				'attri_name' => $a_name,
				'attri_cupid'=> $pro_pid,
				'grade'      => $i_proid,
				'attri_id_1' => $pro_id_1[0],
				'attri_id_2' => $pro_id_2[0],
				'show'       => $i_show,
			];
			$i_result = $this->db->update('attributive', $a_data, ['attri_id' => $i_id]);
			if ($i_result) {
				$this->error->show_success('修改成功', 'attri', false, 1);
			} else {
				$this->error->show_error('无修改', 'attri', false, 1);
			}
		} else {
			$i_id = $this->router->get(1);
			$a_data['pro'] = $this->db->get_row('attributive', ['attri_id' => $i_id]);
			// print_r($a_data['pro']);
			$a_data['ali'] = $this->attr_model->get_pro_showlist();
			$this->view->display('attri_up', $a_data);
		}
	}

	//属性分类显示隐藏
	public function attri_switch() {
		$id  =  $this->general->post('id');
		$a_data = $this->db->get_row('attributive', ['attri_id' => $id]);
		if ($a_data['show'] == 1) {
			$a_is_show = [
				'show' => 2,
			];
			$aou = 2;
		} else {
			$aou = 1;
			$a_is_show = [
				'show' => 1,
			];
		}
		$i_result = $this->db->update('attributive', $a_is_show, ['attri_id' => $id]);
		if (isset($i_result)) {
			echo json_encode(array('code'=>20, 'kou'=>$aou));
		} else {
			echo json_encode(array('code'=>44));
		}
	}

	//属性分类删除
	public function attri_delete() {
		//接收需要删除的分类id
		$type = $this->general->post('out');
		if ($type == 1) {
			$id   = $this->general->post('id');
			// 验证分类是否有子分类 如果有则删除
			$son_count = $this->attr_model->get_cate_son($id);
			if ($son_count > 0) {
				echo json_encode(array('code'=> 400, 'msg'=>'请移动或删除该分类下的子分类再进行操作'));
				die;
			}
			$i_result = $this->attr_model->delete_one($id);
			if ($i_result) {
				echo json_encode(array('code'=> 33));
			} else {
				echo json_encode(array('code'=> 66));
			}
		} else {
			$new_ids = $this->general->post('id');
			// 验证是否符合删除条件
			// for ($i = 0; $i<count($id); $i++) {
			// 	$son_count = $this->attr_model->get_cate_son($id[$i]);
			// 	if ($son_count == 0) {
			// 		$new_ids[] = $id[$i];
			// 	}
			// }
			if (empty($new_ids)) {
				echo json_encode(array('code'=>400, 'msg'=>'没有符合删除条件的分类'));
				die;
			}
			$i_result = $this->db->where_in('attri_id', $new_ids)->delete('attributive');
			if ($i_result) {
				echo json_encode(array('code'=>33, 'msg'=>'删除成功', 'data'=>$new_ids));
			} else {
				echo json_encode(array('code'=>60, 'msg'=>'删除失败', 'data'=>$new_ids));
			}
		}
	}

	//属性分类2级
	public function attri_id_2() {
		$i_id_1 = $this->general->post('id');
		$a_pro  = $this->db->limit(0, 999999999)->get('attributive', ['attri_cupid' => $i_id_1]);
		echo json_encode($a_pro);
	}
}
?>