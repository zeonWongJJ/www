<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/pointCash.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/common.js" type="text/javascript"></script>
    <script src="static/style_default/script/pointCash.js"></script>
    <script src="static/style_default/plugin/layer/layer.js?v=4.0"></script>
    <title>提现</title>
    <style>
    	.cardTips{
    		display: none;
    	}
    </style>
    	
</head>
<body>

    <div class="contentContainer">
        <p class="pjoTitle">
            <a href="javascript:window.history.back();" style="top:0.45rem;"><img src="static/style_default/images/kefu_03.png" /></a>
            <span>
            <?php if ($this->router->get(1) == 1) {
                echo '积分提现';
            } else {
                echo '余额提现';
            } ?>
            </span>
        </p>
        <!-- 积分显示 -->
        <div class="pointShow">
            <?php if ($this->router->get(1) == 1) { ?>
                <span>可提现积分</span>
                <p id="pointShow_p"><?php echo $a_view_data['user']['user_score']; ?></p>
            <?php } else { ?>
                <span>可提现余额</span>
                <p id="pointShow_p"><?php echo $a_view_data['user']['user_balance']; ?></p>
            <?php } ?>
        </div>
        <!-- 积分显示 -->
        <!-- 表单 -->
        <div class="pointForm">
            <?php if ($this->router->get(1) == 1) { ?>
                <form action="new_withdraw_score" method="post" onsubmit="return false;">
            <?php } else { ?>
                <form action="new_withdraw_balance" method="post" onsubmit="return false;">
            <?php } ?>
            <form action="new_withdraw_balance" method="post" onsubmit="return false;">
                <!--提现方式-->
                <input type="hidden" name="withdraw_type">
                <ul>
                    <li class="formList" onclick="choose_account()">
                        <span>收款账户</span>
                        <a class="account">
                            <em>
                                <img src="" />
                                <span class="account_tip">请添加收款账户</span>
                            </em>
                            <img src="static/style_default/images/shezhi_03.png" />
                        </a>
                    </li>
                    <li class="formList">
                        <span>收款方式</span>
                        <input type="text" class="shou_type" placeholder="选择账户后会识别方式"/>
                    </li>
                    <li class="formList">
                        <span>姓名</span>
                        <input type="text" name="withdraw_name" placeholder="请输入收款人姓名"/>
                    </li>
                    <li class="formList">
                        <?php if ($this->router->get(1) == 1) { ?>
                            <span>提现积分</span>
                            <input type="text" onkeyup="clearNoNum(this);" name="withdraw_score" placeholder="请输入提取积分"/>
                        <?php } else { ?>
                            <span>提现余额</span>
                            <input type="text" onkeyup="clearNoNum(this);" name="withdraw_money" placeholder="请输入提取金额"/>
                        <?php } ?>
                        <span>
                    </li>
                    <li class="formList">
                        <span>提现密码</span>
                        <input type="password" name="payment_code" placeholder="您在本平台设置的支付密码"/>
                    </li>
                </ul>
                <span class="cardTips">* 中国银联收取1元手续费</span>
                <p>预计2小时内到账</p>
                <input type="submit" id="subBtn" value="确认提取"/>
            </form>
        </div>
        <!-- 表单 -->
        <!-- 底部弹窗 -->
        <div class="popbottom" style="display:none;">
            <dl>
                <dt>完成</dt>
                 <?php if (!empty($a_view_data['user']['wx_openid']) && !empty($a_view_data['user']['wx_nickname'])) {
                    echo '<dd value="3">微信 :' . $a_view_data['user']['wx_openid'] . '</dd>';
                } ?>                
                <?php if (!empty($a_view_data['user']['alipay_number']) && !empty($a_view_data['user']['alipay_realname'])) {
                    echo '<dd value="1">支付宝 ' . $a_view_data['user']['alipay_number'] . '</dd>';
                } ?>
                <?php if (!empty($a_view_data['user']['bank_number']) && !empty($a_view_data['user']['bank_realname'])) {
                    echo '<dd value="2">' . $a_view_data['user']['bank_name'] .' &nbsp;'. $a_view_data['user']['bank_number'] . '</dd>';
                } ?>

                <dd><a href="account_manage">+管理提现账户</a></dd>
            </dl>
        </div>
        <!-- 底部弹窗 -->
        
        <!-- 银行卡提示 -->
        <div class="card_boxTips">
        	<p>
        		<span>收费提示</span>
        		<img  class="closeTips" src="" alt="" />
        	</p>
        	<div class="tipsList">
        		<p>实际到账金额如下</p>
        		<a>
        			<span>到账金额</span>
        			<em>99</em>
        		</a>
        		<a>
        			<span>中国银联收取服务费</span>
        			<em>0.1元</em>
        		</a>
        	</div>
        	<a id="balance_continue">继续提现</a>
        </div>
        <!-- 银行卡提示 -->
    </div>

    <!-- 遮罩层 -->
    <div class="lay" style="display:none;"></div>
    <!-- 遮罩层 -->

