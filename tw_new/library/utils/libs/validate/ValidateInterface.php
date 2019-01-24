<?php
/**
 * 验证规则类型接口
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */

namespace utils\validate;


interface ValidateInterface
{
    /**
     * 必须对外提供检查方法
     * @param $data
     * @return mixed
     */
    public static function check($data);
}