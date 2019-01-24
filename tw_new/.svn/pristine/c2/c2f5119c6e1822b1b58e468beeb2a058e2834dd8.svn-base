<?php
defined('BASEPATH') OR exit('禁止访问！');

/**
 * MYSQL 数据库操作类，例：
 * $this->db->select(array('g.goods_id','g.goods_name'));
 * $this->db->from(array('goods' => 'g'));
 * $this->db->from('cart as c');
 * $this->db->where(array('g.goods_id' => 1, 'g.goods_name like ' => '%袋鼠%'));
 * $this->db->where(array('g.store_id' => 1));
 * $this->db->where_or(array('g.store_id' => 1));
 * $this->db->order_by(array('g.store_id' => 'desc'));
 * $this->db->limit(0, 1);
 * $a = $this->db->get();
 * $a = $this->db->where(array('g.store_id' => 1))->from(array('goods' => 'g'))->get();
 * $a = $this->db->insert('admin_log', array('content' => '测试哈哈', 'createtime' => 1, 'admin_name' => '管理', 'admin_id' => 100, 'url' => 'index'));
 * $a = $this->db->update('admin_log', array('ip' => '456'), array('id >' => 6830));
 * $a = $this->db->delete('admin_log', array('id >' => 6831));
 * $a = $this->db->get_total('admin_log', array('id <' => 6831));
 * $a = $this->db->get_row('admin_log', array('id <' => 6831));
 */
class TW_Mysql
{
    private $_s_server = '';        // mysql数据库主机地址:端口
    private $_s_user = '';            // 数据库用户名
    private $_s_password = '';        // 数据库密码
    private $_s_database = '';        // 数据库名
    private $_s_charset = 'UTF8';    // 数据库字符集
    private $_b_persistent = false;    // 是否持久连接
    private $_o_link;                // MySQL 连接标识
    private $_s_sql = '';            // SQL语句
    // 操作符
    private $_a_operator = ['=', '!=', '<>', '>', '<', '>=', '<=', 'LIKE'];
    private $_o_prepare;            // 保存预处理对象
    private $_a_prepare = [];        // 保存预处理数据
    private $_a_last_prepare = [];    // 保存最后一次预处理数据，以便生成调试SQL
    // 保存临时SQL数据
    private $_a_tmp_sql = [
        'field' => [],
        'from' => [],
        'condition' => '',
        'order_by' => '',
        'limit' => '',
        'set' => '',
        'group_by' => '',
        'join' => [],
        'having' => ''
    ];
    private $_a_config = [];        // 保存配置文件数据
    private $_s_init_db = 'db';        // 按配置文件的第几个数组信息连接数据库
    private $_s_prefix = '';        // 表名前缀
    // 预处理字段名增加后缀，防止条件中多次使用同一字段进行查询时会覆盖
    private $_a_prepare_suffix = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    // 是否执行sql语句
    private $_b_is_exec = true;
    // 是否开启在执行失败的时候抛出异常
    private $_b_is_throw = false;

    /**
     * 构造函数
     *
     * @param array $parameter
     * @return Mysql
     */
    public function __construct($i_index = NULL)
    {
        require(CONFIGPATH . '/config_database.php');

        $this->_s_init_db = get_config_item('init_db');
        $this->_a_config =& $a_db_config;
        if (!empty($i_index)) {
            $this->connect($i_index);
        } elseif (!empty($this->_s_init_db)) {
            $this->connect($this->_s_init_db);
        }
    }

