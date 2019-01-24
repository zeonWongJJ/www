<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.o-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

use utils\BaseController;

class ServiceUtil_ctrl extends BaseController
{
    public $repository = \repositories\ServiceUtilRepository::class;

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $row = [
            'unit_name' => $this->request->post('unit_name', '', 'trim'),
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
        $row = [
            'unit_name' => 'required',
        ];

        $valid = [
            'insert' => $row,
            'update' => $row
        ];

        return $valid[$method] ?? [];
    }

    // - 更多方法定义
    public function setField(): array
    {
        return [
            'unit_name' => '计费单位'
        ];
    }
}
