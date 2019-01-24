<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace repositories;

use utils\BaseRepository;

class ServiceEquipmentRepository extends BaseRepository
{

    /**
     * @return String
     */
    public function getDbTable()
    {
        return get_table('service_equipment');
    }

    /**
     * @param array $insert
     * @return array
     */
    public function beforeInsertHook($insert): array
    {
        $insert['equipment_add_at'] = $_SERVER['REQUEST_TIME'];
        $insert['equipment_thumb']  = $insert['equipment_img'];

        return $insert;
    }
}
