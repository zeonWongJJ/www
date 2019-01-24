<?php

namespace model;

/**
 * 用户模块
 */
class BillModel extends \TW_Model
{
    public function __construct()
    {
        parent:: __construct();
    }

    //将POST提交过来的数据插入数据
    public function bill()
    {
        // 接受购物车传过来的商品
        $a_goods = $this->general->post('goods');
        // 接受购物车传过来的数量
        $a_num = $this->general->post('num');


        //查询出商品的信息
        $s_field = 'store_id,store_name,goods_id,goods_name,goods_price,goods_image,keywords,have_gift,is_own_shop,goods_freight,goods_promotion_type,goods_promotion_price,deductible_point';
        $a_goods = $this->db->where_in('goods_id', $a_goods)->get('goods', '', $s_field);

        $a_str          = array();
        $i_goods_amount = 0;
        /*
        * 计算出总价格优惠价格店铺额价格
        * $sum 		  市场价总价格
        * $promotion  优惠价总价格
        * $price  	  店铺总价格
        * $freight    总运费
        */
        foreach ($a_goods as $key => $value) {
            $i_goods_amount += 1;
            $s_points       += $value['deductible_point'];
            if ($value['goods_promotion_type'] == 0) {
                $price[$value['store_id']] = $price[$value['store_id']] + $a_num[$key] * $value['goods_price'];
                $promotion                 += $a_num[$key] * $value['goods_price'];
                if (!in_array($value['store_id'], $a_str)) {
                    array_push($a_str, $value['store_id']);
                    $freight += $value['goods_freight'];
                }
            } else {
                $price[$value['store_id']] = $price[$value['store_id']] + $a_num[$key] * $value['goods_promotion_price'];
                $promotion                 += $a_num[$key] * $value['goods_promotion_price'];
                if (!in_array($value['store_id'], $a_str)) {
                    array_push($a_str, $value['store_id']);
                    $freight += $value['goods_freight'];
                }
            }
            $sum += $a_num[$key] * $value['goods_price'];
        }

        //多少件商品
        $a_res['goods_amount'] = $i_goods_amount;

        //总运费
        $a_res['freight'] = $freight;

        //优惠差价
        $a_res['privilege'] = $sum - $promotion;

        //总价格未加上运费
        $a_res['pricesum'] = $promotion;

        //总价格加上运费
        $a_res['pricesumfre'] = $promotion + $freight;

        //可以使用的积分
        $a_res['deductible_point'] = $s_points;

        // 将数据组装成页面需要输出的格式
        foreach ($a_goods as $key => $value) {
            if ($value['have_gift'] == 1) {
                $value['gift'] = $this->db->get_row('goods_gift', ['goods_id' => $value['goods_id']], 'gift_goodsid,gift_goodsname,gift_amount');
            }
            $a_res['data'][$value['store_id']]['goods'][]  = $value;
            $a_res['data'][$value['store_id']]['num'][]    = $a_num[$key];
            $a_res['data'][$value['store_id']]['store']    = $price[$value['store_id']];
            $a_res['data'][$value['store_id']]['store_id'] = $value['store_id'];
        }
        return $a_res;
    }

    //会员信息
    public function member()
    {
        $a_where = ['member_id' => $_SESSION['user_id']];
        $a_field = "member_points,available_predeposit";
        $a_data  = $this->db->get_row('member', $a_where, $a_field);
        return $a_data;
    }

    // 收货人的地址信息
    public function address()
    {
        $a_address = $this->db->get('address', ['member_id' => $_SESSION['user_id']], 'address_id,mob_phone,member_id,address,is_default,true_name,area_info');
        return $a_address;
    }

    // 跟新默认收货地址
    public function upaddress($s_address)
    {
        $this->db->update('address', ['is_default' => 0], ['member_id' => $_SESSION['user_id']]);
        $this->db->update('address', ['is_default' => 1], ['member_id' => $_SESSION['user_id'], 'address_id' => $s_address]);
        $a_data   = $this->db->get_row('address', ['member_id' => $_SESSION['user_id'], 'address_id' => $s_address], 'address,true_name,mob_phone,area_info');
        $a_res[0] = $a_data['area_info'] . ' ' . $a_data['address'];
        $a_res[1] = $a_data['true_name'];
        //手机号码隐藏部分信息
        $a_res[2] = substr($a_data['mob_phone'], 0, 3) . '****' . substr($a_data['mob_phone'], -4);
        return $a_res;
    }

    //查询出地区的信息

