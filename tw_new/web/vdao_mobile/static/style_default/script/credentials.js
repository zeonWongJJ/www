/**
 * Created by 7du-29 on 2017/12/26.
 */
$(function(){
    $(".lay").hide();
    $(".lay").height( $(document).height() );
    $(".choiceText").hide();
    $(".cityList").hide();
    $(".areaList").hide();
    $(".regionContainer").hide();
    // $(".applyName").hide();
    // $(".applyIDcard").hide();
    // $(".applyIDcardNum").hide();
    setDivCenter($(".tips"));
    var registerReg={
        name:/^\w{3,8}$/,
        phone:/(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/,//手机号
        IDcard:/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)///身份证
    };
    choose_province();
    //遮罩层
    $(".lay").click(function(){
        $(".lay").hide();
        $(".regionContainer").hide();
    });
    $(".harea").click(function(){
        $(".lay").hide();
        $(".regionContainer").hide();
    })
    //选择地区
    $(".regionChoice").click(function(){
        $(".lay").show();
        $(".regionContainer").show();
    });

    //有效期
    $(".legalChoiceBox>a").click(function(){
        $(this).addClass("legCur").siblings().removeClass("legCur");
        $(".legCur>img").attr("src","static/style_default/images/redbag_06.png");
        $(".legalChoiceBox>a>img").not( $(".legCur>img")).attr("src","static/style_default/images/redbag_10.png");
        if( $(this).hasClass("legalLongTime") ){
            $(".longText").show();
            $(".choiceText").hide();
            $("input[name='business_imt']").val('9');
        }
        if( $(this).hasClass("legalChoiceTime") ){
            $(".longText").hide();
            $(".choiceText").show();
        }
    });

    //申请人
    $(".applyChoiceBox>a").click(function(){
        $(this).addClass("legCur").siblings().removeClass("legCur");
        $(".legCur>img").attr("src","static/style_default/images/redbag_06.png");
        $(".applyChoiceBox>a>img").not( $(".legCur>img")).attr("src","static/style_default/images/redbag_10.png");
        if( $(this).hasClass("applyLongTime") ){
            $(".applyName").hide();
            $(".applyIDcard").hide();
            $(".applyIDcardNum").hide();
            $(".applicant").val(1);
        }
        if( $(this).hasClass("applyChoiceTime") ){
            $(".applyName").show();
            $(".applyIDcard").show();
            $(".applyIDcardNum").show();
            $(".applicant").val(2);
        }
    });

    //验证身份证
    //法人
    $("#legal_id_card").blur(function(){
        var val=$(this).val();
        if( registerReg.IDcard.test(val) ){
            console.log("ok");
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误！");
        }
        if( val=="" ){
            console.log("不能为空");
        }
    });
    //申请人
    $("#apply_id_card").blur(function(){
        var val=$(this).val();
        if( registerReg.IDcard.test(val) ){
            console.log("ok");
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误！");
        }
        if( val=="" ){
            console.log("不能为空");
        }
    });

    //验证手机号码
    $("#contact_phone").blur(function(){
        var val=$(this).val();
        if( registerReg.phone.test(val) ){
            // console.log("ok");
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误！");
        }
        if( val=="" ){
            console.log("不能为空");
        }
    });

    //验证码倒计时
    var t;
    var m=60;//秒数
    function time(ele){
        m--;
        if( m==0 ){
            ele.css("background","#ff6633");
            ele.attr("disabled",false);
            ele.val("获取验证码");
            clearInterval(t);
            m=60;
        }else{
            ele.css("background","#999999");
            ele.attr("disabled",true);
            ele.val(m+"s");
        }
    }
    //获取验证码
    $(".removeBtn").click(function(){
        var phone=$("#contact_phone").val();
        if( registerReg.phone.test(phone) ){
            // ajax请求发送验证码
            $.ajax({
                url: 'send_code',
                type: 'POST',
                dataType: 'json',
                data: {user_phone: phone},
                success: function(res) {
                    console.log(res);
                }
            })
            t=setInterval(function(){
                time($(".removeBtn"));
            },1000);
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误！");
        }
    });
    
    //让指定的DIV始终显示在屏幕正中间
    function setDivCenter(divName){
        var top = ($(window).height() - divName.height())/3;
        var left = ($(window).width() - divName.width())/2;
        var scrollTop = $(document).scrollTop();
//      var scrollLeft = $(document).scrollLeft();
        divName.css( { 'top' : top + scrollTop } );
    }

});









