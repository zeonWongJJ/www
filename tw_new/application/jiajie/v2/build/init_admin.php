<?php
$index_html = '/www/admin/index.html';
file_exists($index_html) || $index_html = '/www/admin/index.html.back';
$index = file_get_contents($index_html);

$inject = "<?php 
    \$baseURL = getenv('SERVER_DOMAIN') ?: 'http://jiajie-server.7dugo.com';
?>
<script id=\"admin_config\">window.config={ api_prefix: '<?=\$baseURL;?>'}</script>";

$regex = "/<script id=\"admin_config\"[\s\S]*?<\/script>/i";
file_put_contents('/www/admin/index.php', preg_replace($regex, $inject, $index));
copy('/www/admin/index.html', '/www/admin/index.html.back');
unlink('/www/admin/index.html');
