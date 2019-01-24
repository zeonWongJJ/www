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
	</head>
	<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<div class="head clearfix" style="height:6rem; padding-top:0;">
				<div class="img">
					<img src="<?php echo $a_view_data['goods'][0]['pro_img']?>"/>
				</div>
				<div class="title">
					<a href="javascript:history.back(-1);"  class="back" style="top:0;"><img src="static/style_default/images/vbf.png"/></a>
					<span><?php if (empty($a_view_data['goods'][0]['store_id'])) {
						echo "不指定店铺";
					} else {echo $a_view_data['goods'][0]['store_name'];}?></span>
					<input type="hidden" id="store_name" value="<?php echo $a_view_data['goods'][0]['store_name'];?>">
				</div>
				<p class="control">
					<?php if (empty($a_view_data['colle'])) {?>
						<a class="collect" href="javascript:;" value="<?php echo $this->router->get(2)?>"><img src="static/style_default/images/fa.png"/></a>						
					<?php } else {?>
						<a class="collect cCur" href="javascript:;" value="<?php echo $this->router->get(2)?>"><img src="static/style_default/images/unfavourite.png"></a>
					<?php }?>
					<a class="share" href="javascript:;"><img src="static/style_default/images/saf.png"/></a>
				</p>
				
				<!--<div class="xiebai"><img src="static/style_default/images/xiebai3_02.png"/></div>-->
				
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
				
			<!--价格开始-->
			<p class="price">
				<i class="fu">¥</i><?php echo $a_view_data['pric'][0]['price']?><i class="qi">起</i>
				<?php if (!empty($a_view_data['goods'][0]['supply_time']) && !empty($a_view_data['time'])) {$i=1;
                        foreach (explode(",", $a_view_data['goods'][0]['supply_time']) as $time) {
                           if (!empty($time) && in_array($time, $a_view_data['time'])) {
                            if ($a_view_data['goods'][0]['today_stock'] != 0) {if($i == 1){?>
                    	<a class="<?php if ($this->router->get(1) == 'i') {echo "http";} else {echo "joinCart";}?>"><?php if ($this->router->get(1) == 'i') {echo "去选择";} else {echo "加入购物车";}?></a>                           
                    <?php $i++;} } } } } else {if ($a_view_data['goods'][0]['today_stock'] != 0) {?>
                    	<a class="<?php if ($this->router->get(1) == 'i') {echo "http";} else {echo "joinCart";}?>"><?php if ($this->router->get(1) == 'i') {echo "去选择";} else {echo "加入购物车";}?></a> 
                    <?php } }?>
			</p>
			<!--价格结束-->	
				
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
						<li><a href="javascript:;"><img src="<?php echo $value?>"/></a></li>
						<?php }?>
					</ul>
				</div>
				<!--<div class="addBtn">
					<a href="javascript:;"><img src="static/style_default/images/gouxiang_22.png"/></a>
				</div>-->
			</div>
			<!--图片结束-->
			<!--浅灰遮罩层开始-->
			<!--<div class="shade lightGrey"></div>-->
			<!--浅灰遮罩层结束-->
			<!--加入购物车弹框开始-->
				
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
						<li><img src="<?php echo $value?>"/></li>
						<?php }?>
					</ul>
				</div>
				<a class="left" href="javascript:;"><img src="static/style_default/images/left.png"/></a>
				<a class="right" href="javascript:;"><img src="static/style_default/images/right.png"/></a>
			</div>
		</div>
		<!--图片弹框结束-->
		<!--分享弹框开始-->
		<div class="shareBomb" style="z-index:999;">
			<p class="fenxiang">分享到</p>
			<ul class="clearfix">
				<li style="display:none;">
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
				<li style="display:none;">
					<a href="javascript:;">
						<div class="pic">
							<img src="static/style_default/images/fenxiang_09.png"/>
						</div>
						<p class="tit">QQ好友</p>
					</a>
				</li>
				<li style="display:none;">
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
		<!--分享弹框结束-->
		
		<!-- 底部 -->
    	<form action="new_bill?oldurl=<?php echo $this->router->get_url(); ?>" class="iyyy" method="post">
    		<input type="hidden" name="come_type" value="4">
    		<input type="hidden" name="oldurl" value="<?php echo $this->router->get_url(); ?>">
    		<div class="bottom">
       			<div class="productPrice">
            		<em class="yuan">
               		 	<img src="static/style_default/images/bei_03.png" alt=""/>
                		<i id="oute"></i>
            		</em>
            		<em class="priceBox">
                		<span>￥<em id="poutt"></em></span>
                		<em>
                    		<span>另需配送费</span><dfn>￥<?php echo $a_view_data['set']['set_parameter']?></dfn>
                		</em>
            		</em>
        		</div>
        	<input type="hidden" name="store" value="<?php echo $this->router->get(3);?>">
        	<a href="javascript:;" class="totalBox">去结算</a>
         	<script>
        	$(".totalBox").click(function(){
            	$(".iyyy").submit();
        	})
        	</script>
    		</div>
    	</form>
    	<!-- 底部 -->
    	
    	<!-- 购物车 -->
    	<div class="shopCart"></div>
   		<!-- 购物车 -->
   		
   		 <!-- 规格 -->
                    <div class="spec li_<?php echo $this->router->get(2);?>">
                        <p id="pjoTitle" value="<?php echo $this->router->get(3);?>"><?php echo $a_view_data['goods'][0]['product_name']?></p>
                        <input type="hidden" class="product_id" value="<?php echo $this->router->get(2);?>">
                        <img class="closeSpec" src="static/style_default/images/y_03.png" alt=""/>
                        <div class="choiceBox">
                            <ul>
                                <li class="choiceList">
                                    <p>类型</p>
                                    <?php $i = 0;
                                        foreach ($a_view_data['pric'] as $v => $pric) {
                                        if ($pric['product_id'] == $this->router->get(2)) {?>
                                        <a value="<?php echo $pric['cup_id']?>" <?php if ($i == 0) {echo 'class="choiceCur"';}?>><span value="<?php echo $pric['cup_name']?>"><?php echo $pric['cup_name']?></span></a>
                                    <?php $i++ ;}}?>
                                </li>
                                <?php $s = 0;foreach ($a_view_data['att'] as $v => $att) {
                                    if ($att['product_id'] == $this->router->get(2)) {?>
                                    <li class="choiceList">
                                        <p><?php foreach ($a_view_data['attr'] as $attr) {if ($att['stye'] == $attr['attri_id']) {echo $attr['attri_name'];}}?>：</p>
                                        <?php $i = 0;foreach ($a_view_data['attr'] as $attr) {
                                           if ( ! empty($att['attri_id']) && in_array($attr['attri_id'], explode(",", $att['attri_id']))){?>
                                            <a <?php if ($i == 0) {echo 'class="choiceCur"';} ?> id="goods_<?php echo $att['stye']?>" value="<?php echo $att['stye']?>">
                                                <span><?php echo $attr['attri_name']?></span>
                                            </a>
                                        <?php $i++;}}?>  
                                    </li>
                                <?php }}?>
                            </ul>
                        </div>
                        <div class="shopPrice">
                            <span id="ouate">￥<span id="manoe"><?php $i = 0; foreach ($a_view_data['cup'] as $cup) {if ($this->router->get(2) == $cup['product_id']) {if ($i == 0) {echo $cup['price'];}$i++;}}?></span></span>(<em></em><dfn></dfn><s></s>)
                            <input type="hidden" id="xuic" value="">
                        </div>
                        <a class="cart">加入购物车</a>
                    </div>
                    <!-- 规格 -->
   		
   		<div class="lay"></div>
    	<!-- 提示 -->
    	<div class="tips">
        	<p>注意</p>
        	<span>确定要清空购物车吗</span>
        	<div class="tipsChoice">
            	<a class="cancelClear">取消</a>
            	<a class="sureClear" value="<?php echo $this->router->get(3);?>">确定</a>
        	</div>
    	</div>
    	<div class="tipsBox">

    	</div>
	</body>
