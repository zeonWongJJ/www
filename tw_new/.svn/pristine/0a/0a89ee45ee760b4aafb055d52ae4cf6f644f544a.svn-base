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
    <link rel="stylesheet" href="./static/style_default/style/releaseRooms.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/plugin/upload_image.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/releaseRooms.js"></script>
    <title>发布房型</title>
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

        <!-- 发布公告 -->
        <div class="releaseRooms">
            <p><a href="room_showlist" style="color:#000;">房间管理</a> > 发布房间</p>
            <div class="releaseRoomsTitle">
                <span>发布房间</span>
            </div>

        </div>
        <div class="roomsList">
            <form action="room_add" method="post">
                <ul>
                    <li class="roomName">
                        <em><s>*</s>房间名称</em>
                        <input type="text" id="room_name" name="room_name" placeholder="输入14字符/汉字"/>
                        <span class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <em></em>
                        </span>
                    </li>
                    <li class="roomCate">
                        <em><s>*</s>产品分类</em>
                        <select name="type_id" id="room_cate_A">
                            <option value="">请选择类型</option>
                        <?php foreach ($a_view_data['type'] as $key => $value): ?>
                            <option value="<?php echo $value['type_id']; ?>"><?php echo str_repeat('└―',$value['type_level']) . $value['type_name']; ?></option>
                        <?php endforeach ?>
                        </select>
                         <span class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <em></em>
                        </span>
                    </li>
                    <input type="hidden" name="room_state" value="1">
                    <li class="roomDisplay">
                        <em><s>*</s>是否开放</em>
                        <em class="sure" style="width:50px; text-align:left;" value="1">
                            <img  src="./static/style_default/image/pro_38.png" />
                            <span>是</span>
                        </em>
                        <em  class="deny" style="width:50px; text-align:left;" value="0">
                            <img src="./static/style_default/image/pro_38.png" />
                            <span>否</span>
                        </em>
                         <span class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <em></em>
                        </span>
                    </li>
                    <li class="roomArea">
                        <em><s>*</s>房间面积</em>
                        <input type="text" id="room_area" name="room_size" onkeypress="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onkeyup="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onblur="if(!this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?|\.\d*?)?$/))this.value=this.o_value;else{if(this.value.match(/^\.\d+$/))this.value=0+this.value;if(this.value.match(/^\.$/))this.value=0;this.o_value=this.value}"/>
                         <span style="color:black;">㎡ </span>
                         <span class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <em></em>
                        </span>
                    </li>
                    <li class="roomSeat">
                        <em><s>*</s>座位</em>
                        <input type="text" id="room_seat" name="room_seat" onkeypress="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onkeyup="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onblur="if(!this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?|\.\d*?)?$/))this.value=this.o_value;else{if(this.value.match(/^\.\d+$/))this.value=0+this.value;if(this.value.match(/^\.$/))this.value=0;this.o_value=this.value}"/>
                        <span style="color:black;">个</span>
                         <span class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <em></em>
                        </span>
                    </li>
                    <li class="roomKeyWord">
                        <em><s>*</s>房间关键字</em>
                        <input type="text" id="key_word" name="room_keywords" placeholder="关键词之间用逗号隔开"/>
                         <span class="hide">
                            <img src="./static/style_default/image/t_03.png" />
                            <em></em>
                        </span>
                    </li>
                    <li class="mainFigure">
                        <em>房间图片</em>
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
                    <input type="hidden" name="device_ids">
                    <li class="roomsDevice">
                        <em>配备设备</em>
                        <div class="deviceBox">
                            <?php foreach ($a_view_data['device'] as $key => $value): ?>
                            <a value="<?php echo $value['device_id']; ?>">
                                <span><?php echo $value['device_name']; ?></span>
                            </a>
                            <?php endforeach ?>
                        </div>
                    </li>
                    <li class="roomsDescribe">
                        <em>房间描述</em>
                        <textarea name="room_description" id="describe" cols="30" rows="10"></textarea>
                    </li>
                </ul>
                <input type="submit" value="确定发布" id="roomsSub"/>
            </form>

        </div>
        <!-- 发布公告 -->

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
var delete_url    = 'roomtem_delete'; // 删除服务上图片的地址
var input_name    = 'file'; // 后台接收时的表单name值
var module_name   = 'room'; // 服务器上存放图片的模块文件夹
var upload_accept = new Array('image/jpeg', 'image/png','image/gif'); // 允许上传的格式

</script>