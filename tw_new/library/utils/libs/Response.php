<?php
/**
 * 数据响应器
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */
namespace utils;

class Response
{
    // 输出参数
    protected $options = [];

    /**
     * 输出内容类型
     * @var string
     */
    protected $contentType = 'application/json';

    /**
     * 输出数据
     * @var array
     */
    protected $data = [];

    /**
     * 设置响应数据
     * @param array $data
     * @return $this
     */
    public function data(array $data = [])
    {
        if ($data) {
            $this->data = array_merge($this->data, $data);
        }
        return $this;
    }

    /**
     * @param $key
     * @param string $value
     * @return Response
     */
    public function header($key, $value = ''): Response
    {
        if (is_array($key)) {
            foreach ($key as $k => $item) {
                header("{$k}:{$item}");
            }
        }

        header("{$key}:{$value}");

        return $this;
    }

    /**
     * 设置发送
     * @param $msg
     * @param int $code
     * @param array $rows
     * @param array $append
     * @param string $type
     * @return mixed
     */
    public function send($msg = '暂无数据', $code = 1, $rows = [], $count = 0, $append = [], $type = 'json')
    {
        $adapter = __NAMESPACE__ . '\response\\' . ucfirst($type);
        if (\is_callable([$adapter, 'output'])) {
            $msg === '暂无数据' && $code = 0;
            if ($count === 1 || $count === 0) {
                $_rows = $rows;
            } else {
                $_rows['list'] = $rows;
                $_rows['count'] = $count ?: \count($rows);
            }

            $response = (new $adapter)->output(is_array($msg) ? $msg : [$msg], $code, $_rows, $append);
            $this->header('Content-Type', $this->contentType . ';charset=utf8');
            return $response;
        }
        throw new \RuntimeException("输出适配器{$type}未定义!");
    }
}
