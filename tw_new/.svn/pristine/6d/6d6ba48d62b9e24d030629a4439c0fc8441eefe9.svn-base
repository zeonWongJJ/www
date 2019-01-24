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
 * Class CollectRepository
 * @package repositories
 */
class CollectRepository extends BaseRepository
{


    /**
     * 指定查询数据表名，不需要带前缀
     * @return String
     */
    public function getDbTable()
    {
        return 'jiajie_user_collect';
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
    public function beforeGetList($query)
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        $user_id = $user_info->user_id;
        $count = $this->db->get_total($this->table, ['user_id' => $user_id]);

        /** @noinspection CallableParameterUseCaseInTypeContextInspection */
        $query = $query
            ->limit(0, $count)
            ->select([
                'b.id',
                'b.service_lal',
                'b.service_name',
                'b.service_info',
                'b.service_img',
                'b.service_remuneration',
                'b.service_sold',
                'c.store_level',
                'c.store_name'
            ])
            ->join([get_table('service') => 'b'], ['b.id' => 'a.service_id'], 'INNER')
            ->join([get_table('store') => 'c'], ['b.store_id' => 'c.id'], 'INNER')
            ->where(['a.user_id' => $user_id]);

        return $query;
    }

    /**
     * 收藏列表查询后操作，用于处理数据格式
     * @param array $rows
     * @return array
     */
    public function afterGetList(array $rows)
    {
        foreach ($rows as &$row) {
            $row['service_remuneration'] = number_format($row['service_remuneration'] / 100, 2, '.', ',');
            $row['service_img'] = explode(',', $row['service_img']);
        }

        return $rows;
    }

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

        $count = $this->db->get_total($this->table, $insert);
        if ($count) {
            throw new \RuntimeException('已经收藏过该服务，请不要重复收藏');
        }

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
     * @return array
     */
//    public function beforeUpdateHook(array $update, $id): array
//    {
//
//    }

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
     */
//    public function beforeDeleteHook($id)
//    {
//
//    }

    /**
     * 删除后调用
     * @param int $id 要删除的id
     */
//    public function afterDeleteHook($id)
//    {
//
//    }
}
