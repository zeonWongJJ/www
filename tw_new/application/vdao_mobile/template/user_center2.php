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
    <link rel="stylesheet" href="static/style_default/style/userCenter.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/common.js"></script>
    <title>用户中心</title>
    <script>
        $(function(){
            $(".nav>ul>li>a>i>img:last-child").hide();
            $(".nav>ul>li>a>i").click(function(){
                $(this).addClass("cur");
                $(".cur>img:first-child").hide();
                $(".cur>img:last-child").show();
                $(".nav>ul>li>a>i").not($(this)).removeClass("cur");
                $(".nav>ul>li>a>i>:first-child").not( $(".cur>img:first-child")).show();
                $(".nav>ul>li>a>i>:last-child").not( $(".cur>img:last-child")).hide();
            });
            $(".tips").hide();
            $(".lay").hide();

            var u = navigator.userAgent;
            var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
            var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
            if (isAndroid) {
                android_login(); // 安卓登录
            } else if (isiOS) {
                // location.href = 'protocolHead://SignIn_?124';
                ios_login();
            };
        });
    </script>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 用户中心 -->
    <div class="userCenter">
        <!-- 用户信息 -->
        <div class="userContent">
            
            <div class="userPic">
                <?php if (empty($a_view_data['user']['user_pic'])) {
                    echo '<img src="static/style_default/images/tou_03.png" />';
                } else {
                    echo '<img src="'.$a_view_data['user']['user_pic'].'">';
                } ?>
                <span><?php echo $a_view_data['user']['user_name']; ?></span>
            </div>
            <div class="userTool">
                <!--<a href=""><img src="static/style_default/images/in_03.png" /></a>-->
                <!--<a href="user_set"><img src="static/style_default/images/in_05.png" /></a>-->
                <a href="user_erweima">
                	<img src="static/style_default/images/vipCode.png" alt="" />
                	<span>会员专属码</span>
                </a>
            </div>
            <div class="userNav">
                <a href="user_balance">
                    <img src="static/style_default/images/in_13.png" />
                    <p>我的余额</p>
                    <span>¥ <?php echo $a_view_data['user']['user_balance']; ?></span>
                </a>
                <a href="user_score">
                    <img src="static/style_default/images/in_15.png" />
                    <p>我的积分</p>
                    <span><?php echo $a_view_data['user']['user_score']; ?></span>
                </a>
                <a href="user_mood">
                    <img src="static/style_default/images/in_10.png" />
                    <p>我的动态</p>
                    <span><?php echo $a_view_data['mood_count']; ?></span>
                </a>
                <a href="user_set">
                    <img src="static/style_default/images/in_05.png" />
                    <p>设置</p>
                </a>
            </div>
            <div class="userOrders">
                <a href="goods_order">
                    <span>餐饮订单</span>
                </a>
                <a href="order_office">
                    <span>会议订单</span>
                </a>
                <a href="book_order">
                    <span>座位订单</span>
                </a>
            </div>
        </div>
        <!-- 用户信息 -->

        <!-- 导航 -->
        <div class="nav">
            <ul>
                <li>
                    <a class="assets" href="user_asset">
                        <i>
                            <img src="static/style_default/images/in_30.png" />
                            <img src="static/style_default/images/sd7.png" />
                        </i>
                        <span>总资产</span>
                    </a>
                </li>
                <li>
                    <a class="assets" href="collection_showlist">
                        <i>
                            <img src="static/style_default/images/in_24.png" />
                            <img src="static/style_default/images/sd3.png" />
                        </i>
                        <span>我的收藏</span>
                    </a>
                </li>
                <li>
                    <a class="assets" href="footprint_showlist">
                        <i>
                            <img src="static/style_default/images/sd4.png" />
                            <img src="static/style_default/images/in_21.png" />
                        </i>
                        <span>我的足迹</span>
                    </a>
                </li>
                <li>
                    <a class="assets" href="user_comment">
                        <i>
                            <img src="static/style_default/images/in_27.png" />
                            <img src="static/style_default/images/sd2.png" />
                        </i>
                        <span>我的评价</span>
                    </a>
                </li>
                <li>
                    <a class="assets" href="user_invitation">
                        <i>
                            <img src="static/style_default/images/in_43.png" />
                            <img src="static/style_default/images/sd6.png" />
                        </i>
                        <span>邀请好友</span>
                    </a>
                </li>
                <li>
                    <a class="assets" href="javascript:;" id="assets_shopman" onclick="is_shopman(<?php echo $a_view_data['user']['is_shopman']; ?>)">
                        <i>
                            <img src="static/style_default/images/in_37.png" />
                            <img src="static/style_default/images/sd5.png" />
                        </i>
                        <span>我是店主</span>
                    </a>
                </li>
                <li>
                    <a class="assets" href="call_center">
                        <i>
                            <img src="static/style_default/images/in_40.png" />
                            <img src="static/style_default/images/sd1.png" />
                        </i>
                        <span>客服中心</span>
                    </a>
                </li>
                <li>
                    <a class="assets" href="join_showlist">
                        <i>
                            <img src="static/style_default/images/ydi.png" />
                            <img src="static/style_default/images/sssdf.png" />
                        </i>
                        <span>加盟申请</span>
                    </a>
                </li>
				<li>
                    <a class="assets" href="wx_tmp_order">
                        <i>
                            <img src="static/style_default/images/ydi.png" />
                            <img src="static/style_default/images/sssdf.png" />
                        </i>
                        <span>临时微信订单</span>
                    </a>
                </li>
                <!-- <li>
                    <a class="assets" href="myshare">
                        <i>
                            <img src="static/style_default/images/yy.png" />
                            <img src="static/style_default/images/yyaa.png" />
                        </i>
                        <span>我要分享</span>
                    </a>
                </li> -->
            </ul>
        </div>
        <!-- 导航 -->
    </div>
    <!-- 用户中心 -->

    <!-- 提示 -->
    <div class="tips">
        <p>注意</p>
        <span>此账号还未申请成为店主</span>
        <div class="tipsChoice">
            <a class="cancelShopper">取消</a>
            <a class="apply">立即申请</a>
        </div>
    </div>
    <div class="tipsBox"></div>
    <!-- 提示 -->
    <div class="lay"></div>

    <!-- 底部导航 -->
    <?php echo $this->display('bottom'); ?>
    <!-- 底部导航 -->
