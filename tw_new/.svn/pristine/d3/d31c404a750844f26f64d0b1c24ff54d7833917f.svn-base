<?php
/**
 * 控制器
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

class Slide_ctrl extends \utils\BaseController
{

    protected $repository = \repositories\SlideRepository::class;

    protected $cache_key = 'slide.list';

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $data = [
            'insert' => [
                // 写入操作时需要获取的字段 例子:
                'slide_sort'            => $this->request->post('slide_sort', '0', 'trim'),
                'slide_img_url'         => $this->request->post('slide_img_url', '', 'trim'),
                'slide_name'            => $this->request->post('slide_name', '', 'trim'),
                'slide_href'            => $this->request->post('slide_href', '#', 'trim'),
                'slide_type'            => $this->request->post('slide_type', '0', 'trim'),
                'slide_show'            => $this->request->post('slide_show', '1', 'trim'),
                'slide_show_start_time' => $this->request->post('slide_show_start_time', '', 'trim'),
                'slide_show_end_time'   => $this->request->post('slide_show_end_time', '0', 'trim'),
                'slide_add_time'        => $_SERVER['REQUEST_TIME'],
            ],
            'update' => [
                // 更新操作时需要获取的字段 例子:
                'slide_sort'            => $this->request->post('slide_sort', '0', 'trim'),
                'slide_img_url'         => $this->request->post('slide_img_url', '', 'trim'),
                'slide_name'            => $this->request->post('slide_name', '', 'trim'),
                'slide_href'            => $this->request->post('slide_href', '', 'trim'),
                'slide_type'            => $this->request->post('slide_type', '0', 'trim'),
                'slide_show'            => $this->request->post('slide_show', '1', 'trim'),
                'slide_show_start_time' => $this->request->post('slide_show_start_time', $_SERVER['REQUEST_TIME'], 'trim'),
                'slide_show_end_time'   => $this->request->post('slide_show_end_time', '0', 'trim'),
                'slide_add_time'        => $_SERVER['REQUEST_TIME'],
            ]
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
        $valid = [
            'insert' => [
                // 写入时的数据验证如：
                'slide_img_url' => 'required',
                'slide_name'    => 'required',
            ],
            'update' => [
                // 更新时的数据验证如：
                'slide_img_url' => 'required',
                'slide_name'    => 'required',
            ]
        ];

        return $valid[$method] ?? [];
    }

    public function getField()
    {
        return [
            'slide_img_url' => '幻灯片图片url'
            , 'slide_name'  => '幻灯片名字'
        ];
    }

    // - 更多方法定义
    //修改显示状态
    public function display()
    {
        $post = $this->request->post();

        if (!isset($post['id'])) {
            $this->error('primary key must isset', 1);
        }

        $id         = $post['id'];
        $slide_info = $this->db->get_row('jiajie_slide', ['id' => $id]);

        $slide_show  = $slide_info['slide_show'] == 0 ? '1' : '0';
        $update_info = ['slide_show' => $slide_show];

        $this->repository->update($update_info, $id);
    }

    /**刪除幻灯图片
     *
     */
    public function remove_image()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $remove_path = $this->request->post('remove_path', '', 'trim');
            if (file_exists($remove_path)) {
                unlink($remove_path) ? $this->json('删除成功', 0) : $this->error('删除失败');
            }
        }
    }
}
