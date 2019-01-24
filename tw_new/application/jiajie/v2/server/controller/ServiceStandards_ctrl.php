<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 0.1-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

use utils\BaseController;

class ServiceStandards_ctrl extends BaseController
{
    public $repository = \repositories\ServiceStandardsRepository::class;

    /**
     * 数据getter
     * @param string $method 请求方法
     * @return array
     */
    public function getData($method): array
    {
        $row = [
            'standards_desc'  => $this->request->post('standards_desc', '', 'trim'),
            'standards_cover' => $this->request->post('standards_cover', '', 'trim'),
            'standards_sort'  => $this->request->post('standards_sort', 0, 'intval'),
            'service_id'      => $this->router->get(1) ?: 0,
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
            'standards_cover' => 'required',
            'standards_desc'  => 'required',
            'service_id'      => 'required|number'
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
            'flow_content'    => '服务标准描述',
            'standards_cover' => '服务标准封面图',
            'service_id'      => '服务id'
        ];
    }
}
