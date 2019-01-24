<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>产品详情</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/noPointCoffee_productDetail.css" rel="stylesheet" type="text/css">
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/noPointCoffee_productDetail.js" type="text/javascript"></script>
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
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<div class="head clearfix" style="height:8.346666rem; padding-top:0;">
				<div class="img">
					<img src="<?php echo get_config_item('goods_img')?>/<?php echo $a_view_data['goods'][0]['pro_img']?>"/>
				</div>
				<div class="title">
					<a href="<?php  if ($this->router->get(3) == 'i') { echo 'product_list';} else if ($this->router->get(3) == 'n') { echo 'share_goods_list';} else if ($this->router->get(3) == 0) {
						echo $this->router->url('list', [$this->router->get(1)]);
					} else { echo $this->router->url('list_store', [$this->router->get(3), $this->router->get(1)]);};?>"  class="back" style="top:0;"><img src="static/style_default/images/vbf.png"/></a>
					<span><?php if (empty($a_view_data['goods'][0]['store_id'])) {
						echo "不指定店铺";
					} else {echo $a_view_data['goods'][0]['store_name'];}?></span>
					<input type="hidden" name="store" id="store" value="<?php echo $a_view_data['goods'][0]['store_name'];?>">
				</div>
				<p class="control">
					<?php if (empty($a_view_data['colle'])) {?>
						<a class="collect" href="javascript:;" value="<?php echo $this->router->get(2)?>"><img src="static/style_default/images/fa.png"/></a>						
					<?php } else {?>
						<a class="collect cCur" href="javascript:;" value="<?php echo $this->router->get(2)?>"><img src="static/style_default/images/unfavourite.png"></a>
					<?php }?>
					<a class="share"  onclick="store_showlist();" href="javascript:;"><img src="static/style_default/images/saf.png"/></a>
				</p>
				<div class="starName">
					<p class="star">
						<span class="xing">
							<?php if ($a_view_data['payment'] >= 0 && $a_view_data['payment'] <= 20) {?>
								<i></i>
								<?php for ($i=0; $i < 4; $i++) {?>
								<i class="half"></i>
								<?php } ?>
							<?php } else if ($a_view_data['payment'] >= 21 && $a_view_data['payment'] <= 40) {?>
								<i></i>
								<i></i>
								<?php for ($i=0; $i < 3; $i++) {?>
								<i class="half"></i>
								<?php } ?>
							<?php } else if ($a_view_data['payment'] >= 41 && $a_view_data['payment'] <= 60) {?>
								<?php for ($i=0; $i < 3; $i++) {?>
								<i></i>
								<?php } ?>
								<i class="half"></i>
								<i class="half"></i>
							<?php } else if ($a_view_data['payment'] >= 61 && $a_view_data['payment'] <= 80) {?>
								<?php for ($i=0; $i < 4; $i++) {?>
								<i></i>
								<?php } ?>
								<i class="half"></i>
							<?php } else if ($a_view_data['payment'] >= 81 && $a_view_data['payment'] <= 100) {?>
							<?php for ($i=0; $i < 5; $i++) {?>
								<i></i>
								<?php } ?>
							<?php }?>
						</span>
						<span class="fen"><?php echo $a_view_data['payment']?></span>
					</p>
					<p class="name"><?php echo $a_view_data['goods'][0]['product_name']?></p>
				</div>
				<div class="xiebai"><img src="static/style_default/images/xiebai3_02.png"/></div>
				<!--价格开始-->
				<p class="price"><i class="fu">¥</i><?php echo $a_view_data['pric'][0]['price']?><i class="qi">起</i></p>
				<!--价格结束-->
			</div>
			<?php if ($a_view_data['goods'][0]['goods_stye'] == 2) {?>
			<!-- 分享者 -->
			<div class="sharing">
				<dl>
					<dt>
						<span>分享者：</span>
						<em><?php echo $a_view_data['goods'][0]['user_name']?></em>
					</dt>
					<dd>
						<span>许可证号：</span>
						<em><?php echo $a_view_data['goods'][0]['goods_license']?></em>
					</dd>
					<dd>
						<span>发货地：</span>
						<em><?php echo $a_view_data['goods'][0]['join_province'] . $a_view_data['goods'][0]['join_city'] . $a_view_data['goods'][0]['join_district'] . $a_view_data['goods'][0]['addre']?></em>
					</dd>
					<dd>
						<span>配送费:￥</span><em><?php echo $a_view_data['goods'][0]['distribution']?></em>
					</dd>
				</dl>
			</div>
			<!-- 分享者 -->
			<?php }?>
			<!--产品描述开始-->
			<div class="describe">
				<p class="h3">产品描述</p>
				<p class="miao"><?php echo strip_tags($a_view_data['goods'][0]['pro_details'])?></p>
			</div>
			<!--产品描述结束-->
			<!--评价开始-->
			<div class="appraise">
				<p class="aTitle">
					<span class="ping">评价<i class="pNum">+<?php echo $a_view_data['out']?></i></span>
					<a class="seeMore" href="list_comment-<?php echo $this->router->get(1)?>-<?php echo $this->router->get(2)?>-<?php echo $this->router->get(3)?>">查看更多</a>
				</p>
				<div class="aList">
					<ul class="clearfix">
						<?php foreach ($a_view_data['name'] as $name) {?>
							<li><a href="javascript:;"><?php echo $name?></a></li>
						<?php }?>
					</ul>
				</div>
			</div>
			<!--评价结束-->
			<!--图片开始-->
			<div class="picture">
				<p class="aTitle">
					<span class="ping">图片<i class="pNum">+<?php echo count(explode(",", $a_view_data['goods'][0]['pro_image']))?></i></span>
				</p>
				<div class="picList">
					<ul class="clearfix">
						<?php foreach (explode(",", $a_view_data['goods'][0]['pro_image']) as $value) {?>
						<li><a href="javascript:;"><img src="<?php echo get_config_item('goods_img')?>/<?php echo $value?>"/></a></li>
						<?php }?>
					</ul>
				</div>
				<div class="addBtn">
					<a href="javascript:;"><img src="static/style_default/images/gouxiang_22.png"/></a>
				</div>
			</div>
			<!--图片结束-->
			<!--浅灰遮罩层开始-->
			<div class="shade lightGrey"></div>
			<!--浅灰遮罩层结束-->
			<!--加入购物车弹框开始-->
			<form action="new_bill?oldurl=<?php echo $this->router->get_url(); ?>" method="post" class="uuyt">
			<input type="hidden" name="come_type" value="2">
			<div class="putinBomb">
				<div class="goods clearfix">
					<div class="pic">
							<input type="hidden" name="imge" value="<?php echo $a_view_data['goods'][0]['pro_img']?>">
						<img src="<?php echo get_config_item('goods_img')?>/<?php echo $a_view_data['goods'][0]['pro_img']?>"/>
					</div>
					<div class="characters">
						<p class="cName"><?php echo $a_view_data['goods'][0]['product_name']?></p>

							<input type="hidden" name="stuo_name" value="<?php echo $a_view_data['goods'][0]['store_name'];?>">
						<p class="cPrice">
							<i class="pFu">¥</i><i class="pShu"><?php echo $a_view_data['pric'][0]['price']?></i><i class="pYou"></i>
						</p>
						<input type="hidden" name="money" value="<?php echo $a_view_data['pric'][0]['price']?>" id="money">
					</div>
					<a href="javascript:;" class="close"><img src="static/style_default/images/putin_06.png"/></a>
				</div>
				<?php if ($a_view_data['goods'][0]['goods_stye'] == 1) {?>
				<div class="type">
					<!--杯型开始-->
					<div class="temperature cup">
						<p class="wen">杯型:</p>
						<div class="temType">
							<?php foreach ($a_view_data['pric'] as $v => $pric) {?>
								<i value="<?php echo $pric['cup_id']?>" <?php if ($v == 0) {echo 'class="cupCur"';}?>><?php echo $pric['cup_name']?></i>
							<?php }?>
							<input type="hidden" name="pric" value="<?php echo $a_view_data['pric'][0]['cup_id']?>" id="pric">
						<p class="cName"><?php echo $a_view_data['goods'][0]['product_name']?></p>

							<input type="hidden" name="stuo_name" value="<?php echo $a_view_data['goods'][0]['store_name'];?>">
						</div>
						<span class="su"></span>
					</div>
					<!--杯型结束-->
					<!--属性开始-->
					<?php foreach ($a_view_data['att'] as $att) {
						?>
					<div class="temperature temperature1">
						<p class="wen"><?php foreach ($a_view_data['attr'] as $attr) {if ($att['stye'] == $attr['attri_id']) {echo $attr['attri_name'];}}?>:</p>
						<div class="temType">
							 <?php $i = 0;foreach ($a_view_data['attr'] as $attr) {
                               if ( ! empty($att['attri_id']) && in_array($attr['attri_id'], explode(",", $att['attri_id']))){?>
                                <i <?php if ($i == 0) {echo 'class="temCur li_'.$i.'"';}?>><?php echo $attr['attri_name']?></i>
                            <?php $i++;}}?>
						</div>
					</div>
					<?php }?>
					<input type="hidden" name="shux" value="" id="shux">
					<!--属性结束-->
				</div>
				<?php }?>
				<?php if (empty($a_view_data['goods'][0]['user_id'])) {?>
				<input type="hidden" name="share_userid" value="0" id="share_userid">
				<?php } else {?>
				<input type="hidden" name="share_userid" value="<?php echo $a_view_data['goods'][0]['user_id']?>" id="share_userid">
				<?php }?>
				<input type="hidden" name="stuo_id" value="<?php echo $this->router->get(3)?>" id="stuo_id">
				<input type="hidden" name="goods" value="<?php echo $this->router->get(2)?>" id="goods">
				<input type="hidden" name="gname" value="<?php echo $a_view_data['goods'][0]['product_name'];?>">
				<!--加料结束-->
				<!--数量开始-->
				<div class="quantity">
					<p class="shuliang">数量:</p>
					<div class="numBox">
						<i class="less">-</i>
						<i class="num">1</i>
						<i class="more">+</i>
					</div>
					<input type="hidden" name="num" value="1" id="num">
				</div>
				<!--数量结束-->
				<!--按钮开始-->
				<div class="controlBox clearfix">
					<a href="javascript:;" class="addCar">加入购物车</a>
					<a href="javascript:;" class="buy">立即购买</a>
				</div>
				<!--按钮结束-->
			</div>
			<script>
		        $(".buy").click(function(){
		            $(".uuyt").submit();
		        })
       		 </script>
			</form>
			<!--加入购物车弹框结束-->
		</div>
		<!--遮罩层开始-->
		<div class="shade"></div>
		<!--遮罩层结束-->
		<!--图片弹框开始-->
		<div class="picBomb">
			<div class="close2">
				<a href="javascript:;"><img src="static/style_default/images/putin_06.png"/></a>
			</div>
			<div class="picWrap">
				<div class="picShow">
					<ul class="clearfix">
						<?php foreach (explode(",", $a_view_data['goods'][0]['pro_image']) as $value) {?>
						<li><img src="<?php echo get_config_item('goods_img')?>/<?php echo $value?>"/></li>
						<?php }?>
					</ul>
				</div>
				<a class="left" href="javascript:;"><img src="static/style_default/images/left.png"/></a>
				<a class="right" href="javascript:;"><img src="static/style_default/images/right.png"/></a>
			</div>
		</div>
		<!--图片弹框结束-->
		<!--分享弹框开始-->
		<div class="shareBomb">
			<p class="fenxiang">分享到</p>
			<ul class="clearfix">
				<li>
					<a href="javascript:;">
						<div class="pic">
							<img src="static/style_default/images/fenxiang_03.png"/>
						</div>
						<p class="tit">微博</p>
					</a>
				</li>
				<li>
					<a onclick="share_talk()">
						<div class="pic">
							<img src="static/style_default/images/fenxiang_05.png"/>
						</div>
						<p class="tit">微信好友</p>
					</a>
				</li>
				<li>
					<a onclick="share_friends()">
						<div class="pic">
							<img src="static/style_default/images/fenxiang_07.png"/>
						</div>
						<p class="tit">微信朋友圈</p>
					</a>
				</li>
				<li>
					<a href="javascript:;">
						<div class="pic">
							<img src="static/style_default/images/fenxiang_09.png"/>
						</div>
						<p class="tit">QQ好友</p>
					</a>
				</li>
				<li>
					<a href="javascript:;">
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
		<!--分享弹框结束-->
	</body>
