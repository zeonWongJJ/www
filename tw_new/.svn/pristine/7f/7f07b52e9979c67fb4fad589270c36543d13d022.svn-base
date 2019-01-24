/* Created by 7du-29 on 2018/1/4.*/
$(function(){

    $(".lay").height( $(document).height() );
    $(".expressContainer").hide();
    $(".lay").hide();
    $("#logSub").attr("disabled",true);

    $(".lay").click(function(){
        $(this).hide();
        $(".expressContainer").hide();
    });

    //点击显示隐藏
    $(".choiceLog").click(function(){
        $(".expressContainer").show();
        $(".lay").show();
    });
    //选择快递物流公司

    /* 初始化默认状态 根据true和false来控制提交按钮的禁用 */
    var orderInit=false;
    var logInit=false;
    $(".expressList").click(function(){
        logInit=true;
        $(this).addClass("exCur");
        $(".expressList").not($(this)).removeClass("exCur");
        $(".exCur").children("img").attr("src","/static/style_default/images/redbag_06.png");
        $(".expressList>img").not( $(this).children("img")).attr("src","/static/style_default/images/redbag_10.png");
        $(".choiceLog>span").html($(".exCur>span").html());
        $(".expressContainer").hide();
        $(".lay").hide();
        $("input[name='express_company']").val($(this).attr('myname'));

        if( orderInit&&logInit ){
            console.log("ss");
            $("#logSub").attr("disabled",false);
            $("#logSub").css("background","#ff6633");
        }else{
            $("#logSub").attr("disabled",true);
            $("#logSub").css("background","#b5b5b5");
        }
    });

    var orderNum=$("#order_num");
    orderNum.blur(function(){
        if( $(this).val()=="" ){
            console.log("ss");
            orderInit=false;
        }else{
            console.log("gs");
            orderInit=true;
        }
        if( orderInit&&logInit ){
            console.log("ss");
            $("#logSub").attr("disabled",false);
            $("#logSub").css("background","#ff6633");
        }else{
            $("#logSub").attr("disabled",true);
            $("#logSub").css("background","#b5b5b5");
        }
    });


});










