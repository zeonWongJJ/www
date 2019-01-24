<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>登录、注册</title>
        <link rel="stylesheet" type="text/css" href="style/Login.css" />
        <script src="js/jquery-1.8.2.min.js"></script>
        <script src="js/shipei.js"></script>
        <script src="js/Login.js"></script>
    </head>
    <body>
    <!--5.个性注册-->
        <section class="page" id="personality">
            <div class="onekey">
                <div class="onekey_01">
                    <span>已有账号</span>
                </div>
                <!-- <form action="register_auth" method ="post"> -->
                <div class="onekey_02 kidney_02">
                    <div class="kidney">
                        <i>一键注册</i>
                        <p>
                            <em>个性注册</em>
                            <span></span>
                        </p>
                        <div class="clearfix"></div>
                    </div>
                    <div class="kidney_register">
                        <ul class="kidney_register_list">
                            <li>
                                <input type="text" id="user" value="" />
                                <img src="image/zuce.jpg" alt="" />
                            </li>
                            <li>
                                <input type="password" id="pw" value="" />
                                <img src="image/mima.jpg" alt="" />
                            </li>
                        </ul>
                        <div class="add_most">
                            <ul class="kidney_register_list">
                                <li>
                                    <input type="text" id="phone" placeholder="手机号，可不填" value="" />
                                    <img src="image/shouji.jpg" alt="" />
                                </li>
                                <li>
                                    <input type="text" id="email" placeholder="邮箱，可不填" value="" />
                                    <img src="image/em.jpg" alt="" />
                                </li>
                            </ul>
                            <p>取消</p>
                        </div>
                        <div class="kidney_register_add">
                            <p>
                                <span>填写手机</span>
                                <img src="image/tianjia.jpg" alt="" />
                            </p>
                            <p>嘛嘛再也不用怕我忘记密码了！</p>
                        </div>
                    </div>
                </div>
                <input class="Login_04" type="submit" value="注册" onclick="register_auth()">
                <!-- </form> -->
            </div>
        </section>
        <!--1.一键注册-->
        <section class="page" id="registration">
            <div class="onekey">
                <div class="onekey_01">
                    <span>已有账号</span>
                </div>
                <div class="onekey_02">
                    <div class="onekey_02_float">
                        <p>
                            <em>一键注册</em>
                            <span></span>
                        </p>
                        <i>个性注册</i>
                        <div class="clearfix"></div>
                    </div>
                    <p class="onekey_02_btn" onclick="to_register()">一键注册</p>
                    <p class="onekey_02_footer">
                        <img src="image/chuangjian.jpg" alt="" />
                        <span>一键注册将为您自动创建账号</span>
                    </p>
                </div>
            </div>
        </section>
        <!--2.注册成功-->
        <section class="page" id="succeed">
            <div class="onekey">
                <div class="onekey_01">
                    <span>已有账号</span>
                </div>
                <!-- <form action="login_auth" method ="post"> -->
                <div class="onekey_02">
                    <div class="success">
                        <p>
                            <em>注册成功</em>
                            <span></span>
                        </p>
                        <div class="number">
                         <!-- <input type="text" id='name' name="username" />
                         <input type="password" id='i_randpwd' name="passwd" /> -->
                            <p>账号&nbsp;:<span id='user_name'></span></p>
                            <p>密码&nbsp;:<span id='randpwd'></span></p>
                        </div>
                        <div class="success_btn">
                            <span onclick="to_mobli()">发送到我手机</span>
                            <img src="image/success.jpg" alt="" />
                        </div>
                    </div>
                </div>
                <div class="Login">
                    <span onclick="login()">自动登录</span>
                </div>
            </div>
        </section>
        <!--6.验证码登录-->
        <section class="page" id="test">
            <div class="outermost">
                <div class="identifying">
                    <!-- <form action="login_code" method ="post"> -->
                    <div class="identifying_01">
                        <div class="identifying_01_float">
                            <p>
                                <em>验证码登录</em>
                                <span></span>
                            </p>
                            <i>密码登录</i>
                            <div class="clearfix"></div>
                        </div>
                        <div class="identifying_01_code">
                            <ul class="identifying_01_list">
                                <li>
                                    <input type="text" id="btn1" placeholder="" name="mobile" value="" />
                                    <img src="image/shouji.jpg" alt="" />
                                </li>
                                <li>
                                    <input type="text" placeholder="验证码" id="btn2" name="verify" value="" />
                                    <span class="identifying_btn1" id="btn3">获取验证码</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="identifying_02">
                        <span>注册账号</span>
                    </div>
                </div>
                    <input class="Login_04" type="submit" value="登录" onclick="login_code()">
                <!-- </form> -->
                <div class="Login_ways">
                    <div class="Login_ways_line">
                        <p></p>
                        <span>其他方式登录</span>
                        <p></p>
                        <div class="clearfix"></div>
                    </div>
                    <div class="Login_ways_image">
                        <img src="image/QQ.jpg" alt="" onclick='window.open("<?php echo $this->router->url('qq_index');?>","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");'/>
                    </div>
                </div>
            </div>
        </section>
        <!--7.密码登录-->
         <section class="page" id="cryptogram">
            <div class="outermost">
                <div class="identifying">
                    <div class="identifying_01 minus">
                        <div class="identifying_01_float" id="passw">
                            <i class="verify">验证码登录</i>
                            <p>
                                <em>密码登录</em>
                                <span></span>
                            </p>
                            <div class="clearfix"></div>
                        </div>
                        <div class="identifying_01_code">
                            <ul class="identifying_01_list">
                                <li>
                                    <input type="text" id="btn4" placeholder="手机号/用户名"  value="" />
                                    <img src="image/xiala_03.jpg" class="oImage" alt="" />
                                </li>
                                <li>
                                    <input type="password" placeholder="登录密码" id="btn5" name="passwd" value="" />
                                    <img src="image/mima.jpg" alt="" />
                                </li>
                            </ul>
                            <div class="xiala username">
                                <p></p>                
                            </div>
                        </div>
                        <p class="identifying_01_forget">忘记密码？</p>
                    </div>
                    <div class="identifying_02">
                        <span>注册账号</span>
                    </div>
                </div>
                    <input class="Login_04" type="submit" value="登录" onclick="login_user()">
                <div class="Login_ways">
                    <div class="Login_ways_line">
                        <p></p>
                        <span>其他方式登录</span>
                        <p></p>
                        <div class="clearfix"></div>
                    </div>
                    <div class="Login_ways_image">
                        <img src="image/QQ.jpg" alt="" onclick='window.open("<?php echo $this->router->url('qq_index');?>","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");'/>
                    </div>
                </div>
            </div>
        </section>
        <!--8.重置密码-->
        <section class="page" id="resetting">
            <div class="outermost">
                <div class="identifying">
                    <div class="identifying_01 minus">
                        <div class="identifying_01_float">
                            <p>
                                <em>重置密码</em>
                                <span></span>
                            </p>
                        </div>
                        <!-- <form action="verify_res" method="post"> -->
                        <div class="identifying_01_code">
                            <ul class="identifying_01_list">
                                <li>
                                    <input type="text" id="spot" placeholder="手机号" name="mobile" value="" />
                                    <img src="image/shouji.jpg" alt="" />
                                </li>
                                <li>
                                    <input type="text" placeholder="验证码" id="spot_01" name="verifyName" value="" />
                                    <span class="identifying_btn1" id="spot_02">获取验证码</span>
                                </li>
                                <li>
                                    <input type="password" placeholder="新密码" id="spot_03" name="passwd" value="" />
                                    <img src="image/mima.jpg" alt="" />
                                </li>
                            </ul>
                        </div>
                        <p class="cancle">取消</p>
                    </div>
                    <div class="identifying_02">
                        <span>注册账号</span>
                    </div>
                </div>
                <input class="Login_04" type="submit" value="登录" onclick="verify_res()">
                <!-- </form> -->
                <div class="Login_ways max">
                    <div class="Login_ways_line">
                        <p></p>
                        <span>其他方式登录</span>
                        <p></p>
                        <div class="clearfix"></div>
                    </div>
                    <div class="Login_ways_image">
                        <img src="image/QQ.jpg" alt="" onclick='window.open("<?php echo $this->router->url('qq_index');?>","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");'/>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
