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
    <link rel="stylesheet" href="./static/style_default/style/dynamic.css"/>
    <link rel="stylesheet" href="./static/style_default/style/style.css">
    <link rel="stylesheet" href="./static/style_default/style/comment.css">
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/dynamic.js"></script>
    <title>动态管理</title>
</head>
<body style="background:#efefef;">
<!--  后台管理 -->
<div class="productClassification">
    <?php echo $this->display('header'); ?>
    <!--  右侧内容 -->
    <article style="position:relative;">
        <!--  标题 -->
        <?php echo $this->display('top'); ?>
        <!--  标题 -->

        <!-- 动态管理 -->
        <div class="dynamicList">
            <p>
                <span><a style="color:#000;" href="mood_showlist">动态管理</a> >
                    <?php if ($a_view_data['type'] == 1) {
                        if ($a_view_data['time'] == 9) {
                            echo '全部时间';
                        } else {
                            echo date('Y-m-d', $a_view_data['time']).'后发布的动态';
                        }
                        if ($a_view_data['state'] == 9) {
                            echo ' > 全部状态';
                        } else if ($a_view_data['state'] == 0) {
                            echo ' > 隐藏的动态';
                        } else if ($a_view_data['state'] == 1) {
                            echo ' > 显示的动态';
                        }
                    } else if ($a_view_data['type'] == 6) {
                        echo '搜索动态 ['. $a_view_data['keywords'] . ']';
                    }
                    ?>
                </span>
                <em class="tagShell">
                    <img src="/static/style_default/image/dna_03.png" />
                    <span>标签管理</span>
                </em>
            </p>
            <!-- 动态分类 -->
            <div class="dynamicCate">
                <ul>
                    <li class="searchUser">
                        <span>搜索：</span>
                        <input type="text" name="keywords" placeholder="用户名/手机号" id="user_name" onblur="mood_search()" <?php if ($a_view_data['type'] == 6) { echo 'value="'.$a_view_data['keywords'].'"' ;} ?> />
                    </li>
                    <li class="advancedOptions">
                        <span>高级选项：</span>
                        <dl>
                            <dd class="auditStatusBox" style="">
                                <span>审核状态</span>
                                <img src="/static/style_default/image/pro_13.png" />
                                <div class="auditStatus hide">
                                    <a href="mood_showlist-9-9">全部</a>
                                    <a href="mood_showlist-1-9">已通过</a>
                                    <a href="mood_showlist-0-9">未通过</a>
                                </div>
                            </dd>
                            <dd class="displayStatusBox" style="">
                                <span>显示隐藏</span>
                                <img src="/static/style_default/image/pro_13.png" />
                                <div class="displayStatus hide">
                                    <a href="mood_showlist-9-9">全部</a>
                                    <a href="mood_showlist-1-9">显示</a>
                                    <a href="mood_showlist-0-9">隐藏</a>
                                </div>
                            </dd>
                            <dd class="releaseTimeBox" style="">
                                <span>发布时间</span>
                                <img src="/static/style_default/image/pro_13.png" />
                                <div class="releaseTime hide">
                                    <a href="mood_showlist-9-9">全部时间</a>
                                    <a href="mood_showlist-9-<?php echo time()-3600*24*30; ?>">近一个月</a>
                                    <a href="mood_showlist-9-<?php echo time()-3600*24*60; ?>">近三个月</a>
                                    <a href="mood_showlist-9-<?php echo time()-3600*24*180; ?>">近六个月</a>
                                </div>
                            </dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <!-- 动态分类 -->

            <!-- 选择动态 -->
            <div class="dynamic_content">
                <ul class="dynamicBox">
                    <?php foreach ($a_view_data['mood'] as $key => $value): ?>
                    <li class="choiceDynamic" id="<?php echo 'tr_' . $value['mood_id']; ?>" tags="<?php echo $value['mood_tags']; ?>">
                        <em class="v1" style="text-align:left;">
                            <img src="/static/style_default/image/pro_07.png" value="<?php echo $value['mood_id']; ?>" />
                            <div class="dynamicInfo">
                                <?php if (empty($value['user_pic'])) {
                                    echo '<img src="./static/style_default/image/tt_03.png" />';
                                } else if(strpos($value['user_pic'], 'http') === false) {
                                    echo '<img src="'.get_config_item('vdao_mobile').'/'.$value['user_pic'].'" />';
                                } else {
                                    echo '<img src="'.$value['user_pic'].'" />';
                                } ?>
                                <p>
                                    <em><?php echo $value['user_name']; ?></em>
                                    <span><?php echo date('Y-m-d', $value['mood_time']); ?></span>
                                </p>
                            </div>
                        </em>
                        <em class="showDynamic v2" style="text-align:left;">
                            <a onclick="mood_preview(<?php echo $value['mood_id']; ?>)">
                                <?php echo substr($value['mood_content'], 0, 72).'...'; ?>
                            </a>
                        </em>
                        <em class="v3">
                        <?php $i=0; foreach ($a_view_data['tag'] as $k => $v): ?>
                            <?php
                            $thistag = explode(',', $value['mood_tags']);
                            if (in_array($v['tag_id'], $thistag) && $i < 3) {
                                echo '<span>'.$v['tag_name'].'</span>';
                                $i++;
                            } ?>
                        <?php endforeach ?>
                            ...
                        </em>
                        <em class="v4">
                            <a class="forward">
                                <img src="/static/style_default/image/ani_06.png" />
                                <span><?php echo $value['mood_relay']; ?></span>
                            </a>&nbsp;
                            <a class="comment">
                                <img src="/static/style_default/image/ani_08.png" />
                                <span><?php echo $value['mood_discuss']; ?></span>
                            </a>&nbsp;
                            <a class="forGood">
                                <img src="/static/style_default/image/ani_10.png" />
                                <span><?php echo $value['mood_good']; ?></span>
                            </a>
                        </em>
                        <em class="v5" id="<?php echo "switch_".$value['mood_id'];?>" onclick="mood_switch(<?php echo $value['mood_id']; ?>)" value="<?php echo $value['mood_state']; ?>">
                        <?php if ($value['mood_state'] == 1) {
                            echo '<img src="./static/style_default/image/pro_10.png" />';
                        } else {
                            echo '<img src="./static/style_default/image/pro_33.png" />';
                        } ?>
                        </em>
                        <em class="v6">
                            <img class="addTagPic" src="/static/style_default/image/ani_03.png" onclick="mood_addtag(<?php echo $value['mood_id']; ?>)" />
                            <img src="/static/style_default/image/pro_26.png" onclick="mood_delete_one(<?php echo $value['mood_id']; ?>)" />
                        </em>
                    </li>
                    <?php endforeach ?>

                </ul>
            </div>
            <!-- 选择动态 -->
        </div>
        <!-- 动态管理 -->

        <!--  底部选项 -->
        <div class="bottomTool">
            <a class="bottomAllSelect">
                <img src="/static/style_default/image/pro_07.png" />
                <span>全选</span>
            </a>
            <a class="bottomDelect" onclick="mood_delete_mony()">
                <img src="/static/style_default/image/pro_26.png" />
                <span>删除</span>
            </a>
            <a class="bottomHide" onclick="mood_switch_mony()">
                <img src="/static/style_default/image/ann_07.png" />
                <span>隐藏</span>
            </a>
        </div>
        <!--  底部选项 -->

        <!-- 分页 -->
        <div class="page">
            <?php if ($a_view_data['type'] == 6) {
                // 搜索时的分页
                echo $this->pages->link_style_one($this->router->url('mood_search-'.$a_view_data['keywords'].'-', [], false, false));
            } else {
                echo $this->pages->link_style_one($this->router->url('mood_showlist-'.$a_view_data['state'].'-'.$a_view_data['time'].'-', [], false, false));
            } ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->

        <!-- 标签管理 -->
        <div class="tagLay hide">
            <p>
                <span>标签管理</span>
                <img class="closeTag" src="/static/style_default/image/pro_19.png" />
            </p>
            <div class="addTag">
                <input type="text" name="tag_name" placeholder="请输入标签" id="tag_name"/>
                <a onclick="tag_add()">
                    <img src="/static/style_default/image/pro_03.png" />
                    <span>添加标签</span>
                </a>
            </div>
            <div class="dragBox">
                <p>
                    <span>所有标签</span>
                    <!--<em>按住拖动调整排序、启用/暂用</em>-->
                </p>
                <?php foreach ($a_view_data['tag'] as $key => $value): ?>
                <div class="item" id="<?php echo 'tag_'.$value['tag_id']; ?>">
                    <span><?php echo $value['tag_name']; ?></span>
                    <img class="moveTag" onclick="tag_delete(<?php echo $value['tag_id']; ?>)" src="/static/style_default/image/pro_19.png" />
                </div>
                <?php endforeach ?>
            </div>
            <div class="tagSure closeTag" style="text-align:center;">
                <span>确定</span>
            </div>
        </div>
        <!-- 标签管理 -->

        <!--  动态预览 -->
        <div class="aynaPreview hide">
            <img class="closePreview" src="/static/style_default/image/pro_19.png" />
            <em>
                <img src="/static/style_default/image/jt_03.png" />
                <span>动态预览</span>
            </em>
            <div class="viewOperation">
                <i><img src="/static/style_default/image/ani_03.png" class="pre_addtag" onclick="mood_addtag()" /></i>
                <i><img src="/static/style_default/image/ann_07.png" /></i>
                <i><img src="/static/style_default/image/pro_26.png" class="pre_delete" onclick="pre_delete()" /></i>
                <p class="mood_view">所有人可见</p>
            </div>
            <div class="previewTitle">
                <h1>原创动态</h1>
            </div>
            <!-- 左边 -->
            <div class="previewLeft">
                <div class="dynBox">
                    <div class="headPortrait">
                        <img src="/static/style_default/image/tt_03.png" />
                    </div>
                    <!-- 动态信息列表 -->
                    <dl class="previewList">
                        <dd class="userName">
                            <span>咖啡加奶不加糖</span>
                        </dd>
                        <dd class="previewTime">
                            <span>2017-09-22  12:00</span>
                        </dd>
                        <dd class="previewText">
                            <span>2016年1月15日，这个周五与往常并没有任何两样，但是对于国内连锁咖啡行业而言，这一天的意义却非同一般。经过了长时间的酝酿，国内连锁咖啡企业、在南海注册成立的广东爽爽挝啡饮品有限公司，挂牌前海股权交易中心（新四板）（证券名称：爽爽挝啡，证券代码：363997），成为国内咖啡连锁行业最早进入资本市场的企业之一。</span>
                        </dd>
                        <dd class="previewImg">
