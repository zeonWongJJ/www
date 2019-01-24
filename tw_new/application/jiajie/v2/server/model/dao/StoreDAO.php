<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model\dao;

use model\BaseModel;

class StoreDAO extends BaseModel
{
    /**
     * @remark 获取店铺信息包括店铺钱包
     * @param $store_id
     * @param bool $for_update
     * @return string
     */
    public static function getStoreWithWallet($store_id, $for_update = false): string
    {
        $self = new static();
        $sql = <<<EOF
SELECT * FROM 
  {$self->db->get_prefix(get_table('store'))} AS tb_store
INNER JOIN 
  {$self->db->get_prefix(get_table('staff_wallet'))} AS tb_staff_wallet
ON tb_staff_wallet.store_id = tb_store.id
AND tb_staff_wallet.user_id = tb_store.user_id
WHERE
  tb_store.id = {$store_id}
LIMIT 1
EOF;
        if ($for_update) {
            $sql .= ' FOR UPDATE';
        }

        return $sql;
    }
}
