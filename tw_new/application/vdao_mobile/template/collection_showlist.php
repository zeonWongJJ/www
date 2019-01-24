<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="./static/style_default/style/common.css"/>
    <link rel="stylesheet" href="./static/style_default/style/collection.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/flexible.js"></script>
    <script src="./static/style_default/script/common.js"></script>
    <script src="./static/style_default/script/collection.js"></script>
    <title>我的收藏</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 我的收藏-->
    <div class="collection">
        <p class="pjoTitle">
           <!-- <img style="margin-top:0.35rem;" src="static/style_default/images/kefu_03.png" onclick="javascript:window.location.href='user_center';" />-->
            <a class="back" href="javascript:history.back(-1);"><img src="static/style_default/images/yongping_03.png" /></a>
            <span>我的收藏</span>
            <a style="top:0.3rem;" class="edit">编辑</a>
        </p>

        <!-- 导航 -->
        <div class="colleNav">
            <a class="store cur" value="1">
                <span>收藏的门店</span>
            </a>
            <a class="product" value="2">
                <span>收藏的产品</span>
            </a>
            <a class="office" value="3">
                <span>收藏的办公室</span>
            </a>
        </div>
        <input type="hidden" name="coll_type" value="1">
        <!-- 导航 -->
        <!-- 列表 -->
        <div class="listBox">
            <!-- 门店 -->
            <div class="storeList curList">
                <dl>
                    <dt>
                        <a>
                            <img src="static/style_default/images/check_06.png" />
                            <span>全部收藏</span>
                        </a>
                    </dt>
                    <?php foreach ($a_view_data['store'] as $key => $value): ?>
                    <dd>
                        <img src="static/style_default/images/check_06.png" value="<?php echo $value['collection_id']; ?>" />
                        <a class="listContent" href="store_detail-<?php echo $value['object_id']; ?>">
                            <?php if (empty($value['store_touxiang'])) {
                                echo '<img src="static/style_default/images/tou_03.png" />';
                            } else {
                                echo '<img src="'.get_config_item('store_touxiang').$value['store_touxiang'].'">';
                            } ?>
                            <em>
                                <dfn>
                                    <em><?php echo $value['store_name']; ?></em>
                                </dfn>
                            <span>
                                <?php for ($i=0; $i < $value['store_star']; $i++) {
                                    echo '<img src="../static/style_default/images/star_03.png"/>';
                                } ?>
                                <em><?php echo $value['store_star']; ?></em>
                            </span>
                                <p>
                                    <span>¥<?php echo $value['transport_start']; ?>起送</span>
                                    <em></em>
                                    <span>免配送费</span>
                                </p>
                                <em style="display:none;">
                                    <span>0.2km</span>
                                    <dfn></dfn>
                                    <em>38分钟</em>
                                </em>
                            </em>
                        </a>
                    </dd>
                    <?php endforeach ?>
                </dl>
            </div>
            <!-- 门店 -->

            <!-- 产品 -->
            <div class="productList">
                <dl>
                    <dt>
                        <a>
                            <img src="static/style_default/images/check_06.png" />
                            <span>全部收藏</span>
                        </a>
                    </dt>
                    <?php if (empty($a_view_data['goods']['goods'])) {

                    } else { foreach ($a_view_data['goods']['goods'] as $goods) {?>
                    <dd>
                        <img src="static/style_default/images/check_06.png"  value="<?php echo $goods['collection_id']; ?>" />
                        <a class="listContent" href="item-<?php echo $goods['proid_id_1']?>-<?php echo $goods['product_id']?>">
                            <img src="<?php echo $goods['pro_img']?>" />
                            <em>
                                <dfn>
                                    <em><?php echo $goods['product_name']?></em>
                                    <span style="float:right;margin-right:15px;">¥<?php $i = 0;foreach ($a_view_data['goods']['cup'] as $cup) {if ($goods['object_id'] == $cup['product_id']) {if ($i == 0) {echo $cup['price'];}$i++;}}?></span>
                                </dfn>
                                <span><?php echo $goods['pro_details']?></span>
                                <p style="display:none;">
                                    <span>月售3辆</span>
                                    <span>好评率100%</span>
                                </p>
                            </em>
                        </a>
                    </dd>
                    <?php }}?>
                </dl>
            </div>
            <!-- 产品 -->

            <!-- 办公室 -->
            <div class="officeList">
                <dl>
                    <dt>
                        <a>
                            <img src="static/style_default/images/check_06.png" />
                            <span>全部收藏</span>
                        </a>
                    </dt>
                    <?php foreach ($a_view_data['office'] as $key => $value): ?>
                    <dd>
                        <img src="static/style_default/images/check_06.png" value="<?php echo $value['collection_id']; ?>" />
                        <a class="listContent" href="office_detail-<?php echo $value['object_id']; ?>">
                            <?php if (empty($value['room_mainpic'])) {
                                echo '<img src="static/style_default/images/tou_03.png" />';
                            } else {
                                echo '<img src="'.get_config_item('wofei_admin').$value['room_mainpic'].'">';
                            } ?>
                            <em>
                                <dfn>
                                    <em><?php echo $value['room_name']; ?></em>
                                </dfn>
                                <span><?php echo $value['room_size']; ?>㎡ <?php echo $value['room_device']; ?> 可坐<?php echo $value['room_seat']; ?>人 </span>
                            </em>
                        </a>
                    </dd>
                    <?php endforeach ?>
                </dl>
            </div>
            <!-- 办公室 -->
        </div>
        <!-- 列表 -->

        <!-- 底部 -->
        <div class="bottom">
            <a class="cancel">取消</a>
            <a class="delete">删除</a>
        </div>
        <!-- 底部 -->
        <input type="hidden" name="isedit" value="1">

        <!-- 提示层 -->
        <div class="tips">

        </div>
        <!-- 弹出层 -->
    </div>
    <!-- 我的收藏 -->
