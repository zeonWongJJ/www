<?php
/**
 * 服务端初始化处理
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

foreach ($mkdir_dir as $dir) {
    is_dir($dir) ||  mkdir($dir, 0777, true);
    chmod($dir, 0777, true);
}
