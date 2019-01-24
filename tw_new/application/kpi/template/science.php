<!DOCTYPE html>
<html>
<head>
	<title>技术考核表</title>
	<link rel="stylesheet" type="text/css" href="style/index.css" />
</head>
<body>
    <div class="puts">
	    <?php echo $this->display('header');?>
	    <div class="redact">
			<form action="" method="post">
					迟到 ：<input type="text" name="late" class="logi" value="">	<br>
					请假 ：<input type="text" name="leave" class="logi" value="">	<br>
					加分 ：<input type="text" name="add" class="logi" value="">	<br>
					减分 ：<input type="text" name="minus" class="logi" value="">	<br>
					<input type="submit" value="确定" >
			</form>
		</div>
	</div>
	
</body>
</html>