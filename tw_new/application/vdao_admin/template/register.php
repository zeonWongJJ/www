<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>用户注册</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="./style/font.css">
	<link rel="stylesheet" href="./style/xadmin.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/Swiper/3.4.2/css/swiper.min.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/Swiper/3.4.2/js/swiper.jquery.min.js"></script>
    <script src="./lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="./script/xadmin.js"></script>

</head>
<body>
    <!--<div class="register-logo"><h1>X-ADMIN V1.1</h1></div>-->
    <div class="register-box">
        <form class="layui-form layui-form-pane" action="<?php echo $a_view_data['register']; ?>" method='post'>
              
            <h3>注册你的帐号</h3>

                <div class="layui-form-item">
                    <label for="L_username" class="layui-form-label">
                        <span class="x-red">*</span>用户名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_username" name="username" required="" lay-verify="nikename"
                        autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>将会成为您唯一的登入名
                    </div>                    
                </div>
                <div class="layui-form-item">
                    <label for="L_mobile" class="layui-form-label">
                        <span class="x-red">*</span>手机
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_mobile" name="mobile" required="" lay-verify="mobile"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>    
                <div class="layui-form-item">
                    <label for="L_mobile" class="layui-form-label">
                        <span class="x-red">*</span>验证码
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_authcode" name="authcode" required="" lay-verify="mobile"
                        autocomplete="off" class="layui-input" placeholder="请输入验证码">
                        <i><img src="images/border.png" alt=""/></i>
                        <a class="getCode" onclick="get_code(2)">获取验证码</a>
                        <b class="codeTime hide">2s</b>
                        <em class="hide" onclick="get_code(2)">重新获取</em>
                    </div>
                </div>                    
                <div class="layui-form-item">
                    <label for="L_email" class="layui-form-label">
                        <span class="x-red">*</span>邮箱
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_email" name="email" required="" lay-verify="email"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>   
                <div class="layui-form-item">
                    <label for="L_gender" class="layui-form-label">
                        <span class="x-red">*</span>性别
                    </label>
                    <div class="layui-input-inline">
                        <select id="L_gender" name="gender" required="" lay-verify="gender"  class="layui-select">
                            <option value="1">男</option>
                            <option value="2">女</option>
                        </select>        
                    </div>
                </div>                                           
                <div class="layui-form-item">
                    <label for="L_pass" class="layui-form-label">
                        <span class="x-red">*</span>密码
                    </label>
                    <div class="layui-input-inline">
                        <input type="password" id="L_pass" name="pass" required="" lay-verify="pass"
                        autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        6到16个字符
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">
                        <span class="x-red">*</span>确认密码
                    </label>
                    <div class="layui-input-inline">
                        <input type="password" id="L_repass" name="repass" required="" lay-verify="repass"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_referee" class="layui-form-label">
                        <span class="x-red"></span>推荐人
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_referee" name="referee" required="" lay-verify="referee"
                        autocomplete="off" class="layui-input">
                    </div>                   
                </div>                
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">
                    </label>
                    <button  class="layui-btn" lay-filter="register" lay-submit="">
                        注册
                    </button>
                </div>            
        </form>
    </div>
	<div class="bg-changer">
        <div class="swiper-container changer-list">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img class="item" src="./images/a.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="./images/b.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="./images/c.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="./images/d.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="./images/e.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="./images/f.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="./images/g.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="./images/h.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="./images/i.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="./images/j.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="./images/k.jpg" alt=""></div>
                <div class="swiper-slide"><span class="reset">初始化</span></div>
            </div>
        </div>
        <div class="bg-out"></div>
        <div id="changer-set"><i class="iconfont">&#xe696;</i></div>   
    </div>
    <script>
        $(function  () {
            layui.use('form', function(){
              var form = layui.form();
              //监听提交
              form.on('submit(register)', function(data){
                //layer.msg(JSON.stringify(data.field),function(){
                //    location.href='index.html'
                //});
                return true;
              });
            });
        })

        function get_code(type){
            if (type==1) {
                var mobile = $('#check_userPhone').val();
            } else {
                var mobile = $('#L_mobile').val();
            }
            $.ajax({
                url: '<?php echo $this->router->url('send_code'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {'mobile': mobile},
                error: function(XMLHttpRequest, textStatus, errorThrown){
                        console.log(XMLHttpRequest.status);
                        //console.log(XMLHttpRequest.readyState);
                        console.log(textStatus);
                    },
                success: function(data)
                    {
                        console.log(data);
                        // 临时的出错提示方法
                        if(data.code != 200) alert(data.msg);
                    }
            })
        }        
    </script>	
</body>
</html>