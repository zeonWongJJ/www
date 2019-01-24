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
    <link rel="stylesheet" href="static/style_default/style/joinApp.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/joinApp.js"></script>
    <title>加盟列表</title>
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

        <!-- 加盟申请内容 -->
        <div class="joinApp">
            <p><a href="join_showlist" style="color:#000;">加盟申请</a> >
            <?php if ($a_view_data['type'] == 2) {
                echo '申请中';
            } else if ($a_view_data['type'] == 3) {
                echo '已通过';
            } else if ($a_view_data['type'] == 4) {
                echo '已搁置';
            } else if ($a_view_data['type'] == 5) {
                echo '已驳回';
            } else if ($a_view_data['type'] == 9) {
                echo '全部';
            }
            if ($a_view_data['keywords'] != 9) {
                echo ' > 搜索 [' . $a_view_data['keywords'] . ']';
            }
            ?>
            </p>
            <!-- 店主列表 -->
            <div class="join_content">
                <form action="">
                    <div class="search_join">
                        <input type="text" name="keywords" value="<?php if ($a_view_data['keywords'] != 9) { echo $a_view_data['keywords']; } ?>" placeholder="用户名/手机号"/>
                        <i><img src="static/style_default/image/s_03.png" onclick="join_search()" /></i>
                    </div>
                </form>
            </div>
            <ul class="joinList">
                <li class="cateHead">
                    <em class="v1" style="text-align:left;">

                    </em>
                    <em class="v2">申请人姓名</em>
                    <em class="v3">手机号码</em>
                    <em class="v4">法人姓名</em>
                    <em class="v5">营业执照注册号</em>
                    <em class="v6">执照有效期</em>
                    <em class="v7">申请时间</em>
                    <em class="v8 stateBox" style="">
                        <span>
                        <?php if ($a_view_data['type'] == 2) {
                            echo '申请中';
                        } else if ($a_view_data['type'] == 3) {
                            echo '已通过';
                        } else if ($a_view_data['type'] == 4) {
                            echo '已搁置';
                        } else if ($a_view_data['type'] == 5) {
                            echo '已驳回';
                        } else if ($a_view_data['type'] == 9) {
                            echo '全部状态';
                        } ?>
                        </span>
                        <img src="static/style_default/image/pro_13.png" />
                        <div class="state hide">
                            <a href="join_showlist">全部的</a>
                            <a href="join_showlist-2">申请中</a>
                            <a href="join_showlist-3">已通过</a>
                            <a href="join_showlist-4">已搁置</a>
                            <a href="join_showlist-5">已驳回</a>
                        </div>
                    </em>
                    <em class="v9">操作</em>
                </li>
                <?php foreach ($a_view_data['join'] as $key => $value): ?>
                <li class="cateBody">
                    <em class="v1" style="text-align:left;">
                        <div class="joinInfo">
                            <?php if (empty($value['user_pic'])) {
                                echo '<img src="./static/style_default/image/tt_03.png" />';
                            } else if(strpos($value['user_pic'], 'http') === false) {
                                echo '<img src="'.get_config_item('vdao_mobile').$value['user_pic'].'" />';
                            } else {
                                echo '<img src="'.$value['user_pic'].'" />';
                            } ?>
                            <p>
                                <em><?php echo $value['user_name']; ?></em>
                                <span><?php echo date('Y-m-d', $value['user_regtime']); ?></span>
                            </p>
                        </div>
                    </em>
                    <em class="v2"><?php echo $value['join_linkman']; ?></em>
                    <em class="v3"><?php echo $value['join_phone']; ?></em>
                    <em class="v4"><?php echo $value['join_corporation']; ?></em>
                    <em class="v5"><?php echo $value['join_regmark']; ?></em>
                    <em class="v6">
                    <?php if ($value['join_expirydate'] == 9) {
                        echo '长期有效';
                    } else {
                        echo date('Y-m-d', $value['join_expirydate']);
                    } ?>
                    </em>
                    <em class="v7"><?php echo date('Y-m-d', $value['join_time']); ?></em>
                    <em class="v8">
                        <span>
                        <?php if ($value['join_state'] == 2) {
                            echo '申请中';
                        } else if ($value['join_state'] == 3) {
                            echo '已通过';
                        } else if ($value['join_state'] == 4) {
                            echo '已搁置';
                        } else if ($value['join_state'] == 5) {
                            echo '已驳回';
                        } ?>
                        </span><br/>
                        <a href="join_detail-<?php echo $value['join_id']; ?>" value="<?php echo $value['join_id']; ?>">查看详情</a>
                    </em>
                    <em class="v9">
                      <?php if ($value['join_state'] == 2) {
                            echo '<a class="adopt" value="'.$value['join_id'].'">通过</a> ';
                            echo '<a class="shelve" onclick="join_shelve('.$value['join_id'].')">搁置</a> ';
                            echo '<a class="reject" value="'.$value['join_id'].'">驳回</a> ';
                        } else if ($value['join_state'] == 4) {
                            echo '<a class="adopt" value="'.$value['join_id'].'">通过</a> ';
                            echo '<a class="reject" value="'.$value['join_id'].'">驳回</a> ';
                        } else if ($value['join_state'] == 5) {
                            echo '<a class="adopt" value="'.$value['join_id'].'">通过</a> ';
                        } ?>
                        <a class="see" value="<?php echo $value['join_id']; ?>">查看</a>
                    </em>
                </li>
                <?php endforeach ?>
            </ul>
            <!-- 加盟申请内容 -->

        </div>
        <!-- 申请列表 -->

        <!--  底部选项 -->
