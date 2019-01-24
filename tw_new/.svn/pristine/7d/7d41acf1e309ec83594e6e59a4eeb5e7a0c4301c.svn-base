<?php
defined('BASEPATH') OR exit('禁止访问！');
class Demand_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('Demand_model');
		$this->load->model('Competitive_model');
	}

	//发布需求
	public function demand() {
		$this->view->display('demand');
	}

	//需求的触发反应
	public function demand_add() {
		$a_title = $this->general->post('title');
		$a_demand = $this->general->post('demand_details');
		$a_images = $_FILES['images'];
		$a_voice = $_FILES['voice'];
		$o_video = $_FILES['video'];
		$o_position = $this->general->post('position');
		if (empty($a_title)) {
			echo json_encode(array(
				"code" => 1,
            	"msg" => '标题不能为空'
			));die;
		}
		if (empty($a_demand)) {
			echo json_encode(array(
				"code" => 2,
            	"msg" => '需求内容不能为空'
			));die;
		}
		if (empty($o_position)) {
			echo json_encode(array(
				"code" => 3,
            	"msg" => '定位不能为空'
			));die;
		}
		if ( ! empty($a_images[name][0])) {
			$a_url = "./images";
			$a_data = array("gif", "png", "jpg", "jpeg");
			$a_images = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "images");
			// print_r($a_images['msg'][0]);
			// echo json_encode($a_images);

		}

		if ( ! empty($a_voice[name][0])) {
			$a_url = "./images";
			$a_data = array("mp3");
			$a_voice = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "voice");
			// print_r($a_voice['msg']);
			// echo json_encode($a_voice);
		}
		if ( ! empty($o_video[name][0])) {
			$a_url = "./images";
			$a_data = array("mp4");
			$a_im = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "video");
			// print_r($a_im['msg']);
			// echo json_encode($a_im);
		}
		// $a_data = [

		// 	'title' => $title,
		// 	'state' => 1,
		// 	'demand_details' => $demand_details,
		// 	'images_path' => $a_images['msg'][0],
		// 	'video_path' => $a_im['msg'],
		// 	'position' => $o_position,
		// 	'publisher_id' => 1,
		// 	'release_time' => $_SERVER['REQUEST_TIME']
		// ];
		// $data = $this->Competitive_model->inserts_demand($a_data);

		if ( ! empty($a_images['msg'][0]) || ! empty($a_im['msg'] || ! empty($a_voice['msg']))) {
			echo json_encode(array(
				"code" => 11,
            	"msg" => '操作成功！'
			));
		} else {
			echo json_encode(array(
				"code" => 12,
            	"msg" => '操作失败！'
			));
		}
	}

	//评价的订单
	public function demand_index() {
		$a_data['demand'] = $this->db->from('appraise as a')
									->join('appraise_add as b', ['a.appraise_id' => 'b.appraise_id'])
									->where(['a.appraise_id' => 5])
									->get('');
									print_r($a_data['demand']);
		$this->view->display('demand_index', $a_data);
	}

	//评价的订单
	public function demand_appraise() {
		$_SESSION['user_id'] = 1;
		$a_comment = 2;
		$i_capacity = 4;
		$i_attitude = 2;
		$i_efficiency = 1;
		$a_content = $this->general->post('content');
		$a_images = $_FILES['images'];
		$o_video = $_FILES['video'];
		// $a_anonymity = $this->general->post('anonymity');
		if ( ! empty($a_images[name][0])) {
			$a_url = "./images";
			$a_data = array("gif", "png", "jpg", "jpeg");
			$a_images = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "images");
			echo json_encode($a_images);
		}

		if ( ! empty($o_video[name][0])) {
			$a_url = "./images";
			$a_data = array("mp3", "mp4");
			$a_im = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "video");
			echo json_encode($a_im);
		}
		$a_data = [
			'service_bid' => 2,
			'demand_id' => $_SESSION['user_id'],
			'content' => $a_content,
			'video_path' => $a_im['msg'],
			'images_path' => $a_images['msg'][0],
			'comment' => $a_comment,
			'technical_capacity' => $i_capacity,
			'service_attitude' => $i_attitude,
			'time_efficiency' => $i_efficiency,
			'anonymity' => $a_anonymity,
			'edit_time' => $_SERVER['REQUEST_TIME']
		];
		$this->db->insert('appraise', $a_data);
		$this->view->display('demand_appraise');
	}

	//追加评价的订单
	public function demand_appraise_add() {
		$i_appraise_id = 2;
		$a_content = $this->general->post('content');
		$a_images = $_FILES['images'];
		$o_video = $_FILES['video'];
		if ( ! empty($a_images[name][0])) {
			$a_url = "./images";
			$a_data = array("gif", "png", "jpg", "jpeg");
			$a_images = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "images");
			echo json_encode($a_images);
		}

		if ( ! empty($o_video[name][0])) {
			$a_url = "./images";
			$a_data = array("mp3", "mp4");
			$a_im = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "video");
			echo json_encode($a_im);
		}
		$a_data = [
			'appraise_id' => $i_appraise_id,
			'content_add' => $a_content,
			'video_add' => $a_im['msg'],
			'images_add' => $a_images['msg'][0],
			'add_time' => $_SERVER['REQUEST_TIME']
		];
		$this->db->insert('appraise_add', $a_data);
	}
}
?>