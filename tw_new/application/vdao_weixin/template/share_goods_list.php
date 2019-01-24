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
    <link rel="stylesheet" href="static/style_default/style/productList.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/product.js"></script>
    <title>产品列表</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 产品列表 -->
    <div class="productList">
        <p class="pjoTitle">
            <a href="myshare"><img src="static/style_default/images/lefB.png" alt=""/></a>
            <span>产品列表</span>
        </p>
        <!-- 导航 -->
        <div class="nav">
            <a href="<?php echo $this->router->url('share_goods_list', ['i_stuer' => 0]); ?>" <?php if ($a_view_data['i_stuer'] == 0) {echo "class='navCur'";}?>><span>全部</span></a>
            <a href="<?php echo $this->router->url('share_goods_list', ['i_stuer' => 2]); ?>" <?php if ($a_view_data['i_stuer'] == 2) {echo "class='navCur'";}?>><span>显示中</span></a>
            <a href="<?php echo $this->router->url('share_goods_list', ['i_stuer' => 1]); ?>" <?php if ($a_view_data['i_stuer'] == 1) {echo "class='navCur'";}?>><span>待审核</span></a>
            <a href="<?php echo $this->router->url('share_goods_list', ['i_stuer' => 3]); ?>" <?php if ($a_view_data['i_stuer'] == 3) {echo "class='navCur'";}?>><span>未通过</span></a>
            <a href="<?php echo $this->router->url('share_goods_list', ['i_stuer' => 4]); ?>" <?php if ($a_view_data['i_stuer'] == 4) {echo "class='navCur'";}?>><span>已下架</span></a>
        </div>
        <!-- 导航 -->
        <!-- 商品列表 -->
        <div class="productContainer">
            <ul>
                <?php foreach ($a_view_data['goods'] as $goods) {?>
                <li class="shopList li_<?php echo $goods['goo_id'];?>">
                    <a href="<?php echo $this->router->url('item', [$goods['proid_id_1'], $goods['product_id'], 'i']);?>">
                        <i><img src="<?php echo get_config_item('goods_img')?>/<?php echo $goods['pro_img']?>" alt=""/></i>
                        <dfn class="productInfo">
                            <h1><?php echo $goods['product_name']?></h1>
                            <?php if ($goods['state'] == 1) {?>
                                <span class="productState examine">待审核</span>
                            <?php } else if ($goods['state'] == 2 && $goods['pro_show'] == 2) {?>
                                <span class="productState fall">已下架</span>
                            <?php } else if ($goods['state'] == 2) {?>
                                <span class="productState showLook">显示中</span>                        
                            <?php } else if ($goods['state'] == 3) {?>
                                <span class="productState nopass">未通过</span>
                            <?php }?>
                            <p>
                                <span>发布于<em><?php echo date("Y.m.d", $goods['apply_time'])?></em></span>
                                <em>¥<span><?php echo $goods['price']?></span></em>
                            </p>
                        </dfn>
                    </a>
                    <em>
                        <?php if ($goods['state'] == 1) {?>
                            <a class="edit" href="share_goods_up-<?php echo $goods['goo_id']?>" value="<?php echo $goods['goo_id'];?>">编辑</a>
                        <?php } else if ($goods['state'] == 2 && $goods['pro_show'] == 2) {?>
                            <a class="dele" value="<?php echo $goods['goo_id'];?>">删除</a>
                            <a class="down" value="<?php echo $goods['goo_id'];?>">上架</a>
                            <a class="edit" href="share_goods_up-<?php echo $goods['goo_id']?>" value="<?php echo $goods['goo_id'];?>">编辑</a>
                        <?php } else if ($goods['state'] == 2) {?>
                            <a class="dele" value="<?php echo $goods['goo_id'];?>">删除</a>
                            <a class="down" value="<?php echo $goods['goo_id'];?>">下架</a>
                            <a class="edit" href="share_goods_up-<?php echo $goods['goo_id']?>" value="<?php echo $goods['goo_id'];?>">编辑</a>                       
                        <?php } else if ($goods['state'] == 3) {?>
                            <a class="edit" href="share_goods_up-<?php echo $goods['goo_id']?>" value="<?php echo $goods['goo_id'];?>">编辑</a>
                        <?php }?>

                    </em>
                </li>
                <?php }?>
            </ul>
        </div>
        <!-- 商品列表 -->
        <p class="nothing" style="height:0.77rem; line-height:0.77rem; text-align:center; font-size:0.37rem; color:#666666; ">没有更多了</p>
    </div>
    <!-- 产品列表 -->

    <!-- 遮罩层 -->
    <div class="lay"></div>
    <!-- 遮罩层 -->

    <!-- 提示 -->
    <div class="upTips">
        <p>提示</p>
        <span>确定要下架此产品吗?</span>
        <div class="upBtn">
            <a class="sure xia">确定</a>
            <a class="cancel">取消</a>
        </div>
    </div>
    <div class="downTips">
        <p>提示</p>
        <span>确定要上架此产品吗?</span>
        <div class="downBtn">
            <a class="sure shan">确定</a>
            <a class="cancel">取消</a>
        </div>
    </div>
    <div class="deleTips">
        <p>提示</p>
        <span>确定要删除此产品吗?</span>
        <div class="deleBtn">
            <a class="sure">确定</a>
            <a class="cancel">取消</a>
        </div>
    </div>
    <!-- 提示 -->
