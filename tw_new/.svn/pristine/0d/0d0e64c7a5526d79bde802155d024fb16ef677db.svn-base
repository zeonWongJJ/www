<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>附近门店列表</title>
</head>
<body>
	<h1>附近门店列表</h1>
	<ul>
		<?php foreach ($a_view_data as $key => $value): ?>
			<li><a href="<?php echo $this->router->url('store_detail',['sid'=>$value['store_id']]); ?>"><?php echo $value['store_name']; ?></a></li>
		<?php endforeach ?>
	</ul>
</body>
</html>