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
    <link rel="stylesheet" href="./static/style_default/style/addDevice.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/plugin/upload_image.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/addDevice.js"></script>
    <title>添加设备</title>
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

        <!-- 添加设备 -->
        <div class="addDevice">
            <p><a href="room_showlist" style="color:#000;">房间管理</a> > <a href="device_showlist" style="color:#000;">设备列表</a> > 添加设备</p>
            <div class="addDeviceTitle">
                <span>添加设备</span>
            </div>
        </div>
        <div class="deviceList">
            <form action="device_add" method="post">
                <ul>
                    <li class="deviceName">
                        <em><s>*</s>设备名称</em>
                        <input type="text" id="device_name" name="device_name" placeholder="输入14字符/汉字"/>
                        <span class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <em></em>
                        </span>
                    </li>
                    <li class="deviceNum">
                        <em><s>*</s>设备型号</em>
                        <input type="text" id="device_num" name="device_version" placeholder="输入14字符/汉字"/>
                         <span class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <em></em>
                        </span>
                    </li>
                    <input type="hidden" name="device_state" value="1">
                    <li class="deviceDisplay">
                        <em><s>*</s>是否开放</em>
                        <em class="sure" style="width:50px; text-align:left;" value='1'>
                            <img  src="./static/style_default/image/pro_38.png" />
                            <span>是</span>
                        </em>
                        <em  class="deny" style="width:50px; text-align:left;" value='0'>
                            <img src="./static/style_default/image/pro_38.png" />
                            <span>否</span>
                        </em>
                         <span class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <em></em>
                        </span>
                    </li>
                    <li class="mainFigure">
                        <em>设备图片</em>
                        <div class="figureContent">
                            <div id="maxbox">
                                <input type="file" name="mypic" id="mypic" multiple="multiple" onchange="upload_preview()" />
                                <div id="picbox"></div>
                            </div>
                            <div id="choose_box" onclick="javascript:document.getElementById('mypic').click();">选择图片</div>
                            <div id="upload_box" onclick="upload_now()">上传图片</div>
                            <input type="hidden" name="mainpic_path">
                            <input type="hidden" name="otherpic_path">
                            <span>请至少上传一张产品图片；支持jpg/png格式，单张（长&lt;xxx，宽&lt;xxx，大小<1M），
最多支持10张图片，将按上传顺序展示图片，支持批量上传。</span>
                        </div>
                    </li>
                    <li class="deviceDescribe">
                        <em>设备描述</em>
                        <textarea name="device_description" id="describe" cols="30" rows="10"></textarea>
                    </li>
                </ul>
                <input type="submit" value="确定发布" id="deviceSub"/>
            </form>

        </div>
        <!-- 添加设备 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>

<script type="text/javascript">

var file_arr      = new Array(); // 用于保存文件信息
var mainpic_imgid = 0; // 主图的图片id 默认第一张图片为主图
var max_count     = 10; // 允许上传最大文件数
var max_size      = 1048576; // 单个文件允许上传的最大值 1024*1024=1M
var max_allsize   = 10485760; // 允许上传的文件总大小 10M
var upload_url    = 'image_upload'; // 上传的服务器地址
var delete_url    = 'devicetem_delete'; // 删除服务上图片的地址
var input_name    = 'file'; // 后台接收时的表单name值
var module_name   = 'device'; // 服务器上存放图片的模块文件夹
var upload_accept = new Array('image/jpeg', 'image/png','image/gif'); // 允许上传的格式

</script>