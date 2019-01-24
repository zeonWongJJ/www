<?php

class Mood_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('mood_model');
		$this->load->model('allow_model');
	}

/*********************************** 发表动态 ***********************************/

	public function mood_add() {
		// 验证是否登录
		$this->allow_model->is_login();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收用户提交的信息
			$mood_content = trim($this->general->post('mood_content'));
			// 验证数据合法性
			$a_parameter = [
				'msg'      => '这是提示信息',
				'url'      => 'user_mood',
				'log'      => false,
				'wait'     => 1,
			];
			if (empty($mood_content)) {
				$a_parameter['msg'] = '动态内容不能为空';
				$a_parameter['url']  = 'mood_add';
				$this->error->show_error($a_parameter);
			}
			// 上传动态图片
			if (!empty($_FILES['file']['name'])) {
				$file          = $_FILES['file'];
				$allow         = array('image/jpeg','image/jpg','image/png');
				$path          = 'upload/mood';
				$maxsize       = 1048576;
	            for ($i=0; $i < count($_FILES['file']['name']); $i++) {
	                $files[$i]['name']     =    $file['name'][$i];
	                $files[$i]['type']     =    $file['type'][$i];
	                $files[$i]['tmp_name'] =    $file['tmp_name'][$i];
	                $files[$i]['error']    =    $file['error'][$i];
	                $files[$i]['size']     =    $file['size'][$i];
	            }
	            for ($i=0; $i<count($files); $i++) {
	                if ($files[$i]['error'] == 0) {
						$file     = $files[$i];
						$img_path = $this->upload_img($file, $allow, $error, $path, $maxsize);
						if ($img_path) {
							$names[] = $img_path;
						}
	                }
	            }
	            if (!empty($names)) {
	            	$mood_pic = implode('&', $names);
	            } else {
	            	$mood_pic = '';
	            }
			} else {
				$mood_pic = '';
			}
            //判断是否需要审核
            $set_name = 'mood_state_review';
            $a_set = $this->mood_model->get_set_one($set_name);
            if ($a_set['set_parameter'] == 0) {
            	$mood_state = 1;
            } else {
            	$mood_state = 0;
            }
            //组装数据并保存到数据库
            $a_data = [
				'user_id'      => $_SESSION['user_id'],
				'mood_pic'     => $mood_pic,
				'mood_content' => $mood_content,
				'mood_time'    => $_SERVER['REQUEST_TIME'],
				'mood_state'   => $mood_state,
				'mood_view'    => 1,
				'mood_type'    => 1,
            ];
            $i_result = $this->mood_model->insert_mood($a_data);
            if ($i_result) {
            	$a_parameter['msg'] = '发布成功';
            	$a_parameter['url'] = 'mood_showlist';
            	$this->error->show_success($a_parameter);
            } else {
            	$a_parameter['msg'] = '发布失败';
            	$a_parameter['url'] = 'mood_showlist';
            	$this->error->show_error($a_parameter);
            }
		} else {
			$this->view->display('mood_add2');
		}
	}

/*********************************** 动态列表 ***********************************/

	public function mood_showlist() {
        // 接收标签id
        $tag_id = $this->router->get(1);
        if (empty($tag_id)) {
            $tag_id = 'all';
            $keywords = 'all';
        } else {
            // 获取一条标签
            $a_tag = $this->mood_model->get_tag_one($tag_id);
            $keywords = $a_tag['tag_name'];
        }
        // 获取动态标签
        $a_data['tag'] = $this->mood_model->get_tag_all();
        // 获取动态
        $a_data['mood'] = $this->mood_model->get_mood_page($keywords, 1);
        if (!empty($a_data['mood'])) {
            // 加上转发的内容
            foreach ($a_data['mood'] as $key => $value) {
                if ($value['mood_type'] == 2) {
                    // 获取转发的那条动态
                    $a_mood_row = $this->mood_model->get_mood_one($value['relay_mood']);
                    $a_user_row = $this->mood_model->get_user_one($a_mood_row['user_id']);
                    $value['relay_uname'] = $a_user_row['user_name'];
                    $value['replay_upic'] = $a_user_row['user_pic'];
                    $value['replay_mcon'] = $a_mood_row['mood_content'];
                    $value['replay_mid'] = $a_mood_row['mood_id'];
                }

                if ($value['mood_time'] > (time()-3600)) {
                    $value['mood_time'] = ceil((time()-$value['mood_time'])/60).'分钟前';
                } else if ($value['mood_time'] > (time()-86400)) {
                    $value['mood_time'] = ceil((time()-$value['mood_time'])/3600).'小时前';
                } else {
                    $value['mood_time'] = date('Y-m-d', $value['mood_time']);
                }
                $new_data[] = $value;
            }
        }
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // 当前标签id
            $a_data['thistag'] = $tag_id;
            // 当前标签
            $a_data['keywords'] = $keywords;
            $a_data['mood'] = $new_data;
            //$this->view->display('mood_showlist2', $a_data);
            $this->view->display('mood_showlist_new', $a_data);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$new_data));
        }
	}

