<?php
/**
 * 预约仓库
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace repositories;

use model\SubscribeModel;
use utils\BaseRepository;
use utils\Factory;

class SubscribeRepository extends BaseRepository
{
    /**
     * @return String
     */
    public function getDbTable()
    {
        return get_table('subscribe');
    }

    public function beforeInsertHook($insert)
    {
        $user_id             = 0;
        $data['verify_code'] = false;
        $token               = $_SERVER['HTTP_X_TOKEN'] ?? '';

        if ($token) {
            /** @var \model\TokenModel $token_model */
            $token_model = \utils\Factory::getFactory('token');
            $user_info   = $token_model->parseToken($token);

            $user_row                  = $this->db->get_row('user', ['user_id' => $user_info['user_id']], 'user_phone, user_id');
            $insert['subscribe_phone'] = $user_row['user_phone'];
            $user_id                   = $user_row['user_id'];
        } else {
            $insert['subscribe_phone'] = app('request')->post('subscribe_phone', '', 'trim');
            $data['verify_code']       = app('request')->post('verify_code', '', 'trim');
        }

        /** @var \model\MessageModel $message_model */
        $message_model = \utils\Factory::getFactory('message');
        $message_model->checkVerifyCode($insert['subscribe_phone'], $data['verify_code']);

        $has_cate = $this->db->get_total(get_table('category'), [
            'id' => $insert['cate_id'],
        ]);

        if (!$has_cate) {
            throw new \RuntimeException('预约的分类不存在');
        }

        $insert['sub_at']          = $_SERVER['REQUEST_TIME'];
        $insert['belong_order_sn'] = '';
        $insert['subscribe_state'] = 'PENDING';
        $insert['user_id']         = $user_id;

        return $insert;
    }

    /**
     * 查询后操作
     * @param $rows
     * @return array
     */
    public function afterGetList($rows): array
    {
        /** @var SubscribeModel $subscribe_model */
        $subscribe_model = Factory::getFactory('subscribe');
        return $subscribe_model->formatRows($rows);
    }
}
