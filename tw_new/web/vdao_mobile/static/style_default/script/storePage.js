/**
 * Created by 7du-29 on 2018/3/1.
 */
$(function(){
    var top;
    var jinzhi;
    $(".lay").height($(document).height());
    $(".cartLay").height($(document).height());
    $(".spec").hide();
    $(".lay").hide();
    $(".cartLay").hide();
    $(".shopCart").hide();
    $(".tips").hide();
    $(".evaluateContent").hide();
    $(".businessContent").hide();
    
    function touchMove() {
		document.addEventListener("touchmove", function(e) {
			if(jinzhi == 0) {
				e.preventDefault();
				e.stopPropagation();
			}
		}, false);
	}

    //点击遮罩层关闭
    $(".lay").click(function(){
    	jinzhi=1;
        touchMove();
        top = $(window).scrollTop();
        $("body").css("top",top);
        $(this).hide();
        $(this).css("z-index","1");
        $(".spec").hide();
//      $(".yuan").removeClass("show");
//      $(".shopCart").slideUp();
        $(".tips").hide(200);
		$("body").removeClass("ovfHiden");
    });

    //点击打开选规格
    /*$(".specBox").live("click",function(e){
    	var $this=$(this);
        var goods = $this.attr('value');
        var liList=$this.parent().parent().next().find(".choiceBox>ul>li.choiceList");
        top = $(window).scrollTop();
        e.preventDefault();
        setDivCenter($(".li_"+goods));
        $(".lay").show();
        $("body").addClass("ovfHiden");
        $("body").css("top",-top);
        console.log(  );
        liList.each(function(i){
        	$(this).addClass("c"+i);
        	if( liList.length==1 ){
        		$(".shopPrice>em").html( $this.parent().parent().next().find(".choiceBox>ul>li.c0>a.choiceCur>span").html() );
                $("#xuic").val( $this.parent().parent().next().find(".choiceBox>ul>li.c0>a.choiceCur>span").html() );
        	}else if( liList.length==2 ){
        		$(".shopPrice>em").html( $this.parent().parent().next().find(".choiceBox>ul>li.c0>a.choiceCur>span").html()+"/"+$this.parent().parent().next().find(".choiceBox>ul>li.c1>a.choiceCur>span").html() );
                $("#xuic").val( $this.parent().parent().next().find(".choiceBox>ul>li.c0>a.choiceCur>span").html()+"/"+$this.parent().parent().next().find(".choiceBox>ul>li.c1>a.choiceCur>span").html() );
        	}else if( liList.length==3 ){
        		$(".shopPrice>em").html(  $this.parent().parent().next().find(".choiceBox>ul>li.c0>a.choiceCur>span").html()+"/"+$this.parent().parent().next().find(".choiceBox>ul>li.c1>a.choiceCur>span").html()+"/"+$this.parent().parent().next().find(".choiceBox>ul>li.c2>a.choiceCur>span").html() );
                $("#xuic").val(  $this.parent().parent().next().find(".choiceBox>ul>li.c0>a.choiceCur>span").html()+"/"+$this.parent().parent().next().find(".choiceBox>ul>li.c1>a.choiceCur>span").html()+"/"+$this.parent().parent().next().find(".choiceBox>ul>li.c2>a.choiceCur>span").html() );
        	}
        });
    });*/
   
    //让指定的DIV始终显示在屏幕正中间
    function setDivCenter(divName){
        var top = ($(window).height() - divName.height())/4;
        var left = ($(window).width() - divName.width())/2;
        var scrollTop = $(window).scrollTop();
//      var scrollLeft = $(document).scrollLeft();
        divName.css( { 'top' : top + scrollTop } ).show();
    }

   
   
   	$(".specBox").live("click",function(e){
   		e.preventDefault();
   		var $this=$(this);
        var goods = $this.attr('value');
        var liList=$this.parent().parent().next();
        jinzhi=0;
        touchMove();
        setDivCenter($(".li_"+goods));
        $(".lay").show();
        $("body").css("top",-top);

        // console.log( liList.find(".choiceBox>ul>li").length );
        if( liList.find(".choiceBox>ul>li").length==1 ){
        		$(".shopPrice>em").html( liList.find("li:nth-child(1)>a.choiceCur>span").html() );
                $("#xuic").val( liList.find("li:nth-child(1)>a.choiceCur>span").html() );
        }else if( liList.find(".choiceBox>ul>li").length==2 ){
        		// console.log("ss");
        		$(".shopPrice>em").html( liList.find("li:nth-child(1)>a.choiceCur>span").html()+"/"+liList.find("li:nth-child(2)>a.choiceCur>span").html() );
                $("#xuic").val( liList.find("li:nth-child(1)>a.choiceCur>span").html()+"/"+liList.find("li:nth-child(2)>a.choiceCur>span").html() );
        }else if( liList.find(".choiceBox>ul>li").length==3 ){
        		$(".shopPrice>em").html( liList.find("li:nth-child(1)>a.choiceCur>span").html()+"/"+liList.find("li:nth-child(2)>a.choiceCur>span").html()+"/"+liList.find("li:nth-child(3)>a.choiceCur>span").html() );
                $("#xuic").val(liList.find("li:nth-child(1)>a.choiceCur>span").html()+"/"+liList.find("li:nth-child(2)>a.choiceCur>span").html()+"/"+liList.find("li:nth-child(3)>a.choiceCur>span").html() );
        }
   	});
   
    
    $(".choiceBox>ul>li").each(function(i){
//  	console.log("ss");
    	var $this=$(this);
    	$this.addClass("c"+i);
    	
    	$(document).on("click",".c"+i+">a",function(){
    		console.log("ff");
    		$(this).addClass("choiceCur");
            $(".c"+i+">a").not($(this)).removeClass("choiceCur");
            // console.log( $this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)") );
            if( $this.parent().parent().parent().find(".choiceBox>ul>li").length==1 ){
            	$(".shopPrice>em").html( $this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html() );
                $("#xuic").val($this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html() );
            }else if( $this.parent().parent().parent().find(".choiceBox>ul>li").length==2 ){
            	$(".shopPrice>em").html( $this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html() );
                $("#xuic").val($this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html() );
            }else if( $this.parent().parent().parent().find(".choiceBox>ul>li").length==3 ){
            	$(".shopPrice>em").html( $this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html()+"/"+$this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(3)>a.choiceCur>span").html() );
                $("#xuic").val($this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)>a.choiceCur>span").html()+"/"+$this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(2)>a.choiceCur>span").html()+"/"+$this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(3)>a.choiceCur>span").html() );
            }
            var cup   = $this.parent().parent().parent().find(".choiceBox>ul>li:nth-child(1)>a.choiceCur").attr('value');
            var goods = $this.parent().parent().parent().find('.product_id').attr('value');
            $.ajax({
                type : 'post',
                url  : 'list_price',
                data : {cup:cup,goods:goods},
                dataType : 'json',
                success  : function(data) {
                   $this.parent().parent().parent().find('#manoe').html(data.price);
                }
            }) 
    	});
    });
    
    
   /*$(".choiceBox>ul>li").each(function(i){
        var $this=$(this);
        $(".c"+i+">a").live("click",function(){
        	var fath=$(this).parent().parent().parent().parent().parent();
            $(this).addClass("choiceCur");
            $(".c"+i+">a").not($(this)).removeClass("choiceCur");
            // console.log( fath.find(".spec>.choiceBox>ul>li.c0>a.choiceCur").attr('value') );
            if( fath.find(".spec>.choiceBox>ul>li").length==1 ){
            	console.log("11");
            	$(".shopPrice>em").html( fath.find(".spec>.choiceBox>ul>li.c0>a.choiceCur>span").html() );
                $("#xuic").val(fath.find(".spec>.choiceBox>ul>li.c0>a.choiceCur>span").html())
            }else if( fath.find(".spec>.choiceBox>ul>li").length==2 ){
            	console.log("22");
            	$(".shopPrice>em").html( fath.find(".spec>.choiceBox>ul>li.c0>a.choiceCur>span").html()+"/"+fath.find(".spec>.choiceBox>ul>li.c1>a.choiceCur>span").html() );
                $("#xuic").val( fath.find(".spec>.choiceBox>ul>li.c0>a.choiceCur>span").html()+"/"+fath.find(".spec>.choiceBox>ul>li.c1>a.choiceCur>span").html() );
            }else if( fath.find(".spec>.choiceBox>ul>li").length==3 ){
            	console.log("33");
            	$(".shopPrice>em").html( fath.find(".spec>.choiceBox>ul>li.c0>a.choiceCur>span").html()+"/"+fath.find(".spec>.choiceBox>ul>li.c1>a.choiceCur>span").html()+"/"+fath.find(".spec>.choiceBox>ul>li.c2>a.choiceCur>span").html() );
                $("#xuic").val( fath.find(".spec>.choiceBox>ul>li.c0>a.choiceCur>span").html()+"/"+fath.find(".spec>.choiceBox>ul>li.c1>a.choiceCur>span").html()+"/"+fath.find(".spec>.choiceBox>ul>li.c2>a.choiceCur>span").html() );
            }
            var cup = fath.find(".spec>.choiceBox>ul>li.c0>a.choiceCur").attr('value');
            var goods  = fath.find('.product_id').attr('value');
            $.ajax({
                type : 'post',
                url  : 'list_price',
                data : {cup:cup,goods:goods},
                dataType : 'json',
                success  : function(data) {
                   fath.find('#manoe').html(data.price);
                }
            }) 
        });
    });*/
  
    //关闭规格选项
    $(".closeSpec").click(function(){
    	jinzhi=1;
    	touchMove();
        $(".lay").hide();
        $(".lay").css("z-index","1");
        $(".spec").hide();
        $("body").removeClass("ovfHiden");
    });

    //点击购物车
    $(".yuan").click(function(){
        var ddTol=0;
        var usore = $('.pjoTitle').attr('value');
        $.ajax({
            type : 'post',
            url  : 'shop_inex',
            data : {usore:usore},
            dataType : 'json',
            success  : function(data) {
                // console.log(data);
                if(data.code == 200) {
                    var html = "";
                    html += '<dl>'
                    +'<dt class="cartTitle">'
                    +'<span>已选商品</span>'
                    +'<em class="clearCart" onclick="qinh();">清空</em>'
                    +'</dt>';
                    for(var it in data.data.goods){
                        html += '<dd class="cartList html_'+data.data.goods[it].cart_id+'">';
                        html += '<div class="commodity">';
                        html += '<p>'+data.data.goods[it].product_name+'</p>';
                        html += '<span>'+data.data.goods[it].shux_name+'</dfn>';
                        html += '</div>';
                        html += '<div class="shopPriceBox">';
                        html += '<span class="shopNumPrice">￥<em>'+data.data.goods[it].money+'</em></span>';
                        html += '<em class="shopNum">';
                        html += '<img class="reduce" src="static/style_default/images/add_03.png" alt="" onclick="reduce('+data.data.goods[it].cart_id+');"/>';
                        html += '<span id="ou_'+data.data.goods[it].cart_id+'">'+data.data.goods[it].prot_count+'</span>';
                        html += '<img class="add" src="static/style_default/images/add_05.png" alt="" onclick="add('+data.data.goods[it].cart_id+');"/>';
                        html += '</em>';
                        html += '</div>';
                        html += '</dd>';
                    };
                    html += '<dt class="shopText">商品如需分开打包，请在下单时备注</dt>';
                    html += '</dl>';
                    $('.shopCart').html(html);
                }
            }
        })


        if( $(this).hasClass("show") ){
            $(this).removeClass("show");
            $(".cartLay").hide();
            $(".bottom").css("z-index","1");
            $(".shopCart").slideUp(200);
            top = $(window).scrollTop();
            $("body").css("top",top);
            $("body").removeClass("ovfHiden");
        }else{
            $(".shopCart>dl>dd").each(function(i){
                var ddLen=$(".shopCart>dl>dd").eq(i).length;
                ddTol=ddTol+ddLen;
            });

            $(".yuan>i").show();
            $(this).addClass("show");
            $(".cartLay").show();
            $(".bottom").css("z-index","3");
            $(".shopCart").slideDown(200);
            top = $(window).scrollTop();
//           	$("body").addClass("ovfHiden");
            top = $(window).scrollTop();
            $(".body").css("top",-top);
            $("body").addClass("ovfHiden");
            $(".shopCart").css("overflow","scroll");
        }
    });

    //清空购物车
    $(".clearCart").click(function(){
        setDivCenter($(".tips"));
//      $(".tips").show(100);
    });
    $(".cancelClear").click(function(){
        $(".tips").hide(100);
    });
    $(".sureClear").click(function(){
        var stoue = $(this).attr('value');
        $.ajax({
            type : 'post',
            url  : 'shop_delete',
            data : {stoue:stoue},
            dataType : 'json',
            success  : function (data) {
                if (data.code == 200) {
                    $(".shopCart>dl>dd").remove();
                    $(".shopCart").hide();
                    $(".tips").hide(100);
                    $(".yuan>i").html(0);
//                  $(".yuan>i").hide();
                    $(".cartLay").hide();
                    $('#poutt').text(0);
                };
            }
        })
        top = $(window).scrollTop();
        $("body").css("top",top);
        $("body").removeClass("ovfHiden");
    });
    //usorep();
    // 添加购物车
    $(".cart").each(function(i){
        $(this).click(function(){
            var goods = $(this).parent().find('.product_id').attr('value');
            var manoe = $(this).parent().find("#manoe").text();
            // manoe = manoe.slice(1, manoe.length);
            var shuxi = $('#xuic').attr('value');
            var tost  = $('.pjoTitle').attr('value');
            var name  = $('#store_name').text();
            var spec  = $(this).parent().find('.choiceCur').attr('value');
            $.ajax({
                type : 'post',
                url  : 'shop_add',
                data : {tost:tost,goods:goods,manoe:manoe,shuxi:shuxi,name:name,spec:spec,oute:1},
                dataType : 'json',
                success  : function(data) {
                    if (data.code == 200) {
                        $(".lay").hide();
                        $(".spec").hide();
                        usorep();
                    };
                }
            });
            jinzhi=1;
        	touchMove();
            top = $(window).scrollTop();
            $("body").css("top",top);
            $("body").removeClass("ovfHiden");
        });
    });


   
    //选择评价类型
    $('body').on('click','.tagBox li a',function(){
        var liIndex = $(this).parent().index();
        if(liIndex == 0){
            $(this).parent().addClass('allClick').siblings().removeClass('otherClick');
        }else{
            $(this).parent().addClass('otherClick').siblings().removeClass('otherClick');
            $('.tagBox li:eq(0)').removeClass('allClick');
        }
    });
    //导航切换
    $('.tagBox .nav a').click(function(){
        $(this).addClass('current').siblings().removeClass('current');
    });

    $(".navbar>a").click(function(){
        $(this).addClass("navCur");
        $(".navbar>a").not($(this)).removeClass("navCur");
        if( $(this).index()==0 ){
            console.log("1");
            $(".order").show();
            $(".evaluateContent").hide();
            $(".businessContent").hide();
        }else if( $(this).index()==1 ){
            console.log("2");
            $(".order").hide();
            $(".evaluateContent").show();
            $(".businessContent").hide();
        }else if( $(this).index()==2 ){
            console.log("3");
            $(".order").hide();
            $(".evaluateContent").hide();
            $(".businessContent").show();
        }
    });

    //点击分享
    $('body').on('click','.release ',function(){
        $('.shade').show();
        $('.shareBomb').show();
    });
    //关闭弹框
    $('.shareBomb .cancel a').click(function(){
        $('.shade').hide();
        $('.shareBomb').hide();
    });
});
