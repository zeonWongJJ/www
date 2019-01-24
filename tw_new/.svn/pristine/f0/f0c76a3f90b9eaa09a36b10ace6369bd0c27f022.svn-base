<?php
/**
 * 数据仓库
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */
namespace repositories;

use utils\BaseRepository;
use utils\ide\Db;

/**
 * Class AddressRepository
 * @package repositories
 */
class AddressRepository extends BaseRepository
{
    /**
     * 指定查询数据表名，不需要带前缀
     * @return String
     */
    public function getDbTable()
    {
        return 'jiajie_user_address';
    }

    /**
     * @param Db $query
     * @return Db
     */
    public function beforeGetList($query)
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        $this->condition['user_id'] = $user_info->user_id;
//        $map['user_id'] = $user_info->user_id;
//        $query = $query->where($map);

//        return $query;
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
     * 新增前调用
     * @param array $insert 新增的数据
     * @return array
     */
    public function beforeInsertHook(array $insert) :array
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        $insert['user_id'] = $user_info->user_id;
        return $insert;
    }

    /**
     * 新增后调用
     * @param array $insert 新增的数据
     */
//    public function afterInsertHook(array $insert)
//    {
//
//    }

    /**
     * 更新前调用
     * @param array $update 传入的更新数据
     * @param int $id 要更新的id
     * @param array $row
     * @return array
     */
    public function beforeUpdateHook(array $update, $id, array $row): array
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        if ($row['user_id'] != $user_info->user_id) {
            throw new \RuntimeException('不能修改不属于自己的地址!');
        }

        return $update;
    }

    /**
     * 更新后调用
     * @param int $id 要更新的id
     */
//    public function afterUpdateHook($id)
//    {
//
//    }

    /**
     * 删除前调用
     * @param int $id 删除的id
     * @param array $row
     */
    public function beforeDeleteHook($id, array $row)
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        if ($row['user_id'] != $user_info->user_id) {
            throw new \RuntimeException('不能删除不属于自己的地址!');
        }
    }

    /**
     * 删除后调用
     * @param int $id 要删除的id
     */
//    public function afterDeleteHook($id)
//    {
//
//    }
}
