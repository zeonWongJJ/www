<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name=”viewport” content=”width=device-width, initial-scale=1″ />
<meta http-equiv="Cache-Control" content="max-age=7200" />
    <title>我的订单</title>
    <script src="script/jquery-1.8.3.js"></script>
    <script src="js/layer.js"></script>
    

    

    <script>
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {  
    window.onload = function() {
      oldonload();
      func();
    }
  }
}
//订单日期展开、关闭
function getDom(id){
    return document.getElementById(id)
    }
function showOrdertime(){
    getDom("order-time").onclick=showAllOrder;  
    }
function showAllOrder(){
        getDom("allOrder").style.display="block";
        getDom("order-layer").style.display="block";
        getDom("allOrder").style.boxShadow="1px 1px 1px  rgba(0,0,0,.12),-1px 1px 1px rgba(0,0,0,.12)";
        getDom("order-time").style.backgroundPosition="105px -23px";
        getDom("order-time").style.boxShadow="1px -1px 1px  rgba(0,0,0,.12),-1px -1px 1px rgba(0,0,0,.12)";
        getDom("order-layer").onclick=function(){
             hideAllOrder();
            }
        selectOrder()
        }
function hideAllOrder(){
        getDom("allOrder").style.display="none";
        getDom("order-layer").style.display="none";
        getDom("order-time").style.backgroundPosition="105px 1px";
        getDom("order-time").style.boxShadow="5px -5px 5px  rgba(255,255,255,.12),-10px -5px 5px rgba(255,255,255,.12)";
        }
function selectOrder(){
    var pro=getDom("allOrder").getElementsByTagName("li");
    var links;
    for(var i=0;i<pro.length;i++){
         links = pro[i].getElementsByTagName("a");
        for (var j=0;j<links.length;j++){
            links[j].onclick=function(){
                getDom("order-time").innerHTML=this.innerHTML;
                hideAllOrder()  
                }
                }
            }
    }


//订单状态展开、关闭
function showOrderstatus(){
    getDom("order-state").onclick=showALLstatus;    
    }
function showALLstatus(){
        getDom("allorder-state").style.display="block";
        getDom("order-layer").style.display="block";
        getDom("allorder-state").style.boxShadow="1px 1px 1px  rgba(0,0,0,.12),-1px 1px 1px rgba(0,0,0,.12)";
        getDom("order-state").style.backgroundPosition="85px -23px";
        getDom("order-state").style.boxShadow="1px -1px 1px  rgba(0,0,0,.12),-1px -1px 1px rgba(0,0,0,.12)";
        getDom("order-layer").onclick=function(){
             hideALLstatus();
            }
        selectStatus()
        }
function hideALLstatus(){
        getDom("allorder-state").style.display="none";
        getDom("order-layer").style.display="none";
        getDom("order-state").style.backgroundPosition="85px 1px";
        getDom("order-state").style.boxShadow="5px -5px 5px  rgba(255,255,255,.12),-10px -5px 5px rgba(255,255,255,.12)";
        }
function selectStatus(){
    var pro=getDom("allorder-state").getElementsByTagName("li");
    var links;
    for(var i=0;i<pro.length;i++){
         links = pro[i].getElementsByTagName("a");
        for (var j=0;j<links.length;j++){
            links[j].onclick=function(){
                getDom("order-state").innerHTML=this.innerHTML;
                hideALLstatus()             
                           
                }
                }
            }
    }
    

addLoadEvent(showOrdertime);
addLoadEvent(showOrderstatus);
   
    
</script>

