<?php

class Mood_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('mood_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 帖子列表 *************************************/

	public function mood_showlist() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$state = $this->router->get(1);
			$time = $this->router->get(2);
			if ($state === false) {
				$state = 9;
			}
			if (empty($time)) {
				$time = 9;
			}
			$a_data = $this->mood_model->get_mood_page($state, $time);
			$a_data['type']  = 1;
			$a_data['state'] = $state;
			$a_data['time']  = $time;
			// 获取所有标签
			$a_data['tag'] = $this->mood_model->get_tag_all();
			$this->view->display('mood_showlist2', $a_data);
		}
	}

/************************************* 帖子开关 *************************************/

	public function mood_switch() {
		$mood_id = trim($this->general->post('mood_id'));
		$a_data = $this->mood_model->get_mood_one($mood_id);
		$mood_state = $a_data['mood_state'];
		$a_where = [
			'mood_id' => $mood_id
		];
		if ($mood_state == 1) {
			$a_update_data = [
				'mood_state' => 0,
			];
		} else {
			$a_update_data = [
				'mood_state' => 1,
			];
		}
		$i_result = $this->mood_model->update_mood($a_where, $a_update_data);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'设置成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'设置失败'));
		}
	}

/************************************* 删除帖子 *************************************/

	public function mood_delete() {
		$type = trim($this->general->post('type'));
		if ($type==1) {
			$mood_id = $this->general->post('mood_id');
			$i_result = $this->mood_model->delete_mood_one($mood_id);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>200, 'msg'=>'删除失败'));
			}
		} else {
			$mood_ids = $this->general->post('mood_ids');
			$i_result = $this->mood_model->delete_mood_mony($mood_ids);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
			} else {
				echo json_encode(array('code'=>200, 'msg'=>'删除失败'));
			}
		}
	}

/************************************* 搜索帖子 *************************************/

	public function mood_search() {
		$keywords = urldecode($this->router->get(1));
		$a_data = $this->mood_model->get_mood_search($keywords);
		$a_data['type'] = 6;
		$a_data['keywords'] = $keywords;
		$a_data['tag'] = $this->mood_model->get_tag_all();
		$this->view->display('mood_showlist2', $a_data);
	}

/************************************* 预览帖子 *************************************/

	public function mood_preview() {
		$mood_id = trim($this->general->post('mood_id'));
		// 根据id获取一条动态信息
		$a_data['mood'] = $this->mood_model->get_mood_row($mood_id);
		$a_data['mood']['mood_time'] = date('Y-m-d H:i:s', $a_data['mood']['mood_time']);
		if (!empty($a_data['mood']['mood_pic'])) {
			$a_data['pic'] = explode('&', $a_data['mood']['mood_pic']);
		}
		// 获取动态的评论
		$a_data['discuss'] = $this->mood_model->get_mood_discuss($mood_id);
		foreach ($a_data['discuss'] as $key => $value) {
			$value['discuss_time'] = date('Y-m-d H:i:s', $value['discuss_time']);
			$new_data[] = $value;
		}
		$a_data['discuss'] = $new_data;
		echo json_encode($a_data);
	}

/************************************* 删除评论 *************************************/

	public function discuss_delete() {
		$discuss_id = trim($this->general->post('discuss_id'));
		$mood_id    = trim($this->general->post('mood_id'));
		$i_result = $this->mood_model->delete_discuss($discuss_id);
		if ($i_result) {
			// 重新计算动态的评论数
			$discuss_num = $this->mood_model->get_discuss_total($mood_id);
			// 更新动态表
			$a_where_u = [
				'mood_id' => $mood_id,
			];
			$a_data_u = [
				'mood_discuss' => $discuss_num,
			];
			$this->mood_model->update_mood($a_where_u, $a_data_u);
			echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
		}
	}

