<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="keywords" content="HTML,ASP,PHP,SQL">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=6" ><!-- 使用IE6 -->
    <meta http-equiv="X-UA-Compatible" content="IE=7" ><!-- 使用IE7 -->
    <meta http-equiv="X-UA-Compatible" content="IE=8" ><!-- 使用IE8 -->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="./static/style_default/style/common.css"/>
    <!--<link rel="stylesheet" href="./static/style_default/style/public.css"/>-->
    <link rel="stylesheet" href="./static/style_default/style/header.css"/>
    <link rel="stylesheet" href="./static/style_default/style/storeIndex.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="http://echarts.baidu.com/build/dist/echarts.js"></script>
    <script src="./static/style_default/script/storeIndex.js"></script>
    <title>门店管理系统首页</title>
</head>
<body style="background:#efefef;">
    <!-- 门店首页 -->
    <div class="storeIndex">
        <!-- 头部 -->
        <?php echo $this->display('top'); ?>
        <!-- 头部 -->

        <!-- 导航 -->
        <?php echo $this->display('left'); ?>
        <!-- 导航 -->

        <!--  右侧内容 -->
        <article>
            <!--  信息列表 -->
            <div class="infoList">
                <a href="" class="sales">
                    <div class="listL">
                        <p>累计销售金额</p>
                        <span><?php echo $a_view_data['store']['store_amount']; ?></span>
                    </div>
                    <div class="listR">
                        <img src="./static/style_default/images/nb_03.png" alt=""/>
                    </div>
                </a>
                <a href="" class="orders">
                    <div class="listL">
                        <p>累计成交饮品订单数</p>
                        <span><?php echo $a_view_data['store']['store_order']; ?></span>
                    </div>
                    <div class="listR">
                        <img src="./static/style_default/images/nb_05.png" alt=""/>
                    </div>
                </a>
                <a href="" class="roomOrders">
                    <div class="listL">
                        <p>累计成交房间订单数</p>
                        <span><?php echo $a_view_data['store']['store_officeorder']; ?></span>
                    </div>
                    <div class="listR">
                        <img src="./static/style_default/images/nb_07.png" alt=""/>
                    </div>
                </a>
            </div>
            <!--  信息列表 -->

            <!-- 概况与订单 -->
            <div class="conten_boxA">
                <!-- 店铺概况 -->
                <div class="storeSurvey">
                    <p>店铺概况</p>
                    <!-- 概况标题 -->
                    <div class="survetTit">
                        <span class="room_tit surCur">房间数</span>
                        <span class="product_tit">生产量</span>
                    </div>
                    <!-- 概况标题 -->
                    <!-- 房间数 -->
                    <div class="roomNum">
                        <div id="pieMain" style="width:400px; height:300px"></div>
                        <div class="saleNum">
                            <em class="saleMonth">
                                <span>31,945</span>
                                <p>月餐饮销售额</p>
                            </em>
                            <em class="saleMonth">
                                <span>31,945</span>
                                <p>今日销售额</p>
                            </em>
                        </div>
                    </div>
                    <!-- 房间数 -->
                    <!-- 生产量 -->
                    <div class="productNum hide">
                        <div class="progressBg">
                            <div class="progress"></div>
                        </div>
                    </div>
                    <!-- 生产量 -->
                </div>
                <!-- 店铺概况 -->
                <!-- 最新咖啡订单 -->
                <div class="coffeeOrders">
                    <p>附近最新餐饮订单</p>
                    <ul>
                        <li class="cofeOrderTit">
                            <span class="c1">用户名</span>
                            <span class="c2">下单时间</span>
                            <span class="c3">预约时间</span>
                            <span class="c4">距离</span>
                            <span class="c5">订单详情</span>
                            <span class="c6">金额</span>
                            <span class="c7">操作</span>
                        </li>
                        <li class="cofeOrderList">
                            <span class="c1">
                                <img src="./static/style_default/images/store_29.png" alt=""/>
                                <em>还我大鸡腿</em>
                            </span>
                            <span class="c2">2017-06-08 12:00</span>
                            <span class="c3">2017-06-08 12:00</span>
                            <span class="c4">0.5km</span>
                            <a href="" class="c5" style="color:#61acf4;" >查看详情</a>
                            <span class="c6">49元</span>
                            <a href="" class="c7" style="color:#61acf4;">抢单</a>
                        </li>
                        <li class="cofeOrderList">
                            <span class="c1">
                                <img src="./static/style_default/images/store_29.png" alt=""/>
                                <em>还我大鸡腿</em>
                            </span>
                            <span class="c2">2017-06-08 12:00</span>
                            <span class="c3">2017-06-08 12:00</span>
                            <span class="c4">0.5km</span>
                            <a href="" class="c5" style="color:#61acf4;" >查看详情</a>
                            <span class="c6">49元</span>
                            <a href="" class="c7" style="color:#61acf4;">抢单</a>
                        </li>
                        <li class="cofeOrderList">
                            <span class="c1">
                                <img src="./static/style_default/images/store_29.png" alt=""/>
                                <em>还我大鸡腿</em>
                            </span>
                            <span class="c2">2017-06-08 12:00</span>
                            <span class="c3">2017-06-08 12:00</span>
                            <span class="c4">0.5km</span>
                            <a href="" class="c5" style="color:#61acf4;" >查看详情</a>
                            <span class="c6">49元</span>
                            <a href="" class="c7" style="color:#61acf4;">抢单</a>
                        </li>
                        <li class="cofeOrderList">
                            <span class="c1">
                                <img src="./static/style_default/images/store_29.png" alt=""/>
                                <em>还我大鸡腿</em>
                            </span>
                            <span class="c2">2017-06-08 12:00</span>
                            <span class="c3">2017-06-08 12:00</span>
                            <span class="c4">0.5km</span>
                            <a href="" class="c5" style="color:#61acf4;" >查看详情</a>
                            <span class="c6">49元</span>
                            <a href="" class="c7" style="color:#61acf4;">抢单</a>
                        </li>
                        <li class="cofeOrderList">
                            <span class="c1">
                                <img src="./static/style_default/images/store_29.png" alt=""/>
                                <em>还我大鸡腿</em>
                            </span>
                            <span class="c2">2017-06-08 12:00</span>
                            <span class="c3">2017-06-08 12:00</span>
                            <span class="c4">0.5km</span>
                            <a href="" class="c5" style="color:#61acf4;" >查看详情</a>
                            <span class="c6">49元</span>
                            <a href="" class="c7" style="color:#61acf4;">抢单</a>
                        </li>
                        <li class="cofeOrderList">
                            <span class="c1">
                                <img src="./static/style_default/images/store_29.png" alt=""/>
                                <em>还我大鸡腿</em>
                            </span>
                            <span class="c2">2017-06-08 12:00</span>
                            <span class="c3">2017-06-08 12:00</span>
                            <span class="c4">0.5km</span>
                            <a href="" class="c5" style="color:#61acf4;" >查看详情</a>
                            <span class="c6">49元</span>
                            <a  class="c7" >已抢单</a>
                        </li>
                        <li class="cofeOrderList">
                            <span class="c1">
                                <img src="./static/style_default/images/store_29.png" alt=""/>
                                <em>还我大鸡腿</em>
                            </span>
                            <span class="c2">2017-06-08 12:00</span>
                            <span class="c3">2017-06-08 12:00</span>
                            <span class="c4">0.5km</span>
                            <a href="" class="c5" style="color:#61acf4;" >查看详情</a>
                            <span class="c6">49元</span>
                            <a href="" class="c7" style="color:#61acf4;">抢单</a>
                        </li>
                    </ul>
                </div>
                <!-- 最新咖啡订单 -->
            </div>
            <!-- 概况与订单 -->

            <!-- 店铺信息与其他 -->
            <div class="conten_boxB">
                <!-- 左边店铺信息 -->
                <div class="storeLeft">
                    <div  class="store_bg"></div>
                    <img src="./static/style_default/images/tt_03.png" alt=""/>
                    <div class="evaluate">
                        <a>
                           <p>好评率</p>
                            <span><?php echo $a_view_data['good_rate']; ?>%</span>
                        </a>
                        <a>
                            <p>服务态度</p>
                            <span><?php echo $a_view_data['service_score']; ?></span>
                        </a>
                        <a>
                            <p>服务质量</p>
                            <span><?php echo $a_view_data['goods_score']; ?></span>
                        </a>
                        <a>
                            <p>服务速度</p>
                            <span>5.0</span>
                        </a>
                    </div>
                </div>
                <!-- 左边店铺信息 -->

                <!--  其他 -->
                <div class="otherRight">
                    <!-- 资金管理 -->
                    <div class="capital">
                        <p>资金管理</p>
                        <div class="balance">
                            <span>
                                <em><?php echo $a_view_data['store']['store_balance']; ?></em>
                                <p>账户余额</p>
                            </span>
                            <a href="">提现</a>
                            <img src="./static/style_default/images/zhexian_03.png" alt=""/>
                        </div>
                    </div>
                    <!-- 资金管理 -->
                    <!-- 代办事项 -->
                    <div class="matter">
                        <p>待办事项</p>
                        <div class="mat_cofe">
                            <p>餐饮订单</p>
                            <a href="">
                                <i>2</i>
                                <img src="./static/style_default/images/store_43.png" alt=""/>
                                <span>待配送</span>
                            </a>
                            <a href="">

                                <img src="./static/style_default/images/store_45.png" alt=""/>
                                <span>待配送</span>
                            </a>
                        </div>
                        <div class="mat_room">
                             <p>会议订单</p>
                            <a href="">

                                <img src="./static/style_default/images/store_47.png" alt=""/>
                                <span>待配送</span>
                            </a>
                            <a href="">

                                <img src="./static/style_default/images/store_49.png" alt=""/>
                                <span>待配送</span>
                            </a>
                            <a href="">
                                <i>1</i>
                                <img src="./static/style_default/images/store_51.png" alt=""/>
                                <span>待配送</span>
                            </a>
                        </div>
                    </div>
                    <!-- 代办事项 -->

                    <!--  账户安全 -->
                    <div class="account">
                        <p>账户安全</p>
                        <i><img src="./static/style_default/images/safe_03.png" alt=""/></i>
                        <em>安全等级：<s>中</s></em>
                        <a href="">修改密码</a>
                    </div>
                    <!--  账户安全 -->

                    <!-- 最新评价 -->
                    <div class="newEvaluate">
                        <p>最新评价</p>
                        <a href="">
                            <span>查看更多</span>
                            <img src="./static/style_default/images/indexPic_34.png" alt=""/>
                        </a>
                        <ul>
                        	<?php foreach ($a_view_data['store_comment'] as $key => $value): ?>
                            <li>
                                <img src="<?php echo $value['user_pic']; ?>" alt=""/>
                                <span><?php echo $value['user_name']; ?></span>
                                <em>评价订单：<?php echo $value['order_number']; ?>：</em>
                                <s><?php echo $value['comment_content']; ?></s>
                                <a>
                                    <img src="./static/style_default/images/store_59.png" alt=""/>
                                    <span><?php echo date('Y-m-d',$value['comment_time']); ?></span>
                                    <em><?php echo date('H:i',$value['comment_time']); ?></em>
                                </a>
                            </li>
                        	<?php endforeach ?>
                        </ul>
                    </div>
                    <!-- 最新评价 -->
                </div>
                <!--  其他 -->

            </div>
            <!-- 店铺信息与其他 -->
        </article>
        <!--  右侧内容 -->
    </div>
