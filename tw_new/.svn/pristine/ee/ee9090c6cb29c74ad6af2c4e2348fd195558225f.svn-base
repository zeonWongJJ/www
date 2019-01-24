<?php
/**
 * JSON格式验证
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */

namespace utils\validate;

class Json implements ValidateInterface
{
    public static function check($data)
    {
        $data = json_decode($data, true);
        return json_last_error() === JSON_ERROR_NONE;
    }
}