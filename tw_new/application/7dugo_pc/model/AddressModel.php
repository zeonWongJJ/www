<?php

namespace model;

class AddressModel extends \TW_Model
{
    public function __construct()
    {
        $this->tw = $this->db->get_prefix();
    }

    /**
     * [查询地址信息]
     * @param  [userid]  [用户id]
     * @return [array]   [用户地址数组]
     */
    public function address_data($userid)
    {


        $a_where = ['member_id' => $userid];
        //筛选条件
        $a_order = ['is_default' => 'desc'];
        //根据 默认 倒叙排序
        $a_fields = 'address_id,member_id,true_name,address,tel_phone,mob_phone,is_default,area_id,city_id';
        //地址用到的字段
        $a_result = $this->db->from('address')
            ->select($a_fields)
            ->where($a_where)
            ->order_by($a_order)
            ->get();
        return $a_result;

    }

    /**
     * [邮箱或手机 星号隐藏 ]
     * @param  [type]  [类型:手机|邮箱]
     * @return [String] [返回 手机|邮箱]
     */
    public function address_dispose($type, $string)
    {

        switch ($type) {
            case 'mobile':
                $star_mobile_number = substr_replace($string, '****', 3, 4);
                return $star_mobile_number;
            case 'email':
                $star_email = $this->email_dispose($string);
                return $star_email;
        }
    }

    /**
     * [邮箱星号处理]
     * @param  [string]  [邮箱字符串]
     * @return [string]  [处理好后的字符串]
     */
    public function email_dispose($email_string)
    {

        $email_array  = explode("@", $email_string);
        $prefix_email = $email_array[0];
        //邮箱前缀
        $suffix_email = '@' . $email_array[1];
        //邮箱后缀
        $email_count = strlen($email_array[0]);
        //邮箱前缀位数
        switch ($email_count) {
            case 5:
                $star_email = substr_replace($prefix_email, '****', 1, 3);
                return $star_email . $suffix_email;
            case 6:
                $star_email = substr_replace($prefix_email, '****', 1, 4);
                return $star_email . $suffix_email;
            case $email_count > 6:
                $prefix     = floor($email_count / 2) - 1;
                $star_email = substr_replace($prefix_email, '****', $prefix, 4);
                return $star_email . $suffix_email;
        }
    }

    /**
     * [ajax-查询地址数据]
     * @param  [int]  [address_id]
     * @return [array][地址数据]
     */
    public function get_address($address_id)
    {

        $user_id        = $_SESSION['user_id'];
        $a_fields       = 'address_id,member_id,true_name,' . $this->tw . 'area.area_id,city_id,address,tel_phone,mob_phone,is_default,area_deep';
        $a_where        = ['member_id' => $user_id, 'address_id' => $address_id];
        $a_address_data = $this->db->from('address')
            ->select($a_fields)
            ->join('area', [$this->tw . 'area.area_id' => $this->tw . 'address.area_id'])
            ->where($a_where)
            ->order_by($a_order)
            ->get_row();

        if (count($a_address_data) > 1) {
            $area_array['area_id']   = $a_address_data['area_id'];
            $area_array['area_deep'] = $a_address_data['area_deep'];
            // $area_data=$this->get_area($area_array);
            // $a_address_data['area']=$area_data;
            // var_dump($a_address_data);
            return $a_address_data;
        } else {
            return false;
        }
    }

    /**
     * [删除地址信息]
     * @param  [int]  [address_id]
     * @return [int]  [1|0] 成功与否
     */
    public function delete_address($address_id)
    {

        $user_id    = $_SESSION['user_id'];
        $a_where    = ['address_id' => $address_id, 'member_id' => $user_id];
        $status_row = $this->db->where($a_where)
            ->delete('address');
        // echo $this->db->get_sql();
        return $status_row;
    }
    // /**
    //  * [查找地区- 数据库]
    //  * @param  [int]  [area_id 地区id]
    //  * @return [array][地区的ID树 与 地区名]
    //  */
    // public function get_area($area_array)
    // {
    //     $a_fields = "area_id,area_name,area_parent_id,area_region";
    //     $a_where = ['area_id' => $area_array['area_id']];
    //     for (; $area_array['area_deep'] >= 1; $area_array['area_deep']--) {
    //         $a_area_data[$area_array['area_deep']] = $this->db->from('area')
    //                                                           ->select($a_fields)
    //                                                           ->where($a_where)
    //                                                           ->get_row();
    //         $a_where = ['area_id' => $a_area_data[$area_array['area_deep']]['area_parent_id']];
    //     }
    //     // var_dump($a_area_data);
    //     ksort($a_area_data);
    //     return $a_area_data;
    // }

