/**
 * Created by 7du-29 on 2017/9/11.
 */
$(function(){

    //添加管理员账号
    //正则
    var addAdminReg={
        addAdminAccount:/^[0-9a-zA-Z\u4e00-\u9fa5_]{3,15}$/,//账户名
        addAdminName:/^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[a-zA-Z0-9])*$/,//姓名
        addAdminPhone:/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/,//手机号码
        addAdminMail:/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/, //邮箱
        addAdminPwd:/^[a-zA-Z0-9_-]{6,16}$///密码
    };
    //初始化提交状态
    var addAdminState={
        addAdminAccount:false,//账户名
        addAdminName:false,//姓名
        addAdminSex:false,//性别
        addAdminPhone:false,//手机号码
        addAdminMail:false, //邮箱
        addAdminPwd:false,//密码
        addAdminRePwd:false,//二次密码
        addAdminRole:false//属于角色
    };


    //账户名
    $("#addAccount_name").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".addAccountName>em").removeClass("hide");
            $(".addAccountName>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addAccountName>em>span").html("不能为空");
            addAdminState.addAdminAccount=false;
            return false;
        }
        if( addAdminReg.addAdminAccount.test(val) ){
            $(".addAccountName>em").removeClass("hide");
            $(".addAccountName>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".addAccountName>em>span").html("");
            addAdminState.addAdminAccount=true;
            return true;
        }else{
            $(".addAccountName>em").removeClass("hide");
            $(".addAccountName>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addAccountName>em>span").html("格式错误");
            addAdminState.addAdminAccount=false;
            return false;
        }
    });
    //姓名
    $("#addAdmin_name").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".addAdminName>em").removeClass("hide");
            $(".addAdminName>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addAdminName>em>span").html("不能为空");
            addAdminState.addAdminName=false;
            return false;
        }
        if( addAdminReg.addAdminName.test(val) ){
            $(".addAdminName>em").removeClass("hide");
            $(".addAdminName>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".addAdminName>em>span").html("");
            addAdminState.addAdminName=true;
            return true;
        }else{
            $(".addAdminName>em").removeClass("hide");
            $(".addAdminName>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addAdminName>em>span").html("格式错误");
            addAdminState.addAdminName=false;
            return false;
        }
    });

    //性别
    $(".addAdminSex>em").click(function(){
        if($(this).index()==1){
            $(this).parent("li.addAdminSex").find(".man>img").attr("src","/static/style_default/image/pro_36.png");
            $(".addAdminSex>em.wom>img").attr("src","/static/style_default/image/pro_38.png");
            $(this).addClass("choice");
            $(".addAdminSex>em").not($(this)).removeClass("choice");
        }else if($(this).index()==2){
            $(this).parent("li.addAdminSex").find(".wom>img").attr("src","/static/style_default/image/pro_36.png");
            $(".addAdminSex>em.man>img").attr("src","/static/style_default/image/pro_38.png");
            $(this).addClass("choice");
            $(".addAdminSex>em").not($(this)).removeClass("choice");
        }
        $("input[name='admin_sex']").val($(this).attr('value'));
        $(".addAdminSex>img").removeClass("hide");
        addAdminState.addAdminSex=true;
    });
    //手机号码
    $("#addAdmin_phone").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".addAdminPhone>em").removeClass("hide");
            $(".addAdminPhone>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addAdminPhone>em>span").html("不能为空");
            addAdminState.addAdminPhone=false;
            return false;
        }
        if( addAdminReg.addAdminPhone.test(val) ){
            $(".addAdminPhone>em").removeClass("hide");
            $(".addAdminPhone>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".addAdminPhone>em>span").html("");
            addAdminState.addAdminPhone=true;
            return true;
        }else{
            $(".addAdminPhone>em").removeClass("hide");
            $(".addAdminPhone>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addAdminPhone>em>span").html("格式错误");
            addAdminState.addAdminPhone=false;
            return false;
        }
    });

    //邮箱
    $("#addAdmin_mail").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".addAdminMail>em").removeClass("hide");
            $(".addAdminMail>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addAdminMail>em>span").html("不能为空");
            addAdminState.addAdminMail=false;
            return false;
        }
        if( addAdminReg.addAdminMail.test(val) ){
            $(".addAdminMail>em").removeClass("hide");
            $(".addAdminMail>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".addAdminMail>em>span").html("");
            addAdminState.addAdminMail=true;
            return true;
        }else{
            $(".addAdminMail>em").removeClass("hide");
            $(".addAdminMail>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addAdminMail>em>span").html("格式错误");
            addAdminState.addAdminMail=false;
            return false;
        }
    });

    //密码
    $("#addAdmin_pwd").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".addAdminPwd>em").removeClass("hide");
            $(".addAdminPwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addAdminPwd>em>span").html("不能为空");
            addAdminState.addAdminPwd=false;
            return false;
        }
        if( addAdminReg.addAdminPwd.test(val) ){
            $(".addAdminPwd>em").removeClass("hide");
            $(".addAdminPwd>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".addAdminPwd>em>span").html("");
            addAdminState.addAdminPwd=true;
            return true;
        }else{
            $(".addAdminPwd>em").removeClass("hide");
            $(".addAdminPwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addAdminPwd>em>span").html("格式错误");
            addAdminState.addAdminPwd=false;
            return false;
        }
    });


    //二次密码
    $("#addAdmin_rePwd").blur(function(){
        var pwdVal=$("#addAdmin_pwd").val();
        var rePwd=$(this).val();
        if( pwdVal!==rePwd ){
            $(".addAdminRePwd>em").removeClass("hide");
            $(".addAdminRePwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addAdminRePwd>em>span").html("密码不一致");
            addAdminState.addAdminRePwd=false;
            return false;
        }else if( rePwd=="" ){
            $(".addAdminRePwd>em").removeClass("hide");
            $(".addAdminRePwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addAdminRePwd>em>span").html("不能为空");
            addAdminState.addAdminRePwd=false;
            return false;
        }else{
            $(".addAdminRePwd>em").removeClass("hide");
            $(".addAdminRePwd>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".addAdminRePwd>em>span").html("");
            addAdminState.addAdminRePwd=true;
            return true;
        }
    });

    //属于角色
    $(".addRoleLevel>a").click(function(){
        $(this).children("img").removeClass("hide");
        $(this).children("img").addClass("adminChoice");
        $(".addRoleLevel>a>img").not( $(this).children("img")).addClass("hide");
        $(".addRoleLevel>a>img").not( $(this).children("img")).removeClass("adminChoice");
        $("input[name='role_id']").val($(this).attr('value'));
        addAdminState.addAdminRole=true;
    });

    //提交
    $("#addAdminSub").click(function(){
        if( addAdminState.addAdminAccount && addAdminState.addAdminName && addAdminState.addAdminSex && addAdminState.addAdminPhone && addAdminState.addAdminMail && addAdminState.addAdminPwd && addAdminState.addAdminRePwd && addAdminState.addAdminRole ){
            $(this).submit();
        }else{
            alert("格式错误！");
            return false;
        }
    });

    //关闭 编辑角色
    $(".closeRole").click(function(){
        $(".editAdmin").addClass("hide");
    });


});












