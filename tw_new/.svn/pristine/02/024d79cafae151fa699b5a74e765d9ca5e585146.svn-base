<?php
/**
 * 基础数据仓库封装
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace utils;

use utils\ide\Db;

abstract class BaseRepository
{
    /** @var string */
    protected $table = '';

    /** @var Db */
    protected $db;

    /**
     * 表主键
     * @var string
     */
    protected $pk_id = 'id';

    /**
     * 查询条件
     * @var array
     */
    protected $condition = [];

    public function __construct()
    {
        $this->db = app('db');
        if (false === $this->db) {
            throw new \RuntimeException('db服务未注册!');
        }

        $this->table = $this->getDbTable();
    }

    /**
     * @return String
     */
    abstract public function getDbTable();

    /**
     * 必须实现数据列表获取方法
     * @param array $build_query
     * @param string $data_set
     * @return mixed
     */
    public function getList(array $build_query, $data_set = 'list')
    {
        list($field, $sort, $offset, $limit, $condition) = $build_query;

        $this->condition = $condition;

        if (method_exists($this, 'customizeListGetter')) {
            return $this->customizeListGetter($build_query, $data_set);
        }

//        try {
//            $this->db->begin();
        // 获取数据列表，非树形
        if ($data_set === 'list') {
            $query = $this->db->select($field);

            if (method_exists($this, 'beforeGetList')) {
                $before = $this->beforeGetList($query);

                if ($before instanceof \TW_Mysql) {
                    /** @var Db $query */
                    $query = $before;
                }
            }

            foreach ($this->condition as $key => $value) {
                if ('%' === $value[0]) {
                    $this->condition[$key . ' LIKE'] = $value;
                    unset($this->condition[$key]);
                }
            }

            /** @noinspection PassingByReferenceCorrectnessInspection */
            if (isset($sort['id'])) {
                $sort[$this->pk_id] = $sort['id'];
                unset($sort['id']);
            }

            $rows = $query->limit($offset * 1 < 0 ? 0 : $offset, $limit)->where($this->condition)->order_by($sort)->get([$this->table => 'a']);

            $rows && filter($rows);

            if (method_exists($this, 'getListCount')) {
                $count = $this->getListCount();
            }

            if (method_exists($this, 'afterGetList')) {
                $rows = $this->afterGetList($rows);
            }

//                $this->db->commit();
            return success($rows ?: [], $count ?? \count($rows), [
                'sql' => APP_DEBUG ? $query->get_sql() : ''
            ]);
        }

        // 获取树形
        if ($data_set === 'tree') {
            // 如果查询字段不是*的话，需要判断是否有id、parent_id这两个字段，如果没有要加上
            if ($field !== '*') {
                false === strpos($this->pk_id, $field) && $field .= ',' . $this->pk_id;
                false === strpos('parent_id', $field) && $field .= ',parent_id';
            }

            $count = $this->db->get_total($this->table); // 总数量
            $rows  = $this->db
                ->where($condition)
                ->select($field)
                ->order_by($sort)
                ->limit(0, $count)
                ->get($this->table);

            if ($rows) {
                if (method_exists($this, 'beforeChangeTree')) {
                    $rows = $this->beforeChangeTree($rows);
                }
                $rows = list_to_tree(filter($rows));
            }

            if (method_exists($this, 'afterGetTree')) {
                $rows = $this->afterGetTree($rows);
            }
//                $this->db->commit();
            return success($rows ?: [], 0, [
                'sql' => APP_DEBUG ? $this->db->get_sql() : 'NO_DEBUG_EVN'
            ]);
        }
        return error('未知数据格式');
//        } catch (\Exception $e) {
//            $this->db->roll_back();
//            return error($e->getMessage());
//        }
    }

    /**
     * 必须实现数据单条获取方法
     * @param $id
     * @param array $build_query
     * @param $cache_key
     * @return mixed
     */
    public function getOne($id, array $build_query, $cache_key = '')
    {
        $cache_key = $cache_key ?: $this->cache_key;
        $cache_key = $cache_key ?: 'no_key' . time();

        if (method_exists($this, 'customizeGetter')) {
            $row = $this->customizeGetter($id, $build_query, $cache_key);
        } else {
            list($field, $sort, $offset, $rows, $condition) = $build_query;
            $this->condition['a.' . $this->pk_id] = $id;

            $query = $this->db;
            if (method_exists($this, 'beforeGetOne')) {
                $before          = $this->beforeGetOne($query, $id);
                $this->condition = array_merge($this->condition, $condition);

                if ($before instanceof \TW_Mysql) {
                    /** @var Db $before */
                    $query = $before; //$before->select($field)->where($this->condition);
                } else {
                    $query = $query->select($field);
                }
            }
            $row = $query->where($this->condition)->get_row([$this->table => 'a']);
        }

        $row = filter($row);

        if (method_exists($this, 'afterGetOne')) {
            $row = $this->afterGetOne($row);
        }

        if ($row) {
            return success($row, 1, [
                'sql' => APP_DEBUG ? $this->db->get_sql() : ''
            ]);
        }

        return error('no-data', 1, [], [
            'sql'  => APP_DEBUG ? $this->db->get_sql() : ''
            , 'id' => $id
        ]);
    }

    /**
     * 获取总数接口
     * @param array $build_query
     * @return mixed
     */
    public function getCount(array $build_query)
    {
        list($field, $sort, $offset, $rows, $condition) = $build_query;
        $count = $this->db->get_total($this->table, $condition);

        return success(['_count' => $count]);
    }

    /**
     * 必须实现数据更新方法
     * @param array $update
     * @param $id
     * @return mixed
     */
    public function update(array $update, $id)
    {
        $row = $this->db->get_row($this->table, [$this->pk_id => $id]);
        if ($row) {
            try {
                $this->db->begin();
                $this->db->set_error_mode();


                if (method_exists($this, 'beforeUpdateHook')) {
                    $update = $this->beforeUpdateHook($update, $id, $row);
                }

                $this->db->update($this->table, $update, [$this->pk_id => $id]);

                if (method_exists($this, 'afterUpdateHook')) {
                    $this->afterUpdateHook($id);
                }

                $this->db->commit();
                return success(false, 0, [
                    'sql' => APP_DEBUG ? $this->db->get_sql() : ''
                ]);
            } catch (\Exception $e) {
                $this->db->roll_back();
                return error($e->getMessage(), 1);
            }
        }
        return error('no-data');
    }

    /**
     * 必须实现数据新增方法
     * @param array $insert
     * @return mixed
     */
    public function insert(array $insert)
    {
        try {
            $this->db->set_error_mode();
            $this->db->begin();
            if (method_exists($this, 'beforeInsertHook')) {
                $insert = $this->beforeInsertHook($insert);
            }

            if (\is_array($insert)) {

                $result = $this->db->insert($this->table, $insert);

                if (!$result) {
                    throw new \RuntimeException('数据新增失败');
                }

                $insert['id'] = $result; // 追加新插入的ID到数组中

                if (method_exists($this, 'afterInsertHook')) {
                    $result = $this->afterInsertHook($insert);
                } else {
                    $result = [];
                }

                $this->db->commit();
                return success($result ?: false);
            }
        } catch (\Exception $e) {
            $this->db->roll_back();
            return error($e->getMessage(), 1);
        }
    }

    /**
     * 必须实现数据删除方法
     * @param array|int $id
     * @return mixed
     */
    public function delete($id)
    {
        try {
            $this->db->begin();
            $this->db->set_error_mode();

            // 不允许删除存在下级的节点
            if (\is_array($id)) {
                $rows = $this->db->where_in($this->pk_id, $id)->limit(0, \count($id))->get($this->table);

                if (method_exists($this, 'beforeDeleteHook')) {
                    $this->beforeDeleteHook($id, $rows);
                }

                if ($rows && isset($rows[0]['parent_id'])) {
                    foreach ($rows as $row) {
                        if (0 < $this->db->get_total($this->table, ['parent_id' => $row['id']])) {
                            throw new \RuntimeException('此数据或其下级存在下级，不允许删除');
                        }
                    }
                }

                $result = $this->db->where_in($this->pk_id, $id)->delete($this->table);
            } else {
                $row = $this->db->get_row($this->table, [$this->pk_id => $id]);

                if ($row) {
                    if (isset($row['parent_id']) && 0 < $this->db->get_total($this->table, ['parent_id' => $id])) {
                        throw new \RuntimeException('存在下级，不允许删除');
                    }
                } else {
                    return error('no-data');
                }

                if (method_exists($this, 'beforeDeleteHook')) {
                    $this->beforeDeleteHook($id, $row);
                }

                $result = $this->db->delete($this->table, [$this->pk_id => $id]);
            }

            if (!$result) {
                throw new \RuntimeException('数据删除失败!');
            }

            if (method_exists($this, 'afterDeleteHook')) {
                $this->afterDeleteHook($id);
            }

            $this->db->commit();
            return success(false);
        } catch (\Exception $e) {
            $this->db->roll_back();
            return error($e->getMessage(), 1);
        }
    }
}
