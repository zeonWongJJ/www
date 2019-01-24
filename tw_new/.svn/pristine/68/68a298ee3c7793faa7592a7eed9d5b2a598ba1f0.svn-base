<?php
defined('BASEPATH') or exit('禁止访问！');
class Group_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('group_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/***************************************** 分组管理 *****************************************/

	public function group_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$store_id = $_SESSION['store_id'];
			// 获取当前门店所有分组信息
			$a_data['group'] = $this->group_model->get_group_showlist($store_id);
			//获取所有权限
			$a_data['auth'] = $this->group_model->get_auth_all();
			//将数据进行无限极分类整理
			$a_data['auth'] = $this->getSubTree($a_data['auth'], 0 , 0);
			$this->view->display('group_showlist2', $a_data);
		}
	}

/***************************************** 添加分组 *****************************************/

	public function group_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收信息
			$group_name = trim($this->general->post('group_name'));
			$group_auth_str = $this->general->post('group_auth');
			// 将权限ids拆分成数组
			$group_auth = explode('-', $group_auth_str);
			$group_description = trim($this->general->post('group_description'));
			// 验证必填填项是否为空
			if (empty($group_name) || empty($group_auth_str)) {
				$this->error->show_error('必填项是否为空', 'group_showlist', false, 2);die;
			}
			//查询权限表拿到相应权限
			$a_data = $this->group_model->get_auth_all();
			foreach ($a_data as $key => $value) {
				foreach ($group_auth as $k => $v) {
					if ($v==$value['auth_id'] && $value['auth_url']!='') {
						$url[] = $value['auth_url'];
					}
				}
			}
			//将权限url拼接成字符串
			$auth_url = implode('-', $url);
			//角色权限总数
			$auth_count = count($group_auth);
			//将权限id拼接成字符串
			$auth_ids = implode(',', $group_auth);
			//将数据插入到角色表中
			$a_data = [
				'group_name'        => $group_name,
				'group_auth'        => $auth_url,
				'group_description' => $group_description,
				'add_time'          => $_SERVER['REQUEST_TIME'],
				'auth_ids'          => $auth_ids,
				'group_state'       => 1,
				'store_id'          => $_SESSION['store_id'],
				'auth_count'        => $auth_count,
				'manager_count'     => 0
			];
			$i_result = $this->group_model->insert_group($a_data);
			if ($i_result) {
				$this->error->show_success('添加分组成功', 'group_showlist', false, 2);
			} else {
				$this->error->show_error('添加分组失败', 'group_showlist', false, 2);
			}
		} else {
			//获取所有权限
			$a_data = $this->group_model->get_auth_all();
			//将数据进行无限极分类整理
			$a_data = $this->getSubTree($a_data, 0 , 0);
			$this->view->display('group_add', $a_data);
		}
	}

/***************************************** 修改分组 *****************************************/

	public function group_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收信息
			$group_id          = trim($this->general->post('group_id'));
			$group_name        = trim($this->general->post('group_name'));
			$group_state       = trim($this->general->post('group_state'));
			$group_auth_str    = $this->general->post('group_auth');
			$group_auth        = explode('-', $group_auth_str);
			$group_description = trim($this->general->post('group_description'));
			//查询权限表拿到相应权限
			$a_data = $this->group_model->get_auth_all();
			foreach ($a_data as $key => $value) {
				foreach ($group_auth as $k => $v) {
					if ($v==$value['auth_id'] && $value['auth_url']!='') {
						$url[] = $value['auth_url'];
					}
				}
			}
			//将权限url拼接成字符串
			$auth_url = implode('-', $url);
			//角色权限总数
			$auth_count = count($group_auth);
			//将权限id拼接成字符串
			$auth_ids = implode(',', $group_auth);
			//将数据插入到角色表中
			$a_where = [
				'group_id' => $group_id
			];
			$a_data = [
				'group_name'        => $group_name,
				'group_state'       => $group_state,
				'group_auth'        => $auth_url,
				'group_description' => $group_description,
				'auth_ids'          => $auth_ids,
				'update_time'       => $_SERVER['REQUEST_TIME'],
			];
			$i_result = $this->group_model->update_group($a_where, $a_data);
			if ($i_result) {
				$this->error->show_success('修改分组成功', 'group_showlist', false, 2);
			} else {
				$this->error->show_error('修改分组失败', 'group_showlist', false, 2);
			}
		} else {
			// 获取需要修改的分组id
			$group_id = $this->router->get(1);
			// 获取原数据
			$a_data['detail'] = $this->group_model->get_group_one($group_id);
			// 查询所有权限信息分配给模板
			$a_data['auth'] = $this->group_model->get_auth_all();
			// 将数据进行无限极分类整理
			$a_data['auth'] = $this->getSubTree($a_data['auth'], 0 , 0);
			// 当前已有的权限
			$a_data['present'] = explode(',', $a_data['detail']['auth_ids']);
			$this->view->display('group_update2', $a_data);
		}
	}

