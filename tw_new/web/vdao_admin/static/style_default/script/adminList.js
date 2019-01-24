/**
 * Created by 7du-29 on 2017/9/11.
 */
$(function(){
    var head_allselect=$(".cateHead>em.v1>img");//全选
    var bottomAllselect=$(".bottomAllSelect>img");//底部全选按钮
    var choice_role=$(".varieties>em.v1>img");//选择角色
    // var varietiesDisable=$(".varieties>em.v8>img");//是否开放

    function allSelect(eleThis,addClass1,addClass2,addClass3,ele1,ele2,img1,img2){
        if( !(eleThis.hasClass(addClass1)) ){
            eleThis.addClass(addClass1);
            eleThis.attr("src",img1);
            ele1.addClass(addClass2);
            ele1.attr("src",img1);
            ele2.addClass(addClass3);
            ele2.attr("src",img1);
        }else{
            eleThis.removeClass(addClass1);
            eleThis.attr("src",img2);
            ele1.removeClass(addClass2);
            ele1.attr("src",img2);
            ele2.removeClass(addClass3);
            ele2.attr("src",img2);
        }
        console.log(eleThis);
    }
    //全选
    head_allselect.click(function(){
        allSelect($(this),"all_select","bottom_allSelect","varietiesChoice",bottomAllselect,$(".varieties>em.v1>img"),"/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png")
    });
    //底部工具栏全选
    bottomAllselect.click(function(){
        allSelect($(this),"bottom_allSelect","all_select","varietiesChoice",head_allselect,$(".varieties>em.v1>img"),"/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    });

    //  选择角色
    function varieties(eleThis,addClass1,addClass2,addClass3,img1,img2){
        var len;
        var classLen;
        if(!(eleThis.hasClass(addClass1))){
            eleThis.addClass(addClass1);
            eleThis.attr("src",img1);
        }else{
            eleThis.removeClass(addClass1);
            eleThis.attr("src",img2);
        }
        len=choice_role.length;
        classLen=$(".varieties>em.v1>img.varietiesChoice").length;
        if(len==classLen){
            head_allselect.addClass(addClass2);
            head_allselect.attr("src",img1);
            bottomAllselect.addClass(addClass3);
            bottomAllselect.attr("src",img1);
        }else{
            head_allselect.removeClass(addClass2);
            head_allselect.attr("src",img2);
            bottomAllselect.removeClass(addClass3);
            bottomAllselect.attr("src",img2);
        }
    }

    choice_role.click(function(){
        varieties($(this),"varietiesChoice","all_select","bottom_allSelect","/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png")
    });

    //启用/暂用
    // function varieties_disabled(eleThis,addClass1,img1,img2){
    //     if( !(eleThis.hasClass(addClass1)) ){
    //         eleThis.addClass(addClass1);
    //         eleThis.attr("src",img1);
    //     }else{
    //         eleThis.removeClass(addClass1);
    //         eleThis.attr("src",img2);
    //     }
    // }
    // varietiesDisable.click(function(){
    //     varieties_disabled($(this),"disabled","/static/style_default/image/pro_33.png","/static/style_default/image/pro_10.png")
    // });

    //编辑管理员账号
    //正则
    var adminReg={
        adminAccount:/^[0-9a-zA-Z\u4e00-\u9fa5_]{3,15}$/,//账户名
        adminName:/^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[a-zA-Z0-9])*$/,//姓名
        adminPhone:/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/,//手机号码
        adminMail:/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/, //邮箱
        adminPwd:/^[a-zA-Z0-9_-]{6,16}$///密码
    };
    //初始化提交状态
    var adminState={
        adminAccount:false,//账户名
        adminName:false,//姓名
        adminSex:false,//性别
        adminPhone:false,//手机号码
        adminMail:false, //邮箱
        adminPwd:false,//密码
        adminRePwd:false,//二次密码
        adminRole:false//属于角色
    };


    //账户名
    $("#account_name").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".accountName>em").removeClass("hide");
            $(".accountName>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".accountName>em>span").html("不能为空");
            adminState.adminAccount=false;
            return false;
        }
        if( adminReg.adminAccount.test(val) ){
            $(".accountName>em").removeClass("hide");
            $(".accountName>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".accountName>em>span").html("");
            adminState.adminAccount=true;
            return true;
        }else{
            $(".accountName>em").removeClass("hide");
            $(".accountName>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".accountName>em>span").html("格式错误");
            adminState.adminAccount=false;
            return false;
        }
    });
    //姓名
    $("#admin_name").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".adminName>em").removeClass("hide");
            $(".adminName>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".adminName>em>span").html("不能为空");
            adminState.adminName=false;
            return false;
        }
        if( adminReg.adminName.test(val) ){
            $(".adminName>em").removeClass("hide");
            $(".adminName>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".adminName>em>span").html("");
            adminState.adminName=true;
            return true;
        }else{
            $(".adminName>em").removeClass("hide");
            $(".adminName>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".adminName>em>span").html("格式错误");
            adminState.adminName=false;
            return false;
        }
    });

    //性别
    $(".adminSex>em").click(function(){
        if($(this).index()==1){
            $(this).parent("li.adminSex").find(".man>img").attr("src","/static/style_default/image/pro_36.png");
            $(".adminSex>em.wom>img").attr("src","/static/style_default/image/pro_38.png");
            $(this).addClass("choice");
            $(".adminSex>em").not($(this)).removeClass("choice");
            $("input[name='admin_sex']").val('1');
        }else if($(this).index()==2){
            $(this).parent("li.adminSex").find(".wom>img").attr("src","/static/style_default/image/pro_36.png");
            $(".adminSex>em.man>img").attr("src","/static/style_default/image/pro_38.png");
            $(this).addClass("choice");
            $(".adminSex>em").not($(this)).removeClass("choice");
            $("input[name='admin_sex']").val('2');
        }
        $(".adminSex>img").removeClass("hide");
        adminState.adminSex=true;
    });
    //手机号码
    $("#admin_phone").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".adminPhone>em").removeClass("hide");
            $(".adminPhone>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".adminPhone>em>span").html("不能为空");
            adminState.adminPhone=false;
            return false;
        }
        if( adminReg.adminPhone.test(val) ){
            $(".adminPhone>em").removeClass("hide");
            $(".adminPhone>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".adminPhone>em>span").html("");
            adminState.adminPhone=true;
            return true;
        }else{
            $(".adminPhone>em").removeClass("hide");
            $(".adminPhone>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".adminPhone>em>span").html("格式错误");
            adminState.adminPhone=false;
            return false;
        }
    });

    //邮箱
    $("#admin_mail").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".adminMail>em").removeClass("hide");
            $(".adminMail>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".adminMail>em>span").html("不能为空");
            adminState.adminMail=false;
            return false;
        }
        if( adminReg.adminMail.test(val) ){
            $(".adminMail>em").removeClass("hide");
            $(".adminMail>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".adminMail>em>span").html("");
            adminState.adminMail=true;
            return true;
        }else{
            $(".adminMail>em").removeClass("hide");
            $(".adminMail>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".adminMail>em>span").html("格式错误");
            adminState.adminMail=false;
            return false;
        }
    });

    //密码
    $("#admin_pwd").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".adminPwd>em").removeClass("hide");
            $(".adminPwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".adminPwd>em>span").html("不能为空");
            adminState.adminPwd=false;
            return false;
        }
        if( adminReg.adminPwd.test(val) ){
            $(".adminPwd>em").removeClass("hide");
            $(".adminPwd>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".adminPwd>em>span").html("");
            adminState.adminPwd=true;
            return true;
        }else{
            $(".adminPwd>em").removeClass("hide");
            $(".adminPwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".adminPwd>em>span").html("格式错误");
            adminState.adminPwd=false;
            return false;
        }
    });


    //二次密码
    $("#admin_rePwd").blur(function(){
        var pwdVal=$("#admin_pwd").val();
        var rePwd=$(this).val();
        if( pwdVal!==rePwd ){
            $(".adminRePwd>em").removeClass("hide");
            $(".adminRePwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".adminRePwd>em>span").html("密码不一致");
            adminState.adminRePwd=false;
            return false;
        }else if( rePwd=="" ){
            $(".adminRePwd>em").removeClass("hide");
            $(".adminRePwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".adminRePwd>em>span").html("不能为空");
            adminState.adminRePwd=false;
            return false;
        }else{
            $(".adminRePwd>em").removeClass("hide");
            $(".adminRePwd>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".adminRePwd>em>span").html("");
            adminState.adminRePwd=true;
            return true;
        }
    });

    //属于角色
    $(".roleLevel>a").click(function(){
        $(this).children("img").removeClass("hide");
        $(this).children("img").addClass("adminChoice");
        $(".roleLevel>a>img").not( $(this).children("img")).addClass("hide");
        $(".roleLevel>a>img").not( $(this).children("img")).removeClass("adminChoice");
        adminState.adminRole=true;
        $("input[name='role_id']").val($(this).attr('value'));
    });

    //提交
    $("#adminSub").click(function(){
        if( adminState.adminAccount && adminState.adminName && adminState.adminSex && adminState.adminPhone && adminState.adminMail && adminState.adminPwd && adminState.adminRePwd && adminState.adminRole ){
            $(this).submit();
        }else{
            return false;
        }
    })

    //关闭 编辑角色
    $(".closeRole").click(function(){
        $(".editAdmin").addClass("hide");
    });

    // 重置弹出窗口的屏幕显示位置
    var nagheight = $(window).height(); //浏览器时下窗口可视区域高度
    var nagwidth  = $(window).width(); //浏览器时下窗口可视区域宽
    var tiph   = $('.pop_tips').outerHeight();
    var tipw   = $('.pop_tips').outerWidth();
    $('.pop_tips').css('top', (nagheight-tiph)/2);
    $('.pop_tips').css('left', (nagwidth-tipw)/2);

    var editAdminh   = $('.editAdmin').outerHeight();
    var editAdminw   = $('.editAdmin').outerWidth();
    $('.editAdmin').css('top', (nagheight-editAdminh)/2);
    $('.editAdmin').css('left', (nagwidth-editAdminw)/2);

});












