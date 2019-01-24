<?php

/**
 * 全局变量，通用类库
 */
class TW_General
{

    // 对象转数组的临时存储变量
    private $_a_object_to_array = [];

    public function __construct()
    {
        global $o_security;

        $this->security =& $o_security;
    }

    /**
     * 获取$_GET中的参数
     */
    public function get($s_index = NULL, $b_xss_clean = true)
    {
        if ($s_index === NULL AND !empty($_GET)) {
            $a_get = array();
            foreach (array_keys($_GET) as $s_key) {
                $a_get[$s_key] = $this->_fetch_from_array($_GET, $s_key, $b_xss_clean);
            }
            return $a_get;
        }

        return $this->_fetch_from_array($_GET, $s_index, $b_xss_clean);
    }

    private function _fetch_from_array(&$a_array, $s_index = '', $b_xss_clean = true)
    {
        if (empty($s_index)) {
            if ($b_xss_clean) {
                $a_arr = [];
                foreach ($a_array as $s_key => $s_val) {
                    $a_arr[$s_key] = $this->security->xss_clean($a_array[$s_key]);
                }
                return $a_arr;
            }
            return $a_array;
        }
        if (!isset($a_array[$s_index])) {
            return FALSE;
        }

        if ($b_xss_clean === TRUE) {
            return $this->security->xss_clean($a_array[$s_index]);
        }

        return $a_array[$s_index];
    }

    // 设置COOKIE，支持数组参数批量设置

    /**
     * 获取$_POST中的参数
     */
    public function post($s_index = NULL, $b_xss_clean = true)
    {
        if ($s_index === NULL AND !empty($_POST)) {
            $a_post = array();
            foreach (array_keys($_POST) as $s_key) {
                $a_post[$s_key] = $this->_fetch_from_array($_POST, $s_key, $b_xss_clean);
            }
            return $a_post;
        }

        return $this->_fetch_from_array($_POST, $s_index, $b_xss_clean);
    }

    // 获取COOKIE数据

    public function set_cookie($s_name = '', $u_value = '', $i_expire = '', $s_domain = '', $s_path = '/', $s_prefix = '', $b_secure = FALSE)
    {
        if (is_array($s_name)) {
            foreach (array('value', 'expire', 'domain', 'path', 'prefix', 'secure', 'name') as $item) {
                if (isset($s_name[$item])) {
                    $item = $s_name[$item];
                }
            }
        }

        if ($s_prefix == '' AND get_config_item('cookie_prefix') != '') {
            $s_prefix = get_config_item('cookie_prefix');
        }
        if ($s_domain == '' AND get_config_item('cookie_domain') != '') {
            $s_domain = get_config_item('cookie_domain');
        }
        if ($s_path == '/' AND get_config_item('cookie_path') != '/') {
            $s_path = get_config_item('cookie_path');
        }
        if ($b_secure == FALSE AND get_config_item('cookie_secure') != FALSE) {
            $b_secure = get_config_item('cookie_secure');
        }

        if (!is_numeric($i_expire)) {
            $i_expire = $_SERVER['REQUEST_TIME'] - 86500;
        } else {
            $i_expire = ($i_expire > 0) ? $_SERVER['REQUEST_TIME'] + $i_expire : 0;
        }

        setcookie($s_prefix . $s_name, $u_value, $i_expire, $s_path, $s_domain, $b_secure);
    }

    // 获取IP地址

    public function cookie($s_index = '', $b_xss_clean = FALSE)
    {
        if (get_config_item('cookie_prefix') != '') {
            $s_index = get_config_item('cookie_prefix') . $s_index;
        }
        return $this->_fetch_from_array($_COOKIE, $s_index, $b_xss_clean);
    }

    // 数据处理

