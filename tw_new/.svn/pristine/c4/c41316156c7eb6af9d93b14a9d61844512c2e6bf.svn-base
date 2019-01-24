<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <title>动态</title>
    <link rel="stylesheet" type="text/css" href="static/style_default/style/common.css"/>
    <script src="static/style_default/plugin/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="static/style_default/plugin/rem.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
        .body {
            position: relative;
            height: 100%;
            font-size: 0.14rem;
            overflow: hidden;
            
        }
		
        .box {
            background: #f7f7f7;
            position: absolute;
            top: .88rem;
            left: 0;
            right: 0;
            bottom: 0;
            height: calc(100% - 1.5rem);
            overflow: auto;
        }

        .header {
            position: absolute;
            height: .88rem;
            width: 100%;
        }

        .head {
            height: 0.44rem;
            display: flex;
            justify-content: space-between;
            padding: 0 .15rem;
            font-size: .18rem;
            background: #fff;
        }

        .head div {
            line-height: .44rem;
            color: #000000;
        }

        .head .photo {
            flex: 0 0 .25rem;
            background: url(static/style_default/images/photo.png) no-repeat;
            background-size: .205rem .18rem;
            background-position: center;
        }

        .head .person {
            flex: 0 0 .25rem;
            background: url(static/style_default/images/person.png) no-repeat;
            background-size: .19rem .22rem;
            background-position: center;
        }

        .nav {
            height: 0.44rem;
            display: flex;
            justify-content: space-between;
            padding: 0 .15rem;
            font-size: .16rem;
            background: #fff;
            align-items: center;
            border-bottom: 1px solid #efefef;
        }

        .nav .navItem {
            line-height: .44rem;
            padding: 0 .2rem;
        }

        .nav .navItem.check {
            color: #ff6633;
        }

        .view {
            padding: .15rem .2rem;
        }

        .view .item {
            padding: .1rem;
            background: #fff;
            border-radius: .05rem;
            margin-bottom: .1rem;
            box-shadow: 0 0 .1rem rgba(0, 0, 0, .11);
        }

        .view .item .row {
            display: flex;
            font-size: .12rem;
            align-items: center;
            justify-content: space-between;
        }

        .view .item .row .left {
            display: flex;
            align-items: center;
        }

        .view .item .row .left .img {
            height: .4rem;
            width: .4rem;
            border-radius: 50%;
            overflow: hidden;
            margin-right: .1rem;
        }

        .view .item .row .left .img > img {
            width: 100%;
            height: 100%;
        }

        .view .item .row .talk {
            padding: .05rem .1rem;
            border: 1px solid #ff6633;
            color: #ff6633;
            border-radius: .05rem;
            display: none;
        }

        .view .item .info {
            padding: .05rem 0;
        }

        .view .item .info .imgBox {
            overflow-x: auto;
            display: flex;
        }

        .view .item .info > p {
            margin-bottom: .1rem;
        }

        .view .item .info .imgBox > img {
            flex-shrink: 0;
            margin: 0 .1rem .1rem 0;
            width: .95rem;
            height: .95rem;
        }

        .view .item .button {
            display: flex;
            width: 100%;
            flex-direction: row-reverse;
            height: .3rem;
        }

        .view .item .button .btnBox {
            display: flex;
            background: #32aaff;
            border-radius: .15rem;
            padding: .1rem;
            color: #FFFFFF;
        }

        .view .item .button .btnBox .btn {
            display: flex;
            flex: 1;
            align-items: center;
            padding: 0 .1rem;
        }

        .view .item .button .btnBox .btn > .logo {
            width: .2rem;
            height: .2rem;
            background-position: center;
            margin-right: .05rem;
        }

        .btn-nice > .logo {
            background: url(static/style_default/images/nice.png) no-repeat;
            background-size: .21rem .18rem;
        }

        .btn-comments > .logo {
            background: url(static/style_default/images/comments_2.png) no-repeat;
            background-size: .21rem .2rem;
        }

        .btn-exit > .logo {
            background: url(static/style_default/images/exit.png) no-repeat;
            background-size: .2rem .16rem;
        }

        .c_gray {
            color: #666666;
        }
        .footer {
            position:absolute;
            width: 100%;
            bottom: 0;
            font-size: 0;
            border-top: 0.01rem solid #ddd;
            z-index: 90;
            background: white;
        }

        .footer>a {
            position: relative;
            width: 20%;
            display: inline-block;
            padding: 0.05rem 0;
            background: white;
            text-align: center;
        }

        .footer>a>img {
            width: 0.24rem;
        }

        .footer>a>span {
            font-size: 0.12rem;
            display: block;
            margin-top: 0.05rem;
        }
        .cartImg {
				width: 0.34rem;
				height: 0.4rem;
				line-height: 0.38rem;
				position: absolute;
				visibility: hidden;
				display: inline-block;
				text-align: center;
				font-size: 0.18rem;
				font-style: normal;
				color: white;
				top: -0.32rem;
				left: 0.18rem;
				background-image: url(./static/style_default/images/tuoooo.png);
				background-repeat: no-repeat;
				background-size: 100% 100%;
		}
		.wrapper2{
 				position:absolute;
  				top:0;
  				bottom:0;
  				left:0;
  				right:0; 
  				overflow-y:auto;
  				-webkit-overflow-scrolling : touch; 
		}
    </style>
