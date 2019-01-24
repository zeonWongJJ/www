<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>七度购商城</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/iconfont.css">
    <link rel="stylesheet" type="text/css" href="css/orderSettlement.css">
    <link rel="shortcut icon" href="image/bitbug_favicon.ico" />
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/common.js"></script>
    <script src="js/plus.js"></script>
</head>
<body>
<div id="order">
    <?php $this->display('header', $a_view_data['cate']);?>
    <section>
        <div class="order_info">
            <header class="section_nav_bar">
                <div>
                    <div>
                        <i class="iconfont icon-weidian"></i>
                        <span><a href="<?php echo $this->router->url('index'); ?>">首页</a></span>
                        <span>></span>
                        <span><a>订单结算</a></span>
                    </div>
                </div>
            </header>
            <section>
                <h2>填写核对订单信息</h2>
                <div class="consignee">
                    <h3>收货人信息</h3>
                    <ul class="address_ul">
                    <?php if(is_array($a_view_data['address'])){foreach ($a_view_data['address'] as $key => $value) { ?>
                        <li data="<?php echo $value['address_id']; ?>" class="address <?php if($value['is_default'] == 1){ echo 'active';} if($key >= 2){echo ' dn';} ?>">
                            <a>
                                <div class="address_item">
                                    <h4 class="moname"><?php echo $value['true_name']; ?></h4>
                                    <p class="moaddres"><?php echo $value['area_info'] . ' ' . $value['address']; ?></p>
                                    <span class="motel"><?php echo $value['mob_phone']; ?></span>
                                    <label <?php if($value['is_default'] == 1){ echo 'style="opacity: 1;"';} ?>></label>
                                </div>
                                <div class="edit">
                                    <i class="iconfont icon-bianji"></i>
                                    <i class="iconfont icon-shanchu"></i>
                                </div>
                            </a>
                        </li>
                        <?php } } ?>
                        <li>
                            <a>
                                <div class="add_address address_item1">
                                    <i class="iconfont icon-tianjia"></i>
                                    <p>添加新地址</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div>
                        <button>显示全部收货人地址</button>
                        <button>添加新地址</button>
                    </div>
                </div>
                <form action="<?php echo $this->router->url('pay'); ?>" method="post" name="pay">
                <div class="delivery">
                    <h3>送货清单 <a href="<?php echo $this->router->url('shop'); ?>">返回修改购物车</a></h3>
                    <header>
                        <ul>
                            <li>商品信息</li>
                            <li>单价</li>
                            <li>数量</li>
                            <li>小计</li>
                        </ul>
                    </header>
                    <section>
                    <?php if(is_array($a_view_data['bill']['data'])){ foreach ($a_view_data['bill']['data'] as $key => $value) { ?>
                        <?php foreach ($value['goods'] as $k => $v) { ?>
                        <?php if($k == 0){ ?>
                        <div class="store_item">
                            <header>
                                <div class="header_l">
                                    <span><?php if($v['is_own_shop'] == 1){ echo '七度自营';} ?></span>
                                    <h2><?php echo $v['store_name']; ?></h2>
                                    <a href="http://lyt.zoosnet.net/lr/chatpre.aspx?id=LYT42657310" target="_blank"><i class="iconfont icon-kefu"></i></a>
                                </div>
                                <div class="header_r">
                                    <p>本单应付：</p>
                                    <span><span>￥</span><?php echo $value['store']; ?></span>
                                    <P><?php if($v['goods_freight'] == 0){ echo '免运费';}else { echo $v['goods_freight'];}; ?></P>
                                    <a><span>?</span></a>
                                </div>
                            </header>
                            <section>
                            <?php } ?>
                                <div class="order_item">
                                    <a class="img" style="background-image: url(upload/shop/store/goods/<?php echo $value['store_id'] . '/' . $v['goods_image']; ?>)" href="<?php echo $this->router->url('item', ['goods_id' => $v['goods_id']]); ?>"></a>
                                    <div class="cont">
                                        <h2><a href="<?php echo $this->router->url('item', ['goods_id' => $v['goods_id']]); ?>"><?php echo $v['goods_name']; ?></a></h2>
                                        <p><?php echo $v['keywords']; ?></p>
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
                                    <input type="hidden" name="goods_id[]" value="<?php echo $v['goods_id']; ?>">
                                    <input type="hidden" name="num[]" value="<?php echo $value['num'][$k]; ?>">
                                    <div class="price">
                                        <span>
                                            <span>￥</span>
                                            <?php if($v['goods_promotion_type'] == 0){echo $v['goods_price'];} else {echo $v['goods_promotion_price'];}  ?>
                                            </span>
                                    </div>
                                    <div class="number">
                                        <span>x<?php echo $value['num'][$k]; ?></span>
                                    </div>
                                    <div class="amount">
                                        <span>
                                            <span>￥</span>
                                            <?php print_r($v['num']); ?>
                                            <?php if($v['goods_promotion_type'] == 0){echo $v['goods_price'] * $value['num'][$k];} else {echo $v['goods_promotion_price'] * $value['num'][$k];} ?>
                                        </span>
                                    </div>
                                </div>
                            <?php } ?>
                            </section>
                            <footer>
                                <div>
                                    <p>订单备注：</p>
                                    <input type="text" name="remarks[<?php echo $value['store_id']; ?>]" placeholder="选填，限50字，建议填写已和卖家协商的内容" >
                                </div>
                                <!--发票信息暂无-->
                            </footer>
                        </div>
                        <?php } }?>
                    </section>
                    <?php if(is_array($a_view_data['bill']['data'])){ ?>
                        <input type="hidden" value="1" name="paytype" class="paytype">
                        <footer>
                            <ul>
                                <li>共 <span><?php echo $a_view_data['bill']['goods_amount']; ?></span>件商品，总金额：</li>
                                <li>优惠：</li>
                                <li>运费：</li>
                                <li>应付总额：</li>
                            </ul>
                            <dl>
                                <dd>¥<?php echo $a_view_data['bill']['pricesum']; ?></dd>
                                <dd style="text-decoration: line-through">¥<?php echo $a_view_data['bill']['privilege']; ?></dd>
                                <dd>¥<?php if($a_view_data['bill']['freight'] == 0){echo '免运费';} else {echo $a_view_data['bill']['freight'];} ?></dd>
                                <dd>¥<span><?php echo $a_view_data['bill']['pricesumfre']; ?></span></dd>
                            </dl>
                        </footer>
                     <?php } ?>
                </div>
                <?php if(is_array($a_view_data['bill']['data'])){ ?>
                <div class="payment">
                    <h3>支付方式</h3>
                    <h2>选择支付方式支付 <span><?php echo $a_view_data['bill']['pricesumfre']; ?></span>元 </h2>
                    <ul>
                        <li class="active">
                            <a>支付方式</a>
                            <em></em>
                            <div class="payment_item">
                                 <div>
                                    <ul class="balance">
                                        <li class="active">
                                            <a>
                                                <?php if($a_view_data['member']['available_predeposit'] == 0) {?>
                                                <i style="border: 0;"></i>
                                                <?php } else {?>
                                               <i><span></span></i>
                                               <?php }?>
                                                <p>使用账户余额：<span><?php echo $a_view_data['member']['available_predeposit']; ?></span>元</p>
                                                <label <?php if($a_view_data['member']['available_predeposit'] > $a_view_data['bill']['pricesumfre']){echo 'class="dn"';} ?>>（余额不足，请选择其他付款方式）</label>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="payondelivery">
                                        <li>
                                            <a>
                                                <i><span></span></i>
                                                <p>货到付款(送货上门再收款，只支持现金)</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="payterrace">
                                        <li>
                                            <a>
                                                <i><span></span></i>
                                                <div class="img" style="background-position-y:-480px"></div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="more_info">
                        <div>
                            <label>
                                <em></em>
                            </label>
                            <p>使用七度购积分</p>
                            <div class="dn">
                                <input type="number" id="integral" name="integral" step="100" value="0" min="0" >
                                <p>分</p>
                                <span>￥<span id="money">0</span></span>
                                <label>(可用:<span id="usable"><?php if($a_view_data['bill']['deductible_point'] < $a_view_data['member']['member_points']){echo $a_view_data['bill']['deductible_point'];}else{echo $a_view_data['member']['member_points'];} ?></span>)</label>
                            </div>
                        </div>
                    </div>
                    <div class="make_sure">
                        <div>
                            <p>使用 <span class="paytyp">余额支付</span>支付<label><span>¥</span><span class="total"><?php echo $a_view_data['bill']['pricesumfre']; ?></span></label></p>
                            <div>
                                <p><span>寄送至：</span><a class="toaddress"></a></p>
                                <p><span>收件人：</span><a class="addname"></a>(收) / <a class="tel"></a></p>
                            </div>
                        </div>
                        <button type="button" class="affirmpay">确认并支付</button>
                    </div>
                </div>
                <?php } ?>
            </section>
        </div>
        </form>
    </section>
    <div id="box" class="dn">
            <div class="add_address_box dn">
                <input type="hidden" value="" id="alterh">
                <h2 class="addh2">新增收货地址</h2>
                <ul>
                    <li>
                        <div>
                            <span>*</span>
                            <h2 class> 收货人:</h2>
                        </div>
                        <input type="text" name="receving" class="receving">
                        <p class="dn">
                            <i class="pass"></i>
                            <span>收货人不能为空</span>
                        </p>
                    </li>
                    <li>
                        <div>
                            <span>*</span>
                            <h2>所在地区:</h2>
                        </div>
                        <select name="" id="area_top">
                            <option value="">请选择</option>
                            <?php foreach ($a_view_data['area'] as $key => $value): ?>
                                <option value="<?php echo $value['area_id']; ?>"><?php echo $value['area_name']; ?></option>
                            <?php endforeach ?>
                        </select>
                        <input type="hidden" name="area_top" value=""  id="inp_area_top">
                        <input type="hidden" name="area_city" value="" id="inp_area_city">
                        <input type="hidden" name="area_town" value="" id="inp_area_town">
                        <p class="dn">
                            <i class="empty"></i>
                            <span>请选择省市区</span>
                        </p>
                    </li>
                    <li>
                        <div>
                            <span>*</span>
                            <h2>详细地址:</h2>
                        </div>
                        <input type="text" style="width: 350px" name="detailed" id="detailed">
                        <p class="dn">
                            <i class="empty"></i>
                            <span>详细地址不能为空</span>
                        </p>
                    </li>
                    <li>
                        <div>
                            <span>*</span>
                            <h2>手机号码:</h2>
                        </div>
                        <input type="tel" style="width:170px;" name="phone" id="phone">
                        <p class="dn" id="phone_dn">
                            <i class="empty" id="phone_i"></i>
                            <span id="phone_span">手机号码格式不正确</span>
                        </p>
                    </li>
                    <li>
                        <div>
                            <h2>固定电话:</h2>
                        </div>
                        <input type="text" style="width:170px;" name="tel" id="tel">
                    </li>
                </ul>
                <button type="button" id="alter" class="addressarea">保存收件人信息</button>
                <a class="close_box"><em></em></a>
            </div>
        <div class="message_box dn">
            <div>
                <h2>重要提示</h2>
                <p>*确认要删除此收货信息吗？</p>
            </div>
            <div class="btn">
                <button class="active affirm">确认</button>
                <button class="abolish">取消</button>
            </div>
        </div>
    </div>
    <?php if(! empty($_SESSION['user_id'])){ ?>
        <?php $this->display('sidebar');?>
     <?php } ?>
</div>
    <?php $this->display('footer');?>
    
</body>
</html>