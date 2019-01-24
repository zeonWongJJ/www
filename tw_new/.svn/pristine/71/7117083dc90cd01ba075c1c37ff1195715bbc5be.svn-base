<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $a_view_data['shangpin']['goods_name'];?> - 7度购保健品商城</title>
	<meta name="description" content="7度购保健品商城,<?php echo $a_view_data['shangpin']['description'];?>"/>
	<meta name="keywords" content="保健品商城,保健品网,营养保健品,健康产品,保健食品,保健品"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/details.css">
    <link rel="stylesheet" type="text/css" href="css/iconfont.css">
    <link rel="shortcut icon" href="image/bitbug_favicon.ico" />
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/detail.js"></script>

    <script src="js/common.js"></script>
</head>
<body>
<div id="details">
  <?php $this->display('header', $a_view_data['cate']);?>
    <section>
        <div class="product_info">
            <header class="section_nav_bar">
                <div>
                    <div>
                        <i class="iconfont icon-weidian"></i>
                        <span><a href="/">首页</a></span>
                        <span>></span>
                        <span><a href="/search-0-<?php echo $a_view_data['daohang']['one_id']?>-0-0-0-0-0-0-0-0-0-0-0.html"><?php echo $a_view_data['daohang']['one_name']?></a></span>
                        <span>></span>
                        <span><a href="/search-0-<?php echo $a_view_data['daohang']['two_id']?>-0-0-0-0-0-0-0-0-0-0-0.html"><?php echo $a_view_data['daohang']['two_name']?></a></span>
                        <span>></span>
                        <span><a href="/search-0-<?php echo $a_view_data['daohang']['three_id']?>-0-0-0-0-0-0-0-0-0-0-0.html"><?php echo $a_view_data['daohang']['three_name']?></a></span>
                    </div>
                    <ul>
                        <li style="position: relative"><?php echo $a_view_data['shangpin']['store_name'];?>
                            <img src="image/icon_call.png" alt="">
                            <div class="score_detail dn">
                                <h2>
                                    <span>评分详细</span>
                                    <span>与行业相比</span>
                                </h2>
                                <ul>
                                    <li>
                                        <span>商品评分：</span>
                                        <span>5.0</span>
                                        <i></i>
                                        <span>100%</span>
                                    </li>
                                    <li>
                                        <span>服务评分：</span>
                                        <span>5.0</span>
                                        <i></i>
                                        <span>100%</span>
                                    </li>
                                    <li>
                                        <span>时效评分：</span>
                                        <span>5.0</span>
                                        <i></i>
                                        <span>100%</span>
                                    </li>
                                </ul>
                                <p>
                                    <span>服务承诺</span>
                                    <span>
                                        正品保证 &nbsp &nbsp 增票服务 &nbsp &nbsp 隐私包装
                                    </span>
                                </p>
                                <div class="pay">
                                    <p>支付方式</p>
                                    <ul>
                                        <li>
                                            <i></i>
                                            <span>微信</span>
                                        </li>
                                        <li>
                                            <i></i>
                                            <span>支付宝</span>
                                        </li>
                                        <li>
                                            <i></i>
                                            <span>货到付款</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="score">
                            <label><label style="width:80px "></label></label>
                            <span>5.0分</span>

                        </li>
                        <li class="focus">+关注</li>
                        <li class="collect"><i class="iconfont icon-shoucang"></i>收藏店铺</li>
                    </ul>
                </div>
            </header>
            <section>
                <div class="product_info_p">
                    <div class="product_info_pl">
                        <div>
                            <a><i></i></a>
                            <div>
                                <ul>
                                <?php foreach ($a_view_data['shangpin']['details_image'] as $key=>$value) {?>
                                    <li class="img <?php if($key==0){echo 'active';}?>" style="background-image: url(<?php echo get_config_item('img_path').$a_view_data['shangpin']['store_id'].'/'.$value; ?>)"></li>
                                <?php } ?>
                                </ul>
                        
                            </div>
                            <a><i></i></a>
                        </div>
                        <span class="img" style="background-image: url(<?php echo get_config_item('img_path').$a_view_data['shangpin']['store_id'].'/'.$a_view_data['shangpin']['main_image']?>)"></span>
                    </div>
                    <div class="product_info_pr">
                        <h2><?php echo $a_view_data['shangpin']['goods_name']?></h2>
                        <P>/<?php echo $a_view_data['shangpin']['goods_jingle']?>/</P>
                        <div class="price">
                            <span><span>¥</span><?php echo $a_view_data['shangpin']['goods_promotion_price']?></span>
                            <label><span>¥</span><?php echo $a_view_data['shangpin']['goods_marketprice']?></label>
                        </div>
                        <span>好评：<?php echo $a_view_data['pingjia']['good_pie']?>%</span>
                        <div class="prom">
                       <!--      <div class="prom_item">
                                <span>赠</span>
                                <div>
                                    <a href="">
                                        <img class="img" src="image/product1_1.png" alt="">
                                    </a>
                                    <label>x1</label>
                                </div>
                                <div>
                                    <a href="">
                                        <img class="img" src="image/product1_1.png" alt="">
                                    </a>
                                    <label>x1</label>
                                </div>
                                <p>(条件：购买两件及以上，赠品有限，送完即止)</p>
                            </div> -->
                            <?php if(round($a_view_data['shangpin']['goods_feng'],0)!=0){?>
                            <div class="prom_item">
                                <span>积</span>
                                <p>每成功购买一件，赠送<?php echo round($a_view_data['shangpin']['goods_feng'],0)?>积分</p>
                            </div>
                            <?php }?>
                        </div>
                        <div class="address">
                            <!-- <p>商家从江苏南京发货</p> -->
                     
                            <p>运费 &nbsp <?php if ($a_view_data['shangpin']['goods_freight'] == 0) {?>
                                免费包邮
                            <?php } else {?>
                                <?php echo $a_view_data['shangpin']['goods_freight']?>
                            <?php }?>
                            </p>
                        </div>
                    <!--     <div class="package">
                            <ul>
                                <li>
                                    <span>优惠套装1</span>
                                    <div class="package_item item1 dn">
                                        <header>
                                            <div class="p1">
                                                <img src="image/product1.png" alt="">
                                                <p>帝岐轩金芷-快速止痛茶</p>
                                            </div>
                                            <span>+</span>
                                            <div class="p2">
                                                <img src="image/product1.png" alt="">
                                                <p>ZINGY/紫一 赖斯康牌芦荟胶囊 0.3g/粒*70粒 </p>
                                            </div>
                                            <span>=</span>
                                            <div class="price">
                                                <p>套装价：</p>
                                                <span><span>¥</span>156.00</span>
                                                <label>¥200.00</label>
                                                <button>购买套餐</button>
                                            </div>
                                        </header>
                                        <p>
                                            <span>药师点评：</span>帝岐轩金芷-快速止痛茶配ZINGY，/紫一 赖斯康牌芦荟胶囊，帝岐轩金芷-快速止痛茶配ZINGY/紫一 赖斯康牌芦荟胶囊，帝岐轩金芷-快速，止痛茶配ZINGY/紫一 赖斯康牌芦荟胶囊，帝岐轩金芷-快速止痛茶配ZINGY/紫一 赖斯康牌芦荟胶囊
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <span>优惠套装2</span>
                                    <div class="package_item item2 dn">
                                        <header>
                                            <div class="p1">
                                                <img src="image/product2.png" alt="">
                                                <p>帝岐轩金芷-快速止痛茶</p>
                                            </div>
                                            <span>+</span>
                                            <div class="p2">
                                                <img src="image/product2.png" alt="">
                                                <p>ZINGY/紫一 赖斯康牌芦荟胶囊 0.3g/粒*70粒 </p>
                                            </div>
                                            <span>=</span>
                                            <div class="price">
                                                <p>套装价：</p>
                                                <span><span>¥</span>256.00</span>
                                                <label>¥300.00</label>
                                                <button>购买套餐</button>
                                            </div>
                                        </header>
                                        <p>
                                            <span>药师点评：</span>帝岐轩金芷-快速止痛茶配ZINGY，/紫一 赖斯康牌芦荟胶囊，帝岐轩金芷-快速止痛茶配ZINGY/紫一 赖斯康牌芦荟胶囊，帝岐轩金芷-快速，止痛茶配ZINGY/紫一 赖斯康牌芦荟胶囊，帝岐轩金芷-快速止痛茶配ZINGY/紫一 赖斯康牌芦荟胶囊
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div> -->
                        <div class="btn">
                            <div>
                                <button>-</button>
                                <div>
                                    <input type="text" value="1" readonly="readonly">
                                </div>
                                <button>+</button>
                            </div>
                            <button class="add_shop">加入购物车</button>
                            <a href="javascript:void(0);"><img src="image/icon_collect.png" alt=""></a>
                            <a href="javascript:void(0);"><img src="image/icon_share.png" alt=""></a>
                        </div>
          
                    </div>
                </div>
                <div class="product_info_c">
                    <div class="aside_bar">
                        <div class="search">
                            <h2><i class="iconfont icon-sousuo"></i>搜索本店</h2>
                            <label>
                                关键字
                                <input type="text" >
                            </label>
                            <span>
                                价&nbsp;&nbsp;格
                                <input type="text">
                                -
                                <input type="text">
                            </span>
                            <button>搜索</button>
                        </div>
                        <div class="classify">
                            <h2><i class="iconfont icon-tubiao3"></i>店内分类</h2>
                            <ul>
                            <?php foreach($a_view_data['fenlei'] as $key=>$value){?>
                                <li>
                                    <h3>
                                        <span><?php echo $value['gc_name'];?></span>
                                        <i class="icon-nav iconfont"></i>
                                    </h3>
                                    <div class="classify_item dn">
                                        <ul>
                                            <?php foreach($value['child'] as $k=>$v){ ?>
                                            <li><a href="/search--<?php echo $value['gc_id']?>--------<?php echo $v['gc_id']?>---"><?php echo $v['gc_name']?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php 
                            }
                            ?>
                             <!--    <li>
                                    <h3>
                                        <span>男性保健</span>
                                        <i class="icon-nav iconfont"></i>
                                    </h3>
                                    <div class="classify_item dn">
                                        <ul>
                                            <li><a href="">美容美体</a></li>
                                            <li><a href="">补血养血</a></li>
                                            <li><a href="">延缓衰老</a></li>
                                            <li><a href="">产后护理</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <h3>
                                        <span>母婴保健</span>
                                        <i class="icon-nav iconfont"></i>
                                    </h3>
                                    <div class="classify_item dn">
                                        <ul>
                                            <li><a href="">美容美体</a></li>
                                            <li><a href="">补血养血</a></li>
                                            <li><a href="">延缓衰老</a></li>
                                            <li><a href="">产后护理</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <h3>
                                        <span>中老年保健</span>
                                        <i class="icon-nav iconfont"></i>
                                    </h3>
                                    <div class="classify_item dn">
                                        <ul>
                                            <li><a href="">美容美体</a></li>
                                            <li><a href="">补血养血</a></li>
                                            <li><a href="">延缓衰老</a></li>
                                            <li><a href="">产后护理</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <h3>
                                        <span>调节亚健康</span>
                                        <i class="icon-nav iconfont"></i>
                                    </h3>
                                    <div class="classify_item dn">
                                        <ul>
                                            <li><a href="">美容美体</a></li>
                                            <li><a href="">补血养血</a></li>
                                            <li><a href="">延缓衰老</a></li>
                                            <li><a href="">产后护理</a></li>
                                        </ul>
                                    </div>
                                </li> -->
                            </ul>
                        </div>
                        <div class="prom">
                            <h2>店铺热销</h2>
                            <ul>
                                <?php foreach($a_view_data['rexiao'] as $key=>$value){?>
                                <li>
                                    <a class="img" href="/item-<?php echo $value['goods_id']?>" style="background-image: url(<?php echo get_config_item('img_path').$a_view_data['rexiao'][$key]['store_id'].'/'.$value['goods_image']?>)"></a>
                                    <p><?php echo $value['goods_name']?></p>
                                    <span>¥<?php echo $value['goods_promotion_price']?></span>
                                </li>
                                <?php } ?>
                             
                            </ul>
                        </div>
                    </div>
                    <div class="product_detail">
                        <div class="product_detail_nav">
                            <ul>
                                <li class="active">商品详情</li>
                                <li>评价（<?php echo $a_view_data['pingjia']['all_num'];?>）</li>
                                <li>顾客咨询</li>
                                <li>服务说明</li>
                            </ul>
                            <div>
                              <!--   <h2>
                                    <span>手机购买</span>
                                    <i class="iconfont icon-erweima"></i>
                                </h2> -->
                                <div class="phone_buy dn">
                                    <h2>
                                        <span>手机购买</span>
                                        <i class="iconfont icon-erweima"></i>
                                    </h2>
                                    <img src="image/weixin-code.png" alt="">
                                </div>
                                <div class="price">
                                    <span>￥</span>
                                    <span><?php echo $a_view_data['shangpin']['goods_promotion_price']?></span>
                                </div>
                                <button>加入购物车</button>
                            </div>
                        </div>
                        <div class="content">
                            <div class="content_item content_item1 ">
                                <header>
                                    <ul>
                                        <li>商品名称：<?php echo $a_view_data['shangpin']['goods_name'];?></li>
                                      <!--   <li>商品编号：556464646464</li> -->
                                        <li>品牌：<?php echo $a_view_data['shangpin']['brand_name'];?></li>
                                 <!--        <li>商品毛重：340.00g</li>
                                        <li>商品产地：广东广州</li>
                                        <li>货号：56665</li>
                                        <li>蓝帽标识：保健食品（食健字）</li> -->
                                        <li>分类：<?php echo $a_view_data['shangpin']['brand_class']?></li>

                                    </ul>
                                </header>
                                <div style="font-size:16">
                                <?php echo htmlspecialchars_decode($a_view_data['shangpin']['goods_body'])?>
                                 <!--    <img class="img" src="image/details1.png" alt="">
                                    <img class="img" src="image/details2.png" alt="">
                                    <img class="img" src="image/details3.png" alt="">
                                    <img class="img" src="image/details4.png" alt="">
                                    <img class="img" src="image/details5.png" alt="">
                                    <img class="img" src="image/details6.png" alt="">
                                    <img class="img" src="image/details7.png" alt="">
                                    <img class="img" src="image/details8.png" alt=""> -->
                                </div>
                            </div>
                            <div class="content_item content_item2 dn">
                                <header>
                                    <div class="evaluation">
                                        <div>
                                            <h1><?php echo $a_view_data['pingjia']['good_pie']?> <span>%</span></h1>
                                            <label>好评率</label>
                                        </div>

                                        <ul>
                                            <li>
                                                <p>好评（<span><?php echo $a_view_data['pingjia']['good_pie']?></span>%）</p>
                                                <label><span style="width:<?php echo $a_view_data['pingjia']['good_pie']*2;?>px "></span></label>
                                            </li>
                                            <li>
                                                <p>中评（<span><?php echo $a_view_data['pingjia']['milieu_pie']?></span>%）</p>
                                                <label><span style="<?php echo $a_view_data['pingjia']['milieu_pie']*2;?> "></span></label>
                                            </li>
                                            <li>
                                                <p>差评（<span><?php echo $a_view_data['pingjia']['faute_pie']?></span>%）</p>
                                                <label><span style="width:<?php echo $a_view_data['pingjia']['faute_pie']*2?>px "></span></label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="evaluation_right">
                                        <h4>您可对已购的商品进行评价</h4>
                                        <label>评价拿积分</label>
                                        <p>
                                            <span>100积分=1元</span>
                                            <a href="">积分规则</a>
                                        </p>
                                    </div>
                                </header>
                                <section class="k_select">
                                    <ul>
                                        <li class="active" data-type="good" style="cursor:pointer">全部评价(<span><?php echo $a_view_data['pingjia']['all_num'];?></span>)</li>
                                        <li data-type="photo" style="cursor:pointer"> 晒图(<span><?php echo $a_view_data['pingjia']['photo_num'];?></span>)</li>
                                        <li data-type="good" style="cursor:pointer">好评(<span><?php echo $a_view_data['pingjia']['good']?></span>)</li>
                                        <li data-type="milieu" style="cursor:pointer">中评(<span><?php echo $a_view_data['pingjia']['milieu']?></span>)</li>
                                        <li data-type="faute" style="cursor:pointer">差评(<span><?php echo $a_view_data['pingjia']['faute']?></span>)</li>
                                    </ul>
                                    <div>
                                    <?php foreach($a_view_data['pinglun']['details'] as  $key=>$value){?>
                                        <div class="evaluation_item <?php echo $value['img_type'].' '.$value['pl_type'];?>"  >
                                            <div class="pic">
                                                <div class="img" style="background-image: url(image/icon_user.png)">
                                                    <label><label>V</label><span>1</span>会员</label>
                                                </div>
                                                <p><?php echo $value['member_name']?></p>
                                            </div>
                                            <div class="cont">
                                                <div>
                                                    <div class="user_e">
                                                        <p><?php
                                                        echo $value['geval_content'];
                                                        ?></p>
                                                        <?php if(!empty($value['show_image'])){?>
                                                        <div>
                                                            <?php foreach($value['show_image'] as $k=>$v){?>
                                                            <a class="img" style="background-image: url(<?php
                                                                echo $v;
                                                            ?>)"></a>
                                                            <?php }?>
                                                       
                                                        </div>
                                                        <?php } ?>

                                                        <div class="pic_show " style="display: none">
                                                            <div class="cursor_small"></div>
                                                            <div class="cursor_prev"></div>
                                                            <div class="cursor_next"></div>
                                                        </div>
                                                    </div>
                                                    <div class="score">
                                                        <div class="star<?php echo $value['geval_scores']?>"></div>
                                                        <p>收货后<?php echo $value['time_diff'];?>天评论</p>
                                                        <time><?php echo $value['geval_time_create'];?></time>
                                                    </div>
                                                </div>
                                                <?php if(!empty($value['geval_explain'])){?>
                                                <div class="customer_reply">
                                                    <div class="img" style="background-image: url(image/details1.png)"></div>
                                                    <p>
                                                        <span><?php echo $value['geval_storename']?></span>
                                                        <span><?php echo $value['geval_explain']?></span>
                                                        <!-- <time>2017-02-14  4:24 AM</time> -->
                                                    </p>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php }?>
                                   
                                    </div>
                                </section>
                            </div>
                            <div class="content_item content_item3 dn">
                                <label>*因厂家更改商品包装、场地、附配件等不做提前通知，以下内容仅供参考！给您带来的不变还请谅解。谢谢 </label>
                                <h1>常见问题汇总</h1>
                                <h2>
                                    <span>客服答疑·关心从点滴开始</span>
                                </h2>
                                <ul>
                                    <li>
                                        <h3>
                                            <span>问：你们网上为啥比超市卖的还贵？</span>
                                            <time>2017-03-11</time>
                                        </h3>
                                        <p>答：您好，不同网站、购买渠道的促销力度、促销时间都是不同的，所以价格也是不同的。但我们承诺
                                            到货的商品均为正品行货，请放心选购，感谢您支持1号店，祝您购物愉快！ </p>
                                    </li>
                                    <li>
                                        <h3>
                                            <span>问：商品的保质期是什么时候啊?</span>
                                            <time>2017-03-11</time>
                                        </h3>
                                        <p>答： 您好，由于商品库存批次不同，具体生产日期请以收到的实物为准，同时我们承诺到货的商品不会
                                            临近保质期，请放心选购，感谢您支持1号店，祝您购物愉快！</p>
                                    </li>
                                    <li>
                                        <h3>
                                            <span>问：你们网上为啥比超市卖的还贵？</span>
                                            <time>2017-03-11</time>
                                        </h3>
                                        <p>答：您好，不同网站、购买渠道的促销力度、促销时间都是不同的，所以价格也是不同的。但我们承诺
                                            到货的商品均为正品行货，请放心选购，感谢您支持1号店，祝您购物愉快！ </p>
                                    </li>
                                    <li>
                                        <h3>
                                            <span>问：商品的保质期是什么时候啊?</span>
                                            <time>2017-03-11</time>
                                        </h3>
                                        <p>答：您好，不同网站、购买渠道的促销力度、促销时间都是不同的，所以价格也是不同的。但我们承诺
                                            到货的商品均为正品行货，请放心选购，感谢您支持1号店，祝您购物愉快！ </p>
                                    </li>
                                    <li>
                                        <h3>
                                            <span>问：商品的保质期是什么时候啊?</span>
                                            <time>2017-03-11</time>
                                        </h3>
                                        <p>答：您好，不同网站、购买渠道的促销力度、促销时间都是不同的，所以价格也是不同的。但我们承诺
                                            到货的商品均为正品行货，请放心选购，感谢您支持1号店，祝您购物愉快！ </p>
                                    </li>
                                    <li>
                                        <h3>
                                            <span>问：商品的保质期是什么时候啊?</span>
                                            <time>2017-03-11</time>
                                        </h3>
                                        <p>答：您好，不同网站、购买渠道的促销力度、促销时间都是不同的，所以价格也是不同的。但我们承诺
                                            到货的商品均为正品行货，请放心选购，感谢您支持1号店，祝您购物愉快！ </p>
                                    </li>
                                    <li>
                                        <h3>
                                            <span>问：商品的保质期是什么时候啊?</span>
                                            <time>2017-03-11</time>
                                        </h3>
                                        <p>答：您好，不同网站、购买渠道的促销力度、促销时间都是不同的，所以价格也是不同的。但我们承诺
                                            到货的商品均为正品行货，请放心选购，感谢您支持1号店，祝您购物愉快！ </p>
                                    </li>
                                    <li>
                                        <h3>
                                            <span>问：商品的保质期是什么时候啊?</span>
                                            <time>2017-03-11</time>
                                        </h3>
                                        <p>答：您好，不同网站、购买渠道的促销力度、促销时间都是不同的，所以价格也是不同的。但我们承诺
                                            到货的商品均为正品行货，请放心选购，感谢您支持1号店，祝您购物愉快！ </p>
                                    </li>
                                    <li>
                                        <h3>
                                            <span>问：商品的保质期是什么时候啊?</span>
                                            <time>2017-03-11</time>
                                        </h3>
                                        <p>答：您好，不同网站、购买渠道的促销力度、促销时间都是不同的，所以价格也是不同的。但我们承诺
                                            到货的商品均为正品行货，请放心选购，感谢您支持1号店，祝您购物愉快！ </p>
                                    </li>
                                    <li>
                                        <h3>
                                            <span>问：商品的保质期是什么时候啊?</span>
                                            <time>2017-03-11</time>
                                        </h3>
                                        <p>答：您好，不同网站、购买渠道的促销力度、促销时间都是不同的，所以价格也是不同的。但我们承诺
                                            到货的商品均为正品行货，请放心选购，感谢您支持1号店，祝您购物愉快！ </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="content_item content_item4 dn">
                                <header>
                                    <h2>服务承诺：</h2>
                                    <p>7度购平台卖家销售并发货的商品，由平台卖家提供发票和相应的售后服务。请您放心购买！<br>
                                        注：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。只能确保为原厂正
                                        货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！</p>
                                </header>
                                <section>
                                    <div class="pay_method">
                                        <h3>支付方式</h3>
                                        <ul>
                                            <li>
                                                <img src="image/icon_pay_yl.png" alt="">
                                                <p>银联支付</p>
                                            </li>
                                            <li>
                                                <img src="image/icon_pay_ye.png" alt="">
                                                <p>余额支付</p>
                                            </li>
                                            <li>
                                                <img src="image/icon_pay_zfb.png" alt="">
                                                <p>支付宝支付</p>
                                            </li>
                                            <li>
                                                <img src="image/icon_pay_wx.png" alt="">
                                                <p>微信支付</p>
                                            </li>
                                            <li>
                                                <img src="image/icon_pay_cft.png" alt="">
                                                <p>财付通支付</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="shipping_advice">
                                        <h3>发货通知</h3>
                                        <ul>
                                            <li>
                                                <img src="" alt="">
                                                <div>
                                                    <label>发货时间</label>
                                                    <i></i>
                                                    <p>在确认付款后的24小时以内发货，若在16:00以前确定的订单将在当日发货。本公司一般周六日和国家法定假日不发货，如有特殊需求请致电客服电话：400-681-7707。否则7度购将顺延至下一工作日进行发货（大型活动期间，发货另行说明）</p>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="" alt="">
                                                <div>
                                                    <label>发货快递</label>
                                                    <i></i>
                                                    <p>默认申通快递，如果亲所在的地区不在申通快递收送范围，亲可以直接联系在线客服协商快递要求；</p>
                                                </div>

                                            </li>
                                            <li>
                                                <img src="" alt="">
                                                <div>
                                                    <label>收货提醒</label>
                                                    <i></i>
                                                    <p>*请您务必在签收快递前，确认商品完好无损后再签收，如检验商品过程中发现缺货、少货，可以拒签并第一时间联系我们。</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </section>
    <?php if(! empty($_SESSION['user_id'])){ ?>
        <?php $this->display('sidebar');?>
     <?php } ?>
<?php $this->display('footer');?>
</div>
<input type="hidden" value="<?php echo $a_view_data['k_goods_id']?>" name="goods_id">
<input type="hidden" value="<?php echo $a_view_data['shangpin']['store_id']?>" name="store_id">

<script>
$(function(){
    var statue=<?php echo $a_view_data['shangpin']['goods_state']?>;
    if(statue=='0'){
        var tips='该商品已下架';
        
    }else if(statue=='10'){
        var tips='该商品已停售';
    }

    if(statue!=1){
        var btn=$(".btn:eq(0)");
        btn.find("div:eq(0)").remove();
        btn.find("a").remove();
        btn.find("button").text(tips);
        $(".add_shop").removeClass("add_shop");
        btn.find("button").css("background","#34383b");
        
        $(".product_detail_nav").find("button").remove();
    }




    $(".k_select>ul>li").click(function(){
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
        var type=$(this).attr("data-type");
        $(".evaluation_item").siblings().css("display","none");
        $("."+type).css("display","flex");

    })

    $('.add_shop').click(function(){
         var url = '<?php echo $this->general->base64_convert(get_config_item('domain'));?>';
        var num=parseInt($(this).prev().find("input").val());
        var goodshop=$("input[type=hidden]").val();
		
        $.ajax({
            type : "POST",
            url : "<?php echo $this->router->url('goodshop');?>",
            data:{'goodsnum':num,'goodshop':goodshop},
            dataType : "text",
            success : function(res)
            {
                if (res == '1') {
                    alert("加入成功");
                } else if (res == '0') {
                    self.location= '<?php echo get_config_item('user_domain').'/login-';?>'+url;
                }
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                if(res.responseText==""){
                    alert("请检查网络配置");
                }else{
                    self.location= '<?php echo get_config_item('user_domain').'/login-';?>'+url;
                }
                console.log(res);
            }
        })
        
        });

    $(".price").siblings("button").click(function(){
         $('.btn ').children("button:last").click();
    })
})


$('.btn').find('a:eq(0)').click(function(){
    var cellgood = <?php echo $a_view_data['k_goods_id'];?>;

    $.ajax({
        type : "POST",
        url : "<?php echo get_config_item('main_domain').'/collect'?>",
        data: "cellgood="+cellgood,
        dataType : "json",
        success : function(res)
        {
            if(res=='1'){
                    alert("收藏成功");
                }else if(res=='2'){
                    alert("收藏失败");
                } else{
                    alert("您没有登录");
                }
        },
        error:function(res){
            alert(res.responseText);
        }
    });
});
    
</script>
</body>
</html>