    /**
     * 连接数据库
     */
    public function connect($i_index = NULL)
    {
        if (!isset($this->_a_config[$i_index])) {
            throw new Exception('数据库配置信息不存在！');
        }

        $this->_s_server = $this->_a_config[$i_index]['server'];
        $this->_s_user = $this->_a_config[$i_index]['user'];
        $this->_s_password = $this->_a_config[$i_index]['password'];
        $this->_s_database = $this->_a_config[$i_index]['database'];
        $this->_s_charset = $this->_a_config[$i_index]['charset'];
        $this->_b_persistent = $this->_a_config[$i_index]['persistent'];
        $this->_s_prefix = $this->_a_config[$i_index]['prefix'];

        if (empty($this->_s_server)) {
            throw new Exception('数据库DNS错误！');
        }
        if (empty($this->_s_user)) {
            throw new Exception('数据库用户错误！');
        }
        if (empty($this->_s_database)) {
            throw new Exception('数据库错误！');
        }
        if (empty($this->_s_password)) {
            throw new Exception('数据库密码不能为空！');
        }
        if ($this->_b_persistent) {
            try {
                $this->_o_link = new PDO("mysql:host={$this->_s_server};dbname={$this->_s_database}", $this->_s_user, $this->_s_password, [PDO::ATTR_PERSISTENT => true]);
            } catch (PDOException $e) {
                //throw new Exception('数据库连接失败: ' . $e->getMessage());
                exit('数据库连接失败!');
            }
        } else {
            try {
                $this->_o_link = new PDO("mysql:host={$this->_s_server};dbname={$this->_s_database}", $this->_s_user, $this->_s_password);
            } catch (PDOException $e) {
                throw new Exception('数据库连接失败: ' . $e->getMessage());
            }
        }
        if (!empty($this->_s_charset)) {
            $this->_o_link->query("SET NAMES '{$this->_s_charset}'");
        }

        return $this;
    }

