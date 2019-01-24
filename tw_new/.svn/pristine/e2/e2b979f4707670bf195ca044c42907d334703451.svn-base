
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>七度购商城</title>
     <link rel="stylesheet" type="text/css" href="style/style_pay.css">
     <link rel="stylesheet" type="text/css" href="style/stylei.css">

    <link rel="stylesheet" type="text/css" href="style/needPay.css">
    <link rel="stylesheet" type="text/css" href="style/main.css">

    <link rel="stylesheet" type="text/css" href="style/iconfont.css">
    <script src="script/jquery-1.8.3.js"></script>
    <script src="js/main.js"></script>
    <script src="js/common.js"></script>
    
    <script>
        (function() {
            if (!
                            /*@cc_on!@*/
                    0) return;
            var e = "abbr, article, aside, audio, canvas, datalist, details, dialog, eventsource, figure, footer, header, hgroup, mark, menu, meter, nav, output, progress, section, time, video".split(', ');
            var i= e.length;
            while (i--){
                document.createElement(e[i])
            }
        })()
    </script>
</head>
<body>
<div id="needPay">
 <?php echo $this->display('header_pc',$a_view_data['basic']['cate']);?>
    <section>
        <div class="needPay_info">
            <header class="section_nav_bar">
                <div>
                    <div>
                        <i class="iconfont icon-weidian"></i>
                        <span><a href="http://www.w3school.com.cn">首页</a></span>
                        <span>></span>
                        <span><a>订单付款</a></span>
                    </div>
                </div>
            </header>
            <section>
                <div class="cont">
                    <label class="state state1">
                        <i></i>
                        <em></em>
                    </label>
                    <div>
                        <div>
                            <div class="cont_l">
                                <h3><!-- 订单提交成功， -->请你尽快付款</h3>
                                <p>请在 <span><?php echo $a_view_data['basic']['time']['hour']?></span>小时<span><?php echo $a_view_data['basic']['time']['min']?></span>分<span><?php echo $a_view_data['basic']['time']['sec']?></span>秒内付款，以免订单自动取消</p>
                            </div>
                            <div class="cont_r">
                                <label>应付总额：<span><?php echo $a_view_data['basic']['pay_mount']?></span></label>
                                <a href="<?php echo $this->router->url('order_details',[$a_view_data['basic']['order_sn']]);?>">订单详情<i></i></a>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <span>订单号：</span>
                                <label style="color: #bf0000"><?php echo $a_view_data['basic']['order_sn']?></label>
                            </li>
                            <li>
                                <span>发货清单：</span>
                                <label>
                                <?php foreach($a_view_data['data'] as $key=>$value){?>
                                 <?php if($value['goods_type']=='5'){echo '【赠】';}echo $value['goods_name']?>   x<?php echo $value['goods_num']?><br>
                                <?php } ?>
                             
                                </label>
                            </li>
                            <li>
                                <span>收货信息：</span>
                                <label><?php echo $a_view_data['basic']['receive_name']?>&nbsp;&nbsp;<?php echo $a_view_data['basic']['address']['phone']?>
                                    <?php echo $a_view_data['basic']['address']['address']?> </label>
                            </li>
                            <li>
                                <span>发货方式：</span>
                                <label>快递配送</label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="payment">
                    <h2>选择支付方式支付 <span><?php echo $a_view_data['basic']['pay_mount']?></span>元 </h2>
                    <ul>
                        <li   data-default='1'>
                            <a>账户余额</a>
                            <em></em>
                            <div class="payment_item">
                                <h2>账户余额</h2>
                                <div>
                                <?php if($a_view_data['basic']['money'] == 0) {?>
                                                <i class="active" style="border: 0;"></i>
                                                <?php } else {?>
                                               <i class="active"><span></span></i>
                                               <?php }?>
                                    <p>使用账户余额：<span><?php echo $a_view_data['basic']['money']?></span>元</p>
                                    <label class="<?php if($a_view_data['basic']['money']>=$a_view_data['basic']['pay_mount']){echo 'dn';}?>">（余额不足，请选择其他付款方式）</label>
                                </div>
                                <div>
                                <div>
                                    <ul>
                                        <li class="" data-type="3">
                                            <a>
                                                <i><span></span></i>
                                                <div class="img" style="background-position-y:-480px"></div>
                                            </a>
                                        </li>
                               <!--          <li>
                                            <a>
                                                <i><span></span></i>
                                                <div class="img" style="background-position-y:-520px"></div>
                                            </a>
                                        </li> -->
                   <!--                      <li>
                                            <a>
                                                <i><span></span></i>
                                                <div class="img" style="background-position-y:-560px"></div>
                                            </a>
                                        </li> -->
                                    </ul>
                                </div>
                                </div>

                            </div>

                        </li>

                      
                     
                    </ul>
                    <div class="more_info">
                        <p><i><em></em></i>货到付款(送货上门再收款，只支持现金)</p>
                        <button>确认并支付</button>
                    </div>
                </div>
            </section>
        </div>
    </section>
     <?php if(! empty($_SESSION['user_id'])){ ?>
        <?php $this->display('sidebar_pc');?>
     <?php } ?>
 <?php echo $this->display('footer_pc');?>
  
</div>
<form action="<?php echo get_config_item('main_domain').'/payment'?>" method="POST">
<input type="hidden" name="pay_type" value="1">
<input type="hidden" name="pay_sn[]" value="<?php echo $a_view_data['basic']['pay_sn']?>">
</form>
<script>
//点击货到付款 取消 银行与微信支付 选中
$(".more_info").find("p").click(function(){
    $(".active").removeClass("active");
    $(".payment_item").not('.dn').children(".active").removeClass("active");
    $("form input[name=pay_type]").attr('value','2');
})
//点击余额
$(".payment_item").find("div:eq(0)").click(function(){
    $(this).find("i").addClass("active");
    $(".payment_item").find("div:eq(1)").find("li").removeClass("active");
    $(".more_info").find("em").css("opacity","0");
    $("form input[name=pay_type]").attr('value','1');

})
//点击确定付款
$(".more_info").find("button").click(function(){
    $("form").submit();
})


//点击图片取消货到付款选中


// $(".img").parents("ul:eq(1)").children("li").click(function(){
// $(".more_info").find("em").css("opacity",'0');
// })

// $(".payment_item").find("div").toggle(function(){
// $(this).children("i").removeClass("active");
// $(".more_info").find("em").css("opacity",'0');

// },function(){
//     $(this).children("i").addClass("active");
// })
</script>
</body>
</html>