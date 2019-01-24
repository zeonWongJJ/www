<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>消息管理</title>
		<link rel="stylesheet" href="static/style_default/style/common.css"/>
        <link rel="stylesheet" href="static/style_default/style/header.css"/>
        <link rel="stylesheet" href="static/style_default/style/newsManage.css"/>       
        <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>       
	</head>
	<body>
		<!-- 头部 -->
        <?php echo $this->display('top'); ?>
        <!-- 头部 -->
        <div class="bottom clearfix">
        	<!-- 导航 -->
	        <?php echo $this->display('left'); ?>
	        <!-- 导航 -->
	        <!--右边内容开始-->
	        <div class="rightSide">
	        	<!--面包屑导航开始-->
        		<div class="breadNav">
        			<a href="javascript:;">消息管理</a>       			
        		</div>
	        	<!--面包屑导航结束-->
	        	<!--消息模块开始-->
	        	<div class="newsBox clearfix">
	        	 	<?php foreach ($a_view_data['get'] as $value) {?>
                    <div class="sigleNews">
                        <p class="date"><i></i><?php echo $value['day']; ?></p>
                        <ul>
                            <?php foreach ($a_view_data['messg'] as $messg) {if ($value['day'] == date('Ymd',$messg['mess_time'])) {?>
                            <li>
                              <span class="news"><i class="red"><?php echo $messg['ues_name']; ?></i><?php echo $messg['content']; ?></span>
                              <i class="time"><?php echo date('H:i', $messg['mess_time']); ?></i>
                            </li>
                            <?php }}?>
                        </ul>
                    </div>
                    <?php }?>
	        	</div>
	        	<!--消息模块结束-->
	        </div>
	        <!--右边内容结束-->	
	        <!-- 分页 -->
            <div class="page">
                <?php echo $this->pages->link_style_one($this->router->url('message-', [], false, false)); ?>
                <span style="background:none">共计<em> <?php echo $a_view_data['getr']; ?> </em>条数据</span>
            </div>
             <!-- 分页 -->       	        	        	        
	</body>
</html>