/***************************************** 删除分组 *****************************************/

	public function group_delete() {
		// type = 1 代表单个删除 为2代表批量删除
		$type = $this->general->post('type');
		if ($type==1) {
			//接收需要删除的分组id
			$group_id = $this->general->post('group_id');
			// 验证当前分组下是否有管理员 有则阻止删除
			$i_total = $this->group_model->get_manager_total($group_id);
			if ($i_total) {
				echo json_encode(array('code'=>400,'msg'=>'当前分组有管理员，不允许删除'));
				die;
			} else {
				$i_result = $this->group_model->delete_group_one($group_id);
				if ($i_result) {
					echo json_encode(array('code'=>200, 'msg'=>'删除成功'));die;
				} else {
					echo json_encode(array('code'=>400, 'msg'=>'删除失败'));die;
				}
			}
		} else {
			// 接收需要删除的分组ids数组
			$group_ids = $this->general->post('group_ids');
			for ($i=0; $i<count($group_ids); $i++) {
				// 验证当前分组下是否有管理员 有则阻止删除
				$i_total = $this->group_model->get_manager_total($group_ids[$i]);
				if ($i_total == 0) {
					$this->group_model->delete_group_one($group_ids[$i]);
					$a_result[] = $group_ids[$i];
				}
			}
			if (!empty($a_result)) {
				echo json_encode(array('code'=>200, 'msg'=>'删除成功', 'data'=>$a_result));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
			}
		}
	}

/***************************************** 分组开关 *****************************************/

	public function group_switch(){
		//接收分组id
		$group_id = $this->general->post('group_id');
		$a_data = $this->group_model->get_group_one($group_id);
		$a_where = [
			'group_id' => $group_id
		];
		if ($a_data['group_state']==0) {
			$a_update_data = [
				'group_state' => 1
			];
		} else {
			$a_update_data = [
				'group_state' => 0
			];
		}
		$i_result = $this->group_model->update_group($a_where, $a_update_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'设置成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'设置失败'));
		}
	}

/***************************************** 搜索分组 *****************************************/

	public function group_search() {
		$keywords = trim($this->general->post('keywords'));
		if (empty($keywords)) {
			echo json_encode(array('code'=>400, 'msg'=>'关键词不能为空', 'data'=>''));die;
		}
		$a_data = $this->group_model->get_group_search($keywords);
		if (empty($a_data)) {
			echo json_encode(array('code'=>500, 'msg'=>'未搜索到任何数据', 'data'=>''));
		} else {
			foreach ($a_data as $key => $value) {
				$value['add_time'] = date('Y-m-d', $value['add_time']);
				$new_data[] = $value;
			}
			echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$new_data));
		}
	}

/**************************************** 无限极分类 ****************************************/

	/**
	 * 获取子孙树
	 * @param   array        $data   待分类的数据
	 * @param   int/string   $id     要找的子节点id
	 * @param   int          $lev    节点等级
	 */
	 public function getSubTree($data , $id = 0 , $lev = 1) {
	     static $son = array();
	     foreach($data as $key => $value) {
	         if($value['auth_pid'] == $id) {
	             $value['auth_level'] = $lev;
	             $son[] = $value;
	             $this->getSubTree($data, $value['auth_id'] , $lev+1);
	         }
	     }
	     return $son;
	 }

/********************************************************************************************/

}

?>