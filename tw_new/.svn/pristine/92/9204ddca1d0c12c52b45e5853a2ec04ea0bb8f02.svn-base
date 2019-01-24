<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

use utils\Db;

class BaseModel extends \utils\BaseModel
{
    public function __construct(array $param = [])
    {
        parent::__construct($param);
        $this->db = Db::getInstance()->getDB();
    }
}
