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
    <link rel="stylesheet" href="static/style_default/style/integralManagement.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/integralManagement.js"></script>
    <title></title>
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
                    <img src="static/style_default/image/po_03.png" alt=""/>
                    <em>
                        <h3>积分总盈余</h3>
                        <span><?php echo $a_view_data['score']?></span>
                    </em>
                </a>
                <a>
                    <img src="static/style_default/image/po_05.png" alt=""/>
                    <em>
                        <h3>积分总抵现</h3>
                        <span><?php echo $a_view_data['order']?></span>
                    </em>
                </a>
                <a>
                    <img src="static/style_default/image/po_07.png" alt=""/>
                    <em>
                        <h3>积分总提现</h3>
                        <span><?php echo $a_view_data['poi']?></span>
                    </em>
                </a>             
                <!-- <a>
                    <img src="static/style_default/image/po_09.png" alt=""/>
                    <em>
                        <h3>积分总过期</h3>
                        <span>123,456</span>
                    </em>
                </a> -->
            </div>
            <!-- 积分用途 -->

            <!-- 积分列表 -->
            <div class="pointList">
                <form action="points" method='post' id="user">
                    <div class="searchPoint">
                        <input type="text" placeholder="用户名/手机号" onfocus="javascript:if(this.value=='')this.value='';" name="user" />
                        <i onclick="document.getElementById('user').submit();"><img src="static/style_default/image/s_03.png" alt=""/></i>
                    </div>
                </form>

                <ul class="pointListBox">
                    <li>
                        <?php foreach ($a_view_data['points'] as $points) {?>
                        <div class="pointListContent">
                            <img src="static/style_default/image/tt_03.png" alt=""/>
                            <em>
                                <h3><?php echo $points['user_name'];?></h3>
                                <span><?php echo $points['user_score'];?></span>
                            </em>
                            <i>
                                <img src="static/style_default/image/po_16.png" alt=""/>
                                <div class="toolBox hide">
                                    <em class="editPoints" onclick="user_id(<?php echo $points['user_id']?>)">
                                        <img src="static/style_default/image/pro_28.png" alt=""/>
                                        <span>增减积分</span>
                                    </em>
                                    <em class="lookPoints">
                                        <img src="static/style_default/image/pro_28.png" alt=""/>
                                        <span><a href="points_detail-<?php echo $points['user_id']?>">积分明细</a></span>
                                    </em>
                                </div>
                            </i>
                        </div>
                        <?php }?>
                    </li>

                </ul>
                <!-- 分页 -->
                <div class="page">
                  <!-- <ul>
                        <li><a href="" class="prevPage"><img src="static/style_default/image/np_03.png" alt=""/></a></li>
                        <li><a href="" class="pageCur">1</a></li>
                        <li><a href="" class="">2</a></li>
                        <li><a href="" class="">3</a></li>
                        <li><a href="" class="">4</a></li>
                        <li><a href="" class="">5</a></li>
                        <li><a style="background:none;">...</a></li>
                        <li><a href="" class="">10</a></li>
                        <li><a href="" class="nextPage"><img src="static/style_default/image/np_05.png" alt=""/></a></li>
                        <li><a style="background:none;">共计<em> 56 </em>条数据</a></li>
                    </ul> -->
                    <?php echo $a_view_data['page']?>
                </div>
                <!-- 分页 -->
               
                <!-- 修改积分盈余 -->
                <div class="editPoint hide">
                    <p>
                        <span>修改积分盈余</span>
                        <img src="static/style_default/image/pro_19.png" class="closePoint" alt=""/>
                    </p>
                    <form action="">
                        <ul>
                            <li class="pointsSurplus">
                                <span>积分盈余</span>
                                <input type="text" id="points_surplus" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/>
                                <em class="hide">
                                    <img src="static/style_default/image/t_03.png" alt=""/>
                                    <span>
                                    </span>
                                    <em class="hide">
                                        原积分盈余<s class="totalNum" style="color:red; text-decoration:none;"></s>,<dfn style="font-style:normal;" class="pointNumText">减少了</dfn><span class="calculationNum" style="color:red"></span>
                                    </em>
                                </em>
                            </li>
                            <input type="hidden" value="" class="user_id">
                            <li class="pointsRemarks">
                                <span>备注</span>
                                <textarea name="" id="points_remarks" cols="30" rows="10" placeholder="请对积分盈余加减进行备注.." value=""></textarea>
                                <em class="hide">
                                    <img src="static/style_default/image/t_03.png" alt=""/>
                                    <span></span>
                                </em>
                            </li>
                        </ul>
                        <!-- <input type="submit" id="editPointsSub" value="确定"/> -->
                    </form>
                    <span id="editPointsSub">确定</span>
                </div>
                <!-- 修改积分盈余 -->
            </div>
            <!-- 积分列表 -->

            <!--  重要提示 -->
            <div class="tips hide">
                <em>重要提示</em>
                <img src="static/style_default/image/pro_19.png" alt="" class="notsure" />
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
                    <img src="static/style_default/image/f_03.png" alt=""/>
                    <span>信息不完整！</span>
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
	function user_id(user_id) {
        $("#points_surplus").next("em").addClass("hide");
        $('#points_surplus').val("").focus();
         $('.user_id').val();
        $.ajax({
            url: "points_update",
            type: 'POST',
            dataType: 'json',
            data: {id: user_id},
            success: function(data) {
                $('.totalNum').text( data.user_score);
            }
        })
        $('.user_id').val(user_id);
    }
</script>