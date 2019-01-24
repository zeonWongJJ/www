<?php
/**
 * Created by PhpStorm.
 * User: 7du-28
 * Date: 2018/4/25
 * Time: 16:21
 */

class ApiMessage_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    // 消息提示数
    public function message_count()
    {
        $message_count = $this->db->get_total('messagess', ['ues' => 1, 'examine' => 1]);
        return $message_count;
    }

    // 消息查看
    public function messages_show_list($pageNum, $raw)
    {
        // 先设置默认从第一页开始
        if (empty($pageNum)) {
            $pageNum = 1;
        }
        // 设置每页显示的数据行数
        if (empty($raw)) {
            $raw = 10;
        }

        // 加载分页类
        $this->load->library('pages');
        $i_total = $this->db->order_by(['mess_time' => 'desc'])->get_total('messagess');
        if ($pageNum > ceil($i_total / $raw)) {
            return [];
        }
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $pageNum, $raw);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);
        //$this->db->order_by(['mess_time' => 'desc']);
        $a_data = $this->db->order_by(['mess_time' => 'desc'])->get('messagess');
        return $a_data;
    }
}
