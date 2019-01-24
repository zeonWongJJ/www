/**
 * Created by 7du-29 on 2017/11/17.
 */
//登录
$(function(){
    $(window).resize(function(){
        $('.login').css({
            position:'absolute',
            left: ($(window).width() - $('.login').outerWidth())/2
        });
        $('.ganzi').css({
            position:'absolute',
            left: ($(window).width() - $('.ganzi').outerWidth())/2
        });
        $('.loginTips').css({
            position:'absolute',
            top: ($(window).height() - $('.loginTips').outerHeight())/2
        });
    });
    $(".loginTips").hide();
    // 最初运行函数
    $(window).resize();

    var initState={
        adminNum:false,
        adminPwd:false
    };
    var loginReg={
        adminNum:/^\w{3,15}$/,//用户名正则 至少输入3个数字、下划线或字母字符
        adminPwd:/^[a-zA-Z0-9]{6,15}$///必须且只含有数字和字母，6-15位
    };

    
    
    function storeNum($this){
    	var val=$this.val();
        if( val=="" ){
            $(".loginTips>p").html("请输入账号!");
            $(".loginTips").stop().show(100).delay(5000).hide(100);
            initState.adminNum=false;
            return false;
        }
        if( loginReg.adminNum.test(val) ){
            console.log("正确");
            initState.adminNum=true;
            return true;
        }else{
            initState.adminNum=false;
            return false;
        }
    }
    
    function storePwd($this){
    	var val=$this.val();
        if( val=="" ){
            $(".loginTips>p").html("请输入密码!");
            $(".loginTips").stop().show(100).delay(5000).hide(100);
            initState.adminPwd=false;
            return false;
        }
        if( loginReg.adminPwd.test(val) ){
            console.log("正确");
            initState.adminPwd=true;
            return true;
        }else{
            initState.adminPwd=false;
            return false;
        }
    }

	$("#store_num").blur(function(){
        storeNum($(this));
    });
    
    $("#store_pwd").blur(function(){
        storePwd($(this));
    });
    
    function subLogin(){
    	if( initState.adminNum && initState.adminPwd ){
            ("#sub").submit();
        }else{
            $(".loginTips>p").html("账号或密码错误!");
            $(".loginTips").stop().show(100).delay(5000).hide(100);
            return false;
        }
    }
    
    $("#sub").click(function(){
        storeNum($(this));
        storePwd($(this));
    });
});












