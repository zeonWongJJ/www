<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/bindCard.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <title></title>
</head>
<body>

    <div class="contentContainer">
        <p class="pjoTitle">
            <a href="javascript:window.history.back();" style="top:0.45rem;"><img src="static/style_default/images/kefu_03.png" /></a>
            <span>绑定微信</span>
        </p>
        <!-- 表单 -->
        <div class="formContainer">
            <form action="account_add" method="post">
            	<input type="hidden" name="type" value="<?php echo $this->router->get(1); ?>">
                <dl>
                    <dt>请仔细核对您的微信账号，以确保能准确成功提现</dt>
  					<dd>
                        <span>微信名</span>
                        <input type="text" name="wx_nickname"  disabled="disabled" readonly="readonly" placeholder="点击绑定获取微信名"/>
                    </dd>
                    <dd>
                        <span>提现账号</span>
                        <input type="text" name="wx_openid"  disabled="disabled" readonly="readonly" placeholder="点击绑定获取微信账号"/>
                    </dd>                    
                </dl>
  				 <dl>
                    <dt class="weixin">
                    <a href="javascript:;">点击绑定提现微信号</a> 
                    </dt>
                </dl>                
                <input type="submit" id="sub" value="提交"/>
            </form>
        </div>
        <!-- 表单 -->
    </div>

</body>
</html>

<script>

$('#sub').click(function(event) {
	var wx_nickname = $("input[name='wx_nickname']").val();
	var wx_openid   = $("input[name='wx_openid']").val();
	if (wx_nickname != '' && wx_openid != '') {
		// 发送ajax请求
		$.ajax({
			url: 'account_add',
			type: 'POST',
			dataType: 'json',
			data: {wx_nickname: wx_nickname, wx_openid:wx_openid, type:3},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					 window.location.replace("account_manage");
				}
			}
		})
	}
	return false;
});
var u = navigator.userAgent;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
//解除微信绑定
$('.weixin a').click(function(){

		if (isAndroid || isiOS) {
	        var callbackSuccess = function(response){
	        	res =  eval("("+response+")");;
	            if (response != '') {
	               $("[name='wx_openid']").val(res.openid);
	               $("[name='wx_nickname']").val(res.nickname);
	            } else {
	            	alert("绑定失败");
	            	return;
	            }
	        }
		}
		if (isAndroid) {
	        wxAuthorizationLogin(callbackSuccess);
		} else if (isiOS) {
	        window.webkit.messageHandlers.vdao.postMessage({
	            body: '',
	            callback: callbackSuccess+'',
	            command:'wxAuthorizationLogin'
	        });
		}

})


</script>
<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>