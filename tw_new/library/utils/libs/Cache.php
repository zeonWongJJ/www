<?php
/**
 * 缓存调用
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */
namespace utils;

use utils\cache\Memcache;
use utils\cache\Memcached;
use utils\cache\Redis;

class Cache
{
    /**
     * @var Cache
     */
    protected static $instance;

    /**
     * @var Memcached|Redis|Memcache
     */
    private $facade;

    /**
     * @param string $type
     * @param array $config
     * @return Cache
     */
    public static function getInstance($type = 'Redis', array $config = [])
    {
        if (!self::$instance) {
            self::$instance = new self($type, $config);
        }

        return self::$instance;
    }

    /**
     * Cache constructor.
     * @param string $type
     * @param array $config
     */
    private function __construct($type = 'Redis', array $config = [])
    {
        $class = __NAMESPACE__ . '\cache\\' . $type;
        if (class_exists($class)) {
            $this->facade = new $class($config);
            $this->facade->connect();
        }
    }

    /**
     * 缓存操作封装
     * @param $key
     * @param string $value
     * @param int $lifetime
     * @param string $group
     * @return bool|mixed
     */
    public function operate($key, $value = '', $lifetime = 3600, $group = 'qidu_')
    {
        if (!$value) {
            if (is_null($value)) {
                // 缓存删除
                $result = $this->facade->delete($key);
            } else {
                // 缓存读取
                $result = $this->facade->get($key);
            }
        } else {
            // 缓存设置
            $result = $this->facade->set($key, $value, $lifetime, $group);
        }

        return $result;
    }
}