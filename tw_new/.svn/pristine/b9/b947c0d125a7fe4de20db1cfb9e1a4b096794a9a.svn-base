<!DOCTYPE html>
<html>
<head>
	<title>详情页</title>
	<link rel="stylesheet" type="text/css" href="style/index.css" />
</head>
<body>
    <div class="puts">
	    <?php echo $this->display('header');?>
	    <div class="tuo">
			<table>
		<?php //客服
        $this->load->config('hust', 'a_write');  
        //编辑
        $this->load->config('hust', 'a_redact');
        //技术
        $this->load->config('hust', 'a_science');
        if (in_array($this->router->get(1), $this->config['a_write'])) {?>      
	    	<ul>
	    		<li>姓&nbsp&nbsp&nbsp名 : <?php echo $a_view_data['name']?></li>
	    		<li>迟到 : <?php echo $a_view_data['late']?></li>
	    		<li>加分 : <?php echo $a_view_data['add']?></li>
	    		<li>请假 : <?php echo $a_view_data['leave']?></li>
	    		<li>减分 : <?php echo $a_view_data['minus']?></li>
	    		<li>好评 : <?php echo $a_view_data['fine']?></li>
	    		<li>中评 : <?php echo $a_view_data['centre']?></li>
	    		<li>差评 : <?php echo $a_view_data['bad']?></li>
	    		<li>其余 : <?php echo $a_view_data['fine']?>(好评数)+<?php echo $a_view_data['centre']?>(中评数)+<?php echo $a_view_data['bad']?>(差评数)=<?php echo $a_view_data['head']?></li>
	    		<li>总分 : (100 - （差评数除以总评数*100）-（中评数除以总评数再除以2*100）-考勤分+加的分-减分)=<?php echo $a_view_data['total']?></li>
	    		<li>时间 : <?php echo substr_replace($a_view_data['update_time'], '-', 4, -2);?></li>

	    	</ul>
    	<?php } else if (in_array($this->router->get(1), $this->config['a_redact'])) {?>
   			<ul>
	    		<li>姓&nbsp&nbsp&nbsp名 : <?php echo $a_view_data['name']?></li>
	    		<li>迟到 : <?php echo $a_view_data['late']?></li>
	    		<li>请假 : <?php echo $a_view_data['leave']?></li>
	    		<li>加分 : <?php echo $a_view_data['add']?></li>
	    		<li>减分 : <?php echo $a_view_data['minus']?></li>
	    		<li>任务的量 : <?php echo $a_view_data['measure_i']?></li>
	    		<li>完成的量 : <?php echo $a_view_data['measure']?></li>
	    		<li>基础分 : 100（超过一篇加1分，没达到的，按比例得分）= <?php echo $a_view_data['head']?></li>
	    		<li>总分 : (基础分-考勤分+加的分-减分)=<?php echo $a_view_data['total']?></li>
	    		<li>时间 : <?php echo substr_replace($a_view_data['update_time'], '-', 4, -2);?></li>
	    	</ul>
        <?php } else if (in_array($this->router->get(1), $this->config['a_science'])) {?>
    		<ul>
	    		<li>姓&nbsp&nbsp&nbsp名 : <?php echo $a_view_data['name']?></li>
	    		<li>迟到 : <?php echo $a_view_data['late']?></li>
	    		<li>请假 : <?php echo $a_view_data['leave']?></li>
	    		<li>加分 : <?php echo $a_view_data['add']?></li>
	    		<li>减分 : <?php echo $a_view_data['minus']?></li>
	    		<li>任务的量 : <?php echo $a_view_data['meuter_i']?></li>
	    		<li>完成的量 : <?php echo $a_view_data['meuter']?></li>
	    		<li>基础分 : 100（超过40小时的工作量每小时加一分，未完成的任务每个减20分）= <?php echo $a_view_data['head']?></li>
	    		<li>总分 : (基础分-考勤分+加的分-减分)=<?php echo $a_view_data['total']?></li>
	    		<li>时间 : <?php echo substr_replace($a_view_data['update_time'], '-', 4, -2);?></li>
	    	</ul>	
        <?php }?>			
			</table>
			
		</div>
	</div>
</body>
</html>