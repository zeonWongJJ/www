<?php if(isset($a_view_data['customize_js'])): ?>
<!--自定义js加载-->
<?php if (is_array($a_view_data['customize_js'])) { ?>
    <?php foreach ($a_view_data['customize_js'] as $js): ?>
    <script type="text/javascript" src="<?=ASSETS ?>/js/<?=$js;?>.js?<?=time()?>"></script>
    <?php endforeach; ?>
<?php } else { ?>
<script type="text/javascript" src="<?=ASSETS ?>/js/<?=$a_view_data['customize_js'];?>.js?<?=time()?>"></script>
<?php } ?>
<?php endif;?>
</body>
</html>