/*********************************** 获取更多 ***********************************/

	public function mood_more() {
		$page = trim($this->general->post('page'));
		$tag_id = trim($this->general->post('tag_id'));
		if ($tag_id == 'all') {
			$keywords = 'all';
		} else {
			// 获取一条标签
			$a_tag = $this->mood_model->get_tag_one($tag_id);
			$keywords = $a_tag['tag_name'];
		}
		// 获取动态
		$a_data = $this->mood_model->get_mood_page($keywords, $page);
		if (empty($a_data)) {
			echo json_encode(array('code'=>400, 'msg'=>'没有更多数据了', 'data'=>''));
		} else {
			foreach ($a_data as $key => $value) {
				if (empty($value['user_pic'])) {
					$value['user_pic'] = '<img src="static/style_default/images/tou_03.png" />';
				} else {
					$value['user_pic'] = '<img src="'.$value['user_pic'].'">';
				}
				if ($value['mood_time'] > (time()-3600)) {
                    $value['mood_time'] = ceil((time()-$value['mood_time'])/60).'分钟前';
                } else if ($value['mood_time'] > (time()-86400)) {
                    $value['mood_time'] = ceil((time()-$value['mood_time'])/3600).'小时前';
                } else {
                    $value['mood_time'] = date('Y-m-d', $value['mood_time']);
                }
				if ($value['mood_type'] == 2) {
					// 获取转发的那条动态
					$a_mood_row = $this->mood_model->get_mood_one($value['relay_mood']);
					$a_user_row = $this->mood_model->get_user_one($a_mood_row['user_id']);
					$value['relay_uname'] = $a_user_row['user_name'];
					$value['replay_upic'] = $a_user_row['user_pic'];
					$value['replay_mcon'] = $a_mood_row['mood_content'];
					$value['replay_mid'] = $a_mood_row['mood_id'];
				}
                $new_data[] = $value;
			}
			echo json_encode(array('code'=>200, 'msg'=>'获取成功', 'data'=>$new_data));
		}
	}

/*********************************** 动态点赞 ***********************************/

	public function mood_like() {
		$mood_id = trim($this->general->post('mood_id'));
		//验证是否登录
		if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
			echo json_encode(array('code'=>500, 'msg'=>'登录后才可以点赞哦！'));
			die;
		}
		//验证之前是否点赞过
		$a_data = $this->mood_model->get_like_one($_SESSION['user_id'], $mood_id);
		if (!$a_data) {
			//如果之前没点赞则插入一条点赞信息
			$a_insert_data = [
				'user_id'   => $_SESSION['user_id'],
				'mood_id'   => $mood_id,
				'like_time' => $_SERVER['REQUEST_TIME']
			];
			$i_result = $this->mood_model->insert_moodlike($a_insert_data);
			if ($i_result) {
				// 点赞成功更新动态表的点赞数据
				$i_total = $this->mood_model->get_like_total($mood_id);
				$a_update_where = [
					'mood_id' => $mood_id
				];
				$a_update_data = [
					'mood_good' => $i_total
				];
				$this->mood_model->update_mood($a_update_where, $a_update_data);
				// 插入一条动态通知信息
				// 获取通知人id
				$a_mood = $this->mood_model->get_mood_one($mood_id);
				$user_id = $a_mood['user_id'];
				$a_msg = [
					'user_id'     => $user_id,
					'send_uid'    => $_SESSION['user_id'],
					'mood_id'     => $mood_id,
					'msg_content' => '赞了你的动态',
					'msg_type'    => 1,
					'msg_time'    => time(),
				];
				$this->mood_model->insert_moodmsg($a_msg);
				echo json_encode(array('code'=>200, 'msg'=>'点赞成功', 'data'=>$i_total));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'点赞失败', 'data'=>''));
			}
		} else {
			// 如果之前点过赞则取消点赞
			$i_result = $this->mood_model->delete_moodlike($a_data['like_id']);
			if ($i_result) {
				//取消点赞成功更新动态表的点赞数据
				$i_total = $this->mood_model->get_like_total($mood_id);
				$a_update_where = [
					'mood_id' => $mood_id
				];
				$a_update_data = [
					'mood_good' => $i_total
				];
				$this->mood_model->update_mood($a_update_where, $a_update_data);
				echo json_encode(array('code'=>200, 'msg'=>'取消点赞成功', 'data'=>$i_total));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'取消点赞失败', 'data'=>''));
			}
		}
	}