</body>
</html>

<script>
$(function() {

    $(function(){
        $(".lay").click(function(){
            $(this).hide();
            $(".popbottom").hide();
            $(".card_boxTips").hide();
        });

        $("#subBtn").click(function(){
            if( $(".shou_type").attr("data-type") == 2 ){
                var point=$(".pointForm ul>li:nth-child(4)>input").val();//获取积分
                var charge=Number(point)-Number(1);
                $(".tipsList>a:nth-child(2)>em").html(charge.toFixed(2)+"元");
                $(".tipsList>a:nth-child(3)>em").html("1元");
                $(".card_boxTips").show();
                $(".lay").show();
            }else{
                withdraw();
                $(".card_boxTips").hide();
            }
        });
    });

    $('#balance_continue').click(function (e) {
        e.stopPropagation();
        if( $(".shou_type").attr("data-type") == 2 ){
            var point=$(".pointForm ul>li:nth-child(4)>input").val();//获取积分
            var charge=Number(point)-Number(1);
            if (charge.toFixed(2) > 0) {
                withdraw();
            } else {
                my_alert('到账金额不合法!');
            }
        } else {
            withdraw();
        }
    });

    function withdraw() {
        var formObj = $('.pointForm').find('form');
        console.log(formObj);
        $.ajax({
            url: formObj.attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: formObj.serialize(),
            success: function(rs) {
                if (typeof(rs) === 'string') {
                    rs = JSON.parse(rs)
                }
                console.log(rs);
                if (parseInt(rs.code) === 200) {
                    my_alert('提现成功');
                    update_withdraw();
                } else {
                    my_alert(rs.msg)
                }
            }
        })
    }
    // $(".lay").click(function(){
    //     $(this).hide();
    //     $(".popbottom").hide();
    //     $(".card_boxTips").hide();
    // });

    // 点击确认提取按钮，ajax余额提现
    // $('#subBtn').click(function(event) {
    //     var formObj = $(this).parent('form');
    //
    //     // update_withdraw();
    //
    //     if( $(".shou_type").attr("data-type") == 2) {
    //         var point = $(".pointForm ul>li:nth-child(4)>input").val();//获取积分
    //         var charge=Number(point)-Number(1);
    //         $(".tipsList>a:nth-child(2)>em").html(charge.toFixed(2)+"元");
    //         $(".tipsList>a:nth-child(3)>em").html("1元");
    //         $(".card_boxTips").show();
    //         $(".lay").show();
    //         // 继续执行提现
    //         $('#balance_continue').click(function() {
    //             $.ajax({
    //                 url: formObj.attr('action'),
    //                 type: 'POST',
    //                 dataType: 'JSON',
    //                 data: formObj.serialize(),
    //                 success: function(rs) {
    //                     if (typeof(rs) === 'string') {
    //                         rs = JSON.parse(rs)
    //                     }
    //                     if (parseInt(rs.code) === 200) {
    //                         my_alert('提现成功');
    //                         updete_withdraw();
    //                     } else {
    //                         my_alert(rs.msg)
    //                     }
    //                 }
    //             })
    //         });
    //         return false;
    //     } else{
    //         // 其他提现
    //         $(".card_boxTips").hide();
    //         update_withdraw();
    //         // $(this).attr("href");
    //     }
    // });
});

