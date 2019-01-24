  <!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Cache-Control" content="max-age=7200" />
	<title>我的柒度</title>
  <script src="script/jquery-1.8.3.js"></script>
  <script src="js/layer.js"></script>
<!-- <link rel="stylesheet" href="style/UserCenter.css">
<script type="text/javascript" src="script/jquery-1.8.3.js"></script>
</head>

<body>
<div class="main"> -->

<?php echo $this->display('header');?>
  <div class="content">
  <div class="content_top">
  <div class="content_top_l">
  <div class="content_top_l1"><img src="image/avatar.png" width="117" height="117" title="" style="	border-radius:50%;
"><a href="#"><div class="members"><span class="span1">V</span><span class="span2"><?php if ($a_view_data['userinfo']['member_points'] >= 0){echo '0';} else if ($a_view_data['userinfo']['member_points'] >= 1000){echo '1';} else if ($a_view_data['userinfo']['member_points'] >= 10000){echo '2';} else {echo '3';} ?>会员</span></div></a></div>
  <div class="content_top_l2">
  <ul>		
        <li><?php if ( date('H',$a_view_data['time']) < '6' ) {
              echo '凌晨好,';
            } else if ( date('H',$a_view_data['time']) < '11' ) {
                echo '上午好,';
            } else if ( date('H',$a_view_data['time']) < '14' ) {
                echo '中午好,';
            } else if ( date('H',$a_view_data['time']) < '19' ) {
                echo '下午好,';
            } else if ( date('H',$a_view_data['time']) < '24' ) {
                echo '晚上好,';
            }
            ?><span class="zitiffa642"><?php echo $a_view_data['userinfo']['member_name'] ?></span>！
            <?php if ( date('H',$a_view_data['time']) < '6' ) {
                echo '夜的寂静，使疲惫不堪的城市恢复平静！';
            } else if ( date('H',$a_view_data['time']) < '11' ) {
                echo '美好的一天开始了！';
            } else if ( date('H',$a_view_data['time']) < '14' ) {
                echo '累了，要记得小憩歇会儿！';
            } else if ( date('H',$a_view_data['time']) < '19' ) {
                echo '尽情享受下午宁静的时光吧！';
            } else if ( date('H',$a_view_data['time']) < '24' ) {
                echo '忙碌了一天，要注意休息哦！';
            }
            ?>
        </li>		
        <li style="height:23px; line-height:23px;">
        <ul>
       			<li><a href="#"><img src="image/bindPhone.png"  width="26" height="26" title="手机绑定"></a></li>
                <li style="margin-left:7px;"><a href="#"><img src="image/email2.png" width="26" height="26" title="邮箱绑定"></a></li>
               
                <li style="margin-left:7px;"><a href="#"><img src="image/password.png" width="26" height="26" title="密码登录"></a></li>

               <!--   <li style="margin-left:7px;"><a href="#"><img src="image/data.png" width="26" height="26" title="个人资料"></a></li> -->

	        <!-- 	<li style="margin-left:9px;">|</li>
	            <li style="line-height:26px;margin-left:7px">信用等级:<img src="image/hr.png" title="" style="margin-left:7px"> <a href="#" style="color:#666; margin-left:4px;">信用记录</a></li> -->
        </ul>
            
        </li>
        <li style="clear:both"></li>			
       <!-- <li class="safe-levelinfo-text" style="margin-top:12px;">安全等级:<span class="redfont b"><?php echo $a_view_data['safe'] ; ?></span>
           <a href="#" class="improve">提升安全等级&gt;</a>	--></li>						 
       <!--  <li class="warp-safelevelbar">							
        <div class="safe-level-bar">								
        <ul>																	
        <?php 
        for($num=1;$num<=$a_view_data['userinfo']['safe'];$num++){
          echo '<li class="redbar"></li>';
          }
          // echo $a_view_data['userinfo']['safe'];
          for(;$num<=4;$num++){
          echo '<li class=""></li>';
          }
          ?>														
        </ul>							</div>						</li>	 -->	
        <li style="float:left; margin-top: 0px;">上次登录时间：
        <?php if($a_view_data['userinfo']['member_time_old_login']!=""){
          echo date('Y-m-d H:s:i' ,$a_view_data['userinfo']['member_time_old_login']);
        }else{
          echo "您之前尚未登陆过。";
          }?></li>				
        					</ul>
        
        </div>
  </div>
  <div class="content_top_r">
  <div class="balance">
  <div class="money">
  <span class="font1">账户余额</span>						
  <p class="font2"><a><?php echo $a_view_data['userinfo']['available_predeposit'] ?></a></p></div>  </div>
  <div class="funds">
  <ul style=" border-bottom:1px solid #CCC;">
      <li style=" border-right:1px solid#CCC">
      <P>      <span class="font1">可用资金</span></p>							
          <p class="font2"><a><?php  echo $a_view_data['userinfo']['available_predeposit'];?></a></p>
      </li>
      <li><P>	<span class="font1">已充值总额</span></p>							
          <p class="font2"><a ><?php echo $a_view_data['userinfo']['available_rc_balance'] ?></a></p>
      </li>
  </ul>
  <ul>
      <li style=" border-right:1px solid #CCC; margin-top:13px;">
      <P>	<span class="font1">我的积分</span></p>							
          <p class="font2"><a ><?php echo $a_view_data['userinfo']['member_points'] ?></a></p>
      </li>
      <li style=" margin-top:13px;"><P>	<span class="font1">我的优惠券</span></p>							
          <p class="font2"><a ><?php echo $a_view_data['voucher'];?></a></p>
      </li>
  </ul>

  </div>
  <div class="recharge">
  <ul>
  <a href="#" id="name"><li style="background:#17b9bf" >充值</li></a>
  <a href="#" id="nam"> <li style="background:#e4393c; margin-top:25px;">领券中心</li></a>
  </ul>
  </div></div></div>
  <div class="content_m">
  <div class="content_m_l" style="height:auto">
  <div class="order"><div class="info" >				
            <span class="t" >最近的订单</span>							
            <a class="r" href="<?php echo $this->router->url('order_form');?>" style="display:inline;">查看更多订单 &gt; </a>			</div>
            <?php
              if(empty($a_view_data['order'])){
                echo '<div ><div class="info" style="text-align:center">       
            <span class="t" style="text-align:center;line-height:201px">暂无订单。</span></div></div>';
              }
            ?>
            <?php foreach ($a_view_data['order'] as $key => $value) { ?>
          <ul class="pro">									
            <li>						
            <a target="_blank" href="<?php echo $this->router->url('order_details',[$value['order_sn']]) ?>">                                                   
              <img src="http://www.7dugo.com/upload/shop/store/goods/<?php echo $value['store_id'] ?>/<?php echo $value['goods_image'] ?>" title="" >
            </a>						
            <div class="text">							
            <p>订单编号：							
                     <span class="num"><a style="float:none" href="<?php echo $this->router->url('order_details',[$value['order_sn']]) ?>"><?php echo $value['order_sn'] ?></a></span>
            </p>	
            <input type="hidden" target="_blank" class="order_id" value="<?php echo $value['order_id']?>" >						
            <p>共 <span class="b"><?php echo $value['sum'] ?></span> 件商品</p>							
                <p class="total">总金额：<span>¥<?php echo $value['order_amount']; ?></span></p>
            </div>						
            <div class="bar">																								
                <div class="box <?php if( $value['order_state'] >= 10) echo 'gn'; else echo 'gy';?>">
                    <i class="<?php if( $value['order_state'] >= 10){ echo 'spt1';}else{ echo 'spt3';} ?>"></i>	
                    <p></p>
                    <span><?php echo $value['order_state'] == 0?'订单已关闭':'订单已提交';?></span>									
                </div>																										
                <div class="box <?php if( $value['order_state'] >= 20){ echo 'gn';} else { echo 'gy'; } ?>">				
                    <i class="<?php if( $value['order_state'] >= 20){ echo 'spt1';}else if($value['order_state'] == 10){ echo 'spt2';}else{ echo 'spt3'; } ?>"></i>
                    <p></p>        
                     <span <?php if( $value['order_state'] == 10){ echo 'class="btn k_pay" style="border-color: rgb(221, 221, 221);"';} ?>>付款</span>
                </div>								
                <div class="box <?php if( $value['order_state'] >= 30){ echo 'gn';} else { echo 'gy'; } ?>">
                    <i class="<?php if( $value['order_state'] >= 30){ echo 'spt1';}else if( $value['order_state'] == 20 ){ echo 'spt2';}else{ echo 'spt3'; } ?>"></i>	
                    <p></p>	
                    <span <?php if( $value['order_state'] == 20){ echo 'class="btn k_detail" style="border-color: rgb(221, 221, 221);"';} ?>>商品出库</span>
                </div>
                <div class="box <?php if( $value['order_state'] >= 40){ echo 'gn';} else { echo 'gy'; } ?>">
                    <i class="<?php if( $value['order_state'] == 40){ echo 'spt1';}else if($value['order_state'] >= 30){ echo 'spt2';}else{ echo 'spt3'; } ?>"></i>
                    <p></p>
                    <span <?php if( $value['order_state'] == 30){ echo 'class="btn k_detail" style="border-color: rgb(221, 221, 221);"';} ?>>确认收货</span>
                </div>
                <div class="box <?php if( $value['order_state'] == 40){ echo 'gn';} else { echo 'gy'; } ?>">
                    <i class="<?php if( $value['evaluation_state'] == 1){ echo 'spt1';}else if($value['order_state'] == 40){ echo 'spt2';}else{ echo 'spt3'; } ?>"></i>																	
                    <span <?php if( $value['order_state'] == 40 && $value['evaluation_state'] < 1 ){ echo 'class="btn k_detail" style="border-color: rgb(221, 221, 221);"';} ?>><?php if( $value['evaluation_state'] >= 1){ echo '已评价'; } else{ echo '未评价'; } ?></span>
                </div>
            </div>
            </li>	
          </ul>
          <?php }?>	
		
                                    </div></div>
  <div class="content_m_r">
  <ul>
  <li>
   <a href="order_form-0-10-1.html">
		<img src="image/unpaid.png" /><br>
			<span>未付款订单</span>
			<p><?php echo $a_view_data['state']['stateOne']  ?></p>
	</a>
  </li>
  <li>
     <a href="order_form-0-20-1.html">
		<img src="image/delivery.png" /><br>
			<span>未发货订单</span>
			<p><?php echo $a_view_data['state']['stateTwo']  ?></p>
	</a>

  </li>
  </ul>
    <ul style="margin-top:18px;">
  <li>
   <a href="order_form-0-30-1.html">
		<img src="image/unconfirmed.png" /><br>
			<span>未确认订单</span>
			<p><?php echo $a_view_data['state']['stateThree']  ?></p>
	</a>
  </li>
  <li>
     <a href="order_form-0-40-1.html">
		<img src="image/deal.png" /><br>
			<span>已完成订单</span>
			<p><?php echo $a_view_data['state']['stateFour']  ?></p>
	</a>

  </li>
  </ul>  

  </div>
  </div>
