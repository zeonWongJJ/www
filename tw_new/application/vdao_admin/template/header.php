<?php date_default_timezone_set("PRC"); ?>
    <nav class="nav">
        <!-- 问候语 -->
        <span class="greetings">
            <?php if ( date('H',$_SERVER['REQUEST_TIME']) < '6' ) {
              echo 'Hi,凌晨好';
            } else if ( date('H',$_SERVER['REQUEST_TIME']) < '11' ) {
                echo 'Hi,上午好';
            } else if ( date('H',$_SERVER['REQUEST_TIME']) < '14' ) {
                echo 'Hi,中午好';
            } else if ( date('H',$_SERVER['REQUEST_TIME']) < '19' ) {
                echo 'Hi,下午好';
            } else if ( date('H',$_SERVER['REQUEST_TIME']) < '24' ) {
                echo 'Hi,晚上好';
            } ?>
        </span>
        <!-- 问候语 -->
        <!--  logo内容 -->
        <div class="logoBox">
            <i><img src="./static/style_default/image/logo.png" /></i>
            <p><?php echo $_SESSION['admin_name']; ?></p>
            <span><?php echo $_SESSION['role_name']; ?></span>
        </div>
        <!--  logo内容 -->
        <!-- 导航列表 -->
        <ul class="navList">
            <li class="homePage li_index">
                <a href="<?php echo $this->router->url('index'); ?>">
                    <img src="./static/style_default/image/indexPic_23.png" />
                    <span>首页</span>
                </a>
            </li>
            <li class="homePage lit_order_showlist">
                <a>
                    <img src="./static/style_default/image/indexPic_26.png" />
                    <span>订单管理</span>
                    <em class="aChild"><img src="./static/style_default/image/indexPic_34.png" /></em>
                </a>    
                <ul class="">
                  <li class="listCur">
                     <a href="<?php echo $this->router->url('order_showlist'); ?>">店铺订单</a>
                  </li>
                  <li class="">
                     <a href="<?php echo $this->router->url('share_order'); ?>">分享订单</a>
                  </li>
                </ul>
            </li>
            <li class="homePage li_user_showlist">
                <a href="<?php echo $this->router->url('user_showlist'); ?>">
                    <img src="./static/style_default/image/indexPic_28.png" />
                    <span>用户管理</span>
                </a>
            </li>
            <li class="homePage li_store_showlist">
                <a href="<?php echo $this->router->url('store_showlist'); ?>">
                    <img src="./static/style_default/image/indexPic_30.png" />
                    <span>门店管理</span>
                </a>
            </li>
            <li class="productClass lit_time_list">
                <a>
                    <img src="./static/style_default/image/dqiu.png" />
                    <span>品牌管理</span>
                    <em class="aChild"><img src="./static/style_default/image/indexPic_34.png" /></em>
                </a>
                <ul class="">
                    <li class="">
                        <a href="<?php echo $this->router->url('time_list'); ?>">时间段管理</a>
                    </li>
                </ul>
            </li>
            <li class="productClass lit_pro">
                <a>
                    <img src="./static/style_default/image/indexPic_32.png" />
                    <span>产品管理</span>
                    <em class="aChild"><img src="./static/style_default/image/indexPic_34.png" /></em>
                </a>
                <ul class="">
                    <li class="">
                        <a href="<?php echo $this->router->url('pro'); ?>">产品分类</a>
                    </li>
                    <li class="listCur">
                        <a href="<?php echo $this->router->url('product'); ?>">产品列表</a>
                    </li>
                    <li class="">
                        <a href="<?php echo $this->router->url('cup'); ?>">类型管理</a>
                    </li>
                    <li class="">
                        <a href="<?php echo $this->router->url('attri'); ?>">属性分类</a>
                    </li>
                    <li class="">
                        <a href="<?php echo $this->router->url('package_showlist'); ?>">套餐管理</a>
                    </li>
                </ul>
            </li>
            <li class="homePage lit_cons">
                <a>
                    <img src="./static/style_default/image/supi.png" />
                    <span>耗材管理</span>
                    <em class="aChild"><img src="./static/style_default/image/indexPic_34.png" /></em>
                </a>
                <ul class="">
                  <li class="">
                     <a href="cons">耗材分类</a>
                  </li>
                  <li class="">
                     <a href="annex">耗材列表</a>
                  </li>
                  <li class="">
                     <a href="store">耗材申请</a>
                  </li>
                  <li class="">
                     <a href="entry_record">库存记录</a>
                  </li>
                </ul>
            </li>
            <li class="room_cate lit_type_showlist">
                <a>
                    <img src="./static/style_default/image/indexPic_38.png" />
                    <span>房间管理</span>
                    <em class="aChild"><img src="./static/style_default/image/indexPic_34.png" /></em>
                </a>
                <ul class="">
                    <li class="">
                        <a href="<?php echo $this->router->url('type_showlist'); ?>">房型分类</a>
                    </li>
                    <li class="">
                        <a href="<?php echo $this->router->url('device_showlist'); ?>">设备管理</a>
                    </li>
                    <li class="">
                        <a href="<?php echo $this->router->url('room_showlist'); ?>">房型管理</a>
                    </li>
                </ul>
            </li>
            <li class="homePage li_mood_showlist">
                <a href="<?php echo $this->router->url('mood_showlist'); ?>">
                    <img src="./static/style_default/image/indexPic_40.png" />
                    <span>动态管理</span>
                </a>
            </li>
            <li class="homePage li_score_showlist">
                <a href="<?php echo $this->router->url('score_showlist'); ?>">
                    <img src="./static/style_default/image/indexPic_42.png" />
                    <span>积分管理</span>
                </a>
            </li>
            <li class="homePage lit_account_store">
                <a>
                    <img src="./static/style_default/image/indexPic_44.png" />
                    <span>结算管理</span>
                    <em class="aChild"><img src="./static/style_default/image/indexPic_34.png" /></em>
                </a>
                <ul class="">
                    <li class="">
                        <a href="<?php echo $this->router->url('account_store'); ?>">门店结算</a>
                    </li>
                    <li class="">
                        <a href="<?php echo $this->router->url('statistic_showlist'); ?>">消费统计</a>
                    </li>
                </ul>
            </li>
            <li class="homePage li_notice_showlist">
                <a href="<?php echo $this->router->url('notice_showlist'); ?>">
                    <img src="./static/style_default/image/indexPic_48.png" />
                    <span>公告管理</span>
                </a>
            </li>
            <li class="homePage lit_cate_showlist">
                <a>
                    <img src="./static/style_default/image/indexPic_52.png" />
                    <span>新闻管理</span>
                    <em class="aChild"><img src="./static/style_default/image/indexPic_34.png" /></em>
                </a>
                <ul class="">
                    <li class="">
                        <a href="<?php echo $this->router->url('cate_showlist'); ?>">新闻分类</a>
                    </li>
                    <li class="">
                        <a href="<?php echo $this->router->url('news_showlist'); ?>">新闻列表</a>
                    </li>
                </ul>
            </li>
            <li class="homePage li_shopman_showlist">
                <a href="<?php echo $this->router->url('shopman_showlist'); ?>">
                    <img src="./static/style_default/image/indexPic_54.png" />
                    <span>移动店主</span>
                </a>
            </li>
            <li class="homePage li_set_showlist">
                <a href="<?php echo $this->router->url('set_showlist'); ?>">
                    <img src="./static/style_default/image/indexPic_57.png" />
                    <span>设置中心</span>
                </a>
            </li>
            <li class="homePage li_set_showlist">
                <a href="<?php echo $this->router->url('withdraw_log_list'); ?>">
                    <img src="./static/style_default/image/indexPic_57.png" />
                    <span>提现问题</span>
                </a>
            </li>
            <!--<li class="homePage">
                <a href="<?php echo $this->router->url('index'); ?>">
                    <img src="./static/style_default/image/indexPic_59.png" />
                    <span>接口管理</span>
                </a>
            </li>-->
            <li class="permission lit_admin_showlist">
                <a>
                    <img src="./static/style_default/image/indexPic_61.png" />
                    <span>权限设置</span>
                    <em class="aChild"><img src="./static/style_default/image/indexPic_34.png" /></em>
                </a>
                <ul class="">
                    <li>
                        <a href="<?php echo $this->router->url('admin_showlist'); ?>">管理员管理</a>
                    </li>
                    <li class="">
                        <a href="<?php echo $this->router->url('role_showlist'); ?>">角色管理</a>
                    </li>
                </ul>
            </li>
            <li class="homePage li_join_showlist">
                <a href="<?php echo $this->router->url('join_showlist'); ?>">
                    <img style="width:16px;" src="./static/style_default/image/gf.png" />
                    <span>加盟申请</span>
                </a>
            </li>
            <li class="homePage li_qualifi">
                <a href="<?php echo $this->router->url('qualifi'); ?>">
                    <img src="./static/style_default/image/zs.png" />
                    <span>资质申请</span>
                </a>
            </li>
            <li class="homePage li_share_showlist">
                <a href="<?php echo $this->router->url('share_showlist'); ?>">
                    <img src="./static/style_default/image/sh.png" />
                    <span>分享审核</span>
                </a>
            </li>
            <li class="homePage li_share_showlist">
                <a href="<?php echo $this->router->url('ad_showlist'); ?>">
                    <img src="./static/style_default/image/gga.png" />
                    <span>广告管理</span>
                </a>
            </li>
        </ul>
        <!-- 导航列表 -->
    </nav>
