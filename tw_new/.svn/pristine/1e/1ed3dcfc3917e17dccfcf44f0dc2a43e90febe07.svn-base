<!DOCTYPE html>
<html>
<head>
	<title>考核</title>
	<link rel="stylesheet" type="text/css" href="style/index.css" />
</head>
<body>
    <div class="puts">	   
	    <?php echo $this->display('header');?>
		<div class="tuo">
				<table>
					<tr>
						<td>姓&nbsp&nbsp&nbsp名</td>
						<td><a>操作</a></td>			
					</tr>
					<br>
					<?php foreach ($a_view_data['brand'] as $k => $v) { ?>
					<tr>
						<td><?php echo $v?></td>
						<td><a href="<?php echo $this->router->url('check_butr',['bt'=>$k]) ?>">考核操作</a></td>	
						<!-- <td><a href="<?php echo $this->router->url('check_butr',['bt'=>$this->general->base64_convert($v)]) ?>">考核操作</a></td> -->
					</tr>
					<?php }?>
				</table>
		</div>
	</div>
</body>
</html>