<!--                             <i><img src="/static/style_default/image/bd.jpg" /></i>
                            <i><img src="/static/style_default/image/tt_03.png" /></i>
                            <i><img src="/static/style_default/image/bd.jpg" /></i>
                            <i><img src="/static/style_default/image/tt_03.png" /></i>
                            <i><img src="/static/style_default/image/bd.jpg" /></i>
                            <i><img src="/static/style_default/image/tt_03.png" /></i>
                            <i><img src="/static/style_default/image/bd.jpg" /></i>
                            <i><img src="/static/style_default/image/tt_03.png" /></i>
                            <i><img src="/static/style_default/image/bd.jpg" /></i> -->
                        </dd>
                    </dl>
                    <!-- 动态信息列表 -->
                </div>
            </div>
            <!-- 左边 -->
            <!-- 右边 -->
            <div class="previewRight">
                <!-- 查看动态 -->
                <div class="lookDynamic">
                    <a class="forward">
                        <p>转发</p>
                        <span>5</span>
                    </a>
                    <a class="comment">
                        <p>评论</p>
                        <span>5</span>
                    </a>
                    <a class="thumbsUp">
                        <p>点赞</p>
                        <span>5</span>
                    </a>
                </div>
                <!-- 查看动态 -->
                <!-- 查看动态的内容 -->
                <div class="dynamicContent">
                    <div class="commentAll">
                        <!--评论区域 begin-->
                        <div class="reviewArea clearfix">
                            <textarea class="content comment-input" placeholder="请输入&hellip;" onkeyup="keyUP(this)"></textarea>
                            <a href="javascript:;" class="plBtn">评论</a>
                        </div>
                        <!--评论区域 end-->
                        <!--回复区域 begin-->
                        <div class="comment-show">
                            <div class="comment-show-con clearfix">
                                <div class="comment-show-con-img pull-left"><img src="/static/style_default/image/tt_03.png" ></div>
                                <div class="comment-show-con-list pull-left clearfix">
                                    <div class="pl-text clearfix">
                                        <a href="#" class="comment-size-name">葫芦娃大战本拉登: </a>
                                        <span class="my-pl-con">&nbsp;葫芦娃</span>
                                    </div>
                                    <div class="date-dz">
                                        <span class="date-dz-left pull-left comment-time">2017-12-12 11:11:39</span>
                                        <div class="date-dz-right pull-right comment-pl-block">
                                            <a href="javascript:;" class="removeBlock">删除</a>
                                            <a href="javascript:;" class="date-dz-pl pl-hf hf-con-block pull-left">回复</a>
                                            <span class="pull-left date-dz-line">|</span>
                                            <a href="javascript:;" class="date-dz-z pull-left"><i class="date-dz-z-click-red"></i>赞 (<i class="z-num">666</i>)</a>
                                        </div>
                                    </div>
                                    <div class="hf-list-con"></div>
                                </div>
                            </div>
                        </div>
                        <!--回复区域 end-->
                    </div>



                    <script type="text/javascript" src="/static/style_default/plugin/jquery.flexText.js"></script>
                    <!--textarea高度自适应-->
                    <script type="text/javascript">
                        $(function () {
                            $('.content').flexText();
                        });
                    </script>
                    <!--textarea限制字数-->
                    <script type="text/javascript">
                        function keyUP(t){
                            var len = $(t).val().length;
                            if(len > 139){
                                $(t).val($(t).val().substring(0,140));
                            }
                        }
                    </script>
                    <!--点击评论创建评论条-->
