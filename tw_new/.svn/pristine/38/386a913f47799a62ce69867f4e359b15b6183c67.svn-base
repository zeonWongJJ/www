<?php
/**
 * 模型类
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

/**
 * Class CategoryModel
 * @package model
 */
class CategoryModel extends BaseModel
{
    public $ids = [];

    public function getAllChildren($id)
    {
        $row = $this->db->get_total(get_table('category'), ['parent_id' => $id]);
        if ($row) {
            $all = $this->db->limit(0, $row)->get(get_table('category'), ['parent_id' => $id]);
            foreach ($all as $item) {
                $this->ids[] = $item['id'];
                $this->getAllChildren($item['id']);
            }
        }
    }

    /**
     * @param integer $cate_id 分类id
     * @return array|bool|mixed|string
     */
    public function getCateRow($cate_id)
    {
        $cate_info = $this->cache('cate.info.' . $cate_id);
        if (!$cate_info) {
            $cate_info = $this->db->get_row(get_table('category'), ['id' => $cate_id]);
            $cate_info = serialize($cate_info);
            $this->cache('cate.info.' . $cate_id, $cate_info, 3600);
        }
        $cate_info = unserialize($cate_info);

        return $cate_info;
    }

    /**
     *
     * @param $rows
     * @return mixed
     */
    public function formatRows($rows)
    {
        foreach ($rows as $key => &$row) {
            $row['cate_is_show_bool'] = (bool)$row['cate_is_show'];
            $row['is_self_support'] = (bool)$row['is_self_support'];
            $row['loading'] = false;
            if (isset($row['children']) && $row['children']) {
                $this->formatRows($row['children']);
            }
        }
        return $rows;
    }
}
