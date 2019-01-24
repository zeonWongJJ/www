<?php
/**
 * 控制器
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

class Timeline_ctrl extends \utils\BaseController
{
    public $_ignore_node = [
        'getCount'
        , 'getList'
    ];
    protected $repository = \repositories\TimelineRepository::class;

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $rows = [
            'time_line_title'     => $this->request->post('time_line_title', '', 'trim')
            , 'time_line_at'      => $this->request->post('time_line_at', '', 'trim')
            , 'time_line_connect' => $this->request->post('time_line_connect', '', 'trim')
            , 'time_line_is_show' => $this->request->post('time_line_is_show', 0, 'intval')
        ];
        $data = [
            'insert' => array_merge($rows, [
                // 写入操作时需要获取的字段 例子:
                // 'role_name' =>  $this->request->post('role_name', '', 'trim')
            ]),
            'update' => array_merge($rows, [
                // 更新操作时需要获取的字段 例子:
                // 'role_name' =>  $this->request->post('role_name', '', 'trim'),
            ])
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
            'time_line_title'     => 'required'
            , 'time_line_at'      => 'required'
            , 'time_line_connect' => 'required'
        ];
        $valid = [
            'insert'   => array_merge($rows, [
                // 写入时的数据验证如：
                // 'role_name' =>  'required'
            ])
            , 'update' => array_merge($rows, [
                // 更新时的数据验证如：
                // 'role_name' =>  'required'
            ])
        ];

        return $valid[$method] ?? [];
    }

    public function setField()
    {
        return [
            'time_line_title'     => '时间轴标题'
            , 'time_line_at'      => '时间轴发生时间'
            , 'time_line_connect' => '时间轴事件'
        ];
    }

    // - 更多方法定义

    /**
     * @router http://server.name/timeline.show
     * @return mixed
     */
    public function changeShow()
    {
        $timeline_id = (int)$this->router->get(1);
        if (!$timeline_id) {
            return $this->error('没有获取到时间轴id');
        }
        if (!$timeline_info = $this->db->get_row(get_table('timeline'), ['id' => $timeline_id])) {
            return $this->error('记录为空');
        }


        $this->db->update(get_table('timeline'), [
            'time_line_is_show' => $timeline_info['time_line_is_show'] == 1 ? 0 : 1
        ], ['id' => $timeline_id]);

        return $this->success(false);
    }
}