<!--                     <script type="text/javascript">
                        $('.commentAll').on('click','.plBtn',function(){
                            var myDate = new Date();
                            //获取当前年
                            var year=myDate.getFullYear();
                            //获取当前月
                            var month=myDate.getMonth()+1;
                            //获取当前日
                            var date=myDate.getDate();
                            var h=myDate.getHours();       //获取当前小时数(0-23)
                            var m=myDate.getMinutes();     //获取当前分钟数(0-59)
                            if(m<10) m = '0' + m;
                            var s=myDate.getSeconds();
                            if(s<10) s = '0' + s;
                            var now=year+'-'+month+"-"+date+" "+h+':'+m+":"+s;
                            //获取输入内容
                            var oSize = $(this).siblings('.flex-text-wrap').find('.comment-input').val();
                            console.log(oSize);
                            //动态创建评论模块
                            oHtml = '<div class="comment-show-con clearfix"><div class="comment-show-con-img pull-left"><img src="/static/style_default/image/bd.jpg" ></div> <div class="comment-show-con-list pull-left clearfix"><div class="pl-text clearfix"> <a href="#" class="comment-size-name">test: </a> <span class="my-pl-con">&nbsp;'+ oSize +'</span> </div> <div class="date-dz"> <span class="date-dz-left pull-left comment-time">'+now+'</span> <div class="date-dz-right pull-right comment-pl-block"><a href="javascript:;" class="removeBlock">删除</a> <a href="javascript:;" class="date-dz-pl pl-hf hf-con-block pull-left">回复</a> <span class="pull-left date-dz-line">|</span> <a href="javascript:;" class="date-dz-z pull-left"><i class="date-dz-z-click-red"></i>赞 (<i class="z-num">10</i>)</a> </div> </div><div class="hf-list-con"></div></div> </div>';
                            if(oSize.replace(/(^\s*)|(\s*$)/g, "") != ''){
                                $(this).parents('.reviewArea ').siblings('.comment-show').prepend(oHtml);
                                $(this).siblings('.flex-text-wrap').find('.comment-input').prop('value','').siblings('pre').find('span').text('');
                            }
                        });
                    </script> -->
                    <!--点击回复动态创建回复块-->
