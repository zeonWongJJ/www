<?php
/**
 * 匹配时间
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */

namespace utils\validate;


class Time implements ValidateInterface
{
    /**
     * 匹配时间
     * @param string $str
     * @return bool
     */
    public static function check($str)
    {
        $timeArr = explode(":", $str);
        if (is_numeric($timeArr[0]) && is_numeric($timeArr[1]) && is_numeric($timeArr[2])) {
            if (($timeArr[0] >= 0 && $timeArr[0] <= 23) && ($timeArr[1] >= 0 && $timeArr[1] <= 59) && ($timeArr[2] >= 0 && $timeArr[2] <= 59)) {
                return true;
            }
        }
        return false;
    }
}