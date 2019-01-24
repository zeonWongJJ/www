<!DOCTYPE html>
<html>
<head>
	<title>登录</title>
  	<link rel="stylesheet" type="text/css" href="style/index.css" />
</head>
<body>
    <div class="puts">
	  	<?php echo $this->display('header');?>    
		    <form action="index" method="post" style="padding: 0px 339px;">
				<select id="dd" name="dd">	
		    		<option value="<?php echo date('Ym')?>"><?php echo date('Y-m')?></option>
		    		<?php foreach ($a_view_data['min'] as $min) {?>
		    			<option value="<?php echo $min[0]?>"><?php echo substr_replace($min[0], '-', 4, -2)?></option>
		    		<?php }?>
					<!-- <option value="201611">2016-11</option> 
					
					<option value="201701">2017-01</option>
					<option value="201702">2017-02</option>
					<option value="201703">2017-03</option>
					<option value="201704">2017-04</option>					
					<option value="201705">2017-05</option>					
					<option value="201706">2017-06</option>					
					<option value="201707">2017-07</option>					
					<option value="201708">2017-08</option> -->			
				</select>
				<input type="submit" name="submit" value="确定" />
			</form>
		<div class="tuo">
			<table>
				<tr>
					<td>姓&nbsp&nbsp&nbsp名</td>
					<td>分数</td>	
					<td><a>详情</a></td>			
				</tr>
				<br>
				<?php foreach ($a_view_data['details'] as $k) { ?>
				<tr>
					<td><?php echo $k['name']?></td>
					<td><?php echo $k['total']?></td>					
					<td><a href="details-<?php echo $k['uaername']?>-<?php echo $k['id']?>">详情</a></td>	
				</tr>
				<?php }?>
			</table>
		</div>
	</div>
</body>
</html>