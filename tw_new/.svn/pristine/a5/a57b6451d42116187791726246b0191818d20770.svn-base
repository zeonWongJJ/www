<div class="breadcrumbs ace-save-state" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="/">首页</a>
		</li>
		<?php
		if (isset($a_view_data['breadcrumb']) && is_array($a_view_data['breadcrumb'])) {
			$i_count = count($a_view_data['breadcrumb']) - 1;
			$i = 0;
			foreach ($a_view_data['breadcrumb'] as $s_key => $s_val) {
		?>
		<li <?php if ($i_count == $i++) {?>class="active"<?php }?>>
			<a href="<?php echo $s_val;?>"><?php echo $s_key;?></a>
		</li>
		<?php
			}
		}
		?>
	</ul><!-- /.breadcrumb -->

	<div class="nav-search" id="nav-search">
		<form class="form-search">
			<span class="input-icon">
				<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
				<i class="ace-icon fa fa-search nav-search-icon"></i>
			</span>
		</form>
	</div><!-- /.nav-search -->
</div>