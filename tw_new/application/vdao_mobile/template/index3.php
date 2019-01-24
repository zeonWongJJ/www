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
    <link rel="stylesheet" href="static/style_default/style/newIndexB.css"/>
    <link rel="stylesheet" href="static/style_default/style/swiper.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/plugin/swiper.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <title>首页</title>
</head>

<body>

    <div class="index">
        <!-- 天气 -->
        <div class="weather" style="">
            <!-- <a class="weather_content"><?php //echo $a_view_data['weather']['city'].'&nbsp;&nbsp;'. $a_view_data['weather']['temperature'].'℃&nbsp;&nbsp;'.$a_view_data['weather']['weather']; ?></a> -->
            <a class="weather_content"></a>
        </div>
        <!-- 天气 -->
        <!-- 定位 -->
        <div class="location">
            <a class="store">V稻</a>
            <a class="city"><?php echo $a_view_data['weather']['city']; ?></a>
            <a class="message" href="user_moodmsg">
                <img src="static/style_default/images/commentsj.png" />
                <?php if (!empty($a_view_data['moodmsg'])) {
                    echo "<i></i>";
                } ?>
            </a>
        </div>
        <!-- 定位 -->
        <!-- 产品搜索 -->
        <div class="productSearch">
            <input id="product_search" type="text" placeholder="搜索产品"/>
        </div>
        <!-- 产品搜索 -->
        <!-- 广告轮播 -->
        <div class="carousel">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($a_view_data['ad'] as $key => $value): ?>
                    <div class="swiper-slide"><a href="<?php echo $value['ad_link']; ?>"><img src="<?php echo $value['ad_pic']; ?>" /></a></div>
                    <?php endforeach ?>
                </div>
                <!-- 如果需要分页器 -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <!-- 广告轮播 -->
        <!-- 消息通知 -->
        <div class="notice">
            <a href="notice_detail-<?php echo $a_view_data['notice']['notice_id']; ?>">
                <img src="static/style_default/images/tips.png" />
                <marquee scrollAmount=1 width=300 direction="up">
                <?php echo $a_view_data['notice']['notice_title']; ?>
                </marquee>
                <!--<span>好意融融咖啡香，v啡和你一起过星年！</span>-->
            </a>
        </div>
        <!-- 消息通知 -->
        <!-- 选择服务 -->
        <div class="service">
            <a onclick="store_showlist()" class="shareZone">
                <img src="static/style_default/images/hhg_03.png" />
                <em>
                    <h1>共享空间</h1>
                    <span>新一代办公模式</span>
                </em>
            </a>
            <a onclick="store_showlist()" class="seat">
                <img src="static/style_default/images/hhg_05.png" />
                <em>
                    <h1>就餐订座</h1>
                    <span>线上排队、线下就餐</span>
                </em>
            </a>
        </div>
        <!-- 选择服务 -->
        <div id="debug"></div>
        <!-- 动态 -->
        <div class="dynamic">
            <form action="mood_add" method="post">
                <span>动态</span>
                <input type="text" name="mood_content" placeholder="发布动态，一起聊八卦" id="dynamic"/>
                <button type="submit"></button>
            </form>
        </div>
        <!-- 动态 -->
        <!--  热门推荐 -->
        <div class="recommend">
            <p>
                <span>热门推荐</span>
                <a href="product_category" class="recmore">
                    <span>更多</span>
                    <img src="static/style_default/images/shezhi_03.png" />
                </a>
            </p>
            <div class="typeSeq">
                <div class="seqBox">
                    <?php $i=0; foreach ($a_view_data['time'] as $key => $value): ?>
                        <a <?php if ($i==0) { echo 'class="typeCur"'; } ?> value="<?php echo $value['time_id']; ?>"><?php echo $value['time_nema']; ?></a>
                    <?php $i++; endforeach ?>
                </div>
                <!--<span class="sanjiao"></span>-->
            </div>
            <div class="productContainer">
                <div class="swA showCur">
                    <div class="swiper-wrapper" id="hot_rec">
                        <?php $i=1; foreach ($a_view_data['product'] as $key => $value): ?>
                        <?php if ($i<6) { ?>
                        <div class="swiper-slide">
                            <a href="<?php echo $value['gourl']; ?>" class="productList">
                                <dl class="productContent">
                                    <dt class="noA">
                                        <?php if (!empty($value['pro_img'])) {
                                            echo '<img  src="'.$value['pro_img'].'">';
                                        } ?>
                                        <?php if ($i<4) { ?>
                                        <span>热门NO.<?php echo $i; ?></span>
                                        <?php } ?>
                                    </dt>
                                    <dd><?php echo $value['product_name']; ?></dd>
                                    <dd>
                                        <span><?php echo $value['number']; ?></span>
                                        <em>人品尝过</em>
                                    </dd>
                                    <dd>
                                    <?php
                                        $subject = strip_tags($value['pro_details']); //去除html标签
                                        $pattern = '/\s/'; //去除空白
                                        $content = preg_replace($pattern, '', $subject);
                                        $seodata = mb_substr($content, 0, 18); //截取100个汉字
                                        echo $seodata;
                                    ?>
                                    </dd>
                                </dl>
                            </a>
                        </div>
                        <?php } ?>
                        <?php $i++; endforeach ?>
                    </div>
                </div>
            </div>
        </div>
        <!--  热门推荐 -->
        <!-- 热门动态 -->
        <div class="hotDyn">
            <dl>
                <dt>
                    <span>热门动态</span>
                    <a href="mood_showlist" class="Dynmore">
                        <span>更多</span>
                        <img src="static/style_default/images/shezhi_03.png" />
                    </a>
                </dt>
                <?php foreach ($a_view_data['mood'] as $key => $value): ?>
                <dd>
                    <a href="mood_detail-<?php echo $value['mood_id']; ?>">
                        <i>
                        <?php if (!empty($value['mood_pic'])) {
                            $mood_pics = explode('&', $value['mood_pic']);
                            echo '<img src="'.$mood_pics[0].'">';
                        } else {
                            echo '<img src="static/style_default/images/500129376.png" />';
                        } ?>
                        </i>
                        <div class="detail">
                            <p><?php echo substr($value['mood_content'], 0, 63); ?>...</p>
                            <em>
                                <?php if (!empty($value['user_pic'])) {
                                    echo '<img src="'.$value['user_pic'].'">';
                                } else {
                                    echo '<img src="'.$value['user_pic'].'">';
                                } ?>
                                <span><?php echo $value['user_name']; ?></span>
                                <dfn><?php echo date('m-d', $value['mood_time']); ?></dfn>
                            </em>
                            <div class="iconBox">
                                <em>
                                    <img src="static/style_default/images/ssdf.png" />
                                    <span><?php echo $value['mood_discuss']; ?></span>
                                </em>
                                <em>
                                    <img src="static/style_default/images/goodss.png" />
                                    <span><?php echo $value['mood_good']; ?></span>
                                </em>
                                <em>
                                    <img src="static/style_default/images/zhuan.png" />
                                    <span><?php echo $value['mood_relay']; ?></span>
                                </em>
                            </div>
                        </div>
                    </a>
                </dd>
                <?php endforeach ?>
            </dl>
        </div>
        <!-- 热门动态 -->
    </div>

    <!-- 底部导航 -->
    <?php echo $this->display('bottom'); ?>
    <!-- 底部导航 -->
    <script>
        var mySwiper = new Swiper ('.carousel .swiper-container', {
            autoplay: 3000,
            loop: true,
            // 如果需要分页器
            pagination: '.swiper-pagination'
        });
        var productA= new Swiper ('.swA', {
            slidesOffsetBefore : 15,
            slidesOffsetAfter : 70,
            slidesPerView : 3
        });
        var productB= new Swiper ('.swB', {
            slidesOffsetBefore : 15,
            slidesOffsetAfter : 100,
            slidesPerView : 3
        });
        var productC= new Swiper ('.swC', {
            slidesOffsetBefore : 15,
            slidesPerView : 3
        });
        var productD= new Swiper ('.swD', {
            slidesOffsetBefore : 15,
            slidesPerView : 3
        });

        //底部导航
        $(".botNav>a").click(function(){
            $(this).addClass("pgCur");
            $(".botNav>a").not($(this)).removeClass("pgCur");
        });
        // 热们推荐
        $(".seqBox>a").click(function(){
            $(this).addClass("typeCur");
            $(".seqBox>a").not($(this)).removeClass("typeCur");
            // $(".sanjiao").animate({left:"2rem"},100);
            // 三角型移动
            if( $(this).index()==0 ){
                $(".sanjiao").animate({left:"0.3rem"},300);
            }else if( $(this).index()==1 ){
                $(".sanjiao").animate({left:"2rem"},300);
            }else if( $(this).index()==2 ){
                $(".sanjiao").animate({left:"3.8rem"},300);
            }else if( $(this).index()==3 ){
                $(".sanjiao").animate({left:"5.6rem"},300);
            }

            // ajax替换内容
            var time_id = $(this).attr('value');
            // 请求数据
            $.ajax({
                url: 'hot_recommend',
                type: 'POST',
                dataType: 'json',
                data: {time_id: time_id},
                success: function (res) {
                    console.log(res);
                    if (res.code == 200) {
                        $("#hot_rec").html('');
                        var append_content = '';
                        var i = 1;
                        $.each(res.data, function(index, el) {
                            if (i<6) {
                                append_content += '<div class="swiper-slide">';
                                append_content += '<a href="'+el.gourl+'" class="productList">';
                                append_content += '<dl class="productContent">';
                                append_content += '<dt class="noA">';
                                if (el.pro_img != '') {
                                    append_content += '<img src="'+el.pro_img+'">';
                                }
                                if (i<4) {
                                    append_content += '<span>热门NO.'+i+'</span>';
                                }
                                append_content += '</dt>';
                                append_content += '<dd>'+el.product_name+'</dd>';
                                append_content += '<dd>';
                                append_content += '<span>'+el.number+'</span>';
                                append_content += '<em>人品尝过</em>';
                                append_content += '</dd>';
                                append_content += '<dd>'+el.pro_details+'</dd>';
                                append_content += '</dl>';
                                append_content += '</a>';
                                append_content += '</div>';
                                i++;
                            }
                        });
                        $("#hot_rec").append(append_content);
                    } else {
                        $("#hot_rec").html('');
                    }
                }
            })

        })

    </script>
