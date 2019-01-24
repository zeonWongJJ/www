<?php
defined('BASEPATH') OR exit('禁止访问！');
header("Content-Type:text/html;charset=utf8");
date_default_timezone_set('PRC'); 
class Commodity_Evaluation_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();	
		// $this->islogin_ctrl();
	}

    /**
     * [判断是否登录状态]
     * @return [status] [true|false]
     */
    public function islogin_ctrl()
    {
        if ( ! $_SESSION['user_name']) {
            $this->error->show_warning("您没有登陆", "/");
            //如果没登陆的话跳转
        }
    }


    /**
     * [index 订单评价首页]
     * @param  [int]  [i_orderid 订单ID]
     * @return [type]        [description]
     */
    public function index(){
    	// $i_orderid=2;
     //    $this->load->model('Evaluation_model');

     //    $a_view_data = $this->Evaluation_model->not_evaluation();
    	$this->view->display("commondity_evaluation");
  //   	$this->load->library('Upload');
		// $this->Upload->test();

    }

    /**
     * [图片上传处理]
     * @param  [array]  [$_POST 数据包]
     * @return [type]   [description]
     */
    public function img_upload(){
    $this->load->library('Upload');	

    //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)  
    $this->Upload->set("path", "./images/");  
    $this->Upload->set("maxsize", 2000000);  
    $this->Upload->set("allowtype", array("gif", "png", "jpg","jpeg"));  
    $this->Upload->set("israndname", true);  
    //使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false  
    if($this->Upload->upload("file",$_FILES)) {  
  		// echo "333";
        //获取上传后文件名子  
        $src=$this->Upload->
        	getFileName();
       echo "images/".$src;
    
    
    } else {  
        echo '<pre>';  
        //获取上传失败以后的错误提示  
        var_dump($this->Upload->getErrorMsg());  
        echo '</pre>';  
    }  

    

    }





}
