<?php
/**
 * Created by PhpStorm.
 * User: rusice
 * Date: 2018/7/4
 * Time: 14:49
 */

namespace utils\validate;

class Max implements ValidateInterface
{
    public static function check($data, $length = 2)
    {
        return mb_strlen($data) <= $length;
    }
}