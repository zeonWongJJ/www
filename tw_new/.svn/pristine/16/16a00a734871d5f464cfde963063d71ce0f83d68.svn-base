<?php
/**
 * 基础model
 *
 * @copyright 柒度信息科技
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace utils;

use utils\ide\Db;
use utils\traits\BaseTrait;

/**
 * Class BaseModel
 * @package utils
 */
class BaseModel extends \TW_Model
{

    use BaseTrait;

    /** @var string */
    public $pk = 'id';

    /** @var Db */
    public $db;

    /** @var Request */
    protected $request;

    /** @var response */
    protected $response;

    protected $isRPC;

    /**
     * 指定查询的表名
     * @var string
     */
    private $table_name = '';

    /**
     * 指定查询表的前缀
     * @var mixed|string
     */
    private $table_prefix = '';

    /**
     * BaseModel constructor.
     * @param array $param
     */
    public function __construct(array $param = [])
    {
        parent::__construct();

        $this->response = app('response');
        $this->request  = app('request');

        $this->db = app('db');

        if (isset($param['table_prefix'])) {
            $this->setPrefix($param['table_prefix']);
        }
        $this->setSource();
    }

    /**
     * 设置表前缀
     * @param string $prefix
     * @return string
     */
    public function setPrefix($prefix = '')
    {
        $this->table_prefix = $prefix;
    }

    /**
     * 设置表名
     * @param string $table_name
     * @return string
     */
    public function setSource($table_name = '')
    {
        if (!$table_name) {
            $className        = str_replace(__NAMESPACE__, '', lcfirst(static::class));
            $this->table_name = str_replace('_model', '', $className);
        } else {
            $this->table_name = $table_name;
        }

        $this->table_name = $this->table_prefix . $this->table_name;
    }

    public function getPk()
    {
        return $this->pk;
    }
}