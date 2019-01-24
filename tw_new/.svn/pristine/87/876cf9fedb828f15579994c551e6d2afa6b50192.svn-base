<?php
/**
 * 分类控制器
 * @author rusice <liruizhao970302@outlook.com>
 */

/**
 * Class Category_ctrl
 */
class Category_ctrl extends \utils\BaseController
{
    public $_ignore_node = [
        'getList'
    ];

    protected $repository = \repositories\CategoryRepository::class;

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $row = [
            'pay_type'   => $this->request->post('pay_type', 0, 'intval'),
            'cat_name'   => $this->request->post('cat_name', '', 'trim'),
            'parent_id'  => $this->request->post('parent_id', 0, 'intval'),
            'cate_cover' => $this->request->post('cate_cover', '', 'trim')
        ];

        $data = [
            'insert' => $row,
            'update' => $row
        ];

        return $data[$method] ?? [];
    }

    /**
     * 验证定义
     * @param $method
     * @return array
     */
    public function valid($method): array
    {
        $rows  = [
            'cat_name' => 'required'
        ];
        $valid = [
            'insert' => $rows,
            'update' => $rows,
        ];

        return $valid[$method] ?? [];
    }

    public function setField()
    {
        return [
            'cat_name' => '分类名称'
        ];
    }

    /**
     * @router http://server.name/category.get_level
     */
    public function showLevel()
    {
        $category = get_table('category');
        $level    = (int)$this->router->get(1);
        $count    = $this->db->get_total($category, ['level' => $level]);
        $rows     = $this->db->limit(0, $count)->get($category, compact('level'));

        return $this->success($rows, $count);
    }

    /**
     * 获取分类的收费类型
     * @router http://server.name/category.get_payway
     */
    public function getPayWay()
    {
        $id = (int)$this->router->get(1);
        if (!$id) {
            return $this->error('id非法');
        }
        $row = $this->db->get_row(get_table('category'), ['id' => $id], 'pay_type');
        return $this->success(filter($row));
    }

    /**
     * 切换分类是否显示
     * @router http://server.name/category.change.show
     * @return mixed
     */
    public function changeShow()
    {
        $id = (int)$this->router->get(1);
        if (!$id) {
            return $this->error('分类ID必须');
        }

        $row = $this->db->get_row(get_table('category'), compact('id'), 'cate_is_show');
        if (!$row) {
            return $this->error();
        }

        $update['cate_is_show'] = $row['cate_is_show'] == 1 ? 0 : 1;
        $this->db->update(get_table('category'), $update, compact('id'));
        return $this->success(false);
    }

    /**
     * 修改栏目的自营属性
     * @ReqestMapping('/category.change.support-{$id}')
     */
    public function changeSupport()
    {
        $id = (int)$this->router->get(1);
        if (!$id) {
            return $this->error('分类ID必须');
        }
        $row = $this->db->get_row(get_table('category'), compact('id'), 'is_self_support');
        if (!$row) {
            return $this->error();
        }
        $update['is_self_support'] = $row['is_self_support'] == 1 ? 0 : 1;
        $this->db->update(get_table('category'), $update, compact('id'));
        return $this->success(false);
    }


    /**
     * 修改分类排序
     * @router http://server.name/category.update.sort-{cate_id}
     */
    public function updateSort()
    {
        $cate_id           = (int)$this->router->get(1);
        $data['cate_sort'] = $this->request->post('sort', 50, 'intval');
        $this->db->update(get_table('category'), $data, ['id' => $cate_id]);
        return $this->success(false);
    }
}
