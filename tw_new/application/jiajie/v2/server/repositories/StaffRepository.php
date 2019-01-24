<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace repositories;

use model\user\login\adapter\MsnAdapter;
use utils\BaseRepository;

class StaffRepository extends BaseRepository
{
    public function getDbTable()
    {
        return get_table('store_user');
    }

    /**
     * 写入前调用
     * @param $insert
     * @return array
     */
    public function beforeInsertHook($insert): array
    {
        $user_info = $this->db->get_row('user', [
            'user_phone' => $insert['staff_tel']
        ], 'user_id');
        if (!$user_info) {
            $user_info['user_id'] = MsnAdapter::fastInsertUser($insert['staff_tel']);
        }
        return [
            'user_type'            => 1,
            'user_type_key'        => 'SERVER',
            'store_id'             => $insert['store_id'],
            'staff_tel'            => $insert['staff_tel'],
            'user_id'              => $user_info['user_id'],
            'staff_name'           => $insert['staff_name'],
            'store_user_lat'       => $insert['store_user_lat'],
            'store_user_lng'       => $insert['store_user_lng'],
            'staff_id_card_number' => $insert['staff_id_card_number'],
            'staff_add_at'         => $_SERVER['REQUEST_TIME'],
        ];
    }

    /**
     * 写入后调用
     * @param $insert
     */
    public function afterInsertHook($insert): void
    {
        $this->db->insert(get_table('store_staff_info'), [
            'staff_id_card_pic_zm' => app('request')->post('staff_id_card_pic_zm', '', 'trim'), // 店员身份证正面
            'staff_id_card_pic_bm' => app('request')->post('staff_id_card_pic_bm', '', 'trim'), // 店员身份证背面
            'staff_cert_pic_zm'    => app('request')->post('staff_cert_pic_zm', '', 'trim'),    // 店员资质证正面
            'staff_cert_pic_bm'    => app('request')->post('staff_cert_pic_bm', '', 'trim'),    // 店员资质证背面
            'staff_address_info'   => app('request')->post('staff_address_info', '', 'trim'),   // 店员位置信息描述
            'staff_id'             => $insert['id']
        ]);
        $this->db->insert(get_table('staff_wallet'), [
            'total_income' => 0,
            'balance'      => 0,
            'locked'       => 0,
            'staff_id'     => $insert['id'],
            'store_id'     => $insert['store_id'],
            'user_id'      => $insert['user_id']
        ]);
    }
}
