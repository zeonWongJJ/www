<?php
/**
 * Memcached缓存服务实现
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */
namespace utils\cache;

class Memcached extends AbstractCache
{
    /**
     * @var \Memcached
     */
    protected $handle;

    public function getCacheAccessor()
    {
        return 'Memcached';
    }

    /**
     * 缓存初始化
     * @return mixed|void
     */
    public function init()
    {

    }

    /**
     * 缓存服务连接方法
     *
     * @return mixed|void
     */
    public function connect()
    {
        list($host, $port) = explode(':', $this->config['memcache'][0]);
        $this->handle->addServer($host, $port);
    }

    /**
     * Memcache缓存删除具体实现
     *
     * @param string $key
     * @return mixed
     */
    public function delete($key)
    {
        $this->handle->delete($key);
    }

    /**
     * Memcache缓存清空具体实现
     *
     * @return mixed
     */
    public function flush()
    {
        return $this->handle->flush();
    }

    /**
     * Memcache缓存获取具体实现
     *
     * @param string $key
     * @param bool $default
     * @return bool|mixed
     */
    public function get($key, $default = false)
    {
        $result = $this->handle->get($key);
        return $result ?: $default;
    }

    /**
     * Memcache缓存设置具体实现
     *
     * @param string $key
     * @param mixed $value
     * @param int $lifetime
     * @param string $group
     * @return bool|mixed
     */
    public function set($key, $value, $lifetime = 3600, $group = 'qidu_')
    {
        return $this->handle->set($group . $key, $value, $lifetime);
    }
}