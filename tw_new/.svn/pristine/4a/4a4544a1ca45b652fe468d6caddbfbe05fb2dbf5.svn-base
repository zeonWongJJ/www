<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 0.1-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

use utils\Factory;

class SubscribeModel extends BaseModel
{
    public function formatRows($rows)
    {
        /** @var CategoryModel $subscribe_model */
        $cate_model = Factory::getFactory('category');
        foreach ($rows as &$row) {
            $row['sub_at'] = date('Y-m-d H:i:s', $row['sub_at']);
            $row['cate_name'] = $cate_model->getCateRow($row['cate_id'])['cat_name'];
        }

        return $rows;
    }
}
