<!DOCTYPE HTML> 
<html>
<head>
<title>办公室详情</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<meta content="yes" name="apple-touch-fullscreen">
<link href='./static/style_default/style/common.css' rel='stylesheet'/>
<script src="./static/style_default/plugin/rem.js" type="text/javascript" charset="utf-8"></script>
<style>

.body{position: relative;min-height: 100%;font-size: 0.14rem;background: #fff;}
/* Swipe 2 required styles */

.swipe {
  overflow: hidden;
  visibility: hidden;
  position: relative;
  width: 100%;
}
.swipe-wrap {
  overflow: hidden;
  position: relative;
}
.swipe-wrap > div {
  float:left;
  width:100%;
  position: relative;
}
.swipe-wrap > div >img{
  width:100%;
  height: auto;
  height: 2.605rem;
}

/* END required styles */
#mySwipe .row{
	position: absolute;
	top: .1rem;
	display: flex;
	justify-content: space-between;
	height: .33rem;
	width: 100%;
	padding: 0 .1rem;
}
#mySwipe .row2{
	position: absolute;
	top: .53rem;
	display: flex;
	justify-content: flex-end;
	height: .33rem;
	width: 100%;
	padding: 0 .1rem;
}
.share_botBox {
    position: absolute;
    bottom: 0;
    width: 100%;
    font-size: 0.14rem;
    text-align: center;
    display: none;
    background: white;
    z-index: 99;
}
#mySwipe .row>div,#mySwipe .row2>div{
	flex: 0 0 .33rem;background-size: .33rem .33rem; background-position: center;background-repeat:  no-repeat;
}
#mySwipe .row .back{
	background-image: url(./static/style_default/images/back_round.png);
}
#mySwipe .row .share{
	background-image: url(./static/style_default/images/share.png);
}
#mySwipe .row2 .like{
	background-image: url(./static/style_default/images/like.png);
}
#mySwipe .row2 .coll{
    background-image: url(./static/rewrite/img/syyh.png);
}
#mySwipe .index{
	position: absolute;
	bottom: .1rem;
	right: .1rem;
	color: #fff;
	font-size: .13rem;
}
/*mySwipe End*/
.info,.describe,.valuation,.equipment{padding: .1rem;}
.info .price{font-size: .18rem;}
.info .nameBox{display: flex;justify-content: space-between;align-items: center;}
.info .nameBox .name{font-size: .16rem;font-weight: 700;}
.info .nameBox .shop{color: #fff;background: #ff6633;width: .955rem;height: .33rem;line-height: .33rem;text-align: center;border-radius: .05rem;}
.info .star{font-size: .18rem;font-weight: 700;}
.describe .top{font-size: .16rem;}
.describe p{color: #666666;text-indent:2em;padding-right: .1rem;}
.valuation .top{display: flex;justify-content: space-between;align-items: flex-end;}
.valuation .top .left{font-size: .16rem;}
.valuation .top .right{color: #888888;font-size: .12rem;}
.valua{display: flex;padding: .1rem 0;}
.valua .img{width: .31rem;height: .31rem;background: #000000;border-radius: 50%;margin-right: .1rem;}
.valua .other{flex: 1;}
.valua .other .nameBox{display: flex;justify-content: space-between;}
.imgs{line-height: 0;padding: .1rem 0;display: flex;overflow-x: auto;}
.imgs>img{width: .905rem;height: .905rem;}
.imgs>img+img{padding-left: .1rem;}
.equipment .center{padding: .1rem;}
.equipment .center{display: flex;justify-content: space-around;}
.equipment .center>div{height: .48rem;display: flex;flex-direction: column;justify-content: space-between;}
.equipment .center>div>img{width: .25rem;height: auto;}
.box_box>a {
    width: 1rem;
    display: inline-block;
}
.box_box>a>img {
    width: 0.6rem;
}
.share_botBox>p {
    font-weight: bold;
    padding: 0.15rem 0;
}
.box_box>a>span {
    margin-top: 0.1rem;
    display: block;
}
.lay {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: black;
    opacity: 0.5;
    z-index: 90;
    display: none;
}
.c_orange{color: #ff6633;}
.c_gray{color: #999999;}

</style>

</head>
<body>
<div class="body">
	<div id='mySwipe' class='swipe'>
		<div class='swipe-wrap'>
			<?php if (!empty($a_view_data['room']['room_otherpic'])) {
				$room_otherpic = explode(',', $a_view_data['room']['room_otherpic']);
				for ($i=0; $i < count($room_otherpic); $i++) {
				echo'<div><img src="'.get_config_item('wofei_admin').$room_otherpic[$i].'" ></div>';
				}
			} else {
				echo'<div><img src="static/style_default/images/banxiang_02.png" ></div>';
			
						} ?>
		</div>
		<div class="row">
			<a class="back" href="javascript:history.go(-1);"></a>
			<div class="share"></div>
		</div>
		<div class="row2">
            <?php if($a_view_data['is_collection'] ==2){?>
			<div class="likes like" data-oid="<?php echo  $a_view_data['office_id']; ?>" value="<?php echo  $a_view_data['is_collection']; ?>"></div>
            <?php }else{?>
                <div class=" likes coll" data-oid="<?php echo  $a_view_data['office_id']; ?>" value="<?php echo  $a_view_data['is_collection']; ?>"></div>
            <?php }?>
		</div>
		<div class="index">
		</div>
	</div>
	<div class="info">
		<div class="price c_orange">￥<?php echo  $a_view_data['office_price']; ?>/小时</div>
		<div class="nameBox">
			<div class="name"><?php echo $a_view_data['type']['type_name'].$a_view_data['room']['room_name']; ?></div>
			<a href="office_appoint_new-<?php echo  $a_view_data['office_id']; ?>" class="shop">立即预定</a>
		</div>
		<div class="star c_orange">⭐⭐⭐⭐⭐<?php echo $a_view_data['comment_total']; ?></div>
	</div>
	<div class="describe">
		<div class="top">办公室描述</div>
		<p><?php echo $a_view_data['room']['room_description']; ?></p>
	</div>
	<div class="equipment">
		<div class="top">设施服务</div>
		<div class="center">
			<div>
				<img src="./static/style_default/images/officeInfo/friends.png" alt="">
				<p><?php echo $a_view_data['room']['room_seat']; ?>人</p>
			</div>
			<div>
				<img src="./static/style_default/images/officeInfo/area.png" alt="">
				<p><?php echo $a_view_data['room']['room_size']; ?>㎡</p>
			</div>
			<div>
				<img src="./static/style_default/images/officeInfo/signaturePen.png" alt="">
				<p>签字笔</p>
			</div>
			<div>
				<img src="./static/style_default/images/officeInfo/computer.png" alt="">
				<p>电脑</p>
			</div>
			<div>
				<img src="./static/style_default/images/officeInfo/printer.png" alt="">
				<p>打印机</p>
			</div>
			<div>
				<img src="./static/style_default/images/officeInfo/music.png" alt="">
				<p>音响</p>
			</div>
		</div>
	</div>
	<div class="valuation">
		<div class="top">
			<div class="left">评价</div>
			<a href="office_comment-<?php echo  $a_view_data['office_id']; ?>" class="right">查看更多</a>
		</div>
		<div class="valuaBox">
			<?php if(!empty($a_view_data['comment'])){?>
			<?php foreach ($a_view_data['comment'] as $key => $value): ?>
			<div class="valua">
				<div class="img"><img src="<?php echo $value['user_pic'];?>"></div>
				<div class="other">
					<div class="nameBox">
						<div class="name"><?php echo $value['user_name'];?></div>
						<div class="time c_gray"><?php echo date('m-d', $value['comment_time']); ?></div>
					</div>
					<div class="goods c_gray">产品：<?php echo $a_view_data['type']['type_name'].$a_view_data['room']['room_name']; ?> </div>
					<div class="info">
						<span class="type c_orange">[满意]</span>
						<?php echo $value['comment_content'];?>
					</div>
					<div class="imgs">
							<?php if (!empty($value['comment_pic'])) {
									$comment_pic = explode(',', $value['comment_pic']);
									for ($i=0; $i < count($comment_pic); $i++) {
										echo '<img src="'.$comment_pic[$i].'"/>';
									}
								} ?>
						
					</div>
				</div>
			</div>
		<?php endforeach  ?>
	<?php }?>
		<!-- 	<div class="valua">
				<div class="img"></div>
				<div class="other">
					<div class="nameBox">
						<div class="name">还我大鸡腿256</div>
						<div class="time c_gray">11-6</div>
					</div>
					<div class="goods c_gray">产品：抹茶星冰乐 </div>
					<div class="info">
						<span class="type c_orange">[满意]</span>
						干净卫生、食材新鲜，很满意，味道很好，服务态度很好，发货速度也快，赞一个！
					</div>
					<div class="imgs">
						<img src="./static/style_default/images/tea.png" alt="">
						<img src="./static/style_default/images/tea.png" alt=""><img src="./static/style_default/images/tea.png" alt="">
						<img src="./static/style_default/images/tea.png" alt="">
						<img src="./static/style_default/images/tea.png" alt="">
					</div>
				</div>
			</div> -->
		</div>
	</div>
</div>
<div class="lay" style="display: none;"></div>
<div class="share_botBox">
    <p>分享到</p>
    <div class="box_box">
        <a style="cursor: pointer"><img onclick="weix_peyo()" src="./static/rewrite/img/fhao.png"
                                        alt=""/><span>微信好友</span></a>
        <a style="cursor: pointer"><img onclick="weix_quan()" src="./static/rewrite/img/hhas.png"
                                        alt=""/><span>微信朋友圈</span></a>
    </div>
</div>
<script src="./static/style_default/plugin/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src='./static/style_default/plugin/swipe.js'></script>
<script>
var length = $('.swipe-wrap img').length;
$('.index').text('1/'+length);
// pure JS
var elem = document.getElementById('mySwipe');
window.mySwipe = Swipe(elem, {
	startSlide: 0,
	auto: 2000,
	continuous: true,
	disableScroll: true,
	stopPropagation: true,
	callback: function(index, element) {
		$('.index').text(index+1+'/'+length);
	},
	transitionEnd: function(index, element) {}
});
$(".likes").on("click",function(){
    var is_collection = $(this).attr('value');
    var office_id = $(this).data("oid");
    $.ajax({
        url: 'office_collection',
        type: 'POST',
        dataType: 'json',
        data: {office_id: office_id},
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                if (is_collection == 1) {
                    $('.likes').attr('value','2');
                    $('.likes').css('background-image','url(./static/style_default/images/like.png)');
                } else {
                    $('.likes').attr('value','1');
                    $('.likes').css('background-image','url(./static/rewrite/img/syyh.png)');
                }
            }
        }
    })
});
// with jQuery
// window.mySwipe = $('#mySwipe').Swipe().data('Swipe');
$("body").on("click", ".share", function () {
    share();
});
function share() {
    $(".lay").show();
    $(".share_botBox").show();
    $(".share_botBox").slideDown(100);
}
</script>
<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>
<script type="text/javascript">
    var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

    // 分享的链接
    var shareContent = "<?php echo $this->router->get_url(); ?>";
    // 分享的标题
    var title = "<?php echo $a_view_data['room']['room_name']; ?>";
    // 分享的描述
    var content = "<?php echo $a_view_data['room']['room_introduction']; ?>";
    // 门店头像
    var store_touxiang = "<?php echo $a_view_data['store_touxiang']; ?>";

    //遮罩层
    $("body").on("click", ".lay", function () {
        $(".lay").hide();
        $(".type_box").hide();

        $(".share_botBox").slideUp(100);
    });
    // 微信好友
    function weix_peyo() {
        var json = {
            "whatTypeShare": "wx",
            "whoToShare": "talk",
            "shareType": "url",
            "shareContent": shareContent,
            "title": title,
            "content": content,
            "imgurl": store_touxiang,
        }
        if (isiOS) {
            json = JSON.stringify(json);
            window.webkit.messageHandlers.vdao.postMessage({
                body: json,
                callback: '',
                command: 'shareToThirdApp'
            });
        } else if (isAndroid) {
            shareToThirdApp(json);
        }
    }

    // 微信朋友圈
    function weix_quan() {
        var json = {
            "whatTypeShare": "wx",
            "whoToShare": "friends",
            "shareType": "url",
            "shareContent": shareContent,
            "title": title,
            "content": content
        }
        if (isiOS) {
            json = JSON.stringify(json);
            window.webkit.messageHandlers.vdao.postMessage({
                body: json,
                callback: '',
                command: 'shareToThirdApp'
            });
        } else if (isAndroid) {
            shareToThirdApp(json);
        }

    }
</script>
