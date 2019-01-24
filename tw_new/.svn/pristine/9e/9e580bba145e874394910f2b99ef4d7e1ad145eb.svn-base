<?php
defined('BASEPATH') or exit('禁止访问！');
class Comment_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('comment_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************** 添加标签 **************************************/

	public function comtag_add() {
		$comtag_name = trim($this->general->post('comtag_name'));
		$comtag_type = trim($this->general->post('comtag_type'));
		$comtag_cate = trim($this->general->post('comtag_cate'));
		if (empty($comtag_name) || empty($comtag_type) || empty($comtag_cate)) {
			echo json_encode(array('code'=>400, 'msg'=>'数据不完整'));
			die;
		}
		$a_data = [
			'comtag_name' => $comtag_name,
			'comtag_type' => $comtag_type,
			'comtag_cate' => $comtag_cate,
			'add_time'    => $_SERVER['REQUEST_TIME'],
			'store_id'    => $_SESSION['store_id'],
		];
		$i_result = $this->comment_model->insert_comtag($a_data);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'添加成功', 'data'=>$i_result));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'添加失败'));
		}
	}

/************************************** 删除标签 **************************************/

	public function comtag_delete() {
		$comtag_id = trim($this->general->post('comtag_id'));
		$i_result = $this->comment_model->delete_comtag($comtag_id);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
		}
	}