</body>
</html>

<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>

<script>

$(function(){
    initTitleBarLayoutIsVisible();
    // 执行定位
    current_location();
    document.onkeyup = function (e) { //按键信息对象以函数参数的形式传递进来了，就是那个e
        var code = e.charCode || e.keyCode;  //取出按键信息中的按键代码(大部分浏览器通过keyCode属性获取按键代码，但少部分浏览器使用的却是charCode)
        if (code == 13) {
            //此处编写用户敲回车后的代码
            window.location.href='product_list-0-0-0-0-'+$('#product_search').val();
        }
    }

    $('#product_search').click(function() {
        var name = $(this).attr('value');
        // if (name != '') {
            window.location.href='product_list-0-0-0-0-'+name;
        // }
    })

    var winHeight = $(window).height(); //获取当前页面高度
          $(window).resize(function() {
              var thisHeight = $(this).height();
              if (winHeight - thisHeight > 50) {
                  //当软键盘弹出，在这里面操作
                  //alert('aaa');
                  $('body').css('height', winHeight + 'px');
              } else {
                  //alert('bbb');
                  //当软键盘收起，在此处操作
                  $('body').css('height', '100%');
              }
    });
    /*$('input').on('click', function () {
        var target = this;
        // 使用定时器是为了让输入框上滑时更加自然
        setTimeout(function(){
          target.scrollIntoView(true);
        },100);
    });*/
    // choose_user();
});

