<!DOCTYPE html>
<html>
<head>
	<title>任务完成</title>
	<link rel="stylesheet" type="text/css" href="style/index.css" />
</head>
<body>
    <div class="puts">
    	<?php echo $this->display('header');?>    	
	    <div class="task">
			<ul>
				<li>名字</li>
				<li>任务</li>
				<li>内容</li>
				<li>是否完成</li>
			</ul>
			<ul>
			<form action="task_acco" method="post">
				<?php foreach ($a_view_data['tas'] as $tai) { ?>		
					<li><?php echo $tai['name']?></li>
					<li><?php echo $tai['title']?></li>
					<li><?php echo $tai['content']?></li>
					<li>						
						<select name="tasd">
							<option value="1">完成</option>	
		    				<option value="2">未完成</option>		    				
	    				</select>								
					</li>
				<?php }?>
				<input type="submit" name="submit" value="确定" />	
			</form>
			</ul>
	    </div>
	</div>
	
</body>
<script type="text/javascript">	
</script>
</html>