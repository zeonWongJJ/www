<?php
defined('BASEPATH') OR exit('禁止访问！');
class Express_ctrl extends TW_Controller {
	

	public function __construct() {
		parent :: __construct();
        $this->load->model('express_kd100_model');
	}
    
    public function call(){
$ip = $_SERVER["REMOTE_ADDR"];
echo $_SERVER['HTTP_REFERER'];
        // $a_insert_table=['order_log'];
        // $a_insert_data=['order_id'=>689,'log_msg'=>'689订单 自动收货bug 手动修复order表状态','log_time'=>$_SERVER['REQUEST_TIME'],'log_role'=>'系统','log_user'=>'系统','log_orderstate'=>'30'];

        // $order_log_status=$this->db->insert($a_insert_table,$a_insert_data);
        // $data=$this->express_kd100_model->take_express_message(689);

        // $data=$this->db->from("express_log")->where(['shipping_code'=>3464520312])->get();
        // $data=json_decode($data,true);
        // $this->create_express_log();
        // $data=$this->db->from("express_log")->get();
        // $data=$this->db->from("express_kuaidi100")->where(['shipping_code'=>3464520312])->get();
        // $data=$this->db->from("goods_common")->where(['goods_commonid'=>101083])->get();
        // $a_where = ['goods_id' => 1141,'a.goods_verify'=>'1']; 
        // $s_field = 'a.goods_state,a.goods_freight,b.goods_body,d.brand_class,d.brand_name,GROUP_CONCAT(c.goods_image) AS details_image,a.goods_id,a.goods_name,a.goods_jingle,a.description,a.store_id,a.store_name,a.goods_price,a.goods_promotion_price,a.goods_marketprice,a.goods_image,a.goods_feng,a.have_gift';
        // $a_order=['c.is_default' => 'desc', 'c.goods_image_sort' => 'asc'];
        // $a_data  = $this->db->from("goods as a")
        //                     ->join('goods_common as b',['a.goods_commonid'=>'b.goods_commonid'])
        //                     ->join('goods_images as c',['b.goods_commonid'=>'c.goods_commonid'])
        //                     ->join('brand as d',['a.brand_id'=>'d.brand_id'])
        //                     ->select($s_field,false)
        //                     ->where($a_where)
        //                     ->group_by("a.goods_id")
        //                     ->order_by($a_order)
        //                     ->get();

// $result = $this->express_model->get_express_data(1, "express_code_num");
        // var_dump($data);
        // $data=$this->db->query("desc tw_express_log");
        // foreach($data as $key=>$value){
        //     var_dump($value);
        // }
                            // 20                       20
        // SELECT * FROM `tw_order_common` WHERE order_id=1 and (time_shipping-100) <= 1500000000 LIMIT 0,1000;
    //     $a_whert = ['time_shipping   ' =>$_SERVER['REQUEST_TIME'],'order_id'=>'1'];         
    //     $a_time = $this->db
    //                     ->where($a_whert,false)
    //                     ->from('order_common')
    //                     ->get();
    //     echo $this->db->get_sql();

    // true
    // get_cofig_item(["email"=>])

    }

    public function call_back(){
        $data = $this->general->post('param');

        if( !$data ){
            $this->error->show_error("非法访问");
            die;
        }

        $status=$this->express_kd100_model->call_back($data);

        if( $status ){
            echo '{"result":"true",    "returnCode":"200","message":"成功"}';
        }else{
            echo '{"result":"false",   "returnCode":"500","message":"失败"}';
        }
    }

    private function create_express_log(){
        $sql='create table tw_express_log(
            id int  primary key auto_increment,
            type varchar(10),
            company varchar(30),
            shipping_code varchar(50),
            time int(10),
            log text
             )';
        // $sql='drop table tw_express_log';
        $this->db->query($sql);


    }
    
   






}
