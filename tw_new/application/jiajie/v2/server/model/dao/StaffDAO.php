<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model\dao;

use model\BaseModel;

class StaffDAO extends BaseModel
{
    /**
     * @remark 根据店铺查询店员列表
     * @param $store_id
     * @param bool $for_update 是否执行锁表
     * @return string
     */
    public static function selectStaffList($store_id, $for_update = false): string
    {
        $self = new self();
        $sql  = <<<EOF
SELECT * FROM {$self->db->get_prefix(get_table('store_user'))} 
WHERE store_id = {$store_id} AND user_type  <> 3
EOF;
        if ($for_update) {
            $sql .= ' FOR UPDATE';
        }
        return $sql;
    }

    /**
     * @param array $staff
     * @return string
     */
    public static function getUserByStaffID(array $staff): string
    {
        $staff_id = implode(',', $staff);
        $self = new self();
        $sql = <<<EOF
SELECT user_id FROM {$self->db->get_prefix(get_table('store_user'))} 
WHERE id IN ({$staff_id})
EOF;
        return $sql;
    }

    /**
     * @param array $users
     * @return string
     */
    public static function getStaffByUserID(array $users): string
    {
        $staff_id = implode(',', $users);
        $self = new self();
        $sql = <<<EOF
SELECT id FROM {$self->db->get_prefix(get_table('store_user'))} 
WHERE user_id
EOF;
        if (\count($users) > 1) {
            $sql .= " IN ({$staff_id})";
        } else {
            $sql .= " = {$users[0]}";
        }
        return $sql;
    }

    /**
     * @param string $order_sn
     * @param int $order_sub_sn
     * @param bool $is_update
     * @return string
     */
    public static function getOrderAappointed($order_sn, $order_sub_sn = 0, $is_update = false): string
    {
        $self = new self();
        $sql = <<<EOF
SELECT appointed_uid FROM {$self->db->get_prefix(get_table('order_appointed'))} 
WHERE order_sn = {$order_sn} AND `order_sub_id` = {$order_sub_sn}
ORDER BY id ASC
EOF;
        $sql .= $is_update ? ' FOR UPDATE' : '';
        return $sql;
    }
}
