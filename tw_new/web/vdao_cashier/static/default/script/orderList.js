/**
 * Created by 7du-29 on 2018/3/7.
 */
$(function(){
    $(".lay").height( $(document).height() );
    $(".lay").hide();
    $(".modeContainer").hide();
    $(".dealContainer").hide();
    $(".reasonBox").hide();
    $(".tips").hide();
    // $(".online").hide();
    // $(".nearby").hide();

    //订单切换
    $(".orderNav>a").click(function(){
        var $this=$(this);
        $(this).addClass("navCur");
        $(".orderNav>a").not($(this)).removeClass("navCur");
        if( $this.index()==$this.index() ){
            $(".c"+$this.index()).show();
            $(".orderBox>div").not( $(".c"+$this.index())).hide();
        }
    });

    $(".orderBox>div").each(function(i){
        $(this).addClass("c"+i);
    });

    $(".orderTitle>ul>li:nth-child(3)").mouseenter(function(){
        $(this).children("img").attr("src","static/default/images/heisan_03.png");
        $(this).css({ "border":"1px solid #ddd","border-bottom":"white" });
        $(".modeContainer").show();
    });
    $(".orderTitle>ul>li:nth-child(3)").mouseleave(function(){
        $(this).children("img").attr("src","static/default/images/heisan_06.png");
        $(this).css({ "border":"1px solid white","border-bottom":"white" });
        $(".modeContainer").hide();
    });

    $(".orderTitle>ul>li:nth-child(5)").mouseenter(function(){
        $(this).children("img").attr("src","static/default/images/heisan_03.png");
        $(this).css({ "border":"1px solid #ddd","border-bottom":"white" });
        $(".dealContainer").show();
    });
    $(".orderTitle>ul>li:nth-child(5)").mouseleave(function(){
        $(this).children("img").attr("src","static/default/images/heisan_06.png");
        $(this).css({ "border":"1px solid white","border-bottom":"white" });
        $(".dealContainer").hide();
    });

    //鼠标经过状态显示
    $('.orderContainer>dl>dd>ul>li:nth-child(4)').hover(function(){
        $(this).find('.state').toggle();
    });
    
    $(".nearTitle>ul>li:nth-child(3)").mouseenter(function(){
        $(this).children("img").attr("src","static/default/images/heisan_03.png");
        $(this).css({ "border":"1px solid #ddd","border-bottom":"white" });
        $(".modeContainer").show();
    });
    $(".nearTitle>ul>li:nth-child(3)").mouseleave(function(){
        $(this).children("img").attr("src","static/default/images/heisan_06.png");
        $(this).css({ "border":"1px solid white","border-bottom":"white" });
        $(".modeContainer").hide();
    })

    //点击遮罩层
    $(".lay").live("click", function(){
        $(this).hide();
        $('.detailBomb').hide();
    });
    //订单详情
    $(".orderDetail").live("click", function(){
        $(".detailBomb").show();
        $(".lay").show();
    });
    //关闭取消订单弹框
    $(".closeBox>a").live("click", function(){
        $('.detailBomb').hide();
        $(".lay").hide();
    });
    //提示框信息
    $(".resContainer>a").click(function(){
        if( $(this).hasClass("resShow") ){
            $(this).removeClass("resShow");
            $(".reasonBox").hide();
        }else{
            $(this).addClass("resShow");
            $(".reasonBox").show();
        }
    });
    $(".reasonBox>a").click(function(){
        $(this).addClass("resCur");
        $(".reasonBox>a").not($(this)).removeClass("resCur");
        $(".resCur>img").attr("src","static/default/images/Radio.png");
        $(".reasonBox>a>img").not( $(".resCur>img")).attr("src","static/default/images/radio_shape.png");
        $(".resShow>span").html( $(".resCur>span").html() );
        $(".reasonBox").hide();
        $(".resContainer>a").removeClass("resShow");
    });
    // //取消订单
    // var id1;
    // $(".cancelOrder").click(function(){
    //     $(".tips").show();
    //     $(".lay").show();  
    //     id1 = $(this).attr("value"); 
    // });
    //关闭提示
    $(".tips>img").click(function(){
        $(".tips").hide();
        $(".lay").hide();
        $(".resContainer>a").removeClass("resShow");
        $(".reasonBox").hide();
    });
    //再看看
    $(".tipsBtn>a").click(function(){
        $(".tips").hide();
        $(".lay").hide();
        $(".resContainer>a").removeClass("resShow");
        $(".reasonBox").hide();
    });
    // //确定
    // $(".tipsBtn>em").click(function(){
    //     $(".tips").hide();
    //     $(".lay").hide();
    //     $(".resContainer>a").removeClass("resShow");
    //     $(".reasonBox").hide();
    //     var name = $(".name").text();        
    //     $.ajax({
    //         url: "order_cancel",
    //         type: "post",
    //         data: "order_id=" + id1 + "&reason=" + name,
    //         dataType: "json",
    //         success: function(result) {
    //             if (result.result == 'success') {
    //                 if (result.qianxia == 'qianxia') {
    //                     qianxia();
    //                 };
    //                 location.reload();
    //             } else {
    //                 alert('取消订单失败!');
    //             }
    //         },
    //         error:function(msg){
    //             alert(msg);
    //         }
    //     });
    // });
});







