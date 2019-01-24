<?php
$a_config_alipayf2f = array (
	//签名方式,默认为RSA2(RSA2048)
	'sign_type' => "RSA2",

	//支付宝公钥，公钥查看地址（不是在应用那里设置的）：https://openhome.alipay.com/platform/keyManage.htm
	'key_public' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvt7gGQz/qtKZzAsSC+r3L5EMCuAvvdptNBFI/xOrt6/+9Xb2Erv/7xlvO1+KlqPisbxxVRBy0r8JdRANgLI16A/i/Xpxwn9VhyEgo6Eza2oPG34JS8xnlq1iAHFHY+lUl70IRfFz+CP06dxPcZNFDGFeZa4Fh0B2RJpZiilhnuq4boEFJoVn5+Lc8sJ5PIvwgtNh3a5ZmPmtsxc1RjtQ2HE5V7ItdgZFXr3g15/2W7oGm8HdRT8jRaxHKXdSItBlYeFrRJQITBl7EqKBv+J1dStFzGZk+O7SV2RU+MRvKeXXEW2Q1IoNJfl6C+WCCB+vblYeh5mt6NNPgubqtX5mDQIDAQAB",

	//商户私钥
	'key_private' => "MIIEowIBAAKCAQEAq1K0Rxw6/T6G2onJkzMPVNE7nDsKXFQx6XwBcuE+SQxY8sV1ymhyl4/1l9jy4arZlUxOV6Uh+vtsC6R7Jawr9ODaO5CW3RSlYZNfbXByEQp26lgVIXtFGRfjAlwdg8utCVKF7ST2kbUu6Jda0bIxrT/XUcTJ6BfmlE56VcxiJiduZUC29/HLKOO1kpyLalVm7bWwdPyaQK2Wu4WAbrRx+0qZzLxuLcd96pV9hDVkpaoskFjrzLB8sebzTw+0P+ZcdAmDXb+4Lfnv9/XhKs8db3OOTRFkGZI56SnVOGPDShjqriUXAiCcnXGnS9F4uOWGHEr4QXXqM49eRByWOzGWDQIDAQABAoIBAAVlRWg362OuZHDdhgusv/7b2BTDh0ABJtFDpogHr/589RAwR9VoFLPRRNrTalLRHqklDhKUkM1mvbBgLcCx+3Bq5HSbySSNUegQzCCWOgFvYu9edsvnJfX0WqHoZMWR1JFGmBEv6NQN8LxCiAmyov3h1NYubG1y00A4eIHbPfwVlJe9NwfXg9HggtQS9IAdxKauPeZ4eh7jgDRR3sRxXMFFU2UN6PyEKVSxifROan4Cr+1M1rq4ANH5n8X3zQI67SJ8oI60lD+1MpOeaHuDcZ1aVady4LBUbzp3bdZfFObFEXUBlMB6pWAyHHV62NOIaLUnaNWHMnnTyY55NhpR6cECgYEA46fgK3WGJfZoig149C6UhZlopspFqi5eJd+5Ao4HGZPuMB+0aQt0pvlKWaTEDv9NKTZ5BpVnJEOmT6aAofoGb5g8AB43ggLHbb1OsrEailWeORxP7Q8Ne2UbdC3WiyUMPAkZvHXH6v3VRz1OCYExkysZ0OrzGw0P97mzCGhB2BMCgYEAwKdSzlrpNOaIelTLNZy2Xcz/EwE9z2fwTCrr3Fm3Hoba14Ut9+8UmFMrjk+FVBvMZpPTfRW1D8BOUFw1Zly0WFedgdezgQxCGfEaxBEIR5db59JtG1s/V3VWxoX49+pDOktdfgN9rE9NaQmjZX7913YjgwEse6yqo8eWoTse3V8CgYBADvfkIrC5s+lcl0fmpcjDAxTQgfAyX9O8IoTDtEVJLDgEsJcqS7/qUBFcwiEs+yeyJhLOCHI6YRLGLNrbOShgdFzFx7rkyXVmarNfUrheHpNkDJRs5yRrCVs9SLyq8KTNq93jCt1TQVOnNRflUsYpXCJqiAIaJYXNtiIrhnKoowKBgQCD4geNvC5pSGelVubFjMJK9Eqpd/AYS870VW2hKslw3GBzqXgOglxW6pimk0lyipUio4/j0Thh0APMf1MO/+d1koUAnekELqARojvwfLhuSe9gg2ytjYmPFYSR4qTNElFzVqRp33nou2ECxtZUZNrg5L7qr6MEBu/JrpgvR4mZgQKBgAQQkCmlmh0qCCNoCHYx99xscfcK/BtHxg0VZmj0IqD8HujoKI72hqYkeHBHxKPR6L1dsIte89tLUkyjMGePr+FMAjwZSjT2xC5y8tOTysz4IszxoRdyGf896Pq53tgkziUaxPtTrR8pzOhUWCXVOHY2zOSZli0SF91tK1p1oUUb",

	//编码格式
	'charset' => "UTF-8",

	//支付宝网关
	'gateway_url' => "https://openapi.alipay.com/gateway.do",

	//应用ID
	'app_id' => "2017111109866376",

	//异步通知地址,只有扫码支付预下单可用
	'notify_url' => "",

	//最大查询重试次数
	'max_query_retry' => "10",

	//查询间隔
	'query_duration' => "3",
	
	// 调用的接口版本，固定为：1.0
	'version' => '1.0',
	// 请求使用的编码格式，如utf-8,gbk,gb2312等
	'charset' => 'utf-8',
	// 仅支持JSON
	'format' => 'json',
);