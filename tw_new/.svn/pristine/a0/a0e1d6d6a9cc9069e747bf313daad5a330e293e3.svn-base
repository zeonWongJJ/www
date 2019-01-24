<?php
defined('BASEPATH') OR exit('禁止访问！');
date_default_timezone_set('PRC'); 
class Orderdetail_ctrl extends TW_Controller {

	private $order_id;



	public function __construct() {
		parent :: __construct();	
		$this->prefix = $this->db->get_prefix();
		$this->load->model('login_model');
		$this->load->model("Order_details_model");

	}

	//订单代付详情
	public function order_details() {
		// die;
		//判断是否登录
		$this->login_model->login();
		$userid=$_SESSION['user_id'];

		$i_id = $this->router->get(1);


		$i_id = $this->db->get('order', ['order_sn' => $i_id], ['order_id']);
		$i_id = $i_id[0][0];

		$a_whert = ['order_id' => $i_id];
		$a_select = ['order_id','a.buyer_id','goods_pay_price', 'a.goods_image', 'a.store_id', 'a.goods_id', 'a.goods_price', 'a.goods_num', $this->prefix.'goods.goods_name', $this->prefix.'goods.goods_jingle', $this->prefix.'goods.have_gift'];
		//商品信息								
		$a_data['goods'] = $this->db
		        				->from('order_goods as a')
								->join('goods', ['a.goods_id' => $this->prefix.'goods.goods_id'])
								->get('', $a_whert, $a_select);	
		if($userid!=$a_data['goods'][0]['buyer_id']){
			$this->error->show_error("请不要越权访问。",'/');
			DIE;
		}
		$a_data['goods_name'] = $this->db->get('goods_gift');
	
		$a_data['message'] = $this->db->get('order_common', ['order_id' => $i_id], ['order_message']);
		//商品数量
		$a_data['mut'] = $this->db->get('order_goods', ['order_id' => $i_id] 	);
		$num =0;
		foreach ($a_data['mut'] as $kt) {
			$num += $kt['goods_num'];
		}
		$a_data['num'] = $num;
		//商品金额
		$a_data['mount'] = $this->db->get('order', ['order_id' => $i_id]);
		//时间
		$time = $this->db->get('order', ['order_id' => $i_id], ['time_create']);

		$a_data['time'] = $time[0][0] - strtotime('-1 day');
		//地址
		$where = ['a.order_id' =>  $i_id];
		$setele = ['a.order_id', 'a.store_id', 'a.store_name', $this->prefix.'order_common.time_shipping', $this->prefix.'order_common.evalseller_state', $this->prefix.'order_common.time_evaluation', $this->prefix.'order_common.reciver_name', $this->prefix.'address.area_info', $this->prefix.'address.address', $this->prefix.'address.mob_phone'];

		$a_where=['order_id'=>$i_id];
		$s_fields='reciver_info,reciver_name,time_shipping,time_evaluation';
		$a_address = $this->db->from('order_common')
									  ->where($a_where)
									  ->select($s_fields)
									  ->get_row();

		$a_address_info=unserialize($a_address['reciver_info']);
		$a_data['address']['reciver_name']=$a_address['reciver_name'];
		$a_data['address']=$a_address;

		$a_data['address']['reciver_info']=$a_address_info;
		// var_dump($a_data);

		//================================以下康祖明 编写===============================================

		$this->load->model("Order_details_model");
		$a_data['state']=$this->Order_details_model->get_state($i_id,$a_data['address']['evalseller_state']);
		$store_id=$a_data['goods']['0']['store_id'];
		//是否为自营
		$is_own_shop=$this->db->from("store")
				 ->select("is_own_shop")
				 ->where(['store_id'=>$store_id])
				 ->get();

 		$a_data['goods'][0]['is_own_shop']=$is_own_shop[0]['is_own_shop'];

       $this->view->display('order_details', $a_data);
	}


