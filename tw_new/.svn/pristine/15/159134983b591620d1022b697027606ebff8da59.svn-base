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
    <link rel="stylesheet" href="./static/style_default/style/accountingAmount.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/accountingAmount.js"></script>
    <title></title>
    <script>
        $(function(){
            $(".priceHelp").click(function(){
                $(".accountBox").show().delay(3000).hide(300).fadeOut();
            })
        })
    </script>
</head>
<body style="background:#efefef;">
<!--  后台管理 -->
<div class="productClassification">
    <!--  右侧内容 -->
    <article>
        <!-- 核算金额 -->
        <div class="accountingAmount">
            <!-- 修改核算金额 -->
            <div class="accountAm ">
                <p>
                    <span>核算金额(不能核算当前月份)</span>
                </p>
                <form action="<?php echo $this->router->url('account_update'); ?>" method="POST">
                    <input type="hidden" name="account_id" value="<?php echo $a_view_data['account_id']; ?>">
                    <ul>
                        <li class="totalAccount">
                            <span>核算金额</span>
                            <p><em><?php echo $a_view_data['money_count']; ?></em> 元</p>
                        </li>
                        <input type="hidden" name="is_correct" value="1">
                        <li class="correct">
                            <span>是否正确</span>
                            <em class="sure" value="1">
                                <img src="./static/style_default/image/pro_38.png" /> 是
                            </em>
                            <em class="deny" value="2">
                                <img src="./static/style_default/image/pro_38.png" /> 否
                            </em>
                            <img style="vertical-align:middle;" />
                        </li>
                        <li class="editPrice">
                            <span>修改金额</span>
                            <input type="text" name="money_update" id="edit_Price" onkeyup="value=value.replace(/[^\d.]/g,'')" />
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                                <em class="hide">
                                    系统核算金额<s class="totalNum" style="color:red; text-decoration:none;"><?php echo $a_view_data['money_count']; ?></s>元,<dfn style="font-style:normal;" class="pointNumText">减少了</dfn><span class="calculationNum" style="color:red"></span>元
                                </em>
                            </em>
                        </li>
                        <li class="accountRemarks">
                            <span>备注</span>
                            <textarea name="remark_update" id="account_remarks" cols="30" rows="10" placeholder="请对积分盈余加减进行备注.."></textarea>
                            <em class="hide">
                                <img src="./static/style_default/image/t_03.png" />
                                <span></span>
                            </em>
                        </li>
                    </ul>
                    <!--<input type="submit" id="editPointsSub" value="确定"/>-->
                </form>
                <span id="accountSub">确定</span>
            </div>
            <!-- 修改核算金额 -->
        </div>
        <!-- 核算金额 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>