/************************************** 房间评价 **************************************/

	public function comment_room() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$comment_cate = $this->router->get(1);
			if (empty($comment_cate)) {
				$comment_cate = 9;
			}
			$comment_empty = $this->router->get(2);
			if (empty($comment_empty)) {
				$comment_empty = 9;
			}
			$a_data['allcomment'] = $this->comment_model->get_comment_all($_SESSION['store_id']);
			$good_week_one       = 0;
			$good_month_one      = 0;
			$good_month_three    = 0;
			$good_month_six      = 0;
			$good_month_sixago   = 0;
			$good_all            = 0;

			$middle_week_one     = 0;
			$middle_month_one    = 0;
			$middle_month_three  = 0;
			$middle_month_six    = 0;
			$middle_month_sixago = 0;
			$middle_all          = 0;

			$bad_week_one        = 0;
			$bad_month_one       = 0;
			$bad_month_three     = 0;
			$bad_month_six       = 0;
			$bad_month_sixago    = 0;
			$bad_all             = 0;

			$week_all            = 0;
			$month_one_all       = 0;
			$month_three_all     = 0;
			$month_six_all       = 0;
			$month_sixago_all    = 0;
			$all_all             = 0;

			$service_score       = 0;
			$goods_score         = 0;

			$thistime       = $_SERVER['REQUEST_TIME'];
			$weektime       = $thistime - (3600*24*7);
			$monthtime      = $thistime - (3600*24*30);
			$threemonthtime = $thistime - (3600*24*30*3);
			$sixmonthtime   = $thistime - (3600*24*30*6);
			foreach ($a_data['allcomment'] as $key => $value) {
				// 周统计
				if ($value['comment_time'] >= $weektime) {
					$week_all++;
					if ($value['comment_cate'] == 1) {
						$good_week_one++;
					} else if ($value['comment_cate'] == 2) {
						$middle_week_one++;
					} else if ($value['comment_cate'] == 3) {
						$bad_week_one++;
					}
				}
				// 月统计
				if ($value['comment_time'] >= $monthtime) {
					$month_one_all++;
					if ($value['comment_cate'] == 1) {
						$good_month_one++;
					} else if ($value['comment_cate'] == 2) {
						$middle_month_one++;
					} else if ($value['comment_cate'] == 3) {
						$bad_month_one++;
					}
				}
				// 三个月统计
				if ($value['comment_time'] >= $threemonthtime) {
					$month_three_all++;
					if ($value['comment_cate'] == 1) {
						$good_month_three++;
					} else if ($value['comment_cate'] == 2) {
						$middle_month_three++;
					} else if ($value['comment_cate'] == 3) {
						$bad_month_three++;
					}
				}
				// 六个月统计
				if ($value['comment_time'] >= $sixmonthtime) {
					$month_six_all++;
					if ($value['comment_cate'] == 1) {
						$good_month_six++;
					} else if ($value['comment_cate'] == 2) {
						$middle_month_six++;
					} else if ($value['comment_cate'] == 3) {
						$bad_month_six++;
					}
				}
				// 六个月之前统计
				if ($value['comment_time'] < $sixmonthtime) {
					$month_sixago_all++;
					if ($value['comment_cate'] == 1) {
						$good_month_sixago++;
					} else if ($value['comment_cate'] == 2) {
						$middle_month_sixago++;
					} else if ($value['comment_cate'] == 3) {
						$bad_month_sixago++;
					}
				}

				// 总好评 总中评 总差评统计
				if ($value['comment_cate'] == 1) {
					$good_all++;
				} else if ($value['comment_cate'] == 2) {
					$middle_all++;
				} else if ($value['comment_cate'] == 3) {
					$bad_all++;
				}
				$all_all++;
				$service_score = $service_score + $value['service_score'];
				$goods_score   = $goods_score + $value['goods_score'];
			}
			// 好评率 好评总个数/评论总条数
			if ($good_all == 0) {
				$good_ratio = 0;
			} else {
				$good_ratio = round($good_all/$all_all, 2)*100;
			}
			// 服务态度 总分/评论总条数
			if ($service_score != 0) {
				$service_score = round($service_score/$all_all, 1);
			}
			// 服务质量 总分/评论总条数
			if ($goods_score != 0) {
				$goods_score = round($goods_score/$all_all, 1);
			}
			// 评论统计数据
			$a_data['com_acc'] = array(
				'good_week_one'       => $good_week_one,
				'good_month_one'      => $good_month_one,
				'good_month_three'    => $good_month_three,
				'good_month_six'      => $good_month_six,
				'good_month_sixago'   => $good_month_sixago,
				'good_all'            => $good_all,

				'middle_week_one'     => $middle_week_one,
				'middle_month_one'    => $middle_month_one,
				'middle_month_three'  => $middle_month_three,
				'middle_month_six'    => $middle_month_six,
				'middle_month_sixago' => $middle_month_sixago,
				'middle_all'          => $middle_all,

				'bad_week_one'        => $bad_week_one,
				'bad_month_one'       => $bad_month_one,
				'bad_month_three'     => $bad_month_three,
				'bad_month_six'       => $bad_month_six,
				'bad_month_sixago'    => $bad_month_sixago,
				'bad_all'             => $bad_all,

				'week_all'            => $week_all,
				'month_one_all'       => $month_one_all,
				'month_three_all'     => $month_three_all,
				'month_six_all'       => $month_six_all,
				'month_sixago_all'    => $month_sixago_all,
				'all_all'             => $all_all,

				'good_ratio'          => $good_ratio,
				'service_score'       => $service_score,
				'goods_score'         => $goods_score,
			);
			$a_data['store'] = $this->comment_model->get_store_one($_SESSION['store_id']);
			$a_comment = $this->comment_model->get_comment_room($comment_cate, $comment_empty);
			$a_data['comment'] = $a_comment['comment'];
			$a_data['count'] = $a_comment['count'];
			$a_data['comtag'] = $this->comment_model->get_comtag_all();
			$a_data['comment_cate'] = $comment_cate;
			$a_data['comment_empty'] = $comment_empty;
			$this->view->display('comment_room', $a_data);
		}
	}

