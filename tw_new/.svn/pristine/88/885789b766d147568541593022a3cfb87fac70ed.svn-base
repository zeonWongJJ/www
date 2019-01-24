<?php

class Notice_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('notice_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 公告列表 *************************************/

	public function notice_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data['group']  = $this->notice_model->get_notice_showlist();
			$a_data['notice'] = $this->notice_model->get_notice_all();
			$a_data['count']  = $this->notice_model->get_notice_count();
			$this->view->display('notice_showlist', $a_data);
		}
	}

/************************************* 添加公告 *************************************/

	public function notice_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的数据
			$notice_title   = trim($this->general->post('notice_title'));
			$notice_content = trim($this->general->post('notice_content', false));
			//验证数据合法性
			if (empty($notice_title) || empty($notice_content)) {
				$this->error->show_error('必填项不能为空', 'notice_showlist', false, 2);
			}
			//组装数据并保存到数据库
			$a_data = [
				'notice_title'   => $notice_title,
				'notice_content' => $notice_content,
				'notice_time'    => $_SERVER['REQUEST_TIME'],
				'notice_uid'     => $_SESSION['admin_id'],
			];
			$i_result = $this->notice_model->insert_notice($a_data);
			if ($i_result) {
				$this->error->show_success('发布成功', 'notice_showlist', false, 2);
			} else {
				$this->error->show_error('发布失败', 'notice_showlist', false, 2);
			}
		} else {
			$this->view->display('notice_add');
		}
	}

/************************************* 修改公告 *************************************/

	public function notice_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的数据
			$notice_id      = $this->general->post('notice_id');
			$notice_title   = trim($this->general->post('notice_title'));
			$notice_content = trim($this->general->post('notice_content', false));
			//验证数据合法性
			if (empty($notice_title) || empty($notice_content)) {
				$this->error->show_error('必填项不能为空', 'notice_update-' . $notice_id, false, 2);
			}
			//组装数据并保存到数据库
			$a_where = [
				'notice_id'		 => $notice_id
			];
			$a_data = [
				'notice_title'   => $notice_title,
				'notice_content' => $notice_content,
			];
			$i_result = $this->notice_model->update_notice($a_where, $a_data);
			if ($i_result) {
				$this->error->show_success('修改成功', 'notice_showlist', false, 2);
			} else {
				$this->error->show_error('修改失败', 'notice_showlist', false, 2);
			}
		} else {
			//接收需要修改的公告id
			$notice_id = $this->router->get(1);
			//获取原数据并分配到模板
			$a_data = $this->notice_model->get_notice_one($notice_id);
			$this->view->display('notice_update', $a_data);
		}
	}

/************************************* 删除公告 *************************************/

	public function notice_delete() {
		//type值为1表示删除单个 为2表示删除多个
		$type = $this->general->post('type');
		if ($type==1) {
			//接收需要删除的公告id
			$notice_id = $this->general->post('notice_id');
			$i_result = $this->notice_model->delete_notice_one($notice_id);
			if ($i_result) {
				echo json_encode(array('code'=>200,'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400,'msg'=>'删除失败'));
			}
		} else {
			//接收需要删除的公告id
			$a_data   = $this->general->post('notice_ids');
			$i_result = $this->notice_model->delete_notice_mony($a_data);
			if ($i_result) {
				echo json_encode(array('code'=>200,'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400,'msg'=>'删除失败'));
			}
		}
	}

/************************************* 预览公告 *************************************/

	public function notice_preview() {
		//接收需要预览的公告id
		$notice_id = trim($this->general->post('notice_id'));
		$a_data    = $this->notice_model->get_notice_one($notice_id);
		$a_data['notice_time1'] = date('Y-m-d', $a_data['notice_time']);
		$a_data['notice_time2'] = date('H:i:s', $a_data['notice_time']);
		echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$a_data));
	}

/************************************* 显示隐藏 *************************************/

	public function notice_switch() {
		$notice_id = $this->general->post('notice_id');
		//获取原来的状态
		$a_data = $this->notice_model->get_notice_one($notice_id);
		if ($a_data['notice_state']==1) {
			$a_update_data = [
				'notice_state' => 0,
			];
		} else {
			$a_update_data = [
				'notice_state' => 1,
			];
		}
		$a_update_where = [
			'notice_id' => $notice_id,
		];
		$i_result = $this->notice_model->update_notice($a_update_where, $a_update_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'设置成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'设置失败'));
		}
	}

/************************************************************************************/

}

?>