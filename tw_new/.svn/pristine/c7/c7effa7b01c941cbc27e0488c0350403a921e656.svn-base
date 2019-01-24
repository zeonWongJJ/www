<?php

class Roomtype_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('roomtype_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 类型列表 *************************************/

	public function type_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data['roomtype'] = $this->roomtype_model->get_type_showlist();
			//将数据进行无限极分类整理
			$a_data['roomtype'] = $this->getSubTree($a_data['roomtype'], 0, 0);
			$a_data['type'] = 9;
			//将数据分配到模板并展示
			$this->view->display('type_showlist2', $a_data);
		}
	}

/************************************* 添加类型 *************************************/

	public function type_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的数据
			$type_name        = trim($this->general->post('type_name'));
			$type_description = trim($this->general->post('type_description'));
			$type_order       = trim($this->general->post('type_order'));
			$type_state       = trim($this->general->post('type_state'));
			$pid_lev          = trim($this->general->post('pid_lev'));
			$type_cate        = trim($this->general->post('type_cate'));
			if ($pid_lev==999) {
				$type_pid   = 0;
				$type_level = 0;
			} else {
				$pid_lev    = explode('-', $pid_lev);
				$type_pid   = $pid_lev[0];
				$type_level = $pid_lev[1] + 1;
			}
			//验证数据
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'type_add',
				'log'      => false,
				'wait'     => 2,
			];
			if (empty($type_name)) {
				$this->error->show_error($a_parameter);
			}
			//组装数据并保存
			$a_data = [
				'type_name'        => $type_name,
				'type_description' => $type_description,
				'type_pid'         => $type_pid,
				'type_level'       => $type_level,
				'type_state'       => $type_state,
				'type_order'       => $type_order,
				'type_cate'        => $type_cate,
			];
			$i_result = $this->roomtype_model->insert_type($a_data);
			if ($i_result) {
				$a_parameter['msg'] = '添加分类成功';
				$a_parameter['url'] = 'type_showlist';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '添加分类失败';
				$this->error->show_error($a_parameter);
			}
		} else {
			//获取所有的类型并分配到模板
			$a_data = $this->roomtype_model->get_type_showlist();
			$a_data = $this->getSubTree($a_data, 0, 0);
			$this->view->display('type_add2', $a_data);
		}
	}

/************************************* 修改类型 *************************************/

	public function type_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的数据
			$type_id          = trim($this->general->post('type_id'));
			$type_name        = trim($this->general->post('type_name'));
			$type_description = trim($this->general->post('type_description'));
			$type_order       = trim($this->general->post('type_order'));
			$type_state       = trim($this->general->post('type_state'));
			$pid_lev          = trim($this->general->post('pid_lev'));
			$type_cate        = trim($this->general->post('type_cate'));
			if ($pid_lev==999) {
				$type_pid   = 0;
				$type_level = 0;
			} else {
				$pid_lev    = explode('-', $pid_lev);
				$type_pid   = $pid_lev[0];
				$type_level = $pid_lev[1] + 1;
			}
			//验证数据
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'type_showlist',
				'log'      => false,
				'wait'     => 2,
			];
			if (empty($type_name)) {
				$this->error->show_error($a_parameter);
			}
			//组装数据并保存
			$a_where = [
				'type_id' => $type_id
			];
			$a_data = [
				'type_name'        => $type_name,
				'type_description' => $type_description,
				'type_pid'         => $type_pid,
				'type_level'       => $type_level,
				'type_state'       => $type_state,
				'type_order'       => $type_order,
				'type_cate'        => $type_cate,
			];
			$i_result = $this->roomtype_model->update_type($a_where, $a_data);
			if ($i_result) {
				$a_parameter['msg'] = '修改类型成功';
				$a_parameter['url'] = 'type_showlist';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '修改类型失败';
				$a_parameter['url'] = 'type_showlist';
				$this->error->show_error($a_parameter);
			}
		} else {
			//接收需要修改的类型id
			$type_id = $this->router->get(1);
			//获取所有的类型并分配到模板
			$a_data['detail'] = $this->roomtype_model->get_type_one($type_id);
			$a_data['type'] = $this->roomtype_model->get_type_showlist();
			$a_data['type'] = $this->getSubTree($a_data['type'], 0, 0);
			$this->view->display('type_update2', $a_data);
		}
	}

