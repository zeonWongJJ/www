<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace utils;

class Db
{
    public static $instance;
    public $_db;

    /**
     * Db constructor.
     * @param array $config
     */
    private function __construct(array $config = [])
    {
        include_once  BASEPATH . 'core/Mysql.php';
        $this->_db = new \TW_Mysql('db');
    }

    /**
     * @param array $config
     * @return Db
     */
    public static function getInstance(array $config = []): Db
    {
        if (!self::$instance) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function getDB(): \TW_Mysql
    {
        return $this->_db;
    }
}
