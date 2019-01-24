<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>消费统计</title>
	<style>
		table{
			border-collapse: collapse;
		}
		td,th{
			border:1px solid pink;
			padding: 10px;
		}
		a {
			text-decoration: none;
		}
	</style>
</head>
<body>
	<h1>消费统计</h1>
	<table>
		<tr>
			<th>主键id</th>
			<th>会员id</th>
			<th>用户名</th>
			<th>统计月份</th>
			<th>消费总金额</th>
			<th>推荐的人消费总金额</th>
			<th>购买的咖啡数</th>
			<th>推荐的人购买的咖啡数</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr>
			<td><?php echo $value['sta_id']; ?></td>
			<td><?php echo $value['user_id']; ?></td>
			<td><?php echo $value['user_name']; ?></td>
			<td><?php echo date('Y年m月', $value['sta_time']); ?></td>
			<td><?php echo $value['user_self']; ?></td>
			<td><?php echo $value['user_other']; ?></td>
			<td><?php echo $value['user_selfcount']; ?></td>
			<td><?php echo $value['user_othercount']; ?></td>
			<td><a href="<?php echo $this->router->url('statistic_selforder',['id'=>$value['sta_id']]); ?>">查看该用户的订单</a> | <a href="<?php echo $this->router->url('statistic_otherorder',['id'=>$value['sta_id']]); ?>">查看该用户推荐的人的订单</a></td>
		</tr>
		<?php endforeach ?>
	</table>
	<?php echo $this->pages->link_style_one($this->router->url('statistic_showlist-', [], false, false)); ?>
</body>
</html>