/************************************* 评论动态 *************************************/

	public function mood_discuss() {
		$discuss_content = trim($this->general->post('discuss_content'));
		$mood_id         = trim($this->general->post('mood_id'));
		$a_data = [
			'mood_id'         => $mood_id,
			'user_id'         => 0,
			'discuss_content' => $discuss_content,
			'discuss_time'    => $_SERVER['REQUEST_TIME'],
			'discuss_pid'     => 0,
			'discuss_leval'   => 0,
			'discuss_like'    => 0,
		];
		$i_result = $this->mood_model->insert_discuss($a_data);
		if ($i_result) {
			// 重新计算动态的评论数
			$discuss_num = $this->mood_model->get_discuss_total($mood_id);
			// 更新动态表
			$a_where_u = [
				'mood_id' => $mood_id,
			];
			$a_data_u = [
				'mood_discuss' => $discuss_num,
			];
			$this->mood_model->update_mood($a_where_u, $a_data_u);
			echo json_encode(array('code'=>200, 'msg'=>'评论成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'评论失败'));
		}
	}

/************************************* 评论回复 *************************************/

	public function discuss_reply() {
		$discuss_content = trim($this->general->post('discuss_content'));
		$mood_id         = trim($this->general->post('mood_id'));
		$discuss_id      = trim($this->general->post('discuss_id'));
		$a_data = [
			'mood_id'         => $mood_id,
			'user_id'         => 0,
			'discuss_content' => $discuss_content,
			'discuss_time'    => $_SERVER['REQUEST_TIME'],
			'discuss_pid'     => $discuss_id,
			'discuss_leval'   => 1,
			'discuss_like'    => 0,
		];
		$i_result = $this->mood_model->insert_discuss($a_data);
		if ($i_result) {
			// 重新计算动态的评论数
			$discuss_num = $this->mood_model->get_discuss_total($mood_id);
			// 更新动态表
			$a_where_u = [
				'mood_id' => $mood_id,
			];
			$a_data_u = [
				'mood_discuss' => $discuss_num,
			];
			$this->mood_model->update_mood($a_where_u, $a_data_u);
			echo json_encode(array('code'=>200, 'msg'=>'回复评论成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'回复评论失败'));
		}
	}

/************************************* 动态点赞 *************************************/

	public function discuss_like() {
		//接收数据
		$discuss_id = trim($this->general->post('discuss_id'));
		//验证之前否点过赞
		$a_data = $this->mood_model->get_discusslike_one(0, $discuss_id);
		if ($a_data) {
			//之前点过赞则取消点赞
			$i_result = $this->mood_model->delete_discusslike($a_data['dlike_id']);
			if ($i_result) {
				//更新对应评论的点赞总数
				$a_where = [
					'discuss_id' => $discuss_id
				];
				$i_total = $this->mood_model->get_discusslike_total($discuss_id);
				$a_shuju = [
					'discuss_like' => $i_total
				];
				$this->mood_model->update_discuss($a_where, $a_shuju);
				echo json_encode(array('code'=>200, 'msg'=>'取消点赞成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'取消点赞失败'));
			}
		} else {
			//之前未点过赞则插入一条点赞记录
			$a_insert_data = [
				'user_id'    => 0,
				'discuss_id' => $discuss_id,
				'dlike_time' => $_SERVER['REQUEST_TIME'],
			];
			$i_result = $this->mood_model->insert_discusslike($a_insert_data);
			if ($i_result) {
				//点赞成功更新对应评论的点赞总数
				$a_where = [
					'discuss_id' => $discuss_id
				];
				$i_total = $this->mood_model->get_discusslike_total($discuss_id);
				$a_shuju = [
					'discuss_like' => $i_total
				];
				$this->mood_model->update_discuss($a_where, $a_shuju);
				echo json_encode(array('code'=>200, 'msg'=>'点赞成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'点赞失败'));
			}
		}
	}

/************************************* 添加标签 *************************************/

	public function tag_add() {
		$tag_name = trim($this->general->post('tag_name'));
		// 验证是否为空
		if (empty($tag_name)) {
			echo json_encode(array('code'=>400, 'msg'=>'标签名不能为空'));
			die;
		}
		// 验证是否添加过此标签
		$i_result = $this->mood_model->get_tag_name($tag_name);
		if ($i_result) {
			echo json_encode(array('code'=>400, 'msg'=>'此标签已经存在'));
			die;
		} else {
			// 不存在则添加
			$a_data_insert = [
				'tag_name' => $tag_name,
				'tag_time' => $_SERVER['REQUEST_TIME']
			];
			$i_result = $this->mood_model->insert_tag($a_data_insert);
			if ($i_result) {
				echo json_encode(array('code'=>200, 'msg'=>'添加标签成功', 'newid'=>$i_result));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'添加标签失败'));
			}
		}
	}

/********************************** 给动态设置标签 **********************************/

	public function mood_addtag() {
		$mood_id = trim($this->general->post('mood_id'));
		$tag_ids = $this->general->post('tag_ids');
		// 获取标签
		$a_data_tag = $this->mood_model->get_tag_ids($tag_ids);
		foreach ($a_data_tag as $key => $value) {
			$new_data[] = $value['tag_name'];
		}
		$mood_keywords = implode(',', $new_data);
		$mood_tags     = implode(',', $tag_ids);
		$a_where = [
			'mood_id' => $mood_id,
		];
		$a_data = [
			'mood_keywords' => $mood_keywords,
			'mood_tags'     => $mood_tags,
		];
		$i_result = $this->mood_model->update_mood($a_where, $a_data);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'设置标签成功', 'data'=>$a_data_tag));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'设置标签失败'));
		}
	}

/************************************* 删除标签 *************************************/

	public function tag_delete() {
		$tag_id = trim($this->general->post('tag_id'));
		$i_result = $this->mood_model->delete_tag($tag_id);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'删除标签成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'删除标签失败'));
		}
	}

/************************************************************************************/

}

?>