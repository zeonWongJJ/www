/**
 * Created by 7du-29 on 2017/11/24.
 */
$(function(){
    var amountInit=false;
    $(".lay").hide();
    $(".redBagPwd").hide();
    $(".paymentBox").hide();
    $("#amount").keyup(function(){
       if( $(this).val()=="" ){
           $(".money>span").html($(this).attr("placeholder"));
           amountInit=false;
           $("#redBag").css("opacity","0.5");
       }else{
           $(".money>span").html($(this).val());
           $("#redBag").css("opacity","1");
           amountInit=true;
       }
    });

    $(".pwdInput>input").each(function(i){
        $(".pwdInput>input").eq(i).not($(".pwdInput>input").eq(0)).attr("readonly","readonly");
    });
    $(".pwdInput>input").keyup(function(){
        if( $(this).val().length==1 ){
            console.log("ff");
            $(this).next().removeAttr("readonly");
            $(this).next().focus();
        }else{
            $(this).prev().focus();
        }
    });
    //关闭支付密码
    $(".closeRedPwd").click(function(){
        $(".lay").hide(200);
        $(".redBagPwd").hide(200);
    });

    //支付方式
    $(".payment").click(function(){
        $(".redBagPwd").hide(200);
        $(".paymentBox").show(200);
    });

    $(".paymentBox>dl>dd").click(function(){
        $(".paymentBox>dl>dd").not($(this)).removeClass("redCur");
        $(this).addClass("redCur");
        $(".paymentBox>dl>dd>i>img").not( $(".redCur>i>img")).attr("src","../images/check_06.png");
        $(".redCur>i>img").attr("src","../images/redbag_06.png");
        $(".payment>img").attr("src",$(".redCur>img").attr("src"));
        $(".payment>span").html($(".redCur>span").html());
        $(".paymentBox").hide(200);
        $(".redBagPwd").show(200);
    });

    //提交
    $("#redBag").click(function(){
        if( amountInit ){
            $(".lay").show(200);
            $(".redBagPwd").show(200);
            $(".pwdInput>input")[0].focus();
        }else{

        }
    })
});









