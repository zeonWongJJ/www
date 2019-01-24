<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 0.1-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace repositories;


use utils\BaseRepository;

class ServiceUtilRepository extends BaseRepository
{
    public function getDbTable()
    {
        return get_table('value_unit');
    }

    /**
     * 写入前执行
     * @param $insert
     * @return array
     */
    public function beforeInsertHook($insert): array
    {
        $total = $this->db->get_total($this->table, ['unit_name' => $insert['unit_name']]);
        if ($total) {
            throw new \RuntimeException('计费单位已存在');
        }

        return $insert;
    }
}