<!--          <div class="bottomTool">
             <a class="bottomAllSelect">
                 <img src="static/style_default/image/pro_07.png" />
                 <span>全选</span>
             </a>
         <a class="bottomDelect">
                 <img src="static/style_default/image/pro_26.png" />
                 <span>删除</span>
             </a>
         </div> -->
        <!--  底部选项 -->

        <!-- 分页 -->
        <div class="page">
            <?php echo $this->pages->link_style_one($this->router->url('join_showlist-'.$a_view_data['type'].'-'.$a_view_data['keywords'].'-', [], false, false)); ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->

        <!--  重要提示 -->
        <div class="deleTips">
            <em>重要提示</em>
            <img src="static/style_default/image/pro_19.png" />
            <p>
                <span class="span_one">▪ 确认删除此部分申请信息？</span>
                <span class="span_two">▪ 删除后不可恢复！</span>
                </p>
                <div class="deleTipsBtn">
                    <em class="del_confirm">确定</em>
                    <a class="del_cancel">再看看</a>
                </div>
        </div>

        <div class="applyTips">
            <em class="em_title">已通过此加盟申请</em>
            <img src="static/style_default/image/pro_19.png" />
            <p>
                <span class="span_reason">理由：资质达标，已通过</span>
                <span class="span_time">批准时间：2017-10-10  21:00</span>
            </p>
            <div class="applyTipsBtn">
                <em>确定</em>
            </div>
        </div>

       <div class="rejectReason">
            <em>重要提示</em>
            <img src="static/style_default/image/pro_19.png" />
            <form action="join_refuse" method="post">
                <input type="hidden" name="join_id2" >
                <p>
                    <span>*确认要驳回此加盟申请吗？</span>
                    <span>理由：<input type="text" name="join_refusereason" style="padding:5px; border:1px solid #ddd; font-size:12px;" placeholder="输入驳回理由"/></span>
                </p>
                <div class="rejectReasonTipsBtn">
                    <input type="submit" id="rejectSub" value="确定"/>
                </div>
            </form>
        </div>

        <div class="adoptReason">
            <em>重要提示</em>
            <img src="static/style_default/image/pro_19.png" />
            <form action="join_agree" method="post">
                <input type="hidden" name="join_id" >
                <p>
                    <span>*确认要通过此加盟申请吗？</span>
                    <span>理由：<input type="text" name="join_agreereason" style="padding:5px; border:1px solid #ddd; font-size:12px;" placeholder="输入通过理由"/></span>
                </p>
                <div class="adoptReasonTipsBtn">
                    <input type="submit" id="adoptSub" value="确定"/>
                </div>
            </form>
        </div>
        <!--  重要提示 -->

        <!-- 查看法人身份证 -->
        <div class="IDcard">
            <dl>
                <dt>查看法人身份证</dt>
            </dl>
            <a class="closeID">关闭窗口</a>
        </div>
        <!-- 查看法人身份证 -->

        <!-- 查看营业执照 -->
        <div class="license">
            <dl>
                <dt>查看营业执照</dt>
            </dl>
            <a class="closeLicense">关闭窗口</a>
        </div>
        <!-- 查看营业执照 -->

        <!-- 订单层 -->
        <div class="applyDetails">
            <div class="applyerInfo">
                <em>
                    <i></i>
                    <hr/>
                </em>
                <div class="content">
                    <dl>
                        <dt>申请人信息</dt>
                        <dd>
                            <span>账户名：</span>
                            <em class="join_user">咖啡加奶不加糖</em>
                        </dd>
                        <dd>
                            <span>姓名：</span>
                            <em class="join_linkman">登登登登</em>
                        </dd>
                        <dd>
                            <span>手机号码：</span>
                            <em class="join_phone">13546678596</em>
                        </dd>
                        <dd>
                            <span>身份证号码：</span>
                            <em class="join_idcard">430422199605268796</em>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="applyerTime">
                <em>
                    <i></i>
                    <hr/>
                </em>
                <div class="content">
                    <dl>
                        <dt>申请时间</dt>
                        <dd>
                            <span class="join_time1">2017-06-01</span>
                            <em class="join_time2">13:34</em>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="storeInfo">
                <em>
                    <i></i>
                    <hr/>
                </em>
                <div class="content">
                    <dl>
                        <dt>门店信息</dt>
                        <dd>
                            <span>门店面积：</span>
                            <em class="join_size">50m²  </em>
                        </dd>
                        <dd>
                            <span>门店楼层：</span>
                            <em class="join_floor">2楼</em>
                        </dd>
                        <dd>
                            <span>门店人流量：</span>
                            <em class="join_passenger">200/天</em>
                        </dd>
                        <dd style="width:270px;">
                            <span>门店地址：</span>
                            <em class="join_address1">广东省广州市番禺区钟村街道长华创意谷D区16栋06号三楼</em>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="closeLay" style="margin-top:15px;"><span>关闭窗口</span></div>
        </div>
        <!-- 订单层 -->

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

// 搁置申请
function join_shelve(join_id) {
    $('.span_one').html('▪ 确认要搁置此条申请吗？');
    $('.span_two').html('▪ 搁置后需要搁置列表查看此条申请');
    $('.deleTips').show();
    $(".del_confirm").click(function(event) {
        $.ajax({
            url: 'join_shelve',
            type: 'POST',
            dataType: 'json',
            data: {join_id: join_id},
            success: function(res) {
                console.log(res);
                if (res.code == 200) {
                    $('.deleTips').hide();
                    alert('搁置成功');
                    window.location.reload();
                }
            }
        })
    });
    $(".del_cancel").click(function(event) {
        $('.deleTips').hide();
    });
}

// 搜索
function join_search() {
    var keywords = $("input[name='keywords']").val();
    var type = "<?php echo $a_view_data['type']; ?>";
    if (keywords != '') {
        window.location.href = "join_showlist-"+type+"-"+keywords;
    }
}

</script>