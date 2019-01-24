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
            <p>提现问题记录列表</p>
            <!-- 店主列表 -->
<!--            <div class="apply_content">-->
<!--                <form action="--><?php //echo $this->router->url('withdraw_logs')?><!--" method='post' id="formId">-->
<!--                    <div class="search_apply">-->
<!--                        <input type="text" placeholder="--><?php //if (empty($a_view_data['name'])) { echo "用户名/手机号";} else {echo $a_view_data['name'];}?><!--" name="name" />-->
<!--                        <i onclick="document.getElementById('formId').submit();"><img src="static/style_default/image/s_03.png" alt=""/></i>-->
<!--                    </div>-->
<!--                </form>-->
<!--            </div>-->
            <ul class="applyList">
                <li class="cateHead">
                    <em class="v1">用户名</em>
                    <em class="v2">联系电话</em>
                    <em class="v3">提现方式</em>
                    <em class="v4">提现明文错误</em>
                    <em class="v5">提现错误码</em>
<!--                    <em class="v6">提现code</em>-->
                    <em class="v7">错误时间</em>
<!--                    <em class="v9">操作</em>-->
                </li>
                <?php foreach ($a_view_data['data'] as $data) {?>
                    <li class="cateBody">
                        <em class="v1" >
                            <div class="applyInfo">
                                <p>
                                    <em><?php echo $data['user_name']?></em>
                                    <!-- <span>2017-09-22</span> -->
                                </p>
                            </div>
                        </em>
                        <em class="v2"><?php echo $data['user_phone']?></em>
                        <em class="v3"><?php echo $data['payment']?></em>
                        <em class="v4"><?php echo $data['error_content']?></em>
                        <em class="v5"><?php echo $data['error_code']?></em>
<!--                        <em class="v6">--><?php //echo $data['sub_code']?><!--</em>-->
                        <em class="v7"><?php echo $data['wdtime']?></em>

<!--                        <em class="v9 stye_--><?php //echo $data['w_id']?><!--">-->
<!---->
<!--                                <a class="adopt" value="--><?php //echo $data['w_id']?><!--">通过</a>-->
<!--                                <a class="shelve" value="--><?php //echo $data['w_id']?><!--">搁置</a>-->
<!--                                <a class="reject" value="--><?php //echo $data['w_id']?><!--">驳回</a>-->
<!---->
<!--                        </em>-->
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