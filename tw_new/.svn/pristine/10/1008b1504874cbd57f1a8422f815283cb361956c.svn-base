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
 * Class AdminRepository
 * @package repositories
 */
class AdminRepository extends BaseRepository
{
    public $pk_id = 'user_id';

    /**
     * 指定查询数据表名，不需要带前缀
     * @return String
     */
    public function getDbTable()
    {
        return get_table('admin');
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
     * @param $row
     * @return array
     */
    public function afterGetOneHook($row)
    {
        unset($row['user_password'], $row['user_salt']);

        return $row;
    }


    /**
     * 查询列表前操作
     * @param Db $query
     * @return Db
     */
    public function beforeGetList($query)
    {
        $_query = $query->join([get_table('role') => 'b'], ['a.role_id' => 'b.id'])->select('a.*, b.role_name', false);

        return $_query;
    }

    /**
     * @param array $rows
     * @return array
     */
    public function afterGetList(array $rows)
    {
        foreach ($rows as $key => &$row) {
            $row['add_at'] = date('Y-m-d H:s:i', $row['add_at']);

            if ($row['user_id'] == 1) {
                unset($rows[$key]);
            }
        }

        return $rows;
    }


    /**
     * 新增前调用
     * @param array $insert 新增的数据
     * @return array
     */
    public function beforeInsertHook(array $insert): array
    {
        if ($this->db->get_total(get_table('admin'), ['user_name' => $insert['user_name']])) {
            throw new \RuntimeException('管理员账号名已存在');
        }

        $insert['user_salt']     = md5(uniqid(microtime(), true));
        $insert['user_password'] = md5(md5($insert['user_password']));
        $insert['is_enable']     = 1;
        $insert['add_at']        = $_SERVER['REQUEST_TIME'];

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
    public function beforeUpdateHook(array $update, $id): array
    {
        $update['update_at'] = $_SERVER['REQUEST_TIME'];
        if ($update['user_password']) {
            $update['user_password'] = md5(md5($update['user_password']));
        }

        return $update;
    }

    /**
     * 更新后调用
     * @param int $id 要更新的id
     */
    public function afterUpdateHook($id)
    {
        $this->db->delete(get_table('access_token'), [
            'user_id'     => $id,
            'user_type' => 'admin'
        ]);
    }

    /**
     * 删除前调用
     * @param int $id 删除的id
     */
    public function beforeDeleteHook($id, $rows)
    {
        $user_info = app('user_info');
        if ($user_info->user_name !== 'admin') {
            throw new \RuntimeException('只有使徒才能杀死使徒');
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
