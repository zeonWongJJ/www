<?php
/**
 * 文件夹操作类
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */
namespace utils;

/**
 * Class Dir
 * @package utils
 */
class Dir
{
    /**
     * 移动文件夹到指定路径
     * @param string $source 源文件夹路径
     * @param string $dist 目标路径
     */
    public static function move($source, $dist)
    {
        self::copy($source, $dist);
        self::rm($source);
    }

    /**
     * 查看文件夹大小
     * @param $path
     * @return int
     */
    public static function size($path): int
    {
        $size = 0;
        $handle = opendir($path);
        while (($item = readdir($handle)) !== false) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            $_path = $path . '/' . $item;
            if (is_file($_path)) {
                $size += filesize($_path);
            }
            if (is_dir($_path)) {
                $size += self::size($_path);
            }
        }
        closedir($handle);
        return $size;
    }

    /**
     * 复制文件夹到指定路径
     * @param string $source 源文件夹路径
     * @param string $dist 目标路径
     */
    public static function copy($source, $dist)
    {
        if (!file_exists($dist) && !mkdir($dist, 0755, true) && !is_dir($dist)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $dist));
        }
        $handle = opendir($source);
        while (($item = readdir($handle)) !== false) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            $_source = $source . '/' . $item;
            $_dist = $dist . '/' . $item;
            if (is_file($_source)) {
                copy($_source, $_dist);
            }
            if (is_dir($_source)) {
                self::copy($_source, $_dist);
            }
        }
        closedir($handle);
    }

    /**
     * 删除文件夹
     * @param $path
     * @return bool
     */
    public static function rm($path): bool
    {
        $handle = opendir($path);
        while (($item = readdir($handle)) !== false) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            $_path = $path . '/' . $item;
            if (is_file($_path)) {
                unlink($_path);
            }
            if (is_dir($_path)) {
                self::rm($_path);
            }
        }
        closedir($handle);
        return rmdir($path);
    }
}