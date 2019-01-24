<?php
/**
 * 必填验证
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */

namespace utils\validate;

class Required implements ValidateInterface
{
    /**
     * @param $data
     * @return bool|mixed
     */
    public static function check($data)
    {
        return $data !== null && !empty($data);
    }
}