<!--                     <script type="text/javascript">
                        $('.comment-show').on('click','.pl-hf',function(){
                            //获取回复人的名字
                            var fhName = $(this).parents('.date-dz-right').parents('.date-dz').siblings('.pl-text').find('.comment-size-name').html();
                            //回复@
                            var fhN = '回复@'+fhName;
                            //var oInput = $(this).parents('.date-dz-right').parents('.date-dz').siblings('.hf-con');
                            var fhHtml = '<div class="hf-con pull-left"> <textarea class="content comment-input hf-input" placeholder="" onkeyup="keyUP(this)"></textarea> <a href="javascript:;" class="hf-pl">评论</a></div>';
                            //显示回复
                            if($(this).is('.hf-con-block')){
                                $(this).parents('.date-dz-right').parents('.date-dz').append(fhHtml);
                                $(this).removeClass('hf-con-block');
                                $('.content').flexText();
                                $(this).parents('.date-dz-right').siblings('.hf-con').find('.pre').css('padding','6px 15px');
                                //console.log($(this).parents('.date-dz-right').siblings('.hf-con').find('.pre'))
                                //input框自动聚焦
                                $(this).parents('.date-dz-right').siblings('.hf-con').find('.hf-input').val('').focus().val(fhN);
                            }else {
                                $(this).addClass('hf-con-block');
                                $(this).parents('.date-dz-right').siblings('.hf-con').remove();
                            }
                        });
                    </script> -->
                    <!--评论回复块创建-->
                    <script type="text/javascript">
                        $('.comment-show').on('click','.hf-pl',function(){
                            var oThis = $(this);
                            var myDate = new Date();
                            //获取当前年
                            var year=myDate.getFullYear();
                            //获取当前月
                            var month=myDate.getMonth()+1;
                            //获取当前日
                            var date=myDate.getDate();
                            var h=myDate.getHours();       //获取当前小时数(0-23)
                            var m=myDate.getMinutes();     //获取当前分钟数(0-59)
                            if(m<10) m = '0' + m;
                            var s=myDate.getSeconds();
                            if(s<10) s = '0' + s;
                            var now=year+'-'+month+"-"+date+" "+h+':'+m+":"+s;
                            //获取输入内容
                            var oHfVal = $(this).siblings('.flex-text-wrap').find('.hf-input').val();
                            console.log(oHfVal)
                            var oHfName = $(this).parents('.hf-con').parents('.date-dz').siblings('.pl-text').find('.comment-size-name').html();
                            var oAllVal = '回复@'+oHfName;
                            if(oHfVal.replace(/^ +| +$/g,'') == '' || oHfVal == oAllVal){

                            }else {
                                $.getJSON("json/pl.json",function(data){
                                    var oAt = '';
                                    var oHf = '';
                                    $.each(data,function(n,v){
                                        delete v.hfContent;
                                        delete v.atName;
                                        var arr;
                                        var ohfNameArr;
                                        if(oHfVal.indexOf("@") == -1){
                                            data['atName'] = '';
                                            data['hfContent'] = oHfVal;
                                        }else {
                                            arr = oHfVal.split(':');
                                            ohfNameArr = arr[0].split('@');
                                            data['hfContent'] = arr[1];
                                            data['atName'] = ohfNameArr[1];
                                        }

                                        if(data.atName == ''){
                                            oAt = data.hfContent;
                                        }else {
                                            oAt = '回复<a href="#" class="atName">@'+data.atName+'</a> : '+data.hfContent;
                                        }
                                        oHf = data.hfName;
                                    });

                                    var oHtml = '<div class="all-pl-con"><div class="pl-text hfpl-text clearfix"><a href="#" class="comment-size-name">我的名字 : </a><span class="my-pl-con">'+oAt+'</span></div><div class="date-dz"> <span class="date-dz-left pull-left comment-time">'+now+'</span> <div class="date-dz-right pull-right comment-pl-block"> <a href="javascript:;" class="removeBlock">删除</a> <a href="javascript:;" class="date-dz-pl pl-hf hf-con-block pull-left">回复</a> <span class="pull-left date-dz-line">|</span> <a href="javascript:;" class="date-dz-z pull-left"><i class="date-dz-z-click-red"></i>赞 (<i class="z-num">666</i>)</a> </div> </div></div>';
                                    oThis.parents('.hf-con').parents('.comment-show-con-list').find('.hf-list-con').css('display','block').prepend(oHtml) && oThis.parents('.hf-con').siblings('.date-dz-right').find('.pl-hf').addClass('hf-con-block') && oThis.parents('.hf-con').remove();
                                });
                            }
                        });
                    </script>
                    <!--删除评论块-->