</body>
</html>

<script>


var sub_flag = true;
// 判断是否移动店主
function is_shopman(is_shopman) {
    if (is_shopman == 0) {
        $(".tips").show();
        $(".lay").show();
        $('.cancelShopper').click(function(event) {
            $(".tips").hide();
            $(".lay").hide();
        });
        $('.apply').click(function(event) {
            if (sub_flag == true) {
                // 发送ajax请求
                $.ajax({
                    url: 'apply_shopman',
                    type: 'POST',
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                        if (res.code == 200) {
                            sub_flag = false;
                            $(".lay").hide();
                            $(".tips").hide(100);
                            $(".tipsBox").stop().show(100).delay(3000).hide(100);
                            $(".tipsBox").html("申请已提交，请等待管理员的审核！");
                            $("#assets_shopman").attr('onclick','is_shopman(2)');
                        }
                    }
                })
            }
        });
    } else if (is_shopman == 1) {
        window.location.href = 'shopman_detail';
    } else {
    	$(".tipsBox").html("申请已提交，请等待管理员的审核！");
        $(".tipsBox").stop().show(100).delay(1000).hide(100);
    }
}

</script>


<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>

<script>

var user_id = "<?php echo $_SESSION['user_id']; ?>";
var user_name = "<?php echo $_SESSION['user_loginname']; ?>";
var user_password = "<?php echo $_SESSION['user_password']; ?>";
var issave = "<?php echo $_SESSION['issave']; ?>";
// 给安卓发送数据
function android_login() {
    var json = { "user_id": user_id, "user_name": user_name, "user_password":user_password, "issave": issave }
    loginSuccess(json);
}

// 给ios发送数据
function ios_login() {
     var json = { "user_id": user_id, "user_name": user_name, "issave": issave , "user_password":user_password,};
    json = JSON.stringify(json);
    window.webkit.messageHandlers.vdao.postMessage({
        body: json,
        callback: '',
        command: 'loginSuccess'
    });
}

</script>
<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>
<script >
    //是否显示标题
    initTitleBarLayoutIsVisible(1);
</script>
