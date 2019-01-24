<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="../css/common.css"/>
    <link rel="stylesheet" href="../css/competitiveDetails.css"/>
    <script src="../js/jquery-1.8.2.min.js"></script>
    <script src="../js/competitiveDetails.js"></script>
    <title></title>
</head>

<body>
    <!--  竞标详情 -->
    <div class="competitiveDetails">
        <!-- 遮罩层容器 -->
        <div class="zhezhaoBox hide"></div>
        <!-- 遮罩层容器 -->
        <!--  订单信息 -->
        <div class="orderInfo">
            <p><i><img src="../img/ht.png" alt=""/></i>平均竞标时间为<span>15-45分钟</span>&nbsp;请耐心等待</p>
            <dl>
                <dd>
                    <i><img src="../img/app.png" alt=""/></i>
                    <span><?php echo $a_view_data['order_detail']['title']; ?></span>
                </dd>
                <dd>
                    <i><img src="../img/naozhong.png" alt=""/></i>
                    <span><?php echo date('m月d日 h:i', $a_view_data['order_detail']['start_time']); ?> - <?php echo date('m月d日 h:i', $a_view_data['order_detail']['end_time']); ?></span>
                </dd>
                <dd>
                    <i><img src="../img/posi.png" alt=""/></i>
                    <span><?php echo $a_view_data['order_detail']['area_info']; ?></span>
                </dd>
            </dl>
            <!--  按钮组 -->
            <div class="orderBtnBox">
                <div>
                    <a href="<?php echo $this->router->url('demand_cancel', ['id'=>$a_view_data['order_detail']['demand_id']]); ?>">取消订单</a>
                    <a href="<?php echo $this->router->url('demand_detail', ['id'=>$a_view_data['order_detail']['demand_id']]); ?>">订单详情</a>
                    <a>立即付款</a>
                </div>
            </div>
            <!--  按钮组 -->
        </div>
        <!--  订单信息 -->
        <!--  投标的服务者 -->
        <div class="competitiveServant">
            <p><?php echo $a_view_data['order_detail']['bidder_num']; ?>位投标服务者</p>
            <div class="competitiveSelect">
                <div class="all">
                    <span>全部</span>
                    <i><img src="../img/xiaB.png" alt=""/></i>
                    <ul class="allBox">
                        <li>全部</li>
                        <li>fgh</li>
                        <li>fgh</li>
                    </ul>
                </div>
                <div class="sort">
                    <span>智能排序</span>
                    <i><img src="../img/xiaB.png" alt=""/></i>
                    <ul class="sortBox">
                        <li>智能排序</li>
                        <li>ffgh</li>
                        <li>fgh</li>
                    </ul>
                </div>
                <div class="nearSertvan" >
                    <span>附近服务者</span>
                    <i><img src="../img/xiaB.png" alt=""/></i>
                    <ul class="nearSertvanBox">
                        <li>附近服务者</li>
                        <li>fgh</li>
                        <li>fgh</li>
                    </ul>
                </div>
                <div class="screen" style="border:none;">
                    <span>筛选</span>
                </div>
            </div>
            <!-- 服务者选项 -->
            <div class="servantChoice hide">
                <ul>
                    <li class="companySwitch">
                        <span>只看企业</span>
                        <i class="open"><img src="../img/on_03.png" alt=""/></i>
                    </li>
                    <li class="servantRank">
                        <span>服务者等级</span>
                        <ul>
                            <li>
                                <a>
                                    <span style="border-radius:15px; padding:0 10px;">不限</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span class="choice">3+</span>
                                    <em>级</em>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span>5+</span>
                                    <em>级</em>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span>7+</span>
                                    <em>级</em>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span>9+</span>
                                    <em>级</em>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span>11+</span>
                                    <em>级</em>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span>13+</span>
                                    <em>级</em>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span>15+</span>
                                    <em>级</em>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="credit">
                        <span>信誉</span>
                        <a>最低信誉</a>
                        <hr/>
                        <a>最高信誉</a>
                    </li>
                    <!--  保障金与保修时间 -->
                    <li class="ketubbah">
                        <span>保障金与保修时间</span>
                        <div class="rangeBox">
                            <p>
                                <span>0+</span>
                                <em>¥15000</em>
                            </p>
                            <input class="rangeMoney" step="1000" type="range" value="0" min="0" max="15000"/>
                            <br/><br/>
                            <p>
                                <span>0个月+</span>
                            </p>
                            <input class="rangeMon" step="1" type="range" value="0" min="0" max="12"/>
                        </div>
                        <em>重置</em>
                        <a class="ketubbahSure">确定</a>
                    </li>
                    <!--  保障金与保修时间 -->
                </ul>
            </div>
            <!-- 服务者选项 -->
            <!--  服务者 -->
            <div class="competitiveList">
                <ul>
                    <li>
                        <!--  第一行 -->
                        <div class="list1">
                            <div class="listImg">
                                <i><img src="../img/ttt.jpg" alt=""/></i>
                            </div>
                            <div class="listInfo">
                                <div>
                                    <span>我只是个电工</span>
                                    <img src="../img/nan.png" alt=""/>
                                </div>
                                <div>
                                    <span>一级雏匠</span>
                                    <em>信誉值85分</em>
                                </div>
                                <em>番禺区 <<span>500</span>m</em>
                                <span> ¥<em>491</em></span>
                            </div>
                        </div>
                        <!--  第一行 -->
                        <!--  第二行 -->
                        <div class="list2">
                            <dl>
                                <dd style="width:37%;">
                                    <div>
                                        <i><img src="../img/naozhong.png" alt=""/></i>
                                        <span class="compdate">时间:10月20日</span>
                                    </div>
                                    <p class="compTime" style=" margin-top:4px; ">19:30</p>
                                </dd>
                                <dd>
                                    <div>
                                        <i><img src="../img/mhudun.png" alt=""/></i>
                                        <span class="baozhangjin">保障金</span>
                                    </div>
                                    <p class="compTime">0元</p>
                                </dd>
                                <dd style="border:none;">
                                    <div>
                                        <i><img src="../img/hudun.png" alt=""/></i>
                                        <span class="baoxiu">保修</span>
                                    </div>
                                    <p class="compTime">3个月</p>
                                </dd>
                            </dl>
                        </div>
                        <!--  第二行 -->
                        <!--  第三行 -->
                        <div class="list3">
                            <div class="contactBtn">
                                <a href="">
                                    <i><img src="../img/cobtn1.png" alt=""/></i>
                                    <span>联系Ta</span>
                                </a>
                                <a>
                                    <i><img src="../img/cobtn2.png" alt=""/></i>
                                    <span>请Ta服务</span>
                                </a>
                            </div>
                        </div>
                        <!--  第三行 -->
                        <!--<b><img src="../img/lq.png" alt=""/></b>-->
                    </li>
                </ul>
            </div>
            <!--  服务者 -->
        </div>
        <!--  投标的服务者 -->
        <!--  底部提示 -->
        <div class="botTips">
            <hr>
            <p>这是底线儿~</p>
            <hr/>
        </div>
        <!--  底部提示 -->
    </div>
    <!--  竞标详情 -->
    <!--  遮罩层 -->
    <div class="zhezhao hide"></div>
    <!--  遮罩层 -->
    <!--  弹出框 -->
    <div class="pop hide">
        <p>确定要选择Ta为你服务？</p>
        <a><span>确定</span></a>
        <a><em>再想想</em></a>
    </div>
    <!--  弹出框 -->
</body>
</html>