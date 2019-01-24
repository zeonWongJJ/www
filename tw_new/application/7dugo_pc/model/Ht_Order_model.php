<?php
/**
 * 用户模块
 */
class Ht_Order_model extends TW_Model {
	public function __construct() {
        parent :: __construct();
    }

    /**
     * [order_details 订单的信息]
     * @param  [int]  [order_id]
     * @return [array][data 订单的信息]
     */
    public function order_details(){
        $s_fields="order_id,order_sn,store_name,buyer_name,time_create,payment_code,order_state,order_amount";
        $a_data=$this->db->from("order")
                         ->select($s_fields)
                         ->limit(0,100000)
                         ->order_by(["time_create"=>'desc'])
                         ->get();

        foreach($a_data as $key=>$value){
            $a_data[$key]['time_create']=date("Y-m-d H:i:s",$value['time_create']);

            switch ($value['payment_code']) {
                case 'alipay':
                    $a_data[$key]['payment_type']="支付宝";
                    break;

                case 'online':
                    $a_data[$key]['payment_type']="余额支付";
                    break;    

                case 'offline':
                    $a_data[$key]['payment_type']="货到付款";
                    break;

                case 'tenpay':
                    $a_data[$key]['payment_type']="财付通";
                    break;
            }

            switch ($value['order_state']) {
                case '10':
                    $a_data[$key]['order_type']="未付款";
                    break;

                case '20':
                    $a_data[$key]['order_type']="已付款";
                    break;    

                case '30':
                    $a_data[$key]['order_type']="已发货";
                    break;

                case '40':
                    $a_data[$key]['order_type']="已收货";
                    break;

                case '0':
                    $a_data[$key]['order_type']="已关闭";
                    break;
            }


        }

        return $a_data;
        

    }

    /**
     * [express 快递数据]
     * @return [array] [express 数据]
     */
    public function express(){
        $s_fields='id,e_name,e_code';
        $a_express_data=$this->db->from("express")
                                 ->select($s_fields)
                                 ->limit(0,3000)
                                 ->get();

        return $a_express_data;
    }

    /**
     * [设置物流]
     * @param  [set_express 的post 数据]
     */
    public function set_express($post_data){
        $express_num=$post_data['express_num'];
        $express_code=$post_data['express_code'];
        $order_id=$post_data['order_id'];
        $express_company_id=$post_data['express_company_id'];


        $this->db->begin();

        //***********************************************************
        // order => shipping_code 物流单号 , order_state 订单状态码
        $a_where=['order_id'=>$order_id];
        $s_table="order";
        $order_set=['shipping_code'=>$express_num,'order_state'=>'30'];
        $order_status=$this->db->update($s_table,$order_set,$a_where);

        if(!$order_status){
            $this->db->roll_back();
            return 0;
        }
        //***********************************************************

        //***********************************************************
        // order_common => time_shipping 发货时间 , shipping_express_id 发货公司id
        $s_table="order_common";
        $order_common_set=['time_shipping'=>$_SERVER['REQUEST_TIME'],'shipping_express_id'=>$express_company_id];
        $order_common_status=$this->db->update($s_table,$order_common_set,$a_where);

        if(!$order_common_status){
            $this->db->roll_back();
            return 0;
        }
        //***********************************************************

        //***********************************************************
        // order_common => time_shipping 发货时间 , shipping_express_id 发货公司id
        $log_msg="发出了货物 物流单号 :".$express_num;
        $log_role="商家";
        $user_name=$_SESSION['user_name'];
        $log_orderstate=30;

        $a_insert_table=['order_log'];
        $a_insert_data=['order_id'=>$order_id,'log_msg'=>$log_msg,'log_time'=>$_SERVER['REQUEST_TIME'],'log_role'=>$log_role,'log_user'=>$user_name,'log_orderstate'=>$log_orderstate];

        $order_log_status=$this->db->insert($a_insert_table,$a_insert_data);

        if(!$order_log_status){
            $this->db->roll_back();
            return 0;
        }

        //***********************************************************

        //订阅物流
        $this->load->model("express_kd100_model");
        $express_return=$this->express_kd100_model->express($express_code,$express_num);

        $express_return_data=json_decode($express_return,true);

        if( !$express_return_data['result']){
            $this->db->roll_back();
        }else{
            $this->db->commit();
        }
        echo $express_return;

    }

    /**
     * [订单详情]
     * @param  [int]  [order_id]
     */
    public function order($order_id){
        $array=array('订单ID'=>'order_id',
                     '订单编号'=>'order_sn',
                     '支付单号'=>'pay_sn',
                     '订单状态'=>'order_state',
                     '商品信息[成交价]'=>'qew',
                     '卖家店铺名称'=>'store_name',
                     '买家姓名'=>'buyer_name',
                     '订单生成时间'=>'time_create',
                     '支付方式'=>'payment_code',
                     '付款时间'=>'time_payment',
                     '商品总价格'=>'goods_amount',
                     '订单总价格'=>'order_amount',
                     '运费'=>'shipping_fee',
                     '物流公司'=>'shipping_name',
                     '物流单号'=>'shipping_code',
                     '使用积分'=>'use_points',
                     '获赠积分'=>'goods_feng',
                     '订单留言'=>'order_message',
                     '收货人姓名'=>'reciver_name',
                     '收货人信息'=>'reciver_info'                  
                     );

        $table=['order'=>'a'];

        $s_fields="a.order_id,a.order_sn,a.pay_sn,a.store_name,a.buyer_name,a.time_create,a.time_create,a.payment_code,a.time_payment,a.goods_amount,a.order_amount,a.shipping_fee,a.order_state,a.shipping_code,a.use_points,a.goods_feng,b.reciver_name,b.reciver_info,b.order_message";
        $order_and_common=  $this->db->from($table)
                 ->join(['order_common'=>'b'],['a.order_id'=>'b.order_id'])
                 ->where(['a.order_id'=>$order_id])
                 ->select($s_fields)
                 ->get_row();

      $order_goods=  $this->db->from("order_goods")
                 ->where(['order_id'=>$order_id])
                 ->select('goods_name,goods_price,goods_pay_price,goods_num')
                 ->get(); 

      foreach($order_goods as $key=>$value){
        $order_goods[$key]['goods_name']=mb_substr($value['goods_name'],0,10,'utf-8');
      }          

      foreach($array as $key=>$value){

        if($key=='收货人信息'){
            $address=unserialize($order_and_common[$value]);
            $array[$key]=$address['address']." ".$address['mob_phone'];
        }else if($order_and_common[$value]!=null){
            $array[$key]=$order_and_common[$value];
        }else{
            $array[$key]=null;
        }

        if( strstr($value,'time') && $order_and_common[$value]!=0){
            $array[$key]=date("Y-m-d H:i:s",$order_and_common[$value]);
      
        }

      }
      if($array['订单状态']>=30){
          $this->load->model('express_kd100_model');
          $shipping_data=$this->express_kd100_model->take_express_message(intval($order_id));
          $shipping_data=json_decode($shipping_data,true);

          if($shipping_data['status']){
            $tips=$shipping_data['data']['name'];
          }else{
            $tips="查询物流公司错误，请联系管理员";
          }
          $array['物流公司']=$tips;
      }else{
            unset($array['物流公司']);
            unset($array['物流单号']);
      }
      
     
      

      $array['商品信息[成交价]']=$order_goods;

      return $array;

    }





}

?>

