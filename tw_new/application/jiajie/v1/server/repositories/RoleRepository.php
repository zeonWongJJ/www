<?php
/**
 * 权限模块 - 角色组数据仓库
 * @author rusice <liruizhao970302@outlook.com>
 */
namespace repositories;

use utils\BaseRepository;
use utils\PinYin;

/**
 * Class RoleRepository
 * @package repositories
 */
class RoleRepository extends BaseRepository
{
    /**
     * 缓存key前缀
     * @var string
     */
    protected $cache_key = 'auth.role.';

    /**
     * @return String
     */
    public function getDbTable()
    {
        return 'jiajie_role';
    }

    /**
     * 新增前调用
     * @param array $insert
     * @return array
     */
    public function beforeInsertHook(array $insert) :array
    {
        $insert['role_key'] = str_replace(' ', '_', PinYin::encode($insert['role_name'], 'all'));
        if ($this->db->get_total($this->table, ['role_key' => $insert['role_key']])) {
            throw new \RuntimeException('已存在同KEY的用户组!');
        }

        return $insert;
    }

    /**
     * 更新前调用
     * @param array $update 传入的更新数据
     * @param int $id 更新id
     * @return array
     */
    public function beforeUpdateHook(array $update, $id): array
    {
        if (null === $update['parent_id']) {
            unset($update['parent_id']);
        }  elseif ($update['parent_id'] == $id) { // 不能以自己为上级
            throw new \RuntimeException('不能选择自己作为上级');
        }
        return $update;
    }

    /**
     * 更新后调用
     * @param $id
     */
    public function afterUpdateHook($id)
    {
        cache($this->cache_key . $id, null); // 清空缓存
    }

    /**
     * 删除前调用
     * @param $id
     */
    public function beforeDeleteHook($id)
    {
        $can_del = $this->db->get_row($this->table, compact('id'));

        if ($can_del && $can_del['can_del'] == 0) {
            throw new \RuntimeException('角色不能删除');
        }
    }

    /**
     * 删除后调用
     * @param $id
     */
    public function afterDeleteHook($id)
    {
        cache($this->cache_key . $id, null); // 清空缓存
    }
}
