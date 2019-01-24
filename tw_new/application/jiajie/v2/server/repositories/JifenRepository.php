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
 * Class JifenRepository
 * @package repositories
 */
class JifenRepository extends BaseRepository
{

    public $pk_id = 'pl_id';

    /**
     * 指定查询数据表名，不需要带前缀
     * @return String
     */
    public function getDbTable()
    {
        return 'points_log';
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
     * 获取总数
     * @return int
     */
    //    public function getListCount()
    //    {
    //        $user_info = app('user_info');
    //
    //        if (!$user_info || !isset($user_info->user_id)) {
    //            throw new \RuntimeException('user-info-error');
    //        }
    //
    //        $this->db->get_total($this->table, [
    //            'user_id'   =>  $user_info->user_id
    //        ]);
    //    }

    public function afterGetOne($row)
    {
        $row['pl_time']  = date('Y-m-d H:i:s', $row['pl_time']);
//        $row['order_sn'] = ''; //todo::获取积分所属订单
        return $row;
    }


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

        $user_id = app('router')->get(1);
        if ($user_id) {
            if ('admin' !== strtolower($user_info->user_type_key)) {
                throw new \RuntimeException('非管理员不能执行此操作');
            }
            $this->condition['a.user_id'] = $user_id;
        } else {
            $this->condition['a.user_id'] = $user_info->user_id;
        }

        $query = $query->order_by(['a.pl_time' => 'desc']);

        return $query;
    }

    /**
     * 查询后处理
     * @param $rows
     * @return mixed
     */
    public function afterGetList($rows)
    {
        foreach ($rows as &$row) {
            $row['pl_time'] = date('Y-m-d H:i:s', $row['pl_time']);
        }

        return $rows;
    }

    /**
     * 获取总数
     * @return int
     */
    public function getListCount()
    {
        return $this->db->from([$this->table => 'a'])->where($this->condition)->get_total();
    }

    /**
     * @param Db $query
     * @param $id
     * @return Db
     */
    public function beforeGetOne($query, $id)
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        $this->condition['a.pl_id']   = $id;
        $this->condition['a.user_id'] = $user_info->user_id;

        $query = $query->where($this->condition);

        return $query;
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