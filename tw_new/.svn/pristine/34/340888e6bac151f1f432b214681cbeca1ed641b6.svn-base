<?php
class Order_details_model extends TW_Model {

  private $order_state;
  private $order_id;
  private $store_name;
  private $express_code_num;
  private $express_data;




     public function __construct() {
        
    }

   //初步获取数据
   public function get_state($order_id,$is_pinglun=null){
    $this->is_pinglun=$is_pinglun;

    $s_fields='order_state,order_id,store_name,time_create,';

    $a_where = ['order_id' => $order_id];
    $a_result=$this->db->from('order')
         ->select($s_fields,false)
         ->where($a_where)
         ->get();

    $this->user_id=$_SESSION['user_id'];     
    $this->order_state=$a_result[0]['order_state'];
    $this->order_id=$a_result[0]['order_id'];
    $this->store_name=$a_result[0]['store_name'];
    $this->time_create=$a_result[0]['time_create'];

    return $this->check_state();

   }

   //分发 获取数据步骤与拼凑字符串步骤
   private function check_state(){
    $this->load->model('express_model');
    //获取用户 是否存在评论
    // $user_id=$_SESSION['user'];
    // $a_where=['geval_frommemberid'=>$user_id,'geval_orderid'=>$this->order_id];
    // $result=$this->db->from("evaluate_goods")
    //     ->select("count(1) as num",false)
    //      ->where($a_where)
    //     ->get();
    //如果存在  说明用户存在评论  走第五步

    if(!empty( $this->is_pinglun!=0)){

      $this->order_state=50;
    }

    //查询物流信息

    $this->express_code_num();

    switch ($this->order_state) {
      //未付款
        case '0':
        // $this->time=$this->time_diff();
        return $this->get_string();
        break;



      case '10':
        $this->time=$this->time_diff();
        return $this->get_string();
        break;

      default:
        $this->express_details();

        return $this->get_string();
        break;
    }

   }


   //获取时间差
   public function time_diff(){


        $diff_time=$_SERVER['REQUEST_TIME']-$this->time_create;

        $remain = 86400-$diff_time;


        $hours=abs(intval($remain/3600));
    

        $remain = $remain%3600;
        $mins = intval($remain/60);
   

        $secs = $remain%60;
  
        $time_diff['hour']=intval($hours);
        $time_diff['min']=intval($mins);
        $time_diff['sec']=intval($secs);
        return $time_diff;
   }

   //获取物流编号与名字
   public function express_code_num(){

    $this->load->model('Express_kd100_model');
    $data=$this->Express_kd100_model->express_code_num(intval($this->order_id));

    if($data['status']){
        $a_where=['e_code'=>$data['data']['code']];
        $name=$this->db->from("express")
                 ->where($a_where)
                 ->select("e_name")
                 ->get();
        //物流名字 物流编码  物流单号
        $data['data']['name']=$name['0']['e_name'];
        //物流名字 物流编码  物流单号
        $this->express_code_num=$data;
    }



  }

    public function express_details(){
    $this->express_data=json_decode($this->express_model->express(intval($this->order_id)),true);
    // return $this->express_data;
    // $array=array_merge($data['data'],$express_data);

   }
   public function get_string(){
    

    if($this->express_data['status'] && $this->order_id!=0){
        $wuliu_string=$this->express_string();
    }
    
    $tips_string=$this->tips();

    $a_string['tips']=$tips_string;
    $a_string['wuliu']=$wuliu_string;
    $a_string['jindu']=$this->order_state/10;
    return $a_string;

   }



   public function express_string(){

   if( empty($this->express_data['data'])){
    $this->express_data['data'][0]['context']='暂无物流进展，请稍后再试';
   }


    $s_string='         <div class="courier_info">
                        <ul>
                        ';
              foreach($this->express_data['data'] as $key=>$value){
                        if($key==0){
                          $s_class='active';
                        }else{
                          $s_class='';
                        }

                        $s_string.='<li class="'.$s_class.'">
                                <time>'.$value['time'].'</time>
                                <label>
                                    <span></span>
                                    <em></em>
                                    <i></i>
                                </label>
                                <p>'.$value['context'].'</p>
                            </li>';
              };
    $s_string.= '  </ul>
                        <!-- <button>显示全部</button> -->
                    </div>';

    return $s_string;
   }

