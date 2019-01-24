<?php
/**
 * 支付设置
 * @author rusice <liruizhao970302@outlook.com>
 */

return [
    'alipay'    =>  [
        'app_id' => '2016030501185352',
        'notify_url' => 'http://yansongda.cn/notify.php',
        'return_url' => is_https() ? 'https://' : 'http://' . $_SERVER['SERVER_NAME'] . '/order.pay.return-alipay',
        'ali_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvt7gGQz/qtKZzAsSC+r3L5EMCuAvvdptNBFI/xOrt6/+9Xb2Erv/7xlvO1+KlqPisbxxVRBy0r8JdRANgLI16A/i/Xpxwn9VhyEgo6Eza2oPG34JS8xnlq1iAHFHY+lUl70IRfFz+CP06dxPcZNFDGFeZa4Fh0B2RJpZiilhnuq4boEFJoVn5+Lc8sJ5PIvwgtNh3a5ZmPmtsxc1RjtQ2HE5V7ItdgZFXr3g15/2W7oGm8HdRT8jRaxHKXdSItBlYeFrRJQITBl7EqKBv+J1dStFzGZk+O7SV2RU+MRvKeXXEW2Q1IoNJfl6C+WCCB+vblYeh5mt6NNPgubqtX5mDQIDAQAB",
        // 加密方式： **RSA2**
        'private_key' => "MIIEowIBAAKCAQEAvPU4TRU+gGAavB6Wi6m1z/D0lIwmQZuFz421Bt1HqdgOMSjRl1kzxjxktwip+Us3pTKT7RcJOeQi3jIu16i3gXCNbb4s2rRlMd2jVhlMFMwJ4iybeViUsFT4I126qV59f8k4OfZwdoKDhqSflxJ7QvnVp3gM/SPVn2VqWq4tM4xYWx2bEh8DrBd1prKK2nfla5Ixqq2dNhCQ/olNhp/eDm7WByXEhIbIyXESQ/n+nNoQ6/3go6OwO1s2JFhQIk0/F9n/cERm+y6nhuVN2dFY7RWPPTgJZujL4kOfEyhcuqBKpti5qPeMHZHebBa/S6w7K2u9Sg8wOOBH5P29Bub7SQIDAQABAoIBAE092KP5+TC1GHip8FRrLX0xPGm02LadApgTj1qc/fx562NBElxSBI4Whf0kN4dGrhqDkGCsuALINVCrJubVex4YilfAE8nbUDqQJYK+mJEvzyJ7pZp3EWD7euvKFtHBZH/mG2vmR5bKR0W06d/xmB2Kz0HEG1snWN3tsQochTG6isx2SFk2d8OzbCqIvjaDjaT5FCd/p20UmTT1ZlJcH3GJYzOy8t+vg9g/nJXb1r7bf2TcZeS0wcaH++DGwwD5T6qNx4zjV12JH1yO0iwUJGX4NJidDAXmz4zQ2jgspzZhGpqWWmqbcj4M2RNyesnb8rO+hVN151aWUaYFtyZzlZkCgYEA7fRXZEbk0oszmQRNZp/efhD9Jlsl+0wal97ETcckADjkSBfqGmUqjjKIYUH3YLZxbyRuTqxSnRz8xseqmC9AUKtyZmX3Nav6/aMH5Sz5lhmHYR1ZzEczW9xK0gcTy0BmCIgG9eWr3byqbeavCoKNhsNzY1VfgPneXvE/llMUoZMCgYEAy0moLpSn5v4w8LOzlmikLmCJwe+Itoc/x4ihDpS1NAffjkmIsq2uQqgnHwAOiWL50ghtd8XK1IQLgX3ejQIWnWQ67thQ76IuBGL5dS9Gy4CCenyU+la+ATyldua/PaThtG4MBsJNmnMu9qmlHArbWZwdMDda3A7jQLC0kKfU6TMCgYEA4SyEenb/2CEz/Yvttrx4LjHjbKV6ZrhYvfhnKPbWoYM0uugudzXetFsrZWWoM5PR+guuerJlJxokNfMCAytLoErtYesBqX+KbvQU55DMynZz/rlonX+PIVFwWBmsaH0TUOVwOMdTAOylFoTihX6PcMSJ76j9TC6neI6wzo7mChMCgYA8qdVTWS8lonMuUSHlX4KnCE3znqx4c7HXtHEDbeMJDNRsnIr7bxLSd2V9PcIYw31zbOpl1JNriZ/5W3tfLuFaxH9FqS215PrAelyg2KPStJ27OZQnhF0c92EVM1Sca6ii9DgIiFEqJvc7ynIoBSFiA1E+gzZM9vBf7Jtlk3/YuwKBgE3ivTqzhKo4+Y+7lV30pAoV0azQs6CHBCuTPYzrsTIbewTo+JG0fm3Z3/VguJrKgkGYpFfA+S1QlnDqxrNkg9AVK9hQzCb7gaf/2jH9Xrtc7JmrYNnQp0OS3d9ABq4hl8xry/7FeB8ZGcYXb2H9i++GF1FCyDb2r01YIJ8vRZV1",
        'log' => [ // optional
            'file' => './logs/alipay.log',
            'level' => 'debug'
        ],
        // 'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
    ],

    'wechat'    =>  [
        'appid' => 'wxeabc8436ab550bc3', // APP APPID
        'app_id' => 'wxeabc8436ab550bc3', // 公众号 APPID
        'miniapp_id' => 'wxeabc8436ab550bc3', // 小程序 APPID
        'mch_id' => '1488729882',
        'key' => 'QvTcQYHYtfFBaywpv3h4XjRJTS82NqRP',
        'notify_url' => is_https() ? 'https://' : 'http://' . $_SERVER['SERVER_NAME'] . '/order.pay.return',
        'return_url' => is_https() ? 'https://' : 'http://' . $_SERVER['SERVER_NAME'] . '/order.pay.return',
        'cert_client' => __DIR__ . '/wechat_pay_cert/apiclient_cert.pem', // optional，退款等情况时用到
        'cert_key' => __DIR__ . '/wechat_pay_cert/apiclient_key.pem',// optional，退款等情况时用到
//        'log' => [ // optional
//            'file' => './logs/wechat.log',
//            'level' => 'debug'
//        ],
//        'mode' => 'dev', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
    ]
];