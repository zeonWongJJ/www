<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 0.1-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

use utils\BaseController;

class ServiceItem_ctrl extends BaseController
{
    public $repository = \repositories\ServiceItemRepository::class;

    /**
     * 数据getter
     * @param string $method 请求方法
     * @return array
     */
    public function getData($method): array
    {
        $row = [
            'item_name'   => $this->request->post('item_name', '', 'trim'),
            'item_desc'   => $this->request->post('item_desc', '', 'trim'),
            'item_change' => $this->request->post('item_change', 0, 'intval'),
            'is_show'     => $this->request->post('is_show', 1, 'intval'),
            'service_id'  => $this->router->get(1) ?: 0,
        ];


        $data = [
            'insert' => $row,
            'update' => $row,
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
            'item_name'   => 'required',
            'item_change' => 'required',
            'service_id'  => 'required|number'
        ];

        $data = [
            'insert' => $row,
            'update' => $row,
        ];

        return $data[$method] ?? [];
    }

    /**
     * 字段含义定义
     * @return array
     */
    public function setField(): array
    {
        return [
            'item_name'   => '服务项目名称',
            'item_desc'   => '服务项目描述',
            'item_change' => '服务项目收费单价',
            'is_show'     => '项目是否显示',
            'service_id'  => '服务id'
        ];
    }
}
