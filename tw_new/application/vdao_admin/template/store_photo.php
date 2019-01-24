<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>照片审批</title>
	<script src="./script/jquery-1.8.2.min.js"></script>
	<style>

	</style>
</head>
<body>
	<h1>照片审批</h1>
	<div id="imglist">
		<ul>
			<?php foreach ($a_view_data as $key => $value): ?>
				<li id="li_<?php echo $value['store_id']; ?>">
					<h2><?php echo $value['store_name']; ?></h2>
					<?php
						$a_img = explode('&', $value['store_img']);
						foreach ($a_img as $k => $v) {
							echo '<div id="img_'.$value['store_id'].$k.'"><img src="'.$v.'">';
							echo "<button onclick='del_img(".$value['store_id'].','.$k.")'>删除</button></div>";
						}
					?>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
</body>
</html>

<script>

function del_img(store_id,num) {
	$('#img_'+store_id+num).remove();
	$.ajax({
		url: '<?php echo $this->router->url('store_photo'); ?>',
		type: 'post',
		dataType: 'json',
		data: {store_id: store_id,num:num},
		success: function(data) {
			console.log(data);
		}
	})
}

</script>