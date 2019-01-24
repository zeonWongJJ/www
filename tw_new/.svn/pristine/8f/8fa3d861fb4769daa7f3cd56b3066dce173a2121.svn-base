<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>七度购商城</title>
    <link rel="stylesheet" type="text/css" href="style/orderDetails.css">
    <link rel="stylesheet" type="text/css" href="style/iconfont.css">

    <?php echo $this->display('header');?>
    <script type="text/javascript" src="js/toolbar.js"></script>
    <script src="js/layer.js"></script>
<div>
    <div class="orderDetails_info" style="">
        <header>
            <h2>订单详情</h2>
        </header>
        <section>
        <?php if($a_view_data['state']['jindu']!=0){ ?>
            <div class="order_state">
                <ul>
                    <li>
                        <label class="state1">
                            <i></i>
                            <span></span>
                            <em></em>
                        </label>
                        <p>提交订单</p>
                        <?php $time=$a_view_data['mount'][0]['time_create'];?>

                        <time><?php if($time!=0 && $time!=null)echo date("Y-m-d H:i",$a_view_data['mount'][0]['time_create'])?></time>
                    </li>
                    <li>
                    <?php
                    $jindu=$a_view_data['state']['jindu'];

                    ?>
                        <label class="<?php if($jindu>=2){ echo 'state1';}else{echo 'state2';$end='state3';}?>">
                            <i></i>
                            <span></span>
                            <em></em>
                        </label>
                        <p>订单付款</p>
                        <?php $time=$a_view_data['mount'][0]['time_payment'];?>

                        <time><?php if($time!=0 && $time!=null)echo date("Y-m-d H:i",$a_view_data['mount'][0]['time_payment'])?></time>
                    </li>
                    <li>
                        <label class="<?php if($end){
                            echo $end;
                            }else if($jindu>=3){
                            echo 'state1';
                                }else{
                            echo 'state2';

                            $end='state3';        
                                }
                                ?>">
                            <i></i>
                            <span></span>
                            <em></em>
                        </label>
                        <p>商品出库</p>
                        <?php $time=$a_view_data['address']['time_shipping'];?>
                        <time><?php if($time!=0 && $time!=null)echo date("Y-m-d H:i",$a_view_data['address']['time_shipping'])?></time>
                    </li>
                    <li>
                        <label class="<?php if($end){
                            echo $end;
                            }else if($jindu>=4){
                            echo 'state1';
                                }else{
                            echo 'state2';

                            $end='state3';        
                                }
                                ?>">
                            <i></i>
                            <span></span>
                            <em></em>
                        </label>
                        <p>已确认收货</p>
                        <?php $time=$a_view_data['mount'][0]['time_finnshed'];?>
                        <time><?php if($time!=0 && $time!=null)echo date("Y-m-d H:i",$a_view_data['mount'][0]['time_finnshed'])?></time>
                    </li>
                    <li>
                        <label class="<?php if($end){
                            echo $end;
                            }else if($jindu>4){
                            echo 'state1';
                                }else{
                            echo 'state2';
                            $end='state3';        
                                }
                                ?>">
                            <span></span>
                            <em></em>
                        </label>
                        <p>评价 </p>
                        <?php $time=$a_view_data['address']['time_evaluation'];?>
                        <time><?php if($time!=0 && $time!=null)echo date("Y-m-d H:i",$a_view_data['address']['time_evaluation'])?></time>
                    </li>
                </ul>
            </div>
        <?php } ?>
            <div class="order_state_info">
                <header>
                    <div>
                        <div>
                        <?php echo $a_view_data['state']['tips']?>
                        <!--     <div class="now_state pend_pay ">
                                <label class="state state2">
                                    <i></i>
                                    <em></em>
                                </label>
                                <div>
                                    <h3>当前状态：您已下单，请在 <span>23</span>小时<span>59</span>分<span>59</span>秒内付款，以免订单自动取消</h3>
                                    <div class="btn">
                                        <button>立即付款</button>
                                        <span>或</span>
                                        <a>取消订单</a>
                                    </div>
                                </div>
                            </div>
                            <div class="now_state waite_del dn">
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
                            </div>
                            <div class="now_state by_del dn">
                                <label class="state state2">
                                    <i></i>
                                    <em></em>
                                </label>
                                <div>
                                    <h3>当前状态：您的订单已发货，请注意查收...</h3>
                                    <div class="btn">
                                        <button>立即付款</button>
                                        <span>或</span>
                                        <a style="border-right: 1px solid #cccccc;height: 20px">退款</a>
                                        <a>退货</a>
                                    </div>
                                    <p>物流公司：<span>中通快递</span>物流单号：<span>20170323123456</span></p>
                                </div>
                            </div>
                            <div class="now_state confirm_receipt dn">
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
                                    <p>物流公司：<span>中通快递</span>物流单号：<span>20170323123456</span></p>
                                </div>
                            </div>
                            <div class="now_state by_evaluate dn">
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
                                    <p>物流公司：<span>中通快递</span>物流单号：<span>20170323123456</span></p>
                                </div>
                            </div>
                            <div class="now_state order_close dn">
                                <label class="state state3">
                                    <i></i>
                                    <em></em>
                                </label>
                                <div>
                                    <h3>当前状态：订单关闭 </h3>
                                    <div class="btn">
                                        <p style="padding: 0">买家主动取消订单 <br><br>
                                            取消原因：其他 <br>
                                            取消说明：抢到了没钱付款，要哭了。</p>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <img src="image/order_code.png" alt="">
                    </div>
                  <!--   <div class="courier_info">
                        <ul>
                            <li class="active">
                                <time>2017-03-23  08:33:33 </time>
                                <label>
                                    <span></span>
                                    <em></em>
                                    <i></i>
                                </label>
                                <p>[汕头市]广东潮阳公司 已发出</p>
                            </li>
                            <li>
                                <time>2017-03-23  08:33:33 </time>
                                <label>
                                    <span></span>
                                    <em></em>
                                    <i></i>
                                </label>
                                <p>[汕头市]中通快递 广东潮阳公司收件员 已揽件</p>
                            </li>
                            <li>
                                <time>2017-03-23  08:33:33 </time>
                                <label>
                                    <span></span>
                                    <em></em>
                                    <i></i>
                                </label>
                                <p >您的包裹已出库，等待揽收</p>
                            </li>
                            <li>
                                <time>2017-03-23  08:33:33 </time>
                                <label>
                                    <span></span>
                                    <em></em>
                                    <i class="dn"></i>
                                </label>
                                <p>您的包裹已打包装箱，正等待出库</p>
                            </li>
                        </ul>
                        <button>显示全部</button>
                    </div> -->
                     <?php echo $a_view_data['state']['wuliu']?>
                </header>
                <section>
                    <div>
                        <div class="address_info">
                            <h2>收货人信息</h2>
                            <ul>
                                                         
                                    <li>
                                        <span>收货人</span>
                                        <p><?php echo $a_view_data['address']['reciver_name']?></p>
                                    </li>
                                    <li>
                                        <span>收货地址</span>
                                        <p><?php echo $a_view_data['address']['reciver_info']['address']?></p>
                                    </li>
                                    <li>
                                        <span>联系电话</span>
                                        <p><?php echo $a_view_data['address']['reciver_info']['mob_phone']?></p>
                                    </li>
                              
                            </ul>
                        </div>
                        <div class="send_info">
                            <h2>支付及配送信息</h2>
                            <ul>
                                <li>
                                    <span>支付信息</span>
                                    <p> 在线支付</p>
                                </li>
                                <li>
                                    <span>配送方式</span>
                                    <p>快递配送 </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <div class="order_list">
                            <header>
                                <div>
                                    <h2>送货清单</h2>
                                    <div><?php if($a_view_data['goods']['0']['is_own_shop']=='1'){ ?>
                                        <span>
                                        <?php echo "七度自营";?>
                                            </span>

                                            <?php }?>
                                        <h2><a href="<?php echo get_config_item('index')?>/search--0-0-0-0-0-0-0-0-0-0-0-<?php echo $a_view_data['mount'][0]['store_id']?>.html" target="_blank" class="shop-txt" title="<?php echo $add['store_name']?>" style="color: #333333;">
