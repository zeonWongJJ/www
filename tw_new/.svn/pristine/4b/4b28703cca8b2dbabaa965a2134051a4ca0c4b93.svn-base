//检查邮箱函数
function CheckMail(mail) {
    var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (filter.test(mail)) return true;
    else {
        $(".form_hint").eq(3).show().css("background","#fe9d50").text('正确格式为：myemail@163.com');
        return false;
    }
};

//检查用户名函数
function CheckUser(user) {
    var filter  = /^[a-zA-Z0-9_]{2,19}$/;
    if (filter.test(user)) return true;
    else {
        $('.form_hint:first').show().css("background","#fe9d50").text('请输入2-20位字母、数字或中文，不含特殊字符。');
        return false;
    }
};

//检查密码函数
function CheckPwd(pwd) {
    var filter  = /^[0-9a-zA-Z_.$#@^&]{6,14}$/;
    if (filter.test(pwd)) return true;
    else {
        $('.form_hint').eq(1).show().css("background","#fe9d50").text('密码中必须包含字母、数字、特称字符，长度为6-14个字符');
        return false;
    }
};

//验证密码
$("input[name=passwd1]").change(function(){
var pwd = $("input[name=passwd1]").val();
    if( CheckPwd(pwd) ){
        $('.form_hint').eq(1).show().css("background","#43d854").text('密码可以使用');
        $('[name="passwd1"]').css('background-image','url(../image/userPassw-valid.png').css('border','2px solid #fff');
    }else{
        $('[name="passwd1"]').css('background-image','url(../image/userPassw-err.png').css('border','2px solid #fe9d50');
    };   
});

//验证2次密码是否一样
$("input[name=passwd2]").change(function(){
var pwd2 = $("input[name=passwd2]").val();
var pwd = $("input[name=passwd1]").val();
    if( pwd != pwd2 ){
        $('.form_hint').eq(2).show().css("background","#fe9d50").text('两次输入的密码不一致');
        $('[name="passwd2"]').css('background-image','url(../image/userPassw-err.png').css('border','2px solid #fe9d50');
    }else{
        $('.form_hint').eq(2).show().css("background","#43d854").text('两次输入的密码一致');
        $('[name="passwd2"]').css('background-image','url(../image/userPassw-valid.png)').css('border','2px solid #fff');
    }
});

//AJAX提交查看用户是否被注册
$("input[name=username]").change(function(){
    var username = $(this).val();
    if( CheckUser(username) ){
        $.ajax({
                type : "POST",
                url : "name_exists",
                data: "username="+username,
                dataType : "json",
                contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                success : function(data)
                {
                    if( data > 0){
                        $('.form_hint:first').show().css("background","#fe9d50").text('用户已经被注册');
                        $('[name="username"]').css('background-image','url(../image/err.png)').css('border','2px solid #fe9d50');
                    } 
                    else {
                        $('.form_hint:first').show().css("background","#43d854").text('用户没有被注册');
                        $('[name="username"]').css('background-image','url(../image/valid.png)').css('border','2px solid #fff');
                    }
                }
            });
        }
});

//AJAX提交查看邮箱是否被注册
$("input[name=email]").change(function(){
$('[name="email"]').css('background-image','url(../image/userEmail-err.png)').css('border','2px solid #fe9d50');
email = $(this).val();
//判断是否是邮箱，如果是ajax提交判断该邮箱是否存在
if( CheckMail(email) ){
    $.ajax({
        type : "POST",
        url : "email_exists",
        data: "email="+email,
        dataType : "json",
        success : function(data)
        {
            if( data > 0){
                $(".form_hint").eq(3).css("background","#fe9d50").text('邮箱已经被注册');
                $('[name="email"]').css('background-image','url(../image/userEmail-err.png)').css('border','2px solid #fe9d50');
            }else{
                $(".form_hint").eq(3).css("background","#43d854").text('邮箱没有被注册');
                $('[name="email"]').css('background-image','url(../image/userEmail-valid.png)').css('border','2px solid #fff');
            }
        }
    });
}
});