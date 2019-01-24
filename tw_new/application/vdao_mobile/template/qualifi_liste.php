<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/authentication.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <title>资质认证</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 资质认证 -->
    <div class="authentication">
        <p class="pjoTitle">
            <a href="<?php echo $this->router->url('myshare')?>"><img src="static/style_default/images/gouxiang_18.png" alt=""/></a>
            <span>资质认证</span>
        </p>
        <div class="companyContainer">
            <dl>
                <dt>
                    <img src="static/style_default/images/com.png" alt=""/>
                    <em class="companyInfo">
                        <h1><?php echo $a_view_data['business_name']?></h1>
                        <p><?php echo $a_view_data['unit_address']?></p>
                        <dfn class="companySta suc"><?php if($a_view_data['audit'] == 1) {
                                echo "等待审核";
                            } else if ($a_view_data['audit'] == 2) {
                               echo "通过";
                            } else if ($a_view_data['audit'] == 3) {
                               echo "驳回";
                            } else if ($a_view_data['audit'] == 5) {
                               echo "草稿";
                            }?></dfn>
                    </em>
                </dt>
                <dd>
                    <span>注册号</span>
                    <em><?php echo $a_view_data['business_hao']?></em>
                </dd>
                <dd >
                    <span>法人</span>
                    <em><?php echo $a_view_data['unit_legal_name']?></em>
                </dd>
                <dd>
                    <span>有效期</span>
                    <em><?php echo $a_view_data['business_imt']?></em>
                </dd>
            </dl>
        </div>
        <!-- 其他信息 -->
        <div class="otherInfo">
            <dl>
                <dt>其他信息</dt>
                <?php if ($a_view_data['applicant'] == 1) {?>
                    <dd>
                        <span>申请人</span>
                        <em><?php echo $a_view_data['unit_legal_name']?></em>
                    </dd>

                    <dd>
                        <span>法人身份证号</span>
                        <em><?php echo $a_view_data['unit_legal_number']?></em>
                    </dd>
                <?php } else {?>
                    <dd>
                        <span>申请人</span>
                        <em><?php echo $a_view_data['applicant_name']?></em>
                    </dd>

                    <dd>
                        <span>法人身份证号</span>
                        <em><?php echo $a_view_data['unit_legal_number']?></em>
                    </dd>
                    <dd>
                        <span>申请人身份证号</span>
                        <em><?php echo $a_view_data['applicant_number']?></em>
                    </dd>
                <?php }?>
                    <dd>
                        <span>联系电话</span>
                        <em><?php echo $a_view_data['phone']?></em>
                    </dd>
            </dl>
            <a href="qualifi_up-<?php echo $a_view_data['qua_id']?>" class="changeInfo"><span>变更认证信息</span></a>
        </div>
        <!-- 其他信息 -->
    </div>
    <!-- 资质认证 -->
</body>
</html>