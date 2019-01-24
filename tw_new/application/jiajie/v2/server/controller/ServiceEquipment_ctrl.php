<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 0.1-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

use utils\BaseController;

class ServiceEquipment_ctrl extends BaseController
{
    public $repository = \repositories\ServiceEquipmentRepository::class;

    /**
     * 数据getter
     * @param string $method 请求方法
     * @return array
     */
    public function getData($method): array
    {
        $row = [
            'equipment_name'    => $this->request->post('equipment_name', '', 'trim'),
            'equipment_content' => $this->request->post('equipment_content', '', 'trim'),
            'equipment_sort'    => $this->request->post('equipment_sort', 0, 'intval'),
            'equipment_img'     => $this->request->post('equipment_img', '', 'trim'),
            'service_id'        => $this->router->get(1) ?: 0,
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
            'equipment_name'    => 'required',
            'equipment_content' => 'required',
            'service_id'        => 'required|number'
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
            'equipment_name'    => '设备名称',
            'equipment_content' => '设备描述',
            'service_id'        => '服务id'
        ];
    }
}