<!--                     <script type="text/javascript">
                        $('.commentAll').on('click','.removeBlock',function(){
                            var oT = $(this).parents('.date-dz-right').parents('.date-dz').parents('.all-pl-con');
                            if(oT.siblings('.all-pl-con').length >= 1){
                                oT.remove();
                            }else {
                                $(this).parents('.date-dz-right').parents('.date-dz').parents('.all-pl-con').parents('.hf-list-con').css('display','none')
                                oT.remove();
                            }
                            $(this).parents('.date-dz-right').parents('.date-dz').parents('.comment-show-con-list').parents('.comment-show-con').remove();

                        })
                    </script> -->
                    <!--点赞-->
                    <script type="text/javascript">
                        $('.comment-show').on('click','.date-dz-z',function(){
                            var zNum = $(this).find('.z-num').html();
                            if($(this).is('.date-dz-z-click')){
                                zNum--;
                                $(this).removeClass('date-dz-z-click red');
                                $(this).find('.z-num').html(zNum);
                                $(this).find('.date-dz-z-click-red').removeClass('red');
                            }else {
                                zNum++;
                                $(this).addClass('date-dz-z-click');
                                $(this).find('.z-num').html(zNum);
                                $(this).find('.date-dz-z-click-red').addClass('red');
                            }
                        })
                    </script>
                </div>
                <!-- 查看动态的内容 -->
            </div>
            <!-- 右边 -->
        </div>
        <!--  动态预览 -->

        <!-- 查看照片 -->
        <div class="lookPicture hide">
            <p>查看照片</p>
            <div class="picBox">
                <i class="picPrev"><img src="/static/style_default/image/np_03.png" /></i>
                <div class="pictureContent">
                    <img src="/static/style_default/image/tt_03.png" />
                    <em class="picNum">
                        (<span class="picIndex" style="font-weight:bold;"></span>/<span class="picLen" style="font-weight:bold;"></span>)
                    </em>
                </div>
                <i class="picNext"><img src="/static/style_default/image/np_05.png" /></i>
            </div>
            <a>
                <span class="closePic">关闭窗口</span>
            </a>
        </div>
        <!-- 查看照片 -->

        <!-- 添加标签 -->
        <div class="addTagContainer hide" style="z-index:999;">
            <p>
                <span>设置标签</span>
                <img class="closeTag" src="/static/style_default/image/pro_19.png" />
            </p>

            <div class="tagList">
                <span>所有标签</span>
                <ul>
                    <?php foreach ($a_view_data['tag'] as $key => $value): ?>
                    <li value="<?php echo $value['tag_id']; ?>" id="<?php echo 'tagli_'.$value['tag_id']; ?>">
                        <a><?php echo $value['tag_name']; ?></a>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <span class="sureTag">确定</span>
        </div>
        <!-- 添加标签 -->

        <!-- 重要提示 -->
        <div class="pop_tips hide" style="z-index:1234;">
            <p>重要提示</p>
            <img src="./static/style_default/image/pro_19.png" class="closeTips delete_cancel" />
            <div class="tipsText">
                <p class="tipspone"><s>*</s>你确定要删除这条动态吗？</p>
                <p class="tipsptwo"><s>*</s>删除后不可恢复，且与该动态有关的数据将会丢失</p>
            </div>
            <div class="btnBox">
                <span class="delete_confirm">确认</span>
                <em class="delete_cancel">再看看</em>
            </div>
        </div>
        <!-- 重要提示 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>

