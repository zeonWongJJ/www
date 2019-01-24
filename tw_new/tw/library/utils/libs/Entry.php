<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 0.1-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace utils;

class Entry
{
    final public function getEntry()
    {
        $static = (array)$this;
        foreach ($static as $prop => $val) {
            if (null === $val) {
                unset($static[$prop]);
            }
        }

        return $static;
    }
}
