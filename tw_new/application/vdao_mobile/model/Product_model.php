<?php

class Product_model extends TW_Model
{

    function __construct()
    {
        parent:: __construct();
    }

    // 产品综合分类
    public function categories($i_one = false, $s_second = false)
    {
        // 一级
        $a_data['prot'] = $this->db->limit(0, 999999999)->get('pro', ['pro_pid' => 0, 'is_show' => 1], 'pro_pid,pro_name,pro_id');
        if ($i_one == false) {
            $a_cate = $this->db->get_row('pro', ['pro_pid' => 0, 'is_show' => 1], 'pro_id,pro_name,pro_pid');
            //如果第二个参数没有值，默认将二级分类选择第一个值
            $s_second = $a_cate['pro_id'];
        } else {
            $a_cate   = $this->db->get_row('pro', ['pro_id' => $i_one, 'is_show' => 1], 'pro_id,pro_name,pro_pid');
            $s_second = $a_cate['pro_id'];
        }
        //本来判断第一级分类然后获取写死第二级分类
        $a_data['second'] = $this->db->limit(0, 999999999)->get('pro', ['pro_pid' => $a_cate['pro_id'], 'is_show' => 1], 'pro_id,pro_pid,pro_name');
        $a_produ          = $this->db->limit(0, 999999999)->get('product', ['pro_show' => 1]);
        foreach ($a_data['second'] as $key => $value) {
            // 2级的产品数量
            $a_data['yon'][$key] = 0;
            foreach ($a_produ as $produ) {
                if ($value['pro_id'] == $produ['proid_id_2']) {
                    $a_data['yon'][$key] += 1;
                }
            }
        }
        //第三级分类
        $a_data['third'] = $this->db->limit(0, 999999999)->get('pro', ['proid' => 3, 'is_show' => 1], 'pro_pid,pro_name,pro_id');
        foreach ($a_data['third'] as $k => $val) {
            // 3级的产品数量
            $a_data['san'][$k] = 0;
            foreach ($a_produ as $produ) {
                if ($val['pro_id'] == $produ['proid_id_2']) {
                    $a_data['san'][$k] += 1;
                }
            }
        }

        return $a_data;
    }

    // 产品综合分类

    /** @param  [type] $i_one1 [1级分类]
     * @param  [type] $i_one2 [2级分类]
     * @param  [type] $i_one3 [3级分类]
     */
    public function product_classification($i_one1, $i_one2, $i_one3)
    {
        // 显示分类
        if (empty($i_one2)) {
            $pro = $this->db->get('pro', ['proid' => 1, 'is_show' => 1], '', '', 0, 99999999);
        } else {
            if (!empty($i_one3)) {
                $pro = $this->db->get('pro', ['pro_pid' => $i_one2, 'is_show' => 1], '', '', 0, 99999999);
            } else {
                $pro = $this->db->get('pro', ['pro_pid' => $i_one1, 'is_show' => 1], '', '', 0, 99999999);
            }
        }
        return $pro;
    }

    /**
     * 产品综合列表
     * @param  [type] $i_one1   [1级分类]
     * @param  [type] $i_one2   [2级分类]
     * @param  [type] $i_one3   [3级分类]
     * @param  [type] $a_name   [搜索内容]
     * @param  [type] $i_order  [排序]
     * @param  [type] $i_dada   [达达配送]
     * @param  [type] $page     [页]
     */
    public function product_list($i_one1, $i_one2, $i_one3, $a_name, $i_order, $i_dada, $page)
    {
        // 显示全部的产品
        // 先设置默认从第一页开始
        $i_page = $page;
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        $a_where = "`pro_show` = 1";
        // 判断有没有选择分类产品 | 有就显示分类到的产品 | 没就全部
        if (!empty($i_one2)) {
            if (empty($i_one3)) {
                $a_where .= ($a_where ? ' AND ' : '') . "`proid_id_2` = $i_one2";
            } else {
                $a_where .= ($a_where ? ' AND ' : '') . "`proid_id_3` = $i_one3";
            }
        } else {
            if (empty($i_one1)) {

            } else {
                $a_where .= ($a_where ? ' AND ' : '') . "`proid_id_1` = $i_one1";
            }
        }
        if (!empty($a_name)) {
            $a_where .= ($a_where ? ' AND ' : '') . "`product_name` LIKE '%$a_name%'";
        }
        if (!empty($i_dada)) {
            $a_where .= ($a_where ? ' AND ' : '') . "`goods_stye` = '1'";
        }
        // 判断有没有搜索的产品 | 有就显示搜索到的产品 | 没就全部

        $i_total = $this->db->get_total('product');
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);
        // 筛选
        if (!empty($i_order)) {
            if ($i_order == 1) {
                $a_order = ['b.pingl' => 'desc'];
            } else if ($i_order == 2) {
                $a_order = ['d.number' => 'desc'];
            } else if ($i_order == 3) {
                $a_order = ['a.product_id' => 'desc'];
            }
        }