</head>

<body>
<div class="wrapper">
<div class="body">
    <div class="header">
        <div class="head">
            <div class="photo" onclick="go_link('mood_add')"></div>
            <div>动态</div>
            <a class="person" href="user_mood"></a>
        </div>
        <div class="nav">
            <!--标签-->
            <div class="navItem check" id="0">全部</div>
            <?php foreach ($a_view_data['tag'] as $key => $value): ?>
                <div class="navItem" id="<?php echo $value['tag_id']; ?>"><?php echo $value['tag_name']; ?></div>
            <?php endforeach ?>
            <!--            <div class="navItem" id="1">888</div>-->
            <!--            <div class="navItem" id="2">999</div>-->
            <!--标签end-->
        </div>
    </div>
    <div class="box">
        <div class="view">

            <!--动态-->
            <?php foreach ($a_view_data['mood'] as $key => $value): ?>
            <div class="item" data-id="1">
                <div class="row">
                    <div class="left">
                        <div class="img">
                            <?php if (empty($value['user_pic'])) {
                                echo '<img src="static/style_default/images/tou_03.png" alt="">';
                            } else {
                                echo '<img src="'.$value['user_pic'].'">';
                            } ?>
                        </div>
                        <div>
                            <p class="c_gray"><?php echo $value['user_name']; ?></p>
                            <p class="c_gray"><?php echo $value['mood_time']; ?></p>
                        </div>
                    </div>
                    <div class="talk">聊天</div>
                </div>
                <div class="info c_gray">
                    <p><?php echo $value['mood_content']; ?></p>
                    <?php if (!empty($value['mood_pic'])) { ?>
                    <div class="imgBox">
                        <?php $mood_pics = explode('&', $value['mood_pic']); ?>
                        <?php for ($i=0; $i<count($mood_pics); $i++) { ?>
                        <img src="<?php echo $mood_pics[$i]; ?>">
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
                <div class="button">
                    <div class="btnBox">
                        <div class="btn btn-nice" onclick="mood_like(<?php echo $value['mood_id']; ?>)">
                            <div class="logo"></div>
                            <div class="num" id="moodlike_<?php echo $value['mood_id']; ?>"><?php echo $value['mood_good']; ?></div>
                        </div>
                        <div class="btn btn-comments" onclick="go_link('mood_detail-<?php echo $value['mood_id']; ?>')">
                            <div class="logo"></div>
                            <div class="num"><?php echo $value['mood_discuss']; ?></div>
                        </div>
                        <div class="btn btn-exit" onclick="go_link('mood_relay-<?php echo $value['mood_id']; ?>')">
                            <div class="logo"></div>
                            <div class="num"><?php echo $value['mood_relay']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
            <!--动态end-->
        </div>
    </div>
</div>
<div class="footer">
    <a href="index">
        <img src="./static/style_default/images/nav1.png" alt="" />
        <span>首页</span>
    </a>
    <a href="n_goods_list">
        <img src="./static/style_default/images/nav2.png" alt="" />
        <span>产品</span>
    </a>
    <a href="javascript:;">
        <img src="./static/style_default/images/bn3.png" alt="" />
        <span style="color:#ff6633">动态</span>
    </a>
    <a href="shopping" class="shopCart">
        <img src="./static/style_default/images/nav4.png" alt="" />
        <span>购物车</span>
        <i class="cartImg">5</i>
    </a>
    <a href="nuser_center">
        <img src="./static/style_default/images/nav5.png" alt="" />
        <span>会员</span>
    </a>
</div>
</div>
</body>

</html>
<script type="text/javascript">
    // 获取更多动态
    var page = 1;
    var stop = true;
    var recode = 200;
    var tag_id = "<?php echo $a_view_data['thistag']; ?>";
    // 当滚动条滚到底时加载更多
    $(window).scroll(function () {
        totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
        if ($(document).height() <= totalheight) {
            if (stop == true) {
                mood_more();
            }
            if (recode == 400) {
                stop = false;
            }
        }
    });

    function go_link(url) {
        window.location.href = url;
    }

    function mood_more() {
        page++;
        $.ajax({
            url: 'mood_more',
            type: 'POST',
            dataType: 'json',
            data: {page: page, tag_id: tag_id},
            success: function (res) {
                recode = res.code;
                if (res.code == 200) {
                    var append_content = '';
                    $.each(res.data, function (index, el) {
                    })
                }
            }
        })
    }

    // 动态点赞
    function mood_like(mood_id) {
        $.ajax({
            url: 'mood_like',
            type: 'POST',
            dataType: 'json',
            data: {mood_id: mood_id},
            success: function(res) {
                console.log(res);
                if (res.code == 200) {
                    $('#moodlike_'+mood_id).html(res.data);
                }
            }
        })
    }

    function return_link(perfix, id)
    {
        var url = '"' + perfix + '-' + id + '"';
        return "onclick='go_link("+url+")'";
    }

    /**
     * 获取指定标签id的数据条目
     * @param tag_id
     */
    function get_item(tag_id) {
        page = 0;
        $('.view').find('.item[data-id=' + tag_id + ']').remove(); // 插入之前先删除
        $.ajax({
            url: 'mood_showlist-' + tag_id,
            type: 'POST',
            dataType: 'json',
            data: {page: page, tag_id: tag_id},
            success: function (res) {
                recode = res.code;
                var append_content = '';
                $.each(res.data, function (index, el) {
                    append_content += '<div class="item" data-id="'+tag_id+'">' +
                        '<div class="row">' +
                        '<div class="left">' +
                        '<div class="img">' +
                        '<img src="'+el.user_pic+'" alt="">' +
                        '</div>' +
                        '<div>' +
                        '<p class="c_gray">' + el.user_name + '</p>' +
                        '<p class="c_gray">' + el.mood_time + '</p>' +
                        '</div>' +
                        '</div>' +
                        '<div class="talk">聊天</div>' +
                        '</div>' +
                        '<div class="info c_gray">' +
                        '<p>' + el.mood_content + '</p>';
                    if (el.mood_pic != '') {
                        append_content += '<div class="imgBox">';
                        var mood_pics = el.mood_pic.split('&');
                        for (var i = 0; i < mood_pics.length; i++) {
                            append_content += '<img src="' + mood_pics[i] + '">';
                        }
                        append_content += '</div>';
                    }

                    append_content += '</div>' +
                        '<div class="button">' +
                        '<div class="btnBox">' +
                        '<div class="btn btn-nice" onclick="mood_like('+el.mood_id+')">' +
                        '<div class="logo"></div>' +
                        '<div class="num" id="moodlike_'+el.mood_id+'">' + el.mood_good + '</div>' +
                        '</div>' +
                        '<div class="btn btn-comments" '+return_link('mood_detail', el.mood_id)+'>' +
                        '<div class="logo"></div>' +
                        '<div class="num">' + el.mood_discuss + '</div>' +
                        '</div>' +
                        '<div class="btn btn-exit" '+return_link('mood_relay', el.mood_id)+'>' +
                        '<div class="logo"></div>' +
                        '<div class="num">' + el.mood_relay + '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                });
                $('.view').append(append_content)
            }
        });
    }

    $(function () {
        $('.nav').on('click', '.navItem', function () {
            var check = $(this).is('.check');
            if (!check) {
                var id = $(this).attr('id');
                $(this).addClass('check').siblings().removeClass('check');
                $('.view').find('.item').hide();
                if (id == '0') {
                    $('.view').find('.item').show();
                } else {
                    // show节点前进行ajax请求数据
                    get_item(id);
                    $('.view').find('.item[data-id=' + id + ']').show();
                }

            }
        })
    })
</script>

  <?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
    <?php } ?>
    <script type="text/javascript">
        var u = navigator.userAgent;
        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
            if (isAndroid) {
               var obj={"isArrowFinish":true}
                isArrowWindowFinish(obj);
            } else if (isiOS) {
               
            }  
        
    </script>
    <script>
	var ScrollFix = function(elem) {
    // Variables to track inputs
    var startY, startTopScroll;
    
    elem = elem || document.querySelector(elem);
    
    // If there is no element, then do nothing    
    if(!elem)
        return;

    // Handle the start of interactions
    elem.addEventListener('touchstart', function(event){
        startY = event.touches[0].pageY;
        startTopScroll = elem.scrollTop;
        
        if(startTopScroll <= 0)
            elem.scrollTop = 1;

        if(startTopScroll + elem.offsetHeight >= elem.scrollHeight)
            elem.scrollTop = elem.scrollHeight - elem.offsetHeight - 1;
    }, false);
};

/*判断设备调用ScrollFix*/

var sUserAgent=navigator.userAgent.toLowerCase();
if(sUserAgent.match(/iphone os/i) == "iphone os"){
    $('.wrapper').addClass('wrapper2');
    ScrollFix($('.wrapper2')[0]); 
}

/*阻止用户双击使屏幕上滑*/
var agent = navigator.userAgent.toLowerCase();        //检测是否是ios
var iLastTouch = null;                                //缓存上一次tap的时间
if (agent.indexOf('iphone') >= 0 || agent.indexOf('ipad') >= 0)
{
    document.body.addEventListener('touchend', function(event)
    {
        var iNow = new Date()
            .getTime();
        iLastTouch = iLastTouch || iNow + 1 /** 第一次时将iLastTouch设为当前时间+1 */ ;
        var delta = iNow - iLastTouch;
        if (delta < 500 && delta > 0)
        {
            event.preventDefault();
            return false;
        }
        iLastTouch = iNow;
    }, false);
}
</script>