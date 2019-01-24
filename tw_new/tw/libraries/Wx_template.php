<?php
// 微信模板消息 https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1433751277

class TW_wx_template
{
    // 自定义配置文件名，当有多个通知路径等需求时，可以设置不同配置文件来解决
    private $_s_config_file = 'config_wx_template';
    // 配置参数
    private $_a_config = [];
    // general类对象
    public $o_general;

    // 构造函数，对参数进行处理
    public function __construct()
    {
        global $o_general;
        $this->o_general = $o_general;
        $this->_config();
        $this->access_token();
    }

    // 发送模板消息
    public function send($a_param)
    {
        $a_data = [
            'touser' => $a_param['openid'],
            'template_id' => '',
            'data' => $a_param['data']
        ];
        if (isset($a_param['template_id']) && !empty($a_param['template_id'])) {
            $a_data['template_id'] = $a_param['template_id'];
        } else {
            $a_data['template_id'] = 'hh4N3StUMOjg5_SXxgh5Gst7cC6luOVjzP29x4_SHvw';
        }
        if (!empty($a_param['url'])) {
            $a_data['url'] = $a_param['url'];
        }
        if (!empty($a_param['miniprogram'])) {
            $a_data['miniprogram'] = $a_param['miniprogram'];
        }
        $s_data = json_encode($a_data);
        $s_result = $this->o_general->request('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $this->_a_config['access_token'], $s_data);
        $a_result = json_decode($s_result, true);
        // errcode = 0 为成功
        return $a_result;
    }

    // 获取模板列表
    public function get_template_list()
    {
        $a_param = [
            'access_token' => $this->_a_config['access_token'],
        ];
        $s_result = $this->o_general->request('https://api.weixin.qq.com/cgi-bin/template/get_all_private_template', $a_param, 'GET');
        $a_result = json_decode($s_result, true);
        return $a_result;
    }

    // 获得模板ID
    public function get_template_id($s_template_id)
    {
        $a_param = [
            'access_token' => $this->_a_config['access_token'],
            'template_id_short' => $s_template_id
        ];
        $s_result = $this->o_general->request('https://api.weixin.qq.com/cgi-bin/template/api_add_template', $a_param);
        $a_result = json_decode($s_result, true);
        return $a_result;
    }

    // 获取行业
    public function get_industry()
    {
        $a_param = [
            'access_token' => $this->_a_config['access_token'],
        ];
        $s_result = $this->o_general->request('https://api.weixin.qq.com/cgi-bin/template/get_industry', $a_param, 'GET');
        $a_result = json_decode($s_result, true);
        return $a_result;
    }

    // 设置行业
    public function set_industry($a_param = ['industry_id1' => '1', 'industry_id2' => '2'])
    {
        //$a_param['access_token'] = $this->_a_config['access_token'];
        $s_param = json_encode($a_param);
        return $this->o_general->request('https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token=' . $this->_a_config['access_token'], $s_param);
    }

    // 获取token
    public function access_token()
    {
        if ($_SERVER['REQUEST_TIME'] >= $this->_a_config['expires_in_token']) {
            // 如果是企业号用以下URL获取access_token
            // $s_url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";

            $a_param = [
                'grant_type' => 'client_credential',
                'appid' => $this->_a_config['id_app'],
                'secret' => $this->_a_config['app_secret'],
            ];
            $s_url = 'https://api.weixin.qq.com/cgi-bin/token';

            $s_result = $this->o_general->request($s_url, $a_param, 'GET');
            $a_result = json_decode($s_result, true);
            if (isset($a_result['access_token']) && !empty($a_result['access_token'])) {
                if (file_exists(PROJECTPATH . "/config/{$this->_s_config_file}.php")) {
                    require(PROJECTPATH . "/config/{$this->_s_config_file}.php");
                } else {
                    exit('配置文件不存在');
                }
                $this->_a_config['access_token'] = $a_result['access_token'];
                $this->_a_config['expires_in_token'] = $_SERVER['REQUEST_TIME'] + $a_result['expires_in'];
                $s_str = '<?php' . PHP_EOL . '$a_config_wx_template = [' . PHP_EOL;
                foreach ($this->_a_config as $s_k => $m_u) {
                    $s_str .= "\t'{$s_k}' => '{$m_u}'," . PHP_EOL;
                }
                $s_str .= ']' . PHP_EOL . '?>';
                file_put_contents(PROJECTPATH . "/config/{$this->_s_config_file}.php", $s_str);
            }
        }
    }

    // 设置配置文件名
    public function set_config_file($s_config_file)
    {
        $this->_s_config_file = $s_config_file;
    }

    // 公共参数设置
    private function _config()
    {
        $a_config_wx_template = [];
        $this->_s_config_file = rtrim($this->_s_config_file, '.php');
        if (file_exists(PROJECTPATH . "/config/{$this->_s_config_file}.php")) {
            require(PROJECTPATH . "/config/{$this->_s_config_file}.php");
        } else {
            exit('配置文件不存在');
        }
        $this->_a_config = $a_config_wx_template;
    }
}