/*********************************** 评论动态 ***********************************/

	public function mood_discuss() {
		// 验证是否登录
		if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
			echo json_encode(array('code'=>400, 'msg'=>'登录后才可评论'));
			die;
		}
		// 接收数据
		$mood_id         = $this->general->post('mood_id');
		$discuss_content = trim($this->general->post('discuss_content'));
		$discuss_id      = $this->general->post('discuss_id');
		// 验证数据合法性
		if (strlen($discuss_content) < 3 || strlen($discuss_content) > 255) {
			echo json_encode(array('code'=>400, 'msg'=>'评论长度不合法'));
			die;
		}
		// 将数据保存到数据库
		if (empty($discuss_id)) {
			$a_data = [
				'mood_id'         => $mood_id,
				'user_id'         => $_SESSION['user_id'],
				'discuss_content' => $discuss_content,
				'discuss_time'    => $_SERVER['REQUEST_TIME'],
				'discuss_pid'     => 0,
				'discuss_leval'   => 0,
				'discuss_like'    => 0,
			];
		} else {
			$a_data = [
				'mood_id'         => $mood_id,
				'user_id'         => $_SESSION['user_id'],
				'discuss_content' => $discuss_content,
				'discuss_time'    => $_SERVER['REQUEST_TIME'],
				'discuss_pid'     => $discuss_id,
				'discuss_leval'   => 1,
				'discuss_like'    => 0,
			];
		}
		$i_result = $this->mood_model->insert_discuss($a_data);
		if ($i_result) {
			// 评论成功后修改心情的评论数
			$a_where = [
				'mood_id' => $mood_id
			];
			$i_total = $this->mood_model->get_discuss_total($mood_id);
			$a_shuju = [
				'mood_discuss' => $i_total,
				'last_discuss' => $_SERVER['REQUEST_TIME'],
			];
			$this->mood_model->update_mood($a_where, $a_shuju);
			// 插入一条动态通知信息
			// 获取通知人id
			$a_mood = $this->mood_model->get_mood_one($mood_id);
			$user_id = $a_mood['user_id'];
			$a_msg = [
				'user_id'     => $user_id,
				'send_uid'    => $_SESSION['user_id'],
				'mood_id'     => $mood_id,
				'msg_content' => $discuss_content,
				'msg_type'    => 2,
				'msg_time'    => time(),
			];
			$this->mood_model->insert_moodmsg($a_msg);
			// 获取用户信息
			$a_data = $this->mood_model->gte_user_one($_SESSION['user_id']);
			$this_mood = $this->mood_model->get_mood_one($mood_id);
			echo json_encode(array('code'=>200, 'msg'=>'评论成功', 'data'=>$a_data, 'newcount'=>$this_mood['mood_discuss']));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'评论失败'));
		}
	}

/*********************************** 动态详情 ***********************************/

	public function mood_detail() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// 接收需要查看详情的id
			$mood_id = $this->router->get(1);
			// 获取一条动态
			$a_data['mood'] = $this->mood_model->get_mood_one($mood_id);
			// 判断是否是转发的
			if ($a_data['mood']['mood_type'] == 2) {
				// 获取转发的那条动态
				$a_mood_row = $this->mood_model->get_mood_one($a_data['mood']['relay_mood']);
				$a_user_row = $this->mood_model->get_user_one($a_mood_row['user_id']);
				$a_data['mood']['relay_uname'] = $a_user_row['user_name'];
				$a_data['mood']['replay_upic'] = $a_user_row['user_pic'];
				$a_data['mood']['replay_mcon'] = $a_mood_row['mood_content'];
				$a_data['mood']['replay_mid'] = $a_mood_row['mood_id'];
			}
			// 获取一条动态的点赞信息
			$a_data['like'] = $this->mood_model->get_mood_like($mood_id);
			// 获取转发数据
			$a_data['relay'] = $this->mood_model->get_mood_relay($mood_id);
			// 获取动态的父级评论
			$a_data['discuss_p'] = $this->mood_model->get_discuss_parent($mood_id);
			// 获取动态的子级评论
			$a_data['discuss_s'] = $this->mood_model->get_discuss_son($mood_id);
			$this->view->display('mood_detail2', $a_data);
		}
	}

