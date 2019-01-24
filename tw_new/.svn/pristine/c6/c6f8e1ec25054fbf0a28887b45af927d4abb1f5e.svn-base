<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="./static/style_default/style/common.css"/>
    <link rel="stylesheet" href="./static/style_default/style/storeIndex.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/flexible.js"></script>
    <title>店铺详情</title>
    <script>
        $(function(){
            $(".collection").click(function(){
                if( $(this).hasClass("coll") ){
                    $(this).removeClass("coll");
                    $(this).children("img").attr("src","./static/style_default/images/sd3.png");
                }else{
                    $(this).addClass("coll");
                    $(this).children("img").attr("src","./static/style_default/images/coll_03.png");
                }
                // 发送一条ajax请求
                var store_id = "<?php echo $a_view_data['detail']['store_id']; ?>";
                $.ajax({
                    url: 'store_collection',
                    type: 'POST',
                    dataType: 'json',
                    data: {store_id: store_id},
                    success: function(res) {
                        console.log(res);
                    }
                })
            });

            //点击分享
            $('body').on('click','.share',function(){
                $('.shade').show();
                $('.shareBomb').show();
            })
            //关闭弹框
            $('.shareBomb .cancel a').click(function(){
                $('.shade').hide();
                $('.shareBomb').hide();
            })

        })
    </script>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 店铺首页  -->
    <div class="storeIndex">
        <div class="pjoTitle">
            <a href="javascript:;" onclick="goback_app()">
                <img src="./static/style_default/images/dri_03.png" />
            </a>
            <span><?php echo $a_view_data['detail']['store_name']; ?></span>
            <em>
                <a href="javascript:;" class="release share">
                <img src="./static/style_default/images/dt_13.png" />
                </a>
                <a class="collection <?php if ($a_view_data['collection'] == 1) { echo 'coll'; } ?>">
                <?php if ($a_view_data['collection'] == 2) {
                    echo '<img src="./static/style_default/images/sd3.png" />';
                } else {
                    echo '<img src="./static/style_default/images/coll_03.png" />';
                } ?>
                </a>
            </em>
            <!-- 店铺信息 -->
            <div class="situation">
                <?php if (empty($a_view_data['detail']['store_touxiang'])) {
                    echo '<img src="./static/style_default/images/tou_03.png" />';
                } else {
                    echo '<img src="'.get_config_item('store_touxiang').$a_view_data['detail']['store_touxiang'].'" />';
                } ?>
                <p>
                    月售<span><?php echo $a_view_data['order_month']; ?></span>单
                </p>
            </div>
            <!-- 店铺信息 -->
            <!-- 预定 -->
            <div class="reserve">
                <a href="office_showlist-1-<?php echo $a_view_data['detail']['store_id']; ?>" class="reserveOffice">
                    <img src="./static/style_default/images/sIn_11.png" />
                    <em>
                        <!-- <span>预定</span> -->
                        <p>会议</p>
                    </em>
                </a>
                <a href="list_store-<?php echo $a_view_data['detail']['store_id']; ?>" class="reserveCafe">
                    <img src="./static/style_default/images/sIn_14.png" />
                    <em>
                        <!-- <span>预定</span> -->
                        <p>餐饮</p>
                    </em>
                </a>
                <a href="office_showlist-2-<?php echo $a_view_data['detail']['store_id']; ?>" class="seat">订座</a>
            </div>
            <!-- 预定 -->
        </div>
        <div class="part2">
            <!-- 店铺评价 -->
            <dl class="storeEvaluate">
                <dt>店铺评价</dt>
                <dd class="scoreBox">
                    <a class="score">
                        <span><?php echo $a_view_data['star']; ?></span>
                    </a>
                    <a class="scoreStar">
                        <?php for ($i=0; $i < round($a_view_data['star']); $i++) { ?>
                        <img src="./static/style_default/images/star_03.png" />
                        <?php } ?>
                        <?php for ($i=0; $i < 5 - round($a_view_data['star']); $i++) { ?>
                        <img src="./static/style_default/images/star_05.png" />
                        <?php } ?>
                        <p><span><?php echo $a_view_data['comment_count']; ?></span>条点评</p>
                    </a>
                </dd>
                <?php if (!empty($a_view_data['comment_count'])) { ?>
                <dd class="storeUser">
                    <?php if (empty($a_view_data['comment']['user_pic'])) {
                        echo '<img src="./static/style_default/images/tou_03.png" />';
                    } else {
                        echo '<img src="'.$a_view_data['comment']['user_pic'].'" />';
                    } ?>
                    <em>
                        <p><?php echo $a_view_data['comment']['user_name']; ?></p>
                        <span<?php echo date('m-d', $a_view_data['comment']['comment_time']) ?></span>
                    </em>
                </dd>
                <dd class="storeProduct">
                    <p>
                        <span>产品：</span>
                        <em><?php echo $a_view_data['comment']['pname']; ?></em>
                    </p>
                </dd>
                <dd class="storeComment">
                    <p>
                        <span>
                        <?php if (!empty($a_view_data['comment']['comment_tags'])) { ?>
                        <em>[<?php echo str_replace(',', '、', $a_view_data['comment']['comment_tags']); ?>]</em>
                        <?php } ?>
                        <?php echo $a_view_data['comment']['comment_content']; ?>
                        </span>
                    </p>
                </dd>
                <dd class="allComment">
                    <a href="store_comment-<?php echo $a_view_data['detail']['store_id']; ?>">
                        <span>查看全部评论</span>
                    </a>
                </dd>
                <?php } ?>
            </dl>
            <!-- 店铺评价 -->
            <!--  店铺信息 -->
            <dl class="storeInfo">
                <dt>店铺信息</dt>
                <dd class="address">
                    <img src="./static/style_default/images/ca_03.png" />
                    <a href="javascript:;" onclick="store_position()" class="storeAddr"><span><?php echo $a_view_data['detail']['store_address']; ?><img src="./static/style_default/images/shezhi_03.png" /></span></a>
                    <a href="<?php echo 'tel:'.$a_view_data['detail']['store_tel']; ?>" class="storePhone">
                    <img src="./static/style_default/images/ca_06.png" />
                    </a>
                </dd>
                <dd class="businessTime">
                    <img src="./static/style_default/images/ca_10.png" />
                    <span>营业时间:<?php echo $a_view_data['store_open_time']; ?></span>
                </dd>
            </dl>
            <!--  店铺信息 -->
            <!-- 店铺实景 -->
            <dl class="storeReal">
                <dt>店铺实景</dt>
                <?php if (!empty($a_view_data['detail']['store_mainimg'])) {
                    echo '<dd>';
                    echo '<img src="'.get_config_item('store_touxiang').$a_view_data['detail']['store_mainimg'].'" />';
                    echo '</dd>';
                } ?>
                <?php if (!empty($a_view_data['detail']['store_img'])) {
                    $store_img = explode(',', $a_view_data['detail']['store_img']);
                    for ($i=0; $i < count($store_img); $i++) {
                        if ($store_img[$i] != $a_view_data['detail']['store_mainimg'] ) {
                            echo '<dd>';
                            echo '<img src="'.get_config_item('store_touxiang').$store_img[$i].'" />';
                            echo '</dd>';
                        }
                    }
                } ?>
            </dl>
            <!-- 店铺实景 -->
            <!-- 营业资质 -->
            <dl class="businQualifi">
                <dt>营业资质</dt>
                <?php if (!empty($a_view_data['detail']['store_licence'])) {
                    $store_licence = explode(',', $a_view_data['detail']['store_licence']);
                    for ($i=0; $i < count($store_licence); $i++) {
                        echo '<dd>';
                        echo '<img src="'.get_config_item('wofei_admin').$store_licence[$i].'" />';
                        echo '</dd>';
                    }
                } ?>
            </dl>
            <!-- 营业资质 -->
        </div>

    </div>
    <!-- 店铺首页  -->

