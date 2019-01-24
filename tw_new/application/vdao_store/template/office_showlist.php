<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>办公室列表</title>
	<style>
		table{
			border-collapse: collapse;
		}
		th,td{
			padding: 10px;
			border: 1px solid green;
		}
	</style>
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>办公室列表</h1>
	<table>
		<tr>
			<th>选择</th>
			<th>id</th>
			<th>名称</th>
			<th>类型</th>
			<th>设备</th>
			<th>大小</th>
			<th>座位</th>
			<th>描述</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr id="<?php echo 'tr_' . $value['office_id']; ?>">
			<td><input type="checkbox" name="office_id[]" value="<?php echo $value['office_id']; ?>"></td>
			<td><?php echo $value['office_id']; ?></td>
			<td><?php echo $value['room_name']; ?></td>
			<td><?php echo $value['type_name']; ?></td>
			<td><?php echo $value['device']; ?></td>
			<td><?php echo $value['room_size']; ?></td>
			<td><?php echo $value['room_seat']; ?></td>
			<td><?php echo $value['room_description']; ?></td>
			<td>
				<a href="<?php echo $this->router->url('office_plan',['id'=>$value['office_id']]); ?>">设置平面图</a> |
				<a href="#" onclick="office_delete_one(<?php echo $value['office_id']; ?>)">删除</a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<?php echo $this->pages->link_style_one($this->router->url('office_showlist-', [], false, false)); ?>
	<br>
	<button onclick="office_delete_mony()">批量删除</button>
	<br>
	<h1><a href="<?php echo $this->router->url('room_showlist'); ?>">添加办公室</a></h1>
</body>
</html>


<script>
	
$(".popEntry").hide();
	//让指定的DIV始终显示在屏幕正中间
    function setDivCenter(divName){
        var top = ($(window).height() - divName.height())/2;
        var left = ($(window).width() - divName.width())/2;
        var scrollTop = $(document).scrollTop();
        var scrollLeft = $(document).scrollLeft();
        divName.css( { 'top' : top + scrollTop,'left':left+scrollLeft }).show();
    }
    
    setDivCenter($(".popEntry"));
    
    $(".entry").click(function(){
    	$(".popEntry").show();
    });
    
    $(".entry>p>img").click(function(){
    	$(".popEntry").hide();
    });		

function office_delete_one(office_id) {
	if (confirm('你确定要删除这间办公室吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('office_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {office_id: office_id, type: 1},
			success:function(data){
				console.log(data);
				if (data.code==200) {
					$('#tr_'+office_id).remove();
					alert('删除成功');
				} else {
					alert('删除失败');
				}
			}
		})
	}
}


function office_delete_mony() {
	var office_ids = new Array();
	var i = 0;
	$("input:checkbox[name='office_id[]']:checked").each(function(index, el) {
		office_ids[i] = $(this).val();
		i++;
	});
	if (confirm('你确定要删除这'+office_ids.length+'间办公室吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('office_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			async: true,
			data: {office_ids: office_ids, type: 2},
			success: function(obj) {
				console.log(obj);
				if (obj.code==200) {
					for (var i=0; i<obj.data.length; i++) {
						$('#tr_'+obj.data[i]).remove();
					}
					alert(obj.data.length+'间办公室删除成功');
				} else {
					alert(obj.msg);
				}
			}
		})
	}
}

</script>