<?php echo $this->display('header');?>
<script type="text/javascript" src="js/toolbar.js"></script>

    <div class="content_coll">
        <div class="content_coll_top">
            <div class="collect_l">
                <i class="ticon order-ticon"></i>
                <span class="font3">订单管理</span><br />
                <p class="font4">先下手为强，钜惠商品抢先收藏！</p>
            </div>
        </div>
        <hr style=" width:1000px;height:1px;border:0px;background-color:#D5D5D5;color:#D5D5D5; margin-left:20px;"/>
        <ul class="order-num">
            <li>
            <a href="<?php echo $this->router->url("order_form", [$a_view_data['i_indent'], 'i_status'=>'10', $a_view_data['i_page']]);?>">
                <div class="order_pic order_pic2"></div>
                <div class="order_info">
                    <p class="font5"><?php echo $a_view_data['arrearage']?></p>
                    <h4 class="order_info_tit">未付款订单</h4>    
                </div>     
            </a>
            </li>
            <li>
            <a href="<?php echo $this->router->url("order_form", [$a_view_data['i_indent'], 'i_status'=>'20', $a_view_data['i_page']]);?>">
                <div class="order_pic order_pic4"></div>
                <div class="order_info">          
                    <p class="font5"><?php echo $a_view_data['shipments']?></p>
                    <h4 class="order_info_tit">未发货订单</h4>    
                </div>   
             </a>       
            </li>
            <li>
            <a href="<?php echo $this->router->url("order_form", [$a_view_data['i_indent'], 'i_status'=>'30', $a_view_data['i_page']]);?>">
                <div class="order_pic order_pic1"></div>
                <div class="order_info">          
                    <p class="font5"><?php echo $a_view_data['delive']?></p>
                    <h4 class="order_info_tit">未确认订单</h4>    
                </div>      
            </a>    
            </li>
            <li style="margin-right:0px;">
            <a href="<?php echo $this->router->url("order_form", [$a_view_data['i_indent'], 'i_status'=>'40', $a_view_data['i_page']]);?>">
                <div class="order_pic order_pic3"></div>
                <div class="order_info">          
                    <p class="font5"><?php echo $a_view_data['make']?></p>
                    <h4 class="order_info_tit">已成交订单</h4>    
                </div>       
            </a> 
            </li>           
        </ul>
        <div class="order-thead">
            <div class="order-times">
                <span id="order-time">
                <?php if ($a_view_data['i_indent'] == 1) {
                    echo "今年内订单";
                } else if ($a_view_data['i_indent'] == 2) {
                    echo "2016年订单";
                } else if ($a_view_data['i_indent'] == 3) {
                    echo "2015年订单";
                } else if ($a_view_data['i_indent'] == 4) {
                    echo "2014年订单";
                } else if ($a_view_data['i_indent'] == 5) {
                    echo "2014年之前订单";
                } else {
                    echo "近三个月订单";
                }?></span>                 
                <ul id="allOrder">
                    <li><a href="<?php echo $this->router->url("order_form", ['i_indent'=>'0', $a_view_data['i_status'], $a_view_data['i_page']]);?>" >近三个月订单</a></li>
                    <li><a href="<?php echo $this->router->url("order_form", ['i_indent'=>'1', $a_view_data['i_status'], $a_view_data['i_page']]);?>" >今年内订单</a></li>
                    <li><a href="<?php echo $this->router->url("order_form", ['i_indent'=>'2', $a_view_data['i_status'], $a_view_data['i_page']]);?>" >2016年订单</a></li>
                    <li><a href="<?php echo $this->router->url("order_form", ['i_indent'=>'3', $a_view_data['i_status'], $a_view_data['i_page']]);?>" >2015年订单</a></li>
                    <li><a href="<?php echo $this->router->url("order_form", ['i_indent'=>'4', $a_view_data['i_status'], $a_view_data['i_page']]);?>" >2014年订单</a></li>
                    <li><a href="<?php echo $this->router->url("order_form", ['i_indent'=>'5', $a_view_data['i_status'], $a_view_data['i_page']]);?>" >2014年之前订单</a></li>
                </ul>
            </div>
            <div class="fl t-details">订单详情</div>
            <div class="fl t-recipient">收件人</div>
            <div class="fl t-quantity2">金额(元)</div>
            <div class="order-state-cont">
                <span id="order-state">
                <?php if ($a_view_data['i_status'] == 1) {
                    echo "全部状态";
                } else if ($a_view_data['i_status'] == 10) {
                    echo "待付款";
                } else if ($a_view_data['i_status'] == 20) {
                    echo "待发货";
                } else if ($a_view_data['i_status'] == 30) {
                    echo "待收货";
                } else if ($a_view_data['i_status'] == 40) {
                    echo "已完成";
                } else if ($a_view_data['i_status'] == 2) {
                    echo "已关闭";
                }?></span>
                <ul id="allorder-state">
                    <li><a href="<?php echo $this->router->url("order_form", [$a_view_data['i_indent'], 'i_status'=>'1', $a_view_data['i_page']]);?>" >全部状态</a></li>
                    <li><a href="<?php echo $this->router->url("order_form", [$a_view_data['i_indent'], 'i_status'=>'10', $a_view_data['i_page']]);?>" >待付款</a></li>
                    <li><a href="<?php echo $this->router->url("order_form", [$a_view_data['i_indent'], 'i_status'=>'20', $a_view_data['i_page']]);?>" >待发货</a></li>
                    <li><a href="<?php echo $this->router->url("order_form", [$a_view_data['i_indent'], 'i_status'=>'30', $a_view_data['i_page']]);?>" >待收货</a></li>
                    <li><a href="<?php echo $this->router->url("order_form", [$a_view_data['i_indent'], 'i_status'=>'40', $a_view_data['i_page']]);?>" >已完成</a></li>
                    <li><a href="<?php echo $this->router->url("order_form", [$a_view_data['i_indent'], 'i_status'=>'2', $a_view_data['i_page']]);?>" >已关闭</a></li>
                </ul>
            </div>
            <div class="fl t-action2">操作</div>
            </div>

            <div class="order-list" style="margin-bottom: 120px;">
                <?php if (empty($a_view_data['order'])) {?>
                    <div class="product">
                        <ul>
                            <span class='t'>您还没有订单记录，去去<a href="<?php echo get_config_item('index')?>">逛逛</a>吧~</span>     
                        </ul>
                    </div>
                <?php } else {?>
                
               <table id="order-tab">
                    <?php foreach ($a_view_data['order'] as  $order) { ?>
                        <?php if($order['order_state'] == 0) {?>
                        <form action="<?php echo get_config_item('index')?>/shop" method="post">
                        <tbody>
                            <tr>
                                <td class="mytd"><div class="Color-dots" id="Color-dots" style="background: rgb(203, 81, 248) none repeat scroll 0% 0%;"></div> </td>
                                <td class="table-left-top">
                                    <span class="fl gap"></span>
                                    <span class="fl dealtime" title=""><?php echo date('Y-m-d  H:i:s', $order['time_create'])?></span>
                                    <span class="fl number">订单号：
                                        <input type="hidden" name="repurchase" id="repurchase" target="_blank" value="<?php echo $order['order_id']?>" >
                                        <a><?php echo $order['order_sn']?></a>
                                    </span>
                                    <div class="fl tr-operate">
                                        <span class="order-shop">
                                            <a href="<?php echo get_config_item('index')?>/search--0-0-0-0-0-0-0-0-0-0-<?php echo $order['store_id']?>-0.html" target="_blank" class="shop-txt" title="<?php echo $order['store_name']?>">
                                                <i>商</i><?php echo $order['store_name']?>
                                            </a>
                                            <a class="btn-im" href="http://lyt.zoosnet.net/lr/chatpre.aspx?id=LYT42657310" target="_blank" title="联系卖家"></a>
                                        </span>           
                                    </div>
                                </td>
                                <td class="right-bgwd"></td>
                                <td class="right-bgwd"></td>
                                <td class="right-bgwd"></td>                       
                                <td class="right-bgwd"></td>                       
                                                           
                            </tr>
                            <tr>
                                <td class="mytd2"><div class="dashed-lines"></div></td>
                                <td>
                                    <table style="width:100%;" >                            
                                        <tbody>
                                           <?php foreach ($a_view_data['ord'] as $ord) { 
                                                 if ($order['order_id'] == $ord['order_id']) {      
                                            ?>
                                            <tr class="tr-bd">
                                                    <td>
                                                        <div class="goods-item">
                                                            <div class="p-img">
                                                                <a href="<?php echo get_config_item('index')?>/item-<?php echo $ord['goods_id']?>.html" target="_blank">
                                                                    <img class="" src="<?php echo get_config_item('goods_img')?><?php echo $ord['store_id']?>/<?php echo $ord['goods_image']?>" title="<?php echo $ord['goods_name']?>" width="60" height="60">
                                                                </a>
                                                                </div>
                                                            <div class="p-msg">
                                                                <div class="p-name">
                                                                    <a href="<?php echo get_config_item('index')?>/item-<?php echo $ord['goods_id']?>.html" class="a-link" target="_blank" title="<?php echo $ord['goods_name']?>"> <?php echo $ord['goods_name']?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="goods-number">x<?php echo $ord['goods_num']?></div>  
                                                            <div class="unitPrice">
                                                                <span class="upunitPrice">￥<?php echo $ord['goods_pay_price']?></span> <br>
                                                                <span class="line-through">￥<?php echo $ord['goods_price']?></span>
                                                            </div>                                                        
                                                    </td> 
                                            </tr> 
                                            <?php }}?>      
                                        </tbody>
                                                                 
                                          
                                    </table>
                               </td>
                                <td class="right-border">
                                    <div class="consignee tooltip">
                                        <span class="txt"><?php echo $order['buyer_name']?></span><b></b>
                                    </div>
                                </td>
                                <td class="right-border">
                                    <div class="amount">
                                       <span style="height:18px; line-height:18px"> 总额 <input type="hidden" name="WIDtotal_fee" id="WIDtotal_fee" value="<?php echo $order['order_amount']?>"><?php echo $order['order_amount']?></span><br>
                                       (运费:￥<?php echo $order['shipping_fee']?>)
                                        <span class="ftx-13">在线支付</span>
                                    </div>
                                </td>
                                <td class="right-border">
                                    <div class="status">
                                        <span class="order-status ftx-03"><?php if ($order['order_state'] == 0) {
                                           $tips="已关闭";
                                        }
                                        echo $tips.'<a href="'.$this->router->url('order_details',[$order['order_sn']]).'" target="_blank">';

                                        ?></span><br>
                                        订单详情</a>
                                    </div>
                                </td>
                                <td class="right-border">
                                    
                                        
                                           <div class="operate"><a class="btn-fast" target="_blank"> <b class="b3">  </b>   <input class="sure-submit cart" value="重新购买" type="submit"name="submit"></input></a></div>
                                </td>
                            <tr class="sep-row">
                                <td colspan="6" style="border:none"></td>
                            </tr>
                        </tbody>
                        </form>
                        <?php } else {?>
                        <tbody>
                            <tr>
                                <td class="mytd"><div class="Color-dots" id="Color-dots" style="background: rgb(203, 81, 248) none repeat scroll 0% 0%;"></div> </td>
                                <td class="table-left-top">
                                    <span class="fl gap"></span>
                                    <span class="fl dealtime" title=""><?php echo date('Y-m-d  H:i:s', $order['time_create'])?></span>
                                    <span class="fl number">订单号：
                                        <input type="hidden" name="WIDout" id="WIDout" target="_blank" value="<?php echo $order['order_id']?>" >
                                        <a><?php echo $order['order_sn']?></a>
                                    </span>
                                    <div class="fl tr-operate">
                                        <span class="order-shop">
                                            <a href="<?php echo get_config_item('index')?>/search--0-0-0-0-0-0-0-0-0-0-<?php echo $order['store_id']?>-0.html" target="_blank" class="shop-txt" title="<?php echo $order['store_name']?>">
                                                <i>商</i><?php echo $order['store_name']?>
                                            </a>
                                            <a class="btn-im" href="http://lyt.zoosnet.net/lr/chatpre.aspx?id=LYT42657310" target="_blank" title="联系卖家"></a>
                                        </span>           
                                    </div>
                                </td>
                                <td class="right-bgwd"></td>
                                <td class="right-bgwd"></td>
                                <td class="right-bgwd"></td>                       
                                <td class="right-bgwd"></td>                       
                                                           
                            </tr>
                            <tr>
                                <td class="mytd2"><div class="dashed-lines"></div></td>
                                <td>
                                    <table style="width:100%;" >                            
                                        <tbody>
                                           <?php foreach ($a_view_data['ord'] as $ord) { 
                                                 if ($order['order_id'] == $ord['order_id']) {      
                                            ?>
                                            <tr class="tr-bd">
                                                    <td>
                                                        <div class="goods-item">
                                                            <div class="p-img">
                                                                <a href="<?php echo get_config_item('index')?>/item-<?php echo $ord['goods_id']?>.html" target="_blank">
                                                                    <img class="" src="<?php echo get_config_item('goods_img')?><?php echo $ord['store_id']?>/<?php echo $ord['goods_image']?>" title="<?php echo $ord['goods_name']?>" width="60" height="60">
                                                                </a>
                                                                </div>
                                                            <div class="p-msg">
                                                                <div class="p-name">
                                                                    <a href="<?php echo get_config_item('index')?>/item-<?php echo $ord['goods_id']?>.html" class="a-link" target="_blank" title="<?php echo $ord['goods_name']?>"> <?php echo $ord['goods_name']?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="goods-number">x<?php echo $ord['goods_num']?></div>  
                                                            <div class="unitPrice">
                                                                <span class="upunitPrice">￥<?php echo $ord['goods_pay_price']?></span> <br>
                                                                <span class="line-through">￥<?php echo $ord['goods_price']?></span> 
                                                            </div>                                                        
                                                    </td> 
                                            </tr> 
                                            <?php }}?>      
                                        </tbody>
                                                                 
                                          
                                    </table>
                               </td>
                                <td class="right-border">
                                    <div class="consignee tooltip">
                                        <span class="txt"><?php echo $order['buyer_name']?></span><b></b>
                                    </div>
                                </td>
                                <td class="right-border">
                                    <div class="amount">
                                       <span style="height:18px; line-height:18px"> 总额 <input type="hidden" name="WIDtotal_fee" id="WIDtotal_fee" value="<?php echo $order['order_amount']?>"><?php echo $order['order_amount']?></span><br>
                                       (运费:￥<?php echo $order['shipping_fee']?>)
                                        <span class="ftx-13">在线支付</span>
                                    </div>
                                </td>
                                <td class="right-border">
                                    <div class="status">
                                        <span class="order-status ftx-03"><?php if ($order['order_state'] == 10) {
                                           $tips="待付款";
                                         
                                        } else if ($order['order_state'] == 20) {
                                           $tips="已付款";
                                  
                                        } else if ($order['order_state'] == 30) {
                                           $tips="已发货";
                                  
                                        } else if ($order['order_state'] == 40) {
                                           $tips="已收货";
                                       
                                        } else if ($order['order_state'] == 50) {
                                           $tips="退款完成";
                                 
                                        }
                                        echo $tips.'<a href="'.$this->router->url('order_details',[$order['order_sn']]).'" target="_blank">';

                                        ?></span><br>
                                        订单详情</a>
                                    </div>
                                </td>
                                <td class="right-border">
                                    
                                        <?php if ($order['order_state'] == 10) {
                                            echo '<div class="operate">
                                            <a class="btn-fast" target="_blank"> <b class="b1">  </b><input class="sure-submit payment" value="立即付款" type="submit"></a>
                                                        <a target="_blank" class="non" style="color:#333;">取消订单</a></div>';
                                        } else if ($order['order_state'] == 20) {
                                            echo ' <div class="operate">
                                                        <a class="btn-fast"><b class="b4"></b>等待发货</a>
                                                    </div>';
                                        } else if ($order['order_state'] == 30) {
                                            echo '<div class="operate" ><a class="btn-fast err" target="_blank"> <b class="b3">  </b>  
                                                <input class="sure-submit" value="确认收货" type="submit"></input>
                                                 </a>
                                                 <a class="refund kefu" style="color:#333;">申请退款</a>
                                                        </div>';
                                        } else if ($order['order_state'] == 40) { 
                                            echo '  <div class="status ">
                                                        <a class="kefu">评价</a>|<a class="kefu">晒单</a><br><a class="kefu">申请售后</a>
                                                    </div>';
                                        }?>
                                </td>
                            <tr class="sep-row">
                                <td colspan="6" style="border:none"></td>
                            </tr>
                        </tbody>
                        <?php }?>
                    <?php }?>  
                </table> 
            <div id="Turnpage" style="float: none;display: flex;justify-content: flex-end;">
             <?php echo $a_view_data['page']?>
             <?php }?>
            </div>   
    </div> 
    
    <div class="pop delOrderPop" id="confirm" style="position: absolute; left: 50%;top: 50%;margin-left: -136px; display:none">                           
        <div class="deleleText">                                
            <p>您是否确认收货？</p>                               
            <p class="grayfont ml2">确认后，商品有问题请联系客服！</p>
            <p class="grayfont mt2 ml2">                                    
            <a class="blueBtn fl" id="fl">确定</a>                                   
            <a href="javascript:;" class="grayBtn fl ml2" id="hide">取消</a>                               
            </p>                            
        </div>                      
    </div>

 <div class="pop delOrderPop" id="abolish" style="position: absolute; left: 50%;