<script>
var strUrl=window.location.href; 
var arrUrl=strUrl.split("/"); 
var arr={};
var strPage=arrUrl[arrUrl.length-1]; 
var filename=strPage.split("."); // 123      html
if (filename[1] == undefined) {
    var arr=strPage.split("-");   
} else {
    var pre=filename[filename.length-2];
    var arr=pre.split("-");    
};
if(arr[0]=='shopman_search' || arr[0]=='shopman_showlist') {
    arr[0]='shopman_showlist';
} else if(arr[0]=='order_showlist' || arr[0]=='share_order' || arr[0]=='order_coffee' || arr[0]=='order_office' || arr[0]=='book_showlist') {
    arr[0]='order_showlist';
} else if(arr[0]=='pro' || arr[0]=='product' || arr[0]=='cup' ||arr[0]=='attri') {
    arr[0]='pro';
} else if(arr[0]=='cons' || arr[0]=='annex' || arr[0]=='store' ||arr[0]=='entry_record') {
    arr[0]='cons';
} else if (arr[0]=='type_showlist' || arr[0]=='device_showlist' || arr[0]=='room_showlist') {
    arr[0]='type_showlist';
} else if (arr[0]=='account_store' || arr[0]=='statistic_showlist') {
    arr[0]='account_store';
} else if (arr[0]=='cate_showlist' || arr[0]=='news_showlist') {
    arr[0]='cate_showlist';
} else if (arr[0]=='admin_showlist' || arr[0]=='role_showlist') {
     arr[0]='admin_showlist';
};
$(".li_"+arr[0]).addClass('navCur');
$(".lit_"+arr[0]+">a>.aChild").html('<img src="./static/style_default/image/pro_41.png">');
$(".lit_"+arr[0]).children("ul").show(200);


</script>
