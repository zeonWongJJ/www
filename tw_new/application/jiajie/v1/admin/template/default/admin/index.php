<?php include_once APPPATH . 'template/default/common/header.php'; ?>
    <body>
    <div class="layui-layout layui-layout-admin">
        <!-- 顶部 -->
        <div class="layui-header header">
            <div class="layui-main">
                <a href="#" class="logo">后台管理</a>
                <!-- 显示/隐藏菜单 -->
                <a href="javascript:;" class="layui-icon layui-icon-shrink-right hideMenu"></a>
                <ul class="layui-nav top_menu">
<!--                    <li class="layui-nav-item showNotice" id="showNotice" pc>-->
<!--                        <a href="javascript:;"><i class="iconfont icon-gonggao"></i><cite>系统公告</cite></a>-->
<!--                    </li>-->
<!--                    <li class="layui-nav-item" mobile>-->
<!--                        <a href="javascript:;" class="mobileAddTab" data-url="page/user/changePwd.html"><i-->
<!--                                    class="layui-icon layui-icon-set" data-icon="icon-shezhi1"></i><cite>设置</cite></a>-->
<!--                    </li>-->
                    <li class="layui-nav-item" mobile>
                        <a href="javascript:;" class="page_action" data-type="logout"><i
                                    class="iconfont icon-loginout"></i> 退出</a>
                    </li>
                    <!--                    <li class="layui-nav-item lockcms" pc>-->
                    <!--                        <a href="javascript:;"><i class="iconfont icon-lock1"></i><cite>锁屏</cite></a>-->
                    <!--                    </li>-->
                    <li class="layui-nav-item" pc>
                        <a href="javascript:;">
                            <!--                            <img src="images/face.jpg" class="layui-circle" width="35" height="35">-->
                            <span style="width: 35px; height: 35px;">
                                <i class="layui-icon layui-icon-user"></i>
                            </span>
                            <cite>欢迎登录</cite>
                        </a>
                        <dl class="layui-nav-child">
<!--                            <dd><a href="javascript:;"><i class="layui-icon layui-icon-user"></i><cite>个人资料</cite></a></dd>-->
<!--                            <dd><a href="javascript:;"><i class="layui-icon layer-icon-password"></i><cite>修改密码</cite></a></dd>-->
                            <dd><a href="javascript:;" class="page_action" data-type="logout"><i class="layui-icon layui-icon-release"></i><cite>退出</cite></a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
        </div>
        <!-- 左侧导航 -->
        <div class="layui-side layui-bg-black">
            <div class="navBar layui-side-scroll"></div>
        </div>
        <!-- 右侧内容 -->
        <div class="layui-body layui-form">
            <div class="layui-tab marg0" lay-filter="bodyTab" id="top_tabs_box">
                <ul class="layui-tab-title top_tab" id="top_tabs">
                    <li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>后台首页</cite></li>
                </ul>
                <ul class="layui-nav closeBox">
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="iconfont icon-caozuo"></i> 页面操作</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;" class="refresh refreshThis"><i class="layui-icon">&#x1002;</i>
                                    刷新当前</a></dd>
                            <dd><a href="javascript:;" class="closePageOther"><i class="iconfont icon-prohibit"></i>
                                    关闭其他</a></dd>
                            <dd><a href="javascript:;" class="closePageAll"><i class="iconfont icon-guanbi"></i>
                                    关闭全部</a></dd>
                        </dl>
                    </li>
                </ul>
                <div class="layui-tab-content clildFrame">
                    <div class="layui-tab-item layui-show">
                        <!--                        <iframe src="page/main.html"></iframe>-->
                    </div>
                </div>
            </div>
        </div>
        <!-- 底部 -->
                <div class="layui-footer footer">
                    <p>copyright @2018 柒度信息科技公司</p>
                </div>
    </div>
<?php include_once APPPATH . 'template/default/common/footer.php'; ?>