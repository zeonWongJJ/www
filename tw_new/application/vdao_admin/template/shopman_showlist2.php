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
    <link rel="stylesheet" href="/static/style_default/style/common.css"/>
    <link rel="stylesheet" href="/static/style_default/style/public.css"/>
    <link rel="stylesheet" href="/static/style_default/style/mobileShoper.css"/>
    <script src="/static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="/static/style_default/script/public.js"></script>
    <script src="/static/style_default/script/mobileShoper.js"></script>
    <title>移动店主</title>
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

        <!-- 移动店主 -->
        <div class="mobileShoper">
            <?php if ($a_view_data['type']==1) {
                echo '<p><a href="shopman_showlist" style="color:#000;">移动店主</a> > 全部</p>';
            } else if ($a_view_data['type']==2) {
                echo '<p><a href="shopman_showlist" style="color:#000;">移动店主</a> > 已通过</p>';
            } else if ($a_view_data['type']==3) {
                echo '<p><a href="shopman_showlist" style="color:#000;">移动店主</a> > 待处理</p>';
            } else if ($a_view_data['type']==4) {
                echo '<p><a href="shopman_showlist" style="color:#000;">移动店主</a> > 已拒绝</p>';
            } else if ($a_view_data['type']==5) {
                echo '<p><a href="shopman_showlist" style="color:#000;">移动店主</a> > 已搁置</p>';
            } else if ($a_view_data['type']==6) {
                echo '<p><a href="shopman_showlist" style="color:#000;">移动店主</a> > 搜索</p>';
            } ?>
            <!-- 店主列表 -->
            <div class="Shoper_content">
                <form id="searchform" action="<?php echo $this->router->url('shopman_search'); ?>" method="post">
                    <div class="search_Shoper">
                        <?php if ($a_view_data['type'] == 6) {
                            echo '<input type="text" name="keywords" value="'.$a_view_data['keywords'].'"/>';
                        } else {
                            echo '<input type="text" name="keywords" placeholder="用户名/手机号"/>';
                        } ?>
                        <input type="hidden" name="searchtype" value="1" />
                        <i><img src="/static/style_default/image/s_03.png" onclick="shopman_search()" /></i>
                    </div>
                </form>
            </div>
            <ul class="shoperList">
                <li class="cateHead">
                    <em class="v1" style="text-align:left;">
                        <img src="/static/style_default/image/pro_07.png" />
                        <span style="vertical-align:middle;">全选</span>
                    </em>
                    <em class="v2">性别</em>
                    <em class="v3">手机号码</em>
                    <em class="v4">消费总金额</em>
                    <em class="v5">推荐人数</em>
                    <em class="v6">被推荐人消费总金额</em>
                    <em class="v7">申请时间</em>
                    <em class="v8 stateBox" style="">
                        <span>全部状态</span>
                        <img src="/static/style_default/image/pro_13.png" />
                        <div class="state hide">
                            <a href="<?php echo $this->router->url('shopman_showlist',['type'=>1]); ?>">所有的</a>
                            <a href="<?php echo $this->router->url('shopman_showlist',['type'=>2]); ?>">已通过</a>
                            <a href="<?php echo $this->router->url('shopman_showlist',['type'=>3]); ?>">待处理</a>
                            <a href="<?php echo $this->router->url('shopman_showlist',['type'=>4]); ?>">已拒绝</a>
                            <a href="<?php echo $this->router->url('shopman_showlist',['type'=>5]); ?>">已搁置</a>
                        </div>
                    </em>
                    <em class="v9">操作</em>
                </li>
                <?php foreach ($a_view_data['user'] as $key => $value): ?>
                <li class="cateBody" id="<?php echo "tr_" . $value['user_id']; ?>">
                    <em class="v1" style="text-align:left;">
                        <img src="/static/style_default/image/pro_07.png" value="<?php echo $value['user_id']; ?>" />
                        <div class="shoperInfo">
                            <?php if (empty($value['user_pic'])) {
                                echo '<img src="./static/style_default/image/tt_03.png" />';
                            } else if(strpos($value['user_pic'], 'http') === false) {
                                echo '<img src="'.get_config_item('vdao_mobile').$value['user_pic'].'" />';
                            } else {
                                echo '<img src="'.$value['user_pic'].'" />';
                            } ?>
                            <p>
                                <em><?php echo $value['user_name']; ?></em>
                                <span><?php echo date('Y-m-d',$value['user_regtime']); ?></span>
                            </p>
                        </div>
                    </em>
                    <em class="v2">
                    <?php
                        if ($value['user_sex'] == 0) {
                            echo '未知';
                        } else if ($value['user_sex'] == 1) {
                            echo '男';
                        } else if ($value['user_sex'] == 2) {
                            echo '女';
                        }
                    ?>
                    </em>
                    <em class="v3"><?php echo $value['user_phone']; ?></em>
                    <em class="v4"><?php echo $value['user_consume']; ?></em>
                    <em class="v5"><?php echo $value['referee_count']; ?></em>
                    <em class="v6"><?php echo $value['referee_consume']; ?></em>
                    <em class="v7"><?php echo date('Y-m-d',$value['shopman_regtime']); ?></em>
                    <em class="v8" id="zhuangtai_<?php echo $value['user_id']; ?>">
                    <?php
                        if ($value['is_shopman'] == 1) {
                            echo '已通过';
                        } else if ($value['is_shopman'] == 2) {
                            echo '待处理';
                        } else if ($value['is_shopman'] == 3) {
                            echo '已拒绝';
                        } else if ($value['is_shopman'] == 4) {
                            echo '已搁置';
                        }
                    ?>
                    </em>
                    <em class="v9" id="caozuo_<?php echo $value['user_id']; ?>">
                    <?php
                        if ($value['is_shopman'] == 1) {
                            echo '<a onclick="shopman_delete_one('.$value['user_id'].')">删除</a>&nbsp;';
                            if ($value['shopman_state'] == 1) {
                                echo '<a id="switch_'.$value['user_id'].'" onclick="shopman_switch('.$value['user_id'].')">停用</a>&nbsp;';
                            } else {
                                echo '<a id="switch_'.$value['user_id'].'" onclick="shopman_switch('.$value['user_id'].')">启用</a>&nbsp;';
                            }
                        } else if ($value['is_shopman'] == 2) {
                            echo '<a onclick="shopman_accept('.$value['user_id'].')">通过</a>&nbsp;';
                            echo '<a onclick="shopman_shelve('.$value['user_id'].')">搁置</a>&nbsp;';
                            echo '<a onclick="shopman_refuse('.$value['user_id'].')">拒绝</a>&nbsp;';
                        } else if ($value['is_shopman'] == 3) {
                            echo '<a onclick="shopman_accept('.$value['user_id'].')">通过</a>&nbsp;';
                            echo '<a onclick="shopman_shelve('.$value['user_id'].')">搁置</a>&nbsp;';
                        } else if ($value['is_shopman'] == 4) {
                            echo '<a onclick="shopman_accept('.$value['user_id'].')">通过</a>&nbsp;';
                            echo '<a onclick="shopman_refuse('.$value['user_id'].')">拒绝</a>&nbsp;';
                        }
                        echo '<br>';
                        echo '<a href="shopman_referee-'.$value['user_id'].'">推荐的人</a>&nbsp;';
                        echo '<a href="shopman_order-'.$value['user_id'].'">订单明细</a>';
                    ?>
                    </em>
                </li>
                <?php endforeach ?>
            </ul>
            <!-- 店主列表 -->

        </div>
        <!-- 移动店主 -->

        <!--  底部选项 -->
        <div class="bottomTool">
            <a class="bottomAllSelect">
                <img src="/static/style_default/image/pro_07.png" />
                <span>全选</span>
            </a>
            <a class="bottomDelect" onclick="shopman_delete_mony()">
                <img src="/static/style_default/image/pro_26.png" />
                <span>删除</span>
            </a>
        </div>
        <!--  底部选项 -->

        <!-- 分页 -->
        <div class="page">
            <?php if ($a_view_data['type'] == 6) {
                echo $this->pages->link_style_one($this->router->url('shopman_search-'.$a_view_data['type'].'-'.$a_view_data['searchtype'].'-'.$a_view_data['keywords'].'-', [], false, false));
            } else {
                echo $this->pages->link_style_one($this->router->url('shopman_showlist-'.$a_view_data['type'].'-', [], false, false));
            } ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->

        <!--  重要提示 -->
        <div class="tips hide">
            <em>重要提示</em>
            <img src="/static/style_default/image/pro_19.png" class="delete_cancel" />
            <p>
                <span class="span_one">▪ 确认删除这些移动店主吗？</span>
                <span class="span_two">▪ 删除后不可恢复！</span>
                </p>
                <div class="tipsBtn">
                    <em class="delete_confirm">确定</em>
                    <a class="delete_cancel">再看看</a>
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

