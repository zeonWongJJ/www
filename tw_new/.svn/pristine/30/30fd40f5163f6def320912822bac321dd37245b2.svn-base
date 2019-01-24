<?php
/**
 * Redis缓存服务实现
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */
namespace utils\cache;

class Redis extends AbstractCache
{
    /**
     * @var \Redis
     */
    protected $handle;

    public function getCacheAccessor()
    {
        return 'Redis';
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
        list($host, $port) = explode(':', $this->config['redis'][0]);
        $this->handle->connect($host, $port);
    }

    /**
     * redis缓存删除具体实现
     *
     * @param string $key
     * @param string $group
     * @return mixed
     */
    public function delete($key, $group = 'qidu_')
    {
        return $this->handle->delete($this->handle->keys($group . $key));
    }

    /**
     * redis缓存清空具体实现
     *
     * @return mixed
     */
    public function flush()
    {
        return $this->delete('*');
    }

    /**
     * redis缓存获取具体实现
     *
     * @param string $key
     * @param string $group
     * @param bool $default
     * @return bool|mixed
     */
    public function get($key, $group = 'qidu_', $default = false)
    {
        $result = $this->handle->get($group . $key);
        return $result ?: $default;
    }

    /**
     * redis缓存设置具体实现
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