    public function set_error_mode()
    {
        $this->_b_is_throw = true;
        $this->_o_link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * 获取全部查询结果
     */
    public function get($s_table = '', $u_condition = '', $u_field = '', $a_order = '', $i_start = 0, $i_end = 0)
    {

        $this->_build_sql($s_table, $u_condition, $u_field, $a_order, $i_start, $i_end);

        if ($this->_b_is_exec) {
            $this->_exec();
        } else {
            return $this->_s_sql;
        }
        $a_rs = $this->_o_prepare->fetchAll();

        // 清空临时数据
        $this->_clean_tmp_data();

        return $a_rs;
    }

    /**
     * 获取一行数据
     */
    public function get_row($s_table = '', $u_condition = '', $u_field = '', $a_order = '', $i_start = 0, $i_end = 0)
    {

        $this->_build_sql($s_table, $u_condition, $u_field, $a_order, $i_start, $i_end);

        if ($this->_b_is_exec) {
            $this->_exec();
        } else {
            return $this->_s_sql;
        }
        $a_rs = $this->_o_prepare->fetch();

        // 清空临时数据
        $this->_clean_tmp_data();

        return $a_rs;
    }

    /**
     * 获取SQL语句影响的行数
     */
    public function get_total($s_table = '', $u_condition = '', $i_start = 0, $i_end = 0)
    {

        $this->_a_tmp_sql['field'] = ['COUNT(*) AS numrows'];
        $this->_build_sql($s_table, $u_condition, '', '', $i_start, $i_end);

        if ($this->_b_is_exec) {
            $this->_exec();
        } else {
            return $this->_s_sql;
        }
        $a_rs = $this->_o_prepare->fetch();

        // 清空临时数据
        $this->_clean_tmp_data();

        if (isset($a_rs['numrows'])) {
            return $a_rs['numrows'];
        }
        return 0;
    }

    /**
     * 获取SQL语句影响的行数
     */
    public function get_count()
    {
        return $this->_o_prepare->rowCount();
    }

    /**
     * 获取表前缀
     */
    public function get_prefix($s_table = '')
    {
        if (empty($s_table)) {
            return $this->_s_prefix;
        } else {
            return $this->_s_prefix . $s_table;
        }
    }

    /**
     * 插入数据， 返回受 SQL 语句影响的行数
     */
    public function insert($s_table, $a_data)
    {
        $this->from($s_table);
        $this->_s_sql = "INSERT INTO " . join(',', $this->_a_tmp_sql['from']);
        $s_field = '';
        $s_value = '';
        foreach ($a_data as $s_key => $s_val) {
            $s_field .= " `{$s_key}`,";
            $s_value .= " :{$s_key},";
            $this->_a_prepare[':' . $s_key] = $s_val;
        }
        $this->_s_sql .= ' (' . rtrim($s_field, ',') . ') VALUES (' . rtrim($s_value, ',') . ' )';

        if ($this->_b_is_exec) {
            $this->_exec();
        } else {
            return $this->_s_sql;
        }

        // 清空临时数据
        $this->_clean_tmp_data();

        return $this->_o_link->lastInsertId();
    }

    /**
     * 一次插入多行数据， 返回受 SQL 语句影响的行数
     */
    public function inserts($s_table, $a_data)
    {
        $this->from($s_table);
        $this->_s_sql = "INSERT INTO " . join(',', $this->_a_tmp_sql['from']);
        $s_field = '';
        $s_value = '';
        if (!is_array($a_data)) {
            throw new Exception('参数格式错误！');
        }
        $i_i = 0;
        foreach ($a_data as $a_r_data) {
            if (!is_array($a_r_data)) {
                throw new Exception('参数格式错误！');
            }
            $s_value .= '(';
            foreach ($a_r_data as $s_key => $s_val) {
                if (!$i_i) {
                    $s_field .= " `{$s_key}`,";
                }
                $s_value .= "'{$s_val}',";
                $s_val;
            }
            $s_value = rtrim($s_value, ',') . '),';
            $i_i++;
        }
        $s_value = rtrim($s_value, ',');
        $this->_s_sql .= ' (' . rtrim($s_field, ',') . ') VALUES ' . $s_value;

        if ($this->_b_is_exec) {
            $this->_exec();
        } else {
            return $this->_s_sql;
        }

        // 清空临时数据
        $this->_clean_tmp_data();

        return $this->_o_prepare->rowCount();
    }

    /**
     * 更新数据，返回受 SQL 语句影响的行数
     */
    public function update($s_table, $a_data = NULL, $u_where = NULL)
    {
        $this->from($s_table);
        if (!empty($u_where)) {
            $this->where($u_where);
        }

        if (is_array($a_data)) {
            //$s_set = '';
            $s_value = '';
            foreach ($a_data as $s_key => $s_val) {
                //$s_set .= " `{$s_key}` = :{$s_key},";
                $this->set($s_key, $s_val);
            }
        }
        $this->_s_sql = "UPDATE " . join(',', $this->_a_tmp_sql['from']);
        $this->_s_sql .= ' SET ' . ltrim($this->_a_tmp_sql['set'], ' ,');
        if (!empty($this->_a_tmp_sql['condition'])) {
            $this->_s_sql .= ' WHERE ' . $this->_a_tmp_sql['condition'];
        }

        if ($this->_b_is_exec) {
            $this->_exec();
        } else {
            return $this->_s_sql;
        }

        // 清空临时数据
        $this->_clean_tmp_data();

        return $this->_o_prepare->rowCount();
    }

    // 处理 SET 语句
    public function set($s_field, $u_value, $b_protect = true)
    {
        // 清除上次的SQL语句
        $this->_s_sql = '';

        if ($b_protect) {
            $this->_a_tmp_sql['set'] .= " , `{$s_field}` = :{$s_field} ";
            $this->_a_prepare[':' . $s_field] = $u_value;
        } else {
            $this->_a_tmp_sql['set'] .= " , `{$s_field}`={$u_value}";
        }
        return $this;
    }

    /**
     * 删除数据，返回受 SQL 语句影响的行数
     */
    public function delete($s_table, $u_where = '')
    {
        $this->from($s_table);
        if (!empty($u_where)) {
            $this->where($u_where);
        }

        $this->_s_sql = "DELETE FROM " . join(',', $this->_a_tmp_sql['from']);
        if (!empty($this->_a_tmp_sql['condition'])) {
            $this->_s_sql .= ' WHERE ' . $this->_a_tmp_sql['condition'];
        }

        if ($this->_b_is_exec) {
            $this->_exec();
        } else {
            return $this->_s_sql;
        }

        // 清空临时数据
        $this->_clean_tmp_data();

        return $this->_o_prepare->rowCount();
    }

    /**
     * 设置查询字段，支持数组和字符串格式
     * $this->db->select('goods_id,goods_name');
     * $this->db->select(array('g.goods_id','g.goods_name'));
     * $this->db->select('g.goods_id,g.goods_name');
     */
    public function select($u_field = '*', $b_protect = true)
    {
        // 清除上次的SQL语句
        $this->_s_sql = '';

        if (is_array($u_field)) {
            foreach ($u_field as $u_key => $s_field) {
                if (is_int($u_key)) {
                    $this->_a_tmp_sql['field'][] = $this->_as($s_field, $b_protect);
                } else {
                    $this->_a_tmp_sql['field'][] = $b_protect ? $this->_field_protect($u_key) . ' AS ' . $s_field : "{$u_key} AS {$s_field}";
                }
            }
        } elseif (!empty($u_field)) {
            if ($u_field == '*') {
                $this->_a_tmp_sql['field'][] = $u_field;
            } else {
                $this->_a_tmp_sql['field'][] = $this->_as($u_field, $b_protect);
            }
        }
        return $this;
    }

    /**
     * 设置查询的表，支持字符串和数组格式，调用一次只能设置一个表，可以调用多次
     * $this->db->from(['goods' => 'g']);
     * $this->db->from('cart as c');
     */
    public function from($m_table)
    {
        // 清除上次的SQL语句
        $this->_s_sql = '';

        $this->_a_tmp_sql['from'][] = $this->_from($m_table);

        return $this;
    }

    /**
     * 生成 JOIN 语句
     */
    public function join($m_table, $u_condition, $s_type = 'LEFT', $s_relationship = 'AND')
    {
        $s_type = strtoupper($s_type);
        if (!in_array($s_type, ['LEFT', 'RIGHT', 'INNER'])) {
            TW:: debug('不支持的操作！');
        }
        $s_table = $this->_from($m_table);
        $i_cond_item = 0;
        $a_join = [];
        if (is_array($u_condition)) {
            /**
             * 因为预处理会导致返回的结果出现问题，联接的附表会（左联时的右表）返回空数据
             * foreach ($u_condition as $s_key => $s_val) {
             * $a_key = explode(' ', $s_key);
             * $s_prepare_name = ':' . $this->_prepare_name($this->_end_field($a_key[0]));
             * $this->_a_prepare[$s_prepare_name] = $s_val;
             * // 设置了运算符
             * if (isset($a_key[1]) && ! empty($a_key[1])) {
             * $a_key[1] = trim($a_key[1]);
             * if (in_array(strtoupper($a_key[1]), $this->_a_operator)) {
             * $a_join[$i_cond_item] .= $this->_field_protect($a_key[0]) . ' ' . $a_key[1] . ' ' . $s_prepare_name;
             * } else {
             * throw new Exception('尚不支持此运算符！');
             * }
             * } else {// 未设置运算符
             * $a_join[$i_cond_item] .= $this->_field_protect($s_key) . " = {$s_prepare_name}";
             * }
             * $i_cond_item++;
             * }
             */
            foreach ($u_condition as $s_key => $s_val) {
                $a_key = explode(' ', $s_key);
                // 设置了运算符
                if (isset($a_key[1]) && !empty($a_key[1])) {
                    $a_key[1] = trim($a_key[1]);
                    if (in_array(strtoupper($a_key[1]), $this->_a_operator)) {
                        if (!isset($a_join[$i_cond_item])) {
                            $a_join[$i_cond_item] = $this->_field_protect($a_key[0]) . ' ' . $a_key[1] . ' ' . $s_val;
                        } else {
                            $a_join[$i_cond_item] .= $this->_field_protect($a_key[0]) . ' ' . $a_key[1] . ' ' . $s_val;
                        }
                    } else {
                        throw new Exception('尚不支持此运算符！');
                    }
                } else {// 未设置运算符
                    if(!isset($a_join[$i_cond_item])){
                        $a_join[$i_cond_item] = $this->_field_protect($s_key) . " = {$s_val}";
                    }else{
                        $a_join[$i_cond_item] .= $this->_field_protect($s_key) . " = {$s_val}";
                    }
                }
                $i_cond_item++;
            }
        } else {
            $a_join[$i_cond_item] .= $u_condition;
        }
        $i_item = count($this->_a_tmp_sql['join']);
        foreach ($a_join as $s_on) {
            if (!isset($this->_a_tmp_sql['join'][$i_item])) {
                $this->_a_tmp_sql['join'][$i_item] = $this->_relation_character($s_relationship, '') . $s_on;
            } else {
                $this->_a_tmp_sql['join'][$i_item] .= $this->_relation_character($s_relationship, $this->_a_tmp_sql['join'][$i_item]) . $s_on;
            }
        }
        $this->_a_tmp_sql['join'][$i_item] = " $s_type JOIN {$s_table} ON " . $this->_a_tmp_sql['join'][$i_item];
        return $this;
    }

    /**
     * 生成条件语句
     * u_condition 可以是数组array('field' => 'value')，array('field >' => 'value')或字符串两种格式
     * 多次调用，会对之前的条件加括号
     * b_protect 设置是否给字段名加反引号保护
     */
    public function where($u_condition, $b_protect = true)
    {
        // 清除上次的SQL语句
        $this->_s_sql = '';

        $this->_condition($u_condition, $b_protect, 'AND');
        return $this;
    }

    /**
     * 生成“或”的条件语句
     */
    public function where_or($u_condition, $b_protect = true)
    {
        // 清除上次的SQL语句
        $this->_s_sql = '';

        $this->_condition($u_condition, $b_protect, 'OR');
        return $this;
    }

    /**
     * 生成“IN”的条件语句
     */
    public function where_in($s_field, $a_data, $s_relationship = 'AND')
    {
        $this->_in($s_field, $a_data, $s_relationship);
        return $this;
    }

    /**
     * 生成“NOT IN”的条件语句
     */
    public function where_not_in($s_field, $a_data, $s_relationship = 'AND')
    {
        $this->_in($s_field, $a_data, $s_relationship, 'NOT IN');
        return $this;
    }

    /**
     * 生成“GROUP BY”的语句
     */
    public function group_by($m_field, $b_protect = false)
    {
        if (is_array($m_field)) {
            foreach ($m_field as $s_field) {
                $this->_a_tmp_sql['group_by'] .= ($b_protect ? $this->_field_protect($s_field) : $s_field) . ',';
            }
            $this->_a_tmp_sql['group_by'] = rtrim($s_field, ',');
        } else {
            $this->_a_tmp_sql['group_by'] .= $b_protect ? $this->_field_protect($m_field) : $m_field;
        }
        return $this;
    }

    /**
     * 生成“having”的语句
     */
    public function having($u_condition, $b_protect = false)
    {
        // 清除上次的SQL语句
        $this->_s_sql = '';

        $this->_condition($u_condition, $b_protect, 'AND', 'having');
        return $this;
    }

    /**
     * 生成“having”的语句，多个条件使用OR连接
     */
    public function having_or($u_condition, $b_protect = false)
    {
        // 清除上次的SQL语句
        $this->_s_sql = '';

        $this->_condition($u_condition, $b_protect, 'OR', 'having');
        return $this;
    }

    /**
     * 排序，调用一次只能设置一个排序，可以调用多次
     */
    public function order_by($m_order)
    {
        // 清除上次的SQL语句
        $this->_s_sql = '';
        if (is_array($m_order)) {
            foreach ($m_order as $s_key => $s_val) {
                if (in_array(strtoupper($s_val), ['ASC', 'DESC'])) {
                    $this->_a_tmp_sql['order_by'] .= (empty($this->_a_tmp_sql['order_by']) ? '' : ',') . $this->_field_protect($s_key) . ' ' . strtoupper($s_val);
                } else {
                    throw new Exception('排序关键字错误！');
                }
            }
        } else {
            $this->_a_tmp_sql['order_by'] .= (empty($this->_a_tmp_sql['order_by']) ? '' : ',') . $m_order;
        }
        return $this;
    }

    /**
     * LIMIT语句，只能调用一次
     */
    public function limit($i_start, $i_end)
    {
        // 清除上次的SQL语句
        $this->_s_sql = '';

        $this->_a_tmp_sql['limit'] = $i_start . ',' . $i_end;
        return $this;
    }

    /**
     * 获取模拟执行的SQL语句，注意，是非真实执行的SQL语句；
     * PDO模块是分两次把SQL和参数传入的，并非直接生成一条SQL语句执行，所以两者之间有差异
     * 可以在调用get方法之前使用，这样可以先预览语句而不执行
     * $b_is_exec 参数如果为true，就开始生成语句，但是不执行
     */
    public function get_sql($b_is_exec = false)
    {
        if ($b_is_exec) {
            $this->_build_sql();
            foreach ($this->_a_prepare as $s_key => $s_val) {
                $this->_s_sql = str_replace($s_key, $s_val, $this->_s_sql);
            }
            return $this->_s_sql;
        }
        $s_sql = $this->_s_sql;
        $a_prepare = empty($this->_a_prepare) ? $this->_a_last_prepare : $this->_a_prepare;
        if (empty($s_sql)) {
            $s_sql = 'SELECT ' . join(',', $this->_a_tmp_sql['field']);
            $s_sql .= ' FROM  ' . join(',', $this->_a_tmp_sql['from']);
            if (is_array($this->_a_tmp_sql['join'])) {
                foreach ($this->_a_tmp_sql['join'] as $s_join) {
                    $this->_s_sql .= $s_join;
                }
            }
            if (!empty($this->_a_tmp_sql['condition'])) {
                $s_sql .= ' WHERE ' . $this->_a_tmp_sql['condition'];
            }
            if (!empty($this->_a_tmp_sql['group_by'])) {
                $s_sql .= ' GROUP BY ' . $this->_a_tmp_sql['group_by'];
            }
            if (!empty($this->_a_tmp_sql['having'])) {
                $s_sql .= ' HAVING ' . $this->_a_tmp_sql['having'];
            }
            if (!empty($this->_a_tmp_sql['order_by'])) {
                $s_sql .= ' ORDER BY ' . $this->_a_tmp_sql['order_by'];
            }
            if (empty($this->_a_tmp_sql['limit'])) {
                $this->_a_tmp_sql['limit'] = '0, 30';
            }
            $s_sql .= ' LIMIT ' . $this->_a_tmp_sql['limit'];
        }

        foreach ($a_prepare as $s_key => $s_val) {
            if (strstr($s_val, '.') !== false && !is_numeric($s_val)) {
                $s_sql = str_replace($s_key, $this->_field_protect($s_val), $s_sql);
            } else {
                $s_sql = str_replace($s_key, "'{$s_val}'", $s_sql);
            }
        }
        return $s_sql;
    }

    // 执行操作
    private function _exec()
    {
        $this->_o_prepare = $this->_o_link->prepare($this->_s_sql);
        if (!$this->_o_prepare->execute($this->_a_prepare)) {
            if ($this->_b_is_throw) {
                throw new Exception('操作失败！');
            }
        }
    }

    // 清空临时数据
    private function _clean_tmp_data()
    {
        // 先保存好预备数据到临时变量
        $this->_a_last_prepare = $this->_a_prepare;
        // 开始清空
        $this->_a_prepare = [];
        $this->_a_tmp_sql = [
            'field' => [],
            'from' => [],
            'condition' => '',
            'order_by' => '',
            'limit' => '',
            'set' => '',
            'group_by' => '',
            'join' => [],
            'having' => ''
        ];
    }

    /**
     * 构造FROM语句
     */
    private function _from($u_table)
    {
        $s_table = '';
        if (is_array($u_table)) {
            foreach ($u_table as $u_key => $s_val) {
                if (is_int($u_key)) {
                    $s_table .= "`{$this->_s_prefix}{$s_val}`,";
                } elseif (is_string($u_key)) {
                    $s_table .= "`{$this->_s_prefix}{$u_key}` AS {$s_val},";
                }
            }
            $s_table = rtrim($s_table, ',');
        } else {
            $s_table = $this->_as($u_table, true, $this->_s_prefix);
        }
        return $s_table;
    }

    /**
     * 对别名语句加保护处理
     */
    private function _as($s_string, $b_protect = true, $s_prefix = '')
    {
        $s_string = str_replace(',', ' ', $s_string);
        $s_string = explode(' ', $s_string);
        $i = 0;
        $i_count = count($s_string);
        $s_res = '';
        while ($i <= $i_count) {
            if ((isset($s_string[$i]) && !empty($s_string[$i]))
                && isset($s_string[$i + 1]) && strtoupper($s_string[$i + 1]) == 'AS'
                && (isset($s_string[$i + 2]) && !empty($s_string[$i + 2]))) {

                if ($b_protect) {
                    $s_res .= $this->_field_protect($s_prefix . $s_string[$i]) . " AS {$s_string[$i + 2]},";
                } else {
                    $s_res .= "{$s_prefix}{$s_string[$i]} AS {$s_string[$i + 2]},";
                }
                $i += 3;
            } else {
                if (!empty($s_string[$i])) {
                    if ($b_protect) {
                        $s_res .= $this->_field_protect($s_prefix . $s_string[$i]) . ',';
                    } else {
                        $s_res .= "{$s_prefix}{$s_string[$i]},";
                    }
                }
                $i++;
            }
        }
        $s_res = rtrim($s_res, ',');
        return $s_res;
    }

    /**
     * 构造IN语句的的值
     */
    private function _in($s_field, $a_data, $s_relationship = 'AND', $s_in = 'IN')
    {
        $this->_a_tmp_sql['condition'] .= $this->_relation_character($s_relationship) . " `{$s_field}` {$s_in} ( ";
        foreach ($a_data as $u_d) {
            $s_prepare_name = ':' . $this->_prepare_name($s_field);
            $this->_a_tmp_sql['condition'] .= $s_prepare_name . ', ';
            $this->_a_prepare[$s_prepare_name] = $u_d;
        }
        $this->_a_tmp_sql['condition'] = rtrim($this->_a_tmp_sql['condition'], ', ');
        $this->_a_tmp_sql['condition'] .= ')';
    }

    /**
     * 构造条件语句
     */
    private function _condition($u_condition, $b_protect = true, $s_relationship = 'AND', $s_screen = 'condition')
    {

        //$this->_brackets($s_relationship);

        if (is_array($u_condition)) {
            foreach ($u_condition as $s_key => $s_val) {
                $a_key = explode(' ', $s_key);
                // 设置了运算符
                if (isset($a_key[1]) && !empty($a_key[1])) {
                    $s_prepare_name = ':' . $this->_prepare_name($this->_end_field($a_key[0]));
                    $this->_a_prepare[$s_prepare_name] = $s_val;
                    $a_key[1] = trim($a_key[1]);
                    if (in_array(strtoupper($a_key[1]), $this->_a_operator)) {
                        $this->_a_tmp_sql[$s_screen] .= $this->_relation_character($s_relationship, $s_screen) . ($b_protect ? $this->_field_protect($a_key[0]) : $a_key[0]) . ' ' . $a_key[1] . ' ' . $s_prepare_name;
                    } else {
                        throw new Exception('尚不支持此运算符！');
                    }
                } else {// 未设置运算符
                    $s_prepare_name = ':' . $this->_prepare_name($this->_end_field($s_key));
                    $this->_a_prepare[$s_prepare_name] = $s_val;
                    $this->_a_tmp_sql[$s_screen] .= $this->_relation_character($s_relationship, $s_screen) . ($b_protect ? $this->_field_protect($s_key) : $s_key) . " = " . $s_prepare_name;
                }
            }
        } else {
            $this->_a_tmp_sql[$s_screen] .= $this->_relation_character($s_relationship, $s_screen) . $u_condition;
        }

    }

    /**
     * 添加关系符
     */
    private function _relation_character($s_relationship, $m_screen = 'condition')
    {
        if (in_array($m_screen, ['condition', 'having'])) {
            if (empty($this->_a_tmp_sql[$m_screen]) || substr(trim($this->_a_tmp_sql[$m_screen]), -1, 1) == '(') {
                return '';
            }
            return " $s_relationship ";
        } else {
            if (empty($m_screen) || substr(trim($m_screen), -1, 1) == '(') {
                return '';
            }
            return " $s_relationship ";
        }
    }

    /**
     * 返回去掉表名前缀的字段名
     */
    private function _end_field($s_field)
    {
        $a_field = explode('.', $s_field);
        return end($a_field);
    }

    /**
     * 处理字段加反引号保护
     */
    private function _field_protect($s_field)
    {
        $a_field = explode('.', $s_field);
        $s_field = '';
        foreach ($a_field as $s_pre) {
            if (empty($s_pre)) {
                return rtrim($s_field, '.');
            }
            $s_field .= '`' . trim($s_pre) . '`.';
        }
        return rtrim($s_field, '.');
    }

    /**
     * 构建待处理的SQL语句
     */
    private function _build_sql($s_table = '', $u_condition = '', $u_field = '', $a_order = '', $i_start = 0, $i_end = 0)
    {
        if (!empty($s_table)) {
            $this->from($s_table);
        }
        if (!empty($u_condition)) {
            $this->where($u_condition);
        }
        if (!empty($u_field)) {
            $this->select($u_field);
        }
        if (empty($this->_a_tmp_sql['field'])) {
            $this->_a_tmp_sql['field'][] = '*';
        }
        if (!empty($a_order)) {
            $this->order_by($a_order);
        }
        if ($i_end) {
            $this->limit($i_start, $i_end);
        }

        $this->_s_sql = 'SELECT ' . join(',', $this->_a_tmp_sql['field']);
        $this->_s_sql .= ' FROM  ' . join(',', $this->_a_tmp_sql['from']);
        if (is_array($this->_a_tmp_sql['join'])) {
            foreach ($this->_a_tmp_sql['join'] as $s_join) {
                $this->_s_sql .= $s_join;
            }
        }
        if (!empty($this->_a_tmp_sql['condition'])) {
            $this->_s_sql .= ' WHERE ' . $this->_a_tmp_sql['condition'];
        }
        if (!empty($this->_a_tmp_sql['group_by'])) {
            $this->_s_sql .= ' GROUP BY ' . $this->_a_tmp_sql['group_by'];
        }
        if (!empty($this->_a_tmp_sql['having'])) {
            $this->_s_sql .= ' HAVING ' . $this->_a_tmp_sql['having'];
        }
        if (!empty($this->_a_tmp_sql['order_by'])) {
            $this->_s_sql .= ' ORDER BY ' . $this->_a_tmp_sql['order_by'];
        }
        if (empty($this->_a_tmp_sql['limit'])) {
            $this->_a_tmp_sql['limit'] = '0, 30';
        }
        $this->_s_sql .= ' LIMIT ' . $this->_a_tmp_sql['limit'];
    }

    /**
     * 设置预处理字段名，避免重复
     */
    private function _prepare_name($s_prepare_name)
    {
        foreach ($this->_a_prepare_suffix as $s_suffix) {
            if (!isset($this->_a_prepare[':' . $s_prepare_name . $s_suffix])) {
                return $s_prepare_name . $s_suffix;
            }
        }
        throw new Exception('这查询语句太浮夸了！');
    }

    /**
     * 加括号（废弃）
     */
    private function _brackets($s_relationship)
    {
        $s_relationship = " {$s_relationship} ";
        if (!empty($this->_a_tmp_sql['condition'])) {
            if (substr($this->_a_tmp_sql['condition'], -1, 1) != ')') {
                $this->_a_tmp_sql['condition'] = "({$this->_a_tmp_sql['condition']})";
            }
        }
    }

    /**
     * 条件组开始
     */
    public function group_start($s_relationship = 'AND')
    {
        $this->_a_tmp_sql['condition'] .= $this->_relation_character($s_relationship) . '(';
        return $this;
    }

    /**
     * 条件组结束
     */
    public function group_end()
    {
        $this->_a_tmp_sql['condition'] = "{$this->_a_tmp_sql['condition']})";
        return $this;
    }

    /**
     * 执行原生SQL语句
     */
    public function query($s_sql)
    {
        $this->_s_sql = $s_sql;
        $sql_explode = explode(' ', $s_sql);
        $exec = strtoupper($sql_explode[0]);
        if (in_array($exec, ['UPDATE', 'DELETE'])) {
            return $this->_o_link->exec($s_sql);
        }

        return $this->_o_link->query($s_sql);
    }

    /**
     *  获取错误信息
     */
    public function get_error()
    {
        return $this->_o_link->errorInfo();
    }

    /**
     *  事务开始
     */
    public function begin()
    {
        $this->_o_link->beginTransaction();
    }

    /**
     *  提交事务
     */
    public function commit()
    {
        $this->_o_link->commit();
    }

    /**
     *  事务回滚，创建表和删除表的操作无法回滚
     */
    public function roll_back()
    {
        $this->_o_link->rollBack();
    }

    /**
     *  是否执行sql语句
     */
    public function set_is_exec($b_is_exec = true)
    {
        $this->_b_is_exec = $b_is_exec;
    }
}
