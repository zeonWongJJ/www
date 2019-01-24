/**
 * Created by 7du-29 on 2017/12/4.
 */
$(function(){
    var addInit={
        name:false,
        sex:false,
        phone:false,
        door:false
    };

    var addReg={
        phone:/(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)///手机号
    };
    //联系人
    $("#add_contact").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("不能为空！");
            addInit.name=false;
        }else{
            addInit.name=true;
        }
    });
    //性别
    $(".addSex>a").click(function(){
        var out = $(this).attr('value');
        $('#nei').val(out);
        $(this).addClass("choiceSex");
        $(".choiceSex>img").attr("src","static/style_default/images/ck_03.png");
        $(".addSex>a").not($(this)).removeClass("choiceSex");
        $(".addSex>a>img").not($(".addSex>a.choiceSex>img")).attr("src","static/style_default/images/check_06.png");
        addInit.sex=true;
    });
    //手机
    $("#add_phone").blur(function(){
        var val=$(this).val();
        if( addReg.phone.test(val) ){
            console.log("what?");
            addInit.phone=true;
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("手机号码格式错误！");
            addInit.phone=false;
        }
    });
    //门牌号
    $("#add_doorNum").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("不能为空！");
            addInit.door=false;
        }else{
            addInit.door=true;
        }
    });
    //提交
    $("#addAddrSub").click(function(){
        if( addInit.name && addInit.sex && addInit.phone && addInit.door ){

        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误或有选项未选择！");
            return false;
        }
    })
});