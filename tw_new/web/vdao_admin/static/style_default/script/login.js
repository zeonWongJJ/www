/**
 * Created by 7du-29 on 2017/11/17.
 */
//登录
$(function(){
    $(window).resize(function(){
        $('.login').css({
            position:'absolute',
            left: ($(window).width() - $('.login').outerWidth())/2,
            top: ($(window).height() - $('.login').outerHeight())/2
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
        adminNum:/^\w{3,8}$/,//用户名正则 至少输入3个数字、下划线或字母字符
        adminPwd:/^[a-zA-Z0-9]{6,15}$///必须且只含有数字和字母，6-15位
    };

    /*$("#admin_num").blur(function(){
        var val=$(this).val();
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
    });

    $("#admin_pwd").blur(function(){
        var val=$(this).val();
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
    });

    $("#sub").click(function(){
        if( initState.adminNum && initState.adminPwd ){
            $(this).submit();
        }else{
            $(".loginTips>p").html("账号或密码错误!");
            $(".loginTips").stop().show(100).delay(5000).hide(100);
            return false;
        }
    });*/
   
    
    function adminNum($this){
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
            subLogin();
        }else{
        	console.log("错误");
        	subLogin();
            initState.adminNum=false;
        }
    }

    function adminPwd($this){
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
            subLogin();
            return true;
        }else{
        	console.log("错误");
            initState.adminPwd=false;
            subLogin();
            return false;
        }
    }

	$("#admin_num").blur(function(){ adminNum($(this)); })
	$("#admin_pwd").blur(function(){ adminPwd($(this)); })
	
	function subLogin(){
		if( initState.adminNum && initState.adminPwd ){
            $("#sub").submit();
        }else{
//          $(".loginTips>p").html("账号或密码错误!");
//          $(".loginTips").stop().show(100).delay(5000).hide(100);
        }
	}
    
    $("#sub").click(function(){
    	adminNum($(this));
    	adminPwd($(this));   
    });
});