// 单个删除
function shopman_delete_one(user_id) {
    $('.tips').show();
    $('.delete_confirm').click(function(event) {
        $.ajax({
            url: '<?php echo $this->router->url('shopman_delete'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {user_id: user_id, type: 1},
            success: function(data) {
                console.log(data);
                if (data.code==200) {
                    $('#tr_'+user_id).remove();
                }
            }
        })
        $('.tips').hide();
    });
    $('.delete_cancel').click(function(event) {
        $('.tips').hide();
    });
}

// 批量删除
function shopman_delete_mony() {
    $('.tips').show();
    $('.delete_confirm').click(function(event) {
        var user_ids = new Array();
        var i = 0;
        $(".varietiesChoice").each(function(index, el) {
            user_ids[i] = $(this).attr('value');
            i++
        });
        if (user_ids.length > 0) {
            $.ajax({
                url: '<?php echo $this->router->url('shopman_delete'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {user_ids: user_ids, type: 2},
                success: function(data) {
                    console.log(data);
                    if (data.code==200) {
                        for (var j=0; j<user_ids.length; j++) {
                            $('#tr_'+user_ids[j]).remove();
                        }
                    }
                }
            })
        }
        $('.tips').hide();
    });
    $('.delete_cancel').click(function(event) {
        $('.tips').hide();
    });
}

