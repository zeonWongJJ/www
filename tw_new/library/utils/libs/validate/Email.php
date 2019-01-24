<?php
/**
 * 邮件格式验证
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */
namespace utils\validate;

class Email implements ValidateInterface
{
    public static function check($data)
    {
        if (!Required::check($data)) return false;
        return preg_match("/([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?/i", $data) ? true : false;
    }
}