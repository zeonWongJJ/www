<?php

namespace utils\cache;

abstract class AbstractCache implements CacheInterface
{

    /**
     * 设置配置
     * @var array
     */
    protected $config = [];
    /**
     * 缓存句柄实例化的类名
     * @var string
     */
    protected $accessor;
    /**
     * @var \Memcached|\Redis|\Memcache
     */
    protected $handle;

    /**
     * AbstractCache constructor.
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        $this->accessor = $this->getCacheAccessor();
        if ($this->accessor && class_exists($this->accessor)) {
            $this->handle = new $this->accessor;
        } else {
            throw new \RuntimeException("缓存类{$this->accessor}未定义!");
        }

        $configPath = APPPATH . 'config/config_cache.php';

        if (file_exists($configPath)) {
            $defaultConfig = include $configPath;
        } else {
            $defaultConfig = [
                'redis'    => [
                    getenv('REDIS_HOST') ?: '172.18.0.7:6379'
                ],
                'memcache' => [
                    getenv('MEMCACHE_HOST') ?: '172.18.0.8:11211'
                ]
            ];
        }

        $this->config = array_merge($defaultConfig, $config);

        if (!$this->config || !$this->config[lcfirst($this->accessor)]) {
            throw new \RuntimeException('缓存配置为空!');
        }
    }

    /**
     * 获取当前缓存句柄
     * @return \Memcache|\Memcached|\Redis
     */
    public function getCacheHandle()
    {
        return $this->handle;
    }
}