<!--遮罩层开始-->
        <div class="shade"></div>
        <!--遮罩层结束-->
        <!--分享弹框开始-->
        <div class="shareBomb">
            <p class="fenxiang">分享到</p>
            <ul class="clearfix">
                <li>
                    <a href="javascript:;" onclick="share_others()">
                        <div class="pic">
                            <img src="./static/style_default/images/fenxiang_03.png"/>
                        </div>
                        <p class="tit">微博</p>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" onclick="weix_peyo()">
                        <div class="pic">
                            <img src="./static/style_default/images/fenxiang_05.png"/>
                        </div>
                        <p class="tit">微信好友</p>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" onclick="weix_quan()">
                        <div class="pic">
                            <img src="./static/style_default/images/fenxiang_07.png"/>
                        </div>
                        <p class="tit">微信朋友圈</p>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" onclick="qq()">
                        <div class="pic">
                            <img src="./static/style_default/images/fenxiang_09.png"/>
                        </div>
                        <p class="tit">QQ好友</p>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" onclick="qq_konjian();">
                        <div class="pic">
                            <img src="./static/style_default/images/fenxiang_12.png"/>
                        </div>
                        <p class="tit">QQ空间</p>
                    </a>
                </li>
            </ul>
            <div class="cancel">
                <a href="javascript:;">取消</a>
            </div>
        </div>
        <!--分享弹框结束-->

        <!-- 图片容器  -->
        <div class="pictureContainer">

        </div>
        <!-- 图片容器  -->

        <!-- 遮罩 -->
    	<div class="lay"></div>

