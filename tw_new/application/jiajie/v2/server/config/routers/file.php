<?php
/**
 * 文件资源操作路由定义
 *
 * @author rusice <liruzihao970302@outlook.com>
 * @version 1.0.0-dev
 *
 */

return [
    // 移除文件
    'file.remove'   => [
        'class'  => 'File',
        'method' => 'removeFile'
    ],
    'get.thumb.img' => [
        'class'  => 'File',
        'method' => 'getThumbImg'
    ]
];
