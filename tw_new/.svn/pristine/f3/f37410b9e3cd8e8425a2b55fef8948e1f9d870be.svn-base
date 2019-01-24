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
    <link rel="stylesheet" href="static/style_default/style/applyDetail.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/joinApp.js"></script>
    <title>申请详情</title>
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

        <!-- 申请详情 -->
        <div class="applyDetail">
            <p> <a href="join_showlist" style="color:#000;">加盟申请</a> > 申请详情</p>
            <div class="applyContainer">
                <div class="applyLeft">
                    <!-- 申请人信息 -->
                    <dl class="applyerInfo">
                        <dt>联系人信息</dt>
                        <dd>
                            <span>账号名：</span>
                            <em><?php echo $a_view_data['user_name']; ?></em>
                        </dd>
                        <dd>
                            <span>姓名：</span>
                            <em><?php echo $a_view_data['join_linkman']; ?></em>
                        </dd>
                        <dd>
                            <span>手机号码：</span>
                            <em><?php echo $a_view_data['join_phone']; ?></em>
                        </dd>
                    </dl>
                    <!-- 申请人信息 -->
                    <dl class="applyerInfo">
                        <dt>法人信息</dt>
                        <dd>
                            <span>姓名：</span>
                            <em><?php echo $a_view_data['join_corporation']; ?></em>
                        </dd>
                        <dd>
                            <span>身份证号码：</span>
                            <em><?php echo $a_view_data['join_idcard']; ?></em>
                        </dd>
                    </dl>
                    <!-- 申请人信息 -->
                    <!-- 申请时间 -->
                    <dl class="applyTime">
                        <dt>申请时间</dt>
                        <dd>
                            <span><?php echo date('Y-m-d H:i:s', $a_view_data['join_time']); ?></span>
                        </dd>
                    </dl>
                    <!-- 申请时间 -->
                    <!-- 法人身份证照片-->
                    <dl class="applyLegal">
                        <dt>法人身份证照片</dt>
                        <dd>
                            <?php if (!empty($a_view_data['join_idcardpic'])) {
                                $join_idcardpic = explode(',', $a_view_data['join_idcardpic']);
                                for ($i=0; $i < count($join_idcardpic); $i++) {
                                    echo '<img src="'.get_config_item('vdao_mobile').$join_idcardpic[$i].'">';
                                }
                            } ?>
                        </dd>
                    </dl>
                    <!-- 法人身份证照片-->
                    <!-- 门店信息-->
                    <dl class="storeInfo">
                        <dt>门店信息</dt>
                        <dd>
                            <span>营业执照注册号：</span>
                            <em><?php echo $a_view_data['join_regmark']; ?></em>
                        </dd>
                        <dd>
                            <span>执照有效期：</span>
                            <em>
                            <?php if ($a_view_data['join_expirydate'] == 9) {
                                echo '长期有效';
                            } else {
                                echo date('Y-m-d H:i:s', $a_view_data['join_expirydate']);
                            } ?>
                            </em>
                        </dd>
                        <dd>
                            <span>门店面积：</span>
                            <em>5<?php echo $a_view_data['join_size']; ?>m² </em>
                        </dd>
                        <dd>
                            <span>门店楼层：</span>
                            <em><?php echo $a_view_data['join_floor']; ?></em>
                        </dd>
                        <dd>
                            <span>门店人流量：</span>
                            <em><?php echo $a_view_data['join_passenger']; ?>/天</em>
                        </dd>
                        <dd>
                            <span>门店地址：</span>
                            <em><?php echo $a_view_data['join_province'].$a_view_data['join_city'].$a_view_data['join_district'].$a_view_data['join_address']; ?></em>
                        </dd>
                    </dl>
                    <!-- 门店信息-->
                </div>
                <div class="line"></div>
                <div class="applyRight">
                    <!-- 营业执照照片-->
                    <dl class="applyLegal">
                        <dt>营业执照照片</dt>
                        <dd>
                            <?php if (!empty($a_view_data['join_licence'])) {
                                $join_licence = explode(',', $a_view_data['join_licence']);
                                for ($i=0; $i < count($join_licence); $i++) {
                                    echo '<img src="'.get_config_item('vdao_mobile').$join_licence[$i].'">';
                                    echo '<br>';
                                }
                            } ?>
                        </dd>
                    </dl>
                    <!-- 营业执照照片-->
                </div>
            </div>
        </div>
        <!-- 申请详情  -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>