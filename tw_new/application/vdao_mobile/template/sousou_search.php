<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>搜索结果</title>
	<style>
		a {
			text-decoration: none;
			color: #666;
		}
	</style>
</head>
<body>
	<form action="<?php echo $this->router->url('sousou_search'); ?>" method='post'>
		<input type="text" name="keywords">
		<input type="submit" value="搜索">
	</form>
	<h1>搜索结果</h1>
	<h2>门店</h2>
	<div>
		<?php foreach ($a_view_data['store'] as $key => $value): ?>
			<li style="height:40px; line-height:40px;"><a href="<?php echo $this->router->url('store_detail',['id'=>$value['store_id']]); ?>">
				<?php echo str_replace($a_view_data['keywords'], "<span style='color:red;'>".$a_view_data['keywords']."</span>", $value['store_name']); ?>
			</a></li>
		<?php endforeach ?>
	</div>
	<h2>咖啡</h2>
	<div>
		<?php foreach ($a_view_data['product'] as $key => $value): ?>
			<li style="height:40px; line-height:40px;"><a href="<?php echo $this->router->url('item',['id'=>$value['product_id']]); ?>">
				<?php echo str_replace($a_view_data['keywords'], "<span style='color:red;'>".$a_view_data['keywords']."</span>", $value['product_name']); ?>
			</a></li>
		<?php endforeach ?>
	</div>
</body>
</html>