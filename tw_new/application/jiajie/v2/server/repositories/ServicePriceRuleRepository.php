<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace repositories;


use utils\BaseRepository;

class ServicePriceRuleRepository extends BaseRepository
{
    /**
     * @return String
     */
    public function getDbTable()
    {
        return get_table('service_price_change_rule');
    }

    public function afterInsertHook($insert)
    {
        return $insert;
    }
}
