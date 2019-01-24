<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name=”viewport” content=”width=device-width, initial-scale=1″ />
<meta http-equiv="Cache-Control" content="max-age=7200" />
	<title>资产中心</title>

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
function getDom(id){
	return document.getElementById(id)
	}
function showTime(){
	getDom("time-txt").onclick=showAlltime;	
	}
function showAlltime(){
		getDom("allTime").style.display="block";
		getDom("time-layer").style.display="block";
		getDom("time-txt").style.backgroundPosition="135px -24px";
		getDom("time-txt").style.color="#7b8da0";
		getDom("time-layer").onclick=function(){
			 hideAlltime();
			}
		selectTime()
		}
function hideAlltime(){
		getDom("allTime").style.display="none";
		getDom("time-layer").style.display="none";
		getDom("time-txt").style.backgroundPosition="135px -1px";
		getDom("time-txt").style.color="#000";
		}
function selectTime(){
	var pro=getDom("allTime").getElementsByTagName("li");
	var links;
	for(var i=0;i<pro.length;i++){
		 links = pro[i].getElementsByTagName("a");
		for (var j=0;j<links.length;j++){
			links[j].onclick=function(){
				getDom("time-txt").innerHTML=this.innerHTML;
				hideAlltime()
				}
				}
			}
	}
addLoadEvent(showTime);
	
	</script>
  
  <?php echo $this->display('header');?>
  <script type="text/javascript" src="js/toolbar.js"></script>
  <script type="text/javascript" src="js/moneycolorState.js"></script>
  <script src="script/jquery-1.8.3.js"></script>
  <script src="js/layer.js"></script>

  <div class="content_coll">
    <div class="content_coll_money">
    	 <div class="content_coll_money1">
       	<div class="middle-inner">
  		<p><span class="center_info_tit middle-inner-txt">账户余额</span><br/></p>
  		<p><span class="font5"><?php echo $a_view_data['userinfo']['available_predeposit']? $a_view_data['userinfo']['available_predeposit'] : 0 ?></span></p>
  	</div>
       </div>
       <div class="content_coll_money2">
        <ul>
       	 <li><div class="center_info"> <h4 class="center_info_tit">可用资金</h4>              
            <a><p class="font5"><?php echo $a_view_data['userinfo']['available_predeposit'] ?></p></a></div>
            <div class="avail_pic1"></div>
            </li>
             <li style="margin-left:20px;"><div class="center_info"> <h4 class="center_info_tit">充值金额</h4>              
            <a><p class="font5"><?php echo $a_view_data['userinfo']['available_rc_balance'] ?></p></a></div>
            <div class="avail_pic2"></div>
            </li>
             <li style="margin-top: 24px; "><div class="center_info"> <h4 class="center_info_tit">积分</h4>              
            <a><p class="font5"><?php echo $a_view_data['userinfo']['member_points'] ?></p></a></div>
            <div class="avail_pic3"></div>
            </li>
             <li style="margin-top: 24px; margin-left:20px;"><div class="center_info"> <h4 class="center_info_tit">优惠券</h4>              
            <a><p class="font5"><?php echo $a_view_data['voucher']?></p></a></div>
            <div class="avail_pic4"></div>
            </li>
        </ul>
       </div>
       <div class="content_coll_money3">
       <ul>
         <li style="background: #cb51f8"><a href="#" id="name">充值</a></li>

         <li style="background: #5faee3; margin-top: 24px;"><a href="#" id="nam">领券</a></li>
       </ul>
       </div>
  </div>

    <div class="content_coll_top">
  <div class="collect_l"><i class="ticon money-ticon"></i><span>余额记录</span>
  <p class="font4">有钱任性，钱都不知道花哪里去了？快来查查!</p></div>
   <div class="collect_r">
<div class="ordertime-cont">
	<span id="time-txt">
          <?php 
            $s_while = $this->router->get(1);
            if ($s_while==1){
                  echo '今年内收支明细';
                } else if ($s_while==2){
                  echo '2016年收支明细';
                } else if ($s_while==3){
                  echo '2015年收支明细';
                } else if($s_while==4){
                  echo '2014年收支明细';
                } else if($s_while==5){
                  echo '2014年之前收支明细';
                }else{
                  echo '近三个月收支明细';
                } ?>
    </span>							
        <ul id="allTime">
            <li><a href="<?php echo $this->router->url("money", ['while'=>'0', $a_view_data['i_page']]);?>" >
            近三个月收支明细
            </a></li>
            <li><a href="<?php echo $this->router->url("money", ['while'=>'1', $a_view_data['i_page']]);?>" >今年内收支明细</a></li>
            <li><a href="<?php echo $this->router->url("money", ['while'=>'2', $a_view_data['i_page']]);?>" >2016年收支明细</a></li>
            <li><a href="<?php echo $this->router->url("money", ['while'=>'3', $a_view_data['i_page']]);?>" >2015年收支明细</a></li>
            <li><a href="<?php echo $this->router->url("money", ['while'=>'4', $a_view_data['i_page']]);?>" >2014年收支明细</a></li>
            <li><a href="<?php echo $this->router->url("money", ['while'=>'5', $a_view_data['i_page']]);?>" >2014年之前收支明细</a></li>
        </ul>