</html>
<script>
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
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>

<script>
	$('.http').click(function(e){
		e.preventDefault();
        var goods = '<?php echo $this->router->get(2);?>';
        var stoer = '<?php echo $this->router->get(3);?>';
        window.location.href="store_meal-"+stoer+"-"+goods;
	})

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


<script type="text/javascript">
       
    function qinh() {
        if( $(".shopCart>dl>dd").length>0 ){
            $(".tips").show(100);
        }else{
            console.log("none");
        }
    }
    //购物车增加
    function add(cart_id) {
        //门店id
        var stou = $('#pjoTitle').attr('value');
        var outt = $("#ou_"+cart_id).text();
        console.log(outt);
        $.ajax({
            type : 'post',
            url  : '<?php echo $this->router->url('shop_reudaa');?>',
            data : {id:cart_id,stou:stou,vart:1},
            dataType : 'json',
            success  : function(data) {
                if (data.code == 200) {
                    outt = parseInt(outt) + 1;
                    $('#ou_'+cart_id).html(outt);
                    usorep();
                };
            }
        })
    }
    //购物车减少
    function reduce(cart_id) {
        //门店id
        var stou = $('#pjoTitle').attr('value');
        var outt = $("#ou_"+cart_id).text();
            oupp = parseInt(outt) - 1;
            if (oupp <= 0) {
                $.ajax({
                    type : 'post',
                    url  : '<?php echo $this->router->url('shop_dele');?>',
                    data : {id:cart_id},
                    dataType : 'json',
                    success  : function(data) {
                        if (data.code == 200) {
                            $('.html_'+cart_id).remove();
                             usorep();
                        };
                    }
                }) 
            } else {
                $.ajax({
                    type : 'post',
                    url  : '<?php echo $this->router->url('shop_reudaa');?>',
                    data : {id:cart_id,stou:stou,vart:2},
                    dataType : 'json',
                    success  : function(data) {
                        if (data.code == 200) {
                            $('#ou_'+cart_id).html(oupp);
                            usorep();
                        };
                    }
                })                    
            };
    }
    //购物车
    function usorep() {
        var usore = $('#pjoTitle').attr('value');
        $.ajax({
            type : 'post',
            url  : 'shop_inex',
            data : {usore:usore},
            dataType : 'json',
            success  : function(data) {
                if(data.code == 200) {
                    var out = 0;
                    for(var it in data.data.goods){
                        out += parseInt(data.data.goods[it].prot_count);
                    }
                    $('#oute').html(out);   
                    $('#poutt').text(data.data.pout);
                    if (data.data.pout > 0) {                            
                        $(".yuan>i").show();
                    };
                }
            }
        })
    }
</script>