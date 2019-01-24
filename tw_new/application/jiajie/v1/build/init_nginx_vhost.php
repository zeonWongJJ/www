<?php

$domain_env_append    = '_DOMAIN';
$root_env_append      = '_ROOT';
$port_env_append      = '_PORT';
$nginx_vhost_file_ext = '.conf';
$nginx_vhost_temp     = file_get_contents(__DIR__ . '/nginx_vhost_temp.conf');
$nginx_vhost_path     = '/data/nginx/vhost/';

if (!is_dir($nginx_vhost_path)) {
    mkdir($nginx_vhost_path, 0777, true);
}

foreach (['admin', 'touch', 'pc', 'server'] as $map) {
    $end_name   = strtoupper($map);
    $domain_env = $end_name . $domain_env_append;
    $root_env   = $end_name . $root_env_append;
    $port_env   = $end_name . $port_env_append;

    file_put_contents($nginx_vhost_path . $map . $nginx_vhost_file_ext, str_replace([
        '#listen#',
        '#server_name#',
        '#root#',
        '#error_log#',
    ], [
        80,
        str_replace(['http://', 'https://'], '', getenv($domain_env)),
        getenv($root_env),
        $map,
    ], $nginx_vhost_temp));

    file_put_contents($nginx_vhost_path . $map . '_port' . $nginx_vhost_file_ext, str_replace([
        '#listen#',
        '#root#',
        '#error_log#',
        'server_name #server_name#;'
    ], [
        getenv($port_env),
        getenv($root_env),
        $map . '_port',
        ''
    ], $nginx_vhost_temp));
}
