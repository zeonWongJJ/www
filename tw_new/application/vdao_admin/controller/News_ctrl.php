<?php

class News_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('news_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 新闻列表 *************************************/

	public function news_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收栏目id
			$cate_id = $this->router->get(1);
			$a_data['cate']  = $this->news_model->get_cate_all();
			if (empty($cate_id)) {
				$cate_id = 'all';
			}
			if ($cate_id != 'all') {
				// 获取分类的信息
				$a_this_cate     = $this->news_model->get_cate_one($cate_id);
				if ($a_this_cate['cate_level'] == 0) {
					$a_data['cate_one'] = $a_this_cate['cate_id'];
					$a_data['cate_two'] = 'all';
					$a_data['cate_three'] = 'all';
				} else if ($a_this_cate['cate_level'] == 1) {
					$a_data['cate_one'] = $a_this_cate['cate_pid'];
					$a_data['cate_two'] = $a_this_cate['cate_id'];
					$a_data['cate_three'] = 'all';
				} else if ($a_this_cate['cate_level'] == 2) {
					$a_get_topcate     = $this->news_model->get_cate_one($a_this_cate['cate_pid']);
					$a_data['cate_one'] = $a_get_topcate['cate_pid'];
					$a_data['cate_two'] = $a_this_cate['cate_pid'];
					$a_data['cate_three'] = $a_this_cate['cate_id'];
				}
				$a_this_son = $this->mytree_son($a_data['cate'], $a_this_cate['cate_id'], 0);
			} else {
				$a_data['cate_one'] = 'all';
				$a_data['cate_two'] = 'all';
				$a_data['cate_three'] = 'all';
			}
			$a_this_son[] = $a_this_cate['cate_id'];
			$a_news = $this->news_model->get_news_showlist($cate_id, $a_this_son);
			$a_data['news']    = $a_news['news'];
			$a_data['count']   = $a_news['count'];
			$a_data['cate_id'] = $cate_id;
			$a_data['cateids'] = $a_this_son;
			$this->view->display('news_showlist2', $a_data);
		}
	}

/******************************** 获取分类下所有子类id ******************************/

	public function mytree_son($a_data, $cate_pid, $cate_level) {
		static $son = array();
		foreach ($a_data as $key => $value) {
			if ($value['cate_pid'] == $cate_pid) {
				$son[] = $value['cate_id'];
				$this->mytree_son($a_data, $value['cate_id'], $cate_level+1);
			}
		}
		return $son;
	}

/******************************* 获取分类下所有父类id ******************************/

	public function mytree_parent($a_data, $a_this_son) {
		static $parent = array();
		foreach ($a_data as $key => $value) {
			if ($a_this_son['cate_pid'] == $value['cate_id']) {
				$parent[] = $value['cate_id'];
				if ($value['cate_pid'] != 0) {
					$this->mytree_parent($a_data, $value);
				}
			}
		}
		return $parent;
	}

/************************************* 添加新闻 *************************************/

	public function news_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交过的信息
			$news_title       = trim($this->general->post('news_title'));
			$news_content     = $this->general->post('news_content', false);
			$news_keywords    = trim($this->general->post('news_keywords'));
			$news_description = trim($this->general->post('news_description'));
			$cate_id          = trim($this->general->post('cate_id'));
			//验证数据
			if (empty($news_title) || empty($news_content)) {
				$a_parameter = [
					'msg'      => '必填项不能为空',
					'url'      => 'news_add',
					'log'      => false,
					'wait'     => 2,
				];
				$this->error->show_error($a_parameter);
			}
			//将关键词里的中文逗号替换成英文逗号
			if (!empty($news_keywords)) {
				$news_keywords = str_replace('，', ',', $news_keywords);
			}
			//判断是否有描述，没有则截取内容的前120位
			if (empty($news_description)) {
				$news_description = substr(strip_tags($news_content), 0, 120);
			}
			//组装数据并保存到数据
			$a_data = [
				'news_title'       => $news_title,
				'news_content'     => $news_content,
				'news_keywords'    => $news_keywords,
				'news_description' => $news_description,
				'news_time'        => $_SERVER['REQUEST_TIME'],
				'news_uid'         => $_SESSION['admin_id'],
				'news_click'       => 0,
				'cate_id'          => $cate_id,
				'news_state'       => 1,
			];
			$i_result = $this->news_model->insert_news($a_data);
			$a_parameter = [
				'msg'      => '添加新闻成功',
				'url'      => 'news_showlist',
				'log'      => false,
				'wait'     => 2,
			];
			if ($i_result) {
				// 添加新闻成功后将新闻分类的文章数加1
				$a_this_son = $this->news_model->get_cate_one($cate_id);
				// 获取所有分类
				$a_cate = $this->news_model->get_cate_all();
				// 获取所有父分类id
				$a_cate_par = $this->mytree_parent($a_cate, $a_this_son);
				// 加上本身
				$a_cate_par[] = $cate_id;
				// 将所有分类的文章数加1
				for ($i=0; $i < count($a_cate_par); $i++) {
					$a_cate_row = $this->news_model->get_cate_one($a_cate_par[$i]);
					$a_where = [
						'cate_id' => $a_cate_par[$i],
					];
					$a_data = [
						'cate_newscount' => $a_cate_row['cate_newscount'] + 1,
					];
					$this->news_model->update_cate($a_where, $a_data);
				}
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '添加新闻失败';
				$a_parameter['url'] = 'news_add';
				$this->error->show_error($a_parameter);
			}
		} else {
			$a_data = $this->news_model->get_cate_show();
			//将数据进行无限级分类整理
			$a_data = $this->getSubTree($a_data, 0, 0);
			$this->view->display('news_add2', $a_data);
		}
	}

