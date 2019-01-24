<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>首页</title>
		<link rel="stylesheet" type="text/css" href="./static/style_default/style/common.css"/>
		<script src="./static/style_default/plugin/jquery-3.1.1.min.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/rem.js" type="text/javascript" charset="utf-8"></script>
        <script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

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

                var callbackSuccess=function(response) {
                    //客户端返回的数据
                    // alert(response);
                    var json = JSON.parse(response);
                    $.cookie('client_id', json.client_id);
                    localStorage.setItem('client_id', json.client_id);

                    // 获取到设备id后发起一个ajax请求，后端处理此请求进行自动登录
                    // $.ajax({
                    //     url: 'auto_login',
                    //     data: {client_id: json.client_id},
                    //     type: 'POST',
                    //     dataType: 'JSON',
                    //     success: function (rs) {}
                    // })

                    // localStorage.setItem('client_id', json.client_id);
                };
                var objs={"js":111}//前端传输给客户端的参数容器
                initSystemParams(callbackSuccess,objs);
            } else if (isiOS) {
            }

            $(document).on("click",".intSearch",function(){
                window.location.href="indexsearch";
            });
        </script>
	</head>
	<body>
		<style type="text/css">
			.box{background: #fff;min-height: 100%;font-size: .14rem;}
			.head{height: 0.44rem;width: 100%; display: flex;justify-content: space-between; position: fixed;top: 0;padding: 0 .15rem;z-index: 9999;}
			.head div{line-height: .44rem;color: #FF6633;}
			.head div:nth-child(1),.head div:nth-child(3){flex: 0 0 .33rem;background-size: .33rem .33rem; background-position: center;}
			.head .left{background: url(./static/style_default/images/message.png) no-repeat;}
			.head .right{background: url(./static/style_default/images/search_round.png) no-repeat;}
			.head .search{width: 2.55rem;height: .33rem; background: #fff; margin: auto;border-radius: 0.165rem;overflow: hidden;padding: 0 .2rem;box-shadow: 0 0 8px rgba(0,0,0,.15);}
			.head .search input{width: 100%;height: 100%;display: block;}
			.kg{height: 1.78rem;width: 100%; background: #f7f7f7;overflow: hidden;}
			.kg>img{height: auto;width: 100%;}
			.contact{padding: 0 .15rem;font-weight: 700;}
			.contact .tips{display: flex;align-items: center;color: #ff6633;margin: 0.135rem 0;}
			.contact .tips:before{content: '';display: inline-block;width: .18rem; height:.18rem;margin-right: .115rem; background: url(./static/style_default/images/tips.png) no-repeat;background-size:100% 100%; background-position: center;}
			.contact .top{ font-size: .2rem;display: flex; justify-content: space-between;align-items: center;}
			.contact .top .top_more{font-size: .14rem;color: #999999;display: flex;align-items: center;}
			.contact .top .top_more:after{content: '';display: inline-block;width: .07rem; height:.125rem;margin-left: .115rem;background: url(./static/style_default/images/more_gray.png) no-repeat;background-size:100% 100%; background-position: center;}
			.contact .recFood .types{display: flex;padding-top: .15rem;flex-wrap: wrap;}
			.contact .recFood .types .type{width: .5rem;height: .23rem;background: #e9e9e9; text-align: center;line-height: .23rem;border-radius: .05rem;margin-right: .15rem;margin-bottom:.15rem ;}
			.contact .recFood .types .type.check{background: #fed536;position: relative;}
			.contact .recFood .typeItems{display: flex; min-width: 100%;height: 1.86rem; background: #f7f7f7; border-radius: .1rem;padding: .1rem; overflow: scroll;}
			.contact .recFood .item{position: relative; margin-right: .1rem; background: #fff; border-radius: .05rem;}
			.contact .recFood .item .index{display: inline-block; padding: .03rem; background: #fed54c;border-radius: .05rem; color: #fff;font-size: .08rem; text-align: center; line-height: .15rem;position: absolute; top: .1rem;left:-0.1rem;}
			.contact .recFood .item .img{background: #f9eac9;width: 1.15rem;height: 1rem;border-radius: .05rem .05rem 0 0;}
			.contact .recFood .item .name p{margin: .1rem .05rem;}
			.contact .recFood .item .name p span{color: #999999; font-size: .12rem;}
			.contact .recStore .store{display: flex;font-size: .12rem;margin: .1rem 0; border-radius: .1rem;box-shadow: 0 0 8px rgba(0,0,0,.15);padding: .1rem;overflow: hidden;}
			.contact .recStore .store .img{width: .7rem;}
			.contact .recStore .store .img .storeImg{width: .7rem;height: .7rem; border-radius: 50%; background: greenyellow;}
			.contact .recStore .store .other{padding: 0 .1rem;}
			.contact .recStore .store .other .name{font-size: .18rem;}
			.contact .recStore .store .other .info{color: #333333;}
			.contact .recStore .store .other .foods{display: flex;}
			.contact .recStore .store .other .foods .food+.food{margin-left: .1rem;}
			.contact .recStore .store .other .foods .food .foodImg{width: .75rem; height: .75rem; border-radius: .025rem; background: #FED536;}
			.contact .recStore .store .other .foods .food .price{color: #ff0000;margin-top: .05rem;}
			/* Swipe 2 required styles */
			.box{background: #fff;min-height: 100%;font-size: .14rem;position: relative;}
			.head{height: 0.44rem;width: 100%; display: flex;justify-content: space-between; position: absolute;top: 0;padding: 0 .15rem;z-index: 9999;}
			.head div{line-height: .44rem;color: #FF6633;}
			.head div:nth-child(1),.head div:nth-child(3){flex: 0 0 .33rem;background-size: .33rem .33rem; background-position: center;}
			.head .left{background: url(./static/style_default/images/message.png) no-repeat;}
			.head .right{background: url(./static/style_default/images/search_round.png) no-repeat;}
			.head .search{width: 2.55rem;height: .33rem; background: #fff; margin: auto;border-radius: 0.165rem;overflow: hidden;padding: 0 .2rem;box-shadow: 0 0 8px rgba(0,0,0,.15);}
			.head .search input{width: 100%;height: 100%;display: block;}
			.kg{height: 1.78rem;width: 100%; background: #f7f7f7;overflow: hidden;}
			.kg>img{height: auto;width: 100%;}
			.contact{padding: 0 .15rem;font-weight: 700;}
			.contact .tips{display: flex;align-items: center;color: #ff6633;margin: 0.135rem 0;}
			.contact .tips:before{content: '';display: inline-block;width: .18rem; height:.18rem;margin-right: .115rem; background: url(./static/style_default/images/tips.png) no-repeat;background-size:100% 100%; background-position: center;}
			.contact .top{ font-size: .2rem; margin-top:0.15rem; display: flex; justify-content: space-between;align-items: center;}
			.contact .top .top_more{font-size: .14rem;color: #999999;display: flex;align-items: center;}
			.contact .top .top_more:after{content: '';display: inline-block;width: .07rem; height:.125rem;margin-left: .115rem;background: url(./static/style_default/images/more_gray.png) no-repeat;background-size:100% 100%; background-position: center;}
			.contact .recFood .types{display: flex;padding-top: .15rem;flex-wrap: wrap;}
			.contact .recFood .types .type{width: .5rem; font-size:0.12rem; height: .23rem;background: #e9e9e9; text-align: center;line-height: .23rem;border-radius: .05rem;margin-right: .15rem;margin-bottom:.15rem ;}
			.contact .recFood .types .type.check{background: #fed536;position: relative;}
			.contact .recFood .typeItems{display: flex; min-width: 100%;height: 1.86rem; background: #f7f7f7; border-radius: .1rem;padding: .1rem .2rem; overflow: scroll;}
			.contact .recFood .item{position: relative; margin-right: .1rem; background: #fff; border-radius: .05rem;}
			.contact .recFood .item .index{display: inline-block; padding: .03rem; background: #fed54c;border-radius: .05rem; color: #fff;font-size: .08rem; text-align: center; line-height: .15rem;position: absolute; top: .1rem;left:-0.05rem;}
			.contact .recFood .item .img{background: #f9eac9;width: 1.15rem;height: 1rem;border-radius: .05rem .05rem 0 0;}
			.contact .recFood .item .img>img{height: 100%;width: 100%;}
			.contact .recFood .item .name p{margin: .1rem .05rem;}
			.contact .recFood .item .name p span{color: #999999; font-size: .12rem;}
			.contact .recStore .store{display: flex;font-size: .12rem;margin: .1rem 0; border-radius: .1rem;box-shadow: 0 0 8px rgba(0,0,0,.15);padding: .1rem;overflow: hidden;}
			.contact .recStore .store .img{width: .7rem;}
			.contact .recStore .store .img .storeImg{display: inline-block;width: .7rem;height: .7rem;  background: greenyellow;overflow: hidden;}
			.contact .recStore .store .img .storeImg>img{width:100%;height: 100%;}
			.contact .recStore .store .other{padding: 0 .1rem;}
			.contact .recStore .store .other .name{ margin-top:0.05rem; font-size: .18rem;}
			.contact .recStore .store .other .info{ margin-top:0.05rem; }
			.contact .recStore .store .other .info{ margin-top:0.05rem; color: #333333;}
			.contact .recStore .store .other .foods{margin-top:0.05rem; display: flex;}
			.contact .recStore .store .other .foods .food+.food{margin-left: .1rem;}
			.contact .recStore .store .other .foods .food .foodImg{width: .75rem; height: .75rem; border-radius: .025rem; background: #FED536;overflow: hidden;}
			.contact .recStore .store .other .foods .food .foodImg>img{width: 100%;height: 100%;}
			.contact .recStore .store .other .foods .food .price{color: #ff0000;margin-top: .05rem;}
			/* Swipe 2 required styles */
			
			.contact .recFood .typeItems::-webkit-scrollbar {
        		display: none;
    		}
    		.contact .recFood .typeItems{
        		-ms-overflow-style: none;
        		overflow: -moz-scrollbars-none;
    		}
    		
			
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
			.swipe-wrap > div img{
			  width:100%;
			  height: auto;
			  /*height: 2.605rem;*/
			}
			.swipe .round{
				display: flex;
				position: absolute;
				bottom: .1rem;
				width: 100%;
				justify-content: center;
			}
			.swipe .round>li{
				width: .16rem;
				height: .08rem;
				border-radius: 0.035rem;
				margin: 0 .05rem;
				background: #fff;
			}
			/* END required styles */
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
			  width:10%;
			  /*height: auto;*/
			  /*height: 2.605rem;*/
			}
			.swipe .round{
				display: flex;
				position: absolute;
				bottom: .1rem;
				width: 100%;
				justify-content: center;
			}
			.swipe .round>li{
				width: .16rem;
				height: .08rem;
				border-radius: 0.035rem;
				margin: 0 .05rem;
				background: #fff;
			}
			.swipe .round>li.index{
				background: #ff6633;
			}

			.footer {
				position: fixed;
				background:white;
				width: 100%;
				bottom: 0;
				font-size: 0;
				border-top: 0.01rem solid #ddd;
				z-index: 90;
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
			.box{
				padding-bottom:0.6rem;
			}
			.wrapper2{
 				position:absolute;
  				top:0;
  				bottom:0;
  				left:0;
  				right:0; 
  				overflow-x:auto;
  				overflow-y:auto;
  				-webkit-overflow-scrolling : touch; 
			}
			/* END required styles */
			
			.scroll-box {
				height:0.2rem;
				/*border:2px solid #000;*/
				/*margin:20px auto;*/
				overflow:hidden;
			}
			.scroll-box ul {
				list-style:none;
				width:100%;
				height:100%;
			}
			.scroll-box ul li {
				width:100%;
				height:0.2rem;
				box-sizing:border-box;
				line-height:0.2rem;
				text-align:center;
			}
	</style>
		<div class="wrapper">
		<div class="box">
			<!--头-->
			<div class="head">
				<div class="left" onclick="go_herf();">
   				<a  href="user_moodmsg">
                <?php if (!empty($a_view_data['moodmsg'])) {
                    echo "<i></i>";
                } ?>
            </a>					
				</div>
				<div class="search">
					<input type="search" class="intSearch" placeholder="搜索产品">
				</div>
				<div class="right intSearch"></div>
			</div>
			<!--宣传图-->
			<div id='mySwipe' class='swipe'>
				<div class='swipe-wrap'>
				<?php foreach ($a_view_data['ad'] as $key => $value): ?>
					<div><a href="<?php echo $value['ad_link']; ?>"><img src="<?php echo $value['ad_pic']; ?>" ></a></div>
			<!-- 		<div><img src="img/tea.png" ></div>
					<div><img src="img/tea.png" ></div>
					<div><img src="img/search.png" ></div> -->
					  <?php endforeach ?>
				</div>
				<ul class="round">
					<li class="index"></li>
					<li></li>
					<li></li>
					<li></li>
				</ul>
			</div>
			<div class="contact">
				<!--通知-->
				<div class="tips">
   				<div class="scroll-box" ">
               <!--<marquee style="height:0.2rem;" scrollAmount=1 width=300 direction="up">
                <?php echo $a_view_data['notice']['notice_title']; ?>
                </marquee>-->
                <!--<span>好意融融咖啡香，v啡和你一起过星年！</span>-->
                	<ul>
                		<?php foreach ($a_view_data['notice'] as $key => $value): ?>
                		<li><a href="notice_detail-<?php echo $value['notice_id']; ?>"> <?php echo $value['notice_title']; ?></a></li>
                		 <?php endforeach ?>
                		
                	</ul>
           		 </div>					
				</div>
				<!--推荐食品-->
				<div class="recFood">
					<div class="top"><span class="top_l">热门推荐</span><a href="n_goods_list"><span class="top_more">更多</span></a></div>
					<div class="types">
					<?php foreach ($a_view_data['category'] as $key => $value): ?>
					<div class="type" id="<?php echo $value['pro_id']; ?>"><?php echo $value['pro_name']; ?></div>
				<!-- 	<div class="type" id="2">茶饮1</div>
					<div class="type" id="3">茶饮2</div>
					<div class="type" id="4">茶饮3</div> -->
					 <?php endforeach ?>
					</div>
					
						<div class="typeItems">
						<?php $i=1; foreach ($a_view_data['prod_data'] as $key => $val): ?>
							<a class="item" href="<?php echo $this->router->url('item',['pid'=>$val['proid_id_1'],'product_id'=>$val['product_id'],'store_id'=>'0']);?>">
								<div class="index">广州热门NO.<?php echo $i;?></div>
								<div class="img">
								<img src="<?php echo $val['pro_img']; ?>" alt="">
								</div>
								<div class="name">
									<p><?php echo $val['product_name']; ?></p>
									<p><?php echo $val['number']; ?> <span>个品尝过</span></p>
								</div>
							</a>
						<?php $i++; endforeach ?>
				
					</div>
				</div>
				<!--推荐食品End-->
				<!--推荐门店-->
				<div class="recStore">
					<div class="top"><span class="top_l">推荐门店</span><a href="store_showlist"><span class="top_more">更多</span></a>

					</div>
					<?php foreach ($a_view_data['shop_list'] as $key => $val): ?>
					<div class="store">
						<a href="list_store-<?php echo $val['store_id'];?>" >
						<div class="img">
							<div class="storeImg">
								<img src="<?php echo $val['store_touxiang'];?>" alt="">
							</div>
						</div>
						<div class="other">
							<div class="name"><?php echo $val['store_name'];?></div>
							<div class="star">⭐⭐⭐⭐⭐ <?php echo $val['all_score'];?> 月售 <?php echo $val['month_sale'];?></div>
							<div class="info">起送￥<?php echo $val['transport_start'];?>&nbsp;&nbsp; 配送￥<?php echo $val['set']['set_parameter'];?>&nbsp;&nbsp;40分钟 <?php echo $val['distance'];?>km</div>
							<div class="foods">
							<?php foreach ($val['sale_prod'] as $keys => $vals): ?>
							
								<a class="food" href="item-0-<?php echo $vals['product_id'];?>-<?php echo $val['store_id'];?>">
									<div class="foodImg"><img src="<?php echo $vals['pro_img'];?>" alt=""></div>
									<p><?php echo $vals['product_name'];?></p>
									<p class="price">￥<?php echo $vals['price'];?></p>
								</a>
							
							 <?php endforeach ?>
							 </div>
						</div>
						</a>
					</div>	
					 <?php endforeach ?>
				</div>
				<!--推荐门店End-->
			</div>
		</div>
			<div class="footer">
			<a href="javascript:;">
				<img src="./static/style_default/images/bn1.png" alt="" />
				<span style="color:#ff6633">首页</span>
			</a>
			<a href="n_goods_list">
				<img src="./static/style_default/images/nav2.png" alt="" />
				<span>产品</span>
			</a>
			<a href="mood_showlist">
				<img src="./static/style_default/images/nav3.png" alt="" />
				<span>动态</span>
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

<script src='./static/style_default/plugin/swipe.js'></script>

<script type="text/javascript">

	$(function() {
		var elem = document.getElementById('mySwipe');
		window.mySwipe = Swipe(elem, {
			startSlide: 0,
			// auto: 2000,
			continuous: true,
			disableScroll: true,
			stopPropagation: true,
			callback: function(index, element) {
				var li = $('.swipe .round').find('li');
				li.eq(index).addClass('index').siblings().removeClass('index');
				
			},
			transitionEnd: function(index, element) {}
		});
	
		// 点击食品类型
		$('.types .type').on('click',function(){

			var checked = $(this).is('.check');
			if(!checked){
				$(this).addClass('check').siblings('.type').removeClass('check');
				$('.recFood .typeItems').empty();
				var index = $(this).attr('id');
				$.post('search_cate_prod','cat_id='+index,function(res){
				if(res.code ==200) {
					var item = '';
					$.each(res.data,function(idx,object){
						idx +=1;
						item += '<a class="item" href="item-'+object.proid_id_1+'-'+object.product_id+'-0.html">'+
									'<div class="index">广州热门NO.'+idx+'</div>'+
									'<div class="img"><img src="'+object.pro_img+'"/></div>'+
									'<div class="name">'+
										'<p>'+object.product_name+'</p>'+
										'<p>'+object.number+' <span>个品尝过</span></p>'+
									'</div>'+
								'</a>'
					});
					$('.recFood .typeItems').append(item);
				}
				},'json');
		
			}
		})
	})


</script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.6&key=6dbcdd666a88d6ba145ff5b3cd66ec71"></script>
    <script type="text/javascript" >
		//web端用户定位
		mapObj = new AMap.Map('iCenter');
		mapObj.plugin('AMap.Geolocation', function () {
		    geolocation = new AMap.Geolocation({
		        enableHighAccuracy: true,//是否使用高精度定位，默认:true
		        timeout: 10000,          //超过10秒后停止定位，默认：无穷大
		        maximumAge: 0,           //定位结果缓存0毫秒，默认：0
		        convert: true,           //自动偏移坐标，偏移后的坐标为高德坐标，默认：true
		        showButton: true,        //显示定位按钮，默认：true
		        buttonPosition: 'LB',    //定位按钮停靠位置，默认：'LB'，左下角
		        buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
		        showMarker: true,        //定位成功后在定位到的位置显示点标记，默认：true
		        showCircle: true,        //定位成功后用圆圈表示定位精度范围，默认：true
		        panToLocation: true,     //定位成功后将定位到的位置作为地图中心点，默认：true
		        zoomToAccuracy:true      //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
		    });
		    mapObj.addControl(geolocation);
		    geolocation.getCurrentPosition();
		    AMap.event.addListener(geolocation, 'complete', onComplete);//返回定位信息
		    AMap.event.addListener(geolocation, 'error', onError);      //返回定位出错信息
		});
	//解析定位结果
    function onComplete(data) {
    	var lng  = data.position.getLng();
    	var lat  = data.position.getLat();
    	$.post("get_user_location","user_lngs="+lng+"&user_lats="+lat,function(res){

    	},'json');
    }
 //解析定位错误信息
    function onError(data) {
        document.getElementById('tip').innerHTML = '定位失败';
    }    		
    </script>
    
<script>
    function go_herf(){
        window.location.href ="new_user_msg";
    }

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


<script>


		 //获得当前<ul>
    var $uList = $(".scroll-box ul");
    var timer = null;
    //触摸清空定时器
    $uList.hover(function() {
        clearInterval(timer);
    },
    function() { //离开启动定时器
        timer = setInterval(function() {
            scrollList($uList);
        },
        3000);
    }).trigger("mouseleave"); //自动触发触摸事件
    //滚动动画
    function scrollList(obj) {
        //获得当前<li>的高度
        var scrollHeight = $("ul li:first").height();
        //滚动出一个<li>的高度
        $uList.stop().animate({
            marginTop: -scrollHeight
        },
        100,
        function() {
            //动画结束后，将当前<ul>marginTop置为初始值0状态，再将第一个<li>拼接到末尾。
            $uList.css({
                marginTop: 0
            }).find("li:first").appendTo($uList);
        });
    }
	
</script>