</body>
</html>

<script>

var isedit;
// 获取更多收藏的办公室
var offpage = 1;
function collection_offgetmore() {
    isedit = $("input[name='isedit']").val();
    offpage++;
    $.ajax({
        url: 'collection_offgetmore',
        type: 'POST',
        dataType: 'json',
        data: {page: offpage},
        success: function(res) {
            if (res.code == 200) {
                var append_content = '';
                $.each(res.data, function(index, el) {
                    append_content += '<dd>';
                    if (isedit == 1) {
                        append_content += '<img src="static/style_default/images/check_06.png" style="display:none;" value="'+el.collection_id+'" />';
                    } else {
                        append_content += '<img src="static/style_default/images/check_06.png" style="display:inline-block;" value="'+el.collection_id+'" />';
                    }
                    append_content += '<a class="listContent">';
                    append_content += el.room_mainpic;
                    if (isedit == 1) {
                        append_content += '<em>';
                    } else {
                        append_content += '<em style="width:7rem;">';
                    }
                    append_content += '<dfn>';
                    append_content += '<em>'+el.room_name+'</em>';
                    append_content += '</dfn>';
                    append_content += '<span>'+el.room_size+'㎡ '+el.room_device+' 可坐'+el.room_seat+'人 </span>';
                    append_content += '</em>';
                    append_content += '</a>';
                    append_content += '</dd>';
                });
                $('.officeList dl').append(append_content);
            }
        }
    })
}