</div>                                      
   <span class="danwei">单位（元）</span></div>
   </div>
    <hr style=" width:1000px;height:1px;border:0px;background-color:#D5D5D5;color:#D5D5D5; margin-left:20px;"/>
      <div class="Balancerecord">
    <div class="Balancerecord_top">
     <div class="Balancerecord_top_tit">
     <ul>
       <li style="margin-left: 12px;" class="select">
            <a href="<?php echo $this->router->url('money');?>">余额记录</a>
        </li>
       <li>
            <a href="<?php echo $this->router->url('consume');?>">消费记录</a>
        </li>
       <li> 
            <a href="<?php echo $this->router->url('recharge');?>">充值记录</a>
        </li>
       <li>
            <a href="<?php echo $this->router->url('deposit');?>">提现记录</a>
        </li>
     </ul>
    
  </div></div>
  <div id="Balancerecord_con">
    <?php if (empty($a_view_data['balance']['thre'])) {?>
    <div class="product">
  <ul>
    <span class='t'>暂无余额记录.....</span>     </ul>
  </div>
    <?php } else {?>
    
   <table id="table_bg">
     <tbody>
     <?php foreach ( $a_view_data['balance']['thre'] as $value ) { ?>
       <tr>
         <td style="width: 150px; "><?php echo date('Y-m-d H:s' , $value['lg_add_time']); ?></td>
         <td style="width: 100px; ">
         <div class="td_bg1" style="background-color:white">
            <?php if( $value['lg_type'] == 'order_pay' ){
                echo '消费';
              } else if ($value['lg_type'] == 'recharge'){
                echo '充值';
              } else {
                echo '提现';
              }
             ?>
         </div>
         </td>
         <td style="width: 100px; "><div class="autocut width100">
         <?php if( $value['lg_type'] == 'order_pay' ){
                echo '-' . $value['lg_av_amount'];
              } else if ($value['lg_type'] == 'recharge'){
                echo '+' . $value['lg_av_amount'];
              } else {
                echo '-' . $value['lg_av_amount'];
              }
             ?></div></td>
         <td style="width: 200px; "><div class="autocut width200">
         <?php if( $value['lg_type'] == 'order_pay' ){
                echo '购物订单号：' . $value['order_sn'];
              } else if ($value['lg_type'] == 'recharge'){
                echo '银行卡，单次转入';
              } else {
                echo '提现到银行卡';
              }
             ?></div></td>
         <td><span class="verticalline"></span></td>
         <td style=" width: 200px; text-align:left; "><div class="autocut width200">
        <?php if( $value['lg_type'] == 'order_pay' ){
                echo $value['goods_name'];
              } else if ($value['lg_type'] == 'recharge'){
                echo '转入成功';
              } else {
                echo $value['la_desc'];
              }
             ?></div></td>
         <td style="padding-left: 20px;"><div class="td_bg2"><div class="uptd_bg2" style="background-color:white; width:<?php 
         if( $value['lg_type'] == 'order_pay' ){
                if( $value['evaluation_state'] ){
                    echo '200';
                   }else{
                    echo intval($value['order_state'])/40*200;
                   }
              } else if ($value['lg_type'] == 'recharge'){
                echo '200';
              } else {
                echo '200';
              } ?>px;"></div></div></td>
       </tr>
       <?php } ?>
     </tbody>
       
     </table>
      
  </div>
<div id="Turnpage"> 
	<?php echo $a_view_data['balance']['page']; ?>
</div>
<?php }?>
<div class="clear"></div>
</div></div>
</div>

<div id="time-layer"></div>
<?php echo $this->display('footer');?> 
</body>
</html>
<script type="text/javascript" src="js/moneycolorState.js"></script>
<script type="text/javascript" src="js/moneyTurnPage.js"></script>
<script>
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
 
    $("#name").click(function() {
      layer.msg("暂时未开通！");
    });
    $("#nam").click(function() {
      layer.msg("暂时未开通！");
    });
</script>