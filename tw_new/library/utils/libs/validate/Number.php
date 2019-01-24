<?php
/**
 * 是否数字验证
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */
namespace utils\validate;

class Number implements ValidateInterface
{
    /**
     * @param $data
     * @param string $flag
     * @return bool|mixed
     */
    public static function check($data, $flag = 'float')
    {
        if (!Required::check($data)) {
            return false;
        }
        if (strtolower($flag) === 'int') {
            return (string)(int)$data === (string)$data;
        }
        return (string)(float)$data === (string)$data;
    }
}