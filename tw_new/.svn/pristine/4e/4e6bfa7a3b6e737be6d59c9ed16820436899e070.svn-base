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
    <link rel="stylesheet" href="./static/style_default/style/roomsAddCate.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/roomsAddCate.js"></script>
    <title>添加房间分类</title>
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

        <!-- 添加分类 -->
        <div class="addCate">
            <p><a href="type_showlist" style="color:#000;">房间管理</a> > <a href="type_showlist" style="color:#000;">房间分类</a> > 添加分类</p>
            <div class="cateList">
                <form action="type_add" method="post">
                    <ul>
                        <li class="category">
                            <span>所属分类</span>
                            <select name="pid_lev" id="cateA" onchange="type_par()">
                                <option value="999">请选择上级</option>
                                <option value="999">顶级类型</option>
                                <?php foreach ($a_view_data as $key => $value): ?>
                                    <option value="<?php echo $value['type_id'] . '-' .$value['type_level']; ?>"><?php echo str_repeat('└―',$value['type_level']) . $value['type_name']; ?></option>
                                <?php endforeach ?>
                            </select>
                            <em class="cateTip hide">
                                <img src="./static/style_default/image/f_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="category">
                            <span>分类用途</span>
                            <select name="type_cate1" id="typecate" onchange="change_cate()">
                                <option value="1">&nbsp;&nbsp;&nbsp;会议&nbsp;&nbsp;&nbsp;</option>
                                <option value="2">&nbsp;&nbsp;&nbsp;餐厅&nbsp;&nbsp;&nbsp;</option>
                            </select>
                        </li>
                        <input type="hidden" name="type_cate" value="1">
                        <input type="hidden" name="type_state" value="1">
                        <li class="openClose">
                            <span>是否开放</span>
                            <em class="sure" value='1'>
                                <img src="./static/style_default/image/pro_38.png" />
                                <span>是</span>
                            </em>
                            <em class="deny" value='0'>
                                <img src="./static/style_default/image/pro_38.png" />
                                <span>否</span>
                            </em>
                            <em class="cateTip hide">
                                <img src="./static/style_default/image/f_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="addCateName">
                            <span>分类名称</span>
                            <input type="text" name="type_name" id="add_cateName" placeholder="请输入14个字符/汉字"/>
                            <em class="cateTip hide">
                                <img src="./static/style_default/image/f_03.png" />
                                <span></span>
                            </em>
                        </li>
                        <li class="cateDescribe">
                            <span>分类描述</span>
                            <textarea style="vertical-align:top" name="type_description" id="cateText" cols="30" rows="10"></textarea>
                            <span style="position:absolute; bottom:3px; left:358px; font-size:12px;"><s id="cateNum">200</s>/200</span>
                            <em class="cateTip hide">
                                <img src="./static/style_default/image/f_03.png" />
                                <span></span>
                            </em>
                        </li>
                    </ul>
                    <input type="submit" id="cateSub" value="确定"/>
                </form>
            </div>
        </div>
        <!-- 添加分类 -->


        <!--  重要提示 -->
        <div class="tips1 hide">
            <em>重要提示</em>
            <img src="./static/style_default/image/pro_19.png" />
            <p>
                <span>▪ 确认删除这一部分分类吗？</span>
                <span>▪ 删除后不可恢复，所删除分类下的所有产品也将被删除</span>
            </p>
            <div class="tipsBtn">
                <em>确定</em>
                <a>再看看</a>
            </div>

        </div>
        <!--  重要提示 -->
    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>

<script>

function type_par() {
    var type_str = $("#cateA").val();
    if (type_str != '999') {
        var type_id = type_str.split('-')[0];
        $.ajax({
            url: 'type_cate',
            type: 'POST',
            dataType: 'json',
            data: {type_id: type_id},
            success: function (res) {
                console.log(res);
                if (res.code == 200) {
                    $("#typecate").val(res.data.type_cate);
                    $("#typecate").attr('disabled', 'disabled');
                    $("input[name='type_cate']").val(res.data.type_cate);
                }
            }
        })
    } else {
        $("#typecate").removeAttr('disabled');
    }
}

function change_cate() {
    var cate = $("#typecate").val();
    $("input[name='type_cate']").val(cate);
}

</script>