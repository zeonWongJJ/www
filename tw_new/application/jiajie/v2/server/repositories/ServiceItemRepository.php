<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 0.1-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace repositories;

use model\ServiceModel;
use utils\BaseRepository;
use utils\Factory;

class ServiceItemRepository extends BaseRepository
{
    /**
     * 指定查询数据表名，不需要带前缀
     * @return String
     */
    public function getDbTable()
    {
        return get_table('service_items');
    }

    /**
     * 新增前操作
     * @param array $insert
     * @return array
     */
    public function beforeInsertHook(array $insert): array
    {
        $has_one = $this->db->get_total(get_table('service'), ['id' => $insert['service_id']]);
        if (!$has_one) {
            throw new \RuntimeException('所属服务不存在');
        }
        $insert['item_change'] = 100 * $insert['item_change']; // 单位分
        $insert['item_add_at'] = $_SERVER['REQUEST_TIME'];

        return $insert;
    }

    /**
     * 插入后操作
     * @param array $insert
     * @return array
     */
    public function afterInsertHook(array $insert): array
    {
        /** @var ServiceModel $service_model */
        $service_model = Factory::getFactory('service');
        $service_model->padItemSN($insert['id']);

        return $insert;
    }
}
