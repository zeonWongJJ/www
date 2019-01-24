<?php
/**
 * 数据仓库
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author -AUTHOR- <-EMAIL->
 */
namespace repositories;

use utils\BaseRepository;

/**
 * Class --className--
 * @package repositories
 */
class --className-- extends BaseRepository
{
    [--cacheKey--]

    /**
     * 指定查询数据表名，不需要带前缀
     * @return String
     */
    public function getDbTable()
    {
        return '--tableName--';
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
    * @return TW_Mysql
    */
//    public function beforeGetList($query)
//    {
//
//    }



    /**
     * 新增前调用
     * @param array $insert 新增的数据
     * @return array
     */
//    public function beforeInsertHook(array $insert) :array
//    {
//
//    }

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