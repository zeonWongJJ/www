/**
 * Created by 7du-29 on 2017/10/13.
 */
$(function(){
    //添加门店
    //正则
    var addStoreReg={
        addStoreName:/^[0-9a-zA-Z\u4e00-\u9fa5_]{3,14}$/,//门店名称
        addStoreAddress:/^(?=.*?[\u4E00-\u9FA5])[\d\u4E00-\u9FA5]+/,//门店地址
        addStoreNum:/^[a-zA-Z0-9_-]{4,16}$/,//门店账号
        addStorePwd:/^[a-zA-Z0-9_-]{6,16}$/,//密码
        addStoreContact:/^[\u4E00-\u9FA5A-Za-z]+$/,//联系人
        addStoreMobile:/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/,//手机号码
        addStoreLine:/^(0\\d{2,3}-\\d{7,8}(-\\d{3,5}){0,1})|(((13[0-9])|(15([0-3]|[5-9]))|(18[0,5-9]))\\d{8})$///固话
    };
    //初始化提交状态
    var initState={
        addStoreName:false,//门店名称
        addStoreAbled:false,//启用/暂用
        addStoreAddress:false,//门店地址
        addStoreNum:false,//门店账号
        addStoreMobile:false,//手机号码
        addStoreLine:false,//固话
        addStorePwd:false,//密码
        addStoreRePwd:false,//二次密码
        addStoreContact:false//联系人
    };

    //门店名称
    $("#addStore_name").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".addStoreName>em").removeClass("hide");
            $(".addStoreName>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addStoreName>em>span").html("不能为空");
            initState.addStoreName=false;
            return false;
        }
        if( addStoreReg.addStoreName.test(val) ){
            $(".addStoreName>em").removeClass("hide");
            $(".addStoreName>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".addStoreName>em>span").html("");
            initState.addStoreName=true;
            return true;
        }else{
            $(".addStoreName>em").removeClass("hide");
            $(".addStoreName>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addStoreName>em>span").html("格式错误");
            initState.addStoreName=false;
            return false;
        }
    });

    //启用/暂用
    $(".addStoreAbled>em").click(function(){
        if($(this).index()==1){
            $(this).parent("li.addStoreAbled").find(".enabled>img").attr("src","/static/style_default/image/pro_36.png");
            $(".addStoreAbled>em.disabled>img").attr("src","/static/style_default/image/pro_38.png");
            $(this).addClass("choice");
            $(".addStoreAbled>em").not($(this)).removeClass("choice");
        }else if($(this).index()==2){
            $(this).parent("li.addStoreAbled").find(".disabled>img").attr("src","/static/style_default/image/pro_36.png");
            $(".addStoreAbled>em.enabled>img").attr("src","/static/style_default/image/pro_38.png");
            $(this).addClass("choice");
            $(".addStoreAbled>em").not($(this)).removeClass("choice");
        }
        $(".addStoreAbled>img").removeClass("hide");
        $("input[name='store_state']").val($(this).attr('value'));
        initState.addStoreAbled=true;
    });

    //门店地址
    $("#addStore_address").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".addStoreAddress>em").removeClass("hide");
            $(".addStoreAddress>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addStoreAddress>em>span").html("不能为空");
            initState.addStoreAddress=false;
            return false;
        }
        if( addStoreReg.addStoreAddress.test(val) ){
            $(".addStoreAddress>em").removeClass("hide");
            $(".addStoreAddress>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".addStoreAddress>em>span").html("");
            initState.addStoreAddress=true;
            return true;
        }else{
            $(".addStoreAddress>em").removeClass("hide");
            $(".addStoreAddress>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addStoreAddress>em>span").html("格式错误");
            initState.addStoreAddress=false;
            return false;
        }
    });

    //门店账号
    $("#addStore_Num").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".addStoreNum>em").removeClass("hide");
            $(".addStoreNum>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addStoreNum>em>span").html("不能为空");
            initState.addStoreNum=false;
            return false;
        }
        if( addStoreReg.addStoreNum.test(val) ){
            $(".addStoreNum>em").removeClass("hide");
            $(".addStoreNum>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".addStoreNum>em>span").html("");
            initState.addStoreNum=true;
            return true;
        }else{
            $(".addStoreNum>em").removeClass("hide");
            $(".addStoreNum>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addStoreNum>em>span").html("格式错误");
            initState.addStoreNum=false;
            return false;
        }
    });

    //门店密码
    $("#addStore_pwd").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".addStorePwd>em").removeClass("hide");
            $(".addStorePwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addStorePwd>em>span").html("不能为空");
            initState.addStorePwd=false;
            return false;
        }
        if( addStoreReg.addStorePwd.test(val) ){
            $(".addStorePwd>em").removeClass("hide");
            $(".addStorePwd>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".addStorePwd>em>span").html("");
            initState.addStorePwd=true;
            return true;
        }else{
            $(".addStorePwd>em").removeClass("hide");
            $(".addStorePwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addStorePwd>em>span").html("格式错误");
            initState.addStorePwd=false;
            return false;
        }
    });

    //门店二次密码
    $("#addStore_rePwd").blur(function(){
        var pwdVal=$("#addStore_pwd").val();
        var rePwd=$(this).val();
        if( pwdVal!==rePwd ){
            $(".addStoreRePwd>em").removeClass("hide");
            $(".addStoreRePwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addStoreRePwd>em>span").html("密码不一致");
            initState.addStoreRePwd=false;
            return false;
        }else if( rePwd=="" ){
            $(".addStoreRePwd>em").removeClass("hide");
            $(".addStoreRePwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addStoreRePwd>em>span").html("不能为空");
            initState.addStoreRePwd=false;
            return false;
        }else{
            $(".addStoreRePwd>em").removeClass("hide");
            $(".addStoreRePwd>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".addStoreRePwd>em>span").html("");
            initState.addStoreRePwd=true;
            return true;
        }
    });

    //联系人
    $("#addStore_contact").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".addStoreContact>em").removeClass("hide");
            $(".addStoreContact>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addStoreContact>em>span").html("不能为空");
            initState.addStoreContact=false;
            return false;
        }
        if( addStoreReg.addStoreContact.test(val) ){
            $(".addStoreContact>em").removeClass("hide");
            $(".addStoreContact>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".addStoreContact>em>span").html("");
            initState.addStoreContact=true;
            return true;
        }else{
            $(".addStoreContact>em").removeClass("hide");
            $(".addStoreContact>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addStoreContact>em>span").html("格式错误");
            initState.addStoreContact=false;
            return false;
        }
    });

    //联系方式
    $("#addStore_phone").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".addStorePhone>em").removeClass("hide");
            $(".addStorePhone>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addStorePhone>em>span").html("不能为空");
            initState.addStoreMobile=false;
            initState.addStoreLine=false;
            return false;
        }
        if( addStoreReg.addStoreMobile.test(val) || addStoreReg.addStoreLine.test(val) ){
            $(".addStorePhone>em").removeClass("hide");
            $(".addStorePhone>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".addStorePhone>em>span").html("");
            initState.addStoreMobile=true;
            initState.addStoreLine=true;
            return true;
        }else{
            $(".addStorePhone>em").removeClass("hide");
            $(".addStorePhone>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addStorePhone>em>span").html("格式错误");
            initState.addStoreMobile=false;
            initState.addStoreLine=false;
            return false;
        }
    });
    //提交
    $("#addStoreSub").click(function(){
        if( initState.addStoreName && initState.addStoreAbled && initState.addStoreAddress && initState.addStoreNum && initState.addStorePwd && initState.addStoreRePwd &&  initState.addStoreContact && (initState.addStoreLine || initState.addStoreMobile) ){
            $(".addStore>form").submit();
        }else{
            alert("填写的格式有误或有选项未选择！");
            return false;
        }
    });
});









