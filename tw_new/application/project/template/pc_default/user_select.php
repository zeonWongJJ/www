<div id="tw_<?php echo $a_view_data['checkbox_name'];?>" class="">
<?php
if ($a_view_data['multiple']) {
?>
<div class="btn btn-white btn-warning">
	<label class="pos-rel">
		<input type="checkbox" class="ace" />
		<span class="lbl"> 全选 </span>
	</label>
</div>
<?php
}

foreach ($a_view_data['user'] as $a_user) {
?>
<div class="btn btn-white btn-warning">
<label>
	<?php
	if ($a_view_data['multiple']) {
	?>
	<input name="<?php echo $a_view_data['checkbox_name'];?>[]" type="checkbox" class="ace" value="<?php echo $a_user['id_user'];?>" />
	<span class="lbl"> <?php echo $a_user['name_real'];?> </span>
	<?php
	} else {
	?>
	<input name="<?php echo $a_view_data['checkbox_name'];?>" class="ace" type="radio" value="<?php echo $a_user['id_user'];?>">
	<span class="lbl"> <?php echo $a_user['name_real'];?> </span>
	<?php
	}
	?>
</label>
</div>
<?php
}
?>
</div>
<script>
var active_class = 'active';
$('#tw_<?php echo $a_view_data['checkbox_name'];?> > div > label > input[type=checkbox]').eq(0).on('click', function(){
	var th_checked = this.checked;
	$('#tw_<?php echo $a_view_data['checkbox_name'];?>').find('div').each(function(){
		var row = this;
		if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
		else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
	});
});
</script>