function my_alert(msg) {
    if (layer) {
        layer.msg(msg);
    } else {
        alert(msg);
    }
}

/**
 * 更新页面上的剩余积分、余额
 */
function update_withdraw() {
    var withdraw = "<?php echo $this->router->get(1) == 1 ? 'withdraw_score' : 'withdraw_money' ?>"; // 判断提现积分、余额
    var withdraw_count = $('input[name='+withdraw+']').val(); // 获取已提取的数量
    var p = $('#pointShow_p');
    var temp = p.html() - withdraw_count;
    p.html(temp.toFixed(2));

    $('form')[0].reset();
}

function choose_account() {
    $('.lay,.popbottom').show();
    $('.popbottom dl dd').click(function(event) {
        $('.popbottom dl dd').removeClass('popCur');
        $(this).addClass('popCur');
        var type = $(this).attr('value');
        $(".shou_type").attr("data-type",type);
        if (type == 1) {
            var alipay_realname = "<?php echo $a_view_data['user']['alipay_realname']; ?>";
            var alipay_number = "<?php echo $a_view_data['user']['alipay_number']; ?>";
            $(".cardTips").hide();
            $('.account_tip').html(alipay_number);
            $('.account_tip').css('color','black');
            $('.shou_type').val('支付宝');
            $("input[name='withdraw_name']").val(alipay_realname);
            $("input[name='withdraw_type']").val('1');
        } else if (type == 3) {
            var wx_nickname = "<?php echo $a_view_data['user']['wx_nickname']; ?>";
            var wx_openid = "<?php echo $a_view_data['user']['wx_openid']; ?>";
            $(".cardTips").hide();
            $('.account_tip').html(wx_openid);
            $('.account_tip').css('color','black');
            $('.shou_type').val('微信');
            $("input[name='withdraw_name']").val(wx_nickname);
            $("input[name='withdraw_type']").val('3');            

        } else if (type == 2) {
            var bank_realname = "<?php echo $a_view_data['user']['bank_realname']; ?>";
            var bank_number = "<?php echo $a_view_data['user']['bank_number']; ?>";
            $(".cardTips").show();
            $('.account_tip').html(bank_number);
            $('.account_tip').css('color','black');
            $('.shou_type').val('银行卡');
            $("input[name='withdraw_name']").val(bank_realname);
            $("input[name='withdraw_type']").val('2');
        }
    });
}

$('.popbottom dl dt').click(function(event) {
    $('.lay,.popbottom').hide();
    var type = $('.popCur').attr('value');
    if (type == 1) {
        var alipay_realname = "<?php echo $a_view_data['user']['alipay_realname']; ?>";
        var alipay_number = "<?php echo $a_view_data['user']['alipay_number']; ?>";
       
        $('.account_tip').html(alipay_number);
        $('.account_tip').css('color','black');
        $('.shou_type').val('支付宝');
        $("input[name='withdraw_name']").val(alipay_realname);
        $("input[name='withdraw_type']").val('1');
    } else if (type == 3) {
        var wx_nickname = "<?php echo $a_view_data['user']['wx_nickname']; ?>";
        var wx_openid = "<?php echo $a_view_data['user']['wx_openid']; ?>";
        $('.account_tip').html(wx_openid);
        $('.account_tip').css('color','black');
        $('.shou_type').val('微信');
        $("input[name='withdraw_name']").val(wx_nickname);
        $("input[name='withdraw_type']").val('3');        

    } else if (type == 2) {
        var bank_realname = "<?php echo $a_view_data['user']['bank_realname']; ?>";
        var bank_number = "<?php echo $a_view_data['user']['bank_number']; ?>";
        $('.account_tip').html(bank_number);
        $('.account_tip').css('color','black');
        $('.shou_type').val('银行卡');
        $("input[name='withdraw_name']").val(bank_realname);
        $("input[name='withdraw_type']").val('2');
    }
});

    function clearNoNum(obj) {  
    obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符  
        obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字而不是  
        obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的  
        obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");  
        obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); //只能输入两个小数  

}

</script>
<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>
