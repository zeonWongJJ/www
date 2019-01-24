<?php
/**
 * 缓存实现接口
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */
namespace utils\cache;

interface CacheInterface
{
    /**
     * 缓存必须实现获取方法
     * @param string $key 缓存记录key
     * @param mixed $default 默认值
     * @return mixed
     */
    public function get($key, $default = false);

    /**
     * 缓存必须实现设置方法
     * @param string $key 缓存记录key
     * @param mixed $value 缓存设置值
     * @param int $lifetime 缓存有效时间
     * @param string $group 缓存所属组,默认为qidu_前缀
     * @return mixed
     */
    public function set($key, $value, $lifetime = 3600, $group = 'qidu_');

    /**
     * 缓存必须实现连接方法
     * @return mixed
     */
    public function connect();

    /**
     * 缓存必须实现清空方法
     * @return mixed
     */
    public function flush();

    /**
     * 缓存必须实现删除方法
     * @param string $key 缓存记录key
     * @return mixed
     */
    public function delete($key);

    /**
     * 获取缓存调用类名
     * @return mixed
     */
    public function getCacheAccessor();

    /**
     * 必须实现缓存自动初始化方法
     * @return mixed
     */
    public function init();
}