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
    <link rel="stylesheet" href="static/style_default/style/newIndex.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/newIndex.js"></script>
    <title>首页</title>
    <style>
    .tips{ width:6.53rem; position:absolute; text-align:center; top:7rem; left:1.8rem; background:white; border-radius:0.2rem;  z-index:2; }
    .tips>p{ margin-top:0.48rem; font-size:0.42rem; font-weight:bold; }
    .tips>span{ display:inline-block; margin-bottom:0.48rem; font-size:0.32rem; }
    .tipsChoice{ font-size:0; }
    .tipsChoice>a{ width:3.2rem; height:1.06rem; line-height:1.06rem; display:inline-block; font-size:0.4rem; color:#005eff; border-top:0.02rem solid #ddd; }
    .tipsChoice>a:first-child{ border-right:0.02rem solid #ddd; }

    .tipsBox{ width:8rem; position:absolute; top:50%; left:1rem; text-align:center; padding:0.26rem; font-size:0.37rem; background:#303030; color:white; border-radius:0.2rem; display:none; z-index:3; }

    .lay{ position:absolute; width:100%; height:100%; top:0; background:black; opacity:0.5; z-index:1; }
    </style>
</head>
<body>
    <!-- 拉框 -->
    <?php echo $this->display('head'); ?>
    <div class="index">
        <!-- 头部 -->
        <div class="head">
            <form action="">
                <!-- 地址 -->
                <div class="addrContainer">
                    <a style="vertical-align:middle;" class="address" onclick="change_location()">
                        <img src="static/style_default/images/location.png" />
                        <span class="current_location"><?php echo $a_view_data['add']?></span>
                        <img src="static/style_default/images/more.png" />
                    </a>
                    <!--<a class="weather">
                        <em>
                            <p>16</p>
                            <span>多云天</span>
                        </em>
                        <img src="static/style_default/images/cloudy.png" />
                    </a>-->
                    <!--<iframe style="width:6rem; height:0.48rem; vertical-align:middle;" scrolling="no" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=10&color=%23FFFFFF&icon=1&site=12"></iframe>-->

                </div>
                <!-- 地址 -->
                <!-- 搜索 -->
                <div class="searchContainer">
                    <div class="searchBox">
                        <a href="product_list-1">
                            <img src="static/style_default/images/search.png" />
                            <span>输入商品名称</span>
                        </a>
                    </div>
                    <ul class="keyText">
                        <?php foreach ($a_view_data['keywords'] as $key => $value): ?>
                        <li><a href=""><?php echo $value['search_keywords']; ?></a></li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <!-- 搜索 -->
                <!-- 收益 -->
                <div class="profit">
                    <div class="yesterday">
                        <p>
                            <span>昨日收益(元)</span>
                            <img class="ciphertext showText" src="static/style_default/images/eye.png" />
                        </p>
                        <input type="text" id="yesCipher" value="<?php echo $a_view_data['yestoday_income']; ?>" disabled/>
                        <input type="password" id="yesEx" value="<?php echo $a_view_data['yestoday_income']; ?>" disabled/>
                    </div>
                    <div class="earnProfit">
                        <div class="shareProfit">
                            <p>
                                <span>分享收益(元)</span>
                            </p>
                            <input type="text" id="shareCipher" value="<?php echo $a_view_data['share_income']; ?>" disabled/>
                            <input type="password" id="shareEx" value="<?php echo $a_view_data['share_income']; ?>" disabled/>
                        </div>
                        <div class="storeProfit">
                            <p>
                                <span>店主收益</span>
                            </p>
                            <input type="text" id="storeCipher" value="<?php echo $a_view_data['shopman_income']; ?>" disabled/>
                            <input type="password" id="storeEx" value="<?php echo $a_view_data['shopman_income']; ?>" disabled/>
                        </div>
                    </div>
                </div>
                <!-- 收益 -->
            </form>
        </div>
        <!-- 头部 -->

        <!-- 导航 -->
        <div class="nav">
            <ul>
                <li class="navList">
                    <a onclick="store_showlist()">
                        <i><img src="static/style_default/images/hiy.png" /></i>
                        <p>门店</p>
                    </a>
                </li>
                <li class="navList">
                    <a href="product_category">
                        <i><img style="width:0.8rem;" src="static/style_default/images/gg.png" /></i>
                        <p>分类</p>
                    </a>
                </li>
                <li class="navList">
                    <a href="product_list">
                        <i><img src="static/style_default/images/Group.png" /></i>
                        <p>产品</p>
                    </a>
                </li>
                <li class="navList">
                    <a onclick="store_showlist()">
                        <i><img src="static/style_default/images/Layer1.png" /></i>
                        <p>会议</p>
                    </a>
                </li>
                <li class="navList">
                    <a onclick="store_showlist()">
                        <i><img src="static/style_default/images/gh.png" /></i>
                        <p>订座</p>
                    </a>
                </li>
                <li class="navList">
                    <?php if (isset($_SESSION['user_id'])) {?>
                    <a href="javascript:" id="assets_shopman" onclick="is_shopman(<?php echo $a_view_data['user']['is_shopman']; ?>)">
                        <i><img src="static/style_default/images/$.png" /></i>
                        <p>移动店主</p>
                    </a>
                    <?php } else {?>
                    <a href="login?oldurl=<?php echo $this->router->get_url(); ?>">
                        <i><img src="static/style_default/images/$.png" /></i>
                        <p>移动店主</p>
                    </a>
                    <?php }?>
                </li>
                <li class="navList">
                    <a onclick="store_showlist()">
                        <i><img src="static/style_default/images/GlossSmall.png" /></i>
                        <p>我要加盟</p>
                    </a>
                </li>
                <li class="navList">
                    <a onclick="store_showlist()">
                        <i><img src="static/style_default/images/sh.png" /></i>
                        <p>我要分享</p>
                    </a>
                </li>
                <li class="navList">
                    <a href="mood_showlist">
                        <i><img src="static/style_default/images/hu.png" /></i>
                        <p>动态</p>
                    </a>
                </li>
                <li class="navList">
                    <a href="notice_showlist">
                        <i><img src="static/style_default/images/email.png" /></i>
                        <p>公告</p>
                    </a>
                </li>
                <li class="navList">
                    <a href="news_showlist">
                        <i><img src="static/style_default/images/knowledge.png" /></i>
                        <p>新闻</p>
                    </a>
                </li>
                <li class="navList">
                    <a href="index_use">
                        <i><img src="static/style_default/images/ph.png" /></i>
                        <p>了解使用</p>
                    </a>
                </li>
            </ul>
        </div>
        <!-- 导航 -->
    </div>
     <!-- 提示 -->
    <div class="tips" style="display: none;">
        <p>注意</p>
        <span>此账号还未申请成为店主</span>
        <div class="tipsChoice">
            <a class="cancelShopper">取消</a>
            <a class="apply">立即申请</a>
        </div>
    </div>
    <div class="tipsBox"></div>
    <!-- 提示 -->
    <div class="lay" style="display: none;"></div>
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

<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="http://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://qiduvdaolink.js"></script>
<?php } ?>

<script>


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

var u = navigator.userAgent;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

// 门店列表
function store_showlist() {
    // if (isAndroid || isiOS) {
    //     openNearStoreList();
    // }
    $(".lay").show();
    $(".popAppTips").show();
}

// 切换定位
function change_location() {
    if (isAndroid || isiOS) {
        var callbackSuccess=function(address){
            var myjson = JSON.parse(address);
            if (myjson.title == '') {
                $('.current_location').html(myjson.cityName+myjson.direction);
            } else {
                $('.current_location').html(myjson.title);
            }
        }
        var obj = {"isAddressUseForHomePage":true};
    }
    if (isAndroid) {
        addressLocation(callbackSuccess,obj);
    } else if (isiOS) {
        obj = JSON.stringify(obj);
        window.webkit.messageHandlers.vdao.postMessage({
            body: obj,
            callback: callbackSuccess+'',
            command: 'addressLocation'
        });
    }
}


</script>