    public function get_ip()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $s_ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $s_ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR')) {
            $s_ip = getenv('REMOTE_ADDR');
        } else {
            $s_ip = '0.0.0.0';
        }
        return $s_ip;
    }

    // 替换BASE64中的/字符，以便在URL中使用

    public function base64_convert($s_str, $b_convert = false)
    {

        if ($b_convert) {
            $s_str = $this->base32_decode($s_str);
        } else {
            $s_str = $this->base32_encode($s_str);
        }
        return $s_str;
    }

    public function base32_decode($s_str)
    {
        $s_code  = '';
        $i_value = 0;
        $i_bit   = 0;

        for ($i_i = 0, $i_j = strlen($s_str); $i_i < $i_j; $i_i++) {
            $i_value <<= 5;
            if ($s_str[$i_i] >= 'a' && $s_str[$i_i] <= 'z') {
                $i_value += (ord($s_str[$i_i]) - 97);
            } elseif ($s_str[$i_i] >= '2' && $s_str[$i_i] <= '7') {
                $i_value += (24 + $s_str[$i_i]);
            } else {
                exit(1);
            }

            $i_bit += 5;
            while ($i_bit >= 8) {
                $i_bit   -= 8;
                $s_code  .= chr($i_value >> $i_bit);
                $i_value &= ((1 << $i_bit) - 1);
            }
        }
        return $s_code;
    }

    public function base32_encode($s_str)
    {
        $s_str32 = 'abcdefghijklmnopqrstuvwxyz234567';
        $s_code  = '';
        $i_value = 0;
        $i_bit   = 0;

        for ($i_i = 0, $i_j = strlen($s_str); $i_i < $i_j; $i_i++) {
            $i_value <<= 8;
            $i_value += ord($s_str[$i_i]);
            $i_bit   += 8;

            while ($i_bit >= 5) {
                $i_bit   -= 5;
                $s_code  .= $s_str32[$i_value >> $i_bit];
                $i_value &= ((1 << $i_bit) - 1);
            }
        }

        if ($i_bit > 0) {
            $i_value <<= (5 - $i_bit);
            $s_code  .= $s_str32[$i_value];
        }

        return $s_code;
    }

    // 邮箱正则表达式

    public function is_mail($s_mail)
    {
        if (preg_match("/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/is", $s_mail)) {
            return true;
        }
        return false;
    }

    // 下划线转驼峰

    public function batch_to_underline(array $a_data)
    {
        $a_result = [];
        foreach ($a_data as $s_key => $u_item) {
            if (is_array($u_item) || is_object($u_item)) {
                $a_result[$this->hump_to_underline($s_key)] = $this->batch_to_hump((array)$u_item);
            } else {
                $a_result[$this->hump_to_underline($s_key)] = $u_item;
            }
        }
        return $a_result;
    }

    // 驼峰转下划线

    public function hump_to_underline($s_string)
    {
        $s_string = preg_replace_callback('/([A-Z]{1})/', function ($a_matche) {
            return '_' . strtolower($a_matche[0]);
        }, $s_string);
        return $s_string;
    }

    // 批量下划线转驼峰
    public function batch_to_hump(array $a_data)
    {
        $a_result = [];
        foreach ($a_data as $s_key => $u_item) {
            if (is_array($u_item) || is_object($u_item)) {
                $a_result[$this->underline_to_hump($s_key)] = $this->batch_to_hump((array)$u_item);
            } else {
                $a_result[$this->underline_to_hump($s_key)] = $u_item;
            }
        }
        return $a_result;
    }

    // 批量驼峰转下划线

    public function underline_to_hump($s_string)
    {
        $s_string = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($a_matche) {
            return strtoupper($a_matche[2]);
        }, $s_string);
        return $s_string;
    }

    // 递归对象转数组

    public function object_to_array($o_object)
    {
        foreach ($o_object as $s_key => $u_val) {
            if (is_object($u_val)) {
                $this->object_to_array($u_val);
            } else {
                $this->_a_object_to_array[$s_key] = $u_val;
            }
        }
        return $this->_a_object_to_array;
    }

    // xml转数组，$mode两种模式，1：SIMPLE，2：PARSER
    public function xml_to_array($s_xml, $mode = 'SIMPLE')
    {
        $a_data = [];
        if ($mode == 'SIMPLE') {
            libxml_disable_entity_loader(true);
            $a_data = json_decode($this->json_encode(simplexml_load_string($s_xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        } else {
            // 创建 XML 解析器
            $u_parser = xml_parser_create();
            // 将 XML 数据解析到数组中
            xml_parse_into_struct($u_parser, $s_xml, $a_val, $a_index);
            // 释放解析器
            xml_parser_free($u_parser);

            foreach ($a_val as $s_key => $u_val) {
                if (isset ($u_val['tag']) && !empty($u_val['tag']) && isset($u_val['value'])) {
                    $a_data[strtolower($u_val['tag'])] = $u_val['value'];
                }
            }
        }
        return $a_data;
    }

    public function json_encode(array $a_data)
    {
        $a_data = $this->value_to_string($a_data);
        return json_encode($a_data);
    }

    // 返回随机字符串

    public function value_to_string(array $a_data)
    {
        foreach ($a_data as $u_key => $u_val) {
            if (is_array($u_val)) {
                $a_data[$u_key] = $this->array_to_string($u_val);
            } else {
                $a_data[$u_key] = strval($u_val);
            }
        }
        return $a_data;
    }

    // 递归处理数组数据，把类型全部转换成字符类型

    /** 发起请求
     * $s_mode 两个模式，1：FEIL，2：CURL
     * $b_cert 是否使用证书
     */
    public function request($s_url, $m_data = '', $s_method = 'POST', $s_mode = '', $m_header = NULL, $a_ssl = [], $a_proxy = [])
    {
        if (is_array($m_data)) {
            $m_data = http_build_query($m_data);
        }
        if ($s_mode == 'FILE') {
            $a_option = [
                'http' => [
                    'method'  => $s_method,
                    'header'  => empty($m_header) ? 'Content-type: application/x-www-form-urlencoded' : $m_header,
                    //生成URL-encode之后的请求字符串,就是?后的参数
                    'content' => $m_data
                ]
            ];
            // 创建资源流上下文
            $u_context = stream_context_create($a_option);
            $u_result  = file_get_contents($s_url, false, $u_context);
            $a_result  = $u_result;
            return $a_result;

        } else {

            $o_curl = curl_init();
            //超时时间
            curl_setopt($o_curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($o_curl, CURLOPT_RETURNTRANSFER, 1);

            //这里设置代理，如果有的话
            if (!empty($a_proxy)) {
                curl_setopt($o_curl, CURLOPT_PROXY, $a_proxy['ip']);
                curl_setopt($o_curl, CURLOPT_PROXYPORT, $a_proxy['port']);
            }

            curl_setopt($o_curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($o_curl, CURLOPT_SSL_VERIFYHOST, false);

            // 如果设置了证书
            if (!empty($a_ssl)) {
                //默认格式为PEM，可以注释
                curl_setopt($o_curl, CURLOPT_SSLCERTTYPE, 'PEM');
                curl_setopt($o_curl, CURLOPT_SSLCERT, $a_ssl['ssl_cert']);
                if (!empty($a_ssl['ssl_key'])) {
                    //默认格式为PEM，可以注释
                    curl_setopt($o_curl, CURLOPT_SSLKEYTYPE, 'PEM');
                    curl_setopt($o_curl, CURLOPT_SSLKEY, $a_ssl['ssl_key']);
                }
            }

            // 设置host
            if (is_array($m_header) && !empty($m_header)) {
                curl_setopt($o_curl, CURLOPT_HTTPHEADER, $m_header);
            }

            if ($s_method == 'POST') {
                curl_setopt($o_curl, CURLOPT_POST, 1);
                curl_setopt($o_curl, CURLOPT_POSTFIELDS, $m_data);
                curl_setopt($o_curl, CURLOPT_URL, $s_url);
            } else {
                curl_setopt($o_curl, CURLOPT_URL, $s_url . '?' . $m_data);
            }
            $u_data = curl_exec($o_curl);
            if (empty($u_data)) {
                return curl_errno($o_curl);
            }
            curl_close($o_curl);
            return $u_data;
        }
    }

    // 由于php的json_encode会把10.06转换成10.059999999999，所以重写此函数

    public function rand_string($i_length = 6, $s_string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
    {
        $a_result  = [];
        $i_str_len = strlen($s_string);
        for ($i_i = 0; $i_i < $i_length; $i_i++) {
            $a_result[] = $s_string[rand(0, $i_str_len)];
        }
        return implode('', $a_result);
    }

    /**
     * IP字符串到整形的互转
     *
     * @param string/int $ip
     * @param ENCODE/DECODE $operation
     * @return false/string
     */
    public function ip_convert($ip, $operation = 'DECODE')
    {
        if ('ENCODE' == $operation) {
            if (!$this->is_ip($ip)) {
                return false;
            }
            $ip    = explode('.', $ip);
            $covip = '';
            foreach ($ip as $i) {
                $covip .= substr('000' . $i, -3, 3);
            }
            return $covip;
        }
        if ('DECODE' == $operation) {
            if (!preg_match("/^[0-9]{9,12}$/iU", $ip)) {
                return false;
            }
            $len    = strlen($ip);
            $result = intval(substr($ip, $len - 9, 3)) . '.' . intval(substr($ip, $len - 6, 3)) . '.' . intval(substr($ip, $len - 3, 3));
            return intval(substr($ip, -$len, $len - 9)) . '.' . $result;
        }
    }

    /**
     * 判断是否IP
     *
     * @param string $ip
     * @return boolean
     */
    function is_ip($ip)
    {
        $chars = "/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/";
        if (preg_match($chars, $ip)) {
            return true;
        } else {
            return false;
        }
    }
}

?>
