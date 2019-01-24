<?php

class News_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('news_model');
	}

/*********************************** 新闻列表 ***********************************/

	public function news_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收需要查看的分类
			$type = $this->router->get(1);
			if (empty($type)) {
				$type = 'all';
			}
			// 获取新闻分类
			$a_data['cate'] = $this->news_model->get_cate_all();
			$cate_arr = array();
			// 获取所有子分类
			if ($type == 'all') {
				foreach ($a_data['cate'] as $key => $value) {
					$cate_arr[] = $value['cate_id'];
				}
				$a_data['thiscate'] = '全部新闻';
			} else {
				$cate_arr = $this->mytree_son($a_data['cate'], $type);
				$cate_arr[] = $type;
				$a_this_cate = $this->news_model->get_cate_one($type);
				$a_data['thiscate'] = $a_this_cate['cate_name'];
			}
			// 获取新闻列表
			$a_data['news'] = $this->news_model->get_news_page(1, $cate_arr);
			// 当前分类
			$a_data['type'] = $type;
			$this->view->display('news_showlist2', $a_data);
		}
	}

/*********************************** 所有子类 ***********************************/

	public function mytree_son($a_data, $cate_pid) {
		static $son = array();
		foreach ($a_data as $key => $value) {
			if ($value['cate_pid'] == $cate_pid) {
				$son[] = $value['cate_id'];
				$this->mytree_son($a_data, $value['cate_id']);
			}
		}
		return $son;
	}

/*********************************** 所有父类 ***********************************/

	public function mytree_parent($a_data, $cate_pid) {
		static $parent = array();
		foreach ($a_data as $key => $value) {
			if ($cate_pid == $value['cate_id']) {
				$parent[] = $value['cate_id'];
				if ($value['cate_pid'] != 0) {
					$this->mytree_parent($a_data, $value);
				}
			}
		}
		return $parent;
	}

/*********************************** 新闻详情 ***********************************/

	public function news_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//接收需要查看详情的新闻id
			$news_id = $this->router->get(1);
			$a_data['news'] = $this->news_model->get_news_one($news_id);
			$a_data['cate'] = $this->news_model->get_cate_one($a_data['news']['cate_id']);
			$this->view->display('news_detail', $a_data);
		}
	}

/*********************************** 获取更多 ***********************************/

	public function news_getmore() {
		$page = trim($this->general->post('page'));
		$type = trim($this->general->post('type'));
		// 获取新闻分类
		$a_data['cate'] = $this->news_model->get_cate_all();
		$cate_arr = array();
		// 获取所有子分类
		if ($type == 'all') {
			foreach ($a_data['cate'] as $key => $value) {
				$cate_arr[] = $value['cate_id'];
			}
		} else {
			$cate_arr = $this->mytree_son($a_data['cate'], $type);
			$cate_arr[] = $type;
		}
		// 获取新闻列表
		$a_data['news'] = $this->news_model->get_news_page($page, $cate_arr);
		if (empty($a_data['news'])) {
			echo json_encode(array('code'=>400, 'msg'=>'没有更多内容啦', 'data'=>''));
		} else {
			foreach ($a_data['news'] as $key => $value) {
				$value['news_time'] = date('Y-m-d H:i:s', $value['news_time']);
				$subject = strip_tags($value['news_content']);//去除html标签
				$pattern = '/\s/';//去除空白
				$content = preg_replace($pattern, '', $subject);
				$seodata = mb_substr($content, 0, 100);//截取100个汉字
				$value['news_content'] = $seodata;
				$new_data[] = $value;
			}
			echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$new_data));
		}
	}

/********************************************************************************/

}

?>