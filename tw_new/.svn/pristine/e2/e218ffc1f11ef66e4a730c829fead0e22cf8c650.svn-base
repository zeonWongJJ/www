<?php
class Notice_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
		$this->load->model('notice_model');
	}
	
	// 自定义通知
	public function custom() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$a_post = $this->general->post();
			if (empty($a_post['content'])) {
				$this->error->show_error('通知内容必填！');
			} else {
				$a_data = [
					'id_user' => $_SESSION['user']['id_user'],
					'id_project' => -10,
					'title' => $a_post['title'],
					'notifier' => $a_post['notifier'],
					'content' => $a_post['content']
				];
				$this->notice_model->weixin_multiple($a_data, $_SESSION['user']['id_user']);
				$this->error->show_success('通知已发送！', '/', false, 2);
			}
		} else {
			
			$this->view->display('notice_custom');
		}
	}
	
	// 发送的通知列表
	public function sent() {
		$i_page = $this->router->get(2);
		$data = $this->notice_model->get_page($_SESSION['user']['id_user'], $i_page, 'SENT');
		$this->view->display('notice_list', $data);
	}
	
	public function receive() {
		$i_page = $this->router->get(2);
		$a_data = $this->notice_model->get_page($_SESSION['user']['id_user'], $i_page, 'RECEIVE');
		$this->view->display('notice_list', $a_data);
	}
	
	public function update_state() {
		$i_id_notice = intval($this->general->post('notice'));
		if ($i_id_notice) {
			$a_data['state'] = $this->notice_model->update_state($i_id_notice);
			echo json_encode($a_data);
		}
	}
	
	public function get_last() {
		$i_id_notice = intval($this->general->post('notice'));
		$a_notice_last = $this->db->get('notice', ['id_notice >' => $i_id_notice, 'id_receiver' => $_SESSION['user']['id_user'], 'state' => 30], 'id_notice, content, link', ['id_notice' => 'DESC']);
		echo json_encode($a_notice_last);
	}
}
?>