<!DOCTYPE html>
<html>
<head>
	<title>任务列表</title>
	<link rel="stylesheet" type="text/css" href="style/index.css" />
</head>
<body>
    <div class="puts">
    	<?php echo $this->display('header');?>    	
	    <div class="tasks">
	    <form action="tasks" method="post">
			<div class="logi">				
				执行人 ：
				<select id="executor" name="executor">
					<option value=""></option> 
					<?php foreach ($a_view_data['yshw'] as $key => $value) { ?>
						<option value="<?php echo $key?>"><?php echo $value?></option>
					<?php }?>
				</select>				
				状态 ：
				<select id="wen" name="wen">
					<option value=""></option>
					<option value="2">未完成</option>
					<option value="1">完成</option>
				</select>			
				<input type="submit" value="确定" > 
				<a href="<?php echo $this->router->url('task')?>" style="margin: auto 60px;">创建任务</a>
			</div>
		</form>
	    
			<ul>
				<li>发布人</li>
				<li>执行人</li>
				<li>任务</li>
				<li>内容</li>				
				<li>任务开始时间</li>
				<li>任务结束时间</li>
				<li>创建时间</li>
				<li>状态</li>
				<li>消耗时间</li>
				<li>操作</li>
			</ul>
			<ul>
				<?php foreach ($a_view_data['tasks'] as $val) { ?>			
					<li><?php echo $val['manage']?></li>
					<li><?php echo $val['name']?></li>
					<li><?php echo $val['title']?></li>				
					<li><?php echo $val['content']?></li>				
					<li><?php echo substr_replace($val['time_start'], '', 10);?></li>				
					<li><?php echo substr_replace($val['time_end'], '', 10);?></li>				
					<li><?php echo date("Y-m-d ", $val['time_creation']);?></li>
					<li><a href="<?php echo $this->router->url('task_accomplish', [$val['id']]);?>"><?php if($val['accomplish'] == 2){
							echo "未完成";
						} else {
							echo "完成";
						}?></a></li>	
					<li><?php if ($val['residency'] == 0) { ?>
						  	<?php echo '运行中';?>
						<?php } else {?>
							<?php echo $val['residency'];?>小时
						<?php }?>
					</li>		
					<li><a href="<?php echo $this->router->url('taskde', [$val['id']]);?>">操作</a></li>
				<?php }?>				
			</ul>
			<div class="page"><?php echo $a_view_data['page'];?></div>
	    </div>
	</div>
	
</body>
</html>