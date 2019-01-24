<?php
/**
 * 柒度PHP框架数据库操作IDE提示
 * @copyright 广州柒度信息科技有限公司 http://www.7dugo.com/
 * @author rsuice <liruzihao970302@outlook.com>
 */
namespace utils\ide;

/**
 * Class Db
 * @package utils\ide
 */
class Db
{
    /**
     * 链接数据
     * 系统默认会自动连接config_system.php文件中'init_db'指定的数据库，如果此项留空，将不会初始化数据库连接，后续可以使用此函数来完成数据库的连接，
     * 必须是连接数据库之后才能使用，用"$this->数组组键名"来访问，比如下面的数据库，将使用$this->db来访问
     *
     * $this->db->connect('db');
     */
    public function connect() {}

    /**
     * 该方法执行 SELECT 语句并返回查询结果，返回多维数组，建议获取多行数据时使用
     *
     * @param array|string $table
     * @param array $where
     * @param string $fields
     * @return array
     */
    public function get($table = [], $where = [], $fields = '') {}

    /**
     * 该方法执行 SELECT 语句并返回查询结果，返回一维数组，强力推荐获取单行数据时使用更方便
     * @param string $table
     * @param $where
     * @param string $field
     * @return array|bool
     */
    public function get_row($table = '', $where = [], $field = '') {}

    /**
     * 该方法执行 SELECT 语句并返回查询结果的总行数，返回整数，
     * 通常用来统计有多少条符合条件的数据，也可以用来判断数据是否存在
     *
     * @param $table
     * @param array $where
     * @return int
     */
    public function get_total($table, array $where = []) {}

    /**
     * 返回受上一个 SQL 语句影响的行数
     */
    public function get_count() {}

    /**
     * 返回当前数据库连接对象设置的表前缀，如果传入表名，将返回加好前缀的表名
     * @param string $table
     * @return string
     */
    public function get_prefix($table) {}

    /**
     * 生成select字段语句，第二个参数用来控制是否开启字段保护，也就是反引号，默认会自动加，传入false为不加反引号
     *
     * $this->db->select('goods_id,goods_name');
     * $this->db->select(['g.goods_id','g.goods_name']);
     *
     * @param mixed $field
     * @param bool $is_protected 用来控制是否开启字段保护，也就是反引号，默认会自动加，传入false为不加反引号
     *
     * @return $this
     */
    public function select($field, $is_protected = true) {}

    /**
     * 生成from表格语句
     *
     * $this->db->from(['goods' => 'g', 'order' => 'o']);
     * $this->db->from('cart as c');
     *
     * @param mixed $from
     * @return $this
     */
    public function from($from) {}

    /**
     * 生成联表语句，第三个参数为联表类型，默认为LEFT，需要结合from()函数使用
     * @param mixed $table 连接的表名
     * @param array $on 关联条件
     * @param string $type 联表类型，默认为LEFT
     * @return $this
     */
    public function join($table, $on, $type = 'LEFT') {}

    /**
     * 生成WHERE条件语句，多个条件之间用AND连接，第二个参数用来控制是否开启字段保护
     *
     * $this->db->where(['goods_id' => 1]);
     * $this->db->where(['goods_id >' => 1]);
     * $this->db->where(['goods_id LIKE' => '%模糊匹配%']);
     * $this->db->where(['goods_id' => 1, 'goods_name' => '哈哈']);
     *
     * @param array $where
     * @return $this
     */
    public function where(array $where) {}

    /**
     * 生成WHERE条件语句，多个条件之间用OR连接，第二个参数用来控制是否开启字段保护，默认开启
     *
     * $this->db->where_or(['goods_id' => 1, 'goods_name' => '哈哈']);
     *
     * @param array $where
     * @param bool $is_protected
     * @return $this
     */
    public function where_or(array $where, $is_protected = true) {}

    /**
     * 生成IN条件语句，多个条件之间用第三个参数连接，默认使用AND连接
     * $this->db->where_in(字段名(字符串)，IN数据(数组)，多个条件之间的连接方式[AND/OR])
     * @param $field
     * @param array $in
     * @param string $type
     * @return $this
     */
    public function where_in($field, array $in, $type = 'AND') {}

    /**
     * 生成IN条件语句，多个条件之间用第三个参数连接，默认使用AND连接
     * $this->db->where_not_in(字段名(字符串)，IN数据(数组)，多个条件之间的连接方式[AND/OR])
     * @param $field
     * @param array $not_in
     * @param string $type
     * @return $this
     */
    public function where_not_in($field, array $not_in, $type = 'AND') {}

