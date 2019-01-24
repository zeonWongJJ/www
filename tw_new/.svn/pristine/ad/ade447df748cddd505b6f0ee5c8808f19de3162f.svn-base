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
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/public.css"/>
    <link rel="stylesheet" href="static/style_default/style/sharingAudit.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/sharingAudit.js"></script>
    <title>分享列表</title>
    <style>
        .state a {
            color: #000;
        }
    </style>
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

        <!-- 产品分享 -->
        <div class="sharingAudit">
            <p>产品分享 >
                <?php if ($a_view_data['state'] == 1) {
                    echo '申请中';
                } else if ($a_view_data['state'] == 2) {
                    echo '已通过';
                } else if ($a_view_data['state'] == 3) {
                    echo '已通过';
                } else if ($a_view_data['state'] == 4) {
                    echo '已搁置';
                } else {
                    echo '全部';
                } ?>
            </p>
            <!-- 分享列表 -->
            <ul class="shareList">
                <li class="cateHead">
                    <em class="v1">产品信息</em>
                    <em class="v2">产品分类</em>
                    <em class="v3">生产证许可号</em>
                    <em class="v4">价格</em>
                    <em class="v5">配送费</em>
                    <em class="v6 stateBox" style="">
                        <span>
                        <?php if ($a_view_data['state'] == 1) {
                            echo '申请中';
                        } else if ($a_view_data['state'] == 2) {
                            echo '已通过';
                        } else if ($a_view_data['state'] == 3) {
                            echo '已通过';
                        } else if ($a_view_data['state'] == 4) {
                            echo '已搁置';
                        } else {
                            echo '全部状态';
                        } ?>
                        </span>
                        <img src="static/style_default/image/pro_13.png" alt=""/>
                        <div class="state hide">
                            <a href="share_showlist">全部的</a>
                            <a href="share_showlist-1">申请中</a>
                            <a href="share_showlist-2">已通过</a>
                            <a href="share_showlist-3">已驳回</a>
                            <a href="share_showlist-4">已搁置</a>
                        </div>
                    </em>
                    <em class="v7">操作</em>
                </li>
                <?php foreach ($a_view_data['goods'] as $key => $value): ?>
                <li class="cateBody">
                    <em class="v1" style="text-align:left;">
                        <div class="shareInfo">
                            <?php if (empty($value['pro_img'])) {
                                echo '<img src="static/style_default/image/tt_03.png" />';
                            } else {
                                echo '<img src="'.get_config_item('vdao_mobile').$value['pro_img'].'" />';
                            } ?>
                            <p>
                                <em><?php echo $value['product_name']; ?></em>
                                <span>
                                <?php
                                    $subject = strip_tags($value['pro_details']); //去除html标签
                                    $pattern = '/\s/'; //去除空白
                                    $content = preg_replace($pattern, '', $subject);
                                    $seodata = mb_substr($content, 0, 60); //截取100个汉字
                                    echo $seodata;
                                ?>
                                </span>
                            </p>
                        </div>
                    </em>
                    <em class="v2"><?php echo $value['pro_name']; ?></em>
                    <em class="v3"><?php echo $value['goods_license']; ?></em>
                    <em class="v4">￥<?php echo $value['price']; ?></em>
                    <em class="v5">￥<?php echo $value['distribution']; ?></em>
                    <em class="v6">
                        <span>
                        <?php if ($value['state'] == 1) {
                            echo '待审核';
                        } else if ($value['state'] == 2) {
                            echo '已通过';
                        } else if ($value['state'] == 3) {
                            echo '已驳回';
                        } else if ($value['state'] == 4) {
                            echo '已搁置';
                        } ?>
                        </span>
                        <br/>
                        <a href="share_detail-<?php echo $value['goo_id']; ?>">查看详情</a>
                    </em>
                    <em class="v7" id="v7_<?php echo $value['goo_id']; ?>">
                        <?php if ($value['state'] == 1) { ?>
                            <a class="adopt" onclick="share_adopt(<?php echo $value['goo_id']; ?>)">通过</a>
                            <a class="shelve" onclick="share_shelve(<?php echo $value['goo_id']; ?>)">搁置</a>
                            <a class="reject" onclick="share_refuse(<?php echo $value['goo_id']; ?>)">驳回</a>
                        <?php } else if ($value['state'] == 2) { ?>
                            <a class="see" onclick="share_see(<?php echo $value['goo_id']; ?>)">查看</a>
                        <?php } else if ($value['state'] == 3) { ?>
                            <a class="adopt" onclick="share_adopt(<?php echo $value['goo_id']; ?>)">通过</a>
                            <a class="see" onclick="share_see(<?php echo $value['goo_id']; ?>)">查看</a>
                        <?php } else if ($value['state'] == 4) { ?>
                            <a class="adopt" onclick="share_adopt(<?php echo $value['goo_id']; ?>)">通过</a>
                            <a class="reject" onclick="share_refuse(<?php echo $value['goo_id']; ?>)">驳回</a>
                        <?php } ?>
                    </em>
                </li>
                <?php endforeach ?>
            </ul>
            <!-- 分享列表 -->

        </div>
        <!-- 产品分享 -->

        <!-- 分页 -->
        <div class="page">
            <?php echo $this->pages->link_style_one($this->router->url('share_showlist-'.$a_view_data['state'].'-', [], false, false)); ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->

        <!--  重要提示 -->
        <div class="deleTips" style="display:none;">
            <em>重要提示</em>
            <img src="static/style_default/image/pro_19.png" alt=""/>
            <p>
                <span>▪ 确认要搁置此分享申请吗？</span>
                <span>▪ 搁置后可在搁置列表中查看！</span>
                </p>
                <div class="deleTipsBtn">
                    <em>确定</em>
                    <a>再看看</a>
                </div>
        </div>

        <div class="applyTips" style="display:none;">
            <em class="see_em"></em>
            <img src="static/style_default/image/pro_19.png" alt=""/>
            <p>
                <span class="see_span1"></span>
                <span class="see_span2"></span>
            </p>
            <div class="applyTipsBtn">
                <em>确定</em>
            </div>
        </div>

       <div class="rejectReason" style="display:none;">
            <em>重要提示</em>
            <img src="static/style_default/image/pro_19.png"/>
            <form action="share_refuse" method="post">
                <input type="hidden" name="goo_id2">
                <p>
                    <span>*确认要驳回此分享申请吗？</span>
                    <span>理由：<input type="text" name="liyou" style="padding:5px; border:1px solid #ddd; font-size:12px;" placeholder="输入驳回理由"/></span>
                </p>
                <div class="rejectReasonTipsBtn">
                    <input type="submit" id="rejectSub" value="确定"/>
                </div>
            </form>
        </div>

        <div class="adoptReason" style="display:none;">
            <em>重要提示</em>
            <img src="static/style_default/image/pro_19.png"/>
            <form action="share_adopt" method="post">
                <input type="hidden" name="goo_id" >
                <p>
                    <span>*确认要通过此产品的申请吗？</span>
                    <span>理由：<input type="text" name="liyou" style="padding:5px; border:1px solid #ddd; font-size:12px;" placeholder="输入通过理由"/></span>
                </p>
                <div class="adoptReasonTipsBtn">
                    <input type="submit" id="adoptSub" value="确定"/>
                </div>
            </form>
        </div>
        <!--  重要提示 -->

        <!-- 遮罩层 -->
        <div class="lay"></div>
        <!-- 遮罩层 -->
    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>