<script>

// 显示隐藏
function mood_switch(mood_id) {
    var mood_state = $("#switch_"+mood_id).attr('value');
    $.ajax({
        url: 'mood_switch',
        type: 'POST',
        dataType: 'json',
        data: {mood_id: mood_id},
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                if (mood_state == 0) {
                    $("#switch_"+mood_id).html('<img src="./static/style_default/image/pro_10.png" />');
                    $("#switch_"+mood_id).attr('value','1');
                } else {
                    $("#switch_"+mood_id).html('<img src="./static/style_default/image/pro_33.png" />');
                    $("#switch_"+mood_id).attr('value', '0');
                }
            }
        }
    })
}

// 批量显示隐藏
function mood_switch_mony() {
    $(".dynaSelect").each(function(index, value) {
        mood_switch($(this).attr('value'));
    });
}

// 单个删除
function mood_delete_one(mood_id) {
    $(".pop_tips").removeClass('hide');
    $(".delete_confirm").click(function(event) {
        $.ajax({
            url: '<?php echo $this->router->url('mood_delete'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {mood_id: mood_id, type: 1},
            success: function(data) {
                console.log(data);
                if (data.code==200) {
                    $('#tr_'+mood_id).remove();
                }
            }
        });
         $(".pop_tips").addClass('hide');
    });
    $(".delete_cancel").click(function(event) {
        $(".pop_tips").addClass('hide');
    });
}

// 批量删除
function mood_delete_mony() {
    $(".pop_tips").removeClass('hide');
    $(".delete_confirm").click(function(event) {
        var mood_ids = new Array();
        var i = 0;
        $(".dynaSelect").each(function(index, value) {
            mood_ids[i] = $(this).attr('value');
            i++;
        });
        if (mood_ids.length > 0) {
            $.ajax({
                url: '<?php echo $this->router->url('mood_delete'); ?>',
                type: 'post',
                dataType: 'json',
                data: {type: 2, mood_ids:mood_ids},
                success: function(data) {
                    console.log(data);
                    for (var j = 0; j<mood_ids.length; j++) {
                        $('#tr_'+mood_ids[j]).remove();
                    }
                }
            });
        }
        $(".pop_tips").addClass('hide');
    });
    $(".delete_cancel").click(function(event) {
        $(".pop_tips").addClass('hide');
    });
}

// 搜索动态
function mood_search() {
    var keywords = $("input[name='keywords']").val();
    keywords = keywords.replace(/(^\s*)|(\s*$)/g, "");
    if (keywords != '') {
        window.location.href = "mood_search-"+keywords;
    }
}

