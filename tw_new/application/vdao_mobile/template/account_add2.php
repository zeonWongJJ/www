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
            <span>绑定支付宝</span>
        </p>
        <!-- 表单 -->
        <div class="formContainer">
            <form action="account_add" method="post">
            	<input type="hidden" name="type" value="<?php echo $this->router->get(1); ?>">
                <dl>
                    <dt>请仔细核对您的支付宝账号，以确保能准确成功提现</dt>
                    <dd>
                        <span>姓名</span>
                        <input type="text" name="alipay_realname" placeholder="请输入收款人姓名"/>
                    </dd>
                    <dd>
                        <span>提现账号</span>
                        <input type="text" name="alipay_number" placeholder="请输入支付宝账号"/>
                    </dd>
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
	var alipay_realname = $("input[name='alipay_realname']").val();
	var alipay_number   = $("input[name='alipay_number']").val();
	if (alipay_realname != '' && alipay_number != '') {
		// 发送ajax请求
		$.ajax({
			url: 'account_add',
			type: 'POST',
			dataType: 'json',
			data: {alipay_realname: alipay_realname, alipay_number:alipay_number, type:2},
			success: function(res) {
				// console.log(res);
				if (res.code == 200) {
					
                    window.location.replace("account_manage");

				}
			}
		})
	}
	return false;
});


</script>