</body>
</html>

<script>
$(function (){
    // 路径配置
    require.config({
        paths: {
            echarts: 'http://echarts.baidu.com/build/dist'
        }
    });

    // 使用
    require(
        [
            'echarts',
            'echarts/chart/pie'
        ],
        function drawBar(ec) {
            // 基于准备好的dom，初始化echarts图表
            var myChart = ec.init(document.getElementById('pieMain'));
            var office_stopped = "<?php echo $a_view_data['office_stopped']; ?>";
            var office_free = "<?php echo $a_view_data['office_free']; ?>";
            var office_use = "<?php echo $a_view_data['office_use']; ?>";
            var office_fault = "<?php echo $a_view_data['office_fault']; ?>";
            var option = {

                calculable : true,
                series : [
                    {
                        name:'房间分析',
                        type:'pie',
                        radius : '60%',
                        center: ['50%', '50%'],
                        data:[
                            {value:100, name:'暂停使用（'+office_stopped+'）'},
                            {value:310, name:'使用中（'+office_use+'）'},
                            {value:234, name:'空闲中（'+office_free+'）'},
                            {value:135, name:'故障中（'+office_fault+'）'}
                        ],
                        itemStyle: {
                            normal: {
                                color: function(params) {
                                    // build a color map as your need.
                                    var colorList = [
                                        '#3e50b4','#2095f2','#e81d62','#ccdb38'
                                    ];
                                    return colorList[params.dataIndex];
                                }
                            }
                        }
                    }

                ]
            };


            // 为echarts对象加载数据
            myChart.setOption(option);
        }

    );

    //生产量
    //doProgress();


})

//function SetProgress(progress) {
//  if (progress) {
//      $(".progress").css("width", String(progress) + "%"); //控制#loading div宽度
//      $(".progress").html(String(progress) ); //显示百分比
//  }
//}
//var i = 0;
//function doProgress() {
//  if (i > 100) {
//      //$("#message").html("加载完毕！").fadeIn("slow");//加载完毕提示
//      return;
//  }
//  if (i <= 10) {
//      setTimeout("doProgress()", 10);
//      SetProgress(i);
//      i++;
//  }
//}
</script>