	public function order_pay(){
	   $this->load->model('index_model');

	   $a_res = $this->index_model->category();
	   $a_data = $this->index_model->arr($a_res);

	   foreach($a_data as $key=>$value){
	   		$a_data[$key]['gc_url']=get_config_item("main_domain").'/search--'.$value['gc_id'].'-0-0-0-0-0-0-0-0-0-0-0.html';
	   		foreach($value['child'] as $k=>$v){
	   		$a_data[$key]['child'][$k]['gc_url']=get_config_item("main_domain").'/search--'.$value['gc_id'].'-0-0-0-0-0-0-0-'.$v['gc_id'].'-0-0-0.html';

	   			foreach($v['son'] as $kk=>$vv){
	   				$a_data[$key]['child'][$k]['sonurl'][$kk]['gc_url']=get_config_item("main_domain").'/search-'.str_replace('-', '+', urlencode($vv)).'-'.$value['gc_id'].'-0-0-0-0-0-0-0-'.$v['gc_id'].'-0-0-0.html';
	   			}
	   		}


	   }

	   $this->login_model->login();
	   $order_id=$this->router->get(1);

	   if($order_id==null){
	   	$this->error->show_error("非法请求",'/');
			DIE;
	   }

	   $this->load->model("Order_details_model");
	   //查询订单 商品信息
	   $a_order_goods['data']=$this->Order_details_model->order_goods($order_id);

	   if($a_order_goods['data']['0']['buyer_id'] !=$_SESSION['user_id']){
			$this->error->show_error("请不要越权访问。",'/');
			DIE;
	   }

	   //查询总价
	   $i_order_amount=0;
	   foreach($a_order_goods['data'] as $key=>$value){
	   	$i_order_amount=($value['goods_pay_price']*$value['goods_num'])+$i_order_amount;
	   }
	   $i_order_amount=round($i_order_amount,2);
	   //总价+运费

	   if($a_order_goods['data']['0']['shipping_fee']==null){
	   	$a_order_goods['data']['0']['shipping_fee']=0;
	   }
	   $i_order_amount+=$a_order_goods['data']['0']['shipping_fee'];

	   //查询用户地址并反序列化
	   $s_address=$this->Order_details_model->order_address($order_id);
	   $a_address=unserialize($s_address['reciver_info']);

	   //用户的信息
	   $a_member_info=$this->Order_details_model->member_info();

	   $time_create=$a_order_goods['data']['0']['time_create'];
	   //获取时间差
	   $time_diff=$this->Order_details_model->time($time_create);

	   //余额
	   $a_order_goods['basic']['money']=$a_member_info['available_predeposit'];
	   //订单金额
	   $a_order_goods['basic']['pay_mount']=$i_order_amount;
	   //订单编号
	   $a_order_goods['basic']['order_sn']=$a_order_goods['data']['0']['order_sn'];
	   //地址信息
	   $a_order_goods['basic']['address']=$a_address;
	   //收货人姓名
	   $a_order_goods['basic']['receive_name']=$s_address['reciver_name'];

	   //支付单号
	   $a_order_goods['basic']['pay_sn']=$a_order_goods['data']['0']['pay_sn'];

	   //订单id
	   $a_order_goods['basic']['order_id']=$order_id;
	   //时间差
	   $a_order_goods['basic']['time']=$time_diff;
	   //导航
	   $a_order_goods['basic']['cate']=$a_data;
       $this->view->display('order_pay',$a_order_goods);

	}

    /**
     * [订单日志表]
     * @param  [int]  [order_id]
     * @param [string][type 操作类型]
     */
	public function order_logs(){
		$this->login_model->login();
		$i_order_id=$this->general->post("order_id");

		$log_orderstate=40;
		
		$s_tips='签收了货物';

		$s_log_role='买家';


	   echo $this->Order_details_model->order_logs($i_order_id,$log_orderstate,$s_tips,$s_log_role);
	}


}