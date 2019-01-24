<?php

class Jiajie_ctrl extends \TW_Controller
{
    public function Search()
    {
        $user_id = (int)$this->general->get('user_id', false);
        $result  = $this->httpGet('http://jiajie-server.7dugo.com/user.get.share.count-' . $user_id);
        $a_data  = [
            'user_id' => $user_id
            , 'count' => $result->_count
        ];
        $this->view->display('jiajie/search', $a_data);
    }

    private function httpGet($url)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        $data = json_decode($data);
        if (null !== $data && 0 === $data->error) {
            $data = $data->data;
        }
        return $data;
    }
}