        $a_data = $this->db->from('product as a')
            ->join('comment_product as b', ['a.product_id' => 'b.product_id'])
            ->join('product_number as d', ['a.product_id' => 'd.product_id'])
            ->where('a.product_id in (select product_id from ' . $this->db->get_prefix() . 'prod_sto where prod_show =1)', null, false)
            ->get('', $a_where, '', $a_order);
        // echo $this->db->get_sql();
        // 验证是否超出最大页数
        if ($page > ceil($i_total / $i_prow)) {
            return [];
        } else {
            return $a_data;
        }
    }

    /**
     * @param  [type] $name   [搜索关键字]
     */
    public function search($name)
    {

        $a_where = "";
        if (!empty($name)) {
            $a_where = [
                'pro_show'          => 1,
                'product_name LIKE' => '%' . $name . '%',
            ];
        }
        $product = $this->db->where('product_id in (select product_id from ' . $this->db->get_prefix() . 'prod_sto where prod_show =1)', null, false)
            ->limit(0, 999999)
            ->get('product', $a_where);
        // echo $this->db->get_sql();exit;
        return $product;
    }

    // 算好评率
    public function comment()
    {
        $a_comm = $this->db->limit(0, 99999999999)->get('comment_product');
        foreach ($a_comm as $key => $value) {
            $ping = intval($value['hao'] / ($value['hao'] + $value['zhon'] + $value['cha']) * 100);
            $this->db->update('comment_product', ['pingl' => $ping], ['product_id' => $value['product_id']]);
        }
    }

    //返回产品信息
    public function goods_list($cateid = 0, $start = 0, $end = 5)
    {
        //产品列表
        $a_where = [
            'a.pro_show'   => 1,
            'a.goods_stye' => 1,

        ];
        if ($cateid > 0) {
            $a_where['a.proid_id_1'] = $cateid;
        }
        $a_sele = "a.product_id,a.product_name,a.antistop,a.pro_details,a.proid_id_1,a.pro_img,b.pingl,d.number,a.supply_time";
        $a_data = $this->db->from('product as a')
            ->join('comment_product as b', ['a.product_id' => 'b.product_id'])
            ->join('product_number as d', ['a.product_id' => 'd.product_id'])
            ->where('a.product_id in (select product_id from ' . $this->db->get_prefix() . 'prod_sto where prod_show =1)', null, false)
            ->limit($start, $end)
            ->get('', $a_where, $a_sele, ['d.number' => 'desc', 'a.order' => 'asc']);
        //查询相对的时间
        $a_time_name = $this->db->get('time');
        foreach ($a_time_name as $time) {
            $checkDayStr = date('Y-m-d', time());
            $startTime   = strtotime($checkDayStr . $time['start_time'] . ":00");
            $endTime     = strtotime($checkDayStr . $time['end_tiem'] . ":00");
            if ($startTime <= time() && $endTime > time()) {
                $adata['time'][] = $time['time_id'];
            }
        }

        //处理产品数据
        if ($a_data) {
            foreach ($a_data as $key => $value) {
                $supply_time_arr = explode(',', trim($value['supply_time']));
                if (empty($adata['time'])) {
                    $value['in_sale'] = 2;
                } else {
                    if (array_intersect($adata['time'], $supply_time_arr)) {
                        //in_sale =1 在售产品
                        $value['in_sale'] = 1;
                    } else {
                        $value['in_sale'] = 2;
                    }
                }

                $value['prod_price'] = $this->db->get_row('price', ['price >' => 0, 'product_id' => $value['product_id']], 'price', ['price' => 'asc']);

                //价格
                $prod[$key] = $value;
            }
        }
        return $prod;
    }

    //返回某个产品的杯型信息
    public function get_attr_type($pid = 0)
    {
        $ooo = [];

        $s_sele = "'.$this->db->get_prefix().'attributive.attri_name,'.$this->db->get_prefix().'product_att.attri_id";
        $a_data = $this->db->from('attributive ')
            ->join('product_att ', [$this->db->get_prefix() . 'product_att.stye' => $this->db->get_prefix() . 'attributive.attri_id'])
            ->limit(0, 9999999)
            ->get('', [$this->db->get_prefix() . 'attributive.show' => 1, $this->db->get_prefix() . 'product_att.product_id' => $pid], $s_sele);
        if ($a_data) {
            foreach ($a_data as $k => $val) {
                $a_attri_id  = explode(',', $val['attri_id']);
                $val['list'] = $this->db->limit(0, 99999999)->where_in('attri_id', $a_attri_id)->get('attributive', ['show' => 1]);
                $ooo[$k]     = $val;

            }

        }


        return $ooo;
    }
}
