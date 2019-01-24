<?php
/**
 * 数据仓库
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace repositories;

use model\UserModel;
use utils\BaseRepository;
use utils\Factory;
use utils\ide\Db;

/**
 * Class StoreRepository
 * @package repositories
 */
class StoreRepository extends BaseRepository
{

    /**
     * 指定查询数据表名，不需要带前缀
     * @return String
     */
    public function getDbTable()
    {
        return get_table('store');
    }

    /**
     * 自定义列表查询方法
     * 当需要join等非单表查询时可以调用此方法
     * @param array $build_query 查询构建数组，前端传入的排序、字段等
     * @param string $data_set 返回数据集类型
     */
    //    public function customizeListGetter(array $build_query, $data_set)
    //    {
    //
    //    }


    /**
     * 自定义单条查询方法
     * 当需要join等非单表查询时可以调用此方法
     * @param int $id 单条获取的id
     * @param array $build_query 查询构建数组，前端传入的排序、字段等
     * @param string $cache_key cache的key
     */
    //    public function customizeGetter($id, $build_query, $cache_key)
    //    {
    //
    //    }


    /**
     * 查询列表前操作
     * @param Db $query
     * @return Db
     */
    //    public function beforeGetList($query)
    //    {
    //
    //    }

    /**
     * 查询一条数据后调用
     * @param array $row
     * @return array
     */
    public function afterGetOne(array $row)
    {
        $row['store_zizhi_pic'] = explode(',', $row['store_id_card_opposite']);
        $row['store_pic']       = explode(',', $row['store_pic']);
        return $row;
    }

    /**
     * 新增前调用
     * @router http:://server.name/user.store.add
     * @param array $insert 新增的数据
     * @return array
     */
    public function beforeInsertHook(array $insert): array
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }
        $map['user_id'] = $insert['user_id'] = $user_info->user_id;
        if (0 < $this->db->get_total($this->table, $map)) {
            throw new \RuntimeException('您已申请过店铺了，请不要重复提交!');
        }
        $insert['store_status'] = 0; // 审核中
        if (\is_array($insert['store_pic'])) {
            $insert['store_pic'] = implode(',', $insert['store_pic']);
        } else {
            $insert['store_pic'] = trim($insert['store_pic'], ',');
        }

        if ($insert['store_parent_id'] != 0) {
            if (!$parent_store_info = $this->db->get_row(get_table('store'), ['id' => $insert['store_parent_id']])) {
                throw new \RuntimeException('所属上级店铺不存在');
            }
            $insert['store_name']    = $parent_store_info['store_name'];
            $insert['store_range']   = $parent_store_info['store_range'];
            $insert['store_region']  = $parent_store_info['store_region'];
            $insert['store_address'] = $parent_store_info['store_address'];
            $insert['store_info']    = $parent_store_info['store_info'];
        }
        $insert['store_wallet'] = 0; // 初始店铺钱包金额为0
        $insert['store_add_at'] = $_SERVER['REQUEST_TIME'];
        return $insert;
    }

    /**
     * 新增后调用
     * @param array $insert 新增的数据
     */
    public function afterInsertHook(array $insert)
    {

        $user_type = $insert['store_parent_id'] == 0 ? 3 : 1; // 无上级店铺时，会员类型为店主，否则为店员

        $store_id = $insert['store_parent_id'] == 0 ? $insert['id'] : $insert['store_parent_id'];
        $this->db->insert(get_table('store_user'), [
            'store_id'             => $store_id
            , 'user_id'            => $insert['user_id']
            , 'user_type'          => $user_type
            , 'store_user_lat'     => app('request')->post('store_user_lat', '', 'trim') // 店员的经度
            , 'store_user_lng'     => app('request')->post('store_user_lng', '', 'trim') // 店员的纬度
            , 'store_address_info' => app('request')->post('store_user_address_info', '', 'trim') // 店员的详细地址信息
        ]);
    }

    /**
     * 更新前调用
     * @param array $update 传入的更新数据
     * @param int $id 要更新的id
     * @return array
     */
    public function beforeUpdateHook(array $update, $id): array
    {
        if (\is_array($update['store_pic'])) {
            $update['store_pic'] = implode(',', $update['store_pic']);
        } else {
            $update['store_pic'] = trim($update['store_pic'], ',');
        }
        $update['store_update_at'] = $_SERVER['REQUEST_TIME'];
        return $update;
    }

    /**
     * 更新后调用
     * @param int $id 要更新的id
     */
    public function afterUpdateHook($id)
    {
        $this->db->update($this->table, [
            'store_status' => 0
        ], ['id' => $id]);
    }

    /**
     * 删除前调用
     * @param int $id 删除的id
     */
    //    public function beforeDeleteHook($id)
    //    {
    //
    //    }

    /**
     * 删除后调用
     * @param int $id 要删除的id
     * @param $row
     */
    public function afterDeleteHook($id, $row)
    {
        $this->db->delete(get_table('store_user'), ['user_id' => $row['user_id']]);
    }
}
