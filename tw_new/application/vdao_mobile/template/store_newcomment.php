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
    <link rel="stylesheet" href="./static/style_default/style/storePage.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/flexible.js"></script>
    <!-- <script src="./static/style_default/script/storePage.js"></script> -->
    <title>门店详情</title>
</head>
<body>
    <!-- 头部 -->
    <div class="head">
        <p class="pjoTitle">
            <a href="javascript:;" onclick="goback_app()"><img src="static/style_default/images/gouxiang_18.png" /></a>
            <em>
            	<a href="index"><img src="./static/style_default/images/homeHref.png" alt="" /></a>
                <a class="release share" ><img src="static/style_default/images/sIn_06.png" /></a>
                <a class="collection <?php if ($a_view_data['collection'] == 1) { echo 'coll'; } ?>">
                <?php if ($a_view_data['collection'] == 2) {
                    echo '<img src="./static/style_default/images/sd3.png" />';
                } else {
                    echo '<img src="./static/style_default/images/coll_03.png" />';
                } ?>
                </a>
            </em>
        </p>
        <div class="storeBox">
            <i>
            <?php if (empty($a_view_data['detail']['store_touxiang'])) {
                echo '<img src="./static/style_default/images/tou_03.png" />';
            } else {
                echo '<img src="'.$a_view_data['detail']['store_touxiang'].'" />';
            } ?>
            </i>
            <dl>
                <dt><?php echo $a_view_data['detail']['store_name']; ?></dt>
                <dd>
                    <span>总评:</span><em><?php echo $a_view_data['all_score']; ?></em>&nbsp;
                    <span>服务:</span><em><?php echo $a_view_data['service_score']; ?></em>&nbsp;
                    <span>质量:</span><em><?php echo $a_view_data['goods_score']; ?></em>&nbsp;
                </dd>
                <dd>
                    <span>营业时间:</span>
                    <em><?php echo $a_view_data['store_open_time']; ?></em>
                </dd>
            </dl>
        </div>
        <a href="office_showlist-1-<?php echo $a_view_data['detail']['store_id']; ?>" class="meet"><img src="static/style_default/images/huyu_03.png" /></a>
    </div>
    <!-- 头部 -->
    <!-- 内容主体 -->
    <div class="storeContainer">
        <div class="navbar">
            <a href="list_store-<?php echo $a_view_data['detail']['store_id']; ?>">点餐</a>
            <a class="navCur">评价</a>
            <a href="store_newdetail-<?php echo $a_view_data['detail']['store_id']; ?>">商家</a>
            <span><a href="office_showlist-2-<?php echo $a_view_data['detail']['store_id']; ?>" class="seat">就餐订座</a></span>
        </div>
        <!-- 评价 -->
        <div class="evaluateContent">
            <!--商家评分开始-->
            <div class="sellerScore">
                <div class="sLeft">
                    <p class="shu"><?php echo $a_view_data['all_score']; ?></p>
                    <p class="shang">商家评分</p>
                </div>
                <div class="sRight">
                    <p class="manner manner1">
                        <span class="taidu">服务态度</span>
                        <span class="xing">
                            <?php for ($i=0; $i < round($a_view_data['service_score']); $i++) {
                                echo '<i></i>';
                            } ?>
                            <?php for ($i=0; $i < 5-round($a_view_data['service_score']); $i++) {
                                echo '<i class="halfStar"></i>';
                            } ?>
                        </span>
                        <span class="fen"><?php echo $a_view_data['service_score']; ?></span>
                    </p>
                    <p class="manner quality">
                        <span class="taidu">服务质量</span>
                        <span class="xing">
                            <?php for ($i=0; $i < round($a_view_data['goods_score']); $i++) {
                                echo '<i></i>';
                            } ?>
                            <?php for ($i=0; $i < 5-round($a_view_data['goods_score']); $i++) {
                                echo '<i class="halfStar"></i>';
                            } ?>
                        </span>
                        <span class="fen"><?php echo $a_view_data['goods_score']; ?></span>
                    </p>
                </div>
            </div>
            <!--商家评分结束-->
            <!--商家评分结束-->
            <div class="tagBox">
                <!--导航开始-->
                <div class="nav">
                    <a class="cafe <?php if ($a_view_data['comment_type'] == 2) { echo 'current'; } ?>" href="store_newcomment-<?php echo $a_view_data['store_id'].'-2'; ?>">产品评价</a>
                    <a class="office <?php if ($a_view_data['comment_type'] == 1) { echo 'current'; } ?>" href="store_newcomment-<?php echo $a_view_data['store_id'].'-1'; ?>">办公室评价</a>
                </div>
                <!--导航结束-->
                <ul>
                    <li <?php if ($a_view_data['thistag'] == 'all') { echo 'class="allClick"'; } ?>><a href="store_newcomment-<?php echo $a_view_data['store_id'].'-'.$a_view_data['comment_type']; ?>">全部</a></li>
                    <?php foreach ($a_view_data['comtag'] as $key => $value): ?>
                    <li <?php if ($a_view_data['thistag'] == $value['comtag_name']) { echo 'class="otherClick"'; } ?>><a href="store_newcomment-<?php echo $a_view_data['store_id'].'-'.$a_view_data['comment_type'].'-'.$value['comtag_name']; ?>"><?php echo $value['comtag_name']; ?>(<i><?php echo $value['comment_count']; ?></i>)</a></li>
                    <?php endforeach ?>
                </ul>
            </div>
            <div class="appList">
                <ul class="clearfix">
                    <?php foreach ($a_view_data['comment'] as $key => $value): ?>
                    <li>
                        <div class="picL">
                            <?php if (empty($value['user_pic'])) {
                                echo '<img src="./static/style_default/images/tou_03.png"/>';
                            } else {
                                echo '<img src="'.$value['user_pic'].'"/>';
                            } ?>
                        </div>
                        <div class="describeR">
                            <p class="name">
                                <span class="ming"><?php echo $value['user_name']; ?></span>
                                <span class="shijian"><?php echo date('m-d', $value['comment_time']); ?></span>
                            </p>
                            <p class="product">产品：<?php echo $value['proname']; ?></p>
                            <p class="discuss">
                            <i class="red">
                            <?php if (!empty($value['comment_tags'])) {
                                echo '[' . str_replace(',','、', $value['comment_tags']) . ']';
                            } ?>
                            </i>
                            <?php echo $value['comment_content']; ?>
                            </p>
                            <div class="imgBox">
                                <?php if (!empty($value['comment_pic'])) {
                                    $comment_pics = explode(',', $value['comment_pic']);
                                    for ($i=0; $i < count($comment_pics); $i++) {
                                        echo '<img src="'.$comment_pics[$i].'"/>';
                                    }
                                } ?>
                            </div>
                        </div>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
        <!-- 评价 -->
    </div>
    <!-- 内容主体 -->

    <!--遮罩层开始-->
    <div class="shade"></div>
    <!--遮罩层结束-->
    <!--分享弹框开始-->
    <div class="shareBomb">
        <p class="fenxiang">分享到</p>
        <ul class="clearfix">
            <li style="display:none;">
                <a href="javascript:;" onclick="share_others()">
                    <div class="pic">
                        <img src="static/style_default/images/fenxiang_03.png"/>
                    </div>
                    <p class="tit">微博</p>
                </a>
            </li>
            <li>
                <a href="javascript:;" onclick="weix_peyo()">
                    <div class="pic">
                        <img src="static/style_default/images/fenxiang_05.png"/>
                    </div>
                    <p class="tit">微信好友</p>
                </a>
            </li>
            <li>
                <a href="javascript:;" onclick="weix_quan()">
                    <div class="pic">
                        <img src="static/style_default/images/fenxiang_07.png"/>
                    </div>
                    <p class="tit">微信朋友圈</p>
                </a>
            </li>
            <li style="display:none;">
                <a href="javascript:;" onclick="qq()">
                    <div class="pic">
                        <img src="static/style_default/images/fenxiang_09.png"/>
                    </div>
                    <p class="tit">QQ好友</p>
                </a>
            </li>
            <li style="display:none;">
                <a href="javascript:;" onclick="qq_konjian();">
                    <div class="pic">
                        <img src="static/style_default/images/fenxiang_12.png"/>
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
</body>

</html>


<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>


<script>

$(function(){
    $(".collection").click(function(){
        if( $(this).hasClass("coll") ){
            $(this).removeClass("coll");
            $(this).children("img").attr("src","./static/style_default/images/sd3.png");
        } else {
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
// 门店头像
var store_touxiang = "<?php echo $a_view_data['detail']['store_touxiang']; ?>";

// 微信好友
function weix_peyo() {
    var json = {
        "whatTypeShare" : "wx",
        "whoToShare"    : "talk",
        "shareType"     : "url",
        "shareContent"  : shareContent,
        "title"         : title,
        "content"       : content,
        "imgurl"        : store_touxiang,
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


</script>