// 预览动态
function mood_preview(mood_id) {
    $.ajax({
        url: 'mood_preview',
        type: 'POST',
        dataType: 'json',
        data: {mood_id: mood_id},
        success: function(res) {
            console.log(res);
            if (res.mood.mood_type == 1) {
                $(".previewTitle h1").html('原创动态');
            } else {
                $(".previewTitle h1").html('转发动态');
            }
            if (res.mood.mood_view == 1) {
                $(".viewOperation .mood_view").html('全部人可见');
            } else if (res.mood.mood_view == 2) {
                $(".viewOperation .mood_view").html('推荐的人可见');
            } else if (res.mood.mood_view == 3) {
                $(".viewOperation .mood_view").html('仅自己可见');
            }
            if (res.mood.user_pic != '') {
                $('.headPortrait').html('<img src="'+res.mood.user_pic+'">');
            }
            $('.pre_addtag').attr('onclick', 'mood_addtag('+res.mood.mood_id+')');
            $('.pre_delete').attr('onclick', 'pre_delete('+res.mood.mood_id+')');
            $('.userName').html(res.mood.user_name);
            $('.previewTime span').html(res.mood.mood_time);
            $('.previewText span').html(res.mood.mood_content);
            if (res.mood.mood_pic != '') {
                $('.previewImg i').remove();
                for (var i=0; i<res.pic.length; i++) {
                    $('.previewImg').append("<i><img src='"+"<?php echo get_config_item('vdao_mobile'); ?>"+res.pic[i]+"' /></i>");
                }
            } else {
                $('.previewImg i').remove();
            }
            $('.thumbsUp span').html(res.mood.mood_good);
            $('.comment span').html(res.mood.mood_discuss);
            $('.forward span').html(res.mood.mood_relay);
            $('.plBtn').attr('onclick', 'mood_discuss('+res.mood.mood_id+')');
            $('.comment-show').remove();
            var append_content = '';
            if (res.discuss != null) {
                $.each(res.discuss, function(index, el) {
                    append_content += '<div class="comment-show" id="discuss_'+el.discuss_id+'"><div class="comment-show-con clearfix"><div class="comment-show-con-img pull-left">';
                    if (el.user_pic == '' || el.user_id == 0) {
                        append_content += '<img src="/static/style_default/image/tt_03.png" >';
                    } else {
                        append_content += '<img src="'+el.user_pic+'" >';
                    }
                    append_content += '</div>';
                    append_content += '<div class="comment-show-con-list pull-left clearfix"><div class="pl-text clearfix"><a href="javascript:;" class="comment-size-name">';
                    if (el.user_id != 0) {
                        append_content += el.user_name;
                    } else {
                        append_content += '管理员';
                    }
                    append_content += ':</a>';
                    append_content += '<span class="my-pl-con">&nbsp;';
                    append_content += el.discuss_content;
                    append_content += '</span></div><div class="date-dz"><span class="date-dz-left pull-left comment-time">';
                    append_content += el.discuss_time;
                    append_content += '</span><div class="date-dz-right pull-right comment-pl-block">';
                    append_content += '<a href="javascript:;" class="removeBlock" onclick="discuss_delete('+el.discuss_id+','+el.mood_id+')">删除</a>';
                    append_content += '<a href="javascript:;" class="date-dz-pl pl-hf hf-con-block pull-left" onclick="discuss_reply('+el.discuss_id+','+el.mood_id+')" id="mr_'+el.discuss_id+'">回复</a>';
                    append_content += '<span class="pull-left date-dz-line">|</span>';
                    append_content += '<a href="javascript:;" id="discusslike'+el.discuss_id+'" onclick="discuss_like('+el.discuss_id+','+el.mood_id+')" class="date-dz-z pull-left"><i class="date-dz-z-click-red"></i>赞 (<i class="z-num">'+el.discuss_like+'</i>)</a>';
                    append_content += '</div></div><div class="hf-list-con"></div></div></div></div>';
                });
                $('.commentAll').append(append_content);
            }
        }
    })
}

// 预览动态里面的删除动态按钮
function pre_delete(mood_id) {
    mood_delete_one(mood_id);
    $(".aynaPreview").addClass('hide');
}

// 删除动态评论
function discuss_delete(discuss_id, mood_id) {
    var prenum;
    $.ajax({
        url: 'discuss_delete',
        type: 'POST',
        dataType: 'json',
        data: {discuss_id: discuss_id, mood_id: mood_id},
        success: function(res){
            console.log(res);
            if (res.code == 200) {
                $('#discuss_'+discuss_id).remove();
                prenum = $('.comment span').html();
                $('.comment span').html(prenum-1);
            }
        }
    })
}

// 评论动态
function mood_discuss(mood_id) {
    var discuss_content = $(".comment-input").val();
    if (discuss_content != '') {
        $.ajax({
            url: 'mood_discuss',
            type: 'POST',
            dataType: 'json',
            data: {mood_id: mood_id, discuss_content: discuss_content},
            success: function(res) {
                console.log(res);
                if (res.code == 200) {
                    $(".comment-input").val('');
                    mood_preview(mood_id);
                }
            }
        })
    }
}

// 回复评论
function discuss_reply(discuss_id, mood_id) {
    //获取回复人的名字
    var fhName = $('#mr_'+discuss_id).parents('.date-dz-right').parents('.date-dz').siblings('.pl-text').find('.comment-size-name').html();
    //回复@
    var fhN = '@'+fhName+' ';
    var oInput = $('#mr_'+discuss_id).parents('.date-dz-right').parents('.date-dz').siblings('.hf-con');
    var fhHtml = '<div class="hf-con pull-left"> <textarea id="reptext_'+discuss_id+'" class="content comment-input hf-input" placeholder="" onkeyup="keyUP(this)"></textarea> <a href="javascript:;" class="hf-pl" onclick="dis_rep('+discuss_id+','+mood_id+')">评论</a></div>';
    // 显示回复
    if($('#mr_'+discuss_id).is('.hf-con-block')){
        $('#mr_'+discuss_id).parents('.date-dz-right').parents('.date-dz').append(fhHtml);
        $('#mr_'+discuss_id).removeClass('hf-con-block');
        $('.content').flexText();
        $('#mr_'+discuss_id).parents('.date-dz-right').siblings('.hf-con').find('.pre').css('padding','6px 15px');
        // console.log($(this).parents('.date-dz-right').siblings('.hf-con').find('.pre'))
        // input框自动聚焦
        $('#mr_'+discuss_id).parents('.date-dz-right').siblings('.hf-con').find('.hf-input').val('').focus().val(fhN);
    }else {
        $('#mr_'+discuss_id).addClass('hf-con-block');
        $('#mr_'+discuss_id).parents('.date-dz-right').siblings('.hf-con').remove();
    }
}