/*********************************** 回复评论 ***********************************/

	public function discuss_replay() {
		$a_parameter = [
			'msg'      => '登录后才可以评论哦！',
			'url'      => 'login',
			'log'      => false,
			'wait'     => 2,
		];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收数据
			$mood_id         = $this->general->post('mood_id');
			$discuss_pid     = $this->general->post('discuss_pid');
			$discuss_content = trim($this->general->post('discuss_content'));
			//验证数据合法性
			if (strlen($discuss_content) < 3 || strlen($discuss_content) > 255) {
				$a_parameter['msg'] = '评论长度不合法';
				$a_parameter['url'] = 'mood_detail-' . $mood_id;
				$this->error->show_error($a_parameter);
			}
			//将数据保存到数据库
			$a_data = [
				'mood_id'         => $mood_id,
				'user_id'         => $_SESSION['user_id'],
				'discuss_content' => $discuss_content,
				'discuss_time'    => $_SERVER['REQUEST_TIME'],
				'discuss_pid'     => $discuss_pid,
				'discuss_leval'   => 1,
				'discuss_like'    => 0,
			];
			$i_result = $this->mood_model->insert_discuss($a_data);
			if ($i_result) {
				//评论成功后修改心情的评论数
				$a_where = [
					'mood_id' => $mood_id
				];
				$i_total = $this->mood_model->get_discuss_total($mood_id);
				$a_shuju = [
					'mood_discuss' => $i_total,
					'last_discuss' => $_SERVER['REQUEST_TIME'],
				];
				$this->mood_model->update_mood($a_where, $a_shuju);
				// 获取通知人id
				$a_mood = $this->mood_model->get_mood_one($mood_id);
				$user_id = $a_mood['user_id'];
				$a_msg = [
					'user_id'     => $user_id,
					'send_uid'    => $_SESSION['user_id'],
					'mood_id'     => $mood_id,
					'msg_content' => $discuss_content,
					'msg_type'    => 3,
					'msg_time'    => time(),
				];
				$this->mood_model->insert_moodmsg($a_msg);
				$a_parameter['msg'] = '回复成功';
				$a_parameter['url'] = 'mood_detail-' . $mood_id;
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '回复失败';
				$a_parameter['url'] = 'mood_detail-' . $mood_id;
				$this->error->show_error($a_parameter);
			}
		} else {
			//验证是否登录
			if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
				$a_parameter['msg'] = '请登录后再操作';
				$a_parameter['url'] = 'login';
				$this->error->show_error($a_parameter);
			}
			//接收需要评论的动态id
			$mood_id = $this->router->get(1);
			//接收需要回复的评论id
			$discuss_id = $this->router->get(2);
			//获取要评论的动态信息
			$a_data = $this->mood_model->get_mood_one($mood_id);
			$a_data['discuss_pid'] = $discuss_id;
			$this->view->display('discuss_replay', $a_data);
		}
	}

/*********************************** 转发动态 ***********************************/

	public function mood_relay() {
		// 验证是否登录
		$this->allow_model->is_login();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//接收提交的信息
			$mood_content = trim($this->general->post('mood_content'));
			$relay_mood   = $this->general->post('relay_mood');
			$a_parameter = [
				'msg'      => '这是提示信息',
				'url'      => '这是要跳转到的url',
				'log'      => false,
				'wait'     => 1,
			];
			//验证数据合法性
			if (empty($mood_content) || empty($relay_mood)) {
				$a_parameter['msg'] = '必填项不能为空';
				$a_parameter['url'] = 'mood_showlist';
				$this->error->show_error($a_parameter);
			}
            //判断是否需要审核
            $set_name = 'mood_state_review';
            $a_set = $this->mood_model->get_set_one($set_name);
            if ($a_set['set_parameter'] == 0) {
            	$mood_state = 1;
            } else {
            	$mood_state = 0;
            }
            // 组装数据并保存到数据库
            $a_data = [
				'user_id'      => $_SESSION['user_id'],
				'mood_content' => $mood_content,
				'mood_time'    => $_SERVER['REQUEST_TIME'],
				'mood_state'   => $mood_state,
				'mood_view'    => 1,
				'mood_type'    => 2,
				'relay_mood'   => $relay_mood,
            ];
            $i_result = $this->mood_model->insert_mood($a_data);
            if ($i_result) {
            	//转发成功插入一条记录到转发表
            	$a_relay = [
					'mood_id'    => $relay_mood,
					'user_id'    => $_SESSION['user_id'],
					'relay_time' => $_SERVER['REQUEST_TIME'],
            	];
            	$this->mood_model->insert_moodrelay($a_relay);
            	// 更新转发量
            	$a_where = [
            		'mood_id' => $relay_mood
            	];
            	$i_total = $this->mood_model->get_relay_total($relay_mood);
            	$a_mood = [
            		'mood_relay' => $i_total,
            	];
            	$this->mood_model->update_mood($a_where, $a_mood);
				// 获取通知人id
				$a_mood = $this->mood_model->get_mood_one($relay_mood);
				$user_id = $a_mood['user_id'];
				$a_msg = [
					'user_id'     => $user_id,
					'send_uid'    => $_SESSION['user_id'],
					'mood_id'     => $relay_mood,
					'msg_content' => '转发了你的动态',
					'msg_type'    => 4,
					'msg_time'    => time(),
				];
				$this->mood_model->insert_moodmsg($a_msg);
            	$a_parameter['msg'] = '转发成功';
            	$a_parameter['url'] = 'mood_showlist';
            	$this->error->show_success($a_parameter);
            } else {
            	$a_parameter['msg'] = '转发失败';
            	$a_parameter['url'] = 'mood_showlist';
            	$this->error->show_error($a_parameter);
            }
		} else {
			// 接收需要转发的动态id
			$mood_id = $this->router->get(1);
			// 获取需要转发的动态详情
			$a_data = $this->mood_model->get_mood_one($mood_id);
			// 验证是否是原创还是转发他人的
			if ($a_data['mood_type'] == 2 && !empty($a_data['relay_mood'])) {
				$a_data = $this->mood_model->get_mood_one($a_data['relay_mood']);
			}
			$this->view->display('mood_relay2', $a_data);
		}
	}

