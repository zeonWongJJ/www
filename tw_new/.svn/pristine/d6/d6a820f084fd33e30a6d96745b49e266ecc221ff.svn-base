<?php
defined('BASEPATH') OR exit('禁止访问！');
class Index_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		// $this->load->model('is_login_model');
		// $this->load->model('Competitive_model');
	}

	public function index(){
		// $_SESSION['user_id'] = 1;
		// $data = $this->Competitive_model->number(1);
		// $data = $this->Competitive_model->count(1);

		$this->view->display('index');
	}
	// public function add_index() {
	// 	$title = $this->general->post('title');
	// 	$demand_details = $this->general->post('demand_details');
	// 	$images_path = $this->general->post('images');
	// 	$video_path = $this->general->post('video');
	// 	$position = $this->general->post('position');
	// 	print_r($video_path);
	// 	var_dump($images_path);
	// 	die;
	// 	if (empty($title)) {
	// 		$this->error->show_error("标题不能为空!");die;
	// 	}
	// 	if (empty($demand_details)) {
	// 		$this->error->show_error("内容不能为空!");die;
	// 	}

	// 	$a_data = [
	// 		'title' => $title,
	// 		'state' => 1,
	// 		'demand_details' => $demand_details,
	// 		'images_path' => $images_path,
	// 		'video_path' => $video_path,
	// 		'position' => $position,
	// 		'publisher_id' => $this->userid,
	// 		'release_time' => $_SERVER['REQUEST_TIME']
	// 	];
	// 	$data = $this->Competitive_model->inserts_demand($a_data);
	// 	if ( ! empty($data)) {
	// 		$this->error->show_success("操作成功！");
	// 	} else {
	// 		$this->error->show_error("操作失败！");
	// 	}
	// }

	public function add_index() {

		//包含一个文件上传类中的上传类
	    require_once(PROJECTPATH."/libraries/fileupload.php");	  
	    $up = new fileupload;
	    //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
	    $up -> set("path", "./images/");
	    $up -> set("maxsize", 99999999999);
	    $up -> set("allowtype", array("gif", "png", "jpg", "jpeg", "mp3", "mp4"));
	    $up -> set("israndname", true);
	    //使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false
	    if($up -> upload("pic")) {
	        
	        //获取上传后文件名子
	        // var_dump($up->getFileName());
	        
			echo json_encode(array(
            	"code" =>11111
			));
			die;
	    } else {
	    	$a_tis = $up->getErrorMsg();
	    	$a_tishi = $up->errorNum();
	        echo json_encode(array(
	        	"code" => 1222,
            	"msg" => $str
			));
			// echo urldecode($array);
			die;
	    }
	}

}