<script>

// 通过申请
function share_adopt(goo_id) {
    $('.adoptReason').show();
    $("input[name='goo_id']").val(goo_id);
    $('.adoptReason img').click(function(event) {
        $('.adoptReason').hide();
    });
}

// 驳回申请
function share_refuse(goo_id) {
    $('.rejectReason').show();
    $("input[name='goo_id2']").val(goo_id);
    $('.rejectReason img').click(function(event) {
        $('.rejectReason').hide();
    });
}

// 搁置申请
function share_shelve(goo_id) {
    $('.deleTips').show();
    $('.deleTipsBtn em').click(function(event) {
        $.ajax({
            url: 'share_shelve',
            type: 'POST',
            dataType: 'json',
            data: {goo_id: goo_id},
            success: function (res) {
                console.log(res);
                if (res.code == 200) {
                    $('#v7_'+goo_id).html('<a class="adopt" onclick="share_adopt('+goo_id+')">通过</a>&nbsp;&nbsp;<a class="reject" onclick="share_refuse('+goo_id+')">驳回</a>');
                }
            }
        })
        $('.deleTips').hide();
    });
    $('.deleTips img,.deleTipsBtn a').click(function(event) {
        $('.deleTips').hide();
    });
}

// 查看
function share_see(goo_id) {
    $.ajax({
        url: 'share_see',
        type: 'POST',
        dataType: 'json',
        data: {goo_id: goo_id},
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                if (res.data.state == 2) {
                    $('.see_em').html('已通过此分享申请');
                    $('.see_span1').html('理由：' + res.data.liyou);
                    $('.see_span2').html('批准时间：' + res.data.time);
                } else if (res.data.state == 3) {
                    $('.see_em').html('已驳回此分享申请');
                    $('.see_span1').html('理由：' + res.data.liyou);
                    $('.see_span2').html('驳回时间：' + res.data.time);
                }
                $('.applyTips').show();
            }
        }
    })
    $('.applyTips img,.applyTipsBtn em').click(function(event) {
        $('.applyTips').hide();
    });
}

</script>