// ajax回复动态评论
function dis_rep(discuss_id, mood_id) {
    var discon = $("#reptext_"+discuss_id).val();
    if (discon != '') {
        $.ajax({
            url: 'discuss_reply',
            type: 'POST',
            dataType: 'json',
            data: {mood_id: mood_id, discuss_content: discon, discuss_id: discuss_id},
            success: function(res) {
                console.log(res);
                if (res.code == 200) {
                    mood_preview(mood_id);
                }
            }
        })
    }
}

// 动态点赞
function discuss_like(discuss_id, mood_id) {
    $.ajax({
        url: 'discuss_like',
        type: 'POST',
        dataType: 'json',
        data: {discuss_id: discuss_id},
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                mood_preview(mood_id);
            }
        }
    })
}

// 添加标签
function tag_add() {
    var tag_name = $("input[name='tag_name']").val();
    if (tag_name != '') {
        $.ajax({
            url: 'tag_add',
            type: 'POST',
            dataType: 'json',
            data: {tag_name: tag_name},
            success: function(res) {
                console.log(res);
                if (res.code == 200) {
                    $(".dragBox").append('<div class="item" id="tag_'+res.newid+'"><span>'+tag_name+'</span><img class="moveTag" onclick="tag_delete('+res.newid+')" src="/static/style_default/image/pro_19.png" /></div>');
                    $("input[name='tag_name']").val('');
                    $('.tagList ul').append('<li value="'+res.newid+'"><a>'+tag_name+'</a></li>');
                }
            }
        })
    }
}

// 给动态设置标签
function mood_addtag(mood_id) {
    console.log(mood_id);
    $(".tagList ul li").each(function(index, el) {
        $(this).children('img').remove();
        $(this).removeClass('checkedTag');
    });
    $(".sureTag").attr('onclick','set_moodtag('+mood_id+')');
    var this_tags = $("#tr_"+mood_id).attr('tags');
    var tags_arr = this_tags.split(",");
    var tag_id;
    $(".addTagContainer").removeClass("hide");
    $('.tagList ul li').each(function(index, el) {
        tag_id = $(this).attr('value');
        for (var i=0; i<tags_arr.length; i++) {
            if (tags_arr[i] == tag_id) {
                $(this).append('<img src="/static/style_default/image/ac_03.png" />');
                $(this).addClass('checkedTag');
            }
        }
    });
}

function set_moodtag(mood_id) {
    var tag_ids = new Array();
    var i = 0;
    $(".checkedTag").each(function(index, el) {
        tag_ids[i] = $(this).attr('value');
        i++;
    });
    if (tag_ids.length > 0) {
        $.ajax({
            url: 'mood_addtag',
            type: 'POST',
            dataType: 'json',
            data: {mood_id: mood_id, tag_ids: tag_ids},
            success: function(res) {
                console.log(res);
                console.log(mood_id);
                if (res.code == 200) {
                     $("#tr_"+mood_id).attr('tags', tag_ids.join(","));
                     $(".addTagContainer").addClass("hide");
                     // 重置列表里的标签
                     var append_content = '';
                     var j = 0;
                     $.each(res.data, function(index, el) {
                        if (j<3) {
                            append_content += '<span>'+el.tag_name+'</span>&nbsp;';
                        }
                        j++;
                     });
                     $("#tr_"+mood_id).children('.v3').html(append_content + '...');
                }
            }
        })
    }
}

// 删除标签
function tag_delete(tag_id) {
    $(".tipspone").html("<s>*</s> 你确定要删除["+$('#tag_'+tag_id).children('span').text()+"]这个标签吗？");
    $(".tipsptwo").html("<s>*</s> 删除后不可恢复，若想重新使用需要再次添加");
    $(".pop_tips").removeClass('hide');
    $(".delete_confirm").click(function(event) {
        $.ajax({
            url: 'tag_delete',
            type: 'POST',
            dataType: 'json',
            data: {tag_id: tag_id},
            success: function(data) {
                console.log(data);
                if (data.code==200) {
                    $('#tag_'+tag_id).remove();
                }
            }
        });
         $(".pop_tips").addClass('hide');
    });
    $(".delete_cancel").click(function(event) {
        $(".pop_tips").addClass('hide');
    });
}

</script>