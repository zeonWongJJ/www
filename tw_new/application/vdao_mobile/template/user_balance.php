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
    <link rel="stylesheet" href="static/style_default/style/credit.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <title>我的余额</title>
</head>
<style type="text/css">
    html,body{height:auto}
</style>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 我的余额 -->
    <div class="credit">
        <p class="pjoTitle">
            <!--<img style="margin-top:0.4rem;" src="static/style_default/images/kefu_03.png" onclick="javascript:window.location.href='user_center';" />-->
            <a class="back" href="javascript:history.back(-1);"><img src="static/style_default/images/gouxiang_18.png" /></a>
            <span>我的余额</span>
        </p>
        <!-- 账户余额 -->
        <div class="userAmount">
        	
        	<p><?php echo $a_view_data['user']['user_balance']; ?></p>
            <!--<p>账户余额</p>-->
            <!--<span><?php echo $a_view_data['user']['user_balance']; ?></span>-->
            <!--<p><?php echo $a_view_data['user']['user_balance']; ?></p>-->
            <div class="btn_box">
            	<a href="new_withdraw_balance-2" class="rechange">提现</a>
            	<a href="balance_recharge" class="rechange">充值</a> 
            </div>
            
        </div>
        <!-- 账户余额 -->
        <!--  支付列表 -->
        <div class="payList">
            <dl>
                <dt>
                    <p>余额明细</p>
                </dt>
                <?php foreach ($a_view_data['userbalance'] as $key => $value): ?>
                <dd onclick="balance_detail(<?php echo $value['ub_id']; ?>)">
                    <a>
                        <em>
                            <span><?php echo $value['ub_item']; ?></span>
                            <em>余额：<?php echo $value['ub_balance']; ?></em>
                        </em>
                        <dfn>
                            <span>
                            <?php if ($value['ub_type'] == 1) {
                                echo '+' . $value['ub_money'];
                            } else {
                                echo '-' . $value['ub_money'];
                            } ?>
                            </span>
                            <em><?php echo date('Y-m-d', $value['ub_time']); ?></em>
                        </dfn>
                    </a>
                </dd>
                <?php endforeach ?>
            </dl>
        </div>
        <!--  支付列表 -->
    </div>
    <!-- 我的余额 -->
    
    <!-- 底部导航 -->
   
    <!-- 底部导航 -->
</body>
</html>

<script>

function balance_detail(ub_id) {
    window.location.href = 'balance_detail-' + ub_id;
}

var page = 1;
var stop = true;
var recode = 200;
// 当滚动条滚到底时加载更多
$(window).scroll(function(){
    totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
    if($(document).height() <= totalheight){
        if (stop == true) {
            balance_getmore();
        }
        if (recode == 400) {
            stop = false;
        }
    }
});

function balance_getmore() {
    page++;
    $.ajax({
        url: 'balance_getmore',
        type: 'POST',
        dataType: 'json',
        data: {page: page},
        success: function(res) {
            console.log(res);
            recode = res.code;
            var append_content = '';
            $.each(res.data, function(index, el) {
                append_content += '<dd onclick="balance_detail('+el.ub_id+')">';
                append_content += '<a>';
                append_content += '<em>';
                append_content += '<span>'+el.ub_item+'</span>';
                append_content += '<em>余额：'+el.ub_balance+'</em>';
                append_content += '</em>';
                append_content += '<dfn>';
                append_content += '<span>';
                if (el.ub_type == 1) {
                    append_content += '+'+el.ub_money;
                } else {
                    append_content += '-'+el.ub_money;
                }
                append_content += '</span>';
                append_content += '<em>'+el.ub_time+'</em>';
                append_content += '</dfn>';
                append_content += '</a>';
                append_content += '</dd>';
            });
            $('.payList dl').append(append_content);
        }
    })
}

</script>