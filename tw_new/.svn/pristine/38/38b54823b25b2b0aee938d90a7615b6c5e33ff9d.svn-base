<?php
/**
 * JSON格式数据响应
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */
namespace utils\response;

use utils\Response;

class Json extends Response
{
    // 输出参数
    protected $options = [
        'json_encode_param' => JSON_UNESCAPED_UNICODE,
    ];

    /**
     * 输出响应
     * @param $msg
     * @param int $code
     * @param array $rows
     * @param array $append
     * @return string
     */
    public function output($msg, $code = 1, $rows = [], array $append = [])
    {
        if ($append) {
            $this->data = array_merge($this->data, $append);
        }

        $this->data = array_merge((array)$rows, $this->data);

        $response = [
            'error' =>  $code,
            'msg'   =>  $msg,
        ];

        $response['count'] = $this->data['count'] ?? 0;
        unset($this->data['count']);
        $response['data'] = $this->data['list'] ?? $this->data;

        if (isset($response['data']['sql'])) {
            $sql = $response['data']['sql'];
            unset($response['data']['sql']);
            $response['sql'] = $sql;
        }

        ksort($response);

        if (\extension_loaded('jsond')) {
            $json = jsond_encode($response, $this->options['json_encode_param']);
        } else {
            $json = json_encode($response, $this->options['json_encode_param']);
        }

        if (false === $json) {
            throw new \RuntimeException(json_last_error_msg());
        }

        return $json;
    }
}
