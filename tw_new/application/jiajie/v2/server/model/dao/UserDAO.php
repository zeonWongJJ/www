<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model\dao;

use model\BaseModel;

class UserDAO extends BaseModel
{
    /**
     * 上锁用户钱包
     * @param $user_id
     * @return bool|mixed
     */
    public static function lockUserWallet($user_id)
    {
        $_this = new self();
        $sql = <<<EOF
SELECT user_balance, user_score, user_id FROM {$_this->db->get_prefix('user')} WHERE user_id
EOF;
        if (\is_array($user_id)) {
            $user_id = implode(',', $user_id);
            $sql .= " IN ({$user_id}) ";
        } else {
            $sql .= " = {$user_id} ";
        }
        $sql .= ' FOR UPDATE';
        /** @var \PDOStatement $pdo_state */
        $pdo_state = $_this->db->query($sql);
        $users = $pdo_state ? $pdo_state->fetchAll(\PDO::FETCH_ASSOC) : [];
        $result = [];
        foreach ($users as $user) {
            $result[$user['user_id']] = $user;
        }

        return $result;
    }
}