    /**
     * [查询所有地址]
     * @return [array] [所有地址数据]
     */
    public function select_export_address()
    {

        $order_by = ['area_deep' => 'asc', 'area_parent_id' => 'asc'];
        $data     = $this->db->order_by($order_by)->limit(0, 99999999)->get('area');
        foreach ($data as $key => $value) {
            $all_data_sort[$value['area_id']]['area_name']      = $value['area_name'];
            $all_data_sort[$value['area_id']]['area_parent_id'] = $value['area_parent_id'];
            $all_data_sort[$value['area_id']]['area_deep']      = $value['area_deep'];
        }
        // echo $this->db->get_sql();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die;
        foreach ($all_data_sort as $k => $v) {
            $small_area = array('area_name' => $v['area_name'], 'area_parent_id' => $v['area_parent_id'], 'area_deep' => $v['area_deep'], 'area_id' => $k);
            if ($v['area_deep'] == 1) {
                $result['first'][$k] = $small_area;
            } else {
                if ($v['area_deep'] == 2) {
                    $result['second'][$v['area_parent_id']][$k] = $small_area;
                } else {
                    if ($v['area_deep'] == 3) {
                        // $top=$all_data_sort[$v['area_parent_id']]['area_parent_id'];
                        $result['third'][$v['area_parent_id']][$k] = $small_area;
                    }
                }
            }
        }
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        // $json_result['data']=$result;
        // var_dump($json_result);
        $json_data = json_encode($result);
        // var_dump($json_result);
        $file_put_status = file_put_contents(JSDATA, $json_data);
    }

    /**
     * [获取三级地址名]
     * @param  [array]  [a_grade_address 该用户所有三级地址ID]
     * @return [array]  [三级地址数组字符串]
     */
    public function get_three_grade_address($a_grade_address)
    {
        $a_where_or = "";
        foreach ($a_grade_address as $key => $value) {
            $a_where_or .= "third.area_id=" . $value['address_detail'] . " and third.area_parent_id=second.area_id and second.area_parent_id=first.area_id  or ";
        }
        //去掉最后的or
        $a_where_or = substr($a_where_or, 0, strlen($a_where_or) - 3);
        $s_fields   = 'third.area_id as third_id,third.area_name as third_name,second.area_name as second_name,first.area_name as first_name';
        // $arr= $this->db->where($a_where_or)->select($s_fields)->from(['area'=>'third', 'area'=>'second'])->get();
        $sql          = 'select ' . $s_fields . ' from ' . $this->tw . 'area third,' . $this->tw . 'area second,' . $this->tw . 'area first where ' . $a_where_or;
        $a_grade_data = $this->db->query($sql);
        foreach ($a_grade_data as $a_grade_value) {
            $a_grade_result[$a_grade_value['third_id']] = $a_grade_value;
        }
        return $a_grade_result;
    }

    /**$this->tw.'.'
     * [更新收获地址]
     * @param  [array]  [POST提交的数据]
     * @return [boolean][true|false 成功与否]
     */
    public function address_update($a_post_data)
    {

        $a_where['member_id']  = $_SESSION['user_id'];
        $a_where['address_id'] = $a_post_data['address_id'];
        // var_dump($a_post_data);
        // die;
        if ($a_post_data['is_default'] == 1) {
            $this->db->begin();
            $result = $this->db->update('address', $a_post_data, $a_where);
            $data   = $this->set_default($a_where['address_id']);
        } else {
            $this->db->begin();
            //不是默认状态
            $result = $this->db->update('address', $a_post_data, $a_where);
        }
        if ($result > 0) {
            $this->db->commit();
            return 1;
        } else {
            $this->db->roll_back();
            return 0;
        }
    }

    /**
     * [ajax-地址设置默认]
     * @param  [int]  [address_id]
     * @return [int]  [0|2] 成功与否
     */
    public function set_default($address_id)
    {

        $user_id = $_SESSION['user_id'];
        $s_set   = "case when address_id  = " . $address_id . " then 1 else 0 end";
        $this->db->set('is_default', $s_set, false);
        $i_update = $this->db->update('address', '', ['member_id' => $user_id]);
        return $i_update;
    }

    /**
     * [scm_detail_infos 统计出库累计数据]
     * @param  [type]  [description]
     * @return [type]        [description]
     */
    public function address_add($a_post_data)
    {
        $a_post_data['member_id'] = $_SESSION['user_id'];
        if ($a_post_data['is_default'] == 1) {
            //如果新增的数据是默认状态
            $this->db->begin();
            $result = $this->db->insert('address', $a_post_data);
            $data   = $this->set_default($result);
            if ($result > 0) {
                $this->db->commit();
                return 1;

            } else {
                $this->db->roll_back();
                return 0;
            }

        } else {

            //不是默认状态
            $result = $this->db->insert('address', $a_post_data);
            if ($result > 0) {
                return 1;
            } else {
                return 0;
            }
        }

    }
}
