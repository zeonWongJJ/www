<?php
$index_html = '/www/touch/index.html';
$index = file_exists($index_html) ? file_get_contents($index_html) : file_get_contents($index_html . '.back');

$inject = "<?php if (getenv('IS_PRODUCT')) { \$baseURL = getenv('SERVER_DOMAIN') ?: 'http://jiajie-server.7dugo.com';  } else { \$baseURL = 'http://192.168.1.200:19010'; } ?>
<script>window.config = {baseURL: \"<?php echo \$baseURL ?>\"};</script>";

file_put_contents('/www/touch/index.php', str_replace('<meta name=author content=php_inject>',$inject, $index));
copy('/www/touch/index.html', '/www/touch/index.html.back');
unlink('/www/touch/index.html');