<script>
    function to_register() {
        $.ajax({
            url: '<?php echo $this->router->url('key_register'); ?>',
            type: 'post',
            dataType: 'json',
            success: function(data) {
                $('#user_name').html(data.code);
                $('#randpwd').html(data.msg);
            }
        });
    }
    //点击发送账号密码触发
    function to_mobli() {
        var name = $('#user_name').text();
        var randpwd = $('#randpwd').text();
        location.href = 'protocolhead://WHCMobileVC_?123';
        $('.user_name').html(name);
        $('.randpwd').html(randpwd);
        
    }
    function mobli() {
        var name = $('.user_name').text();
        $('#usename').html(name);
    }
    //账号和密码
    function login_user() {
        var name = $('#btn4').attr('value');
        var randpwd = $('#btn5').attr('value');
        location.href = 'protocolhead://WHCMobileVC_?123';
        $.ajax({
            type : "POST",
            url : '<?php echo $this->router->url('login_auth');?>',
            data : {username:name,passwd:randpwd},
            dataType : 'json',
            success : function(data) {
              if (data.code == 23) {
                alert('请填写用户名和密码！');
              } else if (data.code == 24) {
                alert('登录失败！');
              } else if (data.code == 25) {
                window.location.href ='<?php echo $this->router->url('index');?>';
              } else if (data.code == 26) {
                alert('用户密码错误,请尝试重新登录');
              };                                
            }
        })
    }
    //点击账号密码登录
    function login_username() {
        var name = $('.name').text();
        var randpwd = $('.pwd').text();
        $.ajax({
            type : "POST",
            url : '<?php echo $this->router->url('login_auth');?>',
            data : {username:name,passwd:randpwd},
            dataType : 'json',
            success : function(data) {
              if (data.code == 23) {
                alert('请填写用户名和密码！');
              } else if (data.code == 24) {
                alert('登录失败！');
              } else if (data.code == 25) {
                window.location.href ='<?php echo $this->router->url('index');?>';
              } else if (data.code == 26) {
                alert('用户密码错误,请尝试重新登录');
              };                                
            }
        })
    }
    //找回密码
    function verify_res() {
        var mobile = $("#spot").attr('value');
        var verifyName = $("#spot_01").attr('value');
        var passwd = $("#spot_03").attr('value');
        $.ajax({
            type : "POST",
            url : '<?php echo $this->router->url('verify_res');?>',
            data : {verifyName:verifyName,passwd:passwd,mobile:mobile},
            dataType : 'json',
            success : function(data) {
              if (data == 31) {
                alert('手机号有误！');
              } else if (data == 32) {
                alert('密码不能为空！');
              } else if (data == 34) {
                alert('验证码不能为空！');
              } else if (data == 38) {
                alert('验证码错误！');
              } else if (data == 33) {
                alert('重置失败,请尝试！');
              } else if (data == 35) {
                window.location.href ='<?php echo $this->router->url('index');?>';
              };                
            }
        })
    }
    //验证登录
    function login_code() {
        var mobile = $("#btn1").attr('value');
        var verify = $("#btn2").attr('value');
        $.ajax({
            type : "POST",
            url : '<?php echo $this->router->url('login_code');?>',
            data : {verify:verify,mobile:mobile},
            dataType : 'json',
            success : function(data) {
              if (data == 38) {
                alert('验证码不正确！');
              } else if (data == 52) {
                alert('手机号有误！');
              } else if (data == 53) {
                alert('验证码不能为空！');
              } else if (data == 51) {
                window.location.href ='<?php echo $this->router->url('index');?>';
              };                
            }
        })
    }
    //注册登录
    function login() {
        var name = $('#user_name').text();
        var randpwd = $('#randpwd').text();
        $.ajax({
            type : "POST",
            url : '<?php echo $this->router->url('login_auth');?>',
            data : {username:name,passwd:randpwd},
            dataType : 'json',
            success : function(data) {
              if (data == 23) {
                alert('请填写用户名和密码！');
              } else if (data == 24) {
                alert('登录失败！');
              } else if (data == 25) {
                window.location.href ='<?php echo $this->router->url('index');?>';
              } else if (data == 26) {
                alert('用户密码错误,请尝试重新登录');
              };                 
            }
        })
    }
    //个性注册
    function register_auth() {
        var name = $('#user').attr('value');
        var pw = $('#pw').attr('value');
        var phone = $('#phone').attr('value');
        var email = $('#email').attr('value');
        $.ajax({
            type : "POST",
            url : '<?php echo $this->router->url('register_auth');?>',
            data : {username:name,passwd:pw,mobile:phone,email:email},
            dataType : 'json',
            success : function(data) {
              if (data == 41) {
                alert('用户名太短！');
              } else if (data == 42) {
                alert('用户名太长！');
              } else if (data == 43) {
                alert('密码太短！');
              } else if (data == 44) {
                alert('请填写正确的邮箱！');
              } else if (data == 45) {
                alert('邮箱已经注册，请尝试登录或找回密码！');
              } else if (data == 46) {
                alert('请填写正确的手机！');
              } else if (data == 49) {
                alert('注册成功！');
                $('#cryptogram').css('display','block').siblings().css('display','none')
              } else if (data == 48) {
                alert('用户名已经存在！');
              } else if (data == 47) {
                alert('手机已经注册，请尝试登录或找回密码！');
              } else if (data == 50) {
                alert('注册失败，请重试或联系客服！');
              };                 
            }
        })
    }
</script>