// 启用停用
function shopman_switch(user_id) {
    var shopman_nowstate = $('#switch_'+user_id).text();
    $('.span_one').html('▪ 确认要'+shopman_nowstate+'这个移动店主吗？');
    if (shopman_nowstate == '停用') {
        $('.span_two').html('▪ 停用后将按普通用户的规则计算积分！');
    } else {
         $('.span_two').html('▪ 启用后将按移动店主的规则计算积分！');
    }
    $('.tips').show();
    $('.delete_confirm').click(function(event) {
        $.ajax({
            url: '<?php echo $this->router->url('shopman_switch'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {user_id: user_id},
            success: function(data) {
                console.log(data);
                if (data.code==200) {
                    if (shopman_nowstate == '停用') {
                        $('#switch_'+user_id).html('启用');
                    } else {
                        $('#switch_'+user_id).html('停用');
                    }
                }
            }
        })
        $('.tips').hide();
    });
    $('.delete_cancel').click(function(event) {
        $('.tips').hide();
    });
}

// 通过申请
function shopman_accept(user_id) {
    $('.span_one').html('▪ 确认要通过这个用户的申请吗？');
    $('.span_two').html('▪ 通过后将按移动店主的规则计算所得！');
    $('.tips').show();
    $('.delete_confirm').click(function(event) {
        $.ajax({
            url: '<?php echo $this->router->url('shopman_accept'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {user_id: user_id},
            success: function(data) {
                console.log(data);
                if (data.code==200) {
                    // 通过申请后改变显示的状态及操作
                    $("#zhuangtai_"+user_id).html('已通过');
                    $("#caozuo_"+user_id).html('<a onclick="shopman_delete_one('+user_id+')">删除</a>&nbsp;<a id="switch_'+user_id+'" onclick="shopman_switch('+user_id+')">停用</a>&nbsp;<br><a href="shopman_referee-'+user_id+'">推荐的人</a>&nbsp;<a href="shopman_order-'+user_id+'">订单明细</a>');
                    // $("#tr_"+user_id).remove();
                }
            }
        })
        $('.tips').hide();
    });
    $('.delete_cancel').click(function(event) {
        $('.tips').hide();
    });
}

// 搁置申请
function shopman_shelve(user_id) {
    $('.span_one').html('▪ 确认要搁置这个用户的申请吗？');
    $('.span_two').html('▪ 搁置后可以在搁置列表中查看并操作！');
    $('.tips').show();
    $('.delete_confirm').click(function(event) {
        $.ajax({
            url: '<?php echo $this->router->url('shopman_shelve'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {user_id: user_id},
            success: function(data) {
                console.log(data);
                if (data.code==200) {
                    //$("#tr_"+user_id).remove();
                    $("#zhuangtai_"+user_id).html('已搁置');
                    $("#caozuo_"+user_id).html('<a onclick="shopman_accept('+user_id+')">通过</a>&nbsp;<a onclick="shopman_refuse('+user_id+')">拒绝</a>&nbsp;<br><a href="shopman_referee-'+user_id+'">推荐的人</a>&nbsp;<a href="shopman_order-'+user_id+'">订单明细</a>');
                }
            }
        })
        $('.tips').hide();
    });
    $('.delete_cancel').click(function(event) {
        $('.tips').hide();
    });
}

// 拒绝申请
function shopman_refuse(user_id) {
    $('.span_one').html('▪ 确认要拒绝这个用户的申请吗？');
    $('.span_two').html('▪ 拒绝后可以在拒绝列表中查看并操作！');
    $('.tips').show();
    $('.delete_confirm').click(function(event) {
        $.ajax({
            url: '<?php echo $this->router->url('shopman_refuse'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {user_id: user_id},
            success: function(data) {
                console.log(data);
                if (data.code==200) {
                    //$("#tr_"+user_id).remove();
                    $("#zhuangtai_"+user_id).html('已拒绝');
                    $("#caozuo_"+user_id).html('<a onclick="shopman_accept('+user_id+')">通过</a>&nbsp;<a onclick="shopman_shelve('+user_id+')">搁置</a>&nbsp;<br><a href="shopman_referee-'+user_id+'">推荐的人</a>&nbsp;<a href="shopman_order-'+user_id+'">订单明细</a>');
                }
            }
        })
        $('.tips').hide();
    });
    $('.delete_cancel').click(function(event) {
        $('.tips').hide();
    });
}

// 搜索
function shopman_search() {
    var keywords = $("input[name='keywords']").val();
    if (keywords != '') {
        $('#searchform').submit();
    } else {
        $('.span_one').html('▪ 搜索关键词不能为空');
        $('.span_two').html('▪ 搜索关键词可以是用户名，手机号码');
        $('.tips').show();
    }
    $('.delete_confirm').click(function(event) {
        $('.tips').hide();
    });
    $('.delete_cancel').click(function(event) {
        $('.tips').hide();
    });
}

</script>