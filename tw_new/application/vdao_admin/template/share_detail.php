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
    <link rel="stylesheet" href="static/style_default/style/shareDetail.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
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
        <div class="shareDetail">
            <p> <a href="share_showlist" style="color:#000;">产品分享</a> > 申请详情</p>
            <div class="shareContainer">
                <div class="shareLeft">
                    <!-- 产品信息 -->
                    <div class="productInfo">
                        <?php if (empty($a_view_data['goods']['pro_img'])) {
                            echo '<img src="static/style_default/image/tt_03.png" />';
                        } else {
                            echo '<img src="'.get_config_item('vdao_mobile').$a_view_data['goods']['pro_img'].'" />';
                        } ?>
                        <em>
                            <h1><?php echo $a_view_data['goods']['product_name']; ?></h1>
                            <p>￥<?php echo $a_view_data['goods']['price']; ?></p>
                            <span>
                                <dfn>配送费: ￥</dfn><i><?php echo $a_view_data['goods']['distribution']; ?></i>
                            </span>
                        </em>
                    </div>
                    <!-- 产品信息 -->
                    <!-- 产品介绍-->
                    <dl class="productIntroduce">
                        <dt>产品介绍</dt>
                        <dd>
                            <?php
                                $subject = strip_tags($a_view_data['goods']['pro_details']); //去除html标签
                                $pattern = '/\s/'; //去除空白
                                $content = preg_replace($pattern, '', $subject);
                                // $seodata = mb_substr($content, 0, 60); //截取100个汉字
                                echo $content;
                            ?>
                        </dd>
                    </dl>
                    <!-- 产品介绍-->
                    <!-- 产品分类-->
                    <dl class="applyCate">
                        <dt>产品分类</dt>
                        <dd><?php echo $a_view_data['goods']['pro_name']; ?></dd>
                    </dl>
                    <!-- 产品分类-->
                    <!-- 生产许可证号-->
                    <dl class="licence">
                        <dt>生产许可证号</dt>
                        <dd><?php echo $a_view_data['goods']['goods_license']; ?></dd>
                    </dl>
                    <!-- 生产许可证号-->
                    <!-- 发货地址-->
                    <dl class="address">
                        <dt>发货地址</dt>
                        <dd><?php echo $a_view_data['goods']['join_province'].$a_view_data['goods']['join_city'].$a_view_data['goods']['join_district'].$a_view_data['goods']['addre']; ?></dd>
                    </dl>
                    <!-- 发货地址-->
                    <?php if ($a_view_data['qualifi']['applicant'] == 1) { ?>
                    <!-- 法人信息 -->
                    <dl class="lagalInfo">
                        <dt>法人信息</dt>
                        <dd>
                            <span>账号名：</span>
                            <em><?php echo $a_view_data['user']['user_name']; ?></em>
                        </dd>
                        <dd>
                            <span>姓名：</span>
                            <em><?php echo $a_view_data['qualifi']['unit_legal_name']; ?></em>
                        </dd>
                        <dd>
                            <span>手机号码：</span>
                            <em><?php echo $a_view_data['qualifi']['phone']; ?></em>
                        </dd>
                        <dd>
                            <span>身份证号码：</span>
                            <em><?php echo $a_view_data['qualifi']['unit_legal_number']; ?></em>
                        </dd>
                    </dl>
                    <!-- 法人信息 -->
                    <!-- 法人身份证照片-->
                    <dl class="shareLegal">
                        <dt>法人身份证照片</dt>
                        <dd>
                            <?php if (!empty($a_view_data['qualifi']['unit_legal_imge'])) {
                                $imgs = explode(',', $a_view_data['qualifi']['unit_legal_imge']);
                                for ($i=0; $i < count($imgs); $i++) {
                                    echo '<img src="'.$imgs[$i].'">';
                                }
                            } ?>
                        </dd>
                    </dl>
                    <!-- 法人身份证照片-->
                    <?php } else { ?>
                    <!-- 申请人信息 -->
                    <dl class="applyerInfo">
                        <dt>申请人信息</dt>
                        <dd>
                            <span>账号名：</span>
                            <em><?php echo $a_view_data['user']['user_name']; ?></em>
                        </dd>
                        <dd>
                            <span>姓名：</span>
                            <em><?php echo $a_view_data['qualifi']['applicant_name']; ?></em>
                        </dd>
                        <dd>
                            <span>手机号码：</span>
                            <em><?php echo $a_view_data['qualifi']['phone']; ?></em>
                        </dd>
                        <dd>
                            <span>身份证号码：</span>
                            <em><?php echo $a_view_data['qualifi']['applicant_number']; ?></em>
                        </dd>
                    </dl>
                    <!-- 申请人信息 -->
                    <!-- 申请人身份证照片-->
                    <dl class="applyInfo">
                        <dt>申请人身份证照片</dt>
                        <dd>
                            <?php if (!empty($a_view_data['qualifi']['applicant_imge'])) {
                                $imgs = explode(',', $a_view_data['qualifi']['applicant_imge']);
                                for ($i=0; $i < count($imgs); $i++) {
                                    echo '<img src="'.$imgs[$i].'">';
                                }
                            } ?>
                        </dd>
                    </dl>
                    <!-- 申请人身份证照片-->
                <?php } ?>
                </div>
                <div class="line"></div>
                <div class="shareRight">
                    <!-- 申请时间 -->
                    <dl class="applyTime">
                        <dt>申请时间</dt>
                        <dd>
                            <span><?php echo date('Y-m-d H:i:s', $a_view_data['qualifi']['add_time']); ?></span>
                        </dd>
                    </dl>
                    <!-- 申请时间 -->
                    <?php if ($a_view_data['qualifi']['applicant'] == 2) { ?>
                    <!-- 法人信息 -->
                    <dl class="lagalInfo">
                        <dt>法人信息</dt>
                        <dd>
                            <span>姓名：</span>
                            <em><?php echo $a_view_data['qualifi']['unit_legal_name']; ?></em>
                        </dd>
                        <dd>
                            <span>身份证号码：</span>
                            <em><?php echo $a_view_data['qualifi']['unit_legal_number']; ?></em>
                        </dd>
                    </dl>
                    <!-- 法人信息 -->
                    <!-- 申请人身份证照片-->
                    <dl class="applyInfo">
                        <dt>法人身份证照片</dt>
                        <dd>
                            <?php if (!empty($a_view_data['qualifi']['unit_legal_imge'])) {
                                $imgs = explode(',', $a_view_data['qualifi']['unit_legal_imge']);
                                for ($i=0; $i < count($imgs); $i++) {
                                    echo '<img src="'.$imgs[$i].'">';
                                }
                            } ?>
                        </dd>
                    </dl>
                    <!-- 申请人身份证照片-->
                    <?php } ?>
                    <!-- 单位信息-->
                    <dl class="companyInfo">
                        <dt>单位信息</dt>
                        <dd>
                            <span>营业执照注册号：</span>
                            <em><?php echo $a_view_data['qualifi']['business_hao']; ?></em>
                        </dd>
                        <dd>
                            <span>执照有效期：</span>
                            <em>
                            <?php if ($a_view_data['qualifi']['business_imt'] == 9) {
                                echo '长期有效';
                            } else {
                                echo date('Y-m-d', $a_view_data['qualifi']['business_imt']);
                            } ?>
                            </em>
                        </dd>
                        <dd>
                            <span>执照名称：</span>
                            <em><?php echo $a_view_data['qualifi']['business_name']; ?></em>
                        </dd>
                        <dd>
                            <span>单位地址：</span>
                            <em><?php echo $a_view_data['qualifi']['unit_province'].$a_view_data['qualifi']['unit_city'].$a_view_data['qualifi']['unit_district'].$a_view_data['qualifi']['unit_address']; ?></em>
                        </dd>
                    </dl>
                    <!-- 单位信息-->
                    <!-- 营业执照照片-->
                    <dl class="applyLegal">
                        <dt>营业执照照片</dt>
                        <dd>
                            <?php if (!empty($a_view_data['qualifi']['business_imge'])) {
                                $imgs = explode(',', $a_view_data['qualifi']['business_imge']);
                                for ($i=0; $i < count($imgs); $i++) {
                                    echo '<img src="'.$imgs[$i].'">';
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