/************************************* 删除类型 *************************************/

	public function type_delete() {
		// $type值为1代表单个删除 为2代表多个删除
		$type = trim($this->general->post('type'));
		if ($type==1) {
			$type_id = $this->general->post('type_id');
			//判断类型下面是否有子类或者房间 有则阻止删除
			$check_type_son = $this->roomtype_model->get_son_total($type_id);
			if ($check_type_son) {
				echo json_encode(array('code'=>400, 'msg'=>'请先删除子类'));
				die;
			}
			$check_type_room = $this->roomtype_model->get_room_total($type_id);
			if ($check_type_room) {
				echo json_encode(array('code'=>400, 'msg'=>'请先删除此分类下的房间'));
				die;
			}
			$i_result = $this->roomtype_model->delete_type_one($type_id);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
			}
		} else {
			 $type_ids = $this->general->post('type_ids');
			 $length = count($type_ids);
			 for ($i=0; $i<$length; $i++) {
				//判断类型下面是否有子类或者房间 有则阻止删除
				$check_type_son = $this->roomtype_model->get_son_total($type_ids[$i]);
				$check_type_room = $this->roomtype_model->get_room_total($type_ids[$i]);
				if ($check_type_son != 0 || $check_type_room != 0) {
					unset($type_ids[$i]);
				}
			 }
			 if (empty($type_ids)) {
			 	echo json_encode(array('code'=>400, 'msg'=>'没有符合删除条件的项'));
			 	die;
			 }
			 $i_result = $this->roomtype_model->delete_type_mony($type_ids);
			 $type_ids = implode(',', $type_ids);
			 if ($i_result) {
			 	echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
			 } else {
			 	echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
			 }
		}
	}

/************************************* 类型开关 *************************************/

	public function type_switch() {
		//接收参数
		$type_id = $this->general->post('type_id');
		//获取原来的状态
		$a_data = $this->roomtype_model->get_type_one($type_id);
		if ($a_data['type_state']==1) {
			$a_update_data = [
				'type_state' => 0,
			];
		} else {
			$a_update_data = [
				'type_state' => 1,
			];
		}
		$a_update_where = [
			'type_id' => $type_id
		];
		$i_result = $this->roomtype_model->update_type($a_update_where, $a_update_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'设置成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'设置失败'));
		}
	}

/************************************* 类型搜索 *************************************/

	public function type_search() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$keywords = trim($this->general->post('keywords'));
		} else {
			$keywords = urldecode($this->router->get(1));
		}
		$a_data['roomtype'] = $this->roomtype_model->get_type_search($keywords);
		$a_data['keywords'] = $keywords;
		$a_data['type'] = 6;
		$this->view->display('type_showlist2', $a_data);
	}

/********************************* ajax获取一条类型 *********************************/

	public function type_cate() {
		$type_id = trim($this->general->post('type_id'));
		$a_data = $this->roomtype_model->get_type_one($type_id);
		if ($a_data) {
			echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$a_data));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'获取失败', 'data'=>''));
		}
	}

/************************************ 无限极分类 ************************************/

	/**
	 * 获取子孙树
	 * @param   array        $data   待分类的数据
	 * @param   int/string   $id     要找的子节点id
	 * @param   int          $lev    节点等级
	 */
	 public function getSubTree($data , $id = 0 , $lev = 1) {
	     static $son = array();
	     foreach($data as $key => $value) {
	         if($value['type_pid'] == $id) {
	             $value['type_level'] = $lev;
	             $son[] = $value;
	             $this->getSubTree($data, $value['type_id'] , $lev+1);
	         }
	     }
	     return $son;
	 }

/************************************************************************************/

}

?>