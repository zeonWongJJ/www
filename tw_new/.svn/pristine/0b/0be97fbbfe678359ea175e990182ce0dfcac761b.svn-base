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
    <link rel="stylesheet" href="./static/style_default/style/monthlySales.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <title>门店结算-订单明细</title>
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

        <!-- 销售明细 -->
        <div class="monthlySales">
            <p>结算管理 > <?php echo $a_view_data['detail']['store_name'] . ' > ' . date('Y年m月', $a_view_data['detail']['account_time']).'订单明细 > 第'. $a_view_data['page'] . '页'; ?></p>
            <!-- 分店信息 -->
            <div class="storeInfo">
                <p>分店信息</p>
                <div class="infoContent">
                    <img src="./static/style_default/image/tt_03.png" />
                    <ul class="conA">
                        <li>
                            <span>分店ID：</span>
                            <em>NO.<?php echo $a_view_data['detail']['store_id']; ?></em>
                        </li>
                        <li>
                            <span>分店名：</span>
                            <em><?php echo $a_view_data['detail']['store_name']; ?></em>
                        </li>
                        <li>
                            <span>地&nbsp;&nbsp;&nbsp;址：</span>
                            <em><?php echo $a_view_data['detail']['store_address']; ?></em>
                        </li>
                        <li>
                            <span>店长：</span>
                            <em><?php echo $a_view_data['detail']['store_linkman']; ?></em>
                        </li>
                        <li>
                            <span>联系电话：</span>
                            <em><?php echo $a_view_data['detail']['store_contact']; ?></em>
                        </li>
                    </ul>
                    <ul class="conB">
                        
                    </ul>
                </div>
            </div>
            <!-- 分店信息 -->
            <!-- 结算状态 -->
            <div class="mState">
                <p>最近三个月结算状态</p>
                <div class="stateList">
                    <?php foreach ($a_view_data['recently'] as $key => $value): ?>
                    <a class="stateCon">
                        <span><?php echo date('Y年m月', $value['account_time']); ?></span>
                        <?php if ($value['account_state'] == 0) {
                            echo '<p>'.$value['money_count'].'</p><em class="sml" onclick="urlgo('.$value['account_id'].')">前往核算</em>';
                        } else if ($value['account_state'] == 1) {
                            echo '<p>'.$value['money_update'].'</p><em class="sml" onclick="urlgo('.$value['account_id'].')">前往结算</em>';
                        } else if ($value['account_state'] == 2) {
                            echo '<p>'.$value['money_update'].'</p><em class="smlt">已结算</em>';
                        } ?>
                    </a>
                    <?php endforeach ?>
                </div>
            </div>
            <!-- 结算状态 -->
            <!-- 账单列表 -->
            <div class="details">
                <div class="pointState">
                    <em class="pointTime">
                        <span>月订单交易成功账单：</span>
                        <select name="" id="" disabled>
                            <option value=""><?php echo date('Y-m', $a_view_data['detail']['account_time']); ?></option>
                        </select>
                    </em>
                </div>
                
                <div class="detailNav">
                	<a href="account_detail-<?php echo $this->router->get(1)?>-1">餐饮订单</a>
                    <a href="account_detail-<?php echo $this->router->get(1)?>-2">预约办公订单</a>
                </div>
                
                <!-- 积分数据 -->
                <ul class="cateList">
                    <li class="cateHead">
                        <em class="v1">序号</em>
                        <em class="v2">订单号</em>
                        <em class="v3">下单时间</em>
                        <em class="v4">成交时间</em>
                        <?php if ($this->router->get(2) == 1) {?>
                        <em class="v5">餐饮数量</em>
                        <?php } else {?>
                        <em class="v5">预约办公数量</em>
                        <?php }?>
                        <em class="v6">总金额</em>
                        <em class="v7">抢单返积分</em>
                    </li>
                    <?php foreach ($a_view_data['order'] as $key => $value): ?>
                    <li class="cateBody">
                        <div class="varieties">
                            <?php if ($this->router->get(2) == 1) {?>
                            <em class="v1"><?php echo $value['order_id']; ?></em>
                            <em class="v2"><?php echo $value['order_number']; ?></em>
                            <em class="v3"><?php echo date('Y-m-d H:i:s',$value['time_create']); ?></em>
                            <em class="v4"><?php echo date('Y-m-d H:i:s',$value['order_time']); ?></em>
                            <em class="v5"><?php echo $value['order_count']; ?></em>
                            <em class="v6"><?php echo $value['goods_amount']; ?></em>
                            <em class="v7"><?php echo $value['score_tostore']; ?></em>
                            <?php } else {?>
                            <em class="v1"><?php echo $value['appointment_id']; ?></em>
                            <em class="v2"><?php echo $value['appointment_number']; ?></em>
                            <em class="v3"><?php echo date('Y-m-d H:i:s',$value['appointment_time']); ?></em>
                            <em class="v4"><?php echo date('Y-m-d H:i:s',$value['pay_time']); ?></em>
                            <em class="v5">1</em>
                            <em class="v6"><?php echo $value['appointment_price']; ?></em>
                            <em class="v7"><?php echo $value['score_tostore']; ?></em>
                            <?php }?>
                        </div>
                    </li>
                    <?php endforeach ?>
                </ul>
                <!-- 积分数据 -->
            </div>
            <!-- 账单列表 -->
        </div>
        <!-- 销售明细 -->

        <!-- 核算总额 -->
        <div class="totalAccount">
            <div class="priceBox">
                <p>
                    <span>核算金额</span>
                    <img class="priceHelp" src="./static/style_default/image/ww_03.png" />
                </p>
                <span>
                    <?php if ($a_view_data['detail']['account_state'] == 0) {
                        echo $a_view_data['detail']['money_count'];
                    } else {
                        echo $a_view_data['detail']['money_update'];
                    } ?>
                </span>
            </div>
            <div class="accountBox hide">
                <div class="accountBoxContent" style="width:400px;">
                    <?php if ($a_view_data['detail']['account_state'] != 0) {
                        echo '原系统核算金额为'. $a_view_data['detail']['money_count'] . '元，修改备注：' . $a_view_data['detail']['remark_update'];
                    } else {
                        echo '系统核算金额为'. $a_view_data['detail']['money_count'] . '元';
                    } ?>
                </div>
                <s>
                    <i></i>
                </s>
            </div>
            <?php if ($a_view_data['detail']['account_state'] == 0) {
                echo '<span onclick="goto_zero('.$a_view_data['detail']['account_id'].')">前去核算</span>';
            } else if ($a_view_data['detail']['account_state'] == 1) {
                echo '<span onclick="goto_one('.$a_view_data['detail']['account_id'].')">前去结算</span>';
            } else if ($a_view_data['detail']['account_state'] == 2) {
                echo '<span style="background-color:#cccccc;">已结算</span>';
            } ?>
        </div>
        <!-- 核算总额 -->
        <!-- 分页 -->
        <div class="page">
            <?php echo $this->pages->link_style_one($this->router->url('account_detail-'.$a_view_data['account_id'].'-', [], false, false)); ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->
        <!-- 核算金额 -->
        <div class="totalPrice hide">
            <iframe id="totalPrice" src="<?php echo $this->router->url('account_update',['id'=>$a_view_data['detail']['account_id']]); ?>" frameborder="0" scrolling="no">
            </iframe>
            <img class="closeTotal" src="./static/style_default/image/pro_19.png" />
        </div>
        <!-- 核算金额 -->

        <!--  重要提示 -->
        <div class="tips hide">
            <em>重要提示</em>
            <img src="/static/style_default/image/pro_19.png" class="delete_cancel" />
            <p>
                <span class="span_one">▪ 确认要结算金额吗？</span>
                <span class="span_two">▪ 结算后<?php echo $a_view_data['detail']['money_update']; ?>元将会转到门店账户！</span>
                </p>
                <div class="tipsBtn">
                    <em class="delete_confirm">确定</em>
                    <a class="delete_cancel">再看看</a>
            </div>
        </div>
        <!--  重要提示 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>

