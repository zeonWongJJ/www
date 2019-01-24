<?php

class Notice_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('notice_model');
	}

/*********************************** 公告列表 ***********************************/

	public function notice_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$a_data['notice'] = $this->notice_model->get_notice_page(1);
			$this->view->display('notice_showlist2', $a_data);
		}
	}

/*********************************** 公告详情 ***********************************/

	public function notice_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要查看详情的公告id
			$notice_id = $this->router->get(1);
			$a_data = $this->notice_model->get_notice_one($notice_id);
			$this->view->display('notice_detail2', $a_data);
		}
	}

/*********************************** 获取更多 ***********************************/

	public function notice_getmore() {
		$page = trim($this->general->post('page'));
		$a_data = $this->notice_model->get_notice_page($page);
		if (empty($a_data)) {
			echo json_encode(array('code'=>400, 'msg'=>'没有更多数据啦', 'data'=>''));
		} else {
			foreach ($a_data as $key => $value) {
				$value['notice_time'] = date('Y年m月d日 H:i:s', $value['notice_time']);
				$subject = strip_tags($value['notice_content']);//去除html标签
				$pattern = '/\s/';//去除空白
				$content = preg_replace($pattern, '', $subject);
				$seodata = mb_substr($content, 0, 100);//截取100个汉字
				$value['notice_content'] = $seodata;
				$new_data[] = $value;
			}
			echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$new_data));
		}
	}

/********************************************************************************/

}

?>