<?php

class Cate_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('cate_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 分类列表 *************************************/

	public function cate_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data = $this->cate_model->get_cate_showlist();
			//将数据进行无限级分类整理
			$a_data['cate'] = $this->getSubTree($a_data, 0, 0);
			$a_data['type'] = 1;
			$this->view->display('cate_showlist2', $a_data);
		}
	}

/************************************* 增加分类 *************************************/

	public function cate_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$cate_name        = trim($this->general->post('cate_name'));
			$is_show          = trim($this->general->post('is_show'));
			$cate_description = trim($this->general->post('cate_description'));
			$pid_lev          = trim($this->general->post('pid_lev'));
			if ($pid_lev == 999) {
				$cate_pid   = 0;
				$cate_level = 0;
			} else {
				$pid_lev    = explode('-', $pid_lev);
				$cate_pid   = $pid_lev[0];
				$cate_level = $pid_lev[1]+1;
			}
			// 验证是否同名分类
			$i_total = $this->cate_model->get_same_cate($cate_pid, $cate_name);
			if ($i_total > 0) {
				$this->error->show_error('当前已经存在该分类', 'cate_showlist', false, 2);
			}
			//组装数据并保存到数据
			$a_data = [
				'cate_name'        => $cate_name,
				'cate_pid'         => $cate_pid,
				'cate_level'       => $cate_level,
				'is_show'          => $is_show,
				'cate_description' => $cate_description,
			];
			$i_result = $this->cate_model->insert_cate($a_data);
			if ($i_result) {
				$this->error->show_success('添加成功', 'cate_showlist', false, 2);
			} else {
				$this->error->show_error('添加失败', 'cate_showlist', false, 2);
			}
		} else {
			// 先查找所有的分类数据并分配到模板
			$a_data = $this->cate_model->get_cate_showlist();
			// 将数据进行无限级分类整理
			$a_data = $this->getSubTree($a_data, 0, 0);
			$this->view->display('cate_add2', $a_data);
		}
	}

/************************************* 修改分类 *************************************/

	public function cate_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$cate_id          = $this->general->post('cate_id');
			$cate_name        = trim($this->general->post('cate_name'));
			$is_show          = trim($this->general->post('is_show'));
			$cate_description = trim($this->general->post('cate_description'));
			$pid_lev          = trim($this->general->post('pid_lev'));
			if ($pid_lev == 999) {
				$cate_pid   = 0;
				$cate_level = 0;
			} else {
				$pid_lev    = explode('-', $pid_lev);
				$cate_pid   = $pid_lev[0];
				$cate_level = $pid_lev[1]+1;
			}
			//组装数据并保存到数据
			$a_where = [
				'cate_id'    => $cate_id
			];
			$a_data = [
				'cate_name'        => $cate_name,
				'cate_pid'         => $cate_pid,
				'cate_level'       => $cate_level,
				'is_show'          => $is_show,
				'cate_description' => $cate_description,
			];
			$i_result = $this->cate_model->update_cate($a_where, $a_data);
			if ($i_result) {
				$this->error->show_success('修改成功', 'cate_showlist', false, 2);
			} else {
				$this->error->show_error('修改失败', 'cate_showlist', false, 2);
			}
		} else {
			$cate_id = $this->router->get(1);
			//获取原数据并分配到模板
			$a_data['self'] = $this->cate_model->get_cate_one($cate_id);
			// 查找自己所有的子类
			$a_son = $this->cate_model->get_this_son($cate_id);
			if (!empty($a_son)) {
				foreach ($a_son as $key => $value) {
					$son_ids[] = $value['cate_id'];
				}
				$son_ids[] = $cate_id;
				//查找所有非自己的子分类和自己的分类并分配到模板
				$a_data['all'] = $this->cate_model->get_cate_part($son_ids);
			} else {
				$son_ids[] = $cate_id;
				//查找所有非自己的子分类信息并分配到模板
				$a_data['all'] = $this->cate_model->get_cate_part($son_ids);
			}
			//将数据进行无限级分类整理
			$a_data['all'] = $this->getSubTree($a_data['all'], 0, 0);
			$this->view->display('cate_update2', $a_data);
		}
	}

/************************************* 删除分类 *************************************/

	public function cate_delete() {
		// 接收参数
		$type = trim($this->general->post('type'));
		if ($type == 1) {
			$cate_id = trim($this->general->post('cate_id'));
			// 验证是否符合删除条件
			$a_data = $this->cate_model->get_cate_one($cate_id);
			if ($a_data['cate_newscount'] > 0) {
				echo json_encode(array('code'=> 400, 'msg'=>'请移动或删除该分类下的新闻再进行删除操作'));
				die;
			}
			// 验证分类是否有子分类 如果有则删除
			$son_count = $this->cate_model->get_cate_son($cate_id);
			if ($son_count > 0) {
				echo json_encode(array('code'=> 400, 'msg'=>'请移动或删除该分类下的子分类再进行操作'));
				die;
			}
			$i_result = $this->cate_model->delete_cate($cate_id);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
			}
		} else {
			$cate_ids = $this->general->post('cate_ids');
			// 验证是否符合删除条件
			for ($i = 0; $i<count($cate_ids); $i++) {
				$a_data = $this->cate_model->get_cate_one($cate_ids[$i]);
				if ($a_data['cate_newscount'] == 0) {
					$son_count = $this->cate_model->get_cate_son($cate_ids[$i]);
					if ($son_count == 0) {
						$new_ids[] = $cate_ids[$i];
					}
				}
			}
			if (empty($new_ids)) {
				echo json_encode(array('code'=>400, 'msg'=>'没有符合删除条件的分类'));
				die;
			}
			$i_result = $this->cate_model->delete_cate_mony($new_ids);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'删除成功', 'data'=>$new_ids));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
			}
		}
	}

/************************************* 启用停用 *************************************/

	public function cate_switch() {
		// 接收分类id
		$cate_id = trim($this->general->post('cate_id'));
		// 获取原数据
		$a_data = $this->cate_model->get_cate_one($cate_id);
		if ($a_data['is_show'] == 0) {
			$a_data_u = [
				'is_show' => 1,
			];
		} else {
			$a_data_u = [
				'is_show' => 0,
			];
		}
		$a_where = [
			'cate_id' => $cate_id
		];
		$i_result = $this->cate_model->update_cate($a_where, $a_data_u);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'设置成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'设置失败'));
		}
	}

/************************************** 分类搜索 ************************************/

	public function cate_search() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$keywords = trim($this->general->post('keywords'));
		} else {
			$keywords = urldecode($this->router->get(1));
		}
		$a_data['cate']     = $this->cate_model->get_cate_search($keywords);
		$a_data['type']     = 6;
		$a_data['keywords'] = $keywords;
		$this->view->display('cate_showlist2', $a_data);
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
	         if($value['cate_pid'] == $id) {
	             $value['cate_level'] = $lev;
	             $son[] = $value;
	             $this->getSubTree($data, $value['cate_id'] , $lev+1);
	         }
	     }
	     return $son;
	 }

/************************************************************************************/

}

?>