/************************************* 修改新闻 *************************************/

	public function news_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交过的信息
			$news_id          = $this->general->post('news_id');
			$news_title       = trim($this->general->post('news_title'));
			$news_content     = $this->general->post('news_content', false);
			$news_keywords    = trim($this->general->post('news_keywords'));
			$news_description = trim($this->general->post('news_description'));
			$cate_id          = trim($this->general->post('cate_id'));
			$original_cate    = trim($this->general->post('original_cate'));
			//验证数据
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'news_update-' . $news_id,
				'log'      => false,
				'wait'     => 2,
			];
			if (empty($news_title) || empty($news_content)) {
				$this->error->show_error($a_parameter);
			}
			//将关键词里的中文逗号替换成英文逗号
			if (!empty($news_keywords)) {
				$news_keywords = str_replace('，', ',', $news_keywords);
			}
			//判断是否有描述，没有则截取内容的前12位
			if (empty($news_description)) {
				$news_description = substr(strip_tags($news_content), 0, 120);
			}
			//组装数据并保存到数据
			$a_data = [
				'news_title'       => $news_title,
				'news_content'     => $news_content,
				'news_keywords'    => $news_keywords,
				'news_description' => $news_description,
				'cate_id'          => $cate_id,
			];
			$a_where = [
				'news_id' => $news_id
			];
			$i_result = $this->news_model->update_news($a_where, $a_data);
			if ($i_result) {
				// 修改成功后判断分类是否和之前一样
				if ($cate_id != $original_cate) {
					// 获取所有分类
					$a_cate = $this->news_model->get_cate_all();
					// 将原来的分类减1
					$a_this_son = $this->news_model->get_cate_one($original_cate);
					// 获取所有父分类id
					$a_cate_par = $this->mytree_parent($a_cate, $a_this_son);
					// 加上本身
					$a_cate_par[] = $original_cate;
					// 将所有分类的文章数加1
					foreach ($a_cate_par as $key => $value) {
						$a_cate_row = $this->news_model->get_cate_one($value);
						$a_where = [
							'cate_id' => $value,
						];
						$a_data = [
							'cate_newscount' => $a_cate_row['cate_newscount'] - 1,
						];
						$this->news_model->update_cate($a_where, $a_data);
					}
				}
				$a_cate_par = array();
				if ($cate_id != $original_cates) {
					// 如果分类不一样刚将新分类文章数加1,旧分类减1
					$a_this_son = $this->news_model->get_cate_one($cate_id);
					// 获取所有分类
					$a_cate = $this->news_model->get_cate_all();
					// 获取所有父分类id
					$a_cate_par = $this->mytree_parent_two($a_cate, $a_this_son);
					// 加上本身
					$a_cate_par[] = $cate_id;
					// 将所有分类的文章数加1
					foreach ($a_cate_par as $key => $value) {
						$a_cate_row = $this->news_model->get_cate_one($value);
						$a_where = [
							'cate_id' => $value,
						];
						$a_data = [
							'cate_newscount' => $a_cate_row['cate_newscount'] + 1,
						];
						$this->news_model->update_cate($a_where, $a_data);
					}
				}
				$a_parameter['msg'] = '修改新闻成功';
				$a_parameter['url'] = 'news_showlist';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '修改新闻失败';
				$a_parameter['url'] = 'news_update-'.$news_id;
				$this->error->show_error($a_parameter);
			}
		} else {
			//接收需要修改新闻的id
			$news_id = $this->router->get(1);
			//查询原来的数据
			$a_data['news'] = $this->news_model->get_news_one($news_id);
			//查找分类信息并分配到模板
			$a_data['cate'] = $this->news_model->get_cate_all();
			//将数据进行无限级分类整理
			$a_data['cate'] = $this->getSubTree($a_data['cate'], 0, 0);
			$this->view->display('news_update2', $a_data);
		}
	}

