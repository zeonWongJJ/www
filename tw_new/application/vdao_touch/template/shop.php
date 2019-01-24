<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
      <meta content="black" name="apple-mobile-web-app-status-bar-style">
      <meta content="telephone=no" name="format-detection">
      <meta content="yes" name="apple-touch-fullscreen">
    <title>购物车</title>
    <link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
    <link href="static/style_default/style/shopCar.css" rel="stylesheet" type="text/css">
    <script src="static/style_default/script/flexible.js" type="text/javascript"></script>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
    <script src="static/style_default/script/shopCar.js" type="text/javascript"></script>
  </head>
  <body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <div class="main">
      <div class="title">
        <span class="gou">购物车(<i class="num"><?php echo $a_view_data['total']?></i>)</span>
        <!--<a class="guan" href="javascript:;">管理</a>-->
      </div>
      <div class="control">
        <a class="addIn" href="javascript:;">加入收藏夹</a>
        <a class="delete" href="javascript:;">删除</a>
      </div>

      <div class="shopBox">
        <div class="chooseBox">
          <a href="javascript:;" class="allCho"></a>
          <span class="span1">全选</span>
        </div>
        <form action="new_bill?oldurl=<?php echo $this->router->get_url(); ?>" method="post">
          <input type="hidden" name="cart_ids">
          <input type="hidden" name="come_type" value="1">
          <!--钟福广场店开始-->
          <div class="appoint appoint1">
           <?php foreach ($a_view_data['cart'] as $cart) {
            if ( ! empty($cart['store_id'])) {?>
            <div class="aTit">
              <span class="span2"><?php echo $cart['store_name']?></span>
            </div>
            <div class="shopList">
              <ul>
                <?php foreach ($a_view_data['goods'] as $goods) {
                  if ($cart['store_id'] == $goods['store_id']) { ?>
                <!--单个商品开始-->
                <li>
                  <a href="javascript:;" class="singleCho <?php if(!empty($a_view_data['repurchase']) && in_array($goods['cart_id'],$a_view_data['repurchase'])){ echo 'singleHas'; } ?>" value="<?php echo $goods['cart_id']; ?>"></a>
                  <div class="sDiv <?php if(!empty($a_view_data['repurchase']) && in_array($goods['cart_id'],$a_view_data['repurchase'])){ echo 'id'; } ?>" value="<?php echo $goods['product_id']?>">
                    <div class="img">
                      <a href="javascript:;"><img src="<?php echo get_config_item('goods_img')?>/<?php echo $goods['pro_img']?>"/>"/></a>
                    </div>
                    <div class="describe">
                      <p class="name"><a href="javascript:;"><?php echo $goods['product_name']?></a></p>
                      <p class="smallN"><?php echo $goods['shux_name']?></p>
                      <p class="money">¥<i class="qian"><?php echo $goods['money']?></i></p>
                    </div>
                    <div class="quantity">
                     <a class="add" href="javascript:;" value="<?php echo $goods['cart_id']; ?>"><img src="static/style_default/images/shopcar_06.png"/></a>
                      <a class="qNum" href="javascript:;" ><?php echo $goods['prot_count']?></a>
                       <a class="less" href="javascript:;" value="<?php echo $goods['cart_id']; ?>"><img src="static/style_default/images/shopcar_12.png"/></a>
                    </div>
                  </div>
                </li>
                <!--单个商品结束-->
                <?php }}?>
              </ul>
            </div>
            <?php }}?>
          </div>
          <!--钟福广场店结束-->
          <!--不指定配送店铺开始-->
          <div class="appoint notAppoint">
            <div class="aTit">
              <span class="span2">不指定配送店铺</span>
            </div>
            <div class="shopList">
              <ul>
                <?php foreach ($a_view_data['cart'] as $cart) {
                if (empty($cart['store_id'])) {
                  foreach ($a_view_data['goods'] as $goods) {
                  if ($cart['store_id'] == $goods['store_id']) { ?>
                <!--单个商品开始-->
                <li>
                  <a href="javascript:;" class="singleCho <?php if(!empty($a_view_data['repurchase']) && in_array($goods['cart_id'],$a_view_data['repurchase'])){ echo 'singleHas'; } ?>" value="<?php echo $goods['cart_id']; ?>"></a>
                  <div class="sDiv <?php if(!empty($a_view_data['repurchase']) && in_array($goods['cart_id'],$a_view_data['repurchase'])){ echo 'id'; } ?>" value="<?php echo $goods['product_id']?>">
                    <div class="img">
                      <a href="javascript:;"><img src="<?php echo get_config_item('goods_img')?>/<?php echo $goods['pro_img']?>"/>"/></a>
                    </div>
                    <div class="describe">
                      <p class="name"><a href="javascript:;"><?php echo $goods['product_name']?></a></p>
                      <p class="smallN"><?php if ( ! empty($goods['spec_name'])) {
                        echo $goods['spec_name'] . "/" . $goods['swee'] . "/" . $goods['temp'];
                      } ?></p>
                      <p class="money">¥<i class="qian"><?php echo $goods['money']?></i></p>
                    </div>
                    <div class="quantity">
                      <a class="add" href="javascript:;" value="<?php echo $goods['cart_id']; ?>" ><img src="static/style_default/images/shopcar_06.png"/></a>
                      <a class="qNum" href="javascript:;"><?php echo $goods['prot_count']?></a>
                      <a class="less" href="javascript:;" value="<?php echo $goods['cart_id']; ?>" ><img src="static/style_default/images/shopcar_12.png"/></a>
                    </div>
                  </div>
                </li>
                <!--单个商品结束-->
                <?php }}}}?>
              </ul>
            </div>
          </div>
          <!--不指定配送店铺结束-->
        </form>
      </div>
      <!--结费开始-->
      <div class="countMoney">
      <input type="hidden" value="<?php echo $a_view_data['set']['set_parameter']?>" class="set">
        <ul>
          <li>
            <span class="smallTot">小计(<i class="jian">0</i>件)</span>
            <span class="smallMon smallMon1">0.00</span>
          </li>
          <!-- <li>
            <span class="smallTot">配送费</span>
            <span class="smallMon peisong">0.00</span>
          </li>
          <li>
            <span class="smallTot">总计</span>
            <span class="smallMon allMon">0.00</span>
          </li> -->
        </ul>
        <a class="goCount" href="javascript:;">去结算<img src="static/style_default/images/jiantou_03.png"/></a>
      </div>
      <!--结费结束-->
    </div>
  </body>
</html>

