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
 * Class MessageRepository
 * @package repositories
 */
class MessageRepository extends BaseRepository
{
    /**
     * 缓存key前缀
     * @var string
     */
    protected $cache_key = 'message.';

    /**
     * 指定查询数据表名，不需要带前缀
     * @return String
     */
    public function getDbTable()
    {
        return 'jiajie_message';
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

        $this->condition['a.message_notice_uid'] = $user_info->user_id;

        return $query;
    }

    /**
     * 列表数据获取后调用
     * @param $rows
     * @return mixed
     */
    public function afterGetList($rows)
    {
        if ($rows) {
            foreach ($rows as &$row) {

                if ($row['message_info_id'] != 0) {
                    if ($message_info = $this->db->get_row(get_table('message_info'), ['id' => $row['message_info_id']], 'message_info')) {
                        $row['message_content'] = $message_info['message_info'];
                    }
                }
            }
        }

        return $rows;
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
    public function beforeInsertHook(array $insert): array
    {
        $insert['message_post_at'] = $_SERVER['REQUEST_TIME'];

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