</html>
<script>
	//让指定的DIV始终显示在屏幕正中间
    function setDivCenter(divName){
        var top = ($(window).height() - divName.height())/3;
        var left = ($(window).width() - divName.width())/2;
        var scrollTop = $(document).scrollTop();
//      var scrollLeft = $(document).scrollLeft();
        divName.css( { 'top' : top + scrollTop } );
    }
    setDivCenter($(".popAppTips"));
    $(".cancelDw").click(function(){
    	$(".lay").hide();
	    $(".popAppTips").hide();
    });
    $(".lay").click(function(){
    	$(".lay").hide();
	    $(".popAppTips").hide();
    })
	function store_showlist() {
	    // if (isAndroid || isiOS) {
	    //     openNearStoreList();
	    // }
	    $(".lay").show();
	    $(".popAppTips").show();
	}
	zuji();
	function zuji() {
		var goods = $('#goods').attr('value');
		$.ajax({
			type : 'post',
			url  : 'footprint_add',
			data : {goods:goods,type:1},
			dataType : 'json',
			success  : function(data) {

			}
		})
	}
</script>


<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="http://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://qiduvdaolink.js"></script>
<?php } ?>

<script>

var u = navigator.userAgent;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

// 分享的链接
var shareContent = "<?php echo $this->router->get_url(); ?>";
// 分享的标题
var title = "<?php echo $a_view_data['goods'][0]['product_name']; ?>";
// 分享的描述
var content = "<?php echo strip_tags($a_view_data['goods'][0]['pro_details']); ?>";

// 分享到微信好友
function share_talk() {
	if (isAndroid || isiOS) {
        var json = {
            "whatTypeShare" : "wx",
            "whoToShare"    : "talk",
            "shareType"     : "url",
            "shareContent"  : shareContent,
            "title"         : title,
            "content"       : content
        }
	}
	if (isAndroid) {
        shareToThirdApp(json);
	} else if (isiOS) {
        json = JSON.stringify(json);
        window.webkit.messageHandlers.vdao.postMessage({
            body    : json,
            callback: '',
            command : 'shareToThirdApp'
        });
	}
}
// 分享到微信朋友圈
function share_friends() {
	if (isAndroid || isiOS) {
        var json = {
            "whatTypeShare" : "wx",
            "whoToShare"    : "friends",
            "shareType"     : "url",
            "shareContent"  : shareContent,
            "title"         : title,
            "content"       : content
        }
	}
	if (isAndroid) {
        shareToThirdApp(json);
	} else if (isiOS) {
        json = JSON.stringify(json);
        window.webkit.messageHandlers.vdao.postMessage({
            body    : json,
            callback: '',
            command : 'shareToThirdApp'
        });
	}
}

</script>