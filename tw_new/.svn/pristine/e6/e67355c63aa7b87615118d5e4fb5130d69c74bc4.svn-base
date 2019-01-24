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
    <link rel="stylesheet" href="static/style_default/style/boundMobile.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/common.js"></script>
    <script src="static/style_default/script/boundMobile.js"></script>
     <script src="static/style_default/plugin/layer/layer.js?v=4.0"></script>
    <title>绑定手机号码</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <div class="boundMoblie">
        <p class="pjoTitle">
            <a href="javascript:history.go(-1);"><img src="static/style_default/images/kefu_03.png" alt=""/></a>
            <span>绑定手机号</span>
        </p>
        <div class="container">
            <form action="user_phone" method="post">
                <ul>
                    <li class="userPhone">
                        <input type="text" name="user_phone" id="user_phone" placeholder="请输入手机号"/>
                    </li>
                    <li class="userCode">
                        <input type="text" name="user_code" id="contact_code" placeholder="验证码"/><input value="发送验证码" type="button" id="codeBtn" class="removeBtn">
                    </li>
                </ul>
                <input type="button" value="确定" id="mobileSub"/>
            </form>
        </div>
    </div>

    <!-- 提示层 -->
    <div class="tips"></div>
</body>
</html>
<script type="text/javascript">
    $("#mobileSub").click(function(){
            $.post("user_phone",$("form").serialize(),function(res){
                // layer.msg(res.msg); 
                if(res.code==200){
                    layer.msg(res.msg,{
                          offset:['50%'],
                          time: 1000 //2秒关闭（如果不配置，默认是3秒）
                    },function(){
                       window.location.replace("user_update");
                    }); 
             
                }else{
                    layer.msg(res.msg); 
                }
            },"json");
    });
</script>
