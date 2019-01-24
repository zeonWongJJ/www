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

            $(".popAppTips").hide();
            $(".lay").height( $(document).height() );

            $(".lay").click(function(){
                $(this).hide();
                $(".popAppTips").hide();
            });
            $(".cancelDw").click(function(){
                $(".lay").hide();
                $(".popAppTips").hide();
            })

            // 重置弹出窗口的屏幕显示位置
            var nagheight = $(window).height(); //浏览器时下窗口可视区域高度
            var nagwidth  = $(window).width(); //浏览器时下窗口可视区域宽
            var tiph   = $('.popAppTips').outerHeight();
            var tipw   = $('.popAppTips').outerWidth();
            $('.popAppTips').css('top', (nagheight-tiph)/2);
            $('.popAppTips').css('left', (nagwidth-tipw)/2);

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
            <div class="userTool">
                <!--<a href=""><img src="static/style_default/images/in_03.png" /></a>-->
                <a href="user_set"><img src="static/style_default/images/in_05.png" /></a>
            </div>
            <div class="userPic">
                <?php if (empty($a_view_data['user']['user_pic'])) {
                    echo '<img src="static/style_default/images/tou_03.png" />';
                } else {
                    echo '<img src="'.$a_view_data['user']['user_pic'].'">';
                } ?>
                <span><?php echo $a_view_data['user']['user_name']; ?></span>
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
                    <a class="assets" onclick="store_showlist();">
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
                    <a class="assets" onclick="store_showlist();">
                        <i>
                            <img src="static/style_default/images/ydi.png" />
                            <img src="static/style_default/images/sssdf.png" />
                        </i>
                        <span>加盟申请</span>
                    </a>
                </li>
                <li>
                    <a class="assets" onclick="store_showlist();">
                        <i>
                            <img src="static/style_default/images/yy.png" />
                            <img src="static/style_default/images/yyaa.png" />
                        </i>
                        <span>我要分享</span>
                    </a>
                </li>
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
        <!-- 弹窗 -->
    <div class="popAppTips" style="position:fixed;">
        <p>请下载app客户端使用此功能</p>
        <div class="tipsBtn">
            <a href="http://vdao_mobile.7dugo.com/vdao.apk" class="goDW">下载</a>
            <a class="cancelDw">取消</a>
        </div>
    </div>

</body>
</html>

<script>
function store_showlist() {
    // if (isAndroid || isiOS) {
    //     openNearStoreList();
    // }
    $(".lay").show();
    $(".popAppTips").show();
}
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
            // 发送ajax请求
            $.ajax({
                url: 'apply_shopman',
                type: 'POST',
                dataType: 'json',
                success: function(res) {
                    console.log(res);
                    if (res.code == 200) {
                        $(".lay").hide();
                        $(".tips").hide(100);
                        $(".tipsBox").stop().show(100).delay(3000).hide(100);
                        $(".tipsBox").html("申请已提交，请等待管理员的审核！");
                        $("#assets_shopman").attr('onclick','is_shopman(2)');
                    }
                }
            })
        });
    } else if (is_shopman == 1) {
        window.location.href = 'shopman_detail';
    } else {
        $(".tipsBox").stop().show(100).delay(1000).hide(100);
        $(".tipsBox").html("申请已提交，请等待管理员的审核！");
    }
}

</script>


<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="http://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://qiduvdaolink.js"></script>
<?php } ?>

<script>

var user_id = "<?php echo $_SESSION['user_id']; ?>";
var user_name = "<?php echo $_SESSION['user_name']; ?>";
// 给安卓发送数据
function android_login() {
    var json = { "user_id": user_id, "user_name": user_name }
    loginSuccess(json);
}

// 给ios发送数据
function ios_login() {
    var json = { "user_id": user_id, "user_name": user_name };
    json = JSON.stringify(json);
    window.webkit.messageHandlers.vdao.postMessage({
        body: json,
        callback: '',
        command: 'loginSuccess'
    });
}

</script>

