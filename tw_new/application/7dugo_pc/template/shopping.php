<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>七度购商城</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/shoppingCart.css">
    <link rel="stylesheet" type="text/css" href="css/iconfont.css">
    <link rel="shortcut icon" href="image/bitbug_favicon.ico" />
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/plus.js"></script>
    <script src="js/common.js"></script>
</head>
<body>
<div id="shoppingCart">
    <?php $this->display('header', $a_view_data['cate']);?>
    <section>
        <div class="shoppingCart_info">
            <header class="section_nav_bar">
                <div>
                    <div>
                        <i class="iconfont icon-weidian"></i>
                        <span><a href="<?php echo $this->router->url('index'); ?>">首页</a></span>
                        <span>></span>
                        <span><a>购物车</a></span>
                    </div>
                </div>
            </header>
            <section>
                <nav>
                    <h2>我的购物车</h2>
<!--                     <div>
                        <span>配送至：</span>
                        <select>
                            <option value="北京市朝阳区">北京市朝阳区</option>
                            <option value="北京市朝阳区">北京市朝阳区</option>
                            <option value="北京市朝阳区">北京市朝阳区</option>
                            <option value="北京市朝阳区">北京市朝阳区</option>
                        </select>
                    </div> -->
                </nav>
                <ul>
                    <li>
                        <a class="checkbox check_all">
                            <label>
                                <em></em>
                            </label>
                            <span>全选</span>
                        </a>
                    </li>
                    <li style="width: 40%">商品信息</li>
                    <li>单价（元）</li>
                    <li>数量</li>
                    <li>金额（元）</li>
                    <li>操作</li>
                </ul>
                <form name="cart" action="<?php echo $this->router->url('bill'); ?>" method="post" > 
                <div class="store_list">
                <?php if(is_array($a_view_data['cart'])){foreach ($a_view_data['cart'] as $key => $value) { ?>
                <?php foreach ($value as $k => $v) { ?>
                <?php if($k == 0){ ?>
                    <div class="store_item">
                        <header>
                            <div class="header_l">
                                <a class="checkbox check_store">
                                    <label>
                                        <em></em>
                                    </label>
                                </a>
                                <span><?php if($v['is_own_shop'] == 1){ echo '七度自营';} ?></span>
                                <h2><?php echo $v['store_name']; ?></h2>
                                <a href="http://lyt.zoosnet.net/lr/chatpre.aspx?id=LYT42657310"><i class="iconfont icon-kefu"></i></a>
                            </div>
                            <div class="header_r">
                                <p>商品总价：</p>
                                <span>
                                        <span>￥</span>
                                        <label></label>
                                    </span>
                                <P><?php if($v['goods_freight'] == 0){ echo '免运费';}else { echo $v['goods_freight'];}; ?></P>
                                <a><span>?</span></a>
                            </div>
                        </header>
                    <?php } ?>
                        <section>
                            <div class="order_item <?php if($v['goods_state'] != 1){echo "gray";} ?>">
                                <a class="checkbox check_pro">
                                    <?php if($v['goods_state'] == 1){ ?>
                                    <label class="check_del  <?php if(!empty($a_view_data['repurchase']) && strstr($a_view_data['repurchase'],$v['goods_id'])){ echo 'checked'; } ?>" data="<?php if($v['goods_promotion_type'] == 0){echo 0;}else{echo ($v['goods_price'] - $v['goods_promotion_price']) ;} ?>">
                                    <?php } ?>
                                        <input type="hidden"  class="checkgood <?php if($v['goods_state'] != 1){ echo 'delgoods'; }?>" name="goods[]" value="<?php echo $v['goods_id']; ?>">
                                    <?php if($v['goods_state'] == 1){ ?>
                                        <input type="hidden" class="numgoods" name="num[]" value="<?php echo $v['goods_num']; ?>">
                                        <em></em>
                                    </label>
                                    <?php  } ?>
                                </a>
                                <a href="<?php echo $this->router->url('item', ['goods_id' => $v['goods_id']]); ?>">
                                    <div class="img" style="background-image: url(upload/shop/store/goods/<?php echo $v['store_id'] . '/' . $v['goods_image']; ?>)"></div>
                                </a>
                                <div class="cont">
                                    <h2><a href="<?php echo $this->router->url('item', ['goods_id' => $v['goods_id']]); ?>"><?php echo $v['goods_name'];?></a></h2>
                                    <p><?php echo $v['keywords'];?></p>
                                        <?php if($v['have_gift'] == 1){ ?>
                                            <div>
                                                <span>赠</span>
                                                <ul>
                                                    <li>
                                                        <p><?php echo $v['gift']['gift_goodsname']; ?></p>
                                                        <span>x<?php echo $v['gift']['gift_amount']; ?></span>
                                                    </li>
                                                </ul>
                                            </div> 
                                       <?php } ?>
                                </div>
                                <div class="price">
                                        <span <?php if($v['goods_state'] != 1){echo 'style="color:#999"';} ?>>
                                            <span>￥</span>
                                            <label>
                                                <?php if($v['goods_promotion_type'] == 0){echo $v['goods_price'];}else{echo $v['goods_promotion_price'];}  ?>
                                            </label>
                                            </span>
                                </div>
                                <?php if($v['goods_state'] == 1){ ?>
                                <div class="btn">
                                    <span>-</span>
                                    <input type="text" value="<?php echo $v['goods_num']; ?>" readonly="readonly">
                                    <span>+</span>
                                </div>
                                <?php }else{ ?>
                                <div class="btn1">
                                    <span>-</span>
                                    <input type="text" value="<?php echo $v['goods_num']; ?>" readonly="readonly">
                                    <span>+</span>
                                </div>
                                <?php } ?>
                                <div class="<?php if($v['goods_state'] == 1){echo 'amount';}else{echo "amount1";} ?>">
                                        <span <?php if($v['goods_state'] != 1){echo 'style="color:#999"';} ?>>
                                            <span>￥</span>
                                            <label class="price_one" >
                                                <?php if($v['goods_promotion_type'] == 0){echo $v['goods_price'] * $v['goods_num'];} else {echo $v['goods_promotion_price'] * $v['goods_num'];} ?>
                                            </label>
                                        </span>
                                </div>
                                <div class="edit">
                                    <i class="iconfont icon-shanchu clear"></i>
                                    <i></i>
                                </div>
                            </div>
                        </section>
                        <?php } ?>
                    </div>
                <?php } } ?>
                </div>
            </section>
            <footer>
                <div class="pay_bar">
                    <div class="pay_bar_l">
                        <a class="checkbox check_all">
                            <label>
                                <em></em>
                            </label>
                            <span>全选</span>
                        </a>
                        <ul>
                            <li>
                                <a class="del_good delete_checked">删除选中商品</a>
                            </li>
                            <!-- <li>
                                <a>移到我的收藏</a>
                            </li> -->
                            <li>
                                <!-- <a>清除失效商品</a> -->
                            </li>
                        </ul>
                    </div>
                    <div class="pay_bar_r">
                        <div>
                            <div>
                                <div>
                                    <p>已选 <span class="total_num">0</span>件商品 <i></i></p>
                                </div>
                                <span class="total_price">
                                    <span>总计（不含运费）:</span>
                                    <span style="color: #bf0000;font-weight:700;">￥</span><label style="font-size: 22px">0.00</label></span>
                            </div>
                            <p>已优惠: <span class="total_discount"></span></p>
                        </div>
                        <a >
                            <button type="button" class="submit">去结算</button>
                        </a>
                    </div>


                </div>
            </footer>
            </form>
            <div class="hot_sale">
                <h2>热卖推荐</h2>
                <div class="list">
                    <ul>
                        <?php if(is_array($a_view_data['commend'])){foreach ($a_view_data['commend'] as $key => $value) { ?>
                        <li>
                            <a href="<?php echo $this->router->url('item', ['goods_id' => $value['goods_id']]); ?>">
                                <div class="item">
                                    <div class="img" style="background-image: url(upload/shop/store/goods/<?php echo $value['store_id'] . '/' . $value['goods_image']; ?>)"></div>
                                    <h3><?php echo $value['goods_name']; ?></h3>
                                    <div>
                                        <strong><span>￥</span><?php if($value['goods_promotion_type'] == 0){
                                            echo $value['goods_price'];
                                            } else { echo $value['goods_promotion_price']; } ?></strong>
                                        <small><span><?php if($value['goods_promotion_type'] > 0){ echo '￥156.00'; } ?></span></small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php } }?>
                    </ul>
                </div>
                <div class="prev show"></div>
                <div class="next"></div>
                <div class="pot">
                    <ul>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- 弹框 -->
    <div id="box" class="dn">
        <div class="message_box dn">
            <div>
                <h2>重要提示</h2>
                <p>*确认要删除此收货信息吗？</p>
            </div>
            <div class="btn">
                <button class="active delshop">确认</button>
                <button>取消</button>
            </div>
        </div>
    </div>
    <?php if(! empty($_SESSION['user_id'])){ ?>
        <?php $this->display('sidebar');?>
     <?php } ?>
    <?php $this->display('footer');?>
</div>
</body>
</html>