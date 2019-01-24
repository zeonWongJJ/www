/**
 * Created by 7du-29 on 2018/3/1.
 */
$(function(){
    var top;
    $(".lay").height($(document).height());
    $(".spec").hide();
    $(".lay").hide();
    $(".shopCart").hide();
    $(".tips").hide();
    $(".evaluateContent").hide();
    $(".businessContent").hide();

    //点击遮罩层关闭
    $(".lay").click(function(){
        top = $(window).scrollTop();
        $("body").css("top",top);
        $(this).hide();
        $(this).css("z-index","1");
        $(".spec").hide(200);
        $(".yuan").removeClass("show");
        $(".shopCart").slideUp(200);
        $(".tips").hide(200);
        $("body").removeClass("ovfHiden");
    });

    //点击打开选规格
    $(".specBox").live("click",function(e){
        top = $(window).scrollTop();
        e.preventDefault();
        setDivCenter($(this).parent().parent().next());
        $(this).parent().parent().next().children("p:nth-child(1)").html($(this).parent().find("li:nth-child(1)>span").html());
        $(".lay").show();
        $("body").addClass("ovfHiden");
        $("body").css("top",-top);
    });

    //点击选好了
    $(".sureSpec>a").live("click",function(){
        var $this=$(this);//保存this
        var list=$this.parent().parent().parent().parent();// orderList
        var menuTitle="";//设置属性分类的标题变量作为保存
        var menuName="";//设置属性分类的变量作为保存
        var liTi=$this.parent().parent().children("p:nth-child(1)");//每个种类的标题
        var liList=$this.parent().prev().find("ul>li>a.choiceCur>span");//每个种类的分类属性

        liTi.each(function(i){//循环每个种类的标题
            menuTitle+=$(this).html();//累加各个种类标题
        });
        liList.each(function(i){//循环每个种类的分类属性
            menuName+=$(this).html()+"/";//累加各个分类属性
        });

        //如果当前列表index==循环添加创建出的元素的class的index
        if( list.index()== $(".s"+list.index()).index() ){
            $(".packageSpan>.s"+list.index()+">span").html( menuTitle+" + " );//将orderList的index作为循环出来的元素作为寻找的条件，并将累加的种类标题作为元素内容
            $(".packageSpan>.s"+list.index()+">em").html(menuName);//将orderList的index作为循环出来的元素作为寻找的条件，并将累加的分类属性作为元素内容
        }

        //底部循环添加class
        $(".packageSpan>span").each(function(i){
            $(this).addClass("s"+i);//将创建的元素循环添加class
        });
        empty();
        $(".spec").hide();
        $(".lay").hide();
    });
    //循环选项导航
    $(".choiceNav>a").each(function(i){
        /*在此元素下根据选项导航的个数来创建*/
        $(".packageSpan").append($("<p class=\"s"+i+"\"><span></span><em></em></p>"+" + "));
    });

    empty();

    //判断底部内容是否为空
    function empty(){
        if( $(".packageSpan>p>span").is(":empty") ){//如果此元素下的内容为空
            $(".joinCart").addClass("cartEmp");//添加class作为标致
            $(".joinCart").css("background","black");//改变背景色
            $(".totoal").addClass("totalEmp");//添加class作为标致
            $(".totoal").css("background","gray");//改变背景色
        }else{
            $(".joinCart").removeClass("cartEmp");//移除class作为标致
            $(".joinCart").css("background","#ff6633");//改变背景色
            $(".totoal").removeClass("totalEmp");//移除class作为标致
            $(".totoal").css("background","#ffd161");//改变背景色
             $(".joinCart").addClass("guowuc");//添加class作为标致
             $(".totoal").addClass("jiesuan");//添加class作为标致
        }
    }

    // //点击结算按钮
    // $(".totoal").click(function(){
    //     var $this=$(this);
    //     if( !$this.hasClass("totalEmp") ){//判断如果没有class才执行跳转
    //         $this.attr("href","#");//成功时的跳转
    //     }
    // });
    //点击加入购物车
    $(".joinCart").click(function(){
        var $this=$(this);
        if( !$this.hasClass("cartEmp") ){//判断如果没有class才执行跳转
            $this.attr("href","#");//成功时的跳转
        }
    });

    //规格显示
    $(".choiceBox>ul>li").each(function(i){
        var $this=$(this);
        $this.addClass("c"+i);
        $(".shopPrice>em").html( $(".c0>a.choiceCur>span").html()+"/"+$(".c1>a.choiceCur>span").html()+"/"+$(".c2>a.choiceCur>span").html() );
        $(".c"+i+">a").live("click",function(){
            $(this).addClass("choiceCur");
            $(".c"+i+">a").not($(this)).removeClass("choiceCur");
            $(".shopPrice>em").html( $(".c0>a.choiceCur>span").html()+"/"+$(".c1>a.choiceCur>span").html()+"/"+$(".c2>a.choiceCur>span").html() );
        });
    });

    //关闭规格选项
    $(".closeSpec").click(function(){
        $(".lay").hide();
        $(".lay").css("z-index","1");
        $(".spec").hide(100);
        $("body").removeClass("ovfHiden");
    });


    //让指定的DIV始终显示在屏幕正中间
    function setDivCenter(divName){
        var top = ($(window).height() - divName.height())/4;
        var left = ($(window).width() - divName.width())/2;
        var scrollTop = $(document).scrollTop();
//      var scrollLeft = $(document).scrollLeft();
        divName.css( { 'top' : top + scrollTop } ).show();
    }

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
    $('body').on('click','.collection ',function(){
        $('.shade').show();
        $('.shareBomb').show();
    });
    //关闭弹框
    $('.shareBomb .cancel a').click(function(){
        $('.shade').hide();
        $('.shareBomb').hide();
    });
    // 加入购物车
    $('.guowuc').live("click", function() {
        var meal  = $('.packageSpan>p>span').text();
        var shuxi = $('.packageSpan>p>em').text();
        var orst  = $('#orst').attr('value');
        var goods = $('#goods').attr('value');
        var name  = $('#name').attr('value');
        var price = $('#price').attr('value');
        $.ajax({
            type : 'post',
            data : {tost:orst,goods:goods,manoe:price,shuxi:shuxi,meal:meal,name:name,oute:1},
            url  : 'shop_add',
            dataType : 'json',
            success  : function (ort) {
                if (ort.code == 200) {
                    if (orst == 0) {
                        window.location.href = "list-i";                   
                    } else {
                        window.location.href = "list_store-"+orst;
                    };
                };
            }
        })
    })
});
