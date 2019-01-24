<?php
    //搜索框中显示的内容 
    if(strpos($this->router->get_url(),'search') && ! empty($this->router->get(1))){
        $search = urldecode($this->router->get(1));
    } else {
        $search = '请输入搜索的商品名称';
    } ?>
<!-- 头部开始 -->
<style>
	*{margin:0; padding:0; border:0;}
	.titBan{width:100%; height:160px;}
    .titBan img{width:100%; height:160px;}
</style> 	
<header>
	<div class="titBan">
		<a href="http://www.7dugo.com/search-金芷-0-0-0-0-0-0-0-0-0-0-0-0-.html
"><img src="image/PCAdvert.png" alt="" /></a>
</div> 		
    <div id="top_nav">
        <nav>
            <div class="logo">
                <i class="icon-nav iconfont"></i>
            </div>
            <div class="menu_login">
                <div class="search active searchcate">
                    <div>
                        <input type="text" name="search" placeholder="<?php echo $search ?>">
                    </div>
                    <i class="showInput" style="background-position:-108px 6px"></i>
                    <a class="dn">
                        <i class="iconfont" style="background-position:-108px 6px"></i>
                    </a>
                </div>
                <a href="<?php echo $this->router->url('shop'); ?>"><i style="background-position:6px 6px "></i></a>
                <?php  $_SESSION['back_url'] = $this->router->get_url();
                    if(isset($_SESSION['user_id']) && ! empty($_SESSION['user_id'])){ ?>
                    <a href="<?php echo  get_config_item("user_domain") . '/index.html'; ?>"><div class="user img" style="background-image: url(image/icon_user.png)"></div></a>
                <?php }else { ?>
                    <a href="<?php echo  get_config_item("user_domain") . '/index.html'; ?>"><i style="background-position:-30px 6px "></i></a>
                <?php } ?>
                <div class="login_info">
                    <i style="background-position:-70px 6px "></i>
                    <div class="dn">
                        <ul>
                            <li><a href="<?php echo  get_config_item("user_domain") . '/order_form.html';?>">我的订单</a></li>
                            <li><a href="<?php echo $this->router->url('shop'); ?>">我的购物车</a></li>
                            <li><a href="<?php echo  get_config_item("user_domain") . '/collection.html';?>">我的收藏</a></li>
                            <?php if(isset($_SESSION['user_id'])){ ?>
                                <li><a href="<?php echo  get_config_item("user_domain") . '/logout.html'?>">退出</a></li>
                            <?php }else{ ?>
                                <li><a href="<?php echo  get_config_item("user_domain") . '/login.html';?>">登录</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="menu">
                <div class="search searchcate">
                    <input type="text" placeholder="请输入搜索的商品名称">
                    <i class="iconfont icon-sousuo"></i>
                </div>
                <ul>
                    <?php foreach ($a_view_data as $key => $value) { ?>
                    <li>
                        <span><a href="<?php echo $this->router->url("search", ["", "cate_id" => $value['gc_id'], '0', '0', '0', '0', '0', '0', '0', '0', '0','0','0']);  ?>"><?php echo $value['gc_name']; ?></a></span>
                        <i class="iconfont icon-xiayiye"></i>
                        <div class="menu_sub_content dn">
                            <div class="list">
                            <?php foreach ($value['child'] as $kk => $vv) { ?>
                                <dl>
                                    <dt><a href="<?php echo $this->router->url("search", ["", "cate_id" => $value['gc_id'], '0', '0', '0', '0', '0', '0', '0', 'thrid' => $vv['gc_id'], '0', '0','0']);  ?>">
                                            <?php echo $vv['gc_name']; ?>
                                        </a>
                                    </dt>
                                    <?php if(is_array($vv['son'])){
                                        foreach ($vv['son'] as $k => $v) { 
                                            echo '<dd><a href="' . $this->router->url("search", ["keyword" => str_replace('-', '+', urlencode($v)), "cate_id" => $value['gc_id'],'0', '0', '0', '0', '0', '0', '0', 'thrid' => $vv['gc_id'], '0', '0','0']) . ' ">' . $v .'</a></dd>';
                                           }
                                        }?>
                                    <a href="<?php echo $this->router->url("search", ["", "cate_id" => $value['gc_id'], '0', '0', '0', '0', '0', '0', '0', 'thrid' => $vv['gc_id'], '0','0','0']);  ?>.html">
                                            所有<?php echo $vv['gc_name']; ?>
                                    </a>
                                </dl>
                            <?php } ?>
                            </div>
                            <div class="menu_sub_foot">
                                <a href="<?php echo $this->router->url("search", ["", "cate_id" => $value['gc_id'], '0', '0', '0', '0', '0', '0', '0', '0', '0', '0','0']); ?>.html">
                                    所有<?php echo $value['gc_name']; ?>系列
                                </a>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </div>
</header>
<script>
main_domain='<?php echo get_config_item("main_domain")?>';
    (function() {
            if (!
                            /*@cc_on!@*/
                    0) return;
            var e = "abbr, article, aside, audio, canvas, datalist, details, dialog, eventsource, figure, footer, header, hgroup, mark, menu, meter, nav, output, progress, section, time, video".split(', ');
            var i= e.length;
            while (i--){
                document.createElement(e[i])
            }
        })()
    $(".login_info").hover(
        function () {
            $(this).find("div").removeClass("dn");
        },
        function () {
            $(this).find("div").addClass("dn");
        }
    );
</script>