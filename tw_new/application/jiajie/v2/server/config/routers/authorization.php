<?php
/**
 * 用户授权接口定义
 */

return [
    'alipay.system.oauth.token' => [
        'class'  => 'Oauth',
        'method' => 'alipayToken',
    ],
    'alipay.get.signtrue'       => [
        'class'  => 'Oauth',
        'method' => 'getAlipaySign',
    ],
];
