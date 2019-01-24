<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 0.1-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace repositories;


use utils\BaseRepository;

class ServiceStandardsRepository extends BaseRepository
{
    /**
     * @return String
     */
    public function getDbTable()
    {
        return get_table('service_standards');
    }

    /**
     * 写入前调用
     * @param $insert
     * @return mixed
     */
    public function beforeInsertHook($insert)
    {
        $insert['standards_add_at'] = $_SERVER['REQUEST_TIME'];
        return $insert;
    }
}