</body>
</html>
<script>
// 获取更多收藏的产品
var goods = 1;
function collection_goods() {
    var img = '<?php echo get_config_item("goods_img")?>';
    var stuer = '<?php echo $this->router->get(1);?>';
    goods++;
    $.ajax({
        url: 'get_goods_list',
        type: 'POST',
        dataType: 'json',
        data: {page:goods,stuer:stuer},
        success: function(res) {
            if (res.code == 200) {
                var append_content = '';
                $.each(res.data, function(index, el) {
                    append_content += '<li class="shopList li_'+el.goo_id+'">';
                        append_content += '<a href="">';
                            append_content += '<i><img src="'+img+'/'+el.pro_img+'" alt=""/></i>';
                            append_content += '<dfn class="productInfo">';
                            append_content += '<h1>'+el.product_name+'</h1>';
                                if (el.state == 1) {
                                   append_content += '<span class="productState examine">待审核</span>';
                                } else if (el.state == 2 && el.pro_show == 2) {
                                   append_content += '<span class="productState fall">已下架</span>';
                                } else if (el.state == 2) {
                                   append_content += '<span class="productState showLook">显示中</span> ' ;                      
                                } else if (el.state == 3) {
                                   append_content += '<span class="productState nopass">未通过</span>';
                                }
                            append_content += '<p>';
                            append_content += '<span>发布于<em> '+el.apply_time+'</em></span>';
                            append_content += '<em>¥<span>'+el.price+'</span></em>';
                            append_content += '</p>';
                            append_content += '</dfn>';
                        append_content += '</a>';
                        append_content += '<em>';
                            if (el.state == 1) {
                               append_content += '<a class="edit" value="'+el.goo_id+'">编辑</a>';
                            } else if (el.state == 2 && el.pro_show == 2) {
                               append_content += '<a class="dele" value="'+el.goo_id+'">删除</a>';
                               append_content += '<a class="down" value="'+el.goo_id+'">上架</a>';
                               append_content += '<a class="edit" value="'+el.goo_id+'">编辑</a>';
                            } else if (el.state == 2) {
                               append_content += '<a class="dele" value="'+el.goo_id+'">删除</a>';
                               append_content += '<a class="up" value="'+el.goo_id+'">下架</a>';
                               append_content += '<a class="edit" value="'+el.goo_id+'">编辑</a>';
                            } else if (el.state == 3) {
                               append_content += '<a class="edit" value="'+el.goo_id+'">编辑</a>';
                            }
                        append_content += '</em>';
                    append_content += '</li>';
                });
                $('.productContainer ul').append(append_content);
            }
        }
    })
}
$(function(){
    //定义一个总高度变量
    var totalHeight = 0; 
    $(window).scroll(function(){
        //浏览器的高度加上滚动条的高度
        totalHeight =  parseFloat( $(window).height() ) +  parseFloat( $(window).scrollTop() );
        //当文档的高度小于或者等于总的高度时，开始动态加载数据
        if ( $(document).height() <= totalHeight ) { 
            collection_goods();
        }
    })
})
</script>