<?php echo $a_view_data['mount'][0]['store_name']?></a></h2>
                                        <a  class="btn-im" href="http://lyt.zoosnet.net/lr/chatpre.aspx?id=LYT42657310" target="_blank" title="联系卖家"><i class="iconfont icon-kefu"></i></a>
                                    </div>
                                </div>
                                <ul>
                                    <li>商品信息</li>
                                    <li>单价</li>
                                    <li>数量</li>
                                    <li>小计</li>
                                </ul>
                            </header>
                            <section>
                                <div>
                                     <?php foreach ($a_view_data['goods'] as $goods) { ?> 
                                        <div class="order_item">
                                            <div class="img" style="background-image: url(<?php echo get_config_item('goods_img')?><?php echo $goods['store_id']?>/<?php echo $goods['goods_image']?>)"></div>
                                            <div class="cont">
                                                <h2><a href="<?php echo get_config_item('main_domain').'/item-'.$goods['goods_id'].'.html'?>"><?php echo $goods['goods_name']?></a></h2>
                                                <p><?php echo $goods['goods_jingle']?></p>
                                                <?php if (empty($goods['have_gift'])) {?>

                                                <?php } else {?>
                                                <div>
                                                    <span>赠</span>
                                                    <ul>
                                                        <?php foreach ($a_view_data['goods_name'] as $ke ) { 
                                                                if ($goods['goods_id'] == $ke['goods_id']) {           
                                                        ?>                   
                                                        <li>
                                                            <p><?php echo $ke['gift_goodsname']?></p>
                                                            <span><?php echo $ke['gift_amount']?></span>
                                                        </li>
                                                        <?php }}?>
                                                    </ul>
                                                </div>
                                                <?php }?>
                                            </div>
                                            <div class="price">
                                            <span>
                                                <span>￥</span>
                                                 <?php echo $goods['goods_price']?>
                                                </span>
                                                </div>
                                                <div class="number">
                                                    <span> <?php echo $goods['goods_num']?></span>
                                                </div>
                                                <div class="amount">
                                            <span>
                                                <span>￥</span>
                                                <?php echo $goods['goods_pay_price']?>
                                            </span>
                                            </div>
                                        </div>
                                       <?php }?>
                                </div>
                            </section>
                            <footer>
                                <p>订单备注：</p>
                                      <input type="text" placeholder="<?php echo $a_view_data['message'][0][0]?>" readonly="readonly">
                            </footer>
                        </div>
                            <div class="total">
                                <p>共<span><?php echo $a_view_data['num']?></span>件商品</p>
                                <ul>
                                    <li>总金额：</li>
                                    <li>积分抵用：</li>
                                    <li>运费：</li>
                                    <li>实付总额：</li>
                                </ul>
                                <dl>
                                   <?php foreach ($a_view_data['mount'] as $mount) {?>
                                      
                                   
                                    <dd>¥<?php echo $mount['goods_amount']?></dd>
                                    <dd style="text-decoration: line-through">¥<?php echo $mount['use_points'] / 100?></dd>
                                    <dd>¥<?php echo $mount['shipping_fee']?></dd>
                                    <dd><span>¥<?php echo $mount['order_amount']?></span></dd>
                                    <?php }?>
                                </dl>
                            </div>
                    </div>
                </section>
            </div>
        </section>
    </div>
