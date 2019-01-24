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
    <link rel="stylesheet" href="static/style_default/style/storePage.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/storePage.js"></script>
    <title>门店点餐</title>
</head>
<body>
    <!-- 头部 -->
    <div class="head">
        <p class="pjoTitle" value="<?php echo $this->router->get(1)?>">
            <a href="javascript:;" onclick="goback_app()"><img src="static/style_default/images/gouxiang_18.png" alt=""/></a>
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
            <i><?php if (empty($a_view_data['store']['store_touxiang'])) {
                echo '<img src="./static/style_default/images/tou_03.png" />';
            } else {
                echo '<img src="'.$a_view_data['store']['store_touxiang'].'" />';
            } ?></i>
            <dl>
                <dt id="store_name"><?php echo $a_view_data['store']['store_name']; ?></dt>
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
        <a href="office_showlist-1-<?php echo $a_view_data['store']['store_id'];?>" class="meet"><img src="static/style_default/images/huyu_03.png" alt=""/></a>
    </div>
    <!-- 头部 -->
    <!-- 内容主体 -->
    <div class="storeContainer">
        <div class="navbar">
            <a href="list_store-<?php echo $this->router->get(1)?>" class="navCur">点餐</a>
            <a href="store_newcomment-<?php echo $this->router->get(1)?>">评价</a>
            <a href="store_newdetail-<?php echo $this->router->get(1)?>">商家</a>
            <span><a href="office_showlist-2-<?php echo $this->router->get(1);?>" class="seat">就餐订座</a></span>
        </div>
        <!-- 点餐-->
        <div class="order">
            <ul class="orderNav">
                <?php foreach ($a_view_data['pro'] as $pro) {?>
                    <li <?php if ($pro['pro_id'] == $this->router->get(2)) {
                      echo 'class="orderCur"';}?>><a href="<?php echo $this->router->url('list_store', [ $this->router->get(1), $pro['pro_id']]);?>"><?php echo $pro['pro_name']?></a>
                    </li>
                <?php }?>
                <li <?php if ($this->router->get(2) == 'i') {
                    echo 'class="orderCur"';}?>><a href="<?php echo $this->router->url('list_store', [ $this->router->get(1), 'i']);?>">套餐</a>
                </li>
            </ul>
            <dl class="orderList">
                <!-- <dt>挝的啡</dt> -->
                <?php foreach ($a_view_data['prod'] as $prod) {?>
                <dd>
                    <a href="<?php echo $this->router->url('item', [$this->router->get(2), $prod['product_id'], $this->router->get(1)]);?>">
                        <img src="<?php echo $prod['pro_img']?>" alt=""/>
                        <ul>
                        	<li>
                        		<em>
                                    <?php $i=0; if (!empty($prod['supply_time'])) {
                                        foreach (explode(",", $prod['supply_time']) as $time) {
                                           if (!empty($time) && in_array($time, $a_view_data['time'])) {?>    <?php $i=1;?>      
                                    <?php } } } ?>
                                    <?php if ($i != 1) {?>
                                        <?php foreach (explode(",", $prod['supply_time']) as $time) {foreach($a_view_data['time_name'] as $name) {if ($name['time_id'] == $time) {echo '<span>'.$name['time_nema'].'供应</span>';}}}?>
                                    <?php }?>
                                </em>
                        	</li>
                            <li>
                                <span><?php echo $prod['product_name']?></span>
                                
                            </li>
                            <li><?php echo strip_tags($prod['pro_details'])?></li>
                            <li>
                                <span>月售<em><?php echo $prod['number'] ? $prod['number']:0?></em></span>
                                <span>好评率<em><?php echo $prod['pingl'] ? $prod['pingl']:0?>%</em></span>
                            </li>
                            <li>
                                <span>￥<em><?php $i = 0; foreach ($a_view_data['cup'] as $cup) {if ($prod['product_id'] == $cup['product_id']) {if ($i == 0) {echo $cup['price'];}$i++;}}?></em></span>起
                            </li>
                            <?php if (!empty($prod['supply_time'])) {
                                foreach (explode(",", $prod['supply_time']) as $time) {
                                   if (in_array($time, $a_view_data['time'])) {
                                    if ($prod['today_stock'] != 0) {?>
                                <li class="<?php if ($this->router->get(2) == 'i') { echo "http";} else {echo "specBox";}?>" value="<?php echo $prod['product_id']?>"><?php if ($this->router->get(2) == 'i') {echo "去选择";} else {echo "选规格";}?></li>
                            <?php } } } } else {if ($prod['today_stock'] != 0) {?>
                                <li class="<?php if ($this->router->get(2) == 'i') { echo "http";} else {echo "specBox";}?>" value="<?php echo $prod['product_id']?>"><?php if ($this->router->get(2) == 'i') {echo "去选择";} else {echo "选规格";}?></li> 
                            <?php } }?>
                        </ul>
                    </a>
                    <!-- 规格 -->
                    <div class="spec li_<?php echo $prod['product_id']?>">
                        <p id="goodsid" value="<?php echo $prod['product_id']?>"><?php echo $prod['product_name']?></p>
                        <input type="hidden" class="product_id" value="<?php echo $prod['product_id']?>">
                        <img class="closeSpec" src="static/style_default/images/y_03.png" alt=""/>
                        <div class="choiceBox">
                            <ul>
                                <li class="choiceList">
                                    <p>类型</p>
                                    <?php $i = 0;
                                        foreach ($a_view_data['pric'] as $v => $pric) {
                                        if ($pric['product_id'] == $prod['product_id']) {?>
                                        <a value="<?php echo $pric['cup_id']?>" <?php if ($i == 0) {echo 'class="choiceCur"';}?>><span value="<?php echo $pric['cup_name']?>"><?php echo $pric['cup_name']?></span></a>
                                    <?php $i++ ;}}?>
                                </li>
                                <?php $s = 0;foreach ($a_view_data['att'] as $v => $att) {
                                    if ($att['product_id'] == $prod['product_id']) {?>
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
                            <span id="ouate">￥<span id="manoe"><?php $i = 0; foreach ($a_view_data['cup'] as $cup) {if ($prod['product_id'] == $cup['product_id']) {if ($i == 0) {echo $cup['price'];}$i++;}}?></span></span>(<em></em><dfn></dfn><s></s>)
                            <input type="hidden" id="xuic" value="">
                        </div>
                        <a class="cart">加入购物车</a>
                    </div>
                    <!-- 规格 -->
                </dd>
                <?php }?>
            </dl>
        </div>
        <!-- 点餐-->
    </div>
    <!-- 内容主体 -->

    <!-- 底部 -->
    <form action="new_bill?oldurl=<?php echo $this->router->get_url(); ?>" class="iyyy" method="post">
        <input type="hidden" name="come_type" value="4">
        <input type="hidden" name="store" value="<?php echo $this->router->get(1); ?>">
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

    <div class="lay"></div>
    <div class="cartLay"></div>

    <!-- 提示 -->
    <div class="tips">
        <p>注意</p>
        <span>确定要清空购物车吗</span>
        <div class="tipsChoice">
            <a class="cancelClear">取消</a>
            <a class="sureClear" value="<?php echo $this->router->get(1);?>">确定</a>
        </div>
    </div>
    <div class="tipsBox">

    </div>

    <!-- 提示 -->

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
<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>
    <script type="text/javascript">
    $('.http').click(function(e){
        e.preventDefault();
        var goods = $(this).attr('value');
        var stoer = '<?php echo $this->router->get(1);?>';
        window.location.href="store_meal-"+stoer+"-"+goods;
    })

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
            var store_id = "<?php echo $this->router->get(1);?>";
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
    })
    function qinh() {
        $("body").css("top",top);
		var top = ($(window).height() - $(".tips").height())/3;  
        var left = ($(window).width() - $(".tips").width())/2;  
        var scrollTop = $(document).scrollTop();  
//      var scrollLeft = $(document).scrollLeft();  

	 	if( $(".shopCart>dl>dd").length>0 ){
//          	$(".tips").show(100);
 				$(".tips").css( { position : 'absolute', 'top' : top + scrollTop } ).show();  
        }else{
            console.log("none");
        }
    }
    //购物车增加
    function add(cart_id) {
        //门店id
        var stou = '<?php echo $this->router->get(1)?>';
        var outt = $("#ou_"+cart_id).text();
        // console.log(outt);
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
        var stou = '<?php echo $this->router->get(1)?>';
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
    usorep();
    //购物车
    function usorep() {
        var usore = '<?php echo $this->router->get(1)?>'
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
        var latitude = "<?php echo $a_view_data['store']['store_latitude']; ?>";
        var longitude = "<?php echo $a_view_data['store']['store_longitude']; ?>";
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
    var title = "<?php echo $a_view_data['store']['store_name']; ?>";
    // 分享的描述
    var content = "<?php echo $a_view_data['store']['store_introduction']; ?>";
    // 门店头像
    var store_touxiang = "<?php echo $a_view_data['store']['store_touxiang']; ?>";

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
</body>

</html>