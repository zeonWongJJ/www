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
    setDivCenter($(".tips"));
    var registerReg={
        name:/^\w{3,20}$/,
        phone:/(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/,//手机号
        IDcard:/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)///身份证
    };

    //遮罩层
    $(".lay,.harea").click(function(){
        $(".lay").hide();
        $(".regionContainer").hide();
    });

    //选择地区
    $(".region").click(function(){
        $(".lay").show();
        $(".regionContainer").show();
        choose_province(1);
    });

    //有效期
    $(".choiceBox>a").click(function(){
        $(this).addClass("legCur").siblings().removeClass("legCur");
        $(".legCur>img").attr("src","/static/style_default/images/redbag_06.png");
        $(".choiceBox>a>img").not( $(".legCur>img")).attr("src","/static/style_default/images/redbag_10.png");
        if( $(this).hasClass("longTime") ){
            $(".longText").show();
            $(".choiceText").hide();
            $("input[name='join_expirydate']").val('9');
        }
        if( $(this).hasClass("choiceTime") ){
            $(".longText").hide();
            $(".choiceText").show();
        }
    });
    
    function notEmpty($this){
    	var val=$this.val();
    	if( val=="" ){
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("不能为空！");
        }
    }
    
    //门店名称
    $("#join_storeName").blur(function(){ notEmpty($(this)); });
    //门店数量
    $("#store_Num").blur(function(){ notEmpty($(this)); });
    //详细地址
    $("#store_address").blur(function(){ notEmpty($(this)); });
    //注册号
    $("#reg_num").blur(function(){ notEmpty($(this)); });
    //执照名称
    $("#licenseName").blur(function(){ notEmpty($(this)); });
     //法人姓名
    $("#legal_name").blur(function(){ notEmpty($(this)); });
    //联系人
    $("#contacts").blur(function(){ notEmpty($(this)); });

    //验证身份证
    $("#id_card").blur(function(){
        var val=$(this).val();
        notEmpty($(this));
        if( registerReg.IDcard.test(val) ){
            console.log("ok");
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误！");
        }
    });
    

    //验证手机号码
    $("#contact_phone").blur(function(){
        var val=$(this).val();
        notEmpty($(this));
        if( registerReg.phone.test(val) ){
            console.log("ok");
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误！");
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









