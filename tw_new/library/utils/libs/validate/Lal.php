<?php
/**
 * 验证数据是否经纬度
 * @author rusice <liruizhao970302@outlook.com>
 */
namespace utils\validate;

/**
 * Class Lal
 * @package utils\validate
 */
class Lal implements ValidateInterface
{

    /**
     * 必须对外提供检查方法
     * @param $data
     * @return mixed
     */
    public static function check($data)
    {

        if (!Required::check($data)) {
            return false;
        }

        // 判断是否经额度
        preg_match('/^.*,.*$/', $data, $match);

        return $match;
    }
}