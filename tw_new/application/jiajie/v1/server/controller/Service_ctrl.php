<?php
/**
 * 控制器
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

use Controller\Application;

class Service_ctrl extends Application
{
    protected $repository = \repositories\ServiceRepository::class;

//    /**
//     * 服务上架
//     * @route http://server.name/server.shelf
//     */
//    public function shelf()
//    {
//        return $this->changeStatus(1);
//    }
//
//    /**
//     * 改变状态
//     * @param $status
//     * @return mixed
//     */
//    private function changeStatus($status)
//    {
//        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//            $id = $this->router->get(1);
//
//            $this->validate(compact('id'), [
//                'id' => 'required|number'
//            ]);
//
//            $this->db->update('jiajie_service', ['service_status' => $status], compact('id'));
//            return $this->success(false);
//        }
//        return $this->error('isp-invalid-request');
//    }

//    /**
//     * 服务下架
//     * @route http://server.name/service.shift
//     */
//    public function shift()
//    {
//        return $this->changeStatus(2);
//    }
//
//    /**
//     * 下单服务
//     * @route http://server.name/service.buy
//     */
//    public function order()
//    {
//        $map['id'] = $this->router->get(1);
//
//        $this->validate($map, [
//            'id' => 'required|number'
//        ]);
//    }

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $row = [
            'service_level_1'      => $this->request->post('service_level_1', 0, 'intval'), // 服务的顶级id
            'service_level_2'      => $this->request->post('service_level_2', 0, 'intval'), // 	服务的二级id
            'service_level_3'      => $this->request->post('service_level_3', 0, 'intval'), // 服务的三级id
            'service_name'         => $this->request->post('service_name', '', 'trim'),
            'service_info'         => $this->request->post('service_info', '', 'trim'),
            'service_img'          => $this->request->post('service_img', [], 'trim'),
            'service_remuneration' => $this->request->post('service_remuneration', 0, 'float'),
            'service_lal'          => $this->request->post('service_lal', '', 'trim'),
            'service_address_name' => $this->request->post('service_address_name', '', 'trim'),
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
            'service_level_1'      => 'required|number', // 需求服务的顶级id
            'service_level_2'      => 'required|number', // 服务的二级id
            'service_level_3'      => 'required|number', // 服务的三级id
            'service_name'         => 'required|length:15',
            'service_info'         => 'required',
            //            'service_img'          => 'required',
            'service_remuneration' => 'required',
            'service_lal'          => 'required',
            'service_address_name' => 'required'
        ];

        $valid = [
            'insert' => $row,
            'update' => $row
        ];

        return $valid[$method] ?? [];
    }

    /**
     * @return array
     */
    public function setField(): array
    {
        return [
            'service_level_1'        => '服务的顶级分类'
            , 'service_level_2'      => '服务的二级分类id'
            , 'service_level_3'      => '服务的三级分类id'
            , 'service_name'         => '服务标题'
            , 'service_info'         => '服务描述'
            , 'service_remuneration' => '服务收费'
            , 'service_lal'          => '服务经纬度'
            , 'service_address_name' => '服务地址'
        ];
    }

    // - 更多方法定义

    /**
     * 审核服务
     * @router http://server.name/service.examine
     * @return mixed
     */
    public function examine()
    {
        $map['id'] = (int)$this->router->get(1);

        $no_pass_reason  = $this->request->post('reason', '', 'trim');
        $service_is_show = $this->request->post('pass', 0, 'intval');

        $this->validate($map, [
            'id' => 'required|number'
        ]);

        $service = $this->db->get_row('jiajie_service', $map);

        if ($service && $service['service_is_show'] == 0) {

            if ($service_is_show == 2) { // 审核不通过
                $this->db->update('jiajie_service', [
                    'service_is_show' => $service_is_show,
                    'no_pass_reason'  => $no_pass_reason
                ], $map);
            }  elseif ($service_is_show == 1) {
                $this->db->update('jiajie_service', [
                    'service_is_show' => $service_is_show,
                ]);
            } else {
                return $this->error('审核类型不合法');
            }
            return $this->success(false);
        }
        return $this->error('该服务审核状态不允许修改!');
    }

    /**
     * 获取未通过理由
     * @rouer http://server.name/service.nopass.reason
     */
    public function nopassReason()
    {
        $map['id'] = (int)$this->router->get(1);
        $service   = $this->db->get_row('jiajie_service', $map);

        if ($service && $service['service_is_show'] == 2) {
            return $this->success(['reason' => $service['no_pass_reason']]);
        }
        return $this->error('该服务审核状态不能获取未通过路由!');
    }

    /**
     * 删除服务，实现软删除
     * @router http://server.name/service.delete-{service_id}
     * @return mixed
     */
    public function delete()
    {
        $service_id = $this->router->get(1);
        $this->db->update(get_table('service'), ['service_is_del' => 1], ['id' => $service_id]);
        return $this->success(false);
    }
}