// 获取更多收藏的产品
var goods = 1;
function collection_goods() {
    isedit = $("input[name='isedit']").val();
    var img = '<?php echo get_config_item("goods_img")?>';
    goods++;
    $.ajax({
        url: 'collection_goods',
        type: 'POST',
        dataType: 'json',
        data: {page: goods},
        success: function(res) {
            if (res.code == 200) {
                var append_content = '';
                $.each(res.data[0], function(index, el) {
                    append_content += '<dd>';
                   if (isedit == 1) {
                        append_content += '<img src="static/style_default/images/check_06.png" style="display:none;" value="'+el.collection_id+'" />';
                    } else {
                        append_content += '<img src="static/style_default/images/check_06.png" style="display:inline-block;" value="'+el.collection_id+'" />';
                    }
                    append_content += '<a class="listContent" href="item-'+el.proid_id_1+'-'+el.product_id+'">';
                    append_content += '<img src="'+img+'/'+el.pro_img+'" />';
                    if (isedit == 1) {
                        append_content += '<em>';
                    } else {
                        append_content += '<em style="width:7rem;">';
                    }
                    append_content += '<dfn>';
                    append_content += '<em>'+el.product_name+'</em>';
                    append_content += '<span style="float:right; margin-right:15px;">¥';
                    var i = 0;
                    $.each(res.data[1], function(tieng, ont) {
                        if (el.object_id == ont.product_id) {
                            if (i == 0) {
                                append_content += ont.price;
                            }; i++;
                        }
                    });
                    append_content += '</span>';
                    append_content += '</dfn>';
                    append_content += '<span>'+el.pro_details+'</span>';
                    append_content += '<p style="display:none;"><span>月售3辆</span><span>好评率100%</span></p>';
                    append_content += '</em>';
                    append_content += '</a>';
                    append_content += '</dd>';
                });
                $('.productList dl').append(append_content);
            }
        }
    })
}

// 获取更多收藏的门店
var storepage = 1;
function collection_storegetmore() {
    isedit = $("input[name='isedit']").val();
    storepage++;
    $.ajax({
        url: 'collection_storegetmore',
        type: 'POST',
        dataType: 'json',
        data: {page: storepage},
        success: function(res) {
            if (res.code == 200) {
                var append_content = '';
                $.each(res.data, function(index, el) {
                    append_content += '<dd>';
                    if (isedit == 1) {
                        append_content += '<img src="static/style_default/images/check_06.png" style="display:none;" value="'+el.collection_id+'" />';
                    } else {
                        append_content += '<img src="static/style_default/images/check_06.png" style="display:inline-block;" value="'+el.collection_id+'" />';
                    }
                    append_content += '<a class="listContent" href="store_detail-'+el.object_id+'">';
                    append_content += el.store_touxiang;
                    if (isedit == 1) {
                        append_content += '<em>';
                    } else {
                        append_content += '<em style="width:7rem;">';
                    }
                    append_content += '<dfn>';
                    append_content += '<em>'+el.store_name+'</em>';
                    append_content += '</dfn>';
                    append_content += '<span>';
                    for(var i = 0; i < el.store_star; i++){
                        append_content += '<img src="../static/style_default/images/star_03.png"/>';
                    }
                    append_content += '<em>'+el.store_star+'</em>';
                    append_content += '</span>';
                    append_content += '<p>';
                    append_content += '<span>¥'+el.transport_start+'起送</span>';
                    append_content += '<em></em>';
                    append_content += '<span>免配送费</span>';
                    append_content += '</p>';
                    append_content += '<em style="display:none;">';
                    append_content += '<span>0.2km</span>';
                    append_content += '<dfn></dfn>';
                    append_content += '<em>38分钟</em>';
                    append_content += '</em>';
                    append_content += '</em>';
                    append_content += '</a>';
                    append_content += '</dd>';
                });
                $('.storeList dl').append(append_content);
            }
        }
    })
}

// 当滚动条滚到底时加载更多
$(window).scroll(function(){
    totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
    if($(document).height() <= totalheight) {
        var coll_type = $("input[name='coll_type']").val();
        if (coll_type == 1) {
            collection_storegetmore();
        } else if (coll_type == 2) {
            collection_goods();
        } else {
            collection_offgetmore();
        }
    }
});
</script>
<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>