<script>
$(function(){
    $(".priceHelp").click(function(){
        $(".accountBox").show().delay(3000).hide(300).fadeOut();
    });
    $(".closeTotal").click(function(){
        $(".totalPrice").addClass("hide");
    })
    // 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });
})

// 跳转页面
function urlgo(account_id) {
    window.location.href = '/account_detail-'+account_id;
}

// 核算金额
function goto_zero(account_id) {
    $(".totalPrice").removeClass("hide");
}

// 子页面ajax核算后执行父页面的方法
function close_he(code) {
    if (code == 200) {
        $(".totalPrice").addClass("hide");
        $(".tips .span_one").html('▪ 核算已完成!');
        $(".tips .span_two").html('▪ 您现在可以去结算！');
        $(".tips").removeClass('hide');
    } else {
        $(".totalPrice").addClass("hide");
        $(".tips .span_one").html('▪ 核算失败!');
        $(".tips .span_two").html('▪ 您可以重新核算或者联系管理员！');
        $(".tips").removeClass('hide');
    }
    $('.delete_cancel').click(function(event) {
        window.location.reload();
    });
    $('.delete_confirm').click(function(event) {
        window.location.reload();
    });
}

// 结算
function goto_one(account_id) {
    $(".tips").removeClass('hide');
    $('.delete_cancel').click(function(event) {
        $(".tips").addClass('hide');
    });
    $('.delete_confirm').click(function(event) {
        $.ajax({
            url: 'account_statement',
            type: 'POST',
            dataType: 'json',
            data: {account_id: account_id},
            success: function(res) {
                console.log(res);
                goto_tips(res.code);
            }
        })
    });
}

// 结算后的提示
function goto_tips(code) {
    if (code==200) {
        $(".tips .span_one").html('▪ 结算已完成!');
        $(".tips .span_two").html('▪ 您可以去歇息了！');
    } else {
        $(".tips .span_one").html('▪ 结算失败了!');
        $(".tips .span_two").html('▪ 您可以稍候再试或者联系管理员！');
    }
    $('.delete_confirm,.delete_cancel').click(function(event) {
        window.location.reload();
    });
}


</script>