</div>
</div>
<?php echo $this->display('footer');?> 
<script>
// $(".k_pay").click(function(){
//     var order_id=<?php echo $a_view_data['goods'][0]['order_id'];?>;
//     window.lo
// })
$(".receipt_goods").click(function(){
              $.ajax({
                  type: 'POST',
                  data: {order_id:<?php echo $a_view_data['goods'][0]['order_id'];?>},
                  url : "<?php echo $this->router->url('order_logs');?>",
                  success: function(status) {
                  // 设置为 可修改
               
                    if (status==1){
                      alert("确定收货成功");
                      self.location='<?php echo $this->router->url('order_details', [$a_view_data['mount'][0]['order_sn']]);?>'; 
                    }else{
                      alert("确定收货失败，请稍候再试。");
                    }
                  },
                  error: function() {
         
                      alert('请检查网络配置,稍后再试');
                  }
              });
})
//售后触发
$(".cancel").click(function() {
   layer.msg("此功能还未开通，请联系客服！");
})
//售后触发
$(".canc").click(function() {
   layer.msg("订单已付款，仓库配货中，不能取消订单，如需退款，请联系客服！");
})


var intDiff = parseInt(<?php echo $a_view_data['state']['diff_time'];?>);//倒计时总秒数量
if(intDiff>=0){
    $(function(){
        timer(intDiff);
    }); 
}
function timer(intDiff){
    window.setInterval(function(){
    var day=0,
        hour=0,
        minute=0,
        second=0;//时间默认值        
    if(intDiff > 0){
        day = Math.floor(intDiff / (60 * 60 * 24));
        hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
        minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
        second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
    }


    if (minute <= 9 && minute>0) minute = '0' + minute;
    if (second <= 9) second = '0' + second;
    $(".now_state.pend_pay").find("span:eq(2)").text(second);
    $(".now_state.pend_pay").find("span:eq(1)").text(minute);
    $(".now_state.pend_pay").find("span:eq(0)").text(hour);
    intDiff--;
    }, 1000);
} 

</script>
</body>
</html>