/*********************************** 评论点赞 ***********************************/

	public function discuss_like() {
		//验证是否登录
		if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
			echo json_encode(array('code'=>500, 'msg'=>'登录后才能点赞哦！'));
			die;
		}
		//接收数据
		$discuss_id = trim($this->general->post('discuss_id'));
		//验证之前否点过赞
		$a_data = $this->mood_model->get_discusslike_one($_SESSION['user_id'], $discuss_id);
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
				'user_id' => $_SESSION['user_id'],
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
				// 获取通知人id
				$a_discuss = $this->mood_model->get_discuss_one($discuss_id);
				$mood_id = $a_discuss['mood_id'];
				$a_mood = $this->mood_model->get_mood_one($mood_id);
				$user_id = $a_mood['user_id'];
				$a_msg = [
					'user_id'     => $user_id,
					'send_uid'    => $_SESSION['user_id'],
					'mood_id'     => $mood_id,
					'msg_content' => '赞了评论',
					'msg_type'    => 5,
					'msg_time'    => time(),
				];
				$this->mood_model->insert_moodmsg($a_msg);
				echo json_encode(array('code'=>200, 'msg'=>'点赞成功'));
			} else {
				echo json_encode(array('code'=>400, 'msg'=>'点赞失败'));
			}
		}
	}

/*********************************** 文件上传 ***********************************/

    /**
     * [upload_img 上传文件函数]
     * @param  [array]  $file           [上传文件的信息]
     * @param  [array]  $allow          [允许的文件上传类型]
     * @param  [string] &$error         [引用传递，用来记录错误信息]
     * @param  [string] $path           [文件上传目录]
     * @param  [int]    $maxsize        [1024*1024 允许文件上传的最大大小]
     * @return [string] $target|false   [成功则返回新文件路径 失败返回false]
     */
    public function upload_img($file, $allow, &$error, $path, $maxsize) {

        switch ($file['error']) {
            case 1 : $error = '超出了上传限制大小';
                return false;
            case 2 : $error = '超出了浏览器表单允许的大小';
                return false;
            case 3 : $error = '文件上传不完整';
                return false;
            case 4 : $error = '请先选择需要上传的文件';
                return false;
            case 7 : $error = '服务器繁忙，稍后再试';
                return false;
        }

        //判断文件大小
        if ($file['size'] > $maxsize) {
            //超出了规定大小
            $error = '上传错误，超出了上传限制大小';
            return false;
        }

        //判断文件类型
        if (!in_array($file['type'],$allow)) {
            $error = '上传的文件类型不正确';
            return false;
        }

        //判断文件夹是否存在 不存在则创建
	    if (!file_exists($path)){
	        mkdir($path);
	    }

        //拼接新的文件名
        $newname = date('Ymdhis',time()) . rand(111, 999) .strrchr($file['name'], '.');
        $target = $path . '/' . $newname;

        //移动临时文件
        $result = move_uploaded_file($file['tmp_name'] , $target);
        if ($result) {
            //移动成功则返回新的文件名
            return $target;
        } else {
            $error = "发生未知错误，上传失败！";
            return false;
        }
    }

/********************************************************************************/

}

?>