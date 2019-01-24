<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>填写核对购物信息</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="style/reset.css">
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <link rel="stylesheet" type="text/css" href="style/child.css">
    <script src="script/jquery-1.js"></script>
</head>
	<style>
		.order_item{margin-top:20px;}
		.order_item img{width:70%; display:inherit; margin:0 auto; padding:5px; border-radius:50%; border:1px solid white;}
		.header_l h2{text-align:center; font-size:1.2em; color:white;}
		.header_r{background:#FFF9ED; border:2px solid #FFAA01; margin:10px 0; padding:5px;}
		.cont h2>a{color:#6D6D6D;}
		.orderBox{background:#FFF9ED; margin-top:10px; padding:5px; border:2px solid #FFAA01;}
		.choiceAdd_box{display:none; margin-top:10px;}
		.addAddress{background:#FFAA01; font-size:14px; float:right; margin-right:10px; padding:3px 8px;}
		.choiceAddress{background:#fffdf7; border-bottom:1px solid #ded6c9; padding:10px; margin-top:5px;}
		.choiceAddress li{padding:2px 0;}
		.choiceAddress span,.choiceAddress em{font-size:14px;}
		.deAddr{margin-top:4px; padding:4px 6px; font-size:14px; background:#D9434E; color:white;}
		.activity{width:100%;}
		.activity img{width:100%; vertical-align:bottom;}
		.footer-top{padding:0;}
		.footer-top>p{height:44px; line-height:44px; padding:0 20px; float:left; color:white;}
		.sub{float:right;}
		.sub>input{height:44px; padding:0 20px; color:white; background:#D9434E; border:none;}
		.c-mino{;}
	</style>
<body>
<div class="activity">
    <a href="http://wap.7dugo.com/hunt-6YeR6Iq3-0-0-0-0-0-0-0-0-0-1.html"><img src="image/fatherwap.png" alt="" /></a>
</div>
<header id="header">
    <div class="header-wrap">
        <a class="header-back" href="javascript:history.back();"><span>返回</span> </a>
        <h2>填写核对购物信息</h2>
    </div>
</header>
<div class="buy_step1">

    <div class="buys1-cnt buys1-address-cnt">
        <h3 class="clearfix">收货人信息 <span class="btn-s btn-prink-s fright buys1-edit-address buys1-edit-btn">新增地址</span>  
        <em class="addAddress">选择地址</em>		
        </h3>
        
        <h3 class="clearfix1 hide"> 收货人信息 <span class="btn-s btn-prink-s fright buys1-edit-address buys1-edit-btn1">取消新增地址</span>
        </h3>
        
        <ul class="buys-ycnt buys1-hide-detail info_add">
            <li class="clearfix">
                <span class="key fleft">姓名：</span>

                <div class="value fleft" id="true_name"><?php echo $a_view_data['name'][0]['true_name']?></div>
            </li>
            <li class="clearfix">
                <span class="key fleft">详细地址：</span>

                <div class="value fleft" id="address"><?php echo $a_view_data['name'][0]['area_info']?></div>
            </li>
            <li class="clearfix">
                <span class="key fleft">联系电话：</span>

                <div class="value fleft" id="mob_phone"><?php echo $a_view_data['name'][0]['mob_phone']?></div>
            </li>
        </ul>
        <ul class="buys1-hide-list buys-ycnt hide">
            <li id="addresslist">
                <div class="invoice-addcnt" id="new-address-wrapper">
                    <div class="iadd-title">
                        收货人信息：
                    </div>

                    <div>
                        <p class="iadd-ip">姓名：<span class="opera-tips">(*必填)</span></p>

                        <p class="iadd-ip">
                            <input type="text" class="n-input h22 wp100" name="true_name" id="vtrue_name"/>
                        </p>

                        <p class="iadd-ip"> 手机号码:<span class="opera-tips">(*必填)</span></p>

                        <p class="iadd-ip">
                            <input type="text" class="n-input h22 wp100" name="mob_phone" id="vmob_phone"/>
                        </p>

                        <p class="iadd-ip"> 电话号码:</p>

                        <p class="iadd-ip">
                            <input type="text" class="n-input h22 wp100" name="tel_phone" id="vtel_phone"/>
                        </p>
                    </div>
                    <div class="iadd-title"> 地址信息：</div>
                    <div>
                        <p class="iadd-ip">省份：<span class="opera-tips">(*必填)</span></p>

                        <p class="iadd-ip">
                            <select class="select-30" name="prov" id="vprov">
                            <?php foreach($a_view_data['member'] as $key=>$value){ ?>
                                <option value=<?php echo $value['area_id']?>><?php echo $value['area_name']?></option>
                            <?php } ?>
                            </select>
                        </p>
                        <p class="iadd-ip">城市：<span class="opera-tips">(*必填)</span></p>

                        <p class="iadd-ip">
                            <select class="select-30" name="city" id="vcity">
                            </select>
                        </p>
                        <p class="iadd-ip"> 区县：<span class="opera-tips">(*必填)</span></p>

                        <p class="iadd-ip">
                            <select class="select-30" name="region" id="vregion">
                            </select>
                        </p>
                        <p class="iadd-ip"> 街道：<span class="opera-tips">(*必填)</span></p>

                        <p class="iadd-ip">
                            <input type="text" class="n-input h22 wp100" name="vaddress" id="vaddress">
                        </p>
                    </div>
                </div>
                <div class="error-tips"></div>
            </li>
            <li class="invoice_opeara">
                <a href="javascript:void(0);" class="btn-prink save-address">保存地址信息</a>
            </li>
        </ul>
        
        <!--选择地址 -->
        <div class="choiceAdd_box">
            <?php foreach ($a_view_data['address'] as $add) {?>
        	<ul class="choiceAddress" value="<?php echo $add['address_id']?>">
        		<li>
        			<span>姓名：</span>
        			<em><?php echo $add['true_name']?></em>
        		</li>
        		<li>
        			<span>详细地址：</span>
        			<em><?php echo $add['area_info']?></em>
        		</li>
        		<li>
        			<span>联系电话：</span>
        			<em><?php echo $add['mob_phone']?></em>
        		</li>
        		<div class="deAddr hide">
        			设为默认地址
        		</div>
        	</ul>
        	<?php }?>
        </div>
        
        <!--选择地址 -->
    </div>
    <form action="<?php echo $this->router->url('payment'); ?>" method="post">
    <div class="buys1-cnt payfor">
        <h3 class="clearfix">支付方式</h3>
        <input type="hidden" value="3" name="paytype" class="paytype">
        <ul class="buys-ycnt ">
            <?php if ($a_view_data['name'][0]['available_predeposit'] > $a_view_data['bill']['pricesumfre']) {?>
                <li class="clearfix buys-yc-type balance">
                <label id="1">
                    <input type="radio" class="mr5" name="buy-type" checked id="buy-type-online"
                           onClick="document.getElementById('tishi55').innerHTML = '';document.getElementById('tishi55').style.display ='none';">使用账户余额支付
                </label>
                </li>
            <?php }?>    
            <li class="clearfix buys-yc-type payondelivery" id="is_offline"><label class="mt5" id="2">
                <input type="radio" class="mr5" name="buy-type"
                       onClick="document.getElementById('tishi55').innerHTML = '您当前选择的是货到付款，稍后会有客服人员与您取得联系，请保持电话畅通，如果不能及时与您取得联系，可能会影响您的发货，感谢您的配合与支持！';document.getElementById('tishi55').style.cssText='margin: 5px 15px;color: #F70505;line-height:26px; padding-left:15px; text-indent: 2em; border: 1px solid #F70505;'"
                        />货到付款</label>

                <div id="tishi55"></div>
            </li>
            <li class="clearfix buys-yc-type payterrace">
                <label id="3">
                    <input type="radio" class="mr5" name="buy-type" checked id="buy-type-online"
                           onClick="document.getElementById('tishi55').innerHTML = '';document.getElementById('tishi55').style.display ='none';">使用支付宝支付
                </label>
            </li>
        </ul>
    </div>
    <div class="buys1-cnt">
        <h3 class="clearfix">商品清单 </h3>
        <ul class="buys-ytable mt10" id="goodslist_before">
            <?php if(is_array($a_view_data['bill']['data'])){ foreach ($a_view_data['bill']['data'] as $key => $value) { ?>
                    <?php foreach ($value['goods'] as $k => $v) { ?>
                    <?php if($k == 0){ ?>
                    <div class="store_item">
                        <header>
                            <div class="header_l">
                                <span><?php if($v['is_own_shop'] == 1){ echo '七度自营';} ?></span>
                                <h2><?php echo $v['store_name']; ?></h2>
                                <a href="http://lyt.zoosnet.net/lr/chatpre.aspx?id=LYT42657310" target="_blank"><i class="iconfont icon-kefu"></i></a>
                            </div>
                            <div class="header_r">
                                <p style="float:left;">本单应付：</p>
                                <span style="color:#D9434E;"><span>￥</span><?php echo $value['store']; ?></span>
                                <P style="display: inline-block;"><?php if($v['goods_freight'] == 0){ echo '免运费';}else { echo $v['goods_freight'];}; ?></P>
                                <a><span>?</span></a>
                            </div>
                        </header>
                        <section>
                        <?php } ?>
                            <div class="order_item">
                                <img src="http://www.7dugo.com/upload/shop/store/goods/<?php echo $value['store_id'] . '/' . $v['goods_image']; ?>" href="<?php echo $this->router->url('item', ['goods_id' => $v['goods_id']]); ?>">
                                <div class="orderBox">
                                	<div class="cont">
                                    <h2><a href="<?php echo $this->router->url('item', ['goods_id' => $v['goods_id']]); ?>"><?php echo $v['goods_name']; ?></a></h2>
                                    <p><?php echo $v['keywords']; ?></p>
                                    <?php if($v['have_gift'] == 1){ ?>
                                        <div>
                                            <span>赠</span>
                                            <ul>
                                                <li>
                                                    <p><?php echo $v['gift']['gift_goodsname']; ?></p>
                                                    <span>x<?php echo $v['gift']['gift_amount']; ?></span>
                                                </li>
                                            </ul>
                                        </div> 
                                   <?php } ?>
                                </div>
                                <input type="hidden" name="goods_id[]" value="<?php echo $v['goods_id']; ?>">
                                <input type="hidden" name="num[]" value="<?php echo $value['num'][$k]; ?>">
                                <div class="price" style="display:inline-block ;">
                                    <span style="color:#D9434E;">
                                        <span>￥</span>
                                        <?php if($v['goods_promotion_type'] == 0){echo $v['goods_price'];} else {echo $v['goods_promotion_price'];}  ?>
                                        </span>
                                </div>
                                <div class="number" style="display:inline-block ;">
                                    <span>x<?php echo $value['num'][$k]; ?></span>
                                </div>
                                <div class="amount">
                                    <span style="font-size:1.2em; color:#D9434E;">
                                        <span>￥</span>
                                        <?php print_r($v['num']); ?>
                                        <?php if($v['goods_promotion_type'] == 0){echo $v['goods_price'] * $value['num'][$k];} else {echo $v['goods_promotion_price'] * $value['num'][$k];} ?>
                                    </span>
                                </div>
                                </div>
                                
                            </div>
                        <?php } ?>
                        </section>
                       <!--  <footer>
                            <div>
                                <p>订单备注：</p>
                                <input type="text" name="remarks[<?php echo $value['store_id']; ?>]" placeholder="选填，限50字，建议填写已和卖家协商的内容" >
                            </div>
                        </footer> -->
                    </div>
            <?php } }?>
            <li id="deposit">
                <div class="pre-deposit-wp ">
                    <p class="clearfix" id="wrapper-usepoints">
                        <label id="change_points">
                            使用积分:<input type="hidden" id="member_points" />
                            <input type="hidden" id="use_point_is_lt_member_point" />
                        </label>
                    </p>
                    <input class="min" type="button" value="-" style="    width: 20px;"/>
                    <input class="text_box" name="integral" type="text" value="0" style="width: 50px;"/>
                    <input class="add" name="" type="button" value="+" style="    width: 20px;"/> 减￥ <span id="money">0</span>（可用：<span id="usable"><?php echo $a_view_data['bill']['deductible_point'] * $a_view_data['bill']['data'][1]['num'][0]?></span>）
                </div>
            </li>
            <li class="bd-t-cc">
                <!--<div class="buys-order-total">-->
                    <!--订单总金额：￥<span id="total_price"><?php echo $a_view_data['bill']['pricesum']?></span>-->
                    <!-- <span id="online-total-wrapper">（需在线支付：￥<span id="online-total"><?php echo $a_view_data['bill']['pricesumfre']?></span>）</span> -->
                <!--</div>-->
            </li>
            <!--<li>
                <input type="submit" value="提交订单" style="width: 100%;height: 38px;line-height: 38px;text-align: center;display:block;background: #D9434E;color: #fff;border-color: #D9434E;">
            </li>-->
        </ul>
    </div>
    
</div>
 <!--<?php echo $this->display('footer1');?>-->
 <div class="xuanfu">
    <div class="footer">
        <div class="footer-top">
            <!--<div class="footer-tleft">
                <a class="btn mr5" href="logout.html">注销账号</a>
            </div>
            <a href="" class="gotop">
                <span class="gotop-icon"></span>
                <p>回顶部</p>
            </a>-->
           <p>订单总金额：￥<span id="total_price"><?php echo $a_view_data['bill']['pricesum']?></span></p>
           <div class="sub">
           		 <input type="submit" value="提交订单" style="width: 100%;height:44px;line-height: 38px;text-align: center;display:block;background: #D9434E;color: #fff;border-color: #D9434E;">    
           </div>
        </div>
        <div class="main-opera-pannel" id="main-opera-pannel" style=" display:block;">
        <div class="main-op-table main-op-warp">
            <a href="index" class="quarter">
                <span class="i-home"></span>

                <p>首页</p>
            </a>
            <a href="classify" class="quarter">
                <span class="i-categroy"></span>

                <p>客服</p>
            </a>
            <a href="classify.html" class="quarter">
                <span class="i-mine"></span>

                <p>分类</p>
            </a>
            <a href="shop.html" class="quarter li_shop">
                <span class="i-cart"></span>

               <p>购物车</p>
            </a>
            <a href="member.html" class="quarter li_member li_order_form li_collection li_address">
                <span class="i-mino" style="background:url(image/cap.png)"></span>

                <p style="color:#D9434E;">我的商城</p>
            </a>
        </div>
    </div>
</div>
</form>
</div>	
 	
<script>
$(".save-address").click(function(){
    var name = document.getElementById("vtrue_name").value;
    var mob = document.getElementById("vmob_phone").value;
    var vtel = document.getElementById("vtel_phone").value;
    var vcity = document.getElementById("vcity").value;
    var vregion = document.getElementById("vregion").value;
    var vaddress = document.getElementById("vaddress").value;
    $.ajax({
        type : "POST",
        url : "<?php echo $this->router->url('address_update');?>",
        data: {"true_name" : name,"mob_phone" : mob,"tel_phone" : vtel,"city_id" : vcity,"area_id" : vregion,"address" : vaddress},
        dataType : "json",
        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
        success : function(data) {
            if (data == 1) {                       
                alert ("添加成功！");
                // $(".clearfix").removeClass("hide");
                // $(".clearfix1").addClass("hide");
                // $(".buys1-hide-list").addClass("hide");
                // $(".buys1-hide-detail").removeClass("hide");
                window.location.reload();
            } else {   
                alert("添加失败！");
            }
        },
        error:function(data) {
            alert(data.responseText);
        }
    })
})
$(function(){
    //调用文本里的文件
    $.ajaxSettings.async = false;
    $.getJSON("script/address_json_data.js", function(jsonString){
    json_address_data=jsonString;
    });

   $("select").change(function(){
        var tips="<option>请选择</option>";
        $(this).parents(".iadd-ip").nextAll(".iadd-ip").find("select").children("option").remove();
        $(this).parents(".iadd-ip").nextAll(".iadd-ip").find("select").append(tips);
        var address_id=$(this).attr("value");
        var children_data=json_address_data['low'][address_id];
        var string;
        for(var item in children_data){ 
            string+="<option value="+item+">"+children_data[item]+"</option>";
        }
        $(this).parents(".iadd-ip").next().next().find("select").append(string);
    })
})
//结算页面点击支付方式
$('.balance').click(function(){
    $(this).find('li').addClass('active');
    $('.payondelivery').find('li').removeClass('active');
    $('.payterrace').find('li').removeClass('active');
    $('.paytyp').text('余额支付');
    $('.paytype').val('1');
});
$('.payondelivery').click(function(){
    $(this).find('li').addClass('active');
    $('.balance').find('li').removeClass('active');
    $('.payterrace').find('li').removeClass('active');
    $('.paytyp').text('货到付款');
    $('.paytype').val('2');
});
$('.payterrace').click(function(){
    $(this).find('li').addClass('active');
    $('.balance').find('li').removeClass('active');
    $('.payondelivery').find('li').removeClass('active');
    $('.paytyp').text('支付平台(支付宝)');
    $('.paytype').val('3');
});

$(".buys1-edit-btn").click(function() {
    $(".clearfix1").removeClass("hide");
    $(".clearfix").addClass("hide");
    $(".buys1-hide-list").removeClass("hide");
    $(".buys1-hide-detail").addClass("hide");
    $(".payfor").css("display","none");
})
$(".buys1-edit-btn1").click(function() {
    $(".clearfix").removeClass("hide");
    $(".clearfix1").addClass("hide");
    $(".buys1-hide-list").addClass("hide");
    $(".buys1-hide-detail").removeClass("hide");
    $(".payfor").css("display","block");
});

/*选择地址 */ 
$(".choiceAdd_box").click(function(event){
    event.stopPropagation();
});

$(".addAddress").toggle(function(){	
	$(".choiceAdd_box").css("display","block");
	$(".buys1-edit-btn").css("display","none");
	$(".info_add").addClass("hide");
	$(this).html("取消选择地址");		
},function(){
	$(".choiceAdd_box").css("display","none");
	$(".buys1-edit-btn").css("display","block");
	$(".info_add").removeClass("hide");
	$(this).html("选择地址");
});

$(".addAddress").click(function(){
	$(".deAddr").css("display","none");
	$(".choiceAddress").css("border","none");
})
			
$(".choiceAddress").click(function(){
    $(this).addClass("wer");
	$(this).css({"border":"2px solid #D9434E"});
	$(this).find(".deAddr").css("display","inline-block");
    $(this).siblings().removeClass("wer");
	$(this).siblings().css("border","none");
	$(this).siblings().find(".deAddr").css("display","none");
    var car = $('.wer').attr("value");
    $.ajax({
        type : "POST",
        url : "<?php echo $this->router->url('upaddress');?>",
        data: "car="+car,
        dataType : "json",
        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
        success : function(data) {
           if(data == 1){
                alert("设置成功！");
                window.location.reload();
            } else {
                alert("设置失败！");
            }
        }
    });
})
/* 选择地址 结束*/

$(function(){
    $(".add").click(function(){
    var t=$(this).parent().find('input[class*=text_box]');
    t.val(parseInt(t.val())+100)
    setTotal();
    change_price();
    })
    $(".min").click(function(){
    var t=$(this).parent().find('input[class*=text_box]');
    t.val(parseInt(t.val())-100)
    if(parseInt(t.val())<0){
    t.val(0);
    }
    setTotal();
    change_price();
    })
    function setTotal(){
    var s=0;
    $("#tab td").each(function(){
    s+=parseInt($(this).find('input[class*=text_box]').val())*parseFloat($(this).find('span[class*=price]').text());
    });
    $("#total").html(s.toFixed(2));
    }
    setTotal();

}) 
$('.text_box').change(function(){
    text_box = $(this).val();
    var data = text_box-text_box%100;
    $(this).val(data);
    change_price();  
});
//改价格的方法
var total_price = $('#total_price').text();
function change_price(){
    var max_jifen = parseFloat($('#usable').text());
    var jifen = $('.text_box').attr("value");
    if(max_jifen < jifen){
        alert("超出积分限制");
        $(".text_box").attr("value","0");
        $("#money").text("0");  
        $('#total_price').text(total_price);
    } else {
        $('#money').text(jifen*0.01);
        var money = parseInt($('#money').text()); 
        $('#total_price').text(total_price - money);
    }    
}
</script>
</body>
</html>