top: 50%;margin-left: -136px; display:none">                           
        <div class="deleleText">                                
            <p>您是否确认取消？</p>                               
            <p class="grayfont ml2">取消后，想再购买可以直接购买！</p>
            <p class="grayfont mt2 ml2">                                    
            <a class="blueBtn fl" id="conf">确定</a>                                   
            <a href="javascript:;" class="grayBtn fl ml2" id="hin">取消</a>                               
            </p>                            
        </div>                      

    </div>


<div id="order-layer"></div>
</div>
<?php echo $this->display('footer');?> 
</body>
</html>

<script type="text/javascript" src="js/orderColorState.js"></script>
<script>
    //分页
    $("#Turnpage a").each(function(i){
        var str = '<b>';
        var num = $(this).text();
        var num1 = $(this).html();
        if( ! isNaN(num) ){
            num1.indexOf(str)!= -1 ?$(this).addClass('num').css('display','inline-block'):$(this).addClass('num').css('display','none');
        }else{
            $(this).addClass('abled');
        }
    });

    //确定订单 
    $(".err").click(function(){
        var text = $(this).parents("tbody").find(".fl.number input").attr("value");
        $("#confirm").show();
         $("#fl").unbind("click").click(function(){
            $.ajax({
                type : "POST",
                url : "<?php echo $this->router->url('order_confirm');?>",
                data: "abc="+text,
                dataType : "json",
                contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                success : function(data)
                {
                    if (data == 123) {
                        parent.location.reload();
                    } else {
                        alert('请求错误！');
                    }
                }
            });
        });
   
        $("#hide").click(function(){
          $("#confirm").hide();
        });
    });

    //未付款的取消
    $(".non").click(function() {
        var non = $(this).parents("tbody").find(".fl.number input").attr("value");
        $("#abolish").show();
        $("#conf").unbind("click").click(function(){
            $.ajax({
                type : "POST",
                url : "<?php echo $this->router->url('order_confirm');?>",
                data: "non="+non,
                dataType : "json",
                contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                success : function(data)
                {
                    if (data == 88) {                       
                        parent.location.reload();
                    } else {
                        alert('请求错误！');
                    }
                }
            });
        });
   
        $("#hin").click(function(){
          $("#abolish").hide();
        });    
    });
    
    //立即支付
    $(".payment").click(function() {
        var WIDout = $(this).parents("tbody").find(".fl.number a").text();
        // window.open("order_pay-"+WIDout+".html");
        window.open("pay-"+WIDout);
    });  

     //售后
    $(".kefu").click(function() {
        layer.msg('此功能还未开通，请联系客服！');
    })
</script>