</body>
</html>


<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="http://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://qiduvdaolink.js"></script>
<?php } ?>

<script>
$(".lay").hide();
$(".pictureContainer").hide();
$(".lay").height( $(document).height() );
setDivCenter($(".pictureContainer"));

$(".storeReal>dd").click(function(){
	$(".lay").show();
	$(".pictureContainer").show();
	$(".pictureContainer").html($(this).html());
});
$(".businQualifi>dd").click(function(){
	$(".lay").show();
	$(".pictureContainer").show();
	$(".pictureContainer").html($(this).html());
});



$(".lay").click(function(){
	$(".lay").hide();
	$(".pictureContainer").hide();
});

 //让指定的DIV始终显示在屏幕正中间
function setDivCenter(divName){
    var top = ($(window).height() - divName.height())/3;
    var left = ($(window).width() - divName.width())/2;
    var scrollTop = $(document).scrollTop();
    divName.css( { 'top' : top + scrollTop } );
}

var u = navigator.userAgent;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

// 回退到APP店铺列表
function goback_app() {
    if (isAndroid) {
        webGoBackPagePress();
    } else if (isiOS) {
        window.webkit.messageHandlers.vdao.postMessage({
            body:'',
            callback:'',
            command:'webGoBackPagePress'
        });
    } else {
        window.location.href = "index";
    }
}

// 打开店铺位置
function store_position() {
    var latitude = "<?php echo $a_view_data['detail']['store_latitude']; ?>";
    var longitude = "<?php echo $a_view_data['detail']['store_longitude']; ?>";
    var json = {"latitude":latitude,"longitude":longitude};
    if (isAndroid) {
        openStoreLocation(json);
    } else if (isiOS) {
        json = JSON.stringify(json);
        window.webkit.messageHandlers.vdao.postMessage({
            body    : json,
            callback: '',
            command : 'openStoreLocation'
        });
    }
}

// 分享的链接
var shareContent = "<?php echo $this->router->get_url(); ?>";
// 分享的标题
var title = "<?php echo $a_view_data['detail']['store_name']; ?>";
// 分享的描述
var content = "<?php echo $a_view_data['detail']['store_introduction']; ?>";

function share_others() {
    if (isiOS) {
        location.href = 'protocolHead://Sina_?124';
    };
}

// 微信好友
function weix_peyo() {
    var json = {
        "whatTypeShare" : "wx",
        "whoToShare"    : "talk",
        "shareType"     : "url",
        "shareContent"  : shareContent,
        "title"         : title,
        "content"       : content
    }
    if (isiOS){
        json = JSON.stringify(json);
        window.webkit.messageHandlers.vdao.postMessage({
            body    : json,
            callback: '',
            command : 'shareToThirdApp'
        });
    } else if (isAndroid) {
        shareToThirdApp(json);
    }
}

// 微信朋友圈
function weix_quan() {
    var json = {
        "whatTypeShare" : "wx",
        "whoToShare"    : "friends",
        "shareType"     : "url",
        "shareContent"  : shareContent,
        "title"         : title,
        "content"       : content
    }
    if (isiOS) {
        json = JSON.stringify(json);
        window.webkit.messageHandlers.vdao.postMessage({
            body    : json,
            callback: '',
            command : 'shareToThirdApp'
        });
    } else if (isAndroid) {
        shareToThirdApp(json);
    };
}

// QQ
function qq() {
    if (isiOS) {
        location.href = 'protocolHead://WHCQQ_?124';
    };
}

// QQ空间
function qq_konjian() {
    if (isiOS) {
        location.href = 'protocolHead://Qzone_?124';
    };
}

</script>

