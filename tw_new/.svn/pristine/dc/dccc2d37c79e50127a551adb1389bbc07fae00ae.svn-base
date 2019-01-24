<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 0.1-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

use utils\BaseController;

class ServiceFlow_ctrl extends BaseController
{
    public $repository = \repositories\ServiceFlowRepository::class;

    /**
     * 数据getter
     * @param string $method 请求方法
     * @return array
     */
    public function getData($method): array
    {
        $row = [
            'flow_title'   => $this->request->post('flow_title', '', 'trim'),
            'flow_content' => $this->request->post('flow_content', '', 'trim'),
            'flow_cover'   => $this->request->post('flow_cover', '', 'trim'),
            'flow_sort'    => $this->request->post('flow_sort', 0, 'intval'),
            'service_id'   => $this->router->get(1) ?: 0,
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
            'flow_title'   => 'required',
            'flow_content' => 'required',
            'flow_cover'   => 'required',
            'service_id'   => 'required|number'
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
            'flow_title'   => '流程标题',
            'flow_content' => '流程描述',
            'flow_cover'   => '流程封面图',
            'service_id'   => '服务id'
        ];
    }
}
