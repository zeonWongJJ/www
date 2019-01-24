/**
 * Created by 7du-29 on 2017/12/4.
 */
$(function(){
    var editInit={
        name:true,
        sex:true,
        phone:true,
        door:true
    };

    var editReg={
        phone:/(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)///手机号
    };
    //联系人
    $("#edit_contact").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("不能为空！");
            editInit.name=false;
        }else{
            editInit.name=true;
        }
    });
    //性别
    $(".editSex>a").click(function(){
        var out = $(this).attr('value');
        $('#nei').val(out);
        $(this).addClass("choiceSex");
        $(".choiceSex>img").attr("src","static/style_default/images/ck_03.png");
        $(".editSex>a").not($(this)).removeClass("choiceSex");
        $(".editSex>a>img").not($(".editSex>a.choiceSex>img")).attr("src","static/style_default/images/check_06.png");
        editInit.sex=true;
    });
    //手机
    $("#edit_phone").blur(function(){
        var val=$(this).val();
        if( editReg.phone.test(val) ){
            console.log("what?");
            editInit.phone=true;
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("手机号码格式错误！");
            editInit.phone=false;
        }
    });
    //门牌号
    $("#edit_doorNum").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("不能为空！");
            editInit.door=false;
        }else{
            editInit.door=true;
        }
    });
    //提交
    $("#editAddrSub").click(function(){
        if( editInit.name && editInit.sex && editInit.phone && editInit.door ){

        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误或有选项未选择！");
            return false;
        }
    })
});