function initTitleBarLayoutIsVisible() {
    //原生那边标题栏 0显示 1不显示
    if (isAndroid) {
        var obj={"isShowTitle":1}
        titleBarLayoutIsVisible(obj);
    } else if (isiOS) {
        var obj={"isShowTitle":1}
        window.webkit.messageHandlers.vdao.postMessage({
            body: obj,
            callback: '',
            command:'titleBarLayoutIsVisible'
        });
    }
}
var u = navigator.userAgent;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

// 门店列表
function store_showlist() {
    if (isAndroid) {
        openNearStoreList();
    } else if (isiOS) {
        window.webkit.messageHandlers.vdao.postMessage({
            body: '',
            callback: '',
            command:'openNearStoreList'
        });
    }
}


// 当前定位
function current_location() {
    if (isAndroid || isiOS) {
        var callbackSuccess=function(response){
            var myjson = JSON.parse(response);
            $('.city').html(myjson.cityName);
            $.ajax({
                url: 'get_weather',
                type: 'POST',
                dataType: 'json',
                data: {adcode: myjson.adCode},
                success: function(res) {
                    if (res.code == 200) {
                        $('.weather_content').html(myjson.cityName+'&nbsp;&nbsp;'+res.data.temperature+'℃&nbsp;&nbsp;'+res.data.weather);
                    }
                }
            })
        }
    }
    if (isAndroid) {
        var callbackError=function(error){
            $('.current_location').html('定位失败');
        }
        locationCurrentPosition(callbackSuccess,callbackError);
    } else if (isiOS) {
        window.webkit.messageHandlers.vdao.postMessage({body: '', callback: callbackSuccess+'',command:'locationCurrentPosition'});
    }
}


// //获取列表
// function choose_user() {
//     if (isAndroid || isiOS) {
//         //获取账号列表  
//         var callbackSuccess = function(userArray){
//             var myuserArray = JSON.parse(userArray);
//             AutoLogin(myuserArray[0].user_name, myuserArray[0].user_password);
         
//         }
//     }
//     if (isAndroid) {
//         takeLocalUserList(callbackSuccess);
//     } else if (isiOS) {
//         window.webkit.messageHandlers.vdao.postMessage({
//             body: '',
//             callback: callbackSuccess+'',
//             command:'takeLocalUserList'
//         });
//     }
// }

// function  AutoLogin(user_name,user_password){
//         // alert(111);
//         var user_name = user_name;
//         var user_password = user_password;
//             if(user_name != ""&& user_password !="" ) {
//                 $.post(
//                     'loginup',
//                     'name_or_tel='+user_name+"&user_password="+user_password,
//                 );
//             }
//             return false;
        
// }

</script>