/************************************* 删除新闻 *************************************/

	public function news_delete() {
		// $type 为1时代表单个删除 为2时代表批量删除
		$type = $this->general->post('type');
		if ($type==1) {
			$news_id = $this->general->post('news_id');
			$a_news_row = $this->news_model->get_news_one($news_id);
			$i_result = $this->news_model->delete_news_one($news_id);
			if ($i_result) {
				// 删除新闻成功后将新闻分类的文章数-1
				$a_this_son = $this->news_model->get_cate_one($a_news_row['cate_id']);
				// 获取所有分类
				$a_cate = $this->news_model->get_cate_all();
				// 获取所有父分类id
				$a_cate_par = $this->mytree_parent($a_cate, $a_this_son);
				// 加上本身
				$a_cate_par[] = $a_news_row['cate_id'];
				// 将所有分类的文章数加1
				for ($i=0; $i < count($a_cate_par); $i++) {
					$a_cate_row = $this->news_model->get_cate_one($a_cate_par[$i]);
					$a_where = [
						'cate_id' => $a_cate_par[$i],
					];
					$a_data = [
						'cate_newscount' => $a_cate_row['cate_newscount'] - 1,
					];
					$this->news_model->update_cate($a_where, $a_data);
				}
				echo json_encode(array('code'=>200,'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400,'msg'=>'删除失败'));
			}
		} else {
			$news_ids = $this->general->post('news_ids');
			$i_result = $this->news_model->delete_news_mony($news_ids);
			if ($i_result) {
				// 获取所有分类
				$a_cate = $this->news_model->get_cate_all();
				// for ($i=0; $i < count($news_ids); $i++) {
				// 	// 删除新闻成功后将新闻分类的文章数-1
				// 	$a_this_son = $this->news_model->get_cate_one($news_ids[$i]);
				// 	// 获取所有父分类id
				// 	$a_cate_par = $this->mytree_parent($a_cate, $a_this_son);
				// 	// 加上本身
				// 	$a_cate_par[] = $a_this_son['cate_id'];
				// 	// 将所有分类的文章数加1
				// 	for ($j=0; $j < count($a_cate_par); $j++) {
				// 		$a_cate_row = $this->news_model->get_cate_one($a_cate_par[$j]);
				// 		$a_where = [
				// 			'cate_id' => $a_cate_par[$j],
				// 		];
				// 		$a_data = [
				// 			'cate_newscount' => $a_cate_row['cate_newscount'] - 1,
				// 		];
				// 		$this->news_model->update_cate($a_where, $a_data);
				// 	}
				// }
				echo json_encode(array('code'=>200,'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>400,'msg'=>'删除失败'));
			}
		}
	}

/************************************* 预览新闻 *************************************/

	public function news_preview() {
		//接收需要预览的新闻id
		$news_id = trim($this->general->post('news_id'));
		//获取新闻信息
		$a_data = $this->news_model->get_news_one($news_id);
		if (empty($a_data)) {
			echo json_encode(array('code'=> 400, 'msg'=> '数据为空', 'data'=> ''));
		} else {
			$a_data['news_time1'] = date('Y-m-d', $a_data['news_time']);
			$a_data['news_time2'] = date('H:i:s', $a_data['news_time']);
			echo json_encode(array('code'=> 200, 'msg'=> '获取成功', 'data'=> $a_data));
		}
	}

/************************************* 显示隐藏 *************************************/

	public function news_switch() {
		$news_id = $this->general->post('news_id');
		//获取原来的状态
		$a_data = $this->news_model->get_news_one($news_id);
		if ($a_data['news_state']==1) {
			$a_update_data = [
				'news_state' => 0,
			];
		} else {
			$a_update_data = [
				'news_state' => 1,
			];
		}
		$a_update_where = [
			'news_id' => $news_id,
		];
		$i_result = $this->news_model->update_news($a_update_where, $a_update_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'设置成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'设置失败'));
		}
	}

/************************************* 新闻搜索 *************************************/

	public function news_search() {
		$keywords = $this->general->post('keywords');
		if (empty($keywords)) {
			echo json_encode(array('code'=>400,'msg'=>'关键词不能为空'));
			die;
		}
		$a_data = $this->news_model->get_news_search($keywords);
		echo json_encode($a_data);
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

/************************************ 无限极分类 ************************************/

	public function mytree_parent_two($a_data, $a_this_son) {
		static $parent_two = array();
		foreach ($a_data as $key => $value) {
			if ($a_this_son['cate_pid'] == $value['cate_id']) {
				$parent_two[] = $value['cate_id'];
				if ($value['cate_pid'] != 0) {
					$this->mytree_parent_two($a_data, $value);
				}
			}
		}
		return $parent_two;
	}

/************************************************************************************/

}

?>