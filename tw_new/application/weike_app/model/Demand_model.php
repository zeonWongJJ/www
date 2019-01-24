<?php
class Demand_model extends TW_Model {
	public function __construct() {
        parent :: __construct();
        $this->userid=$_SESSION['user_id'];
    }

   /**
     * [设置属性上传]
     * @param  [url]  [上传的位置]
     * @return [name_id]   [post 上传的名]
     * @return [size]   [文件大小]
     * @return [mold]   [类型]
     * @return [named]   [设置是否随机重命名文件， false不随机, true随机]
     */
    public function demand_add($url, $size, $mold, $named, $name_id){

    	//包含一个文件上传类中的上传类
	    require_once(PROJECTPATH."/libraries/fileupload.php");	  
	    $up = new fileupload;
	    //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
	    $up -> set("path", $url);
	    $up -> set("maxsize", $size);
	    $up -> set("allowtype", $mold);
	    $up -> set("israndname", $named);
	    if($up -> upload($name_id)) {
	        //获取上传后文件名子       
			$reminder = array(
            	"code" =>11111,
            	"msg" => $up->getFileName()
			);
			return $reminder;
	    } else {
	        $a_tishi = $up->getErrorNum();	
	        switch ($a_tishi) {
	    		case '-5':
	    			$str = "必须指定上传文件的路径";
	    			break;
	    		case '-4':
	    			$str = "建立存放上传文件目录失败，请重新指定上传目录";
	    			break;
	    		case '-3':
	    			$str = "上传失败";
	    			break;
	    		case '-2':
	    			$str = "文件过大,上传的文件不能超过9242880个字节";
	    			break;
	    		case '-1':
	    			$str = "未允许类型";
	    			break;
	    		case '1':
	    			$str = "上传的文件超过了php.ini中upload_max_filesize选项限制的值";
	    			break;
	    		case '2':
	    			$str = "上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值";
	    			break;
	    		case '3':
	    			$str = "文件只有部分被上传";
	    			break;
	    		case '4':
	    			$str = "没有文件被上传";
	    			break;
	    		
	    		default:
	    			$str = "未知错误";
	    			break;
	    	}
	        $reminder = array(
	        	"code" => 1222,
            	"msg" => $str
			);
			return $reminder;
	    }
    }

     /**
     * [需求者的竞标]
     */
    public function demand() {
    	//查询收货人地址
		$a_address = $this->db->get_row('address',['member_id' => $_SESSION['user_id'], 'is_default' => 1]);	
		//判断用户是否有登录地址
		if($a_address == false){
			//获取上传后文件名子       
			$address = array(
            	"code" => 22,
            	"msg" => 请您设置您的收货地址！
			);
			return $address;
			die;
		}

		//生成支付单号
		$pay_sn  = $_SERVER['REQUEST_TIME'] . rand(10000000,99999999);

		$pay_sn_sum[] = $pay_sn;

		//生成订单编号
		$new_order = $this->db->get_row('demand', '','demand_id', ['demand_id' => desc]);
		$new_order_id = $new_order['demand_id'] + 1;
		$order_sn = date('YmdH', $_SERVER['REQUEST_TIME']) . sprintf("%06d", $new_order['demand_id'] + 1);

		$a_title = $this->general->post('title');
		$a_demand = $this->general->post('demand_details');
		$a_images = $_FILES['images'];
		$a_voice = $_FILES['voice'];
		$o_video = $_FILES['video'];
		$o_position = $this->general->post('position');
		$i_option = $this->general->post('option');
		if ( ! empty($a_images[name][0])) {
			$a_url = "./images";
			$a_data = array("gif", "png", "jpg", "jpeg");
			$a_images = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "images");				
			$a_imag = implode(",", $a_images['msg']);			
		}	
		
		if ( ! empty($a_voice[name][0])) {
			$a_url = "./images";
			$a_data = array("mp3");
			$a_voice = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "voice");
		}
		if ( ! empty($o_video[name][0])) {
			$a_url = "./images";
			$a_data = array("mp4");
			$a_im = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "video");
		}
		
		$a_data = [
			'publisher_id' => $_SESSION['user_id'],
			'publisher_name' => $_SESSION['username'],
			'order_sn' => $order_sn,
			'pay_sn' => $pay_sn,
			'title' => $a_title,
			'demand_details' => $a_demand,
			'state' => 11,
			'contacts_name' => $a_address['user_name'],
			'mobile_phone' => $a_address['mobile_phone'],
			'area_info' => $a_address['area_info'].$a_address['house_number'],
			'images_path' => $a_imag,
			'video_path' => $a_im['msg'],
			'voice' => $a_voice['msg'],
			'payment_code' => 'offline',
			'option' => 2,
			'release_time' => $_SERVER['REQUEST_TIME']
		]; 
		$demand = $this->db->insert('demand', $a_data);
		//添加订单历史表
		$b_order_log = $this->db->insert('message_logging', ['demand_id' => $demand, 'classify_msg' => '用户等待竞标', 'write_time' => $_SERVER['REQUEST_TIME'], 'classify' => '需求', 'classify_user' => $_SESSION['username'], 'service_state' => 11]);
    }

    /**
     * [需求者的竞标修改]
     * @param  [demand_id]  [需求id]
     */
    public function demand_update($demand_id) {
    	//查询收货人地址
		$a_address = $this->db->get_row('address',['member_id' => $_SESSION['user_id'], 'is_default' => 1]);
    	$a_title = $this->general->post('title');
		$a_demand = $this->general->post('demand_details');
		$a_images = $_FILES['images'];
		$a_voice = $_FILES['voice'];
		$o_video = $_FILES['video'];
		$o_position = $this->general->post('position');
		$i_option = $this->general->post('option');
		if ( ! empty($a_images[name][0])) {
			$a_url = "./images";
			$a_data = array("gif", "png", "jpg", "jpeg");
			$a_images = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "images");				
			$a_imag = implode(",", $a_images['msg']);			
		}	
		
		if ( ! empty($a_voice[name][0])) {
			$a_url = "./images";
			$a_data = array("mp3");
			$a_voice = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "voice");
		}
		if ( ! empty($o_video[name][0])) {
			$a_url = "./images";
			$a_data = array("mp4");
			$a_im = $this->Demand_model->demand_add($a_url, 995829999, $a_data, true, "video");
		}
		
		$a_data = [
			'title' => $a_title,
			'contacts_name' => $a_address['user_name'],
			'mobile_phone' => $a_address['mobile_phone'],
			'area_info' => $a_address['area_info'].$a_address['house_number'],
			'images_path' => $a_imag,
			'video_path' => $a_im['msg'],
			'voice' => $a_voice['msg'],
			'demand_details' => $a_demand,
			'release_time' => $_SERVER['REQUEST_TIME']
		]; 
		$this->db->update('demand', $a_data, ['demand_id' => $demand_id]);
		//添加订单历史表
		$this->db->update('message_logging', ['classify_msg' => '用户等待竞标', 'write_time' => $_SERVER['REQUEST_TIME'], 'classify' => '需求', 'classify_user' => $_SESSION['username'], 'service_state' => 12], ['demand_id' => $demand_id]);
    	
    	return $demand_id;
    }

     /**
     * [用户金券]
     * @param  [uesr_id]  [用户ID]
     */
    public function cash_coupon($uesr_id) {
    	$i_total = $this->db->get_total('cash_coupon', ['uesr_id' => $uesr_id]);
		
		$user_id = $this->db->update('member', ['cash_coupon' => $i_total], ['id' => $uesr_id]);
		return $user_id;
    }
}
?>