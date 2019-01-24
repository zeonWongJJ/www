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
    <link rel="stylesheet" href="static/style_default/style/credentialApply.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/credentialApply.js"></script>
    <title>资质申请</title>
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

        <!-- 资质申请内容 -->
        <div class="credentialApply">
            <p>资质申请</p>
            <!-- 店主列表 -->
            <div class="apply_content">
                <form action="<?php echo $this->router->url('qualifi')?>" method='post' id="formId">
                    <div class="search_apply">
                        <input type="text" placeholder="<?php if (empty($a_view_data['name'])) { echo "用户名/手机号";} else {echo $a_view_data['name'];}?>" name="name" />
                        <i onclick="document.getElementById('formId').submit();"><img src="static/style_default/image/s_03.png" alt=""/></i>
                    </div>
                </form>
            </div>
            <ul class="applyList">
                <li class="cateHead">
                    <em class="v1">用户名</em>
                    <em class="v2">单位名称</em>
                    <em class="v3">法人姓名</em>
                    <em class="v4">联系电话</em>
                    <em class="v5">执照有效期</em>
                    <em class="v6">营业执照注册号</em>
                    <em class="v7">申请时间</em>
                    <em class="v8 stateBox" style="">
                        <span><?php if ($a_view_data['i_one'] == 0) {
                           echo "全部状态";
                        } else if ($a_view_data['i_one'] == 1) {
                            echo "申请中";
                        } else if ($a_view_data['i_one'] == 2) {
                            echo "已通过";
                        } else if ($a_view_data['i_one'] == 3) {
                            echo "已驳回";
                        } else if ($a_view_data['i_one'] == 4) {
                            echo "已搁置";
                        }?></span>
                        <img src="static/style_default/image/pro_13.png" alt=""/>
                        <div class="state hide">
                            <a href="qualifi-0-<?php echo $a_view_data['name']?>">全部状态</a>
                            <a href="qualifi-1-<?php echo $a_view_data['name']?>">申请中</a>
                            <a href="qualifi-2-<?php echo $a_view_data['name']?>">已通过</a>
                            <a href="qualifi-3-<?php echo $a_view_data['name']?>">已驳回</a>
                            <a href="qualifi-4-<?php echo $a_view_data['name']?>">已搁置</a>
                        </div>
                    </em>
                    <em class="v9">操作</em>
                </li>
                <?php foreach ($a_view_data['goods'] as $goods) {?>
                <li class="cateBody">
                    <em class="v1" style="text-align:left;">
                        <div class="applyInfo">
                            <?php if (empty($goods['user_pic'])) {
                                echo '<img src="./static/style_default/image/tt_03.png" />';
                            } else if(strpos($goods['user_pic'], 'http') === false) {
                                echo '<img src="'.get_config_item('vdao_mobile').$goods['user_pic'].'" />';
                            } else {
                                echo '<img src="'.$goods['user_pic'].'" />';
                            } ?>
                            <p>
                                <em><?php echo $goods['user_name']?></em>
                                <!-- <span>2017-09-22</span> -->
                            </p>
                        </div>
                    </em>
                    <em class="v2"><?php echo $goods['business_name']?></em>
                    <em class="v3"><?php echo $goods['unit_legal_name']?></em>
                    <em class="v4"><?php echo $goods['phone']?></em>
                    <em class="v5"><?php if ($goods['business_imt'] == 9) {
                        echo "长期有效";
                    } else { echo date('Y-m-d', $goods['business_imt']);}?></em>
                    <em class="v6"><?php echo $goods['business_hao']?></em>
                    <em class="v7"><?php echo date('Y-m-d', $goods['add_time'])?></em>
                    <em class="v8">
                        <span class="audit_<?php echo $goods['qua_id']?>"><?php if ($goods['audit'] == 1) {
                            echo "待审核";
                        } else if ($goods['audit'] == 2) {
                            echo "已通过";
                        } else if ($goods['audit'] == 3) {
                            echo "已驳回";
                        } else if ($goods['audit'] == 4) {
                            echo "已搁置";
                        }?></span><br/>
                        <a href="qualifi_list-<?php echo $goods['qua_id']?>">查看详情</a>
                    </em>
                    <em class="v9 stye_<?php echo $goods['qua_id']?>">
                        <?php if ($goods['audit'] == 1) {?>
                            <a class="adopt" value="<?php echo $goods['qua_id']?>">通过</a>
                            <a class="shelve" value="<?php echo $goods['qua_id']?>">搁置</a>
                            <a class="reject" value="<?php echo $goods['qua_id']?>">驳回</a>
                        <?php } else if ($goods['audit'] == 2) {?>
                            <a class="see ton" value="<?php echo $goods['qua_id']?>">查看</a>
                        <?php } else if ($goods['audit'] == 3) {?>
                            <a class="see bo" value="<?php echo $goods['qua_id']?>">查看</a>
                        <?php } else if ($goods['audit'] == 4) {?>
                            <a class="adopt" value="<?php echo $goods['qua_id']?>">通过</a>
                            <a class="reject" value="<?php echo $goods['qua_id']?>">驳回</a>
                        <?php }?>     
                    </em>
                </li>
                <?php }?>
            </ul>
            <!-- 加盟申请内容 -->

        </div>
        <!-- 资质申请内容 -->

        <!-- 分页 -->
        <div class="page">
            <?php echo $a_view_data['pages']?>
            <span style="background:none">共计<em> <?php echo $a_view_data['i_total']?> </em>条数据</span>
            <script>
                $(function(){
                    $('.page a').each(function(index, el) {
                        if ($(this).attr('href') == '#') {
                            $(this).css('background-color','#6e5c58');
                            $(this).css('color','#ffffff');
                        }
                    });
                })
            </script>
        </div>
        <!-- 分页 -->

        <!--  重要提示 -->
        <div class="deleTips">
            <em>重要提示</em>
            <img src="static/style_default/image/pro_19.png" alt=""/>
            <p>
                <span>▪ 确认删除此部分申请信息？</span>
                <span>▪ 删除后不可恢复！</span>
                </p>
                <div class="deleTipsBtn">
                    <em>确定</em>
                    <a>再看看</a>
                </div>
        </div>

        <div class="applyTips">
            <em>已通过此加盟申请</em>
            <img src="static/style_default/image/pro_19.png" alt=""/>
            <p>
                <span>理由：资质达标，已通过</span>
                <span>批准时间：2017-10-10  21:00</span>
            </p>
            <div class="applyTipsBtn">
                <em>确定</em>
            </div>
        </div>

       <div class="rejectReason">
            <em>重要提示</em>
            <img src="static/style_default/image/pro_19.png" alt=""/>
            <!-- <form action=""> -->
                <p>
                    <span>*确认要驳回此加盟申请吗？</span>
                    <span>理由：<input type="text" style="padding:5px; border:1px solid #ddd; font-size:12px;" placeholder="输入驳回理由" name="bohui" /></span>
                </p>
                <div class="rejectReasonTipsBtn">
                    <input type="submit" id="rejectSub" value="确定"/>
                </div>
            <!-- </form> -->
        </div>

        <div class="adoptReason">
            <em>重要提示</em>
            <img src="static/style_default/image/pro_19.png" alt=""/>
            <!-- <form action=""> -->
                <p>
                    <span>*确认要通过此加盟申请吗？</span>
                    <span>理由：<input type="text" style="padding:5px; border:1px solid #ddd; font-size:12px;" placeholder="输入通过理由" name="ton" /></span>
                </p>
                <div class="adoptReasonTipsBtn">
                    <input type="submit" id="adoptSub" value="确定"/>
                </div>
            <!-- </form> -->
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