    /**
     * 生成group by语句，第二个参数用来控制是否开启字段保护，默认不开启
     * $this->db->group_by(字段名(字符串|数组), 是否开户保护[true/false])
     * @param $field
     * @param bool $is_protected
     * @return $this
     */
    public function group_by($field, $is_protected = false) {}

    /**
     * 生成having语句，多个条件之间用AND连接，第二个参数用来控制是否开启字段保护，默认不开启
     * $this->db->having(条件(字符串|数组), 是否开户保护[true/false])
     * @param array $having
     * @param bool $is_protected
     * @return $this
     */
    public function having(array $having, $is_protected = false) {}

    /**
     * $this->db->having_or(条件(字符串|数组), 是否开户保护[true/false])
     * @param $having
     * @param bool $is_protected
     * @return $this
     */
    public function having_or($having, $is_protected = false) {}

    /**
     * 生成排序语句
     * $this->db->order_by(排序(字符串|数组))
     * @param $order
     * @return $this
     */
    public function order_by($order) {}

    /**
     * 生成limit分页语句，框架自带防爆死机制，当没有设置limit语句时，将默认获取30条数据
     * $this->db->limit(开始行(整数), 结束行(整数))
     * @param $offset
     * @param $rows
     *
     * @return $this
     */
    public function limit($offset, $rows) {}

    /**
     * 更新数据，返回受影响的行数（删除的行数）
     * $this->db->update(表名(字段串), 数据[数组], 条件[字段串|数组])
     * @param $table
     * @param array $data
     * @param $where
     * @return int
     */
    public function update($table, array $data, $where = []) {}

    /**
     * 此函数对字段设置指定的值，第三个参数设置是否开户保护，默认开启
     * $this->db->set(字段(字段串), 值(字段串), 是否开启保护[true/false])
     * @param $field
     * @param $value
     * @param bool $is_protected
     * @return Db
     */
    public function set($field, $value, $is_protected = true) {}

    /**
     * 插入数据，返回最后插入行的ID或序列值
     * $this->db->insert(表名(字段串), 数据(数组))
     * @param $table
     * @param array $data
     * @return int
     */
    public function insert($table = '', array $data = []) {}

    /**
     * 一次插入多行数据，返回受影响的行数（插入的行数）
     * $this->db->inserts(表名(字段串), 数据(数组))
     * @param $table
     * @param array $data 二维数组
     */
    public function inserts($table, array $data) {}

    /**
     * 删除数据，返回受影响的行数（删除的行数）
     * $this->db->delete(表名(字段串), 条件[字段串|数组])
     * @param $table
     * @param $where
     * @return bool|int
     */
    public function delete($table, $where = []) {}

    /**
     * 查询条件组可以让你生成用括号括起来的一组条件，这能创造出非常复杂的语句，支持嵌套的条件组，
     * 简单说此函数会在SQL语句的当前位置添加一个左括号“(”，参数是在多个条件组时，使用“and”或“OR”来连接。
     * @param $type
     */
    public function group_start($type) {}

    /**
     * 此函数针对group_start的左括号进行闭合，也就是在SQL语句的此处添加一个右括号“)”
     * @param $type
     */
    public function group_end($type) {}

    /**
     * 事务开始，事务使用实例
     */
    public function begin() {}

    /**
     * 事务回滚，创建表和删除表的操作无法回滚
     */
    public function roll_back() {}

    /**
     * 提交事务
     */
    public function commit() {}

    /**
     * 执行原生SQL语句，为了代码的整洁性，非特殊语句，不得使用此函数。
     * @param $sql
     * @return \PDORow
     */
    public function query($sql) {}

    /**
     * 获取数据库类生成的模拟SQL语句，自动获取前面调用的数据库函数所生成的模拟SQL语句，以便调试使用，
     * 需要注意的是，SQL语句是模拟出来的，和实际的数据库操作有差异，请以实际执行效果为准。
     * 参数默认为false，默认返回最后一次执行的SQL语句，
     * 当设置为true时，将会对前面的语句构建SQL，但是不会实际执行数据库操作，用于不方便改变数据库数据时，先检查SQL语句用。
     *
     * @param bool $debug 生成当前构建的语句，但不进行数据库操作
     * @return string
     */
    public function get_sql($debug = false) {}

    /**
     * 获取错误信息。
     * @return string
     */
    public function get_error() {}

    /**
     * 由于PHP函数本身对于某些情况不会报错，所以增加此异常抛出，以便调试；
     * 所有数据库操作失败时，都会抛出的异常，比如表名写错，字段名写错等等情况都会触发此异常
     */
    public function set_error_mode() {}
}
