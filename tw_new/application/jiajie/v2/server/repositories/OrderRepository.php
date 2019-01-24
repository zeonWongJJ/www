<?php
/**
 * 数据仓库
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace repositories;

use model\OrderModel;
use utils\BaseRepository;
use utils\Factory;
use utils\ide\Db;

/**
 * Class OrderRepository
 * @package repositories
 */
class OrderRepository extends BaseRepository
{
    /**
     * 指定查询数据表名，不需要带前缀
     * @return String
     */
    public function getDbTable()
    {
        return get_table('order');
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
     * 查询一条的前置操作
     * @param Db $query
     * @param $id
     * @return Db
     */
//    public function beforeGetOne($query, $id)
//    {
//        $field = [
//            'a.*',
//            'b.user_name',
//            'b.user_pic',
//            'c.entity_title',
//            'c.entity_id',
//            'c.entity_type'
//        ];
//        $query = $query->join(['user' => 'b'], ['a.user_id' => 'b.user_id'], 'inner')
//            ->where(['a.id' => $id])
//            ->join([get_table('order_entity') => 'c'], ['c.order_sn' => 'a.order_sn'], 'inner')
//            ->select($field);
//        return $query;
//    }

    /**
     * @param array $row
     * @return array
     */
    public function afterGetOne(array $row)
    {
        return $row;
    }

    /**
     * 查询前置操作
     * @param Db $query
     * @return Db
     */
    public function beforeGetList($query)
    {
        /*$field = [
            'a.*',
            'b.user_name',
            'b.user_pic',
//            'c.entity_title',
//            'c.entity_id',
//            'c.entity_type'
        ];*/
        $_query = $query->join(['user' => 'b'], ['a.user_id' => 'b.user_id'], 'inner')
//            ->join([get_table('order_entity') => 'c'], ['c.order_sn' => 'a.order_sn'], 'inner')
            ->select('a.*, b.user_name, b.user_pic, b.user_phone', false);

        return $_query;
    }

    /**
     * @param array $rows
     * @return array
     */
    public function afterGetList(array $rows)
    {
        /** @var OrderModel $order_model */
        $order_model = Factory::getFactory('order');
        foreach ($rows as &$row) {
            $row = $order_model->formatOrderRow($row);
        }

        return $rows;
    }



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
