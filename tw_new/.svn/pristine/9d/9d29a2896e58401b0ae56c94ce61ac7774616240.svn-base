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
class CategoryModel extends \utils\BaseModel
{
    public $ids = [];

    public function getAllChildren($id)
    {
        $row = $this->db->get_total('jiajie_category', ['parent_id' => $id]);
        if ($row) {
            $all = $this->db->limit(0, $row)->get('jiajie_category', ['parent_id' => $id]);
            foreach ($all as $item) {
                $this->ids[] = $item['id'];
                $this->getAllChildren($item['id']);
            }
        }
    }
}