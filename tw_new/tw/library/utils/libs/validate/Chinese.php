<?php
/**
 * 纯中文检测
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */

namespace utils\validate;

class Chinese implements ValidateInterface
{
    public static function check($data, $charset = 'utf-8')
    {
        if(!Required::check($data)) return false;
        $match = (strtolower($charset) === 'gb2312') ? "/^[".chr(0xa1)."-".chr(0xff)."]+$/"
            : "/^[x{4e00}-x{9fa5}]+$/u";
        return preg_match($match, $data);
    }
}