<!--    <div class="content_f">
   <div class="info2">	
    <span class="t">最新活动</span>		
	 <a class="r" href="#" style="display:inline;">查看更多活动 &gt; </a></div>
	 <div class="activity" style="text-align:center">
   <span class="t" style="line-height:268px;">来晚啦，活动已经结束。</span>
	 <ul>
	 <li>
	 <img src="image/activity1.png" /><br>
	 <p>新人专享红包</p>
	 <a href="#"><input type="button" class="receive" value="立即领取"></button></a>
	 </li>
	 <li>
	 <img src="image/activity2.png" /><br>
	<p>会员限时抢</p>
	 <a href="#"><input type="button" class="receive" value="立即参加"></button></a>
	 </li>
	 <li>
	 <img src="image/activity3.png" /><br>
	 <p>会员VIP积分兑换</p>
	 <a href="#"><input type="button" class="receive" value="立即参加"></button></a>
	 </li>
	 <li>
	 <img src="image/activity1.png" /><br>
	 <p>新人专享红包</p>
	 <a href="#"><input type="button" class="receive" value="立即领取"></button></a>
	 </li>
	 </ul></div>
	</div> -->

  </div>
<?php echo $this->display('footer');?>
</body>
<script type="text/javascript">
  $("#name").click(function() {
    layer.msg("暂时未开通！");
  });
  $("#nam").click(function() {
    layer.msg("暂时未开通！");
  });
  $(".k_pay").click(function() {
      var WIDout=$(this).parents("ul").find(".text input").attr("value");
      window.open("order_pay-"+WIDout+".html");
  })
  $(".k_detail").click(function(){
      var WIDout=$(this).parents(".bar").siblings(".text").find(".num>a").attr("href");
      window.open(WIDout);
  })
</script>

</html>