/************************************** 删除评价 **************************************/

	public function comment_delete() {
		$comment_id = trim($this->general->post('comment_id'));
		// 获取一条评论信息
		$a_comment = $this->comment_model->get_comment_one($comment_id);
		$comtag_type = $a_comment['comment_type'];
		if (!empty($a_comment['comment_tags'])) {
			$tag_arr = explode(',', $a_comment['comment_tags']);
			for ($i=0; $i<count($tag_arr); $i++) {
				$a_comtag = $this->comment_model->get_tag_one($_SESSION['store_id'], $tag_arr[$i], $comtag_type);
				$a_uwhere = [
					'comtag_id' => $a_comtag['comtag_id'],
				];
				$a_udata = [
					'comment_count' => $a_comtag['comment_count'] - 1,
				];
				$this->comment_model->update_comtag($a_uwhere, $a_udata);
			}
		}
		$i_result = $this->comment_model->delete_comment($comment_id);
		if ($i_result) {
			echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
		}
	}

/************************************** 审核评价 **************************************/

	public function comment_shenhe() {
		$comment_id = trim($this->general->post('comment_id'));
		$a_where = [
			'comment_id' => $comment_id,
		];
		$a_data = [
			'comment_state' => 1
		];
		$i_result = $this->comment_model->update_comment($a_where, $a_data);
		if ($i_result) {
			// 获取一条评论
			$a_comment = $this->comment_model->get_comment_one($comment_id);
			$store_id  =$_SESSION['store_id'];
			if (!empty($a_comment['comment_tags'])) {
				$tag_arr = explode(',', $a_comment['comment_tags']);
				for ($i=0; $i < count($tag_arr); $i++) {
					$a_tag = $this->comment_model->get_tag_one($store_id, $tag_arr[$i], 1);
					$a_whereu = [
						'comtag_id' => $a_tag['comtag_id'],
					];
					$a_datau = [
						'comment_count' => $a_tag['comment_count'] + 1,
					];
					$this->comment_model->update_comtag($a_whereu, $a_datau);
				}
			}
			echo json_encode(array('code'=>200, 'msg'=>'审核成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'审核失败'));
		}
	}

/*****************************************  产品评价 **************************************/
	public function coffee_room() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$comment_cate = $this->router->get(1);
			if (empty($comment_cate)) {
				$comment_cate = 9;
			}
			$comment_empty = $this->router->get(2);
			if (empty($comment_empty)) {
				$comment_empty = 9;
			}
			$a_data['allcomment'] = $this->comment_model->get_comment_all($_SESSION['store_id']);
			$good_week_one       = 0;
			$good_month_one      = 0;
			$good_month_three    = 0;
			$good_month_six      = 0;
			$good_month_sixago   = 0;
			$good_all            = 0;

			$middle_week_one     = 0;
			$middle_month_one    = 0;
			$middle_month_three  = 0;
			$middle_month_six    = 0;
			$middle_month_sixago = 0;
			$middle_all          = 0;

			$bad_week_one        = 0;
			$bad_month_one       = 0;
			$bad_month_three     = 0;
			$bad_month_six       = 0;
			$bad_month_sixago    = 0;
			$bad_all             = 0;

			$week_all            = 0;
			$month_one_all       = 0;
			$month_three_all     = 0;
			$month_six_all       = 0;
			$month_sixago_all    = 0;
			$all_all             = 0;

			$service_score       = 0;
			$goods_score         = 0;

			$thistime       = $_SERVER['REQUEST_TIME'];
			$weektime       = $thistime - (3600*24*7);
			$monthtime      = $thistime - (3600*24*30);
			$threemonthtime = $thistime - (3600*24*30*3);
			$sixmonthtime   = $thistime - (3600*24*30*6);
			foreach ($a_data['allcomment'] as $key => $value) {
				// 周统计
				if ($value['comment_time'] >= $weektime) {
					$week_all++;
					if ($value['comment_cate'] == 1) {
						$good_week_one++;
					} else if ($value['comment_cate'] == 2) {
						$middle_week_one++;
					} else if ($value['comment_cate'] == 3) {
						$bad_week_one++;
					}
				}
				// 月统计
				if ($value['comment_time'] >= $monthtime) {
					$month_one_all++;
					if ($value['comment_cate'] == 1) {
						$good_month_one++;
					} else if ($value['comment_cate'] == 2) {
						$middle_month_one++;
					} else if ($value['comment_cate'] == 3) {
						$bad_month_one++;
					}
				}
				// 三个月统计
				if ($value['comment_time'] >= $threemonthtime) {
					$month_three_all++;
					if ($value['comment_cate'] == 1) {
						$good_month_three++;
					} else if ($value['comment_cate'] == 2) {
						$middle_month_three++;
					} else if ($value['comment_cate'] == 3) {
						$bad_month_three++;
					}
				}
				// 六个月统计
				if ($value['comment_time'] >= $sixmonthtime) {
					$month_six_all++;
					if ($value['comment_cate'] == 1) {
						$good_month_six++;
					} else if ($value['comment_cate'] == 2) {
						$middle_month_six++;
					} else if ($value['comment_cate'] == 3) {
						$bad_month_six++;
					}
				}
				// 六个月之前统计
				if ($value['comment_time'] < $sixmonthtime) {
					$month_sixago_all++;
					if ($value['comment_cate'] == 1) {
						$good_month_sixago++;
					} else if ($value['comment_cate'] == 2) {
						$middle_month_sixago++;
					} else if ($value['comment_cate'] == 3) {
						$bad_month_sixago++;
					}
				}

				// 总好评 总中评 总差评统计
				if ($value['comment_cate'] == 1) {
					$good_all++;
				} else if ($value['comment_cate'] == 2) {
					$middle_all++;
				} else if ($value['comment_cate'] == 3) {
					$bad_all++;
				}
				$all_all++;
				$service_score = $service_score + $value['service_score'];
				$goods_score   = $goods_score + $value['goods_score'];
			}
			// 好评率 好评总个数/评论总条数
			if ($good_all == 0) {
				$good_ratio = 0;
			} else {
				$good_ratio = round($good_all/$all_all, 2)*100;
			}
			// 服务态度 总分/评论总条数
			if ($service_score != 0) {
				$service_score = round($service_score/$all_all, 1);
			}
			// 服务质量 总分/评论总条数
			if ($goods_score != 0) {
				$goods_score = round($goods_score/$all_all, 1);
			}
			// 评论统计数据
			$a_data['com_acc'] = array(
				'good_week_one'       => $good_week_one,
				'good_month_one'      => $good_month_one,
				'good_month_three'    => $good_month_three,
				'good_month_six'      => $good_month_six,
				'good_month_sixago'   => $good_month_sixago,
				'good_all'            => $good_all,

				'middle_week_one'     => $middle_week_one,
				'middle_month_one'    => $middle_month_one,
				'middle_month_three'  => $middle_month_three,
				'middle_month_six'    => $middle_month_six,
				'middle_month_sixago' => $middle_month_sixago,
				'middle_all'          => $middle_all,

				'bad_week_one'        => $bad_week_one,
				'bad_month_one'       => $bad_month_one,
				'bad_month_three'     => $bad_month_three,
				'bad_month_six'       => $bad_month_six,
				'bad_month_sixago'    => $bad_month_sixago,
				'bad_all'             => $bad_all,

				'week_all'            => $week_all,
				'month_one_all'       => $month_one_all,
				'month_three_all'     => $month_three_all,
				'month_six_all'       => $month_six_all,
				'month_sixago_all'    => $month_sixago_all,
				'all_all'             => $all_all,

				'good_ratio'          => $good_ratio,
				'service_score'       => $service_score,
				'goods_score'         => $goods_score,
			);
			$a_data['store'] = $this->comment_model->get_store_one($_SESSION['store_id']);
			$a_comment = $this->comment_model->coffee_room($comment_cate, $comment_empty);
			$a_data['comment'] = $a_comment['comment'];
			$a_data['count'] = $a_comment['count'];
			$a_data['comtag'] = $this->comment_model->get_comtag_all();
			$a_data['comment_cate'] = $comment_cate;
			$a_data['comment_empty'] = $comment_empty;
			// print_r($a_data['comment']);
			$this->view->display('coffee_room', $a_data);
		}
	}
/**************************************************************************************/

}

?>