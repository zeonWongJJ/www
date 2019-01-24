<?php
/**
 * UTF-8检测
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */

namespace utils\validate;


class Utf8 implements ValidateInterface
{
    /**
     * @param $data
     * @return bool|mixed
     */
    public static function check($data)
    {
        if(!Required::check($data)) {
            return false;
        }
        return (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/", $data)
            == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$data)
            == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$data)
            == true);
    }
}