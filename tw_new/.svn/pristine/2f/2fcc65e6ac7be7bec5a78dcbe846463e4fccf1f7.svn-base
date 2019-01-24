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
    <link rel="stylesheet" href="static/style_default/style/credentialDetail.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <title>资质申请详情</title>
    <script>

    </script>
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

        <!-- 资质申请详情 -->
        <div class="credentialDetail">
            <p>资质申请 > 申请详情</p>
            <div class="credentiaContainer">
                <div class="credentiaLeft">
                    <!-- 申请人信息 -->
                    <?php if ($a_view_data['applicant'] == 1) {?>
                    <dl class="applyerInfo">
                        <dt>申请人信息</dt>
                        <dd>
                            <span>账号名：</span>
                            <em><?php echo $a_view_data['user_name']?></em>
                        </dd>
                        <dd>
                            <span>姓名：</span>
                            <em><?php echo $a_view_data['unit_legal_name']?></em>
                        </dd>
                        <dd>
                            <span>手机号码：</span>
                            <em><?php echo $a_view_data['phone']?></em>
                        </dd>
                        <dd>
                            <span>身份证号码：</span>
                            <em><?php echo $a_view_data['unit_legal_number']?></em>
                        </dd>
                    </dl>
                    <?php } else {?>
                    <dl class="applyerInfo">
                        <dt>申请人信息</dt>
                        <dd>
                            <span>账号名：</span>
                            <em><?php echo $a_view_data['user_name']?></em>
                        </dd>
                        <dd>
                            <span>姓名：</span>
                            <em><?php echo $a_view_data['applicant_name']?></em>
                        </dd>
                        <dd>
                            <span>手机号码：</span>
                            <em><?php echo $a_view_data['phone']?></em>
                        </dd>
                        <dd>
                            <span>身份证号码：</span>
                            <em><?php echo $a_view_data['applicant_number']?></em>
                        </dd>
                    </dl>
                    <!-- 申请人信息 -->
                    <!-- 申请人身份证照片-->
                    <dl class="applyInfo">
                        <dt>申请人身份证照片</dt>
                        <dd>
                            <img src="<?php echo get_config_item('vdao_mobile') . explode(",", $a_view_data['applicant_imge'])[0]?>" alt=""/>
                            <img src="<?php echo get_config_item('vdao_mobile') . explode(",", $a_view_data['applicant_imge'])[1]?>" alt=""/>
                        </dd>
                    </dl>
                    <?php }?>
                    <!-- 申请人身份证照片-->
                    <!-- 申请时间 -->
                    <dl class="applyTime">
                        <dt>申请时间</dt>
                        <dd>
                            <span><?php echo date('Y-m-d H:i', $a_view_data['add_time']);?></span>
                            <!-- <em>13:34</em> -->
                        </dd>
                    </dl>
                    <!-- 申请时间 -->
                     <?php if ($a_view_data['applicant'] == 2) {?>
                    <!-- 法人信息 -->
                    <dl class="lagalInfo">
                        <dt>法人信息</dt>
                        <dd>
                            <span>姓名：</span>
                            <em><?php echo $a_view_data['unit_legal_name']?></em>
                        </dd>
                        <dd>
                            <span>身份证号码：</span>
                            <em><?php echo $a_view_data['unit_legal_number']?></em>
                        </dd>
                    </dl>
                    <!-- 法人信息 -->
                    <?php }?>
                    <!-- 法人身份证照片-->
                    <dl class="credentiaLegal">
                        <dt>法人身份证照片</dt>
                        <dd>
                            <img src="<?php echo get_config_item('vdao_mobile') . explode(",", $a_view_data['unit_legal_imge'])[0]?>" alt=""/>
                            <img src="<?php echo get_config_item('vdao_mobile') . explode(",", $a_view_data['unit_legal_imge'])[1]?>" alt=""/>
                        </dd>
                    </dl>
                    <!-- 法人身份证照片-->

                </div>
                <div class="line"></div>
                <div class="credentiaRight">
                    <!-- 单位信息-->
                    <dl class="companyInfo">
                        <dt>单位信息</dt>
                        <dd>
                            <span>营业执照注册号：</span>
                            <em><?php echo $a_view_data['business_hao']?></em>
                        </dd>
                        <dd>
                            <span>执照有效期：</span>
                            <em><?php if ($a_view_data['business_imt'] == 9) {
                                echo "长期有效";
                            } else {echo date('Y-m-d', $a_view_data['business_imt']);}?></em>
                        </dd>
                        <dd>
                            <span>单位名称：</span>
                            <em><?php echo $a_view_data['business_name']?></em>
                        </dd>
                        <dd>
                            <span>单位地址：</span>
                            <em><?php echo $a_view_data['unit_province'] . $a_view_data['unit_city'] . $a_view_data['unit_district'] . $a_view_data['unit_address'] ?></em>
                        </dd>
                    </dl>
                    <!-- 单位信息-->
                    <!-- 营业执照照片-->
                    <dl class="credentiaLegal">
                        <dt>营业执照照片</dt>
                        <dd>
                            <img src="<?php echo get_config_item('vdao_mobile').$a_view_data['business_imge']?>" alt=""/>
                        </dd>
                    </dl>
                    <!-- 营业执照照片-->
                </div>
            </div>
        </div>
        <!-- 资质申请详情  -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>