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
    <script src="./static/style_default/plugin/upload_image.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/updateStore.js"></script>
    <title>修改门店</title>
</head>
<body style="background:#efefef;">
<!--  后台管理 -->
<div class="productClassification">
    <?php echo $this->display('header'); ?>
    <!--  右侧内容 -->
    <article>
        <!--  标题 -->
        <?php echo $this->display('top'); ?>
        <!--  标题 -->

        <!-- 添加门店 -->
        <div class="addStore">
            <p>修改门店</p>
            <div class="fromBox">
                <form action="store_update" method="post">
                    <input type="hidden" name="manager_name_old" value="<?php echo $a_view_data['manager']['manager_name']; ?>" />
                    <input type="hidden" id="record_id" name="store_id" value="<?php echo $a_view_data['store']['store_id']; ?>">
                    <input type="hidden" name="manager_id" value="<?php echo $a_view_data['manager']['manager_id']; ?>">
                    <ul>
                        <li class="addStoreName">
                            <span>门店名称</span>
                            <input type="text" name="store_name" id="addStore_name" value="<?php echo $a_view_data['store']['store_name']; ?>" />
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <input type="hidden" name="store_state" value="<?php echo $a_view_data['store']['store_state']; ?>">
                        <li class="addStoreAbled">
                            <span>启用/暂用</span>
                            <em class="enabled" value="1">
                                <?php if ($a_view_data['store']['store_state'] == 1) {
                                    echo '<img src="./static/style_default/image/pro_36.png" />';
                                } else {
                                    echo '<img  src="./static/style_default/image/pro_38.png" />';
                                } ?>
                                <span>启用</span>
                            </em>
                            <em  class="disabled" value="2">
                                <?php if ($a_view_data['store']['store_state'] == 2) {
                                    echo '<img src="./static/style_default/image/pro_36.png" />';
                                } else {
                                    echo '<img  src="./static/style_default/image/pro_38.png" />';
                                } ?>
                                <span>暂用</span>
                            </em>
                            <img class="hide" style="vertical-align:middle;" src="./static/style_default/image/t_03.png" />
                        </li>
                        <li class="addStoreAddress">
                            <span>门店地址</span>
                            <input type="text" name="store_address" value="<?php echo $a_view_data['store']['store_address']; ?>" id="addStore_address"/>
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="addPassengerID">
                            <span>客流openID</span>
                            <input type="text" name="passenger_openid" id="addStore_address" value="<?php echo $a_view_data['store']['passenger_openid']; ?>" />
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="addDistributionID">
                            <span>配送门店ID</span>
                            <input type="text" name="transport_id" id="addStore_address" value="<?php echo $a_view_data['store']['transport_id']; ?>" />
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="addStoreNum">
                            <span>门店账号</span>
                            <input type="text" name="manager_name" value="<?php echo $a_view_data['manager']['manager_name']; ?>" id="addStore_Num"/>
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="addStorePwd">
                            <span>门店密码</span>
                            <input type="password" name="manager_password" id="addStore_pwd" placeholder="不填表示不修改" />
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="addStoreRePwd">
                            <span>确认密码</span>
                            <input type="password" name="manager_password2" id="addStore_rePwd" placeholder="不填表示不修改" />
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="addStoreContact">
                            <span>联系人</span>
                            <input type="text" name="store_linkman" value="<?php echo $a_view_data['store']['store_linkman']; ?>" id="addStore_contact"/>
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="addStorePhone">
                            <span>联系方式</span>
                            <input type="text" name="store_contact" value="<?php echo $a_view_data['store']['store_contact']; ?>" id="addStore_phone"/>
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="editStoreLicense">
                            <span>营业执照</span>
                            <div class="figureContent">
                                <div id="maxbox">
                                    <input type="file" name="mypic" id="mypic" multiple="multiple" onchange="upload_preview()" />
                                    <div id="picbox"></div>
                                </div>
                                <div id="choose_box" onclick="javascript:document.getElementById('mypic').click();">选择图片</div>
                                <div id="upload_box" onclick="upload_now()">上传图片</div>
                                <input type="hidden" name="mainpic_path">
                                <input type="hidden" name="otherpic_path" value="<?php echo $a_view_data['store']['store_licence']; ?>">
                            <span>请至少上传一张产品图片；支持jpg/png格式，单张（长&lt;xxx，宽&lt;xxx，大小<1M），
最多支持1张图片，将按上传顺序展示图片，支持批量上传。</span>
                            </div>
                        </li>
                    </ul>
                    <input type="submit" id="addStoreSub" value="确定"/>
                </form>
            </div>
        </div>
        <!-- 添加门店 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>

<script type="text/javascript">

var file_arr      = new Array(); // 用于保存文件信息
var mainpic_imgid = 0; // 主图的图片id 默认第一张图片为主图
var max_count     = 1; // 允许上传最大文件数
var max_size      = 1048576; // 单个文件允许上传的最大值 1024*1024=1M
var max_allsize   = 10485760; // 允许上传的文件总大小 10M
var upload_url    = 'image_upload'; // 上传的服务器地址
var delete_url    = 'storetem_delete'; // 删除服务上图片的地址
var input_name    = 'file'; // 后台接收时的表单name值
var module_name   = 'store'; // 服务器上存放图片的模块文件夹
var upload_accept = new Array('image/jpeg', 'image/png','image/gif'); // 允许上传的格式

</script>