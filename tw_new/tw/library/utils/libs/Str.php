<?php
/**
 * 字符串处理类
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace utils;

class Str
{
    // 纯数字验证码
    const DIGITAL = 1;
    // 纯字母验证码
    const LETTER = 2;
    // 混杂验证码 数字+字母
    const MIXED = 3;

    /**
     * 生成指定长度的字符串
     * @param int $length
     * @return string
     */
    public static function random($length = 16)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = static::randomBytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

    /**
     * 快速获取随机字符串
     * @param int $length
     * @param int $type
     * @return bool|string
     */
    public static function quickRandom($length = 16, $type = self::MIXED)
    {
        if ($type === self::DIGITAL) {
            $pool = '0123456789';
        } else if ($type === self::LETTER) {
            $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } else {
            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
}