<?php
/**
 * 数据仓库CURD操作封装
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace utils\traits;

/**
 * Trait BaseRepositoryTrait
 * @package utils\traits
 * @property \utils\BaseRepository repository
 */
trait BaseRepositoryTrait
{
    /**
     * 必须实现数据列表获取方法
     * @return mixed
     */
    public function getList()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data_set = $this->request->post('data-set', 'list', 'trim');
            return $this->repository->getList($this->buildQuery(), $data_set);
        }

        return $this->error('isp-invalid-request');
    }

    /**
     * 必须实现数据单条获取方法
     * @return mixed
     */
    public function getOne()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->router->get(1);

            if (!$id) {
                return $this->error('id为空!');
            }

            $build_query = $this->buildQuery();
            return $this->repository->getOne($id, $build_query, $this->cache_key);
        }

        return $this->error('isp-invalid-request');
    }

    public function getCount()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $build_query = $this->buildQuery();
            return $this->repository->getCount($build_query);
        }
    }

    /**
     * 必须实现数据更新方法
     * @return mixed
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->router->get(1);

            if (!$id) {
                return $this->error('id为空!');
            }

            $data = $this->getData('update');
            $this->validate($data, $this->valid('update'));
            return $this->repository->update($data, $id);
        }

        return $this->error('isp-invalid-request');
    }

    /**
     * 必须实现数据新增方法
     * @return mixed
     */
    public function insert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->getData('insert');
            $this->validate($data, $this->valid('insert'));
            return $this->repository->insert($data);
        }

        return $this->error('isp-invalid-request');
    }

    /**
     * 必须实现数据删除方法
     * @return mixed
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->router->get(1);

            if ('admin' === $id) {
                // URL不携带id情况下，尝试从post中获取ids
                $id = $this->request->post('id/a', [], 'trim');
                if (!$id) {
                    return $this->error('id为空!');
                }
            }
            return $this->repository->delete($id);
        }

        return $this->error('isp-invalid-request');
    }
}
