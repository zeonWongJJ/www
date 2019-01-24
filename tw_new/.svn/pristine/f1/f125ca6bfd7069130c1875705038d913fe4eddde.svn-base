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
 * Class RuleRepository
 * @package repositories
 */
class RuleRepository extends BaseRepository
{
    /**
     * 指定查询数据表名，不需要带前缀
     * @return String
     */
    public function getDbTable()
    {
        return get_table('rule');
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
        $_query = $query;
        if ('admin' === app('router')->get(1)) {
            $_query = $query->select(['a.id', 'a.rule_name as `name`', 'a.parent_id as parentid'])
                ->order_by(['a.rule_sort' => 'desc']);
        }
        return $_query;
    }

    /**
     * 转换成树形格式之前调用
     * @param array $rows
     * @return array
     */
    public function beforeChangeTree(array $rows): array
    {
        foreach ($rows as &$row) {
            $row['open']     = true;
            $row['opened']   = true;
            $row['selected'] = true;
        }

        return $rows;
    }

    /**
     * 响应树形数据前调用
     * @param array $rows
     * @return array
     */
    public function afterGetTree(array $rows): array
    {
        $new_rows = [];
        foreach ($rows as $row) {
            $new_rows[] = $row;
        }

        return $new_rows;
    }


    /**
     * 新增前调用
     * @param array $insert 新增的数据
     * @return array
     */
    public function beforeInsertHook(array $insert): array
    {
        $count = $this->db->get_total($this->table, [
            'rule_controller'     => $insert['rule_controller']
            , 'rule_action'       => $insert['rule_action']
            , 'rule_router_param' => $insert['rule_router_param']
        ]);
        if (!$count) {
            return $insert;
        }
        throw new \RuntimeException('已存在相同的记录');
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
    public function beforeUpdateHook(array $update, $id): array
    {
        if (null === $update['parent_id']) {
            unset($update['parent_id']);
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
