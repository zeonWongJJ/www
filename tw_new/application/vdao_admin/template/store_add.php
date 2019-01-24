<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="keywords" content="HTML,ASP,PHP,SQL">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=6" ><!-- 使用IE6 -->
    <meta http-equiv="X-UA-Compatible" content="IE=7" ><!-- 使用IE7 -->
    <meta http-equiv="X-UA-Compatible" content="IE=8" ><!-- 使用IE8 -->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="./static/style_default/style/common.css"/>
    <link rel="stylesheet" href="./static/style_default/style/public.css"/>
    <link rel="stylesheet" href="./static/style_default/style/addStore.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <link rel="stylesheet" type="text/css" href="./static/style_default/diyUpload/css/webuploader.css">
    <link rel="stylesheet" type="text/css" href="./static/style_default/diyUpload/css/diyUpload.css">
    <script type="text/javascript" src="./static/style_default/diyUpload/js/webuploader.html5only.min.js"></script>
    <script type="text/javascript" src="./static/style_default/diyUpload/js/diyUpload.js"></script>
    <script src="./static/style_default/script/addStore.js"></script>
    <title></title>
</head>
<body style="background:#efefef;">
<!--  后台管理 -->

        <!-- 门店管理 -->
        <div class="storeManagers">
            <!-- 添加门店 -->
            <div class="addStore">
                <div class="addStoreTitle">
                    <span>添加门店</span>
                </div>
                <form action="">
                    <ul>
                        <li class="storeName">
                            <span>门店名称</span>
                            <input type="text" id="store_name"/>
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="storeAbled">
                            <span>启用/暂用</span>
                            <em class="enabled">
                                <img  src="./static/style_default/image/pro_38.png" /> 启用
                            </em>
                            <em  class="disabled">
                                <img src="./static/style_default/image/pro_38.png" /> 暂用
                            </em>
                            <img class="hide" style="vertical-align:middle;" src="./static/style_default/image/t_03.png" />
                        </li>
                        <li class="storeAddress">
                            <span>门店地址</span>
                            <input type="text" id="store_address"/>
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="storeNum">
                            <span>门店账号</span>
                            <input type="text" id="store_Num"/>
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="storePwd">
                            <span>门店密码</span>
                            <input type="password" id="store_pwd"/>
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="storeRePwd">
                            <span>确认密码</span>
                            <input type="password" id="store_rePwd"/>
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="storeContact">
                            <span>联系人</span>
                            <input type="text" id="store_contact"/>
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="storePhone">
                            <span>联系方式</span>
                            <input type="text" id="store_phone"/>
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="storeLicense">
                            <span>营业执照</span>
                            <div id="upPic" style="width:570px;">
                                <div id="picBox" ></div>
                            </div>
                        </li>
                    </ul>
                    <!--<input type="submit" id="storeSub" value="确定"/>-->
                </form>
                <span id="storeSub">确定修改</span>
            </div>
            <!-- 添加门店 -->
        </div>
        <!-- 门店管理 -->


<!--  后台管理 -->
</body>
</html>