<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace repositories;

use utils\BaseRepository;

class ServiceFlowRepository extends BaseRepository
{
    public function getDbTable()
    {
        return get_table('service_flow');
    }

    /**
     * 添加前执行
     * @param $insert
     * @return mixed
     */
    public function beforeInsertHook($insert)
    {
        $insert['flow_at'] = $_SERVER['REQUEST_TIME'];

        return $insert;
    }
}
