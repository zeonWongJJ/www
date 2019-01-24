<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <title>个人信息</title>
    <link rel="stylesheet" type="text/css" href="static/style_default/style/common.css" />
    <script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
    <script src="static/style_default/plugin/rem.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
        .body {
            position: relative;
            height: 100%;
            font-size: 0.16rem;
        }

        .box {
            background: #f7f7f7;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            height: 100%;
            overflow: auto;
        }

        .kg {
            height: .1rem;
            width: 100%;
            background: #f7f7f7;
        }

        .head {
            height: 0.44rem;
            display: flex;
            justify-content: space-between;
            padding: 0 .15rem;
            font-size: .18rem;
            background: #fff;
        }

        .head div {
            line-height: .44rem;
            color: #000000;
        }

        .head .left {
            flex: 0 0 .1rem;
            background: url(static/style_default/images/back.png) no-repeat;
            background-size: .1rem .18rem;
            background-position: center;
        }

        .content .item {
            padding: .15rem;
            background: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content .item+.item {
            border-top: 1px solid #eeeeee;
        }

        .content .item.nameBox .input {
            flex: 1;
            padding: 0 .1rem;
            display: block;
           
        }
		.content .item.nameBox .input>input{
			 font-size:0.14rem;
		}
        /*发送验证码按钮*/
        .send_code {
            border: 1px solid #ff6633;
            border-radius: 4px;
            padding: 0.097em 0.197em;
            font-size: 0.14rem;
            color: #ff6633;
        }

        .content .item .img {
            height: .525rem;
            width: .525rem;
            border-radius: 50%;
            overflow: hidden;
        }

        .content .item .img>img {
            width: 100%;
            height: 100%;
        }

        /*按钮*/
        .content .btn {
            background: #ff6633;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        .bg_gray {
            background: rgba(0, 0, 0, .4);
            font-size: 0.14rem;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            display: none;
            flex-direction: column-reverse;
            align-items: center;
        }

        .bg_gray .select {
            display: none;
        }

        .bg_gray .select>div {
            background: #fff;
            text-align: center;
            width: 3.45rem;
            border-radius: .05rem;
            font-size: .16rem;
        }

        .bg_gray .select .type>div {
            height: .55rem;
            line-height: .55rem;
        }

        .bg_gray .select .type>div+div {
            border-top: 1px solid rgba(0, 0, 0, .4);
        }

        .bg_gray .cancel {
            margin-top: .15rem;
            height: .55rem;
            line-height: .55rem;
        }
        .send_code span{
        	font-size:0.16rem;
        }
    </style>
</head>

<body>
<!--办公室订单-->
<div class="body">
    <div class="box">
        <div class="head">
            <div class="left" onclick="window.history.go(-1)"></div>
            <div>个人信息</div>
            <div></div>
        </div>
        <div class="kg"></div>
        <div class="content">
            <div class="item nameBox">
                <div>手机号</div>
                <div class="input">
                    <input type="text" value="13800138000" name="user_phone" id="user_phone">
                </div>
            </div>
            <div class="item nameBox">
                <div>验证码</div>
                <div class="input">
                    <input type="text"  onkeyup="this.value=this.value.replace(/\D/g,'')" value="" placeholder="请输入验证码" name="verfiy_code" id="verfiy_code">
                </div>
                <div class="send_code" onclick="send_code()">
                    <span>发送验证码</span>
                </div>
            </div>
            <div class="item nameBox">
                <div>密码</div>
                <div class="input">
                    <input type="password" value="" placeholder="请输入新的登录密码" name="user_password">
                </div>
            </div>
            <!-- 确定按钮 -->
            <div class="btn" id="main-btn">确定</div>
        </div>
    </div>
</div>
</body>

</html>
<script type="text/javascript">
    /**
     * 发送验证码
     */
    function send_code () {
        if (check_phone_number()) {
            alert('发送验证码')
        } else {
            alert('手机号码格式不对')
        }
    }

    /**
     * 手机号码验证
     */
    function check_phone_number() {
        //手机号正则
        var phoneReg = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;
        //电话
        var phone = $.trim($('#user_phone').val());
        return phoneReg.test(phone);
    }

    /**
     * 检测验证码是否合法
     */
    function check_code()
    {
        var codeReg = /([0-9]{4})/;
        var code = $.trim($('#verfiy_code').val());
        return codeReg.test(code);
    }

    $(function() {
        $('#main-btn').click(function () {
            if (check_phone_number() && check_code()) {
                alert('ajax提交修改请求')
            }
        });
    })
</script>