  public function tips(){

     $code['0']='            <div class="now_state order_close">
                                <label class="state state3">
                                    <i></i>
                                    <em></em>
                                </label>
                                <div>
                                    <h3>当前状态：订单关闭 </h3>
                                    <div class="btn" style="text-align: left;">
                              

                              
                                    </div>
                                </div>
                            </div>';
          // <p style="padding: 0">买家主动取消订单 <br><br>
          //                                   取消原因：其他 <br>
          //                                   取消说明：抢到了没钱付款，要哭了。</p>
      $code['10']='         
      <form method="POST" action="'.$this->router->url('order_pay',[$this->order_id]).'">
      <div class="now_state pend_pay">
                                <label class="state state2">
                                    <i></i>
                                    <em></em>
                                </label>
                                <div>
                                    <h3>当前状态：您已下单，请在 <span>'.$this->time['hour'].'</span>小时<span>'.$this->time['min'].'</span>分<span>'.$this->time['sec'].'</span>秒内付款，以免订单自动取消</h3>
                                    <div class="btn">
                                        <button class="k_pay">立即付款</button>
                                        <span>或</span>
                                        <a>取消订单</a>
                                    </div>
                                </div>
                            </div>
      </form>';

      $code['20']='  <div class="now_state waite_del">
                                <label class="state state2">
                                    <i></i>
                                    <em></em>
                                </label>
                                <div>
                                    <h3>当前状态：订单已付款，您的订单正在处理中，请耐心等待...</h3>
                                    <div class="btn">
                                        <p>去</p>
                                        <a>
                                            <button>首页</button>
                                        </a>
                                        <p>逛逛...</p>
                                        <span>或</span>
                                        <a>取消订单</a>
                                    </div>
                                </div>
                            </div>';


    $code['30']=' <div class="order-delivery-express">物流公司: <span>'.$this->express_code_num['data']['name'].'</div>
                                </span><div class="order-delivery-shipcode">运单号码: <span>'.$this->express_code_num['data']['num'].'</span></div>
                            ';

    $code['40']='           <div class="now_state confirm_receipt">
                                <label class="state state1">
                                    <i></i>
                                    <em></em>
                                </label>
                                <div>
                                    <h3>当前状态：您已确认收货，感谢您在七度购商城购物 </h3>
                                    <div class="btn">
                                        <button>评价</button>
                                        <a>申请售后</a>
                                    </div>
                                    <p>物流公司：<span>'.$this->express_code_num['data']['name'].'&nbsp</span>物流单号：<span>'.$this->express_code_num['data']['num'].'</span></p>
                                </div>
                            </div>';

      $code['50']='        <div class="now_state by_evaluate">
                                <label class="state state1">
                                    <i></i>
                                    <em></em>
                                </label>
                                <div>
                                    <h3>当前状态：您已评价，感谢您在七度购商城购物 </h3>
                                    <div class="btn">
                                        <button>查看评价</button>
                                        <span>或</span>
                                        <a>申请售后</a>
                                    </div>
                                    <p>物流公司：<span>'.$this->express_code_num['data']['name'].'&nbsp</span>物流单号：<span>'.$this->express_code_num['data']['num'].'</span></p>
                                </div>
                            </div>';

      return $code[$this->order_state];
  }

    /**
     * [获取订单的商品]
     * @param  [int]  [order_id]
     * @return [array][order_goods 订单商品]
     */

  public function order_goods($order_id){
          $this->order_id=$order_id;
          $s_fields='b.shipping_fee,b.pay_sn,b.time_create,b.order_sn,a.order_id,a.goods_name,a.goods_pay_price,a.buyer_id,a.goods_num,a.goods_type';

          $a_where=['a.order_id'=>$this->order_id,'b.order_id'=>$this->order_id];

          $data=$this->db->from(['order_goods'=>'a','order'=>'b'])
                          ->select($s_fields,false)
                          ->where($a_where)
                          ->order_by("goods_type")
                          ->get();
          return $data;
  }

    /**
     * [订单的地址信息 ]
     */
  public function order_address($order_id){
    $a_where=['order_id'=>$order_id];
    $a_order_address=$this->db->from('order_common')
    ->select('reciver_info,reciver_name',false)
    ->where($a_where)
    ->get();

    return $a_order_address[0];

  }

    /**
     * [用户的数据信息]
     * @param  [type]  [description]
     * @return [type]        [description]
     */
    public function member_info(){
    $a_where = ['member_id' => $_SESSION['user_id']];
    $a_field = "available_predeposit";
    $a_data  = $this->db->get_row('member', $a_where, $a_field);
    return $a_data;
  }

    /**
     * [时间差 | 距离24小时多久]
     * @param  [type]  [description]
     * @return [type]        [description]
     */
    public function time($time_create){

        $diff_time=$_SERVER['REQUEST_TIME']-$time_create;

        $remain = 86400-$diff_time;


        $hours=abs(intval($remain/3600));
    

        $remain = $remain%3600;
        $mins = intval($remain/60);
   

        $secs = $remain%60;
  
        $time_diff['hour']=abs(intval($hours));
        $time_diff['min']=abs(intval($mins));
        $time_diff['sec']=abs(intval($secs));
        return $time_diff;
    }

}
?>