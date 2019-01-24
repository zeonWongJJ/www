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
    <link rel="stylesheet" href="./static/style_default/style/integralManagement.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/integralManagement.js"></script>
    <title>积分管理</title>
</head>
<body style="background:#efefef;">
<!--  后台管理 -->
<div class="productClassification">
    <?php echo $this->display('header'); ?>
    <!--  右侧内容 -->·z
    <article>
        <!--  标题 -->
        <?php echo $this->display('top'); ?>
        <!--  标题 -->

        <!-- 积分管理 -->
        <div class="integralManagement">
            <p>积分管理</p>
            <!-- 积分用途 -->
            <div class="pointUse">
                <a>
                    <img src="static/style_default/image/po_03.png" />
                    <em>
                        <h3>积分总量</h3>
                        <span><?php echo $a_view_data['total']; ?></span>
                    </em>
                </a>
                <a>
                    <img src="static/style_default/image/po_05.png" />
                    <em>
                        <h3>积分总抵现</h3>
                        <span><?php echo $a_view_data['dike']; ?></span>
                    </em>
                </a>
                <a>
                    <img src="static/style_default/image/po_07.png" />
                    <em>
                        <h3>积分总提现</h3>
                        <span><?php echo $a_view_data['tixian']; ?></span>
                    </em>
                </a>
                <a>
                    <img src="static/style_default/image/po_09.png" />
                    <em>
                        <h3>积分总使用</h3>
                        <span><?php echo $a_view_data['shiyong']; ?></span>
                    </em>
                </a>
            </div>
            <!-- 积分用途 -->

            <!-- 积分列表 -->
            <div class="pointList">
                <form action="score_showlist" method="post" id="userPoints">
                    <div class="searchPoint">
                        <input type="text" name="keywords" placeholder="用户名/手机号" value="<?php if ($a_view_data['keywords'] != 9) { echo $a_view_data['keywords']; } ?>" />
                        <i onclick="document.getElementById('userPoints').submit();"><img  src="static/style_default/image/s_03.png"/></i>
                    </div>
                </form>

                <ul class="pointListBox">
                    <li>
                        <?php foreach ($a_view_data['score'] as $key => $value): ?>
                        <div class="pointListContent">
                            <?php if (empty($value['user_pic'])) {
                                echo '<img src="./static/style_default/image/tt_03.png" />';
                            } else if(strpos($value['user_pic'], 'http') === false) {
                                echo '<img width="50"  height="50" src="'.get_config_item('vdao_mobile').$value['user_pic'].'" />';
                            } else {
                                echo '<img width="50"  height="50" src="'.$value['user_pic'].'" />';
                            } ?>
                            <em>
                                <h3><?php echo $value['user_name']; ?></h3>
                                <span><?php echo $value['user_score']; ?></span>
                            </em>
                            <i>
                                <img src="static/style_default/image/po_16.png" />
                                <div class="toolBox hide">
                                    <em class="editPoints" style="cursor:pointer;" value="<?php echo $value['user_score']; ?>" uid="<?php echo $value['user_id']; ?>">
                                        <img src="static/style_default/image/pro_28.png" />
                                        <span>增减积分</span>
                                    </em>
                                    <em class="lookPoints" style="cursor:pointer;" onclick="score_detail(<?php echo $value['user_id']; ?>)">
                                        <img src="static/style_default/image/pro_28.png" />
                                        <span>积分明细</span>
                                    </em>
                                </div>
                            </i>
                        </div>
                        <?php endforeach ?>
                    </li>
                </ul>

                <!-- 分页 -->
                <div class="page">
                    <?php echo $this->pages->link_style_one($this->router->url('score_showlist-'.$a_view_data['keywords'].'-', [], false, false)); ?>
                    <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
                </div>
                <!-- 分页 -->

                <!-- 修改积分盈余 -->
                <div class="editPoint hide">
                    <p>
                        <span>修改积分盈余</span>
                        <img src="static/style_default/image/pro_19.png" class="closePoint" />
                    </p>
                    <form action="score_update" method="post">
                        <ul>
                            <input type="hidden" name="user_id">
                            <li class="pointsSurplus">
                                <span>积分盈余</span>
                                <input type="text" name="score_update" id="points_surplus" onkeyup="clearNoNum(this);" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/>
                                <em class="hide">
                                    <img src="static/style_default/image/t_03.png" />
                                    <span>
                                    </span>
                                    <em class="hide">
                                        原积分盈余<s class="totalNum" style="color:red; text-decoration:none;">123456</s>,<dfn style="font-style:normal;" class="pointNumText">减少了</dfn><span class="calculationNum" style="color:red"></span>
                                    </em>
                                </em>
                            </li>
                            <li class="pointsRemarks">
                                <span>备注</span>
                                <textarea name="pl_description" id="points_remarks" cols="30" rows="10" placeholder="请对积分盈余加减进行备注.."></textarea>
                                <em class="hide">
                                    <img src="static/style_default/image/t_03.png" />
                                    <span></span>
                                </em>
                            </li>
                        </ul>
                        <!--<input type="submit" id="editPointsSub" value="确定"/>-->
                    </form>
                    <span id="editPointsSub">确定</span>
                </div>
                <!-- 修改积分盈余 -->
            </div>
            <!-- 积分列表 -->

            <!--  重要提示 -->
            <div class="tips hide">
                <em>重要提示</em>
                <img src="static/style_default/image/pro_19.png" class="thinkpic" />
                <p>
                    <span>▪ 确定要退出吗？</span>
                    <span>▪ 已编辑的内容将不做保存</span>
                </p>
                <div class="tipsBtn">
                    <em class="ensure">确定</em>
                    <a class="notsure">再看看</a>
                </div>
            </div>

            <div class="subWrong hide">
                <p>
                    <img src="static/style_default/image/f_03.png" />
                    <span>输入的格式有误！</span>
                </p>
                <em class="subSure">确定</em>
            </div>
            <!--  重要提示 -->
        </div>
        <!-- 积分管理 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>

<script>

// 积分明细
function score_detail(user_id) {
    window.location.href = "score_detail-"+user_id;
}

// 搜索
// function score_search() {
//     var keywords = $("input[name='keywords']").val();
//     console.log(keywords);
//     if (keywords != '') {
//         window.location.href = "score_showlist-"+keywords;
//     } else {
//         window.location.href = "score_showlist";
//     }
// }

 function clearNoNum(obj) {  
    obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符  
        obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字而不是  
        obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的  
        obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");  
        obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); //只能输入两个小数  

}

</script>