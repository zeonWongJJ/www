<?php
define('BASEPATH', '/tw/');
include BASEPATH . '/libraries/Phpqrcode.php';

$tw_phpqrcode = new \TW_phpqrcode();
$touch_domain = getenv('PC_DOMAIN') ?: 'http://jiajie-touch.7dugo.com';
$tw_phpqrcode->qrcode([
    // 要生成二维码的数据，必填
    'data'      => $touch_domain . '/qr.php',
    // 二维码图片大小，选填，默认4
    'size'      => 10,
    // 二维码错误修正级别L/M/Q/H，选填，默认“L”。L水平 7% 的字码可被修正，M水平 15% 的字码可被修正，Q水平 25% 的字码可被修正，H水平 30% 的字码可被修正
    'level'     => 'L'
]);
