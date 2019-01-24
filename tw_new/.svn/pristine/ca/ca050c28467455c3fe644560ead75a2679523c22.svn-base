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

    if(!empty( $this->is_pinglun!=0)){

      $this->order_state=50;
    }

    //查询物流信息

    

    switch ($this->order_state) {
      //未付款
        case '0':
        return $this->get_string();
        break;

      case '10':
        $this->time=$this->time_diff();
        return $this->get_string();
        break;

      case '20':
        return $this->get_string();
        break;

      default:
        $this->express_code_num();
        $this->express_details();

        return $this->get_string();
        break;
    }

   }


   //获取时间差
   public function time_diff(){

        $diff_time=$_SERVER['REQUEST_TIME']-$this->time_create;

        $diff_time=abs(86400-$diff_time);
        $day=floor($diff_time / (60 * 60 * 24));

        $hours=floor($diff_time / (60 * 60)) - ($day * 24);
        $mins = floor($diff_time / 60) - ($day * 24 * 60) - ($hours * 60);
        $secs = floor($diff_time) - ($day * 24 * 60 * 60) - ($hours * 60 * 60) - ($mins * 60);
  
        $time_diff['hour']=abs(intval($hours));
        $time_diff['min']=abs(intval($mins));
        $time_diff['sec']=abs(intval($secs));
        $time_diff['diff_time']=abs(intval($diff_time));
        return $time_diff;
   }

   //获取物流编号与名字
   public function express_code_num(){

    $this->load->model('Express_kd100_model');

    $json_data=$this->Express_kd100_model->take_express_message(intval($this->order_id));

    $data=json_decode($json_data,true);

    $this->express_code_num=$data;

  }

  //物流详情
  public function express_details(){
    $this->express_data=json_decode($this->express_model->express(intval($this->order_id)),true);
   }

   public function get_string(){
    
    if($this->express_data['status'] && $this->order_id!=0){
        $wuliu_string=$this->express_string();
    }

    $tips_string=$this->tips();

    $a_string['tips']=$tips_string;
    $a_string['wuliu']=$wuliu_string;
    $a_string['diff_time']=$this->time['diff_time'];
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
                                        <a class="cancel">取消订单</a>
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
                                        <a href="'.get_config_item('main_domain').'">
                                            <button>首页</button>
                                        </a>
                                        <p>逛逛...</p>
                                        <span>或</span>
                                        <a class="canc">取消订单</a>
                                    </div>
                                </div>
                            </div>';


    $code['30']='           <div class="now_state by_del">
                                <label class="state state2">
                                    <i></i>
                                    <em></em>
                                </label>
                                <div>
                                    <h3>当前状态：您的订单已发货，请注意查收...</h3>
                                    <div class="btn">
                                        <button class="receipt_goods">确定收货</button>
                                        <span>或</span>
                                        <a style="border-right: 1px solid #cccccc;height: 20px" class="cancel">退款</a>
                                        <a class="cancel">退货</a>
                                    </div>
                                    <p>物流公司：<span>'.$this->express_code_num['data']['name'].'&nbsp</span>物流单号：<span>'.$this->express_code_num['data']['num'].'</span></p>
                                </div>
                            </div>';

    $code['40']='           <div class="now_state confirm_receipt">
                                <label class="state state1">
                                    <i></i>
                                    <em></em>
                                </label>
                                <div>
                                    <h3>当前状态：您已确认收货，感谢您在七度购商城购物 </h3>
                                    <div class="btn">
                                        <button>评价</button>
                                        <a class="cancel">申请售后</a>
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
                                        <a class="cancel">申请售后</a>
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

  /**
   * [订单状态修改]
   * @param  [int]  [order_id]
  */
   public function order_logs($order_id,$log_orderstate="",$tips,$log_role,$user_name=null){

    // $user_id=$_SESSION['user_id'];
    if($user_name==null){
       $user_name=$_SESSION['user_name'];
    }

    if( !isset($order_id) && !isset($log_orderstate) && !isset($tips) && !isset($log_role)){
      return 0;
    }

    $this->db->begin();

    //提示语
    $log_msg=$tips;
    //角色
    $log_role=$log_role;

    //更新order表
    $a_set=['order_state'=>$log_orderstate];
    $a_order_table=['order'];
    $a_where=['order_id'=>$order_id];
    $i_update=$this->db->update($a_order_table,$a_set,$a_where);

    //插入log日志
    $a_insert_table=['order_log'];
    $a_insert_data=['order_id'=>$order_id,'log_msg'=>$log_msg,'log_time'=>$_SERVER['REQUEST_TIME'],'log_role'=>$log_role,'log_user'=>$user_name,'log_orderstate'=>$log_orderstate];

    $i_insert=$this->db->insert($a_insert_table,$a_insert_data);

    //根据结果返回
    if($i_update>0 && $i_insert){
      $this->db->commit();
      return 1;
    }else{
      $this->db->roll_back();
      return 0;
    }
    
   } 

}
?>