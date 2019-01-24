<?php
/**
 * 验证长度
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */

namespace utils\validate;


class Length implements ValidateInterface
{
    /**
     * 验证长度
     * @param: string $str
     * @param int $length
     * @param string $charset
     * @return bool
     */
    public static function check($str, $length = 0, $charset = 'utf-8')
    {
        if(!Required::check($str)) {
            return false;
        }

        $len = mb_strlen($str,$charset); // 计算总长

        if (strpos($length, ',')) {
            list($min, $max) = explode(',', $length);

            if ($len < $min) {
                return false;
            }
            if ($len > $max) {
                return false;
            }
        } else {
            return $len <= $length;
        }

        return true;
    }
}