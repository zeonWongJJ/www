<?php
$a_system_config = [
    // URL域名设置
    'domain' => 'http://jiajie-server.7dugo.com',
    // 扩展类前缀
    'subclass_prefix' => 'MY_',
    // 代理IP，如'10.0.1.200,10.0.1.201'
    'proxy_ips' => '',
    // 是否全站静态化
    'is_html' => false,
    // 默认初始化的数据库
    'init_db' => 'db',

    //===COOKIE设置========================================
    // COOKIE前缀
    'cookie_prefix' => '',
    // 规定COOKIE域名
    'cookie_domain' => '',
    // COOKIE的服务器路径
    'cookie_path' => '/',
    // 是否通过安全HTTPS连接
    'cookie_secure' => false,

    //===短信设置==========================================
    // 短信前缀
    'short_message_prefix' => '【7度购】',

    //===邮件设置==========================================
    // SMTP 服务器
    'email_smtp_host' => 'smtp.qq.com',
    // 设置ssl连接smtp服务器的远程服务器端口号
    'email_smtp_port' => 465,
    // 设置邮件发件人姓名（昵称）
    'email_from_name' => '7度服务中心',
    // smtp登录的账号
    'email_username' => '',
    // smtp登录的密码
    'email_password' => '',
    // 设置发件人邮箱地址
    'email_from' => '',
];