    public function addarea()
    {
        $s_receving  = $this->general->post('receving');
        $i_area_top  = $this->general->post('area_top');
        $i_area_city = $this->general->post('area_city');
        $i_area_town = $this->general->post('area_town');
        $s_detailed  = $this->general->post('detailed');
        $s_phone     = $this->general->post('phone');
        $s_tel       = $this->general->post('tel');

        if (!empty($s_receving) && !empty($i_area_top) && !empty($i_area_city) && !empty($i_area_town) && !empty($s_detailed) && !empty($s_phone)) {
            $a_res = $this->db->where_in('area_id', [$i_area_top, $i_area_city, $i_area_town])->get('area', '', 'area_name');
            foreach ($a_res as $key => $value) {
                $area_info .= $value['area_name'];
                $area_info .= " ";
            }
            $a_where = ['member_id' => $_SESSION['user_id'],
                        'true_name' => $s_receving,
                        'area_id'   => $i_area_town,
                        'city_id'   => $i_area_city,
                        'area_info' => $area_info,
                        'address'   => $s_detailed,
                        'tel_phone' => $s_tel,
                        'mob_phone' => $s_phone];
            $i_res   = $this->db->insert('address', $a_where);
            if ($i_res > 0) {
                $a_res = $this->db->get_row('address', ['member_id' => $_SESSION['user_id']], 'address_id,mob_phone,member_id,address,is_default,true_name,area_info', ['address_id' => 'desc']);
                return $a_res;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    //添加新的地址

    public function del_address()
    {
        $s_del_address = $this->general->post('del_address');
        $i_res         = $this->db->delete('address', ['member_id' => $_SESSION['user_id'], 'address_id' => $s_del_address]);
        if ($i_res) {
            return $i_res;
        } else {
            return $i_res;
        }
    }

    //删除地址

    public function update_address()
    {
        $s_del_address = $this->general->post('update_address');

        $address = $this->db->get_row('address', ['member_id' => $_SESSION['user_id'], 'address_id' => $s_del_address], 'address_id,true_name,mob_phone,member_id,address,city_id,area_id,mob_phone,tel_phone');

        $a_data = $this->site($address['city_id'], $address['area_id']);

        $city_sum   = $this->area($a_data['barea_id']);
        $county_sum = $this->area($address['city_id']);

        $address['province']    = $a_data['bname'];
        $address['province_id'] = $a_data['barea_id'];
        $address['county']      = $a_data['cname'];
        $address['cityname']    = $a_data['cityname'];
        $address['city_sum']    = $city_sum;
        $address['county_sum']  = $county_sum;

        return $address;
    }

    // 修改地址

    private function site($city, $area)
    {
        $s_fields = 'a.area_name as cityname,b.area_name as bname,b.area_id as barea_id,c.area_name as cname';
        $a_data   = $this->db->select($s_fields, false)
            ->from('area as a')
            ->join('area as b', ['a.area_parent_id' => 'b.area_id'])
            ->join('area as c', ['a.area_id' => 'c.area_parent_id'])
            ->get_row('', ['a.area_id' => $city, 'c.area_id' => $area]);
        return $a_data;
    }

    // 根据城市id查出市和县的信息

    public function area($area_id = 0)
    {
        $a_data = $this->db->get('area', ['area_parent_id' => $area_id], 'area_id,area_name', ['area_sort' => 'asc']);
        return $a_data;
    }

    //修改数据库的数据

    public function alter_address()
    {
        $s_receving  = $this->general->post('receving');
        $i_area_top  = $this->general->post('area_top');
        $i_area_city = $this->general->post('area_city');
        $i_area_town = $this->general->post('area_town');
        $s_detailed  = $this->general->post('detailed');
        $s_phone     = $this->general->post('phone');
        $s_tel       = $this->general->post('tel');
        $s_alterh    = $this->general->post('alterh');

        if (!empty($s_alterh) && !empty($s_receving) && !empty($i_area_top) && !empty($i_area_city) && !empty($i_area_town) && !empty($s_detailed) && !empty($s_phone)) {
            $a_res = $this->db->where_in('area_id', [$i_area_top, $i_area_city, $i_area_town])->get('area', '', 'area_name');
            foreach ($a_res as $key => $value) {
                $area_info .= $value['area_name'];
                $area_info .= " ";
            }
            $a_where = ['member_id' => $_SESSION['user_id'], 'address_id' => $s_alterh];
            $a_data  = ['true_name' => $s_receving,
                        'area_id'   => $i_area_town,
                        'city_id'   => $i_area_city,
                        'area_info' => $area_info,
                        'address'   => $s_detailed,
                        'tel_phone' => $s_tel,
                        'mob_phone' => $s_phone];
            $i_res   = $this->db->update('address', $a_data, $a_where);
            if ($i_res > 0) {
                $a_res = $this->db->get_row('address', $a_where, 'address_id,is_default,mob_phone,member_id,address,is_default,true_name,area_info', ['address_id' => 'desc']);
                return $a_res;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }


}

?>
