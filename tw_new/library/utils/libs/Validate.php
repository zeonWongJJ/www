<?php
/**
 * 数据验证处理
 *
 * @copyright 柒度信息科技
 * @author rusice 李锐钊 <liruizhao970302@outlook.com>
 */
namespace utils;

class Validate
{
    /**
     * 类型提示数据
     * @var array
     */
    private static $typeMsg = [
        'chinese'   =>  ':attr 必须是中文',
        'email'     =>  ':attr 必须是邮件地址',
        'json'      =>  ':attr 必须是json数据',
        'length'    =>  ':attr 长度必须在 :arg',
        'number'    =>  ':attr 必须是数字',
        'phone'     =>  ':attr 必须是手机号码',
        'required'  =>  ':attr 必须',
        'time'      =>  ':attr 不是合法的时间',
        'url'       =>  ':attr 不是合法的url地址',
        'utf8'      =>  ':attr 必须是utf8编码',
        'max'       =>  ':attr 长度不能大于 :arg'
    ];

    /**
     * 验证出错信息存放
     * @var array
     */
    protected $_message = [];

    /**
     * @var array
     */
    protected $_fields = [];

    public function setField($fields)
    {
        $this->_fields = $fields;
        return $this;
    }

    /**
     * 验证字段
     * @param $data
     * @param array $rules
     * @return bool|array
     */
    public function check($data, array $rules)
    {
        // 'name' => 'required|max:25'
        foreach ($rules as $field => $rule) {
            if (isset($data[$field])) {
                $_rules = explode('|', $rule);
                foreach ($_rules as $_rule) {
                    $temp = explode(':', $_rule);
                    $_fuck_what = $temp[0];
                    $validtor = __NAMESPACE__ . '\validate\\' . ucfirst($_fuck_what);
                    unset($temp[0]);
                    if (!$temp) {
                        $result = $validtor::check($data[$field]);
                    } else {
                        $result = $validtor::check($data[$field], ...$temp); // 执行验证并传入参数
                    }

                    // 记录验证错误信息
                    if (!$result) {
                        $this->_message[] = $this->getErrorMsg($_fuck_what, $field);
                    }
                }
            }
        }

        return $this->_message ?: true;
    }

    /**
     * 获取认证失败的信息
     * @param $rule
     * @param $field
     * @return string
     */
    private function getErrorMsg($rule, $field)
    {
        $field = $this->_fields[$field] ?? $field;
        if (isset(self::$typeMsg[$rule])) {
            return str_replace(':attr', $field, self::$typeMsg[$rule]);
        }
        return "{$field}未通过验证";
    }
}